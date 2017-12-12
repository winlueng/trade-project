<?php if (!defined('THINK_PATH')) exit(); $navList = showCompanyNavList(); $ip = get_client_ip(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title><?php echo ($_SESSION['companyInfo']['company_name']); ?>后台</title>
	<!-- public start -->
	<link rel="stylesheet" href="/Public/salon/css/common.css?=1"></link>
	<script type="text/javascript" src="/Public/JS/jquery-1.8.2.min.js"></script>
	<link rel="stylesheet" href="/Public/Portal/PortalCSS/mbase.special.css"></link>

	<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
	<!-- <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

	<!--module  start-->
	<link rel="stylesheet" href="/Public/Business/BusinessJS/alert/companyalert.css?version=1.3"></link>
	<script type="text/javascript" src="/Public/Business/BusinessJS/alert/alertNew.js?version=3.1"></script>
	<link type="text/css" rel="stylesheet" href="/Public/JS/module/jedate/skin/jedate.css">
    <script type="text/javascript" src="/Public/JS/module/jedate/jquery.jedate.min.js"></script>
	<!--module  end-->
	<!-- public end -->
	<!--defalut  -->
	<link rel="stylesheet" href="/Public/Business/BusinessCSS/kbshopAdmin.1.0.css?version=1.19"></link>
	<link rel="stylesheet" href="/Public/Business/BusinessCSS/kbshopAdmin.mend.css?version=1.18"></link>
	<script type="text/javascript" src="/Public/Business/BusinessJS/kbshopAdmin.js?version=4.11"></script>
	
	<script src="/Public/JS/module/handlebars/handlebars-base.js" type="text/javascript"></script>
	<script src="/Public/JS/module/vue/vue.js" type="text/javascript"></script>





	
    	
<link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">
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
 .kbShopAdmin_box{
 	height:100%;
 }
</style>
	<?php  ?>

</head>
<body>

	<div id="kbShopAdmin_header" class="bg_main color_last">
		<h2><?php echo ($_SESSION['companyInfo']['company_name']); ?>后台管理系统</h2>
		<div class="header_Fun tr pl100 pr100 h25 lh200 fr">
			<div class="kbShop_systemInfo">
				<a href="javascript:;"><img src="/Public/Business/BusinessImages/nav_icon_mail_default.svg" alt="系统消息" />
				<?php if(array_sum($orderConut) > 0): ?><strong class="redInfoCount"><?php echo ($orderConut[0]+$orderConut[1]); ?></strong><?php endif; ?>
				</a>
				<dl>
					<dt>系统消息</dt>
					<?php if($orderConut[0] > 0): ?><dd>
							<a href="<?php echo U('OrderForm/orderList',['status' => 2]);?>">	
								您有<?php echo ($orderConut[0]); ?>张新订单待处理,请前往处理
							</a>
						</dd><?php endif; ?>
					<?php if($orderConut[4] > 0): ?><dd>
							<a href="<?php echo U('OrderForm/orderList',['status' => 5]);?>">	
								您有<?php echo ($orderConut[4]); ?>张退款订单,请前往查看
							</a>
						</dd><?php endif; ?>
				</dl>
			</div>
			
			<div class="kbShop_shopInfo ml30">
				<a href="javascript:;" ><img src="/Public/Business/BusinessImages/nav_icon_person_default.svg" alt="商户资料" /><span><?php echo ($_SESSION['companyInfo']['user_name']); ?></span></a>
					<dl>
						<dt><?php echo ($_SESSION['companyInfo']['company_name']); ?></dt>
						<!-- <dd><a href="javascript:;">商户资料</a></dd> -->
						<dd><a href="<?php echo U('Login/logout');?>">退出</a></dd>
					</dl>
				
			</div>
		</div>
	</div>
	<div id="kbShopAdmin_leftNav" class="bg_main color_last">
		<ul >
			<?php if(is_array($navList)): foreach($navList as $key=>$v): ?><li>
				<?php if($v['rules']): ?><a href="javascript:;" class="special"><?php echo ($v["parent_name"]["alias"]); ?></a>
				<!-- 子菜单 -->
					<ul>
					<?php if(is_array($v["rules"])): foreach($v["rules"] as $key=>$vo): ?><li>
							<a  href="<?php echo U($vo['name']);?>">
							<?php if((in_array($vo['name'],$showNumberArr)) AND (checkIsControl($vo['name'], $companyID))): ?><strong class="redInfoCount"><?php echo checkIsControl($vo['name'], $companyID);?></strong><?php endif; ?>
							<?php echo ($vo["alias"]); ?></a>
						</li><?php endforeach; endif; ?>
					</ul>
				<?php else: ?>
					<a  href="<?php echo U($v['parent_name']['name']);?>"><!-- <strong class="redInfoCount">99</strong> --><?php echo ($v["parent_name"]["alias"]); ?></a><?php endif; ?>
			</li><?php endforeach; endif; ?>
		</ul>
	</div>


	<div id="kbShopAdmin_rightCenter" class="mb10"><!-- 内容页开始 -->
		<div class="kbShopAdmin_box">	
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
			<div class="kbShopAdmin_operating filter-operating" >
				<form>
					<div class="filterData">
					<input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
					<input class="start" type="hidden" name="start" value="" />
					<input  class="end"  type="hidden" name="end" value="" />
					<button class="kbShopAdmin_opt w80 h30" type="submit">确定</button>
					</div>
				</form>

				<button class="kbShopAdmin_opt  h30 fr" type="button" onclick="javascript:window.location.href='?getExcel=1'">下载Excel</button>
			</div>
			<div class="kbShopAdmin_table mb20">
				
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
				<div class="kbShopAdmin_page mb10">
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


 <p class="tc mt20 f14">技术支持由<a href="http://gdkbvip168.gdallinone.com/Company/Index/index">广州旷邦科技有限责任公司提供</a></p>



	<script type="text/javascript">
	$(function(){
		$('.kbShop_shopInfo>a,.kbShop_systemInfo>a').on('click',function(){
			var $this=$(this);
			$this.next().slideToggle();
		});
		(function(){
			var nav_a = $('#kbShopAdmin_leftNav a');
			for(var i = 0;i < nav_a.length;i ++)
			{
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/Goods/goodsData.html?start=1511798400000&amp;end=1512921600000';?>")
				{
					console.log($(nav_a[i]));
					$(nav_a[i]).addClass('selected');
					$(nav_a[i]).parent().parent().addClass('selectedPar') ;
					$(nav_a[i]).parent().parent().parent().addClass('selected') ;
				}
			}
		})();
	});

	
	</script>
</body>
</html>