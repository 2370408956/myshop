{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
    {{--<meta charset="UTF-8">--}}
    {{--<meta name="viewport"--}}
          {{--content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
    {{--<title>Document</title>--}}
    {{--<style>--}}
        {{--li{float: left;list-style: none;margin-left: 2%}--}}
    {{--</style>--}}
    {{--<script src="{{url('js/jq.js')}}"></script>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div id="content">--}}
    {{--<input type="text" id="search" value="{{$search}}"><input type="button" id="btn" value="搜索">--}}
    {{--@foreach($data as $v)--}}
        {{--<p>{{$v->goods_name}}</p>--}}
    {{--@endforeach--}}
    {{--{{$data->appends(['search'=>$search])->links()}}--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}
{{--<script>--}}
    {{--$(function () {--}}
        {{--$("#btn").click(function(){--}}
            {{--var search=$("#search").val();--}}
            {{--$.ajax({--}}
                {{--url:"/demo/index",--}}
                {{--data:{search:search,_token:'{{csrf_token()}}'},--}}
                {{--type:'post',--}}
                {{--success:function (res) {--}}
                    {{--$("#content").html(res);--}}
                {{--}--}}
            {{--})--}}
        {{--})--}}
    {{--})--}}
{{--</script>--}}

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h1 {
            font-family:"微软雅黑";
            font-size:40px;
            margin:20px 0;
            border-bottom:solid 1px #ccc;
            padding-bottom:20px;
            letter-spacing:2px;
        }
        .time-item strong {
            background:#C71C60;
            color:#fff;
            line-height:49px;
            font-size:36px;
            font-family:Arial;
            padding:0 10px;
            margin-right:10px;
            border-radius:5px;
            box-shadow:1px 1px 3px rgba(0,0,0,0.2);
        }
        #day_show {
            float:left;
            line-height:49px;
            color:#c71c60;
            font-size:32px;
            margin:0 10px;
            font-family:Arial,Helvetica,sans-serif;
        }
        .item-title .unit {
            background:none;
            line-height:49px;
            font-size:24px;
            padding:0 10px;
            float:left;
        }
    </style>
</head>
<body>
<h1>网页上的倒计时</h1>
<div class="time-item">
    <span id="day_show">1天</span>
    <strong id="hour_show">10时</strong>
    <strong id="minute_show">34分</strong>
    <strong id="second_show">0秒</strong>
</div>
</body>
</html>
<script src="{{url('js/jq.js')}}"></script>
<script type="text/javascript">
    var intDiff = parseInt(60);//倒计时总秒数量
    function timer(intDiff){
        window.setInterval(function(){
            var day=0,
                hour=0,
                minute=0,
                second=0;//时间默认值
            if(intDiff > 0){
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#day_show').html(day+"天");
            $('#hour_show').html('<s id="h"></s>'+hour+'时');
            $('#minute_show').html('<s></s>'+minute+'分');
            $('#second_show').html('<s></s>'+second+'秒');
            intDiff--;
        }, 1000);
    }
    $(function(){
        timer(intDiff);
    });
</script>
