<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cek', function () {
    return ["status" => "Aman!", "pesan" => "Web API Inventory sudah aktif"];
});

Route::apiResource('categories', CategoryController::class);
Route::apiResource('items', ItemController::class);