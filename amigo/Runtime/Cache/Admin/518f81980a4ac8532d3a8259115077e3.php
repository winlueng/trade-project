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


	
<link rel="stylesheet" href="/Public/Business/BusinessCSS/companyInfo/companyInfo.css?t=1.0"></link>
    <style>
    .kbVipAdmin_alertBox form {
            /*overflow-y: scroll;*/
            height:90%;
        }
    </style>

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
	
    <div id="kbVipAdmin_rightCenter" class="spAnAdList OrderForm">
        <div class="centerTitle">
            <h1>广告列表</h1>
        </div>
        <div class="kbVipAdmin_operating" >
            <!-- <form action="" method="get" style="display:inline-block">
                    <select class="kbVipAdmin_slt w200 h30" name="correlation_id" title="可选择分类查找相关广告">
                        <option value="">广告类别</option>
                        
                    </select>
                <input type="submit" class="kbVipAdmin_opt  w80 h30" value="确认">
            </form> -->
            
            <input class="kbVipAdmin_opt kbVipAdmin_add  w80 h30 ml20 " type="button" value="添加" />
        </div>
        <div class="main-contentBox kbVipAdmin_mt24" >
            <div class="kbVipAdmin_table">
                <table>
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th width="150">广告图片</th>
                            <th>标题</th>
                            <th width="150">跳转路径</th>
                            <!-- <th>类别</th> -->
                            <th>点击量</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                        <td><?php echo ($v["id"]); ?></td>
                        <td class="kbVipAdmin_tdImg">
                            <div>
                            <img src="/Public<?php echo ($v['banner_pic']); ?>" alt="广告图片" />
                            </div>
                        </td>
                        <td class="pageT"><p><?php echo ($v["banner_title"]); ?></p></td>
                        <td class="pageT"><p><?php echo ($v["banner_url"]); ?></p></td>
                        <!-- <td>
                            <?php switch($v["correlation_id"]): case "1": ?>首页位置头部<?php break;?>    
                            <?php case "2": ?>首页位置尾部<?php break;?>    
                            <?php default: ?>优惠信息顶部<?php endswitch;?>
                        </td> -->
                        <td><?php echo ($v['visit_total']?$v['visit_total']:'0'); ?></td>
                        <td><?php echo date('Y年m月d日', $v['start_time']);?></td>
                        <td><?php echo date('Y年m月d日', $v['end_time']);?></td>
                        <td>
                            <?php if(($v['end_time'] < time())): ?><font color="#FC0070">广告已过期</font>
                            <?php else: ?>
                            <p class="kbVipAdmin_pushBtn">
                                <input type="checkbox" value="" <?php echo ($v['status'] == '0'?'checked':''); ?> title=" <?php echo ($vo['status'] == '0'?'启用':'禁用'); ?>"/>
                                <label><b></b></label>
                            </p><?php endif; ?>
                        </td>
                        <td class="kbVipAdmin_tdAction">
                            <input class="font_57c8f2 kbVipAdminEdit mb10" type="button" value="" title="编辑" />
                            <input class="font_ff6c60 kbVipAdminDel" type="button" value="" title="删除" />
                        </td>
                    </tr><?php endforeach; endif; ?>
                    </tbody>
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
    <div class="kbVipAdmin_alert spAnAdList_alert">
            <div class="kbVipAdmin_alertBox">
                <button type="button" class="kbVipAdmin_alert-close "></button>
                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="mb10">添加广告</h3>
                    <p class="kbVipAdmin_enter"><b><i>*</i>广告位置:</b>
                    <select name="banner_type" class="kbVipAdmin_slt kbVipAdmin_sltblack" 
                      required="required"
                      data-datatype="select"
                    >
                        <option value="-1">类型选择</option>
                        <option value="1">首页头部</option>
                        <option value="2">首页中部</option>
                    </select>
                    <strong class="kbVipAdmin_tip">必选项。广告banner图片出现的位置</strong>
                    </p>
                    <p class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>广告图片:</b>
                        <input id="shopImg" type="file" value="" name="banner_pic" required="required"/>
                        <label class="" for="shopImg"><span style="font-size:27px">+</span><br /><span>选择一张图片作为广告封面</span></label>
                    </p>
                    <p class="kbVipAdmin_enter"><b><i>*</i>广告标题:</b>
                    <input type="text" maxlength="20" name="banner_title" value=""  
                      required="required" 
                      data-datatype="input"
                    />
                    </p>
                    <input type="hidden" name="correlation_id" value="13">
                    <p class="kbVipAdmin_enter"><b><i>*</i>跳转路径:</b>
                    <input type="text" name="banner_url" value=""
                     required="required" 
                     data-datatype="input"

                     />
                    </p>
                    <p class="kbVipAdmin_enter"><b><i>*</i>开始时间:</b>
                    <!-- <input type="date" name="start_time" value="" required="required" /> -->
                    <input  class="datainp wicon" id="kbVipAdmin_inpstart" type="text" name="start_time" placeholder="开始日期"   readonly required="required" data-datatype="input" />
                    </p>
                    <p class="kbVipAdmin_enter"><b><i>*</i>结束时间:</b>
                    <!-- <input type="date" name="end_time" value="" required="required" /> -->
                    <input  class="datainp wicon"  type="text" name="end_time" placeholder="结束日期"   readonly required="required" data-datatype="input" />
                    </p>
                    <div class="kbVipAdmin_operating">
                        <div class="kbVipAdmin_restsubmit">
                            <input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                            <input  class="kbVipAdmin_opt w100 h40" type="submit" value="保存" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="kbVipAdmin_alert spAnAdList_alertEdit">
            <div class="kbVipAdmin_alertBox">
                <button class="kbVipAdmin_alert-close "></button>
                
                    <h3 class="mb10">编辑广告</h3>
                    <form action="" method="post" enctype="multipart/form-data">
                    <div>
                    <p class="kbVipAdmin_enter"><b><i>*</i>广告位置:</b>
                        <select name="banner_type" class="kbVipAdmin_slt kbVipAdmin_sltblack" 
                        required="required"
                        data-datatype="select"
                        >
                            <option value="-1">类型选择</option>
                            <option value="1">首页头部</option>
                            <option value="2">首页中部</option>
                        </select>
                        <strong class="kbVipAdmin_tip">必选项。广告banner图片出现的位置</strong>
                    </p>
                    <p class="kbVipAdmin_enter kbVipAdmin_fileImg"><b><i>*</i>广告图片:</b>
                        <span class="shopImg businessFileImgList">
                            <span class="cleraIMG" onclick="clearImg(this)"></span>
                            <img src=""  alt="shopImg1"/>
                        </span>
                        <input id="shopImg1"  type="file" name="banner_pic" value=""  />
                        <label class="" for="shopImg1"><span style="font-size:27px">+</span><br /><span>选择一张图片作为广告封面</span></label>
                    </p>
                    <p class="kbVipAdmin_enter"><b><i>*</i>广告标题:</b>
                    <input type="text" maxlength="18" name="banner_title" value=""
                      required="required"
                      data-datatype="input"
                      />
                    <strong class="kbVipAdmin_tip">必填项。广告标题不能为空，文字字数不能超过18个字。</strong>
                    </p>
                    <p class="kbVipAdmin_enter"><b><i>*</i>跳转路径:</b>
                    <input type="text" name="banner_url" value="" 
                       required="required"
                       data-datatype="input"
                     />
                    <strong class="kbVipAdmin_tip">必填项。若想跳转到指定的详情或者产品。需填上该详情或者产品的链接</strong>
                    </p>
                    <p class="kbVipAdmin_enter"><b><i>*</i>开始时间:</b>
                    <input  class="datainp wicon"  type="text" name="start_time" placeholder="开始日期"   readonly   
                      required="required" 
                      data-datatype="input"
                     />
                    <strong class="kbVipAdmin_tip">必填项。广告图会在开始时间之后出现</strong>
                    </p>
                    <p class="kbVipAdmin_enter"><b><i>*</i>结束时间:</b>
                    <input  class="datainp wicon"  type="text" name="end_time" placeholder="结束日期"   readonly required="required"
                    data-datatype="input"
                     />
                    <strong class="kbVipAdmin_tip">必填项。广告图会在结束时间之后出现</strong>
                    </p>
                    <div class="kbVipAdmin_operating ">
                        <div class="kbVipAdmin_restsubmit">
                            <input  class="kbVipAdmin_button_eee w100 h40 tc" type="reset" value="取消" />
                            <input  class="kbVipAdmin_opt w100 h40" type="submit" value="保存" />
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    <script type="text/javascript">
     $(function(){
        var start = {
            format: 'YYYY-MM-DD hh:mm:ss',
            minDate: '2016-06-22 23:59:59', //设定最小日期为当前日期
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
     $(function(){
        $('.spAnAdList  .kbVipAdmin_add').on('click',function(){
            $('.spAnAdList_alert').fadeIn();
            var checkData=new CheckData('.spAnAdList_alert');
            $('.spAnAdList_alert [type="submit"]').on('click',function(){
               return  checkData.verify();
            })
        });
        $('.kbVipAdmin_alert .kbVipAdmin_operating input[type="reset"]').on('click',function(){
            $('.kbVipAdmin_alert').fadeOut();
        });
        $('.spAnAdList .kbVipAdmin_tdAction .kbVipAdminEdit').on('click',function(){
            $('.spAnAdList_alertEdit').fadeIn();
            var $this = $(this);
            var ID=$this.parent().siblings().eq(0).text();
            var newDate=new Date();
            $.get("<?php echo U('ajaxControl');?>",{'flag':"selPosterInfo",'id':ID},function (res){
                    for(r in res[0]){
                        switch(r){
                            case "banner_type":
                                $('.spAnAdList_alertEdit form select[name="banner_type"]').find(' option[value="'+res[0].banner_type+'"]').prop("selected",true);
                                break;
                            case "end_time":
                                var end_time=date('Y-m-d H:m:s',res[0].end_time);
                                $('.spAnAdList_alertEdit form').find('input[name="end_time"]').val(end_time);
                                break;
                            case "start_time":
                                var start_time=date('Y-m-d H:m:s',res[0].start_time);
                                $('.spAnAdList_alertEdit form').find('input[name="start_time"]').val(start_time);
                                break;
                            case "banner_pic":
                                $('.spAnAdList_alertEdit .businessFileImgList').find('img').prop("src","/Public"+res[0].banner_pic);
                                break;
                            case "correlation_id":
                                $('.spAnAdList_alertEdit select[name="correlation_id"] option[value="'+ res[0].correlation_id +'"]').attr('selected',true);
                                break;
                                default:
                                    $('.spAnAdList_alertEdit form').find('input[name="'+r+'"]').val(res[0][r]);
                        }
                    }
                    $('.spAnAdList_alertEdit .kbVipAdmin_alertBox form').attr('action','<?php echo U("bannerUpdate");?>?id='+ID);
                });
                var checkData=new CheckData('.spAnAdList_alertEdit');
                $('.spAnAdList_alertEdit [type="submit"]').on('click',function(){
                   return  checkData.verify();
                })
            });
                
        $('.kbVipAdmin_pushBtn input').on('click',function(){
            var $this = $(this);
            
            var statusTxt=$this.siblings('label').text().replace(/(^\s+)|(\s+$)/g, "");
            var statusFlag = $this.is(':checked')? "show":"change";
            var Status=$this.is(':checked')?1:0;
            var ID = $this.parents('tr').children().eq(0).text().trim();

            $.get("<?php echo U('ajaxControl');?>",{'flag':statusFlag,'id':ID,'status':Status},function (res){
                // console.log(res)
                if(res!="更改成功"){
                    $this.attr('checked',false)
                    eTip(res)
                }else{
                    sTip(res)
                }
            });
        });
        $('.kbVipAdmin_tdAction .kbVipAdminDel').on('click',function(){
            var $this = $(this);
            var ID = $this.parent().siblings().eq(0).text(); 
            Confirm("您确定删除该广告？",function(ren){
                    if(ren){
                        $.get("<?php echo U('ajaxControl');?>",{'flag':"del",'id':ID,},function (res){
                            if (res == 1) {
                                $this.parent().parent().remove();
                            }
                            operatingTip(res?true:false);
                        });
                    }else{
                        console.log("不删除");
                    }
            });
            
        });
        $('.kbVipAdmin_enter .datainp').on('click',function(){
            // var $this=$(this);
            // var status =($this.prop("name")==="start_time")?"start": "end"; 
            // jeDateTime(this,status);

        })
        
            
     })
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

			if($('.left_nav a:eq('+i+')').attr('active') == '/Admin/ProjectBanner/bannerAdd'+'.html')
			{
				nav_a[i].parentNode.className = 'selected';
				nav_a[i].parentNode.parentNode.className = 'selectedPar';
			}
		}
	</script>
	
	
</body>
</html>