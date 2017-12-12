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


	
<link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">
<style>
.kbVipAdmin_enter input[readonly]{
	 opacity: 0.6;

}
.filterData{
		display:inline-block;
		width:40%;
	}
	#kbVipAdmin_rightCenter .filterData .ui-datepicker-time{
		width:100%;
		 text-indent: 40px;
	}
	#kbVipAdmin_rightCenter input:disabled{
		opacity: .5
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
		
	<div id="kbVipAdmin_rightCenter" class="spAnProductAdd">
		<div class="centerTitle">
			<h1>商品修改</h1>
		</div>
		<div class="spAnProductAdd kbVipAdmin_box">
			<form  action="<?php echo U('goodsUpdateByProject' , ['id' => $_GET['id'],'module' => $_GET['module']]);?>" method="post" class="checkForm" enctype="multipart/form-data">
				<!-- <h3 class="mt20 mt10 tc">商品添加</h3> -->
				<div class="formData">
					<ul class="mt20" id="myTemplate">
						<li class="kbVipAdmin_enter" >
							<b><i>*</i>商品名称:</b>
							<input type="text" value="<?php echo ($info['goods_name']); ?>" placeholder="请输入商品名字" maxlength="30" name="goods_name" required="required"
							data-datatype="input"
							/>
						</li>
						<li class="kbVipAdmin_enter"><b><i>*</i>商品价格:</b>
						<input  type="text" name="price" value="<?php echo ($info['price']); ?>" placeholder="请输入商品价格"
							required="required" 
							data-datatype="input" 
							data-regexp="posititveNum"
						 />
							
						</li>
						<li class="kbVipAdmin_enter"><b><i>*</i>促销:</b>
							<p class="kbVipAdmin_radio">
								<input type="radio" value="1" name="is_discount" <?php echo ($info['is_discount']=1?'checked':''); ?> 
								required="required"
								/> <label><b></b></label>
							</p>
							 <span class="radioText">是</span> 
							<p class="kbVipAdmin_radio">
								<input type="radio" value="0" name="is_discount" <?php echo ($info['is_discount']=1?'':'checked'); ?> 
								required="required"
								/>
								<label><b></b></label>
							</p> 
							<span class="radioText">否</span>
						</li>
						<li class="kbVipAdmin_enter ">
							<b>促销日期:</b>
							<div class="filterData w">
								<input type="text" class="ui-datepicker-time" readonly="readonly"  value="<?php echo date('Y年m月d日',$info['sales_start_time']);?>-<?php echo date('Y年m月d日',$info['sales_end_time']);?>" />
								<input class="start" type="hidden" name="sales_start_time" value="<?php echo ($info['sales_start_time']); ?>" />
								<input  class="end"  type="hidden" name="sales_end_time" value="<?php echo ($info['sales_end_time']); ?>" />
							</div>
						</li>
						<li class="kbVipAdmin_enter"><b>促销折扣:</b><input  type="text" name="discount" value="<?php echo ($info["discount"]); ?>" placeholder="请输入促销折扣"
							data-datatype="input"
							data-regexp="posititveNum"
						/>
						</li>
						<!-- <li class="kbVipAdmin_enter">
							<b><i>*</i>商品简述:</b>
							<textarea name="describe" required="required"></textarea>
						</li> -->
						<li class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>商品封面:</b>
							<div class="shopImg businessFileImgList">
								<span class="cleraIMG" onclick="clearImg(this);"></span>
								<img src="/Public<?php echo ($info["goods_logo"]); ?>" alt="">
							</div>
							<input id="shopImg" name="goods_logo" type="file" value="dafult"  />
							<label class="" for="shopImg">
								<span style="font-size:27px">+</span><br />
								<span>选择一张图片作为商品封面</span>
							</label>
						</li>
						<li class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>商品图片:</b>
							<div class="fileImgMore">
							<?php if(is_array($info["goods_picture"])): $i = 0; $__LIST__ = $info["goods_picture"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="shopImg businessFileImgList">
									<span class="cleraIMG" onclick="clearImg(this)"></span>
									<img src="/Public<?php echo ($v); ?>" alt="">
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
							<input id="shopImg1"  type="file" name="pic_path[]" multiple="multiple" value="dafult" />
							<label class="" for="shopImg1" >
								<span style="font-size:27px">+</span><br />
								<span>可选择五张图片作为商品图片</span>
							</label>
							</div>
						</li>
						<li class="kbVipAdmin_enter "><b><i>*</i>商品分类:</b>
							<select name="classify_id" class="kbVipAdmin_slt kbVipAdmin_sltblack" required="required"
							data-datatype="select"
							>
							<option value="-1">请选择商品分类</option>
							<?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($info['classify_id'] == $v['id']?'selected':''); ?> /><?php echo ($v['classify_name']); endforeach; endif; ?>
						</select>
						</li>
						<li class="kbVipAdmin_enter "><b>商品品牌:</b>
							<select name="brand_id" class="kbVipAdmin_slt kbVipAdmin_sltblack" data-datatype="select">
							<option value="-1">请选择商品品牌</option>
								<?php if(is_array($brandList)): foreach($brandList as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($info['brand_id'] == $v['id']?'selected':''); ?> /><?php echo ($v['brand_name']); endforeach; endif; ?>
							</select>
						</li>
						<li class="kbVipAdmin_enter">
							<b><i>*</i>商品重量:</b>
							<input type="text" name="weight" value="<?php echo ($info['weight']); ?>" placeholder="单位g" 
							required="required" 
							data-datatype="input" 
							data-regexp="posititveNum"
							/>
						</li>
						<li class="kbVipAdmin_enter">
							<b><i>*</i>商品邮费:</b>
							<input type="text" name="express_price" min="0" value="<?php echo ($info['express_price']); ?>" placeholder="默认0元" 
							required="required" 
							data-datatype="input" 
							data-regexp="posititveNum"
							/>
						</li>
					<!-- 	<li class="kbVipAdmin_enter">
							<b><i>*</i>商品关键字:</b>
							<input type="text" name="attr_name" value="" placeholder="多个关键字以','隔开" />
						</li> -->
						<li class="kbVipAdmin_enter property">
							<b><i>*</i>属性名称:</b>
							<input type="text" name="attr_name" value="<?php echo ($attr["0"]["attr_name"]); ?>" placeholder="属性名称"
							maxlength="8" 
							required="required"
							data-datatype="input"
							 />
							<p class="adminProperty">
								<button  id="addProperty" type="button" class="addProperty kbVipAdmin_opt w80 h30"  v-on:click="addPropertyTemp">添加</button>
								<!-- <button type="button" class="delProperty kbVipAdmin_opt w50 h30">删除</button> -->
							</p>
						</li>
						<?php if(is_array($attr)): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="kbVipAdmin_enter property" data-attrId="<?php echo ($v["id"]); ?>">
							<p class="adminProperty">
								<button type="button" class="updateProperty kbVipAdmin_opt w80 h30 mb10" v-on:click="updateProperty">修改属性</button>
								<button type="button" class="delProperty kbVipAdmin_opt w80 h30">删除属性</button>
							</p>
							<p>
								<b><i>*</i>属性值:</b>
								<input type="text" name="attr_val" value="<?php echo ($v["attr_val"]); ?>"  placeholder="属性值" disabled
								maxlength="8" 
								required="required" 
								data-datatype="input" 
								 />
							</p>
							<p>
								<b><i>*</i>价格:</b>
								<input type="text" name="attr_price" value="<?php echo ($v["attr_price"]); ?>" placeholder="价格" disabled 
								required="required" 
								data-datatype="input" 
								data-regexp="posititveNum"
								/>
							</p>
							<p>
								<b><i>*</i>库存量:</b>
								<input type="number" name="inventory_total" value="<?php echo ($v["inventory_total"]); ?>" placeholder="库存量" disabled 
								required="required" 
								data-datatype="input" 
								data-regexp="posititveNum"
								/>
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
						

						 <li is="my-components" v-bind:id="lengths"  v-for="(lengths, index) in lengths" ></li>
						
					</ul>
						<div class="kbVipAdmin_enter">
							<b>商品描述详情:</b>
							<div id="myEditor" class="myEditor">
								<script id="container" name="goods_title" type="text/plain">
								<?php echo ($info["goods_title"]); ?>
							    </script>
							  
							    
							</div>
						</div>
					<!-- <textarea>
					  <?php echo ($info["goods_title"]); ?>
					</textarea> -->
					<div class="kbVipAdmin_operating tc">
						<input  class="w200 h40 f16 kbVipAdmin_opt bc" type="submit" value="保存" />
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Goods/goodsUpdateByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	<script id="addPropertyTemplate" type="text/x-template">
		<li class="kbVipAdmin_enter property">
			<p class="adminProperty">
				<button type="button" class="delProperty kbVipAdmin_opt w50 h30" v-on:click="delProperty">删除</button>
			</p>
			<p>
				<b><i>*</i>属性值:</b>
				<input type="text" name="attr_val[]" value=""   placeholder="属性值" 
				required="required"
				maxlength="8" 
 				data-datatype="input"
				/>
			</p>
			<p>
				<b><i>*</i>价格:</b>
				<input type="text" name="attr_price[]" value=""  placeholder="价格" 
					required="required"
	 				data-datatype="input"
	 				data-regexp="posititveNum"
				/>
			</p>
			<p>
				<b><i>*</i>库存量:</b>
				<input type="number" name="inventory_total[]" value=""  placeholder="库存量" 
				required="required"
 				data-datatype="input"
				/>
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
<block name="js_files">
	
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.js"> </script>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
	
							 
<script type="text/javascript">
$(function(){
	(function(){
		var ue = UE.getEditor('container',{
				'initialFrameHeight':360,
				// 'initialContent':'在这里你可以布置好你商品详情的资料'
		});
	})()
});
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
            		$this.siblings('.shopImg.businessFileImgList').remove();
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
$(function(){
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

	
	

	
    function delProperty(_this){
		Confirm("数据将不会保存。确认继续进行该操作吗？",function(res){
			if(res){
				var $this=$(_this);
				$this.parents('.property').remove();
			}

		})
	}
	//修改属性
	/*function updateProperty(_this){
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

	}*/

	
		
	

	(function(){
		
		Vue.component('my-components', {
		  template: '#addPropertyTemplate',
		  props: ['id'],
		  methods:{
		  	delProperty:function(event){
		  		var $this=$(event.target)?$(event.target):$(event.srcElement)
		  		Confirm("数据将不会保存。确认继续进行该操作吗？",function(res){
					if(res){
						$this.parents('.property').remove();
					}

				})
		  	},
		  }
		});
		var app=new Vue({
			el:'#myTemplate',
			data:{
					lengths:[]
				},
			methods:{
				addPropertyTemp:vueMethods.addPropertyTemp,
				myTitile:vueMethods.myTitile,
				maxLength:vueMethods.maxLength,
				updateProperty:function(event){
					var $this=$(event.target)?$(event.target):$(event.srcElement),
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
							status?$this.parents('form').find('[type="submit"]').attr('title',"属性还没确定"):$this.parents('form').find('[type="submit"]').removeAttr('title')
				},
				checkdata:function(e){
					  var checkData;
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
				},

			},
			
			mounted:function(){
				this.checkdata('.formData');
				$('.kbVipAdmin_fileImg input[type="file"]').on('change',function(){
				    $(this).siblings('.shopImg.businessFileImgList').remove();
				    if ( typeof(FileReader) === 'undefined' ){ 
				      alert("抱歉，你的浏览器不支持 FileReader，推荐使用谷歌浏览器操作！"); 
				      this.setAttribute( 'disabled','disabled' ); 
				    } else { 
				        console.log(this.files)
				      readFile(this,this.files);
				    } 
				 })
			},
			updated:function(){
				app.myTitile();
				app.maxLength();
				app.checkdata('.formData');
			
			}
				
		})
		// console.log(app.$mounted.checkData);
	})();
});
</script>
<script type="text/javascript" src="/Public/JS/module/datenew/js/shareing.js?v=1.12"></script>

</body>
</html>