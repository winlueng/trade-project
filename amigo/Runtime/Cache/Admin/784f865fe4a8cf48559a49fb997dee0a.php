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
.filter-searchDate input[type="search"]{
    width:254px;
}
</style>
<?php ?>

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
    <h2>现金卡/已使用情况</h2>
  </div>
   <div class="kbVipAdmin_operating filter-operating" >
    <form>
        <div class="filter-searchDate">
            <input type="search" name="order_number" value="" placeholder="请输入想要查找的内容">
            <button class="kbVipAdmin_opt w80 h30" type="submit">确定</button>
        </div>
    </form>
    <button class="choose kbVipAdmin_opt w80 h30 tc fr" type="button" onclick="javascript:window.location.href='?downloadExcel=1&card_id=<?php echo ($_GET["card_id"]); ?>&card_number=<?php echo ($_GET["card_number"]); ?>'">下载</button>
   </div>
   <div class="main-contentBox  kbVipAdmin_mt24" >
    <div class="kbVipAdmin_table">
      <table>
        <thead>
            <tr>
                <th>序号</th>
                <th>使用用户</th>
                <th>电话号码</th>
                <th>序列号</th>
                <th>卡号</th>
                <th>金额</th>
                <th>赠送金额</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>充值时间</th>
            </tr>
        </thead>
        <tbody>
          <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                <td><?php echo ($vo['id']); ?></td>
                <td><?php echo ($vo['nick_name']); ?></td>
                <td><?php echo ($vo['phone']); ?></td>
                <td><?php echo ($vo["card_number"]); ?></td>
                <td><?php echo ($vo["serial_number"]); ?></td>
                <td><?php echo ($vo["money"]); ?></td>
                <td><?php echo ($vo["presenter_money"]); ?></td>
                <td><?php echo date('Y-m-d', $vo['start_time']);?></td>
                <td><?php echo date('Y-m-d', $vo['end_time']);?></td>
                <td><?php echo date('Y-m-d H:i:s', $vo['used_time']);?></td>
                
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
            <input class="w60  fl" type="text" value="" />
            <a class="fl" href="javascript:;">跳转</a>
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/RechargeCard/used_card_info'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
<script>
$(function(){
    // 
    /* $('mark-cardActivation').on('click',function(){
        var $this,status,cardNum,flag,Url,params=new Object();
        $this=$(this);
        flag='changeCardStatus',
        Url="<?php echo U('RechargeCard/ajaxControl');?>";
        cardNum=$this.attr('data-cardNum').trim();
        status=$this.prop('checked')?1:0;
        params={
            flag:flag,
            status:status,
            card_number:cardNum
        }
        $.ajax({
            type:"GET",
            data:params,
            url:Url,
            dataType:'json',
            success:function(data){
                if(data==1){
                    sTip('操作成功');
                }else{
                   eTip('操作成功'); 
                   $this.prop('checked',status);
                }
            },
            error:function(error){
                console.log(error);
            }
        })
        
    }) */
})
</script>

</body>
</html>