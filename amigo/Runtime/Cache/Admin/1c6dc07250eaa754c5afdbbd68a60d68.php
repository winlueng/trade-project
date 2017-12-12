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
	

	<div id="kbVipAdmin_rightCenter" class="spAnProductList OrderForm">
	<?php  ?>
		<div class="centerTitle">
			<h1>商品列表</h1>
		</div>
		<div class="kbVipAdmin_operating filter-operating" >
			<form class="mr10" action="<?php echo U('goodsListByProject',['module' => $_GET['module']]);?>" method="get">
				<select class="kbVipAdmin_slt w200 h30" name="classify_id" title="可选择分类查找相关商品" >
					<option value="">所有分类</option>
					<?php if(is_array($classify)): foreach($classify as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id']==$_GET['classify_id']?'selected':''); ?> >
							<?php echo ($v['classify_name']); ?>
						</option><?php endforeach; endif; ?>
				</select>
				<button class="kbVipAdmin_opt w80 h30" >确定</button>
			</form>
			<form>
				<div class="filter-searchDate mr10">
						<input type="search" name="order_number" value="" placeholder="请输入想要查找的内容">
						<input class="kbVipAdmin_opt w80 h30 fr" type="submit" value="确定">
				</div>
				
			</form>
		</div>
		<div class="main-contentBox kbVipAdmin_mt24" >
			<div class="kbVipAdmin_table">
				<table>
					<thead>
						<tr>
							<th width="50">序号</th>
							<th>产品名称</th>
							<th width="100">价格</th>
							<th width="200">图片</th>
							<th>分类</th>
							<th>浏览量</th>
							<th>添加时间</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(empty($list)): ?><tr ><td colspan="8"><span style="color:#F209CA;font-size:20px">暂无产品数据</span></td></tr>
					<?php else: ?>
					<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
							<td><?php echo ($v["id"]); ?></td>
							<td><?php echo ($v["goods_name"]); ?></td>
							<td>￥<?php echo ($v["price"]); ?></td>
							<td class="kbVipAdmin_tdImg" width="200">
								<div>
								<img src="/Public/<?php echo ($v['goods_logo']); ?>" height="200" alt="商品图片" />
								</div>
							</td>
							<td><?php echo ($v["classify_name"]); ?></td>
							<td><?php echo ($v['click_total']?$v['click_total']:0); ?></td>
							<td><?php echo date('Y年m月d日', $v['addtime']);?></td>
							<td>
								<div>
									<p class="kbVipAdmin_checkbox kbVipAdmin_checkboxTop">
									<?php if($v['stick_classify']): ?><input  type="checkbox" name="status<?php echo ($v["id"]); ?>" checked data-goodsid="<?php echo ($v["id"]); ?>" />
										<label class="font_6ccac9">
											<b class="kbVipAdmin_buttonMr"></b>
											<?php switch($v["stick_classify"]): case "1": ?>折扣区<?php break;?>
												<?php case "2": ?>热销区<?php break;?>
												<?php case "3": ?>新品区<?php break; endswitch;?>
										</label>
									<?php else: ?>
										<input  type="checkbox" name="status<?php echo ($v["id"]); ?>" data-goodsid="<?php echo ($v["id"]); ?>" />
										<label class="font_6ccac9">
											<b class="kbVipAdmin_buttonMr"></b>
											置顶
										</label><?php endif; ?>
									</p>
									<p class="kbVipAdmin_checkbox kbVipAdmin_checkboxdisabled">
										<input type="checkbox"  name="status<?php echo ($v["id"]); ?>" <?php echo ($v['status'] == '3'?'checked':''); ?> />
										<label class="font_ff6c60">
											<b class="kbVipAdmin_buttonMr">
											</b>
											下架
										</label>
									</p>
									<!-- <p class="kbVipAdmin_checkbox kbVipAdmin_checkboxNew">
										<input type="checkbox"  name="status<?php echo ($v["id"]); ?>"  />
										<label class="font_ff6c60">
											<b class="kbVipAdmin_buttonMr">
											</b>
											新品
										</label>
									</p> -->
								</div>
							</td>
							<td class="kbVipAdmin_tdAction">
								
								<a href="<?php echo U('preview', ['id' => $v['id']]);?>" class="kbVipAdminSea w30 h20 copyButton-default" target="view_window" title="预览"></a>
								<a href="<?php echo U('goodsUpdateByProject', ['id' => $v['id'], 'module' => 2]);?>" class="font_57c8f2   kbVipAdminEdit choose w30 h20" title="编辑"></a>

								<input class="font_ff6c60 kbVipAdminDel" type="button" value="" title="删除" />
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody><?php endif; ?>
				</table>
			</div>
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
	<div class="kbVipAdmin_alert recommend_alert">
		<div class="kbVipAdmin_alertBox">
			<button type="button" class="kbVipAdmin_alert-close "></button>
			<form id="recommendForm" action="" method="post" enctype="multipart/form-data">
				 <h3 class="mb10">置顶商品</h3>
				<p class="kbVipAdmin_enter"><b><i>*</i>显示位置</b>
					<select name="stick_classify" class="kbVipAdmin_slt kbVipAdmin_sltblack" required="required">
						<option value="-1">请选择推荐位置</option>
						<option value="1"> 折扣区</option>
						<option value="2"> 热销区</option>
						<option value="3">新品区</option>
					</select>
				</p>
				<p class="kbVipAdmin_enter"><b><i>*</i>开始时间:</b>
                <!-- <input type="date" name="start_time" value="" required="required" /> -->
                <input  class="datainp wicon" id="kbVipAdmin_inpstart" type="text" name="start_time" placeholder="开始日期"   readonly required="required" />
                </p>
                <p class="kbVipAdmin_enter"><b><i>*</i>结束时间:</b>
                <!-- <input type="date" name="end_time" value="" required="required" /> -->
                <input  class="datainp wicon"  type="text" name="end_time" placeholder="结束日期"   readonly required="required" />
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Goods/goodsListByProject'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	<script type="text/javascript">
	    $(function() {
	         $("[title]").each(function(b) {//这里是控制标签
	             if (this.title) {
	                 var c = this.title; //把title的赋给自定义属性 myTilte ，屏蔽自带提示
	                 var a = -16; //设置提示框相对于偏移位置，防止遮挡鼠标
	                 var e = 30; //设置提示框相对于偏移位置，防止遮挡鼠标
	                 $(this).mouseover(function(d) { //鼠标移上事件
	                     this.title = "";
	                     $("body").append('<div id="tooltip">' + c + "</div>"); //创建提示框,添加到页面中
	                     $("#tooltip").css({
	                         left: (d.pageX) + "px",
	                         top: (d.pageY+e) + "px",
	                         opacity: "0.8"
	                     }).show(250) //设置提示框的坐标，并显示
	                     console.log(d.pageY+e);
	                 }).mouseout(function() { //鼠标移出事件
	                     this.title = c; //重新设置title
	                     $("#tooltip").remove() //移除弹出框
	                 }).mousemove(function(d) { //跟随鼠标移动事件
	                     $("#tooltip").css({
	                         left: (d.pageX + a) + "px",
	                         top: (d.pageY+e) + "px"
	                     })
	                 })
	             }
	         })
	     });
	 </script>
	<script type="text/javascript">
	$(function(){
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
	           checkData(elem);
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
		          checkData(elem);
		     },
		     //  okfun:function(elem, val) {
		     //     checkData(elem);
		     // }
		 };
		 $('.kbVipAdmin_enter input[name="start_time"]').jeDate(start);
		 $('.kbVipAdmin_enter input[name="end_time"]').jeDate(end);
	})
	
		$('.tip-result').on('click',function(){
			var $this=$(this);
			$this.toggleClass('is_active');
		})

		    $(function(){
		   		

		   		

		   		$('.spAnProductList .kbVipAdmin_table .kbVipAdmin_slt').on('change',function(){
		   			var ID = $(this).parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
		   			var seleStatus = $(this).val().replace(/(^\s+)|(\s+$)/g, "");
		   			
		   			$.get('<?php echo U("ajaxControl");?>',{flag:'changeGoodsStatus',id:ID,status:seleStatus},function(res){
			   		 		if(res){
			   		 			oTip(res);
			   		 	}
			   		})
		   		 })
		   		
		   		
		   		 $('.kbVipAdmin_tdAction .kbVipAdminDel').on('click',function(){
		   		 	var $this = $(this);
		   		 	var ID =$this.parent().siblings('td').eq(0).text().replace(/(^\s+)|(\s+$)/g, "");
		   		 	Confirm("你确定删除该商品？",function(ren){
		   		 		if(ren){
		   		 			 $.get('<?php echo U("Goods/ajaxControl");?>',{flag:'goodsDel',id:ID},function(res){
			   		 			if(res){
			   		 			 	$this.parent().parent().remove();
				   		 			 oTip(res);
			   		 			}
			   				})
		   		 		}else{
		   		 			console.log("不删除");
		   		 		}
		   		 	});
		   		
		   		 });

		   		});

		     	function delPic(obj) 
		     	{	
		     		var res = confirm('确定删除图片吗?');
		     		if (res) 
		     		{
		     			$.get("<?php echo U('Goods/ajaxControl');?>", {flag:'delGoodsPicture',id:$(obj).attr('picid')},function (res){
		     				if (res) 
		     				{
		     					alert('删除成功');
		     					clearImg($(obj));
		     				}else{
		     					alert('删除失败');
		     				}
		     			});
		     		}
		     	}

		    $(function(){
		   		
		   		$(".spAnProductList_alert  .kbVipAdmin_operating input[type=reset]").on('click',function(){
		   			console.log("aaa");
		   			$(".spAnProductList_alert").fadeOut();

		   		})
		   		/* // 灰掉置顶和精选按钮
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
		   		checkChosen(); */
		   		/* 商户后台置顶*/
		   		$('.kbVipAdmin_checkboxTop input').on('change',function(){
		   			var $this=$(this),
		   				ajaxUrl='<?php echo U("GoodsStick/ajaxControl");?>?flag=stickByProject',
		   				goodsId=$this.attr('data-goodsid');
		   				;
		   			$('.recommend_alert').fadeIn();
		   			$('.recommend_alert .kbVipAdmin_restsubmit .kbVipAdmin_opt').on('click',function(){
		   				if($('.recommend_alert .kbVipAdmin_slt option:selected').val()==-1){
		   					eTip('还没选择推荐位置');
		   					return false;
		   				}
		   				var i,
		   					datainp=$('.datainp');
		   				for(i in datainp){
		   					console.log($('.datainp').eq(i));
		   					if($('.datainp').eq(i).length){
		   						if(!$('.datainp').eq(i).val().length>0){
		   							eTip('请设置开始时间或结束时间');
		   							return false;
		   						}
		   					}
		   				}
		   				var formData=new FormData($('#recommendForm')[0]);
		   					formData.append('goods_id',goodsId);
		   				$.ajax({
		   					type:"POST",
		   					url:ajaxUrl,
		   					data:formData,
		   					dataType:'json',
		   					async:false,
		   					cache:false,
		   					contentType:false,
		   					processData:false,
		   					success:function(data){
		   						console.log(data);
		   						if(data.status){
		   							sTip('推荐成功');
		   							$('.recommend_alert').fadeOut();
		   							// window.location.reload();
		   						}else{
		   							eTip('推荐失败');
		   							$this.prop('checked',false);
		   							console.log(data);
		   						}

		   					},
		   					eroor:function(error){
		   						console.log(error);
		   					}

		   				})
		   			})
		   			
		   		})
		   		$('.kbVipAdmin_checkboxdisabled input').on('change',function(){
		   			var $this=$(this);
		   			var  Status=($this.is(":checked")===true)? 3:1;
		   			var ajaxUrl='<?php echo U("Goods/ajaxControl");?>';
		   			if(!$this.prop('disabled')){
		   			jsAjaxControl($this,{
							ajaxURL:ajaxUrl,
					        ajaxBranch:'Common',
					        params:{//这是ajax需要提交的集合
					        	flag:"changeGoodsStatus",
					        	status:Status,
					        }
						},function(res){
							oTip(res);
							$this.parent().siblings('.kbVipAdmin_checkboxTop').children('input').prop('checked',false)
					})
					}
		   		})
		 
		     })
	</script>

</body>
</html>