<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EcommerceIntegrationController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// 1. User Management APIs
// =======================
// Authentication API:
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
});

// User API:
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

// 3. Define Product Management API Endpoints

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);         // List all products
    Route::get('/products/{id}', [ProductController::class, 'show']);     // Show a specific product
    Route::post('/products', [ProductController::class, 'store']);        // Create a new product
    Route::put('/products/{id}', [ProductController::class, 'update']);   // Update a specific product
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);// Delete a specific product
});

// Inventory Routes
Route::get('/inventory/{id}', [InventoryController::class, 'show']);
Route::put('/inventory/{id}', [InventoryController::class, 'update']);
Route::get('/inventory/{id}/history', [InventoryController::class, 'history']);


// Location Routes
Route::get('/locations', [LocationController::class, 'index']);
Route::post('/locations', [LocationController::class, 'store']);
Route::put('/locations/{id}', [LocationController::class, 'update']);
Route::delete('/locations/{id}', [LocationController::class, 'destroy']);

// Order Routes
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Order Items Routes
Route::get('/orders/{order_id}/items', [OrderItemController::class, 'index']);
Route::post('/orders/{order_id}/items', [OrderItemController::class, 'store']);
Route::put('/orders/{order_id}/items/{item_id}', [OrderItemController::class, 'update']);
Route::delete('/orders/{order_id}/items/{item_id}', [OrderItemController::class, 'destroy']);


// Order Routes
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Order Items Routes
Route::get('/orders/{order_id}/items', [OrderItemController::class, 'index']);
Route::post('/orders/{order_id}/items', [OrderItemController::class, 'store']);
Route::put('/orders/{order_id}/items/{item_id}', [OrderItemController::class, 'update']);
Route::delete('/orders/{order_id}/items/{item_id}', [OrderItemController::class, 'destroy']);


// 5. Reporting and Analytics APIs
// Report API:
Route::get('/reports/inventory', [ReportController::class, 'inventory']);
Route::get('/reports/sales', [ReportController::class, 'sales']);
Route::get('/reports/orders', [ReportController::class, 'orders']);
Route::get('/reports/low-stock', [ReportController::class, 'lowStock']);

// Notification API
Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications', [NotificationController::class, 'store']);
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

//
Route::post('/ecommerce/orders', [EcommerceIntegrationController::class, 'receiveOrder']);
Route::get('/ecommerce/inventory', [EcommerceIntegrationController::class, 'syncInventory']);
