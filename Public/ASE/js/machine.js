/**
 * 
 * @authors lixiuhuang@meilishuo.com
 * @date    2016-02-04 16:11:21
 * @version $1.1.0
 */
(function (){
	
	var config = {
        '.chosen-select'           : {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
	$('#model_select').css('width' , '260px');
	$('#modal-dialog').hide();
	
	//显示or隐藏高级搜索
	$('#addSelectedServer').on('mouseover' , function(){
		cleartimer();
		$('#modal-dialog').stop().slideDown('fast');
		$(this).addClass('btn4545-hide');		
	}).on('mouseout', function(){
		hideDiv();
	});
	$('#modal-dialog').on('mouseover' , function(){
		cleartimer();
	}).on('mouseout', function(){
		hideDiv();
	});
	var timer = null; 
	function hideDiv() {
		timer = setTimeout(function (){
			$('#modal-dialog').stop().slideUp('fast');
			$('#addSelectedServer').removeClass('btn4545-hide');
		},300); 
	}
	function cleartimer() {
		clearTimeout(timer);
	}
	
	// slider
	$("#sliderCPU").slider({});
	$("#sliderDisk").slider({});
	$("#sliderMemory").slider({});
	$("#sliderNetCard").slider({});
	
	$("input[type='checkbox']").on('click' , function (){
		$('#modSeniorSearchForm').submit();
	});
	$('.slider-handle').on('mouseup' , function(){
		$('#modSeniorSearchForm').submit();
	})
	$('#health_status_select').on('change' , function (){		
		setTextVal(this.options[this.selectedIndex].text);
		$('#machineListForm').submit();
	})
	function setTextVal(_text){
	   document.getElementById("health_status_str").value=_text;
	}
	
	//高级搜索
	$('#modSeniorSearchForm').on('submit' , function (){		
		var short_name_arr   = new Array();  //idc机房
		var manufacturer_arr = new Array();	 // 品牌		
		//var model_arr        = new Array();   // 机型
		
		//idc机房
		var short_name_len =  $("input[name='short_name[]']:checked").length;
		if(short_name_len >= 1){
			 $("input[name='short_name[]']:checked").each(function (){
				 var this_short_name = $(this).val();
				 short_name_arr.push(this_short_name);
			 })
			 $('#short_name_val').val(short_name_arr);
		}
		
		//品牌
		var manufacturer_len =  $("input[name='manufacturer[]']:checked").length;
		if(manufacturer_len >= 1){
			 $("input[name='manufacturer[]']:checked").each(function (){
				 var this_manufacturer = $(this).val();
				 manufacturer_arr.push(this_manufacturer);
			 })
			 $('#manufacturer_val').val(manufacturer_arr);
		}		
		//CPU	
		var sliderCPUval = $('#sliderCPUform').find('.tooltip-inner').eq(0).text();
		$('#sliderCPUval').val(sliderCPUval);
		//磁盘
		var sliderDiskVal = $('#sliderDiskForm').find('.tooltip-inner').eq(0).text();
		$('#sliderDiskVal').val(sliderDiskVal);
		
		//内存
		var sliderMemoryVal = $('#sliderMemoryForm').find('.tooltip-inner').eq(0).text();
		$('#sliderMemoryVal').val(sliderMemoryVal);
		
		//网卡
		var sliderNetCardVal = $('#sliderNetCardForm').find('.tooltip-inner').eq(0).text();
		$('#sliderNetCardVal').val(sliderNetCardVal);	
	})
	
	//删除当前筛选的
	$('.crumbs-nav a').on('click' , function (){
		var $this     = $(this);
		var thisName  = $this.attr('name');   //选择机型为下拉框 没有name属性
		var thisText  = $this.text();
		var thisClass = $this.attr('class'); 
		var this_data_config = $this.attr('data-config'); 
		if(thisName != undefined){   //机房  品牌
			$('input[name="'+thisName+'"]:checked').each(function(){
				var thisVal = $(this).val();
				if(thisText == thisVal){
					$(this).removeAttr('checked');
					$('#modSeniorSearchForm').submit();
				}
			})
		}
		if(thisClass == 'model'){   //机型
			$('#model_select option:selected').each(function(){
				var thisVal = $(this).val();
				if(thisText == thisVal){
					$(this).removeAttr('selected');
					changeSelectedItem();
					$('#modSeniorSearchForm').submit();
				}
			})
		}	
		if(this_data_config != undefined){  //配置
			var current_confir = $('#'+this_data_config).find('input');
			var current_confir_hidden = $('#'+this_data_config).find('.tooltip-inner');
			var current_confir_bottom = current_confir.attr('data-slider-min');
			var current_confir_top = current_confir.attr('data-slider-max');
			current_confir_hidden.text(current_confir_bottom + ':' + current_confir_top);
			console.log(current_confir_hidden.val());
			$('#modSeniorSearchForm').submit();
			
		}
		
	})
	
	window.parent.clickPage("MF_ASE_machineListNew");
	window.parent.needMfTree(true);
	
})();