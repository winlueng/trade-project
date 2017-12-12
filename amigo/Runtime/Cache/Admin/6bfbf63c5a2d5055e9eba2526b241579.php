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


	<div id="kbShopAdmin_rightCenter" class="spAnProductClass OrderForm">
		<div class="centerTitle">
			<h1>商品分类</h1>
		</div>
		<div class="kbShopAdmin_operating spAnProductClass-operating" >
			<input class="kbShopAdmin_opt kbShopAdmin_add w80 h30" type="button" value="添加" />
		</div>
		<div class="main-contentBox  kbShopAdmin_mt24" >
			<div class="kbShopAdmin_table">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>分类名称</th>
							<th>分类logo</th>
							<th>所属商品数量</th>
							<th>浏览量</th>
							<th>分类状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($showcate)): foreach($showcate as $key=>$vo): ?><tr>
							<td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vo["classify_name"]); ?></td>
							<td><img src="/Public<?php echo ($vo["classify_logo"]); ?>" width="100" style="margin-top: 3px"></td>
							<td><?php echo ($vo["gnum"]); ?></td>
							<td><?php echo ($vo["visitorTotal"]); ?></td>
							<td>
								<p class="kbShopAdmin_pushBtn">
									<input type="checkbox" value="" <?php echo ($vo['status'] == '0'?'checked':''); ?> title=" <?php echo ($vo['status'] == '0'?'启用':'禁用'); ?>"/>
									<label><b></b></label>
								</p>
								<!-- <p class="kbShopAdmin_checkbox">
									<input  type="radio" name="status<?php echo ($vo["id"]); ?>" value="0"  />
									<label class="font_6ccac9">
										<b class="kbShopAdmin_buttonMr"></b>
										启用
									</label>
								</p>
								<p class="kbShopAdmin_checkbox">
									<input type="radio"  name="status<?php echo ($vo["id"]); ?>" value="1" <?php echo ($vo['status'] == '1'?'checked':''); ?>/>
									<label class="font_ff6c60">
										<b class="kbShopAdmin_buttonMr">
										</b>
										禁用
									</label>
								</p> -->
							</td>
							<td class="kbShopAdmin_tdAction">
								<input class="font_57c8f2 kbShopAdminEdit" type="button" value="" title="编辑"/>
								<input class="font_ff6c60 kbShopAdminDel" type="button" value="" title="删除"/>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
					
				</table>
			</div>
			<!-- 分页位置 -->
			<div class="kbShopAdmin_page">
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
	<div class="kbShopAdmin_alert spAnProductClass_alert">
		<div class="kbShopAdmin_alertBox">
			<button type="button" class="kbShopAdmin_alert-close "></button>
			<form action="" method="post" enctype="multipart/form-data">
				 <h3 class="mb10">添加产品分类</h3>
				<p class="kbShopAdmin_enter"><b><i>*</i>分类名称</b>
				<input type="text" maxlength="6" name="classify_name" value="" placeholder="请输入子分类名字" required="required" />
					
				</p>
				<div class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>分类封面:</b>
						
					<input id="shopImg"  type="file" value="" name="classify_logo"  />
					<label class="" for="shopImg" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为分类封面</span></label>
				</div>
				<p class="kbShopAdmin_enter"><b><i>*</i>描述</b>
				<textarea placeholder="请输入产品描述" name="title" required="required"></textarea>
				</p>
				<div class="kbShopAdmin_operating ">
					<div class="kbShopAdmin_restsubmit"> 
						<input  class="kbShopAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
						<input  class="kbShopAdmin_opt w100 h40" type="submit" value="保存" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="kbShopAdmin_alert spAnProductClass_alertEdit">
		<div class="kbShopAdmin_alertBox">
			<button type="button" class="kbShopAdmin_alert-close "><img src=" " alert="X" /></button>
			<form action="" method="post" enctype="multipart/form-data">
				<h3 class="mb10">编辑产品分类</h3>
				
				<p class="kbShopAdmin_enter"><b><i>*</i>分类名称:</b>
				<input type="text" maxlength="6" name="classify_name" value="" placeholder="请输入子分类名字" required="required" />
				</p>
				<div class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>分类封面:</b>
					<div class="shopImg businessFileImgList">
						<span class="cleraIMG" onclick="clearImg(this)"></span>
					</div>	
					<input id="shopImg1"  type="file" value="" name="classify_logo"  />
					<label class="" for="shopImg1" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为分类封面</span></label>
				</div>
				<p class="kbShopAdmin_enter"><b><i>*</i>描述:</b>
				<textarea placeholder="请输入产品描述" name="title" required="required"></textarea>
				</p>
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
   		$(".spAnProductClass .spAnProductClass-operating  .kbShopAdmin_add").on('click',function(){
   			$(".spAnProductClass_alert").fadeToggle();

   		})
   		$(".kbShopAdmin_alert  .kbShopAdmin_operating input[type='reset']").on('click',function(){
   			$(".kbShopAdmin_alert").fadeOut();
   		})
   		$(".spAnProductClass .kbShopAdmin_tdAction .kbShopAdminEdit").on('click',function(){
   			$(".spAnProductClass_alertEdit").fadeToggle();
   			var ID = $(this).parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   			$.get('<?php echo U("ajaxControl");?>',{flag:'selClassifyInfo',id:ID},function(res){
   				for(r in res){
   					console.log(r);
   					switch(r){
   						/* case 'pid':
   							$(".spAnProductClass_alertEdit form select").find('option[value="'+res.pid+'"]').prop('selected',true);
   						break; */
   						case 'title':
   							$('.spAnProductClass_alertEdit form').find('textarea[name="'+r+'"]').val(res[r]);
   						break;
   						case 'classify_name':
   							$('.spAnProductClass_alertEdit form').find('input[name="classify_name"]').val(res.classify_name);
   						break;
   						case 'classify_logo':
   							$('.spAnProductClass_alertEdit form').find('.kbShopAdmin_fileImg .businessFileImgList').append("<img src='/Public"+res.classify_logo+"' alt='产品分类图片' />");
   						break;
   					}
   				}
   			});
   			$('.spAnProductClass_alertEdit form').prop('action',"<?php echo U('goodsClassifyUpdate');?>?id="+ID);
   		})
   		 $('.kbShopAdmin_tdAction .kbShopAdminDel').on('click',function(){
   		 	var $this = $(this);
   		 	var ID =$this.parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
   		 	
   		 	Confirm("你确定删除该分类吗？",function(ren){

   		 		if(ren){
   		 			
   		 			$.get('<?php echo U("ajaxControl");?>',{flag:'goodsClassifyDel',id:ID},function(res){
		   		 		if(res){
		   		 			oTip(res);
		   		 			console.log(res);
			   		 			if(res!="当前分类下存在存在商品,不能删除!"){

			   		 			 	$this.parent().parent().remove();
			   		 			}
		   		 		}
   		 			})
   		 		}else{
   		 			eTip('操作失败')
   		 		}
   		 	});
   		 	
   		 });
   		 $('.kbShopAdmin_pushBtn input').on('click',function(){
   		 	 var $this=$(this);
   		 	 var ajaxUrl='<?php echo U("ajaxControl");?>';
   		 	 var Status=$this.is(':checked')?0:1;
   		 	 var ID = $this.parents('tr').children().eq(0).text().trim();
   		 	 // console.log(Status);
   		 	 $.get(ajaxUrl,{
   		 	 	flag:'changeGoodsClassifyStatus',
	   		 	status:Status,
	   		 	id:ID
   		 	 },function(res){
   		 	 	if(!res.status){
   		 	 		Alert("当前分类下存在子类或存在商品不能被修改状态")
   		 	 		$this.attr('checked',Status)
   		 	 	}else{
   		 	 		sTip("操作成功")
   		 	 	}

   		 	 	console.log(res);
   		 	 })
   		 
   		 })
     });
    	
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/GoodsClassify/goodsClassifyAdd.html';?>")
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