/**
 * 
 * @authors lixiuhuang
 * @date    2016-01-07 12:41:32
 * @version 1.1.0
 */


(function (){
	var totalNum = '';
	//var currentdate = ''; //当前时间
	var currentSingleServerID = 0;
	getNowFormatDate ();  //初始化调用显示当前时间
	var thyt=showTime(7);
	
	function addByTransDate(dateParameter, num) {  
	    var translateDate = "", dateString = "", monthString = "", dayString = "";  
	    translateDate = dateParameter.replace("-", "/").replace("-", "/");   
	    var newDate = new Date(translateDate);  
	    newDate = newDate.valueOf();  
	    newDate = newDate + num * 24 * 60 * 60 * 1000;  
	    newDate = new Date(newDate);  
	    //如果月份长度少于2，则前加 0 补位     
	    if ((newDate.getMonth() + 1).toString().length == 1) {  
	    		monthString = 0 + "" + (newDate.getMonth() + 1).toString();  
	    } else {  
	    		monthString = (newDate.getMonth() + 1).toString();  
	    }  
	    //如果天数长度少于2，则前加 0 补位     
	    if (newDate.getDate().toString().length == 1) {  
	    		dayString = 0 + "" + newDate.getDate().toString();  
	    } else {  
	    		dayString = newDate.getDate().toString();  
	    }  
	    dateString = newDate.getFullYear() + "-" + monthString + "-" + dayString;  
	    return dateString;  
	}  
	//得到日期  主方法  
	function showTime(pdVal) {  
	    var trans_day = "";  
	    var cur_date = new Date();  
	    var cur_year = new Date().getFullYear();
	    var seperator2 = ":";
	    
	    var cur_month = cur_date.getMonth() + 1;  
	    var real_date = cur_date.getDate();  
	    var hours   = cur_date.getHours();
	    var minutes = cur_date.getMinutes();
	    var seconds = cur_date.getSeconds()
	    
	    cur_month = cur_month > 9 ? cur_month : ("0" + cur_month);  
	    real_date = real_date > 9 ? real_date : ("0" + real_date);  
	    hours = hours > 9 ? hours : ("0" + hours);  
	    minutes = minutes > 9 ? minutes : ("0" + minutes);  
	    seconds = seconds > 9 ? seconds : ("0" + seconds);  
	    
	    eT = cur_year + "-" + cur_month + "-" + real_date;

	    if (pdVal == 7) {  
	    		trans_day = addByTransDate(eT, 7);  
	    } 
	    
	    var currentdate = trans_day + " " + hours + seperator2 + minutes + seperator2 + seconds;//当前时间; 
	    
	    $('#end').val(currentdate);
	}  
	
	
	$('.select-button').on('click' , function (e){
		 e.preventDefault(); 
		 e.stopPropagation();
		$(".dropdown-menu").slideToggle('fast');
	});
	
	$('#templateSearchKey').on('keydown' , function(){   //输入文字  删除按钮show
		$(".delete-btn").show();
	});

   	$(".delete-btn").on("click" , function(){
		$('#templateSearchKey').val('');
		$(this).hide();
	})  
	
	$('.dropdown-menu').on('mouseleave' , function (){
		$(this).fadeOut();
	});
   	
   	$('.dropdown-menu li').on('click' , function (){
   		$('.select-button b').html($(this).text());   //1显示全部的  2显示已屏蔽的
   		$(".dropdown-menu").slideUp('fast');   	
   		var index = $(this).index();
   		if(index == 0){
   			$('#checkedType').val('1');
   		}else if(index == 1){
   			$('#checkedType').val('2');
   		}  
   		$('#search_tpl_form').submit();
   	})
   	
   	$('.hover-td').bind('mouseover' , function(){
		$(this).find('.span1').show();
	}).on('mouseout' , function(){
		$(this).find('.span1').hide();
	}) 
	
	$('#screen_btn').on('click' , function (){   //展示屏蔽选中
		//window.parent.scrollTo(0,0);
		$('#pop-layer').show();
		$('.pop-box').show();
		$('.record-box').hide();
		$('html body').css('overflow' , 'hidden');
		// 获取当前时间戳(以s为单位)
		var timestamp = Date.parse(new Date());
		timestamp = timestamp / 1000;   //设置默认时间
		$('#start_time').val(timestamp);
		
		getNowFormatDate(60);
		
		currentSingleServerID = 0;
	})
	
   	$('.btnShieldHostAlarm label').on('click', function(e) {
   		//alert(1);
   		e.preventDefault();
   		e.stopPropagation();
   		window.parent.scrollTo(0,0);
   		//console.log(scrollTop);
   		$('html,body').animate({scrollTop:0},100);//回到顶端
   		$('html body').css('overflow' , 'hidden');
   		$('#pop-layer').show();
   	    $('.pop-box').show();
   	    $('.record-box').hide();
   	    $(this).parents('td').siblings().find('input').prop('checked','checked');
   	    currentSingleServerID = $(this).parents('td').siblings().find('input').val();
        
   	    // 获取当前时间戳(以s为单位)
   	    var timestamp = Date.parse(new Date());
   	    timestamp = timestamp / 1000;   //设置默认时间
   	    $('#start_time').val(timestamp);
   	    
   	    getNowFormatDate(60);
   	})

	$('.screen-records a').on('click' , function (){  //展示屏蔽记录
		$('#pop-layer').show();
		$('.pop-box').hide();
		$('.record-box').show();
		$('html,body').animate({scrollTop:0},100);//回到顶端
		$('html body').css('overflow' , 'hidden');

		var $this       = $(this);
		//机器id
		var host_id   = $this.parent().siblings('td').eq(0).find('input').val();
		//机器名
		var host_name = $this.parent().siblings('td').eq(1).text();
		//机器ip
		var host_ip   = $this.parent().siblings('td').eq(2).text();
		
		//console.log(host_ip);
	    	$('#host_record').text(host_name + ' ' + host_ip);
	 //   	var operateObjectIDArr = new Array(host_id);

	    	$.post(showHostShieldRecordsUrl, {
	    		'param': JSON.stringify(host_id)
	    	}, function(json) {
	    		var retResult = JSON.parse(json);
	    		if (retResult.status == 1) {
	    		//	console.log(json);
	    			var dataLength = retResult.data.length;
	    			if(dataLength > 0){
	    				var i = 0;
		    			var html = '';
		    			for(i = 0 ; i<dataLength; i++){
		    				html += '<tr><td>'+retResult.data[i].operate_type+'</td><td>'+retResult.data[i].create_at+'</td><td>'+retResult.data[i].begin_timestamp+' 至 '+retResult.data[i].end_timestamp+'</td><td>'+retResult.data[i].create_user+'</td><td>'+retResult.data[i].operate_remarks+'</td></tr>'
		    			}
	    			}else{
	    				html = '<tr><td colspan="5">没有操作记录</td></tr>'
	    			}
	    			
	    			$('#tbl_host_record tbody').html(html);
	    		}
	    	});
	    	
	    	/*
    	  	$.post(showHostShieldRecordsPageUrl, {
   	    		'param': JSON.stringify(host_id)
   	    	}, function(json) {
   	    		var retResult = JSON.parse(json);
   	    		if (retResult.status == 1) {
   	    			totalNum = retResult.data;	
   	    			testPage(1); 

   	    		}
   	    	}); 
   	    	*/	    	
	})
	
	
	$('.close-btn').on('click' , function (){   //关闭弹出框
		$('#pop-layer').hide();
		$('html body').css('overflow' , 'auto');
		$('.checkbox-td').find('input').removeAttr('checked');
	})
	
    function testPage(curPage){  
	    console.log(totalNum);
	    supage('pageNav','testPage','',curPage,totalNum,10);    
	} 
	//计算后n分钟的时间
	function getNowFormatDate(argumentsMinutes) {
	    var date = new Date();
	    var seperator1 = "-";
	    var seperator2 = ":";
	    var month = date.getMonth() + 1;
	    var strDate = date.getDate();
	    var hours   = date.getHours();
	    var minutes = date.getMinutes();
	    var seconds = date.getSeconds()
	    if (month >= 1 && month <= 9) {
	        month = "0" + month;
	    }
	    if (strDate >= 0 && strDate <= 9) {
	        strDate = "0" + strDate;
	    }
	    
	    if (hours >= 0 && hours <= 9) {
	    		hours = "0" + hours;
	    }
	    
	    if (minutes >= 0 && minutes <= 9) {
	    		minutes = "0" + minutes;
	    }
	    
	    if (seconds >= 0 && seconds <= 9) {
	    		seconds = "0" + seconds;
	    }
	    
	    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
	            + " " + hours + seperator2 + minutes + seperator2 + seconds;   //当前时间
	    $('#start').val(currentdate);	    
	    var time = new Date(currentdate.replace("-","/"));
	    var b = argumentsMinutes; //分钟数
	    time.setMinutes(time.getMinutes() + b, time.getSeconds(), 0);
	    
	    var timestamp2 = Date.parse(new Date(time));
	    timestamp2 = timestamp2 / 1000;
	    $('#end_time').val(timestamp2);
	    
	    //console.log(time + "的时间戳为：" + timestamp2);
	}

   	$('.radioSemanticMonitor').on('click' , function (){  //选择屏蔽时间
		var index = $(this).index();
		$(this).addClass('mychecked');
		$(this).find('input').attr('checked','checked');
		$(this).siblings().removeClass('mychecked');
		$(this).siblings().find('input').removeAttr('checked');
		
		// 获取当前时间戳(以s为单位)
		var timestamp = Date.parse(new Date());
		timestamp = timestamp / 1000;
		
		if(index == 1){
			$('#start_time').val(timestamp);
			getNowFormatDate(60);
		}else if(index== 2){
			$('#start_time').val(timestamp);
			getNowFormatDate(180);
		}else if(index== 3){
			$('#start_time').val(timestamp);
			getNowFormatDate(1440);
		}
			  	
		if(index == 4){
			$('.chose-time').show();
		}else{
			$('.chose-time').hide();
		}
		
	})
	
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
    
    //全选机器
    $('#allChecked').on('click' , function(){
	    	if($("#allChecked").prop("checked")=="checked"||$("#allChecked").prop("checked")==true)
	    	{
	    		$('#TemplateBodyTable .checkbox-td').find('input:checkbox').prop("checked",'checked');
	    	}else{
	    		$('#TemplateBodyTable .checkbox-td').find('input:checkbox').prop("checked",'');
	    	}
    })
    
    $('#submit-btn').on('click' , function (){     //屏蔽监控项	
    		var is_specified_time = $('#specified_time').attr('checked');
    		if (is_specified_time == 'checked' || is_specified_time == true){
    			var start = $('#start').val();
    		    var end = $('#end').val();
    		    
    		    // 获取某个时间格式的时间戳    
    		    if(start != ''){
    		    		var stringTime = start;
    		    		var timestamp2 = Date.parse(new Date(stringTime));
    			    timestamp2 = timestamp2 / 1000;
    			   // console.log(stringTime + "的时间戳为：" + timestamp2);
    			    $('#start_time').val(timestamp2);
    		    }
    		    if(end != ''){
    			    	var stringTime = end;
    		    		var timestamp2 = Date.parse(new Date(stringTime));
    			    timestamp2 = timestamp2 / 1000;
    			    //console.log(stringTime + "的时间戳为：" + timestamp2);
    			    $('#end_time').val(timestamp2);
    		    }
    		}	

    		if (currentSingleServerID != 0) {
    			$('#server_id').val(currentSingleServerID);
    			$('#screenMonitor_form').submit();
    		}
    		else {
    		    var machine_name_list =  $("input[name='machine_name_list']:checked").length;
    		    if(machine_name_list >0){
    		    	var checked_server_cluster = new Array();
    		    	$("input[name='machine_name_list']:checked").each(function(){
    		    		var thisVal = $(this).val();
    		    		checked_server_cluster.push(thisVal);
    		    	});
    		    	$('#server_id').val(checked_server_cluster);
    		    	//var r=confirm("确认屏蔽选中的机器");
    		    	//if(r){
    		    		$('#screenMonitor_form').submit();
    		    	//}else{
    		    	//	return;
    		    	//}	
    		    }else{
    		    	alert('请选择需要屏蔽的机器')
    		    }
    		}
    })
    
    $('#clear_screen_btn').on('click' , function (){   //解除屏蔽监控项
    		var machine_name_list =  $("input[name='machine_name_list']:checked").length;
    		if(machine_name_list >0){
    			var checked_server_cluster = new Array();
    			$("input[name='machine_name_list']:checked").each(function(){
    				var thisVal = $(this).val();
    				checked_server_cluster.push(thisVal);
    			});
    			$('#unset_server_id').val(checked_server_cluster);
    			var r=confirm("确认解除报警屏蔽");
    			if(r){
    				$('#removeScreenForm').submit();
    			}else{
    				return;
    			}	
    		}else{
    			alert('请选择需要解除屏蔽的机器')
    		}
    })
    

    //分页
    /** 
     * @param {String} divName 分页导航渲染到的dom对象ID 
     * @param {String} funName 点击页码需要执行后台查询数据的JS函数 
     * @param {Object} params 后台查询数据函数的参数，参数顺序就是该对象的顺序，当前页面一定要设置在里面的 
     * @param {String} total 后台返回的总记录数 
     * @param {Boolean} pageSize 每页显示的记录数，默认是10 
     */  
   /* function supage(divId, funName, params, curPage, total, pageSize){  
        var output = '<div class="pagination">';  
        var pageSize = parseInt(pageSize)>0 ? parseInt(pageSize) : 10;  
        if(parseInt(total) == 0 || parseInt(total) == 'NaN') return;  
        var totalPage = Math.ceil(total/pageSize);  
        var curPage = parseInt(curPage)>0 ? parseInt(curPage) : 1;  
          
        //从参数对象中解析出来各个参数  
        var param_str = '';  
        if(typeof params == 'object'){  
            for(o in params){  
                if(typeof params[o] == 'string'){  
                   param_str += '\'' + params[o] + '\',';  
                }  
                else{  
                   param_str += params[o] + ',';  
                }  
            }  
            //alert(111);  
        }  
        //设置起始页码  
        if (totalPage > 10) {  
            if ((curPage - 5) > 0 && curPage < totalPage - 5) {  
                var start = curPage - 5;  
                var end = curPage + 5;  
            }  
            else if (curPage >= (totalPage - 5)) {  
                var start = totalPage - 10;  
                var end = totalPage;  
            }  
            else {  
                var start = 1;  
                var end = 10;  
            }  
        }  
        else {  
            var start = 1;  
            var end = totalPage;  
        }  
          
        //首页控制  
        if(curPage>1){  
            output += '<a href="javascript:'+funName+'(' + param_str + '1);" title="第一页" class="page-first">«</a>';  
        }  
        else  
        {  
            output += '<span class="page-disabled">«</span> ';  
        }  
        //上一页菜单控制  
        if(curPage>1){  
            output += '<a href="javascript:'+funName+'(' + param_str + (curPage-1)+');" title="上一页" class="page-previous">‹</a>';  
        }  
        else{  
            output += '<span class="page-disabled">‹</span>';  
        }  
          
        //页码展示  
        for (i = start; i <= end; i++) {  
            if (i == curPage) {  
                output += '<a href="javascript:;" class="page-cur">' + curPage + '</a>';  
            }  
            else {  
                output += '<a href="javascript:'+funName+'(' + param_str + i + ');">' + i + '</a>';  
            }  
        }  
        //下一页菜单控制  
        if(totalPage>1 && curPage<totalPage){  
            output += '<a title="下一页" href="javascript:'+funName+'('+param_str + (curPage+1)+');" class="page-next">›</a>';  
        }  
        else{  
            output += '<span class="page-disabled">›</span>';  
        }  
        //最后页控制  
        if(curPage<totalPage){  
            output += '<a title="最后页" href="javascript:'+funName+'('+param_str + totalPage+');" class="page-end">»</a>';  
        }  
        else{  
            output += '<span class="page-disabled">»</span>';  
        }  
          
        output += '</div>';  
        //渲染到dom中  
        document.getElementById(divId).innerHTML = output;  
    };  */
   
    
})();