<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        $data = [
            [
                "name" => 'admin'
            ],
            [
                "name" => 'early_bird'
            ]
        ];

        DB::table('roles')->insert($data);

    }
}
