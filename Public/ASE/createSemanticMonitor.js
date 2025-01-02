/**
 * 
 * @authors lixiuhuan@meilishuo.com
 * @date    2015-10-10 16:19:44
 * @version _v=0.0.1
 */
var saveTemplate = true;
//调用时间控件
$(function() {
    $("#run_begin").on("click",
    function(e) {
        e.stopPropagation();
        $(this).lqdatetimepicker({
            css: 'datetime-hour'
        });
    });
    $("#run_end").on("click",
    function(e) {
        e.stopPropagation();
        $(this).lqdatetimepicker({
            css: 'datetime-hour'
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

	$("#check_from_idc_short_name_select").change(function(){
		var uicTeamSelect       = $("#check_from_idc_short_name_select").find("option:selected").text();
		var hidenControl        = document.getElementById('check_from_idc_short_name');
		// 给隐藏域赋值
        uicTeamSelect      = uicTeamSelect.trim();
        uicTeamSelect      = uicTeamSelect.replace(/\s+/g, ',');
        uicTeamSelect      = uicTeamSelect.replace("全选", "ALL");
        hidenControl.value = uicTeamSelect;
    });
	$("#check_from_idc_short_name_nginx_select").change(function(){
		var uicTeamSelect       = $("#check_from_idc_short_name_nginx_select").find("option:selected").text();
		var hidenControl        = document.getElementById('check_from_idc_short_name_nginx');
		// 给隐藏域赋值
        uicTeamSelect      = uicTeamSelect.trim();
        uicTeamSelect      = uicTeamSelect.replace(/\s+/g, ',');
        uicTeamSelect      = uicTeamSelect.replace("全选", "ALL");
        uicTeamSelect      = uicTeamSelect.replace("汇总", "SUM");
        hidenControl.value = uicTeamSelect;
    });

	$("#create_task_form").submit(function(e){
		var taskName                  = document.getElementById("task_name");
		var semanticMonitorPackageStr = document.getElementById("semantic_monitor_package_str");

		if ((taskName == null) || (taskName.value.trim() == ""))
		{
			alert('任务名不能为空！请填写任务名');
			$("#task_name").focus();

			return false;
		}
		if ((semanticMonitorPackageStr == null) || (semanticMonitorPackageStr.value.trim() == ""))
		{
			alert('策略信息不能为空！请填写策略信息');
	        // 展开监控策略
	        $('#form-group').slideDown('fast');
	        $('.slide-btn').addClass('slideup-btn');
	        show = true;

			return false;
		}

		return true;
	});

	//显示tips
    $('.help').on('mouseover',
    function() {
        $(this).find('span').show();
    }).on('mouseout',
    function() {
        $(this).find('span').hide();
    });
    
  //展示or隐藏回调
    $('.callback-img').on('click', function() {
        $('.col-sm-11').slideToggle('fast');
        $(this).toggleClass('callback1-img');
    })
    //监控方式切换
    $('#check_ways_ul li').on('click' , function (){
    		$(this).addClass('select').siblings().removeClass('select');
    		var index = $(this).index();
    		if (index == 0) {
    			//$('#check_type_request_count').addClass('select').siblings().removeClass('select');
    			$('.nginx-div').show();
    			$('.simulation-div').hide();
    			$('#text-content-div').hide();

    			if ($('#check_type_request_count').hasClass('select')){
        			$('.tab-box').eq(0).show().siblings('.tab-box').hide();
    				$('#check_type').val(8);
    				$('#metric').val('semantic.request_count');
    			} else if ($('#check_type_statuscode_error_rate').hasClass('select')){
        			$('.tab-box').eq(1).show().siblings('.tab-box').hide();
    				$('#check_type').val(16);
    				$('#metric').val('semantic.statuscode_error_rate');
    			}
    			//$('#metric').val('semantic.request_count');
    		}else if(index == 1 ){
    			//$('#check_type_text_content').addClass('select').siblings().removeClass('select');
    			$('.nginx-div').hide();
    			$('.simulation-div').show();
    			if($('#check_type_text_content').hasClass('select')){
    				$('#text-content-div').show();
    			}

    			if ($('#check_type_status_code').hasClass('select')){
        			$('.tab-box').eq(2).show().siblings('.tab-box').hide();
    				$('#check_type').val(2);
    	            $('#metric').val("semantic.status_code");
    			} else if ($('#check_type_text_content').hasClass('select')){
        			$('.tab-box').eq(3).show().siblings('.tab-box').hide();
    				$('#check_type').val(1);
    	            $('#metric').val("semantic.text_content");
    			} else if ($('#check_type_time_total').hasClass('select')){
        			$('.tab-box').eq(4).show().siblings('.tab-box').hide();
    				$('#check_type').val(4);
    	            $('#metric').val("semantic.time_total");
    			}
    			//$('#metric').val('semantic.text_content');
    		}
    })
    
    //nginx类型切换
    $('#check_type_nginx_ul li').on('click' , function (){
    	$(this).addClass('select').siblings().removeClass('select');
    	var index = $(this).index();
		$('.tab-box').eq(index).show().siblings('.tab-box').hide();
		if(index == 0){
			$('#metric').val('semantic.request_count');
			$('#check_type').val(8);
		}else if(index == 1){
			$('#metric').val('semantic.statuscode_error_rate');
			$('#check_type').val(16);
		}
    })
    
    //模拟探测校验类型切换
    $('#check_type_simulation_ul li').on('click', function() {
    	var index = $(this).index();
        $(this).addClass('select').siblings().removeClass('select');
        $('.tab-box').eq(index).show().siblings('.tab-box').hide();
        if (index == 0){
            $('#text-content-div').hide();
            $('#check_type').val(2);
            $('#metric').val("semantic.status_code");
            $('.tab-box').eq(2).show().siblings('.tab-box').hide();
        }else if (index == 1) {
            $('#text-content-div').show();
            $('#check_type').val(1);
            $('#metric').val("semantic.text_content");
            $('.tab-box').eq(3).show().siblings('.tab-box').hide();
        }else if (index == 2){
            $('#text-content-div').hide();
            $('#check_type').val(4);
            $('#metric').val("semantic.time_total");
            $('.tab-box').eq(4).show().siblings('.tab-box').hide();
        } else {
        	$('#text-content-div').hide();
        }
    });
    //展示or隐藏监控策略
    $('.slide-btn').on('click', function() {
        if (show == false) {
            $('#form-group').slideDown('fast');
            $(this).addClass('slideup-btn');
            show = true;
        } else {
            $('#form-group').slideUp('fast');
            $(this).removeClass('slideup-btn');
            show   = false;
            isEdit = false;
        }
    });
    //调用多选下拉框
    var config = {
        '.chosen-select'           : {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }         
    $('#check_from_idc_short_name_select_chosen').css('width' , '260px');
    $('#check_from_idc_short_name_nginx_select_chosen').css('width' , '260px');
   
    var i            = 0;
    var show         = false;
    var currentState = 'save';
    
    $('#SaveStrategy').on('click' , function (){
    		SaveStrategy();
	})
	
	function SaveStrategy() {
    		var func, func_param, op, right_value;
	    var check_type  = $("#check_type").val();
	    check_type      = parseInt(check_type);
	    var metric      = $("#metric").val();
	    var note        = $("#note").val();
	    var max_step    = $("#max_step").val();
	    var priority    = $("#priority").val();
	    var run_begin   = $("#run_begin").val();
	    var run_end     = $("#run_end").val();
	    var sendUrlAndParams          = '';
	    var check_from_idc_short_name = '';
	    var tags              = '';
	    var monitorConditions = '';  // 报警条件
	    var check_type_text   = '';
	    var func_text         = '';
	    var op_text           = '';
	    var check_ways        = '';

    	if (max_step==null || max_step.trim()=="" || max_step.trim()=="[]" || max_step.trim()=="[[]]") {
    		alert("最大报警次数不能为空!");
    		$("#max_step").focus();
    		return true;
    	}

    	if (check_type == 1) {
    		tags = $("#check_text_content").val();
    		if (tags == null || tags.trim() == "") {
    			alert("正文内容不能为空!");
        		$("#check_text_content").focus();
        		return true;
    		}
	    	check_from_idc_short_name = $("#check_from_idc_short_name").val();
    		if (check_from_idc_short_name == null || check_from_idc_short_name.trim() == "") {
    			alert("机房不能为空！请选中机房");
        		$("#check_from_idc_short_name").focus();
        		return true;
    		}

    		tags             = tags.trim();
    		check_ways       = "模拟探测";
    		check_type_text  = "正文内容";
    		sendUrlAndParams = $("#send_url_and_params").val();
    		sendUrlAndParams = sendUrlAndParams.trim();
    		if (sendUrlAndParams.indexOf('-') == 0){
    			sendUrlAndParams = ' ' + sendUrlAndParams;
    		}

    		func        = $("#func_text_content").val();
    		func_param  = $("#func_param_text_content").val();
    		op          = $("#op_text_content").val();
    		right_value = $("#right_value_text_content").val();
    		func_text   = $("#func_text_content_select option:selected").text();
    		op_text     = $("#op_text_content_select option:selected").text(); 
    		monitorConditions = "连续监测 " + func_param + " 个点, " + func_text + " " + op_text + " " + tags;
    		if ((op == "!=") && (func == "max"))
    		{
    			func = "min";
    		}
    	} else if (check_type == 2) {
    		right_value = $("#right_value_status_code").val();
    		if ((right_value == null) || (right_value.trim() == "")) {
    			alert("HTTP状态码不能为空!");
        		$("#right_value_status_code").focus();
        		return true;
    		}
	    	check_from_idc_short_name = $("#check_from_idc_short_name").val();
    		if (check_from_idc_short_name == null || check_from_idc_short_name.trim() == "") {
    			alert("机房不能为空！请选中机房");
        		$("#check_from_idc_short_name").focus();
        		return true;
    		}
    		right_value      = right_value.trim();
    		right_value      = right_value;
    		check_ways       = "模拟探测";
    		check_type_text  = "HTTP状态码";
    		sendUrlAndParams = $("#send_url_and_params").val();
    		sendUrlAndParams = sendUrlAndParams.trim();
    		if (sendUrlAndParams.indexOf('-') == 0){
    			sendUrlAndParams = ' ' + sendUrlAndParams;
    		}

    		func        = $("#func_status_code").val();
    		func_param  = $("#func_param_status_code").val();
    		op          = $("#op_status_code").val();
    		func_text   = $("#func_status_code_select option:selected").text();
    		op_text     = $("#op_status_code_select option:selected").text(); 
    		monitorConditions = "连续监测 " + func_param + " 个点, " + func_text + " " + op_text + " " + right_value;
    	} else if (check_type == 4) {
    		right_value = $("#right_value_time_total").val();
    		if ((right_value == null) || (right_value.trim() == "")) {
    			alert("响应时间阈值不能为空!");
        		$("#right_value_time_total").focus();
        		return true;
    		}
	    	check_from_idc_short_name = $("#check_from_idc_short_name").val();
    		if (check_from_idc_short_name == null || check_from_idc_short_name.trim() == "") {
    			alert("机房不能为空！请选中机房");
        		$("#check_from_idc_short_name").focus();
        		return true;
    		}
    		right_value      = right_value.trim();
    		right_value      = parseInt(right_value);
    		check_ways       = "模拟探测";
    		check_type_text  = "响应时间";
    		sendUrlAndParams = $("#send_url_and_params").val();
    		sendUrlAndParams = sendUrlAndParams.trim();
    		if (sendUrlAndParams.indexOf('-') == 0){
    			sendUrlAndParams = ' ' + sendUrlAndParams;
    		}

    		func        = $("#func_time_total").val();
    		func_param  = $("#func_param_time_total").val();
    		op          = $("#op_time_total").val();
    		func_text   = $("#func_time_total_select option:selected").text();
    		op_text     = $("#op_time_total_select option:selected").text(); 
    		monitorConditions = "连续监测 " + func_param + " 个点, " + func_text + " " + op_text + " " + right_value + "毫秒";
    	} else if (check_type == 8) {
    		right_value = $("#right_value_request_count").val();
    		if ((right_value == null) || (right_value.trim() == "")) {
    			alert("每分钟请求量阈值不能为空!");
        		$("#right_value_request_count").focus();
        		return true;
    		}
	    	check_from_idc_short_name = $("#check_from_idc_short_name_nginx").val();
    		if (check_from_idc_short_name == null || check_from_idc_short_name.trim() == "") {
    			alert("机房不能为空！请选中机房");
        		$("#check_from_idc_short_name_nginx").focus();
        		return true;
    		}
    		right_value      = right_value.trim();
    		right_value      = parseInt(right_value);
    		check_ways       = "nginx日志";
    		check_type_text  = "每分钟请求量";
    		//sendUrlAndParams = $("#send_url_and_params").val();
    		//sendUrlAndParams = sendUrlAndParams.trim();
	    	//check_from_idc_short_name = $("#check_from_idc_short_name").val();
			func        = $("#func_request_count").val();
    		func_param  = $("#func_param_request_count").val();
    		op          = $("#op_request_count").val();
    		right_value_unit = $("#right_value_unit_request_count").val();
    		func_text   = $("#func_request_count_select option:selected").text();
    		
    		monitorConditions = "连续监测 " + func_param + " 个点, " + func_text + " " + right_value;
    		if (right_value_unit == "%") {
        		monitorConditions += "%";
        		if (func == "add") {
        			func = "pdiff";
        			op   = ">";
        		}
        		else if (func == "reduce") {
        			func = "pdiff";
        			op   = "<";
        			right_value = "-" + right_value;
        		}
        		else {
        		}
    		} else {
        		monitorConditions += "次";
        		if (func == "add") {
        			func = "diff";
        			op   = ">";
        		}
        		else if (func == "reduce") {
        			func = "diff";
        			op   = "<";
        			right_value = "-" + right_value;
        		}
        		else if (func == "under") {
        			func = "all";
        			op   = "<";
        		}
        		else if (func == "higher") {
        			func = "all";
        			op   = ">";
        		}
        		else {
        			
        		}
    		}
    	} else if (check_type == 16) {
    		right_value = $("#right_value_statuscode_error_rate").val();
    		if ((right_value == null) || (right_value.trim() == "")) {
    			alert("错误率阈值不能为空!");
        		$("#right_value_statuscode_error_rate").focus();
        		return true;
    		}
	    	check_from_idc_short_name = $("#check_from_idc_short_name_nginx").val();
    		if (check_from_idc_short_name == null || check_from_idc_short_name.trim() == "") {
    			alert("机房不能为空！请选中机房");
        		$("#check_from_idc_short_name_nginx").focus();
        		return true;
    		}
    		right_value      = right_value.trim();
    		right_value      = parseInt(right_value);
    		check_ways       = "nginx日志";
    		check_type_text  = "错误率";
    		//sendUrlAndParams = $("#send_url_and_params").val();
    		//sendUrlAndParams = sendUrlAndParams.trim();
	    	//check_from_idc_short_name = $("#check_from_idc_short_name").val();
			func        = $("#func_statuscode_error_rate").val();
    		func_param  = $("#func_param_statuscode_error_rate").val();
    		op          = $("#op_statuscode_error_rate").val();
    		func_text   = "全部";
    		op_text     = "高于";
    		monitorConditions = "连续监测 " + func_param + " 个点, " + op_text + " " + right_value + "%";
    	} else {
    		
    	}

    	//取出字符串append到表格的后面            	
	    var html= '';  	    
		if( isEdit ){
			//alert('到这里了');
		html += '<td>'+ check_ways + '</td><td>'+sendUrlAndParams+'</td><td>'+check_type_text+'</td><td>'+check_from_idc_short_name+'</td><td>'+monitorConditions+'</td><td>'+max_step+'</td><td>'+priority+'</td><td>'+run_begin+' 至 '+run_end+'</td><td><a class="edit-strategy-btn" data-exit="2" href="javascript:void(0)">查看</a> | <a class="edit-strategy-btn" data-exit="2" href="javascript:void(0)">编辑</a> | <a class="clone-strategy-btn" data-exit="1" href="javascript:void(0)">复制</a> | <a class="delete-btn" href="javascript:void(0)" title="点击删除">删除</a></td>';   
			$('#createSemanticMonitorTable tbody').find('tr').eq(trIndex).html(html);
	    }else{
	    	html += '<tr id="'+i+'"><td>'+ check_ways + '</td><td>'+sendUrlAndParams+'</td><td>'+check_type_text+'</td><td>'+check_from_idc_short_name+'</td><td>'+monitorConditions+'</td><td>'+max_step+'</td><td>'+priority+'</td><td>'+run_begin+' 至 '+run_end+'</td><td><a class="edit-strategy-btn" data-exit="2" href="javascript:void(0)">查看</a> | <a class="edit-strategy-btn" data-exit="2" href="javascript:void(0)">编辑</a> | <a class="clone-strategy-btn" data-exit="1" href="javascript:void(0)">复制</a> | <a class="delete-btn" href="javascript:void(0)" title="点击删除">删除</a></td></tr>'; 
	    	$('#createSemanticMonitorTable').append(html);
	    }

	    //隐藏监控策略
	    $('#form-group').slideUp('fast');
		$('.slide-btn').removeClass('slideup-btn');
		show = false;
		var strategyRecordArr         = new Array();
		var strategyRecord            = new Object();
		strategyRecord["check_ways"]  = check_ways;
		strategyRecord["send_url_and_params"]  = sendUrlAndParams;
		strategyRecord["check_from_idc_short_name"] = check_from_idc_short_name;
		strategyRecord["check_type"]  = check_type;
		strategyRecord["check_type_text"] = check_type_text;
		strategyRecord["monitor_condition"] = monitorConditions;
	    strategyRecord["metric"]      = metric;
	    strategyRecord["tags"]        = tags;
	    strategyRecord["note"]        = note;
	    strategyRecord["func"]        = func;
	    strategyRecord["func_param"]  = func_param;
	    strategyRecord["op"]          = op;
	    strategyRecord["right_value"] = right_value;
	    strategyRecord["max_step"]    = max_step;
	    strategyRecord["priority"]    = priority;
	    strategyRecord["run_begin"]   = run_begin;
	    strategyRecord["run_end"]     = run_end;
	
	    var semanticMonitorPackageStrControl = document.getElementById("semantic_monitor_package_str");
	    var semanticMonitorPackageStr        = semanticMonitorPackageStrControl.value
	    if ((semanticMonitorPackageStr != null) && (semanticMonitorPackageStr.trim() != ""))
	    {
	        strategyRecordArr         = JSON.parse(semanticMonitorPackageStr);
	    }

	    if (isEdit)
	    {
	    	strategyRecordArr[trIndex]                  = strategyRecord;
	    }
	    else
	    {
	    	strategyRecordArr[strategyRecordArr.length] = strategyRecord;
	    }
	    semanticMonitorPackageStrControl.value          = JSON.stringify(strategyRecordArr);
	
	    i = i + 1;
	    isEdit = false;    // 设置 "非编辑模式"
    		currentState = 'save'; //设置当前状态为保存状态
    		saveTemplate = false;
    }
	
	//编辑 监控策略
	$('.edit-strategy-btn').live('click' , function (){
		if (currentState != 'save'){
			var r = confirm(' 是否保存当前报警策略?');
			if(r){
				SaveStrategy();
			}	
		}
		var tableHeight = $('#createSemanticMonitorTable').height()+250;
		$('html,body').animate({scrollTop:tableHeight},300);//设置滚动条距离顶部的位置
		isEdit = true;
		trIndex = $(this).parents("tr").index();    // 获取编辑的监控策略的 rowIndex
		
		var semanticMonitorPackageStrControl = document.getElementById("semantic_monitor_package_str");
		var semanticMonitorPackageStr        = semanticMonitorPackageStrControl.value;
		var strategyRecordArr         = new Array();	
		//console.log(semanticMonitorPackageStr);		
		strategyRecordArr             = JSON.parse(semanticMonitorPackageStr);
		var selectedStrategyRecord    = new Object();
		
		selectedStrategyRecord        = strategyRecordArr[trIndex];

		var check_type = selectedStrategyRecord["check_type"];
		var metric = selectedStrategyRecord["metric"];
		$('#metric').val(metric);
		//console.log(metric);
	    	if ((check_type == "1") || (check_type == 1))
	    	{
	    		$('.nginx-div').hide();
	    		$('.simulation-div').show();
	    		$("#check_ways_simulation").addClass('select').siblings().removeClass('select');
	    		$('#check_type_text_content').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').show();
	    		$('.tab-box').eq(3).show().siblings('.tab-box').hide();
	    		$('#check_type').val(1);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		if ((op == "!=") && (func == "min"))
	    		{
	    			func = "max";
	    		}

	    		$("#send_url_and_params").val(selectedStrategyRecord["send_url_and_params"]);
	    		$("#check_from_idc_short_name_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name").val(check_from_idc_short_name);
	    		$("#check_text_content").val(selectedStrategyRecord["tags"]);

	    		$("#func_text_content").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_text_content").val(func_param);
				$("#op_text_content").val(selectedStrategyRecord["op"]);
				$("#right_value_text_content").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_select").trigger("chosen:updated");
				setSelectedItem("func_param_text_content_select", func_param);
				setSelectedItem("func_text_content_select", func);
				setSelectedItem("op_text_content_select", op);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "2") || (check_type == 2))
	    	{
	    		$('.nginx-div').hide();
	    		$('.simulation-div').show();
	    		$("#check_ways_simulation").addClass('select').siblings().removeClass('select');
	    		$('#check_type_status_code').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(2).show().siblings('.tab-box').hide();
	    		$('#check_type').val(2);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		$("#send_url_and_params").val(selectedStrategyRecord["send_url_and_params"]);
	    		$("#check_from_idc_short_name_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name").val(check_from_idc_short_name);

	    		$("#func_status_code").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_status_code").val(func_param);
				$("#op_status_code").val(selectedStrategyRecord["op"]);
				$("#right_value_status_code").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_select").trigger("chosen:updated");
				setSelectedItem("func_param_status_code_select", func_param);
				setSelectedItem("func_status_code_select", func);
				setSelectedItem("op_status_code_select", op);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "4") || (check_type == 4))
	    	{
	    		$('.nginx-div').hide();
	    		$('.simulation-div').show();
	    		$("#check_ways_simulation").addClass('select').siblings().removeClass('select');
	    		$('#check_type_time_total').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(4).show().siblings('.tab-box').hide();
	    		$('#check_type').val(4);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		$("#send_url_and_params").val(selectedStrategyRecord["send_url_and_params"]);
	    		$("#check_from_idc_short_name_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name").val(check_from_idc_short_name);

	    		$("#func_time_total").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_time_total").val(func_param);
				$("#op_time_total").val(selectedStrategyRecord["op"]);
				$("#right_value_time_total").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_select").trigger("chosen:updated");
				setSelectedItem("func_param_time_total_select", func_param);
				setSelectedItem("func_time_total_select", func);
				setSelectedItem("op_time_total_select", op);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "8") || (check_type == 8))
	    	{
	    		$('.nginx-div').show();
	    		$('.simulation-div').hide();
	    		$("#check_ways_nginx_log").addClass('select').siblings().removeClass('select');
	    		$('#check_type_request_count').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(0).show().siblings('.tab-box').hide();
	    		$('#check_type').val(8);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];
	    		var right_value  = selectedStrategyRecord["right_value"];
	    		var refined_func = func;
	    		if (func == "pdiff")
	    		{
	    			$("#right_value_unit_request_count").val('%');
	    			setSelectedItem("right_value_unit_request_count_select", '%');
	    			$('#right_value_unit_request_count_select option').show();
	    			if (op == ">")
	    			{
	    				refined_func = "add";
	    			}
	    			else if (op == "<")
	    			{
	    				refined_func = "reduce";
	    				right_value  = right_value * (-1);
	    			}
	    			else
	    			{
	    				// 待扩展
	    			}
	    		}
	    		else
	    		{
	    			$("#right_value_unit_request_count").val('count');
	    			setSelectedItem("right_value_unit_request_count_select", 'count');
	    			if (func == "diff")
	    			{
		    			if (op == ">")
		    			{
		    				refined_func = "add";
		    			}
		    			else if (op == "<")
		    			{
		    				refined_func = "reduce";
		    				right_value  = right_value * (-1);
		    			}
		    			else
		    			{
		    				// 待扩展
		    			}
		    			$('#right_value_unit_request_count_select option').show();
	    			}
	    			if (func == "all")
	    			{
	    			    $("#right_value_unit_request_count_select option[value='%']").hide();
		    			if (op == ">")
		    			{
		    				refined_func = "higher";
		    			}
		    			else if (op == "<")
		    			{
		    				refined_func = "under";
		    			}
		    			else
		    			{
		    				// 待扩展
		    			}
	    			}
	    		}

	    		$("#check_from_idc_short_name_nginx_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name_nginx").val(check_from_idc_short_name);
	    		$("#func_request_count").val(refined_func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_request_count").val(func_param);
				$("#op_request_count").val(selectedStrategyRecord["op"]);
				$("#right_value_request_count").val(right_value);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_nginx_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_nginx_select").trigger("chosen:updated");
				setSelectedItem("func_param_request_count_select", func_param);
				setSelectedItem("func_request_count_select", refined_func);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "16") || (check_type == 16))
	    	{
	    		$('.nginx-div').show();
	    		$('.simulation-div').hide();
	    		$("#check_ways_nginx_log").addClass('select').siblings().removeClass('select');
	    		$('#check_type_statuscode_error_rate').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(1).show().siblings('.tab-box').hide();
	    		$('#check_type').val(16);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		$("#check_from_idc_short_name_nginx_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name_nginx").val(check_from_idc_short_name);
	    		$("#func_statuscode_error_rate").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_statuscode_error_rate").val(func_param);
				$("#op_statuscode_error_rate").val(selectedStrategyRecord["op"]);
				$("#right_value_statuscode_error_rate").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_nginx_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_nginx_select").trigger("chosen:updated");
				setSelectedItem("func_param_statuscode_error_rate_select", func_param);
				setSelectedItem("priority_select", priority);
	    	}
	    	else
	    	{
	    		// 待扩展
	    	}
		//$('#func_name').find('b').html(selectedStrategyRecord["func"]);
		
		// 展开监控策略
		$('#form-group').slideDown('fast');
		$('.slide-btn').addClass('slideup-btn');
		show = true;
		currentState = 'edit';   //设置当前状态为编辑状态
	})

	// 复制 监控策略
	$('.clone-strategy-btn').live('click' , function (){
		
		if (currentState != 'save'){
			var r = confirm(' 是否保存当前报警策略?');
			if(r){
				SaveStrategy();
			}	
		}
		
		var tableHeight = $('#createSemanticMonitorTable').height()+250;
		$('html,body').animate({scrollTop:tableHeight},300);//设置滚动条距离顶部的位置
		
		isEdit = false;
		trIndex = $(this).parents("tr").index();    // 获取复制的监控策略的 rowIndex
		var semanticMonitorPackageStrControl = document.getElementById("semantic_monitor_package_str");
		var semanticMonitorPackageStr        = semanticMonitorPackageStrControl.value;
		var strategyRecordArr         = new Array();
		strategyRecordArr             = JSON.parse(semanticMonitorPackageStr);
		var selectedStrategyRecord    = new Object();
		selectedStrategyRecord        = strategyRecordArr[trIndex];
		//console.log(selectedStrategyRecord);

		var check_type = selectedStrategyRecord["check_type"];
		var metric = selectedStrategyRecord["metric"];
		//console.log(metric);
	    	if ((check_type == "1") || (check_type == 1))
	    	{
	    		$('.nginx-div').hide();
	    		$('.simulation-div').show();
	    		$("#check_ways_simulation").addClass('select').siblings().removeClass('select');
	    		$('#check_type_text_content').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').show();
	    		$('.tab-box').eq(3).show().siblings('.tab-box').hide();
	    		$('#check_type').val(1);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		if ((op == "!=") && (func == "min"))
	    		{
	    			func = "max";
	    		}

	    		$("#send_url_and_params").val(selectedStrategyRecord["send_url_and_params"]);
	    		$("#check_from_idc_short_name_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name").val(check_from_idc_short_name);
	    		$("#check_text_content").val(selectedStrategyRecord["tags"]);

	    		$("#func_text_content").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_text_content").val(func_param);
				$("#op_text_content").val(selectedStrategyRecord["op"]);
				$("#right_value_text_content").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_select").trigger("chosen:updated");
				setSelectedItem("func_param_text_content_select", func_param);
				setSelectedItem("func_text_content_select", func);
				setSelectedItem("op_text_content_select", op);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "2") || (check_type == 2))
	    	{
	    		$('.nginx-div').hide();
	    		$('.simulation-div').show();
	    		$("#check_ways_simulation").addClass('select').siblings().removeClass('select');
	    		$('#check_type_status_code').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(2).show().siblings('.tab-box').hide();
	    		$('#check_type').val(2);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		$("#send_url_and_params").val(selectedStrategyRecord["send_url_and_params"]);
	    		$("#check_from_idc_short_name_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name").val(check_from_idc_short_name);

	    		$("#func_status_code").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_status_code").val(func_param);
				$("#op_status_code").val(selectedStrategyRecord["op"]);
				$("#right_value_status_code").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_select").trigger("chosen:updated");
				setSelectedItem("func_param_status_code_select", func_param);
				setSelectedItem("func_status_code_select", func);
				setSelectedItem("op_status_code_select", op);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "4") || (check_type == 4))
	    	{
	    		$('.nginx-div').hide();
	    		$('.simulation-div').show();
	    		$("#check_ways_simulation").addClass('select').siblings().removeClass('select');
	    		$('#check_type_time_total').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(4).show().siblings('.tab-box').hide();
	    		$('#check_type').val(4);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		$("#send_url_and_params").val(selectedStrategyRecord["send_url_and_params"]);
	    		$("#check_from_idc_short_name_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name").val(check_from_idc_short_name);

	    		$("#func_time_total").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_time_total").val(func_param);
				$("#op_time_total").val(selectedStrategyRecord["op"]);
				$("#right_value_time_total").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_select").trigger("chosen:updated");
				setSelectedItem("func_param_time_total_select", func_param);
				setSelectedItem("func_time_total_select", func);
				setSelectedItem("op_time_total_select", op);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "8") || (check_type == 8))
	    	{
	    		$('.nginx-div').show();
	    		$('.simulation-div').hide();
	    		$("#check_ways_nginx_log").addClass('select').siblings().removeClass('select');
	    		$('#check_type_request_count').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(0).show().siblings('.tab-box').hide();
	    		$('#check_type').val(8);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];
	    		var right_value  = selectedStrategyRecord["right_value"];
	    		var refined_func = func;
	    		if (func == "pdiff")
	    		{
	    			$("#right_value_unit_request_count").val('%');
	    			setSelectedItem("right_value_unit_request_count_select", '%');
	    			$('#right_value_unit_request_count_select option').show();
	    			if (op == ">")
	    			{
	    				refined_func = "add";
	    			}
	    			else if (op == "<")
	    			{
	    				refined_func = "reduce";
	    				right_value  = right_value * (-1);
	    			}
	    			else
	    			{
	    				// 待扩展
	    			}
	    		}
	    		else
	    		{
	    			$("#right_value_unit_request_count").val('count');
	    			setSelectedItem("right_value_unit_request_count_select", 'count');
	    			if (func == "diff")
	    			{
		    			if (op == ">")
		    			{
		    				refined_func = "add";
		    			}
		    			else if (op == "<")
		    			{
		    				refined_func = "reduce";
		    				right_value  = right_value * (-1);
		    			}
		    			else
		    			{
		    				// 待扩展
		    			}
		    			$('#right_value_unit_request_count_select option').show();
	    			}
	    			if (func == "all")
	    			{
	    			    $("#right_value_unit_request_count_select option[value='%']").hide();
		    			if (op == ">")
		    			{
		    				refined_func = "higher";
		    			}
		    			else if (op == "<")
		    			{
		    				refined_func = "under";
		    			}
		    			else
		    			{
		    				// 待扩展
		    			}
	    			}
	    		}

	    		$("#check_from_idc_short_name_nginx_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name_nginx").val(check_from_idc_short_name);
	    		$("#func_request_count").val(refined_func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_request_count").val(func_param);
				$("#op_request_count").val(selectedStrategyRecord["op"]);
				$("#right_value_request_count").val(right_value);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_nginx_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_nginx_select").trigger("chosen:updated");
				setSelectedItem("func_param_request_count_select", func_param);
				setSelectedItem("func_request_count_select", refined_func);
				setSelectedItem("priority_select", priority);
	    	}
	    	else if ((check_type == "16") || (check_type == 16))
	    	{
	    		$('.nginx-div').show();
	    		$('.simulation-div').hide();
	    		$("#check_ways_nginx_log").addClass('select').siblings().removeClass('select');
	    		$('#check_type_statuscode_error_rate').addClass('select').siblings().removeClass('select');
	    		$('#text-content-div').hide();
	    		$('.tab-box').eq(1).show().siblings('.tab-box').hide();
	    		$('#check_type').val(16);

	    		var check_from_idc_short_name = selectedStrategyRecord["check_from_idc_short_name"];
	    		var func       = selectedStrategyRecord["func"];
	    		var func_param = selectedStrategyRecord["func_param"];
	    		var op         = selectedStrategyRecord["op"];
	    		var priority   = selectedStrategyRecord["priority"];

	    		$("#check_from_idc_short_name_nginx_select").val(check_from_idc_short_name);
	    		$("#check_from_idc_short_name_nginx").val(check_from_idc_short_name);
	    		$("#func_statuscode_error_rate").val(func);
				//funcParam = funcParam.replace("(#", '');
				//funcParam = funcParam.replace(")", '');
				$("#func_param_statuscode_error_rate").val(func_param);
				$("#op_statuscode_error_rate").val(selectedStrategyRecord["op"]);
				$("#right_value_statuscode_error_rate").val(selectedStrategyRecord["right_value"]);
				$("#max_step").val(selectedStrategyRecord["max_step"]);
				$("#priority").val(priority);
				$("#note").val(selectedStrategyRecord["note"]);
				$("#run_begin").val(selectedStrategyRecord["run_begin"]);
				$("#run_end").val(selectedStrategyRecord["run_end"]);

				setIDCSelectedItem("check_from_idc_short_name_nginx_select", check_from_idc_short_name);
				$("#check_from_idc_short_name_nginx_select").trigger("chosen:updated");
				setSelectedItem("func_param_statuscode_error_rate_select", func_param);
				setSelectedItem("priority_select", priority);
	    	}
	    	else
	    	{
	    		// 待扩展
	    	}
		//$('#func_name').find('b').html(selectedStrategyRecord["func"]);
		
		// 展开监控策略
		$('#form-group').slideDown('fast');
		$('.slide-btn').addClass('slideup-btn');
		show = true;
		currentState = 'clone';   //设置当前状态为复制状态
	})	

	// 删除 监控策略
	$('.delete-btn').live('click' , function (){
		var r=confirm("确认删除？");
		if(r == true){
			//var id = $(this).parents('tr').attr('id');
			var trIndex = $(this).parents("tr").index();
			var semanticMonitorPackageStrControl = document.getElementById("semantic_monitor_package_str");
			var semanticMonitorPackageStr        = semanticMonitorPackageStrControl.value;
			var strategyRecordArr         = new Array();
			if ((semanticMonitorPackageStr != null) && (semanticMonitorPackageStr.trim() != ""))
			{
			    strategyRecordArr         = JSON.parse(semanticMonitorPackageStr);
			    strategyRecordArr.splice(trIndex, 1);
			    semanticMonitorPackageStrControl.value = JSON.stringify(strategyRecordArr);
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
})
