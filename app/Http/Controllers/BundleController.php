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
        DB::table('itemset2')->truncate();
        DB::table('itemset3')->truncate();

        $transactions = Transaction::where('file_list_id', $request->filelist)->get();
        $count_transaction = count($transactions);

        foreach ($transactions as $t) {
            foreach ($t->product as $p) {
                $pid[] = $p->id;
                $pid2 = array_unique($pid);
            }
        }

        $products = Product::whereIn('id', $pid2)->get(); //mengambil data produk yang termasuk dalam transaksi
        foreach ($products as $p) {
            $jumlah = DB::table('product_transaction')->where('product_id', $p->id)->count();
            $support = $jumlah / $count_transaction;
            if ($support > 0.1) {
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
            foreach($itemset1 as $b => $item_b) {
                if ($item_a->product_id != $item_b->product_id) {
                    DB::table('itemset2')->insert([
                        'product_id_a' => $item_a->product_id,
                        'product_id_b' => $item_b->product_id,
                        'product_name' => $item_a->product_name . ',' . $item_b->product_name,
                        'jumlah' => 0,
                        'support' => 0,
                        'status' => 'T'
                    ]);
                }
            }
        }

        $i = 0;
        do {
            $k_item2 = DB::table('itemset2')->get();
            if($k_item2[$i]->product_id_a != NULL && $k_item2[$i]->product_id_b != NULL){
                DB::table('itemset2')
                    ->where('product_id_a', $k_item2[$i]->product_id_b)
                    ->where('product_id_b', $k_item2[$i]->product_id_a)
                    ->update([
                        'product_id_a' => NULL,
                        'product_id_b' => NULL,
                        'product_name' => NULL
                    ]);
            }
            $count = DB::table('itemset2')->count();
            $i++;
        } while($i < $count);
        DB::table('itemset2')
            ->where('product_id_a', NULL)
            ->where('product_id_b', NULL)
            ->delete();


        $itemset2_fix = DB::table('itemset2')->select('id','product_id_a','product_id_b')->get();
        $cek = array();
        foreach ($itemset2_fix as $product_itemset2) {
            foreach ($transactions as $t) {
                foreach ($t->product as $product_detail) {
                    if ($product_itemset2->product_id_a == $product_detail->pivot->product_id) {
                        $cek[$t->no_invoice][0] = 1;
                        break;
                    } else {
                        $cek[$t->no_invoice][0] = 0;
                    }
                }

                foreach ($t->product as $product_detail) {
                    if ($product_itemset2->product_id_b == $product_detail->pivot->product_id) {
                        $cek[$t->no_invoice][1] = 1;
                        break;
                    } else {
                        $cek[$t->no_invoice][1] = 0;
                    }
                }
            }
            $jum = 0;
            foreach ($cek as $value) {
                if ($value[0] != 0 && $value[1] != 0) {
                    if ($value[0] == $value[1]) {
                        $jum++;
                    }
                }
            }
            $support = $jum / $count_transaction;
            if ($support > 0.1) {
                $status = 'L';
            } else {
                $status = 'T';
            }
            DB::table('itemset2')->where('id', $product_itemset2->id)->update([
                'jumlah' => $jum,
                'support' => $support,
                'status' =>$status
            ]);
        }
        DB::table('itemset2')->where('status', 'T')->delete();
        // Proses 2 Selesai

        //Prosess 3. Membuat kombinasi 3-itemset
        // 1. Proses mengambil data 2 itemset yang item pertamanya sama
        $itemset2_lolos = DB::table('itemset2')->get();
        foreach ($itemset2_lolos as $value) {
            $item2_kembar = DB::table('itemset2')->where('product_id_a', $value->product_id_a)->get();
            if (count($item2_kembar) > 1) {
                $kandidat_item3[] = $item2_kembar;
            }
        }
        $kandidat_item3_lolos = array_values(array_unique($kandidat_item3));
        // 2. Setelah didapat data 2 itemset yang item satunya kembar
        // selanjutnya mulai membuat kombinasi 3 itemset 
        foreach($kandidat_item3_lolos as $a => $item3_a) {
            foreach($kandidat_item3_lolos as $b => $item3_b) {
                if ($item3_a[$a]->product_id_b != $item3_b[$b]->product_id_b) {
                    //mengambil data nama produk berdasarkan id itemset yang terpilih
                    $pname_a = DB::table('products')
                                ->select('name')
                                ->where('id', $item3_a[$a]->product_id_a)
                                ->first(); //hasilnya berupa objek $pname_a->name
                    $pname_b = DB::table('products')
                                ->select('name')
                                ->where('id', $item3_a[$a]->product_id_b)
                                ->first(); //hasilnya berupa objek $pname_b->name
                    $pname_c = DB::table('products')
                                ->select('name')
                                ->where('id', $item3_b[$b]->product_id_b)
                                ->first(); //hasilnya berupa objek $pname_c->name
                    
                    DB::table('itemset3')->insert([
                        'product_id_a' => $item3_a[$a]->product_id_a,
                        'product_id_b' => $item3_a[$a]->product_id_b,
                        'product_id_c' => $item3_b[$b]->product_id_b,
                        'product_name' => $pname_a->name. ',' .$pname_b->name. ',' .$pname_c->name,
                        'jumlah' => 0,
                        'support' => 0,
                        'status' => 'T'
                    ]);
                }
            }
        }

        // $z = 0;
        // do {
        //     $k_item3 = DB::table('itemset3')->get();
        //     if($k_item3[$z]->product_id_b != NULL && $k_item3[$z]->product_id_c != NULL){
        //         DB::table('itemset3')
        //             ->where('product_id_b', $k_item3[$z]->product_id_c)
        //             ->where('product_id_c', $k_item3[$z]->product_id_b)
        //             ->update([
        //                 'product_id_a' => NULL,
        //                 'product_id_b' => NULL,
        //                 'product_id_c' => NULL,
        //                 'product_name' => NULL
        //             ]);
        //     }
        //     $count_item3 = DB::table('itemset3')->count();
        //     $z++;
        // } while($z < $count_item3);
        // DB::table('itemset3')
        //     ->where('product_id_a', NULL)
        //     ->where('product_id_b', NULL)
        //     ->where('product_id_c', NULL)
        //     ->delete();
    }
}
