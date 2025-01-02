/**
 * 
 * @authors lixiuhuang@meilishuo.com
 * @date    2015-10-13 19:11:51
 * @version _v=0.0.1
 */

/*$('.span1').each(function (){
	$(this).css('height' , $(this).parent('.code').height() + 'px');
})*/
function init(){
	var checkWayHiddenVal = $('#checkWayHidden').val();
	if(checkWayHiddenVal != ''){
		$('.show-box').eq(checkWayHiddenVal-1).show().siblings('.show-box').hide();
		$('.checkWay-radio').eq(checkWayHiddenVal-1).addClass('mychecked').siblings().removeClass('mychecked');
		$('.checkWay-radio').eq(checkWayHiddenVal-1).find('input').attr('checked','checked').end().siblings().find('input').removeAttr('checked');
	}
	//alert(checkWayHiddenVal);	
}
init();

function check_code(obj, cName){
    var checkboxs = document.getElementsByName(cName);
    var classNmae = 'mychecked';

    if (obj.checked) {
    	for(var i=0; i<checkboxs.length; i++) {
    		checkboxs[i].checked = obj.checked;
    		checkboxs[i].parentNode.parentNode.setAttribute('class' , classNmae + ' radio');
    	}
    	obj.parentNode.parentNode.setAttribute('class' , classNmae + ' radio');
    }
    else {
    	for(var i=0; i<checkboxs.length; i++) {
    		checkboxs[i].checked = obj.checked;
    		checkboxs[i].parentNode.parentNode.setAttribute('class' , 'radio');
    	}
    	obj.parentNode.parentNode.setAttribute('class' , 'radio');
    }

    dashboardSemanticMonitorCharts();
}

$('.radioSemanticMonitor').on('click' , function (){
	if($(this).hasClass('mychecked')){
		$(this).removeClass('mychecked');
		$(this).find('input').removeAttr('checked');
	}else{
		$(this).addClass('mychecked');
		$(this).find('input').attr('checked','checked');
	}
	dashboardSemanticMonitorCharts();
})

//监控方式切换  单选
$('.checkWay-radio').on('click' , function (){
	var index = $(this).index();
	$(this).addClass('mychecked').siblings().removeClass('mychecked');
	$(this).find('input').attr('checked','checked').end().siblings().find('input').removeAttr('checked');
	$('.show-box').eq(index-1).show().siblings('.show-box').hide();
	$('#checkWayHidden').val(index);
	//$('.span1').css('height' ,$('.show-box:visible').find('.code').height() + 'px');
	dashboardSemanticMonitorCharts();
})

function dashboardSemanticMonitorCharts(){
	var default_graph_type  = 'h';    // 默认为"机器视角"
	var taskNamelen         = $("input[name='taskName[]']:checked").length;         // 域名
	var sendUrlAndParamslen = $("input[name='sendUrlAndParams[]']:checked").length; // URL
	var statusCodeLen       = $("input[id='checkTypeStatusCode']:checked").length;  // 状态码
	var textContentLen      = $("input[id='checkTypeTextContent']:checked").length; // 正文内容
	var timeTotalLen        = $("input[id='checkTypeTimeTotal']:checked").length;   // 响应时间
	var checkTypeLen        = $("input[name='checkType[]']:checked").length;        // 类型
	var checkFromIdcLen     = $("input[name='checkFromIDC[]']:checked").length;     // 机房

	if ((sendUrlAndParamslen > 0) && (checkTypeLen > 0) && (checkFromIdcLen > 0)) {
		var checked_items_arr     = new Array();
		var checked_hosts_arr     = new Array();           // 机器
		var checked_task_name_arr = new Array();           // 域名
		var checked_send_url_and_params_arr = new Array(); // URL
		var checked_metric_arr    = new Array();           // 类型(监控项)
		var checked_from_idc_arr  = new Array();           // 机房
		var checked_str = '';
		$("input[name='fixedSemanticMonitorHost[]']:checked").each(function() {
			var fixedSemanticMonitorHost = $(this).val();
			if (fixedSemanticMonitorHost.indexOf('.meilishuo.com') == -1) {
				fixedSemanticMonitorHost += '.meilishuo.com';
			}
			checked_hosts_arr.push(fixedSemanticMonitorHost);
			//checked_hosts_arr.push(fixedSemanticMonitorHost);
		});

		//$("input[name='taskName[]']:checked").each(function() {
		//	var taskName = $(this).val();
		//	checked_str  = 'task_name=' + taskName;
		//	checked_task_name_arr.push(checked_str);
		//});
		var check_way_val = $("input[name='checkWay[]']:checked").val();
		//console.log(check_way_val);
		$("input[name='sendUrlAndParams[]']:checked").each(function() {
			var sendUrlAndParams = $(this).val();
			if(check_way_val == 'PING'){
				checked_str          = 'target=' + sendUrlAndParams;
			}else{
				checked_str          = 'url=' + sendUrlAndParams;
			}			
			checked_send_url_and_params_arr.push(checked_str);
		});

		$('.show-box:visible').find($("input[name='checkType[]']:checked")).each(function() {
			var checkType = $(this).val();
			checked_str   =  checkType;
			checked_metric_arr.push(checked_str);
		});

		$('.show-box:visible').find($("input[name='checkFromIDC[]']:checked")).each(function() {
			var checkFromIDCShortName = $(this).val();
			checked_str = 'idc=' + checkFromIDCShortName;
			checked_from_idc_arr.push(checked_str);
			//console.log($('.show-box:visible').find($("input[name='checkFromIDC[]']:checked")).length);
		});

		for (var metric_index in checked_metric_arr) {
			var metric = checked_metric_arr[metric_index];
			for (var idc_index in checked_from_idc_arr) {
				var idc = checked_from_idc_arr[idc_index];
				for (var url_index in checked_send_url_and_params_arr) {
					var url          = checked_send_url_and_params_arr[url_index];
					if ((metric == "request_count") || (metric == "error_statuscode_rate"))
					{
						url = url.replace('https://', '');
						url = url.replace('http://', '');
						var urlSegArr = url.split(/[?\/\s+]/);
						url = urlSegArr[0];
						url = 'service_type=lvs,' + url;
					}
					var checked_item = metric + "/" + idc + "," + url;
					checked_items_arr.push(checked_item);
				}
			}
		}
		
		$.ajaxSetup({  
			async : true  
	    });
		$.ajax({
	        url: commitUrl,
	        dataType: "json",
	        method: "POST",
	        data: { "endpoints": checked_hosts_arr, "counters": checked_items_arr, "graph_type": default_graph_type, "_r": Math.random()},
	        success:function(ret){		        		
		        	if (ret.ok) {
		        		//console.log(ret.id);
		            	dashboarChartsUrl = "http://dashboard.falcon.meiliworks.com/charts?id="+ret.id+"&graph_type="+default_graph_type;
			    		$("#Frame_dashboarCharts").attr("src", dashboarChartsUrl);
			    		$('#Frame_dashboarCharts').show();
		            }else {
		                console.log("返回状态出错了");
	            }
	        },
	        error:function(ret){
	        		console.log("请求出错了");
	        }
	    });	
	}
}
//选中项动画
var machineNum = 0;
function machineMoveBox(obj) {   
    var divTop = $(obj).offset().top;
    var divLeft = $(obj).offset().left;
    $(obj).css({ "position": "absolute", "z-index": "0", "left": divLeft + "px", "top": divTop -120 + "px" });
    $(obj).animate({ "left": ($("#posBtnRmachine").offset().left -20) + "px", "top": $("#posBtnRmachine").offset().top -120 + "px", "width": "100px", "height": "30px"}, 500, function () {
        $(obj).animate({ "left":($("#posBtnRmachine").offset().left -20) + "px", "top": $("#posBtnRmachine").offset().top -120 + "px" , "opacity":"0", "width": "30px" }, 300);
    });
    machineNum ++;
    $('#posBtnRmachine b').html(machineNum);
    var Timer =null;
    	function remainTime(){ 
    		$(obj).removeAttr('style');
    	 	$(obj).appendTo('#selectMachineUl ul');  	 
    	 	$('#noSelectTextRmachine').hide();
    	 	
    } 
    	Timer= setTimeout(function(){
    		remainTime();
    	},1000);   
} 
//选择域名
$('#sendUrlAndParamsList').delegate('li' , 'click' , function (event) {
	machineMoveBox(this);
    $(this).addClass('select');
    $(this).find('.delete-btn').show();
    $(this).find('input').prop('checked' , 'checked');
    dashboardSemanticMonitorCharts ();	  
})
//查看所选域名
$('#posBtnRmachine').on('click' , function (){
	$('#selectMachineUl li').removeAttr('style');
	$(this).hide()
	$('#selectMachineUl').show();
	$('#machineUl').hide();
	$('#AllBtn').hide();
	$('#clearBtnRmachine').show();
	$('#backBtnRmachine').show();
	var liLen = $('#selectMachineUl li').length;
    if(liLen == 1){
    		$('#noSelectTextRmachine').show();
    }else{
    	$('#noSelectTextRmachine').hide();
    }
})
//返回域名列表
$('#backBtnRmachine').on('click' , function (){
	$(this).hide()
	$('#selectMachineUl').hide();
	$('#machineUl').show();
	$('#AllBtn').show();
	$('#clearBtnRmachine').hide();
	$('#posBtnRmachine').show();
})
//清空已选域名
$('#clearBtnRmachine').on('click' , function (){
	machineNum = 0;
	$('#noSelectTextRmachine').show();
	$('#selectMachineUl li').find('.delete-btn').hide();
	$('#selectMachineUl li').removeClass('select');
	$('#selectMachineUl li').find('input').prop('checked' , '');
	$('#selectMachineUl li').not('#noSelectTextRmachine').appendTo('#machineUl .ul-list');
	$('#AllBtn span').text('全选');  
	$('#posBtnRmachine b').html(machineNum);
	$('#noSelectTextRmachine').show();
	dashboardSemanticMonitorCharts ();	 
	$('#allChecked').prop('checked' , '');
})
 //删除所选域名
$('#selectMachineUl').delegate('li','click' , function (event){    		
	machineNum --;
    $(this).find('img').hide();
    $(this).removeClass('select');
    $(this).find('input').prop('checked' , '');
    $(this).appendTo('#sendUrlAndParamsList');
    $('#posBtnRmachine b').html(machineNum);
    dashboardSemanticMonitorCharts ();
});
//全选域名
$("#allChecked").click(function() {
    	if($("#allChecked").prop("checked")=="checked"||$("#allChecked").prop("checked")==true)
    	{ 
    		$('.ul-list li').addClass('select');
    		$('.ul-list li').find('.delete-btn').show();
    		$('.ul-list li').find('input').prop('checked' , 'checked');
    		$('.ul-list li').appendTo('.myselect');
    		$('#AllBtn span').text('反选');
    		machineNum = $('.myselect li').length -1;
    		$('#posBtnRmachine b').html(machineNum);
    		dashboardSemanticMonitorCharts ();
    	}else {			
    		$('.myselect li').find('.delete-btn').hide();
    		$('.myselect li').removeClass('select');
    		$('.myselect li').find('input').prop('checked' , '');
    		$('.myselect li').not('#noSelectTextRmachine').appendTo('.ul-list');
    		$('#AllBtn span').text('全选');
    		machineNum = 0;
    		$('#posBtnRmachine b').html(machineNum);
    	}	    		
})
//搜索域名	    	
$("#machineListSearchBtn").on('click',function(event) { 
	 event.stopPropagation();
	 event.preventDefault();		
	var keyword = $('#machineListSearchKey').val();
	if(keyword != ""){   
		$('.cont-left .load-text').show();
		$('.search-error').hide();
      	$("#machineUl li").each(function(index){
  	    	    var textVal = $(this).text();  	    	  						
	    	  	if(textVal.indexOf(keyword) >= 0) {
	    	  		$(this).show();	
	    	  	}else{
	    	  		$(this).hide();
	    	  	}
	    	  	if (index == $("#machineUl li").length -1){
	    	  		$('.cont-left .load-text').hide();
	    	  	}
        });
      	var visibleObjLength = $(".list-div li:visible").length;
      	if(visibleObjLength == 0 ){
      		//alert('没有匹配的机器');
      		$('.search-error').show();
      	}
	}else{
		$("#machineUl li").show();	  		  				
  	}	    		             	 
 });
//选择域名分类
$('#templateType li').on('click' , function (){
	var thisVal = $(this).text();
	$('#taskNameSearchKey').val(thisVal);
	if(thisVal == '全部'){
		$('#taskNameSearchKey').val('');
	}
	$('#taskNameForm').submit();
})

window.parent.clickPage("MF_ASE_dashboardSemanticMonitor");	
window.parent.changeMTree();

