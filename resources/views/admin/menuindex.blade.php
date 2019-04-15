<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>菜单添加</title>
    <script src="{{url('xadmin/lib/layui/layui.js')}}"></script>
    <link rel="stylesheet" href="{{url('xadmin/lib/layui/css/layui.css')}}">
    <script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
</head>
<body>
<a href="{{url('admin/menuindexadd')}}" style="margin-left: 550px;margin-top: 20px;">
    <input type="button" value="添加菜单" class="layui-btn">
</a>
<div style="padding: 20px;width: 600px;">
    @foreach($data as $v)
            <div class="layui-form-item">
                <label class="layui-form-label">一级菜单</label>
                <div class="layui-input-block">
                    <input type="text" name="name" required   value="{{$v->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$v->type}}" autocomplete="off" class="layui-input stair">
                    <input type="hidden" value="{{$v->m_id}}">
                </div>
            </div>
    @endforeach
</div>
<input type="button" value="立即启用" class="layui-btn" id="btn" style="margin-left: 50px;" >
</body>
</html>
<script>
    $(function(){
        $('.stair').each(function(){
            var m_id=$(this).next().val();
            var _this=$(this);
            $.post(
                "{{url('admin/menuinfo')}}",
                {m_id:m_id,_token:'{{csrf_token()}}'},
                function(res){
                    var str='';
                    for(var i in res){
                        str+='<div class="layui-form-item" style="margin-left: 10%;">\n' +
                            '        <label class="layui-form-label">二级菜单</label>\n' +
                            '        <div class="layui-input-block">\n' +
                            '            <input type="text" name="name" required   value="'+res[i]['name']+'" autocomplete="off" class="layui-input stair">\n' +
                            '            <input type="hidden" value="'+res[i]['m_id']+'">\n' +
                            '        </div>\n' +
                            '    </div>';
                    }
                    _this.parents("div[class='layui-form-item']").after(str);
                },
                'json'
            )
        })

        $('#btn').click(function(){
            $.ajax({
                url:"{{url('admin/menuadddo')}}",
                async:true,
                success:function(res){
                    console.log(res);
                }
            })
        })
    })
</script>