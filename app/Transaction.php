<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['file_list_id', 'no_invoice', 'date', 'grand_total'];

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'price', 'subtotal');
    }

    public function filelist()
    {
    	return $this->belongsTo(FileList::class);
    }
}
