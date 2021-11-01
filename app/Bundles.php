<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundles extends Model
{
    protected $fillable = ['bundle_name', 'date', 'support', 'confidence', 'final_role'];
}
