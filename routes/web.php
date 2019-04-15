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


Route::any('/','IndexController@index');


Route::any('login/login','LoginController@login');
//商品
Route::prefix('goods')->group(function(){
    Route::get('goodsinfo','GoodsController@goodsInfo');
    Route::get('shopcontent/{id}','GoodsController@shopcontent');
    Route::get('categoods/{id}','GoodsController@categoods');
    Route::any('allshops/{id?}','GoodsController@allshops');
});
//登录
Route::prefix('login')->group(function(){
    Route::get('login','LoginController@login');
    Route::get('register','LoginController@register');
    Route::any('registerdo','LoginController@registerDo');
    Route::any('sendcode','LoginController@sendcode');
    Route::any('findpwd','LoginController@findpwd');
    Route::any('next','LoginController@next');
    Route::any('loginpwd','LoginController@loginpwd');
});

Route::get('login/','CartController@shopcart');
//购物车
Route::group(['middleware'=>'checklogin','prefix'=>'shopcart'],function(){
    Route::any('shopcart','CartController@shopcart');
    Route::any('cartdel','CartController@cartdel');
    Route::any('buygoodsid/{goods_id?}','CartController@buygoodsid');
    Route::any('payment/{type?}','CartController@payment');
    Route::any('paysuccess','CartController@paysuccess');
});
//地址
Route::group(['middleware'=>'checklogin','prefix'=>'address'],function(){
    Route::any('address','AddressController@address');
    Route::any('addaddress','AddressController@addaddress');
    Route::any('addressedit/{address_id?}','AddressController@addressedit');
    Route::any('addressupdate','AddressController@addressupdate');
    Route::any('addressdo','AddressController@addressdo');
    Route::any('adddefault','AddressController@adddefault');
    Route::any('addressdel','AddressController@addressdel');
    Route::any('addressarea','AddressController@addressarea');
});

//我的
Route::group(['middleware'=>'checklogin','prefix'=>'user'],function(){
    Route::get('edituser','UserController@edituser');
    Route::get('quit','UserController@quit');
    Route::get('buyrecord','UserController@buyrecord');
});

//订单
Route::group(['middleware'=>'checklogin','prefix'=>'order'],function(){
    Route::get('orderadd','OrderController@orderAdd');
//    Route::get('onepay','OrderController@onepay');
    Route::get('getinfo','OrderController@getinfo');
});

//阿里云
Route::prefix('aliyun')->group(function(){
    Route::any('aliyun/{demo?}','OrderController@aliyun');
    Route::any('sync','OrderController@sync');
    Route::post('async','OrderController@async');
});
Route::get('user/userpage','LoginController@userpage');

Route::get('VerifierController/verifier','VerifierController@verifier');


//Route::prefix('demo')->group(function(){
//    Route::any('index','DemoController@index');
//});
Route::get('test','DemoController@test');

Route::any('wechat','Wechat\WechatController@checksign');
Route::any('wechat/up','Wechat\\MaterialController@index');
Route::any('wechat/updo','Wechat\\MaterialController@updo');

Route::prefix('admin')->group(function(){
    Route::get('index',"Admin\\SubstribeController@index");
    Route::any('indexdo',"Admin\\SubstribeController@indexdo");
    Route::get('wetype',"Admin\\SubstribeController@wetype");
    Route::get('wetype',"Admin\\SubstribeController@wetype");
    Route::any('wetypedo',"Admin\\SubstribeController@wetypedo");
    Route::any('menu',"Admin\\MenuController@menu");
    Route::any('getmenulist',"Admin\\MenuController@getmenulist");
    Route::any('addmenudo',"Admin\\MenuController@addmenudo");
    Route::any('getmenuinfo',"Admin\\MenuController@getmenuinfo");
    Route::any('menudel',"Admin\\MenuController@menudel");
    Route::any('menuindex',"Admin\\MenuController@menuindex");
    Route::any('menuindexadd',"Admin\\MenuController@menuindexadd");
    Route::any('menuindexado',"Admin\\MenuController@menuindexado");
    Route::any('menuinfo',"Admin\\MenuController@menuinfo");
    Route::any('menuadddo',"Admin\\MenuController@menuadddo");
});
route::get('admin',"Admin\\AdminController@index");


route::prefix('demo')->group(function(){
    Route::any('index','Demo\\DemoController@index');
    Route::any('check','Demo\\DemoController@check');
    Route::any('indexadd','Demo\\DemoController@indexadd');
    Route::any('addmenu','Demo\\DemoController@addmenu');
});

//Route::get('index','Demo\UserController@index');
//Route::get('sendcode','Demo\UserController@sendcode');
//Route::post('useradd','Demo\UserController@useradd');
//Route::get('login','Demo\UserController@login');
//Route::post('logindo','Demo\UserController@logindo');
//Route::any('userlist','Demo\UserController@userlist');
