<?php

use Illuminate\Database\Seeder;

class ShopAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //店铺地区填充
        DB::table('shop_areas')->delete();
        DB::table('shop_areas')->insert([
            'id'=>1,
            'area'=>'杭州',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_areas')->insert([
            'id'=>2,
            'area'=>'嘉兴',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_areas')->insert([
            'id'=>3,
            'area'=>'湖州',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_areas')->insert([
            'id'=>4,
            'area'=>'宁波',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_areas')->insert([
            'id'=>5,
            'area'=>'温州',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_areas')->insert([
            'id'=>6,
            'area'=>'金华',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_areas')->insert([
            'id'=>7,
            'area'=>'丽水',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
