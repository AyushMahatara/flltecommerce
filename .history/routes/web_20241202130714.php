<?php

use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProdectDetailPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class)->name('categories');
Route::get('/products', ProductsPage::class)->name('products');
Route::get('/products/{product}', ProdectDetailPage::class)->name('product.details.page');
Route::get('/cart', CartPage::class)->name('carts');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('/my-orders', MyOrdersPage::class)->name('my.orders');
Route::get('/my-orders/{order}', MyOrderDetailPage::class)->name('my.orders.detail');

Route::get('/login', LoginPage::class)->name('login');
Route::get('/register', RegisterPage::class)->name('register');
Route::get('/forgot', ForgotPasswordPage::class)->name('forgot.password');
Route::get('/reset', ResetPasswordPage::class)->name('reset.password');

Route::get('/success', SuccessPage::class)->name('success');
Route::get('/cancel', CancelPage::class)->name('cancel');
