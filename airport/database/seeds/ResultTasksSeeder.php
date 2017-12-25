<?php

use Illuminate\Database\Seeder;

class ResultTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('result_tasks')->delete();

    }
}
