<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->truncate();

        $data = [
            [
                "name" => 'Minimalist'
            ],
            [
                "name" => 'Multipurpose'
            ],
            [
                "name" => 'Angular JS'
            ],
            [
                "name" => 'Bootstrap'
            ]
        ];

        DB::table('tags')->insert($data);
    }
}
