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

<style>
	.HealthStatus{
		display:none;
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


	<div id="kbShopAdmin_rightCenter" class=" OrderForm mb10"><!-- 内容页开始 -->
			<div class="centerTitle">
				<h1>用户列表</h1>
			</div>
			<div class="kb_table-filter mb10">
				<!-- <form action="" method="get" style="display:inline-block">
						<select class="kbShopAdmin_slt w100 h30" name="correlation_id" title="可选择分类查找相关商品">
							<option value="">全部类型</option>
							<?php if(is_array($typeList)): foreach($typeList as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
						</select>
						<input type="submit" class="kbShopAdmin_opt  w80 h30" value="确认查找">
				</form> -->
				<div class="filter-searchDate mr10">
					<form action="<?php echo U('VisitorInfo/visitorList');?>">
						<input type="search" value="<?php echo I('sel_name');?>" name="sel_name" placeholder="请输入用户呢称" />
						<input class="kbShopAdmin_opt w80 h30 fr" type="submit" value="确定" />
					</form>
				</div>
			</div>
			<div class="main-contentBox kbShopAdmin_mt24" >
			<div class="kbShopAdmin_table mb20">
				
				<table>
					<thead>
						<tr>
							<th width="50">用户ID</th>
							<th>呢称</th>
							<th>用户头像</th>
							<th>性别</th>
							<th>电话号码</th>
							<th>购买次数</th>
							<!-- <th>预约次数</th> -->
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td><p><?php echo ($v["id"]); ?></p></td>
							<td><p><?php echo ($v["nick_name"]); ?></p></td>
							<td><p><img src="<?php echo ($v["head_portrait"]); ?>" width="80" alt=""></p></td>
							<td><p><?php echo ($v['sex'] == '1'?'男':'女'); ?></p></td>
							<td><p><?php echo ($v["phone"]); ?></p></td>
							<td><p><?php echo ($v["pay_total"]); ?></p></td>
							<!-- <td><p><?php echo ($v["subscribe_total"]); ?></p></td> -->
							<td>
								<div class="kbShopAdmin_tdAction">
									<input class=" kbShopAdminSea mb10" type="button" value="" title="详情" v-on:click="selectInfo(this)" />
									<!-- <input class=" kbShopAdminStaff mb10" type="button" visitorID="<?php echo ($v["id"]); ?>" value="" title="历史形象"  />
									<input class=" kbShopAdminHistorty mb10" type="button" visitorID="<?php echo ($v["id"]); ?>" nickName="<?php echo ($v["nick_name"]); ?>" value="" title="加入员工"  /> -->
								</div>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
				<!-- 表格页数开始 -->
				<div class="kbShopAdmin_page mb10">
					<div class="pageSize">
						<?php echo ($page); ?>
						<script type="text/javascript">
							$('.pageSize a:first-child').addClass('prevPage');
							$('.pageSize a:last-child').addClass('nextPage');
						</script>
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
	</div><!-- 内容页结束 -->

	<div class="kbShopAdmin_alert visitorList_alert">
		<div class="kbShopAdmin_alertBox"  id="visitorList_alert">
			<button type="button" class="kbShopAdmin_alert-close "></button>
				<h3 >个人资料</h3>
			<form >
				<div class="formDate">
				<ul class="mt20"   >
					<li class="kbShopAdmin_enter" >
						<b>呢称:</b>
						<p class="infoBlock">{{info.nick_name}}</p>
					</li>
					<!-- <li class="kbShopAdmin_enter" >
						<b>微信ID:</b>
						<p class="infoBlock"></p>
					</li> -->
					<li class="kbShopAdmin_enter" >
						<b>姓名:</b>
						<p class="infoBlock">{{info.real_name}}</p>
					</li>
					<li class="kbShopAdmin_enter" >
						<b>性别:</b>
						<p class="infoBlock" v-if="info.sex==='2'">女</p>
						<p class="infoBlock" v-if="info.sex==='1'">男</p>
					</li>
					<li class="kbShopAdmin_enter" >
						<b>生日:</b>
						<p class="infoBlock">{{info.visitor_birthday}}</p>
					</li>
					<li class="kbShopAdmin_enter" >
						<b>星座:</b>
						<p class="infoBlock">{{info.constellation}}</p>
					</li>
					<li class="kbShopAdmin_enter" >
						<b>手机号码:</b>
						<p class="infoBlock">{{info.phone}}</p>
					</li>
					<li class="kbShopAdmin_enter" >
						<b>邮箱:</b>
						<p class="infoBlock">{{info.email}}</p>
					</li>
					<li class="kbShopAdmin_enter" >
						<b>个人说明:</b>
						<p class="infoBlock">{{info.visitor_title}}</p>
					</li>
				</ul>
				</div>
				<div class="kbShopAdmin_operating ">
					<div class="kbShopAdmin_restsubmit">
						<input  class="kbShopAdmin_opt_7facff  HistortyInfo w80 h30 tc" v-bind:visitorID="info.visitor_id" type="button" value="历史形象" />
						<input  class="visitorInfo kbShopAdmin_opt_7facff w80 h30" v-bind:visitorID="info.visitor_id" type="button" value="完善资料" />
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>


 <p class="tc mt20 f14">技术支持由<a href="http://gdkbvip168.gdallinone.com/Company/Index/index">广州旷邦科技有限责任公司提供</a></p>

	<script>
		$(function(){
			$('.kbShopAdmin_alert .kbShopAdmin_operating input[type="reset"],.kbShopAdmin_alert-close').on('click',function(){
				$('.kbShopAdmin_alert').fadeOut();
			});
			$('.kbShopAdminHistorty').on('click', function(){
				var url = "<?php echo U('ajaxControl');?>";
				var data = {
					flag: 'joinInStaff',
					id: $(this).attr('visitorID'),
					nick_name: $(this).attr('nickName')
				};
				Confirm("确定加入员工列表？",function(res){
					if(res){
						$.get(url, data , function(res){
							console.log(res);
							if (res == 0) {
								sTip('已经是员工了');
							}else if(res == true){
								sTip('搞定!');
							}
						})
					}
				})

			});
			(function(){
				var app=new Vue({
					el:'#visitorListEdit',
					data:{
						info:{}
					}
				});
				var Url;
				$('#visitorListInfoEdit').on('click',function(){
					if($(this).prev().children('option').length==0) return false;
					var $this=$(this);
						sltTime=Date.parse(new Date($this.prev().children('option:selected').val()))/1000-8*60*60,
						visitor_id=$this.parents('[data-visitor_id]').attr('data-visitor_id').trim();
						$.get("<?php echo U('VisitorImage/ajaxControl');?>", {
							flag:'getImageInfo', 
							visitor_id:visitor_id,
							time:sltTime
						}, function(res){
							app.info=res;
							if(res.information){
								Object.keys(res.information).map(function(elem,indexs){
									var problem=$('#visitorListEdit').find("input[name='information["+elem+"]']");
									if(problem.length==0){
										var Html='<li class="kbShopAdmin_enter" >'+
													'<b>'+elem+':</b>'+
													'<p class="kbShopAdmin_radio">'+
														'<input class="" type="radio" value="是" name="information['+elem+']" />'+
														'<label><b></b></label>'+
													'</p>'+
													'<span class="radioText">是</span>'+
													'<p class="kbShopAdmin_radio">'+
														'<input class="" type="radio" value="否" name="information['+elem+']" />'+
														'<label><b></b></label>'+
													'</p>'+
													'<span class="radioText">否</span>'+
												'</li>';
										$('#visitorListEdit .property').after(Html);
										problem.push($('.visitorListEdit_alert').find('[name="information['+elem+']"]'));
									}
									
									problem.each(function(pindexs,pelem){
										if($(pelem).val()==res.information[elem]){
											$(pelem).attr('checked',true);
										}
									})
								});
								 Url="<?php echo U('VisitorImage/update');?>?id="+res.id+"&visitor_id="+res.visitor_id;
								$('#visitorListEdit').parents('form').attr('action',Url);

								$('#shopImg10').on('change',function(){
									var shopImg10=document.getElementById('shopImg10').files,
										imgArr=new Array(),
										$this=$(this);
									Object.keys(shopImg10).map(function(elem,indexs){
										var reader=new FileReader();
										reader.readAsDataURL(shopImg10[elem]);
										reader.onload=function(e){
											// imgArr.push(this.result);
											var Html='<div class="shopImg businessFileImgList"><img src="'+this.result+'" alt=""></div>'
											$this.before(Html);
										}
									})
									console.log(imgArr);
									/* imgArr.map(function(elem,indexs){

									}) */
								})
							}	

						});
								/*$('#visitorListEdit').parents('form').find('input[type="button"]').on('click',function(){
									var $this=$(this),
										formData=new FormData(),
										name=$('.visitorListEdit_alert').find('[name]').not('[type="file"]');
										Object.keys(name).map(function(elem,indexs){
											var iNmae=name[elem].attr("name"),
												Val=name[elem].val();
											formData.append(iName,Val);
										})
										document.getElementById('shopImg10').files[0];
										console.log(name)
										// formData.append("")

								}) */
				
					$('.kbShopAdmin_alert').fadeOut();
					$('.visitorListEdit_alert').fadeIn();
				})

			})();
				//自定义属性
			$('.addProperty').on('click',function(){
				var	$this=$(this),
					template=$('#addPropertyTemp').html(),
					data={
						attrName:$this.parent().siblings('input').val()
					};
					console.log(data);
				if(data.attrName.length !=0){
					var myTempalte=Handlebars.compile(template);
						$this.parents('.kbShopAdmin_alert').find('.property').last().after(myTempalte(data));
				}
				$this.parent().siblings('input').val('');
			})

			//头发健康
			$('.health input,.nohealth input').on('click',function(){
				var $this=$(this),
					status=($this.parent().hasClass('health'))? $this.parents('li').siblings('.Health'):$this.parents('li').siblings('.noHealth');
					console.debug(status);
					console.debug($this.parent().hasClass('Health'));
				$('.HealthStatus').fadeOut();
				status.fadeIn();
			})
		});



		(function(){
			var app =new Vue({
				el:'#visitorList_alert',
				data:{
					info:{},

				}
			})
			// 详细资料
			$('.kbShopAdminSea').on('click',function(){
				var $this=$(this),
					visitor_id=$this.parents('tr').children('td').eq(0).children('p').text().trim();
				$.get('<?php echo U("VisitorInfo/ajaxControl");?>',{
					flag:"visitorInfo",
					visitor_id:visitor_id
				},function(res){
					app.info=res.info;
					// console.log(app.$el);
				var url = "<?php echo U('VisitorImage/insert');?>?visitor_id="+app.info.visitor_id;
				$('.visitorListAdd_alert').find('form').attr('action',url);
				})
				$('.visitorList_alert').fadeIn();
			})
			$('.visitorInfo').on('click',function(){
				/*$.get('<?php echo U("ajaxControl");?>',{flag: 'checkOrderIsExist', visitorID: $(this).attr('visitorID')},function (res){
					if (!res) {
						alert('用户最近还没预约过服务');
					}else{
					}
				})*/
						$('.kbShopAdmin_alert').fadeOut();
						$('.visitorListAdd_alert').fadeIn();
				
			})


		})();
		(function(){
			/* var Child={
				template:'#visitorListInfo_temp',
				props:['historeyInfo']
			} */
			
			var app=new Vue({
				el:'#historyInfo',
				data:{
					info:{}
				}
			});
			//历史形象
			$('.HistortyInfo,.kbShopAdminStaff').on('click',function(){
				var $this=$(this);
				$.get("<?php echo U('VisitorImage/ajaxControl');?>", {flag:'getImageInfo', visitor_id: $($this).attr('visitorID')}, function(res){
					app.info=res;
					console.log(res);
				});
				$('.kbShopAdmin_alert').fadeOut();
				$('.visitorListInfo_alert').fadeIn();
			});
			$('#historyInfo select').on('change',function(){
				
				var $this=$(this);
					sltTime=Date.parse(new Date($this.children('option:selected').val()))/1000-8*60*60,
					visitor_id=$this.parents('[data-visitor_id]').attr('data-visitor_id').trim();
					$.get("<?php echo U('VisitorImage/ajaxControl');?>", {
						flag:'getImageInfo', 
						visitor_id:visitor_id,
						time:sltTime
					}, function(res){
						/*res.visitor_upload="/Uploads/visitorImage/20170614/5940fc2a93532_thumbnail.jpg"*/

						app.info=res;
					})
			})
		})();
	

		
		function HistortyInfo(_this){
			
		}
		function delProperty(_this){
				Confirm("进行该操作后，数据将不能恢复。确认继续进行该操作吗？",function(res){
					if(res){
						var $this=$(_this);
						$this.parents('.property').remove();
					}

				})
			}
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/VisitorInfo/visitorList/p/3.html';?>")
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