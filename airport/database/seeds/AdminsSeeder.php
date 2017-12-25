<?php

use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //管理员表填充
        DB::table('admins')->delete();
        DB::table('admins')->insert([
            'id'=>'1',
            'name'=>'tom',
            'email'=>'641212003@163.com',
            'phone'=>'15757130092',
            'password'=>Hash::make('secret'),
            'auth'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('admins')->insert([
            'id'=>'2',
            'name'=>'bob',
            'email'=>'641212003@qq.com',
            'phone'=>'15757130093',
            'password'=>Hash::make('secret'),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
