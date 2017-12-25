<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //普通用户填充
        DB::table('users')->delete();
        DB::table('users')->insert([
            'id'=>1,
            'shop_id'=>1,
            'openid'=>str_random(32),
            'password'=>Hash::make("secret"),
            'register'=>1,
            'remember_token' => str_random(10),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>2,
            'shop_id'=>2,
            'openid'=>str_random(32),
            'password'=>Hash::make("secret"),
            'register'=>1,
            'remember_token' => str_random(10),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>3,
            'shop_id'=>3,
            'openid'=>str_random(32),
            'password'=>Hash::make("secret"),
            'register'=>1,
            'remember_token' => str_random(10),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>4,
            'shop_id'=>4,
            'openid'=>str_random(32),
            'password'=>Hash::make("secret"),
            'register'=>1,
            'remember_token' => str_random(10),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>5,
            'shop_id'=>5,
            'openid'=>str_random(32),
            'password'=>Hash::make("secret"),
            'register'=>1,
            'remember_token' => str_random(10),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>6,
            'shop_id'=>6,
            'openid'=>str_random(32),
            'password'=>Hash::make("secret"),
            'register'=>1,
            'remember_token' => str_random(10),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>7,
            'shop_id'=>5,
            'openid'=>str_random(32),
            'register'=>3,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>8,
            'openid'=>str_random(32),
            'register'=>2,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id'=>9,
            'openid'=>str_random(32),
            'register'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
