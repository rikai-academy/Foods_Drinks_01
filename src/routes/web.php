<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/logout',[LogoutController::class, 'logout']);
Route::get('/admin/login',[LoginController::class, 'login'])->middleware('locale')->name('login_admin');
Route::group(['middleware' => 'locale'], function() {
    # Change language
    Route::get('change-language/{language}', [LocaleController::class, 'changeLanguage'])
        ->name('change-language');

    # Home page
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    # Route Auth
    Auth::routes();

    # Admin page
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
    });
});