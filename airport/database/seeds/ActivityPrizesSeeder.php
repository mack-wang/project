<?php

use Illuminate\Database\Seeder;

class ActivityPrizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_prizes')->delete();
        DB::table('activity_prizes')->insert([
            'activity_id' => 1,
            'cigarette_id' => 2477,
            'name' => '芙蓉王（硬闪带75mm）',
            'count' => 10,
            'price' => 40,
            'description'=> '特点：好用,特色：好看',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_prizes')->insert([
            'activity_id' => 2,
            'cigarette_id' => 2477,
            'name' => '芙蓉王（硬闪带75mm）',
            'count' => 10,
            'price' => 40,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_prizes')->insert([
            'activity_id' => 3,
            'cigarette_id' => 36,
            'name' => '白沙（和天下）',
            'count' => 10,
            'price' => 100,
            'description'=> '特点：好用,特色：好看',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_prizes')->insert([
            'activity_id' => 4,
            'name' => '充电宝',
            'count' => 10,
            'price' => 80,
            'description'=> '特点：好用,特色：好看',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
