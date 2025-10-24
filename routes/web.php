<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerDisplayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Route;
use Pusher\Pusher;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/', 'loginPost')->name('login.action');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware(LoginMiddleware::class)->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::prefix('/menu')->controller(MenuController::class)->group(function () {
        Route::prefix('/category')->group(function () {
            Route::get('/', 'category')->name('menu.category');
            Route::post('/', 'categoryAdd')->name('menu.category.add');
            Route::get('/find', 'findCategory')->name('menu.category.find');
            Route::post('/edit', 'categoryEdit')->name('menu.category.edit');
            Route::get('/delete', 'categoryDelete')->name('menu.category.delete');
        });

        Route::prefix('/addon')->group(function () {
            Route::get('/', 'addon')->name('menu.addon');
            Route::get('/detail', 'addonDetail')->name('menu.addon.detail');
            Route::post('/detail/variant', 'addonDetailAddVariant')->name('menu.addon.detail.add.variant');
            Route::get('/detail/delete', 'addonDetailDelete')->name('menu.addon.detail.delete');
            Route::post('/detail/edit', 'addonDetailEdit')->name('menu.addon.detail.edit');
            Route::get('/edit/name', 'addonDetailEditName')->name('menu.addon.edit.name');
            Route::get('/create', 'addonCreate')->name('menu.addon.create');
            Route::post('/', 'addonStore')->name('menu.addon.store');
        });

        Route::prefix('/recipe')->group(function () {
            Route::get('/', 'recipe')->name('menu.recipe');
            Route::get('/create-addon', 'recipeAddonCreate')->name('menu.create.recipe.addon');
            Route::get('/create-menu', 'recipeMenuCreate')->name('menu.create.recipe.menu');
            Route::post('/', 'recipeStore')->name('menu.recipe.store');
            Route::post('/store', 'recipeMenuStore')->name('menu.recipe.menu.store');
        });

        Route::get('/list', 'list')->name('menu.list');
        Route::get('/create', 'createMenu')->name('menu.create');
        Route::post('/store', 'storeMenu')->name('menu.store');
        Route::get('/detail', 'detailMenu')->name('menu.detail');
        Route::get('/edit', 'editMenu')->name('menu.edit');
        Route::post('/update', 'updateMenu')->name('menu.update');
        Route::get('/delete', 'deleteMenu')->name('menu.delete');

        // JSON Response
        Route::get('/find-all', 'findAllMenu')->name('menu.find.all');
        Route::get('/find-variant-addon', 'findVariantAddon')->name('menu.find.variant.addon');
        Route::get('/variant-addon', 'variantAddonFind')->name('menu.variant.addon.find');
        Route::get('/find-menu', 'findMenu')->name('menu.find.menu');
    });

    Route::prefix('/discount')->controller(DiscountController::class)->group(function () {
        Route::get('/', 'index')->name('discount');
        Route::get('/create', 'create')->name('discount.create');
        Route::post('/store', 'store')->name('discount.store');
        Route::get('/detail', 'detail')->name('discount.detail');
        Route::get('/edit', 'edit')->name('discount.edit');
        Route::post('/update', 'update')->name('discount.update');
        Route::get('/delete', 'delete')->name('discount.delete');

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
        Route::post('/change-payment-method', 'changePaymentMethod')->name('pos.payment.method.change');
    });

    Route::prefix('/transaction')->controller(TransactionController::class)->group(function () {
        Route::get('/', 'index')->name('transaction.index');
        Route::get('/detail', 'detail')->name('transaction.detail');
        Route::post('/', 'store')->name('transaction.store');
        Route::post('/data', 'dataStore')->name('transaction.data.store');
        Route::get('/data', 'findDataCart')->name('transaction.data.find');
        Route::post('/create/transaction-payment', 'createTransactionPayment')->name('transaction.create.payment');
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
            Route::get('/create', 'createMaterial')->name('inventory.material.create');
            Route::post('/', 'storeMaterial')->name('inventory.material.store');
            Route::get('/detail', 'detailMaterial')->name('inventory.material.detail');
            Route::get('/edit', 'editMaterial')->name('inventory.material.edit');
            Route::post('/update', 'updateMaterial')->name('inventory.material.update');
            Route::get('/delete', 'deleteMaterial')->name('inventory.material.delete');
        });

        Route::prefix('/purchase-order')->group(function () {
            Route::get('/', 'indexPurchaseOrder')->name('inventory.purchase.order');
            Route::get('/detail', 'detailPurchaseOrder')->name('inventory.purchase.order.detail');
            Route::get('/create', 'createPurchaseOrder')->name('inventory.purchase.order.create');
            Route::post('/store', 'storePurchaseOrder')->name('inventory.purchase.order.store');

            Route::post('/cancel', 'cancelPurchaseOrder')->name('inventory.purchase.order.cancel');
            Route::post('/process', 'processPurchaseOrder')->name('inventory.purchase.order.process');

            // JSON
            Route::get('/find-material', 'findMaterial')->name('inventory.purchase.order.find.material');
        });

        Route::prefix('/manage-stock')->group(function () {
            Route::get('/', 'indexManageStock')->name('inventory.manage.stock');
            Route::get('/detail', 'detailManageStock')->name('inventory.manage.stock.detail');
        });

        Route::prefix('/stock-consumption')->group(function () {
            Route::get('/', 'indexStockConsumption')->name('inventory.stock.consumption');
        });

        Route::prefix('/transfer-stock')->group(function () {
            Route::get('/', 'indexTransferStock')->name('inventory.transfer.stock');
        });
    });

    Route::prefix('/customer-display')->controller(CustomerDisplayController::class)->group(function () {
        Route::get('/', 'index')->name('customer.display');
    });
});
