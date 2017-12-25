<?php

use Illuminate\Database\Seeder;

class ShopAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //店铺管理员地址填充
        DB::table('shop_addresses')->delete();
        DB::table('shop_addresses')->insert([
            'shop_id'=>1,
            'manager_id'=>1,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_addresses')->insert([
            'shop_id'=>1,
            'manager_id'=>2,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号2',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_addresses')->insert([
            'shop_id'=>2,
            'manager_id'=>3,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号3',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_addresses')->insert([
            'shop_id'=>4,
            'manager_id'=>4,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号3'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_addresses')->insert([
            'shop_id'=>5,
            'manager_id'=>5,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号3'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_addresses')->insert([
            'shop_id'=>6,
            'manager_id'=>6,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号3'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_addresses')->insert([
            'shop_id'=>7,
            'manager_id'=>7,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号3'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
