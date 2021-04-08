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
Route::get('product/{id}', 'ProductController@index')->name('product.index');
Route::post('product/filter', 'ProductController@filter')->name('product.filter.post');
