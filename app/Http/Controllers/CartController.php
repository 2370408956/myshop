<?php

namespace App\Http\Controllers;

use App\Model\Cart;
use App\Model\Goods;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //加入购物车
    public function shopcart(Request $request){
        $goods_id=$request->post('goods_id');
        if(empty($goods_id)){
            $goodsinfo=Cart::where('u_id',session('u_id'))
                ->where('status',1)
                ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
                ->get(['goods_name','shop_cart.goods_id','buy_number','self_price','goods_img']);
            $info=$this->goodsinfo();
            $price=0;
            foreach($goodsinfo as $k=>$v){
                $price+=intval(intval($v['self_price'])*intval($v['buy_number']));
            }
            return view('shopcart',['goodsinfo'=>$goodsinfo,'price'=>$price,'info'=>$info]);
        }else {
            $buy_number=$request->buy_number;
            if(empty($buy_number)){
                return $this->shopAdd($goods_id);
            }else{
                return $this->shopcartedit($goods_id,$buy_number);
            }
        }
    }

    //加入购物车
    public function shopAdd($goods_id)
    {
        $where=[
            'u_id'=>session('u_id'),
            'shop_cart.goods_id'=>$goods_id,
            'status'=>1
        ];
        $cart=new Cart();
        $arr=Cart::where($where)
            ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->first(['goods_num','buy_number']);
        //验证该用户是否加入过该商品
        if(!empty($arr)){
            //判断库存
            if($arr['buy_number']+1<=$arr['goods_num']){
                $res=Cart::where($where)->update(['buy_number'=>$arr['buy_number']+1]);
            }else{
                return  2;
            }
        }else{
            //直接添加
            $cart->u_id=session('u_id');
            $cart->goods_id=$goods_id;
            $cart->buy_number=1;
            $res=$cart->save();
        }


        if($res){
            return 1;
        }else{
            return 2;
        }
    }

    //修改
    public function shopcartedit($goods_id,$buy_number)
    {
        $where=[
            'u_id'=>session('u_id'),
            'shop_cart.goods_id'=>$goods_id
        ];
        $cart=new Cart();
        $arr=Cart::where($where)
            ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->first(['goods_num','buy_number']);
        if(!empty($arr)){
            //修改
            if($buy_number<=$arr['goods_num']){
                $res=Cart::where($where)->update(['buy_number'=>$buy_number]);
                if($res){
                    return 1;
                }else{
                    return 2;
                }
            }else{
                return 2;
            }
        }
    }

    //删除
    public function cartdel(Request $request)
    {
        $goods_id=$request->goods_id;
        $goods_id=explode(',',$goods_id);
//        $where=[
//            'u_id'=>session('u_id'),
//            'goods_id'=>['in',$goods_id]
//        ];
        $cart=new Cart();
        $res=$cart->where('u_id',session('u_id'))
            ->whereIn('goods_id',$goods_id)
            ->delete();
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

    //获取商品数据
    public function goodsinfo()
    {
        $goods=new Goods();
        return $goods->limit(6)->get(['goods_id','goods_name','goods_img','self_price']);
    }

    public function buygoodsid(Request $request)
    {

        $goods_id=$request->goods_id;
        session(['goods_id'=>$goods_id]);
        if(session('goods_id')!=''){
            return 1;
        }
    }

    //结算页面
    public function payment()
    {
        $goods=new Goods();
        $goods_id=explode(',',session('goods_id'));
        $goodsinfo=$goods->where(['u_id'=>session('u_id'),'status'=>1])
                    ->whereIn('shop_cart.goods_id',$goods_id)
                    ->join('shop_cart','shop_cart.goods_id','=','shop_goods.goods_id')
                    ->get(['self_price','buy_number','goods_name','goods_img']);
        $price=0;
        foreach($goodsinfo as $k=>$v){
            $price+=intval(intval($v['self_price'])*intval($v['buy_number']));
        }
        return view('payment',['goodsinfo'=>$goodsinfo,'price'=>$price]);
    }

    //支付成功
    public function paysuccess()
    {
        return view('paysuccess');
    }


}
