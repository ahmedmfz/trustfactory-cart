<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Cart\Show as CartShow;
use App\Livewire\Orders\Index as OrdersIndex;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products', ProductsIndex::class)->name('products.index');
    Route::get('/cart', CartShow::class)->name('cart.show');
    Route::get('/orders', OrdersIndex::class)->name('orders.index');
});