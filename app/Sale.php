<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Sale extends Model
{
    use AutoNumberTrait;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'price', 'discount', 'subtotal');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getAutoNumberOptions()
    {
        return [
            'no_invoice' => [
                'format' => function () {
                    return 'INV/' . date('Y-m-d') . '/?';
                },
                'length' => 5,
            ]
        ];
    }
}
