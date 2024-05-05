<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('/posts', [PostController::class, 'index']);
// Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
// Route::get('/posts/{post}', [PostController::class, 'show']);

Route::prefix("posts")
    ->controller(PostController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store')->middleware('auth:sanctum');
        Route::get('/{post}', 'show');
    });

require __DIR__.'/auth.php';