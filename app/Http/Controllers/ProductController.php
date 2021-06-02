<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Group;
use App\ProductBundle;
use DB;
use App\Http\Requests\StoreProductRequest;

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $title = "Detail Produk " .  $product->nama;

        return view('product.show', compact('product', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Product $product)
    {
        $title = "Produk";
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
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return redirect()->route('product.index', 0)->with('success', 'Produk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->tipe == "Bundle") {
            DB::transaction(function () use ($product) {
                ProductBundle::where('product_id', '=', $product->id)->delete();

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
}
