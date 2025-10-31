<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobilehub\BrandController;
use App\Http\Controllers\Mobilehub\CategoryController;
use App\Http\Controllers\Mobilehub\ProductController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('ad_dashboard')
    //    ->name('dashboard_ad')
    ->group(function () {
        Route::get('/', fn() => view('admin.index'))->name('admin_dashboard');
        Route::resource('brands', BrandController::class);
        Route::resource('products', ProductController::class);
    });

//
// Now For Products Management
//

Route::middleware(['auth', 'role:admin'])->group(function () {

    // ----------------------
    // BRAND ROUTES
    // ----------------------
    Route::prefix('brand')->name('brand.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        //Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('edit');
        Route::put('/update/{brand}', [BrandController::class, 'update'])->name('update');
        Route::delete('/delete/{brand}', [BrandController::class, 'destroy'])->name('destroy');
    });

    // ----------------------
    // CATEGORY ROUTES
    // ----------------------
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        // Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit'); // Optional if using same form
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
     // ----------------------
    // Product ROUTES
    // ----------------------
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit'); // Optional if using same form
        Route::put('/update/{category}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });


});
