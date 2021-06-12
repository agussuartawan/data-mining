<?php

use App\Sale;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $data = [
                'customer_id' => 1,
                'date' => Carbon::parse('2021-06-11'),
                'year' => '2021',
                'global_discount' => 0,
                'grand_total' => 500000,
            ];
            $sales = Sale::create($data);
            $sales->product()->attach(1, [
                'qty' => 1,
                'price' => 250000,
                'discount' => 0,
                'subtotal' => 250000,
            ]);
            $sales->product()->attach(2, [
                'qty' => 1,
                'price' => 250000,
                'discount' => 0,
                'subtotal' => 250000,
            ]);
        });
    }
}
