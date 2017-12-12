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


	
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css"></link>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
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
	
	<div id="kbVipAdmin_rightCenter" class="spAnDynamic OrderForm">
		<div class="centerTitle">
			<h1>招聘列表</h1>
		</div>
		<div class="kbVipAdmin_operating spAnDynamic-operating" >
			<input class="kbVipAdmin_opt w80 h30 kbVipAdmin_add " type="button" value="添加" />
		</div>
		<div class="main-contentBox kbVipAdmin_mt24" >
			<div class="kbVipAdmin_table">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>职位名称</th>
							<th>职位标题</th>
							<th>添加时间</th>
							<th>浏览量</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["job_name"]); ?></td>
							<td><?php echo ($v["job_title"]); ?></td>
							<td><?php echo date('Y-m-d H:i:s', $v['addtime']);?></td>
							<td><?php echo ($v['visitTotal']?$v['visitTotal']:0); ?></td>
							<td>
								<p class="kbVipAdmin_pushBtn">
									<input type="checkbox" value="" <?php echo ($v['status'] == '0'?'checked':''); ?> title=" <?php echo ($v['status'] == '0'?'启用':'禁用'); ?>"/>
									<label><b></b></label>
								</p>
								
							</td>
							<td class="kbVipAdmin_tdAction">
								<input class="font_57c8f2 kbVipAdminEdit" type="button" value="" title="编辑" />
								<input class="font_ff6c60 kbVipAdminDel" type="button" value="" title="删除" />
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
			<!-- 分页位置 -->
			<div class="kbVipAdmin_page">
				<div class="pageSize">
					<?php echo ($page); ?>
				</div>
				<div class="pageJump">			
					<input class="w60  fl" type="text" value="" />
					<a class="fl" href="javascript:;">跳转</a>
				</div>
			</div>
		</div>
		<div id="kbVipAdmin-edit" class="spAnDynamic-edit mt10" >
			<div class="centerTitle">
				<h1>添加招聘</h1>
			</div>
			<form class="" action="<?php echo U('jobAdd');?>" method="post" enctype="multipart/form-data">
				<p class="kbVipAdmin_enter"><b><i>*</i>职位名称：</b><input type="text" maxlength="20" name="job_name" value="" placeholder="请输入职位名称" required="required" data-datatype="input" />
					<strong class="kbVipAdmin_tip">必填项。职位名称不能超过20个字数。</strong>
				</p>
				
				<p class="kbVipAdmin_enter"><b><i>*</i>职位简述：</b><input type="text" maxlength="54" name="job_title" value="" placeholder="请输入职位描述" required="required" data-datatype="input" />
					<strong class="kbVipAdmin_tip">必填项。职位简述不能超过54个字数。两行文字显示，如不能则省略号代替</strong>
				</p>
				<p class="kbVipAdmin_enter"><b><i>*</i>职位薪酬：</b><input type="text" maxlength="54" name="payment" value="" placeholder="请输入职位薪酬" required="required" data-datatype="input" />
					<!-- <strong class="kbVipAdmin_tip">必填项。职位简述不能超过54个字数。两行文字显示，如不能则省略号代替</strong> -->
				</p>
				<div class="kbVipAdmin_enter">
					<b>详细内容:</b>
					<div id="myEditor" class="myEditor">
						<script id="container" name="job_info" type="text/plain">
						在这里你可以布置好你的职位详情
					    </script>
					    <!-- 配置文件 -->
					    <script type="text/javascript" src="ueditor.config.js"></script>
					    <!-- 编辑器源码文件 -->
					    <script type="text/javascript" src="ueditor.all.js"></script>
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">
					        var ue = UE.getEditor('container',{
				        		// 'initialFrameWidth':700,
				        		'initialFrameHeight':500,
				        		// 'initialContent':'在这里你可以布置好你商品详情的资料'
					        });
					    </script>
					</div>
				</div>
				<div class="kbVipAdmin_operating">
					<div class="kbVipAdmin_restsubmit"> 
						<input  class="kbVipAdmin_button_eee w200 h40 tc" type="reset" value="取消" />
						<input  class="kbVipAdmin_opt w200 h40" type="submit" value="保存" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="kbVipAdmin_alert spAnDynamic_alert">
		<div class="kbVipAdmin_alertBox">
			<button class="kbVipAdmin_alert-close "></button>
			<h3 class="mb10">招聘修改</h3>
			<form class="" action="" method="post" enctype="multipart/form-data">
				<div class="spAnDynamic_alert_from">
				<p class="kbVipAdmin_enter"><b><i>*</i>职位名称：</b><input type="text" maxlength="20" name="job_name" value="" placeholder="请输入职位名称" required="required" data-datatype="input" />
					<strong class="kbVipAdmin_tip">必填项。职位名称不能超过20个字数。</strong>
				</p>
				<p class="kbVipAdmin_enter"><b><i>*</i>职位简述：</b><input type="text" maxlength="54" name="job_title" value="" placeholder="请输入职位描述" required="required" data-datatype="input" />
					<strong class="kbVipAdmin_tip">必填项。职位简述不能超过54个字数。两行文字显示，如不能则省略号代替</strong>
				</p>
				<p class="kbVipAdmin_enter"><b><i>*</i>职位薪酬：</b><input type="text" maxlength="54" name="payment" value="" placeholder="请输入职位薪酬" required="required" data-datatype="input" />
				<div class="kbVipAdmin_enter">
					<b>详细内容:</b>
					<div id="myEditor1" name="job_info" class="myEditor">
					    <!-- 配置文件 -->
					</div>
					<script type="text/javascript"  src="ueditor.config.js"></script>
				    <!-- 编辑器源码文件 -->
				    <script type="text/javascript" src="ueditor.all.js"></script>
				    <!-- 实例化编辑器 -->
				    <script type="text/javascript">
				        var ue = UE.getEditor('myEditor1',{
			        		//'initialFrameWidth':700,
			        		'initialFrameHeight':500,
			        		// 'initialContent':'在这里你可以布置好你商品详情的资料'
				        });
				    </script>
				</div>
				</div>
				<div class="kbVipAdmin_operating ">
				<div class="kbVipAdmin_restsubmit"> 
					<input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
					<input  class="kbVipAdmin_opt w100 h40" type="submit" value="保存" />
				</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
     $(function(){
   		$('.spAnDynamic-operating .kbVipAdmin_add').on('click',function(){
   			$("#kbVipAdmin-edit").siblings().fadeOut();
   			$("#kbVipAdmin-edit").fadeIn();
   			var checkData=new CheckData('#kbVipAdmin-edit');
   			vueMethods.maxLength();
   			$('#kbVipAdmin-edit .kbVipAdmin_restsubmit .kbVipAdmin_opt').on('click',function(){
   				return checkData.verify();
   			})

   		})
   		$('.spAnDynamic-edit .kbVipAdmin_operating input[type="reset"]').on('click',function(){
   			$("#kbVipAdmin-edit").siblings().fadeIn();
   			$("#kbVipAdmin-edit").fadeOut();
   		})
   		$('.spAnDynamic .kbVipAdmin_tdAction .kbVipAdminEdit').on('click',function(){
   			$(".spAnDynamic_alert").fadeIn();
   			vueMethods.maxLength();
   		})
   		$('.spAnDynamic_alert .kbVipAdmin_operating input[type="reset"]').on('click',function(){
   			$(".spAnDynamic_alert").fadeOut();
   		})
   		$('.kbVipAdmin_checkbox input').on('click',function(){
   			var $this = $(this);
   			var checkStatus = $(this).val();
   			var ID=$this.parent().parent().siblings().eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   			$.get('<?php echo U("Job/ajaxControl");?>',{'flag':'changeNewsStatus',id:ID,status:checkStatus},function(res){
   				Alert((res=="1")? "修改成功":"修改失败");
   			})
   		})
   		$('.kbVipAdminEdit').on('click',function(){
   			var $this=$(this);
   			var ID=$this.parent().siblings().eq(0).text().replace(/(^\s+)|(\s+$)/g, "");

   			$.get('<?php echo U("Job/ajaxControl");?>',{'flag':'selJobInfo',id:ID,},function(res){

	   				for(r in res){
	   					switch(r){
	   						case "job_info":
	   							UE.getEditor('myEditor1').setContent(res.job_info);
	   						break;
	   						default:
	   							$(".spAnDynamic_alert .kbVipAdmin_enter").find('input[name="'+r+'"]').val(res[r]);
	   					}
	   				}

   			})
   			$(".spAnDynamic_alert form").prop('action',"<?php echo U('jobUpdate');?>?id="+ID)
   		})
   		 $('.kbVipAdmin_tdAction .kbVipAdminDel').on('click',function(){
   		 	var $this=$(this);
   		 	var ID=$this.parent().siblings().eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   		 	Confirm("你确定删除该招聘岗位吗？",function(ren){
   		 	 		if(ren){
 			   		 	$.get('<?php echo U("Job/ajaxControl");?>',{flag:'jobDel',id:ID},function(res){
 			   		 		if(res){
 			   		 			$this.parent().parent().remove();
 			   		 			sTip('操作成功');
 			   		 		}else{
 			   		 			eTip('操作失败');
 			   		 		}
 				   		})
   		 	 		}else{
   		 	 		}
   		 	 		console.log(ren);
   		 	});
   		 	
   		 })
   		  $('.kbVipAdmin_pushBtn input').on('click',function(){
   		 	 var $this=$(this);
   		 	 var ajaxUrl='<?php echo U("ajaxControl");?>';
   		 	 var Status=$this.is(':checked')?0:1;
   		 	 var ID = $this.parents('tr').children().eq(0).text().trim();
   		 	 // console.log(Status);
   		 	 $.get(ajaxUrl,{
   		 	 	flag:'changeJobStatus',
	   		 	status:Status,
	   		 	id:ID
   		 	 },function(res){
   		 	 	if(res!="1"){
   		 	 		$this.attr('checked',false)
   		 	 		eTip("操作失败")
   		 	 	}else{
   		 	 		sTip("操作成功")
   		 	 	}
   		 	 	console.log(res);
   		 	 })
   		 
   		 })
     })
	</script>

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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Job/jobAddByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>