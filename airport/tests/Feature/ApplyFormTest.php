<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplyFormTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        Auth::guard('wechat')->loginUsingId(7);
        session(['user_id'=>7]);
        //测试店铺上传是否正常
        $this->post('/wechat/activity/question', [
            'question_id' => 1,
            'activity_id'=>1,
            'type'=>'radio',
            'selected'=>'1',
            '_token' => csrf_token(),
            '_method' => 'POST'
        ])->assertSee('success');
    }
}
