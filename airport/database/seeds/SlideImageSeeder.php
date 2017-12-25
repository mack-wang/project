<?php

use Illuminate\Database\Seeder;

class SlideImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //普通用户地址填充
        DB::table('slide_images')->delete();
        DB::table('slide_images')->insert([
            'id'=>1,
            'redirect_path'=>'/wechat/apply/1',
            'image_path'=>'/storage/slide/header1.png',
            'state'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

        DB::table('slide_images')->insert([
            'id'=>2,
            'redirect_path'=>'/wechat/apply/1',
            'image_path'=>'/storage/slide/header2.png',
            'state'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

        DB::table('slide_images')->insert([
            'id'=>3,
            'redirect_path'=>'/wechat/apply/1',
            'image_path'=>'/storage/slide/header3.png',
            'state'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

        DB::table('slide_images')->insert([
            'id'=>4,
            'redirect_path'=>'/wechat/apply/1',
            'image_path'=>'/storage/slide/header1.png',
            'state'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

        DB::table('slide_images')->insert([
            'id'=>5,
            'redirect_path'=>'/wechat/apply/1',
            'image_path'=>'/storage/slide/header2.png',
            'state'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);

        DB::table('slide_images')->insert([
            'id'=>6,
            'redirect_path'=>'/wechat/apply/1',
            'image_path'=>'/storage/slide/header3.png',
            'state'=>1,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);


    }
}
