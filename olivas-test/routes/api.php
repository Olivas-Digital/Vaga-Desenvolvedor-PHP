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
    'show' => 'seller.show',
    'edit' => 'seller.edit',
    'update' => 'seller.update',
    'destroy' => 'seller.destroy',
]);
