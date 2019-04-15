<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{url('xadmin/lib/layui/layui.js')}}"></script>
    <link rel="stylesheet" href="{{url('xadmin/lib/layui/css/layui.css')}}">
    <script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
    <title>菜单添加</title>
</head>
<body>
<div style="padding: 15px;">
    <div class="tbo">
        <div class="stair">
            <select name="" id="">
                <option value="click">点击</option>
                <option value="view">跳转</option>
            </select>
            <input type="text">
            <input type="text">
            <input type="button" class="layui-btn btn1" value="添加一级菜单">
            <input type="button" class="layui-btn del" value="删除">
            <input type="button" class="layui-btn btn2" value="添加二级菜单">
        </div>
    </div>
</div>
<input type="button" class="layui-btn btn1" id="btn" value="立即提交">
</body>
</html>
<script>
    $(document).on('click','.btn2',function(){
        var num=$(this).parent().siblings('div').length;
        if(num>=5){
            alert('最大5个');
            return false;
        }
        $(this).parent().after('<div style="margin-left: 10%" class="second">\n' +
            '            <select name="" id="">\n' +
            '                <option value="click">点击</option>\n' +
            '                <option value="view">跳转</option>\n' +
            '            </select>\n' +
            '            <input type="text">\n' +
            '            <input type="text">\n' +
            '            <input type="button" class="layui-btn del1" value="删除">\n' +
            '        </div>');
    })


    $(document).on('click','.btn1',function(){
        var num=$(this).parents("div[class='tbo']").siblings().length;
        if(num>=2){
            alert('一级菜单最大3个');
            return false;
        }
        $(this).parents("div[class='tbo']").after('<div class="tbo">\n' +
            '        <div>\n' +
            '            <select name="" id="">\n' +
            '                <option value="click">点击</option>\n' +
            '                <option value="view">跳转</option>\n' +
            '            </select>\n' +
            '            <input type="text">\n' +
            '            <input type="text">\n' +
            '            <input type="button" class="layui-btn btn1" value="添加一级菜单">\n' +
            '            <input type="button" class="layui-btn del" value="删除">\n' +
            '            <input type="button" class="layui-btn btn2" value="添加二级菜单">\n' +
            '        </div>\n' +
            '    </div>');
    })

    // $("#btn").
</script>