<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Jenis;
use App\Bundle;
use App\BundleProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title = "Data Produk";

        if ($id == 0) {
            $products = Product::orderBy('id', 'desc')->get();
        } else {
            $products = Product::where('jenis_id','=', $id)->orderBy('id','desc')->get();
        }

        $jenis = Jenis::get();
        $selected = $id;

        return view('product.index', compact('title', 'products', 'jenis', 'selected'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Produk";
        $jenis = Jenis::get();
        return view('product.create', compact('title','jenis'));
    }

    public function create_bundle()
    {
        $title = "Tambah Produk Bundle";
        $allProducts = Product::all();
        $count = count($allProducts);
        return view('product.create-bundle', compact('title','allProducts','count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($request->redirect_to);
        Product::create($data);

        if ($request->redirect_to == 'index') {
            return redirect()->route('product.index',0)->with('success', 'Produk berhasil ditambahkan');
        } else {
            return redirect()->route('product.create')->with('success', 'Produk berhasil ditambahkan');   
        }
    }

    public function store_bundle(Request $request)
    {
        $new_price = 0;
        $harga_jual = str_replace('.', '', $request->harga_jual);
        if($harga_jual == 0) {
            $prices = $request->price;
            foreach ($prices as $price) {
                $new_price = $new_price + str_replace('.', '', $price);
            }
        } else {
            $new_price = $harga_jual;
        }

        # insert into table bundles
        $product = array(
            'kode' => $request->kode,
            'nama' => $request->nama,
            'harga_jual' => $new_price
        );
        $last_data = Bundle::create($product);

        # insert into table bundle_product
        $product_id = $request->product_id;
        $qty = $request->qty;
        for ($i = 0; $i < count($product_id); $i++) {
            if($product_id[$i] != 0){
                $products[] = array(
                    'bundle_id' => $last_data->id,
                    'product_id' => $product_id[$i], 
                    'qty' => $qty[$i]
                );
            }
        }
        BundleProduct::insert($products);

        if ($request->redirect_to == 'index') {
            return redirect()->route('product.index',0)->with('success', 'Produk bundel berhasil ditambahkan');
        } else {
            return redirect()->route('product.create.bundle')->with('success', 'Produk bundel berhasil ditambahkan');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
    	$title = "Detail Produk " .  $product->nama;

    	return view('product.show', compact('product', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$title = "Edit Produk";
    	$product = Product::find($id);
    	$jenis = Jenis::get();

        return view('product.edit', compact('product', 'jenis', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        Product::find($id)->update($data);

        return redirect()->route('product.index',0)->with('success', 'Produk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($product->nama);
        Product::find($id)->delete();
        return redirect()->route('product.index',0)->with('success', 'Produk berhasil dihapus');
    }

    public function find(Request $request)
    {
        $search = $request->search;
        $data = Product::orderBy('nama', 'asc')
                            ->select('id', 'nama', 'harga_jual')
                            ->where('nama', 'LIKE', "%{$search}%")
                            ->get();

        $results = [];
        foreach($data as $d){
            $results[] = array(
                'id' => $d->id,
                'text' => $d->nama
            );
        }
        return response()->json($results);
    }

    public function find_price($id)
    {
        if ($id > 0) {
            $data = Product::select('harga_jual')->where('id', '=', $id)->get();
            $price = $data[0]['harga_jual'];
        } else {
            $price = 0;
        }
        
        return $price;
    }

    public function sum()
    {
        $grand_total = 0;
        $subtotal = [];
        $qty = $_POST['qty'];
        $prices = $_POST['price'];
        $count = count($qty);

        if($count > 0){
            for ($i=0; $i < $count; $i++) { 
                $price = str_replace('.', '', $prices[$i]);
                $subtotal[$i] = $qty[$i] * $price;
                $grand_total = $grand_total + $subtotal[$i];
            }
        }
        return currency($grand_total);
    }
}
