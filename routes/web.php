<?php

use App\Livewire\Admin\Category;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User;
use App\Livewire\User\HomePage;
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

Route::prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/user', User::class)->name('admin.user');
    Route::get('/category', Category::class)->name('admin.category');

});
