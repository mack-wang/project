<?php

use Illuminate\Database\Seeder;

class ActivityQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_questions')->delete();
        DB::table('activity_questions')->insert([
            'activity_id' => 1,
            'question_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
