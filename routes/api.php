<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
   
    // ========== Публичные маршруты ==========
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/feedback', [FeedbackController::class, 'store']);
    
    // ========== Аутентификация ==========
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // ========== Защищенные маршруты ==========
    Route::middleware('auth:sanctum')->group(function () {
        
        // Профиль
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/user', [AuthController::class, 'update']);
        
        // Корзина
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart/items', [CartController::class, 'addItem']);
        Route::put('/cart/items/{productId}', [CartController::class, 'updateQuantity']);
        Route::delete('/cart/items/{productId}', [CartController::class, 'removeItem']);
        Route::delete('/cart', [CartController::class, 'clear']);
        
        // Заказы
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        
        // Сертификаты
        Route::get('/certificates', [CertificateController::class, 'index']);
        Route::post('/certificates', [CertificateController::class, 'store']);
        Route::post('/certificates/validate', [CertificateController::class, 'checkValidity']);
        Route::post('/certificates/use', [CertificateController::class, 'use']);
        
        // ========== Админские маршруты ==========
        Route::middleware('admin')->prefix('admin')->group(function () {
            Route::apiResource('products', AdminProductController::class);
            Route::get('/orders', [AdminOrderController::class, 'index']);
            Route::put('/orders/{order}', [AdminOrderController::class, 'update']);
            Route::get('/users', [AdminUserController::class, 'index']);
            Route::put('/users/{user}/bonuses', [AdminUserController::class, 'updateBonuses']);
            Route::get('/certificates', [AdminCertificateController::class, 'index']);
            Route::post('/certificates', [AdminCertificateController::class, 'store']);
            Route::delete('/certificates/{certificate}', [AdminCertificateController::class, 'destroy']);
            Route::get('/feedback', [AdminFeedbackController::class, 'index']);
            Route::put('/feedback/{feedback}/read', [AdminFeedbackController::class, 'markAsRead']);
            Route::post('/feedback/{feedback}/reply', [AdminFeedbackController::class, 'sendReply']);
            Route::get('/stats', [DashboardController::class, 'stats']);
        });
    });
    
    // ========== Тестовые маршруты ==========
    Route::post('/test-cert', function (Request $request) {
        return response()->json([
            'message' => 'Test работает!',
            'data' => $request->all()
        ]);
    });
});

// ========== Тестовые маршруты вне префикса v1 ==========
Route::post('/test-simple', function (Request $request) {
    return response()->json(['message' => 'Simple test works!']);
});

// Тестовый маршрут с авторизацией
Route::middleware('auth:sanctum')->post('/test-auth', function (Request $request) {
    return response()->json([
        'message' => 'Auth работает!',
        'user' => $request->user()->name
    ]);
});
