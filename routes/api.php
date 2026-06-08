<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

Route::get('/cek', function () {
    return ["status" => "Aman!", "pesan" => "Web API Inventory sudah aktif"];
});

Route::prefix('v1')->group(function () {

    // Public routes (tanpa auth)
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);

    // Protected routes (butuh token Sanctum)
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Category routes (semua kecuali delete)
        Route::apiResource('categories', CategoryController::class)
            ->except(['destroy']);

        // Category delete — hanya admin
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
            ->middleware('role:admin');

        // Item routes (semua kecuali delete)
        Route::apiResource('items', ItemController::class)
            ->except(['destroy']);

        // Item delete — hanya admin
        Route::delete('items/{item}', [ItemController::class, 'destroy'])
            ->middleware('role:admin');
    });
});