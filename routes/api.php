<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/callback/payment-qris', [TransactionController::class, 'callbackMidtransPayment']);

Route::controller(InventoryController::class)->group(function () {
    Route::post('/approved/purchase-order', 'approvedPurchaseOrderWMS');
    Route::post('/cancelled/purchase-order', 'cancelledPurchaseOrderWMS');
});
