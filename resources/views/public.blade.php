<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css"  id='pay'/>
    <link href="{{url('css/index.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/mui.min_1.css')}}" id="indexgoods">
    <link href="{{url('css/goods.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('css/cartlist.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('css/member.css')}}" rel="stylesheet" type="text/css" id="paysuccess" />
</head>
<body fnav="1" class="g-acc-bg">
<div class="page-group">

    <div id="page-infinite-scroll-bottom" class="page">
        @yield('body')
        <div class="footer clearfix" id="navigation">
            <ul>
                <li class="f_home"><a href="{{url('/')}}" class="hover"><i></i>潮购</a></li>
                <li class="f_announced"><a href="{{url('goods/allshops')}}" ><i></i>所有商品</a></li>
                <li class="f_single"><a href="" ><i></i>home</a></li>
                <li class="f_car"><a id="btnCart" href="{{url('shopcart/shopcart')}}" ><i></i>购物车</a></li>
                <li class="f_personal"><a href="{{url('user/userpage')}}" ><i></i>我的潮购</a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>

<script src="{{url('js/jq.js')}}"></script>
<script src="{{url('layui/layui.js')}}"></script>
<script src="{{url('js/all.js')}}"></script>
<script src="{{url('js/index.js')}}"></script>
<script src="{{url('js/lazyload.min.js')}}"></script>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/flexslider/2.6.2/jquery.flexslider.min.js"></script>


@yield('my-js')