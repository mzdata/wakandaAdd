
$(document).ready(function() {
	$("#search_person").keyup(function() {
		var search_key = $("#search_person").val();
		if (search_key.length < 2) {
			return;
		}
		$.post(APP_PATH+"/Ajax/searchUser", {
			search_key : search_key
		}, function(data, st) {
			$('#select_1').empty();
			$(data).appendTo('#select_1');
		});
	});
    
    // 移到右边
    $('#add').click(function() {
    // 获取选中的选项，删除并追加给对方
            $('#select_1 option:selected').appendTo('#select_2');
    });
    // 移到左边
    $('#remove').click(function() {
            $('#select_2 option:selected').appendTo('#select_1');
    });
    //全部移到右边
    $('#add_all').click(function() {
            //获取全部的选项,删除并追加给对方
            $('#select_1 option').appendTo('#select_2');
    });
    //全部移到左边
    $('#remove_all').click(function() {
            $('#select_2 option').appendTo('#select_1');
    });
    //双击选项
    $('#select_1').dblclick(function(){ //绑定双击事件
            //获取全部的选项,删除并追加给对方
            $('#select_1 option:selected').appendTo('#select_2');
    });
    //双击选项
    $('#select_2').dblclick(function(){
      $('#select_2 option:selected').appendTo('#select_1');
    });
    
    //还原
    $('#revert').click(function(){
      var data = $('#div').html();
      $('#select_2').html(data);
    });
    
    //必须要让select_2里面的option都选中，防止用户仅部分选择了select_2中的选项
    $("#sub").click(function(){
         $("#select_2").find("option").attr("SELECTED","SELECTED");
    });
});