<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::get('/image/{filename}', function ($filename) {
    $path = "profiles/$filename"; // Assuming all images are stored in profiles folder

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    return Response::make($file, 200, [
        'Content-Type' => Storage::disk('public')->mimeType($path),
        'Access-Control-Allow-Origin' => '*', // Explicitly add CORS headers
    ]);
})->where('filename', '.*');

