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
});

Route::get('login/','CartController@shopcart');
//购物车
Route::group(['middleware'=>'checklogin','prefix'=>'shopcart'],function(){
    Route::any('shopcart','CartController@shopcart');
    Route::any('cartdel','CartController@cartdel');
});

//我的
//Route::group(['middleware'=>'checklogin','prefix'=>'user'],function(){
//    Route::get('userpage','IndexController@userpage');
//});
Route::get('user/userpage','LoginController@userpage');

Route::get('VerifierController/verifier','VerifierController@verifier');

