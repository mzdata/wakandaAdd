  function showMySetFieldTools(obj) {
	   
		$('#div_SetField_mytools').css("left", obj.offset().left+40);
		$('#div_SetField_mytools').css("top", obj.offset().top + obj.outerHeight());
		$('#div_SetField_mytools').css("position", "absolute");
		$('#div_SetField_mytools').show(); 
		 
	}
	
	  	$(function(){
			$(".close").click(function(){
                $("#div_SetField_mytools").hide();   
            });
            
             $("#selectShowAll").click(function(){
			 
		 
					if($("#selectShowAll").attr("checked")=="checked"||$("#selectShowAll").attr("checked")==true)
					{ 
						$(".myckshowArr").attr("checked",true);
						//showMyBatchTools($(this) ,"otherparam"); //在此对象处显示工具栏
					}else
					{
						$(".myckshowArr").attr("checked",false);
					} 
				 
				})
        })
        
                 
	