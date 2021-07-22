<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\FileList;
use App\Imports\TransactionsImport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index($id)
    {
    	if($id >= 0) {    	
    		$transaction = Transaction::where('file_list_id', $id)->get();
    	} elseif($id == 'latest') {
    		$filelist_latest = FileList::select('id')->latest()->first()->id;
	    	$transaction = Transaction::where('file_list_id', $filelist_latest)->get();
    	}
    	$title = "Transaksi Penjualan";

    	return view('transaction.index', compact('transaction', 'title'));
    }

    public function create()
    {
    	$title = "Transaksi Penjualan";
    	return view('transaction.create', compact('title'));
    }

    public function filelist()
    {
    	$title = "Transaksi Penjualan";
    	$filelist = FileList::all();
    	return view('transaction.filelist', compact('title', 'filelist'));
    }

    public function import(Request $request) 
	{
		$title = "Transaksi Penjualan";
		$file = $request->file('file');
		$fileName = $file->getClientOriginalName();
		$file->move('DataTransaction', $fileName);

	    Excel::import(new TransactionsImport, public_path('/DataTransaction/' . $fileName));

	    return view('transaction.create', compact('title'));
	}
}
