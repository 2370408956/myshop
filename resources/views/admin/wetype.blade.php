<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('xadmin/lib/layui/css/layui.css')}}">
    <script src="{{url('xadmin/lib/layui/layui.js')}}"></script>
    <script src="{{url('js/jq.js')}}"></script>
</head>
<body>
<form action="" class="layui-form" >
    <div style="padding: 40px;width: 600px;">
        <div class="layui-form-item">
            <label class="layui-form-label">请选择回复类型</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="text" title="文本" checked>
                <input type="radio" name="sex" value="image" title="图片">
                <input type="radio" name="sex" value="video" title="视频">
                <input type="radio" name="sex" value="voice" title="语言">
                <input type="radio" name="sex" value="news" title="图文">
            </div>

        </div>
        <input type="button" id="btn" value="立即更改" style="margin-left: 400px;" class="layui-btn layui-btn-normal">
    </div>
</form>
</body>
</html>
<script>
    $(function(){
        $("input[type='radio']").each(function(){
           var type=$(this).val();
           var _type='{{$type}}';
           // console.log(_type);
           if(type == _type){
               $(this).attr('checked',true);
           }
       })
    });
    layui.use('form', function(){
        var form = layui.form;
        var layer =layui.layer;
        $("#btn").click(function(){
            var radio=$("input[type='radio']:checked");
            var type=radio.val();
            var title=radio.attr('title');
            layer.confirm('是否要修改'+title+'类型的', {icon: 3, title:'提示'}, function(index){
                //do something
                $.post(
                    "/admin/wetypedo",
                    {type:type,_token:'{{csrf_token()}}'},
                    function(res){
                        if(res){
                            layer.msg('修改成功',{icon:1});
                        }else{
                            layer.msg('修改失败，请重试',{icon:2});
                        }
                    }
                )
                layer.close(index);
            });

        })
    })
</script>