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
		.orderDetail h2{
			font-size:1.6em;
			font-weight:bold;
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
		<?php  ?>
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
				<p>订单编号：<?php echo ($info["order_number"]); ?></p>
				<p>交易时间：<?php echo date('Y年m月d日 H:i:s', $info['create_time']);?></p>
				<?php switch($info["status"]): case "0": ?><p><b>待付款</b></p><?php break;?>
					<?php case "1": ?><p><b>用户取消订单</b></p><?php break;?>
					<?php case "2": if($info['is_send_out'] == 0): ?><p><b>已付款,待发货</b></p>
						<?php elseif($info['is_send_out'] == 1): ?>
							<p><b>待收货</b></p>
						<?php elseif($info['is_send_out'] == 2): ?>
							<p><b>已收货</b></p><?php endif; break;?>
					<?php case "3": ?><p><b>关闭交易</b></p><?php break;?>
					<?php case "4": ?><p><b>已完成</b></p><?php break;?>
					<?php case "5": ?><p><b style="font-size: 10px;color: #509fc9">退款申请中</b></p>
						<p style="font-size: 10px;color: #509fc9"><b>退款订单号：<?php echo ($info["refundInfo"]["out_refund_no"]); ?></b></p><?php break;?>
					<?php case "6": ?><p><b style="font-size: 10px;color: #509fc9">退款结果: 同意退款</b></p>
						<p style="font-size: 10px;color: #509fc9"><b>退款订单号：<?php echo ($info["refundInfo"]["out_refund_no"]); ?></b></p><?php break;?>
					<?php case "7": ?><p><b style="font-size: 10px;color: #509fc9">退款结果: 拒绝退款</b></p>
						<p style="font-size: 10px;color: #509fc9"><b>退款订单号：<?php echo ($info["refundInfo"]["out_refund_no"]); ?></b></p><?php break; endswitch;?>
			</article>
			<h2>商品信息</h2>
			<?php if(is_array($info["goods_data"])): $i = 0; $__LIST__ = $info["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><article class="goodsDetails">
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
				<p>费用金额:<?php echo ($info["total"]); ?>元</p>
				<p>运费:<?php echo ($info["express_price"]); ?>元</p>
				<p>总计:<?php echo ($info["total"]); ?>元</p>
			</article>
			<h2>买家信息</h2>	
			<article >
				<p><b>买家呢称:<?php echo ($info["address_id"]["consignee"]); ?></b><a href="<?php echo U('visitorOrder', ['visitor_id' => $info['visitor_id'],'module'=>$_GET['module']]);?>"><b style="font-size: 15px;color: #509fc9;margin-left:10px">查看历史订单</b></a></p>
				<p><b>收件人电话:<?php echo ($info["address_id"]["phone"]); ?></b></p>
				<p><b>收货地址:<?php echo ($info["address_id"]["address_str"]); ?></b></p>
			</article>
			<?php switch($info["status"]): case "1": ?><h2>取消原因:</h2>	
					<article>
						<textarea placeholder="管理员什么都没写...." disabled><?php echo ($info["refund_remark"]); ?></textarea>
						<br />
					</article><?php break;?>
				<?php case "2": ?><h2>用户订单备注:</h2>	
					<article>
						<textarea placeholder="用户什么都没写...." disabled><?php echo ($info["visitor_remark"]); ?></textarea>
						<br />
					</article><?php break;?>
				<?php case "3": ?><h2>取消原因:</h2>	
					<article>
						<textarea placeholder="管理员什么都没写...." disabled><?php echo ($info["refund_remark"]); ?></textarea>
						<br />
					</article><?php break;?>
				<?php case "4": ?><h2>备注信息:</h2>	
					<article>
						<textarea placeholder="管理员什么都没写...." disabled><?php echo ($info["admin_remark"]); ?></textarea>
						<br />
					</article><?php break;?>
				<?php case "5": ?><h2>退款原因:</h2>
					<article>
						<textarea placeholder="他什么都没写...." disabled><?php echo ($info["refundInfo"]["refund_remark"]); ?></textarea>
						<br />
					</article><?php break;?>
				<?php case "6": ?><h2>退款原因</h2>
					<article>
						<textarea placeholder="他什么都没写...." disabled><?php echo ($info["refundInfo"]["refund_remark"]); ?></textarea>
					</article>
					<article>
						<p>售后状态: <b style="font-size: 20px; color: pink">同意退款</b></p>
						<p>售后备注: <b style="font-size: 20px; color: #dd6549"><?php echo ($info["refundInfo"]["admin_remark"]); ?></b></p>
					</article><?php break;?>
				<?php case "7": ?><h2>退款原因</h2>
					<article>
						<textarea placeholder="他什么都没写...." disabled><?php echo ($info["refundInfo"]["refund_remark"]); ?></textarea>
					</article>
					<article>
						<p>售后状态: <b style="font-size: 20px; color: pink">拒绝退款</b></p>
						<p>拒绝原因: <b style="font-size: 20px; color: #dd6549"><?php echo ($info["refundInfo"]["admin_remark"]); ?></b></p>
					</article><?php break;?>
				<?php default: ?>
					<h2>用户订单备注:</h2>	
					<article>
						<textarea placeholder="用户什么都没写...." disabled><?php echo ($info["visitor_remark"]); ?></textarea>
						<br />
					</article>
					<?php if($info['admin_remark']): ?><h2>备注信息</h2>	
						<article>
							<textarea placeholder="他什么都没写...." name="admin_remark" disabled><?php echo ($info["admin_remark"]); ?></textarea>
								<br />
						</article>
					<?php else: ?>
						<h2>添加备注</h2>	
						<article>
							<form action="<?php echo U('orderInfo', ['id' => $_GET['id']]);?>" method="post">
								<textarea placeholder="他什么都没写...." name="admin_remark"><?php echo ($info["admin_remark"]); ?></textarea>
								<br />
								<input class="kbVipAdmin_opt w80 h30"" type="submit" value="确定" />
							</form>
						</article><?php endif; endswitch;?>
		<!-- 评价 start -->
		<?php if($info['goods_data'][0]['comment']): ?><hr>
		<h2>用户评论</h2><br>
		<section class="orderDetail" >
			<?php if(is_array($info["goods_data"])): $i = 0; $__LIST__ = $info["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><article class="bc pt10">
					<p class="bsGondsImg " style="width:80px;height:80px;">
						<img src="/Public<?php echo ($vi["goodsAttr"]["attr_pic"]); ?>"  alt="商品图" />
					</p>
					<aside class="bsScore ml10 ">
						<label>评分<?php echo ($vi["comment"]["score"]); ?></label>
						<?php $__FOR_START_895387826__=0;$__FOR_END_895387826__=$vi['comment']['score'];for($i=$__FOR_START_895387826__;$i < $__FOR_END_895387826__;$i+=1){ ?><p class="choose">
								<input type="checkbox" value="" checked disabled/>
								<label class="icon-score" ></label>
							</p><?php } ?>
					
						
					</aside>
					<p class="color_firstAid mt10">
						商品名字:<?php echo ($vi["goodsInfo"]); ?> <br>
						<?php echo ($vi['goodsAttr']['attr_name']); ?>:<?php echo ($vi['goodsAttr']['attr_val']); ?> <br>
						购买数量：<?php echo ($vi["total"]); ?>
					</p>
				</article>
				<h2>评价内容</h2>
				<article class="bc pt10">
					<p class="mb10">
					<textarea name="recontent" disabled="disabled"><?php echo ($vi['comment']['content']); ?></textarea>
					<br />
					</p>
					<p class="reviewImg mb10">
					<?php if($vi['comment']['image'][0]): if(is_array($vi["comment"]["image"])): $i = 0; $__LIST__ = $vi["comment"]["image"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><img src="/Public<?php echo ($vo); ?>" style="width: 300px" alt="" /><?php endforeach; endif; else: echo "" ;endif; endif; ?>
					</p>
				</article>
				<?php if(!$vi['comment']['recontent']): ?><h2>回复评价</h2>	
					<article class="contentPush bc pt10">
						<form action="<?php echo U('recontent',['id' => $vi['comment']['id']]);?>" method="post">
							<textarea name="recontent" placeholder="请输入"></textarea>
							<br />
							<input class="kbVipAdmin_opt w80 h30"" type="submit" value="回复" />
						</form>
					</article>
				<?php else: ?>
					<h2>回复内容</h2>	
					<article class="contentPush bc pt10">
						<textarea disabled="disabled"><?php echo ($vi['comment']['recontent']); ?></textarea>
						<br />
					</article><?php endif; ?>
				<p class="gSeparated mb10"></p><?php endforeach; endif; else: echo "" ;endif; ?>
		</section><?php endif; ?>
		</section>

			<!-- <h2>回复评价</h2>	
			<article class="contentPush bc pt10">
				<form action="" method="post">
					<textarea placeholder="请输入想要回复内容"></textarea>
					<br />
					<input class="kbVipAdmin_opt w80 h30"" type="submit" value="确定" />
				</form>
			</article> -->
			<!-- 评价 -->
		<!-- 主体内容部分end -->

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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/OrderForm/companyOrderDetailByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>