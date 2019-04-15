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
<div style="margin-top: 40px;width: 600px;">
<form action="{{url('admin/indexdo')}}" method="post" enctype="multipart/form-data" class="layui-form">
    @csrf
    <div class="layui-form-item" id="type">
        <label class="layui-form-label">下拉选择框</label>
        <div class="layui-input-block">
            <select name="type" lay-filter="aihao">
                <option value="text">文本</option>
                <option value="image">图片</option>
                <option value="video">视频</option>
                <option value="voice">录音</option>
                <option value="news">图文</option>
            </select>
        </div>
    </div>
    <div id="tbd">
        <div class="layui-form-item layui-form-text text">
                    <label class="layui-form-label">请输入文本</label>
                    <div class="layui-input-block">
                            <textarea name="title" placeholder="请输入内容" class="layui-textarea"></textarea>
                    </div>
        </div>
    </div>



    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="submit" value="立即提交"  class="layui-btn" >
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
</div>
</body>

</html>
<script>
    $(function(){
        layui.use(['form','layer'],function(){
            var form=layui.form;
            var layer=layui.layer;
            form.on('select(aihao)', function(data){
                var _type=data.value; //得到被选中的值
                if(_type=='text'){
                    var str='<div class="layui-form-item layui-form-text text">\n' +
                        '        <label class="layui-form-label">请输入文本</label>\n' +
                        '        <div class="layui-input-block">\n' +
                        '            <textarea name="title" placeholder="请输入内容" class="layui-textarea"></textarea>\n' +
                        '        </div>\n' +
                        '    </div>';
                    $('#tbd').html(str);
                }else if (_type=='news'){
                    var str='<div class="layui-form-item">\n' +
                        '            <label class="layui-form-label">标题</label>\n' +
                        '            <div class="layui-input-block">\n' +
                        '                <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="layui-form-item">\n' +
                        '            <label class="layui-form-label">简介</label>\n' +
                        '            <div class="layui-input-block">\n' +
                        '                <input type="text" name="intro" required  lay-verify="required" placeholder="请输入简介" autocomplete="off" class="layui-input">\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="layui-form-item">\n' +
                        '            <label class="layui-form-label">上传文件</label>\n' +
                        '            <div class="layui-input-block">\n' +
                        '                <input type="file" name="file">\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="layui-form-item">\n' +
                        '            <label class="layui-form-label">网站url</label>\n' +
                        '            <div class="layui-input-block">\n' +
                        '                <input type="text" name="s_url" required  lay-verify="required" placeholder="请输入网站链接" autocomplete="off" class="layui-input">\n' +
                        '            </div>\n' +
                        '        </div>';
                    $("#tbd").html(str);
                }else{
                    str='<div class="layui-form-item layui-form-text image" >\n' +
                        '        <label class="layui-form-label">上传文件</label>\n' +
                        '        <div class="layui-input-block">\n' +
                        '            <input type="file"  name="file">\n' +
                        '        </div>\n' +
                        '    </div>';
                    $("#tbd").html(str);
                }

            });
        })
    })
</script>