<?php

use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activities')->delete();
        DB::table('activities')->insert([
            'id' => 1,
            'cigarette_id' => 2477,
            'article_id' =>1,
            'type' => 'apply',
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 week")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 2,
            'cigarette_id' => 2477,
            'article_id' =>2,
            'type' => 'apply',
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 minute")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 3,
            'type' => 'kill',
            'cigarette_id' => 36,
            'article_id' =>3,
            'elect'=>2,
            'start_at' => date("Y-m-d H:i:s", strtotime("+1 minute")),
            'end_at' => date("Y-m-d H:i:s", strtotime("+5 minutes")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 4,
            'type' => 'airport',
            'article_id' =>5,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 5,
            'type' => 'airport',
            'article_id' =>5,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 6,
            'type' => 'shop',
            'article_id' =>6,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 7,
            'type' => 'shop',
            'article_id' =>7,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 8,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 9,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 10,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 11,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 12,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 13,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 14,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activities')->insert([
            'id' => 15,
            'type' => 'task',
            'article_id' =>1,
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 days")),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
