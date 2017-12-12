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


	
  <style>
	.couponBusiness_alertEdit .couponAddrTrade b{
		cursor: pointer; 
	}
	.userAreaSlt select{
        width:120px;
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
	
	<div id="kbVipAdmin_rightCenter" class="couponTrade_center OrderForm">
		 <div class="centerTitle">
	      <h1>行业列表</h1>
	   </div>
	   <div class="kbVipAdmin_operating">
	   	<p class="authAddBtn">
	   		<input class=" adminFont kbVipAdmin_opt w80 h30 addCouponTrade"  type="button" value="&#xe762;&nbsp;&nbsp;添加" />
	   	</p>
	   </div>
		<div class="main-contentBox">
			<div class="kbVipAdmin_table">
				<table class="roleList couponBusiness_roleList">
					<thead>
						<tr>
							<th>编号</th>
							<th>行业名称</th>
							<th>所属区域</th>
							<th>描述</th>
							<th>添加时间</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td class="businessID"><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["business_name"]); ?></td>
							<td><?php echo ($v['address']); ?></td>
							<td><?php echo ($v["business_desc"]); ?></td>
							<td><?php echo date('Y年m月d日', $v['addtime']);?></td>
							<td class="microWebMenuAdmin">
								<p class="kbVipAdmin_pushBtn">
									<input type="checkbox" value="" <?php echo ($v['status'] == '0'?'checked':''); ?> title=" <?php echo ($vo['status'] == '0'?'启用':'禁用'); ?>"/>
									<label><b></b></label>
								</p>
								
							</td>
							<td>
								<input class="adminFont kbVipAdmin_btnMenu couponListWirte" type="button" value="&#xe601;&nbsp;编辑" />
								<input class="adminFont kbVipAdmin_btnMenu" type="button" value="&#xe606;&nbsp;删除" onclick="businessDel(this)" />
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
			<!-- 分页位置 -->
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
	<div class="kbVipAdmin_alert couponBusiness_alertWriter">
		<div class="kbVipAdmin_alertBox ">
		<button class="kbVipAdmin_alert-close adminFont"></button>
		<h3>添加行业</h3>
		<form class="couponBusiness_FormParent pt10" action="<?php echo U('businessAdd');?>" method="post">
			<div class="kbVipAdmin_form">
				<p class="kbVipAdmin_enter">
					<b><i>*</i>行业名称:</b>
					<input type="text" name="business_name" value="" />
				</p>
				<!-- <p class="couponAddrTrade"><b>所属区域：</b>
					<input type="text" value="" disabled="disabled" name="region" /><b>修改</b>
				</p> -->
				<div class="couponAddr userAreaSlt kbVipAdmin_enter">
					<b><i>*</i>所属区域:</b>
					<select>
						<option value="">请选择</option>
						<?php if(is_array($region)): foreach($region as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v["region_name"]); ?></option><?php endforeach; endif; ?>
					</select> 
				</div>
				<div class="kbVipAdmin_textArea kbVipAdmin_enter">
					<b><i>*</i>描述:</b>
					<textarea name="business_desc"></textarea>
				</div>
			</div>
			<div class="kbVipAdmin_operating ">
			    <div class="kbVipAdmin_restsubmit"> 
			        
			        <input  class="kbVipAdmin_opt authAddFormSmt w100 h40" type="submit" value="添加" />
			    </div>
			</div>
			
		</form>
		</div>
	</div>
	<div class="kbVipAdmin_alert couponBusiness_alertEdit">
		<div class="kbVipAdmin_alertBox ">
		<button class="kbVipAdmin_alert-close adminFont"></button>
		<h3>编辑行业</h3>
		<form class="couponBusiness_FormParent pt10" action="" method="post">
			<div class="kbVipAdmin_form">
				<p class="kbVipAdmin_enter ">
					<b><i>*</i>行业名称:</b>
					<input type="text" name="business_name" value="" />
				</p>
				<p class="couponAddrTrade kbVipAdmin_enter">
				<b>所属区域：</b>
					<input type="text" value="" disabled="disabled" name="region_name" />
					<span>修改</span>
				</p>
				<p class="couponAddr userAreaSlt kbVipAdmin_enter" style="display:none">
					<b><i>*</i>所属区域:</b>
					<select>
						<option value="">请选择</option>
						<?php if(is_array($region)): foreach($region as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v["region_name"]); ?></option><?php endforeach; endif; ?>
					</select>
				</p>
				<div class="kbVipAdmin_textArea kbVipAdmin_enter">
					<b><i>*</i>描述:</b>
					<textarea name="business_desc"></textarea>
				</div>
			</div>
			<div class="kbVipAdmin_operating ">
			    <div class="kbVipAdmin_restsubmit"> 
			        <input  class="kbVipAdmin_opt authAddFormSmt w100 h40" type="submit" value="保存" />
			    </div>
			</div>
		
		</form>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){

			$('.addCouponTrade').on('click',function(){
				$('.couponBusiness_alertWriter').fadeIn();
			});
			$('.couponListWirte').on('click',function(){
				$('.couponBusiness_alertEdit').fadeIn();
				var $this = $(this);
				var ID = $this.parent().siblings().eq(0).text();
		        $.get('<?php echo U("ajaxControl");?>',{flag:"selBusinessInfo",id:ID},function (res){
		        		for(r in res){
		        			switch(r){
		        				case "business_desc":
		        					$('.couponBusiness_alertEdit form').find('textarea[name="business_desc"]').val(res[r]);
		        				break;
		        				default:
		        				$('.couponBusiness_alertEdit form').find('input[name="'+r+'"]').val(res[r]);
		        			}
		        			
		        		}
			 			
				});
				$('.couponBusiness_alertEdit form').prop('action',"<?php echo U('businessUpdate');?>?id="+ID);
		        $('.couponAddrTrade span').on('click',function(){
					$('.couponAddr').fadeToggle();
					$('.couponTrade').fadeToggle();
					$(this).text(($(this).text()=="修改")? "取消":"修改");
					// var inputName=$(this).text(($(this).text()=="修改")? "取消":"修改");
				})
			});

			$('.couponAddr select').on('change',function (){
	            var a ;
	            a = parseInt($(this).attr('sta'));
	            var flag = 'address';
	            if (a === 3) 
	            {   
	                flag = 'region';
	            }
	            var fa = $(this).next();
	            var name = fa.find('option:eq(0)').text();
	            $.get('/Admin/Card/ajaxControl',{'flag':flag,'pid':$(this).val()},function (res){
	                var str = '<option value="">'+name+'</option>';
	                for(var k in res)
	                {
	                    str += '<option value="'+res[k].district_id+'">'+ res[k].name +'</option>';
	                }
	                fa.html(str);
	            });
	        });

	        $(' .microWebMenuAdmin input').on('click',function(){
	        	var $this= $(this);
	        	var couponAreaListStatus= $this.prop('checked')?0:1,
	        	id=$this.parents('tr').children('td').eq(0).text().trim();

	        	var ajaxUrl='<?php echo U("Business/ajaxControl");?>'
	        	// console.log(couponAreaListId);
	        	$.ajax({
					type:"GET",
					url:ajaxUrl,
					data:{
						flag:'changeBusinessStatus',
				        status:couponAreaListStatus,
				        id:id
					},
					dataType:"json",
					success:function(data){
						console.log(data);
						oTip(data);
					},
					error:function(error){
						console.log(error);
					}
				})
	        	
	        });

	        $('.userAreaSlt select').on('change',function(){
                var $this = $(this);
                var options=$this.children('option:selected');
                var optionsVal=options.val();
                var ajaxUrl='<?php echo U("Goods/ajaxControl");?>';
              	$('select[name=business_id]').children().not('option[value=-1]').remove();//区域选择有变动时，清除行业选择内容
                userAreaSltChild(this,ajaxUrl);
               
            });/*userAreaSlt select end */
		});

		function businessDel(obj)
		{
			var bool = Confirm('确定要删除吗?',function(res){
				if(res){
					$.get('<?php echo U("ajaxControl");?>',{flag:'del',id:$(obj).parents('td').siblings('.businessID').text()},function(res){
						if (res == 2) 
						{
							oTip('此行业下还存在商户,不能删除');
						}else{
							oTip(res);
							$(obj).parent().parent().remove();
						}
					});
				}
			});
			
		}
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Business/businessAdd'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>