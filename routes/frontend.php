<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\CartWishController;
use App\Http\Controllers\Frontend\CheckoutController;


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
// Cart & Wishlist Routes
Route::prefix('product')->name('product.')->middleware('auth')->group(function () {
    // Cart Routes
    Route::post('/cart/add', [CartWishController::class, 'CartAdd'])->name('cart.add');
    Route::get('/cart', [CartWishController::class, 'Cartindex'])->name('cart.index');
    Route::post('/cart/update', [CartWishController::class, 'CartUpdate'])->name('cart.update');
    Route::post('/cart/remove', [CartWishController::class, 'CartRemove'])->name('cart.remove');
    Route::post('/cart/clear', [CartWishController::class, 'ClearCart'])->name('cart.clear');

    // Wishlist Routes
    Route::post('/wishlist/add', [CartWishController::class, 'WishAdd'])->name('wishlist.add');
    Route::get('/wishlist', [CartWishController::class, 'Wishindex'])->name('wishlist.index');
    Route::post('/wishlist/remove', [CartWishController::class, 'WishRemove'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart', [CartWishController::class, 'MoveToCart'])->name('wishlist.move-to-cart');
     Route::post('/wishlist/move-all-to-cart', [CartWishController::class, 'moveAllToCart'])->name('wishlist.move-all-to-cart');

});


// Checkout Routes with Auth Middleware
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/order-summary', [CheckoutController::class, 'getOrderSummary'])->name('checkout.summary');




    // Coupon Routes
Route::prefix('coupon')->name('coupon.')->group(function () {
    Route::post('/apply', [CouponController::class, 'apply'])->name('apply');
    Route::post('/remove', [CouponController::class, 'remove'])->name('remove');
    Route::post('/check', [CouponController::class, 'check'])->name('check');
});




// Buy Now
Route::get('/buy-now/{id}', [CheckoutController::class, 'buyNow'])->name('buy.now');

// Checkout Order Place
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');


Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::post('/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
});

});




