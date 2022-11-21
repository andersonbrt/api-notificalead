<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\GatewayController;

Route::get('/v1/purchase', function () {
    return [
        'error' => 404,
        "msg" => 'endpoint not found.'
    ];
});
Route::get('/v1/integration', function () {
    return [
        'error' => 404,
        "msg" => 'endpoint not found.'
    ];
});
Route::post('/v1/integration/eduzz', [GatewayController::class, 'show']);
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/v1/purchase/create', [PurchaseController::class, 'store']);
    Route::get('/v1/purchase/get', [PurchaseController::class, 'index']);
    Route::get('/v1/purchase/get/{id}', [PurchaseController::class, 'show']);
    Route::put('/v1/purchase/update/{id}', [PurchaseController::class, 'update']);
    Route::delete('/v1/purchase/delete/{id}', [PurchaseController::class, 'destroy']);
});
