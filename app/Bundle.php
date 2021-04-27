<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function bundle_product()
    {
    	return $this->hasMany('App\BundleProduct');
    }

    public function product()
    {
    	return $this->hasMany('App\Product');
    }
    
}
