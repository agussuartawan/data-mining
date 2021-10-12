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
        // dd($itemset1[0]->product_name);
        $itemset2 = [];
        for ($a = 0; $a <  count($itemset1); $a++) {
            for ($b = 0; $b < count($itemset1); $b++) {
                if ($itemset1[$a]->product_id != $itemset1[$b]->product_id) {
                    $kandidat1 = $itemset1[$a]->product_id;
                    $kandidat2 = $itemset1[$b]->product_id;
                    $itemset2 = [
                        'product_id_a' => $kandidat1,
                        'product_id_b' => $kandidat2
                    ];
                }
            }

            // if (array_diff($itemset2[$a], $itemset2[$b])) {
            //     DB::table('itemset2')->insertOrIgnore([
            //         'product_id_a' => $itemset1[$a]['product_id_a'],
            //         'product_id_b' => $itemset1[$b]['product_id_b'],
            //         'product_name' => $itemset1[$a]->product_name . ',' . $itemset1[$b]->product_name,
            //         'jumlah' => 0,
            //         'support' => 0,
            //         'status' => 'L'
            //     ]);
            // }

            echo $itemset2['product_id_a'] . ',' . $itemset2['product_id_b'] . '<br>';
        }

        // if (array_diff($itemset2[4], $itemset2[7])) {
        //     echo "Beda <br>";
        // } else {
        //     echo "Sama <br>";
        // }
    }
}
