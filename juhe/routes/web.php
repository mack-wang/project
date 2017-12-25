<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Headline;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    dd(\App\City::find(58)->name);
});

//保证微信服务器正常运行的
Route::any('/wechat', 'WechatController@serve');

Route::group(['prefix' => 'wechat', 'namespace' => 'Wechat'], function () {
    Route::get('home', 'HomeController@home');
    Route::get('index', 'HomeController@index');
    Route::get('product', 'HomeController@product');
    Route::get('connect', 'HomeController@connect');
    Route::get('company', 'HomeController@company');
    Route::get('user', 'HomeController@user');
    Route::get('user', 'HomeController@user');
    Route::get('password/reset', 'HomeController@reset');

    //显示城市
    Route::get('search/city/{pid}', 'AddressController@city');
    Route::post('address', 'AddressController@address');
    Route::get('address/show', 'AddressController@show');
    Route::get('address/getAddress/{id}', 'AddressController@getAddress');

    //显示公司信息编辑
    Route::post('company', 'CompanyController@company');
    Route::get('company/show', 'CompanyController@show');

    //显示文章
    Route::get('article/{id}', 'HomeController@article');
    Route::get('catalog/{id}', 'HomeController@catalog');

    //上传用户头像

    Route::post('home/avatar', 'HomeController@avatar');

    //用户修改密码
    Route::post('reset/password', 'PasswordController@reset');
    Route::get('reset/password', 'PasswordController@show');
    Route::get('reset/forget', 'PasswordController@forget');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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
Route::get('admin/search/article', 'Admin\IndexController@searchArticle');
Route::get('admin/index/view/{id}', 'Admin\IndexController@increaseHeadlineView');

Route::group(['middleware' => ['auth.admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('home', function () {
        return view('admin.home');
    });
    Route::get('logout', 'LoginController@logout');

    //首页控制
    Route::get('index/show/nav', 'IndexController@nav');
    //导航图管理
    Route::get('index/nav', 'IndexController@nav');
    Route::post('index/nav/form', 'IndexController@navForm');
    Route::get('index/nav/delete/{id}', 'IndexController@navDelete');
    Route::get('index/navToggle/{id}', 'IndexController@navToggle');
    Route::get('nav/getNav/{id}', 'IndexController@getNav');
    //钜合头条管理
    Route::get('index/show/headline', 'IndexController@headline');

    Route::post('index/headline/form', 'IndexController@headlineForm');
    Route::get('index/delHeadline/{id}', 'IndexController@delHeadline');
    Route::get('index/getHeadline/{id}', 'IndexController@getHeadline');

    //产品控制
    Route::get('product/show/article', 'ProductController@article');
    Route::get('product/show/catalog', 'ProductController@catalog');
    Route::get('product/show/editArticle/{id?}', 'ProductController@editArticle');
    Route::get('product/addCatalog', 'ProductController@addCatalog');
    Route::get('product/delCatalog/{id}', 'ProductController@delCatalog');
    Route::get('product/delArticle/{id}', 'ProductController@delArticle');
    Route::post('product/addArticle', 'ProductController@addArticle');
    Route::get('product/getArticle/{id}', 'ProductController@getArticle');//返回指定文章的ajax信息
    //目录的推荐，关闭，置顶
    Route::get('product/catalog/recommend/{id}', 'ProductController@recommendCatalog');
    Route::get('product/catalog/top/{id}', 'ProductController@topCatalog');
    Route::get('product/catalog/off/{id}', 'ProductController@offCatalog');

    //联系方式控制
    Route::get('connect/index', 'ConnectController@index');
    Route::post('connect/update', 'ConnectController@update');

    //微信分享设置
    Route::get('wechat/index', 'WechatController@index');
    Route::post('wechat/update', 'WechatController@update');

    //显示所有用户
    Route::get('user/index', 'UserController@index');
    Route::post('user/search','UserController@search');

    //更换企业介绍文章
    Route::get('company/index', 'CompanyController@index');
    Route::get('company/form', 'CompanyController@form');

    //管理员修改密码
    Route::post('reset/password', 'PasswordController@reset');
    Route::get('reset/password', 'PasswordController@show');
    Route::get('reset/forget', 'PasswordController@forget');
    Route::get('reset/forget', 'PasswordController@forget');

    //搜索编辑文章
    Route::post('article/search','ProductController@search');
    //文章置顶
    Route::get('article/top/{id}', 'ProductController@topArticle');
});

