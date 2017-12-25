<?php

use Illuminate\Database\Seeder;

class ShopHeadimgsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //店铺填充
        DB::table('shop_headimgs')->delete();
        DB::table('shop_headimgs')->insert([
            'shop_id' => 5,
            'image_path' => '/storage/headimg/airport.png',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
