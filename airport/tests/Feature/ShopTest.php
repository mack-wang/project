<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShopTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //测试管理员是否能进入后台
        Session::start();
        $this->post('/admin/login', ['name' => 'tom', 'password' => 'secret', '_token' => csrf_token()])
            ->assertSee('退出');


        //测试店铺上传是否正常
        $this->post('/admin/shop/', [
            'name' => '单元测试店' . str_random(4),
            'area_id' => '2',
            'phone' => '1575713' . rand(1000, 9999),
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'type' => 'A',
            'level' => '3',
            'scores' => '400',
            '_token' => csrf_token(),
            '_method' => 'POST'
        ])->assertSessionHas('success');

        //测试店铺修改是否正常
        $this->put('/admin/shop/1', [
            'name' => '修改的单元测试店' . str_random(4),
            'area_id' => '2',
            'phone' => '1575713' . rand(1000, 9999),
            'cigarette_id' => '12345678' . rand(1000, 9999),
            'type' => 'A',
            'level' => '3',
            'scores' => '400',
            '_token' => csrf_token(),
            '_method' => 'PUT'
        ])->assertSessionHas('success');



    }


}
