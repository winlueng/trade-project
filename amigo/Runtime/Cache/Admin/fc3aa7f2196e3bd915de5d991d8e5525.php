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
	
	<div id="kbVipAdmin_rightCenter" class="spAnDynamic OrderForm">
		<div class="centerTitle">
			<h1>动态列表</h1>
		</div>
		<div class="kbVipAdmin_operating spAnDynamic-operating filter-operating" >
			<form action="" method="get" style="display:inline-block">
					<select class="kbVipAdmin_slt w200 h30" name="news_classify_id" title="可选择分类查找相关商品">
						<option value="">全部类型</option>
						<?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id'] == $_GET['news_classify_id']?'selected':''); ?>><?php echo ($v["news_type_name"]); ?></option><?php endforeach; endif; ?>
					</select>
				<input type="submit" class="kbVipAdmin_opt w80 h30" value="确认查找">
			</form>
			<form>
				<div class="filter-searchDate mr10">
						<input type="search" name="order_number" value="" placeholder="请输入想要查找的内容">
						<input class="kbVipAdmin_opt w80 h30 fr" type="submit" value="确定">
				</div>
				
			</form>
			<a class="kbVipAdmin_opt w80 h20 kbVipAdmin_add fr copyButton-default" href="<?php echo U('News/newsAddByProject',['id' => $v['id'], 'module' => $_GET['module']]);?>">添加</a>
		</div>
		<div class="main-contentBox kbVipAdmin_mt24" >
			<div class="kbVipAdmin_table">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>动态分类</th>
							<th width="15%">动态标题</th>
							<th width="20%">动态简述</th>
							<th>添加时间</th>
							<th>浏览人数</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(empty($list)): ?><tr ><td colspan="8"><span style="color:#F209CA;font-size:20px">暂无动态数据</span></td></tr>
					<?php else: ?>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["classify_name"]); ?></td>
							<td width="15%"><?php echo ($v["news_name"]); ?></td>
							<td width="20%"><?php echo ($v["title"]); ?></td>
							<td><?php echo date('Y-m-d', $v['addtime']);?></td>
							<td><?php echo ($v['visit_total']?$v['visit_total']:0); ?></td>
							<td>
								
								<p class="kbVipAdmin_checkbox kbVipAdmin_checkboxTop">
									<input  type="checkbox" name="is_top" <?php echo ($v['is_top'] == '1'?'checked':''); ?> />
									<label class="font_6ccac9">
										<b class="kbVipAdmin_buttonMr"></b>
										置顶
									</label>
								</p>
								<p class="kbVipAdmin_checkbox kbVipAdmin_checkboxdisabled">
									<input type="checkbox"  name="status" <?php echo ($v['status'] == '1'?'checked':''); ?> />
									<label class="font_ff6c60">
										<b class="kbVipAdmin_buttonMr">
										</b>
										禁用
									</label>
								</p>
								
							</td>
							<td class="kbVipAdmin_tdAction">
								<a class="font_57c8f2 kbVipAdminSea w30 h20 copyButton-default" href="<?php echo U('preview', ['id' => $v['id']]);?>" target="view_window" tittle="预览"></a>
								<a class="font_57c8f2 kbVipAdminEdit w20 h20 copyButton-default"  tittle="编辑" href="<?php echo U('News/newsUpdateByProject',['id' => $v['id'], 'module' => $_GET['module']]);?>"></a>
								<input class="font_ff6c60 kbVipAdminDel" type="button" value="" tittle="删除" data-id="<?php echo ($v["id"]); ?>" />
							</td>
						</tr><?php endforeach; endif; endif; ?>
					</tbody>
				</table>
			</div>
			<div class="kbVipAdmin_page mb10">
					<div class="pageSize">
						<?php echo ($page); ?>
						<script type="text/javascript">
							$('.pageSize a:first-child').addClass('prevPage');
							$('.pageSize a:last-child').addClass('nextPage');
						</script>
					</div>
					<div class="pageJump">	
					<form >
						<input class="w60  fl" type="text" name="p" placeholder="<?php echo I('get.p');?>" />
						<input type="submit" class="fl" name="" value="跳转">
					</form>	
					</div>
				</div>
		</div>
		
	 

	<script type="text/javascript">

	
     $(function(){
   		$('.spAnDynamic-operating .kbVipAdmin_add').on('click',function(){
   			$("#kbVipAdmin-edit").siblings().fadeOut();
   			$("#kbVipAdmin-edit").fadeIn();

   			


   		})
   		$('.spAnDynamic-edit .kbVipAdmin_operating input[type=reset]').on('click',function(){
   			$("#kbVipAdmin-edit").siblings().fadeIn();
   			$("#kbVipAdmin-edit").fadeOut(); 
   		})
   		
   		$('.spAnDynamic_alert .kbVipAdmin_operating input').on('click',function(){
   			$(".spAnDynamic_alert").fadeOut();
   		})
   		function checkChosen(){
   			var icheckChosen= $(".kbVipAdmin_checkboxChosen input");
   			for(var r=0;r<icheckChosen.length;r++){
   				if($(icheckChosen[r]).is(":checked")){
   					if(!$(icheckChosen[r]).hasClass('audioDisable')){
   						$(icheckChosen[r]).parent().siblings('.kbVipAdmin_checkbox').addClass('kbVipAdmin_checkboxChosenNot');
			   			$(icheckChosen[r]).parent().siblings('.kbVipAdmin_checkbox').children('input').prop('disabled','disabled')
   					}
		   		}else{
		   			$(icheckChosen[r]).parent().siblings('.kbVipAdmin_checkbox').removeClass('kbVipAdmin_checkboxChosenNot');
		   			$(icheckChosen[r]).parent().siblings('.kbVipAdmin_checkbox input').prop('disabled',false)
		   		}
   			}
   			
   		}
   		checkChosen();
   		/* 商户后台置顶*/
   		$('.kbVipAdmin_checkboxTop input').on('change',function(){
   			var $this=$(this);
   			var  Status=($this.is(":checked")===true)? 1:0;
   			var ajaxUrl='<?php echo U("News/ajaxControl");?>';
   			if(!$this.prop('disabled')){
   			jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
			        params:{//这是ajax需要提交的集合
			        	flag:"changeNewsTop",
			        	is_top:Status,
			        }
				},function(res){

					oTip(res);
					if(res=="操作成功"){
						$this.parent().siblings('.kbVipAdmin_checkboxChosen').fadeToggle();
					}
					
			})
	   		}
	   	})
   		$('.kbVipAdmin_checkboxdisabled input').on('change',function(){
   			var $this=$(this);
   			var  Status=($this.is(":checked")===true)? 1:0;
   			var ajaxUrl='<?php echo U("News/ajaxControl");?>';
   			if(!$this.prop('disabled')){
   			jsAjaxControl($this,{
					ajaxURL:ajaxUrl,
			        ajaxBranch:'Common',
			        params:{//这是ajax需要提交的集合
			        	flag:"changeNewsStatus",
			        	status:Status,
			        }
				},function(res){
					if(res){
						sTip('操作成功');
					}else{
						eTip('操作失败')
					}
					console.log(res);
			})
			}
   		})

   		/* 商户后台推选*/
		
	    	/* 删除 */
   		$(".kbVipAdminDel").on('click',function(){
   			var $this=$(this);
   			var ajaxUrl='<?php echo U("News/ajaxControl");?>';
            Confirm("确定删除吗？",function(res){
                if(res){
                    $.ajax({
                        type:"GET",
                        url:ajaxUrl,
                        data:{
                            flag:"newsDel",
                            id:$this.attr('data-id')
                        },
                        dataType:"json",
                        success:function(data){
                            console.log(data);
                            if(data==1){
                                sTip("操作成功");
                                $this.parents('tr').remove();
                            }
                        },
                        error:function(error){
                            console.log(error)
                        }
                    })    
                }
                
            })
            
   			
   		})
	 })/* function end */
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/News/newsListByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>