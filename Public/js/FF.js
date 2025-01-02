	  function showMyFFTools(obj, otherparam) {
	   
		$('#div_FF_mytools').css("left", obj.offset().left+40);
		$('#div_FF_mytools').css("top", obj.offset().top + obj.outerHeight());
		$('#div_FF_mytools').css("position", "absolute");
		$('#div_FF_mytools').show(); 
		 
	}
	 
	
	   	$(function(){
			$(".close").click(function(){
                $("#div_FF_mytools").hide(); 
            });
            
            
          
			$("#clearFF").click(function(){
			     $("#FFSearch").val("-1");
                 $("#form_FF_mytools").submit(); 
            });
            
		})
	    	
	    	
	    	
	    
			
	 