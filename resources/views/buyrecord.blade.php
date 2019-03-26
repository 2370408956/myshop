<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>潮购记录</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/buyrecord.css')}}">
    <link href="{{url('css/cartlist.css')}}" rel="stylesheet" type="text/css" />



</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">潮购记录</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="buycart"></i></a>
</div>
<div class="g-Cart-list">
    <ul id="cartBody">
        @foreach($goodsinfo as $v)
            <li goods_id="{{$v->goods_id}}" class="li" self_price="{{$v->self_price}}" buy_number="{{$v->buy_number}}">
                <s class="xuan current"></s>
                <a class="fl u-Cart-img" href="{{url("goods/shopcontent/$v->goods_id")}}">
                    <img src="/images/{{$v->goods_img}}" border="0" alt="暂无图片">
                </a>
                <div class="u-Cart-r">
                    <a href="/v44/product/12501977.do" class="gray6">{{$v->goods_name}}</a>
                    <span class="gray9">
                            <em>价格{{$v->self_price}}</em>
                        </span>
                    {{--<div class="num-opt">--}}
                        已购买{{$v->buy_number}}
                        {{--<em class="num-mius less min" ><i></i></em>--}}
                        {{--<input class="text_box" name="num" maxlength="6" type="text" value="{{$v->buy_number}}" codeid="12501977">--}}
                        {{--<em class="num-add add"><i></i></em>--}}
                    {{--</div>--}}
                    {{--<a href="javascript:;" name="delLink" cid="12501977"  isover="0" class="z-del"><s></s></a>--}}
                </div>
            </li>
        @endforeach
    </ul>
    <div id="divNone" class="empty "  style="display: none"><s></s><p>您的购物车还是空的哦~</p><a href="https://m.1yyg.com" class="orangeBtn">立即潮购</a></div>
</div>
<div class="recordwrapp" style="display: none">
    <div class="buyrecord-con clearfix">
        <div class="record-img fl">
            <img src="images/goods2.jpg" alt="">
        </div>
        <div class="record-con fl">
            <h3>(第<i>87390潮</i>)伊利 安慕希希腊风味酸奶 原味205gX12盒</h3>
            <p class="winner">获得者：<i>终于中了一次</i></p>
            <div class="clearfix">
                <div class="win-wrapp fl">
                    <p class="w-time">2017-06-30 11:11:11</p>
                    <p class="w-chao">第<i>23568</i>潮正在进行中...</p>
                </div>
                <div class="fr"><i class="buycart"></i></div>
            </div>
            

        </div>
    </div>
    <div class="buyrecord-con clearfix">
        <div class="record-img fl">
            <img src="images/goods2.jpg" alt="">
        </div>
        <div class="record-con fl">
            <h3>(第<i>87390潮</i>)伊利 安慕希希腊风味酸奶 原味205gX12盒</h3>
            <p class="winner">获得者：<i>终于中了一次</i></p>
            <div class="clearfix">
                <div class="win-wrapp fl">
                    <p class="w-time">2017-06-30 11:11:11</p>
                    <p class="w-chao"><i>23568</i>潮正在进行中...</p>
                </div>
                <div class="fr"><i class="buycart"></i></div>
            </div>
            

        </div>
    </div>
</div>

<div class="nocontent">
    <div class="m_buylist m_get">
        <ul id="ul_list">
            {{--<div class="noRecords colorbbb clearfix">--}}
                {{--<s class="default"></s>您还没有购买商品哦~--}}
            {{--</div>--}}
            <div class="hot-recom">
                <div class="title thin-bor-top gray6">
                    <span><b class="z-set"></b>人气推荐</span>
                    <em></em>
                </div>
                <div class="goods-wrap thin-bor-top">
                    <ul class="goods-list clearfix">
                        <li>
                            <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                                <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                            </a>
                            <p class="g-name">
                                <a href="https://m.1yyg.com/v44/products/23458.do">(第<i>368671</i>潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                            </p>
                            <ins class="gray9">价值:￥7130</ins>
                            <div class="btn-wrap">
                                <div class="Progress-bar">
                                    <p class="u-progress">
                                        <span class="pgbar" style="width:1%;">
                                            <span class="pging"></span>
                                        </span>
                                    </p>
                                </div>
                                <div class="gRate" data-productid="23458">
                                    <a href="javascript:;"><s></s></a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="" class="g-pic">
                                <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                            </a>
                            <p class="g-name">
                                <a href="https://m.1yyg.com/v44/products/23458.do">(第368671潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                            </p>
                            <ins class="gray9">价值:￥7130</ins>
                            <div class="btn-wrap">
                                <div class="Progress-bar">
                                    <p class="u-progress">
                                        <span class="pgbar" style="width:45%;">
                                            <span class="pging"></span>
                                        </span>
                                    </p>
                                </div>
                                <div class="gRate" data-productid="23458">
                                    <a href="javascript:;"><s></s></a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                                <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                            </a>
                            <p class="g-name">
                                <a href="https://m.1yyg.com/v44/products/23458.do">(第<i>368671</i>潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                            </p>
                            <ins class="gray9">价值:￥7130</ins>
                            <div class="btn-wrap">
                                <div class="Progress-bar">
                                    <p class="u-progress">
                                        <span class="pgbar" style="width:1%;">
                                            <span class="pging"></span>
                                        </span>
                                    </p>
                                </div>
                                <div class="gRate" data-productid="23458">
                                    <a href="javascript:;"><s></s></a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                                <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                            </a>
                            <p class="g-name">
                                <a href="https://m.1yyg.com/v44/products/23458.do">(第368671潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                            </p>
                            <ins class="gray9">价值:￥7130</ins>
                            <div class="btn-wrap">
                                <div class="Progress-bar">
                                    <p class="u-progress">
                                        <span class="pgbar" style="width:1%;">
                                            <span class="pging"></span>
                                        </span>
                                    </p>
                                </div>
                                <div class="gRate" data-productid="23458">
                                    <a href="javascript:;"><s></s></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </ul>
    </div>
</div>


<script src="js/jq.js"></script>




</body>
</html>
