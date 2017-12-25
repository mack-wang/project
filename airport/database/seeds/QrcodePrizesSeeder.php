<?php

use Illuminate\Database\Seeder;


class QrcodePrizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qrcode_prizes')->delete();
        DB::table('qrcode_prizes')->insert([
            'id' => 1,
            'name' => '芙蓉王硬闪带1包',
            'count' => 100,
            'cost' => 10,
            'type' => 0,
            'image_path' => '/img/wechat/frw.png',
            'expire' => 7 * 24 * 60 * 60,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('qrcode_prizes')->insert([
            'id' => 2,
            'name' => '小米2000毫安充电宝1个',
            'count' => 10,
            'cost' => 15,
            'type' => 0,
            'image_path' => '/img/wechat/mi.png',
            'expire' => 7 * 24 * 60 * 60,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('qrcode_prizes')->insert([
            'id' => 3,
            'name' => '360随身WIFI 1个',
            'count' => 10,
            'cost' => 10,
            'type' => 0,
            'image_path' => '/img/wechat/wifi.png',
            'expire' => 2 * 60,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('qrcode_prizes')->insert([
            'id' => 4,
            'name' => '云南白药牙膏 1支',
            'count' => 10,
            'cost' => 0,
            'type' => 1,
            'image_path' => '/img/lottery/prize/ynby.png',
            'expire' => 24 * 60 * 60,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('qrcode_prizes')->insert([
            'id' => 5,
            'name' => '10元话费 1份',
            'count' => 10,
            'cost' => 0,
            'type' => 1,
            'kind' => 'charge',
            'price' => 10,
            'image_path' => '/img/lottery/prize/10yuan.png',
            'expire' => 24 * 60 * 60,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('qrcode_prizes')->insert([
            'id' => 6,
            'name' => '康佳电火锅 1台',
            'count' => 10,
            'cost' => 0,
            'type' => 1,
            'image_path' => '/img/lottery/prize/kangjia.png',
            'expire' => 24 * 60 * 60,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('qrcode_prizes')->insert([
            'id' => 7,
            'name' => '3元话费 1份',
            'count' => 10,
            'cost' => 0,
            'type' => 1,
            'kind'=>'charge',
            'price'=>3,
            'image_path' => '/img/lottery/prize/3yuan.png',
            'expire' => 24 * 60 * 60,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
