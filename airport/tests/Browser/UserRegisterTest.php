<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\DuskTestCase;

class UserRegisterTest extends DuskTestCase
{
    //测试能否登入，并填写表单
    public function testExample()
    {
        $this->browse(function ($browser) {
            $browser->visit('/wechat/apply')
                ->assertSee('未登入')
                ->clickLink('登入')
                ->type('phone', '15757130071')
                ->click('#get-code')
                ->type('code', '123456')
                ->click('.ui.agreement.checkbox')
                ->click('#test1')
                ->assertSee('性别')
                ->type('age', 19)
                ->type('cigarette_age', 5)
                ->type('price', 25)
                ->type('brand', '黄鹤楼')
                ->waitFor('a.result', 3)
                ->click('div.title')
                ->type('brand', '黄金叶')
                ->waitFor('a.result', 3)
                ->click('div.title')
                ->type('expect', '芙蓉王,和天下')
                ->type('real_name', '王乐城')
                ->select('province', '11')
                ->waitFor('#city', 5)
                ->select('city', '175')
                ->waitFor('#area', 5)
                ->select('area', '2140')
                ->type('address', '红石中央225号')
                ->click('#user-submit')
                ->assertSee('礼品券');
        });

        //测试完后，该用户要退出，不然登入记录还在
        Auth::guard('wechat')->logout();
    }

    //测试结束后重置数据库
    public function testResetDatabase()
    {
        Artisan::call('db:seed');
    }


}
