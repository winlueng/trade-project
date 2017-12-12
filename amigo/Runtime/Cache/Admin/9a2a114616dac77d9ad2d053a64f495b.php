<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title><?php echo ($companyInfo['company_name']); ?></title>
	
<!-- default end -->
<link rel="stylesheet" href="/Public/salon/css/base.css?v=1.0" />
<link rel="stylesheet" href="/Public/salon/swiper/swiper.min.css?v=1.1" />
<link rel="stylesheet" href="/Public/salon/module/dlalert/dlalert.css?v=1.1" />
<link rel="stylesheet" href="/Public/salon/css/beautySalons.css?v=1.13" />
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/salon/jquery-1.8.2.min.js"></script>

	<style>
		body{
			
		}
	</style>
	
	<style>
		.bgGoodsDetails img {  
		 max-width: 97%; /*图片自适应宽度*/  
		}
		.bsIndex .bsGoodsPrice .other{
		    display: flex;
		    display: -webkit-flex;
		}
		.other em{
			flex-grow:1;
			-webkit-flex-grow:1;
		}
		.bsGoodsTitle{
		    text-indent: 30px;
			background-size: 38px;
			background-position-x: 5px;
		}
	</style>
	<?php  ?>

</head>
<body class="kbMt_bc-fdf7ee">
	
		<header id="bsHeader" class="bsHeader">
			<nav>
				
					<a class="icon-back" href="javascript:;" >
					</a>
				
			</nav>	
			<h1>
				
					
				
			</h1>
			<nav>
				
					<a class="icon-MoreMenu" href="javascript:;" >
					</a>
					<div class="moreMenu">
						<div class="Cover"></div>
						<div class="moreMenu-box">
							<p>
								<a href="javascript:;">
									<span class="icon-MoreIndex"></span>
									<b>首页</b>
								</a>
							</p>
							<p>
								<a href="javascript:;">
									<span class="icon-MoreMessage"></span>
									<b>消息</b>
								</a>
							</p>
						
							<!-- <p>
								<a href="javascript:;">
									<span class="icon-MoreShare"></span>
									<b>分享</b>
								</a>
							</p> -->

						</div>
					</div>
				
			</nav>
		</header>
	
	
	<section id="bsMain" class="bsIndex">
		<header id="focusWap" class="swiper-container focusWap">
		        <ul class="swiper-wrapper">
		        <?php if(is_array($info["goods_picture"])): foreach($info["goods_picture"] as $key=>$v): ?><li class="swiper-slide bc mb10 bsBanner">
		          	<a href="javascript:;">
		          		<img src="/Public<?php echo ($v); ?>" alt="大图" />
		          	</a>
		           </li><?php endforeach; endif; ?>
		        </ul>
		        <div class="swiper-pagination banner-pagination mb10"></div>
			    <script>
				    $(function(){
						var swiper = new Swiper('#focusWap', {
				            autoplay:5000,//可选选项，自动滑动
				            pagination: '.swiper-pagination',
				        });
				    })
				</script>
		</header>
		<p class="bsSeparate"></p>
		<article class="bsGoodsPrice p10 ">
			<h3 class="mb10"><?php echo ($info['goods_name']); ?></h3>
			<?php if(($info['is_promotion'] == '1') AND ($info['sales_start_time'] < time()) AND ($info['sales_end_time'] > time())): ?><p class="mb10"><b class="c00bec5 mr10">￥<?php echo ($info['promotion_price']); ?></b><em class="lineThrough">￥<?php echo ($info['price']); ?></em></p>
				<p class="mb10">距离促销结束还有: <b class="c00bec5 mr10"><?php echo turnDistanceTime($info['sales_end_time']);?></b></p>
			<?php else: ?>
				<p class="mb10"><b class="c00bec5 mr10">￥<?php echo ($info['price']); ?></b></p><?php endif; ?>
			<p class="other"><em>快递:&nbsp;&nbsp;0.00</em><em>月销:&nbsp;&nbsp;0</em><em>地点</em></p>
		</article>
		<p class="bsSeparate"></p>
		<article class="bgGoodsDetails ">
			<h1 class="pl10 pr10 bsGoodsTitle c999 mb10 icon-detail">商品详情</h1>
			<?php echo ($info['goods_title']); ?>
		</article>
		<p class="bsSeparate"></p>
		<!-- <h1 class="pl10 pr10 bsGoodsTitle c999">评价详情</h1>
		<ul class="bsGoodsReviewList p10">
			<li>
				<header class="peopleInfo mb10">
					<p>
						<img src="image/1.jpg" alt="logo" />
					</p>
					<p><b>用户名字</b></p>
				</header>
				<p class="mb10">
					用户评价用户评价用户评价用户评价用户评价用户评价用户评价用户评价用户评价用户评价用户评价用户评价
				</p>
				<p class="reviewImg mb10">
					<img src="image/1.jpg" alt="" />
				</p>
				<footer class="reviewOther">
					<p>2017-5-12</p>
					<p class="tc">颜色分类：自然色</p>
					<p class="tr">尺寸：320#</p>
				</footer>
			</li>
		</ul>
		<p class="tc bsReviewMore  pb10">
			<a class="copyBtn" href="javascript:;">查看更多评论</a>		
		</p> -->
		<p class="bsSeparate"></p>
		<article class="bsRecommendList pt10">
			<h2 class="tc pb10">为你推荐</h2>
			<ul class="bsList bsTogether bc">
			<?php if(is_array($goodsLike)): $i = 0; $__LIST__ = $goodsLike;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="bsRecommendGoods swiper-slide">
					<a href="javascript:;">
						<p>
							<img src="/Public<?php echo ($v["goods_logo"]); ?>" style="height: 100px" alt="" />
						</p>
						<h3 class="mb10 Ellipsis"><?php echo ($v["goods_name"]); ?></h3>
						<p style="padding:0 5px">
							<b>￥<?php echo ($v["price"]); ?></b>
							<em class="c00bec5 fr">销量<?php echo ($v["salesTotal"]); ?></em>
						</p>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</article>
		<p class="bsSeparate"></p>
	</section>



	
	<footer id="bsFooter" class="bsSubNav bsFooter">
		<p>
			<a href="javascript:;"></a>
			<b>客服</b>
		</p>
		<p>
			<a href="<?php echo U('Index/index', ['companyName' => $_GET['companyName']]);?>"></a>
			<b>首页</b>
		</p>
		<p>
			<a href="<?php echo U('ShoppingCart/myCart',['companyName' => $_GET['companyName']]);?>"></a>
			<b>购物车</b>
		</p>
		<p class="addShopCarBtn">
			加入购物车
		</p>
	</footer>
	

	
	<div class="Popout ShopCarPopout">
		<p class="popoutMask"></p>
		<section class="addShopCar popitMain" style="bottom:-256px">
			<button class="icon-close" type="button"></button>
			<form action="<?php echo U('ShoppingCart/insertCart', ['companyName' => $_GET['companyName']]);?>" method="post">
				<header> 
					<p>
						<img src="" alt="" />
					</p>
					<article>
						<h3 class="mb10 c666">商品名字商品名字商品名字</h3>
						<p class="f18">￥99</p>
					</article>
				</header>
				<article class="mb10">
					<input type="hidden" value="1" name="goods_id" required="required"/>
					<p class="mb10 c666 attrName"><b >规格选择</b></p>
					<div class="classfiyChoose">
						
					</div>
				</article>
				<article class="mb20">
					<b class="c666 mb10	">数量选择</b>
					<p class="changeNumber">
						<input class="min" type="button" value="-"/>
						<input class="goodsNum" min="1"   type="number" value="1" name="total" />
						<input class="add" type="button" value="+"/>
					</p>
				</article>
				<footer>
					<input class="defineBtn btnColor00bec5 f16" type="submit" value="确定" />
				</footer>
			</form>
		</section>
		<script>
			$(function(){
				$('.Popout .icon-close,.Popout .popoutMask').on('click',function(){
					$('.Popout').fadeOut();
					$('.ShopCarPopout').find('.addShopCar').css('bottom','-256px');
				})
				$('.changeNumber .min').on('click',function(){
					var $this=$(this),
						goodsNum=$this.siblings('.goodsNum'),
						num=parseInt(goodsNum.val());
						if(goodsNum.val()!=1){
							goodsNum.val(num-=1)
						}
				})
				$('.changeNumber .add').on('click',function(){
					var $this=$(this),
						goodsNum=$this.siblings('.goodsNum'),	
						num=parseInt(goodsNum.val());
						goodsNum.val(num+=1)
						
				})
				$('.changeNumber .goodsNum').on('input propertychange',function(){
					var $this=$(this);
					console.log($this.val());
					
					if($this.val()<1){
						$this.val(1);
					}else if($this.val()>999){
						$this.val(999);
					}
				})
			})
		</script>
	</div>

	<script src="/Public/salon/swiper/swiper.jquery.min.js"></script>
<script src="/Public/salon/module/dlalert/dlalertNew.js"></script>
<script src="/Public/salon/beautySalong.js"></script>
<script src="/Public/JS/module/vue/vue.js"></script>
<script>
	wx.config({
      	debug: false,
      	appId: "<?php echo ($jssdk["appId"]); ?>",
      	timestamp: "<?php echo ($jssdk["timestamp"]); ?>",
      	nonceStr:  "<?php echo ($jssdk["nonceStr"]); ?>",
      	signature: "<?php echo ($jssdk["signature"]); ?>",
      	jsApiList: [
        	'checkJsApi',
        	'onMenuShareTimeline',
        	'onMenuShareAppMessage',
        	'onMenuShareQQ',
        	'onMenuShareWeibo',
        	'onMenuShareQZone',
        	'hideMenuItems',
        	'showMenuItems',
        	'hideAllNonBaseMenuItem',
        	'showAllNonBaseMenuItem',
        	'translateVoice',
        	'startRecord',
        	'stopRecord',
        	'onVoiceRecordEnd',
        	'playVoice',
        	'onVoicePlayEnd',
        	'pauseVoice',
        	'stopVoice',
        	'uploadVoice',
        	'downloadVoice',
        	'chooseImage',
        	'previewImage',
        	'uploadImage',
        	'downloadImage',
        	'getNetworkType',
        	'openLocation',
        	'getLocation',
        	'hideOptionMenu',
        	'showOptionMenu',
        	'closeWindow',
        	'scanQRCode',
        	'chooseWXPay',
        	'openProductSpecificView',
        	'addCard',
        	'chooseCard',
        	'openCard'
      	]
  	});
   
</script>
	<script>
		$(function(){
			$('.icon-MoreMenu,.Cover').on('click',function(){
				$('.moreMenu').fadeToggle();
			})
		})
	</script>
	
	<script>
		$(function(){
			$('.icon-collect').prev().on('click',function(){
				/*
					flag: collectGoods
					goods_id:int (商品id)
					status: 1/2  (  1:收藏 ,  2:取消收藏 )
				*/
				var $this=$(this),
					status=($this.prop('checked'))? 1:2;
				$.get('<?php echo U("Goods/ajaxControl");?>',{
					flag:'collectGoods',
					goods_id:"<?php echo ($_GET['id']); ?>",
					companyName:"<?php echo ($_GET['companyName']); ?>",
					status:status
				},function(res){
					if(res){
						sTip('操作成功');
					}else{
						eTip('操作失败');
						 $this.attr("checked",false);
					}
					console.log(res);
				})				

			})
		})
		

		$(function(){
			var url = "<?php echo U('Goods/ajaxControl');?>";
			var name = "<?php echo ($_GET['companyName']); ?>";
			$('.addShopCarBtn').on('click',function(){
				$('.ShopCarPopout').fadeIn();
				$('.ShopCarPopout').find('.addShopCar').attr('style','');
				$('.ShopCarPopout input[type="submit"]').on('click',function(){
					var classfiyChoose=$('.classfiyChoose').find('.choose input[type=radio]');
					var status=Object.keys(classfiyChoose).filter(function(elem){
							return $(classfiyChoose[elem]).prop('checked')==true;
						})
					if(status.length<=0){
						eTip("请选择属性");
						return false;
					}

				})
			})
			console.log(<?php echo ($attr); ?>)
			$('.addShopCarBtn').on('click',function () {
				var data = {
					flag:'getAttr',
					id:"<?php echo ($_GET['id']); ?>",
					companyName:name
				}
				$.get(url,data,function info(res){
					
					$('.addShopCar header p img').attr('src', '/Public'+res.Info['goods_logo']);
					$('.addShopCar header article h3').text(res.Info['goods_name']);
					$('.addShopCar header article p').text('￥' + res.Info['true_price']);
					$('.addShopCar article input[type="hidden"]').val(res.Info['id']);
					var str = '';
					var attr = res.goodsAttr;
					$('.attrName b').text(attr[0].attr_name+':');
					for(var k in attr){
						var status=attr[k].inventory_total<=0? 'disabled=true':'' 
						str += '<p class="choose mr10">'
							+'<input type="radio" value="'+ attr[k].id +'" name="attribute_id" required="required" '+status+' />'
							+'<label class="roundBtn">'+ attr[k].attr_val+'</label>'
							+'<input type="hidden" class="attrPic" value="'+ attr[k].attr_pic +'"/>'
							+'<input type="hidden" class="attrPrice" value="'+ attr[k].attr_price +'"/>'
							+'</p>';

					}
					$('.classfiyChoose').html(str);
				});
			})

			$('.choose').live('click', function(){
				var pic = $(this).children('.attrPic').val();
				var price = $(this).children('.attrPrice').val();
				console.log(pic);
				$('.addShopCar header p img').attr('src', '/Public'+$(this).children('input[type="hidden"]').val());
				if (price != '0.00') {
					$('.addShopCar header article p').text('￥' + price);
				}
			});
		});
	</script>

</body>
</html>