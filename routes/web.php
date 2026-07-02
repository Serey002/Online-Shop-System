<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ProfileController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Admin Guest Routes (Login / Authentication)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Logout action requires an active web session
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

// Protected Admin Panel Panel Routes (Blade Sessions Only)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // 1. Central Admin Dashboard Statistics Page (CORRECTED INTERFACE COUPLING)
    Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])->name('admin.dashboard');
    
    // 2. Full Category CRUD Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // 3. Full Product CRUD Routes (Includes file image upload actions)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 4. Orders Management Routes (Listing, Viewing, Status Updates)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status.update');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');

    // Profile Settings Routes
    Route::get('/settings', [ProfileController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/settings', [ProfileController::class, 'update'])->name('admin.settings.update');
});