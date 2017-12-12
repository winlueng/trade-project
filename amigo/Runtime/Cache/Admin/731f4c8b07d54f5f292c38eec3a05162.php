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





	
    
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?version=1.1"></link>
<!-- <script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script> -->
<style>
.kbShopAdmin_checkboxChosen input:checked+label span{
	display:none;
}
</style>


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


	<div id="kbShopAdmin_rightCenter" class="spAnProductList OrderForm">
		<div class="centerTitle">
			<h1>商品列表</h1>
		</div>
		<div class="kbShopAdmin_operating filter-operating" >
			<form class="mr10" action="<?php echo U('goodsList');?>" method="get">
				<select class="kbShopAdmin_slt w200 h30" name="classify_id" title="可选择分类查找相关商品" >
					<option value="">所有分类</option>
					<?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id']==$_GET['classify_id']?'selected':''); ?> >
							<?php echo ($v['classify_name']); ?>
						</option><?php endforeach; endif; ?>
				</select>
				<button class="kbShopAdmin_opt w80 h30" >确定</button>
			</form>
			<form>
				<div class="filter-searchDate mr10">
						<input type="search" name="selName" value="" placeholder="请输入想要查找的内容">
						<input class="kbShopAdmin_opt w80 h30 fr" type="submit" value="确定">
				</div>
				
			</form>
		</div>
		<div class="main-contentBox kbShopAdmin_mt24" >
			<div class="kbShopAdmin_table">
				<table>
					<thead>
						<tr>
							<th width="50">序号</th>
							<th>产品名称</th>
							<th width="100">价格</th>
							<th width="200">图片</th>
							<th>分类</th>
							<th>浏览量</th>
							<th>添加时间</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(empty($list)): ?><tr ><td colspan="8"><span style="color:#F209CA;font-size:20px">暂无产品数据</span></td></tr>
					<?php else: ?>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["goods_name"]); ?></td>
							<td>￥<?php echo ($v["price"]); ?></td>
							<td class="kbShopAdmin_tdImg" width="200">
								<div>
								<img src="/Public<?php echo ($v['goods_logo']); ?>" height="200" alt="商品图片" />
								</div>
							</td>
							<td><?php echo ($v["classify_name"]); ?></td>
							<td><?php echo ($v['click_total']?$v['click_total']:0); ?></td>
							<td><?php echo date('Y年m月d日', $v['addtime']);?></td>
							<td>
								<div>
									<p class="kbShopAdmin_checkbox kbShopAdmin_checkboxNew">
										<input  type="checkbox" name="status<?php echo ($v["id"]); ?>" <?php echo ($v['status'] == '4'?'checked':''); ?> />
										<label class="font_6ccac9">
											<b class="kbShopAdmin_buttonMr"></b>
											新品
										</label>
									</p>
									<p class="kbShopAdmin_checkbox kbShopAdmin_checkboxHot">
										<input  type="checkbox" name="status<?php echo ($v["id"]); ?>" <?php echo ($v['status'] == '2'?'checked':''); ?> />
										<label class="font_6ccac9">
											<b class="kbShopAdmin_buttonMr"></b>
											热销
										</label>
									</p>
									<p class="kbShopAdmin_checkbox kbShopAdmin_checkboxdisabled">
										<input type="checkbox"  name="status<?php echo ($v["id"]); ?>" <?php echo ($v['status'] == '3'?'checked':''); ?> />
										<label class="font_ff6c60">
											<b class="kbShopAdmin_buttonMr">
											</b>
											禁用
										</label>
									</p>
									<!-- <p class="kbShopAdmin_checkbox kbShopAdmin_checkboxNew">
										<input type="checkbox"  name="status<?php echo ($v["id"]); ?>"  />
										<label class="font_ff6c60">
											<b class="kbShopAdmin_buttonMr">
											</b>
											新品
										</label>
									</p> -->
								</div>
							</td>
							<td class="kbShopAdmin_tdAction">
								
								<a href="<?php echo U('preview', ['id' => $v['id']]);?>" class="kbShopAdminSea w30 h20 copyButton-default" target="view_window" ></a>
								<a href="<?php echo U('goodsUpdate', ['id' => $v['id']]);?>" class="font_57c8f2   kbShopAdminEdit choose w30 h20" title="编辑"></a>

								<input class="font_ff6c60 kbShopAdminDel" type="button" value="" title="删除" />
								
								<input class="font_ff6c60 kbShopAdminIsTop" type="button" value="" title="置顶" />
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody><?php endif; ?>
				</table>
			</div>
			<div class="kbShopAdmin_page">
				<div class="pageSize">
					<?php echo ($page); ?>
				</div>
				<div class="pageJump">
				<form>	
					<input class="w60  fl" type="text" name="p" value="<?php echo I('get.p');?>" />
					<input type="submit" class="fl" value="跳转">
				</form>
				</div>
			</div>
		</div>
	</div>
	
	
<script type="text/javascript">
    $(function(){
   		

   		

   		$('.spAnProductList .kbShopAdmin_table .kbShopAdmin_slt').on('change',function(){
   			var ID = $(this).parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   			var seleStatus = $(this).val().replace(/(^\s+)|(\s+$)/g, "");
   			
   			$.get('<?php echo U("ajaxControl");?>',{flag:'changeGoodsStatus',id:ID,status:seleStatus},function(res){
	   		 		if(res){
	   		 			oTip(res);
	   		 	}
	   		})
   		 })
   		
   		
   		 $('.kbShopAdmin_tdAction .kbShopAdminDel').on('click',function(){
   		 	var $this = $(this);
   		 	var ID =$this.parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   		 	Confirm("你确定删除该商品？",function(ren){
   		 		if(ren){
   		 			 $.get('<?php echo U("Goods/ajaxControl");?>',{flag:'goodsDel',id:ID},function(res){
	   		 			if(res){
	   		 			 	$this.parent().parent().remove();
		   		 			 oTip(res);
	   		 			}
	   				})
   		 		}else{
   		 			console.log("不删除");
   		 		}
   		 	});
   		
   		 });

   		});
    	$('.kbShopAdminIsTop').on('click',function(){
    		var $this = $(this);
   		 	var ID =$this.parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   		 	Confirm('是否推荐到主平台首页',function(res){
   		 		if(res){
		   		 	$.ajax({
		   		 		type:"GET",
		   		 		url:"<?php echo U('GoodsStick/ajaxControl');?>",
		   		 		data:{
		   		 			flag: 'company_stick_to_project',
							id:ID
			   		 	},
		   		 		dataType:'json',
		   		 		success:function(data){
		   		 			if(data.status){
		   		 				sTip('操作成功');
		   		 			}else{
		   		 				eTip('操作失败');
		   		 			}
		   		 		},
		   		 		error:function(error){
		   		 			console.log(error);
		   		 			eTip('操作失败')
		   		 		}
		   		 	})
   		 		}
   		 	})
    	})
     	function delPic(obj) 
     	{	
     		var res = confirm('确定删除图片吗?');
     		if (res) 
     		{
     			$.get("<?php echo U('Goods/ajaxControl');?>", {flag:'delGoodsPicture',id:$(obj).attr('picid')},function (res){
     				if (res) 
     				{
     					alert('删除成功');
     					clearImg($(obj));
     				}else{
     					alert('删除失败');
     				}
     			});
     		}
     	}

    $(function(){
   		
   		$(".spAnProductList_alert  .kbShopAdmin_operating input[type=reset]").on('click',function(){
   			console.log("aaa");
   			$(".spAnProductList_alert").fadeOut();

   		})
   		// 灰掉置顶和精选按钮
   		// function checkChosen(){
   		// 	var icheckChosen= $(".kbShopAdmin_checkboxChosen input");
   		// 	for(var r=0;r<icheckChosen.length;r++){
   		// 		if($(icheckChosen[r]).is(":checked")){
   		// 			if(!$(icheckChosen[r]).hasClass('audioDisable')){
   		// 				$(icheckChosen[r]).parent().siblings('.kbShopAdmin_checkbox').addClass('kbShopAdmin_checkboxChosenNot');
			  //  			$(icheckChosen[r]).parent().siblings('.kbShopAdmin_checkbox').children('input').prop('disabled','disabled')
   		// 			}
		   			
		   // 		}else{
		   // 			$(icheckChosen[r]).parent().siblings('.kbShopAdmin_checkbox').removeClass('kbShopAdmin_checkboxChosenNot');
		   // 			$(icheckChosen[r]).parent().siblings('.kbShopAdmin_checkbox input').prop('disabled',false)
		   // 		}
   		// 	}
   		// }
   		// checkChosen();
   		/* 商户后台置顶*/
   		$('.kbShopAdmin_checkboxHot input').on('change',function(){
   			var $this=$(this);
   			var  Status=($this.is(":checked")===true)? 2:1;
   			var ajaxUrl='<?php echo U("Goods/ajaxControl");?>';
   			if(!$this.prop('disabled')){
	   			jsAjaxControl($this,{
						ajaxURL:ajaxUrl,
				        ajaxBranch:'Common',
				        params:{//这是ajax需要提交的集合
				        	flag:"stickByCompany",
				        	status:Status,
				        }
				},function(res){
						oTip(res);
						if(res="修改状态成功"){
							$this.parent().siblings('.kbShopAdmin_checkboxChosen').fadeToggle();
							$this.parent().siblings('.kbShopAdmin_checkboxdisabled').children('input').prop('checked',false)
						}

				})
	   		}
   		})
   		$('.kbShopAdmin_checkboxdisabled input').on('change',function(){
   			var $this=$(this);
   			var  Status=($this.is(":checked")===true)? 3:1;
   			var ajaxUrl='<?php echo U("Goods/ajaxControl");?>';
   			if(!$this.prop('disabled')){
   			jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
			        ajaxBranch:'Common',
			        params:{//这是ajax需要提交的集合
			        	flag:"changeGoodsStatus",
			        	status:Status,
			        }
				},function(res){
					oTip(res);
					$this.parent().siblings('.kbShopAdmin_checkboxTop').children('input').prop('checked',false)
			})
			}
   		})
 		$('.kbShopAdmin_checkboxNew input').on('click',function(){
 			var $this=$(this);
   			var  Status=$this.prop("checked")? 4:1;
   			var ajaxUrl='<?php echo U("Goods/ajaxControl");?>';
   			var id=$this.parents('tr').children('td').eq(0).text();
   			$.ajax({
   				type:"GET",
   				url:ajaxUrl,
   				data:{
   					flag:"stickByCompany",
   					id:id,
   					status:Status
   				},
   				dataType:'json',
   				success:function(data){
   					if(data.status){
   						sTip('操作成功');
   					}else {
   						$this.attr('checked',Status==4?true:false)
   						eTip('操作失败');
   					}
   				},
   				error:function(error){

   				}
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/Goods/goodsList.html';?>")
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