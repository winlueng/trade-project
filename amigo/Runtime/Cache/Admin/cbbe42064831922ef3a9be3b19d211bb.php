<?php if (!defined('THINK_PATH')) exit(); $moduleList = showModuleList(); $navList = showNavList(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<title>管理后台</title>
	<!-- public end -->
	<link rel="stylesheet" href="/Public/CSS/common.css">
	<script type="text/javascript" src="/Public/JS/jquery-1.8.2.min.js"></script>
	<!--module start  -->
    <script type="text/javascript" src="/Public/JS/module/jedate/jquery.jedate.min.js"></script>
	<link type="text/css" rel="stylesheet" href="/Public/JS/module/jedate/skin/jedate.css">
	<script type="text/javascript" src="/Public/JS/module/dlalert/dlalert.js"></script>
	<link rel="stylesheet" href="/Public/JS/module/dlalert/dlalert.css">
	<!--module end  -->
	<!-- public end -->
	<!-- default -->
	<link rel="stylesheet" href="/Public/selfAdmin/selfAdminCSS/projectBadmin.css?version=3.5"></link>
	<link rel="stylesheet" href="/Public/selfAdmin/selfAdminCSS/coupon/coupon.css">
	<script type="text/javascript" src="/Public/JS/kbMarketAdmin.js?version=3.2"></script>

	 <script src="/Public/JS/module/handlebars/handlebars-base.js" type="text/javascript"></script>
	
	<link rel="stylesheet" href="/Public/selfAdmin/selfAdminCSS/kbVipAdminCount.css">

</head>
<body>
	<div id="kbVipAdmin_header" class="ftcolorNav ">
		<p class="tr pl100 pr100 h25 lh200 kbVipAdmin_f20">欢迎回来，<?php echo ($_SESSION['adminInfo']['user_name']); ?><a href="<?php echo U('Login/logout');?>" class="ml50">退出</a></p>
		<nav class="kbVipAdmin_header_nav ft">
		<?php if(is_array($moduleList)): foreach($moduleList as $key=>$v): ?><a class="<?php echo ($_GET['module']==$v['id']?'selected':''); ?>" href="?module=<?php echo ($v["id"]); ?>"><?php echo ($v["module_name"]); ?></a><?php endforeach; endif; ?>
		</nav>
	</div>
	<nav class="kbVipAdmin_center_nav left_nav">
		<ul >
			<?php if(($_SESSION['adminInfo']['id'] == 1) and ($_GET['module'] == 1) ): ?><li>
				<a active="<?php echo U('Module/moduleAdd');?>" href="<?php echo U('Module/moduleAdd',[module=>1]);?>">添加显示模块</a>
			</li><?php endif; ?>
			<?php if(is_array($navList)): foreach($navList as $key=>$v): ?><li>
				<?php if($v['rules']): ?><a href="javascript:;" class="special"><?php echo ($v["parent_name"]["alias"]); ?></a>
				<!-- 子菜单 -->
					<ul>
					<?php if(is_array($v["rules"])): foreach($v["rules"] as $key=>$vo): ?><li>
							<a active="<?php echo U($vo['name']);?>" href="<?php echo U($vo['name'],[module=>$_GET['module']]);?>"><?php echo ($vo["alias"]); ?></a>
						</li><?php endforeach; endif; ?>
					</ul>
				<?php else: ?>
					<a active="<?php echo U($v['parent_name']['name']);?>" href="<?php echo U($v['parent_name']['name'],[module=>$_GET['module']]);?>"><?php echo ($v["parent_name"]["title"]); ?></a><?php endif; ?>
			</li><?php endforeach; endif; ?>
		</ul>
	</nav>
	
	<div id="kbVipAdmin_center">
		<div class="kbVipAdmin_center_txt">
			<ul class="microWebCount">
				<h3>访问量</h3>
				<li>
					<p>微官网</p>
					<p><b><?php echo ($websiteVisitTotal); ?></b></p>
				</li>
				<li>
					<p>卡券速递</p>
					<p><b><?php echo ($cardVisitTotal); ?></b></p>
				</li>
			</ul>
			<ul class="preferentialCount">
				<h3>卡券速递(联盟卡券)</h3>
				<li>
					<p>优惠券</p>
					<div>
					 	<p>
						 	
						 	<span>点击量：</span>
						 	<b ><?php echo ($league['favorable']['click_total']); ?></b>
						 </p>
						 <p>
							
							<span>领取量：</span>
							<b><?php echo ($league['favorable']['get_total']); ?></b>
						</p>
					</div>
				</li>
				<li>
					<p>体验券</p>
					<div>
					 	<p>
						 	
						 	<span>点击量：</span>
						 	<b><?php echo ($league['experience']['click_total']); ?></b>
						 </p>
						 <p>
							<span>领取量：</span>
							<b><?php echo ($league['experience']['get_total']); ?></b>
						</p>
					</div>
				</li>
				<li>
					<p>现金券</p>
					<div>
						<p>
						 	<span>点击量：</span>
						 	<b><?php echo ($league['cash']['click_total']); ?></b>

						 </p>
						 <p>
							<span>领取量：</span>
							<b><?php echo ($league['cash']['get_total']); ?></b>

						</p>
					</div>
				</li>
				<li>
					<p>代金券</p>
					<div>
					 	<p>
						 	<span>点击量：</span>
						 	<b><?php echo ($league['voucher']['click_total']); ?></b>

						 </p>
						 <p>
							<span>领取量：</span>
							<b><?php echo ($league['voucher']['get_total']); ?></b>

						</p>
					</div>
				</li>
				<li>
					<p>折扣券</p>
					<div>
					 	<p>
						 	<span>点击量：</span>
						 	<b><?php echo ($league['discount']['click_total']); ?></b>

						 </p>
						 <p>
							<span>领取量：</span>
							<b><?php echo ($league['discount']['get_total']); ?></b>

						</p>
					</div>
				</li>
			</ul>
			<ul class="preferentialCount">
				<h3>卡券速递(自身卡券)</h3>
				<li>
					<p>优惠券</p>
					<div>
					 	<p>
						 	
						 	<span>点击量：</span>
						 	<b ><?php echo ($us['favorable']['click_total']); ?></b>
						 </p>
					</div>
				</li>
				<li>
					<p>体验券</p>
					<div>
					 	<p>
						 	
						 	<span>点击量：</span>
						 	<b><?php echo ($us['experience']['click_total']); ?></b>
						 </p>
					</div>
				</li>
				<li>
					<p>现金券</p>
					<div>
						<p>
						 	<span>点击量：</span>
						 	<b><?php echo ($us['cash']['click_total']); ?></b>
						 </p>
					</div>
				</li>
				<li>
					<p>代金券</p>
					<div>
					 	<p>
						 	<span>点击量：</span>
						 	<b><?php echo ($us['voucher']['click_total']); ?></b>
						 </p>
					</div>
				</li>
				<li>
					<p>折扣券</p>
					<div>
					 	<p>
						 	<span>点击量：</span>
						 	<b><?php echo ($us['discount']['click_total']); ?></b>
						 </p>
					</div>
				</li>
			</ul>
			<ul class="businessCount">
				<h3>商户统计</h3>
				<li>
					<p><b><?php echo ($websiteCompanyCount); ?></b></p>
					<p>微官网</p>
				</li>
				<li>
					<p><b><?php echo ($cardCompanyCount); ?></b></p>
					<p>卡券速递</p>
				</li>
				<li>
					<p><b><?php echo ($dueCompanyCount); ?></b></p>
					<p>将要过期商户</p>
				</li>
			</ul>
			<div class="businessCount">
				<h3>近期过期商户</h3>
				<table class="roleList">
					<thead>
						<tr>
							<th>编号</th>
							<th>商户名称</th>
							<th>商户地址</th>
							<th>行业</th>
							<!-- <th>协议类别</th> -->
							<th>注册人</th>
							<th>电话</th>
							<th>开始时间</th>
							<th>结束时间</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($dueCompanyList)): foreach($dueCompanyList as $key=>$v): ?><tr>
							<td><?php echo ($v['uid']); ?></td>
							<td><?php echo ($v['company_name']); ?></td>
							<td><?php echo ($v['address']); ?></td>
							<td><?php echo ($v['business']); ?></td>
							<!-- <td></td> -->
							<td><?php echo ($v['principal']); ?></td>
							<td><?php echo ($v['phone']); ?></td>
							<td><?php echo date('Y-m-d',$v['start_time']);?></td>
							<td><?php echo date('Y-m-d',$v['end_time']);?></td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					<tfoot>
			           <!--  <tr>
			                <td colspan="9">
			                    <div id="dvPager" class="page fr clearfix" style="margin: 10px 0 15px;"></div>
			                </td>
			            </tr> -->
		        	</tfoot>
				</table>
			</div>

		</div>

	</div>

	<script type="text/javascript">
	var nav_a = $('.left_nav a');
	for(var i = 0;i < nav_a.length;i ++)
	{

		if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Index/adminIndex'+'.html')
		{
			nav_a[i].parentNode.className = 'selected';
			nav_a[i].parentNode.parentNode.className = 'selectedPar';
		}
	}
	</script>
	
	
</body>
</html>