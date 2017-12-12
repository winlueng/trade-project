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


	
<?php  ?>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>

	<link rel="stylesheet" href="/Public/Portal/PortalCSS/coupon/coupon.css">
	<script type="text/javascript">
		$(function(){ 
			$('.kbVipAdmin_fileImg input[type="file"]').on('change',function(){
				if ( typeof(FileReader) === 'undefined' ){ 
					alert("抱歉，你的浏览器不支持 FileReader，推荐使用谷歌浏览器操作！"); 
					this.setAttribute( 'disabled','disabled' ); 
				} else { 
					readFile(this,this.files[0]);
				} 
			})
		});
	
	</script>
	<style>
		#marketInfo-edit{
			/*width:50%;*/
		}
		.kbVipAdmin_form{
			margin-bottom:40px;
			    height: 86%;
		}
	</style>

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
	
	<div id="kbVipAdmin_rightCenter" class=" spAnProductAdd couponAdClass_center">
	<div class="centerTitle">
		<h1>资料完善</h1>
	</div>
	<div class="spAnProductAdd kbVipAdmin_box">
		<form class="userAdmin_center-addUser kbVipAdmin_form" action="<?php echo U('marketInfo');?>" method="post" enctype="multipart/form-data">
		<div class="formData">
			<p class="kbVipAdmin_enter">
				<b><i>*</i>商盟名称：</b>
				<input type="text" name="market_name" maxlength="20" required="required" value="<?php echo ($info['market_name']); ?>"
				 data-datatype="input"
				 />
				<strong class="kbVipAdmin_tip">必填项。输入字符不超过20个</strong>
			</p>
			<p class="kbVipAdmin_enter">
				<b><i>*</i>商盟负责人：</b>
				<input type="text" name="principal"  maxlength="8" required="required" value="<?php echo ($info['principal']); ?>"
				data-datatype="input"
				 />
				<strong class="kbVipAdmin_tip">必填项。输入字符不超过8个</strong>
			</p>
			<p class="kbVipAdmin_enter">
				<b><i>*</i>联系电话：</b>
				<input type="tel" name="phone" value="<?php echo ($info['phone']); ?>"  maxlength="11" required="required"
				data-datatype="input"
				 />
				<strong class="kbVipAdmin_tip">必填项。请输入商场的联系电话</strong>
			</p>
			<p class="kbVipAdmin_enter">
			 	<b><i>*</i>公众号AppID：</b>
			 	<input type="text" name="app_id" value="<?php echo ($info['app_id']); ?>" required="required"
			 	data-datatype="input"
			 	 />
				<strong class="kbVipAdmin_tip">必填项。请输入公众号AppID(做微信交互所用)</strong>
			</p>
			<p class="kbVipAdmin_enter">
				<b><i>*</i>公众号密钥AppSecret：</b>
				<input type="text" name="app_secret" value="<?php echo ($info['app_secret']); ?>" required="required"
				data-datatype="input"
				 />
				<strong class="kbVipAdmin_tip">必填项。请输入公众号密钥AppSecret(做微信交互所用)</strong>
			</p>

			<p class="kbVipAdmin_enter">
			 	<b><i>*</i>微信商户平台ID：</b>
			 	<input type="text" name="mch_id" value="<?php echo ($info['mch_id']); ?>" required="required"
			 	data-datatype="input"
			 	 />
				<strong class="kbVipAdmin_tip">必填项。请输入微信商户平台ID(做微信支付所用)</strong>
			</p>
			<p class="kbVipAdmin_enter">
				<b><i>*</i>微信商户密钥：</b>
				<input type="password" name="mch_sectet" value="<?php echo ($info['mch_sectet']); ?>" required="required"
				data-datatype="input"
				 />
				<strong class="kbVipAdmin_tip">必填项。请输入微信商户密钥(做微信支付所用)</strong>
			</p>

			</p>
			<p class="kbVipAdmin_enter">
				<b><i>*</i>联系邮箱：</b>
				<input type="email" name="email" value="<?php echo ($info['email']); ?>"   required="required"
				data-datatype="input"
				 />
				<strong class="kbVipAdmin_tip">必填项。请输入商场的联系邮箱</strong>
			</p>
			<p class="kbVipAdmin_enter">
				<b><i>*</i>商盟地址：</b>
				<input type="text" name="address_info" value="<?php echo ($info['address_info']); ?>"   required="required"
				data-datatype="input"
				 />
				<strong class="kbVipAdmin_tip">必填项。请输入商场的详细地址</strong>
			</p>

			<div  class="kbVipAdmin_enter kbVipAdmin_file"> <b><i>*</i>微信支付CERT证书：</b>
				<!-- <div class="shopImg businessFileImgList">
					<b class="cleraIMG" onclick="clearImg(this);"></b>
				</div> -->
				<label class="fileImg" for="apiclient_cert">点击上传CERT证书</label>
				<input id="apiclient_cert" type="file" name="apiclient_cert"    />
				<strong class="kbVipAdmin_tip"><span>必需上传,微信支付双向证书<br>(apiclient_cert.pem文件)</span></strong>
			</div>
			<div  class="kbVipAdmin_enter kbVipAdmin_file"> <b><i>*</i>微信支付KEY证书：</b>
				<!-- <div class="shopImg businessFileImgList">
					<b class="cleraIMG" onclick="clearImg(this);"></b>
				</div> -->
				<label class="fileImg" for="apiclient_key">点击上传KEY证书</label>
				<input id="apiclient_key" type="file" name="apiclient_key"    />
				<strong class="kbVipAdmin_tip"><span>必需上传,微信支付双向证书<br>(apiclient_key.pem文件)</span></strong>
			 </div>

			<div  class="kbVipAdmin_enter kbVipAdmin_fileImg"> <b><i>*</i>商盟Logo：</b>
				<div class="shopImg businessFileImgList">
					<b class="cleraIMG" onclick="clearImg(this);"></b>
					<?php if(info.project_logo): if(!empty($info["project_logo"])): ?><img src="/Public<?php echo ($info['project_logo']); ?>" width="600"><?php endif; endif; ?>
				</div>
				<label class="fileImg" for="businessFileImg">点击上传图片</label>
				<input id="businessFileImg" type="file" name="project_logo"    />
				<strong class="kbVipAdmin_tip">必填项。图片格式为png、jpg。不大于200k</strong>
			 </div>
			
			<div id="marketInfo-edit" class="bc kbVipAdmin_enter">
				<b><i>*</i>商盟简介：</b>
					<div id="myEditor"  class="myEditor">
					<script id="container" name="abstruct" type="text/plain">
						<?php echo ($info['abstruct']); ?>
				    </script>
				    <!-- 配置文件 -->
				    <script type="text/javascript" src="ueditor.config.js"></script>
				    <!-- 编辑器源码文件 -->
				    <script type="text/javascript" src="ueditor.all.js"></script>
				    <!-- 实例化编辑器 -->
				    <script type="text/javascript">
				        var ue = UE.getEditor('container',{
				        		'initialFrameWidth':400,
				        		// 'initialContent':'在这里你可以布置好你商品详情的资料'
				        });
				    </script>
					</div>
					
			</div>	
			<!-- <textarea name="abstruct"   required="required" ></textarea>
			<strong class="kbVipAdmin_tip">必填项。请输入商场的简单介绍</strong> -->
			

				<div class="kbVipAdmin_operating tc mt20">
					<input  class="w200 h40 f16 kbVipAdmin_opt bc" type="submit" value="保存" />
				</div>
			</div>	
		</form>
		</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			(function(){
				var checkData;
				checkData=new CheckData('.formData');
				 $('.formData .kbVipAdmin_operating [type=submit]').on('click',function(){
					return checkData.verify();
				})
				 vueMethods.maxLength();
			})()
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Project/marketInfo'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>