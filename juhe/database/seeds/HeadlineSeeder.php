<?php

use Illuminate\Database\Seeder;

class HeadlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('headlines')->delete();
        DB::table('headlines')->insert([
            'id'=>1,
            'headline'=>'企业团购福利，8折起，点击查看详情',
            'article_id'=>29,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('headlines')->insert([
            'id'=>2,
            'headline'=>'新品推荐：金龙鱼最新款食用油',
            'article_id'=>30,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
        DB::table('headlines')->insert([
            'id'=>3,
            'headline'=>'七月暑期巨献，免费送饮料福利',
            'article_id'=>31,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s"),
        ]);
    }
}
