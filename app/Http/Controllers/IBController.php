<?php
// app/Http/Controllers/IBController.php
namespace App\Http\Controllers;


use App\Services\IBService;
use Illuminate\Http\JsonResponse;

class IBController extends Controller
{
    protected IBService $ibService;

    public function __construct(IBService $ibService)
    {
        $this->ibService = $ibService;
    }

    public function show(int $userId): JsonResponse
    {
        $ib = $this->ibService->getByUser($userId);
        return response()->json($ib);
    }

    public function update(int $userId): JsonResponse
    {
        $ib = $this->ibService->updateMetrics($userId);
        return response()->json($ib);
    }
}
