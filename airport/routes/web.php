<?php
use App\Fetch\Snoopy;
use App\Http\Controllers\Wechat\Helper;
use App\Models\Activity;
use App\Models\ResultApply;
use App\Models\Cigarette;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserRecommend;
use EasyWeChat\Foundation\Application;
use Vinkla\Hashids\Facades\Hashids;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 前台路由
|
*/

//"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx7066cfcf8f77f66f&redirect_uri=https%3A%2F%2Fwww.boyuantang.com%2Fwechat%2Fapply&response_type=code&scope=snsapi_base&state=0#wechat_redirect"

Route::get('spider/{page}', 'FetchController@test');
Route::get('fetch', 'FetchController@update');
Route::get('getImages', 'FetchController@getImages');


Route::get('test', function () {
    User::find(session('user_id'))->shop_id;
});


Route::get('test2', function () {
    $snoopy = new Snoopy;

    $url = "http://test.api2.adsl.cn/unicomAync/queryBizOrder.do?serialno=8&userId=422&sign=".md5("8422".env("PHONE_CHARGE_PRIVATEKEY"));
    $snoopy->fetch($url);
    dd(simplexml_load_string($snoopy->results));
});

//测试微信连接是否成功的，打印获取的用户信息
Route::get('wechat/info', function () {
    return Helper::header('/wechat/info', 1, 0);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/{id}', function ($id) {
    Auth::guard('wechat')->login(User::find(6), true);
    session(['user_id' => $id]);
    return redirect('/wechat/showApply');
});

//保证微信服务器正常运行的
Route::any('/wechat', 'WechatController@serve');


//微信公众号路由
Route::group(['prefix' => 'wechat', 'namespace' => 'Wechat'], function () {

    //微信登入路由
    Route::get('logout', 'LoginController@logout');
    Route::get('login', 'LoginController@index');
    Route::post('login', 'LoginController@login');
    Route::get('login/sendCode', 'LoginController@sendCode');
    Route::get('login/view/{blade}', 'LoginController@view');
    //用户手动退出后，使用密码登入
    Route::post('password-login', 'LoginController@passwordLogin');
    Route::post('password-reset', 'LoginController@passwordReset');

    //搜索，查找，显示数据路由
    Route::get('search/cigarette', 'SearchController@cigarette');
    Route::get('search/search', 'SearchController@search');
    Route::get('search/searchByName', 'SearchController@searchByName');
    Route::get('search/address/{phone}', 'SearchController@address');
    Route::get('search/city/{pid}', 'SearchController@city');
    Route::get('search/question', 'SearchController@question');

    //微信测评申领路由
    Route::any('apply', 'ApplyController@index');
    Route::any('getInfo', 'ApplyController@getInfo');
    Route::get('showApply', 'ApplyController@showApply');
    Route::any('info', function (Application $wechat) {
        $user_wechat = $wechat->oauth->user();
        dd($user_wechat);
    });


    //微信用户提交注册信息路由
    Route::get('register/{phone}', 'RegisterController@index');
    Route::post('register', 'RegisterController@register');

    //微信活动路由
    Route::get('activity/show/apply/{activity_id}/{report?}', 'ActivityController@apply');
    Route::get('activity/show/kill/{activity_id}/{report?}', 'ActivityController@kill');
    Route::get('activity/show/airport/{activity_id}/{report?}', 'ActivityController@airport');
    Route::get('activity/show/shop/{activity_id}/{report?}', 'ActivityController@shop');
    Route::get('activity/show/task/{activity_id}', 'ActivityController@task');
    Route::get('activity/show/task_question/{activity_id}', 'ActivityController@task_question');
    Route::get('activity/show/task-list', 'ActivityController@task_list');
    Route::get('activity/requires/{activity_id}', 'ActivityController@requires');

    Route::get('activity/require_kill/{activity_id}', 'ActivityController@require_kill');

    //独有活动跳转路由
    Route::get('link/takephoto', function () {
        return '跳转成功,您已经进入特殊活动';
    });

    //微信种草路由
    Route::get('grass/show/{user_id}', 'GrassController@show');
    Route::get('grass/getExp/{user_id}', 'GrassController@getExp');
    Route::get('grass/index', 'GrassController@index');
    Route::get('grass/water/{id}', 'GrassController@water');
    Route::get('grass/plant', 'GrassController@plant');

    //微信H5路由
    Route::get('h5/sandai', 'H5Controller@sandai');
    Route::get('zmxy/callback', function () {
        return view("welcome");
    });

    //单独显示文章
    Route::get('article/{id}', 'ApplyController@article');
    Route::get('qrcode/scan', 'PrizeController@scan');

    //用户直接登入个人中心
    Route::get('gohome', 'LoginController@gohome');
    Route::any('gohome/getInfo', 'LoginController@getInfo');

    //用户大转盘抽奖，获取用户信息
    //微信抽奖路由
    Route::get('lottery', 'LotteryController@index');
    Route::get('lottery/play', 'LotteryController@play');

    //保险
    Route::get('insurance', 'InsuranceController@index');
    //出行
    Route::get('guide', 'GuideController@index');
    //显示天气
    Route::get('weather', 'WeatherController@index');
    Route::get('weather/get/{code}', 'WeatherController@getWeather');
    //话费充值回调
    Route::any('charge/callback', 'ChargeController@callback');
});

//微信用户注册登入后，才能访问的路由，否则会被退回到登入注册页面
Route::group(['middleware' => ['auth.wechat'], 'prefix' => 'wechat', 'namespace' => 'Wechat'], function () {
    Route::get('home', 'HomeController@index');
    Route::post('home/address', 'HomeController@address');
    Route::get('home/view/{blade}', 'HomeController@view');
    Route::get('home/apply-list', 'HomeController@applyList');
    Route::get('home/report-list', 'HomeController@reportList');

    //资源下载路由
    Route::get('resource/qrcode', 'ResourceController@qrcode');
    Route::get('task/cancel/{activity_id}', 'ActivityController@task_cancel');
    Route::get('task/get/{activity_id}', 'ActivityController@get_task');

    //芝麻信用
    Route::get('zmxy/auth/{cert_name}/{cert_no}', 'ZmxyController@test');

    //提交问题答案
    Route::post('activity/question', 'ActivityController@question');
    Route::post('activity/questionForTask', 'ActivityController@question_for_task');

    //测评报告提交
    Route::get('report/write/{activity_id}', 'ReportController@write');
    Route::post('report/form', 'ReportController@form');
    Route::get('report/good/{report_id}', 'ReportController@good');

    //奖品管理
    Route::get('prize/show', 'PrizeController@show');
    Route::get('prize/getPrize/{id}', 'PrizeController@getPrize');
    Route::get('prize/prize_list', 'PrizeController@prizeList');
    Route::get('prize/showQrcode/{hashids}', 'PrizeController@prize_qrcode');


    //显示测评申领页面列表
    Route::get('apply/list', 'ApplyController@applyList');

    //显示邮寄奖品列表
    Route::get('prize/showPostPrize', 'PrizeController@showPostPrize');

    //未回答问题也能申领
    Route::get('activity/withoutQuestion/{activity_id}', 'ActivityController@withoutQuestion');

    //话费充值
    Route::get('charge/id/{post_prize_id}', 'ChargeController@getPhoneCharge');

    Route::get('charge/queryCharge', 'ChargeController@queryCharge');
    Route::get('charge/queryBalance', 'ChargeController@queryBalance');
    Route::get('charge/phoneCharge/{uid}/{itemId}/{serialno}', 'ChargeController@phoneCharge');
    Route::get('charge/getItemId/{phone}/{price}', 'ChargeController@getItemId');

    //每日签到
    Route::get('getDaily','GrassController@getDaily');

    //查看帮助
    Route::get('help','HelpController@index');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台路由
|
*/
Route::any('admin/login', 'Admin\LoginController@login');
Route::any('admin', 'AdminController@index');

Route::group(['middleware' => ['auth.admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('home', function () {
        return view('admin.home');
    });

    Route::get('logout', 'LoginController@logout');

    //终端店铺路由
    Route::get('shop/search/{key}/{value}', 'ShopController@search');
    Route::get('shop/excel/{key?}/{value?}', 'ShopController@excel');
    Route::post('shop/storeExcel', 'ShopController@storeExcel');
    Route::post('shop/delete', 'ShopController@delete');
    Route::post('shop/black', 'ShopController@black');
    Route::post('shop/white', 'ShopController@white');
    Route::get('shop/setPage/{page}', 'ShopController@setPage');
    Route::get('shop/remove/{id}', 'ShopController@remove');
    Route::get('shop/profile/{id}', 'ShopController@profile');
    Route::resource('shop', 'ShopController');

    //Excel表格路由
    Route::get('resource/excel/{name}', 'ResourceController@getExcel');

    //统计分析路由
    Route::get('analyze/user', 'AnalyzeController@user');

    //终端店铺管理员路由
    Route::get('manager', 'ManagerController@index');
    Route::get('manager/search/{key}/{value}', 'ManagerController@search');
    Route::get('manager/excel/{key?}/{value?}', 'ManagerController@excel');
    Route::get('manager/remove/{id}', 'ManagerController@remove');
    Route::get('manager/white', 'ManagerController@white');

    //用户路由
    Route::get('user/search/{key}/{value}', 'UserController@search');
    Route::get('user/excel/{key?}/{value?}', 'UserController@excel');
    Route::get('user/remove/{id}', 'UserController@remove');
    Route::get('user/white', 'UserController@white');
    Route::get('user/profile/{id}', 'UserController@profile');
    Route::resource('user', 'UserController');

    //活动管理的路由
    Route::get('activity/apply', 'ActivityController@apply');
    Route::get('activity/kill', 'ActivityController@kill');
    Route::get('activity/airport', 'ActivityController@airport');
    Route::get('activity/shop', 'ActivityController@shop');
    Route::get('activity/task', 'ActivityController@task');
    Route::post('activity/article', 'ActivityController@article');
    Route::post('activity/articleOnly', 'ActivityController@articleOnly');
    Route::post('activity/task_form', 'ActivityController@task_form');

    //所有活动列表的显示和编辑
    Route::get('list', 'ListController@index');
    Route::get('list/detail/apply/{activity_id}', 'ListController@applyDetail');
    Route::get('list/detail/kill/{activity_id}', 'ListController@applyDetail');
    Route::get('list/detail/airport/{activity_id}', 'ListController@shopDetail');
    Route::get('list/detail/shop/{activity_id}', 'ListController@shopDetail');
    Route::get('list/detail/task/{activity_id}', 'ListController@taskDetail');

    //查看具体活动详细
    Route::get('list/view/apply/{activity_id}', 'ListController@applyView');
    Route::get('list/view/setResultApply/{result_apply_id}', 'ListController@setResultApply');
    Route::get('list/view/showReport/{report_id}', 'ListController@showReport');
    Route::get('list/view/search/{key}/{value}/{activity_id}', 'ListController@search');
    Route::get('list/view/excel/{activity_id?}/{key?}/{value?}', 'ListController@excel');
    Route::get('list/view/setElect/{activity_id}', 'ListController@setElect');


    Route::get('list/delete/{activity_id}', 'ListController@delete');
    Route::post('list/edit/apply', 'ListController@applyEdit');
    Route::post('list/edit/kill', 'ListController@applyEdit');
    Route::post('list/edit/shop', 'ListController@shopEdit');
    Route::post('list/edit/airport', 'ListController@shopEdit');
    Route::post('list/edit/task', 'ListController@taskEdit');
    Route::get('activity/activitiesToggle/{id}', 'ListController@activitiesToggle');

    //问题管理
    Route::get('activity/question', 'ActivityController@question');
    Route::get('question/delete/{id}', 'ActivityController@questionDelete');
    Route::post('activity/question', 'ActivityController@question_form');

    //导航图管理
    Route::get('activity/nav', 'ActivityController@nav');
    Route::post('activity/nav', 'ActivityController@navForm');
    Route::get('activity/nav/delete/{id}', 'ActivityController@navDelete');
    Route::get('activity/navToggle/{id}', 'ActivityController@navToggle');
    Route::get('nav/getNav/{id}', 'ActivityController@getNav');

    //文章管理
    Route::get('article', 'ArticleController@index');
    Route::post('article', 'ArticleController@articleForm');
    Route::get('article/delete/{id}', 'ArticleController@delete');
    Route::get('article/getContent/{id}', 'ArticleController@getContent');
    Route::get('article/search', 'ArticleController@search');

    //搜索管理
    Route::get('search/article/', 'ArticleController@searchResults');

    //显示奖品和大转盘
    Route::get('prize/show', 'PrizeController@show');
    Route::post('prize/form', 'PrizeController@form');
    Route::get('prize/getPrize/{id}', 'PrizeController@getPrize');
    Route::get('prize/toggle/{id}', 'PrizeController@toggle');
    Route::get('prize/delete/{id}', 'PrizeController@delete');

    Route::get('lottery/show', 'LotteryController@show');

    //管理员修改密码
    Route::post('reset/password', 'PasswordController@reset');
    Route::get('reset/password', 'PasswordController@show');

    //管理奖品邮寄
    Route::get('post/index', 'PostController@index');
    Route::get('post/search/{key}/{value}', 'PostController@search');
    Route::get('post/excel/{key?}/{value?}', 'PostController@excel');
    Route::get('post/toggle/{id}', 'PostController@toggle');

    //测评产品添加和修改（烟或者其他普通产品）
    Route::get('product/index', 'ProductController@index');
    Route::get('product/search', 'ProductController@search');
    Route::get('product/getProduct/{id}', 'ProductController@getProduct');
    Route::get('product/getContent', 'ProductController@getContent');
    Route::post('product/form', 'ProductController@form');

    //店铺添加地区
    Route::get('shop/set/area', 'ShopController@setArea');

    //查询话费充值
    Route::get('charge/index', 'ChargeController@index');
    Route::get('charge/search/{key}/{value}', 'ChargeController@search');
    Route::get('charge/excel/{key?}/{value?}', 'ChargeController@excel');
    Route::get('charge/queryBalance', 'ChargeController@queryBalance');

    //帮助文章添加
    Route::get('help/index', 'HelpController@index');
    Route::get('help/setHelp/{article_id}', 'HelpController@setHelp');

});
