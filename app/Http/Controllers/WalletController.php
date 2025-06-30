<?php
// app/Http/Controllers/WalletController.php
namespace App\Http\Controllers;


use App\Http\Requests\WalletRequest;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index(Request $request): JsonResponse
    {
        $wallets = $this->walletService->all($request->user());
        return response()->json($wallets);
    }

    public function show(int $id): JsonResponse
    {
        $wallet = $this->walletService->find($id);
        return response()->json($wallet);
    }

    public function store(WalletRequest $request): JsonResponse
    {
        $wallet = $this->walletService->create($request->user(), $request->validated());
        return response()->json($wallet, 201);
    }

    public function update(WalletRequest $request, int $id): JsonResponse
    {
        $wallet = $this->walletService->update($id, $request->validated());
        return response()->json($wallet);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->walletService->delete($id);
        return response()->json(null, 204);
    }
}
