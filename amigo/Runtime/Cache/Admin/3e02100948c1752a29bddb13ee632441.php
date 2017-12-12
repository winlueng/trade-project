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

.dl_cell{
    display:flex;
    display:-webkit-flex;
   
    align-items:center;
    -webkit-align-items:center;
}
.dl_cell-bd{
    flex-grow:1;
    -webkit-flex-grow:1;
}
.dl_cell-hd{
    min-width:100px;
}
.dl_input{
    border:1px solid #ddd;
    text-indent:10px;
    min-height:26px;
    
}

.dl_label{
    min-width:60px;
    display:inline-block;
}
.dl_ft-defalute{
    color:#a7a7a7;
}
.dl_cellWrap{
    flex-wrap:wrap;
    -webkit-flex-wrap:wrap;
}
.dl_oneRow .dl_input:not(.ui-datepicker-time){
    width:100px;
}
.filterData{
    width: 240px;
}
.dl_btn{
    border:1px solid transparent;
    color:#3c74de;
    background-color:transparent;
    outline:0;
}
.dl_btn:active{
    opacity:.5;
}
.dl_input[readonly]:not(.ui-datepicker-time),.ui-datepicker-time:disabled{
    border-color:transparent;
    /*background-color:;*/
}
.reginReward .dl_cell-bd{
   max-width: 200px;
}

.filterData .ui-datepicker-time:disabled{
  background-image:none;
}
.filterData{
  position:relative;
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
	
  <div id="kbVipAdmin_rightCenter" class="spAnIndex ">
    <div class="centerTitle">
      <h2>充值设置</h2>
    </div>

    <div class="dl_rechargeMain ">
      <!-- <article class="dl_cell reginReward">
        <p class="dl_cell-hd">
          <label class="dl_label">注册福利：</label>
        </p>
        <p class="dl_cell-bd">
            <input type="number" value="" class="dl_input" />
            <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <p class="dl_cell-ft">
            <button type="button" class="dl_btn">保存</button>
            
        </p>
        
      </article> -->
      <h1 class="f14 mb10 mt10 fb">优惠首充</h1>
    
      <article class="dl_cell dl_oneRow mb10">
        <input type="hidden" name="is_first_recharge" value="1" />
        <p class="dl_cell-bd">
          <label class="dl_label">充值：</label>
          <input type="number" value="" name="recharge_price" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <p class="dl_cell-bd">
          <label>赠送：</label>
          <input type="number" value="" name="present_price" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <div class="dl_cell-bd">
          <label class="">日期：</label>
          <div class="filterData">
            
            <input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
            <input class="start" type="hidden" name="start_time" value="" />
            <input  class="end"  type="hidden" name="end_time" value="" />
          </div>
          <button type="button" class="dl_btn mark-oneRowAdd">增加</button>
          <button type="reset" class="dl_btn">取消</button>
        </div>
      </article>
      <?php if(is_array($first_recharge)): foreach($first_recharge as $key=>$v): ?><article class="dl_cell dl_oneRow mb10 isAdd  ">
        <input type="hidden" name="is_first_recharge" value="1" />
        <p class="dl_cell-bd">
          <label class="dl_label">充值金额：</label>
          <input type="number" value="<?php echo ($v['recharge_price']); ?>" name="recharge_price" readonly="readonly" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <p class="dl_cell-bd">
          <label>赠送金额：</label>
          <input type="number" value="<?php echo ($v['present_price']); ?>" name="present_price" readonly="readonly" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <div class="dl_cell-bd">
          <label class="">日期：</label>
          <div class="filterData">
             <input type="text" value="<?php echo date('Y-m-d H:i:s', $v['start_time']);?> - <?php echo date('Y-m-d H:i:s', $v['end_time']);?>" disabled="disabled"
            class="kb_input w"
             />
            <input type="text" class="ui-datepicker-time dl_input hide" readonly="readonly"  value="" />
            <input class="start" type="hidden" name="start_time" value=" <?php echo ($v['start_time']); ?>" />
            <input  class="end"  type="hidden" name="end_time" value="<?php echo ($v['end_time']); ?>" />
          </div>
          <button type="button" class="dl_btn mark-rachargeUpdate" data-id="<?php echo ($v['id']); ?>">编辑</button>
          <button type="button" class="dl_btn mark-delrecharge"  data-id="<?php echo ($v['id']); ?>">删除</button>
        </div>

      </article><?php endforeach; endif; ?>
      <h1 class="f14 mb10 mt10 fb">普通优惠</h1>
      <article class="dl_cell dl_oneRow mb10">
        <p class="dl_cell-bd">
          <label class="dl_label">充值：</label>
          <input type="number" value="" name="recharge_price" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <p class="dl_cell-bd">
          <label>赠送：</label>
          <input type="number" value="present_price" name="present_price" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <div class="dl_cell-bd">
          <label class="">日期：</label>
          <div class="filterData">
            <input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
            <input class="start" type="hidden" name="start_time" value="" />
            <input  class="end"  type="hidden" name="end_time" value="" />
          </div>
          <button type="button" class="dl_btn mark-defaultRechange">增加</button>
          <button type="button" class="dl_btn">取消</button>
        </div>
      </article>
      <?php if(is_array($other_recharge)): foreach($other_recharge as $key=>$v): ?><article class="dl_cell dl_oneRow mb10 isAdd  ">
        <p class="dl_cell-bd">
          <label class="dl_label">充值：</label>
          <input type="number" value="<?php echo ($v['recharge_price']); ?>" name="recharge_price" readonly="readonly" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <p class="dl_cell-bd">
          <label>赠送：</label>
          <input type="number" value="<?php echo ($v['present_price']); ?>" name="present_price" readonly="readonly" class="dl_input" />
          <em class="ml10 dl_ft-defalute">元</em>
        </p>
        <div class="dl_cell-bd">
          <label class="">日期：</label>
          <div class="filterData">
            <input type="text" value="<?php echo date('Y-m-d H:i:s', $v['start_time']);?> - <?php echo date('Y-m-d H:i:s', $v['end_time']);?>" disabled="disabled"
            class="kb_input w"
             />

            <input type="text" class="ui-datepicker-time dl_input hide" readonly="readonly"  value="" />
            <input class="start" type="hidden" name="start_time" value="<?php echo ($v['start_time']); ?>" />
            <input  class="end"  type="hidden" name="end_time" value="<?php echo ($v['end_time']); ?>" />
          </div>
          <button type="button" class="dl_btn mark-rachargeUpdate" data-id="<?php echo ($v['id']); ?>">编辑</button>
          <button type="button" class="dl_btn mark-delrecharge" data-id="<?php echo ($v['id']); ?>">删除</button>
        </div>
      </article><?php endforeach; endif; ?>
    </div>
   <div class="kbVipAdmin_operating tc mt50">
        <input  class="w200 h40 f16 kbVipAdmin_opt bc" type="button" value="返回" onclick="window.history.go(-1)" />
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/RechargeSetting/rechargeSetting'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
<div class="ui-datepicker-css">  
   <div class="ui-datepicker-quick">
       <p>快捷日期<a class="ui-close-date">X</a></p>
       <div>
           <input class="ui-date-quick-button" type="button" value="今天" alt="0"  name=""/>
           <input class="ui-date-quick-button" type="button" value="昨天" alt="1" name=""/>
           <input class="ui-date-quick-button" type="button" value="7天内" alt="6" name=""/>
           <input class="ui-date-quick-button" type="button" value="14天内" alt="13" name=""/>
           <input class="ui-date-quick-button" type="button" value="30天内" alt="29" name=""/>
           <input class="ui-date-quick-button" type="button" value="60天内" alt="59" name=""/>
       </div>
   </div>
   <div class="ui-datepicker-choose">
         <p>自选日期</p>
         <div class="ui-datepicker-date">
             <input name="start" id="startDate" class="startDate" readonly value="2014/12/20" type="text">
            -
             <input name="start" id="endDate" class="endDate" readonly  value="2014/12/20" type="text" disabled onChange="datePickers()">
         
         </div>
     </div>

 </div>
 <script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>
 <script type="text/javascript" src="/Public/JS/module/datenew/js/shareing.js?v=1.11"></script>

 <script>
  $(function(){
    $('.mark-oneRowAdd,.mark-defaultRechange').on('click',function(){
       var $this,formData,parents,i;
       formData=new FormData();
       $this=$(this);
       parents=$this.parents('.dl_oneRow').find("[name]");
      for(i in parents){
          if(parents.eq(i).length==0) continue;
          if(parents.eq(i).val().trim().length>0){
            formData.append(parents.eq(i).attr('name'),parents.eq(i).val());
          }else{
            if(parents.eq(i).attr('type')=="hidden"){
              Alert("请选择开始时间和结束时间");
            }else{
              Alert('充值金额或赠送金额未输入');
            }
            return false;
          }
      }
      
       $.ajax({
           type:'POST',
           url:"<?php echo U('RechargeSetting/ajaxControl');?>?flag=settingIns",
           data:formData,
           dataType:'json',
           enctype: 'multipart/form-data',
           async: false,  
           cache: false,  
           contentType: false,  
           processData: false,
           success:function(res){
              if(res.status){
                sTip("操作成功")
              }else{
                Alert(res.err_msg);
              }

           },
           error:function(xhr, errorType, error){
               console.log("xhr"+xhr);
               console.log("errorType"+errorType);
               console.log("error"+error);
           }
       })
    })
    $('.mark-rachargeUpdate').on('click',function(){
       var $this,formData,parents,id,status,inputname;
       formData=new FormData();
       $this=$(this);
       parents=$this.parents('.dl_oneRow');
       id=$this.attr('data-id').trim();
       status=$this.text()=="编辑"?true:false;
       console.log(status)
       if(status){

         parents.find(".dl_input").removeAttr('disabled');
         parents.find(".dl_input").not('.ui-datepicker-time').removeAttr('readonly');
         parents.find('.ui-datepicker-time').removeClass('hide').prev().hide();
         $this.text("完成");
       }else{
          inputname=parents.find("[name]");
          inputname.each(function(indexs,elem){
            if($(elem).val().trim().length>0){
              formData.append($(elem).attr('name'),$(elem).val());
            }else{
              if($(elem).attr('type')=="hidden"){
                Alert("请选择开始时间和结束时间");
              }else{
                Alert('充值金额或赠送金额未输入');
              }
              return false;
            }

          })
          $.ajax({
              type:'POST',
              url:"<?php echo U('RechargeSetting/ajaxControl');?>?flag=settingUpdate&id="+id,
              data:formData,
              dataType:'json',
              enctype: 'multipart/form-data',
              async: false,  
              cache: false,  
              contentType: false,  
              processData: false,
              success:function(res){
                
                if(res.status){
                  sTip("操作成功")
                  $this.text("编辑");

                }else{
                  Alert(res.err_msg);
                }

              },
              error:function(xhr, errorType, error){
                  console.log("xhr"+xhr);
                  console.log("errorType"+errorType);
                  console.log("error"+error);
              }
          })
       }
    });
    $('.mark-delrecharge').on('click',function(){
      var $this,id;
      $this=$(this);
      id=$this.attr('data-id');
      $.ajax({
        type:"GET",
        url:"<?php echo U('RechargeSetting/ajaxControl');?>",
        data:{id:id,flag:'settingDel'},
        dataType:'json',
        succcess:function(data){
          console.log(data);
          if (data.status == 'true') {
            sTip("操作成功");
            window.location.reload();
            
          }
        },
        error:function(error){
          console.log(error)
        }
      })
    })
  })
   
 </script>

</body>
</html>