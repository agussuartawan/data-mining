<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\FileList;
use App\Transaction;
use App\Product;
use App\Bundle;
use DB;
use PDF;

class BundleController extends Controller
{
    public function index()
    {
        $title = "Produk Bundel";
        $bundles = Bundle::latest()->get();
        return view('bundle.index', compact('title', 'bundles'));
    }

    public function create()
    {
        $title = "Produk Bundel";
        $filelist = FileList::latest()->get();
        return view('bundle.create', compact('title', 'filelist'));
    }

    public function show(Bundle $bundle)
    {
        $title = "Produk Bundel";
        return view('bundle.show', compact('title', 'bundle'));
    }

    public function modal_detail(Bundle $bundle)
    {
        return view('bundle.table-detail', compact('bundle'));
    }

    public function store(Request $request)
    {
        // mengosongkan tabel temporary sebelum perhitungan dimulai
        DB::table('itemset1')->truncate();
        DB::table('itemset2')->truncate();
        DB::table('itemset3')->truncate();
        DB::table('association_rule')->truncate();

        $input_support = $request->support / 100;
        $input_confidence = $request->confidence / 100;
        $transactions = Transaction::where('file_list_id', $request->filelist)->get();
        $count_transaction = count($transactions);

        //Proses 1. mengubah data transaksi menjadi bentuk tabular dan menghitung support tiap 1-itemset
        //sekaligus mengeliminasi itemset dengan nilai dibawah minimum support
        foreach ($transactions as $t) {
            foreach ($t->product as $p) {
                $pid[] = $p->id;
                $pid2 = array_unique($pid);
            }
        }
        $products = Product::whereIn('id', $pid2)->get(); //mengambil data produk yang termasuk dalam transaksi
        foreach ($products as $p) {
            $jumlah = DB::table('product_transaction')
                ->where('product_id', $p->id)
                ->where('file_list_id', $request->filelist)
                ->count();
            $support = $jumlah / $count_transaction;
            ($support >= $input_support) ? $status1 = 'L' : $status1 = 'T';
            DB::table('itemset1')->insert([
                'product_id' => $p->id,
                'product_name' => $p->name,
                'jumlah' => $jumlah,
                'support' => $support,
                'status' => $status1
            ]);
        }
        // Proses 1 berakhir. Data hasil disimpan di tabel itemset1

        $itemset1 = DB::table('itemset1')->where('status', 'L')->get();
        if (count($itemset1) > 0) {
            // Proses 2. Membuat kombinasi 2-itemset
            foreach ($itemset1 as $a => $item_a) {
                foreach ($itemset1 as $b => $item_b) {
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
        } else {
            return redirect()->back()->with('error', 'Tidak ada itemset yang memenuhi nilai minimum support, coba nilai minimum support yang lebih rendah');
        }

        // Selanjutnya mengiliminasi kombinasi itemset-2 yang nilainya kembar
        $i = 0;
        do {
            $k_item2 = DB::table('itemset2')->get();
            if ($k_item2[$i]->product_id_a != NULL && $k_item2[$i]->product_id_b != NULL) {
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
        } while ($i < $count);
        DB::table('itemset2')
            ->where('product_id_a', NULL)
            ->where('product_id_b', NULL)
            ->delete();

        // Selanjutnya menghitung support dari tiap kombinasi 2-itemset
        $itemset2_fix = DB::table('itemset2')->select('id', 'product_id_a', 'product_id_b')->get();
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
                if ($value[0] == 1 && $value[1] == 1) {
                    $jum++;
                }
            }
            $support = $jum / $count_transaction;
            if ($support >= $input_support) {
                $status = 'L';
            } else {
                $status = 'T';
            }
            DB::table('itemset2')->where('id', $product_itemset2->id)->update([
                'jumlah' => $jum,
                'support' => $support,
                'status' => $status
            ]);
        }
        // Proses 2 Selesai

        //Prosess 3. Membuat kombinasi 3-itemset
        // 1. Proses mengambil data 2 itemset yang item pertamanya sama
        $itemset2_lolos = DB::table('itemset2')->where('status', 'L')->get();
        $item3_temporary = [];
        $kandidat_item3 = [];
        if (count($itemset2_lolos) > 0) {
            foreach ($itemset2_lolos as $value) {
                $item2_kembar = DB::table('itemset2')->where('product_id_a', $value->product_id_a)->get();
                if (count($item2_kembar) > 1) {
                    $kandidat_item3[] = $item2_kembar;
                }
            }
            $kandidat_item3_lolos = array_values(array_unique($kandidat_item3)); //mengurutkan index array dan menghapus duplicate data
            foreach ($kandidat_item3_lolos as $val) {
                foreach ($val as $v) {
                    $item3_temporary[] = $v; // menyederhanakan array menjadi satu index
                }
            }
        } else {
            return redirect()->back()->with('error', 'Tidak ada itemset yang memenuhi nilai minimum support, coba nilai minimum support yang lebih rendah');
        }

        // 2. Setelah didapat data 2 itemset yang item-1 nya kembar
        // selanjutnya mulai membuat kombinasi 3 itemset 
        foreach ($item3_temporary as $a => $item3_a) {
            foreach ($item3_temporary as $b => $item3_b) {
                if ($item3_a->product_id_b != $item3_b->product_id_b) {
                    if ($item3_a->product_id_a == $item3_b->product_id_b) {
                        //mengambil data nama produk berdasarkan id itemset yang terpilih
                        $pname_a = DB::table('products')
                            ->select('name')
                            ->where('id', $item3_a->product_id_a)
                            ->first(); //hasilnya berupa objek $pname_a->name
                        $pname_b = DB::table('products')
                            ->select('name')
                            ->where('id', $item3_a->product_id_b)
                            ->first(); //hasilnya berupa objek $pname_b->name
                        $pname_c = DB::table('products')
                            ->select('name')
                            ->where('id', $item3_b->product_id_a)
                            ->first(); //hasilnya berupa objek $pname_c->name
                        DB::table('itemset3')->insertOrIgnore([
                            'product_id_a' => $item3_a->product_id_a,
                            'product_id_b' => $item3_a->product_id_b,
                            'product_id_c' => $item3_b->product_id_a,
                            'product_name' => $pname_a->name . ',' . $pname_b->name . ',' . $pname_c->name,
                            'jumlah' => 0,
                            'support' => 0,
                            'status' => 'T'
                        ]);
                    } else {
                        //mengambil data nama produk berdasarkan id itemset yang terpilih
                        $pname_a = DB::table('products')
                            ->select('name')
                            ->where('id', $item3_a->product_id_a)
                            ->first(); //hasilnya berupa objek $pname_a->name
                        $pname_b = DB::table('products')
                            ->select('name')
                            ->where('id', $item3_a->product_id_b)
                            ->first(); //hasilnya berupa objek $pname_b->name
                        $pname_c = DB::table('products')
                            ->select('name')
                            ->where('id', $item3_b->product_id_b)
                            ->first(); //hasilnya berupa objek $pname_c->name
                        DB::table('itemset3')->insertOrIgnore([
                            'product_id_a' => $item3_a->product_id_a,
                            'product_id_b' => $item3_a->product_id_b,
                            'product_id_c' => $item3_b->product_id_b,
                            'product_name' => $pname_a->name . ',' . $pname_b->name . ',' . $pname_c->name,
                            'jumlah' => 0,
                            'support' => 0,
                            'status' => 'T'
                        ]);
                    }
                }
            }
        }

        // 3. Setelah kombinasi itemset-3 terbentuk, selanjutnya mengeliminasi kombinasi
        // yang kembar agar bersifat unik
        $n = 0;
        do {
            $k_item3_a = DB::table('itemset3')->get();
            if (count($k_item3_a) > 0) {
                $m = 0;
                do {
                    $k_item3_b = DB::table('itemset3')->get();
                    if ($k_item3_a[$n] != $k_item3_b[$m]) {
                        if ($k_item3_a[$n]->product_id_b != NULL && $k_item3_b[$m]->product_id_c != NULL) {
                            $twin_value_count = 0;
                            if ($k_item3_a[$n]->product_id_a ==  $k_item3_b[$m]->product_id_a) {
                                $twin_value_count++;
                            } else if ($k_item3_a[$n]->product_id_a ==  $k_item3_b[$m]->product_id_b) {
                                $twin_value_count++;
                            } else if ($k_item3_a[$n]->product_id_a ==  $k_item3_b[$m]->product_id_c) {
                                $twin_value_count++;
                            }

                            if ($k_item3_a[$n]->product_id_b ==  $k_item3_b[$m]->product_id_a) {
                                $twin_value_count++;
                            } else if ($k_item3_a[$n]->product_id_b ==  $k_item3_b[$m]->product_id_b) {
                                $twin_value_count++;
                            } else if ($k_item3_a[$n]->product_id_b ==  $k_item3_b[$m]->product_id_c) {
                                $twin_value_count++;
                            }

                            if ($k_item3_a[$n]->product_id_c ==  $k_item3_b[$m]->product_id_a) {
                                $twin_value_count++;
                            } else if ($k_item3_a[$n]->product_id_c ==  $k_item3_b[$m]->product_id_b) {
                                $twin_value_count++;
                            } else if ($k_item3_a[$n]->product_id_c ==  $k_item3_b[$m]->product_id_c) {
                                $twin_value_count++;
                            }

                            if ($twin_value_count > 1) {
                                DB::table('itemset3')
                                    ->where('id', $k_item3_b[$m]->id)
                                    ->update([
                                        'product_id_a' => NULL,
                                        'product_id_b' => NULL,
                                        'product_id_c' => NULL,
                                        'product_name' => NULL
                                    ]);
                            }
                        }
                    }
                    $count_item3_b = DB::table('itemset3')->count();
                    $m++;
                } while ($m < $count_item3_b);
            }
            $count_item3_a = DB::table('itemset3')->count();
            $n++;
        } while ($n < $count_item3_a);
        DB::table('itemset3')
            ->where('product_id_a', NULL)
            ->where('product_id_b', NULL)
            ->where('product_id_c', NULL)
            ->delete();

        // 4. Selanjutnya menghitung support dari tiap kombinasi 3-itemset
        $itemset3_fix = DB::table('itemset3')->select('id', 'product_id_a', 'product_id_b', 'product_id_c')->get();
        $cek3 = array();
        foreach ($itemset3_fix as $product_itemset3) {
            foreach ($transactions as $t) {
                foreach ($t->product as $product_detail) {
                    if ($product_itemset3->product_id_a == $product_detail->pivot->product_id) {
                        $cek3[$t->no_invoice][0] = 1;
                        break;
                    } else {
                        $cek3[$t->no_invoice][0] = 0;
                    }
                }

                foreach ($t->product as $product_detail) {
                    if ($product_itemset3->product_id_b == $product_detail->pivot->product_id) {
                        $cek3[$t->no_invoice][1] = 1;
                        break;
                    } else {
                        $cek3[$t->no_invoice][1] = 0;
                    }
                }
                foreach ($t->product as $product_detail) {
                    if ($product_itemset3->product_id_c == $product_detail->pivot->product_id) {
                        $cek3[$t->no_invoice][2] = 1;
                        break;
                    } else {
                        $cek3[$t->no_invoice][2] = 0;
                    }
                }
            }
            $jum3 = 0;
            foreach ($cek3 as $value) {
                if (($value[0] == 1) && ($value[1] == 1) && ($value[2] == 1)) {
                    $jum3++;
                }
            }
            $support3 = $jum3 / $count_transaction;
            if ($support3 >= $input_support) {
                $status3 = 'L';
            } else {
                $status3 = 'T';
            }
            DB::table('itemset3')->where('id', $product_itemset3->id)->update([
                'jumlah' => $jum3,
                'support' => $support3,
                'status' => $status3
            ]);
        }
        // Proses 3 selesai

        //Proses 4. Membuat association rule dan menghitung nilai confidence
        $this->association_rule($input_confidence);

        // memasukan data itemset yang telah diseleksi kedalam tabel bundle
        $bundles = $this->insert_into_bundle(); // data produk bundel yang baru diproses

        return redirect()->route('bundle.create')->with(['bundles' => $bundles, 'success' => 'Data telah diproses.']);
    }

    public function report_create()
    {
        $title = 'Laporan';
        return view('bundle.report', compact('title'));
    }

    public function report_pdf(Request $request)
    {
        $date['from'] = $request->from;
        $date['to'] = $request->to;
        $bundles = Bundle::whereBetween('date', $date)->orderBy('date', 'asc')->get();

        $pdf = PDF::loadview('bundle.report_pdf', ['bundles' => $bundles, 'date' => $date])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-produk-bundle.pdf');
    }

    public function association_rule($confidence)
    {
        $itemset2 = DB::table('itemset2')->where('status', 'L')->get();
        $itemset3 = DB::table('itemset3')->where('status', 'L')->get();

        if (count($itemset2) > 0) {
            // Membuat aturan asosasi dari kombinasi 2 itemset
            foreach ($itemset2 as $item2) {
                // mengambil data nama produk berdasarkan id itemset yang terpilih
                $pname_a = DB::table('products')
                    ->select('name')
                    ->where('id', $item2->product_id_a)
                    ->first(); //hasilnya berupa objek $pname_a->name
                $pname_b = DB::table('products')
                    ->select('name')
                    ->where('id', $item2->product_id_b)
                    ->first(); //hasilnya berupa objek $pname_a->name

                // mengambil data jumlah kemunculan tiap itemset pada transaksi
                $data_jumlah = DB::table('itemset1')
                    ->select('jumlah')
                    ->whereIn('product_id', [$item2->product_id_a, $item2->product_id_b])
                    ->get();
                $jumlah_a = $data_jumlah[0]->jumlah;
                $jumlah_b = $data_jumlah[1]->jumlah;

                $confidence_a = ($jumlah_a != 0) ? $item2->jumlah / $jumlah_a : 0;
                $confidence_b = ($jumlah_b != 0) ? $item2->jumlah / $jumlah_b : 0;

                $support_x_confidence_a = $item2->support * $confidence_a;
                $support_x_confidence_b = $item2->support * $confidence_b;

                ($confidence_a >= $confidence) ? $status_a = 'L' : $status_a = 'T';
                ($confidence_b >= $confidence) ? $status_b = 'L' : $status_b = 'T';

                // memasukan data aturan asosiasi ke tabel association_rule
                DB::table('association_rule')->insertOrIgnore([
                    [
                        'product_id_a' => $item2->product_id_a,
                        'product_id_b' => $item2->product_id_b,
                        'rule_name' => 'Jika membeli ' . $pname_a->name . ' maka membeli ' . $pname_b->name,
                        'jumlah_a_b' => $item2->jumlah,
                        'jumlah_a' => $jumlah_a,
                        'support' => $item2->support,
                        'confidence' => $confidence_a,
                        'support_x_confidence' => $support_x_confidence_a,
                        'status' => $status_a,
                        'type' => 'Kombinasi 2 item'
                    ],
                    [
                        'product_id_a' => $item2->product_id_b,
                        'product_id_b' => $item2->product_id_a,
                        'rule_name' => 'Jika membeli ' . $pname_b->name . ' maka membeli ' . $pname_a->name,
                        'jumlah_a_b' => $item2->jumlah,
                        'jumlah_a' => $jumlah_b,
                        'support' => $item2->support,
                        'confidence' => $confidence_b,
                        'support_x_confidence' => $support_x_confidence_b,
                        'status' => $status_b,
                        'type' => 'Kombinasi 2 item'
                    ],
                ]);
            }
        }

        if (count($itemset3) > 0) {
            // Membuat aturan asosasi dari kombinasi 3 itemset
            foreach ($itemset3 as $item3) {
                // mengambil data nama produk berdasarkan id itemset yang terpilih
                $pname_a = DB::table('products')
                    ->select('name')
                    ->where('id', $item3->product_id_a)
                    ->first(); //hasilnya berupa objek $pname_a->name
                $pname_b = DB::table('products')
                    ->select('name')
                    ->where('id', $item3->product_id_b)
                    ->first(); //hasilnya berupa objek $pname_a->name
                $pname_c = DB::table('products')
                    ->select('name')
                    ->where('id', $item3->product_id_c)
                    ->first(); //hasilnya berupa objek $pname_a->name

                // mengambil data jumlah kemunculan tiap itemset pada transaksi
                $jumlah_a = DB::table('itemset2')
                    ->select('jumlah')
                    ->where('product_id_a', $item3->product_id_a)
                    ->where('product_id_b', $item3->product_id_b)
                    ->first();
                $jumlah_b = DB::table('itemset2')
                    ->select('jumlah')
                    ->where('product_id_a', $item3->product_id_a)
                    ->where('product_id_b', $item3->product_id_c)
                    ->first();
                $jumlah_c = DB::table('itemset2')
                    ->select('jumlah')
                    ->where('product_id_a', $item3->product_id_b)
                    ->where('product_id_b', $item3->product_id_c)
                    ->first();

                $confidence3_a = ($jumlah_a->jumlah != 0) ? $item3->jumlah / $jumlah_a->jumlah : 0;
                $confidence3_b = ($jumlah_b->jumlah != 0) ? $item3->jumlah / $jumlah_b->jumlah : 0;
                $confidence3_c = ($jumlah_c->jumlah != 0) ? $item3->jumlah / $jumlah_c->jumlah : 0;

                $support3_x_confidence_a = $item3->support * $confidence3_a;
                $support3_x_confidence_b = $item3->support * $confidence3_b;
                $support3_x_confidence_c = $item3->support * $confidence3_c;

                ($confidence3_a >= $confidence) ? $status3_a = 'L' : $status3_a = 'T';
                ($confidence3_b >= $confidence) ? $status3_b = 'L' : $status3_b = 'T';
                ($confidence3_c >= $confidence) ? $status3_c = 'L' : $status3_c = 'T';

                // // memasukan data aturan asosiasi ke tabel association_rule
                DB::table('association_rule')->insertOrIgnore([
                    [
                        'product_id_a' => $item3->product_id_a,
                        'product_id_b' => $item3->product_id_b,
                        'product_id_c' => $item3->product_id_c,
                        'rule_name' => 'Jika membeli ' . $pname_a->name . ' dan ' . $pname_b->name . ' maka membeli ' . $pname_c->name,
                        'jumlah_a_b' => $item3->jumlah,
                        'jumlah_a' => $jumlah_a->jumlah,
                        'support' => $item3->support,
                        'confidence' => $confidence3_a,
                        'support_x_confidence' => $support3_x_confidence_a,
                        'status' => $status3_a,
                        'type' => 'Kombinasi 3 item'
                    ],
                    [
                        'product_id_a' => $item3->product_id_a,
                        'product_id_b' => $item3->product_id_c,
                        'product_id_c' => $item3->product_id_b,
                        'rule_name' => 'Jika membeli ' . $pname_a->name . ' dan ' . $pname_c->name . ' maka membeli ' . $pname_b->name,
                        'jumlah_a_b' => $item3->jumlah,
                        'jumlah_a' => $jumlah_b->jumlah,
                        'support' => $item3->support,
                        'confidence' => $confidence3_b,
                        'support_x_confidence' => $support3_x_confidence_b,
                        'status' => $status3_b,
                        'type' => 'Kombinasi 3 item'
                    ],
                    [
                        'product_id_a' => $item3->product_id_b,
                        'product_id_b' => $item3->product_id_c,
                        'product_id_c' => $item3->product_id_a,
                        'rule_name' => 'Jika membeli ' . $pname_b->name . ' dan ' . $pname_c->name . ' maka membeli ' . $pname_a->name,
                        'jumlah_a_b' => $item3->jumlah,
                        'jumlah_a' => $jumlah_c->jumlah,
                        'support' => $item3->support,
                        'confidence' => $confidence3_c,
                        'support_x_confidence' => $support3_x_confidence_c,
                        'status' => $status3_c,
                        'type' => 'Kombinasi 3 item'
                    ],
                ]);
            }
        }
    }

    public function slow_moving_product()
    {
        $jumlah_terendah = DB::table('itemset1')->min('jumlah');
        return $slow_moving_product = DB::table('itemset1')->where('jumlah', $jumlah_terendah)->get();
    }

    public function fast_moving_product()
    {
        return $final_rule = DB::table('association_rule')->where('status', 'L')->get();
    }

    public function insert_into_bundle()
    {
        $produk_laku = $this->fast_moving_product();
        $produk_tidak_laku = $this->slow_moving_product();
        foreach ($produk_laku as $laku) {
            foreach ($produk_tidak_laku as $tidak_laku) {
                $product_id['a'] = $laku->product_id_a;
                $product_id['b'] = $laku->product_id_b;
                $product_id['c'] = $laku->product_id_c;
                $product_id['d'] = $tidak_laku->product_id;

                $bundle = Bundle::create([
                    'bundle_name' => 'Produk Bundel ' . Carbon::now(),
                    'date' => Carbon::today(),
                    'support' => $laku->support,
                    'confidence' => $laku->confidence,
                    'support_x_confidence' => $laku->support_x_confidence
                ]);
                $bundle->product()->attach($product_id['a'], ['keterangan' => 'Fast Moving']);
                $bundle->product()->attach($product_id['b'], ['keterangan' => 'Fast Moving']);
                if ($product_id['c'] != NULL) {
                    $bundle->product()->attach($product_id['c'], ['keterangan' => 'Fast Moving']);
                }
                $bundle->product()->attach($product_id['d'], ['keterangan' => 'Slow Moving']);
                $latest_bundles[] = $bundle;
            }
        }

        return $latest_bundles;
    }
}
