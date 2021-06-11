<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'price', 'discount', 'subtotal');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
