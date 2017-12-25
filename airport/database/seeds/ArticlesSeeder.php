<?php

use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->delete();
        DB::table('articles')->insert([
            'id'=>1,
            'title'=>'芙蓉王文章1',
            'content' => '<img class="full_width" src="'.asset("/store/article/1/article-frw.jpg").'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>2,
            'title'=>'芙蓉王文章2',
            'content' => '<img class="full_width" src="'.asset("/store/article/1/article-frw.jpg").'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>3,
            'title'=>'和天下文章1',
            'content' => '<img class="full_width" src="'.asset("/store/article/2/article-htx.jpg").'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>4,
            'title'=>'和天下文章2',
            'content' => '<img class="full_width" src="'.asset("/store/article/3/article-xb.jpg").'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>5,
            'title'=>'机场活动文章1',
            'content' => '<img class="full_width" src="'.asset("/store/article/4/article-pz.jpg").'">',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>6,
            'title'=>'烟店活动文章1',
            'content' => '卷烟终端店铺活动-内容1',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>7,
            'title'=>'烟店活动文章2',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>8,
            'title'=>'烟店活动文章3',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>9,
            'title'=>'烟店活动文章4',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>10,
            'title'=>'烟店活动文章5',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>11,
            'title'=>'烟店活动文章6',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>12,
            'title'=>'烟店活动文章7',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>13,
            'title'=>'烟店活动文章8',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>14,
            'title'=>'烟店活动文章9',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('articles')->insert([
            'id'=>15,
            'title'=>'烟店活动文章10',
            'content' => '卷烟终端店铺活动-内容2',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
