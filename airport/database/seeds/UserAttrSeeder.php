<?php

use Illuminate\Database\Seeder;

class UserAttrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //普通用户属性填充
        DB::table('user_attrs')->delete();
        DB::table('user_attrs')->insert([
            'user_id'=>1,
            'real_name'=>'王乐城',
            'id_card'=>'33032919930305xxxx',
            'age'=>24,
            'job'=>str_random(4),
            'income'=>rand(3,10).'000',
            'education'=>str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_attrs')->insert([
            'user_id'=>2,
            'real_name'=>'张'.str_random(4),
            'id_card'=>'44032919930306'.str_random(4),
            'age'=>rand(18,88),
            'job'=>str_random(4),
            'income'=>rand(3,10).'000',
            'education'=>str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_attrs')->insert([
            'user_id'=>3,
            'real_name'=>'张'.str_random(4),
            'id_card'=>'44032919930306'.str_random(4),
            'age'=>rand(18,88),
            'job'=>str_random(4),
            'income'=>rand(3,10).'000',
            'education'=>str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_attrs')->insert([
            'user_id'=>4,
            'real_name'=>'张'.str_random(4),
            'id_card'=>'44032919930306'.str_random(4),
            'age'=>rand(18,88),
            'job'=>str_random(4),
            'income'=>rand(3,10).'000',
            'education'=>str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_attrs')->insert([
            'user_id'=>5,
            'real_name'=>'张'.str_random(4),
            'id_card'=>'44032919930306'.str_random(4),
            'age'=>rand(18,88),
            'job'=>str_random(4),
            'income'=>rand(3,10).'000',
            'education'=>str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_attrs')->insert([
            'user_id'=>6,
            'real_name'=>'张'.str_random(4),
            'id_card'=>'44032919930306'.str_random(4),
            'age'=>rand(18,88),
            'job'=>str_random(4),
            'income'=>rand(3,10).'000',
            'education'=>str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_attrs')->insert([
            'user_id'=>9,
            'real_name'=>'张'.str_random(4),
            'id_card'=>'44032919930306'.str_random(4),
            'age'=>rand(18,88),
            'job'=>str_random(4),
            'income'=>rand(3,10).'000',
            'education'=>str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
