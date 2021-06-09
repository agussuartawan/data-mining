<?php

use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'name' => 'Agus Suartawan',
                'address' => 'Denpasar',
                'email' => 'agussuartawan@mail.com',
                'phone' => '0812',
            ],
            [
                'name' => 'Stepanhie',
                'address' => 'London',
                'email' => 'step@mail.com',
                'phone' => '0361',
            ],
        ];

        App\Customer::insert($customers);
    }
}
