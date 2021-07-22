<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = "Dashboard";
    return view('welcome', compact('title'));
});

#transaction
Route::get('transaction/index', 'TransactionController@index')->name('transaction.index');
Route::get('transaction/create', 'TransactionController@create')->name('transaction.create');

#bundle
Route::get('bundle/index', 'BundleController@index')->name('bundle.index');
Route::get('bundle/create', 'BundleController@create')->name('bundle.create');
