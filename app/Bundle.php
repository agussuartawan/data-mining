<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = ['bundle_name', 'date', 'support', 'confidence', 'support_x_confidence'];

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }
}
