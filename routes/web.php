<?php
use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace' => 'App\Http\Controllers\Admin', //定义命名空间
], function ($api) {
    $api->group(['prefix' => 'admin'], function ($api) {
        //示例路由 http://www.test.com/admin/account
        $api->post('/account', 'Auth\RegisterController@account')->name('account');//检验账号唯一性
        $api->post('/register', 'Auth\RegisterController@create')->name('register');//注册
        $api->post('/login', 'AuthController@login')->name('login'); //登录
        $api->post('/logout', 'AuthController@logout')->name('logout'); //退出

        $api->group(['middleware' => ['auth']], function($api){
            $api->get('/','HomeController@index')->name('index'); //首页
            $api->get('/banners','BannerController@index')->name('banners'); //轮播图列表
            $api->post('/banners','BannerController@add')->name('banners.add'); //轮播图新增
            $api->delete('/banners/d','BannerController@del')->name('banners.del'); //轮播图新增

        });

    });
});

