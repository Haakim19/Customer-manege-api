<?php

use App\Http\Controllers\api\V1\CustomerController;
use App\Http\Controllers\api\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(
    ['prefix' => 'v1', 'middlewar'],
    function () {
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('invoices', InvoiceController::class);

        Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
    }
);
