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


		
<!-- <link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?version=1.1"></link>
 -->
<style>
	.HealthStatus{
		display:none;
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
	
	<div id="kbVipAdmin_rightCenter" class=" OrderForm mb10"><!-- 内容页开始 -->
			<div class="centerTitle">
				<h1>用户列表</h1>
			</div>
			<div class="kb_table-filter mb10">
				<!-- <form action="" method="get" style="display:inline-block">
						<select class="kbVipAdmin_slt w100 h30" name="correlation_id" title="可选择分类查找相关商品">
							<option value="">全部类型</option>
							<?php if(is_array($typeList)): foreach($typeList as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
						</select>
						<input type="submit" class="kbVipAdmin_opt  w80 h30" value="确认查找">
				</form> -->
				<div class="filter-searchDate mr10">
					<form action="<?php echo U('VisitorInfo/visitorListByProject',['module' => $_GET['module']]);?>">
						<input type="search" value="<?php echo I('sel_name');?>" name="sel_name" placeholder="请输入用户呢称" />
						<input class="kbVipAdmin_opt w80 h30 fr" type="submit" value="确定" />
					</form>
				</div>
			</div>
			<div class="main-contentBox kbVipAdmin_mt24" >
			<div class="kbVipAdmin_table mb20">
				
				<table>
					<thead>
						<tr>
							<th width="50">用户ID</th>
							<th>呢称</th>
							<th>性别</th>
							<th>电话号码</th>
							<th>购买次数</th>
							<th>充值次数</th>
							<th>累计充值金额</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td><p><?php echo ($v["id"]); ?></p></td>
							<td><p><?php echo ($v["nick_name"]); ?></p></td>
							<td><p><?php echo ($v['sex'] == '1'?'男':'女'); ?></p></td>
							<td><p><?php echo ($v["phone"]); ?></p></td>
							<td><p><?php echo ($v["pay_total"]); ?></p></td>
							<td><p><?php echo ($v["recharge_total"]); ?></p></td>
							<td><p><?php echo ($v['recharge_sum']?$v['recharge_sum']:0); ?></p></td>
							<td>
								<div class="kbVipAdmin_tdAction">
									<input class=" kbVipAdminSea mb10" type="button" value="" title="详情" v-on:click="selectInfo(this)" />
								<!-- 	<input class=" kbVipAdminStaff mb10" type="button" visitorID="<?php echo ($v["id"]); ?>" value="" title="历史形象"  />
									<input class=" kbVipAdminHistorty mb10" type="button" visitorID="<?php echo ($v["id"]); ?>" nickName="<?php echo ($v["nick_name"]); ?>" value="" title="加入员工"  /> -->
								</div>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
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
			<!-- 表格结束 -->
		</div>
	</div><!-- 内容页结束 -->

	<div class="kbVipAdmin_alert visitorList_alert">
		<div class="kbVipAdmin_alertBox"  id="visitorList_alert">
			<button type="button" class="kbVipAdmin_alert-close "></button>
				<h3 >个人资料</h3>
			<form >
				<div class="formDate">
				<ul class="mt20"   >
					<li class="kbVipAdmin_enter" >
						<b>呢称:</b>
						<p class="infoBlock">{{info.nick_name}}</p>
					</li>
					<!-- <li class="kbVipAdmin_enter" >
						<b>微信ID:</b>
						<p class="infoBlock"></p>
					</li> -->
					<li class="kbVipAdmin_enter" >
						<b>姓名:</b>
						<p class="infoBlock">{{info.real_name}}</p>
					</li>
					<li class="kbVipAdmin_enter" >
						<b>性别:</b>
						<p class="infoBlock" v-if="info.sex==='2'">女</p>
						<p class="infoBlock" v-if="info.sex==='1'">男</p>
					</li>
					<li class="kbVipAdmin_enter" >
						<b>生日:</b>
						<p class="infoBlock">{{info.visitor_birthday}}</p>
					</li>
					<li class="kbVipAdmin_enter" >
						<b>购物次数:</b>
						<p class="infoBlock">{{info.pay_total}}</p>
					</li>
					<li class="kbVipAdmin_enter" >
						<b>手机号码:</b>
						<p class="infoBlock">{{info.phone}}</p>
					</li>
					<!-- <li class="kbVipAdmin_enter" >
						<b>邮箱:</b>
						<p class="infoBlock">{{info.email}}</p>
					</li> -->
					<li class="kbVipAdmin_enter" >
						<b>所在地:</b>
						<p class="infoBlock">{{info.city}}</p>
					</li>
					<li class="kbVipAdmin_enter" >
						<b>个人说明:</b>
						<p class="infoBlock">{{info.visitor_title}}</p>
					</li>
					<li class="kbVipAdmin_enter" >
						<b>用户来源:</b>
						<p class="infoBlock">{{info.company_name}}</p>
					</li>
				</ul>
				</div>
				<!-- <div class="kbVipAdmin_operating ">
					<div class="kbVipAdmin_restsubmit">
						<input  class="kbVipAdmin_opt_7facff  HistortyInfo w80 h30 tc" v-bind:visitorID="info.visitor_id" type="button" value="历史形象" />
						<input  class="visitorInfo kbVipAdmin_opt_7facff w80 h30" v-bind:visitorID="info.visitor_id" type="button" value="完善资料" />
					</div>
				</div> -->
			</form>
		</div>
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/VisitorInfo/visitorListByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	<script>
		$(function(){
			
			

		(function(){
			var app =new Vue({
				el:'#visitorList_alert',
				data:{
					info:{},

				}
			})
			// 详细资料
			$('.kbVipAdminSea').on('click',function(){
				var $this=$(this),
					visitor_id=$this.parents('tr').children('td').eq(0).children('p').text().trim();
				$.get('<?php echo U("VisitorInfo/ajaxControl");?>',{
					flag:"visitorInfo",
					visitor_id:visitor_id
				},function(res){
					app.info=res.info;
					
					console.log(app.info);
				var url = "<?php echo U('VisitorImage/insert');?>?visitor_id="+app.info.visitor_id;
				$('.visitorListAdd_alert').find('form').attr('action',url);
				})
				$('.visitorList_alert').fadeIn();
			})
			$('.visitorInfo').on('click',function(){
						$('.kbVipAdmin_alert').fadeOut();
						$('.visitorListAdd_alert').fadeIn();
				
			})


		})();
		
		
		$('.kbVipAdmin_alert .kbVipAdmin_operating input[type="reset"],.kbVipAdmin_alert-close').on('click',function(){
			$('.kbVipAdmin_alert').fadeOut();
		});
	})	
	</script>

</body>
</html>