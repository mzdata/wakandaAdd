/**
 * 
 * @authors lixiuhaung@meilishuo.com
 * @date    2015-09-25 10:47:08
 * @version $Id$
 */

(function (){
	function showserverCluster () {
		$('.list-div').eq(1).show();
	    	$('.list-div').eq(0).hide();
	    	isServerModeChecked = true;
	    	$('#posBtnRmachine').hide();
	    	$('#posBtnserverCluster').hide();
	    	$('#backBtnserverCluster').show();
	    	$('#clearBtnserverCluster').show();
	    	$('#clearBtnRmachine').hide();
	    	$('#backBtnRmachine').hide();
	    	$('#AllBtn').hide();
	    	serverClusterNum = $('#myselect-serverCluster li').length -1;
	    	$('#myselect-serverCluster li').find('input').prop('checked' , 'checked');
		$('#posBtnserverCluster b').html(serverClusterNum);
		$('#myselect-serverCluster').show();
		$('#serverCluster-ul').hide();
		$('.nav-box li').eq(2).addClass('mychecked').siblings().removeClass('mychecked');
	}
	var searchFaild = false; 
    var para = new Object();
	var counterCpuArr     = [],    //cpu数组
		counterDiskArr    = [],   //磁盘数组
		counterMemArr     = [],	  //内存数组
		counterNetArr     = [],	  //网卡数组 
		counterPortArr    = [],  //端口
		counterProcArr    = [],   //进程
		counterOtherArr   = [], //其他
		counterDefaultArr = ['cpu.idle','df.bytes.free.percent/fstype=ext4,mount=/','mem.memfree.percent','net.if.in.bytes/iface=eth0','net.if.out.bytes/iface=eth0'];//常用   
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
	//调用时间空间
    var start = {
        elem: '#start',
        format: 'YYYY/MM/DD hh:mm:ss',
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY/MM/DD hh:mm:ss',
        min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
        choose: function(datas) {
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);
    
    //机器or集群切换
    var isServerModeChecked = false;
    $('.nav-box li').on('click' , function () {
	    $(this).addClass('mychecked').siblings().removeClass('mychecked');
	    if($(this).index() == 2){
	   	 	showserverCluster();
	   	 	requestServerClusterCounters();
	    }else{
		    	$('.list-div').eq(0).show();
		    	$('.list-div').eq(1).hide();
		    	isServerModeChecked = false;
		    	$('#posBtnRmachine').show();
		    	$('#posBtnserverCluster').hide();
		    	$('#backBtnserverCluster').hide();
		    	$('#clearBtnserverCluster').hide();
		    	$('#clearBtnRmachine').hide();
		    	$('#backBtnRmachine').hide();
		    	$('#selectMachineUl').hide();
		    	$('#machineListUl').show();
	    }
    })
    	//选中集群动画
    var serverClusterNum = 0;
    function serverClusterMoveBox(obj) {  
        var divTop = $(obj).offset().top;
        var divLeft = $(obj).offset().left;
        $(obj).css({ "position": "absolute", "z-index": "0", "left": divLeft + "px", "top": divTop -120 + "px" });
        $(obj).animate({ "left": ($("#posBtnserverCluster").offset().left -20) + "px", "top": $("#posBtnserverCluster").offset().top -120 + "px", "width": "100px", "height": "30px"}, 500, function () {
            $(obj).animate({ "left":($("#posBtnserverCluster").offset().left -20) + "px", "top": $("#posBtnserverCluster").offset().top -120 + "px" , "opacity":"0", "width": "30px" }, 300);
        });
        serverClusterNum ++;
        $('#posBtnserverCluster b').html(serverClusterNum);
        var Timer =null;
	    	function remainTime(){ 
	    		$(obj).removeAttr('style');
	    	 	$(obj).appendTo('#myselect-serverCluster');  	 
	    	 	$('#noSelectserverCluster').hide();
	    	 	
	    } 
	    	Timer= setTimeout(function(){
	    		remainTime();
	    	},1000);   
    } 
    //选择集群
    $('#serverCluster-ul').delegate('li' , 'click' , function (event) {
    		serverClusterMoveBox(this);
	    $(this).addClass('select');
	    $(this).find('.delete-serverCluster-btn').show();
	    $(this).find('input').prop('checked' , 'checked');
	    requestServerClusterCounters(); 
	    var server_cluster_list =  $("input[name='server_cluster_list']:checked").length;
	    if(server_cluster_list > 0){
	    		templateParam ();
	    }
    })
    //删除所选集群
    $('#myselect-serverCluster').delegate('li','click' , function (event){    		
    		serverClusterNum --;
	    $(this).find('img').hide();
	    $(this).removeClass('select');
	    $(this).find('input').prop('checked' , '');
	    $(this).appendTo('#serverCluster-ul');
	    $('#posBtnserverCluster b').html(serverClusterNum);
	    requestServerClusterCounters();
	    var server_cluster_list =  $("input[name='server_cluster_list']:checked").length;
	    if(server_cluster_list > 0){
	    		templateParam ();
	    }
    });
    //已选集群
    $('#posBtnserverCluster').on('click' , function (){
    		$(this).hide();
    		$('#AllBtn').hide();
    		$('#serverCluster-ul').hide();
    		$('#myselect-serverCluster').show();
    		$('#myselect-serverCluster li').removeAttr('style');
    		$('#backBtnserverCluster').show();
    		$('#clearBtnserverCluster').show();
    		var liLen = $('#myselect-serverCluster li').length;
        if(liLen == 1){
        		$('#noSelectserverCluster').show();
        }else{
        	$('#noSelectserverCluster').hide();
        }
    })
    //返回集群列表
    $('#backBtnserverCluster').on('click' , function (){
    		$(this).hide()
		$('#myselect-serverCluster').hide();
		$('.serverCluster-ul').show();
		$('#AllBtn').show();
		$('#clearBtnserverCluster').hide();
		$('#posBtnserverCluster').show();
    })
    //清空已选集群
    $('#clearBtnserverCluster').on('click' , function (){
    		serverClusterNum = 0
    		$('#noSelectTextRmachine').show();
    		$('.myselect-serverCluster li').find('.delete-serverCluster-btn').hide();
		$('.myselect-serverCluster li').removeClass('select');
		$('.myselect-serverCluster li').find('input').prop('checked' , '');
		$('.myselect-serverCluster li').not('#noSelectserverCluster').appendTo('.serverCluster-ul');
		$('#AllBtn span').text('全选');  
		$('#posBtnserverCluster b').html(serverClusterNum);
		$('#noSelectserverCluster').show();
		machineParam ();	 	
		$('#allChecked').prop('checked' , '');
    })
    //获取集群下的机器
    function requestServerClusterCounters (){
    		var server_cluster_list =  $("input[name='server_cluster_list']:checked").length;
    		var searchMetricVal     = $.trim($("#metricSearchKey").val());
    		if(server_cluster_list > 0){
    			checked_server_cluster = new Array();
    			$("input[name='server_cluster_list']:checked").each(function(){
    				var serverClusterNodeID = $(this).parents('li').attr('title');
    				checked_server_cluster.push(parseInt(serverClusterNodeID));
    			});
    			$.ajaxSetup({  
    				async : true  
    		    });
    			$.ajax({
			        url: requestServerClusterCountersUrl,
			        dataType: "json",
			        method: "POST",
			        data: {"checked_server_cluster": checked_server_cluster, "q": searchMetricVal, "limit": 10000, "_r": Math.random()},
			        success:function(ret){
			            	var counter_items = ret.data;
			            	var htmlStr ='';
			            	for (var item in counter_items) {
			                	var counter = counter_items[item];
			                //	checked_hosts.push(counter);
			                	htmlStr += '<input type="checkbox" name ="machine_name_list" checked ="checked" value ='+counter+' />'
			            	}
			            	if(htmlStr != ''){
			            		$('#SelectserverClusterBox').html(htmlStr);
				            	machineParam();
			                	templateParam();
			            	}else{
			            		alert('选中节点下没有挂载机器！');
			            		return;
			            	}
			            	$('.load-text').hide();
			        },
			        error:function(ret){
			        		$('.load-text').hide();
			        		console.log('请求出错了');
			        		searchFaild = true;
			        }
			    });	
    		}else{
    			return;
    		}
    }
	//数组去重
	/*function unique(arr) {
	    var result = [], hash = {};
	    for (var i = 0, elem; (elem = arr[i]) != null; i++) {
	        if (!hash[elem]) {
	            result.push(elem);
	            hash[elem] = true;
	        }
	    }
	    return result;
	}*/
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
				if (host_fullname.indexOf('.meilishuo.com') == -1) {
					host_fullname += '.meilishuo.com';
				}
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
				            	//console.log(queryedCounters);
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
				           // 	console.log(queryedCounters);
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
			        	if (counterName.toLowerCase().indexOf("cpu") == 0) {		        		
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
			        	}		        	
			    }
			}	
		}
    }
	//选中机器项动画
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
    //删除所选机器
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
    
    //选择机器
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
    // 全选机器
    $("#allChecked").click(function() {
	    if( isServerModeChecked != true ) {
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
	    }else {
	    		if($("#allChecked").prop("checked")=="checked"||$("#allChecked").prop("checked")==true)
		    	{ 
		    		$('.serverCluster-ul li').addClass('select');
		    		$('.serverCluster-ul li').find('.delete-serverCluster-btn').show();
		    		$('.serverCluster-ul li').find('input').prop('checked' , 'checked');
		    		$('.serverCluster-ul li').appendTo('.myselect-serverCluster');
		    		$('#AllBtn span').text('反选');
		    		serverClusterNum = $('#myselect-serverCluster li').length -1;
		    		$('#posBtnserverCluster b').html(serverClusterNum);
		    		requestServerClusterCounters();
		    	}else
		    	{			
		    		$('.myselect-serverCluster li').find('.delete-serverCluster-btn').hide();
		    		$('.myselect-serverCluster li').removeClass('select');
		    		$('.myselect-serverCluster li').find('input').prop('checked' , '');
		    		$('.myselect-serverCluster li').appendTo('.serverCluster-ul');
		    		$('#AllBtn span').text('全选');
		    		serverClusterNum = 0;
		    		$('#posBtnserverCluster b').html(serverClusterNum);
		    	} 
	    }	    		
	})
	//搜索机器	    	
	/*$("#machineListSearchBtn").on('click',function(event) { 
		 event.stopPropagation();
		 event.preventDefault();		
		var keyword = $('#machineListSearchKey').val();
		if(keyword != ""){   
			$('.cont-left .load-text').show();
			$('.search-error').hide();
          	$(".list-div li").each(function(index){
	  	    	    var textVal = $(this).text();  	    	  						
		    	  	if(textVal.indexOf(keyword) >= 0) {
		    	  		$(this).show();	
		    	  	}else{
		    	  		$(this).hide();
		    	  	}
		    	  	if (index == $(".list-div li").length -1){
		    	  		$('.cont-left .load-text').hide();
		    	  	}
            });
          	var visibleObjLength = $(".list-div li:visible").length;
          	if(visibleObjLength == 0 ){
          		//alert('没有匹配的机器');
          		$('.search-error').show();
          	}
  		}else{
  			$(".list-div li").show();	  		  				
	  	}	    		             	 
	 });*/
    //查看所选机器
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
    //返回机器列表
    $('#backBtnRmachine').on('click' , function (){
    		$(this).hide()
		$('#selectMachineUl').hide();
		$('.ul-list').show();
		$('#AllBtn').show();
		$('#clearBtnRmachine').hide();
		$('#posBtnRmachine').show();
    })
    //清空已选机器
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
    function templateParam () {
    		 machine_name_list =  $("input[name='machine_name_list']:checked").length;
		 metric_name_list =  $("input[name='metric_name_list']:checked").length;
		 server_cluster_list =  $("input[name='server_cluster_list']:checked").length;
		    if((machine_name_list > 0 || server_cluster_list > 0 ) && metric_name_list > 0){
		    		checked_items = new Array();
				$("input[name='machine_name_list']:checked").each(function(){					
					var host_fullname = $(this).val();
					if (host_fullname.indexOf('.meilishuo.com') == -1) {
						host_fullname += '.meilishuo.com';
					}
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
	//搜索监控项
    $('#searchMetricBtn').on('click' , function (e){
    		e.preventDefault(); 
    		var selectMachineLen = $('#selectMachineUl li').length;
    		if(selectMachineLen <= 1){
    			alert('请先选择机器');
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
    
	$('#dashboard_form').on('submit' , function (){
		event.stopPropagation();
       	return false;
	});
    
  //判断当前是集群or机器
	var urlStr = window.location.href;
	if(urlStr.indexOf('serverCluster') != -1){
		showserverCluster();
   	 	requestServerClusterCounters();
	}
	
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
})();
