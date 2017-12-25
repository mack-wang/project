<?php

use Illuminate\Database\Seeder;

class UserCigarettesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //普通用户属性填充
        DB::table('user_cigarettes')->delete();
        DB::table('user_cigarettes')->insert([
            'user_id'=>1,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_cigarettes')->insert([
            'user_id'=>2,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_cigarettes')->insert([
            'user_id'=>3,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_cigarettes')->insert([
            'user_id'=>4,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_cigarettes')->insert([
            'user_id'=>5,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_cigarettes')->insert([
            'user_id'=>6,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_cigarettes')->insert([
            'user_id'=>7,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('user_cigarettes')->insert([
            'user_id'=>9,
            'age'=>24,
            'brand'=>'芙蓉王,黄鹤楼',
            'expect'=>'和天下',
            'price'=>rand(20,100),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

    }
}
