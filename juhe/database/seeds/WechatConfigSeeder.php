<?php

use Illuminate\Database\Seeder;

class WechatConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //普通用户地址填充
        DB::table('wechat_configs')->delete();
        DB::table('wechat_configs')->insert([
            'id'=>1,
            'imgUrl'=>'/img/wechat/recommend.png',
            'description'=>'专注于解决企事业单位、机构部门的大宗采购，福利团购、联合促销、节日礼品等解决方案。',
            'title'=>'钜合天下',
            'link'=>url('/wechat/home'),
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
