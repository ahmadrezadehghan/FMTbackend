<?php
// app/Http/Controllers/BankAccountController.php
namespace App\Http\Controllers;

use App\Http\Requests\BankAccountRequest;
use App\Services\BankAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    protected BankAccountService $service;

    public function __construct(BankAccountService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $accounts = $this->service->all($request->user());
        return response()->json($accounts);
    }

    public function show(int $id): JsonResponse
    {
        $account = $this->service->find($id);
        return response()->json($account);
    }

    public function store(BankAccountRequest $request): JsonResponse
    {
        $account = $this->service->create($request->user(), $request->validated());
        return response()->json($account, 201);
    }

    public function update(BankAccountRequest $request, int $id): JsonResponse
    {
        $account = $this->service->update($id, $request->validated());
        return response()->json($account);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
