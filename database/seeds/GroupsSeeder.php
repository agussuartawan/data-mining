<?php

use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'nama'           => 'Paket',
            ],
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
                'nama'           => 'Beer',
            ]
        ];

        App\Group::insert($groups);
    }
}
