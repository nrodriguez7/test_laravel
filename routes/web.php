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
    \Log::info('TEST LARAVEL 2', ['id' => 123, 'name' => 'Naren']);
    return view('welcome');
});

Route::get('/hola', function () {
    \Log::info('TEST LARAVEL 3', ['id' => 123, 'name' => 'Naren']);
   echo "hola"; die();
});
