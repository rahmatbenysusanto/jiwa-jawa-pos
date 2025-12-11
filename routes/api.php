<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/process-po', [InventoryController::class, 'callbackPurchaseOrder']);

