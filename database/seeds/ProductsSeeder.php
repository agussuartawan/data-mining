<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\ProductBundle;

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
                'group_id'          => '2',
                'tipe'  => 'single',
                'harga_beli'       => '300000',
                'harga_jual'       => '500000'
            ],
            [
            	'kode'           => 'AB001',
                'nama'          => 'Absolut Blue',
                'group_id'          => '2',
                'tipe'  => 'single',
                'harga_beli'       => '200000',
                'harga_jual'       => '400000'
            ],
            [
                'kode'           => 'CM001',
                'nama'          => 'Captain Morgan Gold',
                'group_id'          => '2',
                'tipe'  => 'single',
                'harga_beli'       => '150000',
                'harga_jual'       => '250000'
            ],
            [
                'kode'           => 'CM002',
                'nama'          => 'Captain Morgan White',
                'group_id'          => '2',
                'tipe'  => 'single',
                'harga_beli'       => '150000',
                'harga_jual'       => '250000'
            ],
            [
                'kode'           => 'CM003',
                'nama'          => 'Captain Morgan Orange',
                'group_id'          => '2',
                'tipe'  => 'single',
                'harga_beli'       => '150000',
                'harga_jual'       => '250000'
            ]
        ];

        Product::insert($products);
    }
}
