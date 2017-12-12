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


	    
<!-- <link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?version=1.1"></link>
 -->
<style>
    .HealthStatus{
        display:none;
    }
</style>
<?php echo('<pre>'); var_dump($list);exit; ?>

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
	
    <div id="kbVipAdmin_rightCenter" class=" OrderForm mb10"><!-- 内容页开始 -->
            <div class="centerTitle">
                <h1>审核列表</h1>
            </div>
            <div class="kb_table-filter mb10">
                <!-- <form action="" method="get" style="display:inline-block">
                        <select class="kbVipAdmin_slt w100 h30" name="correlation_id" title="可选择分类查找相关商品">
                            <option value="">全部类型</option>
                            <?php if(is_array($typeList)): foreach($typeList as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                        <input type="submit" class="kbVipAdmin_opt  w80 h30" value="确认查找">
                </form> -->
                <div class="filter-searchDate mr10">
                    <form action="<?php echo U('VisitorInfo/visitorList');?>">
                        <input type="search" value="<?php echo I('sel_name');?>" name="sel_name" placeholder="请输入用户呢称" />
                        <input class="kbVipAdmin_opt w80 h30 fr" type="submit" value="确定" />
                    </form>
                </div>
            </div>
            <div class="main-contentBox kbVipAdmin_mt24" >
            <div class="kbVipAdmin_table mb20">
                
                <table>
                    <thead>
                        <tr>
                            <th width="50">编号</th>
                            <th>所属区域</th>
                            <th>所属行业</th>
                            <th>店铺名称</th>
                            <th>商品名称</th>
                            <th>操作时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                            <td><p><?php echo ($v["goods_id"]); ?></p></td>
                            <td><p><?php echo ($v["region"]); ?></p></td>
                            <td><p><?php echo ($v["business"]); ?></p></td>
                            <td><p><?php echo ($v["company_name"]); ?></p></td>
                            <td><p><?php echo ($v["goods_name"]); ?></p></td>
                            <td><p><?php echo date('Y-m-d H:i:s',$v['create_time']);?></p></td>
                            <td>
                              <p>
                                <?php switch($v["status"]): case "-1": ?>已删除<?php break;?>
                                  <?php case "0": ?>申请中<?php break;?>
                                  <?php case "1": ?>已同意<?php break;?>
                                  <?php case "2": ?>已拒绝<?php break; endswitch;?>
                              </p>
                            </td>
                            <td>
                                <div class="kbVipAdmin_tdAction">
                                    <a class=" kbVipAdminSea  w30 h30 copyButton-default" title="预览" href="<?php echo U('Goods/preview', ['id' => $v['goods_id']]);?>" target="view_window"> </a>
                                    <input class="icon-complete"  type="button"  value="" title="通过"
                                        v-on:click="complete($event,'<?php echo ($v['goods_id']); ?>')"
                                      />
                                    <input class=" icon-refuse " type="button"  value="" title="拒绝" 
                                      v-on:click="refuse($event,<?php echo ($v['goods_id']); ?>)"
                                     />
                                </div>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
                <!-- 表格页数开始 -->
                <div class="kbVipAdmin_page mb10">
                    <div class="pageSize">
                        <?php echo ($page); ?>
                       
                    </div>
                    <div class="pageJump">  
                    <?php if(count($list) == 10 ): ?><form >
                        <input class="w60  fl" type="text" name="p" placeholder="<?php echo I('get.p');?>" />
                        <input type="submit" class="fl" name="" value="跳转">
                    </form><?php endif; ?>   
                    </div>
                </div>
                <!-- 表格页数结束 -->
            <!-- 表格结束 -->
        </div>

        <div class="kbVipAdmin_alert recommend_alert">
            <div class="kbVipAdmin_alertBox">
                <button type="button" class="kbVipAdmin_alert-close "></button>
                <form id="recommendForm" action="" method="post" enctype="multipart/form-data">
                     <h3 class="mb10">置顶商品</h3>
                    <p class="kbVipAdmin_enter"><b><i>*</i>显示位置</b>
                        <select name="stick_classify" class="kbVipAdmin_slt kbVipAdmin_sltblack"
                         required="required"
                         data-datatype="select"
                         >
                            <option value="-1">请选择推荐位置</option>
                            <option value="1"> 折扣区</option>
                            <option value="2"> 热销区</option>
                            <option value="3">新品区</option>
                        </select>
                    </p>
                  <!--   <p class="kbVipAdmin_enter"><b><i>*</i>开始时间:</b>
                      <input  class="datainp wicon" id="kbVipAdmin_inpstart" type="text" name="start_time" placeholder="开始日期"   readonly required="required" />
                      </p> -->
                      <p class="kbVipAdmin_enter"><b><i>*</i>结束时间:</b>
                      <!-- <input type="date" name="end_time" value="" required="required" /> -->
                      <input  class="datainp wicon"  type="text" name="end_time" placeholder="结束日期"   readonly required="required"
                       data-datatype="input"
                       />
                      </p>
                    <div class="kbVipAdmin_operating ">
                        <div class="kbVipAdmin_restsubmit"> 
                            <input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                            <input  class="kbVipAdmin_opt w100 h40" type="button" value="保存" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="kbVipAdmin_alert refuse_alert">
            <div class="kbVipAdmin_alertBox">
                <button type="button" class="kbVipAdmin_alert-close "></button>
                <form id="recommendForm" action="" method="post" enctype="multipart/form-data">
                     <h3 class="mb10">拒绝</h3>

                      <p class="kbVipAdmin_enter">
                        <b><i>*</i>拒绝理由:</b>
                        <input  class="mark-refuse"  type="text" name="refuse_remark" placeholder="请输入拒绝理由"    required="required"
                          data-datatype="input"
                       />
                      </p>
                    <div class="kbVipAdmin_operating ">
                        <div class="kbVipAdmin_restsubmit"> 
                            <input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                            <input  class="kbVipAdmin_opt w100 h40" type="button" value="保存" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- 内容页结束 -->

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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/GoodsStick/auditList'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
<script type="text/javascript">
    $('.pageSize a:first-child').addClass('prevPage');
    $('.pageSize a:last-child').addClass('nextPage');
</script>
  <script>
    $(function(){
       var app=new Vue({
         el:'#kbVipAdmin_rightCenter',
         data:{

         },
         methods:{
            myTitle:vueMethods.myTitile,
            complete:function(event,id){
              var $this, stick_classify,end_time,checkData,url,getData=new Object();
              $('.recommend_alert').fadeIn();
              $this=$(event.srcElement)?$(event.srcElement):$(event.target);
              checkData=new CheckData('.recommend_alert');
              getData={
                goods_id:id,
                status:1,
                 flag:"passOrRefuse",
              };
              url="<?php echo U('GoodsStick/ajaxControl');?>";
              $('.recommend_alert .kbVipAdmin_restsubmit .kbVipAdmin_opt').on('click',function(){
                 if(!checkData.verify()) return false;
                 getData.stick_classify=$('.recommend_alert select').val();
                 
                 $.ajax({
                    type:"GET",
                    url:url,
                    data:getData,
                    dataType:"json",
                    success:function(data){
                        console.log(data);
                        if(data.status){
                            sTip('操作成功');
                           $this.parents('tr').remove();
                        }else{
                            eTip('操作失败')
                        }
                         $('.recommend_alert').fadeOut();
                    },
                    error:function(error){
                        console.log(error);
                        eTip('操作失败')
                    }
                 })
              })
            },
            refuse:function(event,id){
              var $this,getData,url,refuseRemark,checkData;
              $('.refuse_alert').fadeIn();
              $this=$(event.srcElement)?$(event.srcElement):$(event.target);
              checkData=new CheckData('.refuse_alert');
              getData={
                goods_id:id,
                status:2,
                flag:"passOrRefuse",
              };
              url="<?php echo U('GoodsStick/ajaxControl');?>";
              $('.refuse_alert .kbVipAdmin_restsubmit .kbVipAdmin_opt').on('click',function(){
                 if(!checkData.verify()) return false;
                 getData.refuse_remark=$('.recommend_alert .mark-refuse').val();
                 $.ajax({
                    type:"GET",
                    url:url,
                    data:getData,
                    dataType:"json",
                    success:function(data){
                        console.log(data);
                        if(data.status){
                            sTip('操作成功');
                           $this.parents('tr').remove();
                            
                        }else{
                            eTip('操作失败')
                        }
                        $('.refuse_alert').fadeOut();
                    },
                    error:function(error){
                        console.log(error);
                        eTip('操作失败')
                    }
                 })
              })
            }
         },
         mounted:function(){
            this.myTitle();
            (function(){
               var now=new Date(),
                   nowTime=now.getFullYear()+'-'+(now.getMonth()+1)+"-"+now.getDate()+" 00:00:00";
                   console.log(nowTime);
               var start = {
                   format: 'YYYY-MM-DD hh:mm:ss',
                   minDate: $.nowDate(-1), //设定最小日期为当前日期
                   festival:true,
                   //isinitVal:true,
                  // maxDate: $.nowDate(0), //最大日期
                   choosefun: function(elem,datas){
                       end.minDate = datas; //开始日选好后，重置结束日的最小日期
                   },
               };
                 var end = {
                     format: 'YYYY-MM-DD hh:mm:ss',
                     minDate: $.nowDate(0), //设定最小日期为当前日期
                     festival:true,
                     //isinitVal:true,
                     //maxDate: '2099-06-16 23:59:59', //最大日期
                     choosefun: function(elem,datas){
                         start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
                     },
                 };
                 $('.kbVipAdmin_enter input[name="start_time"]').jeDate(start);
                 $('.kbVipAdmin_enter input[name="end_time"]').jeDate(end);
             })();
             $('.kbVipAdmin_alert .kbVipAdmin_alert-close,.kbVipAdmin_alert .kbVipAdmin_restsubmit input[type=reset]').on('click',function(){
                 $('.kbVipAdmin_alert').fadeOut();
             })
         }
       });
    })
  </script>

</body>
</html>