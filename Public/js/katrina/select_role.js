$(document).ready(function() {

	$('#sel_depart').change(function() {
		// alert($(this).children('option:selected').val());
		var str = $(this).children('option:selected').val();
		var strs = new Array(); // 定义一数组
		strs = str.split(";"); // 字符分割
		$("#sel_next_exec_person").empty();
		for (i = 0; i < strs.length; i++) {
			var tmpstrs = new Array();
			tmpstrs = strs[i].split("|");
			if (tmpstrs.length >= 2) {
				$("<option value='"+tmpstrs[0]+"'>"+tmpstrs[1]+"</option>").appendTo("#sel_next_exec_person");
			}
		}
	})
});

function alertMessage(obj, msg) {
	msg = "<font color=red>" + msg + "</font>";
	//  $('#div_show_msg').text("");// 清空数据
	$('#font_msg').html(msg); // 添加Html内容，不能用Text 或 Val
	$('#div_show_msg').css("left", obj.offset().left);
	$('#div_show_msg').css("top", obj.offset().top + obj.outerHeight());
	$('#div_show_msg').css("position", "absolute");
	$('#div_show_msg').show();
	setTimeout("$('#div_show_msg').css('display','none');", 3000)
}
