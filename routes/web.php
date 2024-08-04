<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Admin\Banner;
use App\Livewire\Admin\Category;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Order;
use App\Livewire\Admin\Product;
use App\Livewire\Admin\User;
use App\Livewire\Admin\Voucher;
use App\Livewire\User\AccountPage;
use App\Livewire\User\Auth\LoginPage;
use App\Livewire\User\Auth\LogoutPage;
use App\Livewire\User\Auth\RegisterPage;
use App\Livewire\User\CartPage;
use App\Livewire\User\CategoriesPage;
use App\Livewire\User\CategoryDetailPage;
use App\Livewire\User\CheckoutPage;
use App\Livewire\User\HomePage;
use App\Livewire\User\MyOrderDetailPage;
use App\Livewire\User\MyOrdersPage;
use App\Livewire\User\ProductDetailPage;
use App\Livewire\User\ProductsPage;
use App\Livewire\User\SuccessPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{slug}', ProductDetailPage::class);
Route::get('/categories/{slug}', CategoryDetailPage::class);

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');

    Route::get('/register', RegisterPage::class);

    Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);

    Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    });

    Route::get('/checkout', CheckoutPage::class);
    Route::get('/my-orders', MyOrdersPage::class);
    Route::get('/my-orders/{id}', MyOrderDetailPage::class);
    Route::get('/account', AccountPage::class);
    Route::get('/order-success/{order}', SuccessPage::class)->name('order.success');

    Route::post('/vnpay_payment', [PaymentController::class, 'vnpay_payment']);
    
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', Dashboard::class)->name('admin.dashboard');
        Route::get('/user', User::class)->name('admin.user');
        Route::get('/category', Category::class)->name('admin.category');
        Route::get('/product', Product::class)->name('admin.product');
        Route::get('/order', Order::class)->name('admin.order');
        Route::get('/voucher', Voucher::class)->name('admin.voucher');
        Route::get('/banner', Banner::class)->name('admin.banner');
    });
});




