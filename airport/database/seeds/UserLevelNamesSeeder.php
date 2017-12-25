<?php

use Illuminate\Database\Seeder;

class UserLevelNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_level_names')->delete();
        DB::table('user_level_names')->insert([
            'id'=>1,
            'name'=>'菜鸟',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_level_names')->insert([
            'id'=>2,
            'name'=>'新手',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_level_names')->insert([
            'id'=>3,
            'name'=>'高手',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_level_names')->insert([
            'id'=>4,
            'name'=>'专家',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_level_names')->insert([
            'id'=>5,
            'name'=>'大师',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_level_names')->insert([
            'id'=>6,
            'name'=>'顶级',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

    }
}
