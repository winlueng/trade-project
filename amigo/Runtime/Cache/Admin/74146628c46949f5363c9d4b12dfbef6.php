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
	

	<div id="kbVipAdmin_rightCenter" class="spAnProductClass OrderForm">
		<?php  ?>
		<div class="centerTitle">
			<h1>品牌管理</h1>
		</div>
		<div class="kbVipAdmin_operating spAnProductClass-operating" >
			<input class="kbVipAdmin_opt kbVipAdmin_add w80 h30" type="button" value="添加" />
		</div>
		<div class="main-contentBox  kbVipAdmin_mt24" >
			<div class="kbVipAdmin_table">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>品牌名称</th>
							<th>简述</th>
							<th>所属商品数量</th>
							<!-- <th>浏览量</th> -->
							<th>分类状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
							<td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vo["brand_name"]); ?></td>
							
							<td><?php echo ($vo["brand_describe"]); ?></td>
							<td><?php echo ($vo["goodsCount"]); ?></td>
							<td>
								<p class="kbVipAdmin_pushBtn">
									<input type="checkbox" value="" <?php echo ($vo['status'] == '0'?'checked':''); ?> title=" <?php echo ($vo['status'] == '0'?'启用':'禁用'); ?>"/>
									<label><b></b></label>
								</p>
								
							</td>
							<td class="kbVipAdmin_tdAction">
								<input class="font_57c8f2 kbVipAdminEdit" type="button" value="" title="编辑"/>
								<input class="font_ff6c60 kbVipAdminDel" type="button" value="" title="删除"/>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
			<!-- 分页位置 -->
			<div class="kbVipAdmin_page">
				<div class="pageSize">
					<a class="prevPage"  href="javascript:;"></a>
					<p class="pageNum"><span>1</span><span>/</span><span>3</span></p>
					<a class="nextPage" href="javascript:;"></a>
				</div>
				<div class="pageJump">			
					<input class="w60  fl" type="text" value="" />
					<a class="fl" href="javascript:;">跳转</a>
				</div>
			</div>
		</div>

	</div>

	<div class="kbVipAdmin_alert spAnProductClass_alert">
		<div class="kbVipAdmin_alertBox">
			<button type="button" class="kbVipAdmin_alert-close "></button>
			<form action="" method="post" enctype="multipart/form-data">
				 <h3 class="mb10">添加品牌</h3>
				<p class="kbVipAdmin_enter"><b><i>*</i>品牌名称</b>
				<input type="text" maxlength="6" name="brand_name" value="" placeholder="请输入子品牌名字" required="required" />
					<strong class="kbVipAdmin_tip">必填项。品牌名字不能超过6个字数</strong>
				</p>
				<div class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>品牌封面:</b>
						
					<input id="shopImg"  type="file" value="" name="brand_logo"  />
					
					<label class="" for="shopImg" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为品牌封面</span></label>
				</div>
				<p class="kbVipAdmin_enter"><b>品牌简述</b>
				<textarea placeholder="请输入品牌描述" name="brand_describe" ></textarea>
				</p>
				<div class="kbVipAdmin_operating ">
					<div class="kbVipAdmin_restsubmit"> 
						<input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
						<input  class="kbVipAdmin_opt w100 h40" type="submit" value="保存" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="kbVipAdmin_alert spAnProductClass_alertEdit">
		<div class="kbVipAdmin_alertBox">
			<button type="button" class="kbVipAdmin_alert-close "><img src=" " alert="X" /></button>
			<form action="" method="post" enctype="multipart/form-data">
				<h3 class="mb10">编辑品牌</h3>
				
				<p class="kbVipAdmin_enter"><b><i>*</i>品牌名称:</b>
				<input type="text" maxlength="6" name="brand_name" value="" placeholder="请输入子品牌名字" required="required" />
				<strong class="kbVipAdmin_tip">必填项。子品牌名字不能超过6个字数</strong>
				</p>
				<div class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>品牌封面:</b>
					<div class="shopImg businessFileImgList">
						<span class="cleraIMG" onclick="clearImg(this)"></span>
					</div>	
					<input id="shopImg1"  type="file" value="" name="brand_logo"  />
					<label class="" for="shopImg1" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为品牌封面</span></label>
				</div>
				<p class="kbVipAdmin_enter"><b>品牌简述:</b>
				<textarea placeholder="请输入产品描述" name="brand_describe" maxlength="10" ></textarea>
				</p>
				<div class="kbVipAdmin_operating ">
					<div class="kbVipAdmin_restsubmit"> 
						<input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
						<input  class="kbVipAdmin_opt w100 h40" type="submit" value="保存" />
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/GoodsBrand/brandAdd'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
<script type="text/javascript">
 $(function(){
 	vueMethods.myTitile(); 
	$(".spAnProductClass .spAnProductClass-operating  .kbVipAdmin_add").on('click',function(){
		$(".spAnProductClass_alert").fadeToggle();
		vueMethods.maxLength(); 

	})
	$(".kbVipAdmin_alert  .kbVipAdmin_operating input[type='reset']").on('click',function(){
		$(".kbVipAdmin_alert").fadeOut();

	})
	$(".spAnProductClass .kbVipAdmin_tdAction .kbVipAdminEdit").on('click',function(){

		$(".spAnProductClass_alertEdit").fadeToggle();
		vueMethods.maxLength(); 
		var ID = $(this).parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
		$.get('<?php echo U("ajaxControl");?>',{flag:'selBrandInfo',id:ID},function(res){
			for(r in res){
				switch(r){
					case 'brand_describe':
						$('.spAnProductClass_alertEdit form').find('textarea[name="'+r+'"]').val(res[r]);
					break;
					case 'brand_name':
						$('.spAnProductClass_alertEdit form').find('input[name="brand_name"]').val(res.brand_name);
					break;
					case 'brand_logo':
						$('.spAnProductClass_alertEdit form').find('.kbVipAdmin_fileImg .businessFileImgList').append("<img src='/Public"+res.brand_logo+"' alt='产品品牌图片' />");
					break;
				}
			}
		});
		$('.spAnProductClass_alertEdit form').prop('action',"<?php echo U('brandUpdate');?>?id="+ID);
	})
	 $('.kbVipAdmin_tdAction .kbVipAdminDel').on('click',function(){
	 	var $this = $(this);
	 	var ID =$this.parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
	 	Confirm("你确定进行该删除操作吗？",function(ren){
	 		if(ren){
	 			$.get('<?php echo U("ajaxControl");?>',{flag:'del',id:ID,status:'-1'},function(res){
   		 		if(res){
   		 			oTip(res);
   		 			$this.parent().parent().remove();
   		 		}
	 			})
	 		}
	 	});
	 	
	 });
	 $('.kbVipAdmin_pushBtn input').on('click',function(){
	 	 var $this=$(this);
	 	 var ajaxUrl='<?php echo U("ajaxControl");?>';
	 	 var Status=$this.is(':checked')?0:1;
	 	  var ID = $this.parents('tr').children().eq(0).text().trim();
	 	$.get(ajaxUrl,{
	 	 	flag:'del',
		 	status:Status,
		 	id:ID
	 	 },function(res){
	 	 	if(res!="操作成功"){
	 	 		$this.attr('checked',false)
	 	 		oTip(res)
	 	 	}else{
	 	 		sTip(res)
	 	 	}
	 	 	console.log(res);
	 	 })
	 	
	 })
 });
</script>

</body>
</html>