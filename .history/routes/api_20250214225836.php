<?php

use App\Http\Controllers\api\V1\CustomerController;
use App\Http\Controllers\api\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Models\Controllers\api'], function () {
    Route::apiResource('customer', CustomerController::class);
    Route::apiResource('invoice', InvoiceController::class);
});
