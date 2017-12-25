<?php

namespace App\Providers;

use App\WechatConfig;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //将微信设置绑定到多个视图
        view()->composer([
            'wechat.layout.frame-home',
        ], function ($view) {
            $view->with('wechat', WechatConfig::find(1))
                ->with('js', app('wechat')->js);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
