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





	
    
	<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?version=1.1"></link>
	<link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">
	<link rel="stylesheet" href="/Public/JS/module/contact/contact.css?v=1.2" type="text/css">
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
		.shipGoods_alert .kbShopAdmin_radio{vertical-align: top;}
		.shipGoods_alert  form{
			height:calc(100% - 260px);
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


<!-- 主内容 -->
	<div id="kbShopAdmin_rightCenter" class="OrderForm">
		<!-- 内容标题部 -->
		
		<div class="centerTitle">
			
			<div class="kbShopAdmin_operating filter-operating" >
				<form>
					<div class="filterData">
					<input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
					<input class="start" type="hidden" name="start" value="" />
					<input  class="end"  type="hidden" name="end" value="" />
					<button class="kbShopAdmin_opt w80 h30" type="submit">确定</button>
					</div>
				</form>

				<form >
				<span class="kbShopAdmin_enter"><input type="text" name="order_number" value="<?php echo I('get.order_number');?>" style="width: 200px" placeholder="请输入订单号进行搜索" ></span>
					<button class="kbShopAdmin_opt w80 h30" type="submit">确定</button>
				</form>
			</div>
	
		</div>
		<div class="kb_table-filter mb10">
			<nav class="hrefFlex">
				<a class="<?php echo ($_GET['status']?'':'selected'); ?>" href="<?php echo U('');?>">全部订单</a>
				<a class="<?php echo ($_GET['status'] == 1?'selected':''); ?>" href="<?php echo U('', ['status' => 1]);?>">待付款</a>
				<a class="<?php echo ($_GET['status'] == 2?'selected':''); ?>" href="<?php echo U('', ['status' => 2]);?>">
								<!-- <strong class="redInfoCount">99</strong> -->待发货
							</a>
				<a class="<?php echo ($_GET['status'] == 3?'selected':''); ?>" href="<?php echo U('', ['status' => 3]);?>">已发货</a>
				<a class="<?php echo ($_GET['status'] == 4?'selected':''); ?>" href="<?php echo U('', ['status' => 4]);?>">交易完成</a>
				<a class="<?php echo ($_GET['status'] == 5?'selected':''); ?>" href="<?php echo U('', ['status' => 5]);?>">售后/退款</a>
				<a class="<?php echo ($_GET['status'] == 6?'selected':''); ?>" href="<?php echo U('', ['status' => 6]);?>">退款已处理</a>
			</nav>
			<button class="choose kbShopAdmin_opt w80 h30 tc" type="button" onclick="javascript:window.location.href='?getExcel=1&status=<?php echo ($_GET["status"]); ?>&start=<?php echo ($_GET["start"]); ?>&end=<?php echo ($_GET["end"]); ?>'">下载</button>
		</div>
		<!-- 内容标题部结束 -->
		<!-- 内容表格部 -->
		<div class="main-contentBox kbShopAdmin_mt24" >
			
			<div class="kbShopAdmin_table mb20 orderTable">
				<table>
					<thead>
						<tr>
							<th width="5%">序号</th>
							<th width="30%">商品名称</th>
							<th >单价/数量</th>
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
							<td>
							<?php if(is_array($v["goods_data"])): $i = 0; $__LIST__ = $v["goods_data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><article>
									<p><?php echo ($vo["price"]); ?>&nbsp;X<?php echo ($vo["total"]); ?></p>
								</article><?php endforeach; endif; else: echo "" ;endif; ?>
							<td><p>￥<?php echo ($v["wechat_total"]); ?></p></td>
							
							<td>
								<p><?php echo ($v["address_id"]["consignee"]); ?> <?php echo ($v["address_id"]["phone"]); ?>  </p>
							</td>
							<?php switch($v["status"]): case "0": ?><td><p>待付款</p></td>
									<td>
										<div class="kbShopAdmin_tdAction"><?php break;?>
								<?php case "1": ?><td><p>用户取消订单</p></td>
									<td>
										<div class="kbShopAdmin_tdAction"><?php break;?>
								<?php case "2": switch($v["is_send_out"]): case "0": ?><td><p>已付款,待发货</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
												<p class="mb10">
													<input class="kbShopAdmin_opt  h30 tc shipGoods" title="家下就发货" orderID="<?php echo ($v["id"]); ?>" type="button" value="发货" />
												</p><?php break;?>
										<?php case "1": ?><td><p>待收货</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
													<p class="mb10">
													<!-- 	<input type="button" class="kbShopAdmin_opt_7facff	 h30" value="确定按钮用" onclick="eTip()"> -->
														<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
													</p><?php break;?>
										<?php case "2": ?><td><p>已收货</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
													<p class="mb10">
														<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
													</p><?php break; endswitch; break;?>
								<?php case "3": ?><td><p>关闭交易</p></td>
									<td>
										<div class="kbShopAdmin_tdAction"><?php break;?>
								<?php case "4": ?><td><p>已完成</p></td>
									<td>
										<div class="kbShopAdmin_tdAction">
											<p class="mb10">
												<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
											</p><?php break;?>
								<?php case "5": switch($v["is_send_out"]): case "0": ?><td><p>未发货,申请退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction"><?php break;?>
										<?php case "1": ?><td><p>已发货,申请退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
												<p class="mb10">
													<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
												</p><?php break;?>
										<?php case "2": ?><td><p>已收货,申请退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
												<p class="mb10">
													<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
												</p><?php break; endswitch; break;?>
								<?php case "6": switch($v["is_send_out"]): case "0": ?><td><p>未发货,已退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction"><?php break;?>
										<?php case "1": ?><td><p>已发货,已退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
												<p class="mb10">
													<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
												</p><?php break;?>
										<?php case "2": ?><td><p>已收货,已退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
												<p class="mb10">
													<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
												</p><?php break; endswitch; break;?>
								<?php case "7": switch($v["is_send_out"]): case "0": ?><td><p>未发货,拒绝退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction"><?php break;?>
										<?php case "1": ?><td><p>已发货,拒绝退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
												<p class="mb10">
													<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
												</p><?php break;?>
										<?php case "2": ?><td><p>已收货,拒绝退款</p></td>
											<td>
												<div class="kbShopAdmin_tdAction">
												<p class="mb10">
													<input class="kbShopAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
												</p><?php break; endswitch; break; endswitch;?>
									<p class="mb10">
									<a class="kbShopAdmin_button_eee " href="<?php echo U('orderInfo', ['id' => $v['id']]);?>">订单详情</a>
									</p>
								</div>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
			<div class="kbShopAdmin_page">
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
		<div  class="kbShopAdmin_alert shipGoods_alert " style="display:none">

			<div  class="kbShopAdmin_alertBox">
				<button type="button" class="kbShopAdmin_alert-close "></button>
				<h3 class="mb10">发货</h3>
				<article id="shipGoods_alert">
					<h4>买家收货信息</h4>
					<p>收货人：{{info.address_id.consignee}}</p>
					<p>收货地址：{{info.address_id.address_str}}</p>
					<p>联系电话：{{info.address_id.phone}}</p>
				</article>
				<hr/>
				<form action="" id="addrForm" method="post" enctype="multipart/form-data">
					<article>				
						<div id="letter" ></div>
						<div>
							<label>物流选择:</label>
							<p class="kbShopAdmin_radio express">
								<input type="radio" name="express_way" value="1" checked="checked"/>
								<label><b></b></label>
							</p>
							<span>快递</span>
							<p class="kbShopAdmin_radio ">
								<input type="radio" name="express_way" value="2" />
								<label>
									<b></b>
								</label>
							</p>
							<span>自提</span>
						</div>
						<div class="kbShopAdmin_enter">
							<label>快递公司:</label>
							<select class="kbShopAdmin_slt w100 h30" name="express_name">
								<?php if(is_array($express)): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["coding"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<button class="testExpress" type="button">快速选择</button>
							<div class="kbShopAdmin_sltExpress sort_box">
								<button class="close" type="button"></button>
								<?php if(is_array($express)): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="sort_list" data-val="<?php echo ($v["coding"]); ?>">
										<p class="num_name"><?php echo ($v["name"]); ?></p>
									</div><?php endforeach; endif; else: echo "" ;endif; ?>
								<div class="initials">
									<ul>
										<li><img src="/Public/images/068.png"></li>
									</ul>
								</div>
							</div>
						</div>
						<p class="kbShopAdmin_enter">
							<label>快递单号:</label>
							<input type="text" value="" name="express_number"  placeholder="请输入快递单号" />
						</p>
					</article>
					<div class="kbShopAdmin_operating">
						<div class="kbShopAdmin_restsubmit">
							<input  class="kbShopAdmin_button_eee w80 h30 tc" type="reset" value="取消" />
							<input  class="kbShopAdmin_opt_7facff w80 h30" type="submit" value="保存" />
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="kbShopAdmin_alert showExpressInfo ">
			<div class="kbShopAdmin_alertBox">
				<button type="button" class="kbShopAdmin_alert-close "></button>
					<h3 class="mb10">物流信息</h3>
				<section class="kbShopAdmin_alertCentent">
						<article>
							<h4>买家收货信息</h4>
							<p>收货人：</p>
							<p>收货人电话：</p>
							<p>收货人地址：</p>
							
						</article>
					<hr/>
						<article>
							<p>
								<label>快递公司:</label>
								<b>收货人：张大充 13729000000</b>
							</p>
							<p class="kbShopAdmin_enter">
								<label>运单号:</label>
								<input type="text" value="" name="express_number" disabled="disabled" />
							</p>
							<div class="showExpressAddr">
								
							</div>
						</article>
					</section>
					<div class="kbShopAdmin_operating">
						<div class="kbShopAdmin_restsubmit">
							<input  class="kbShopAdmin_button_eee w80 h30 tc" type="reset" value="好的" />
						</div>
					</div>
				
			</div>
		</div>

		

 <p class="tc mt20 f14">技术支持由<a href="http://gdkbvip168.gdallinone.com/Company/Index/index">广州旷邦科技有限责任公司提供</a></p>

	<script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="/Public/JS/module/datenew/js/share.js?v=1.11"></script>
	<script type="text/javascript" src="/Public/JS/module/contact/jquery.charfirst.pinyin.js?t=1"></script>
	<script type="text/javascript" src="/Public/JS/module/contact/contactSort.js?v=1.17"></script>
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

   		
	   		(function(){
	   			var app=new Vue({
	   				el:'#shipGoods_alert',
	   				data:{
	   					info:{},
	   					// blockControl:true
	   				}
	   			});

		   		$('.shipGoods').on('click',function(){
		   			var id = $(this).attr('orderID');
		   			url = "<?php echo U('orderExpressUpdate');?>?id="+id;
		   			$('.shipGoods_alert form').attr('action', url);
		   			$('.shipGoods_alert:eq(0)').fadeIn();

		   			$.get("<?php echo U('ajaxControl');?>",{
		   				flag:'orderInfo',
		   				id:id
		   			},function(res){
		   				console.log(res);
		   				app.info=res;
		   			})
		   			$('.kbShopAdmin_radio.express').parent().find('input').on('click',function(){
		   				var $this=$(this),
		   					status=$this.parent().hasClass('express');
		   				if(status){
		   					$this.parents('form').find('.kbShopAdmin_enter').fadeIn();

		   				}else{
		   					$this.parents('form').find('.kbShopAdmin_enter').fadeOut();
		   				}

		   			})

		   			$('.shipGoods_alert form').find('[type="submit"]').on('click',function(){
		   				if($('.shipGoods_alert form').find('.kbShopAdmin_enter').css('display')!="none"){
			   				var lengths=$('.shipGoods_alert form').find('[name="express_number"]').val().length;
			   				if(lengths>0){return true}else{Alert('请输入快递单号!');return false} ;
		   				}
		   			})

	            });
	            	$('.testExpress').on('click',function(){
		   				$('.kbShopAdmin_sltExpress').fadeIn();
		   				
		   				$('.kbShopAdmin_sltExpress .sort_list').on('click',function(){
		   					var $this=$(this),
		   						sltVal=$this.attr('data-val');
		   					$('.kbShopAdmin_slt').find('option[value="'+sltVal+'"]').attr('selected',true);
		   			
		   					$('.kbShopAdmin_sltExpress').fadeOut();
		   				})
		   				$('.kbShopAdmin_sltExpress .close').click(function(){$('.kbShopAdmin_sltExpress').fadeOut();})
		   			})
			   		$('.kbShopAdmin_alert .kbShopAdmin_operating input[type="reset"]').on('click',function(){
			   			$('.kbShopAdmin_alert').fadeOut();
			   		});
	   		})()

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
	   					$('.showExpressInfo article:eq(1) .kbShopAdmin_enter input').val(res.express_number);
	   					var str = '';
	   					var info = res.express.Traces;
	   						console.log(info)
	   					for(var k in info){
	   						str += '<p class="kbShopAdmin_enter">'
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/OrderForm/orderList/status/2.html';?>")
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