<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Log;

// Routes công khai (không cần auth)
Route::get('/', [HomeController::class, 'index'])->name('home'); // Thêm route cho trang chủ
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes yêu cầu auth
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập.');
        }
        $role = Auth::user()->role ?? 'user';
        Log::info('Current Role: ' . $role);
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    Route::middleware(['can:user'])->group(function () {
        Route::get('/user/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    });

    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/admin/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/admin/products/{id}', [AdminProductController::class, 'show'])->name('admin.products.show');
        Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/admin/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/admin/orders/{id}/confirm', [AdminOrderController::class, 'confirm'])->name('admin.orders.confirm');
        Route::put('/admin/orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});