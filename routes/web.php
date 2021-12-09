<?php

use App\Http\controllers\SellerController;
use App\Http\controllers\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeMail;


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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('app')->group(function() {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Sellers
    Route::get('/vendedores', [SellerController::class, 'page']);
    // Customers
    Route::get('/clientes', [CustomerController::class, 'page']);
});

Auth::routes();

