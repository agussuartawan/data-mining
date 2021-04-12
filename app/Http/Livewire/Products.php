<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Product;

class Products extends Component
{

    public $orderProducts = [];
    public $allProducts = [];

    public function mount()
    {
        $this->allProducts = Product::all();
        $this->orderProducts = [
            ['product_id' => '', 'qty' => 1, 'price' => 0]
        ];
    }

    public function addProduct()
    {
        $this->orderProducts[] = ['product_id' => '', 'qty' => 1, 'price' => 0];
    }

    public function removeProduct($index)
    {
        unset($this->orderProducts[$index]);
        array_values($this->orderProducts);
    }

    public function render()
    {
        return view('livewire.products');
    }
}
