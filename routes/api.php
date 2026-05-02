<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cek', function () {
    return ["status" => "Aman!", "pesan" => "Web API Inventory sudah aktif"];
});