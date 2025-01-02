<?php
$host= $_SERVER['SERVER_NAME']; 

if(preg_match('/ops.yungongfang.com/',$host,$match)) {
	print "<script>document.location='http://ops.yungongfang.com/yungongfang'</script>";
}