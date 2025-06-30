<?php
// app/Http/Controllers/PersonalCabinController.php
namespace App\Http\Controllers;

use App\Http\Requests\PersonalCabinRequest;
use App\Services\PersonalCabinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonalCabinController extends Controller
{
    protected PersonalCabinService $cabinService;

    public function __construct(PersonalCabinService $cabinService)
    {
        $this->cabinService = $cabinService;
    }

    public function dashboard(Request $request): JsonResponse
    {
        $data = $this->cabinService->dashboard($request->user());
        return response()->json($data);
    }

    public function update(PersonalCabinRequest $request): JsonResponse
    {
        $profile = $this->cabinService->updateProfile($request->user(), $request->validated());
        return response()->json($profile);
    }
}
