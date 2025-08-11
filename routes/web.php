<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [ShopController::class,'home'])->name('home');

// Public shop page
Route::get('/shop', function () {
    return view('customer.shop.shop');
})->name('shop');

Route::get('/wigs', function () {
    return view('customer.shop.wigs');
})->name('wigs');

Route::get('/cart', function () {
    return view('customer.shop.cart');
})->name('cart');

Route::get('/signin', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

Route::get('/login', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'login'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'logout'])->name('logout');

// Customer password reset/forgot
Route::get('/password/forgot', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'reset'])->name('password.update');

Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register'])->name('register.post');

// Admin routes (all grouped under 'admin' prefix and 'admin.' name)
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin authentication (public)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin management routes (require auth and admin role)
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Products management
        Route::resource('products', ProductController::class);
        Route::post('products/{product}/images', [ProductController::class, 'storeImages'])->name('products.images.store');
        Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.delete');

        // Categories management
        Route::resource('categories', CategoryController::class);

        // Orders management
        Route::resource('orders', OrderController::class);
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

        // Customers management
        Route::resource('customers', CustomerController::class);
        Route::get('customers/{customer}/orders', [CustomerController::class, 'orders'])->name('customers.orders');

        // Transactions management
        Route::resource('transactions', TransactionController::class);
        Route::get('transactions/{transaction}/details', [TransactionController::class, 'details'])->name('transactions.details');

        // Vouchers management
        Route::resource('vouchers', VoucherController::class);
        Route::post('vouchers/{voucher}/activate', [VoucherController::class, 'activate'])->name('vouchers.activate');
        Route::post('vouchers/{voucher}/deactivate', [VoucherController::class, 'deactivate'])->name('vouchers.deactivate');
    });
});

// Authentication routes
Route::middleware('auth')->group(function () {
    // Customer routes
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
        Route::get('/products/{product}', [ShopController::class, 'show'])->name('products.show');

        // Cart routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::put('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // Customer orders
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');
    });
});

// Payment routes (public but with CSRF protection)
Route::middleware('web')->group(function () {
    Route::post('/payment/initialize', [PaymentController::class, 'initialize'])->name('payment.initialize');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');
    Route::get('/payment/verify/{reference}', [PaymentController::class, 'verify'])->name('payment.verify');
});

// Fallback route
Route::fallback(function () {
    return view('welcome');
});
