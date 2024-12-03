<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\ProductsPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProdectDetailPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class)->name('categories');
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/{product}', ProdectDetailPage::class)->name('product.details.page');
Route::get('/cart', CartPage::class)->name('carts');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('my-orders', MyOrdersPage::class)->name('my.orders');
