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
		.filter-operating{

		}
		.filter-operating form{
			display:inline-block;
			vertical-align:top;
		}
	/*	.filterData input{
			width:130px;
		}*/
		.filterData{
			display:inline-block;
			width:340px;
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
	<div id="kbVipAdmin_rightCenter" class="visitorOrder">
		<!-- 内容标题部 -->
		<div class="centerTitle">
			<!-- <div class="kbVipAdmin_operating filter-operating" >
				<form>
					<div class="filterData">
					<input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
					<input class="start" type="hidden" name="start" value="" />
					<input  class="end"  type="hidden" name="end" value="" />
					<button class="kbVipAdmin_opt w80 h30" type="submit">确定</button>
					</div>
				</form>

				<form >
				<span class="kbVipAdmin_enter"><input type="text" name="order_number" value="<?php echo I('get.order_number');?>" style="width: 200px" placeholder="请输入订单号进行搜索" ></span>
					<button class="kbVipAdmin_opt w80 h30" type="submit">确定</button>
				</form>
			</div> -->
			<h2 class="mb10">
				<a class="mr10" href="javascript:history.back(-1)" ><img src="/Public/Business/BusinessImages/back.png"></a>
				<span>历史购物信息</span>
			</h2>
		</div>
		<!-- <div class="kb_table-filter mb10">
			<nav class="hrefFlex">
				<a class="<?php echo ($_GET['status']?'':'selected'); ?>" href="<?php echo U('');?>">全部订单</a>
				<a class="<?php echo ($_GET['status'] == 1?'selected':''); ?>" href="<?php echo U('', ['visitor_id' => $_GET['visitor_id'], 'status' => 1]);?>">待付款</a>
				<a class="<?php echo ($_GET['status'] == 2?'selected':''); ?>" href="<?php echo U('', ['visitor_id' => $_GET['visitor_id'], 'status' => 2]);?>">待发货</a>
				<a class="<?php echo ($_GET['status'] == 3?'selected':''); ?>" href="<?php echo U('', ['visitor_id' => $_GET['visitor_id'], 'status' => 3]);?>">已发货</a>
				<a class="<?php echo ($_GET['status'] == 4?'selected':''); ?>" href="<?php echo U('', ['visitor_id' => $_GET['visitor_id'], 'status' => 4]);?>">交易完成</a>
				<a class="<?php echo ($_GET['status'] == 5?'selected':''); ?>" href="<?php echo U('', ['visitor_id' => $_GET['visitor_id'], 'status' => 5]);?>">售后/退款</a>
				<a class="<?php echo ($_GET['status'] == 6?'selected':''); ?>" href="<?php echo U('', ['visitor_id' => $_GET['visitor_id'], 'status' => 6]);?>">退款已处理</a>
			</nav>
			<a href="?getExcel=1">下载</a>
			<button class="kbVipAdmin_opt w80 h30" type="button">下载</button>
		</div> -->
		<!-- 内容标题部结束 -->
		<!-- 内容表格部 -->
		<div class="main-contentBox kbVipAdmin_mt24" >
			
			<div class="kbVipAdmin_table mb20 orderTable">
				<table>
					<thead>
						<tr>
							<th width="5%">序号</th>
							<th width="30%">商品名称</th>
							<th >单价数量</th>
							<th >总金额</th>
							<th>买家信息</th>
							<th>交易状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td>
							</td>
							<td colspans="8">
								<p>
									<time><?php echo date('Y-m-d H:i:s', $v['create_time']);?></time>
									<b>订单编号:<?php echo ($v["order_number"]); ?></b>
								</p>
							</td>
						</tr>
						<tr>
							<td width="5%"><p><?php echo ($v["id"]); ?></p></td>
							<td width="30%">
							<?php if(is_array($v["goods_data"])): $i = 0; $__LIST__ = $v["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><article>
									<p><?php echo ($vo["goodsInfo"]); ?></p>
									<p><?php echo ($vo["goodsAttr"]["attr_name"]); ?>: <?php echo ($vo["goodsAttr"]["attr_val"]); ?></p>
								</article><?php endforeach; endif; else: echo "" ;endif; ?>
							</td>
							<td><p>X<?php echo ($v["piece"]); ?></p></td>
							<td><p>￥<?php echo ($v["total"]); ?></p></td>
							
							<td>
								<p><?php echo ($v["address_id"]["consignee"]); ?> <?php echo ($v["address_id"]["phone"]); ?>  </p>
							</td>
							<?php switch($v["status"]): case "0": ?><td><p>待付款</p></td>
									<td>
										<div class="kbVipAdmin_tdAction"><?php break;?>
								<?php case "1": ?><td><p>用户取消订单</p></td>
									<td>
										<div class="kbVipAdmin_tdAction"><?php break;?>
								<?php case "2": switch($v["is_send_out"]): case "0": ?><td><p>已付款,待发货</p></td>
											<td>
												<div class="kbVipAdmin_tdAction">
													<input class="kbVipAdmin_opt w80 h30 tc shipGoods" title="家下就发货" orderID="<?php echo ($v["id"]); ?>" type="button" value="发货" /><?php break;?>
										<?php case "1": ?><td><p>待收货</p></td>
											<td>
												<div class="kbVipAdmin_tdAction">
													<input class="kbVipAdmin_opt w80 h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="查看物流信息" /><?php break;?>
										<?php case "2": ?><td><p>已收货</p></td>
											<td>
												<div class="kbVipAdmin_tdAction">
													<input class="kbVipAdmin_opt w80 h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="查看物流信息" /><?php break; endswitch; break;?>
								<?php case "3": ?><td><p>关闭交易</p></td>
									<td>
										<div class="kbVipAdmin_tdAction"><?php break;?>
								<?php case "4": ?><td><p>已完成</p></td>
									<td>
										<div class="kbVipAdmin_tdAction">
											<input class="kbVipAdmin_opt w80 h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="查看物流信息" /><?php break;?>
								<?php case "5": switch($v["is_send_out"]): case "0": ?><td><p>未发货,申请退款</p></td>
											<td>
												<div class="kbVipAdmin_tdAction"><?php break;?>
										<?php case "1": ?><td><p>已发货,申请退款</p></td>
											<td>
												<div class="kbVipAdmin_tdAction">
													<input class="kbVipAdmin_opt w80 h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="查看物流信息" /><?php break;?>
										<?php case "2": ?><td><p>已收货,申请退款</p></td>
											<td>
												<div class="kbVipAdmin_tdAction">
													<input class="kbVipAdmin_opt w80 h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="查看物流信息" /><?php break; endswitch; break;?>
								<?php case "6": switch($v["is_send_out"]): case "0": ?><td><p>未发货,已退款</p></td>
											<td>
												<div class="kbVipAdmin_tdAction"><?php break;?>
										<?php case "1": ?><td><p>已发货,已退款</p></td>
											<td>
												<div class="kbVipAdmin_tdAction">
													<input class="kbVipAdmin_opt w80 h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="查看物流信息" /><?php break;?>
										<?php case "2": ?><td><p>已收货,已退款</p></td>
											<td>
												<div class="kbVipAdmin_tdAction">
													<input class="kbVipAdmin_opt w80 h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="查看物流信息" /><?php break; endswitch; break;?>
								<?php default: ?>
									<td><p>未知情况</p></td>
											<td>
												<div class="kbVipAdmin_tdAction"><?php endswitch;?>
									<a class="kbVipAdmin_button_005aff " href="<?php echo U('orderInfo', ['id' => $v['id']]);?>">订单详情</a>
								</div>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
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
		<div class="kbVipAdmin_alert shipGoods_alert ">
			<div class="kbVipAdmin_alertBox">
				<button type="button" class="kbVipAdmin_alert-close "></button>
				<h3 class="mb10">发货</h3>
				<article>
					<h4>买家收货信息</h4>
					<p>收货人：张大充 13729000000</p>
					<p>收货人电话：</p>
					<p>收货地址：广东省广州市</p>
				</article>
				<hr/>
				<form action="" id="addrForm" method="post" enctype="multipart/form-data">
					<article>				
						<!-- <asibe>
							<label>物流选择:</label>
							<p class="choose">
								<input type="radio" name="a" checked="checked"/>
								<label>需要物流</label>
							</p>
							<p class="choose">
								<input type="radio" name="a" />
								<label>自提</label>
							</p>
						</asibe> -->
						<p>
							<label>运单号:</label>
							<select class="kbVipAdmin_slt w100 h30" name="express_name">
								<?php if(is_array($express)): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["coding"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</p>
						<p class="kbVipAdmin_enter">
							<label>运单号:</label>
							<input type="text" value="" name="express_number" />
						</p>
					</article>
					<div class="kbVipAdmin_operating">
						<div class="kbVipAdmin_restsubmit">
							<input  class="kbVipAdmin_button_005aff w80 h30 tc" type="reset" value="取消" />
							<input  class="kbVipAdmin_opt_7facff w80 h30" type="submit" value="保存" />
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="kbVipAdmin_alert showExpressInfo shipGoods_alert">
			<div class="kbVipAdmin_alertBox">
				<button type="button" class="kbVipAdmin_alert-close "></button>
					<h3 class="mb10">睇睇去到边</h3>
				<section class="kbVipAdmin_alertCentent">
						<article>
							<h4>买家收货信息</h4>
							<p>收货人：张大充 13729000000</p>
							<p>收货人电话：</p>
							<p>收货地址：广东省广州市</p>

						</article>
					<hr/>
						<article>
							<p>
								<label>快递公司:</label>
								<b>收货人：张大充 13729000000</b>
							</p>
							<p class="kbVipAdmin_enter">
								<label>运单号:</label>
								<input type="text" value="" name="express_number" disabled="disabled" />
							</p>
							<div class="showExpressAddr">
								<p class="kbVipAdmin_enter">
									<label>运单号:</label>
									<input type="text" value="" name="express_number" />
								</p>
							</div>
						</article>
					</section>
					<div class="kbVipAdmin_operating">
						<div class="kbVipAdmin_restsubmit">
							<input  class="kbVipAdmin_button_005aff w80 h30 tc" type="reset" value="好的" />
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/OrderForm/visitorOrder'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	<script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/share.js?v=1.11"></script>
	<script>
			/* $(function(){
				
			        var start = {
			            format: 'YYYY-MM-DD hh:mm:ss',
			            minDate: $.nowDate(0), //设定最小日期为当前日期
			            festival:true,
			            //isinitVal:true,
			           // maxDate: $.nowDate(0), //最大日期
			            choosefun: function(elem,datas){
			                end.minDate = datas; //开始日选好后，重置结束日的最小日期
			                $('.filterData  input[name="start"]').val(Date.parse(new Date(datas)));
			            },
			            okfun:function(elem, val) {
			                // checkData(elem);
			            }
			        };
			       var end = {
			          format: 'YYYY-MM-DD hh:mm:ss',
			          minDate: $.nowDate(0), //设定最小日期为当前日期
			          festival:true,
			          //isinitVal:true,
			          //maxDate: '2099-06-16 23:59:59', //最大日期
			          choosefun: function(elem,datas){
			              start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
			               $('.filterData  input[name="end"]').val(Date.parse(new Date(datas)));
			          }
			      	};

			        $('.filterData  input').on('click',function(){
			        	var $this=$(this),
			        		status=$this.hasClass('start')?start:end;
			        		
					       $.jeDate($this,status);
			        })
				      
				 
			}) */
		  $(function(){
   			
	   		$('.kbVipAdmin_alert .kbVipAdmin_operating input[type="reset"]').on('click',function(){
	   			$('.kbVipAdmin_alert').fadeOut();
	   		});

	   		$('.shipGoods').on('click',function(){
	   			var id = $(this).attr('orderID');
	   			url = "<?php echo U('orderExpressUpdate');?>?id="+id;
	   			$('.shipGoods_alert form').attr('action', url);
	   			
	   			$('.shipGoods_alert:eq(0)').fadeIn();
            });

	   		$('.showExpress').on('click',function(){
	   			var data = {
	   				flag : 'selExpress',
	   				id:$(this).attr('orderID')
	   			}
	   			$.get("<?php echo U('ajaxControl');?>",data, function(res){
	   				if(res){
	   					$('.showExpressInfo article:eq(0) p').eq(0).text('收货人：'+res.address_id.consignee);
	   					$('.showExpressInfo article:eq(0) p').eq(1).text('收货人电话：'+res.address_id.phone);
	   					$('.showExpressInfo article:eq(0) p').eq(2).text('收货地址：'+ res.address_id.address_str);
	   					$('.showExpressInfo article:eq(1) p:eq(0) b').text(res.express.name);
	   					$('.showExpressInfo article:eq(1) .kbVipAdmin_enter input').val(res.express_number);
	   					var str = '';
	   					var info = res.express.Traces;
	   						console.log(info)
	   					for(var k in info){
	   						str += '<p class="kbVipAdmin_enter">'
	   							+'<label>'+ info[k].AcceptTime +'</label><br>'
	   							+ '<label>'+ info[k].AcceptStation +'</label></p>';
	   					}
	   					$('.showExpressInfo article:eq(1) .showExpressAddr').html(str);
	   				}
	   			})
	   			$('.showExpressInfo').fadeIn();
            });
         });
   	</script>

</body>
</html>