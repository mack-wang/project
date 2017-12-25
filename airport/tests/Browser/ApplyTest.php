<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApplyTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */


    //测试微信申领界面登入
    public function testWechatApply()
    {
        Auth::guard('wechat')->logout();
        $this->browse(function (Browser $browser) {
            $browser->visit('/wechat/apply')
                    ->assertSee('未登入');
        });
    }


    //测试微信申领个人中心短信注册
    public function testWechatLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/wechat/apply')
                    ->clickLink('登入')
                    ->type('phone','15757130071')
                    ->click('#get-code')
                    ->type('code','123456')
                    ->click('.ui.agreement.checkbox>label')
                    ->press('登入')
                    ->assertSee('编辑资料');
        });
    }

    //测试结束后重置数据库
    public function testResetDatabase()
    {
        Artisan::call('db:seed');
    }


}
