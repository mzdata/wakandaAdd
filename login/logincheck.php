<?php
 session_start();
header ( "Content-Type:text/html;charset=utf-8" );
require_once("../Conf/authorization_config.php");

 error_reporting(E_ERROR);
$myname = addslashes($_REQUEST["myname"]);
$mypass = addslashes($_REQUEST["mypass"]);
$validatecode = addslashes($_REQUEST["validatecode"]);
if( strtolower($validatecode ) != strtolower($_SESSION["verify"]))
{
 
}	
//连接数据库，校验帐户密码
 
if(MYBACKGROUPD<2)
{
	$_SESSION[DBNAME."myname"]= OPUSER; 
	$_SESSION[DBNAME."auth"]= "OPUSER"; 
	print "<script >document.location='../index.php/Index/index';</script>"; 
	die;
}
 

if($myname===SYSUSER&&$mypass===SYSPASSWORD )
{
	$_SESSION[DBNAME."myname"]= $myname; 
	$_SESSION[DBNAME."auth"]= "SYSUSER"; 
	print "<script >document.location='../index.php/Index/index';</script>"; 
}else if($myname===OPUSER&&$mypass===OPPASSWORD )
{
	$_SESSION[DBNAME."myname"]= $myname; 
	$_SESSION[DBNAME."auth"]= "OPUSER"; 
	print "<script >document.location='../index.php/Index/index';</script>"; 
}
else
{
	
	print "<script >alert(\"error login user or password\");</script>";
	print "<script >document.location='index.html';</script>"; 
}
 

 

	function getOneResult($sql,$link)
	{ 
		$result=mysqli_query($link,$sql); 
		$ret="";
		if($result)
		{
			if($row = mysqli_fetch_array($result))
			{ 
				$ret=$row[0];
		
			}  
			 mysqli_free_result($result); 
			
		} 

		return $ret;

	}
?>