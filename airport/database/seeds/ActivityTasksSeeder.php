<?php

use Illuminate\Database\Seeder;

class ActivityTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_tasks')->delete();
       
        DB::table('activity_tasks')->insert([
            'activity_id' => 8,
            'type'=>'all',
            'message'=>'机场问卷1',
            'title'=>'关于萧山机场问卷任务',
            'prize_name'=>'滴水',
            'prize_type'=>'water',
            'prize_count'=>200,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_tasks')->insert([
            'activity_id' => 9,
            'type'=>'all',
            'message'=>'机场问卷2',
            'title'=>'关于萧山机场问卷2任务',
            'prize_name'=>'颗种子',
            'prize_type'=>'seed',
            'prize_count'=>1,
            'top'=>1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_tasks')->insert([
            'activity_id' => 10,
            'type'=>'airport',
            'message'=>'机场问卷3',
            'title'=>'关于萧山机场问卷3任务',
            'prize_name'=>'张礼品券',
            'prize_type'=>'ticket',
            'prize_count'=>1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_tasks')->insert([
            'activity_id' => 11,
            'type'=>'airport',
            'message'=>'机场问卷4',
            'title'=>'关于萧山机场问卷4任务',
            'prize_name'=>'颗种子',
            'prize_type'=>'seed',
            'prize_count'=>1,
            'top'=>1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_tasks')->insert([
            'activity_id' => 15,
            'type'=>'airport',
            'message'=>'机场问卷5',
            'title'=>'关于萧山机场问卷4任务',
            'prize_name'=>'颗种子',
            'prize_type'=>'seed',
            'prize_count'=>1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_tasks')->insert([
            'activity_id' => 12,
            'type'=>'airport',
            'message'=>'机场问卷6',
            'title'=>'关于萧山机场问卷4任务',
            'prize_name'=>'颗种子',
            'prize_type'=>'seed',
            'prize_count'=>1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_tasks')->insert([
            'activity_id' => 13,
            'type'=>'shop',
            'message'=>'烟店问卷1',
            'title'=>'关于烟店问卷1任务',
            'prize_name'=>'颗种子',
            'prize_type'=>'seed',
            'prize_count'=>1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_tasks')->insert([
            'activity_id' => 14,
            'type'=>'shop',
            'message'=>'烟店问卷2',
            'title'=>'关于烟店问卷2任务',
            'prize_name'=>'颗种子',
            'prize_type'=>'seed',
            'prize_count'=>1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
