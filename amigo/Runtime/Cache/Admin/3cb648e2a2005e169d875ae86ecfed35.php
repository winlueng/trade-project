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


	
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?version=1.1"></link>
	<link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">

<style>
.kbVipAdmin_alertBox article{
	width:92%;
	margin-left:auto;
	margin-right:auto;

}
.RefundsBtn_opt p{
	margin-bottom:10px;
}
.RefundsBtn_opt li:nth-child(2){
	display:none;
}
.filter-operating form{
			display:inline-block;
			vertical-align:top;
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
	
<!-- 主内容 -->
	<div id="kbVipAdmin_rightCenter" class="OrderForm">
		<!-- 内容标题部 -->
		<div class="centerTitle">
			<div class="kbVipAdmin_operating filter-operating" >
				<form>
					<div class="filterData">
					<input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
					<input class="start" type="hidden" name="start" value="" />
					<input  class="end"  type="hidden" name="end" value="" />
					<button class="kbVipAdmin_opt w80 h30" type="submit">确定</button>
					</div>
				</form>
				<form >
				<span class="kbVipAdmin_enter"><input type="text" name="out_refund_no" value="<?php echo I('get.out_refund_no');?>" style="width: 200px" placeholder="请输入退款订单号进行搜索" ></span>
				<button class="kbVipAdmin_opt w80 h30" type="submit">确定</button>
				</form>
			</div>
		</div>
		<div class="kb_table-filter mb10">
			<nav class="hrefFlex">
				<a class="<?php echo ($_GET['status']?'':'selected'); ?>" href="<?php echo U('orderListByProject', ['status' => 0, 'module' => $_GET['module']]);?>">全部退款</a>
				<a class="<?php echo ($_GET['status'] == 1?'selected':''); ?>" href="<?php echo U('orderListByProject', ['status' => 1, 'module' => $_GET['module']]);?>">申请退款</a>
				<a class="<?php echo ($_GET['status'] == 2?'selected':''); ?>" href="<?php echo U('orderListByProject', ['status' => 2, 'module' => $_GET['module']]);?>">已退款</a>
				<a class="<?php echo ($_GET['status'] == 3?'selected':''); ?>" href="<?php echo U('orderListByProject', ['status' => 3, 'module' => $_GET['module']]);?>">拒绝退款</a>
			</nav>
			<button class="kbVipAdmin_opt  h30" type="button" onclick="javascript:window.location.href='?getExcel=1&status=<?php echo ($_GET["status"]); ?>&start=<?php echo ($_GET["start"]); ?>&end=<?php echo ($_GET["end"]); ?>'">下载Excel</button>

		</div>
		<!-- 内容标题部结束 -->
		<!-- 内容表格部 -->
		<div class="main-contentBox kbVipAdmin_mt24" >
			
			<div class="kbVipAdmin_table mb20	">
				<table>
					<thead>
						<tr>
							<th>序号</th>
							<th>申请时间</th>
							<th>订单号</th>
							<th>微信支付单号</th>
							<th>订单金额</th>
							<th>用户信息</th>
							<th>退款状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td><p><?php echo ($v["id"]); ?></p></td>
							<td><p><?php echo date('Y年m月d日 H时i分s秒', $v['create_time']);?></p></td>
							<td>
								<p><?php echo ($v["out_trade_no"]); ?></p>
							</td>
							<td><p><?php echo ($v['transaction_id']?$v['transaction_id']:'余额支付'); ?></p></td>
							<td><p>￥<?php echo ($v["total_fee"]); ?></p></td>
							
							<td>
								<p>用户ID: <?php echo ($v["visitor_id"]); ?></p>
								<p>用户名称: <?php echo ($v["visitor_name"]); ?></p>
							</td>
							<td>
								<p>
									<?php switch($v["status"]): case "0": ?>申请中<?php break;?>
										<?php case "1": ?>已退款<?php break;?>
										<?php case "2": ?>拒绝退款<?php break; endswitch;?>
								</p>
							</td>
							<td>
								<p class="mb10">
									<a href="<?php echo U('WechatRefund/companyOrderDetailByProject',['id' => $v['id'],'module' => $_GET['module']]);?>" class=" kbVipAdmin_button_eee">查看</a>
								</p>
								<?php if($v['status'] == 0): ?><p class="mb10">
									<input class="kbVipAdmin_opt RefundsBtn" refundID="<?php echo ($v["id"]); ?>" type="button" value="退款操作" v-on:click="RefundsBtn('<?php echo ($v["id"]); ?>')"/>
									</p><?php endif; ?>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<!-- <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>-->
					<!--<?php endforeach; endif; else: echo "" ;endif; ?> -->		
					</tbody>
				</table>
			</div>
			<div class="kbVipAdmin_page">
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
		
		<div id="showExpressInfo" class="kbVipAdmin_alert showExpressInfo ">
			<div class="kbVipAdmin_alertBox ">
				<button type="button" class="kbVipAdmin_alert-close " v-on:click="hideExpressInfo"></button>
				<h3 class="mb10">睇睇去到边</h3>
					<article>
						<h4>交易信息</h4>
						<p>微信支付单号：{{info.transaction_id}}</p>
						<p>商品订单号：{{info.transaction_id}}</p>
						<p>订单金额：{{info.total_fee}}</p>
						<p>退款原因：{{info.refund_remark}}</p>
					</article>
				<hr/>
				<form action="<?php echo U('WechatRefund/wxRefund');?>" method="post">
					<article>
						<p class="mb10 tc RefundsBtn_btn">
							<button  type="button" class="kbVipAdmin_opt kbVipAdmin_opt_7facff" v-on:click="RefundsBtn_btn($event)">同意退款</button>
							<button type="button" class="kbVipAdmin_opt" v-on:click="RefundsBtn_btn($event)">拒绝退款</button>
						</p>
						<ul class="RefundsBtn_opt">
							<li class="kbVipAdmin_enter agreeReturn" v-if="blockControl">
								<p>
									<b><i>*</i>退款金额:</b>
									<input class="remarkMoney" type="number" name="refund_fee" value=""   placeholder="退款金额" required="required" />
								</p>
								<p>
									<b><i>*</i>同意退款备注:</b>
									<input class="remark" type="text"  value=""  name="admin_remark" placeholder="同意退款备注" required="required" />
								</p>
							</li>
							<li class="kbVipAdmin_enter refuseReturn" v-else>
								<p>
									<b><i>*</i>拒绝原因:</b>
									<input class="remark" type="text"  name="admin_remark" value=""   placeholder="请说明拒绝理由" required="required" />
								</p>
							</li>
						</ul>
					</article>
					<div class="kbVipAdmin_operating">
						<div class="kbVipAdmin_restsubmit">
							<input v-on:click="RefundsSmt($event)"  class="kbVipAdmin_button_005aff w80 h30 tc" type="button" value="好的" />
						</div>
					</div>
				</form>
			</div>
		</div>
	<div class="ui-datepicker-css">	
	    <div class="ui-datepicker-quick">
	        <p>快捷日期<a class="ui-close-date">X</a></p>
	        <div>
	            <input class="ui-date-quick-button" type="button" value="今天" alt="0"  name=""/>
	            <input class="ui-date-quick-button" type="button" value="昨天" alt="-1" name=""/>
	            <input class="ui-date-quick-button" type="button" value="7天内" alt="-6" name=""/>
	            <input class="ui-date-quick-button" type="button" value="14天内" alt="-13" name=""/>
	            <input class="ui-date-quick-button" type="button" value="30天内" alt="-29" name=""/>
	            <input class="ui-date-quick-button" type="button" value="60天内" alt="-59" name=""/>
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/WechatRefund/companyOrderListByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	<script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/share.js?v=1.11"></script>
	<script>

		  $(function(){
   		
	   		$('.kbVipAdmin_alert .kbVipAdmin_operating input[type="reset"]').on('click',function(){
	   			$('.kbVipAdmin_alert').fadeOut();
	   		});
	   		(function(){
	   			var app=new Vue({
	   				el:'#showExpressInfo',
	   				data:{
	   					info:{},
	   					blockControl:true
	   				},
	   				methods:{
				   		RefundsBtn_btn:function(event){
				   			var RefundsBtn_btn=$('.showExpressInfo .RefundsBtn_btn button');
				   				$this=$((event.srcElement)?event.srcElement:event.target);
				   				indexs=RefundsBtn_btn.index($this);

				   			$this.addClass('kbVipAdmin_opt_7facff').siblings().removeClass('kbVipAdmin_opt_7facff');
				   			if(indexs==0){
				   				this.blockControl=true;
					   		
				   			}else{
				   				this.blockControl=false;
				   				
				   			}
				   		},
	   					RefundsSmt:function(event){
	   						var $this=$((event.srcElement)?event.srcElement:event.target),
	   							Required=$this.parents('form').find('.kbVipAdmin_enter'),
	   							status=false,	
	   							url="<?php echo U('WechatRefund/ajaxControl');?>?flag=wxRefund&id="+app.info.id,
	   							formData=new FormData();
	   						if(app.blockControl){
	   							if(Required.find('.remarkMoney').val()<=app.info.total_fee && Required.find('.remark').val().length){
	   								status=true;
	   							}else{
	   								Alert("退款金额不能大于订单金额或退款原因不能为空");
	   							}

	   						}else{
	   							if(Required.find('.remark').val().length>0){
	   								status=true;
	   							}else{
	   								Alert("请填写拒绝退款原因");	
	   							}
	   						}
	   						Required.find('input[name]').each(function(indexs,elem){
								formData.append($(elem).attr('name'),$(elem).val());
							});
							
	   						if(status){
   						        $.ajax({  
   						            url: url ,  
   						            type: 'POST',  
   						            data: formData,  
   						            enctype: 'multipart/form-data',
   						            async: false,  
   						            cache: false,  
   						            contentType: false,  
   						            processData: false,  
   						            success: function (res) { 
   						            	if(res.status=='true'){
   						            		sTip('操作成功');
   						            	}else{
					            			eTip('操作失败');
   						            	}
   						          		console.debug(res);
   						          		$('.showExpressInfo').fadeOut();
   						            },  
   						            error: function (returndata) {  
   						                alert(returndata);  
   						            }  
   							     }); 
	   						}

	   					},
	   					hideExpressInfo:function(){
	   						$('.showExpressInfo').fadeOut();
	   					}
	   				}
	   			});
	   			$('.RefundsBtn').on('click',function(){
		   			var $this=$(this),
				   		id=$this.parents('tr').children('td').eq(0).children('p').text().trim();
			   			$('.showExpressInfo  form').attr('action', '<?php echo U("wxRefund");?>?id='+$(this).attr('refundID'));

			   			$('.showExpressInfo').fadeIn();
			   			$.get("<?php echo U('WechatRefund/ajaxControl');?>",{
			   				flag:'orderInfo',
			   				id:id
			   			},function(res){
			   				console.log(res);
			   				app.info=res;
			   			})
	   			})
	   		})();
         });
   	</script>

</body>
</html>