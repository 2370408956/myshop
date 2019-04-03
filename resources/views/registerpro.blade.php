 <link href="{{url('css/login.css')}}" rel="stylesheet" type="text/css" />
@extends('public')
@section('body')
    @if($errors->any())
        @foreach($errors->all() as $v)
            {{$v}}
        @endforeach
    @endif
    <div class="m-block-header" id="div-header" style="display: none">
        <strong id="m-title"></strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <div class="wrapper">
        <input name="hidForward" type="hidden" id="hidForward" value="https://m.1yyg.com/v44/member/" />
        <div class="registerCon">
            <ul>
                <li class="accAndPwd">
                    <dl>
                        <input id="userMobile" maxlength="11" type="tel" placeholder="请输入您的手机号码" value="" />
                    </dl>
                </li>
                <li class="accAndPwd">
                    <input type="text" id="code" placeholder="请输入验证码" value=""/>
                    <a href="javascript:void(0);" id="createcode" style="float: right" class="sendcode" id="btn">获取验证码</a>
                </li>
                <li class="accAndPwd">
                    <input type="text" id="u_pwd" placeholder="请输入密码" value=""/>
                </li>
                <li class="accAndPwd">
                    <input type="text" id="u_pwd_confirmation" placeholder="请确认密码" value=""/>
                </li>
                <li style="padding: 10px">
                    <a id="btnNext" href="javascript:;" class="orangeBtn loginBtn">注册</a>
                </li>
                <li>
                    <span id="isCheck"><em></em>我已阅读并同意</span>
                    <a href="terms.do" class="blue">1元云购用户服务协议</a>
                </li>
            </ul>
        </div>
        <input type="hidden" id="_token" value="{{csrf_token()}}">
        <input id="hidPageType" type="hidden" value="-1" />
        <input id="hidIsHttps" type="hidden" value="1" />
        <input id="hidSiteVer" type="hidden" value="v51" />
        <input id="hidWxDomain" type="hidden" value="https://m.1yyg.com" />
        <input id="hidOpenID" type="hidden" value=""/>

        <div style="display: none;">
            <script type="text/javascript" language="JavaScript" src="https://s22.cnzz.com/stat.php?id=3362429&web_id=3362429"></script>
        </div>
    </div>
@endsection
<!--触屏版内页头部-->

@section('my-js')
    <script>
        $(function(){
            $('#userMobile').blur(function(){
                var tel=$('#userMobile').val();
                reg=/^1[34578]\d{9}$/;//验证手机正则(输入前7位至11位)
                if(tel==''){
                    layer.msg('手机号不能为空',{icon:2});
                    return false;
                }else if(!reg.test(tel)){
                    layer.msg('您输入的手机号不存在!',{icon:2});
                    return false;
                }
            })
            $('#createcode').click(function(){
                var tel=$('#userMobile').val();
                reg=/^1[34578]\d{9}$/;//验证手机正则(输入前7位至11位)

                if(tel==''){
                    layer.msg('手机号不能为空',{icon:2});
                    return false;
                }else if(!reg.test(tel)){
                    layer.msg('您输入的手机号不存在!',{icon:2});
                    return false;
                }else{
                    var _token=$('#_token').val();
                    $.post(
                        "{{url('login/sendcode')}}",
                        {mobile:tel,_token:_token},
                        function(res){
                            console.log(res);
                        }
                    )
                }
            })
            function registertel(){
                // 手机号失去焦点

                // 密码失去焦点
                $('#u_pwd').blur(function(){
                    reg=/^[0-9a-zA-Z]{6,16}$/;
                    var that = $(this);
                    if( that.val()==""|| that.val()=="6-16位数字或字母组成")
                    {
                        layer.msg('请设置您的密码！');
                        return false;
                    }else if(!reg.test($(".pwd").val())){
                        layer.msg('请输入6-16位数字或字母组成的密码!');
                        return false;
                    }
                })

                // 重复输入密码失去焦点时
                $('#u_pwd_confirmation').blur(function(){
                    var that = $(this);
                    var pwd1 = $('#u_pwd').val();
                    var pwd2 = that.val();
                    if(pwd1!=pwd2){
                        layer.msg('您俩次输入的密码不一致哦！');
                        return false;
                    }
                })

            }
            registertel();
            // 购物协议
            $('dl.a-set i').click(function(){
                var that= $(this);
                if(that.hasClass('gou')){
                    that.removeClass('gou').addClass('none');
                    $('#btnNext').css('background','#ddd');

                }else{
                    that.removeClass('none').addClass('gou');
                    $('#btnNext').css('background','#f22f2f');
                }

            })

            //下一步
            $('#btnNext').click(function(){
                var tel=$('#userMobile').val();
                var code=$('#code').val();
                var u_pwd=$('#u_pwd').val();
                var u_pwd_confirmation=$('#u_pwd_confirmation').val();
                var _token=$('#_token').val();
                var reg=/^.{6,}$/;
                if(tel==''){
                    layer.msg('账号不能为空',{icon:2});
                    return false;
                }
                if(code==''){
                    layer.msg('验证码不能为空',{icon:2});
                    return false;
                }
                if(u_pwd==''){
                    layer.msg('密码不能为空',{icon:2});
                    return false;
                }else if(!reg.test(u_pwd)){
                    layer.msg('密码应6位以上',{icon:2});
                    return false;
                }
                if(u_pwd_confirmation==''){
                    layer.msg('确认密码不能为空',{icon:2});
                    return false;
                }else if(u_pwd!=u_pwd_confirmation){
                    layer.msg('2次密码不一致',{icon:2});
                    return false;
                }

                $.post(
                    "{{url('login/registerdo')}}",
                    {u_name:tel,code:code,u_pwd:u_pwd,u_pwd_confirmation:u_pwd_confirmation,_token:_token},
                    function(res){
                        if(res==1){
                            location.href="{{url('/')}}"
                        }else{
                            layer.msg(res,{icon:2});
                        }
                    }
                )

            })
            if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
                document.getElementById('div-header').style.display = 'block';
            }
            document.getElementById('m-title').innerText = document.title;
        })
    </script>
    <script type="text/html" id="vcCodeHtmlSectionTmpl">
        <section class="vc-wrapper" style="display: block; height: 226px;">
            <div class="vc-btn-container" id="dragBtnContainer" style="display: block;">
                <div class="vc-slide-text" style="display: block;"><span>请按住滑块，拖动到最右边</span></div>
                <div class="vc-slideBtnLeft" id="dragBtnLeft" style="width: 0;">
                    <span class="canvas-Title" style="display: none;">请点击图中的“<strong id="selectedChar"></strong>”字</span>
                </div>
                <div class="vc-slideBtn ui-draggable ui-draggable-handle" id="dragBtn" style="left: 0; top: 0px; float: left;"><i class="passport-icon ready-status"></i></div>
            </div>
            <div class="canvas-wrapper" style="">
                <div class="canvas-container" id="canvasContainer" style="height: 138px;">
                    <img id="vcCanvas" class="vc-canvas" src="" alt="">
                </div>
                <div class="canvas-foot">
                    <div class="fl">
                        <p class="tips" id="vcCodeTips"></p>
                    </div>
                    <div class="fr btn" style="display: none;" id="vcCodeRefresh">刷新</div>
                </div>
            </div>
            <div class="vc-close-btn"></div>
        </section>
    </script>
    <script type="text/javascript">
        var Base = {
            head: document.getElementsByTagName("head")[0] || document.documentElement,
            Myload: function (B, A) {
                this.done = false;
                B.onload = B.onreadystatechange = function () {
                    if (!this.done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                        this.done = true;
                        A();
                        B.onload = B.onreadystatechange = null;
                        if (this.head && B.parentNode) {
                            this.head.removeChild(B)
                        }
                    }
                }
            },
            getScript: function (A, C) {
                var B = function () { };
                if (C != undefined) {
                    B = C;
                }
                var D = document.createElement("script");
                D.setAttribute("language", "javascript");
                D.setAttribute("type", "text/javascript");
                D.setAttribute("src", A);
                this.head.appendChild(D);
                this.Myload(D, B);
            },
            getStyle: function (A, C) {
                var B = function () { };
                if (C != undefined) {
                    B = C;
                }
                var C = document.createElement("link");
                C.setAttribute("type", "text/css");
                C.setAttribute("rel", "stylesheet");
                C.setAttribute("href", A);
                this.head.appendChild(C);
                this.Myload(C, B);
            }
        }
        function GetVerNum() {
            var D = new Date();
            return D.getFullYear().toString().substring(2, 4) + '.' + (D.getMonth() + 1) + '.' + D.getDate() + '.' + D.getHours() + '.' + (D.getMinutes() < 10 ? '0' : D.getMinutes().toString().substring(0, 1));
        }
        $(document).ready(function () {
            var _SkinDomain = $("#hidIsHttps").val() == "1" ? "https://skin.1yyg.net" : "https://skin.1yyg.net";
            Base.getScript(_SkinDomain+'/v51/weixin/JS/Bottom.js?v=' + GetVerNum(), function () {
                var _pagetype = $("#hidPageType").val();
                var _footer = $("div.footer");
                var _cartpay = $("#mycartpay");
                var _cartlist = 0;//$("li", "#cartBody");
                var _saysome = $("div.saysome");
                var _curpage = window.location.href.toLowerCase();

                var _ishide = false;
                if (_cartpay.length > 0 && _cartlist.length > 0) {
                    _footer = _cartpay;
                    _pagetype = "1";
                    _ishide = true;
                }
                else if (_saysome.length > 0)
                {
                    _footer = _saysome;
                    _pagetype = "1";
                }
                //弹出输入法是否隐藏底部导航
                if (_curpage.indexOf('/member/recharge.do')>0 || _curpage.indexOf('/member/goodsbuydetail-')>0)
                {
                    _ishide = true;
                }

                var _hh = parseInt($(window).height());
                var _ww=$(window).width();
                if (_pagetype != "-1" && _footer.length>0) {
                    var SetFooterPos = function () {
                        var j = 0;
                        var _setObj;
                        _setObj = setInterval(function (){
                            var _hh1 = parseInt($(window).height());
                            var _hh2 = _hh - _hh1;

                            if (_hh1 > 200) {
                                if (_hh2 > 0) {
                                    if (parseInt($(window).width()) != parseInt(_ww)) {
                                        _footer.css("bottom", 0).show();
                                    }
                                }
                                else {
                                    _footer.css("bottom", 0).show();
                                }
                                j++;
                                //$("#mycarttest").html(_hh1 + "||" + _hh2 + "||" + $(window).width());
                                if (j == 3) {
                                    clearInterval(_setObj);
                                }
                            }
                        }, 100);
                    }

                    SetFooterPos();

                    window.onresize = function () {
                        if (_ishide) {
                            _footer.hide();
                        }
                        SetFooterPos();
                    };
                }
            });
        });
    </script>
@endsection








