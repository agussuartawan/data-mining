<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = "Dashboard";
    $count_transaction = App\Transaction::count();
    $count_product = App\Product::count();
    $count_user = App\User::count();
    $count_bundle = App\ProductBundle::count();
    return view('welcome', compact('title','count_transaction','count_product','count_user','count_bundle'));
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

Route::get('transaction/{transaction}/show', 'TransactionController@show')
    ->name('transaction.show');


#bundle
Route::get('bundle/index', 'BundleController@index')
    ->name('bundle.index');

Route::get('bundle/create', 'BundleController@create')
    ->name('bundle.create');

Route::post('bundle/create', 'BundleController@store')
    ->name('bundle.store');

Route::get('bundle/result', 'BundleController@result')
    ->name('bundle.result');
