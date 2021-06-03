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
                'name'           => 'Paket',
            ],
            [
                'name'           => 'Spirit',
            ],
            [
                'name'           => 'Wine',
            ],
            [
                'name'           => 'Campagne',
            ],
            [
                'name'           => 'Beer',
            ]
        ];

        App\Group::insert($groups);
    }
}
