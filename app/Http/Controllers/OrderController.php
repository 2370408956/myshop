<?php

namespace App\Http\Controllers;

use App\Model\Address;
use App\Model\Goods;
use App\Model\Order;
use App\Model\OrderAddress;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Model\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orderAdd(Request $request)
    {
        if(session('goods_id')==''){
            return '请选择一件商品';die;
        }
        $order=new Order();
        $goods_id=explode(',',session('goods_id'));
        $goodsinfo=Cart::whereIn('shop_cart.goods_id',$goods_id)
            ->where(['u_id'=>session('u_id'),'status'=>1])
            ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->get(['self_price','buy_number','shop_cart.goods_id','goods_name','buy_num','goods_num'])
            ->toarray();
        $order_price=0;
        foreach ($goodsinfo as $v){
            $order_price+=intval(intval($v['self_price'])*intval($v['buy_number']));
        }
        DB::beginTransaction();
        //获取订单总价
        $order->order_price=$order_price;
        $order->pay_way=$request->pay_way;
        //获取订单号
        $order->order_no=$this->getorderno();
        $u_id=session('u_id');
        $order->u_id=$u_id;
        $res1=$order->save();
        //获取刚刚添加的id
        $order_id=$order->order_id;

        //订单详情添加
//        $goodsinfo['u_id']=$u_id;
//        $goodsinfo['order_id']=$order_id;
        $orderdetail=new OrderDetail();
//        var_dump($goodsinfo);die;
        $str='';
        foreach($goodsinfo as $v){
            $goods_name=$v['goods_name'];
            $str.='('.$order_id.','.$u_id.','.$v['self_price'].','.$v['buy_number'].','.$v['goods_id'].','."'$goods_name'".')'.',';
        }
        $str=rtrim($str,',');
//        echo $str;die;
        $res2=DB::insert("insert into shop_order_detail (order_id,u_id,self_price,buy_number,goods_id,goods_name) value $str");
        //订单地址
        $addressinfo=Address::where('is_default',1)->first(['address_name','address_tel','province','county','city','address_area'])->toarray();
        $addressinfo['order_id']=$order_id;
        $addressinfo['u_id']=$u_id;
        $addressinfo['created_at']=time();
        $addressinfo['updated_at']=time();
        $res3=OrderAddress::insert($addressinfo);

        //减少商品数量
         foreach($goodsinfo as $v){
             $res4=Goods::where('goods_id',$v['goods_id'])->update(['buy_num'=>$v['buy_num']+$v['buy_number'],'goods_num'=>$v['goods_num']-$v['buy_number']]);
         }
         //删除购物车数据
        $cart=new Cart();
        $res5=$cart->where('u_id',$u_id)
            ->whereIn('goods_id',$goods_id)
            ->update(['status'=>2]);
        //判断结果
        if($res1 && $res2 && $res3 && $res4 && $res5){
            DB::commit();
            return 1;
        }else{
            DB::rollBack();
            return '添加失败';
        }

    }

    //获取订单号
    public function getorderno(){
        $str='0987654321123456789';
        $string='';
        for($i=0;$i<=6;$i++){
            $string.=substr(str_shuffle($str),5,1);
        }
        return $string.time().rand(10000,99999);
    }


    //获取订单总价
    public function getorderprice($goods_id)
    {

    }
}
