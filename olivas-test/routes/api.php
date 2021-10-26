<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/vendedores', \App\Http\Controllers\SellerController::class)->names([
    'index' => 'seller.index',
    'create' => 'seller.create',
    'store' => 'seller.store',
    'update' => 'seller.update',
    'destroy' => 'seller.destroy',
]);

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
