<?php

use Illuminate\Database\Seeder;

class CigaretteLabelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cigarette_labels')->delete();
    }
}
