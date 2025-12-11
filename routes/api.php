<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/process-po', [InventoryController::class, 'callbackPurchaseOrder']);

Route::post('/callback/midtrans/payment', [TransactionController::class, 'callbackMidtransPayment']);
Route::post('/testing', function () {
    return response()->json([
        'status' => true,
    ]);
});