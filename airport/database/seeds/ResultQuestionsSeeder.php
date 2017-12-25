<?php

use Illuminate\Database\Seeder;

class ResultQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('result_questions')->delete();
    }
}
