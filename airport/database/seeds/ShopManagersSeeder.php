<?php

use Illuminate\Database\Seeder;

class ShopManagersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //店铺管理人员填充
        DB::table('shop_managers')->delete();
        DB::table('shop_managers')->insert([
            'id'=>1,
            'shop_id'=>1,
            'user_id'=>1,
            'manager_name'=>'王乐城',
            'phone'=>"15757130092",
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_managers')->insert([
            'id'=>2,
            'shop_id'=>1,
            'user_id'=>2,
            'manager_name'=>'张三',
            'phone'=>"15757130093",
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_managers')->insert([
            'id'=>3,
            'shop_id'=>3,
            'user_id'=>3,
            'manager_name'=>'李四',
            'phone'=>"15757130094",
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_managers')->insert([
            'id'=>4,
            'shop_id'=>3,
            'user_id'=>4,
            'manager_name'=>'王五',
            'phone'=>"15757130095",
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_managers')->insert([
            'id'=>5,
            'shop_id'=>3,
            'user_id'=>5,
            'manager_name'=>'赵六',
            'phone'=>"15757130096",
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('shop_managers')->insert([
            'id'=>6,
            'shop_id'=>4,
            'user_id'=>6,
            'manager_name'=>'孙七',
            'phone'=>"15757130097",
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

    }
}
