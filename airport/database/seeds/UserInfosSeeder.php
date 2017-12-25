<?php

use Illuminate\Database\Seeder;

class UserInfosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_infos')->delete();
        DB::table('user_infos')->insert([
            'id'=>1,
            'user_id'=>1,
            'phone'=>'15657130092',
            'exp'=>rand(100,999),
            'level'=>rand(1,5),
            'ticket'=>rand(0,20),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_infos')->insert([
            'id'=>2,
            'user_id'=>2,
            'phone'=>'1575713'.rand(1000,5999),
            'exp'=>rand(100,999),
            'level'=>rand(1,5),
            'ticket'=>rand(0,20),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_infos')->insert([
            'id'=>3,
            'user_id'=>3,
            'phone'=>'1575713'.rand(1000,5999),
            'exp'=>rand(100,999),
            'level'=>rand(1,5),
            'ticket'=>rand(0,20),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_infos')->insert([
            'id'=>4,
            'user_id'=>4,
            'phone'=>'1575713'.rand(1000,5999),
            'exp'=>rand(100,999),
            'level'=>rand(1,5),
            'ticket'=>rand(0,20),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_infos')->insert([
            'id'=>5,
            'user_id'=>5,
            'phone'=>'1575713'.rand(1000,5999),
            'exp'=>rand(100,999),
            'level'=>rand(1,5),
            'ticket'=>rand(0,20),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_infos')->insert([
            'id'=>6,
            'user_id'=>6,
            'phone'=>'1575713'.rand(1000,5999),
            'exp'=>rand(100,999),
            'level'=>rand(1,5),
            'ticket'=>rand(0,20),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_infos')->insert([
            'id'=>7,
            'user_id'=>9,
            'phone'=>'1575713'.rand(1000,5999),
            'exp'=>rand(100,999),
            'level'=>rand(1,5),
            'ticket'=>rand(0,20),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
