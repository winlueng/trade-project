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





	
    
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?v=1"></link>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
	<link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">


<style>
	.filterData{
		display:inline-block;
		width:40%;
	}
	#kbShopAdmin_rightCenter .filterData .ui-datepicker-time{
		width:100%;
		 text-indent: 40px;
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


	<div id="kbShopAdmin_rightCenter" class="spAnProductAdd">
		<div class="centerTitle">
		
			<h1>产品添加</h1>
		</div>
		<div class="spAnProductAdd kbShopAdmin_box">
			<form  action="<?php echo U('goodsAdd');?>" method="post" class="checkForm" enctype="multipart/form-data">
				<!-- <h3 class="mt20 mt10 tc">产品添加</h3> -->
				<div class="formData">
					<ul class="mt20" id="myTemplate">
						<li class="kbShopAdmin_enter" >
							<b><i>*</i>商品名称:</b>
							<input type="text" value="" placeholder="请输入商品名字"    maxlength="30" name="goods_name" required="required"
							data-datatype="input"
							/>
						</li>
						<li class="kbShopAdmin_enter"><b><i>*</i>商品价格:</b>
						<input  type="text" name="price" value="" placeholder="请输入商品价格" required="required"  
						  data-datatype="input" 
						  data-regexp="posititveNum"
						/>
						</li>
						<li class="kbShopAdmin_enter"><b>促销:</b>
							<p class="kbShopAdmin_radio">
								<input type="radio" value="1" name="is_discount"  required="required"> <label><b></b></label>
							</p>
							 <span class="radioText">是</span> 
							<p class="kbShopAdmin_radio">
								<input type="radio" value="0" name="is_discount" checked="checked" required="required">
								<label><b></b></label>
							</p> 
							<span class="radioText">否</span>
							
						</li>
						<li class="kbShopAdmin_enter ">
							<b>促销日期:</b>
							<div class="filterData w">
								<input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
								<input class="start" type="hidden" name="sales_start_time" value="" />
								<input  class="end"  type="hidden" name="sales_end_time" value="" />
							</div>
						</li>
						<li class="kbShopAdmin_enter"><b>促销折扣:</b><input  type="number" name="discount" value="" placeholder="请输入促销折扣" 
						data-regexp="posititveNum"
						data-datatype="input"
						/>
							
						</li>
						<!-- <li class="kbShopAdmin_enter">
							<b><i>*</i>商品简述:</b>
							<textarea name="describe" required="required"></textarea>
						</li> -->
						<li class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>商品封面:</b>
							
							<input id="shopImg" name="goods_logo" type="file" value="dafult"  />
							<label class="" for="shopImg">
								<span style="font-size:27px">+</span><br />
								<span>选择一张图片作为商品封面</span>
							</label>
							
						</li>
						<li class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>商品图片:</b>
							<div class="fileImgMore">
							<input id="shopImg1"  type="file" name="pic_path[]" multiple="multiple" value="dafult" />
							<label class="" for="shopImg1" >
								<span style="font-size:27px">+</span><br />
								<span>可选择五张图片作为商品图片</span>
							</label>
							</div>
						</li>
						<li class="kbShopAdmin_enter "><b><i>*</i>商品分类:</b>
							<select name="classify_id" class="kbShopAdmin_slt kbShopAdmin_sltblack" required="required"
							data-datatype="select"
							>
							<option value="-1">请选择商品分类</option>
							<?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" /><?php echo ($v['classify_name']); endforeach; endif; ?>
						</select>
						
						</li>
						<li class="kbShopAdmin_enter "><b>商品品牌:</b>
							<select name="brand_id" class="kbShopAdmin_slt kbShopAdmin_sltblack" 
							data-datatype="select"
							>
							<option value="-1">请选择商品品牌</option>
								<?php if(is_array($brandList)): foreach($brandList as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" /><?php echo ($v['brand_name']); endforeach; endif; ?>
							</select>
						
						</li>
						<li class="kbShopAdmin_enter">
							<b><i>*</i>商品重量:</b>
							<input type="text" name="weight" value="" placeholder="单位g" required="required"
							data-datatype="input" 
							data-regexp="posititveNum" 
							/>
						</li>
						<li class="kbShopAdmin_enter">
							<b><i>*</i>商品邮费:</b>
							<input type="text" name="express_price" min="0" value="0" placeholder="默认0元" required="required"
							data-datatype="input" 
							data-regexp="posititveNum" 
							/>
						</li>
					
						<li class="kbShopAdmin_enter">
							<b><i>*</i>属性名称:</b>
							<input type="text" name="attr_name" value="" placeholder="属性名称" maxlength="8" 
							required="required"  
							data-datatype="input"  
							
							 />
						</li>

						<li class="kbShopAdmin_enter property">
							<p class="adminProperty">
								<button  id="addProperty" type="button" class="addProperty kbShopAdmin_opt w50 h30"  v-on:click="addPropertyTemp" >添加</button>
								<!-- <button type="button" class="delProperty kbShopAdmin_opt w50 h30">删除</button> -->
							</p>
							<p>
								<b><i>*</i>属性值:</b>
								<input type="text" name="attr_val[]" value=""  placeholder="属性值" 
								maxlength="8" 
								required="required" 
								data-datatype="input" 
								/>
							</p>
							<p>
								<b><i>*</i>价格:</b>
								<input type="text" name="attr_price[]" value="" placeholder="价格"
								required="required"
								data-datatype="input" 
								data-regexp="posititveNum"
								 />
							</p>
							<p>
								<b><i>*</i>库存量:</b>
								<input type="number" name="inventory_total[]" value="" placeholder="库存量"
								/>
							</p>
							<p class="">
								<b>相应图片:</b>
								<input id="attrImg1" type="file" name="attrPic"  class="attrPic" onchange="attpic(this)"/>
								<label class="" for="attrImg1" >
									<span style="font-size:27px">+</span><br />
									<span>选择一张图片作为属性封面，图片不得大于500kb</span>
								</label>
								<input type="hidden" name="attr_pic[]" value="1" class="attr_pic_text">
							</p>
						</li>

						 <li is="my-components" v-bind:id="lengths"  v-for="(lengths, index) in lengths"   ></li>
						
					</ul>
						<div class="kbShopAdmin_enter">
							<b>产品描述详情:</b>
							<div id="myEditor" class="myEditor">
								<script id="container" name="goods_title" type="text/plain">
								
							    </script>
							  
							    <!-- 实例化编辑器 -->
							    <script type="text/javascript">
							        var ue = UE.getEditor('container',{
							        		'initialFrameHeight':360,
							        		// 'initialContent':'在这里你可以布置好你商品详情的资料'
							        });
							        $(function(){
							        	var html = '<p><img src="http://company.chinaimigo.com/Public/JS/module/ueditor/php/upload/18661511281786.jpg"/></p><p><img src="http://project.chinaimigo.com/Public/JS/module/ueditor/php/./upload1/20171113/1510535755933881.png" style="float:none;" title="商场购买流程.png"/></p><p><img src="http://project.chinaimigo.com/Public/JS/module/ueditor/php/./upload1/20171113/1510535755663007.png" style="float:none;" title="退换货流程.png"/></p><p style="margin-top:0;margin-right:0;margin-bottom:0;text-indent:0;padding:0 0 0 0 ;line-height:32px;background:rgb(255,255,255)"><span style="font-family: 微软雅黑;color: rgb(228, 57, 60);letter-spacing: 0;font-size: 16px">&nbsp;</span><strong><span style="font-family: 微软雅黑;color: rgb(228, 57, 60);letter-spacing: 0;font-size: 16px"><span style="font-family:微软雅黑">卖家服务</span></span></strong></p><p style="margin-top:0;margin-right:0;margin-bottom:0;text-indent:0;padding:0 0 0 0 ;line-height:32px;background:rgb(255,255,255)"><strong><span style="font-family: 微软雅黑;color: rgb(228, 57, 60);letter-spacing: 0;font-size: 16px"><span style="font-family:微软雅黑">阿密购</span></span></strong><strong><span style="font-family: 微软雅黑;color: rgb(228, 57, 60);letter-spacing: 0;font-size: 16px"><span style="font-family:微软雅黑">承诺</span></span></strong></p><p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;text-indent:0;padding:0 0 0 0 ;line-height:18px;background:rgb(255,255,255)"><span style="font-family: 宋体;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:宋体">阿密购</span></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">平台卖家销售并发货的商品，由平台卖家提供发票和相应的售后服务。请您放心购买！</span></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><br/></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</span></span></p><p style="margin-top:0;margin-right:0;margin-bottom:0;text-indent:0;padding:0 0 0 0 ;line-height:32px;background:rgb(255,255,255)"><strong><span style="font-family: 微软雅黑;color: rgb(228, 57, 60);letter-spacing: 0;font-size: 16px"><span style="font-family:微软雅黑">正品行货</span></span></strong></p><p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;text-indent:0;padding:0 0 0 0 ;line-height:18px;background:rgb(255,255,255)"><span style="font-family: 宋体;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:宋体">阿密购</span></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">商城向您保证所售商品均为正品行货</span></span><span style="font-family: 宋体;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px">.</span></p><p style="margin-top:0;margin-right:0;margin-bottom:0;text-indent:0;padding:0 0 0 0 ;line-height:32px;background:rgb(255,255,255)"><strong><span style="font-family: 微软雅黑;color: rgb(228, 57, 60);letter-spacing: 0;font-size: 16px"><span style="font-family:微软雅黑">全国联保</span></span></strong></p><p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;text-indent:0;padding:0 0 0 0 ;line-height:18px;background:rgb(255,255,255)"><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">凭质保证书及</span></span><span style="font-family: 宋体;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:宋体">阿密购</span></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">商城发票，可享受全国联保服务，与您亲临商场选购的商品享受相同的质量保证。</span></span><span style="font-family: 宋体;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:宋体">昂</span></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">商城还为您提供具有竞争力的商品价格和</span></span><span style="font-family: 宋体;color: rgb(0, 0, 255);letter-spacing: 0;font-size: 12px"><span style="font-family:宋体">零</span></span><a href="https://help.jd.com/help/question-892.html"><span style="font-family: Tahoma;color: rgb(0, 90, 160);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">运费政策</span></span></a><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">，请您放心购买！</span>&nbsp;</span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><br/></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><br/></span><span style="font-family: Tahoma;color: rgb(102, 102, 102);letter-spacing: 0;font-size: 12px"><span style="font-family:Tahoma">注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</span></span></p>'
							        	setTimeout(function(){
							        		UE.getEditor('container').execCommand('insertHtml', html)
							        	},3000)
							        })
							    </script>
							</div>
						</div>
					<div class="kbShopAdmin_operating tc">
						<input  class="w200 h40 f16 kbShopAdmin_opt bc" type="submit" value="保存" />
					</div>
				</div>
			</form>
		</div>
	</div>	
	<script id="addPropertyTemplate" type="text/x-template">
		<li class="kbShopAdmin_enter property">
			<p class="adminProperty">
				<button type="button" class="delProperty kbShopAdmin_opt w50 h30" onclick="delProperty(this)">删除</button>
			</p>
			<p>
				<b><i>*</i>属性值:</b>
				<input type="text" name="attr_val[]" value=""   placeholder="属性值" />
			</p>
			<p>
				<b><i>*</i>价格:</b>
				<input type="number" name="attr_price[]" value=""  placeholder="属性值" />
			</p>
			<p>
				<b><i>*</i>库存量:</b>
				<input type="number" name="inventory_total[]" value=""  placeholder="属性值" />
			</p>
			<p class="">
				<b><i>*</i>相应图片:</b>
				<input v-bind:id="id" type="file" name="attrPic"  class="attrPic" onchange="attpic(this)"/>
				<label class="" v-bind:for="id" >
					<span style="font-size:27px">+</span><br />
					<span>选择一张图片作为属性封面,图片不得大于500kb</span>
				</label>
				<input type="hidden" name="attr_pic[]" value="1"  class="attr_pic_text" />
			</p>
		</li>
	</script>
	<div class="ui-datepicker-css">	
	    <div class="ui-datepicker-quick">
	        <p>促销日期<a class="ui-close-date">X</a></p>
	        <!-- <div>
	            <input class="ui-date-quick-button" type="button" value="今天" alt="0"  name=""/>
	            <input class="ui-date-quick-button" type="button" value="明天" alt="+1" name=""/>
	            <input class="ui-date-quick-button" type="button" value="7天内" alt="+6" name=""/>
	            <input class="ui-date-quick-button" type="button" value="14天内" alt="+13" name=""/>
	            <input class="ui-date-quick-button" type="button" value="30天内" alt="+29" name=""/>
	            <input class="ui-date-quick-button" type="button" value="60天内" alt="+59" name=""/>
	        </div> -->
	    </div>
	    <div class="ui-datepicker-choose">
		        <!-- <p>促销日期</p> -->
		        <div class="ui-datepicker-date">
		            <input name="startDate" id="startDate" class="startDate" readonly value="2014/12/20" type="text">
		           -
		            <input name="endDate" id="endDate" class="endDate" readonly  value="2014/12/20" type="text" disabled onChange="datePickers()">
		        
		        </div>
		    </div>
		</div>
	</div>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/shareing.js?v=1.12"></script>
	<script type="text/javascript">
	$(function(){
		/* $('.spAnProductAdd [required="required"]').bind('change blur',function(){
	    	checkData(this);
	    })
		$('.spAnProductAdd form .kbShopAdmin_operating input[type="submit"]').on('click',function(){
				var sStatus = false;
		    	checkData('.spAnProductAdd',function(ren){
		    		 sStatus=ren;
		    	});
		    	//数据正确则提交
		    	return sStatus;
		}) */

		/* 统计字数*/
		var init=new companyPortal();
		$('[maxlength]').each(function(index){
			var pleft=$(this).position().left+(this.clientWidth)+10;
			init.countLength(this,pleft);
			$(this).on('input propertychange',function(){
				$(this).next().children('.valLength').text($(this).val().length);
			})
			
		})	
		// 添加属性
		/* $('.addProperty ').on('click',function(){
			
			// 
			console.log();
			var Child={
				template:'#addPropertyTemp'
			}
			
		}) */

		
		})	


		function attpic(_this){
				var $this = $(_this);
				var id = $this.attr('id');
				var formData = new FormData();  
				formData.append('attrPic', document.getElementById(id).files[0]);  
		        $.ajax({  
		            url: '<?php echo U("GoodsAttribute/ajaxControl", ["flag" => "asyncUpload"]);?>' ,  
		            type: 'POST',  
		            data: formData,  
		            enctype: 'multipart/form-data',
		            async: false,  
		            cache: false,  
		            contentType: false,  
		            processData: false,  
		            success: function (res) {  
		            	$this.siblings('.attr_pic_text').val(res);
		            	if(res!="上传文件大小不符！"){
			            	var html='<div class="shopImg businessFileImgList">'+
			            			 
			            			  '</span><img src="/Public'+res+'" alt=""></div>'
			            	$this.before(html);

		            	}else{
		            		eTip(res);
		            	}

		          		console.debug(res);
		            },  
		            error: function (returndata) {  
		                alert(returndata);  
		            }  
			     }); 
			
		}
			
		
	    function delProperty(_this){
			Confirm("数据将不会保存。确认继续进行该操作吗？",function(res){
				if(res){
					var $this=$(_this);
					$this.parents('.property').remove();
				}

			})
		}
 (function(){
	Vue.component('my-components', {
	  template: '#addPropertyTemplate',
	  props: ['id'],
	  methods:{
	  	delProperty:function(event){
	  		var $this=$(event.target)?$(event.target):$(event.srcElement)
	  		Confirm("数据将不会保存。确认继续进行该操作吗？",function(res){
	  			if(res){
	  				console.log(event);
	  				// var $this=$(_this);
	  				$this.parents('.property').remove();
	  			}

	  		});
	  	},
	  	initFunction:function(){
	  		console.log("aaa");
	  		this.$on('addPropertyTemp');
			this.$emit('initFunction');
	  	}
	  }
	})
	var app=new Vue({
		el:'#myTemplate',
		data:{
				lengths:[]
			},
		methods:{
			//添加属性
			addPropertyTemp:vueMethods.addPropertyTemp,
			myTitile:vueMethods.myTitile,
			maxLength:vueMethods.maxLength
		},
		mounted:function(){
			var checkData;
			(function(e){
			  checkData=new CheckData(e);
			  checkData.isVerify.posititveNum=function(_this){
				var $this,patt,patt2,newVal;
				$this=$(_this);
				patt=new RegExp('^[0-9]+','g');
				if(!patt.test($this.val())){
					$this.val('') 
					return false
				};
				patt2=new RegExp('^[0-9]*\.?[0-9]{1,2}','g');
				newVal=patt2.exec($this.val());
				$this.val(newVal);
				return true;
			  }
			  $('[data-regexp=posititveNum]').on('blur',function(){
			  	checkData.isVerify.posititveNum(this);
			  })
			  $(e).find('[type=submit]').on('click',function(){
			  	 return checkData.verify();
			  })
			})('#myTemplate');

		},
		updated:function(){
			app.myTitile();
			app.maxLength();
			this.checkdata()

		},
	})
	app.myTitile();
	app.maxLength();
})();
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/Goods/goodsAdd.html';?>")
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