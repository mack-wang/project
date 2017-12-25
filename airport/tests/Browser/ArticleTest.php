<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArticleTest extends DuskTestCase
{

    public function testAdminLogin()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/login')
                ->type('name', 'tom')
                ->type('password', 'secret')
                ->press('登入');
        });
    }

    //添加测评活动是否能进入
    public function testApply()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/activity/apply')
                ->assertSee('添加测评活动');
        });
    }

    //
    public function testPostArticle()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/activity/apply')
                ->type('title','芙蓉王活动' . str_random(4))
                ->type('content','文章内容' . str_random(4))
                ->type('name','白沙')
                ->waitFor('a.result', 3)
                ->click('div.title')
                ->type('describe_title','奖品标题1')
                ->type('describe_content','奖品内容1')
                ->type('start_at','2017/06/08 23:00')
                ->type('end_at','2017/06/10 23:00')
                ->type('count',10)
                ->type('exp',200)
                ->type('image_path','/uploads/ueditor/php/upload/image/20170526/1495728218368231.png,/uploads/ueditor/php/upload/image/20170525/1495727091961591.png')
                ->click('#article-submit')
                ->assertSee('成功');
        });
    }

}
