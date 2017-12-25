<?php

use Illuminate\Database\Seeder;

class UserWechatsSeeder extends Seeder
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
        DB::table('user_wechats')->delete();
        DB::table('user_wechats')->insert([
            'user_id'=>1,
            'nickname'=>str_random('6'),
            'headimgurl'=>'/img/tom.png',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechats')->insert([
            'user_id'=>2,
            'nickname'=>str_random('6'),
            'headimgurl'=>'img/bob.jpg',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechats')->insert([
            'user_id'=>3,
            'nickname'=>str_random('6'),
            'headimgurl'=>'/img/cindy.png',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechats')->insert([
            'user_id'=>4,
            'nickname'=>str_random('6'),
            'headimgurl'=>'/img/mack.png',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechats')->insert([
            'user_id'=>5,
            'nickname'=>str_random('6'),
            'headimgurl'=>'/img/ming.png',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechats')->insert([
            'user_id'=>6,
            'nickname'=>str_random('6'),
            'headimgurl'=>'/img/steve.jpg',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechats')->insert([
            'user_id'=>7,
            'nickname'=>str_random('6'),
            'headimgurl'=>'/img/steve.jpg',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_wechats')->insert([
            'user_id'=>9,
            'nickname'=>str_random('6'),
            'headimgurl'=>'/img/ming.png',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
