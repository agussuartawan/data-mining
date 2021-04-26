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
Route::post('product/bundle/sum', 'ProductController@sum')->name('product.bundle.sum');
Route::get('product/find/price/{id}', 'ProductController@find_price');
Route::post('product/find', 'ProductController@find')->name('find.product');
Route::get('product/create', 'ProductController@create')->name('product.create');
Route::get('product/create/bundle', 'ProductController@create_bundle')->name('product.create.bundle');
Route::post('product', 'ProductController@store')->name('product.store');
Route::get('product/{id}/edit', 'ProductController@edit')->name('product.edit');
Route::put('product/{id}/update', 'ProductController@update')->name('product.update');
Route::delete('product/{id}/destroy/', 'ProductController@destroy')->name('product.destroy');
Route::get('product/{id}/show', 'ProductController@show')->name('product.show');
Route::get('product/{id}', 'ProductController@index')->name('product.index');

