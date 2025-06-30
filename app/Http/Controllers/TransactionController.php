<?php
// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request): JsonResponse
    {
        $transactions = $this->transactionService->all($request->user());
        return response()->json($transactions);
    }

    public function show(int $id): JsonResponse
    {
        $transaction = $this->transactionService->find($id);
        return response()->json($transaction);
    }

    public function store(TransactionRequest $request): JsonResponse
    {
        $transaction = $this->transactionService->create($request->user(), $request->validated());
        return response()->json($transaction, 201);
    }
}
