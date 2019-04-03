@extends('public')
@section('body')
    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header" style="display: none">
        <strong id="m-title"></strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>

    <div class="pro-s-box thin-bor-bottom" id="divSearch">
        <div class="box">
            <div class="border">
                <div class="border-inner"></div>
            </div>
            <div class="input-box">
                <i class="s-icon"></i>
                <input type="text" placeholder="输入“汽车”试试" id="txtSearch" />
                <i class="c-icon" id="btnClearInput" style="display: none"></i>
            </div>
        </div>
        <a href="javascript:;" class="s-btn" id="btnSearch">搜索</a>
    </div>

    <!--搜索时显示的模块-->
    <div class="search-info" style="display: none;">
        <div class="hot">
            <p class="title">热门搜索</p>
            <ul id="ulSearchHot" class="hot-list clearfix"><li wd='iPhone'><a class="items">iPhone</a></li><li wd='三星'><a class="items">三星</a></li><li wd='小米'><a class="items">小米</a></li><li wd='黄金'><a class="items">黄金</a></li><li wd='汽车'><a class="items">汽车</a></li><li wd='电脑'><a class="items">电脑</a></li></ul>
        </div>
        <div class="history" style="display: none">
            <p class="title">历史记录</p>
            <div class="his-inner" id="divSearchHotHistory">
                <ul class="his-list thin-bor-top">
                    <li wd="小米移动电源" class="thin-bor-bottom"><a class="items">小米移动电源</a></li>
                    <li wd="苹果6" class="thin-bor-bottom"><a class="items">苹果6</a></li>
                    <li wd="苹果电脑" class="thin-bor-bottom"><a class="items">苹果电脑</a></li>
                </ul>
                <div class="cle-cord thin-bor-bottom" id="btnClear">清空历史记录</div>
            </div>
        </div>
    </div>

    <div class="all-list-wrapper">
        <div class="menu-list-wrapper" id="divSortList">
            <ul id="sortListUl" class="list">
                @if($cate_id=='')
                <li sortid='0' class='current'><a href="{{url('goods/allshops')}}" style="color: #0C0C0C"><span class='items'>全部商品</span></a></li>
                @else
                    <li sortid='0' ><a href="{{url('goods/allshops')}}" style="color: #0C0C0C"><span class='items'>全部商品</span></a></li>
                @endif
                @foreach($cateinfo as $v)
                    @if($cate_id ==$v->cate_id)
                        <li sortid='100' class="cate current" cate_id="{{$v->cate_id}}" reletype='1' linkaddr=''>
                            <span class='items'>{{substr($v->cate_name,0,12)}}</span>
                        </li>
                    @else
                        <li sortid='100' class="cate" cate_id="{{$v->cate_id}}" reletype='1' linkaddr=''>
                            <span class='items'>{{substr($v->cate_name,0,12)}}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="good-list-wrapper">
            <div class="good-menu thin-bor-bottom">
                <ul class="good-menu-list" id="ulOrderBy">
                    <li orderflag="10" class="nav current" type="1">
                        <a href="javascript:;">
                            默认
                        </a>
                    </li>
                    <li orderflag="20" class="nav" type="2">
                        <a href="javascript:;">
                            人气
                        </a>
                    </li>
                    <li orderflag="30" class="nav" type="3">
                        <a href="javascript:;">
                            <span>价值</span>
                            <span id="nav">↑</span>
                        </a>
                    </li>
                    <!--价值(由高到低30,由低到高31)-->
                </ul>
            </div>

            <input type="hidden" value="{{csrf_token()}}" id="_token" name="_token">
            <div class="good-list-inner">
                <div id="pullrefresh" class="good-list-box  mui-content mui-scroll-wrapper">
                    <div class="goodList mui-scroll">
                        <ul id="ulGoodsList" class="mui-table-view mui-table-view-chevron">
                            @foreach($goodsinfo as $v)
                            <li id="23468" goods_id="{{$v->goods_id}}">
                                    <span class="gList_l fl">
                                        <a href="{{url("goods/shopcontent/$v->goods_id")}}">
                                        <img class="lazy" src="/images/{{$v->goods_img}}">
                                        </a>
                                    </span>
                                <div class="gList_r">
                                    <a href="{{url("goods/shopcontent/$v->goods_id")}}">
                                    <h3 class="gray6">{{$v->goods_name}}</h3>
                                    </a>
                                    <em class="gray9">价值：￥{{$v->self_price}}</em>
                                    <div class="gRate">
                                        <div class="Progress-bar">
                                            <p class="u-progress">
                                                    <span style="width: 91.91286930395593%;" class="pgbar">
                                                        <span class="pging"></span>
                                                    </span>
                                            </p>
                                            <ul class="Pro-bar-li">
                                                <li class="P-bar01"><em>{{$v->buy_num}}</em>已购买</li>
                                                {{--<li class="P-bar02"><em>7988</em>总需人次</li>--}}
                                                <li class="P-bar03"><em>{{$v->goods_num}}</em>剩余</li>
                                            </ul>
                                        </div>
                                        <a codeid="12785750" class="addcart" canbuy="646"><s></s></a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

<script src="js/mui.min.js"></script>
@section('my-js')
<script>
        $(function(){
            //分类
            $('.cate').click(function(){
                var _this=$(this);
                var cate_id=_this.attr('cate_id');
                $(this).addClass('current').siblings('li').removeClass('current');
                $('.nav').removeClass('current').first().addClass('current');
                $('#txtSearch').val('');
                goodsinfo();
            });

            //导航
            $('.nav').click(function(){
                var _this=$(this);
                $(this).addClass('current').siblings('li').removeClass('current');
                var nav=_this.find('span').last().text();
                if(nav=='↑'){
                    _this.find('span').last().text('↓')
                }else{
                    _this.find('span').last().text('↑')
                }
                goodsinfo();
            });

            $('#txtSearch').blur(function(){
                goodsinfo();
            })
            function goodsinfo(){
                var nav=$("li[class='nav current']").attr('type');
                var search=$('#txtSearch').val();
                var cate_id=$("li[class='cate current']").attr('cate_id');
                if(nav==1){
                    nav=1;
                }else if(nav==2){
                    nav=2;
                }else if(nav==3){
                    if($('#nav').text()=='↑'){
                        nav=3;
                    }else{
                        nav=4;
                    }
                }
                $.get(
                    "{{url('goods/goodsinfo')}}",
                    {cate_id:cate_id,nav:nav,search:search},
                    function(res){
                        $('#ulGoodsList').html(res)
                    }
                )
            }

            //添加购物车
            $(document).on('click','.addcart',function(){
                var _this=$(this);
                var goods_id=_this.parents('li').attr('goods_id');
                var _token=$('#_token').val();
                $.post(
                    "{{url('shopcart/shopcart')}}",
                    {goods_id:goods_id,_token:_token},
                    function(res){
                        if(res==1){
                            layer.msg('添加成功',{icon:1});
                        }else{
                            layer.msg('添加失败',{icon:2});
                        }
                    }
                )
            })
        })

        jQuery(document).ready(function() {
            $("img.lazy").lazyload({
                placeholder : "images/loading2.gif",
                effect: "fadeIn",
            });
        });

        mui.init({
            pullRefresh: {
                container: '#pullrefresh',
                down: {
                    contentdown : "下拉可以刷新",//可选，在下拉可刷新状态时，下拉刷新控件上显示的标题内容
                    contentover : "释放立即刷新",//可选，在释放可刷新状态时，下拉刷新控件上显示的标题内容
                    contentrefresh : "正在刷新...",
                    callback: pulldownRefresh
                },
                up: {
                    contentrefresh: '正在加载...',
                    callback: pullupRefresh
                }
            }
        });
        /**
         * 下拉刷新具体业务实现
         */
        function pulldownRefresh() {
            setTimeout(function() {
                var table = document.body.querySelector('.mui-table-view');
                var cells = document.body.querySelectorAll('.mui-table-view-cell');
                for (var i = cells.length, len = i + 3; i < len; i++) {
                    var li = document.createElement('li');
                    var str='';
                    // li.className = 'mui-table-view-cell';
                    str += '<span class="gList_l fl">';
                    str += '<img class="lazy" data-original="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" src="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" style="display: block;"/>';
                    str += '</span>';
                    str += '<div class="gList_r">';
                    str += '<h3 class="gray6">(第'+i+'云)苹果（Apple）iPhone 7 Plus 256G版 4G手机</h3>';
                    str += '<em class="gray9">价值：￥7988.00</em>';
                    str += '<div class="gRate">';
                    str += '<div class="Progress-bar">'
                    str += '<p class="u-progress">';
                    str += '<span style="width: 91.91286930395593%;" class="pgbar">';
                    str += '<span class="pging"></span>';
                    str += '</span>';
                    str += '</p>';
                    str += '<ul class="Pro-bar-li">';
                    str += '<li class="P-bar01"><em>7342</em>已参与</li>';
                    str += '<li class="P-bar02"><em>7988</em>总需人次</li>';
                    str += '<li class="P-bar03"><em>646</em>剩余</li>';
                    str += '</ul>';
                    str += '</div>';
                    str += '<a codeid="12785750" class="" canbuy="646"><s></s></a>';
                    str += '</div>';
                    str += '</div>';
                    //下拉刷新，新纪录插到最前面；
                    li.innerHTML = str;
                    table.insertBefore(li, table.firstChild);
                }
                mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
            }, 1500);
        }
        var count = 0;
        /**
         * 上拉加载具体业务实现
         */
        function pullupRefresh() {
            setTimeout(function() {
                mui('#pullrefresh').pullRefresh().endPullupToRefresh((++count > 2)); //参数为true代表没有更多数据了。
                var table = document.body.querySelector('.mui-table-view');
                var cells = document.body.querySelectorAll('.mui-table-view-cell');
                for (var i = cells.length, len = i + 20; i < len; i++) {
                    var li = document.createElement('li');
                    // li.className = 'mui-table-view-cell';
                    var str='';
                    str += '<span class="gList_l fl">';
                    str += '<img class="lazy" data-original="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" src="https://img.1yyg.net/GoodsPic/pic-200-200/20160908104402359.jpg" style="display: block;"/>';
                    str += '</span>';
                    str += '<div class="gList_r">';
                    str += '<h3 class="gray6">(第'+i+'云)苹果（Apple）iPhone 7 Plus 256G版 4G手机</h3>';
                    str += '<em class="gray9">价值：￥7988.00</em>';
                    str += '<div class="gRate">';
                    str += '<div class="Progress-bar">'
                    str += '<p class="u-progress">';
                    str += '<span style="width: 91.91286930395593%;" class="pgbar">';
                    str += '<span class="pging"></span>';
                    str += '</span>';
                    str += '</p>';
                    str += '<ul class="Pro-bar-li">';
                    str += '<li class="P-bar01"><em>7342</em>已参与</li>';
                    str += '<li class="P-bar02"><em>7988</em>总需人次</li>';
                    str += '<li class="P-bar03"><em>646</em>剩余</li>';
                    str += '</ul>';
                    str += '</div>';
                    str += '<a codeid="12785750" class="" canbuy="646"><s></s></a>';
                    str += '</div>';
                    str += '</div>';
                    li.innerHTML = str;
                    table.appendChild(li);
                }
            }, 1500);
        }
        // if (mui.os.plus) {
        //     mui.plusReady(function() {
        //         setTimeout(function() {
        //             mui('#pullrefresh').pullRefresh().pullupLoading();
        //         }, 1000);

        //     });
        // }
        // else {
        //     mui.ready(function() {
        //         mui('#pullrefresh').pullRefresh().pullupLoading();
        //     });
        // }



    
</script>
@endsection


