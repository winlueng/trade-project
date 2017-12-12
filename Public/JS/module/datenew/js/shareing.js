
/**
 * Created with PyCharm.
 * User: Administrator
 * Date: 14-9-11
 * Time: 上午11:18
 * To change this template use File | Settings | File Templates.
 */
/* 共用 js 模块 *

/* 时间插件 使用 */
(function($){
    $.setStartTime = function(){
        $('.startDate').datepicker({
            dateFormat: "yy/mm/dd ",
            // minDate: "+d",
            onClose : function(dateText, inst) {
                $( "#endDate" ).datepicker( "show" );
            },
			onSelect:function(dateText, inst) {
                $( "#endDate" ).datepicker( "option","minDate",dateText );
            },
        });
    };
    $.setEndTime = function(){
        $(".endDate").datepicker({
            dateFormat: "yy/mm/dd ",
            // maxDate: "+d",
			defaultDate : new Date(),
            onClose : function(dateText, inst) {
                if (dateText < $("input[name=startDate]").val()){
                  $( "#endDate" ).datepicker( "show" );
				    alert("结束日期不能小于开始日期！");
					//$("#endDate").val(newdate)
                }
            }
        });
    };
    $.date = function(){
        $('.date').datepicker(
            $.extend({showMonthAfterYear:true}, $.datepicker.regional['zh-CN'],
                {'showAnim':'','dateFormat':'yy/mm/dd','changeMonth':'true','changeYear':'true',
                    'showButtonPanel':'true'}
            ));
    };
    $.datepickerjQ = function(){
       $(".ui-datepicker-time").on("click",function(){
           var $this=$(this),
                sPosition=$this.position();
            if(sPosition.top<2){
                sPosition=$this.offset();
            }
           $(".ui-datepicker-css").css({top:sPosition.top+28+"px",left:sPosition.left+"px",display:"block"});

        });
        $(".ui-kydtype li").on("click",function(){
            $(".ui-kydtype li").removeClass("on").filter($(this)).addClass("on");
//            getAppCondtion();
        });
        $(".ui-datepicker-quick input").on("click",function(){
            var thisAlt = $(this).attr("alt");
            var dateList = timeConfig(thisAlt);
            $(".ui-datepicker-time").val(dateList);
            // dateList
            console.log(dateList);
            var start,end;
            var newDate=dateList.split('一').map(function(elem,indexs,arr){
                return elem;
            })
            console.log(new Date().getMilliseconds())
               start=Date.parse(new Date(newDate[0]))/1000;
               end=Date.parse(new Date(newDate[1]))/1000;
            $(".ui-datepicker-time").siblings('.start').val(start);
            $(".ui-datepicker-time").siblings('.end').val(end);
            $(".ui-datepicker-css").css("display","none");
			$("#ui-datepicker-div").css("display","none")
//            getAppCondtion()
        });
        $(".ui-close-date").on("click",function(){
            $(".ui-datepicker-css").css("display","none")
			 $("#ui-datepicker-div").css("display","none")
			//inst.dpDiv.css({"display":"none"})
        });
		 $(".startDate").on("click",function(){
            $(".endDate").attr("disabled",false);
        });
    }
})(jQuery);

$(function(){
        $.setStartTime();
        $.setEndTime();
        $.datepickerjQ();
        var nowDate = new Date();
        timeStr = nowDate.getFullYear() + '/' + (nowDate.getMonth()+1) + '/' + nowDate.getDate();
        nowDate.setDate(nowDate.getDate()+parseInt(-1));
        var endDateStr = nowDate.getFullYear() + '/'+  (nowDate.getMonth()+1) + '/' + nowDate.getDate();
		// $(".ui-datepicker-time").attr("value",endDateStr +"—"+ timeStr)
		 $("#startDate").attr("value",endDateStr)
		 $("#endDate").attr("value",timeStr)
    });


    function timeConfig(time){
		//快捷菜单的控制
        var nowDate = new Date();
        timeStr =nowDate.getFullYear() + '/' + (nowDate.getMonth()+1) + '/' + nowDate.getDate()+ '一';
        nowDate.setDate(nowDate.getDate()+parseInt(time));
        var endDateStr = nowDate.getFullYear() + '/'+  (nowDate.getMonth()+1) + '/' + nowDate.getDate();
        if(time == 0){
            endDateStr +='一'+endDateStr+" "+"23:59:59";
        }else{
            endDateStr =timeStr+endDateStr+" "+"23:59:59";
        }
        return endDateStr;
    }

    function datePickers(){
		//自定义菜单
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var dateList = startDate +'一'+ endDate;
        $(".ui-datepicker-time").val(dateList);
        var start=Date.parse(new Date(startDate))/1000
        var end=(Date.parse(new Date(endDate))+23*60*60*1000+59*60*1000+59*1000)/1000
        $(".ui-datepicker-time").siblings('.start').val(start);
        $(".ui-datepicker-time").siblings('.end').val(end);
        $(".ui-datepicker-css").css("display","none");
//        getAppCondtion()
    }