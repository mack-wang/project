<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Shop;
use App\Models\ShopArea;
use App\Models\ShopAttr;
use App\Models\ShopManager;
use App\Models\User;
use App\Models\UserLevelName;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //将地区列表绑定到多个视图
        view()->composer([
            'admin.shop',
            'admin.manager',
            'admin.user',
            'admin.post',
            'admin.shop-profile',
        ],function($view){
            $view->with('areas',ShopArea::get(['id','area']));
        });

        //将店铺，管理员，用户数量的统计结果绑定到相关视图
        view()->composer([
            'admin.home',
        ],function($view){
            $view->with('counts',
                [
                    'shops'=>Shop::count(),
                    'managers'=>ShopManager::count(),
                    'users'=>User::count(),
                    'activityCount'=>Activity::where('start_at','<',date('Y-m-d H:m:s',time()))->where('end_at','>',date('Y-m-d H:m:s',time()))->count(),
                ]);
        });

        //将等级列表绑定到多个视图
        view()->composer([
            'wechat.home.home',
            'wechat.apply',
            'wechat.grass.grass',
        ],function($view){
            $view->with('levels',UserLevelName::get(['id','name']));
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
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
