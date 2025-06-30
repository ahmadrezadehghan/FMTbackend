<?php
// app/Http/Controllers/ForexController.php
namespace App\Http\Controllers;

use App\Services\MarketDataService;
use Illuminate\Http\JsonResponse;

class ForexController extends Controller
{
    protected MarketDataService $marketDataService;

    public function __construct(MarketDataService $marketDataService)
    {
        $this->marketDataService = $marketDataService;
    }

    public function pairs(): JsonResponse
    {
        $pairs = $this->marketDataService->listForexPairs();
        return response()->json($pairs);
    }

    public function quote(string $symbol): JsonResponse
    {
        $quote = $this->marketDataService->getLatestQuote($symbol);
        return response()->json($quote);
    }
}
