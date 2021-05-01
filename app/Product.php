<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function group()
    {
    	return $this->belongsTo('App\Group');
    }

    public function product_bundle()
    {
        return $this->hasMany('App\ProductBundle');
    }
}
