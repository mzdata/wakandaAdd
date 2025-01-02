/**
 * 
 * @authors lixiuhuang@meilishuo.com
 * @date    2015-12-03 11:26:04
 * @version 1.0.0
 */
(function (){
	//展示or隐藏监控策略
	var show = false;
	$('.slide-btn').on('click' , function (){
		if(show == false){
			$('#form-group').slideDown('fast');
			$(this).addClass('slideup-btn');
			show = true;
		}else{
			$('#form-group').slideUp('fast');
			$(this).removeClass('slideup-btn');
			show = false;
		}	
	})
	//展示or隐藏回调
	$('.callback-img').on('click' , function (){
		$('.col-sm-11').slideToggle('fast');
		$(this).toggleClass('callback1-img');
	})
	var thisVal = '';
	$('#checkboxMyself').on('click', function (){ 			//点击单选框 只显示自己创建的  
		$('#checkboxMyselfTpl').val('1');
		$('#tplDataType').val('');
		thisVal = $(this).html();
		$('#tplDataTypeVal').val('端口进程监控');
		$('#search_tpl_form').submit();        		
	});
	$('#checkboxAll').on('click' , function (){    // 0表示显示全部模板 1表示显示自己创建的模板 2表示公共模板
		$('#checkboxMyselfTpl').val('0');
		$('#tplDataType').val('');
		thisVal = $(this).html();
		$('#tplDataTypeVal').val('端口进程监控');
		$('#search_tpl_form').submit();         		
	});

	$('#templateSearchKey').on('keydown' , function(){   //输入文字  删除按钮show
		$(".delete-btn-text").show();
	});

	$(".delete-btn-text").on("click" , function(){
		$('#templateSearchKey').val('');
		$(this).hide();
	})    		

	$('.select-button').on('click' , function (e){
		 e.preventDefault(); 
		$(".dropdown-menu").slideToggle('fast');
	});
	$('.dropdown-menu').on('mouseleave' , function (){
		$(this).fadeOut();
	});
	
	//Port or Proc 切换      1进程 2端口
	$('#check_ways_ul li').on('click' , function (){
		var index = $(this).index();
		if(index == 0){
			showProc ();
		}else if(index == 1){
			showPort ();
		}
	})
	
	function showProc (){
		$('.port-num').hide();
		$('.port-monitor-condition').hide();
		$('.proc-monitor-condition').show();
		$('.monitor-way-proc').show();
		$('#check_type').val(1);
		$('#check_ways_ul li').eq(0).addClass('select').siblings().removeClass('select');
	}
	
	function showPort () {
		$('.port-num').show();
		$('.port-monitor-condition').show();
		$('.proc-monitor-condition').hide();
		$('.monitor-way-proc').hide();
		$('#check_type').val(2);
		$('#check_ways_ul li').eq(1).addClass('select').siblings().removeClass('select');
	}
	
	// 进程名 启动命令切换
	var monitoringMode = 'name'; 
	$('.proc-label').on('click' , function (){
		$(this).removeClass('default').parents().siblings().find('.proc-label').addClass('default');
		$(this).siblings().find('input').removeAttr('disabled').parents().siblings().find('.input1').attr('disabled','disabled');
		var index = $(this).index();
		var thisId= $(this).attr('id');
		monitoringMode = thisId;
	})
	
	var isEdit = false;  //是否点击的是编辑按钮  默认为false
    	var trIndex ;         //编辑当前tr的index 
        function setSelectedItem(selectedControlID, value)
        {
        	var selectedControl = document.getElementById(selectedControlID);
            for (var i=0; i<selectedControl.length; i++)
            {
            	var childNode = selectedControl.children[i];
                //if (!!childNode.getAttribute ('selected'))
                //{
                	childNode.removeAttribute ('selected');
                //}
                if (selectedControl.options[i].value == value)
                {
                	selectedControl.options[i].setAttribute('selected', 'selected');
                }
            }
            if (selectedControlID == "metric_select")
            {
            	$('#metric_select').val(value).trigger('chosen:updated');
            }
        } 

        var i = 0;
		$('#SaveStrategy').on('click' , function (){
	        	var note        = $("#note").val();  //node
	        	
	        	var check_type = $('#check_type').val();  //监控类型
	        	
	        	var func_param_proc  = $("#func_param_proc").val(); //报警条件 proc
	        	var op_status_code   = $("#op_status_code").val();  //报警条件 proc
	        	var right_value = $("#right_value").val();  //报警条件 proc	        	
	        	var process_name = $('#process_name').val();  //进程名 proc
	        	var start_command = $('#start_command').val();  //启动命令 proc
	        	
	        	var func = $('#func').val();  //报警条件
	        	
	        	var func_param_port = $('#func_param_port').val(); //报警条件 port	    	        	
	        	var port = $('#port').val();        //端口  port
	        	
	        	var max_step    = $("#max_step").val();      //最大报警次数
	        	var priority    = $("#priority").val();   //优先级
	
	        	var run_begin   = $("#run_begin").val();
	        	var run_end     = $("#run_end").val();   
	        	
	        	var alarmConditionStr = '';   //报警条件字符串
	        	var check_type_str = '';  //
	        	//判断当前选中的哪种类型监控  进程or端口
	        	if(check_type == 1){
	        	 	if (func_param_proc==null || func_param_proc.trim()=="" || func_param_proc.trim()=="[]" || func_param_proc.trim()=="[[]]") 
		        	{
		        		alert("报警条件不能为空!");
		        		$("#func_param_select_proc").focus();
		        		return true;
		        	}
		        	if (op_status_code==null || op_status_code.trim()=="" || op_status_code.trim()=="[]" || op_status_code.trim()=="[[]]") 
		        	{
		        		alert("报警条件不能为空!");
		        		$("#op_status_code_select").focus();
		        		return true;
		        	}
		        	if (right_value==null || right_value.trim()=="" || right_value.trim()=="[]" || right_value.trim()=="[[]]") 
		        	{
		        		alert("报警条件不能为空!");
		        		$("#right_value").focus();
		        		return true;
		        	}
		        	if (process_name == "" && start_command == "") 
		        	{
		        		alert("监控方式不能为空!");
		        		$("#process_name").focus();
		        		return true;
		        	}
		        	
		        	alarmConditionStr = '连续监测' + func_param_proc + '个点，进程数' + op_status_code + right_value +'发送报警';
		        	check_type_str = '进程';
	        	}else if(check_type == 2){
	        		if (func_param_port==null || func_param_port.trim()=="" || func_param_port.trim()=="[]" || func_param_port.trim()=="[[]]") 
		        	{
		        		alert("报警条件不能为空!");
		        		$("#func_param_select_port").focus();
		        		return true;
		        	}
	        		if (port==null || port.trim()=="" || port.trim()=="[]" || port.trim()=="[[]]") 
		        	{
		        		alert("端口不能为空!");
		        		$("#port").focus();
		        		return true;
		        	}
	        			        		
	        		right_value = 1;
	        		op_status_code = '!=';
	        		alarmConditionStr = '连续监测' + func_param_port + '个点， 端口监听异常发送报警';
	        		check_type_str = '端口';
	        	}
		       
	        	if (max_step==null || max_step.trim()=="" || max_step.trim()=="[]" || max_step.trim()=="[[]]") 
	        	{
	        		alert("最大报警次数不能为空!");
	        		$("#max_step").focus();
	        		return true;
	        	}
	        	if (priority==null || priority.trim()=="" || priority.trim()=="[]" || priority.trim()=="[[]]") 
	        	{
	        		alert("优先级不能为空!");
	        		$("#priority_select").focus();
	        		return true;
	        	}
	        	
	        	if (func_param_proc.indexOf("(#") < 0)
	        	{
				 func_param_proc = '(#' + func_param_proc + ')';
	        	}
	        	
	        	if (func_param_port.indexOf("(#") < 0)
	        	{
				func_param_port = '(#' + func_param_port + ')';
	        	}
	       				
	        	//隐藏监控策略
	        	$('#form-group').slideUp('fast');
			$('.slide-btn').removeClass('slideup-btn');
			show = false;
		 
			var strategyRecordArr         = new Array();
			var strategyRecord            = new Object();
			if (check_type == 1)
            {		
				strategyRecord["metric"]  = "proc.num";
				if (monitoringMode == 'name'){		
					strategyRecord["tags"]    = 'name=' + process_name;
				}else if(monitoringMode == 'cmdline'){
					strategyRecord["tags"]    = 'cmdline=' +start_command;
				}
				strategyRecord["func_param"]        = func_param_proc;
            
            }else if(check_type == 2){
            		strategyRecord["metric"]  = "net.port.listen";
                strategyRecord["tags"]    = 'port=' + port;
                strategyRecord["func_param"]        = func_param_port;
            }
			strategyRecord["func"]        = func;			
			strategyRecord["op"]  = op_status_code;
			//strategyRecord["process_name"]          = process_name;
			//strategyRecord["start_command"]          = start_command;
			//strategyRecord["func_param_port"]          = func_param_port;
			//strategyRecord["port"] = port;
			strategyRecord["note"]        = note;
			strategyRecord["right_value"]    = right_value;
			strategyRecord["max_step"]    = max_step;			
			strategyRecord["priority"]    = priority;
			strategyRecord["run_begin"]   = run_begin;
			strategyRecord["run_end"]     = run_end;

			var strategyPackageStrControl = document.getElementById("strategy_package_str");
			var strategyPackageStr        = strategyPackageStrControl.value;
			if ((strategyPackageStr != null) && (strategyPackageStr.trim() != ""))
			{
			    strategyRecordArr         = JSON.parse(strategyPackageStr);
			}
			
			if( isEdit )
			{
				strategyRecordArr[trIndex]                  = strategyRecord;
			}
			else
			{
				strategyRecordArr[strategyRecordArr.length] = strategyRecord;
			}
			strategyPackageStrControl.value             = JSON.stringify(strategyRecordArr);
	        //取出字符串append到表格的后面 	        	
	        	var html= '';            	            	           	
				if( isEdit ){
					html += '<td class="check_type_val">'+check_type_str+'</td><td>'+strategyRecord["tags"] +'</td><td>'+alarmConditionStr+'</td><td>'+max_step+'</td><td>'+priority+'</td><td>'+run_begin+' 至 '+run_end+'</td><td><a class="clone-strategy-btn" data-exit="1" href="javascript:void(0)">复制</a> | <a class="edit-strategy-btn" data-exit="2" href="javascript:void(0)">编辑</a> | <a class="delete-btn" href="javascript:void(0)" title="点击删除">删除</a></td>';   
					$('#createMonitorTemplateTable tbody').find('tr').eq(trIndex).html(html);
	        	}else{
	        		html += '<tr id="'+i+'"><td class="check_type_val">'+check_type_str+'</td><td>'+strategyRecord["tags"] +'</td><td>'+alarmConditionStr+'</td><td>'+max_step+'</td><td>'+priority+'</td><td>'+run_begin+' 至 '+run_end+'</td><td><a class="clone-strategy-btn" data-exit="1" href="javascript:void(0)">复制</a> | <a class="edit-strategy-btn" data-exit="2" href="javascript:void(0)">编辑</a> | <a class="delete-btn" href="javascript:void(0)" title="点击删除">删除</a></td></tr>'; 
	        		$('#createMonitorTemplateTable').append(html);
	        	}
			i = i + 1;
	        	isEdit = false;    // 设置 "非编辑模式"
	        	console.log($('#strategy_package_str').val());
		})	

		//编辑 监控策略
		$('.edit-strategy-btn').live('click' , function (){			
			isEdit = true;
			trIndex = $(this).parents("tr").index();    // 获取编辑的监控策略的 rowIndex
			var strategyPackageStrControl = document.getElementById("strategy_package_str");
			var strategyPackageStr        = strategyPackageStrControl.value;
			var strategyRecordArr         = new Array();
			strategyRecordArr             = JSON.parse(strategyPackageStr);
			var selectedStrategyRecord    = new Object();
			selectedStrategyRecord        = strategyRecordArr[trIndex];
			var tags_name_val= '';
			var tags_cmdline_val = '';
			var tags_port_val = '';
			var tags_val = selectedStrategyRecord["tags"];
			if(tags_val.indexOf('name=') != -1){
				tags_name_val = tags_val.replace('name=' , ' ');
			}else if(tags_val.indexOf('cmdline=') != -1){
				tags_cmdline_val = tags_val.replace('cmdline=' , ' ');
			}else if(tags_val.indexOf('port=') != -1){
				tags_port_val = tags_val.replace('port=' , ' ');
			}
						
			//$("#check_type").val(selectedStrategyRecord["check_type"]);
			$("#note").val(selectedStrategyRecord["note"]);
			$("#func_param_proc").val(selectedStrategyRecord["func_param"]);
			$("#func").val(selectedStrategyRecord["func"]);
			$("#op_status_code").val(selectedStrategyRecord["op"]);
			$("#process_name").val($.trim(tags_name_val));
			$("#start_command").val($.trim(tags_cmdline_val));
			$("#func_param_port").val(selectedStrategyRecord["func_param"]);
			$("#port").val($.trim(tags_port_val));
			$("#right_value").val(selectedStrategyRecord["right_value"]);
			$("#max_step").val(selectedStrategyRecord["max_step"]);
			$("#priority").val(selectedStrategyRecord["priority"]);
			$("#run_begin").val(selectedStrategyRecord["run_begin"]);
			$("#run_end").val(selectedStrategyRecord["run_end"]);
			
			var func_param_val =  selectedStrategyRecord["func_param"];
			var func_param_length = func_param_val.length;
			if (func_param_val.indexOf("(#") >= 0)
	        	{
				func_param_val = func_param_val.substring(2,func_param_length-1);
	        	}
			setSelectedItem("func_param_select_proc", func_param_val);
			setSelectedItem("op_status_code_select",  selectedStrategyRecord["op"]);
			setSelectedItem("func_param_select_port", func_param_val);
			setSelectedItem("priority_select", selectedStrategyRecord["priority"]);			
			
			// 展开监控策略
			$('#form-group').slideDown('fast');
			
			var check_type_val = $(this).parents('td').siblings('.check_type_val').text();
			if(check_type_val == '进程'){
				showProc();
			}else if(check_type_val == '端口'){
				showPort();
			}
			$('.slide-btn').addClass('slideup-btn');
			show = true;
		})

		// 复制 监控策略		
		$('.clone-strategy-btn').live('click' , function (){
			//alert(1);
			trIndex = $(this).parents("tr").index();    // 获取复制的监控策略的 rowIndex
			var strategyPackageStrControl = document.getElementById("strategy_package_str");
			var strategyPackageStr        = strategyPackageStrControl.value;
			var strategyRecordArr         = new Array();
			strategyRecordArr             = JSON.parse(strategyPackageStr);
			var selectedStrategyRecord    = new Object();
			selectedStrategyRecord        = strategyRecordArr[trIndex];

			var tags_name_val= '';
			var tags_cmdline_val = '';
			var tags_port_val = '';
			var tags_val = selectedStrategyRecord["tags"];
			if(tags_val.indexOf('name=') != -1){
				tags_name_val = tags_val.replace('name=' , ' ');
			}else if(tags_val.indexOf('cmdline=') != -1){
				tags_cmdline_val = tags_val.replace('cmdline=' , ' ');
			}else if(tags_val.indexOf('port=') != -1){
				tags_port_val = tags_val.replace('port=' , ' ');
			}
		
			$("#note").val(selectedStrategyRecord["note"]);
			$("#func_param_proc").val(selectedStrategyRecord["func_param"]);
			$("#op_status_code").val(selectedStrategyRecord["op"]);
			$("#func").val(selectedStrategyRecord["func"]);
			$("#process_name").val($.trim(tags_name_val));
			$("#start_command").val($.trim(tags_cmdline_val));
			$("#func_param_port").val(selectedStrategyRecord["func_param"]);
			$("#port").val($.trim(tags_port_val));
			$("#right_value").val(selectedStrategyRecord["right_value"]);
			$("#max_step").val(selectedStrategyRecord["max_step"]);
			$("#priority").val(selectedStrategyRecord["priority"]);
			$("#run_begin").val(selectedStrategyRecord["run_begin"]);
			$("#run_end").val(selectedStrategyRecord["run_end"]);

			var func_param_val =  selectedStrategyRecord["func_param"];
			var func_param_length = func_param_val.length;
			if (func_param_val.indexOf("(#") >= 0)
	        	{
				func_param_val = func_param_val.substring(2,func_param_length-1);
	        	}
			setSelectedItem("func_param_select_proc", func_param_val);
			setSelectedItem("op_status_code_select",  selectedStrategyRecord["op"]);
			setSelectedItem("func_param_select_port", func_param_val);
			setSelectedItem("priority_select", selectedStrategyRecord["priority"]);			
			
			// 展开监控策略
			$('#form-group').slideDown('fast');
			var check_type_val = $(this).parents('td').siblings('.check_type_val').text();
			if(check_type_val == '进程'){
				showProc();
			}else if(check_type_val == '端口'){
				showPort();
			}
			$('.slide-btn').addClass('slideup-btn');
			show = true;
		})	

		// 删除 监控策略		
		$('.delete-btn').live('click' , function (){
			var r=confirm("确认删除？");
			if(r == true){
				//var id = $(this).parents('tr').attr('id');
				var trIndex = $(this).parents("tr").index();
	    			var strategyPackageStrControl = document.getElementById("strategy_package_str");
	    			var strategyPackageStr        = strategyPackageStrControl.value;
	    			var strategyRecordArr         = new Array();
	    			if ((strategyPackageStr != null) && (strategyPackageStr.trim() != ""))
	    			{
	    			    strategyRecordArr         = JSON.parse(strategyPackageStr);
	    			    strategyRecordArr.splice(trIndex, 1);
	    			    strategyPackageStrControl.value = JSON.stringify(strategyRecordArr);
	    			}
	
	    			$(this).parents('tr').remove();
			}
		})
		
		//回调提醒
		$('.checkbox-inline input').on('click' , function (){
			var isCheccked = $(this).prop('checked');
			if(isCheccked == true){
				$(this).val('1');
			}else{
				$(this).val('0');
			}
		})
		
		//调用时间控件
        $("#run_begin").on("click",function(e){
            e.stopPropagation();
            $(this).lqdatetimepicker({
            	format: 'YYYY/MM/DD hh:mm:ss',
                css : 'datetime-hour'
            });
        });
        $("#run_end").on("click",function(e){
            e.stopPropagation();
            $(this).lqdatetimepicker({
                css : 'datetime-hour'
            });
        });

		$("#uic_team_select").change(function(){
			var uicTeamSelect       = $("#uic_team_select").find("option:selected").text();
			var hidenControl        = document.getElementById('uic_team');
			// 给隐藏域赋值
            uicTeamSelect      = uicTeamSelect.trim();
            uicTeamSelect      = uicTeamSelect.replace(/\s+/g, ',');
            hidenControl.value = uicTeamSelect;
        });

    	$("#create_tpl_form").submit(function(e){
    		var tplName            = document.getElementById("tpl_name");
    		var strategyPackageStr = document.getElementById("strategy_package_str");
    		var parentTplID        = $("#parent_tpl_id").val();

    		if ((tplName == null) || (tplName.value.trim() == ""))
    		{
    			alert('模板名不能为空！请填写模板名');
    			$("#tpl_name").focus();

    			return false;
    		}
    		if (((parentTplID == null) || (parentTplID == "") || (parentTplID == "0") || (parentTplID == 0))
    			&& ((strategyPackageStr == null) 
    		    || (strategyPackageStr.value.trim() == "")
    		    || (strategyPackageStr.value.trim() == "[]")
    		    || (strategyPackageStr.value.trim() == "[[]]")))
    		{
    			alert('监控策略不能为空！请添加监控策略');
    			// 展开监控策略
				$('#form-group').slideDown('fast');
    			$('.slide-btn').addClass('slideup-btn');
    			show = true;

    			return false;
    		}
    		return true;
		});
    	    // 查看模板 默认不能编辑  有权限则点击编辑按钮 进行编辑
	    	$('.exit-btn').on('click' , function (){
	    		$('.delault-hide').css('visibility','inherit');
	    		$('.delault-disabled').removeAttr("disabled");
	    		$('.disabled-div').hide();
	    	})
    	
    	//显示tips
   /* 	$('.help').on('mouseover' , function (){
    		$(this).find('span').show();
    	}).on('mouseout' , function (){
    		$(this).find('span').hide();
    	})*/	    
    window.parent.needMfTree(true);
})();
