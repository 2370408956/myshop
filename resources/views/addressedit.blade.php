<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>填写收货地址</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/writeaddr.css')}}">
    {{--<link rel="stylesheet" href="{{url('layui/css/layui.css')}}">--}}
    <link rel="stylesheet" href="{{url('dist/css/LArea.css')}}">
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">填写收货地址</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="javascript:;" id="addaddress" class="m-index-icon">保存</a>
</div>
<div class=""></div>
<!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">

</form> -->
<form class="layui-form" action="">
    <div class="addrcon">
        <ul>
            <li><em>收货人</em><input type="text" id="address_name" value="{{$addressinfo->address_name}}" placeholder="请填写真实姓名"></li>
            <li><em>手机号码</em><input type="number" id="address_tel" value="{{$addressinfo->address_tel}}"  placeholder="请输入手机号"></li>
            <li>
                <em>所在区域</em>
                {{--<input  type="text" id="area"  name="input_area"   placeholder="请选择所在区域">--}}
                <select name="province" class="area" id="province">
                    <option value="">请选择省</option>
                    @foreach($area as $v)
                        @if($addressinfo['province'] ==$v['id'])
                        <option selected value="{{$v->id}}">{{$v->name}}</option>
                        @else
                        <option  value="{{$v->id}}">{{$v->name}}</option>
                        @endif
                    @endforeach
                </select>
                <select name="" id="city" class="area">
                    <option value="">请选择市</option>
                    @foreach($city as $v)
                        @if($v['id']==$addressinfo['city'])
                        <option selected value="{{$v->id}}">{{$v->name}}</option>
                        @else
                        <option  value="{{$v->id}}">{{$v->name}}</option>
                        @endif
                    @endforeach
                </select>
                <select name="" id="county" class="area">
                    <option value="">请选择县</option>
                    @foreach($county as $v)
                        @if($v['id']==$addressinfo['county'])
                            <option selected value="{{$v->id}}">{{$v->name}}</option>
                        @else
                            <option  value="{{$v->id}}">{{$v->name}}</option>
                        @endif
                    @endforeach
                </select>
            </li>
            <li class="addr-detail"><em>详细地址</em><input type="text" value="{{$addressinfo->address_area}}"  id="address_area" placeholder="20个字以内" class="addr"></li>
            <input type="hidden" value="{{$addressinfo->address_id}}" id="address_id">
        </ul>
        <div class="setnormal">
            <input type="checkbox" id="is_default">
            <span>设为默认地址</span>
            <input type="checkbox" name="xxx" lay-skin="switch">
        </div>
    </div>
    <input type="hidden" value="{{csrf_token()}}" id="_token">
</form>

<!-- SUI mobile -->
<script src="{{url('dist/js/LArea.js')}}"></script>
<script src="{{url('dist/js/LAreaData1.js')}}"></script>
<script src="{{url('dist/js/LAreaData2.js')}}"></script>
<script src="{{url('js/jq.js')}}"></script>
{{--<script src="{{url('layui/layui.js')}}"></script>--}}

<script>
    $(function(){
        // layui.use('form', function(){
        //     var form = layui.form();

            //监听提交
            // form.on('submit(formDemo)', function(data){
            //     layer.msg(JSON.stringify(data.field));
            //     return false;
            // });
            $('.area').change(function(){
                var id=$(this).val();
                var _token=$("#_token").val();
                var _option="<option value=>请选择</option>";
                var select=$(this).next('select');
                if($(this).attr('id')=='province'){
                    $("select[class='area']").last().html(_option)
                }
                $.post(
                    "{{url('address/addressarea')}}",
                    {id:id,_token:_token},
                    function(res){
                        for(var x in res){
                            _option+="<option value='"+res[x]['id']+"'>"+res[x]['name']+"</option>";
                        }
                        select.html(_option);
                    },
                    'json'
                )
            });

            //修改
        $('#addaddress').click(function(){
            var obj={};
            obj.address_name=$('#address_name').val();
            obj.address_tel=$('#address_tel').val();
            obj.province=$('#province').val();
            obj.city=$('#city').val();
            obj.county=$('#county').val();
            obj.address_area=$('#address_area').val();
            obj.is_default=$('#is_default').prop('checked');
            obj.address_id=$('#address_id').val();
            var _token=$('#_token').val()
            var reg=/^1[34578]\d{9}$/;
            if(obj.address_tel==''){
                alert('手机号必填');
                return false;
            }else if(!reg.test(obj.address_tel)){
                alert('手机号不存在');
                return false;
            }
            if(obj.address_name==''){
                alert('收货人名称必填');
                return false;
            }
            if(obj.province==''){
                alert('地址有误');
                return false;
            }
            if(obj.city==''){
                alert('地址有误')
                return false;
            }
            if(obj.county==''){
                alert('地址有误')
                return false;
            }
            if(obj.address_area==''){
                alert('详细地址必填');
                return false;
            }
            if(obj.is_default==true){
                obj.is_default=1
            }else{
                obj.is_default=2;
            }
            console.log(obj);
            $.post(
                "{{url('address/addressupdate')}}",
                {obj:obj,_token:_token},
                function(res){
                    if(res==1){
                        location.href="{{url('address/address')}}"
                    }else{
                        alert('保存失败')
                    }
                }
            )

        })
        // });
    })


    var area = new LArea();
    area.init({
        'trigger': '#demo1',//触发选择控件的文本框，同时选择完毕后name属性输出到该位置
        'valueTo':'#value1',//选择完毕后id属性输出到该位置
        'keys':{id:'id',name:'name'},//绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
        'type':1,//数据源类型
        'data':LAreaData//数据源
    });


</script>


</body>
</html>
