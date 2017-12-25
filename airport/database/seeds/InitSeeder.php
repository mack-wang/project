<?php

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activities')->delete();
        DB::table('activity_attrs')->delete();
        DB::table('activity_headimgs')->delete();
        DB::table('activity_prizes')->delete();
        DB::table('activity_questions')->delete();
        DB::table('activity_shops')->delete();
        DB::table('activity_tasks')->delete();
        DB::table('articles')->delete();
        DB::table('auth_areas')->delete();
        DB::table('auth_shops')->delete();
        DB::table('cigarette_labels')->delete();
        DB::table('cigarette_prices')->delete();
        DB::table('grass_attrs')->delete();
        DB::table('grasses')->delete();
        DB::table('lotteries')->delete();
        DB::table('lottery_results')->delete();
        DB::table('password_resets')->delete();
        DB::table('post_prizes')->delete();
        DB::table('qrcode_paths')->delete();
        DB::table('qrcode_prizes')->delete();
        DB::table('qrcodes')->delete();
        DB::table('questions')->delete();
        DB::table('report_goods')->delete();
        DB::table('reports')->delete();
        DB::table('result_applies')->delete();
        DB::table('result_questions')->delete();
        DB::table('result_tasks')->delete();
        DB::table('scan_results')->delete();
        DB::table('shop_addresses')->delete();
        DB::table('shop_areas')->delete();
        DB::table('shop_attrs')->delete();
        DB::table('shop_headimgs')->delete();
        DB::table('shop_managers')->delete();
        DB::table('shops')->delete();
        DB::table('slide_images')->delete();
        DB::table('user_addresses')->delete();
        DB::table('user_attrs')->delete();
        DB::table('user_cigarettes')->delete();
        DB::table('user_infos')->delete();
        DB::table('user_message_codes')->delete();
        DB::table('user_recommends')->delete();
        DB::table('user_wechat_infos')->delete();
        DB::table('user_wechats')->delete();
        DB::table('users')->delete();
    }
}
