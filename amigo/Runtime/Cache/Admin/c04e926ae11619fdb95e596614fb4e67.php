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


	
    <link rel="stylesheet" href="/Public/Portal/PortalCSS/coupon/coupon.css">
    <style>
        .marketUser_form-box{
            margin-bottom:100px;
        }
        .userAreaSlt select{
            width:120px;
        }
    </style>
     <script type="text/javascript">
       $(function(){ 
            $('.kbVipAdmin_fileImg input[type="file"]').on('change',function(){
                if ( typeof(FileReader) === 'undefined' ){ 
                    alert("抱歉，你的浏览器不支持 FileReader，推荐使用谷歌浏览器操作！"); 
                    this.setAttribute( 'disabled','disabled' ); 
                } else { 
                    readFile(this,this.files[0]);
                } 
            })
        });
    
    </script>

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
	
    <div id="kbVipAdmin_rightCenter" class="couponAdClass_center">
       <div class="centerTitle">
                 
          <h1>商家进驻</h1>
       </div>
    <div class="spAnProductAdd kbVipAdmin_box">
        <form class="userAdmin_center-addUser kbVipAdmin_form" action="<?php echo U('Company/companyAdd');?>" method="post" enctype="multipart/form-data">
        <div class="marketUser_form-box">
            <p class="kbVipAdmin_enter">
                <b>商户编号：</b>
                <input type="text" name="user_ip" placeholder="请输入商户编号" /> 
                <strong class="kbVipAdmin_tip">选填项, 请输入商户编号</strong>
            </p>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>域名后缀：</b>
                <input type="text" name="web_postfix" required="required" placeholder="请填写域名后缀,商户官网以唯一后缀进入" />
                <strong class="kbVipAdmin_tip">必填项。请填写域名后缀,商户官网以唯一后缀进入</strong>
            </p>
            <div class="kbVipAdmin_fileImg kbVipAdmin_enter">
                <b><i>*</i>商户营业执照：</b>
                
                <input id="businessFileImg" type="file" name="business_license" required="required" />
                <label class="" for="businessFileImg">
                    <span style="font-size:27px">+</span><br />
                    <span>请上传商户营业执照</span>
                </label>
                <strong class="kbVipAdmin_tip">请上传商户营业执照，图片格式为png、jpg；不大于200k</strong>
            </div>
            <div class="kbVipAdmin_fileImg kbVipAdmin_enter">
                <b><i>*</i>商户身份证正面：</b>
                
                <input id="businessFileImg2" type="file" name="person_code_front" required="required" />
                <label class="" for="businessFileImg2">
                    <span style="font-size:27px">+</span><br />
                    <span>请上传商户身份证正面</span>
                </label>
                <strong class="kbVipAdmin_tip">请上传商户身份证正面，图片格式为png、jpg；不大于200k</strong>
            </div>
            <div class="kbVipAdmin_fileImg kbVipAdmin_enter">
                <b><i>*</i>商户身份证反面：</b>
                
                <input id="businessFileImg3" type="file" name="person_code_rear" required="required" />
                <label class="" for="businessFileImg3">
                    <span style="font-size:27px">+</span><br />
                    <span>请上传商户身份证反面</span>
                </label>
                <strong class="kbVipAdmin_tip">请上传商户身份证反面，图片格式为png、jpg；不大于200k</strong>
            </div>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>邮箱：</b>
                <input type="email" name="email" required="required" placeholder="请输入邮箱地址" />
                <strong class="kbVipAdmin_tip">必填项。请输入电子邮箱地址</strong>
            </p>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>联系人：</b>
                <input type="text" name="principal" required="required" placeholder="请输入店铺负责人姓名" />
                <strong class="kbVipAdmin_tip">必填项。请输入店铺负责人姓名</strong>
             </p>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>手机号码：</b>
                <input type="tel" name="phone" required="required" 
                 minlength="11" maxlength="11" placeholder="请输入店铺负责人联系手机号码" />
                <strong class="kbVipAdmin_tip">必填项。请输入店铺负责人联系手机号码</strong>
            </p>
            <p class="kbVipAdmin_enter"><b><i>*</i>店铺名称：</b>
                <input type="text" name="company_name" required="required" placeholder="请输入店铺名称" /> 
                <strong class="kbVipAdmin_tip">必填项。请输入店铺名称</strong>
            </p>
            <div class="couponAddr userAreaSlt kbVipAdmin_enter">
                <b><i>*</i>商户区域：</b>
                <select class="" required="required" >
                    <option value="-1">--请选择区域--</option>
                    <?php if(is_array($region)): foreach($region as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["region_name"]); ?></option><?php endforeach; endif; ?>
                </select>
                <strong class="kbVipAdmin_tip">必填项。请选择商户区域</strong>
            </div>
            <div class="couponAddr userTradeSlt kbVipAdmin_enter">
                <b><i>*</i>行业：</b>
                <select class="" required="required" name="business_id">
                    <option value="-1">请选择行业</option>
                </select>
                <!-- <p class='userAreaSltChild'></p> -->
                <strong class="kbVipAdmin_tip">必填项。需先选择商户区域才能商户行业</strong>
            </div>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>店铺编号：</b>
                <input type="text" name="address_info" required="required" placeholder="请输入店铺编号" /> 
                <strong class="kbVipAdmin_tip">必填项。请输入店铺编号</strong>
            </p>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>开始时间：</b>
                <input class="datainp wicon" id="kbShopAdmin_inpstart" type="text" name="start_time" placeholder="服务开始日期" readonly="" required="required">
                <strong class="kbVipAdmin_tip">必填项。鼠标左键双击输入框选择服务开始日期</strong>
            </p>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>结束时间：</b>
                <input class="datainp wicon" id="kbShopAdmin_inpstart" type="text" name="end_time" placeholder="服务结束日期" readonly="" required="required">
                <strong class="kbVipAdmin_tip">必填项。鼠标左键双击输入框选择服务结束日期。结束日期不能小于开始日期</strong>
            </p>
            <p class="kbVipAdmin_enter">
                <b><i>*</i>合同签订日期：</b>
                <input class="datainp wicon" id="kbShopAdmin_inpstart" type="text" name="addtime" placeholder="合同签订日期" readonly="" required="required"> 
            </p>
           <div class="kbVipAdmin_operating tc">
                <input  class="w200 h40 f16 kbVipAdmin_opt bc" type="submit" value="保存" />
            </div>
        </div>
        </form>
    </div>
    </div>
    
    </div>
    <script type="text/javascript">
        $(function(){
            // 日期插件
              var start_time = {
                format: 'YYYY-MM-DD hh:mm:ss',
                minDate: '2016-01-01 00:00:00', //设定最小日期为当前日期
                festival:true,
                //isinitVal:true,
               // maxDate: $.nowDate(0), //最大日期
                choosefun: function(elem,datas){
                    end_time.minDate= datas; //开始日选好后，重置结束日的最小日期
                    checkData(elem);
                },
           
            };
            var end_time = {
              format: 'YYYY-MM-DD hh:mm:ss',
              minDate: $.nowDate(0), //设定最小日期为当前日期
              festival:true,
              //isinitVal:true,
              //maxDate: '2099-06-16 23:59:59', //最大日期
              choosefun: function(elem,datas){
                 start_time.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
                 checkData(elem);
              }
            };
            $('input.datainp[name="start_time"]').jeDate(start_time);
            $('input.datainp[name="end_time"]').jeDate(end_time);
            $('input.datainp[name="addtime"]').jeDate(start_time);
            // $('input.datainp[name="start_time"]').jeDate(start_time.choosefun());
        })
        $(function(){

            $('.addCouponAreaList ').on('click',function(){
                $('.couponAreaList_alert').fadeIn();
            })
            $('.couponAreaListWirte ').on('click',function(){
                $('.couponAreaList_alertWriter').fadeIn();
            })
            $('.kbVipAdmin_MenuAdminBtn').on('click',function(){
                checkData('.kbVipAdmin_center_tables',function(ren){
                });
            })
            $('.kbVipAdmin_center_tables form [required="required"]').bind('change blur',function(){
                checkData(this);
                
            })
             $('.userAreaSlt select').on('change',function(){
                var $this = $(this);
                var options=$this.children('option:selected');
                var optionsVal=options.val();
                var ajaxUrl='<?php echo U("Goods/ajaxControl");?>';

                $('select[name=business_id]').children().not('option[value=-1]').remove();//区域选择有变动时，清除行业选择内容
                 userAreaSltChild(this,ajaxUrl);
              
               
            });/*userAreaSlt select end */
            $('#kbVipAdmin_center').find('[required="required"]').on('blur change',function(){
                checkData(this);
            })
            $('#kbVipAdmin_center').find('[type="submit"]').on('change',function(){
                var sStatus = false;
                       var $this=$(this);
                       var thisParent=$this.parents('form').parent();
                         checkData(thisParent,function(ren){
                            sStatus=ren;
                         });
                         //数据正确则提交
                         return sStatus;
            })

        })
        
        // 查询数据唯一
        // 错误
         function checkOnly(_this,callback){
          var onlyDate = $(_this).val();
          var onlyName = $(_this).prop('name');
          var status='Error';
             $.ajax({
                type: "get",
                async: false,
                dataType: "json",
                url: '<?php echo U("User/ajaxControl");?>',
                data: {'flag':"selUserAddBefore",'key':onlyName,data:onlyDate},
                success: function(response) {
                    status=(response===true)?'Proper':'Error';
                    console.log(status);
                },
                error: function() {
                
                }
            });
             return status;
            
        }
        
    </script>

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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/Company/companyAdd'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>