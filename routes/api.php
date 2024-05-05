<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('/posts', [PostController::class, 'index']);
// Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
// Route::get('/posts/{post}', [PostController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::apiResource('posts', PostController::class);
    Route::post('/posts', [PostController::class, 'store']);
    Route::post('/tags', [TagController::class, 'store']);
});

require __DIR__.'/auth.php';