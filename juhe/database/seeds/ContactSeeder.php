<?php

use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->delete();
        DB::table('contacts')->insert([
            'id' => 1,
            'image' => '/img/wechat/recommend.png',
            'phone' => '400-080-220',
            'time' => '每周一至每周五 9:00 ~ 18:00',
            'content' => '钜合团购官方订购热线',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
