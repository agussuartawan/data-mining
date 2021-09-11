<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileList;
use App\Transaction;

class BundleController extends Controller
{
    public function index()
    {
    	$title = "Produk Bundel";
    	return view('bundle.index', compact('title'));
    }

    public function create()
    {
    	$title = "Produk Bundel";
        $filelist = FileList::all();
    	return view('bundle.create', compact('title', 'filelist'));
    }

    public function store(Request $request)
    {
        $transactions = Transaction::where('file_list_id', $request->filelist)->get();
        dd($transactions);
    }
}
