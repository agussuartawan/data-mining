<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product_bundle_detail()
    {
    	return $this->hasMany('App\BundleProduct');
    }
}
