<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Mobilehub\BkashController;
use App\Http\Controllers\Mobilehub\OrderController;
use App\Http\Controllers\Frontend\CartWishController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Mobilehub\PaymentController;
use App\Http\Controllers\Mobilehub\DemoPaymentController;
use App\Http\Controllers\NewsletterController;

// ----------------------
// Home ROUTES
// ----------------------


// Newsletter Routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Admin Newsletter Routes (if needed)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('admin.newsletter.index');
    Route::delete('/newsletter/{newsletter}', [NewsletterController::class, 'destroy'])->name('admin.newsletter.destroy');
});
Route::get('/', [HomeController::class, 'Homeindex'])->name('index');
// Static Pages Routes
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/details/{id}', [HomeController::class, 'productDetails'])->name('details');
    // Route::get('/create', [HomeController::class, 'create'])->name('create');
    // Route::post('/store', [HomeController::class, 'store'])->name('store');
    Route::get('/brand/{brand}', [HomeController::class, 'BrandProduct'])->name('brand.products');
    Route::get('/category/{category}', [HomeController::class, 'CategoryProduct'])->name('category.products');
    // Route::put('/update/{brand}', [HomeController::class, 'update'])->name('update');
    // Route::delete('/delete/{brand}', [HomeController::class, 'destroy'])->name('destroy');
    // Track product view (AJAX)
    // Route::post('/{id}/track-view', [HomeController::class, 'trackView'])
    //     ->name('trackView');
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




// Payment Routes
Route::prefix('payment')->group(function () {
    Route::get('/process/{payment}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/success/{payment}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/cancel/{payment}', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/webhook/{gateway}', [PaymentController::class, 'webhook'])->name('payment.webhook');
});

// Order Routes
Route::prefix('order')->group(function () {
    // Order Pages
    Route::get('/confirmation/{order}', [OrderController::class, 'confirmation'])->name('frontend.pages.orderconfirmation');
    Route::get('/details/{order}', [OrderController::class, 'show'])->name('order.details');
    Route::get('/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('/tracking/{order}', [OrderController::class, 'tracking'])->name('order.tracking');
    Route::get('/print/{order}', [OrderController::class, 'print'])->name('order.print');

    // Order Actions
    Route::post('/cancel/{order}', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('/reorder/{order}', [OrderController::class, 'reorder'])->name('order.reorder');
    Route::get('/invoice/{order}', [OrderController::class, 'downloadInvoice'])->name('order.invoice');
    Route::get('/status/{order}', [OrderController::class, 'getOrderStatus'])->name('order.status');
    Route::get('/invoice/view/{order}', [OrderController::class, 'viewInvoice'])->name('order.invoice.view');

    // Public Order Tracking
    Route::get('/track', function () {
        return view('frontend.pages.trackorder');
    })->name('order.track');
    Route::post('/track', [OrderController::class, 'trackOrder'])->name('order.track.submit');
});


// Demo Payment Routes
Route::prefix('payment')->group(function () {
    Route::get('/demo/{payment}', [DemoPaymentController::class, 'showDemoPayment'])->name('payment.demo');
    Route::post('/demo/process/{payment}', [DemoPaymentController::class, 'processDemoPayment'])->name('payment.demo.process');

    // Stripe Routes
    Route::get('/stripe/success/{payment}', [PaymentController::class, 'stripeSuccess'])->name('payment.stripe.success');

    // bKash Routes
    Route::prefix('bkash')->group(function () {
        Route::post('/create/{payment}', [BkashController::class, 'createPayment'])->name('payment.bkash.create');
        Route::get('/callback/{payment}', [BkashController::class, 'callback'])->name('payment.bkash.callback');
        Route::post('/execute/{payment}', [BkashController::class, 'executePayment'])->name('payment.bkash.execute');
    });
});


// // Order Routes
// Route::prefix('order')->group(function () {
//     Route::get('/confirmation/{order}', [OrderController::class, 'confirmation'])->name('frontend.pages.orderconfirmation');
//     Route::get('/details/{order}', [OrderController::class, 'show'])->name('order.details');
//     Route::get('/history', [OrderController::class, 'history'])->name('order.history');
//     Route::get('/tracking/{order}', [OrderController::class, 'tracking'])->name('order.tracking');
// });

});




