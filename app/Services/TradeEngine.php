<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Trade;
use App\Models\User;

class TradeEngine
{
    // Standard contract sizes and pip values for different instruments
    private $symbolConfigs = [
        'EURUSD' => [
            'pipDigits' => 4,
            'pipValue' => 10,
            'contractSize' => 100000, // Standard lot = 100,000 units
            'minLot' => 0.01,  // Micro lot
            'maxLot' => 100    // Maximum lot size
        ],
        'BTCUSD' => [
            'pipDigits' => 1,
            'pipValue' => 1,
            'contractSize' => 1,
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'ETHUSD' => [
            'pipDigits' => 2,
            'pipValue' => 1,
            'contractSize' => 1,
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'XAUUSD' => [
            'pipDigits' => 2,
            'pipValue' => 10,
            'contractSize' => 100, // Gold is typically traded in ounces
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'XAGUSD' => [
            'pipDigits' => 3,
            'pipValue' => 5,
            'contractSize' => 5000, // Silver is typically traded in ounces
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'WTI' => [
            'pipDigits' => 2,
            'pipValue' => 10,
            'contractSize' => 1000, // Oil is traded in barrels
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'BRENT' => [
            'pipDigits' => 2,
            'pipValue' => 10,
            'contractSize' => 1000,
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'DXY' => [
            'pipDigits' => 3,
            'pipValue' => 10,
            'contractSize' => 100000,
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'Nasdaq' => [
            'pipDigits' => 1,
            'pipValue' => 1,
            'contractSize' => 1,
            'minLot' => 0.01,
            'maxLot' => 100
        ],
        'DowJones30' => [
            'pipDigits' => 1,
            'pipValue' => 1,
            'contractSize' => 1,
            'minLot' => 0.01,
            'maxLot' => 100
        ]
    ];

    /**
     * Process a newly created order.
     *
     * @param Order $order
     * @return void
     */
    public function processOrder(Order $order)
    {
        // Validate order parameters
        $this->validateOrder($order);

        // Calculate and check required margin
        $this->checkMarginRequirements($order);

        \Log::info("Order {$order->id} processed for user {$order->user_id}.", [
            'symbol' => $order->symbol,
            'type' => $order->type,
            'lot_size' => $order->lot_size,
            'leverage' => $order->leverage
        ]);
    }

    /**
     * Process the closing of an order and create a trade.
     *
     * @param Order $order
     * @return Trade
     */
    public function processCloseOrder(Order $order)
    {
        \Log::info('Starting processCloseOrder for order ID ' . $order->id);
        \Log::info('Calculating profit/loss and pips...');

        try {
            $profitOrLoss = $this->calculateProfitLoss($order);
            $pips = $this->calculatePips($order);
        } catch (\Exception $e) {
            \Log::error('Error calculating P/L or pips: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            throw $e; // re-throw so higher-level code can handle it
        }

        \Log::info("Calculated profitOrLoss={$profitOrLoss}, pips={$pips} for order ID {$order->id}");

        // Calculate commission (if any)
        $commission = $this->calculateCommission($order);
        \Log::info("Calculated commission={$commission} for order ID {$order->id}");

        // Calculate swap (if position was held overnight)
        $swap = 0;
        \Log::info("Calculated swap={$swap} for order ID {$order->id}");

        // Adjust final P/L with commission and swap
        $finalProfitLoss = $profitOrLoss - ($commission + $swap);
        \Log::info("Calculated finalProfitLoss={$finalProfitLoss} for order ID {$order->id}");

        // Update user's balance
        \Log::info("Fetching user with ID={$order->user_id} to update balance...");
        $user = User::find($order->user_id);
        if (!$user) {
            \Log::error("User not found. ID={$order->user_id}");
            throw new \Exception("User not found, ID={$order->user_id}");
        }

        $newBalance = $user->tcoin + $finalProfitLoss;
        \Log::info("Updating user balance from {$user->tcoin} to {$newBalance} for user ID {$user->id}");
        $this->updateUserBalance($order->user_id, $newBalance);

        // Update user's total profit/loss
        \Log::info("Updating user's total profit from {$user->profit} to ".($user->profit + $finalProfitLoss)." for user ID {$user->id}");
        // $user->profit = $user->profit + $finalProfitLoss;
        $user->save();

        // Create trade record
        \Log::info("About to create Trade record for order ID {$order->id}");

        $trade = Trade::create([
            'user_id'       => $order->user_id,
            'order_id'      => $order->id,
            'symbol'        => $order->symbol,
            'lot_size'      => $order->lot_size,
            'type'          => $order->type,
            'opening_price' => $order->price,
            'closing_price' => $order->closing_price,
            'leverage'      => $order->leverage,
            'profit_loss'   => $finalProfitLoss,
            'commission'    => $commission,
            'swap'          => $swap,
            'pips'          => $pips
        ]);

        \Log::info("Trade create call returned ID: ".($trade->id ?? 'null'));

        // (Optionally) delete or mark the order as 'closed'
        \Log::info("Deleting order with ID={$order->id}...");
        $order->delete();

        \Log::info("Finished processCloseOrder successfully for order ID={$order->id}, created trade ID=".($trade->id ?? 'null'));
        return $trade;
    }

    /**
     * Calculate profit/loss using proper pip values and lot sizes.
     *
     * @param Order $order
     * @return float
     */
    protected function calculateProfitLoss(Order $order)
    {
        $config = $this->symbolConfigs[$order->symbol] ?? null;
        if (!$config) {
            throw new \Exception("Invalid symbol: {$order->symbol}");
        }

        // Calculate price difference in pips
        $multiplier = pow(10, $config['pipDigits']);
        $priceDifference = $order->type === 'buy'
            ? ($order->closing_price - $order->price) * $multiplier
            : ($order->price - $order->closing_price) * $multiplier;

        // Calculate profit/loss based on pip value and lot size
        $profitOrLoss = $priceDifference * $config['pipValue'] * $order->lot_size;

        // **Remove Leverage from P/L Calculation**
        // if ($order->leverage > 1) {
        //     $profitOrLoss *= $order->leverage;
        // }

        return round($profitOrLoss, 2);
    }

    protected function calculatePips(Order $order)
    {
        $config = $this->symbolConfigs[$order->symbol];
        $multiplier = pow(10, $config['pipDigits']);
        return round(abs($order->closing_price - $order->price) * $multiplier, 2);
    }

    protected function calculateCommission(Order $order)
    {
        // Example commission calculation: $7 per standard lot
        $commissionPerLot = -7;
        return round($order->lot_size * $commissionPerLot, 2);
    }

    protected function calculateSwap(Order $order)
    {
        // Example swap calculation: -$2.5 per standard lot per day
        $swapPerLot = -2.5;
        $daysHeld = max(1, $order->updated_at->diffInDays($order->created_at));
        return round($order->lot_size * $swapPerLot * $daysHeld, 2);
    }

    /**
     * Check margin requirements for the order.
     *
     * @param Order $order
     * @throws \Exception
     */
    protected function checkMarginRequirements(Order $order)
    {
        $config = $this->symbolConfigs[$order->symbol];

        // Calculate position size in base currency
        $positionSize = $order->lot_size * $config['contractSize'] * $order->price;

        // Calculate required margin based on leverage
        $requiredMargin = $positionSize / $order->leverage;

        // Check if user has sufficient margin
        $user = User::find($order->user_id);
        if ($user->tcoin < $requiredMargin) {
            throw new \Exception("Insufficient margin. Required: {$requiredMargin}, Available: {$user->tcoin}");
        }
    }

    /**
     * Validate order parameters against symbol configuration.
     *
     * @param Order $order
     * @throws \Exception
     */
    protected function validateOrder(Order $order)
    {
        $config = $this->symbolConfigs[$order->symbol] ?? null;
        if (!$config) {
            throw new \Exception("Invalid symbol: {$order->symbol}");
        }

        if ($order->lot_size < $config['minLot'] || $order->lot_size > $config['maxLot']) {
            throw new \Exception("Invalid lot size for {$order->symbol}. Must be between {$config['minLot']} and {$config['maxLot']}");
        }

        if ($order->leverage < 1) {
            throw new \Exception("Leverage must be at least 1");
        }
    }

    /**
     * Update user's balance with new amount.
     *
     * @param int $userId
     * @param float $newBalance
     */
    protected function updateUserBalance($userId, $newBalance)
    {
        $user = User::find($userId);
        if ($user) {
            $user->tcoin = $newBalance;
            $user->save();
            \Log::info("User {$userId} balance updated to {$newBalance}");
        }
    }
}
