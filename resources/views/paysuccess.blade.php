@extends('public')
	<link rel="stylesheet" href="{{url('css/paysuccess.css')}}">
@section('body')
	<section>
		<div class="pay-wrapper">
			<span><i></i></span>
			<p>支付成功，请耐心等待揭晓结果！</p>
			<div class="pay-btn">
				<a href="" class="watch">查看潮购码</a>
				<a href="{{url('goods/allshops')}}">继续潮购</a>
			</div>
		</div>
		 
	</section>
	<div class="line hot">
    	<div class="hot-content">
    		<i></i>
    		<span>人气推荐</span>
    		<div class="l-left"></div>
    		<div class="l-right"></div>
    	</div>
    </div>
    <div class="goods-wrap marginB">
        <ul id="ulGoodsList" class="goods-list clearfix">
        	<li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436">
        		<a href="javascript:;" class="g-pic">
        			<img name="goodsImg" src="" width="136" height="136">
        		</a>
        		<p class="g-name">(第<em>28436</em>潮)中国黄金 财富投资金条 Au9999 5g</p>
        		<ins class="gray9">价值：￥1625.00</ins>
        		<div class="Progress-bar">
        			<p class="u-progress">
        				<span class="pgbar" style="width: 96.43076923076923%;">
        					<span class="pging"></span>
        				</span>
        			</p>

        		</div>
        		<div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
        			<a href="javascript:;" class="buy-btn" codeid="12751965">立即潮购</a>
        			<div class="gRate" codeid="12751965" canbuy="58">
        				<a href="javascript:;"></a>
        			</div>
        		</div>
        	</li>
        	<li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436">
        		<a href="javascript:;" class="g-pic">
        			<img name="goodsImg" src="https://img.1yyg.net/GoodsPic/pic-200-200/20161103170504456.jpg" width="136" height="136">
        		</a>
        		<p class="g-name">(第<em>28436</em>潮)中国黄金 财富投资金条 Au9999 5g</p>
        		<ins class="gray9">价值：￥1625.00</ins>
        		<div class="Progress-bar">
        			<p class="u-progress">
        				<span class="pgbar" style="width: 96.43076923076923%;">
        					<span class="pging"></span>
        				</span>
        			</p>

        		</div>
        		<div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
        			<a href="javascript:;" class="buy-btn" codeid="12751965">立即潮购</a>
        			<div class="gRate" codeid="12751965" canbuy="58">
        				<a href="javascript:;"></a>
        			</div>
        		</div>
        	</li>
        	<li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436">
        		<a href="javascript:;" class="g-pic">
        			<img name="goodsImg" src="https://img.1yyg.net/GoodsPic/pic-200-200/20161103170504456.jpg" width="136" height="136">
        		</a>
        		<p class="g-name">(第<em>28436</em>潮)中国黄金 财富投资金条 Au9999 5g</p>
        		<ins class="gray9">价值：￥1625.00</ins>
        		<div class="Progress-bar">
        			<p class="u-progress">
        				<span class="pgbar" style="width: 96.43076923076923%;">
        					<span class="pging"></span>
        				</span>
        			</p>

        		</div>
        		<div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
        			<a href="javascript:;" class="buy-btn" codeid="12751965">立即潮购</a>
        			<div class="gRate" codeid="12751965" canbuy="58">
        				<a href="javascript:;"></a>
        			</div>
        		</div>
        	</li>
        	<li id="23558" codeid="12751965" goodsid="23558" codeperiod="28436">
        		<a href="javascript:;" class="g-pic">
        			<img name="goodsImg" src="https://img.1yyg.net/GoodsPic/pic-200-200/20161103170504456.jpg" width="136" height="136">
        		</a>
        		<p class="g-name">(第<em>28436</em>潮)中国黄金 财富投资金条 Au9999 5g</p>
        		<ins class="gray9">价值：￥1625.00</ins>
        		<div class="Progress-bar">
        			<p class="u-progress">
        				<span class="pgbar" style="width: 96.43076923076923%;">
        					<span class="pging"></span>
        				</span>
        			</p>

        		</div>
        		<div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
        			<a href="javascript:;" class="buy-btn" codeid="12751965">立即潮购</a>
        			<div class="gRate" codeid="12751965" canbuy="58">
        				<a href="javascript:;"></a>
        			</div>
        		</div>
        	</li>
        </ul>
    </div>
@endsection
@section('my-js')
	<script>
		$('#paysuccess').attr('href','')
		$('#pay').attr('href','')
		$('#navigation').css('display','none')
	</script>
@endsection