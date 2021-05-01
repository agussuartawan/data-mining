<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductBundle extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product_nama($product)
    {
    	$product_detail = DB::table('product_bundles')
    				->join('products', 'product_bundles.product', '=', 'products.id')
    				->select('products.nama')
    				->where('products.id', '=', $product)
    				->first();

    	return $product_detail->nama;
    }
    
}
