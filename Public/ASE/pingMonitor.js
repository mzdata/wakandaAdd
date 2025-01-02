/**
 * 
 * @authors lixiuhuang@meilishuo.com
 * @date    2015-12-16 11:57:08
 * @version 1.0.0
 */

(function (){
	
	var check_type_val = $('#check_type').val();
	if(check_type_val == 1){
		$('.monitor-tab').eq(1).find('.ping-label').addClass('default');
		$('.monitor-tab').eq(1).find('.input1').prop('disabled','disabled');
		$('.monitor-tab').eq(1).find('.ping-label span').html('X');
	}else if(check_type_val == 2){
		$('.monitor-tab').eq(0).find('.ping-label').addClass('default');
		$('.monitor-tab').eq(0).find('.input1').prop('disabled','disabled');
		$('.monitor-tab').eq(0).find('.ping-label span').html('X');
	}else if(check_type_val == 3){
		
	}
	
	$('#templateSearchKey').on('keydown' , function(){   //输入文字  删除按钮show
		$(".delete-btn").show();
	});

   	$(".delete-btn").on("click" , function(){
		$('#templateSearchKey').val('');
		$(this).hide();
	})  
	
	 //展示or隐藏回调
	$('#callback').on('click' , function (){
		$('.col-sm-11').slideToggle('fast');
        $(this).toggleClass('callback1-img');
	})
	
	//展示or隐藏高级选项
	$('#options-tbn').on('click' , function (){
		$('#form-group').slideToggle('fast');
        $(this).toggleClass('callback1-img');
        $('#callback').slideToggle('fast');
        $('.col-sm-11').hide();
	})
	
	// 丢包率 响应时间切换	monitor-tab
	$('.ping-label').on('click' , function (event){
		event.preventDefault();
		$(this).toggleClass('default');
		var has_class = $(this).hasClass('default');
		if(has_class){
			$(this).parents('.monitor-tab').find('.input1').prop('disabled','disabled');
			$(this).parents('.monitor-tab').find('.ping-label span').html('X');
		}else{
			$(this).parents('.monitor-tab').find('.input1').removeAttr('disabled');
			$(this).parents('.monitor-tab').find('.ping-label span').html('√');
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

	$("#check_from_idc_short_name_select").change(function(){
		var idcSelect      = $("#check_from_idc_short_name_select").find("option:selected").text();
		var hidenControl   = document.getElementById('check_from_idc_short_name');
		// 给隐藏域赋值
		idcSelect          = idcSelect.trim();
		idcSelect          = idcSelect.replace(/\s+/g, ',');
		idcSelect          = idcSelect.replace("全选", "ALL");
        hidenControl.value = idcSelect;
    });

    //显示tips
    $('.help').on('mouseover',
    function() {
        $(this).find('span').show();
    }).on('mouseout',
    function() {
        $(this).find('span').hide();
    });

	$("#create_task_form").submit(function(e){
		var taskName              = document.getElementById("task_name");
		var pingTarget            = document.getElementById("ping_target");
		var checkFromIDCShortName = document.getElementById("check_from_idc_short_name");
		var uicTeam               = document.getElementById("uic_team");
		var packetLossRate        = document.getElementById("packet_loss_rate");
		var rttAvgTime            = document.getElementById("rtt_avg_time");
		
		var packet_loss_rate_disabled = $('#packet_loss_rate').attr('disabled');
		var rtt_avg_time_disabled = $('#rtt_avg_time').attr('disabled');

		if ((taskName == null) || (taskName.value.trim() == ""))
		{
			alert('监控名称不能为空！请填写监控名称');
			$("#task_name").focus();

			return false;
		}

		if ((pingTarget == null) || (pingTarget.value.trim() == ""))
		{
			alert('监控对象不能为空！请填写监控对象');
			$("#ping_target").focus();

			return false;
		}

		if ((checkFromIDCShortName == null) || (checkFromIDCShortName.value.trim() == ""))
		{
			alert('监控点不能为空！请填写监控点');
			$("#check_from_idc_short_name_select").focus();

			return false;
		}

		if (((packetLossRate == null) || (packetLossRate.value.trim() == "")) && ((rttAvgTime == null) || (rttAvgTime.value.trim() == "")))
		{
			alert('报警条件不能为空！请至少填写一项报警条件');
	        // 展开高级选项
			initInput();     
			return false;
		}
		
		if((packet_loss_rate_disabled) && (rtt_avg_time_disabled)){
			alert('报警条件不能为空！请至少启用一项报警条件');
			initInput();
			return false;
		}
		return true;
	});

	//回调提醒
	$('.checkbox-inline input').on('click' , function (){
		var isCheccked = $(this).prop('checked');
		if(isCheccked == true){
			$(this).val('1');
		}else{
			$(this).val('0');
		}
	})

	function initInput() {
		$('#form-group').show();
        $('#options-tbn').removeClass('callback1-img');
        $('#callback').removeClass('callback1-img');
        $('.col-sm-11').hide();	 
		$('.ping-label').removeClass('default');
		$('.ping-label span').html('√');
		$('.input1').removeAttr('disabled');
		$('.input1').focus();
		$('#callback').show();
	}
	
	

})();

