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

        DB::table('itemset1')->truncate();
        DB::table('kandidat_itemset2')->truncate();
        DB::table('item2')->truncate();

        $transactions = Transaction::where('file_list_id', $request->filelist)->get();
        $count_transaction = count($transactions);

        foreach ($transactions as $t) {
            foreach ($t->product as $p) {
                $pid[] = $p->id;
                $pid2 = array_unique($pid);
            }
        }
        $products = Product::whereIn('id', $pid2)->get();
        foreach ($products as $p) {
            $jumlah = DB::table('product_transaction')->where('product_id', $p->id)->count();
            $support = $jumlah / $count_transaction;
            if ($support > 0.3) {
                DB::table('itemset1')->insert([
                    'product_id' => $p->id,
                    'product_name' => $p->name,
                    'jumlah' => $jumlah,
                    'support' => $support,
                    'status' => 'L'
                ]);
            }
        }
        //Proses 1 berakhir. Data hasil disimpan di tabel itemset1

        // Proses 2. Membuat kombinasi 2-itemset
        $itemset1 = DB::table('itemset1')->get();

        foreach($itemset1 as $a => $item_a) {
            $k_itemset_a = $item_a->product_name;
            $item2 = DB::table('item2')->select('item1', 'item2')->get();

            if ($item2) {
                DB::table('kandidat_itemset2')->insert([
                    'item1' => $item_a->product_name,
                    'item2' => $item_b->product_name
                ]);
            } else {
                foreach($item2 as $b => $item_b) {
                    $k_itemset_b = $item_b->product_name;
                    if ($item_a->product_id != $item_b->product_id) {

                        DB::table('kandidat_itemset2')->insert([
                            'item1' => $item_a->product_name,
                            'item2' => $item_b->product_name
                        ]);
                    }
                }
            }
        }
    }

    function if_exist_itemset2($count_item2, $a, $b){
        for ($i=0; $i < $count_item2; $i++) { 
            
        }
    }
}
