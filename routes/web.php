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
    $title = "Dashboard";
    return view('welcome', compact('title'));
});

# Produk
Route::get('product/create', 'ProductController@create')->name('product.create');
Route::get('product/create/bundle', 'ProductController@create_bundle')->name('product.create.bundle');
Route::post('product', 'ProductController@store')->name('product.store');
Route::get('product/{id}', 'ProductController@index')->name('product.index');
