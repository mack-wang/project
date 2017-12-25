<?php

use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //普通用户地址填充
        DB::table('user_addresses')->delete();
        DB::table('user_addresses')->insert([
            'user_id'=>1,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_addresses')->insert([
            'user_id'=>2,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号2'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_addresses')->insert([
            'user_id'=>3,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号2'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_addresses')->insert([
            'user_id'=>4,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号2'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_addresses')->insert([
            'user_id'=>5,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号2'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_addresses')->insert([
            'user_id'=>6,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号2'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_addresses')->insert([
            'user_id'=>9,
            'province'=>11,
            'city'=>175,
            'area'=>2140,
            'address'=>'潮王路225号2'.str_random(4),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

    }
}
