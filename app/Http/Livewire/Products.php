<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Product;
use DB;

class Products extends Component
{

    public $product_id;
    public $qty;
    public $price;
    public $allProducts;
    public $formType = 0;
    public $btnTitle = "Tambah";
    public $idProduct = 0;

    public function mount()
    {
        $this->allProducts = Product::all();
    }

    public function render()
    {
        $this->product_temp = DB::table('product_temp')->get();
        return view('livewire.products', [
            'product_temp' => DB::table('product_temp')
                            ->join('products', 'product_temp.product_id','=','products.id')
                            ->select('product_temp.*','products.nama')
                            ->get()
        ]);
    }

    public function store()
    {
        DB::table('product_temp')->insert([
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'price' => $this->price
        ]);

        $this->resetInput();
    }

    public function destroy($id)
    {
        DB::table('product_temp')->where('id', $id)->delete();
    }


    public function update()
    {
        DB::table('product_temp')
        ->where('id', $idProduct)
        ->update([
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'price' => $this->price
        ]);
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->product_id = null;
        $this->qty = null;
        $this->price = null;
        $this->btnTitle = "Tambah";
        $this->formType = 0;
    }

    public function getDataProduct($id)
    {
        $product = DB::table('product_temp')
                  ->where('id', $id)
                  ->orderBy('id','desc')
                  ->first();

        $this->product_id = $product->product_id;
        $this->qty = $product->qty;
        $this->price = $product->price;
        $this->formType = 1;
        $this->btnTitle = "Ubah";
        $this->idProduct = $product->id;
    }
}
