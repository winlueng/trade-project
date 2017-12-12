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


	
   <!--  <link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?version=1.1"></link> -->
    <link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">
    <link rel="stylesheet" href="/Public/JS/module/contact/contact.css?v=1.2" type="text/css">
    <style>
        .filter-operating{

        }
        .filter-operating form{
            display:inline-block;
            vertical-align:top;
        }
    /*  .filterData input{
            width:130px;
        }*/
        .filterData{
            display:inline-block;
            width:340px;
        }
        .shipGoods_alert .kbVipAdmin_radio{vertical-align: top;}
        .shipGoods_alert  form{
            height:calc(100% - 260px);
        }
        .OrderForm  .main-contentBox{
            height: calc(100% - 250px);
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
                <span class="kbVipAdmin_enter"><input type="text" name="order_number" value="<?php echo I('get.order_number');?>" style="width: 200px" placeholder="请输入订单号进行搜索" ></span>
                    <button class="kbVipAdmin_opt w80 h30" type="submit">确定</button>
                </form>
                <form class="mr10 ml10" action="" method="get">
                    <div class="userAreaSlt mb10">
                    <label>
                        区域选择
                    </label>
                    <select class="kbVipAdmin_slt     w100 h30" name="region" title="区域" >
                        <option value="-1">选择区域</option>
                        <?php if(is_array($region)): foreach($region as $key=>$v): ?><option value="<?php echo ($v['id']); ?>" >
                               <?php echo ($v['region_name']); ?>
                            </option><?php endforeach; endif; ?>
                    </select>
                    </div>
                    <div class="userTradeSlt mb10">
                    <label>行业选择</label>
                    <select class="kbVipAdmin_slt     w200 h30" name="region" title="区域" onchange="selCompanyList(this)">
                       <option value="-1">选择行业</option>
                    </select>
                    </div>
                    <button class="kbVipAdmin_opt w80 h30" >确定</button>
                </form>
            </div>
        </div>
        <div class="kb_table-filter mb10">
            <nav class="hrefFlex">
                <a class="<?php echo ($_GET['status'] == 0?'selected':''); ?>" href="<?php echo U('', ['status' => 0,'module' => $_GET['module']]);?>">全部订单</a>
                <a class="<?php echo ($_GET['status'] == 1?'selected':''); ?>" href="<?php echo U('', ['status' => 1, 'module' => $_GET['module']]);?>">待付款</a>
                <a class="<?php echo ($_GET['status'] == 2?'selected':''); ?>" href="<?php echo U('', ['status' => 2, 'module' => $_GET['module']]);?>">
                                <!-- <strong class="redInfoCount">99</strong> -->待发货
                            </a>
                <a class="<?php echo ($_GET['status'] == 3?'selected':''); ?>" href="<?php echo U('', ['status' => 3, 'module' => $_GET['module']]);?>">已发货</a>
                <a class="<?php echo ($_GET['status'] == 4?'selected':''); ?>" href="<?php echo U('', ['status' => 4, 'module' => $_GET['module']]);?>">交易完成</a>
                <a class="<?php echo ($_GET['status'] == 5?'selected':''); ?>" href="<?php echo U('', ['status' => 5, 'module' => $_GET['module']]);?>">售后/退款</a>
                <a class="<?php echo ($_GET['status'] == 6?'selected':''); ?>" href="<?php echo U('', ['status' => 6, 'module' => $_GET['module']]);?>">退款已处理</a>
            </nav>
            <button class="choose kbVipAdmin_opt w80 h30 tc" type="button" onclick="javascript:window.location.href='?getExcel=1&status=<?php echo ($_GET["status"]); ?>&start=<?php echo ($_GET["start"]); ?>&end=<?php echo ($_GET["end"]); ?>'">下载</button>
        </div>
        <!-- 内容标题部结束 -->
        <!-- 内容表格部 -->
        <div class="main-contentBox kbVipAdmin_mt24" >
            
            <div class="kbVipAdmin_table mb20 orderTable">
                <table>
                    <thead>
                        <tr>
                            <th width="5%">序号</th>
                            <th >订单所属店铺</th>
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
                            <td ><p><?php echo ($v["company_name"]); ?></p></td>
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
                                                <div class="kbVipAdmin_tdAction"><?php break;?>
                                        <?php case "1": ?><td><p>待收货</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                    <p class="mb10">
                                                    <!--    <input type="button" class="kbVipAdmin_opt_7facff   h30" value="确定按钮用" onclick="eTip()"> -->
                                                        <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                    </p><?php break;?>
                                        <?php case "2": ?><td><p>已收货</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                    <p class="mb10">
                                                        <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                    </p><?php break; endswitch; break;?>
                                <?php case "3": ?><td><p>关闭交易</p></td>
                                    <td>
                                        <div class="kbVipAdmin_tdAction"><?php break;?>
                                <?php case "4": ?><td><p>已完成</p></td>
                                    <td>
                                        <div class="kbVipAdmin_tdAction">
                                            <p class="mb10">
                                                <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                            </p><?php break;?>
                                <?php case "5": switch($v["is_send_out"]): case "0": ?><td><p>未发货,申请退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction"><?php break;?>
                                        <?php case "1": ?><td><p>已发货,申请退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                <p class="mb10">
                                                    <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                </p><?php break;?>
                                        <?php case "2": ?><td><p>已收货,申请退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                <p class="mb10">
                                                    <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                </p><?php break; endswitch; break;?>
                                <?php case "6": switch($v["is_send_out"]): case "0": ?><td><p>未发货,已退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction"><?php break;?>
                                        <?php case "1": ?><td><p>已发货,已退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                <p class="mb10">
                                                    <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                </p><?php break;?>
                                        <?php case "2": ?><td><p>已收货,已退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                <p class="mb10">
                                                    <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                </p><?php break; endswitch; break;?>
                                <?php case "7": switch($v["is_send_out"]): case "0": ?><td><p>未发货,拒绝退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction"><?php break;?>
                                        <?php case "1": ?><td><p>已发货,拒绝退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                <p class="mb10">
                                                    <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                </p><?php break;?>
                                        <?php case "2": ?><td><p>已收货,拒绝退款</p></td>
                                            <td>
                                                <div class="kbVipAdmin_tdAction">
                                                <p class="mb10">
                                                    <input class="kbVipAdmin_opt  h30 tc showExpress" title="睇下去到边" orderID="<?php echo ($v["id"]); ?>" type="button" value="物流信息" />
                                                </p><?php break; endswitch; break; endswitch;?>
                                    <p class="mb10">
                                    <a class="kbVipAdmin_button_eee " href="<?php echo U('OrderForm/companyOrderDetailByProject', ['id' => $v['id'],'module' => $_GET['module']]);?>">订单详情</a>
                                    </p>
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
        <div  class="kbVipAdmin_alert shipGoods_alert " style="display:none">

            <div  class="kbVipAdmin_alertBox">
                <button type="button" class="kbVipAdmin_alert-close "></button>
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
                            <p class="kbVipAdmin_radio express">
                                <input type="radio" name="a" value="" checked="checked"/>
                                <label><b></b></label>
                            </p>
                            <span>快递</span>
                            <p class="kbVipAdmin_radio ">
                                <input type="radio" name="a" value="" />
                                <label>
                                    <b></b>
                                </label>
                            </p>
                            <span>自提</span>
                        </div>
                        <div class="kbVipAdmin_enter">
                            <label>快递公司:</label>
                            <select class="kbVipAdmin_slt w100 h30" name="express_name">
                                <?php if(is_array($express)): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["coding"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <button class="testExpress" type="button">快速选择</button>
                            <div class="kbVipAdmin_sltExpress sort_box">
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
                        <p class="kbVipAdmin_enter">
                            <label>快递单号:</label>
                            <input type="text" value="" name="express_number"  placeholder="请输入快递单号" />
                        </p>
                    </article>
                    <div class="kbVipAdmin_operating">
                        <div class="kbVipAdmin_restsubmit">
                            <input  class="kbVipAdmin_button_eee w80 h30 tc" type="reset" value="取消" />
                            <input  class="kbVipAdmin_opt_7facff w80 h30" type="submit" value="保存" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="kbVipAdmin_alert showExpressInfo ">
            <div class="kbVipAdmin_alertBox">
                <button type="button" class="kbVipAdmin_alert-close "></button>
                    <h3 class="mb10">物流信息</h3>
                <section class="kbVipAdmin_alertCentent">
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
                            <p class="kbVipAdmin_enter">
                                <label>运单号:</label>
                                <input type="text" value="" name="express_number" disabled="disabled" />
                            </p>
                            <div class="showExpressAddr">
                                
                            </div>
                        </article>
                    </section>
                    <div class="kbVipAdmin_operating">
                        <div class="kbVipAdmin_restsubmit">
                            <input  class="kbVipAdmin_button_eee w80 h30 tc" type="reset" value="好的" />
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/OrderForm/companyOrderList'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
    <script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
    <script type="text/javascript" src="/Public/JS/module/datenew/js/share.js?v=1.11"></script>
    <script type="text/javascript" src="/Public/JS/module/contact/jquery.charfirst.pinyin.js?t=1"></script>
    <script type="text/javascript" src="/Public/JS/module/contact/contactSort.js?v=1.17"></script>
<script>
  $(function(){

    (function(){
         var app=new Vue({
            el:'#shipGoods_alert',
            data:{
                info:{
                    address_id:{}
                }
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
                app.info.address_id=res.address_id;
            })
            $('.kbVipAdmin_radio.express').parent().find('input').on('click',function(){
                var $this=$(this),
                    status=$this.parent().hasClass('express');
                if(status){
                    $this.parents('form').find('.kbVipAdmin_enter').fadeIn();

                }else{
                    $this.parents('form').find('.kbVipAdmin_enter').fadeOut();
                }

            })

            $('.shipGoods_alert form').find('[type="submit"]').on('click',function(){
                if($('.shipGoods_alert form').find('.kbVipAdmin_enter').css('display')!="none"){
                    var lengths=$('.shipGoods_alert form').find('[name="express_number"]').val().length;
                    if(lengths>0){return true}else{Alert('请输入快递单号!');return false} ;
                }
            })

        });
            $('.testExpress').on('click',function(){
                $('.kbVipAdmin_sltExpress').fadeIn();
                
                $('.kbVipAdmin_sltExpress .sort_list').on('click',function(){
                    var $this=$(this),
                        sltVal=$this.attr('data-val');
                    $('.kbVipAdmin_slt').find('option[value="'+sltVal+'"]').attr('selected',true);
            
                    $('.kbVipAdmin_sltExpress').fadeOut();
                })
                $('.kbVipAdmin_sltExpress .close').click(function(){$('.kbVipAdmin_sltExpress').fadeOut();})
            })
            $('.kbVipAdmin_alert .kbVipAdmin_operating input[type="reset"]').on('click',function(){
                $('.kbVipAdmin_alert').fadeOut();
             });
    })();

    $('.showExpress').on('click',function(){
        var data = {
            flag : 'selExpress',
            id:$(this).attr('orderID')
        }
        $.get("<?php echo U('ajaxControl');?>",data, function(res){
            // console.log(res);
            if(res){
                $('.showExpressInfo article:eq(0) p').eq(0).text('收货人：'+res.info.address_id.consignee);
                $('.showExpressInfo article:eq(0) p').eq(1).text('收货人电话：'+res.info.address_id.phone);
                $('.showExpressInfo article:eq(0) p').eq(2).text('收货地址：'+ res.info.address_id.address_str);
                $('.showExpressInfo article:eq(1) p:eq(0) b').text(res.info.express.name);
                $('.showExpressInfo article:eq(1) .kbVipAdmin_enter input').val(res.info.express.express_number);
                var str = '';
                var info = res.info.express.Traces;
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
     $('.userAreaSlt select').on('change',function(){
        var $this = $(this);
        var options=$this.children('option:selected');
        var optionsVal=options.val();
        var ajaxUrl='<?php echo U("Goods/ajaxControl");?>';
        $('select[name=business_id]').children().not('option[value=-1]').remove();//区域选择有变动时，清除行业选择内容
         userAreaSltChild(this,ajaxUrl);
      
    });/*userAreaSlt select end */
});
 

</script>

</body>
</html>