<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;

// Public/Buyer Routes
Route::get('/', [BuyerController::class, 'index'])->name('home');
Route::get('/collection', [BuyerController::class, 'collection'])->name('collection');
Route::get('/product/{id?}', [BuyerController::class, 'product'])->name('product.detail'); 
Route::get('/checkout', [BuyerController::class, 'checkout'])->name('checkout');
Route::get('/page/{slug}', [App\Http\Controllers\PageController::class, 'page'])->name('page');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('home'); // or buyer dashboard if exists
    })->name('dashboard');

    Route::get('/transaction-history', [BuyerController::class, 'history'])->name('transaction.history');
    
    // Checkout Processing
    Route::post('/checkout/process', [BuyerController::class, 'processCheckout'])->name('checkout.process');
});

// Cart Routes (Public Access)
Route::post('/cart/add', [BuyerController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [BuyerController::class, 'showCart'])->name('cart.show');
Route::delete('/cart/{id}', [BuyerController::class, 'removeFromCart'])->name('cart.remove');

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/stores', [AdminController::class, 'stores'])->name('stores');
});

// Seller Routes
Route::middleware(['auth', 'verified', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
    Route::get('/products', [SellerController::class, 'products'])->name('products');
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::patch('/orders/{id}', [SellerController::class, 'updateOrderStatus'])->name('orders.update');
    Route::get('/setup', [SellerController::class, 'setup'])->name('setup');
    Route::get('/withdrawal', [SellerController::class, 'withdrawal'])->name('withdrawal');
    Route::get('/balance', [SellerController::class, 'balance'])->name('balance');
    Route::get('/categories', [SellerController::class, 'categories'])->name('categories');
    Route::get('/product-image', [SellerController::class, 'productImage'])->name('product.image');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
