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





	
    
<link rel="stylesheet" href="/Public/Business/BusinessCSS/shopIndex/shopIndex.css"></link>

 <link rel="stylesheet" href="/Public/JS/module/datenew/css/jquery-ui-1.9.2.custom.css?v=1" type="text/css">
  <style>
            .container{
               border:1px solid #eee;
            }
            .spAnIndex{
              overflow-y:scroll !important;
            }
            .kbShopAdmin_box{

                border-bottom: 1px solid #eee;
                padding-bottom: 10px;
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


	<div id="kbShopAdmin_rightCenter" class="spAnIndex ">
		<div class="kbShopAdmin_box">
	          <div class="centerTitle">
	            <h2>访问量统计</h2>
	          </div>
	        <div class="kbShopAdmin_operating filter-operating" >
	          <form>
	            <div class="filterData">
	            <input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
	            <input class="start" type="hidden" name="start" value="" />
	            <input  class="end"  type="hidden" name="end" value="" />
	            <button class="kbShopAdmin_opt w80 h30" type="button">确定</button>
	            </div>
	          </form>
	        </div>
	       <div id="container" class="container" style="height: 300px"></div>
	      </div>


	      <div class="kbShopAdmin_box">
	          <div class="centerTitle">
	            <h2>销售统计</h2>
	          </div>
	        <div class="kbShopAdmin_operating filter-operating" >
	          <form>
	            <div class="filterData">
	            <input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
	            <input class="start" type="hidden" name="start" value="" />
	            <input  class="end"  type="hidden" name="end" value="" />
	            <button class="kbShopAdmin_opt w80 h30" type="button">确定</button>
	            </div>
	          </form>
	        </div>
	       <div id="container2" class="container" style="height: 300px"></div>
	      </div>

	      <div class="kbShopAdmin_box">
	          <div class="centerTitle">
	            <h2>新增用户统计</h2>
	          </div>
	        <div class="kbShopAdmin_operating filter-operating" >
	          <form>
	            <div class="filterData">
	            <input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
	            <input class="start" type="hidden" name="start" value="" />
	            <input  class="end"  type="hidden" name="end" value="" />
	            <button class="kbShopAdmin_opt w80 h30" type="button">确定</button>
	            </div>
	          </form>
	        </div>
	       <div id="container3" class="container" style="height: 300px"></div>
	      </div>

	      <div class="kbShopAdmin_box">
	          <div class="centerTitle">
	            <h2>官网菜单浏览统计</h2>
	          </div>
	        <div class="kbShopAdmin_operating filter-operating" >
	          <form>
	            <div class="filterData">
	            <input type="text" class="ui-datepicker-time" readonly="readonly"  value="" />
	            <input class="start" type="hidden" name="start" value="" />
	            <input  class="end"  type="hidden" name="end" value="" />
	            <button class="kbShopAdmin_opt w80 h30" type="button">确定</button>
	            </div>
	          </form>
	        </div>
	       <div id="container4" class="container" style="height: 300px"></div>
	      </div>
	      <!--  <div id="container2" style="height: 100%"></div>
	       <div id="container3" style="height: 100%"></div>
	       <div id="container4" style="height: 100%"></div> -->
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
	</div>


 <p class="tc mt20 f14">技术支持由<a href="http://gdkbvip168.gdallinone.com/Company/Index/index">广州旷邦科技有限责任公司提供</a></p>


  <script type="text/javascript" src="/Public/JS/module/datenew/js/jquery-ui-1.9.2.custom.js"></script>

  <script type="text/javascript" src="/Public/JS/module/datenew/js/share.js?v=1.11"></script>


   <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js"></script>
   <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
   <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
   <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
   <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
   <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUONbpqGBsYGXNIYHicvbAbM"></script>
   <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
  <script type="text/javascript">
    window.onload=function(){
      //访问量统计
     
      	function getFirstTableData(start,end){

      		$.get('<?php echo U("ajaxControl");?>',{
      			flag:"getFirstTableData",
      			start:start,
      			end:end
      		},function(res){
      			var newDate=new Array();
      			res.date.map(function(elem,indexs){
      				console.log(elem)
      				newDate.push(date('Y-m-d',elem));
      			})
      			
      			var dom = document.getElementById("container");
      			var myChart = echarts.init(dom);
      			var app = {};
      			var option = null;
      			option = {
      			    title: {
      			        text: ''
      			    },
      			    tooltip: {
      			        trigger: 'axis'
      			    },
      			    // legend: {
      			    //     data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
      			    // },
      			    grid: {
      			        left: '3%',
      			        right: '4%',
      			        bottom: '3%',
      			        containLabel: true
      			    },
      			    toolbox: {
      			        feature: {
      			            saveAsImage: {}
      			        }
      			    },
      			    xAxis: {//横坐标
      			        type: 'category',
      			        boundaryGap: false,
      			        data: newDate
      			    },
      			    yAxis: {//纵坐标
      			        type: 'value'
      			    },
      			    series: [
      			        {
      			            name:'访问量',
      			            type:'line',
      			            data:res.visit_total
      			        }
      			       
      			    ]
      			};
      			
      			if (option && typeof option === "object") {
      			    myChart.setOption(option, true);
      			}
      		})

      	}
      


       
    
       //销售统计
      
       	function getSecondTableData(start,end){
       		var data=new Object();
      		$.get('<?php echo U("ajaxControl");?>',{
      			flag:"getSecondTableData",
      			start:start,
      			end:end
      		},function(res){
      			
      			data=res;
      			var newDate=new Array();
      			data.date.map(function(elem,indexs){
      				newDate.push(date('Y-m-d',elem));
      			})
	      		var dom = document.getElementById("container2");
		        var myChart = echarts.init(dom);
		        var app = {};
		        var option = null;
		        option = {
		            title: {
		                text: ''
		            },
		            tooltip: {
		                trigger: 'axis'
		            },
		            legend: {//
		                data:['订单量']
		            },
		            grid: {
		                left: '3%',
		                right: '4%',
		                bottom: '3%',
		                containLabel: true
		            },
		            toolbox: {
		                feature: {
		                    saveAsImage: {}
		                }
		            },
		            xAxis: {
		                type: 'category',
		                boundaryGap: false,
		                data: newDate
		            },
		            yAxis: {
		                type: 'value'
		            },
		            series: [
		               
		                {
		                    name:'订单量',
		                    type:'line',
		                    
		                    data:data.OrderForm
		                }
		               
		            ]
		        };
		        
		        if (option && typeof option === "object") {
		            myChart.setOption(option, true);
		        }
      		})
      		
      	}
      
      	
        
    
      //新增用户统计
      
       	function getThirdTableData(start,end){
       		var data=new Object();
      		$.get('<?php echo U("ajaxControl");?>',{
      			flag:"getThirdTableData",
      			start:start,
      			end:end
      		},function(res){
      			console.log(res);
      			// data=res;
      			var newDate=new Array();
       				res.date.map(function(elem,indexs){
       					newDate.push(date('Y-m-d',elem));
       				})
      			var dom = document.getElementById("container3");
      			var myChart = echarts.init(dom);
      			var app = {};
      			var option = null;
      			option = {
      			    title: {
      			        text: ''
      			    },
      			    tooltip: {
      			        trigger: 'axis'
      			    },
      			    // legend: {
      			    //     data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
      			    // },
      			    grid: {
      			        left: '3%',
      			        right: '4%',
      			        bottom: '3%',
      			        containLabel: true
      			    },
      			    toolbox: {
      			        feature: {
      			            saveAsImage: {}
      			        }
      			    },
      			    xAxis: {
      			        type: 'category',
      			        boundaryGap: false,
      			        data:newDate
      			    },
      			    yAxis: {
      			        type: 'value'
      			    },
      			    series: [
      			        {
      			            name:'用户',
      			            type:'line',
      			            data:res.data
      			        }
      			        
      			    ]
      			};
      			
      			if (option && typeof option === "object") {
      			    myChart.setOption(option, true);
      			}
      		});
      	}
      	
     
       
     
      //官网菜单浏览统计
      
       	 	function getFortTableData(start,end){
       			$.get('<?php echo U("ajaxControl");?>',{
       				flag:"getFortTableData",
       				start:start,
       				end:end
       			},function(res){
       				console.log(res);
       				var newDate=new Array();
       				res.date.map(function(elem,indexs){
       					newDate.push(date('Y-m-d',elem));
       				})
	       			var dom = document.getElementById("container4");
	       			var myChart = echarts.init(dom);
	       			var app = {};
	       			var option = null;
	       			option = {
	       			    title: {
	       			        text: ''
	       			    },
	       			    tooltip: {
	       			        trigger: 'axis'
	       			    },
	       			    legend: {
	       			        data:['首页点击量','动态点击量','商品点击量','我的点击量']
	       			    },
	       			    grid: {
	       			        left: '3%',
	       			        right: '4%',
	       			        bottom: '3%',
	       			        containLabel: true
	       			    },
	       			    toolbox: {
	       			        feature: {
	       			            saveAsImage: {}
	       			        }
	       			    },
	       			    xAxis: {
	       			        type: 'category',
	       			        boundaryGap: false,
	       			        data: newDate
	       			    },
	       			    yAxis: {
	       			        type: 'value'
	       			    },
	       			    series: [
	       			        {
	       			            name:'首页点击量',
	       			            type:'line',
	       			            data:res.click_total[1]
	       			        },
	       			        {
	       			            name:'动态点击量',
	       			            type:'line',
	       			            data:res.click_total[2]
	       			        },
	       			        {
	       			            name:'商品点击量',
	       			            type:'line',
	       			            data:res.click_total[3]
	       			        },
	       			      
	       			        {
	       			            name:'我的点击量',
	       			            type:'line',
	       			            data:res.click_total[5]
	       			        }
	       			    ]
	       			};
	       			if (option && typeof option === "object") {
	       			    myChart.setOption(option, true);
	       			}
       			})
       		}

       		
       		
       		
	    (function(){
	     	var nowDate = new Date(),
	     		end=Date.parse(new Date(nowDate.getFullYear() + '/'+  (nowDate.getMonth()+1) + '/' + nowDate.getDate()));
	     		nowDate.setDate(nowDate.getDate()-parseInt(7));
	     		var start =Date.parse( nowDate.getFullYear() + '/'+  (nowDate.getMonth()+1) + '/' + nowDate.getDate());
	     		getFirstTableData(start,end);
	      		getSecondTableData(start,end);
	     		getThirdTableData(start,end);
	     		getFortTableData(start,end);
	     })();
      	$('.filterData .kbShopAdmin_opt' ).on('click',function(){
      		var $this=$(this),
      			filterData=$('.filterData .kbShopAdmin_opt' ),
      			start=$this.siblings('[name="start"]').val().trim(),
      			end=$this.siblings('[name="end"]').val().trim(),
      			indexs=filterData.index($this);
      			
      			switch(indexs){
      				case 0:
      					getFirstTableData(start,end)
      				break;
      				case 1:
      					getSecondTableData(start,end);
      				break;
      				case 2:
      					getThirdTableData(start,end);
      				break;
      				case 3:
      					getFortTableData(start,end);
      				break;
      			}
      	});
    
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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/Index/companyIndex.html';?>")
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