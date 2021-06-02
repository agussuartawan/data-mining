<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductBundle;
use App\Http\Requests\StoreProductBundleRequest;
use DB;

class ProductBundleController extends Controller
{
    public function create()
    {
        $title = "Produk Bundle";
        $allProducts = Product::all();
        $count = count($allProducts);
        return view('product.create-bundle', compact('title', 'allProducts', 'count'));
    }

    public function store(StoreProductBundleRequest $request)
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

    public function edit(Product $product)
    {
        $title = "Produk";
        return view('product.edit-bundle', compact('product', 'title'));
    }

    public function update(Request $request, Product $product)
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

        DB::transaction(function () use ($request, $product, $data, $new_price) {
            #Update product table
            $product_update = [
                "group_id" => 1,
                "kode" => $data["kode"],
                "nama" => $data["nama"],
                "tipe" => "Bundle",
                "stok" => $data["stok"],
                "harga_jual" => $new_price
            ];
            $product->update($product_update);

            #Update Product Bundle table
            $product_id = $request->product_id;
            $qty = $request->qty;
            $subprices = $request->price;
            for ($i = 0; $i < count($product_id); $i++) {
                if ($product_id[$i] != 0 && $product_id[$i] != null) {
                    $subprice = str_replace('.', '', $subprices[$i]);
                    $products[] = array(
                        'product_id' => $product->id,
                        'product' => $product_id[$i],
                        'qty' => $qty[$i],
                        'price' => $subprice
                    );
                }
            }
            ProductBundle::where('product_id', $product->id)->delete();
            ProductBundle::insert($products);
        });

        return response()->json('Data produk bundel berhasil diubah');
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
}
