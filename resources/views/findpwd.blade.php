<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>找回密码</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('css/login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('css/find.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">找回密码</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="home-icon"></i></a>
</div>

<div class="wrapper">
    <div class="registerCon">
        <div class="binSuccess5">
            <ul>
                <li class="accAndPwd">
                    <dl class="phone">
                        <div class="txtAccount">
                            <input id="txtAccount" type="text" placeholder="请输入您的手机号"><i></i>
                            <a href="javascript:void(0);" class="sendcode" id="btn">获取验证码</a>
                        </div>
                        <cite class="passport_set" style="display: none"></cite>
                    </dl>
                    <dl>
                        <input id="txtPassword" type="password" placeholder="请输入验证码" value="" maxlength="20" /><b></b>
                    </dl>
                </li>
            </ul>
            <a id="btnLogin" href="javascript:;" class="orangeBtn loginBtn">下一步</a>
            <input type="hidden" value="{{csrf_token()}}" id="_token">
        </div>
    </div>
</div>
</body>
</html>
<script src="{{url('js/jq.js')}}"></script>
<script src="{{url('layui/layui.js')}}"></script>
<script>
    $(function(){
        layui.use('layer',function(){
            $('#btn').click(function(){
                var tel=$('#txtAccount').val();
                reg=/^1[34578]\d{9}$/;
                if(tel==''){
                    layer.msg('手机号不能为空',{icon:2});
                    return false;
                }else if(!reg.test(tel)){
                    layer.msg('手机号不存在',{icon:2});
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

            $('#btnLogin').click(function(){
                reg=/^1[34578]\d{9}$/;
                var tel=$('#txtAccount').val();
                if(tel==''){
                    layer.msg('手机号不能为空',{icon:2});
                    return false;
                }else if(!reg.test(tel)){
                    layer.msg('手机号不存在',{icon:2});
                    return false;
                }
                var code=$('#txtPassword').val();
                if(code==''){
                    layer.msg('验证码不能为空',{icon:2});
                    return false;
                }

                $.get(
                    "{{url('login/next')}}",
                    {tel:tel,code:code},
                    function(res){
                        if(res==1){
                            layer.msg('稍等,正在跳转',{icon:1,time:1000},function(){
                                location.href="{{url('login/loginpwd')}}"
                            });
                        }else{
                            layer.msg('验证码或手机错误',{icon:2});
                        }
                    }
                )
            })
        })

    })
</script>
