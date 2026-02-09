<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/product/{product}', [HomeController::class, 'product'])->name('product.show');

// ===== AUTH ROUTES =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/seller/register', [AuthController::class, 'showSellerRegister'])->name('seller.register');
    Route::post('/seller/register', [AuthController::class, 'sellerRegister']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===== AUTHENTICATED BUYER ROUTES =====
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
    Route::delete('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');

    // Buyer Dashboard
    Route::prefix('my')->name('buyer.')->group(function () {
        Route::get('/profile', [BuyerController::class, 'profile'])->name('profile');
        Route::put('/profile', [BuyerController::class, 'updateProfile'])->name('profile.update');
        Route::get('/orders', [BuyerController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [BuyerController::class, 'orderDetail'])->name('order.detail');
        Route::get('/orders/{order}/track', [BuyerController::class, 'trackOrder'])->name('order.track');
        Route::get('/wishlist', [BuyerController::class, 'wishlist'])->name('wishlist');
        Route::post('/wishlist/{product}', [BuyerController::class, 'toggleWishlist'])->name('wishlist.toggle');
        Route::get('/addresses', [BuyerController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [BuyerController::class, 'storeAddress'])->name('addresses.store');
        Route::delete('/addresses/{address}', [BuyerController::class, 'deleteAddress'])->name('addresses.delete');
        Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
        Route::put('/change-password', [AuthController::class, 'updatePassword'])->name('change-password.update');
    });

    // Reviews
    Route::post('/product/{product}/review', [BuyerController::class, 'storeReview'])->name('review.store');
});

// ===== SELLER ROUTES =====
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/pending', [SellerController::class, 'pending'])->name('pending');

    Route::middleware('seller.approved')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');

        // Products
        Route::get('/products', [SellerController::class, 'products'])->name('products');
        Route::get('/products/create', [SellerController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [SellerController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{product}/edit', [SellerController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{product}', [SellerController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{product}', [SellerController::class, 'deleteProduct'])->name('products.delete');

        // Orders
        Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [SellerController::class, 'orderDetail'])->name('orders.detail');
        Route::patch('/orders/{order}/status', [SellerController::class, 'updateOrderStatus'])->name('orders.status');

        // Coupons
        Route::get('/coupons', [SellerController::class, 'coupons'])->name('coupons');
        Route::post('/coupons', [SellerController::class, 'storeCoupon'])->name('coupons.store');
        Route::delete('/coupons/{coupon}', [SellerController::class, 'deleteCoupon'])->name('coupons.delete');

        // Wallet
        Route::get('/wallet', [SellerController::class, 'wallet'])->name('wallet');
        Route::post('/wallet/withdraw', [SellerController::class, 'requestWithdraw'])->name('wallet.withdraw');

        // Profile
        Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
        Route::put('/profile', [SellerController::class, 'updateProfile'])->name('profile.update');
    });
});

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');

    // Sellers
    Route::get('/sellers', [AdminController::class, 'sellers'])->name('sellers');
    Route::patch('/sellers/{seller}/approve', [AdminController::class, 'approveSeller'])->name('sellers.approve');
    Route::patch('/sellers/{seller}/suspend', [AdminController::class, 'suspendSeller'])->name('sellers.suspend');

    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::patch('/products/{product}/approve', [AdminController::class, 'approveProduct'])->name('products.approve');
    Route::patch('/products/{product}/reject', [AdminController::class, 'rejectProduct'])->name('products.reject');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'orderDetail'])->name('orders.detail');
    Route::patch('/orders/{order}/refund', [AdminController::class, 'refundOrder'])->name('orders.refund');

    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Banners
    Route::get('/banners', [AdminController::class, 'banners'])->name('banners');
    Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
    Route::delete('/banners/{banner}', [AdminController::class, 'deleteBanner'])->name('banners.delete');

    // Payments
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::patch('/sellers/{seller}/commission', [AdminController::class, 'updateCommission'])->name('sellers.commission');
    Route::patch('/withdrawals/{withdrawRequest}/approve', [AdminController::class, 'approveWithdraw'])->name('withdrawals.approve');
    Route::patch('/withdrawals/{withdrawRequest}/reject', [AdminController::class, 'rejectWithdraw'])->name('withdrawals.reject');

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

