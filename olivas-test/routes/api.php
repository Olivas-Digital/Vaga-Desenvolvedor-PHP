<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('auth/login', [AuthController::class, 'login'])->name('user.login');
Route::post('auth/registrar', [AuthController::class, 'register'])->name('user.register');

// Sellers GET route
Route::apiResource('/vendedores', \App\Http\Controllers\SellerController::class, ['only' => ['index']])->names(['index' => 'seller.index']);

Route::group(['middleware' => ['auth:api']], function () {
    // Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);

    Route::apiResource('/vendedores', \App\Http\Controllers\SellerController::class, [
        'only' => ['create', 'update', 'destroy', 'store']
    ])->names([
        'create' => 'seller.create',
        'update' => 'seller.update',
        'store' => 'seller.store',
        'destroy' => 'seller.destroy',
    ]);

    // Client Routes
    Route::apiResource('/clientes', \App\Http\Controllers\ClientController::class)->names([
        'index' => 'client.index',
        'create' => 'client.create',
        'store' => 'client.store',
        'update' => 'client.update',
        'destroy' => 'client.destroy',
    ]);

    Route::apiResource('/tiposCliente', \App\Http\Controllers\ClientTypeController::class)->names([
        'index' => 'typesClient.index',
        'create' => 'typesClient.create',
        'store' => 'typesClient.store',
        'destroy' => 'typesClient.destroy',
    ]);

    Route::apiResource('/clientesTelefone', \App\Http\Controllers\ClientPhoneController::class)->names([
        'index' => 'clientsPhone.index',
        'create' => 'clientsPhone.create',
        'store' => 'clientsPhone.store',
        'update' => 'clientsPhone.update',
        'destroy' => 'clientsPhone.destroy',
    ]);

    Route::apiResource('/clientesVendedores', \App\Http\Controllers\ClientSellerController::class)->names([
        'index' => 'clientsSeller.index',
        'create' => 'clientsSeller.create',
        'store' => 'clientsSeller.store',
        'update' => 'clientsSeller.update',
        'destroy' => 'clientsSeller.destroy',
    ]);
});
