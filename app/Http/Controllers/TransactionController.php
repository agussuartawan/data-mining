<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
    	$transaction = Transaction::all();
    	$title = "Transaksi Penjualan";

    	return view('transaction.index', compact('transaction', 'title'));
    }
}
