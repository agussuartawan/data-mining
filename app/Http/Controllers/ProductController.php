<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Group;
use App\ProductBundle;
use DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreProductBundleRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title = "Produk";

        if ($id == 0) {
            $products = Product::orderBy('id', 'desc')->get();
        } else {
            $products = Product::where('group_id', '=', $id)->orderBy('id', 'desc')->get();
        }

        $group = Group::get();
        $selected = $id;

        return view('product.index', compact('title', 'products', 'group', 'selected'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Produk";
        $group = Group::where('id', '!=', 1)->get();
        return view('product.create', compact('title', 'group'));
    }

    public function create_bundle()
    {
        $title = "Produk Bundle";
        $allProducts = Product::all();
        $count = count($allProducts);
        return view('product.create-bundle', compact('title', 'allProducts', 'count'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        Product::create($data);

        if ($request->redirect_to == 'index') {
            return redirect()->route('product.index', 0)->with('success', 'Produk berhasil ditambahkan');
        } else {
            return redirect()->route('product.create')->with('success', 'Produk berhasil ditambahkan');
        }
    }

    public function store_bundle(StoreProductBundleRequest $request)
    {
        $new_price = 0;
        $harga_jual = str_replace('.', '', $request->harga_jual);
        if ($harga_jual == 0) {
            $prices = $request->price;
            foreach ($prices as $price) {
                $new_price = $new_price + str_replace('.', '', $price);
            }
        } else {
            $new_price = $harga_jual;
        }

        DB::transaction(function () use ($request, $new_price) {
            # insert into table product
            if ($request->stok == null) {
                $stok = 1;
            } else {
                $stok = $request->stok;
            }
            $product = array(
                'group_id' => 1,
                'kode' => $request->kode,
                'nama' => $request->nama,
                'tipe' => "Bundle",
                'stok' => $stok,
                'harga_jual' => $new_price

            );
            $last_data = Product::create($product);

            # insert into table product bundle
            $product_id = $request->product_id;
            $qty = $request->qty;
            $subprices = $request->price;
            for ($i = 0; $i < count($product_id); $i++) {
                if ($product_id[$i] != 0 && $product_id[$i] != null) {
                    $subprice = str_replace('.', '', $subprices[$i]);
                    $products[] = array(
                        'product_id' => $last_data->id,
                        'product' => $product_id[$i],
                        'qty' => $qty[$i],
                        'price' => $subprice
                    );
                }
            }
            ProductBundle::insert($products);
        });
        return response()->json('Data produk bundel berhasil ditambahkan');
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
    public function edit_bundle($id)
    {
        $title = "Produk";
        $product = Product::find($id);
        // dd($product->product_bundle);

        return view('product.edit-bundle', compact('product', 'title'));
    }

    public function edit($id)
    {
        $title = "Produk";
        $product = Product::find($id);
        $jenis = Group::get();

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

        return redirect()->route('product.index', 0)->with('success', 'Produk berhasil diubah');
    }

    public function update_bundle(Request $request, $id)
    {
        $data = $request->all();
        $new_price = 0;
        $harga_jual = str_replace('.', '', $request->harga_jual);
        if ($harga_jual == 0) {
            $prices = $request->price;
            foreach ($prices as $price) {
                $new_price = $new_price + str_replace('.', '', $price);
            }
        } else {
            $new_price = $harga_jual;
        }

        DB::transaction(function () use ($request, $id, $data, $new_price) {
            #Update product table
            $product_update = [
                "group_id" => 1,
                "kode" => $data["kode"],
                "nama" => $data["nama"],
                "tipe" => "Bundle",
                "stok" => $data["stok"],
                "harga_jual" => $new_price
            ];
            Product::find($id)->update($product_update);

            #Update Product Bundle table
            $product_id = $request->product_id;
            $qty = $request->qty;
            $subprices = $request->price;
            for ($i = 0; $i < count($product_id); $i++) {
                if ($product_id[$i] != 0 && $product_id[$i] != null) {
                    $subprice = str_replace('.', '', $subprices[$i]);
                    $products[] = array(
                        'product_id' => $id,
                        'product' => $product_id[$i],
                        'qty' => $qty[$i],
                        'price' => $subprice
                    );
                }
            }
            ProductBundle::where('product_id', $id)->delete();
            ProductBundle::insert($products);
        });

        return response()->json('Data produk bundel berhasil diubah');
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
        $product = Product::find($id);

        if ($product->tipe == "Bundle") {
            DB::transaction(function () use ($product, $id) {
                ProductBundle::where('product_id', '=', $id)->delete();

                $product->delete();
            });
        } else {
            $product->delete();
        }
        return redirect()->route('product.index', 0)->with('success', 'Produk berhasil dihapus');
    }

    public function find(Request $request)
    {
        $search = $request->search;
        $data = Product::orderBy('nama', 'asc')
            ->select('id', 'nama', 'harga_jual')
            ->where('nama', 'LIKE', "%{$search}%")
            ->where('tipe', '=', 'Single')
            ->get();

        $results = [];
        foreach ($data as $d) {
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

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $price = str_replace('.', '', $prices[$i]);
                $subtotal[$i] = $qty[$i] * $price;
                $grand_total = $grand_total + $subtotal[$i];
            }
        }
        return currency($grand_total);
    }
}
