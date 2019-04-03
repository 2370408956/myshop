<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tools\alipay\wappay\service\AlipayTradeService;
use App\Tools\alipay\wappay\buildermodel\AlipayTradeWapPayContentBuilder;
use App\Model\Cart;
class AliyunController extends Controller
{
    public function aliyun(Request $request)
    {
//        echo app_path().'\Tools\alipay\AopSdk.php';die;
        header("Content-type: text/html; charset=utf-8");

        $goods_id=explode(',',session('goods_id'));
        $goodsinfo=Cart::whereIn('shop_cart.goods_id',$goods_id)
            ->where(['u_id'=>session('u_id'),'status'=>1])
            ->join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->get(['self_price','buy_number','shop_cart.goods_id','goods_name','buy_num','goods_num'])
            ->toarray();
//        var_dump($goodsinfo);die;
        $order_price=0;
        $order_name='';
        foreach ($goodsinfo as $v){
            $order_price+=intval(intval($v['self_price'])*intval($v['buy_number']));
            $order_name.=$v['goods_name'];
        }
        echo $order_price;
        echo $order_name;die;

        $config=config('aliyun');
//        if (!empty($_POST['WIDout_trade_no'])&& trim($_POST['WIDout_trade_no'])!=""){
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = getorderno();

            //订单名称，必填
            $subject = substr($order_name,0,120);

            //付款金额，必填
            $total_amount = $order_price;

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
        var_dump($request->all());
    }

    public function async(Request $request)
    {
        $re=$request->post();
        file_put_contents('paystatus',$re);
    }
}
