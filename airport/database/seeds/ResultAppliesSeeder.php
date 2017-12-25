<?php

use Illuminate\Database\Seeder;

class ResultAppliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('result_applies')->delete();

    }
}
