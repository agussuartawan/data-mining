<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = "Dashboard";
    return view('welcome', compact('title'));
});

#transaction
Route::get('transaction/data/{id?}', 'TransactionController@index')
    ->name('transaction.data');

Route::get('transaction/create', 'TransactionController@create')
    ->name('transaction.create');

Route::get('transaction/filelist', 'TransactionController@filelist')
    ->name('transaction.filelist');

Route::post('transaction/create', 'TransactionController@import')
    ->name('transaction.import');


#bundle
Route::get('bundle/index', 'BundleController@index')
    ->name('bundle.index');

Route::get('bundle/create', 'BundleController@create')
    ->name('bundle.create');
