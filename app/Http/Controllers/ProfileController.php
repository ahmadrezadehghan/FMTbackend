<?php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $profile = $request->user()->personalCabin;
        return response()->json($profile);
    }

    public function update(ProfileRequest $request): JsonResponse
    {
        $profile = $request->user()->personalCabin;
        $profile->update($request->validated());
        return response()->json($profile);
    }
}
