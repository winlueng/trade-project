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


	
	<link rel="stylesheet" href="/Public/Portal/PortalCSS/coupon/coupon.css">
	<style>
		.moduleUpdate li{
			box-shadow: 0px -1px 3px 2px #eee;
			text-align: center;
		    margin-bottom: 30px;
		    padding: 12px;
		    width: 50%;
		}
		.spAnDynamic_alert_from{

			height: 78%;
		    overflow-x: hidden;
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
	
	<div id="kbVipAdmin_rightCenter" class="couponBusiness_center OrderForm">
		<div class="centerTitle">
	      <h1>商盟管理</h1>
	   </div>
	   <div class="kbVipAdmin_operating">
	   		<form class="kbVipAdmin_inlineBlock" action="<?php echo U('companyList',['module' => $_GET['module']]);?>" method="get">
	   	<p class=" filter-searchDate ">
			<input  type="search" value="<?php echo I('get.selname');?>" name="selname" placeholder="请输入商户名称关键字搜索" />
			<button   type="submit" class="kbVipAdmin_opt w80 h30 fr">查询</button>
		</p>
			</form>
	   </div>
		<div class="main-contentBox">
			<div class="kbVipAdmin_table">
				<table class="roleList couponBusiness_roleList">
					<thead>
						<tr>
							<th>序号</th>
							<th>店铺名称</th>
							<th>联系人</th>
							<th>联系电话</th>
							<th>区域</th>
							<!-- <th>地址</th> -->
							<th>行业</th>
							<th>浏览量</th>
							<th>截止时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(empty($list)): ?><tr><td colspan="11"><center><span style="font-size: 20px;color: #FF54AE">暂无数据</span>
					<?php else: ?>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td class="companyId"><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["company_name"]); ?></td>
							<td><?php echo ($v["principal"]); ?></td>
							<td><?php echo ($v["phone"]); ?> </td>
							<td><?php echo ($v["company_address"]); ?></td>
							<!-- <td><?php echo ($v["address_info"]); ?></td> -->
							<td><?php echo ($v["business"]); ?></td>
							<td><?php echo ($v['visit_total']?$v['visit_total']:0); ?></td>
							<td><?php echo date('Y-m-d', $v['end_time']);?></td>
							<td>
								<div class="kbVipAdmin_btnMenuBox bc">
									<!-- <input class="adminFont kbVipAdmin_btnMenu operatingTOP" type="button" value="&#xe601;&nbsp;精选" /> -->
									<!-- <input class="adminFont kbVipAdmin_btnMenu" type="button" value="&#xe606;&nbsp;删除" /> -->
									<input class="adminFont kbVipAdmin_btnMenu lookList " type="button" value="&#xe625;&nbsp;详情" />
									<a class="adminFont kbVipAdmin_btnMenu lookWeb"  herf="javascript:;" target="_Blank" >&#xe714;&nbsp;预览 </a>
								</div>
							</td>
						</tr><?php endforeach; endif; endif; ?>
					</tbody>
				</table>
			</div>
			<div class="kbVipAdmin_page">
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
	<div class="kbVipAdmin_alert companyList_alert">
		<div class="kbVipAdmin_alertBox ">
		<button class="kbVipAdmin_alert-close adminFont"></button>
		<h3>商户详细信息</h3>
			<div class="kbVipAdmin_form spAnDynamic_alert_from">
				<p class="kbVipAdmin_enter">
					<b>店铺编号:</b>
					<input type="text" value="" name="address_info" />
				</p>
				<p class="kbVipAdmin_enter">
					<b>商户名称:</b>
					<input type="text" value="" name="company_name" />
				</p>
				<p class="kbVipAdmin_enter">
					<b>联系人:</b>
					<input type="text" value="" name="principal"/>
				</p>
				<!-- <p class="kbVipAdmin_enter">
					<b>商户类型:</b>
					<input type="text" value="" />
				</p> -->
				<p class="couponAddr kbVipAdmin_enter">
					<b>商户地区:</b>
					<input type="text" value="" name="company_address" />
				</p>
				<p class="couponTrade kbVipAdmin_enter"><b>商户行业:</b>
					<input type="text" value="" name="business_name" />
				</p>
				<!-- <div class="kbVipAdmin_fileImg">
					<b>商家图片:</span>
					
					<label class="fileImg" for="businessFileImg">请上传商家店铺图片</label>
					<input id="businessFileImg" type="file" />
					<h3 class="businessImg">
						<img src="images/21.jpg" alt="店铺图片" />
					</h3>
				</div> -->
					
				<p class="kbVipAdmin_enter">
					<b>商户手机:</b>
					<input type="text" value="" name="phone" />
				</p>
				<p class="kbVipAdmin_enter">
					<b>商户邮箱:</b>
					<input type="text" value="" name="email" />
				</p>
				<p class="kbVipAdmin_enter">
					<b>开通时间:</b>
					<input   type="text" name="start_time"  readonly=""  required="required"/>
				</p>
		<form class="couponBusiness_FormParent" action="<?php echo U('companyInfoUpdate');?>" method="post" onsubmit="return confirm('请注意:每个商户一个月内只能切换一次模版哦!并且所有广告轮播图需要重新设置')">
				<p class="kbVipAdmin_enter">
					<b>结束时间:</b>
					<input  type="text" name="end_time"  readonly="" onclick="jeDateTime(this,'end');" />
				</p>
				<p class="kbVipAdmin_enter">
					<b>商户域名后缀:</b>
					<input type="text" value="" name="web_postfix" />
				</p>
				<ul class="microWebMenuAdmin moduleUpdate kbVipAdmin_enter"><b>模版切换:</b>
					<?php if(is_array($templateList)): foreach($templateList as $key=>$v): ?><li class="bc">
					<img src="/Public<?php echo ($v["template_logo"]); ?>" width="150">
					<br />
					<p>
					<label class="kb_choose" style="top:6px">
						<input type="radio" name="template_id" value="<?php echo ($v["id"]); ?>" class="" required="required" />
						<span class="kb_choose-check kb_choose-check_radio w20 h20">
							<em class=" kb_choose-checkRadio"></em>
						</span>
					</label>
					<?php echo ($v["template_name"]); ?>
					</p>
					<!-- <input id="microWebDisabled<?php echo ($v["id"]); ?>" style="width: 0%;height: 0%" name="template_id" type="radio" value="<?php echo ($v["id"]); ?>" required="required" />
					<label for="microWebDisabled<?php echo ($v["id"]); ?>"><i></i><?php echo ($v["template_name"]); ?></label> -->
					</li><?php endforeach; endif; ?>
				</ul>
			</div>
			<div class="kbVipAdmin_operating ">
			    <div class="kbVipAdmin_restsubmit"> 
			       
			        <input  class="kbVipAdmin_opt w100 h40" type="submit" value="确认更新" />
			    </div>
			</div>
				
		</form>
		</div>
	</div>
	<script type="text/javascript">

		

		$(function(){
				// function init(){

				// }
				// init();
			// ajax
			// 详情
			$('.lookList ').on('click',function(){
				$('.kbVipAdmin_alert').fadeIn();
				$('.companyList_alert').find('input').not('input[name="web_postfix"]').prop('readonly',true)
				// $('.companyList_alert').find('input').prop('disabled',true)
				$('.companyList_alert').find('input').not('input[name="end_time"],input[name="web_postfix"]').css('border','none')
				
				var $this=$(this)
				var ajaxUrl ='<?php echo U("Company/ajaxControl");?>'
				jsAjaxControl( $this,{
					 ajaxURL:ajaxUrl,
					 ajaxBranch:'Common',
					 params:{
						flag:'selCompanyInfo',
					}
				},function(ren){
					$('.companyList_alert .couponBusiness_FormParent').attr('action', "<?php echo U('companyInfoUpdate');?>?id="+ren.id);
					for(r in ren){
						if(r=="start_time" || r=="end_time"){
							$('.companyList_alert input[name="'+r+'"]').val(date('Y-m-d H:i:s',ren[r]));
						}else if(r=="template_id"){
							$('.companyList_alert input[name="template_id"][value="'+ren.template_id+'"]').attr('checked',true);

						}else{
							$('.companyList_alert input[name="'+r+'"]').val(ren[r]);
						}
						
					}
				})
			})
			//状态
			$('tr .microWebMenuAdmin input').on('click',function(){
				/* var ID = $(this).parent().parent().siblings().eq(0).text().trim();*/
				var $this=$(this)
				var ajaxUrl ='<?php echo U("Company/ajaxControl");?>'

				var Status =$this.val().trim(); 
				jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
					ajaxBranch:'Common',
					params:{
						flag:'changeCompanyStatus',
						id:$this.parent().parent().siblings('.companyId').text(),
						status:Status
					}
					},function(ren){
						operatingTip(ren);
				})
			})
			// 精选
			$('.operatingTOP').on('click',function(){
				var $this = $(this);
				var ajaxUrl ='<?php echo U("Company/ajaxControl");?>'

				jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
					ajaxBranch:'Confirm',
					params:{
						flag:'changeCompanyType',
						status:1
					}
				},function(ren){
					operatingTip(ren);
					if(ren=="操作成功") $($this).parents('tr').children('td[class="microWebMenuAdmin"]').html('<center><span style="font-size: 15px;color: #FF54AE">店铺已推选为特色店铺,不能修改其状态</span></center>');
				})
			})
		})/* end */

		//精选
		/* $.get('<?php echo U("ajaxControl");?>', {flag:'changeAdminUserStatus', id: id,status:$(this).val()},function (res){
				if (res) 
				{
					alert('修改成功');
				}
			}); */
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Company/companyList'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>