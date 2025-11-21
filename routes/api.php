<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::post('/process-po', [InventoryController::class, 'callbackPurchaseOrder']);