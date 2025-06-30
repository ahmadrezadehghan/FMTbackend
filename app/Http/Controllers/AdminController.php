<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\IB;
use App\Services\BonityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected BonityService $bonityService;

    public function __construct(BonityService $bonityService)
    {
        // Only allow admin users
        $this->middleware(['auth:api','admin']);
        $this->bonityService = $bonityService;
    }

    /**
     * List all users with full relations.
     */
    public function usersIndex(): JsonResponse
    {
        $users = User::with([
            'wallets.transactions',
            'trades.forexPair',
            'ib',
            'personalCabin',
            'demoAccounts',
            'copyTradesAsFollower',
            'copyTradesAsProvider',
            'kycDocuments',
            'bankAccounts',
            'tradingAccounts',
            'notifications',
        ])->paginate(50);

        return response()->json($users);
    }

    /**
     * Show a single user by ID, with all relations.
     */
    public function usersShow(int $id): JsonResponse
    {
        $user = User::with([
            'wallets.transactions',
            'trades.forexPair',
            'ib',
            'personalCabin',
            'demoAccounts',
            'copyTradesAsFollower',
            'copyTradesAsProvider',
            'kycDocuments',
            'bankAccounts',
            'tradingAccounts',
            'notifications',
        ])->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Get transactions filtered by period: 'hour','12hours','24hours','week','month'.
     */
    public function transactionsByPeriod(Request $request): JsonResponse
    {
        $start = $this->resolveStart($request->query('period'));
        $transactions = Transaction::where('transaction_date', '>=', $start)
            ->orderBy('transaction_date', 'desc')
            ->get();

        return response()->json([
            'period' => $request->query('period'),
            'start'  => $start,
            'count'  => $transactions->count(),
            'data'   => $transactions,
        ]);
    }

    /**
     * Get IB records filtered by period.
     */
    public function ibByPeriod(Request $request): JsonResponse
    {
        $start = $this->resolveStart($request->query('period'));
        $ibs = IB::where('created_at', '>=', $start)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'period' => $request->query('period'),
            'start'  => $start,
            'count'  => $ibs->count(),
            'data'   => $ibs,
        ]);
    }

    /**
     * Get Bonity scores for users filtered by their creation date period.
     */
    public function bonityByPeriod(Request $request): JsonResponse
    {
        $start = $this->resolveStart($request->query('period'));
        $users = User::where('created_at', '>=', $start)->get();

        $results = $users->map(function($user) {
            return [
                'user_id' => $user->id,
                'email'   => $user->email,
                'score'   => $this->bonityService->calculateForUser($user->id),
            ];
        });

        return response()->json([
            'period'  => $request->query('period'),
            'start'   => $start,
            'count'   => $results->count(),
            'data'    => $results,
        ]);
    }

    /**
     * Resolve the starting DateTime based on period string.
     */
    protected function resolveStart(?string $period)
    {
        $now = now();

        return match ($period) {
            'hour'     => $now->copy()->subHour(),
            '12hours'  => $now->copy()->subHours(12),
            '24hours'  => $now->copy()->subHours(24),
            'week'     => $now->copy()->subWeek(),
            'month'    => $now->copy()->subMonth(),
            default    => throw new \InvalidArgumentException('Invalid period'),
        };
    }
}
