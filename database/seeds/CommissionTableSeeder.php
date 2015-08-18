<?php

use Illuminate\Database\Seeder;

class CommissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commissions')->truncate();

        $data = [
            
        ];

        $amount = 1000;

        $percentage = 55;

        for($i=0;$i<20;$i++) {

            $data[] = [

                'amount'        => $amount + ($i * 200),
                'percentage'    => $percentage + $i
            ];

        }

        DB::table('commissions')->insert($data);
    }
}
