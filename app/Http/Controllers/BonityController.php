<?php
// app/Http/Controllers/BonityController.php
namespace App\Http\Controllers;

use App\Services\BonityService;
use Illuminate\Http\JsonResponse;

class BonityController extends Controller
{
    protected BonityService $bonityService;

    public function __construct(BonityService $bonityService)
    {
        $this->bonityService = $bonityService;
    }

    public function calculate(int $userId): JsonResponse
    {
        $score = $this->bonityService->calculateForUser($userId);
        return response()->json(['score' => $score]);
    }
}
