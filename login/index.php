<?php 

 session_start();

header ( "Content-Type:text/html;charset=utf-8" );
error_reporting(E_ERROR);
		  
include_once '../Conf/authorization_config.php';
$config = require("../Conf/config.php"); 
 
$title= $config["TITLE"]; 
//查看是否有权限，如果有直接到首页
$mail =  $_SESSION [DBNAME."mail"] ;
 
   
if(!empty($mail))
{
	
	print "<script >document.location='../index.php/Index/index';</script>"; 
	die;
} 


// oauth认证方式开始 //setp 3
$oauth = 0;
if ($oauth == 1) {
	$myFrom = "syspush.meilishuo.com/opssys/login/index.php";
	$access_token = $_REQUEST ["access_token"];
	$mail = $_REQUEST ["mail"];
	$name = $_REQUEST ["name"];
	if (empty ( $access_token )) {
		header ( "location:http://sysplat.meilishuo.com/operdb/oauth/index.php?from=$myFrom" );
	} else {
		// 取得用户信息，取失败的再去登陆
		$key = "access_token|$access_token";
		$url = "http://172.16.4.63/operdb/interface/getRedis.php?key=$key";

		$cc = file_get_contents ( $url );
		$tmpArr = preg_split ( '/\|/', $cc, - 1, PREG_SPLIT_NO_EMPTY );
		if (count ( $tmpArr ) < 2) {
			header ( "location:http://sysplat.meilishuo.com/opsdev/operdb/oauth/index.php?from=$myFrom" );
			die ();
		}
		$loginMail = $tmpArr [0];
		$myname = preg_replace ( '/@.*/', '', $loginMail );
		$zh_name = $tmpArr [1];
		$link = mysqli_connect ( SERVER, USERNAME, PASSWORD ) or die ( "connection failed" );

		mysqli_query ( "set names 'utf8'", $link );
		mysqli_select_db ( DBNAME, $link );

		$md5pass = md5 ( $mypass );
		$sql = "select count(*) from users where login='$myname'  ";

		$checkret = getOneResult ( $sql, $link );
			

		mysqli_close ( $link );
		// 取成功了，清除这个redis
		$key = "access_token|$access_token";
		$delUrl = "http://172.16.4.63/operdb/interface/delRedis.php?key=$key";
		file_get_contents ( $delUrl );


		$checkret = getOneResult($sql,$link);


		//增加一个发起者用户
		if(	$checkret ==0 && !empty($myname))
		{
			//http://speed.meilishuo.com/api/userInfo?mail=wenjiezeng@meilishuo.com
			$url = "http://speed.meilishuo.com/api/userInfo?mail=$myname";
			$cc = file_get_contents($url);
			$jd = json_decode($cc,true);
			$name_c = $jd["data"]["name_c"];
			$getPhone = $jd["data"]["phone"];

			$sql = "insert into users(id,role_id,login,email,phone,created_at,updated_at,zh_name,define_auth,reporting,department,status_flag)
			values(NULL,1,'$myname','$myname"."@meilishuo.com"."','$getPhone',now(),now(),'$name_c','','','',0);";

			mysqli_query($link,$sql);
			$user_id = mysqli_insert_id($link);

			$sql = "insert into user_roles( id, user_id, role_id,created_at,updated_at) values(NULL,$user_id,1,now(),now())";

			mysqli_query($link,$sql);
			$checkret =1;
		}

		if ($checkret == 0) {
			print "<script >alert(\"未被".DBNAME."授权的用户，请联系wenjiezeng\");</script>";
			print "<script >document.location='index.html';</script>";
		} else {
			$_SESSION [DBNAME . "myname"] = $myname;
				
			$uri = $_SESSION [DBNAME . "REQUEST_URI"];
				
			if (! empty ( $uri ) && !preg_match('/speed/',$uri,$match)&& !preg_match('/Authorization/',$uri,$match)) {


				print "<script >document.location='$uri';</script>";
			} else {
				print "<script >document.location='../index.php/Index/index';</script>";
			}
		}
	}

	die ();
}
function getOneResult($sql, $link) {
	$result = mysqli_query ( $link,$sql );
	$ret = "";
	if ($result) {
		if ($row = mysqli_fetch_array ( $result ,MYSQLI_NUM)) {
			$ret = $row [0];
		}
		mysqli_free_result ( $result );
	}

	return $ret;
}
// oauth认证方式结束
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<style type="text/css">
<!--
a{ color:#008EE3}
a:link  { text-decoration: none;color:#008EE3}
A:visited {text-decoration: none;color:#666666}
A:active {text-decoration: underline}
A:hover {text-decoration: underline;color: #0066CC}
A.b:link {
	text-decoration: none;
	font-size:12px;
	font-family: "Helvetica,微软雅黑,宋体";
	color: #FFFFFF;
}
A.b:visited {
	text-decoration: none;
	font-size:12px;
	font-family: "Helvetica,微软雅黑,宋体";
	color: #FFFFFF;
}
A.b:active {
	text-decoration: underline;
	color: #FF0000;

}
A.b:hover {text-decoration: underline; color: #ffffff}

.table1 {
	border: 1px solid #CCCCCC;
}
.font {
	font-size: 12px;
	text-decoration: none;
	color: #999999;
	line-height: 20px;
	

}
.input {
	font-size: 12px;
	color: #999999;
	text-decoration: none;
	border: 0px none #999999;


}

td {
	font-size: 12px;
	color: #007AB5;
}
form {
	margin: 1px;
	padding: 1px;
}
input {
	border: 0px;
	height: 26px;
	color: #007AB5;

	.unnamed1 {
	border: thin none #FFFFFF;
}
.unnamed1 {
	border: thin none #FFFFFF;
}
select {
	border: 1px solid #cccccc;
	height: 18px;
	color: #666666;

	.unnamed1 {
	border: thin none #FFFFFF;
}
body {
	background-repeat: no-repeat;
	background-color: #9CDCF9;
	background-position: 0px 0px;

}
.tablelinenotop {
	border-top: 0px solid #CCCCCC;
	border-right: 1px solid #CCCCCC;
	border-bottom: 0px solid #CCCCCC;
	border-left: 1px solid #CCCCCC;
}
.tablelinenotopdown {

	border-top: 1px solid #eeeeee;
	border-right: 1px solid #eeeeee;
	border-bottom: 1px solid #eeeeee;
	border-left: 1px solid #eeeeee;
}
.style6 {FONT-SIZE: 9pt; color: #7b8ac3; }

-->
</style>
</head>
<body>
 
<table width="681" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:120px">
<tr><td><h3><?php echo $title; ?></h3></td></tr>
  <tr>
    <td width="353" height="259" align="center" valign="bottom" background="Images/login_1.gif"><table width="90%" border="0" cellspacing="3" cellpadding="0">
      <tr>
        <td align="right" valign="bottom" style="color:#05B8E4">
         </td>
      </tr>
    </table></td>
    <td width="195" background="Images/login_2.gif"><table width="190" height="106" border="0" align="center" cellpadding="2" cellspacing="0">
      <form method="post" onSubmit="return chk(this);" name="NETSJ_Login" action="logincheck.php" >
            <tr>
              <td height="50" colspan="2" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td width="60" height="30" align="left">登陆名称</td>
              <td><input name="myname" type="TEXT" style="background:url(Images/login_6.gif) repeat-x; border:solid 1px #27B3FE; height:20px; background-color:#FFFFFF" id="myname" size="14"></td>
            </tr>
            <tr>
              <td height="30" align="left">登陆密码</td>
              <td><input name="mypass" TYPE="Password" style="background:url(Images/login_6.gif) repeat-x; border:solid 1px #27B3FE; height:20px; background-color:#FFFFFF" id="mypass" size="16"></td>
            </tr>
            <tr>
              <td height="30"> 验 证 码 </td>
			  <td><input name="Code" type="text" id="Code" size="4" style="background:url(Images/login_6.gif) repeat-x; border:solid 1px #27B3FE; height:20px; background-color:#FFFFFF" maxlength="4">
			  <img src="validatecode.php" width="50" height="24" />
		      </td>
            </tr>
            <tr>
              <td height="40" colspan="2" align="center"><img src="Images/tip.gif" width="16" height="16"> 请勿非法登陆！</td>
          <tr>
              <td colspan="2" align="center"><input type="submit" name="submit" style="background:url(Images/login_5.gif) no-repeat" value=" 登  陆 "> 
			  <input type="reset" name="Submit" style="background:url(Images/login_5.gif) no-repeat" value=" 取  消 "></td>
            <tr>
              <td height="5" colspan="2"></td>
        </form>
    </table></td>
    <td width="133" background="Images/login_3.gif">&nbsp;</td>
  </tr>
  <tr>
    <td height="161" colspan="3" background="Images/login_4.gif"></td>
  </tr>
</table>
</body>
</html>