<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends DuskTestCase
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

    //测试用户管理是否能进入
    public function testUser()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/user')
                ->assertSee('王乐城');
        });
    }

    //测试地区搜索用户
    public function testUserAreaSearch()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/user/search/area_id/1')
                ->assertSee('杭州烟草店')
                ->assertDontSee('嘉兴烟草店');
        });
    }

    //测试名字搜索用户
    public function testUserNameSearch()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/user/search/real_name/王乐城')
                ->assertSee('杭州烟草店')
                ->assertDontSee('嘉兴烟草店');
        });
    }

    //测试导出excel
    public function testUserExcel()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/user/excel')
                ->assertDontSee('ErrorException')
            ;
        });
    }

    //测试用户删除
    public function testManagerBlack()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/user')
                ->click(".delete-button")
                ->acceptDialog()
                ->assertSee('删除成功');
        });
    }

    //测试结束后重置数据库
    public function testResetDatabase()
    {
        Artisan::call('db:seed');
    }
}
