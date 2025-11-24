<?php

use App\Http\Controllers\Frontend\CartWishController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


    // ----------------------
    // Home ROUTES
    // ----------------------

     Route::get('/', [HomeController::class, 'index'])->name('index');

        Route::prefix('product')->name('product.')->group(function () {
        Route::get('/details/{id}', [HomeController::class, 'productDetails'])->name('details');
        Route::get('/create', [HomeController::class, 'create'])->name('create');
        Route::post('/store', [HomeController::class, 'store'])->name('store');
        //Route::get('/edit/{brand}', [HomeController::class, 'edit'])->name('edit');
        Route::put('/update/{brand}', [HomeController::class, 'update'])->name('update');
        Route::delete('/delete/{brand}', [HomeController::class, 'destroy'])->name('destroy');
         // Track product view (AJAX)
        Route::post('/{id}/track-view', [HomeController::class, 'trackView'])
        ->name('trackView');
    });

    // ----------------------
    // cart and wish list ROUTES
    // ----------------------

    Route::prefix('product')->name('product.')->group(function () {
      // Cart
        Route::post('/cart/add', [CartWishController::class, 'CartAdd'])->name('cart.add');
        Route::get('/cart', [CartWishController::class, 'index'])->name('cart.index');
        Route::post('/cart/update', [CartWishController::class, 'CartUpdate'])->name('cart.update');
        Route::post('/cart/remove', [CartWishController::class, 'CartRemove'])->name('cart.remove');

        // Wishlist
        Route::post('/wishlist/add', [CartWishController::class, 'WishAdd'])->name('wishlist.add');
        Route::get('/wishlist', [CartWishController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/remove', [CartWishController::class, 'WishRemove'])->name('wishlist.remove');
    });
