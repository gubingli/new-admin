<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace' => 'App\Http\Controllers\Api',
], function ($api) {
   $api->group(['prefix' => 'api'], function ($api) {
       $api->post('/login', 'AuthController@login'); //登录
       $api->post('/logout', 'AuthController@logout'); //退出

       $api->group(['middleware' => ['api.auth']], function($api){
           $api->get('/','HomeController@index')->name('index'); //首页

       });

   });
});
