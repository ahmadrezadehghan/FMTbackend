<?php
// app/Http/Controllers/TradeController.php
namespace App\Http\Controllers;

use App\Http\Requests\TradeRequest;
use App\Services\TradeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    protected TradeService $tradeService;

    public function __construct(TradeService $tradeService)
    {
        $this->tradeService = $tradeService;
    }

    public function index(Request $request): JsonResponse
    {
        $trades = $this->tradeService->all($request->user());
        return response()->json($trades);
    }

    public function show(int $id): JsonResponse
    {
        $trade = $this->tradeService->find($id);
        return response()->json($trade);
    }

    public function store(TradeRequest $request): JsonResponse
    {
        $trade = $this->tradeService->create($request->user(), $request->validated());
        return response()->json($trade, 201);
    }

    public function update(TradeRequest $request, int $id): JsonResponse
    {
        $trade = $this->tradeService->update($id, $request->validated());
        return response()->json($trade);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->tradeService->cancel($id);
        return response()->json(null, 204);
    }
}
