<?php

namespace App\Http\Controllers;

use App\Model\Cart;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edituser()
    {
        $userinfo=User::where('u_id',session('u_id'))->first();
        return view('edituser',['userinfo'=>$userinfo]);
    }

    //用户退出
    public function quit()
    {
        session(['u_id'=>null]);
        session(['u_name'=>null]);
        return redirect('/');
    }
    //购买记录
    public function buyrecord()
    {
        $goodsinfo=Cart::where('status',2)
            ->orderBy('created_at','desc')
            ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->get(['goods_name','buy_number','self_price','shop_cart.goods_id','goods_img']);
//        var_dump($goods_id);die;
        return view('buyrecord',['goodsinfo'=>$goodsinfo]);
    }
}
