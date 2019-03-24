<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>地址管理</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('css/address.css')}}">
    <link rel="stylesheet" href="{{url('css/sm.css')}}">
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">




</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">地址管理</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="{{url('address/addaddress')}}" class="m-index-icon">添加</a>
</div>
<div class="addr-wrapp">
    @foreach($addressinfo as $v)
     <div class="addr-list" >
         <ul>
            <li class="clearfix">
                <span class="fl">{{$v->address_name}}</span>
                <span class="fr">{{$v->address_tel}}</span>
            </li>
            <li>
                <p>{{$v->province}}{{$v->city}}{{$v->county}} &nbsp;&nbsp;&nbsp;&nbsp;{{$v->address_area}}</p>
            </li>
             <li class="a-set" address_id="{{$v->address_id}}">
                 @if($v->is_default==1)
                 <a href="javascript:;" class="default" style="color: red">默认</a>
                 @else
                 <a href="javascript:;" class="default" >设为默认</a>
                 @endif
                 <div class="fr">
                     <span class="edit"><a href="{{url("address/addressedit/$v->address_id")}}">编辑</a></span>
                     <span class="remove">删除</span>
                 </div>
             </li>
        </ul>  
    </div>
    @endforeach
        <input type="hidden" value="{{csrf_token()}}" id="_token">
</div>


<script src="{{url('js/zepto.js')}}" charset="utf-8"></script>
<script src="{{url('js/sm.js')}}"></script>
<script src="{{url('js/sm-extend.js')}}"></script>


<!-- 单选 -->
<script src="{{url('layui/layui.js')}}"></script>

<script>
    //设为默认
    $(function(){
        layui.use('layer',function(){
            var layer=layui.layer;
            $('.default').click(function(){
                var _this=$(this);
                if(_this.text()=='设为默认'){
                    address_id=_this.parent('li').attr('address_id');
                    var _token=$('#_token').val();
                    $.post(
                        "{{url('address/adddefault')}}",
                        {address_id:address_id,_token:_token},
                        function(res){
                            history.go(0)
                        }
                    )
                }
            })


            // 删除地址
            $(document).on('click','span.remove', function () {
                var address_id=$(this).parents('li').attr('address_id');
                var _token=$('#_token').val();
                var buttons1 = [
                    {
                        text: '删除',
                        bold: true,
                        color: 'danger',
                        onClick: function() {
                            $.alert("您确定删除吗?",function(){
                                $.post(
                                    "{{url('address/addressdel')}}",
                                    {address_id:address_id,_token:_token},
                                    function(res){
                                        if(res==1){
                                            layer.msg('删除成功',{icon:1});
                                            history.go(0)
                                        }else{
                                            layer.msg('删除失败',{icon:1});
                                            history.go(0)
                                        }
                                    }
                                )
                            })
                        }
                    }
                ];
                var buttons2 = [
                    {
                        text: '取消',
                        bg: 'danger'
                    }
                ];
                var groups = [buttons1, buttons2];
                $.actions(groups);
            });

        })
    })

</script>
<script src="{{url('js/jq.js')}}"></script>
<script>
    var $$=jQuery.noConflict();
    $$(document).ready(function(){
            // jquery相关代码
            $$('.addr-list .a-set s').toggle(
            function(){
                if($$(this).hasClass('z-set')){
                    
                }else{
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }   
            },
            function(){
                if($$(this).hasClass('z-defalt')){
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }
                
            }
        )

    });
    
</script>



</body>
</html>
