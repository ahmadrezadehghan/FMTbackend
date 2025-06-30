<?php
// app/Http/Controllers/TradingAccountController.php

namespace App\Http\Controllers;

use App\Http\Requests\TradingAccountRequest;
use App\Services\TradingAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TradingAccountController extends Controller
{
    protected TradingAccountService $service;

    public function __construct(TradingAccountService $service)
    {
        $this->service = $service;
    }

    /**
     * List all trading accounts for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $accounts = $this->service->all($request->user());
        return response()->json($accounts);
    }

    /**
     * Show a single trading account by ID.
     */
    public function show(int $id): JsonResponse
    {
        $account = $this->service->find($id);
        return response()->json($account);
    }

    /**
     * Create a new trading account (demo or real).
     */
    public function store(TradingAccountRequest $request): JsonResponse
    {
        $account = $this->service->create($request->user(), $request->validated());
        return response()->json($account, 201);
    }

    /**
     * Update an existing trading account's settings.
     */
    public function update(TradingAccountRequest $request, int $id): JsonResponse
    {
        $account = $this->service->update($id, $request->validated());
        return response()->json($account);
    }

    /**
     * Delete (deactivate) a trading account.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
