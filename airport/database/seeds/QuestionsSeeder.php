<?php

use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->delete();
        DB::table('questions')->insert([
            'id' => 1,
            'image_path' => '/img/wechat/question.png',
            'question' => '芙蓉王硬闪带细支长度是多少？',
            'options' => '70mm,75mm,80mm',
            'selected' => '2',
            'type'=>'radio',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('questions')->insert([
            'id' => 2,
            'image_path' => '/img/wechat/question.png',
            'question' => '你看中卷烟的哪些特点？',
            'options' => '烟香,包装,品牌,吸感',
            'selected' => '14',
            'type'=>'select',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('questions')->insert([
            'id' => 3,
            'image_path' => '/img/wechat/question.png',
            'question' => '请上传正在抽的烟的烟包照片',
            'type'=>'photo',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('questions')->insert([
            'id' => 4,
            'image_path' => '/img/wechat/question.png',
            'question' => '谈谈您对和而不同的理解',
            'type'=>'input',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
