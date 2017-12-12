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
  .dl_addCard-main{
    width:50%;
    min-width:300px;
  }
  .dl_addCard-main .kb_cell::before{
    display:none;
  }
  .dl_addCard-main .kb_cell-bd:not(.no-border){
    border:1px solid #eee;
    text-indent:.5em;
    height:25px;
    line-height:25px;
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
    <h2>现金卡/添加</h2>
  </div>
  <div class="kbVipAdmin_operating">
  <section class="dl_addCard-main">
    <form id="dl_addCard-form" action="" method="post">
    <article class="kb_cell">
        <p class="kb_cell-hd">
            <label class="kb_label">现金卡金额</label>
        </p>
        <p class="kb_cell-bd pr10">
            <input type="number" name="money" placeholder="请输入金额" class="kb_input   w"  required="required"/>
        </p>
        <p class="kb_cell-ft ml10 ">
            元
        </p>
    </article>
    <article class="kb_cell">
        <p class="kb_cell-hd">
            <label class="kb_label">赠送金额</label>
        </p>
        <p class="kb_cell-bd pr10">
            <input type="number" name="presenter_money" placeholder="请输入金额" class="kb_input   w"  required="required"/>
        </p>
         <p class="kb_cell-ft ml10 ">
            元
        </p>
    </article>
    <article class="kb_cell">
        <p class="kb_cell-hd">
            <label class="kb_label">现金卡数量</label>
        </p>
        <p class="kb_cell-bd pr10">
            <input type="number" name="card_count" placeholder="请输入现金卡数量" class="kb_input   w" required="required" />
        </p>
         <p class="kb_cell-ft ml10 ">
            张
        </p>
    </article>
    <article class="kb_cell">
        <p class="kb_cell-hd ">
            <label class="kb_label">开始时间</label>
        </p>
        <p class="kb_cell-bd pr10">
            <input type="text"   placeholder="请输入开始时间" class="kb_input datainp mark-startTime  wicon  w" readonly required="required"/>
             <input type="hidden" name="start_time" />
        </p>
       
    </article>
    <article class="kb_cell">
        <p class="kb_cell-hd ">
            <label class="kb_label">结束时间</label>
        </p>
        <p class="kb_cell-bd pr10">
            <input type="text" placeholder="请输入结束时间" class="kb_input datainp wicon  mark-endTime w "  readonly required="required"/>
            <input type="hidden" name="end_time" />
        </p>
        
    </article>
    <article class="kb_cell">
        <p class="kb_cell-bd pr10 no-border tr">
            <button type="button" class="kb_btn kb_btn-main w100 mark-cardAddSub">生成</button>
        </p>
         <p class="kb_cell-ft ml10 ">
            <!-- <a href="javascript:;" class="kb_btn kb_btnPlain-main">下载序列表</a> -->
        </p>
    </article>
    <form>
  </section>
  </div>
 <!-- <div class="main-contentBox  kbVipAdmin_mt24" > -->
    <!-- <div class="kbVipAdmin_table">
      <table>
        <thead>
            <tr>
                <th>序号</th>
                <th>序列号</th>
                <th>卡号</th>
                <th>金额</th>
                <th>赠送金额</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>添加时间</th>
            </tr>
        </thead>
        <tbody>
          <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                <td><?php echo ($vo["card_id"]); ?></td>
                <td><?php echo ($vo["create_time"]); ?></td>
                <td><?php echo ($vo["money"]); ?></td>
                <td>赠送金额</td>
                <td><?php echo ($vo["start_time"]); ?></td>
                <td><?php echo ($vo["end_time"]); ?></td>
                <td><?php echo ($vo["card_total"]); ?></td>
                <td>已用</td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
  </div> -->
        <!-- 分页位置 -->
    <!-- <div class="kbVipAdmin_page">
        <div class="pageSize">
            <a class="prevPage"  href="javascript:;"></a>
            <p class="pageNum"><span>1</span><span>/</span><span>3</span></p>
            <a class="nextPage" href="javascript:;"></a>
        </div>
        <div class="pageJump">          
            <input class="w60  fl" type="text" value="" />
            <a class="fl" href="javascript:;">跳转</a>
        </div>
    </div> -->
    <!-- </div> -->
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/RechargeCard/cardAdd'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
<script>
  $(function(){
     var start = {
         format: 'YYYY-MM-DD hh:mm:ss',
         minDate: '2016-06-22 23:59:59', //设定最小日期为当前日期
         festival:true,
         //isinitVal:true,
        // maxDate: $.nowDate(0), //最大日期
         choosefun: function(elem,datas){
             end.minDate = datas; //开始日选好后，重置结束日的最小日期
            var startData=new Date(datas).getTime()/1000;
            $(elem).next().val(startData)
         },
         // okfun:function(elem, val) {
         //     checkData(elem);
         // }
     };
   var end = {
       format: 'YYYY-MM-DD hh:mm:ss',
       minDate: $.nowDate(0), //设定最小日期为当前日期
       festival:true,
       //isinitVal:true,
       //maxDate: '2099-06-16 23:59:59', //最大日期
       choosefun: function(elem,datas){
           start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
           var endData=new Date(datas).getTime()/1000;
           $(elem).next().val(endData)

       },
        okfun:function(elem, val) {
           checkData(elem);
       }
   };
   $('.mark-startTime').jeDate(start);
   $('.mark-endTime').jeDate(end);
 
  })
  $(function(){
     
  $('.mark-cardAddSub').on('click',function(){
    var $this,formData;
    $this=$(this);

    formData=new FormData($('#dl_addCard-form')[0]);
    $.ajax({
        type:'POST',
        url:"<?php echo U('RechargeCard/ajaxControl');?>?flag=cardAdd",
        data:formData,
        dataType:'json',
        enctype: 'multipart/form-data',
        async: false,  
        cache: false,  
        contentType: false,  
        processData: false,
        success:function(res){
          console.log(res);
          if(res){
             Confirm("操作成功！继续添加还是返回现金卡表格页面？","温馨提醒","返回","继续",function(result){
                if(result){
                  window.location.href="<?php echo U('RechargeCard/cardList',['module' => $_GET['module']]);?>"
                }
            })
          }
          // downloadExcelBefore(res);
        },
        error:function(xhr, errorType, error){
            console.log("xhr"+xhr);
            console.log("errorType"+errorType);
            console.log("error"+error);
        }
    })
    return false;
  });
  function downloadExcelBefore(id){
    $.ajax({
      type:"GET",
      url:"<?php echo U('RechargeCard/ajaxControl');?>",
      data:{flag:'downloadExcelBefore',card_id:id,used:1},
      dataType:'json',
      success:function(data){
        console.log(data);
      },
      error:function(error){
        console.log(error);
      }
    })
  }
 /*  添加成功后会返回id值
  Recharge/ajaxControl (获取添加成功后数据)
  flag: downloadExcelBefore
  id:添加成功后返回的id
  used: 1 (固定值1)
  返回数据:
  card_number: 卡号 
  serial_number: 序列号  
  money: 金额 
  presenter_money: 赠送金额
  status: (0: 默认, 1:启用)
  start_time: 充值卡使用开始时间戳  
  end_time: 充值卡使用结束时间戳   */
    
  })
</script>


</body>
</html>