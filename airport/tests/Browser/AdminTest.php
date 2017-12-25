<?php

namespace Tests\Browser;

use App\Models\Admin;
use DatabaseSeeder;
use Illuminate\Support\Facades\Artisan;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    /**
     * 所有测试如果需要额外定位的，均使用id=test1234 在最外框上定位
     */

    //测试后台登入
    public function testAdminLogin()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/login')
                ->type('name', 'tom')
                ->type('password', 'secret')
                ->press('登入')
                ->assertSee('退出');
        });
    }

    //测试店铺分类筛选
    public function testShopTypeFilter()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/shop')
                ->click('#test1')
                ->assertSee('杭州烟草店')
                ->assertDontSee('嘉兴烟草店');
        });
    }

    //测试店铺搜索
    public function testShopSearch()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/shop')
                ->type('search', '嘉兴')
                ->click('#search_shop')
                ->assertSee('嘉兴烟草店')
                ->assertDontSee('杭州烟草店');
        });
    }

    //测试修改单个店铺
    public function testShopEdit()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/shop')
                ->click(".edit-button")
                ->type('name', '杭州烟草店dusk')
                ->click('#test3')
                ->assertSee('修改成功');
        });
    }

    //测试删除单个店铺
    public function testShopDelete()
    {
        /*
         * $browser->dismissDialog() = press Cancel (if confirmation)
         * $browser->acceptDialog() = press OK
         * */

        $this->browse(function ($browser) {
            $browser->visit('/admin/shop')
                ->click(".delete-button")
                ->acceptDialog()
                ->assertSee('删除成功');
        });
    }

    //测试添加新店铺
    public function testShopDeleteGroup()
    {

        $this->browse(function ($browser) {
            $browser->visit('/admin/shop')
                ->click("#add-shop")
                ->type('name','店铺dusk')
                ->type('phone','15757140092')
                ->type('cigarette_id','123456789110')
                ->type('level','2')
                ->type('scores','300')
                ->click('#test3')
                ->assertSee('新店铺上传成功');
        });
    }


    //测试下载表格
    public function testShopExcelDownload()
    {

        $this->browse(function ($browser) {
            $browser->visit('/admin/shop/excel')
                ->assertDontSee('ErrorException')
                ->visit('/admin/shop/excel/area_id/2')
                ->assertDontSee('ErrorException')
                ->visit('/admin/shop')
                ->click('#add-shop-excel')
                ->click('.add-shop-excel>.basic.primary.button')
                ->assertDontSee('ErrorException')
            ;
        });
    }



    //测试结束后重置数据库
    public function testResetDatabase()
    {
        Artisan::call('db:seed');
    }
}
