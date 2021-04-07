<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function jenis()
    {
    	return $this->belongsTo('App\Jenis');
    }
}
