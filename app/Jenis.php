<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    public $table = "jenis";
    protected $fillable = ['nama'];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }
}
