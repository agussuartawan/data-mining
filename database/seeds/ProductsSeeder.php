<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'kode'           => 'JD001',
                'nama'          => 'Jack Daniel',
                'jenis_id'          => '1',
                'harga_beli'       => '300000',
                'harga_jual'       => '500000'
            ],
            [
            	'kode'           => 'AB001',
                'nama'          => 'Absolut Blue',
                'jenis_id'          => '1',
                'harga_beli'       => '200000',
                'harga_jual'       => '400000'
            ],
            [
                'kode'           => 'CM001',
                'nama'          => 'Captain Morgan',
                'jenis_id'          => '1',
                'harga_beli'       => '150000',
                'harga_jual'       => '250000'
            ]
        ];

        Product::insert($products);
    }
}
