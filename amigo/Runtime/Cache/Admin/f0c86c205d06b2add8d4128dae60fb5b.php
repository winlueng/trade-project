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


		
<link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css"></link>
<style>
 .kbtable-statistics{
 	display:flex;
 	justify-content:center;
 	min-height:100px;
 	padding-top: 20px;
 }
 .kbtable-statistics-slide{
 	flex-grow: 1
 }
 .filterData{
 	display:inline-block;
 	width:340px;
 }
 .kbVipAdmin_box{
 	height:100%;
 }
</style>
	<?php  ?>

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
	
	<div id="kbVipAdmin_rightCenter" class="mb10"><!-- 内容页开始 -->
		<div class="kbVipAdmin_box">	
			<div class="centerTitle">
				<h2>总库存情况</h2>
			</div>
			<div class="kbtable-statistics mb10">
				<article class="kbtable-statistics-slide tc">
					
					<p class="f20 mb10">
						<?php if(empty($info["salesTotal"])): ?>0
						<?php else: ?>
							<?php echo ($info["salesTotal"]); endif; ?>
					</p>
					<p>已销售</p>
				</article>
				<article class="kbtable-statistics-slide tc">
					
					<p class="f20 mb10"><?php echo ($info['inventoryTotal']?$info['inventoryTotal']:0); ?></p>
					<p>总库存</p>
				</article>
				
			</div>
		
			<div class="centerTitle">
				<h2>昨日店铺情况</h2>
			</div>
			<div class="kbtable-statistics mb10">
				<article class="kbtable-statistics-slide tc">
					<p>订单数</p>
					<p class="f16">
						<?php if(empty($info["yesterdayData"]["orderTotal"])): ?>0
						<?php else: ?>
							<?php echo ($info["yesterdayData"]["orderTotal"]); endif; ?>
					</p>
					
				</article>
				<article class="kbtable-statistics-slide tc">
					<p>商品成交量</p>
					<p class="f16"><?php echo ($info["yesterdayData"]["goodsSales"]); ?></p>
					
				</article>
				<article class="kbtable-statistics-slide tc">
					<p>成交额</p>
					<p class="f16">
						<?php if(empty($info["yesterdayData"]["priceTotal"])): ?>0
						<?php else: ?>
							<?php echo ($info["yesterdayData"]["priceTotal"]); endif; ?>
					</p>
					
				</article>
				<article class="kbtable-statistics-slide tc">
					<p>商品浏览量</p>
					<p class="f16">
						<?php if(empty($info["yesterdayData"]["goodsStatic"])): ?>0
						<?php else: ?>
							<?php echo ($info["yesterdayData"]["goodsStatic"]); endif; ?>
					</p>
					
				</article>
			</div>
			<div class="kbVipAdmin_operating filter-operating" >
				<form>
					<div class="filterData">
					<input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
					<input class="start" type="hidden" name="start" value="" />
					<input  class="end"  type="hidden" name="end" value="" />
					<button class="kbVipAdmin_opt w80 h30" type="submit">确定</button>
					</div>
				</form>

				<button class="kbVipAdmin_opt  h30 fr" type="button" onclick="javascript:window.location.href='?getExcel=1'">下载Excel</button>
			</div>
			<div class="kbVipAdmin_table mb20">
				
				<table>
					<thead>
						<tr>
							<th width="100">日期</th>
							<th>订单数</th>
							<th>商品成交量</th>
							<th>成交额</th> 
							<th>商品浏览量</th>
							
						</tr>
					</thead>
					<tbody>
					 <?php if(is_array($info["dateData"])): $i = 0; $__LIST__ = $info["dateData"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td width="100"><p><?php echo ($key); ?></p></td>
							<td><p><?php echo ($v["orderTotal"]); ?></p></td>
							<td><p><?php echo ($v['goodsSales']?$v['goodsSales']:0); ?></p></td>
							<td><p><?php echo ($v['priceTotal']?$v['priceTotal']:0); ?></p></td>
							<td><p><?php echo ($v['goodsStatic']?$v['goodsStatic']:0); ?></p></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
				<!-- 表格页数开始 -->
				<div class="kbVipAdmin_page mb10">
					<div class="pageSize">
						<?php echo ($page); ?>
						<script type="text/javascript">
							$('.pageSize a:first-child').addClass('prevPage');
							$('.pageSize a:last-child').addClass('nextPage');
						</script>
					</div>
					<div class="pageJump">	
					<?php if(count($list) == 10 ): ?><form >
						<input class="w60  fl" type="text" name="p" placeholder="<?php echo I('get.p');?>" />
						<input type="submit" class="fl" name="" value="跳转">
					</form><?php endif; ?>	
					</div>
				</div>
				<!-- 表格页数结束 -->
			</div>
			<!-- 表格结束 -->
			
		</div>
	</div><!-- 内容页结束 -->
	<div class="ui-datepicker-css">	
	    <div class="ui-datepicker-quick">
	        <p>快捷日期<a class="ui-close-date">X</a></p>
	        <div>
	            <input class="ui-date-quick-button" type="button" value="今天" alt="0"  name=""/>
	            <input class="ui-date-quick-button" type="button" value="昨天" alt="-1" name=""/>
	            <input class="ui-date-quick-button" type="button" value="7天内" alt="-6" name=""/>
	            <input class="ui-date-quick-button" type="button" value="14天内" alt="-13" name=""/>
	            <input class="ui-date-quick-button" type="button" value="30天内" alt="-29" name=""/>
	            <input class="ui-date-quick-button" type="button" value="60天内" alt="-59" name=""/>
	        </div>
	    </div>
	    <div class="ui-datepicker-choose">
		        <p>自选日期</p>
		        <div class="ui-datepicker-date">
		            <input name="startDate" id="startDate" class="startDate" readonly value="2014/12/20" type="text">
		           -
		            <input name="endDate" id="endDate" class="endDate" readonly  value="2014/12/20" type="text" disabled onChange="datePickers()">
		        
		        </div>
		    </div>
		</div>
	</div>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/share.js?v=1.11"></script>


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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Goods/goodsDataByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>