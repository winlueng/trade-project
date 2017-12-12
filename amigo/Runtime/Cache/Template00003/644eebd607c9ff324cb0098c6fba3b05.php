<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1,user-scalable=0">
    <title>阿密购商城</title>
    <link rel="shortcut icon" href="/Public/trading/images/favicon.ico">
<link rel="stylesheet" href="/Public/CSS/mbase.css" />
<link rel="stylesheet" href="/Public/tradchild/style/tradechild.css" /><!-- 与主门户css同步 -->
<link rel="stylesheet" href="/Public/tradchild/script/swiper/swiper.min.css" />
<script src="/Public/tradchild/script/zepto.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    
	<style>
		.bsSearchCare {
			width:92%;
			margin-left:auto;
			margin-right:auto;
			display:flex;
			display:-webkit-flex;
			-webkit-flex-wrap:wrap;
		}
		.bsSearchCare h2{
			text-align: left;
			-webkit-flex-basis:100%;
		}
		.bsSearchCare li{
			/*width:15%;*/
			margin-right:5%;
			padding:5px 10px;
			background-color:#eaeaea;
		    margin-bottom: 10px;
		    height: 2em;
		    line-height: 2em;
		}
		.bsSearchCare li>a{
			display:block;
			color:#999;
		}
	</style>
  <?php  ?>

</head>
<body>

	<header id="Header" class="kb_header  ">
		<form id="toSearch" action="<?php echo U('goSearch',['companyName' => $_GET['companyName']]);?>" >
		<article class="flexLayout-center kb_header">
			<nav class="kb_cell-hd w40 h">
				<a class="icon-back w h" href="javascript:javascript:history.back(-1)">
				</a>
			</nav>
			<h1 class="kb_header-title kb_cell-bd">
				<input class="kb_search icon-search bc" type="search" name="words" value=""  placeholder="请输入搜索内容" />
			</h1>
			<nav class="kb_cell-ft w40 h">
				<p class="kb_choose w">
					<input  type="submit" value="搜索">
					<label class="kb_btn">搜索</label>
				</p>
			</nav>
		</article>
		</form>
	</header>


<section id="Main" class="kb_main kb_Search kb_notFooter">
		<article >
			<aside class="searchContent">
			<br>
			 <ul id="searchbox" class=" bsReservationList bc mb10">
		     	 <li is="my-components" v-bind:Phrase="arr"  v-for="(arr, index) in arr" >
		     	 </li>
		     </ul>

			<ul class="bsSearchCare">
				<h2>历史搜索</h2>
				<?php if(is_array($historyWords)): $i = 0; $__LIST__ = $historyWords;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('goSearch',['companyName' => $_GET['companyName'], 'words' => $v]);?>"><?php echo ($v); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<br><br><br>
			<ul class="bsSearchCare">
				<h2>热门搜索</h2>
				<?php if(is_array($hotWords)): $i = 0; $__LIST__ = $hotWords;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('goSearch',['companyName' => $_GET['companyName'], 'words' => $v]);?>"><?php echo ($v); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			
			</aside>
		</article>

</section>
<script id="searchPhrase" type="text/x-template">
	<li >
		<a v-bind:href="Phrase.link">
		<p v-on:click="searchTxt">{{Phrase.name}}</p>
		</a>
	</li>
	
</script>


  


<script src="/Public/tradchild/script/vue.js"></script>
<script src="/Public/tradchild/script/alertmodule.js"></script>
<script src="/Public/tradchild/script/swiper/swiper-3.4.2.jquery.min.js"></script>
<script>
	wx.config({
      	debug: false,
      	appId: "<?php echo ($jssdk["appId"]); ?>",
      	timestamp: "<?php echo ($jssdk["timestamp"]); ?>",
      	nonceStr:  "<?php echo ($jssdk["nonceStr"]); ?>",
      	signature: "<?php echo ($jssdk["signature"]); ?>",
      	jsApiList: [
        	'checkJsApi',
        	'onMenuShareTimeline',
        	'onMenuShareAppMessage',
        	'onMenuShareQQ',
        	'onMenuShareWeibo',
        	'onMenuShareQZone',
        	'hideMenuItems',
        	'showMenuItems',
        	'hideAllNonBaseMenuItem',
        	'showAllNonBaseMenuItem',
        	'translateVoice',
        	'startRecord',
        	'stopRecord',
        	'onVoiceRecordEnd',
        	'playVoice',
        	'onVoicePlayEnd',
        	'pauseVoice',
        	'stopVoice',
        	'uploadVoice',
        	'downloadVoice',
        	'chooseImage',
        	'previewImage',
        	'uploadImage',
        	'downloadImage',
        	'getNetworkType',
        	'openLocation',
        	'getLocation',
        	'hideOptionMenu',
        	'showOptionMenu',
        	'closeWindow',
        	'scanQRCode',
        	'chooseWXPay',
        	'openProductSpecificView',
        	'addCard',
        	'chooseCard',
        	'openCard'
      	]
  	});
   
</script>
<script>
    $(function(){
      $('.icon-MoreMenu,.Cover').on('click',function(){
        $('.moreMenu').show();
      })
    })
  </script>

<script>
	$(function(){
			var Child = {
						  template: '#searchPhrase',
						  props: ['Phrase'],
						  methods:{
						  	searchTxt:function(event){
						  		console.log("event");
						  		console.log(event);
						  		var Value=(event.srcElement.outerText.length>0)?event.srcElement.outerText:event.target.innerText;
						  		$('.hd-search').val(Value);
						  		$('#toSearch').submit();
						  	}
						  }
						}
			var app=new Vue({
					components:({
					  'my-components': Child
					}),
					el:'#searchbox',
					data:{
							arr:[]
						},
					computed: {
					  // a computed getter
					  reversedMessage: function () {
					    // `this` points to the vm instance
					    return this.arr.split('').reverse().join('')
					  }
					}
					
			})
			
		$('.bsSearchCare li>a').on('click',function(){
			var $this=$(this),
				searchVal=$this.text().trim();
			$('#bsHeader').find('.hd-search').val(searchVal);
			searchResult(searchVal);
		})
		$('.kb_header .kb_search').on('input propertychange',function(){
			$('.bsReservationList').siblings().show;
			var $this=$(this),
				Value=$this.val();
			if($this.val().length==0){
				$('.bsReservationList').siblings().hide();
			 }
			searchResult($this.val(),function(res){
				// 搜索出来的数据
				if(res.length>0){
					app.arr=res;
				}else{
					app.arr=[{name:"暂无该搜索商品"}];
				}
			})
		})

		function insert_flg(str,flg,sn){
		    var newstr="";
		    for(var i=0;i<str.length;i+=sn){
		        var tmp=str.substring(i, i+sn);
		        newstr+=tmp+flg;
		    }
		    return newstr;
		}
		function searchResult(text,callback){
			var callback = callback ? callback:"callback";
			$.get('<?php echo U("Search/ajaxControl");?>',{
				flag:"getCorrelation",
				correlation:text
				// companyName: '<?php echo ($_GET["companyName"]); ?>'
			},function(res){
				callback(res);
				
			})
		}
	})
</script>


  <script>
    wx.ready(function(){
        wx.onMenuShareAppMessage({
           title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
           desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
           link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
           imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
           type: '', // 分享类型,music、video或link，不填默认为link
           dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
           success: function () { 
               // 用户确认分享后执行的回调函数
               console.log("asdasdasd");
           },
           cancel: function () { 
               // 用户取消分享后执行的回调函数
           }
       });
         wx.onMenuShareTimeline({
           title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
           link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
           imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
           success: function () { 
               // 用户确认分享后执行的回调函数
           },
           cancel: function () { 
               // 用户取消分享后执行的回调函数
           }
       });
         wx.onMenuShareQQ({
           title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
           desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
           link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
           imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
             success: function () { 
                // 用户确认分享后执行的回调函数
             },
             cancel: function () { 
                // 用户取消分享后执行的回调函数
             }
         });
         wx.onMenuShareQZone({
              title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
           desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
           link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
           imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
             success: function () { 
                // 用户确认分享后执行的回调函数
             },
             cancel: function () { 
                 // 用户取消分享后执行的回调函数
             }
         });
         wx.onMenuShareWeibo({
              title: '<?php echo ($companyInfo["company_name"]?$companyInfo["company_name"]:"阿密购商城"); ?>', // 分享标题
           desc: '欢迎光临Imigo阿密购商城，这里有您想要的一切优质实惠商品', // 分享描述
           link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
           imgUrl: 'http://www.chinaimigo.com/Public/trading/images/kblogo.jpg', // 分享图标
             success: function () { 
                // 用户确认分享后执行的回调函数
             },
             cancel: function () { 
                 // 用户取消分享后执行的回调函数
             }
         });
     });
  </script>

</body>
</html>