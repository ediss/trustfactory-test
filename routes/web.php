<?php

use App\Livewire\CartView;
use App\Livewire\Checkout;
use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Public product listing
Route::get('/products', ProductList::class)->name('products');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', CartView::class)->name('cart');
    Route::get('/checkout', Checkout::class)->name('checkout');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
