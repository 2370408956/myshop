<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>修改支付密码</title>
<meta content="app-id=984819816" name="apple-itunes-app" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('css/login.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('css/findpwd.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
<link rel="stylesheet" href="{{url('css/modipwd.css')}}">
<script src="{{url('js/jq.js')}}"></script>
</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">修改登录密码</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
</div>



    <div class="wrapper">
        <form class="layui-form" action="">
            <div class="registerCon regwrapp">
                <div class="account">
                    <em>账户名：</em> <i>155****3866</i>
                </div>
                <div><em>当前密码</em><input type="password" id="nowpwd"></div>
                <div><em>新密码</em><input id="u_pwd" type="password" placeholder="请输入6-16位数字、字母组成的新密码"></div>
                <div><em>确认新密码</em><input type="password" id="u_pwd_confirmation" placeholder="确认新密码"></div>
                <div class="save" id="save"><span>保存</span></div>
            </div>
        </form>
    </div>
<input type="hidden" value="{{csrf_token()}}" id="_token">


<script src="{{url('layui/layui.js')}}"></script>
<script>
//Demo
layui.use('form', function(){
  var form = layui.form();
  
    $("#save").click(function(){
        var nowpwd=$("#nowpwd").val();
        var u_pwd=$("#u_pwd").val();
        var _token=$("#_token").val();
        var u_pwd_confirmation=$("#u_pwd_confirmation").val();
        reg=/^.{6,}$/;
        if(nowpwd==''){
            layer.msg('原密码不能为空',{icon:2});
            return false;
        }
        if(u_pwd==''){
            layer.msg('新密码不能为空',{icon:2});
            return false;
        }else if(!reg.test(u_pwd)){
            layer.msg('密码6位以上',{icon:2});
            return false;
        }
        if(u_pwd!=u_pwd_confirmation){
            layer.msg('2次密码不一致');
            return false;
        }

        $.post(
            "{{url('login/loginpwd')}}",
            {nowpwd:nowpwd,u_pwd:u_pwd,u_pwd_confirmation:u_pwd_confirmation,_token:_token},
            function(res){
                if(res==1){
                    layer.msg('修改成功',{icon:1,time:2000},function(){
                        location.href="{{url('login/login')}}";
                    })
                }else{
                    layer.msg(res,{icon:2});
                }
            }
        )
    })

});

</script>    

</body>
</html>
    