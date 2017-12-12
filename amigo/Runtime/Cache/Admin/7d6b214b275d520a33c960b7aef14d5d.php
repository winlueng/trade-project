<?php if (!defined('THINK_PATH')) exit(); $moduleList = showModuleList(); $navList = showNavList(); $ip = get_client_ip(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title>管理后台</title>
	<!-- default end -->
<link rel="stylesheet" href="/Public/CSS/common.css">

<link rel="stylesheet" href="/Public/Portal/PortalJS/alert/companyalert.css?version=4">

<link rel="stylesheet" href="/Public/JS/module/jedate/skin/jedate.css"></link>
<link rel="stylesheet" href="/Public/Portal/PortalCSS/mbase.special.css"></link>
<link rel="stylesheet" href="/Public/Portal/PortalCSS/Portal.css">


<script type="text/javascript" src="/Public/JS/jquery-1.8.2.min.js"></script>


	

<style>
	.RefundsBtnOrder{
		width:50%;
	}
	.RefundsBtn_opt li:nth-child(2){
	display:none;
	}
</style>

</head>
<body>
	<div id="kbVipAdmin_header" class="bg_main color_last kbVipAdmin_header">
		<h2>
			<span class="kbVipAdmin_logo mr10  imgH100">
				
			</span>
			<?php echo ($userInfo['market_name']); ?>后台管理系统
		</h2>
		<nav class="kbVipAdmin_header_nav ft">
		<?php if(is_array($moduleList)): foreach($moduleList as $key=>$v): ?><a class="<?php echo ($_GET['module']==$v['id']?'selected':''); ?>" href="<?php echo U('', ['module' => $v['id']]);?>"><?php echo ($v["module_name"]); ?></a><?php endforeach; endif; ?>
		</nav>
		<div class="header_Fun tr   h25 lh200 fr">
			<div class="kbVipAdmin_systemInfo">
				<a href="javascript:;"><img src="/Public/Business/BusinessImages/nav_icon_mail_default.svg" alt="系统消息" />
				<?php if(array_sum($orderConut) > 0): ?><strong class="redInfoCount"><?php echo array_sum($orderConut);?></strong><?php endif; ?>
				</a>
				<dl>
					<dt>系统消息</dt>
					<?php if($orderConut[0] > 0): ?><dd>
							<a href="<?php echo U('OrderForm/projectOrderList',['status' => 2,'module' => 5]);?>">	
								您有<?php echo ($orderConut[0]); ?>张新订单待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[1] > 0): ?><dd>
							<a href="<?php echo U('SubscribeOrderForm/orderList',['status' => 1,'module' => 5]);?>">	
								您有<?php echo ($orderConut[1]); ?>张新预约订单待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[2] > 0): ?><dd>
							<a href="<?php echo U('WechatRefund/orderListByProject',['status' => 1,'module' => 5]);?>">	
								您有<?php echo ($orderConut[2]); ?>张自营退款待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[3] > 0): ?><dd>
							<a href="<?php echo U('WechatRefund/companyOrderListByProject',['status' => 1,'module' => 5]);?>">	
								您有<?php echo ($orderConut[3]); ?>张商盟退款待处理,请前往处理
							</a>
						</dd><?php endif; ?>
				</dl>
			</div>


			<div class="kbVipAdmin_shopInfo ml30">
				<a href="javascript:;" ><img src="/Public/Business/BusinessImages/nav_icon_person_default.svg" alt="商户资料" /><span><?php echo ($_SESSION['marketInfo']['user_name']); ?></span></a>
					<dl>
						<dt><?php echo ($_SESSION['marketInfo']['user_name']); echo ($_SESSION['adminInfo']['user_name']); ?></dt>
						<!-- <dd><a href="javascript:;">商户资料</a></dd> -->
						<dd><a href="<?php echo U('Login/logout');?>">退出</a></dd>
					</dl>
				
			</div>
		</div>

		
	</div>
	<nav id="kbVipAdmin_leftNav" class="bg_main color_last">
		<ul >
			<?php if(is_array($navList)): foreach($navList as $key=>$v): ?><li>
				<?php if($v['rules']): ?><a href="javascript:;" class="special"><?php echo ($v["parent_name"]["alias"]); ?></a>
				<!-- 子菜单 -->
					<ul>
					<?php if(is_array($v["rules"])): foreach($v["rules"] as $key=>$vo): ?><li>
							<a active="<?php echo U($vo['name']);?>" href="<?php echo U($vo['name'],[module=>$_GET['module']]);?>"><?php echo ($vo["alias"]); ?></a>
						</li><?php endforeach; endif; ?>
					</ul>
				<?php else: ?>
					<a active="<?php echo U($v['parent_name']['name']);?>" href="<?php echo U($v['parent_name']['name'],[module=>$_GET['module']]);?>"><?php echo ($v["parent_name"]["alias"]); ?></a><?php endif; ?>
			</li><?php endforeach; endif; ?>	
		</ul>
	</nav>
	

<!-- 主内容 -->
	<div id="kbVipAdmin_rightCenter" class="spAnProductList">
		<!-- 内容标题部 -->
		<div class="centerTitle">
			<h1>
				<a class="goback mr10" href="javascript:history.back(-1)" ><img src="/Public/Business/BusinessImages/back.png"></a>
				<b>订单详情</b>
			</h1>
		</div>
		
		<!-- 内容标题部结束 -->
		<!-- 内容表格部 -->
		
		<section class="orderDetail" >
			<article class="gSeparated">	
				<p>原订单编号：<?php echo ($info["orderInfo"]["order_number"]); ?></p>
				<p>退款订单编号：<?php echo ($info["out_refund_no"]); ?></p>
				<p>交易时间：<?php echo date('Y年m月d日 H:i:s', $info['orderInfo']['create_time']);?></p>
				<?php switch($info["status"]): case "0": ?><p><b>订单状态: </b><b>申请退款</b></p><?php break;?>
					<?php case "1": ?><p><b>订单状态: </b><b style="font-size: 20px;color: red">已退款</b></p><?php break;?>
					<?php case "2": ?><p><b>订单状态: </b><b style="font-size: 20px;color: red">拒绝退款</b></p><?php break; endswitch;?>
			</article>
			<h2>商品信息</h2>
			<?php if(is_array($info["orderInfo"]["goods_data"])): $i = 0; $__LIST__ = $info["orderInfo"]["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><article class="goodsDetails">
					<p><img src="/Public<?php echo ($v["goodsAttr"]["attr_pic"]); ?>"  alt=""/></p>
					<aside>
						<p><?php echo ($v["goodsInfo"]); ?></p>
						<p><?php echo ($v["goodsAttr"]["attr_name"]); ?>:<?php echo ($v["goodsAttr"]["attr_val"]); ?></p>
						<p>￥<?php echo ($v["price"]); ?></p>
						<p>数量：X<?php echo ($v["total"]); ?></p>
					</aside>
				</article>
				<p class="gSeparated mb10"></p><?php endforeach; endif; else: echo "" ;endif; ?>
			<h2>费用信息</h2>	
			<article>
				<p>商品金额:<?php echo ($info["orderInfo"]["total"]); ?>元</p>
				<p>运费:<?php echo ($info["orderInfo"]["express_price"]); ?>元</p>
				<p>总计:<?php echo ($info["orderInfo"]["wechat_total"]); ?>元</p>
			</article>
			<h2>买家信息</h2>	
			<article >
				<p><b>买家呢称:<?php echo ($info["visitor_name"]); ?></b></p>
				<p><b>收货人:<?php echo ($info["orderInfo"]["address_id"]["consignee"]); ?></b></p>
				<p><b>收件人电话:<?php echo ($info["orderInfo"]["address_id"]["phone"]); ?></b></p>
				<p><b>收货地址:<?php echo ($info["orderInfo"]["address_id"]["address_str"]); ?></b></p>
			</article>
			<?php switch($info["status"]): case "0": ?><article >
						<p><b style="font-size: 15px; color: #5885cf">退款原因:&nbsp;&nbsp;&nbsp;</b><b style="font-size: 18px; color: #ee903c"><?php echo ($info["refund_remark"]); ?></b></p>
					</article><?php break;?>
				<?php case "1": ?><article >
						<p><b style="font-size: 15px; color: #5885cf">退款原因:&nbsp;&nbsp;&nbsp;</b><b style="font-size: 18px; color: #ee903c"><?php echo ($info["refund_remark"]); ?></b></p>
					</article>
					<article >
						<p><b style="font-size: 15px; color: #5885cf">同意退款备注:&nbsp;&nbsp;&nbsp;</b><b style="font-size: 18px; color: #ee903c"><?php echo ($info["admin_remark"]); ?></b></p>
					</article><?php break;?>
				<?php case "2": ?><article >
						<p><b style="font-size: 15px; color: #5885cf">退款原因:&nbsp;&nbsp;&nbsp;</b><b style="font-size: 18px; color: #ee903c"><?php echo ($info["refund_remark"]); ?></b></p>
					</article>
					<article >
						<p><b style="font-size: 15px; color: #5885cf">拒绝退款备注:&nbsp;&nbsp;&nbsp;</b><b style="font-size: 18px; color: #ee903c"><?php echo ($info["admin_remark"]); ?></b></p>
					</article><?php break; endswitch;?>
			<p class="tc">
			<input class="kbVipAdmin_opt w80 h30"" type="button" onclick="javascript:history.back(-1)" value="返回" />
			<?php switch($info["status"]): case "0": ?><input class="kbVipAdmin_opt w80 h30 RefundsBtn" type="button" value="退款操作" /><?php break;?>
					<?php case "1": ?><input class="kbVipAdmin_opt w80 h30" type="button" value="已退款" /><?php break;?>
					<?php case "2": ?><input class="kbVipAdmin_opt w80 h30" type="button" value="已拒绝" /><?php break; endswitch;?>
			</p>
		</section>
		<!-- 主体内容部分end -->
		<div class="kbVipAdmin_alert showExpressInfo RefundsBtn_alert">
			<div class="kbVipAdmin_alertBox ">
				<button type="button" class="kbVipAdmin_alert-close "></button>
				<h3 class="mb10">退款</h3>
				<form action="<?php echo U('wxRefund', ['id' => I('get.id')]);?>" method="post">
						<!-- <article class="RefundsBtnOrder bc">
							<h4>交易信息</h4>
							<p>微信支付单号：12321323123123213</p>
							<p>商品订单号：12321323123123213</p>
							<p>订单金额：122</p>
							<p>退款原因：122</p>
						</article>
											<hr/> -->
					<article>
						<p class="mb10 tc RefundsBtn_btn">
							<button type="button" class="kbVipAdmin_opt kbVipAdmin_opt_7facff">同意退款</button>
							<button type="button" class="kbVipAdmin_opt">拒绝退款</button>
						</p>
						<ul class="RefundsBtn_opt">
							<li class="kbVipAdmin_enter ">
								<p>
									<b><i>*</i>退款金额:</b>
									<input type="number" name="refund_fee" value=""   placeholder="退款金额" />
								</p>
								<p>
									<b><i>*</i>同意退款备注:</b>
									<input type="text" name="admin_remark" value=""  placeholder="同意退款备注" />
								</p>
							</li>
							<li class="kbVipAdmin_enter ">
								<p>
									<b><i>*</i>拒绝原因:</b>
									<input type="text" name="admin_remark"  value=""   placeholder="属性值" />
								</p>
							</li>
						</ul>
					</article>
					<div class="kbVipAdmin_operating">
						<div class="kbVipAdmin_restsubmit">
							<input  class="kbVipAdmin_button_005aff w80 h30 tc" type="submit" value="好的" />
						</div>
					</div>
				</form>
			</div>
		</div>

	<script type="text/javascript" src="/Public/Portal/PortalJS/alert/alertNew.js?version=3.1"></script>
<script src="/Public/JS/module/handlebars/handlebars-base.js" type="text/javascript"></script>
<script src="/Public/JS/module/vue/vue.js" type="text/javascript"></script>

<script type="text/javascript" src="/Public/JS/module/jedate/jquery.jedate.min.js"></script>

<script type="text/javascript" src="/Public/Portal/PortalJS/portal.js?version=9.7"></script>

	
	<script type="text/javascript">
		$(function(){
			$('.kbVipAdmin_shopInfo>a,.kbVipAdmin_systemInfo>a').on('click',function(){
				var $this=$(this);
				$this.next().slideToggle();
			})

		});
		var nav_a = $('.left_nav a');
		for(var i = 0;i < nav_a.length;i ++)
		{

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/WechatRefund/companyOrderDetailByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
		<script>

			  $(function(){
	   		
		   		$('.kbVipAdmin_alert .kbVipAdmin_operating input[type="reset"]').on('click',function(){
		   			$('.kbVipAdmin_alert').fadeOut();
		   		});

		   		$('.RefundsBtn').on('click',function(){
		   			console.log("aaa");
		   			$('.RefundsBtn_alert').fadeIn();
		   			/* $('.RefundsBtn_alert form').attr('action', '<?php echo U("wxRefund");?>?id='+$(this).attr('refundID')); */
	            });
		   		$('.RefundsBtn_btn button').on('click',function(){
		   			var RefundsBtn_btn=$('.RefundsBtn_btn button');
		   				$this=$(this);
		   				indexs=RefundsBtn_btn.index($this);
		   				console.log(indexs);
		   			$this.addClass('kbVipAdmin_opt_7facff').siblings().removeClass('kbVipAdmin_opt_7facff');
		   			$('.RefundsBtn_opt li').eq(indexs).fadeIn().siblings('li').fadeOut();
		   			// console.log($('.RefundsBtn_opt li').eq(indexs))
		   			// $('.RefundsBtn_opt li').eq(indexs).siblings('li').fadeOut();
		   		})
		   		
	         });
	   	</script>


</body>
</html>