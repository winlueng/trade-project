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
	
		<link rel="stylesheet" href="/Public/selfAdmin/selfAdminCSS/userAdmin/userAdmin.css">

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
	
	<div id="kbVipAdmin_center" class="userAdmin_center">
		<div class="kbVipAdmin_center_txt">
			<div class="kbVipAdmin_center_tables">
			<div class="kbVipAdmin_tableHead">
				<p class="authAddBtn">
					<input class=" adminFont kbVipAdmin_btn w100 h50 "  type="button" value="&#xe762;&nbsp;&nbsp;添加" />
				</p>
			</div>
				<table class="roleList">
					<thead>
						<tr>
							<th>编号</th>
							<th>模块名称</th>
							<th>显示功能模块</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td class="moduleID"><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["module_name"]); ?></td>
							<td><?php echo ($v["ruleName"]); ?></td>
							<td>
								<input class="adminFont kbVipAdmin_btnMenu moduleAddWrite" type="button" value="&#xe601;&nbsp;编辑" />
								<input class="adminFont kbVipAdmin_btnMenu" type="button" value="&#xe606;&nbsp;删除" onclick="delList(this)" delid='<?php echo ($v["id"]); ?>'/>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="kbVipAdmin_alert userAdmin_alert">
		<div class="kbVipAdmin_alert_box userAdmin_alert-box">
		<button class="kbVipAdmin_alert-close adminFont">&#xe61b;</button>
		<h2>添加模块</h2>
		<form class="userAdmin_FormParent" action="<?php echo U('moduleAdd');?>" method="post">
			<p class="userAdmin_FormParent-addRoleName">
				<label><b>模块名称</b></label>
				<input type="text" name="module_name" value="" placeholder="请输入模块名称" />
			</p>
			<ul class="userAdmin_Form">
				<?php if(is_array($rules)): foreach($rules as $key=>$v): ?><li>
					<p class="userAdmin_Form-first">
						<input type="checkbox" name="parent_rules[]" value="<?php echo ($v["id"]); ?>" />
						<label><?php echo ($v["title"]); ?></label>
					</p>
				</li><?php endforeach; endif; ?>
			</ul>
			<p class="kbVipAdmin_MenuAdminBtn">
					<input class="authAddFormSmt" type='submit' value="确认添加" />
				</p>	
		</form>
		</div>
	</div>
	<div class="kbVipAdmin_alert userAdmin_alertWrite">
		<div class="kbVipAdmin_alert_box userAdmin_alert-box">
		<button class="kbVipAdmin_alert-close adminFont">&#xe61b;</button>
		<h2>修改模块信息</h2>
		<form class="userAdmin_FormParent" action="<?php echo U('moduleAdd');?>" method="post">
			<p class="userAdmin_FormParent-addRoleName">
				<label><b>模块名称</b></label>
				<input type="text" name="module_name" value="" placeholder="请输入模块名称" />
			</p>
			<ul class="userAdmin_Form">
				<?php if(is_array($rules)): foreach($rules as $key=>$v): ?><li>
					<p class="userAdmin_Form-first">
						<input type="checkbox" name="parent_rules[]" value="<?php echo ($v["id"]); ?>" />
						<label><?php echo ($v["title"]); ?></label>
					</p>
				</li><?php endforeach; endif; ?>
			</ul>
			<p class="kbVipAdmin_MenuAdminBtn">
					<input class="authAddFormSmt" type='submit' value="确认修改" />
				</p>	
		</form>
		</div>
	</div>
	
	<script type="text/javascript">
		$(function(){
			$('.authAddBtn input').on('click',function(){
				$('.userAdmin_alert').fadeIn();
			})
			$('.moduleAddWrite').on('click',function(){
				$('.userAdmin_alertWrite').fadeIn();
				var $this=$(this);
				var moduleID=$this.parent().siblings('.moduleID').text();//
				var moduleNameInfo=$('.userAdmin_alertWrite .userAdmin_FormParent-addRoleName');
				var moduleForm = $('.userAdmin_alertWrite .userAdmin_Form');
				console.log(moduleForm);
				console.log(moduleID);
				$.get('<?php echo U("ajaxControl");?>',{flag:'selModuleInfo',id:moduleID},function (res){
					console.log(res)
					$(moduleNameInfo[0]).find('input').val(res.module_name)
					for(var i=0;i<res.parent_rules.length;i++){
						$(moduleForm).find('input[value='+res.parent_rules[i]+']').prop("checked",true);
					}
		 			$('.userAdmin_alertWrite').find('form').prop("action",'<?php echo U("moduleUpdate");?>?id='+moduleID);
		 		});
			})
			/* $.get('<?php echo U("ajaxControl");?>',{flag:'selModuleInfo',id:1},function (res){
			 console.log(res)		
			}); */
		})

		// 删除当前模块
		function delList(obj) 
		{
			var res = confirm('确认要删除吗?');
			if (res) {
				$.get('<?php echo U("ajaxControl");?>', {flag:'del',id:$(obj).attr('delid')},function (res) {
					if (res) 
					{
						$(obj).parent().parent().remove();
					}
				});
			}
		}
		
	</script>

	<script type="text/javascript">
	var nav_a = $('.left_nav a');
	for(var i = 0;i < nav_a.length;i ++)
	{

		if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Module/moduleAdd'+'.html')
		{
			nav_a[i].parentNode.className = 'selected';
			nav_a[i].parentNode.parentNode.className = 'selectedPar';
		}
	}
	</script>
	
	
</body>
</html>