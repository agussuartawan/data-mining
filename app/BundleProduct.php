<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BundleProduct extends Model
{
    public $table = "bundle_product";

    protected $fillable = ['bundle_id', 'product_id', 'qty'];

    public function bundle()
    {
    	return $this->hasMany('App\Bundle');
    }
}
