<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBundle extends Model
{
    protected $fillable = ['bundle_name', 'date', 'support', 'confidence', 'final_role'];
}
