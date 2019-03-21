<link href="{{url('css/login.css')}}" rel="stylesheet" type="text/css" />
@extends('public')
<!--触屏版内页头部-->
@section('body')
<div class="wrapper">
    <div class="registerCon">
        <div class="binSuccess5">
            <ul>
                <li class="accAndPwd">
                    <dl>
                        <div class="">
                            <input  type="text" id="u_name" placeholder="请输入您的手机号码/邮箱"><i></i>
                        </div>
                        <cite class="passport_set" style="display: none"></cite>
                    </dl>
                    <dl>
                        <input  type="password" id="u_pwd" placeholder="密码" value="" maxlength="20" /><b></b>
                    </dl>
                    <dl>
                        <input  type="text" id="verifier" placeholder="请输入验证码" width="100" maxlength="4" /><b></b>
                        <img id="code" name="code" src="{{url('VerifierController/verifier')}}" alt="">
                    </dl>
                </li>
            </ul>
            <a id="btnLogin" href="javascript:;" lay-filter="*"  class="orangeBtn loginBtn">登录</a>
        </div>
        <input type="hidden" value="{{csrf_token()}}" id="_token" name="_token">
        <div class="forget">
            <a href="https://m.1yyg.com/v44/passport/FindPassword.do">忘记密码？</a><b></b>
            <a href="{{url('login/register')}}">新用户注册</a>
            {{--<a href="https://m.1yyg.com/v44/passport/register.do?forward=https%3a%2f%2fm.1yyg.com%2fv44%2fmember%2f">新用户注册</a>--}}
        </div>
    </div>
    <div class="oter_operation gray9" style="display: none;">

        <p>登录666潮人购账号后，可在微信进行以下操作：</p>
        1、查看您的潮购记录、获得商品信息、余额等<br />
        2、随时掌握最新晒单、最新揭晓动态信息
    </div>
</div>
@endsection
@section('my-js')
    <script>
        $(function(){


                $('#btnLogin').click(function(){
                    var u_name=$('#u_name').val();
                    var u_pwd=$('#u_pwd').val();
                    var _token=$('#_token').val();
                    var code=$('#verifier').val();
                    $.post(
                        "{{url('login/login')}}",
                        {u_name:u_name,u_pwd:u_pwd,_token:_token,code:code},
                        function(res){
                            if(res==1){
                                location.href="{{url('/')}}"
                            }else{
                                $('#code').attr('src',"{{url('VerifierController/verifier')}}"+'?'+Math.random());
                                layer.msg(res,{icon:2})
                            }
                        }
                    )
                })

                $('#code').click(function(){
                    $(this).attr('src',"{{url('VerifierController/verifier')}}"+'?'+Math.random());
                })


                $("#navigation").css('display','none');
        })


    </script>
@endsection

