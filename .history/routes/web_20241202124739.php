<?php

use App\Livewire\HomePage;
use App\Livewire\ProductsPage;
use App\Livewire\CategoriesPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class)->name('categories');
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products', ProductsPage::class)->name('products');
