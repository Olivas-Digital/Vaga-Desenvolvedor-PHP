<?php

use App\Http\controllers\SellerController;
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
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('vendedores')->group(function() {
        Route::get('/', [SellerController::class, 'index']);
        Route::get('/{seller}', [SellerController::class, 'show']);
    });
});

Auth::routes();

