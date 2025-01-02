 
$(function(){
	$("#do_submit").click(function(){
	//    var ok = confirm("确认表单信息，是否提交？");
	   ok=true;	
		var returnValue = false;
	    if (ok == true) {
	        window.returnValue = true; // 父窗口需要刷新
	        if ($("input:hidden[name='role_type']").val() == 0 && $("#action_type").val() == 1) { // 流程结束的role_type也是1，所以需要判断
	            if ($("input:hidden[name='next_role_id']").val() == 0) {
	                $("#suggestion").submit();
	            } else {
	                $("#choose-next").modal("show");
	                
	                $("#sub_next_person").click(function(){
		                /*
		                var ok = confirm("确认选择此人作为下级处理人？"); 
		                if (ok) {
		                    var nextPerson = $("select[name='next_exec_person']").val();
		                    $("input:hidden[name='next_exec_peron']").val(nextPerson);
		                    $("#suggestion").submit();
							returnValue = true;                               
		                } else {
		                    returnValue = false;
		                }*/
		                
		                    var nextPerson = $("select[name='next_exec_person']").val();
		                   
		                    $("input:hidden[name='next_exec_peron']").val(nextPerson);
		                    $("#suggestion").submit();
							returnValue = true;
	                })
	            }
	        } else {
	            returnValue = true;
	            $("#suggestion").submit();
	                            
	            return returnValue;
	        }
	    }
	})
})

function closeWindow(){
    var ok = confirm('离开后本页面所有的信息将会丢失，确认？');
    if (ok) {
        window.close();
        window.returnValue = true;
        return true;
    }
}