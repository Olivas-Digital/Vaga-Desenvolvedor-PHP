<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

// Users
Route::get('/usuario/criar', function () {
    return view('users/create', [
        'title' => 'Criar Usuário',
        'dataPage' => 'create-user-page'
    ]);
});

Route::get('/login', function () {
    return view('users/login', [
        'title' => 'Login Usuário',
        'dataPage' => 'login-user-page'
    ]);
});

// Sellers
Route::get('/vendedores', function () {
    return view('sellers/displayAll', [
        'title' => 'Vendedores',
        'dataPage' => 'sellers-paginate'
    ]);
});

Route::get('/vendedores/criar', function () {
    return view('sellers/create', [
        'title' => 'Registrar um vendedor',
        'dataPage' => 'sellers-create'
    ]);
});

// Clients
Route::get('/clientes', function () {
    return view('clients/displayAll', [
        'title' => 'Clientes',
        'dataPage' => 'clients-paginate'
    ]);
});

Route::get('/clientes/criar', function () {
    return view('clients/create', [
        'title' => 'Registrar um cliente',
        'dataPage' => 'clients-create'
    ]);
});
