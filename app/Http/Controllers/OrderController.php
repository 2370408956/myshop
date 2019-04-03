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
use App\Tools\alipay\wappay\service\AlipayTradeService;
use App\Tools\alipay\wappay\buildermodel\AlipayTradeWapPayContentBuilder;

class OrderController extends Controller
{
    //结算
    public function orderAdd($out_trade_no,$trade_no)
    {
        if(session('goods_id')==''){
            return '请选择一件商品';die;
        }
        $order=new Order();
        $goods_id=explode(',',session('goods_id'));
        //查询商品信息
        $goodsinfo=Cart::whereIn('shop_cart.goods_id',$goods_id)
            ->where(['u_id'=>session('u_id'),'status'=>1])
            ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->get(['self_price','buy_number','shop_cart.goods_id','goods_name','buy_num','goods_num'])
            ->toarray();
        $order_price=0;
        //计算总价
        foreach ($goodsinfo as $v){
            $order_price+=intval(intval($v['self_price'])*intval($v['buy_number']));
        }
        DB::beginTransaction();
        //获取订单总价
        $order->order_price=$order_price;
        $order->trade_no=$trade_no;
//        $order->pay_way=1;
        //获取订单号
        $order->order_no=$out_trade_no;
        $u_id=session('u_id');
        $order->u_id=$u_id;
        $res1=$order->save();
        //获取刚刚添加的id
        $order_id=$order->order_id;

        //订单详情添加
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
            return redirect('shopcart/paysuccess');
        }else{
            DB::rollBack();
            return '添加失败';
        }
    }



    //获取商品数据
    public function getinfo()
    {

//        successly($order_name.','.$order_price);die;
//        return json_encode($order_name.','.$order_price);
    }


    public function aliyun()
    {
//        echo app_path().'\Tools\alipay\AopSdk.php';die;
        header("Content-type: text/html; charset=utf-8");
//        $arr=$request->all();
//        var_dump($data);die;

        $config=config('aliyun');
//        if (!empty($_POST['WIDout_trade_no'])&& trim($_POST['WIDout_trade_no'])!=""){
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $order=new Order();
        $goods_id=explode(',',session('goods_id'));
        $goodsinfo=Cart::whereIn('shop_cart.goods_id',$goods_id)
            ->where(['u_id'=>session('u_id'),'status'=>1])
            ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->get()
            ->toarray();
        $order_price=0;
        $order_name='';
        foreach ($goodsinfo as $v){
            $order_name.=$v['goods_name'];
            $order_price+=intval(intval($v['self_price'])*intval($v['buy_number']));
        }
        $out_trade_no = getorderno();
        //订单名称，必填
        $subject =$order_name;

        //付款金额，必填
        $total_amount =$order_price;

        //商品描述，可空
        $body = '';

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return ;
//        }
    }

    public function sync(Request $request)
    {
//        print_r( $request->all());
//        return redirect('shopcart/paysuccess');
        $config=config('aliyun');
//require_once 'wappay/service/AlipayTradeService.php';


        $arr=$_GET;
        $alipaySevice = new AlipayTradeService($config);
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号

            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

            //支付宝交易号

            $trade_no = htmlspecialchars($_GET['trade_no']);
            return redirect('shopcart/paysuccess');
//	echo "验证成功<br />外部订单号：".$out_trade_no;
            echo '验证成功';
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }else {
            //验证失败
            echo "验证失败";
        }
    }

    public function async()
    {
        $config=config('aliyun');
        $arr=$_POST;
        $alipaySevice = new AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];


            if($_POST['trade_status'] == 'TRADE_FINISHED') {
//                $this->orderAdd($out_trade_no,$trade_no);
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }else if($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
//                $this->orderAdd($out_trade_no,$trade_no);
            }
//            $this->orderAdd($out_trade_no,$trade_no);
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            echo "success";		//请不要修改或删除

        }else {
            //验证失败
            echo "fail";	//请不要修改或删除

        }

    }



}
