$(document).ready(function() {
 	$("#sub_notify").click(function() {
		// 发送数据，并关闭

		// all_notifies
		var move_to_ids = $("select[name='move_to_ids[]']").val();
		var task_id = $("input:hidden[name='task_id']").val();
		$.post(APP_PATH+"/Ajax/moveTaskTo", {
			task_id : task_id,
			move_to_ids : move_to_ids
		}, function(data, st) {
			alert(data);
			self.opener.location.reload();window.close();
		});
	})
 
    
	$("#do_notify").click(function(){
		$("#choose-notify").modal("show");
	})
        
});