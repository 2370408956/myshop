<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
</head>
<body>
<div style="padding: 30px;width: 600px">
<form class="layui-form" action="{{url('wechat/updo')}}" method="post" enctype="multipart/form-data">
    @csrf
<div class="layui-form-item">
    <label class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="material_title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">上传</label>
    <div class="layui-input-block">
        <input type="file" name="file">
    </div>
</div>

<div class="layui-form-item layui-form-text">
    <label class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">链接</label>
    <div class="layui-input-block">
        <input type="text" name="url" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
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
<script src="{{url('layui/layui.js')}}"></script>
<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;

    });
</script>
