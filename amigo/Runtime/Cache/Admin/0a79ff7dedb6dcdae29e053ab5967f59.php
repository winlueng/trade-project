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





	
    
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css"></link>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
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


	<div id="kbShopAdmin_rightCenter" class="spAnDynamic OrderForm">
		<div class="centerTitle">
			<h1>招聘列表</h1>
		</div>
		<div class="kbShopAdmin_operating spAnDynamic-operating" >
			<input class="kbShopAdmin_opt w80 h30 kbShopAdmin_add " type="button" value="添加" />
		</div>
		<div class="main-contentBox kbShopAdmin_mt24" >
			<div class="kbShopAdmin_table">
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
								<p class="kbShopAdmin_pushBtn">
									<input type="checkbox" value="" <?php echo ($v['status'] == '0'?'checked':''); ?> title=" <?php echo ($v['status'] == '0'?'启用':'禁用'); ?>"/>
									<label><b></b></label>
								</p>
								
							</td>
							<td class="kbShopAdmin_tdAction">
								<input class="font_57c8f2 kbShopAdminEdit" type="button" value="" title="编辑" />
								<input class="font_ff6c60 kbShopAdminDel" type="button" value="" title="删除" />
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
			<!-- 分页位置 -->
			<div class="kbShopAdmin_page">
				<div class="pageSize">
					<?php echo ($page); ?>
				</div>
				<div class="pageJump">			
					<input class="w60  fl" type="text" value="" />
					<a class="fl" href="javascript:;">跳转</a>
				</div>
			</div>
		</div>
		<div id="kbShopAdmin-edit" class="spAnDynamic-edit mt10" >
			<div class="centerTitle">
				<h1>添加招聘</h1>
			</div>
			<form class="" action="<?php echo U('jobAdd');?>" method="post" enctype="multipart/form-data">
				<p class="kbShopAdmin_enter"><b><i>*</i>职位名称：</b><input type="text" maxlength="20" name="job_name" value="" placeholder="请输入职位名称" required="required" />
					<strong class="kbShopAdmin_tip">必填项。职位名称不能超过20个字数。</strong>
				</p>
				
				<p class="kbShopAdmin_enter"><b><i>*</i>职位简述：</b><input type="text" maxlength="54" name="job_title" value="" placeholder="请输入职位描述" required="required"/>
					<strong class="kbShopAdmin_tip">必填项。职位简述不能超过54个字数。两行文字显示，如不能则省略号代替</strong>
				</p>
				<p class="kbShopAdmin_enter"><b><i>*</i>职位薪酬：</b><input type="text" maxlength="54" name="payment" value="" placeholder="请输入职位薪酬" required="required"/>
					<!-- <strong class="kbVipAdmin_tip">必填项。职位简述不能超过54个字数。两行文字显示，如不能则省略号代替</strong> -->
				</p>
				<div class="kbShopAdmin_enter">
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
				<div class="kbShopAdmin_operating">
					<div class="kbShopAdmin_restsubmit"> 
						<input  class="kbShopAdmin_button_eee w200 h40 tc" type="reset" value="取消" />
						<input  class="kbShopAdmin_opt w200 h40" type="submit" value="保存" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="kbShopAdmin_alert spAnDynamic_alert">
		<div class="kbShopAdmin_alertBox">
			<button class="kbShopAdmin_alert-close "></button>
			<h3 class="mb10">招聘修改</h3>
			<form class="" action="" method="post" enctype="multipart/form-data">
				<div class="spAnDynamic_alert_from">
				<p class="kbShopAdmin_enter"><b><i>*</i>职位名称：</b><input type="text" maxlength="20" name="job_name" value="" placeholder="请输入职位名称" required="required" />
					<strong class="kbShopAdmin_tip">必填项。职位名称不能超过20个字数。</strong>
				</p>
				<p class="kbShopAdmin_enter"><b><i>*</i>职位简述：</b><input type="text" maxlength="54" name="job_title" value="" placeholder="请输入职位描述" required="required" />
					<strong class="kbShopAdmin_tip">必填项。职位简述不能超过54个字数。两行文字显示，如不能则省略号代替</strong>
				</p>
				<p class="kbShopAdmin_enter"><b><i>*</i>职位薪酬：</b><input type="text" maxlength="54" name="payment" value="" placeholder="请输入职位薪酬" required="required"/>
				</p>
				<div class="kbShopAdmin_enter">
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
				<div class="kbShopAdmin_operating ">
				<div class="kbShopAdmin_restsubmit"> 
					<input  class="kbShopAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
					<input  class="kbShopAdmin_opt w100 h40" type="submit" value="保存" />
				</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
     $(function(){
   		$('.spAnDynamic-operating .kbShopAdmin_add').on('click',function(){
   			$("#kbShopAdmin-edit").siblings().fadeOut();
   			$("#kbShopAdmin-edit").fadeIn();
   		})
   		$('.spAnDynamic-edit .kbShopAdmin_operating input[type="reset"]').on('click',function(){
   			$("#kbShopAdmin-edit").siblings().fadeIn();
   			$("#kbShopAdmin-edit").fadeOut();
   		})
   		$('.spAnDynamic .kbShopAdmin_tdAction .kbShopAdminEdit').on('click',function(){
   			$(".spAnDynamic_alert").fadeIn();
   		})
   		$('.spAnDynamic_alert .kbShopAdmin_operating input[type="reset"]').on('click',function(){
   			$(".spAnDynamic_alert").fadeOut();
   		})
   		$('.kbShopAdmin_checkbox input').on('click',function(){
   			var $this = $(this);
   			var checkStatus = $(this).val();
   			var ID=$this.parent().parent().siblings().eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   			$.get('<?php echo U("Job/ajaxControl");?>',{'flag':'changeNewsStatus',id:ID,status:checkStatus},function(res){
   				Alert((res=="1")? "修改成功":"修改失败");
   			})
   		})
   		$('.kbShopAdminEdit').on('click',function(){
   			var $this=$(this);
   			var ID=$this.parent().siblings().eq(0).text().replace(/(^\s+)|(\s+$)/g, "");

   			$.get('<?php echo U("Job/ajaxControl");?>',{'flag':'selJobInfo',id:ID,},function(res){

	   				for(r in res){
	   					switch(r){
	   						case "job_info":
	   							UE.getEditor('myEditor1').setContent(res.job_info);
	   						break;
	   						default:
	   							$(".spAnDynamic_alert .kbShopAdmin_enter").find('input[name="'+r+'"]').val(res[r]);
	   					}
	   				}

   			})
   			$(".spAnDynamic_alert form").prop('action',"<?php echo U('jobUpdate');?>?id="+ID)
   		})
   		 $('.kbShopAdmin_tdAction .kbShopAdminDel').on('click',function(){
   		 	var $this=$(this);
   		 	var ID=$this.parent().siblings().eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   		 	Confirm("你确定删除该招聘岗位吗？",function(ren){
   		 	 		if(ren){
 			   		 	$.get('<?php echo U("ajaxControl");?>',{flag:'jobDel',id:ID},function(res){
 			   		 		if(res){
 			   		 			$this.parent().parent().remove();
 			   		 			sTip('操作成功');
 			   		 		}else{
 			   		 			eTip('操作成功');
 			   		 		}
 				   		})
   		 	 		}else{
   		 	 		}
   		 	 		console.log(ren);
   		 	});
   		 	
   		 })
   		  $('#kbShopAdmin-edit [required="required"]').bind('change blur',function(){
	         	checkData(this);
		  })
   		 $('#kbShopAdmin-edit .kbShopAdmin_operating input[type="submit"]').on('click',function(){
   			var sStatus = false;
   			console.log($(this));
	          checkData('#kbShopAdmin-edit',function(ren){
	             sStatus=ren;
	          });
	          //数据正确则提交
	          return sStatus;
   		})
   		  $('.kbShopAdmin_pushBtn input').on('click',function(){
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/Job/jobAdd.html';?>")
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