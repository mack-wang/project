<?php

use Illuminate\Database\Seeder;

class UserWechatInfosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //店铺管理人员填充
        DB::table('user_wechat_infos')->delete();
        DB::table('user_wechat_infos')->insert([
            'user_id'=>1,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechat_infos')->insert([
            'user_id'=>2,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechat_infos')->insert([
            'user_id'=>3,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechat_infos')->insert([
            'user_id'=>4,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechat_infos')->insert([
            'user_id'=>5,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechat_infos')->insert([
            'user_id'=>6,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechat_infos')->insert([
            'user_id'=>7,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechat_infos')->insert([
            'user_id'=>9,
            'province'=>str_random('2'),
            'city'=>str_random('2'),
            'sex'=>rand(0,1),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

    }
}
