<?php

use Illuminate\Database\Seeder;

class ShopAttrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //店铺填充
        DB::table('shop_attrs')->delete();
        DB::table('shop_attrs')->insert([
            'id'=>1,
            'shop_id'=>1,
            'type'=>'A',
            'level'=>'4',
            'scores'=>300,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_attrs')->insert([
            'id'=>2,
            'shop_id'=>2,
            'type'=>'B',
            'level'=>'2',
            'scores'=>500,
            'black'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_attrs')->insert([
            'id'=>3,
            'shop_id'=>3,
            'type'=>'A',
            'level'=>'5',
            'scores'=>500,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_attrs')->insert([
            'id'=>4,
            'shop_id'=>4,
            'type'=>'B',
            'level'=>'2',
            'scores'=>600,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_attrs')->insert([
            'id'=>5,
            'shop_id'=>5,
            'type'=>'C',
            'level'=>'2',
            'scores'=>900,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_attrs')->insert([
            'id'=>6,
            'shop_id'=>6,
            'type'=>'C',
            'level'=>'3',
            'scores'=>100,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_attrs')->insert([
            'id'=>7,
            'shop_id'=>7,
            'type'=>'A',
            'level'=>'1',
            'scores'=>200,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
