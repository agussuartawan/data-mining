<?php

use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = [
            [
                'nama'           => 'Spirit',
            ],
            [
            	'nama'           => 'Wine',
            ],
            [
                'nama'           => 'Campagne',
            ],
            [
                'nama'           => 'Produk Bundel',
            ]
        ];

        App\Jenis::insert($jenis);
    }
}
