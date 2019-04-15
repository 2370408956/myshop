<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{url('xadmin/lib/layui/layui.js')}}"></script>
    <link rel="stylesheet" href="{{url('xadmin/lib/layui/css/layui.css')}}">
    <script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
</head>
<body>
<div style="padding: 40px;width: 600px;">
    <form class="layui-form" action="{{url('admin/menuindexado')}}" method="post">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">请输入名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" required   placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择框</label>
            <div class="layui-input-block">
                <select name="pid" lay-verify="required">
                    <option value="0">一级菜单</option>
                    @foreach($info as $v)
                        <option value="{{$v->m_id}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">学择类型</label>
            <div class="layui-input-block">
                <select name="type">
                    <option value="">请选择</option>
                    <option value="click">点击</option>
                    <option value="view">跳转</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">请输入key或url</label>
            <div class="layui-input-block">
                <input type="text" name="key" required   placeholder="请输入key或url" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;

        form.on('submit(formDemo)', function(data){
            console.log(data.field);
            $.post(
                "{{url('admin/menuindexado')}}",
                data.field,
                function(res){
                    layer.msg(res,{icon:1});
                }
            )
            return false;
        });
    });
</script>