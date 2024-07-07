<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('posts')->name('posts.')->group(function () {

    Route::prefix('images')->controller(ImageController::class)->name('images.')->group(function () {
        Route::post('/store', 'store')->name('store');
    });

    Route::controller(PostController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
});
