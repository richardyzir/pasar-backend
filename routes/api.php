<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\UserController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/banners', [BannerController::class, 'index']);
Route::get('/promos', [PromoController::class, 'index']);
// Route::get('/payment-settings', [PaymentSettingController::class, 'index']);
// Route::apiResource('/payment-settings', PaymentSettingController::class)->middleware('role:master');

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register/send-otp', [AuthController::class, 'sendRegisterOtp']);
    Route::post('/register/verify', [AuthController::class, 'verifyRegisterOtp']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/verify-otp', [AuthController::class, 'verifyLoginOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'getOrderDetail']);
});

// Admin Routes
Route::middleware(['auth:sanctum', 'role:admin,master'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Users (hanya master)
    Route::apiResource('/users', UserController::class)->middleware('role:master');

    // Kurir list
    Route::get('/kurir', [AdminOrderController::class, 'kurirList']);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->middleware('permission:orders,view');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->middleware('permission:orders,edit');
    Route::post('/orders/{id}/assign', [AdminOrderController::class, 'assignKurir'])->middleware('permission:orders,edit');

    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->middleware('permission:products,view');
    Route::post('/products', [AdminProductController::class, 'store'])->middleware('permission:products,create');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->middleware('permission:products,edit');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->middleware('permission:products,delete');
    Route::post('/products/{id}/image', [AdminProductController::class, 'uploadImage'])->middleware('permission:products,edit');

    // Banners
    Route::get('/banners', [AdminBannerController::class, 'index'])->middleware('permission:banners,view');
    Route::post('/banners', [AdminBannerController::class, 'store'])->middleware('permission:banners,create');
    Route::post('/banners/upload-temp', [AdminBannerController::class, 'uploadTemp']);
    Route::put('/banners/{id}', [AdminBannerController::class, 'update'])->middleware('permission:banners,edit');
    Route::delete('/banners/{id}', [AdminBannerController::class, 'destroy'])->middleware('permission:banners,delete');
    Route::post('/banners/{id}/image', [AdminBannerController::class, 'uploadImage'])->middleware('permission:banners,edit');

    // Promos
    Route::get('/promos', [AdminPromoController::class, 'index'])->middleware('permission:banners,view');
    Route::post('/promos', [AdminPromoController::class, 'store'])->middleware('permission:banners,create');
    Route::post('/products/upload-temp', [AdminProductController::class, 'uploadTemp']);
    Route::put('/promos/{id}', [AdminPromoController::class, 'update'])->middleware('permission:banners,edit');
    Route::delete('/promos/{id}', [AdminPromoController::class, 'destroy'])->middleware('permission:banners,delete');
    Route::post('/promos/{id}/image', [AdminPromoController::class, 'uploadImage'])->middleware('permission:banners,edit');
});
