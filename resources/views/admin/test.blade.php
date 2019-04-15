<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>会员管理-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <link rel="stylesheet" type="text/css" href="css/manhuaDate.1.0.css">
    <script type="text/javascript" src="{{url('js/jq.js')}}"></script>
    {{--<script type="text/javascript" src="js/manhuaDate.1.0.js"></script>--}}
    {{--<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>--}}
    <!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>
<style>
    .button{
        margin-left: 10px;
        width: 135px;
        height: 30px;
        border: none;
        font-size: 16px;
        color: #fff;
        background-color: #47a4e1;
    }
</style>

<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
                        href="#">公共管理</a>&nbsp;-</span>&nbsp;意见管理
        </div>
    </div>

    <div class="page">
        <!-- vip页面样式 -->
        <div class="vip">
            <div class="conform">
                <div>
                    <div style="line-height: 30px;float:left;" class="second">
                        一级按钮
                    </div>
                    <div class="cfD">

                        <select name="type"  style="width:150px;height:30px;margin-right:15px;color:#000000;" onchange='change($(this))'>
                            <option value="click">点击按钮</option>
                            <option value="view">跳转按钮</option>
                        </select>
                        <input class="addUser" name="name" type="text" placeholder="输入按钮名称" />
                        <input type="text" class="addUser" name="key_url" placeholder="请输入key值" style="margin-left:15px;">
                        <button class="button" name="clone" onclick="add($(this))">克隆</button>
                        <button class="button" name="del" onclick="less($(this))">删除</button>
                        <button class="button" name="addSecond" onclick="addSecond($(this))">添加二级菜单</button>

                    </div>
                </div>

                <button class="button" name="submit" style="margin-top:20px;margin-left:450px;">提交</button>
            </div>


        </div>
        <!-- vip页面样式end -->
    </div>

</div>


</body>

</html>
<script>
    //克隆
    function add(obj) {
        var _this=obj;
        if($.trim(_this.parent().prev('.second').text())=='一级按钮'){
            if($(".cfD").length==3){
                alert('只能克隆两个一级按钮！');
                return false;
            }
        }
        var cFd=_this.parent().html();
        if($.trim(_this.parent().prev('.second').text())=='一级按钮') {
            $(".cfD").first().parent().before("<div style='line-height: 30px;float:left;' class='second'>一级按钮</div><div class='cfD'>" + cFd + "</div>");
        }
    }
    //删除
    function less(obj){
        var _this=obj;
        if($.trim(_this.parent().prev('.second').text())=='一级按钮') {
            if($(".cfD").length==1) {
                alert('不能再删除了！');
                return false;
            }
            _this.parent().prev('.second').remove()
            _this.parent().remove();
        }else{
            var input="<input type='text' class='addUser' name='key_url' placeholder='请输入key值' style='margin-left:15px;'>";
            if(_this.parent().parent().find('.second_show').length==1){
                _this.parent().parent().find("[name='addSecond']").prev().prev().before(input);
                _this.parent().parent().find('[name=type]').html('<option value="click">点击按钮</option><option value="view">跳转按钮</option>')
            }
            _this.parent().remove();
        }


    }
    //添加二级菜单
    function addSecond(obj){
        var _this=obj;
        if(_this.parent().find('.second_show').length==5){
            alert('只能添加五个二级菜单！');
            return false;
        }
        var cFd="<select onchange='change($(this))' name=\"type\" style=\"width:150px;height:30px;margin-right:15px;color:#000000;\">\n" +
            "                                <option value=\"click\">点击按钮</option>\n" +
            "                                <option value=\"view\">跳转按钮</option>\n" +
            "                            </select>\n" +
            "                            <input class=\"addUser\" name=\"name\" type=\"text\" placeholder=\"输入按钮名称\">\n" +
            "                            <input type=\"text\" class=\"addUser\" name=\"key_url\" placeholder=\"请输入key值\" style=\"margin-left:15px;\">\n" +
            "                            <button class=\"button\" name=\"del\" onclick=\"less($(this))\">删除</button>";
        _this.after("<div class='second_show' style='margin-left:56px;margin-top:10px;'>"+cFd+"</div>");
        if(_this.prev().prev().prev().prop('name')=='key_url'){
            _this.prev().prev().prev().remove();
        }
        _this.prev().prev().prev().prev().html('<option value="click">点击按钮</option>')
    }
    //下拉菜单值改变
    function change(obj){
        var _this=obj;
        console.log(_this.next().next());
        var type=_this.val();
        if(type=='click'){
            _this.next().next().prop('placeholder',"请输入key值");
        }else if(type=='view'){
            _this.next().next().prop('placeholder',"请输入url值");
        }
    }

    $(function(){
        //提交
        $("[name='submit']").click(function(){
            // alert(111);
            var _length=$(".cfD").length;
            var type=[];
            var name=[];
            var key_url=[];
            var second_type=[];
            var second_name=[];
            var second_key_url=[];
            var __length=[];
            for(var i=0;i<_length;i++){
                __length[i]=$('.cfD').eq(i).find('.second_show').length;
                $.each($('.cfD').eq(i).find('.second_show'),function(ii,v){
                    second_type.push($(this).find('[name=type]').val());
                    second_name.push($(this).find('[name=name]').val());
                    second_key_url.push($(this).find('[name=key_url]').val());
                });
                type.push($('.cfD').eq(i).find('[name=type]').eq(0).val());
                name.push($('.cfD').eq(i).find('[name=name]').eq(0).val());
                key_url.push($('.cfD').eq(i).find('[name=key_url]').eq(0).val());
            }
            var data={};
            data.type=type;
            data.name=name;
            data.key_url=key_url;
            data.second_type=second_type;
            data.second_name=second_name;
            data.second_key_url=second_key_url;
            data.length=__length;
            console.log(data);
            //
        });

    })

</script>