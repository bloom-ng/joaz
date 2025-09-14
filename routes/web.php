<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsletterController;
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

// Newsletter subscription
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterSubscriptionController::class, 'store'])
    ->name('newsletter.subscribe');
Route::get('product-details/{id}', [ShopController::class, 'productDetails'])->name('shop.productDetails');
// Main category page route - handles both parent and child categories
Route::get('/category/{category?}', [ShopController::class, 'categoryPage'])
    ->where('category', '[0-9]+') // Only match numeric category IDs
    ->name('shop.category');

// Profile routes (protected - requires authentication)
Route::middleware('auth')->group(function () {
    // Profile update route
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('profile.update-address');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Guest cart routes (no authentication required)
Route::post('/guest/cart/add', [CartController::class, 'add'])->name('guest.cart.add');
Route::delete('/cart/guest/{itemId}', [CartController::class, 'remove'])->name('cart.guest.remove');

Route::get('/learn', function () {
    return view('customer.learn');
})->name('learn');

Route::get('/readmore', function () {
    return view('customer.readmore');
})->name('readmore');

Route::get('/contact-us', function () {
    return view('customer.contact-us');
})->name('contact-us');

Route::get('/no-delivery', function () {
    return view('customer.shop.no-delivery');
})->name('no-delivery');

Route::get('/order-summary', function () {
    return view('customer.shop.order-summary');
})->name('order-summary');

use App\Http\Controllers\CheckoutController;

// Checkout routes
Route::get('/confirm-delivery', [CheckoutController::class, 'showDeliveryForm'])->name('confirm-delivery');
Route::post('/process-delivery', [CheckoutController::class, 'processDelivery'])->name('process-delivery');
Route::post('/checkout/add-address', [CheckoutController::class, 'addAddress'])
    ->name('checkout.addAddress');
Route::post('/checkout/set-default-address', [CheckoutController::class, 'setDefaultAddress'])
    ->name('checkout.setDefaultAddress');

Route::get('/confirm-delivery2', function () {
    return view('customer.shop.confirm-delivery2');
})->name('confirm-delivery2');

// Route::get('/select-pickup', function () {
//     return view('customer.shop.pickup');
// })->name('select-pickup');

// web.php
Route::get('/select-pickup', [CheckoutController::class, 'showPickupSelect'])->name('select-pickup');
Route::post('/checkout/set-pickup', [CheckoutController::class, 'setPickup'])->name('checkout.setPickup');



Route::get('/order-summary2', [CheckoutController::class, 'index'])->name('order-summary2');

Route::get('/payment-redirect', function () {
    return view('customer.shop.payment-redirect');
})->name('payment-redirect');

// Account center route - uses CartController@index to handle cart logic
Route::get('/account-center', [CartController::class, 'index'])->name('account-center');

Route::get('/address-book', function () {
    $user = Auth::user();
    return view('customer.shop.address-book', ['user' => $user]);
})->name('address-book');

Route::get('/my-orders', function () {
    return view('customer.shop.my-orders');
})->name('my-orders');
//public routes added by lekan to hit for testing


Route::get('/signin', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

// Route::get('/login', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'login'])->name('login.post');
Route::post('/user-logout', [\App\Http\Controllers\Customer\CustomerLoginController::class, 'userLogout'])->name('user-logout');

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

        // Reviews management
        Route::resource('reviews', ReviewController::class);

        // Newsletter management
        Route::get('newsletters', [NewsletterController::class, 'index'])->name('newsletters.index');
        Route::post('newsletters', [NewsletterController::class, 'store'])->name('newsletters.store');
        Route::delete('newsletters/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletters.destroy');
        Route::get('newsletters/export', [NewsletterController::class, 'exportToCsv'])->name('newsletters.export');

        // Pickup Addresses management
        Route::resource('pickup-addresses', \App\Http\Controllers\Admin\PickupAddressController::class)->except(['show']);

        // Delivery Fees management
        Route::resource('delivery-fees', \App\Http\Controllers\Admin\DeliveryFeeController::class)->except(['show']);

    });

    Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class)->except(['show']);
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
        Route::get('/account-center', [OrderController::class, 'index'])->name('account.center');

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
