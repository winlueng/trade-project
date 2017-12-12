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





	
    
	<?php  ?>
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?v=1"></link>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
<link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">
<style>
.kbShopAdmin_enter input[readonly]{
	 opacity: 0.6;

}
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
			
			<h1>
				<a class="goback mr10" href="javascript:history.back(-1)" ><img src="/Public/Business/BusinessImages/back.png"></a>
				<b>产品修改</b>
			</h1>
		</div>
		<div class="spAnProductAdd kbShopAdmin_box">
			<form  action="<?php echo U('goodsUpdate' , ['id' => $_GET['id']]);?>" method="post" class="checkForm" enctype="multipart/form-data">
				<div class="formData">
				<ul class="mt20" data-goodID="<?php echo ($info['id']); ?>"  id="myTemplate">
					<li class="kbShopAdmin_enter" >
						<b><i>*</i>产品名称:</b>
						<input type="text" value="<?php echo ($info['goods_name']); ?>" placeholder="请输入产品名字" minLength="1" name="goods_name" required="required" />
					</li>
					<li class="kbShopAdmin_enter"><b>产品价格:</b><input  type="number" name="price" value="<?php echo ($info['price']); ?>" min='0.1' placeholder="请输入产品价格" step="0.1" />
						
					</li>
					<li class="kbShopAdmin_enter"><b>促销:</b>
							<p class="kbShopAdmin_radio">
								<input type="radio" value="1" name="is_discount" <?php echo ($info['is_discount']=1?'checked':''); ?>> <label><b></b></label>
							</p>
							 <span class="radioText">是</span> 
							<p class="kbShopAdmin_radio">
								<input type="radio" value="0" name="is_discount"  <?php echo ($info['is_discount']=1?'':'checked'); ?>>
								<label><b></b></label>
							</p> 
							<span class="radioText">否</span>
							
					</li>
					<li class="kbShopAdmin_enter ">
						<b>促销日期:</b>
						<div class="filterData">
							<input type="text" class="ui-datepicker-time" readonly="readonly"  value="<?php echo date('Y年m月d日',$info['sales_start_time']);?>-<?php echo date('Y年m月d日',$info['sales_end_time']);?>" />
							<input class="start" type="hidden" name="sales_start_time" value="<?php echo ($info["sales_start_time"]); ?>" />
							<input  class="end"  type="hidden" name="sales_end_time" value="<?php echo ($info["sales_end_time"]); ?>" />
						</div>
					</li>
					<li class="kbShopAdmin_enter"><b>促销折扣:</b><input  type="text" name="discount" value="<?php echo ($info["discount"]); ?>" placeholder="请输入促销折扣"
						data-datatype="input" 
						data-regexp="posititveNum"
					 />
						
					</li>
					<!-- <li class="kbShopAdmin_enter">
						<b><i>*</i>产品简述:</b>
						<textarea name="describe" required="required"><?php echo ($info["describe"]); ?></textarea>
					</li> -->
					<li class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>产品封面:</b>
						<div class="shopImg businessFileImgList">
							<span class="cleraIMG" onclick="clearImg(this);"></span>
							<img src="/Public<?php echo ($info["goods_logo"]); ?>" alt="">
						</div>
						<input id="shopImg" name="goods_logo" type="file" value="dafult"  />
						<label class="" for="shopImg">
							<span style="font-size:27px">+</span><br />
							<span>选择一张图片作为产品封面</span>
						</label>
					</li>
					<li class="kbShopAdmin_enter kbShopAdmin_fileImg"><b><i>*</i>产品图片:</b>
						<div class="fileImgMore">
						<?php if(is_array($info["goods_picture"])): $i = 0; $__LIST__ = $info["goods_picture"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="shopImg businessFileImgList">
								<span class="cleraIMG" onclick="clearImg(this)"></span>
								<img src="/Public<?php echo ($v); ?>" alt="">
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
						<input id="shopImg1"  type="file" name="pic_path[]" multiple="multiple" value="dafult" />

						

						<label class="" for="shopImg1" >
							<span style="font-size:27px">+</span><br />
							<span>可选择五张图片作为产品图片</span>
						</label>
						</div>
					</li>
					<li class="kbShopAdmin_enter "><b><i>*</i>产品分类:</b>
						<select name="classify_id" class="kbShopAdmin_slt kbShopAdmin_sltblack" required="required">
						<option value="-1">请选择产品分类</option>
						<?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($info['classify_id'] == $v['id']?'selected':''); ?> /><?php echo ($v['classify_name']); endforeach; endif; ?>
					</select>
					
					</li>
					<li class="kbShopAdmin_enter "><b><i>*</i>产品品牌:</b>
						<select name="brand_id" class="kbShopAdmin_slt kbShopAdmin_sltblack" required="required">
						<option value="-1">请选择产品品牌</option>
							<?php if(is_array($brandList)): foreach($brandList as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($info['brand_id'] == $v['id']?'selected':''); ?> /><?php echo ($v['brand_name']); endforeach; endif; ?>
						</select>
					
					</li>
					<li class="kbShopAdmin_enter">
						<b><i>*</i>商品重量:</b>
						<input type="text" name="weight" value="<?php echo ($info['weight']); ?>" placeholder="单位g" />
					</li>
					<li class="kbShopAdmin_enter">
						<b><i>*</i>商品邮费:</b>
						<input type="number" name="express_price" min="0" value="<?php echo ($info['express_price']); ?>" placeholder="默认0元" />
					</li>
					<!-- <li class="kbShopAdmin_enter">
						<b><i>*</i>商品关键字:</b>
						<input type="text" name="attr_name" value="" placeholder="多个关键字以','隔开" />
					</li> -->
					<li class="kbShopAdmin_enter property">
						<b><i>*</i>属性名称:</b>
						<input type="text" name="attr_name" value="<?php echo ($attr["0"]["attr_name"]); ?>" placeholder="属性名称" />
						<p class="adminProperty">
						<button type="button" class="addProperty kbShopAdmin_opt w80 h30 " v-on:click="addPropertyTemp">增加属性</button>
						</p>
					</li>
					<?php if(is_array($attr)): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="kbShopAdmin_enter property" data-attrId="<?php echo ($v["id"]); ?>">
							<p class="adminProperty">
								<button type="button" class="updateProperty kbShopAdmin_opt w80 h30" onclick="updateProperty(this)">修改属性</button>
								<button type="button" class="delProperty kbShopAdmin_opt w80 h30">删除属性</button>
							</p>
							<p>
								<b><i>*</i>属性值:</b>
								<input type="text" name="attr_val" value="<?php echo ($v["attr_val"]); ?>"  placeholder="属性值"  disabled/>
							</p>
							<p>
								<b><i>*</i>价格:</b>
								<input type="text" name="attr_price" value="<?php echo ($v["attr_price"]); ?>" placeholder="价格" disabled />
							</p>
							<p>
								<b><i>*</i>库存量:</b>
								<input type="text" name="inventory_total" value="<?php echo ($v["inventory_total"]); ?>" placeholder="库存量" disabled />
							</p>
							<p class="">
								<b><i>*</i>相应图片:</b>
									<span class="shopImg businessFileImgList">
										<img src="/Public<?php echo ($v["attr_pic"]); ?>" alt="">
									</span>
								<input id="attrImg<?php echo ($v["id"]); ?>" type="file" disabled  class="attrPic" onchange="attpic(this)"/>
								<label class="" for="attrImg<?php echo ($v["id"]); ?>" >
									<span style="font-size:27px">+</span><br />
									<span>选择一张图片作为属性封面</span>
								</label>
								<!-- <div class="shopImg businessFileImgList">
									<span class="cleraIMG" onclick="clearImg(this)"></span>
									<img src="/Public" alt="">
								</div> -->
								<input type="hidden" name="attr_pic" value="<?php echo ($v["attr_pic"]); ?>" class="attr_pic_text">
							</p>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>

					 <li is="mycomponents" v-bind:id="lengths"  v-for="(lengths, index) in lengths" ></li>
					
				</ul>
				<div class="kbShopAdmin_enter">
						<b>产品描述详情:</b>
						<div id="myEditor" class="myEditor">
							<script id="container" name="goods_title" type="text/plain">
							<?php echo ($info["goods_title"]); ?>
						    </script>
						  
						    <!-- 实例化编辑器 -->
						    <script type="text/javascript">
						        var ue = UE.getEditor('container',{
						        		'initialFrameHeight':360,
						        		// 'initialContent':'在这里你可以布置好你商品详情的资料'
						        });
						    </script>
						</div>
					</div>
				<div class="kbShopAdmin_operating tc">
				<!-- 	<input  class="w80 h30 kbShopAdmin_opt_7facff bc" type="button" value="返回" onclick="javascript:history.back(-1)" /> -->
					<input  class="w200 h40 kbShopAdmin_opt bc" type="submit" value="保存" />
				</div>
				</div>
			</form>
		</div>
	</div>	
	<script id="addPropertyTemp" type="text/template">
		<li class="kbShopAdmin_enter property new">
			<p class="adminProperty">
				<button type="button" class="delProperty kbShopAdmin_opt w50 h30" onclick="delProperty(this)">删除</button>
				<button type="button" class=" kbShopAdmin_opt w50 h30" onclick="addProperty(this)">确定</button>
			</p>
			<p>
				<b><i>*</i>属性值:</b>
				<input type="text" name="attr_val[]" value=""   placeholder="属性值" />
			</p>
			<p>
				<b><i>*</i>价格:</b>
				<input type="number" name="attr_price[]" value=""  placeholder="价格" />
			</p>
			<p>
				<b><i>*</i>库存量:</b>
				<input type="number" name="inventory_total[]" value=""  placeholder="库存量" />
			</p>
			<p class="">
				<b><i>*</i>相应图片:</b>
				<input v-bind:id="id" type="file"   class="attrPic" onchange="attpic(this)"/>
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
	        <p>快捷日期<a class="ui-close-date">X</a></p>
	        <div>
	             <input class="ui-date-quick-button" type="button" value="今天" alt="0"  name=""/>
	            <input class="ui-date-quick-button" type="button" value="明天" alt="+1" name=""/>
	            <input class="ui-date-quick-button" type="button" value="7天内" alt="+6" name=""/>
	            <input class="ui-date-quick-button" type="button" value="14天内" alt="+13" name=""/>
	            <input class="ui-date-quick-button" type="button" value="30天内" alt="+29" name=""/>
	            <input class="ui-date-quick-button" type="button" value="60天内" alt="+59" name=""/>
	        </div>
	    </div>
	    <div class="ui-datepicker-choose">
		        <p>自选日期</p>
		        <div class="ui-datepicker-date">
		            <input name="startDate" id="startDate" class="startDate" readonly value="2014/12/20" type="text">
		           -
		            <input name="endDate" id="endDate" class="endDate" readonly  value="2014/12/20" type="text" disabled onChange="datePickers()">
		        
		        </div>
		    </div>
		</div>
	</div>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/shareing.js?v=1.11"></script>
	<script type="text/javascript">
	$(function(){
		 $('.spAnProductAdd [required="required"]').bind('change blur',function(){
	    	checkData(this);
	    })
		$('.spAnProductAdd form .kbShopAdmin_operating input[type="submit"]').on('click',function(){
				var sStatus = false;
		    	checkData('.spAnProductAdd',function(ren){
		    		 sStatus=ren;
		    	});
		    	//数据正确则提交
		    	return sStatus;
		}) 

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
		// $('.addProperty ').on('click',function(){
		// 	var template=$('#addPropertyTemp').html();
		// 	$('.property').last().after(template);

		// })
		
		
		//修改属性
		/* $('.updateProperty').on('click',function(){
			

			
		}) */
		//先删除再上传新的属性图片
		$('.property .attrPic').on('change',function(){
			var $this=$(this),
				attr_id=$this.parents('[data-attrid]').attr('data-attrid'),
				formData=new FormData,
				id=$this.attr('id'),
				rawImg=$this.prev('.shopImg ').children('img').attr('src');
				attr_price=document.getElementById(id).files[0];
			
				formData.append("attr_id",attr_id);
				formData.append("attr_price",attr_price);
				console.debug(attr_price.size<500*1024);
				if(attr_price.size<500*1024){
					$.get('<?php echo U("GoodsAttribute/ajaxControl");?>',{
						flag:'delAttrPic',
						attr_id:attr_id
					},function(res){
						if(res==true){
							// 删除成功后，重新保存属性
					        updateProperty($this)
						}else{
							eTip('删除失败')
						}
					});
				}else{
					$this.prev('.shopImg').find('img').attr('src',rawImg);
					oTip("上传图片不得大于500kb")
				}
				//删除
				

		})
		$('.delProperty').on('click',function(){
			var $this=$(this),
				attr_id=$this.parents('[data-attrid]').attr('data-attrid');
			Confirm("进行该操作后，数据将不能再次恢复。确认继续该操作吗？",function(res){
				if(res){
					$.get('<?php echo U("GoodsAttribute/ajaxControl");?>',{
						flag:'del',
						attr_id:attr_id
					},function(res){
						if(res){
							sTip('操作成功');
						}else{
							eTip('操作失败');
						}
					})
				}
			})

		})
	})
	    function delProperty(_this){
			Confirm("数据将不会保存。确认继续进行该操作吗？",function(res){
				if(res){
					var $this=$(_this);
					$this.parents('.property').remove();
				}

			})
		}
		//异步提交属性图片
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
			            			  '<img src="/Public'+res+'" alt=""></div>'

			            	if($this.siblings('.shopImg').length>0){
			            		$this.siblings('.shopImg').find('img').attr('src',"/Public"+res);
			            	}else{
				            	$this.before(html);
			            	}

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
		//修改属性
 		function updateProperty(_this){
 			var $this=$(_this),
 				everVal=$this.parent().siblings().children('[name]');
 				if($this.hasClass('updateIng')){
 					Confirm("您确定进行该属性修改吗？",function(res){
 						if(res){
 							var	UpdateData=new Object(),
 								formData = new FormData();
 							everVal.each(function(indexs,elem){
 								var name=$(elem).attr('name'),
 									Val=$(elem).val();
 								formData.append(name,Val);
 							})

 							formData.append("attr_id",$this.parents('[data-attrid]').attr('data-attrid'));
 					        $.ajax({  
 					            url: '<?php echo U("GoodsAttribute/ajaxControl", ["flag" => "update"]);?>',  
 					            type: 'POST',  
 					            data: formData,  
 					            enctype: 'multipart/form-data',
 					            async: false,  
 					            cache: false,  
 					            contentType: false,  
 					            processData: false,  
 					            success: function (res) {  
 					            	console.log(res);
 					            	if(res){
 						            	sTip("修改成功");
 					            	}else{
 					            		 eTip("修改失败")
 					            	}
 					            },  
 					            error: function (returndata) {  
 					                oTip("修改失败")
 					            }  
 						     }); 
 						}
 					
 					});
 				}
 				$this.toggleClass('updateIng');
 				var status= $this.hasClass('updateIng');
 					statusText = status ? '确定操作':'修改属性';
 					$this.text(statusText);
 					$this.parent('p').siblings().children('input[type="file"]').attr('disabled',!status);
 					everVal.attr('disabled',!status);
 					$this.parents('form').find('[type="submit"]').attr('disabled',status);

 		}
 		//增加属性
		function addProperty(_this){
			var $this=$(_this),
				goods_id=$this.parents('[data-goodid]').attr('data-goodid').trim(),
				Parent=$this.parents('p.adminProperty'),
				formData=new FormData,
				chidldrenEmt=Parent.siblings('p').children('input[name]').not('input[type=file]');
				formData.append('goods_id',goods_id);
				// Object(chidldrenEmt)
				chidldrenEmt.each(function(indexs,elem){
					var name=$(elem).attr('name'),
						Val=$(elem).val();
					formData.append(name,Val);
				})
				 $.ajax({  
			            url: '<?php echo U("GoodsAttribute/ajaxControl", ["flag" => "insAttr"]);?>',  
			            type: 'POST',  
			            data: formData,  
			            enctype: 'multipart/form-data',
			            async: false,  
			            cache: false,  
			            contentType: false,  
			            processData: false,  
			            success: function (res) {  
			            	console.log(res);
			            	if(res){
				            	sTip("修改成功");
			            	}else{
			            		 eTip("修改失败")
			            	}
			            },  
			            error: function (returndata) {  
			                oTip("修改失败")
			            }  
				     }); 
		};
		(function(){
			/*  var template=$('#addPropertyTemp').html();
			var Child={
				template:template
			} */
		/* 	var Child={
			  template: '#addPropertyTemp',
			  props: ['id']
			} */
			Vue.component('mycomponents', {
			  template: '#addPropertyTemp',
			  props: ['id']
			})
			var app=new Vue({
			
				el:'#myTemplate',
				data:{
						lengths:[]
					},
				methods:{
					addPropertyTemp:function(even){
						var propertynum=document.getElementsByClassName('property').length
						console.info(propertynum);
						console.info(app.lengths.length);
						this.lengths.push("attr"+propertynum);
						console.debug(app.lengths.length);
					}

				}
			})
			$('')
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/Goods/goodsUpdate/id/1159.html';?>")
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