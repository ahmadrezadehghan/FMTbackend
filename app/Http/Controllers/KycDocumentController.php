<?php
// app/Http/Controllers/KycDocumentController.php
namespace App\Http\Controllers;

use App\Http\Requests\KycDocumentRequest;
use App\Services\KycService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KycDocumentController extends Controller
{
    protected KycService $kycService;

    public function __construct(KycService $kycService)
    {
        $this->kycService = $kycService;
    }

    public function index(Request $request): JsonResponse
    {
        $docs = $this->kycService->all($request->user());
        return response()->json($docs);
    }

    public function show(int $id): JsonResponse
    {
        $doc = $this->kycService->find($id);
        return response()->json($doc);
    }

    public function store(KycDocumentRequest $request): JsonResponse
    {
        $doc = $this->kycService->create($request->user(), $request->validated());
        return response()->json($doc, 201);
    }

    public function update(KycDocumentRequest $request, int $id): JsonResponse
    {
        $doc = $this->kycService->update($id, $request->validated());
        return response()->json($doc);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->kycService->delete($id);
        return response()->json(null, 204);
    }
}
