
@extends('public')
{{--<link rel="stylesheet" href="{{url('js/mui.min.js')}}">--}}
@section('body')
    <input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
    <div>
        <!--首页头部-->
        <div class="m-block-header">
            <a href="/" class="m-public-icon m-1yyg-icon"></a>
            <a href="/" class="m-index-icon">编辑</a>
        </div>
        <!--首页头部 end-->
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
                        <div class="num-opt">
                            <em class="num-mius less min" ><i></i></em>
                            <input class="text_box" name="num" maxlength="6" type="text" value="{{$v->buy_number}}" codeid="12501977">
                            <em class="num-add add"><i></i></em>
                        </div>
                        <a href="javascript:;" name="delLink" cid="12501977"  isover="0" class="z-del"><s></s></a>
                    </div>    
                </li>
                @endforeach
            </ul>
            <div id="divNone" class="empty "  style="display: none"><s></s><p>您的购物车还是空的哦~</p><a href="https://m.1yyg.com" class="orangeBtn">立即潮购</a></div>
        </div>
        <div id="mycartpay" class="g-Total-bt g-car-new" style="">
            <dl>
                <dt class="gray6">
                    <s class="quanxuan current"></s>全选
                    <p class="money-total">合计<em class="orange total"><span>￥</span>{{$price}}</em></p>
                    
                </dt>
                <dd>
                    <a href="javascript:;" id="a_payment" class="orangeBtn w_account remove">删除</a>
                    <a href="javascript:;" id="a_payment" class="orangeBtn w_account">去结算</a>
                </dd>
            </dl>
        </div>
        <div class="hot-recom">
            <div class="title thin-bor-top gray6">
                <span><b class="z-set"></b>人气推荐</span>
                <em></em>
            </div>
            <div class="goods-wrap thin-bor-top">
                <ul class="goods-list clearfix">
                @foreach($info as $v)
                    <li>
                        <a href="{{url("goods/shopcontent/$v->goods_id")}}" class="g-pic">
                            <img src="/images/{{$v->goods_img}}" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="{{url("goods/shopcontent/$v->goods_id")}}">{{$v->goods_name}}</a>
                        </p>
                        <ins class="gray9">价值:￥{{$v->self_price}}</ins>
                        {{--<div class="btn-wrap">--}}
                            {{--<div class="Progress-bar">--}}
                                {{--<p class="u-progress">--}}
                                    {{--<span class="pgbar" style="width:1%;">--}}
                                        {{--<span class="pging"></span>--}}
                                    {{--</span>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                            {{--<div class="gRate" data-productid="23458">--}}
                                {{--<a href="javascript:;"><s></s></a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        <input type="hidden" value="{{csrf_token()}}" id="_token">
@endsection

<!---商品加减算总数---->
    @section('my-js')
            <script>
                $(function(){
                    $('#div-header').css('display','none');
                    $('.less').click(function(){
                        var _this=$(this);
                        var buy_number=parseInt(_this.next('input').val())-1;
                        var goods_id=_this.parents('li').attr('goods_id');
                        var _token=$('#_token').val();
                        $.post(
                            "{{url('shopcart/shopcart')}}",
                            {goods_id:goods_id,_token:_token,buy_number:buy_number},
                            function(res){
                                console.log(res);
                            }
                        )
                    });

                    //删除
                    $('.z-del').click(function(){
                        var _this=$(this);
                        var goods_id=_this.parents('li').attr('goods_id');
                        var _token=$('#_token').val();
                        $.post(
                            "{{url('shopcart/cartdel')}}",
                            {goods_id:goods_id,_token:_token},
                            function(res){
                                if(res==1){
                                    _this.parents('li').remove();
                                    layer.msg('删除成功',{icon:1});
                                }else{
                                    layer.msg('删除失败',{icon:1});
                                }
                            }
                        )
                    })
                    $('.add').click(function(){
                        var _this=$(this);
                        var buy_number=parseInt(_this.prev('input').val())+1;
                        var goods_id=_this.parents('li').attr('goods_id');
                        var _token=$('#_token').val();
                        $.post(
                            "{{url('shopcart/shopcart')}}",
                            {goods_id:goods_id,_token:_token,buy_number:buy_number},
                            function(res){
                                console.log(res);
                            }
                        )
                    })

                    $('.text_box').blur(function(){
                        var _this=$(this);
                        var buy_number=parseInt(_this.val());
                        var goods_id=_this.parents('li').attr('goods_id');
                        var _token=$('#_token').val();
                        $.post(
                            "{{url('shopcart/shopcart')}}",
                            {goods_id:goods_id,_token:_token,buy_number:buy_number},
                            function(res){
                                console.log(res);
                            }
                        )
                    })


                })
            </script>
            <script type="text/javascript">
                $(function () {
                    $(".add").click(function () {
                        var t = $(this).prev();
                        t.val(parseInt(t.val()) + 1);
                        GetCount();
                    })
                    $(".min").click(function () {
                        var t = $(this).next();
                        if(t.val()>1){
                            t.val(parseInt(t.val()) - 1);
                            GetCount();
                        }
                    })
                })
            </script>
            <script>

                // 全选
                $(".quanxuan").click(function () {
                    if($(this).hasClass('current')){
                        $(this).removeClass('current');

                        $(".g-Cart-list .xuan").each(function () {
                            if ($(this).hasClass("current")) {
                                $(this).removeClass("current");
                            } else {
                                $(this).addClass("current");
                            }
                        });
                        GetCount();
                    }else{
                        $(this).addClass('current');

                        $(".g-Cart-list .xuan").each(function () {
                            $(this).addClass("current");
                            // $(this).next().css({ "background-color": "#3366cc", "color": "#ffffff" });
                        });
                        GetCount();
                    }


                });
                // 单选
                $(".g-Cart-list .xuan").click(function () {
                    if($(this).hasClass('current')){


                        $(this).removeClass('current');

                    }else{
                        $(this).addClass('current');
                    }
                    if($('.g-Cart-list .xuan.current').length==$('#cartBody li').length){
                        $('.quanxuan').addClass('current');

                    }else{
                        $('.quanxuan').removeClass('current');
                    }
                    // $("#total2").html() = GetCount($(this));
                    GetCount();
                    //alert(conts);
                });
                // 已选中的总额
                function GetCount() {
                    var conts = 0;
                    var aa = 0;
                    $(".xuan").each(function () {
                        if($(this).prop('class')=='xuan current'){
                            var buy_number=$(this).parent('li').attr('buy_number');
                            var self_price=$(this).parent('li').attr('self_price');
                            conts+=parseInt(buy_number)*parseInt(self_price);
                        }
                        $(".total").html('<span>￥</span>'+(conts).toFixed(2));
                    })
                }
                GetCount();
            </script>
    @endsection


    

