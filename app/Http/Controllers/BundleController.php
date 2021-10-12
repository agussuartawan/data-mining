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
        // dd($itemset1);
        //Proses 1 berakhir. Data hasil disimpan di $itemset1

        //Proses 2. Membuat kombinasi 2-itemset
        $itemset2 = [];
        for ($a=0; $a <  count($itemset1); $a++) {
            for ($b=0; $b < count($itemset1); $b++) { 
                if($itemset1[$a] != $itemset1[$b]){
                    $kandidat1 = $itemset1[$a]['name'];
                    $kandidat2 = $itemset1[$b]['name'];
                    $itemset2 = [$kandidat1, $kandidat2];
                }
            }
        }
        // dd($itemset2[0], $itemset2[2]);

        // if (array_diff($itemset2[4], $itemset2[7])) {
        //     echo "Beda <br>";
        // } else {
        //     echo "Sama <br>";
        // }
        dd($itemset2fix);
    }
}
