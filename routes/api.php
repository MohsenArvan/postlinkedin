<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/posts/tag/{tag_id}', [PostController::class , 'getPostTag']);
});

require __DIR__.'/auth.php';