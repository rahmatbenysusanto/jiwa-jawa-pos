<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

Route::prefix('/menu')->controller(MenuController::class)->group(function () {
    Route::get('/category', 'category')->name('menu.category');
    Route::post('/category', 'categoryAdd')->name('menu.category.add');
    Route::get('/category/find', 'findCategory')->name('menu.category.find');
    Route::post('/category/edit', 'categoryEdit')->name('menu.category.edit');
    Route::get('/category/delete', 'categoryDelete')->name('menu.category.delete');

    Route::get('/addon', 'addon')->name('menu.addon');
    Route::get('/addon/detail', 'addonDetail')->name('menu.addon.detail');
    Route::post('/addon/detail/variant', 'addonDetailAddVariant')->name('menu.addon.detail.add.variant');
    Route::get('/addon/detail/delete', 'addonDetailDelete')->name('menu.addon.detail.delete');
    Route::post('/addon/detail/edit', 'addonDetailEdit')->name('menu.addon.detail.edit');
    Route::get('/addon/edit/name', 'addonDetailEditName')->name('menu.addon.edit.name');
    Route::get('/addon/create', 'addonCreate')->name('menu.addon.create');
    Route::post('/addon', 'addonStore')->name('menu.addon.store');

    Route::get('/list', 'list')->name('menu.list');
    Route::get('/create', 'createMenu')->name('menu.create');
    Route::post('/store', 'storeMenu')->name('menu.store');

    // JSON Response
    Route::get('/find-all', 'findAllMenu')->name('menu.find.all');
});

Route::prefix('/discount')->controller(DiscountController::class)->group(function () {
    Route::get('/', 'index')->name('discount');
    Route::get('/create', 'create')->name('discount.create');
    Route::post('/store', 'store')->name('discount.store');

    // JSON Response
    Route::get('/find/transaction', 'findDiscountTransaction')->name('discount.find.transaction');
});

Route::prefix('/outlet')->controller(OutletController::class)->group(function () {
    Route::get('/', 'index')->name('outlet.index');
    Route::post('/', 'store')->name('outlet.store');
});

Route::prefix('/user')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('user.index');
    Route::get('/create', 'create')->name('user.create');
});

Route::prefix('/pos')->controller(PosController::class)->group(function () {
    Route::get('/', 'index')->name('pos.index');

    // JSON Response
    Route::get('/menu', 'menu')->name('pos.menu');
    Route::get('/menu/find', 'findProduct')->name('pos.product.find');
    Route::get('/addon', 'addon')->name('pos.addon');
    Route::get('/addon/find', 'findAddon')->name('pos.addon.find');
    Route::get('/addon/variant', 'findAddonVariant')->name('pos.addon.variant');
    Route::get('/payment-method', 'paymentMethod')->name('pos.payment.method');
});

Route::prefix('/transaction')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index')->name('transaction.index');
    Route::post('/', 'store')->name('transaction.store');
});

Route::prefix('/inventory')->controller(InventoryController::class)->group(function () {
    Route::prefix('/category')->group(function () {
        Route::get('/', 'indexCategory')->name('inventory.category');
        Route::post('/', 'storeCategory')->name('inventory.category.store');
        Route::get('/delete', 'deleteCategory')->name('inventory.category.delete');
        Route::get('/find', 'findCategory')->name('inventory.category.find');
        Route::post('/edit', 'editCategory')->name('inventory.category.edit');
    });

    Route::prefix('/material')->group(function () {
        Route::get('/', 'indexMaterial')->name('inventory.material');
    });

    Route::prefix('/purchase-order')->group(function () {
        Route::get('/', 'indexPurchaseOrder')->name('inventory.purchase.order');
    });

    Route::prefix('/manage-stock')->group(function () {
        Route::get('/', 'indexManageStock')->name('inventory.manage.stock');
    });

    Route::prefix('/stock-adjusment')->group(function () {
        Route::get('/', 'indexStockAdjusment')->name('inventory.stock.adjustment');
    });

    Route::prefix('/transfer-stock')->group(function () {
        Route::get('/', 'indexTransferStock')->name('inventory.transfer.stock');
    });
});
