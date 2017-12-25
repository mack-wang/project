<?php

use Illuminate\Database\Seeder;

class CigarettePricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cigarette_prices')->delete();
        DB::table('cigarette_prices')->insert([
            'cigarette_id' => 1375,
            'price' => 40,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('cigarette_prices')->insert([
            'cigarette_id' => 1364,
            'price' => 100,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
