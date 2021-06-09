<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = "Dashboard";
    return view('welcome', compact('title'));
});

# Product
Route::post('product/find', 'ProductController@find')
    ->name('find.product');

Route::get('product/create', 'ProductController@create')
    ->name('product.create');

Route::post('product', 'ProductController@store')
    ->name('product.store');

Route::get('product/{product}/edit', 'ProductController@edit')
    ->name('product.edit');

Route::put('product/{product}/update', 'ProductController@update')
    ->name('product.update');

Route::delete('product/{product}/destroy/', 'ProductController@destroy')
    ->name('product.destroy');

Route::get('product/{product}/show', 'ProductController@show')
    ->name('product.show');

Route::get('product/index/{id}', 'ProductController@index')
    ->name('product.index');


# Product Bundel
Route::get('product/create/bundle', 'ProductBundleController@create')
    ->name('product.create.bundle');

Route::post('product/create/bundle', 'ProductBundleController@store')
    ->name('product.store.bundle');

Route::get('product/{product}/edit/bundle', 'ProductBundleController@edit')
    ->name('product.edit.bundle');

Route::put('product/{product}/update/bundle', 'ProductBundleController@update')
    ->name('product.update.bundle');

Route::post('product/bundle/sum', 'ProductBundleController@sum')
    ->name('product.bundle.sum');

Route::get('product/find/price/{id}', 'ProductBundleController@find_price');


# Group Product
Route::resource('product/group', 'GroupController');

# Customer
Route::resource('customer', 'CustomerController');
