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





	
    

	<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?version=1.13"></link>

	<script>
		$('.kbShopAdmin_fileImg input[type="file"]').on('change',function(){
				if ( typeof(FileReader) === 'undefined' ){ 
					alert("抱歉，你的浏览器不支持 FileReader，推荐使用谷歌浏览器操作！"); 
					this.setAttribute( 'disabled','disabled' ); 
				} else { 
					readFile(this,this.files);
				} 
		});
	</script>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/ueditor.all.min.js"> </script>
	<script type="text/javascript" charset="utf-8" src="/Public/JS/module/ueditor/lang/zh-cn/zh-cn.js"></script>
	  <!-- gaoCode -->
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=a2414330232c1ba563ad05237561e9d9&plugin=AMap.Autocomplete,AMap.PlaceSearch,AMap.Geocoder"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/PlaceSearchRender.js"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
    <style>
    .couponAddr select {
    	    width: 120px;
    	    height: 30px;
    	    border-radius: 5px;
    	    margin-right: 5px;
    	}
    </style>
    <?php  ?>

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



	<div id="kbShopAdmin_rightCenter" class="spAnUserCore kbShopAdmin_box" style="    overflow-y: scroll;">
		<div class="kbShopAdmin_operating spAnUserCore-operating">
			<!-- <input class="kbShopAdmin_button_ff6c60 kbShopAdmin_add fr mt15 mr10" type="button" value="添加分店" /> -->

		</div>
		<div class="centerTitle">
			<input class="kbShopAdmin_writer spAnUserCoreDefault-editBtn kbShopAdmin_opt fr w80 h30" type="button" value="编辑" />
			<h1>店铺资料</h1>
		</div>
		<div class="spAnUserCoreDefault ">
			
			<ul class="spAnUserCoreDefault-info">
				<li><b>商户编号:</b><p><?php echo ($info['user_ip']?$info['user_ip']:'暂无商户编号'); ?></p></li>
				<li><b>本店名称:</b><p><?php echo ($info['company_name']); ?></p></li>
				<li><b>微官网网址:</b><p><?php echo ($info['company_link']); ?><font size="3" color="#FF2020">(如需改动请向项目管理员申请)</font></p></li>
				<!-- <li><b>商户地址:</b><p><?php echo ($info['company_address']); ?>-<?php echo ($info['address_info']); ?></p></li> -->
				<li><b>商户地址:</b><p><?php echo ($info['company_address']); ?>-<?php echo ($info['address_info']); ?></p></li>
				<li><b>商户行业:</b><p><?php echo ($info['business_name']); ?></p></li>
				<li><b>联系人:  </b><p><?php echo ($info['principal']); ?></p></li>
				<li><b>联系电话:</b><p><?php echo ($info['phone']); ?></p></li>
				<li><b>联系邮箱:</b><p><?php echo ($info['email']); ?></p></li>
				<!-- <li><b>公众号AppID:</b><p><?php echo ($info['app_id']?$info['app_id']:'请填写完毕APPID与密匙'); ?></p></li>
				<li><b>微信商户密钥:</b><p><?php echo ($info['api_key']?$info['api_key']:'填写可开通微信支付功能'); ?></p></li>
				<li><b>微信商户号:</b><p><?php echo ($info['mch_id']?$info['mch_id']:'填写可开通微信支付功能'); ?></p></li>
				<li><b>系统登录ip地址白名单:</b>
					<p><?php echo ($info['ip_address']?$info['ip_address']:'现在设置是哪里都可以登录,为保障你的系统安全性,请设置好ip白名单'); ?></p>
				</li> -->
				<!-- <li><b>营业执照:</b>
					<p class="shopImg">
						<img src="/Public<?php echo ($info['pictureInfo']['business_license']); ?>"  alt="shopImg"/>
					</p>
				</li>
				<li><b>身份证正面:</b>
					<p class="shopImg">
						<img src="/Public<?php echo ($info['pictureInfo']['person_code_front']); ?>"  alt="shopImg"/>
					</p>
				</li>
				<li><b>身份证反面:</b>
					<p class="shopImg">
						<img src="/Public<?php echo ($info['pictureInfo']['person_code_rear']); ?>"  alt="shopImg"/>
					</p>
				</li> -->
				<li><b>本店LOGO:</b>
					<?php if(empty($info["pictureInfo"]["company_logo"])): ?><p><font size="4" color="#FF2020">请完善上传本店LOGO</font></p>
					<?php else: ?>
					<p class="shopImg">
						<img src="/Public<?php echo ($info['pictureInfo']['company_logo']); ?>"  alt="shopImg"/>
					</p><?php endif; ?>
				</li>
				<li><b>本店二维码:</b>
					<?php if(empty($info["pictureInfo"]["company_code"])): ?><p><font size="4" color="#FF2020">请完善上传本店公众号二维码</font></p>
					<?php else: ?>
					<p class="shopImg">
						<img src="/Public<?php echo ($info['pictureInfo']['company_code']); ?>"  alt="shopImg"/>
					</p><?php endif; ?>
				</li>
				<li><b>商盟官网背景:</b>
					<?php if(empty($info["pictureInfo"]["company_bgpic"])): ?><p><font size="4" color="#FF2020">请完善上传本店商盟官网背景</font></p>
					<?php else: ?>
					<p class="shopImg">
						<img src="/Public<?php echo ($info['pictureInfo']['company_bgpic']); ?>"  alt="shopImg"/>
					</p><?php endif; ?>
				</li>
				<!--  -->
			</ul>
			<!-- <div class="kbShopAdmin_operating ">
				<input class="spAnUserCoreDefault-editBtn kbShopAdmin_opt fr w80 h30" type="button" value="编辑" />
			</div> -->

			<form class="spAnUserCoreDefault-formEdit" action="<?php echo U('Company/companyInfoComplete');?>" method="post" enctype="multipart/form-data">
				<!-- <h3 class="mt20 mt10 tc">修改店铺资料</h3> -->
				<div class="formData">
					<ul>
						<li class="kbShopAdmin_enter"><b>联系电话:</b><input  type="text" name="phone" value="<?php echo ($info['phone']); ?>" /></li>
						<li class="kbShopAdmin_enter"><b>联系人:</b><input  type="text" name="principal" value="<?php echo ($info['principal']); ?>" /></li>
						<li class="kbShopAdmin_enter"><b>联系邮箱:</b><input  type="text" name="email" value="<?php echo ($info['email']); ?>" /></li>
						
						<!-- <li class="kbShopAdmin_enter"><b>公众号AppID:</b><input  type="text" name="app_id" value="<?php echo ($info['app_id']); ?>" placeholder="公众号AppID" /></li>
						<li class="kbShopAdmin_enter"><b>公众号AppSecret:</b><input  type="password" name="app_secret" value="<?php echo ($info['app_secret']); ?>" placeholder="公众号AppSecret" /></li>
						<li class="kbShopAdmin_enter"><b>微信商户号:</b><input  type="password" name="mch_id" value="<?php echo ($info['mch_id']); ?>" placeholder="微信商户平台商户号,获取微信支付功能" /></li>
						<li class="kbShopAdmin_enter"><b>微信商户密钥:</b><input  type="password" name="api_key" value="<?php echo ($info['api_key']); ?>" placeholder="微信商户平台商户密钥,获取微信支付功能" /></li>
						<li class="kbShopAdmin_enter"><b>系统允许登录的ip地址:</b>
						<textarea name="ip_address" cols="30" placeholder="如有多个请使用分号';'分割(想了解当前IP地址可访问http://ip.qq.com)"  rows="10"><?php echo ($info['ip_address']); ?></textarea>
						</li> -->
						<li class="kbShopAdmin_enter kbShopAdmin_fileImg">
							<b>本店LOGO:</b>
							<div class="shopImg businessFileImgList">
								<span class="cleraIMG" onclick="clearImg(this)"></span>
								<img src="/Public<?php echo ($info['pictureInfo']['company_logo']); ?>" alt="本店LOGO"/>
							</div>
							<input id="shopImg" name="company_logo" type="file" value=""  />
							<label class="" for="shopImg" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为本店LOGO</span></label>
							
						</li>
						<li class="kbShopAdmin_enter kbShopAdmin_fileImg">
							<b>本店二维码:</b>
							<!-- <div class="fileImgMore"> -->
							<div class="shopImg businessFileImgList">
								<span class="cleraIMG" onclick="clearImg(this)"></span>
								<img src="/Public<?php echo ($info['pictureInfo']['company_code']); ?>" alt="本店二维码"/>
							</div>
							<!-- </div> -->
							<input id="shopImg2" name="company_code" type="file" value=""  />
							<label class="" for="shopImg2" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为本店二维码</span></label>
							
							
						</li>
						<li class="kbShopAdmin_enter kbShopAdmin_fileImg">
							<b>商盟官网背景:</b>
							
							<div class="shopImg businessFileImgList">
								<span class="cleraIMG" onclick="clearImg(this)"></span>
								<img src="/Public<?php echo ($info['pictureInfo']['company_bgpic']); ?>" alt="商盟官网背景"/>
							</div>
							<input id="shopImg3" name="company_bgpic" type="file" value="" />
							<label class="" for="shopImg3" ><span style="font-size:27px">+</span><br /><span>选择一张图片作为商盟官网背景</span></label>
							
						</li>

						
						<!-- <li class="kbShopAdmin_enter kbShopAdmin_fileImg">
							<b>微信支付CERT证书:<br><font color="red"><?php echo ($info['pem_addr']?'已上传证书':'请上传证书,两个证书必需同时上传'); ?></font></b>
							<input id="shopImg4" name="apiclient_cert" type="file" value="" />
							<label class="" for="shopImg4" ><span style="font-size:27px">+</span><br /><span>微信支付双向证书<br>(apiclient_cert.pem文件)</span></label>
						</li>
						<li class="kbShopAdmin_enter kbShopAdmin_fileImg">
							<b>微信支付KEY证书:<br><font color="red"><?php echo ($info['pem_addr']?'已上传证书':'请上传证书,两个证书必需同时上传'); ?></font></b>
							<input id="shopImg5" name="apiclient_key" type="file" value="" />
							<label class="" for="shopImg5" ><span style="font-size:27px">+</span><br /><span>微信支付双向证书<br>(apiclient_key.pem文件)</span></label>
						</li> -->

						<li class="kbShopAdmin_enter couponAddr">
							<b><i>*</i>地址:</b>
							<select required="required" name="province">
		                        <option value="" >请选择省级</option>
		                            <?php if(is_array($address)): foreach($address as $key=>$v): ?><option value="<?php echo ($v['district_id']); ?>">
		                                	<?php echo ($v["name"]); ?>
		                                </option><?php endforeach; endif; ?>
		                    </select>
		                    <select required="required" name="city">
		                        <option value="">请选择市级</option>
		                    </select>
		                    <select name="district" required="required">
		                        <option value="">请选择区级</option>
		                    </select>
						</li>
						<li  class="kbShopAdmin_enter spAnUserAddr">
							<b>商户地址:</b><input id="tipinput" type="text" value="<?php echo ($info['address_info']); ?>" name="address_info" />
							 </br> </br>
							 <b>地图地址:</b><input id="result" type="text" value="" / disabled>
							 <!--  <input id="lnglat" type="hidden" name="coordinate" value="<?php echo ($info['x_coordinate']); ?>,<?php echo ($info['y_coordinate']); ?>" /> -->

							 <!-- 地图坐标 -->
								<?php if(empty($info["x_coordinate"])): ?><input id="lnglat" type="hidden" name="coordinate" value="" />
								<?php else: ?> 
									<input id="lnglat" type="hidden" name="coordinate" value="<?php echo ($info['x_coordinate']); ?>,<?php echo ($info['y_coordinate']); ?>" /><?php endif; ?> 
							 <!-- 地图加载容纳的元素 -->
								<div id="geoCoder">

								</div>
						</li>
					</ul>
					<div class="kbShopAdmin_operating ">
						<div class="kbShopAdmin_restsubmit">
							<input class="spAnUserCoreDefault-submit kbShopAdmin_opt_7facff fr mr20 w80 h30" type="submit" value="确认修改" />
							<input class="spAnUserCoreDefault-submit kbShopAdmin_button_6ccac9 fr mr20 w80 h30" type="button" value="取消" />
						</div>
					</div>
				</div>
			</form>
			
		</div>
		<div class="centerTitle">
			<input class="kbShopAdmin_writer spAnCompanyInfo-writer  kbShopAdmin_opt fr w80 h30" type="button" value="编辑" />
			<h1>公司简介</h1>
		</div>
		<div class="spAnCompanyInfo">
			<!-- 	<div class="kbShopAdmin_operating spAnCompanyInfo-operating">
					<input class="kbShopAdmin_button_ff6c60 kbShopAdmin_writer fr" type="button" value="编辑" />
				</div> -->
				<div class="spAnCompanyInfo-introduction">
					<h3 class="mb10">公司简介:</h3>
					<p>
						<?php echo ($newsInfo); ?>
					</p>
				</div>
				<div id="spAnCompanyInfo-edit" >
					<h3 class="mb10">公司简介:</h3>
					<form id="spAnCompanyInfoForm" action="<?php echo U('companyInfo');?>" method="post">
						<div id="myEditor"  class="myEditor">
						<script id="container2" name="news" type="text/plain">
						<?php echo ($newsInfo); ?>
					    </script>
					    <!-- 配置文件 -->
					    <script type="text/javascript" src="ueditor.config.js"></script>
					    <!-- 编辑器源码文件 -->
					    <script type="text/javascript" src="ueditor.all.js"></script>
					    <!-- 实例化编辑器 -->
					    <script type="text/javascript">
					        var ue = UE.getEditor('container2',{
					        		'initialFrameWidth':950,
					        		'initialFrameHeight':360,
					        		// 'initialContent':'在这里你可以布置好你商品详情的资料'
					        });
					    </script>
						</div>
						<div class="kbShopAdmin_operating ">
							<div class="kbShopAdmin_restsubmit">
								
							<input for="spAnCompanyInfoForm" class="kbShopAdmin_opt_7facff  w80 h30" type="submit" value="保存" />
							</div>
						</div>
					
					</form>
				</div>
			</div>
	</div>	

	<script type="text/javascript">
    var marker = new AMap.Marker() ; map = new AMap.Map("geoCoder", {
        resizeEnable: true,
        zoom: 13
    });
    //map.setZoom(13);
    //为地图注册click事件获取鼠标点击出的经纬度坐标
    //var clickEventListener =
     map.on('click', function(e) {
       var getLnglat  = document.getElementById("lnglat").value = e.lnglat.getLng() + ',' + e.lnglat.getLat();
         marker.setMap(null);
         marker = new AMap.Marker({
             icon:"/Public/images/addr.png",
             map: map,
             position: [e.lnglat.getLng(), e.lnglat.getLat()],
             offset: new AMap.Pixel(-8, -40)
         });
         console.log(e.lnglat);
        regeocoder(e.lnglat);
    });

    function regeocoder(lnglatXY,callback) {  //逆地理编码
         

           var geocoder = new AMap.Geocoder({
               radius: 1000,
               extensions: "all"
           });        

           geocoder.getAddress(lnglatXY, function(status, result) {
               if (status === 'complete' && result.info === 'OK') {
                   geocoder_CallBack(result);
                   callback(true);
               }
           });  
           
          //var getLnglat=lnglatXY.getLng() + ',' + lnglatXY.getLat()

       }
   function geocoder_CallBack(data) {
       var address = data.regeocode.formattedAddress; //返回地址描述
        // id result 地址解析显现的地方
       document.getElementById("result").value = address;
   }

    //输入关键字下拉提示搜索
    var auto = new AMap.Autocomplete({
        input: "tipinput"
    });
    AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
    function select(e) {
        if (e.poi && e.poi.location) {
            map.setZoom(18);
            map.setCenter(e.poi.location);

        }
    }

    AMap.service(["AMap.PlaceSearch"], function() {
        var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
            pageSize: 1,
            pageIndex: 1,
            map: map,
            // panel: "panel"
        });
    $('#tipinput').blur(function(){
        var tipSearch=$("#tipinput").val();
        //console.log(tipSearch.length);
        if(tipSearch.length>0){
        	  //关键字查询
      		  placeSearch.search(tipSearch,function(status, result){
            
             map.setZoom(17);
            if (result.poiList.pois.length>0) {
            var lng=result.poiList.pois[0].location.lng;
            var lat=result.poiList.pois[0].location.lat;
            var address = result.poiList.pois[0].cityname+result.poiList.pois[0].adname+result.poiList.pois[0].address;
             $('#lnglat').val(lng+","+lat);
            $('#result').val(address);
             }else{
             	$('#result').val("");
             	 $('#lnglat').val("");
                alert("抱歉！你输入的地名暂时找不到，换另一个试试呗");  
        	}
           
        });
      		  }	

    });   
    
   })
</script>
	<script type="text/javascript">
		$(function(){
			$('.spAnUserCoreDefault-editBtn').on('click',function(){
				$('.spAnUserCoreDefault-formEdit').fadeIn();
				$('.spAnUserCoreDefault-formEdit').siblings().fadeOut();
				$(this).fadeOut()
			})
			$('.spAnUserCoreDefault-submit').on('click',function(){
				$('.spAnUserCoreDefault-formEdit').fadeOut();
				$('.spAnUserCoreDefault-formEdit').siblings().fadeIn();
				$('.spAnUserCoreDefault-editBtn').fadeIn();
			})

			$(" .spAnCompanyInfo-writer").on('click',function(){
				$('#spAnCompanyInfo-edit').fadeIn();
				$('#spAnCompanyInfo-edit').siblings().fadeOut();
			});
			$("#spAnCompanyInfo-edit  [type='submit']").on('click',function(){
				$('#spAnCompanyInfo-edit').fadeOut();
				$('#spAnCompanyInfo-edit').siblings().fadeIn();
			});
			$('.couponAddr select').on('change',function (){
	            var fa = $(this).next();
	            var flag = 'address';
	            var name = fa.find('option:eq(0)').text();
	            $.get('<?php echo U("Card/ajaxControl");?>',{'flag':flag,'pid':$(this).val()},function (res){
	                var str = '<option value="">'+name+'</option>';
	                for(var k in res)
	                {
	                    str += '<option value="'+res[k].district_id+'">'+ res[k].name +'</option>';
	                }
	                fa.html(str);
	            });
	        });
		})
		window.onload=function(){
			var mapPosition= $('#lnglat').val().trim();
			console.log(mapPosition.length)
			
			if(mapPosition.length){
				var mapPositionArry= mapPosition.split(",");
				regeocoder(mapPositionArry,function(res){
					if(res) $('#tipinput').val($('#result').val())
				});
				var marker = new AMap.Marker({  //加点
				         map: map,
				         position:mapPositionArry
				 });
				 map.setFitView();
				 map.setZoom(18);
			}

		}
	</script>

 <p class="tc mt20 f14">技术支持由<a href="http://gdkbvip168.gdallinone.com/Company/Index/index">广州旷邦科技有限责任公司提供</a></p>



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
				if(nav_a[i].href == 'http://'+"<?php echo $_SERVER['HTTP_HOST'].'/Admin/Company/companyInfoComplete.html';?>")
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