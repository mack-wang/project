<?php

use Illuminate\Database\Seeder;

class ActivityAttrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_attrs')->delete();
        DB::table('activity_attrs')->insert([
            'activity_id' => 1,
            'title' => '芙蓉王推出首款细支烟——芙蓉王硬闪带细支（菜鸟福利）',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_attrs')->insert([
            'activity_id' => 2,
            'title' => '芙蓉王推出首款细支烟——芙蓉王硬闪带细支（菜鸟福利）',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_attrs')->insert([
            'activity_id' => 3,
            'title' => '拾岁辛勤耕耘，今日欢笑收获——和天下回馈体验测评',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
