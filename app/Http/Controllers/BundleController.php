<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileList;
use App\Transaction;
use App\Product;
use DB;

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
        //Proses 1. mengubah data transaksi menjadi bentuk tabular dan menghitung support tiap 1-itemset
        //sekaligus mengeliminasi itemset dengan nilai dibawah minimum support
        $transactions = Transaction::where('file_list_id', $request->filelist)->get();
        $count_transaction = count($transactions);

        foreach ($transactions as $t) {
            foreach ($t->product as $p) {
                $pid[] = $p->id;
                $pid2 = array_unique($pid);
            }  
        }
        $products = Product::whereIn('id',$pid2)->get();
        foreach ($products as $p) {
            $jumlah = DB::table('product_transaction')->where('product_id', $p->id)->count();
            $support = $jumlah / $count_transaction;
            if($support > 0.3){
                $itemset1[] = [
                    'id' => $p->id,
                    'name' => $p->name,
                    'jumlah' => $jumlah,
                    'support' => $support
                ];
            }
        }
        //Proses 1 berakhir. Data hasil disimpan di $itemset1
        dd($itemset1);
    }
}
