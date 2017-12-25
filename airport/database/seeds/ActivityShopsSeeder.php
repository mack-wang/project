<?php

use Illuminate\Database\Seeder;

class ActivityShopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_shops')->delete();
        DB::table('activity_shops')->insert([
            'activity_id' => 4,
            'image_path' => '/img/wechat/airport1.png',
            'link' => '/wechat/link/takephoto',
            'button' => '我要参与',
            'message' => '机场寻宝活动',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_shops')->insert([
            'activity_id' => 5,
            'image_path' => '/img/wechat/airport2.png',
            'avatar_path' => '/img/car.png',
            'button' => '立即参与',
            'message' => '机场吸烟室自拍活动',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_shops')->insert([
            'activity_id' => 6,
            'image_path' => '/img/wechat/hb.png',
            'button' => '我要参与',
            'message' => '店铺红包活动',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('activity_shops')->insert([
            'activity_id' => 7,
            'image_path' => '/img/wechat/dt.png',
            'avatar_path' => '/img/car.png',
            'button' => '立即参与',
            'message' => '店铺限时答题活动',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
