<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{url('js/jq.js')}}"></script>
</head>
<body>
    <table>
        <tr>
            <td>账号</td>
            <td><input type="text" id="user_name"></td>
        </tr>
        <tr>
            <td>验证码</td>
            <td>
                <input type="text" id="_code">
                <input type="button" id="code" value="获取验证码">
            </td>
        </tr>
        <tr>
            <td>网名</td>
            <td><input type="text" id="username"></td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" id="user_pwd"></td>
        </tr>
        <tr>
            <td>确认密码</td>
            <td><input type="password" id="user_pwd1"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" id="btn" value="立即注册"></td>
        </tr>
    </table>
</body>
</html>
<script>
    $(function(){
        $('#code').click(function(){
            var user_name=$('#user_name').val();
            var reg=/^\d{6,}@qq.com$/;
            if(user_name==''){
                alert('账号不能为空');
                return false;
            }else if(!reg.test(user_name)){
                alert('手机号不存在')
                return false;
            }
            $.get(
                "{{url('sendcode')}}",
                {user_name:user_name},
                function(res){
                    if(res==1){
                        alert('发送成功');
                    }else{
                        alert('发送失败')
                    }
                }
            )
        })

        //点击提交
        $('#btn').click(function(){
            var user_name=$('#user_name').val();
            var reg=/^\d{6,}@qq.com$/;
            if(user_name==''){
                alert('账号不能为空');
                return false;
            }else if(!reg.test(user_name)){
                alert('手机号不存在');
                return false;
            }

            var _code=$("#_code").val();
            if(_code==''){
                alert('验证码不能为空');
                return false;
            }
            var username=$("#username").val();
            if(username==''){
                alert('网名不能为空');
                return false;
            }
            var user_pwd=$('#user_pwd').val();
            if(user_pwd==''){
                alert('密码不能为空')
            }
            var user_pwd1=$("#user_pwd1").val();
            if(user_pwd1!=user_pwd){
                alert('2次密码不一致');
            }

            $.post(
                "{{url('useradd')}}",
                {user_pwd1:user_pwd1,user_name:user_name,_code:_code,username:username,user_pwd:user_pwd,_token:'{{csrf_token()}}'},
                function(res){
                    if(res==1){
                        alert('注册成功');
                        location.href="{{url('login')}}";
                    }else{
                        // alert(res);
                    }
                }
            )
        })
    })
</script>