<?php

namespace Tests\Browser;

use App\Models\Admin;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManagerTest extends DuskTestCase
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


    //测试访问管理员页面
    public function testManager()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/manager')
                ->assertSee('杭州烟草店');
        });
    }

    //测试地区搜索
    public function testManagerSearch()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/manager/search/area_id/1')
                ->assertSee('杭州')
                ->assertDontSee('嘉兴');
        });
    }

    //测试名字搜索
    public function testManagerNameSearch()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/manager')
                ->type('search','王五')
                ->click('#search_manager')
                ->assertSee('王五')
                ->assertDontSee('李四');
        });
    }

    //测试导出excel
    public function testManagerExcel()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/manager/excel')
                ->assertDontSee('ErrorException')
            ;
        });
    }

    //测试管理员拉黑
    public function testManagerBlack()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/manager')
                ->click(".delete-button")
                ->acceptDialog()
                ->assertSee('拉黑成功');
        });
    }

    //测试管理员拉黑恢复
    public function testManagerBack()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/manager')
                ->type("phone",'15757130092')
                ->click('.ui.submit.button')
                ->assertSee('管理员恢复成功!');
        });
    }



    //测试结束后重置数据库
    public function testResetDatabase()
    {
        Artisan::call('db:seed');
    }

}
