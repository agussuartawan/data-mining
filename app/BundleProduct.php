<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BundleProduct extends Model
{
    public $table = "bundle_product";

    protected $fillable = ['product_bundle_id', 'product_id'];

    public function bundle()
    {
    	return $this->hasMany('App\Bundle');
    }
}
