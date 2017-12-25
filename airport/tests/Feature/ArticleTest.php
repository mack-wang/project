<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        Session::start();
        $this->post('/admin/login', ['name' => 'tom', 'password' => 'secret', '_token' => csrf_token()])
            ->assertSee('退出');
        //测试店铺上传是否正常
        $this->post('/admin/activity/article', [
            'content' => '文章内容' . str_random(4),
            'count' => 10,
            'describe_title' => '奖品标题1,奖品标题2,奖品标题3',
            'describe_content' => '奖品描述1,奖品描述2,奖品描述3',
            'start_at' => date("Y-m-d H:i:s"),
            'end_at' => date("Y-m-d H:i:s", strtotime("+1 week")),
            'exp' => '800',
            'level' => '3',
            'name' => '卷烟名',
            'image_path' => '/uploads/ueditor/php/upload/image/20170526/1495728218368231.png,/uploads/ueditor/php/upload/image/20170525/1495727091961591.png',
            'off' => '0',
            'cigarette_id' => 2477,
            'title' => '芙蓉王活动' . str_random(4),
            '_token' => csrf_token(),
            '_method' => 'POST'
        ])->assertSessionHas('success');



    }


}
