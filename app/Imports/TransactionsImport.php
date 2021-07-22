<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Transaction;
use App\Product;
use App\FileList;
use Carbon\Carbon;

class TransactionsImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
    	$fileName = "Transaksi-" . Carbon::now();
    	$fileList = FileList::create([
    		'file_name' => $fileName,
    	]);

        foreach ($collection as $row) 
        {
        	if (!$row[0] == NULL) {
        		if ($row[6] == NULL) {
        			$grand_total = 0;
        		} else {
        			$grand_total = $row[6];
        		}
            	$transaction = Transaction::create([
	            	'file_list_id' => $fileList->id,
	                'no_invoice' => $row[0],
	                'date' => Carbon::parse($row[1])->format('Y-m-d'),
	                'grand_total' => $grand_total,
	            ]);
            }

            if (!$row[2] == NULL) {
            	if (!$row[6] == NULL) {
            		$transaction->update(['grand_total' => $row[6]]);
            	}

            	$product = Product::updateOrCreate([
            		'name' => $row[2],
            	]);

            	$transaction->product()->attach($product->id, [
	                'qty' => $row[3],
	                'price' => $row[4],
	                'subtotal' => $row[5],
	            ]);
            }
        }
    }
}
