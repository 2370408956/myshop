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
    <script src="{{url('js/jq.js')}}"></script>
</head>
<body>
<input type="button" class="layui-btn layui-btn-normal" value="一级菜单" id="btn1">
<div id="tdiv">



</div>
<input type="button" id="btn" value="提交">
{{--<input type="button" class="layui-btn layui-btn-normal" value="二级菜单" id="btn2">--}}
</body>
</html>
<script>
    $(document).on('click','#btn1',function(){
            if($('.stair').length<3){
                $('#tdiv').append('<div>\n' +
                    '        <div>\n' +
                    '                <span>一级菜单</span>\n' +
                    '                <input type="button" value="一级菜单" class="layui-btn stair">\n' +
                    '                <input type="text" name="name" class="name">\n' +
                    '                <input type="text" name="type" class="type">\n' +
                    '                <input type="text" name="key" class="key">\n' +
                    '                <input type="button" class="layui-btn layui-btn-normal btn2" value="二级菜单">\n' +
                    '        </div>\n' +
                    '    </div>');
            }else{
                alert('一级菜单最大3个');
            }

    })
    $(document).on('click','.btn2',function(){
        if($(this).parent('div').siblings('div').length<5){
            $(this).parent('div').after('<div style="margin-left:10%;margin-top: 20px;">\n' +
                '            <span>二级菜单</span>\n' +
                '            <input type="text" name="name" class="secondname">\n' +
                '            <input type="text" name="type" class="secondtype">\n' +
                '            <input type="text" name="key" class="secondkey">\n' +
                '    </div>')
        }else{
            alert('最大只能有5个二级菜单')
        }

    })

    $("#btn").click(function(){
        var str={"button":[

            ]};
        var name='';
        var type='';
        var key='';
        var secondname='';
        var secondtype='';
        var secondkey='';
        var menu=[];
        $('.stair').each(function(index){
            var name=$(this).siblings("input[class='name']").val();
            var type=$(this).siblings("input[class='type']").val();
            var key=$(this).siblings("input[class='key']").val();
            var menu1=[];
            menu1['name']=name;
            menu1['type']=name;
            menu1['key']=name;
            $('.btn2').parent('div').siblings('div').each(function(){
                var secondname=$(this).find("input[class='secondname']").val();
                var secondtype=$(this).find("input[class='secondtype']").val();
                var secondkey=$(this).find("input[class='secondkey']").val();
                var menu2=[];
                menu2['name']=secondname;
                menu2['type']=secondtype;
                menu2['key']=secondkey;

            });
            menu[index]=menu1;
            // menu.push(menu1);
        });


        // var menu=JSON.stringify(menu);
        console.log(menu);
        $.post(
            "{{url('demodo')}}",
            {data:menu,_token:'{{csrf_token()}}'},
            function(res){
                console.log(res);
            }
        )
    });


</script>