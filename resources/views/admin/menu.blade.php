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
    <style>
        input[type='text']{
            margin-left: 10px;
            display: inline-block;
            width: 215px;
            padding: 10px 0 10px 15px;
            font-family: "Open Sans", sans;
            font-weight: 400;
            color: #377D6A;
            background: #efefef;
            border: 0;
            border-radius: 3px;
            outline: 0;
            text-indent: 70px; // Arbitrary.
        transition: all .3s ease-in-out;
        }
        input[type='button']{
            margin-left: 12px;
        }
        select{
            position:relative;
            width:100px;
            height:25px;
            background:#ffffff;
            border-radius: 5px;
            box-shadow:1px 1px 5px #169BD5;
            display:inline-block;
            text-decoration: none;
        }
    </style>
</head>
<body>
{{--<input type="button" class="layui-btn layui-btn-normal" value="一级菜单" id="btn1">--}}
<div id="tdiv" style="margin-left: 5%;">
    @if(!empty($data))
    @foreach($data as $k=>$v)
        {{--{{print_r($v)}}--}}
        @if(empty($v['sub_button']))
            <div style="margin-top: 20px;">
                <div class="stair">
                    <select name="type" class="check" >
                        <option value="1" selected>点击按钮</option>
                        <option value="2">跳转按钮</option>
                    </select>
                    <input type="text" class="text layui-input" value="{{$v['name']}}">
                    @if($v['type']=='view')
                        <input type="text" class="key"  value="{{$v['url']}}">
                        @else
                        <input type="text" class="key"  value="{{$v['key']}}">
                        @endif
                    <input type="button" class="layui-btn layui-btn-normal btn1" value="一级菜单">
                    <input type="button" class="layui-btn layui-btn-normal del" value="删除">
                    <input type="button" class="layui-btn layui-btn-normal btn2" value="二级菜单">
                </div>
            </div>
        @else
            <div style="margin-top: 20px;">
                <div class="stair" style="margin-top: 20px;">
                    <select name="type" class="check" >
                        <option value="1">点击按钮</option>
                        <option value="2">跳转按钮</option>
                    </select>
                    <input type="text" class="text" value="{{$v['name']}}">
                    <input type="button" class="layui-btn layui-btn-normal btn1" value="一级菜单">
                    <input type="button" class="layui-btn layui-btn-normal del" value="删除">
                    <input type="button" class="layui-btn layui-btn-normal btn2" value="二级菜单">
                </div>
                @foreach($v['sub_button'] as $key=>$val)
                <div style="margin-top: 20px;" class="second">
                    <select name="second_type" class="check" >
                        @if($val['type']=='click')
                            <option value="1" selected>点击按钮</option>
                            <option value="2">跳转按钮</option>
                        @else
                            <option value="1">点击按钮</option>
                            <option value="2" selected>跳转按钮</option>
                        @endif
                    </select>
                    <input type="text" class="secondname" value="{{$val['name']}}">
                    @if($val['type']=='view')
                        <input type="text" class="secondkey"  value="{{$val['url']}}">
                    @else
                        <input type="text" class="secondkey"  value="{{$val['key']}}">
                    @endif
                    <input type="button" class="layui-btn layui-btn-normal del1" value="删除">
                </div>
                @endforeach
            </div>
        @endif
    @endforeach
    @else
    <div>
        <div class="stair" style="margin-top: 20px;">
            <select name="type" class="check" >
                <option value="1">点击按钮</option>
                <option value="2">跳转按钮</option>
            </select>
            <input type="text" class="text" placeholder="请输入名字">
            <input type="text" class="key" placeholder="请输入key">
            <input type="button" class="layui-btn layui-btn-normal btn1" value="一级菜单">
            <input type="button" class="layui-btn layui-btn-normal del" value="删除">
            <input type="button" class="layui-btn layui-btn-normal btn2" value="二级菜单">
        </div>
    </div>
    @endif

</div>
@if($is_start==1)
    <input type="button" id="btn" value="已启用" class="layui-btn layui-btn-normal" style="width:120px;margin-left: 55px;margin-top: 30px;">
@else
    <input type="button" id="btn" value="未启用" class="layui-btn layui-btn-normal" style="width:120px;margin-left: 55px;margin-top: 30px;">
@endif
{{--<input type="button" class="layui-btn layui-btn-normal" value="二级菜单" id="btn2">--}}
</body>
</html>
<script>
    //添加一级菜单
    $(document).on('click','.btn1',function(){
        if($('.btn1').length<3){
            // var _clone=$(this).parent().parent().clone();
            $('#tdiv').append('<div>\n' +
                '        <div  class="stair" style="margin-top: 20px;">\n' +
                '        <select name="type" class="check" >\n' +
                '            <option value="1">点击按钮</option>\n' +
                '            <option value="2">跳转按钮</option>\n' +
                '        </select>\n' +
                '        <input type="text" class="text" placeholder="请输入名字">\n' +
                '        <input type="text" class="key" placeholder="请输入key">\n' +
                '        <input type="button" class="layui-btn layui-btn-normal btn1" value="一级菜单">\n' +
                '        <input type="button" class="layui-btn layui-btn-normal del" value="删除">\n' +
                '        <input type="button" class="layui-btn layui-btn-normal btn2" value="二级菜单">\n' +
                '        </div>\n' +
                '    </div>');
        }else{
            alert('一级菜单最大3个');
        }

    })
    //删除一级菜单
    $(document).on('click','.del',function () {
        // console.log($('.btn1').length);
        if($('.btn1').length>1){
            $(this).parents("div[class='stair']").parent().remove();
        }else{
            var _this=$(this).prev("input[type='button']");
            _input(_this);
            $(this).parent().siblings('div').remove();
        }
    });
    //不全文本
    function _input(_this){
        var _key=_this.parent().find("input[class='key']").length;
        // console.log(_key);
        if(_key<1){
            _this.before(' <input type="text" class="key" placeholder="请输入url">');
        }

    }
    //删除二级
    $(document).on('click','.del1',function () {
        if($('.second').length==1){
            var _this=$(this).parent('div').prev('div').find("input[type='button']").first();
            console.log(_this);
            _input(_this);
        }
        $(this).parent().remove();
    });
    //添加二级
    $(document).on('click','.btn2',function(){
        if($(this).parent('div').siblings('div').length<5){
            $(this).siblings("input[class='key']").remove();
            var _second=$('#second').clone();
            $(this).parent('div').after('<div style="margin-top: 20px;" class="second">\n' +
                '        <select name="second_type" class="check" >\n' +
                '            <option value="1">点击按钮</option>\n' +
                '            <option value="2">跳转按钮</option>\n' +
                '        </select>\n' +
                '        <input type="text" class="secondname" placeholder="请输入名字">\n' +
                '        <input type="text" class="secondkey" placeholder="请输入key">\n' +
                '        <input type="button" class="layui-btn layui-btn-normal del1" value="删除">\n' +
                '    </div>');
        }else{
            alert('最大只能有5个二级菜单')
        }

    });

    //修改
    $(document).on('change','.check',function(){
        var _type=$(this).val();
        if(_type==1){
            $(this).siblings('input').eq(1).attr('placeholder','请输入key');
        }else if(_type==2){
            $(this).siblings('input').eq(1).attr('placeholder','请输入url');
        }
        console.log(_type);
    });
layui.use('layer',function(){
    var layer=layui.layer;
    $("#btn").click(function(){
        var _btn=$(this).val();
        if(_btn=='已启用'){
            layer.msg('已经启用了，不需要再启用了',{icon:1});
            return false;
        }else{
            layer.confirm('确定要启用吗', {icon: 3, title:'提示'}, function(index){
                //do something
                var data=[];
                $('.stair').each(function(i,v){
                    var sub_button=[];
                    var aa=[];
                    var _stair={};
                    _stair.name=$(this).find('[class=text]').val();
                    var _type=$(this).find('[name=type]').val();
                    var sonnum=$(this).siblings('div').length;
                    if(sonnum==0){
                        if(_type==1){
                            _stair.type='click';
                            _stair.key=$(this).find('[class=key]').val();
                        }else{
                            _stair.type='view';
                            _stair.url=$(this).find('[class=key]').val();
                        }
                    }
                    $(this).siblings('div').each(function(ii,vv){
                        var sub_button1={};
                        var __type=$(this).find('[name=second_type]').val();
                        if(__type==1){
                            sub_button1.type='click';
                            sub_button1.key=$(this).find('[class=secondkey]').val();
                        }else{
                            sub_button1.type='view';
                            sub_button1.url=$(this).find('[class=secondkey]').val();
                        }
                        sub_button1.name=$(this).find('[class=secondname]').val();
                        sub_button[ii]=sub_button1;
                    });
                    _stair.sub_button=sub_button;
                    data[i]=_stair;
                });
                var button={};
                button.button=data;
                $.post(
                    "{{url('admin/addmenudo')}}",
                    {data:button,_token:'{{csrf_token()}}'},
                    function (res) {
                        console.log(res);
                    }
                )
                layer.close(index);

            });
        }
    });

})



</script>