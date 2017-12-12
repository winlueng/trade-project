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





	
    
<?php ?>
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css"></link>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>

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



	<div id="kbShopAdmin_rightCenter" class="spAnAdClass OrderForm">
		<div class="centerTitle">
			<h1>动态分类</h1>
		</div>
		<div class="kbShopAdmin_operating spAnAdClass-operating" >
			<input class="kbShopAdmin_opt w80 h30 kbShopAdmin_add " type="button" value="添加" />
		</div>
		<div class="main-contentBox kbShopAdmin_mt24" >
			<div class="kbShopAdmin_table">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>类型</th>
							<th>描述</th>
							<th>动态logo</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(empty($list)): ?><tr ><td colspan="8"><span style="color:#F209CA;font-size:20px">暂无动态分类数据</span></td></tr>
					<?php else: ?>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["news_type_name"]); ?></td>
							<td><?php echo ($v["title"]); ?></td>
							<td><img src="/Public<?php echo ($v["news_classify_logo"]); ?>" width="100"></td>
							<td>
								<p class="kbShopAdmin_pushBtn">
									<input type="checkbox" value="<?php echo ($v['status']); ?>" <?php echo ($v['status'] == '0'?'checked':''); ?> title="<?php echo ($v['status'] == '0'?'启用':'禁用'); ?>"/>
									<label><b></b></label>
								</p>
								<!-- <p class="kbShopAdmin_checkbox">
									<input  type="radio" name="status<?php echo ($v["id"]); ?>" value="0" <?php echo ($v['status'] == '0'?'checked':''); ?>  />
									<label class="font_6ccac9">
										<b class="kbShopAdmin_buttonMr"></b>
										启用
									</label>
								</p>
								<p class="kbShopAdmin_checkbox">
									<input type="radio"  name="status<?php echo ($v["id"]); ?>" value="1" <?php echo ($v['status'] == '1'?'checked':''); ?>/>
									<label class="font_ff6c60">
										<b class="kbShopAdmin_buttonMr">
										</b>
										禁用
									</label>
								</p> -->
							</td>
							<td class="kbShopAdmin_tdAction">
								<input class="font_57c8f2 kbShopAdminEdit" type="button" value="" title="编辑" />
								<input class="font_ff6c60 kbShopAdminDel" type="button" value="" title="删除" />
							</td>
						</tr><?php endforeach; endif; endif; ?>
					</tbody>
				</table>
			</div>
			<div class="kbShopAdmin_page">
				<div class="pageSize">
					<?php echo ($page); ?>
				</div>
				<div class="pageJump">
				<form action="<?php echo U('orderList');?>">	
					<input class="w60  fl" type="text" name="p" value="<?php echo I('get.p');?>" />
					<input type="submit" class="fl" value="跳转">
				</form>
				</div>
			</div>
		</div>
		
	</div>
	<div class="kbShopAdmin_alert spAnAdClass_alert">
		<div class="kbShopAdmin_alertBox">
			<button type="button" class="kbShopAdmin_alert-close "></button>
			<form action="" method="post" enctype="multipart/form-data">
				<h3 class="mb10">添加动态分类</h3>
				<p class="kbShopAdmin_enter"><b><i>*</i>分类名称:</b>
					<input type="text" value="" name="news_type_name" maxlength="6" placeholder="请输入动态类别" required="required" 
					data-datatype="input" 
					/>
					<strong class="kbShopAdmin_tip">必填项。分类名称输入字符不能超过六个</strong>
				</p>
				<div class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>动态分类封面:</b>
					<input id="shopImg2" name="news_classify_logo" type="file" value=""/>
					<label class="" for="shopImg2" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为分类封面</span></label>
					<strong class="kbShopAdmin_tip">必填项。上传格式为jpg或png的图片，大小不超过200k，仅可上传一张图片</strong>
				</div>
				<p class="kbShopAdmin_enter"><b>分类描述:</b>
					<textarea name="title" maxlength="10" placeholder="请输入分类描述" data-datatype="input"  ></textarea>
					<strong class="kbShopAdmin_tip">选填项。分类描述输入字符不能超过十个</strong>
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
	<div class="kbShopAdmin_alert spAnAdClass_alertEdit">
		<div class="kbShopAdmin_alertBox">
			<button type="button" class="kbShopAdmin_alert-close "></button>
			<form action="" method="post" enctype="multipart/form-data">
				<h3 class="mb10">编辑动态分类</h3>
				<p class="kbShopAdmin_enter"><b><i>*</i>分类名称:</b>
					<input type="text" value="" name="news_type_name" maxlength="6" placeholder="请输入动态类别"
					required="required" 
					data-datatype="input" 
					/>
					<strong class="kbShopAdmin_tip">必填项。分类名称输入字符不能超过六个</strong>
				</p>
				<div class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>动态分类封面:</b>
					<div class="shopImg businessFileImgList"><span class="cleraIMG" onclick="clearImg(this)"></span>
					</div>
					<input id="shopImg1" name="news_classify_logo" type="file" value=""/>

					<label class="" for="shopImg1" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为分类封面</span></label>
					<strong class="kbShopAdmin_tip">必填项。上传格式为jpg或png的图片，大小不超过200k，仅可上传一张图片</strong>
			</div>
				<p class="kbShopAdmin_enter"><b><i>*</i>分类描述:</b>
					<textarea name="title" maxlength="10" placeholder="请输入分类描述" required="required" data-datatype="input"></textarea>
					<strong class="kbShopAdmin_tip">必填项。分类描述输入字符不能超过十个</strong>
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
   		$('.spAnAdClass .spAnAdClass-operating .kbShopAdmin_add').on('click',function(){
   			$('.spAnAdClass_alert').fadeIn();
   			var checkData=new CheckData('.spAnAdClass_alert');
   			$('.spAnAdClass_alert .kbVipAdmin_restsubmit [type=submit]').on('click',function(){
   				return checkData.verify();
   			})
   			vueMethods.maxLength();
   		});
   		
   		
   		$('.spAnAdClass .kbShopAdmin_tdAction .kbShopAdminEdit').on('click',function(){
   			var $this= $(this);
   			$('.spAnAdClass_alertEdit').fadeIn();
   			var ajaxUrl='<?php echo U("ajaxControl");?>';
   			var ID = $($this).parents('tr').children().eq(0).text().trim();
   			jsAjaxControl($this,{
   				ajaxURL:ajaxUrl,
   				params:{
   					flag:"selNewsClassifyInfo",
   				}
   			},function(res){
   				for(r in res){
   					switch(r){
   						case 'news_classify_logo':
   							$('.spAnAdClass_alertEdit').find('.kbShopAdmin_fileImg .businessFileImgList').append('<img src="/Public'+res.news_classify_logo+'" alt="动态分类图" />')
   						break;
   						default:
   							if($(".spAnAdClass_alertEdit [name="+r+"]").length){
   								$(".spAnAdClass_alertEdit [name="+r+"]").val(res[r])
   							}
   						break;
   					}
   				}
   				$(".spAnAdClass_alertEdit").find('form').prop('action','<?php echo U("newsClassifyUpdate");?>?id='+res.id);
   				vueMethods.maxLength();
   				var checkData=new CheckData('.spAnAdClass_alertEdit');
   				$('.spAnAdClass_alertEdit .kbVipAdmin_restsubmit [type=submit]').on('click',function(){
   					return checkData.verify();
   				})
   			})
   		});
   		$('.kbShopAdmin_alert .kbShopAdmin_operating input[type=reset]').on('click',function(){
   			$('.kbShopAdmin_alert').fadeOut();
   		});
   		// newsClassifyStatus
   		 $('.kbShopAdmin_pushBtn input').on('click',function(){
   		 	 var $this=$(this);
   		 	 var ajaxUrl='<?php echo U("ajaxControl");?>';
   		 	 var Status=$this.is(':checked')?0:1;
   		 	 var ID = $this.parents('tr').children().eq(0).text().trim();
   		 	 // console.log(Status);
   		 	 $.get(ajaxUrl,{
   		 	 	flag:'newsClassifyStatus',
	   		 	status:Status,
	   		 	id:ID
   		 	 },function(res){
   		 	 	if(res!=1){
   		 	 		$this.attr('checked',false)
   		 	 		eTip('操作失败')
   		 	 	}else{
   		 	 		sTip('操作成功')
   		 	 	}
   		 	 	console.log(res);
   		 	 })
   		 
   		 })
   		$('.kbShopAdminDel').on('click',function(){
   			var $this= $(this);
   			var ajaxUrl='<?php echo U("ajaxControl");?>';
   			Confirm("确定进行该操作吗？",function(res){
   				if(res){
   					
		   			jsAjaxControl($this,{
		   				ajaxURL:ajaxUrl,
		   				params:{
		   					flag:"newsClassifyDel",
		   				}
		   			},function(res){
		   				console.log(res);
		   				if(res=="1"){
		   					sTip("操作成功");
		   					 $this.parents('tr').remove();
		   				}else{
		   					oTip(res);
		   				}

		   			})
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/NewsClassify/newsClassifyList.html';?>")
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