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
	
	<div id="kbVipAdmin_rightCenter" class="couponTrade_center OrderForm">
	<div class="centerTitle">
             
      <h1>管理员列表</h1>
   </div>

    <div class="kbVipAdmin_operating filter-operating">
    	<form class="kbVipAdmin_inlineBlock" action="" >
    		<div class="filter-searchDate mr10">
	    	<input class="kbVipAdmin_search microWeb-search" type="search" name="selCompanyName" value="<?php echo I('get.selCompanyName');?>" placeholder="请输入商户名称搜索" />

	    	<button  type="submit" class="kbVipAdmin_opt w80 h30 fr">查询</button>
	    	</div>
    	</form>
    	<!-- <p class="authAddBtn"> -->
    		<!-- <input class=" adminFont kbVipAdmin_btn w100 h50 addCouponAdClass fr"  type="button" value="&#xe762;&nbsp;&nbsp;添加" /> -->
    	<!-- </p> -->
    </div>

	<div class="main-contentBox">
		<div class="kbVipAdmin_table">
			<table class="roleList couponBusiness_roleList">
				<thead>
					<tr>
						<th>序号</th>
						<th>用户帐号</th>
						<th>手机号码</th>
						<th>邮箱地址</th>
						<th>所属商户</th>
						<th>状态</th>
						<!-- <th>操作</th> -->
					</tr>
				</thead>
				<tbody>
				<?php if(empty($noList)): ?><tr><td colspan="6"><center><font size="5" color="#F50C36">暂无查找数据</font></center></td></tr>
				<?php else: ?>
				<?php if(is_array($userList)): $i = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
						<td class="companyAdminId"><?php echo ($v["id"]); ?></td>
						<td><?php echo ($v["user_name"]); ?></td>
						<td><?php echo ($v["phone"]); ?></td>
						<td><?php echo ($v["email"]); ?></td>
						<td><?php echo ($v["company_name"]); ?></td>
						<td class="microWebMenuAdmin">
							<p class="kbVipAdmin_pushBtn">
								<input  name="microWebMenuAdmin"  type="checkbox" <?php echo ($v['status'] == '0'?'checked':''); ?> 
								title="<?php echo ($v['status'] == '0'?'启用':'禁用'); ?>"
								value="0"
								 onclick="companyAdminChangeStatus(this)" 
								/>
								<label ><b></b></label>
							</p>
						</td>
						<!-- <td>
							<div class="kbVipAdmin_btnMenuBox bc">
								<input class="adminFont kbVipAdmin_btnMenu lookList couponAreaListWirte" type="button" value="&#xe601;&nbsp;编辑" />
								<input class="adminFont kbVipAdmin_btnMenu kbVipAdmin_btnMenuDel" type="button" value="&#xe606;&nbsp;删除" />
							</div>
						</td> -->
					</tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
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
		<div class="kbVipAdmin_alert_box ">
		<button class="kbVipAdmin_alert-close adminFont">&#xe61b;</button>
		<h2>添加行业</h2>
		<form class="couponBusiness_FormParent" action="<?php echo U('businessAdd');?>" method="post">
			<div class="kbVipAdmin_form">
				<p>
					<span>行业名称:</span>
					<input type="text" name="business_name" value="" />
				</p>
				<!-- <p class="couponAddrTrade"><span>所属区域：</span>
					<input type="text" value="" disabled="disabled" name="region" /><b>修改</b>
				</p> -->
				<div class="couponAddr userAreaSlt">
					<span>所属区域:</span>
					<select>
						<option value="">请选择</option>
						<?php if(is_array($region)): foreach($region as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v["region_name"]); ?></option><?php endforeach; endif; ?>
					</select> 
				</div>
				<div class="kbVipAdmin_textArea">
					<span>描述:</span>
					<textarea name="business_desc"></textarea>
				</div>
			</div>
			<p class="kbVipAdmin_MenuAdminBtn">
				<input class="authAddFormSmt" type='submit' value="添加" />
			</p>
		</form>
		</div>
	</div>
	<div class="kbVipAdmin_alert couponBusiness_alertEdit">
		<div class="kbVipAdmin_alert_box ">
		<button class="kbVipAdmin_alert-close adminFont">&#xe61b;</button>
		<h2>编辑行业</h2>
		<form class="couponBusiness_FormParent" action="" method="post">
			<div class="kbVipAdmin_form">
				<p>
					<span>行业名称:</span>
					<input type="text" name="business_name" value="" />
				</p>
				<p class="couponAddrTrade"><span>所属区域：</span>
					<input type="text" value="" disabled="disabled" name="region_name" /><b>修改</b>
				</p>
				<p class="couponAddr userAreaSlt" style="display:none">
					<span>所属区域:</span>
					<select>
						<option value="">请选择</option>
						<?php if(is_array($region)): foreach($region as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v["region_name"]); ?></option><?php endforeach; endif; ?>
					</select>
				</p>
				<div class="kbVipAdmin_textArea">
					<span>描述:</span>
					<textarea name="business_desc"></textarea>
				</div>
			</div>
			<p class="kbVipAdmin_MenuAdminBtn">
				<input style="display:block" class="authAddFormSmt" type='submit' value="保存" />
			</p>
		</form>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){

			$('.addCouponTrade ').on('click',function(){
				$('.couponBusiness_alertWriter').fadeIn();
			});
			$('.couponListWirte ').on('click',function(){
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
		        $('.couponAddrTrade b').on('click',function(){

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
			var bool = confirm('确定要删除吗?');
			if (bool) 
			{
				$.get('<?php echo U("ajaxControl");?>',{flag:'del',id:$(obj).parent().siblings('.businessID').text()},function(res){
					if (res == 2) 
					{
						alert('此行业下还存在商户,不能删除');
					}else{
						alert(res);
						$(obj).parent().parent().remove();
					}
				});
			}
		}

		function companyAdminChangeStatus(obj) {
			var id = $(obj).parents('td').siblings('.companyAdminId').text().trim(),
			 status = $(obj).prop("checked")?0:1;
			$.get('<?php echo U("ajaxControl");?>', {flag:'changeAdminUserStatus', id:id, status:status}, function (res) {
				if(res){
				  sTip("修改成功");
				}else{
				  eTip("修改失败");	
				}
			})
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/User/userListByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>