<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['nama'];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }
}
