/**
 * 
 * @authors lixiuhuang@meilishuo.com
 * @date    2015-12-11 11:09:12
 * @version 1.1.0
 */

(function () {
	
	var searchFaild = false; 
    var para = new Object();
	var counterCpuArr     = [],    //cpu数组
		counterDiskArr    = [],   //磁盘数组
		counterMemArr     = [],	  //内存数组
		counterNetArr     = [],	  //网卡数组 
		counterPortArr    = [],  //端口
		counterProcArr    = [],   //进程
		counterOtherArr   = [], //其他
		counterDefaultArr = ['fan-status/fan=memb0-fan1'];//常用   
    var i    = 0;
	var html = '';
	var str  = '';
	var queryedCountersAll = new Array();
	var queryedServerClusterAll = new Array();
	var queryedCounters = new Array();
	var machine_name_list = '';
	var metric_name_list =  '';
	var server_cluster_list =  '';
	var checked_hosts = new Array();
	var checked_server_cluster = new Array();
	var checked_items = new Array();
	var default_graph_type = 'h';
	
	//获取监控
    function machineParam (obj) {
		 queryedCountersAll = [];
		 machine_name_list =  $("input[name='machine_name_list']:checked").length;
		 server_cluster_list =  $("input[name='server_cluster_list']:checked").length;		 
		var searchMetricVal = $.trim($("#metricSearchKey").val());		
		var dashboarChartsUrl = '';
		if (machine_name_list > 0 || server_cluster_list > 0 ) {
			checked_hosts = new Array();
			$("input[name='machine_name_list']:checked").each(function(){
				var host_fullname = $(this).val();
				/*if (host_fullname.indexOf('.meilishuo.com') == -1) {
					host_fullname += '.meilishuo.com';
				}*/
				checked_hosts.push(host_fullname);	
			});			
			if(obj){
				$.ajaxSetup({  
					async : false  
			    });
				$.ajax({
			        url: requestFnCountersUrl,
			        dataType: "json",
			        method: "POST",
			        data: {"endpoints": checked_hosts, "q": searchMetricVal, "limit": 100000, "_r": Math.random()},
			        success:function(ret){		        		
			            if(ret.ok){
			            		searchFaild = false;
				            	var counter_items = ret.data;
				            	for (var item in counter_items) {
				                	var counter = counter_items[item];
				                	queryedCountersAll.push(counter[0]);
				                }
				            	queryedCounters = _.uniq(queryedCountersAll);
				            //	console.log(queryedCounters);
				           // 	queryedCounters = unique(queryedCountersAll) ;
				            	metricClassifying ()  //调用监控项分类方法
				            	$('.load-text').hide();
			            }else{
			                console.log("搜索失败：" + ret.msg);
			                $('.load-text').hide();
			                searchFaild = true;
			                return false;
			            }
			        },
			        error:function(ret){
			        		$('.load-text').hide();
			        		console.log('出错了');
			        		searchFaild = true;
			        }
			    });	
			}else{
				$.ajaxSetup({  
					async : true  
			    });
				$.ajax({
			        url: requestFnCountersUrl,
			        dataType: "json",
			        method: "POST",
			        data: {"endpoints": checked_hosts, "limit": 100000, "_r": Math.random()},
			        success:function(ret){		        		
			            if(ret.ok){		
				            	var counter_items = ret.data;
				            	for (var item in counter_items) {
				                	var counter = counter_items[item];
				                	queryedCountersAll.push(counter[0]);
				                }
				            	queryedCounters = _.uniq(queryedCountersAll);
				           // 	queryedCounters = unique(queryedCountersAll) ;
				            	//console.log(queryedCounters);
				            	metricClassifying ()  //调用监控项分类方法
				            	$('.load-text').hide();
			            }else{
			                console.log("搜索失败：" + ret.msg);
			                $('.load-text').hide();
			                searchFaild = true;
			                return false;
			            }
			        },
			        error:function(ret){
			        		$('.load-text').hide();
			        		alert('出错了');
			        		searchFaild = true;
			        }
			    });
			}	
			function metricClassifying (){
				//监控数据分数组	
				counterCpuArr     = [],    //cpu数组
				counterDiskArr    = [],   //磁盘数组
				counterMemArr     = [],	  //内存数组
				counterNetArr     = [],	  //网卡数组 
				counterPortArr    = [],  //端口
				counterProcArr    = [],   //进程
				counterOtherArr   = []; //其他
				//console.log('这里是：'  + queryedCounters)
			    for (var item in queryedCounters) {			    		
			        	var counterName = queryedCounters[item];	  
			        	counterOtherArr.push(counterName);
			      /*  	if (counterName.toLowerCase().indexOf("cpu") == 0) {		        		
			        		counterCpuArr.push(counterName);		        		
			        	}else if ((counterName.toLowerCase().indexOf("disk") == 0) || (counterName.toLowerCase().indexOf("df") == 0)) {
			        		counterDiskArr.push(counterName);
			        	}else if (counterName.toLowerCase().indexOf("mem") == 0) {
			        		counterMemArr.push(counterName);
			        	}else if (counterName.toLowerCase().indexOf("port") == 0 || counterName.toLowerCase().indexOf("net.port") == 0 ) {
			        		counterPortArr.push(counterName);
			        	}else if (counterName.toLowerCase().indexOf("net") == 0) {
			        		counterNetArr.push(counterName);
			        	}else if (counterName.toLowerCase().indexOf("proc") == 0) {
			        		counterProcArr.push(counterName);
			        	}else {
			        		counterOtherArr.push(counterName);
			        	}*/		        	
			    }
			}	
		}
	}
	 //选择ip
    $('#machineListUl').delegate('li' , 'click' , function (event) {
    		machineMoveBox(this);
	    $(this).addClass('select');
	    $(this).find('.delete-btn').show();
	    $(this).find('input').prop('checked' , 'checked');
	    machineParam (false);	 
	    var metric_name_list =  $("input[name='metric_name_list']:checked").length;
	    if(metric_name_list > 0){
	    		templateParam ();
	    }
    })
    
    //删除所选ip
    $('#selectMachineUl').delegate('li','click' , function (event){    		
    		machineNum --;
	    $(this).find('img').hide();
	    $(this).removeClass('select');
	    $(this).find('input').prop('checked' , '');
	    $(this).appendTo('#machineListUl');
	    $('#posBtnRmachine b').html(machineNum);
	    machineParam ();
	    var metric_name_list =  $("input[name='metric_name_list']:checked").length;
	    if(metric_name_list > 0){
	    		templateParam ();
	    }
    });
    
  //查看所选ip
    $('#posBtnRmachine').on('click' , function (){
    		$('#selectMachineUl li').removeAttr('style');
    		$(this).hide()
    		$('#selectMachineUl').show();
    		$('.ul-list').hide();
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
    //返回ip列表
    $('#backBtnRmachine').on('click' , function (){
    		$(this).hide()
		$('#selectMachineUl').hide();
		$('.ul-list').show();
		$('#AllBtn').show();
		$('#clearBtnRmachine').hide();
		$('#posBtnRmachine').show();
    })
    //清空已选ip
    $('#clearBtnRmachine').on('click' , function (){
    		machineNum = 0
    		$('#noSelectTextRmachine').show();
    		$('.myselect li').find('.delete-btn').hide();
		$('.myselect li').removeClass('select');
		$('.myselect li').find('input').prop('checked' , '');
		$('.myselect li').not('#noSelectTextRmachine').appendTo('.ul-list');
		$('#AllBtn span').text('全选');  
		$('#posBtnRmachine b').html(machineNum);
		$('#noSelectTextRmachine').show();
		machineParam ();	 	
		$('#allChecked').prop('checked' , '');
    })
    
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
	    		machineParam ();
	    		templateParam ();
	    	}else {			
	    		$('.myselect li').find('.delete-btn').hide();
	    		$('.myselect li').removeClass('select');
	    		$('.myselect li').find('input').prop('checked' , '');
	    		$('.myselect li').not('#noSelectTextRmachine').appendTo('.ul-list');
	    		$('#AllBtn span').text('全选');
	    		machineNum = 0;
	    		$('#posBtnRmachine b').html(machineNum);
	    	}
    });
    
  //选中ip项动画
	var machineNum = 0;
    function machineMoveBox(obj) {   
        var divTop = $(obj).offset().top;
        var divLeft = $(obj).offset().left;
        $(obj).css({ "position": "absolute", "z-index": "0", "left": divLeft + "px", "top": divTop -120 + "px" });
        $(obj).animate({ "left": ($("#posBtnRmachine").offset().left -20) + "px", "top": $("#posBtnRmachine").offset().top -160 + "px", "width": "100px", "height": "30px"}, 500, function () {
            $(obj).animate({ "left":($("#posBtnRmachine").offset().left -20) + "px", "top": $("#posBtnRmachine").offset().top -160 + "px" , "opacity":"0", "width": "30px" }, 300);
        });
        machineNum ++;
        $('#posBtnRmachine b').html(machineNum);
        var Timer =null;
	    	function remainTime(){ 
	    		$(obj).removeAttr('style');
	    	 	$(obj).appendTo('#selectMachineUl');  	 
	    	 	$('#noSelectTextRmachine').hide();
	    	 	
	    } 
	    	Timer= setTimeout(function(){
	    		remainTime();
	    	},1000);   
    } 
    
  //选中监控项动画
	var num = 0;
    function MoveBox(obj) {    		
        var divTop = $(obj).offset().top;
        var divLeft = $(obj).offset().left;
        $(obj).css({ "position": "absolute", "z-index": "0", "right": "40px", "top": divTop -140 + "px" });
        
        $(obj).animate({ "right": "40px", "top":"40px", "width": "100px", "height": "70px"}, 500, function () {
            $(obj).animate({ "right": "40px", "top":"40px" , "opacity":"0", "width": "0" }, 300);
        });
        num ++;
        $('#posBtnR b').html(num);
        var Timer =null;
	    	function remainTime(){ 
	    		$(obj).removeAttr('style');
	    	 	$(obj).appendTo('.myselect-template');  	 
	    	 	$('#noSelectText').hide();
	    	 	
	    } 
	    	Timer= setTimeout(function(){
	    		remainTime();
	    	},1000);   
    }
    //点击选中监控项
    $('.template-ul-list').delegate('li' , 'click' , function (){
    		MoveBox(this);
    	 	$(this).addClass('select');
	    	$(this).find('.delete-list-btn').show();
	    	$(this).find('input').prop('checked' , 'checked');
	    	templateParam ();
    })    
    
  //清空选中的监控项
	$('#clearBtnR').on('click' , function (){
		$('.myselect-template li').removeClass('select');
		$('.myselect-template li').find('input').prop('checked' , '');
		$('.myselect-template li').find('img').hide();
		$('.myselect-template li').not('#noSelectText').appendTo('.template-ul-list');
		$('#noSelectText').show();
		num = 0;
		$('#posBtnR b').html(num);
		templateParam ();
	});

    //返回监控项
    $('#backBtnR').on('click' , function (){
    	$(this).hide();
    	$('#clearBtnR').hide();
		$('#posBtnR').show();
		$('.myselect-template').hide();
		$('.template-ul-list').show();
    })
    //查看选中监控项
    $('#posBtnR').on("click" , function(){
    		$('.myselect-template li').removeAttr('style');
        $(this).hide();
        $('#clearBtnR').show();
        $('#backBtnR').show();
        $('.myselect-template').show();
        $('.template-ul-list').hide();
        var liLen = $('.myselect-template li').length;
       // console.log(liLen);
        if(liLen == 1){
        		$('#noSelectText').show();
        }else{
        	$('#noSelectText').hide();
        }
    })
    //删除选中的监控项
    $('.myselect-template').delegate('li','click' , function (event){
        num --;
	    window.event.cancelBubble = true;
	    event.stopPropagation(); 
	    $('#posBtnR b').html(num);
	    $(this).find('img').hide();
	    $(this).removeClass('select');
	    $(this).find('input').prop('checked' , '');
	    $(this).appendTo('.template-ul-list');
	    templateParam ();
    }) 
    
    //选择分类
    var templateTypeLi = document.getElementById('templateType').getElementsByTagName('li');
    for(var k= 0; k<templateTypeLi.length; k++){
    	    		templateTypeLi[k].onclick = function (event){
	    			var selectMachineLen = $('#selectMachineUl li').length;
	    			var selectserverClusterLen = $('#myselect-serverCluster li').length;
	    			if(selectMachineLen == 1 && selectserverClusterLen == 1){
    				alert('请先选择机器或者集群');
    	        }else{
	    	        event.preventDefault(); 
		    	    	event.stopPropagation();
		    	    	$('.template-ul-list').show();
		    	    	$('.myselect-template').hide();
		    	    	$('#clearBtnR').hide();
		    	    	$('#backBtnR').hide();
		    	    	$('#posBtnR').show();
		        	var $this = $(this);
		    		if($this.hasClass('select')){
		    			$this.removeClass('select');	    
		    			return false;
		    		}else{  
		    			$this.addClass('select');
		    			$this.find('input').attr('checked','checked');
		    			$this.siblings().removeClass('select');
		    			var thisVal = $this.find('input').val();
		    			if(thisVal == 'CPU'){
		    				dataList(counterCpuArr);
		    			}else if(thisVal == '磁盘'){
		    				dataList(counterDiskArr);
		    			}else if(thisVal == '内存'){
		    				dataList(counterMemArr);
		    			}else if(thisVal == '端口'){
		    				dataList(counterPortArr);				
		    			}else if(thisVal == '进程'){
		    				dataList(counterProcArr);
		    			}else if(thisVal == '其它'){
		    				dataList(counterOtherArr);
		    			}else if(thisVal == '网卡'){
		    				dataList(counterNetArr);
		    			}else if(thisVal == '常用'){
		    				dataList(counterDefaultArr);
		    			}
		    			return false;
		    		}
    	        }    			
    		}
    }    
  //搜索监控项
    $('#searchMetricBtn').on('click' , function (e){
    		e.preventDefault(); 
    		var selectMachineLen = $('#selectMachineUl li').length;
    		if(selectMachineLen <= 1){
    			alert('请先选择IP');
         }else{ 
        	 	$('.cont-right .load-text').show();
     	 	machineParam (true); 
     	 	if (searchFaild){
     	 		$('.template-ul-list').html('没有匹配的监控记录');
     	 	}else{
     	 		dataList(queryedCounters);
     	 		//console.log(queryedCounters)
     	 	} 
         }    		   	 	
    })
  //解析显示监控项
    function dataList(queryedCountersData) {
    		//console.log(queryedCountersData);
		html = '';
		for(i= 0; i < queryedCountersData.length; i++){ 								
			html += '<li title = "'+queryedCountersData[i]+'">'+queryedCountersData[i]+'<img class="delete-list-btn" src='+imgUrl+' ><input type="checkbox" name="metric_name_list" value='+queryedCountersData[i]+' ></li>';
		};
		if(html != ''){
		 	$('.template-ul-list').html(html);
		}else{
			$('.template-ul-list').html('<li>没有数据</li>');
			$('.load-text').hide();
		}      
    }
    
    function templateParam () {
		 machine_name_list =  $("input[name='machine_name_list']:checked").length;
		 metric_name_list =  $("input[name='metric_name_list']:checked").length;
		 server_cluster_list =  $("input[name='server_cluster_list']:checked").length;
		    if((machine_name_list > 0 || server_cluster_list > 0 ) && metric_name_list > 0){
		    		checked_items = new Array();
				$("input[name='machine_name_list']:checked").each(function(){					
					var host_fullname = $(this).val();
					//console.log(host_fullname);
					/*if (host_fullname.indexOf('.meilishuo.com') == -1) {
						host_fullname += '.meilishuo.com';
					}*/
					checked_hosts.push(host_fullname);				
				});
			$("input[name='metric_name_list']:checked").each(function(){
				var item_name = $(this).val();
				checked_items.push(item_name);
			});	
			$.ajaxSetup({  
				async : true  
		    });
		    $.ajax({
		        url: commitUrl,
		        dataType: "json",
		        method: "POST",
		        data: {"endpoints": checked_hosts, "counters": checked_items, "graph_type": default_graph_type, "_r": Math.random()},
		        success: function(ret) {
		            if (ret.ok) {
		            	dashboarChartsUrl = "http://dashboard.falcon.meiliworks.com/charts?id="+ret.id+"&graph_type="+default_graph_type;
			    		$("#Frame_dashboarCharts").attr("src", dashboarChartsUrl);
			    		$('#Frame_dashboarCharts').show();
		            }else {
		                console.log("返回状态出错了");
		            }
		        },
		        error: function(){
		            console.log("请求出错了");
		        }
		    });   		
		}	
	};
	$('#dashboard_form').on('submit' , function (){
		event.stopPropagation();
       	return false;
	});
	
	//show or hide content
	var show = true;
    	$('.slideup-btn').on('click' , function (){
    		if(show == false){
    			$('.content').slideDown('fast');
    			$(this).addClass('slideup-btn');
    			show = true;
    		}else{
    			$('.content').slideUp('fast');
    			$(this).addClass('slide-btn');
    			$(this).removeClass('slideup-btn');
    			show = false;
    		}	
    	});
	
	window.parent.clickPage("MF_ASE_dashboard");	
	window.parent.changeMTree();	
	window.parent.needMfTree(true);
})();
