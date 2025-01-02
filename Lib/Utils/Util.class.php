<?php

import("@.Utils.Smtp");
import("@.Utils.CertificationAction");
import("@.Utils.GenFunc");

include_once 'Conf/enum_config.php';
include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';


class Util {

	public static function EnPwd($password){
		$command = "\"C:\Program Files\Java\jdk-1.8\bin\java.exe\" -cp D:/wamp7/www/wakandaAdd/tools/java EnPwd  $password\n"; 
		if(MYBACKGROUPD>=2){
			$command="/usr/local/bin/java   -cp /data/wakandaAdd/tools/java EnPwd  $password\n"; 
		}

		$output = shell_exec($command);
		return $output;
	}


	public static function AppIdAppSecretGenerator($appId){
		$command = "\"C:\Program Files\Java\jdk-1.8\bin\java.exe\" -cp D:/wamp7/www/wakandaAdd/tools/java AppIdAppSecretGenerator  $appId\n"; 
		if(MYBACKGROUPD>=2){
			$command="/usr/local/bin/java   -cp /data/wakandaAdd/tools/java AppIdAppSecretGenerator  $appId\n"; 
		}

		$output = shell_exec($command);
		return $output;
	}
		
	public static function getOneResult($sql, $link) {
		$result = mysqli_query ( $link,$sql );
	
		$ret = "";
		if ($result) {
		if ($row = mysqli_fetch_array ( $result,MYSQLI_NUM)) {
			
			$ret = $row [0];
		}
		mysqli_free_result ( $result );
		}

		$errorMsg = mysqli_error($link);
		if(!empty($errorMsg)) {
			//print $errorMsg."=$sql\n";
		}
		
		return $ret;
		}

		public function chat_one_network($query){ 
			$post='{"query":"'.$query.'"}';
			//print $post;
			//curl "http://39.100.3.162:14003/ai/chat/chat_one_query"
			
			$urlai =  "http://39.100.3.162:14003/ai/chat/chat_one_network"; 
			if(MYBACKGROUPD>=2){
				$urlai =  "http://127.0.0.1:14003/ai/chat/chat_one_network"; 
			}
	
			$addData_header_txt="Content-type:application/json";
			$cc =  Util::sendPostAddHeader($urlai,$post,$addData_header_txt );
			return $cc;
		}


	public function chat4_task($taskId){
 
		$post='{"query":"'.$taskId.'"}';
		print $post;
		//curl "http://39.100.3.162:14003/ai/chat/chat4_task"
		
		$urlai =  "http://39.100.3.162:14003/ai/chat/chat4_task"; 
		if(MYBACKGROUPD>=2){
			$urlai =  "http://127.0.0.1:14003/ai/chat/chat4_task"; 
		}

		$addData_header_txt="Content-type:application/json";
		$cc =  Util::sendPostAddHeader($urlai,$post,$addData_header_txt );
		return $cc;
	}



		
	public function chat4_one_base64($query){

		$queryBase64=base64_encode($query);
		$post='{"query":"'.$queryBase64.'"}';
		//print $post;
		//curl "http://39.100.3.162:14003/ai/chat/chat_one_query"
		
		$urlai =  "http://39.100.3.162:14003/ai/chat/chat4_one_base64"; 
		if(MYBACKGROUPD>=2){
			$urlai =  "http://127.0.0.1:14003/ai/chat/chat4_one_base64"; 
		}

		$addData_header_txt="Content-type:application/json";
		$cc =  Util::sendPostAddHeader($urlai,$post,$addData_header_txt );
		return $cc;
	}


	
 	public function chat_one_base64($query){

		$queryBase64=base64_encode($query);
		$post='{"query":"'.$queryBase64.'"}';
		//print $post;
		//curl "http://39.100.3.162:14003/ai/chat/chat_one_query"
		
		$urlai =  "http://39.100.3.162:14003/ai/chat/chat_one_base64"; 
		if(MYBACKGROUPD>=2){
			$urlai =  "http://127.0.0.1:14003/ai/chat/chat_one_base64"; 
		}

		$addData_header_txt="Content-type:application/json";
		$cc =  Util::sendPostAddHeader($urlai,$post,$addData_header_txt );
		return $cc;
	}


	public function chat_one_txt($query){
 
		$post='{"query":"'.$queryBase64.'"}';
		//print $post;
		//curl "http://39.100.3.162:14003/ai/chat/chat_one_query"
		
		$urlai =  "http://39.100.3.162:14003/ai/chat/chat_one_query"; 
		if(MYBACKGROUPD>=2){
			$urlai =  "http://127.0.0.1:14003/ai/chat/chat_one_query"; 
		}

		$addData_header_txt="Content-type:application/json";
		$cc =  Util::sendPostAddHeader($urlai,$post,$addData_header_txt );
		return $cc;
	}
	
	function getTblStruct( $USERNAME,$PASSWORD, $dbNameStr,&$tableTitleArr )
	{
	
			//print $dbNameStr."\n";
			$dbName = preg_replace('/.*\|/', '', $dbNameStr);
			$ipStr = preg_replace('/\|.*/', '', $dbNameStr);
			$tmpArr = preg_split('/:/', $ipStr);
			$ip = $tmpArr[0];
			$port = $tmpArr[1];
			$SERVER="$ip:$port";
			
			$DBNAME=$dbName;

		//	print "\n######$SERVER,$USERNAME ,$PASSWORD,$DBNAME\n";
			
			$link=mysqli_connect($SERVER,$USERNAME ,$PASSWORD)or die("connection failed" . mysqli_error());
			
			mysqli_query($link,"set names 'utf8'");
			mysqli_select_db($link,$DBNAME );
			//mysqli_query($tmpSql);
			$tmpSql = "show table status";
			$result=mysqli_query($link,$tmpSql);

			
			if($result)
			{
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
				{ 
					$tableName = $row["Name"];
					$Comment = $row["Comment"];
					if(strlen($Comment)<2) $Comment=$tableName;
					$tableTitleArr[$tableName]=$Comment;

					
				}
				mysqli_free_result($result);
			} 
			
			$tmpSql = "show tables";
			$result=mysqli_query($link,$tmpSql);
			
			$retArr = array();
			if($result)
			{
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
				{ 
					$bgetTitle = 0;
					if(!empty($titleStr)) $bgetTitle =1;
					foreach($row as $k=>$v)
					{
						if(!$bgetTitle) $titleStr.="$k,";
						$v = str_replace(","," ",$v);
						//防止几百张表情况
						$v = preg_replace('/\d+$/', "number", $v);
						$retArr[$v]=array();
						
					}
					
				}
				mysqli_free_result($result);
			} 
			

			foreach($retArr as $tbl => $v)
			{
				$tmpSql = "select COLUMN_NAME,COLUMN_TYPE,COLUMN_COMMENT from information_schema.columns where table_schema = '$dbName'   and table_name = '$tbl' ";
				$result=mysqli_query($link,$tmpSql);
		
				if($result)
				{
					$tmpArr = array();
					
					while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
					{
					
						$COLUMN_NAME = $row["COLUMN_NAME"];
						$tmpArr[ $COLUMN_NAME ] = $row;
						
					}
					mysqli_free_result($result);
					$retArr[$tbl]=$tmpArr;
				}

				$retArr[$tbl]["mztableTitle"]=$tableTitleArr[$tbl];
				
			}
			mysqli_close($link); 
		
			
			foreach ($retArr as $tbl => $tmpArr)
			{
				foreach($tmpArr as  $COLUMN_NAME  => $row)
				{
			
				//print $tbl.".".$COLUMN_NAME."\n";
				}
			}
			return $retArr;
	}




	public function saveLocalPic($srcFile){
		$today = date("Ymd",time()); 
	  
		
		$ext = Util::get_extension($pic);
		if(empty($ext)){
			$ext="png";
		}
		$mark = microtime(1);

		$destFileName= md5($srcPic.$mark  ).".".$ext;

		print "uploadAgent($srcFile,$destFileName)";
		
		$ret = Util::uploadAgent($srcFile,$destFileName);
		print $ret."\n";

		$retArr = json_decode($ret,true);

		  
		$returl =  $retArr["returl"];  
		print "returl=".$returl."\n";
		return $returl;
	}
	

	

	public function saveUrlPic($pic,$addData_header_txt){
		$today = date("Ymd",time()); 
					 
		$tmpDir =   PIC_WORK_DIR.$today;
		mkdir($tmpDir);
		
		$ext = Util::get_extension($pic);
		if(empty($ext)){
			$ext="png";
		}
		$mark = microtime(1);

		$destFileName= md5($srcPic.$mark  ).".".$ext;
	 
		$srcFile= $tmpDir."/".$destFileName;
		$cc="";
		$pic = str_replace('http://','https://',$pic);
		if(preg_match('/https/',$pic,$match)){
			$cc = Util::sendPostAddHeader($pic,"",$addData_header_txt);

		}else{
			
			$cc = Util::vcurl($pic);
			
			//$cc = file_get_contents($pic);
		}

		print "cclen=".strlen($cc)."\n<br>";
	 
		// 打开文件以供写入，如果文件不存在则创建
		$file = fopen($srcFile, "w");
		
		// 检查文件是否成功打开
		if ($file) {
			// 写入数据
			 
			fwrite($file, $cc); 
			// 关闭文件句柄
			fclose($file);
		//	echo "文件写入成功，并且句柄已关闭。";
		} else {
		//	echo "文件无法打开。";
		} 
		

		print "uploadAgent($srcFile,$destFileName)";
		
		$ret = Util::uploadAgent($srcFile,$destFileName);
		print $ret."\n";

		$retArr = json_decode($ret,true);

		  
		$returl =  $retArr["returl"];  
		print "returl=".$returl."\n";
		return $returl;
	}
	


	public function getSearchResult($milvus_db,$searchLine){

		$myBookModel = D("MyBook");
		$list = $myBookModel->where("milvus_db='$milvus_db'")->select();
		$tbl_nmber=$list[0]["tbl_nmber"];
		$uuid=$list[0]["uuid"];



		$tblName = "my_book".$tbl_nmber;
		$md5=md5($milvus_db.$searchLine);
	
		$taskUUID =  $md5;
		
		$taskFile=MYAPPROOT."/dest/task".$taskUUID;

		error_reporting(	E_WARNING);
		{ 
			$searchLine=preg_replace('/\r|\n/','',$searchLine);
				file_put_contents($taskFile,$searchLine);

				$command = "C:\Users\booksoft\AppData\Local\Programs\Python\Python311\python.exe D:/wamp7/www/db_auth/tools/searchLine.py   $milvus_db  $taskFile $tblName  $uuid \n"; 
				if(MYBACKGROUPD>=2){
					$command="/opt/python311/bin/python3    /data/db_auth/tools/searchLine.py   $milvus_db  $taskFile $tblName  $uuid \n"; 
				}

			//	print "command=$command \n<br>";
			//	print microtime(1)."=bt\n<br>";

				$output = shell_exec($command);
			 
			//	print microtime(1)."=et\n<br>";
			//	print $output;
		 
		 
			 /*
				$mychDir = MYAPPROOT."/tools/"; 
				chdir($mychDir);  
				print "try  $command"; 
				$output = array();  
				
				exec($command, $output, $returnVar);	 
				// 打印输出结果
				foreach ($output as $line) {
					echo $line . "\n";
				}
				print $returnVar;
				*/

				//print "finish searchLine.py";
		}

		$cc =  file_get_contents($taskFile.".result");
		$ccArr = json_decode($cc,true);
		//print_r($ccArr);

		$retArr = array();
		
		$myBookModel = D("MyBook".$tbl_nmber);
	

		foreach($ccArr as $md5){

		 $listTmp = $myBookModel->where("milvus_id='$md5'")->select();
	 //	print_r($myBookModel);
		 $part_txt = $listTmp[0]["part_txt"];
		 $retArr[]=$part_txt;


 
	 }

		 //print_r($retArr);
		 return $retArr;

	}

	
	public  function uploadAgent($srcFile,$destFileName){

		$url = LOCALdb_auth."interface/oss/uploadoss/uploadAgent.php";
		$post="srcFile=$srcFile&destFileName=$destFileName";
		$ret = Util::vcurl($url,$post);
		return $ret; 
	}


	
		//去除标点符号
function removeBDMark($str){
	  if($str==null||empty($str)){
        return $str;
    }
 	//支持 . - _
	 $str = str_replace(".","myDianMark",$str);
	 $str = str_replace("-","myzhongMark",$str);
	 $str = str_replace("_","mylowMark",$str);
	  $pattern = array(
		 "/[[:punct:]]/i", //英文标点符号 
		 '/[ ]{2,}/'
	 );
	 $str = preg_replace($pattern, '', $str);
	 //支持 . - _
	 $str = str_replace("myDianMark",".",$str);
	 $str = str_replace("myzhongMark","-",$str);
	 $str = str_replace("mylowMark","_",$str);
    return $str;    

}
	public function getRemoteIp(){ 
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		
		}
		elseif(!empty($_SERVER["REMOTE_ADDR"])){
		$cip = $_SERVER["REMOTE_ADDR"];
		
		}
		else{
		$cip = "无法获取！";
		
		} 
		return $cip;
		
		}


		function sendAlarmPhoneAndMail($pretitle,$msg,$enPhone,$enMail){

			 
		
			date_default_timezone_set('PRC');
			$url = "http://jzbpreagent.jdcloud.local/jzbadd/interface/alarm/alarmGroupAll.php";
		
			$subject="$pretitle:".$msg;
			$content="$pretitle:".$msg;
		 
			$timeMark =time();//报警时间戳例 1636423341
			$key = "202111B43,2"; //报警加密秘钥，不需要改
			$sign = md5(trim($subject).trim($content).trim($enPhone).trim($enMail).$timeMark.$key); //数字签名
		
			$post = "subject=$subject&content=$content&enPhone=$enPhone&enMail=$enMail&timeMark=$timeMark&sign=$sign";
		
			
			 $cc = Util::vcurl($url,$post); //这个脚本只提供数据，不报警
			 print $cc;
				 
		}


//Util::sendAlarmMail("zengwenjie@jd.com","这是一个测试","这是一个测试");
function sendAlarmMail($enMail,$subject,$content){

	date_default_timezone_set('PRC');
 
 
	 $enPhone="15010796740"; //多个以英文逗号分割 
	 $timeMark ="1636451691";//报警时间戳例 1636423341
	 $key = "202111B43,2"; //报警加密秘钥，不需要改
	 $base = trim($subject).trim($enPhone).trim($enMail).$timeMark.$key; //不要内容，因为带内容容易出错
	  
	$sign = md5($base); //数字签名
	 
	
	 
	$url = "http://jzbpreagent.jdcloud.local/jzbadd/interface/alarm/alarmMailAll.php"; 
	
	$jsonArr=array();
	$jsonArr["subject"]=$subject;
	$jsonArr["content"]=$content;
	$jsonArr["enPhone"]=$enPhone;
	$jsonArr["enMail"]=$enMail;
	$jsonArr["timeMark"]=$timeMark;
	$jsonArr["sign"]=$sign;
	
	 $post=json_encode($jsonArr);
	$cc = Util::vcurlHttps($url, $post);
	print $cc;
	
	print "发送成功";

  
     
     //return $cc;
}


public static function sendRandMail($e_mail,$phone)
{ 

	$rand = Util::randomcode(6);
	if(MYBACKGROUPD>1){
		$redis = new Redis();
		$redis->connect(REDIS_HOST, REDIS_PORT);
		$pass=REDIS_PASSWORD; 
		if(!empty($pass)){ 
		$auth=$redis->auth("$pass");//设置密码
		}
	
	 
		$key = "phonecmd".$rand;
		$redis->setex($key,600,$phone);
		
	
		$redis->close();
	}


	
	$msg = "短命令验证码为: ".$rand." (10分钟内有效)";
	print $e_mail;
 

	date_default_timezone_set('PRC');
    $url = "https://jzb-app-pre.jdcloud.com/jzbadd/interface/alarm/alarmGroupAll.php";

    $subject= $msg;
    $content= $msg;
    $enPhone=""; //多个以英文逗号分割
    
    $enMail= $e_mail;//多个以英文逗号分割
    $timeMark =time();//报警时间戳例 1636423341
    $key = "202111B43,2"; //报警加密秘钥，不需要改
    $sign = md5(trim($subject).trim($content).trim($enPhone).trim($enMail).$timeMark.$key); //数字签名

    $post = "subject=$subject&content=$content&enPhone=$enPhone&enMail=$enMail&timeMark=$timeMark&sign=$sign";

    
     $cc = Util::vcurlHttps($url,$post); //这个脚本只提供数据，不报警
     print $cc;
//print "\ncc=".$cc;

print "发送成功";

	
}


	public static function sendRand($phone,$rand){ 
		$redis = new Redis();
		$redis->connect(REDIS_HOST, REDIS_PORT);
		$pass=REDIS_PASSWORD; 
		if(!empty($pass)){ 
		$auth=$redis->auth("$pass");//设置密码
		}
	
		
	 //   $key = "limit".$phone;
	//	$value = $redis->get($key);
	//	i($value==1){
	//		$redis->close();
	//		die("limit 30 seconds");
	//	}
	//    $redis->setex($key,30,1);
	
	
		$key = "$phone.$rand";
		$redis->setex($key,120,1);
		
	
		$redis->close();
	
		
		$msg = "验证码为:".$rand."(2分钟内有效)";
	 
	
		date_default_timezone_set('PRC');
	   // $url = "https://jzb-app-pre.jdcloud.com/jzbadd/interface/alarm/alarmGroupAll.php";
	   if(MYBACKGROUPD<2){//外网网代理发送	   
		$url="https://apps.jzb.beijing.gov.cn/jzbadd/postAlarm/agentClxxAlarm.php";
	
	   }else{	   //线上内网代理发送
		$url=  "http://172.16.86.132/jzbadd/postAlarm/agentClxxAlarm.php"; 
	   }
		$subject= $msg;
		$content= $msg;
		$enPhone=$phone; //多个以英文逗号分割
		$enMail="";//多个以英文逗号分割
		$timeMark =time();//报警时间戳例 1636423341
		$key = "202111B43,2"; //报警加密秘钥，不需要改
	   // $sign = md5(trim($subject).trim($content).trim($enPhone).trim($enMail).$timeMark.$key); //数字签名
	
	   // $post = "subject=$subject&content=$content&enPhone=$enPhone&enMail=$enMail&timeMark=$timeMark&sign=$sign";
	
	   // $cc = Util::vcurlHttps($url,$post);   
	//	print $cc."\n";
	  
	
	$base = trim($subject).trim($content).trim($enPhone).trim($enMail).$timeMark.$key;
	//print "base=$base";
	$sign = md5($base); //数字签名
	//echo "sign=$sign";
	$post = "subject=$subject&content=$content&enPhone=$enPhone&enMail=$enMail&timeMark=$timeMark&sign=$sign";
	
	$urlGet = $url."?".$post;
	$cc = Util::vcurlHttps($urlGet);
	//print "\ncc=".$cc;
	
	print "发送成功";
	
		
	}
 
	public static  function sendPhoneMsg($phone,$msg){

		
		date_default_timezone_set('PRC');
	  
		$url=  "http://172.16.86.132/jzbadd/postAlarm/agentClxxAlarm.php"; 
	   
		$subject= $msg;
		$content= $msg;
		$enPhone=$phone; //多个以英文逗号分割
		$enMail="";//多个以英文逗号分割
		$timeMark =time();//报警时间戳例 1636423341
		$key = "202111B43,2"; //报警加密秘钥，不需要改
 
	
		$base = trim($subject).trim($content).trim($enPhone).trim($enMail).$timeMark.$key;
		//print "base=$base";
		$sign = md5($base); //数字签名
		//echo "sign=$sign";
		$post = "subject=$subject&content=$content&enPhone=$enPhone&enMail=$enMail&timeMark=$timeMark&sign=$sign";
		
		$urlGet = $url."?".$post;
		$cc = Util::vcurlHttps($urlGet);
		//print "\ncc=".$cc;
		
		print "发送成功";
	
		 
	}

	public static function  getUUid()
	{
		$chars = md5(uniqid(mt_rand(), true));
		$uuid = substr ( $chars, 0, 8 ) . ''
				. substr ( $chars, 8, 4 ) . ''
				. substr ( $chars, 12, 4 ) . ''
				. substr ( $chars, 16, 4 ) . ''
				. substr ( $chars, 20, 12 );
		return $uuid ;
	}

	public static function is_json($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	   }


		/**
 * 导入excel文件
 * @param  string $file excel文件路径
 * @return array        excel文件内容数组
 */
public static function import_excel($file){
    // 判断文件是什么格式
    $type = pathinfo($file);
    $type = strtolower($type["extension"]);
    if ($type=='xlsx') {
        $type='Excel2007';
    }elseif($type=='xls') {
        $type = 'Excel5';
    }
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    $objReader = PHPExcel_IOFactory::createReader($type);//判断使用哪种格式
    $objReader ->setReadDataOnly(true); //只读取数据,会智能忽略所有空白行,这点很重要！！！
    $objPHPExcel = $objReader->load($file); //加载Excel文件
    $sheetCount = $objPHPExcel->getSheetCount();//获取sheet工作表总个数
    $rowData = array();
    $RowNum = 0;
    /*读取表格数据*/
    for($i =0;$i <= $sheetCount-1;$i++){//循环sheet工作表的总个数
        $sheet = $objPHPExcel->getSheet($i);
        $highestRow = $sheet->getHighestRow();
        $RowNum += $highestRow-1;//计算所有sheet的总行数
        $highestColumn = $sheet->getHighestColumn();
        //从第$i个sheet的第1行开始获取数据
        for($row = 1;$row <= $highestRow;$row++){
            //把每个sheet作为一个新的数组元素 键名以sheet的索引命名 利于后期数组的提取
            $rowData[$i][] = Util::arrToOne($sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE));
        }
    }
    /*删除每行表头数据*/
    foreach($rowData as $k=>$v){
        array_shift($rowData[$k]);
    }
   // echo '<pre>';
   // print_r($rowData);//打印结果
  //  echo '</pre>';
    return array("RowNum" => $RowNum,"Excel_Data" => $rowData);
}

function arrToOne($Array){ $arr = array(); foreach ($Array as $key => $val) { if( is_array($val) ) { $arr = array_merge($arr, Util::arrToOne($val)); } else { $arr[] = $val; } } return $arr; }


		public static function get_extension($file) {
		$ext= end ( explode ( '.', $file ) );

		$ext = preg_replace('/%.*/','',$ext);

		return $ext;
	}

	public static function  randomcode($len) {
	$srcstr = "ABCDEFGHJKMNPQRTUVWXYZ2346789";
	mt_srand ();
	$strs = "";
	for($i = 0; $i < $len; $i ++) {
		$strs .= $srcstr [mt_rand ( 0, strlen ( $srcstr ) - 1 )];
	}
	return strtoupper ( $strs );
}


public    static function getk8sArrFromDb() {
	//select fixed_ip_address,real_hostname from online_assert where is_k8s=1;

	$onlineAssertModel = D("OnlineAssert");
	$list = $onlineAssertModel->where("is_k8s=1")->select();
	$tmpArr=array();
	foreach($list as $row){

		$fixed_ip_address=$row["fixed_ip_address"];
		$real_hostname=$row["real_hostname"];
		$tmpArr[$fixed_ip_address]=$real_hostname;
	}

 
	return $tmpArr;
 
}


public function diemsg($msg) {
	$retArr = array();
	$retArr["code"]=1;
	$retArr["msg"]=$msg;
	
	print json_encode($retArr);
	die;
}


public  function sendPostAddHeader($url, $post ,$addData_header_txt   ) {

	// print "[$Cookie]"; 
 //	print "post=$post\n<br>";
	   
	 $tmpInfo = '';
  
	 $curl = curl_init ();
  
	 curl_setopt ( $curl, CURLOPT_URL, $url );
	 curl_setopt ( $curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)' );
  
   if(!empty($post)){
 
	 curl_setopt ( $curl, CURLOPT_POST, 1 );
	 curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
 
   }
  
		 $headerArr = preg_split('/\r|\n/',$addData_header_txt,-1,PREG_SPLIT_NO_EMPTY);
	 
		 curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );
 
 
  
 
	 // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	 
	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ( $curl, CURLOPT_TIMEOUT, 300000 );
	//CURLOPT_CONNECTTIMEOUT
	curl_setopt ( $curl, CURLOPT_CONNECTTIMEOUT, 300000 );
	 curl_setopt ( $curl, CURLOPT_HEADER,0 );
	 curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	 $tmpInfo = curl_exec ( $curl );
	 if (curl_errno ( $curl )) {
		 echo '<pre><b>错误:</b><br />' . curl_error ( $curl );
	 }
	 curl_close ( $curl );
	 return $tmpInfo;
 }
 
 

public    static function  sendPostData($url, $post ,$Cookie   ) {

   // print "[$Cookie]";
	$Cookie = preg_replace('/\s/','',$Cookie);
//	print "post=$post\n<br>";

	$tmpInfo = '';

	$curl = curl_init ();

	curl_setopt ( $curl, CURLOPT_URL, $url );
	curl_setopt ( $curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)' );


		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );

     $headerArr = array(
    'Content-Type: application/json',
    'accept: application/json',
    'stationUUid:sh',
 'Cookie:' .$Cookie ,
    'Content-Length: ' . strlen($post),

	);
//	print_r( $headerArr);

	curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );




	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
	curl_setopt ( $curl, CURLOPT_HEADER,0 );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	$tmpInfo = curl_exec ( $curl );
	if (curl_errno ( $curl )) {
		echo '<pre><b>curl错误:</b><br />' . curl_error ( $curl );
	}
	curl_close ( $curl );
	return $tmpInfo;
}

	static function getUpDownFlagData($today){

			$weatherUpdowndataModel = D("WeatherUpdowndata");
			$list = $weatherUpdowndataModel->where("time_ym='$today'")->select();
			$todayArr = $list[0];
			return $todayArr;
	}

public static function  getAgentHttp($url, $post = '' ){
			set_time_limit(10);
	$agentUrl = "https://jzb-clxx-online.jcloudec.com/jzbadd/interface/agentHttpData.php?httpUrl=$url&post=$post";

	return Util::vcurlHttps($agentUrl,$post);
}

public static function  getAgentHttp2($url  ){
	set_time_limit(10);
$agentUrl = "https://jzb-clxx-online.jcloudec.com/jzbadd/interface/agentHttpData2.php?httpUrl=".base64_encode($url);

return file_get_contents($agentUrl);
}
public static  function vcurlHttps($url, $post = '', $cookie = '', $cookiejar = '', $referer = ''){
        $tmpInfo = '';
        $cookiepath = getcwd().'./'.$cookiejar;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
        if($referer) {
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        } else {
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        }
        if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
		//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        if($cookiejar) {
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        }
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 100);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>curl https错误:</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
    }


	public static  function vcurlHttpsMax($url, $post = '', $cookie = '', $cookiejar = '', $referer = ''){
        $tmpInfo = '';
        $cookiepath = getcwd().'./'.$cookiejar;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
        if($referer) {
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        } else {
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        }
        if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
		//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        if($cookiejar) {
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        }
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1000);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>curl错误:</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
    }

public static  function vcurlHttpsHeader($url, $addHeaderArr,$post = '', $cookie = '', $cookiejar = '', $referer = ''){
        $tmpInfo = '';
        $cookiepath = getcwd().'./'.$cookiejar;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
        if($referer) {
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        } else {
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        }
        if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		//	print "set post=$post\n";
        }
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
		//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        if($cookiejar) {
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        }
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 100);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


	    $headerArr = array(
	);

	foreach($addHeaderArr as $k=>$v) {
		$headerArr[]="$k:$v";
	}

	curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );

		$tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>curl错误:</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
    }


	static function getTeamAccessToken($openTeamId,$appKey,$appSecret){
		$appAccessToken = Util::getThirdAppAccessToken($appKey,$appSecret);
		 $url = TOKENBASE_URL."/open-api/auth/v1/team_access_token";
		$postArr = array(
		"appAccessToken"=>$appAccessToken,
		"openTeamId"=>$openTeamId,
		);
		$post = json_encode($postArr);
	 	$ret = Util::getHttpsRet($url,$post);
		$retArr=json_decode($ret,true);
		$teamAccessToken=$retArr["data"]["teamAccessToken"];
		return $teamAccessToken;
	}

	static function getTeamAccessTokenArr( $openTeamId,$appKey,$appSecret){
		$appAccessToken = Util::getThirdAppAccessToken($appKey,$appSecret);
		$url = TOKENBASE_URL."/open-api/auth/v1/team_access_token";

		$postArr = array(
		"appAccessToken"=>$appAccessToken,
		"openTeamId"=>$openTeamId,
		);
	//	print_r($postArr);
		$post = json_encode($postArr);
 		$ret = Util::getHttpsRet($url,$post);
		$retArr=json_decode($ret,true);
		return $retArr;
	}
	static function getDeptInfo($teamAccessToken, $deptId){
		$url = TOKENBASE_URL."/open-api/contact/v1/department/info/get?deptId=".$deptId;

		$addHeaderArr = array("Authorization"=>"Bearer ".$teamAccessToken);

		//print $url;
	//	print_r($addHeaderArr);

		$retStr = Util::vcurlGetHeaderArr($url, $addHeaderArr); //addHeaderArr k=>v 形式
		$retArr = json_decode($retStr,true);
		return $retArr;
	}
	static function getSigleUser($teamAccessToken, $openUserId){
		$url = TOKENBASE_URL."/open-api/contact/v1/user/single_get?openUserId=".$openUserId;

		$addHeaderArr = array("Authorization"=>"Bearer ".$teamAccessToken);

		//print $url;
	//	print_r($addHeaderArr);

		$retStr = Util::vcurlGetHeaderArr($url, $addHeaderArr); //addHeaderArr k=>v 形式
		$retArr = json_decode($retStr,true);
		return $retArr;
	}


	static function getOpenUserInfo($accessToken){
		$url = TOKENBASE_URL."/open-api/auth/v1/user_info";
		$post = "";
		$addHeaderArr = array("Authorization"=>"Bearer ".$accessToken);
		$retStr = Util::getHttpsHeaderRet($url,$post ,$addHeaderArr); //addHeaderArr k=>v 形式
		$retArr = json_decode($retStr,true);
		return $retArr;
	}

		static function getUserDeptList($userAccessToken) {
				set_time_limit(10);
			 $url = TOKENBASE_URL."/open-api/contact/v1/selector/get_dept_infos";

				$addHeaderArr = array("Authorization"=>"Bearer ".$userAccessToken);


				$retStr = Util::vcurlGetHeaderArr($url, $addHeaderArr); //addHeaderArr k=>v 形式
				$retArr = json_decode($retStr,true);
				return $retArr;


		}
		static function getUserContactList($userAccessToken) {
				set_time_limit(10);
			 $url = TOKENBASE_URL."/open-api/contact/v1/selector/get_contacts";

				$addHeaderArr = array("Authorization"=>"Bearer ".$userAccessToken);


				$retStr = Util::vcurlGetHeaderArr($url, $addHeaderArr); //addHeaderArr k=>v 形式
				$retArr = json_decode($retStr,true);
				return $retArr;


		}

//获取根文件夹

	static function get_folder($userAccessToken) {
				set_time_limit(10);
			 $url = TOKENBASE_URL."/open-api/joyspace/v1/get_folder";
//Content-Type:application/json
				$addHeaderArr = array("Authorization"=>"Bearer ".$userAccessToken,
					"Content-Type"=>"application/json"
				);

				//post
	// "teamRoot"=>"共享文件",
  //"root"=>"我的文件"


			$postArr = array(
		"folderType"=>"root"

		);

		$post =  json_encode($postArr);

	//	print_r($addHeaderArr );

	//	print "post=$post\n";

				$retStr = Util::vcurlHttpsHeader($url, $addHeaderArr,$post); //addHeaderArr k=>v 形式
				$retArr = json_decode($retStr,true);
				return $retArr;

		}


static function get_sub_folder($folderId,$userAccessToken) {
				set_time_limit(10);
			 $url = TOKENBASE_URL."/open-api/joyspace/v1/get_sub_folder";
				$addHeaderArr = array("Authorization"=>"Bearer ".$userAccessToken,
					"Content-Type"=>"application/json"
				);
			$postArr = array(
		"folderId"=>"$folderId",//"yTw54gdQyoqVQI0R3MVT"

		);
	//	print "url=$url\n";
		$post =  json_encode($postArr);
	//	print_r($addHeaderArr );
	//	print "post=$post\n";
				$retStr = Util::vcurlHttpsHeader($url, $addHeaderArr,$post); //addHeaderArr k=>v 形式
				$retArr = json_decode($retStr,true);
				return $retArr;

		}

static function get_file($folderId,$userAccessToken,$pageNum,$pageSize) {
				set_time_limit(10);
			 $url = TOKENBASE_URL."/open-api/joyspace/v1/get_file";
				$addHeaderArr = array("Authorization"=>"Bearer ".$userAccessToken,
					"Content-Type"=>"application/json"
				);
			$postArr = array(
		"folderId"=>"$folderId",
				"pageNum"=>$pageNum,
				"pageSize"=>$pageSize,
		);

		$post =  json_encode($postArr);

				$retStr = Util::vcurlHttpsHeader($url, $addHeaderArr,$post); //addHeaderArr k=>v 形式
				$retArr = json_decode($retStr,true);
				return $retArr;

		}


static function get_download_url($pageId,$userAccessToken) {
				set_time_limit(10);
			 $url = TOKENBASE_URL."/open-api/joyspace/v1/get_download_url";
				$addHeaderArr = array("Authorization"=>"Bearer ".$userAccessToken,
					"Content-Type"=>"application/json"
				);
			$postArr = array(
		"pageId"=>"$pageId" //oZQhRPGUnZ7UbSfegW3A
		);
	//	print "url=$url\n";
		$post =  json_encode($postArr);
		//print_r($addHeaderArr );
		//print "post=$post\n";
				$retStr = Util::vcurlHttpsHeader($url, $addHeaderArr,$post); //addHeaderArr k=>v 形式
				$retArr = json_decode($retStr,true);
				return $retArr;

		}

	static function getOpenUserIdAndArgs($code,$jsonStr,$appKey,$appSecret) {
		set_time_limit(10);
		 $appAccessToken = Util::getThirdAppAccessToken($appKey,$appSecret);
		 $url = TOKENBASE_URL."/open-api/auth/v1/access_token";
		$postArr = array(
		"appAccessToken"=>$appAccessToken,
		"code"=>$code,
		);
		$post = json_encode($postArr);
	//	print "getOpenUserIdAndArgs url=$url <br>\n";

	//	print "getOpenUserIdAndArgs post=$post <br>\n";
	 	$ret = Util::getHttpsRet($url,$post);
	//	print "getOpenUserIdAndArgs ret=$ret\n";
		$retArr=json_decode($ret,true);
	//	 print_r($retArr);
		$openUserId = $retArr["data"]["openUserId"];
		$openTeamId = $retArr["data"]["openTeamId"];
		$accessToken = $retArr["data"]["accessToken"];
		$thirdUserId = $retArr["data"]["thirdUserId"];

		$openUserIdShow = substr($openUserId,0,3)."****";


		$jsonArr = json_decode($jsonStr,true);
		$retArr = array();
		$retArr["appAccessToken"]=$appAccessToken;
		$retArr["thirdUserId"]=$thirdUserId;
		$retArr["accessToken"]=$accessToken;
		$retArr["openUserIdShow"]=$openUserIdShow;
		$retArr["openUserId"]=$openUserId;
		$retArr["openTeamId"]=$openTeamId;

		foreach($jsonArr as $k=>$v) {
			$retArr[$k]=$v;
		}

		return $retArr;

	}


	static function getHttpsRet($url,$post )
{

 		$referer="";

		$tmpInfo = '';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
        if($referer) {
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        } else {
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        }
        if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }


      $headerArr = array(
    'Content-Type: application/json',
    'accept: application/json',

    'Content-Length: ' . strlen($post),

	);

	curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );


        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
//curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>curl错误:</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
}

static function getHttpsHeaderRet($url,$post ,$addHeaderArr) //addHeaderArr k=>v 形式
{

 		$referer="";

		$tmpInfo = '';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
        if($referer) {
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        } else {
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        }
        if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }


      $headerArr = array(
    'Content-Type: application/json',
    'accept: application/json',

    'Content-Length: ' . strlen($post),

	);

	foreach($addHeaderArr as $k=>$v) {
		$headerArr[]="$k:$v";
	}

	curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );


        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 4);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
//curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>错误:'.$url.'</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
}




	static function getHttpsHeaderRet2($url,$post ,$addData_header_txt) //addHeaderArr k=>v 形式
{

 		$referer="";

		$tmpInfo = '';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
        if($referer) {
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        } else {
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        }
        if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }



		$headerArr = preg_split('/\r|\n/',$addData_header_txt,-1,PREG_SPLIT_NO_EMPTY);
	
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );


        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 14);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
//curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        $tmpInfo = curl_exec($curl);
		$header = curl_getinfo($curl, CURLINFO_HEADER_OUT);
	 
        if (curl_errno($curl)) {
           echo '<pre><b>错误:'.$url.'</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
}


	static function getThirdAppAccessToken($appKey,$appSecret) {
		set_time_limit(10);


		$url  =  TOKENBASE_URL."/open-api/auth/v1/app_access_token?".microtime(1);

		$postArr = array(
		"appKey"=>$appKey,
		"appSecret"=>$appSecret,
		);
		$post = json_encode($postArr);
		//print "url=$url\n";
		//print "post=$post\n<br>";

	 	$ret = Util::getHttpsRet($url,$post);
		//print "getThirdAppAccessToken ret=$ret\n<br>";

		if(empty($ret)) {

			 $returnArr = array(
					"code"=>1,
						"msg"=>"getThirdAppAccessToken 获得APP授权为空 "
					);

					print json_encode($returnArr);
					die;
		}
		$retArr=json_decode($ret,true);



		 $retCode = $retArr["code"];
		 $msg = $retArr["msg"];
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getThirdAppAccessToken 获得APP授权失败 "
					);

					print json_encode($returnArr);
					die;
		 }
		$appAccessToken = $retArr["data"]["appAccessToken"];
		return $appAccessToken;
	}


	

	static  function getLimitByDate($date,$preClass) {

		$dateShow =  date("m月d日",strtotime($date));
		$cpxxHolidayModel = D("CpxxHoliday");

		$cpxxLimitModel = D("CpxxLimit");
		$editData = $cpxxLimitModel->where("limit_day='$date'")->select();
		$limit_last = $editData[0]["limit_last"];// varchar(255) 限行尾号  7|9 如果为空表示不限行
		$weekday  = $editData[0]["weekday"];//  varchar(255) 星期几

		$lastShow = "不限行";
		$needLast = 0;
		$holidayType=0;
		$lastMatch = "";

		if(empty($preClass)) {
			$preClass="heShow";
		}

		if(!empty($limit_last)) {
			$limitArr = preg_split('/\|/',$limit_last,-1,PREG_SPLIT_NO_EMPTY);

			if(count($limitArr)>=2)  {
				$existList =  $cpxxHolidayModel->where("holiday='$date'")->select();
				if(count($existList)==0) {
					$needLast = 1;

					$lastMatch =  $limitArr[0].",".$limitArr[1];
					$lastShow = "<b>".$limitArr[0]."</b><span class=\"$preClass\">和</span><b>".$limitArr[1]."</b>";// str_replace("|","<span class=\"$preClass\">和</span>",$limit_last);
				}else {
						//holidayType=0;
						$holidayType = $existList[0]["holiday_type"];

				}
			}
		}





        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);
        $pageElement["selected"]= str_replace("Action","", get_class( $this )); $cpxxHolidayModel = D("CpxxHoliday");

		$cpxxLimitModel = D("CpxxLimit");
		$editData = $cpxxLimitModel->where("limit_day='$date'")->select();
		$limit_last = $editData[0]["limit_last"];// varchar(255) 限行尾号  7|9 如果为空表示不限行
		$weekday  = $editData[0]["weekday"];//  varchar(255) 星期几

		$lastShow = "不限行";
		$needLast = 0;
		if(!empty($limit_last)) {
			$limitArr = preg_split('/\|/',$limit_last,-1,PREG_SPLIT_NO_EMPTY);
			if(count($limitArr)>=2)  {
				$existList =  $cpxxHolidayModel->where("holiday='$date'")->select();
				if(count($existList)==0) {
					$needLast = 1;
					$lastMatch =  $limitArr[0].",".$limitArr[1];
					$lastShow = "<b>".$limitArr[0]."</b><span class=\"$preClass\">和</span><b>".$limitArr[1]."</b>";
				}
				else {
						//holidayType=0;

						$holidayType = $existList[0]["holiday_type"];
				}
			}
		}







		if($needLast==1) {

			$dataArr = array(
				"date"=>"$date",
				"dateShow"=>"$dateShow",
				"weekday"=>"$weekday",
				"limit"=>"$lastShow",
				"bjLimit"=>"7时-20时",
				"outLittleLimit"=>"9时-17时",
				"outCustomerLimit"=>"7时-9时；17时-20时",
				"gwLimit"=>"0时-24时",
				"lastMatch"=>"$lastMatch",
			);
		}
		else {
			//不限行
			$dataArr = array(
				"date"=>"$date",
				"dateShow"=>"$dateShow",
				"weekday"=>"$weekday",
				"limit"=>"不限行",
				"bjLimit"=>"不限行",
				"outLittleLimit"=>"不限行",
				"outCustomerLimit"=>"不限行",
				"gwLimit"=>"不限行",
				"lastMatch"=>"$lastMatch",
			);
		}
		$existList =  $cpxxHolidayModel->where("holiday='$date'")->select();
		if(count($existList)>0)
		{
				$holidayType = $existList[0]["holiday_type"];

		}

		$dataArr["holidayType"]=$holidayType;
		return $dataArr;
	}

/**
 * utf8字符转换成Unicode字符
 * @param [type] $utf8_str Utf-8字符
 * @return [type]      Unicode字符
 */
static function utf8_str_to_unicode($utf8_str) {
  $unicode = 0;
  $unicode = (ord($utf8_str[0]) & 0x1F) << 12;
  $unicode |= (ord($utf8_str[1]) & 0x3F) << 6;
  $unicode |= (ord($utf8_str[2]) & 0x3F);
  return dechex($unicode);
}

/**
 * Unicode字符转换成utf8字符
 * @param [type] $unicode_str Unicode字符
 * @return [type]       Utf-8字符
 */
static function unicode_to_utf8($unicode_str) {
  $utf8_str = '';
  $code = intval(hexdec($unicode_str));
  //这里注意转换出来的code一定得是整形，这样才会正确的按位操作
  $ord_1 = decbin(0xe0 | ($code >> 12));
  $ord_2 = decbin(0x80 | (($code >> 6) & 0x3f));
  $ord_3 = decbin(0x80 | ($code & 0x3f));
  $utf8_str = chr(bindec($ord_1)) . chr(bindec($ord_2)) . chr(bindec($ord_3));
  return $utf8_str;
}

	static  function getLimitByDatePc($date,$preClass) {

		$dateShow =  date("m月d日",strtotime($date));
		$cpxxHolidayModel = D("CpxxHoliday");

		$cpxxLimitModel = D("CpxxLimit");
		$editData = $cpxxLimitModel->where("limit_day='$date'")->select();
		$limit_last = $editData[0]["limit_last"];// varchar(255) 限行尾号  7|9 如果为空表示不限行
		$weekday  = $editData[0]["weekday"];//  varchar(255) 星期几

		$lastShow = "不限行";
		$needLast = 0;
		$holidayType=0;

		if(empty($preClass)) {
			$preClass="heShow";
		}

		if(!empty($limit_last)) {
			$limitArr = preg_split('/\|/',$limit_last,-1,PREG_SPLIT_NO_EMPTY);

			if(count($limitArr)>=2)  {
				$existList =  $cpxxHolidayModel->where("holiday='$date'")->select();
				if(count($existList)==0) {
					$needLast = 1;
					$lastShow = str_replace("|","<span class=\"$preClass\">和</span>",$limit_last);
				}else {
						//holidayType=0;
						$holidayType = $existList[0]["holiday_type"];

				}
			}
		}





        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);
        $pageElement["selected"]= str_replace("Action","", get_class( $this )); $cpxxHolidayModel = D("CpxxHoliday");

		$cpxxLimitModel = D("CpxxLimit");
		$editData = $cpxxLimitModel->where("limit_day='$date'")->select();
		$limit_last = $editData[0]["limit_last"];// varchar(255) 限行尾号  7|9 如果为空表示不限行
		$weekday  = $editData[0]["weekday"];//  varchar(255) 星期几

		$lastShow = "不限行";
		$needLast = 0;
		if(!empty($limit_last)) {
			$limitArr = preg_split('/\|/',$limit_last,-1,PREG_SPLIT_NO_EMPTY);
			if(count($limitArr)>=2)  {
				$existList =  $cpxxHolidayModel->where("holiday='$date'")->select();
				if(count($existList)==0) {
					$needLast = 1;
					$lastShow = str_replace("|","<span class=\"$preClass\">和</span>",$limit_last);
				}
				else {
						//holidayType=0;

						$holidayType = $existList[0]["holiday_type"];
				}
			}
		}







		if($needLast==1) {

			$dataArr = array(
				"date"=>"$date",
				"dateShow"=>"$dateShow",
				"weekday"=>"$weekday",
				"limit"=>"$lastShow",
				"bjLimit"=>"7时-20时",
				"outLittleLimit"=>"9时-17时",
				"outCustomerLimit"=>"7时-9时；17时-20时",
				"gwLimit"=>"0时-24时",
			);
		}
		else {
			//不限行
			$dataArr = array(
				"date"=>"$date",
				"dateShow"=>"$dateShow",
				"weekday"=>"$weekday",
				"limit"=>"不限行",
				"bjLimit"=>"不限行",
				"outLittleLimit"=>"不限行",
				"outCustomerLimit"=>"不限行",
				"gwLimit"=>"不限行",
			);
		}
		$existList =  $cpxxHolidayModel->where("holiday='$date'")->select();
		if(count($existList)>0)
		{
				$holidayType = $existList[0]["holiday_type"];

		}

		$dataArr["holidayType"]=$holidayType;
		return $dataArr;
	}


	static function buildESField($showFieldsArr, &$realshowFieldsArr) {
		$tableName = str_replace ( "Action", "", get_class ( $this ) );
		$tableName = Util::getBaseTableName ( $tableName );
		$editFieldsArr = $showFieldsArr;

		$realshowFieldsArr = array ();
		$editFieldsArr = array ();

		foreach ( $showFieldsArr as $field => $value ) {
			if ($value == 1) {

				$idName = $tableName . "." . $field;
				$realvalue = Util::getSelfAuth ( $idName );
				$realshowFieldsArr [$field] = $realvalue;

				$showIdName = $tableName . "__" . $field;
				$tmpTitle = Util::getTableFieldTitle ( $idName );
				if (! empty ( $tmpTitle )) {

					$editFieldsArr [$showIdName] ["title"] = $tmpTitle;
					$editFieldsArr [$showIdName] ["value"] = $realvalue;
				}
			}
		}
		return $editFieldsArr;
	}

	static function initTable($idName, &$searchkey, &$FFSearch, &$showTable, &$tableTitle) {
		$searchkey = $_REQUEST ["searchkey"];
		if (empty ( $searchkey ))
			$searchkey = "";
		$searchkey = trim ( $searchkey );

		$FFSearch = $_REQUEST ["FFSearch"];
		if (empty ( $FFSearch )) {
			$FFSearch = $_SESSION ["searchkey"];
		}

		$cmd = $_REQUEST ["cmd"];
		if ($cmd == "search") {
			$_SESSION ["searchkey"] = $_REQUEST ["searchkey"];
		}

		// 是否有表查看权限
		$showTable = Util::getTFAuth ( $idName );

		$tableTitle = Util::getTableFieldTitle ( $idName );

		if ($showTable < 1) {
			header ( "Content-Type:text/html;charset=utf-8" );

			print "<script>alert('没有查看" . $tableTitle . "模块的权限');</script>";
			print "<script>history.go(-1);</script>";
			die ();
		}
	}

    /**
     * cast the html chars
     *
     * @param $req
     */
    public function filter($req) {
        $req = preg_replace("/[<>]+/",   "", $req);            // convert the <> to " "
        $req = preg_replace('/[\'\"]+/', " ", $req);
        $req = trim($req);                                    // trim the \n or \r\n characters
        $req = preg_replace("/[\r\n]+/", " ", $req);        // convert the \r\n to <br/>

        return $req;
    }

    public static function isUpper ( $char )
    {
        $ascii = ord ( $char );
        if( $ascii > 64 and $ascii < 91 ) return true;
        return false;
    }


	public static function getOrderDesc($p)
	{ 
			

				if(empty($p))
				{
					$orderbyDesc = $_SESSION["orderbyDesc"];
					//print "orderbyDesc=($orderbyDesc)";
					if($_SESSION["orderbyDesc"]=="")
					{
						$orderbyDesc = " desc ";
					}
					else
					{
						$orderbyDesc = "";
					}
				}
				return $orderbyDesc ;
	}


    	public function  syncTableAdd($tableName ,$data )
	{
		$user_id = $_SESSION [DBNAME."user_id"];




		$idName = "tablename.".$tableName;
		$actionName =  Util::getActionTableName($idName);

		$sqlModel = D("$actionName");

		$insertId =  $sqlModel->data($data)->add();


		if ($insertId) {
			return $insertId; //申请者获得这个id，replace into 到本地即可 $data["id"]=$insertId;然后本地添加

		} else {
			return 0;

		}
	}

		public function  syncTableId($tableName,$fieldName,$fieldValue)
	{




		$idName = "tablename.".$tableName;
		$actionName =  Util::getActionTableName($idName);

		$sqlModel = D("$actionName");

		$list =  $sqlModel->where("$fieldName='$fieldValue'")->select();

		//print_r( $sqlModel);die;
		 $retId = $list[0]["id"];
		 if(empty($retId))$retId=0;
		 return $retId;
	}



    public  static function importExecl($file){



        if(!file_exists($file)){
            return array("error"=>0,'message'=>'file not found!');
        }
        Vendor("PHPExcel.PHPExcel.IOFactory");
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        try{
            $PHPReader = $objReader->load($file);
        }catch(Exception $e){

        }
        if(!isset($PHPReader)) return array("error"=>0,'message'=>'read error!');
        $allWorksheets = $PHPReader->getAllSheets();
        $i = 0;
        foreach($allWorksheets as $objWorksheet){
            $sheetname=$objWorksheet->getTitle();
            $allRow = $objWorksheet->getHighestRow();//how many rows
            $highestColumn = $objWorksheet->getHighestColumn();//how many columns
            $allColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $array[$i]["Title"] = $sheetname;
            $array[$i]["Cols"] = $allColumn;
            $array[$i]["Rows"] = $allRow;
            $arr = array();
            $isMergeCell = array();
            foreach ($objWorksheet->getMergeCells() as $cells) {//merge cells
                foreach (PHPExcel_Cell::extractAllCellReferencesInRange($cells) as $cellReference) {
                    $isMergeCell[$cellReference] = true;
                }
            }
            for($currentRow = 1 ;$currentRow<=$allRow;$currentRow++){
                $row = array();
                for($currentColumn=0;$currentColumn<$allColumn;$currentColumn++){;
                    $cell =$objWorksheet->getCellByColumnAndRow($currentColumn, $currentRow);
                    $afCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn+1);
                    $bfCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn-1);
                    $col = PHPExcel_Cell::stringFromColumnIndex($currentColumn);
                    $address = $col.$currentRow;
                    $value = $objWorksheet->getCell($address)->getValue();
                    if(substr($value,0,1)=='='){
                        return array("error"=>0,'message'=>'can not use the formula!');
                        exit;
                    }
                    if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){
                        $cellstyleformat=$cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();
                        $formatcode=$cellstyleformat->getFormatCode();
                        if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)) {
                            $value=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));
                        }else{
                            $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatcode);
                        }
                    }
                    if($isMergeCell[$col.$currentRow]&&$isMergeCell[$afCol.$currentRow]&&!empty($value)){
                        $temp = $value;
                    }elseif($isMergeCell[$col.$currentRow]&&$isMergeCell[$col.($currentRow-1)]&&empty($value)){
                        $value=$arr[$currentRow-1][$currentColumn];
                    }elseif($isMergeCell[$col.$currentRow]&&$isMergeCell[$bfCol.$currentRow]&&empty($value)){
                        $value=$temp;
                    }
                    $row[$currentColumn] = $value;
                }
                $arr[$currentRow] = $row;
            }
            $array[$i]["Content"] = $arr;
            $i++;
        }
        spl_autoload_register(array('Think','autoload'));//must, resolve ThinkPHP and PHPExcel conflicts
        unset($objWorksheet);
        unset($PHPReader);
        unset($PHPExcel);
        unlink($file);
        return array("error"=>1,"data"=>$array);
    }

    public static function isLower ( $char )
    {
        $ascii = ord ( $char );
        if( $ascii > 96 and $ascii < 123 ) return true;
        return false;
    }


   	public static function getBaseTableName($tableName)
 	{
 		$baseTableName = strtolower(substr($tableName,0,1));
 		for($i=1;$i<strlen($tableName);$i++ )
 		{
 			$tmpStr = substr($tableName,$i,1);
 			if(Util::isUpper($tmpStr )) $baseTableName.="_".strtolower($tmpStr);
 			else $baseTableName.= $tmpStr ;
 		}

 		return $baseTableName;

 	}


    /**
     * page navgator
     *
     * @param $pageType
     */
    public static function navigator($pageType) {


        $indexConfigUrl = C("INDEX_CONFIG_URL");

        $naviAuth    = C("NAVIGATOR_AUTH");
        $naviConfigs = C("NAVIGATOR");
        $indexConfig = "";// json_decode(file_get_contents($indexConfigUrl), true);

        $certification = new CertificationAction();

        $nav = "";
        foreach ($naviConfigs as $config) {
            if ($config[3] == 1) {            # needs dropdown
                if($config[0] == $pageType) {
                    $nav .= "<li style=\"z-index:9999\"><a href=\"".$config[2]."\" style=\"padding:0\" class=\"selected\">";
                } else {
                    $nav .= "<li style=\"z-index:9999\"><a href=\"".$config[2]."\" style=\"padding:0\">";
                }

                $nav .= "<span style=\"padding:5px 15px\">".$config[1]."</span><span class=\"btn_dropmenu\" href=\"#\" id=\"__dropmenu_nav_drop\"></span></a>";
                $nav .= "<div id=\"__dropmenu_nav_selector\" class=\"dropmenu3_frame\" style=\"display: none;\">";
                $nav .= "<table class=\"tbl_drop_status\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"z-index:9999;\"><tbody>";

                # needs your option
                if (!$indexConfig) {
                    $nav .= "<tr><td><a href=\"#\">空<br/><span>当前无任何其他入口！</span></a></td></tr>";
                } else {
                    foreach ($indexConfig as $ic) {
                        $nav .= "<tr><td><a href='".$ic["sys_path"]."'>".$ic["sys_name"]."<br/><span>".$ic["sys_desc"]."</span></a></td></tr>";
                    }
                }

                $nav .= "</tbody></table></div></li>";
            } else {
                if ($certification->showNavigatorCert($_SESSION["user_id"], $config[0])) {

                    if($config[0] == $pageType) {
                        $nav .= "<li><a href=\"".$config[2]."\" class=\"selected\">".$config[1]."</a></li>";
                    } else {
                        $nav .= "<li><a href=\"".$config[2]."\">".$config[1]."</a></li>";
                    }
                } else {
                    continue;
                }
            }
        }

        return $nav;
    }


    /**
     * 获取下拉信息
     *
     */
    public static function getSelectList() {
        $ispModel = D("Isp");
        $departmentModel = D("Department");
        $departmentBusinessModel = D("DepartmentBusiness");
        $channelModel = D("Channel");
        $tmpArr = array();
        $tmpArr["isp"] = $ispModel->select();
        $tmpArr["departmentBusiness"] = $departmentBusinessModel->order("departname")->select();
        $tmpArr["department"] = $departmentModel->select();
        $tmpArr["channel"] = $channelModel->select();
        return $tmpArr;
    }



    /**
     * Send a mail, alert something
     *
     * @param $emails            mail user lists
     * @param $title            mail title
     * @param $content            mail content
     * @param $from                mail user,default is from config.php
     * @param $cc                mail cc users
     */
    public function sendingMail($emails, $title, $content, $from = "", $cc = "") {
        $mailing = C("MAILING");

        if ($mailing["switch"] == false) {            # do not need to send mails
            return;
        }

        if ($from == "") {
            $from = $mailing["from"];                # default mailing user
        }

        if ($cc == "") {
            $cc   = $mailing["cc"];
        }

        $content = mb_convert_encoding ($content, "gb2312", "utf-8");
        $title   = mb_convert_encoding ($title, "gb2312", "utf-8");

        $content = preg_replace('/<br[ ]*\/>/', "\n", $content);
        $content = htmlspecialchars($content)."\n";
        $content = str_replace(" ", "&nbsp;", $content);
        $content = nl2br($content);

        if($emails) {
            $smtp = new Smtp();
            $smtp->send($emails, $title, $content, $cc, "", $from);
        }
    }


    /**
     * 发送http请求，获取数据
     *
     * @param $url            目标url
     * @param $data            额外数据
     */
    public static function get_data_by_interface($url, $data) {

        $data = http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //缺少这两句将无法获取数据！
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


        $response = curl_exec($ch);

        if(preg_match("/404/", $response,$match)
        && preg_match("/not/",strtolower($response),$match)
        && preg_match("/found/", strtolower($response),$match) )
        {
            $ret = array("RESULT"=>"1", "ERROR_MESSAGE"=>'接口 404 NOT FOUND');
        	return json_encode($ret);
        }
        if ($response === false) {        //报错则输出报错信息。
            // echo 'Curl error: ' . curl_error($ch);
            //  echo "<br>";
           // print_r($data);die;
            $ret = array("RESULT"=>"1", "ERROR_MESSAGE"=>'接口网络故障，请稍后重试');
        	return json_encode($ret);
        }
        curl_close($ch);

        return $response;
    }


    public static function get_data_by_transit($url, $request_data, $uuid) {
        $data["url"]     = $url;
        $data["request"] = serialize($request_data);
        $data["uuid"]    = $uuid;
        $ret = Util::get_data_by_interface(SET_URL_REQUEST, $data);

        return $ret;
    }

    public static function getUnitHostName($id)
    {
    	if($id>0)
    	{
			$sqlModel = D("ServerUnits" );
			 $tmpList = $sqlModel->where("id=$id")->select();
			 $type = $tmpList[0]["type"];
			 $server_id = $tmpList[0]["server_id"];
			  if($type==0)
			 {
				$sqlModel = D("Servers" );
				$tmpList = $sqlModel->getById($server_id);
				$selectValue = $tmpList["hostname"];

			 }elseif($type==1)
			 {
				$sqlModel = D("Switches" );
				$tmpList = $sqlModel->getById($server_id);
				$selectValue = $tmpList["hostname"];

			 }
			 elseif($type==2)
			 {
				$sqlModel = D("VmServers" );
				$tmpList = $sqlModel->getById($server_id);
				$selectValue = $tmpList["hostname"];
			 }


			 return $selectValue;
		}
		else
		{
			return "";
		}
    }

    public static function getNameById($objId,$id) {




    	$srctableName = Util::getTableByIdName($objId);
    	$tableName = preg_replace('/:.*/','',$srctableName);
    	$showField =  preg_replace('/.*:/','',$srctableName);

    	$tableName =  Util::getActionTableName($tableName);



        $sqlModel = D($tableName );

        $list =   $sqlModel->getById("$id") ;


    		$selectValue="";
        	foreach($list  as $fieldName => $value)
        	{
        		if(preg_match('/name/',$fieldName,$match)) $selectValue.=$value ;
        		if($fieldName == $showField)  $selectValue.=$value ;

        		if(!empty($selectValue))break;
        	}

        	if(empty($selectValue)) $selectValue =$id;



        return $selectValue;

    }

















public static function buildAuthSelect($authArr)

{


    $baseArr = Util::getTableFieldBase( )
;

    $content = " <div style=\"float:left;width:500px;\">
                                <fieldset>
                                    <legend style=\"color:#555;\">权限设置</legend>


                                 ";



    $tableNameNow = "";
    foreach($baseArr as $idName => $title)
    {
    	$pIdName = str_replace('.','_',$idName);
    	$myAuth = $authArr[$idName];
    	if(empty($myAuth)||$myAuth ==0)  $myAuth= $authArr[$pIdName];


        if(preg_match('/tablename/',$idName ,$match))
        {
        	if(!empty($tableNameNow))
        	{
        		$content .=" </fieldset> ";
        	}
        	$tableNameNow = $idName;

        	$content .="  <fieldset id=\"id_".$tableNameNow ."\"> ";

        	$checkStr0 = "";
        	if(empty($myAuth)||$myAuth ==0) 	$checkStr0 = " checked=\"checked\"";
        	$checkStr1 = "";
        	if($myAuth ==1) 	$checkStr1 = " checked=\"checked\"";
        	$checkStr2 = "";
        	if($myAuth ==2) 	$checkStr2 = " checked=\"checked\"";

        	$srcTableName = preg_replace('/.*\./','',$tableNameNow);
        	$content .="   <legend style=\"color:#555;\"> $title 权限   | <input type=\"radio\" name=\"".$idName."\" value =\"0\" $checkStr0> 无权限 |
        	<input type=\"radio\" name=\"".$idName."\" value =\"1\" $checkStr1 > 只读  |
        	<input type=\"radio\" name=\"".$idName."\"  value =\"2\"	$checkStr2>读写 |
        	 <input type=\"checkbox\"  id=\"ck_".$srcTableName ."\" onclick=selectAllTable('".$srcTableName."') >查看全部
        	</legend>";// >查看全选



        }
        else
        {
        	$checkStr = "";
        	if($myAuth ==1) 	$checkStr = " checked=\"checked\"";

       		$content .= " $title 查看<input type=\"checkbox\" name=\"$idName\"  id=\"$idName\" value =\"1\"  $checkStr> |";

        }

    }


    $content .= "

                                </fieldset>
                            </div>";
	return $content ;


}


 public static function getActionTableName($tablename)
 {
     $ActionTableName            = "";
        for ($i = 0; $i < strlen($tablename); $i++) {
            $tmp  = substr($tablename, $i, 1);
			$tmppre = "";
			if($i>0) $tmppre = substr($tablename, $i-1, 1);
			if($i==0||$tmppre == "_")
			{
				$ActionTableName .= strtoupper($tmp);
			}
			else if($tmp != "_" && $tmppre != "_")
			{
				$ActionTableName .= $tmp;
			}

        }
		return   $ActionTableName ;
 }
public static function getTFAuth($idName)

{

/*
	$tableArr = array(

	"tablename.isps"=>"2",
"isps.id"=>"1",
"isps.name"=>"1",
"isps.zh_name"=>"1",
"isps.created_at"=>"1",
"isps.updated_at"=>"1",
"tablename.idcs"=>"2",
"idcs.id"=>"1",
"idcs.name"=>"1",
"idcs.short_name"=>"1",
"idcs.zh_name"=>"1",
"idcs.isp_id"=>"1",
"idcs.address"=>"1",
"idcs.contact"=>"1",
"idcs.created_at"=>"1",
"idcs.updated_at"=>"1",
"tablename.bandwidthes"=>"2",
"bandwidthes.id"=>"1",
"bandwidthes.idc_id"=>"1",
"bandwidthes.bandwidth"=>"1",
"bandwidthes.bandwidthmax"=>"1",
"bandwidthes.supplier_id"=>"1",
"bandwidthes.contract_id"=>"1",
"bandwidthes.starttime"=>"1",
"bandwidthes.endtime"=>"1",
"bandwidthes.created_at"=>"1",
"bandwidthes.updated_at"=>"1",
"tablename.racks"=>"2",
"racks.id"=>"1",
"racks.idc_id"=>"1",
"racks.name"=>"1",
"racks.supplier_id"=>"1",
"racks.contract_id"=>"1",
"racks.starttime"=>"1",
"racks.endtime"=>"1",
"racks.created_at"=>"1",
"racks.updated_at"=>"1",
"tablename.switches"=>"2",
"switches.id"=>"1",
"switches.idc_id"=>"1",
"switches.rack_id"=>"1",
"switches.rack_pos"=>"1",
"switches.switch_type"=>"1",
"switches.hostname"=>"1",
"switches.manager_ip"=>"1",
"switches.hw_brand"=>"1",
"switches.hw_model"=>"1",
"switches.user_id"=>"1",
"switches.fixed_asset"=>"1",
"switches.sn"=>"1",
"switches.starttime"=>"1",
"switches.endtime"=>"1",
"switches.supplier_id"=>"1",
"switches.contract_id"=>"1",
"switches.created_at"=>"1",
"switches.updated_at"=>"1",
"tablename.switch_ports"=>"2",
"switch_ports.id"=>"1",
"switch_ports.switch_id"=>"1",
"switch_ports.switch_type"=>"1",
"switch_ports.port_name"=>"1",
"switch_ports.port_type"=>"1",
"switch_ports.line_id"=>"1",
"switch_ports.line_port"=>"1",
"switch_ports.bandwidth"=>"1",
"switch_ports.bandwidthmax"=>"1",
"switch_ports.created_at"=>"1",
"switch_ports.updated_at"=>"1",
"tablename.servers"=>"2",
"servers.id"=>"1",
"servers.idc_id"=>"1",
"servers.rack_id"=>"1",
"servers.rack_pos"=>"1",
"servers.hostname"=>"1",
"servers.managerip"=>"1",
"servers.matian_status"=>"1",
"servers.department_id"=>"1",
"servers.user_id"=>"1",
"servers.hw_brand"=>"1",
"servers.hw_model"=>"1",
"servers.cpu"=>"1",
"servers.ram"=>"1",
"servers.disk"=>"1",
"servers.raid"=>"1",
"servers.other"=>"1",
"servers.fixed_asset"=>"1",
"servers.sn"=>"1",
"servers.starttime"=>"1",
"servers.endtime"=>"1",
"servers.supplier_id"=>"1",
"servers.contract_id"=>"1",
"servers.created_at"=>"1",
"servers.updated_at"=>"1",
"tablename.componets"=>"2",
"componets.id"=>"1",
"componets.dev_add_type"=>"1",
"componets.dev_type"=>"1",
"componets.dev_model"=>"1",
"componets.sn"=>"1",
"componets.starttime"=>"1",
"componets.endtime"=>"1",
"componets.supplier_id"=>"1",
"componets.contract_id"=>"1",
"componets.line_id"=>"1",
"componets.created_at"=>"1",
"componets.updated_at"=>"1",
"tablename.vm_servers"=>"2",
"vm_servers.id"=>"1",
"vm_servers.server_id"=>"1",
"vm_servers.real_server_name"=>"1",
"vm_servers.hostname"=>"1",
"vm_servers.w_ip"=>"1",
"vm_servers.i_ip"=>"1",
"vm_servers.matian_status"=>"1",
"vm_servers.department_id"=>"1",
"vm_servers.user_id"=>"1",
"vm_servers.cpu"=>"1",
"vm_servers.ram"=>"1",
"vm_servers.disk"=>"1",
"vm_servers.os"=>"1",
"vm_servers.memo"=>"1",
"vm_servers.created_at"=>"1",
"vm_servers.updated_at"=>"1",
"tablename.suppliers"=>"2",
"suppliers.id"=>"1",
"suppliers.zh_name"=>"1",
"suppliers.address"=>"1",
"suppliers.contact"=>"1",
"suppliers.goods"=>"1",
"suppliers.created_at"=>"1",
"suppliers.updated_at"=>"1",
"tablename.budgets"=>"2",
"budgets.id"=>"1",
"budgets.begin_year"=>"1",
"budgets.begin_month"=>"1",
"budgets.idc_id"=>"1",
"budgets.budget_type"=>"1",
"budgets.infos"=>"1",
"budgets.premoney"=>"1",
"budgets.created_at"=>"1",
"budgets.updated_at"=>"1",
"tablename.contracts"=>"2",
"contracts.id"=>"1",
"contracts.budget_id"=>"1",
"contracts.contract_number"=>"1",
"contracts.infos"=>"1",
"contracts.supplier_id"=>"1",
"contracts.created_at"=>"1",
"contracts.updated_at"=>"1",
"tablename.contract_details"=>"2",
"contract_details.id"=>"1",
"contract_details.contract_id"=>"1",
"contract_details.buy_type"=>"1",
"contract_details.unit_price"=>"1",
"contract_details.buy_num"=>"1",
"contract_details.created_at"=>"1",
"contract_details.updated_at"=>"1",
"tablename.departments"=>"2",
"departments.id"=>"1",
"departments.department"=>"1",
"departments.memo"=>"1",
"departments.created_at"=>"1",
"departments.updated_at"=>"1",
"tablename.roles"=>"2",
"roles.id"=>"1",
"roles.rolename"=>"1",
"roles.roleauth"=>"1",
"roles.memo"=>"1",
"roles.created_at"=>"1",
"roles.updated_at"=>"1",
"tablename.users"=>"2",
"users.id"=>"1",
"users.department_id"=>"1",
"users.role_id"=>"1",
"users.login"=>"1",
"users.pass"=>"1",
"users.zh_name"=>"1",
"users.email"=>"1",
"users.phone"=>"1",
"users.created_at"=>"1",
"users.updated_at"=>"1",
"tablename.oplogs"=>"2",
"oplogs.id"=>"1",
"oplogs.user_id"=>"1",
"oplogs.ops_table"=>"1",
"oplogs.table_id"=>"1",
"oplogs.ops_sql"=>"1",
"oplogs.before_ops"=>"1",
"oplogs.after_ops"=>"1",


	);
	*/

	$idName = str_replace('.','_',$idName);


	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$rolesModel = D("Roles");
	$list = $usersModel->getById($userId);
	$roleId = $list["role_id"];
	$list = $rolesModel->getById($roleId);
	$roleId = $list["role_id"];
	$auth = json_decode($list["roleauth"],true);


	if(preg_match('/tablename/',$idName,$match)) return 2;
	else return 1;
	//return $auth[$idName];


}


public static function getSelfAuth($idName)

{

/*
	$tableArr = array(

	"tablename.isps"=>"2",
"isps.id"=>"1",
"isps.name"=>"1",
"isps.zh_name"=>"1",
"isps.created_at"=>"1",
"isps.updated_at"=>"1",
"tablename.idcs"=>"2",
"idcs.id"=>"1",
"idcs.name"=>"1",
"idcs.short_name"=>"1",
"idcs.zh_name"=>"1",
"idcs.isp_id"=>"1",
"idcs.address"=>"1",
"idcs.contact"=>"1",
"idcs.created_at"=>"1",
"idcs.updated_at"=>"1",
"tablename.bandwidthes"=>"2",
"bandwidthes.id"=>"1",
"bandwidthes.idc_id"=>"1",
"bandwidthes.bandwidth"=>"1",
"bandwidthes.bandwidthmax"=>"1",
"bandwidthes.supplier_id"=>"1",
"bandwidthes.contract_id"=>"1",
"bandwidthes.starttime"=>"1",
"bandwidthes.endtime"=>"1",
"bandwidthes.created_at"=>"1",
"bandwidthes.updated_at"=>"1",
"tablename.racks"=>"2",
"racks.id"=>"1",
"racks.idc_id"=>"1",
"racks.name"=>"1",
"racks.supplier_id"=>"1",
"racks.contract_id"=>"1",
"racks.starttime"=>"1",
"racks.endtime"=>"1",
"racks.created_at"=>"1",
"racks.updated_at"=>"1",
"tablename.switches"=>"2",
"switches.id"=>"1",
"switches.idc_id"=>"1",
"switches.rack_id"=>"1",
"switches.rack_pos"=>"1",
"switches.switch_type"=>"1",
"switches.hostname"=>"1",
"switches.manager_ip"=>"1",
"switches.hw_brand"=>"1",
"switches.hw_model"=>"1",
"switches.user_id"=>"1",
"switches.fixed_asset"=>"1",
"switches.sn"=>"1",
"switches.starttime"=>"1",
"switches.endtime"=>"1",
"switches.supplier_id"=>"1",
"switches.contract_id"=>"1",
"switches.created_at"=>"1",
"switches.updated_at"=>"1",
"tablename.switch_ports"=>"2",
"switch_ports.id"=>"1",
"switch_ports.switch_id"=>"1",
"switch_ports.switch_type"=>"1",
"switch_ports.port_name"=>"1",
"switch_ports.port_type"=>"1",
"switch_ports.line_id"=>"1",
"switch_ports.line_port"=>"1",
"switch_ports.bandwidth"=>"1",
"switch_ports.bandwidthmax"=>"1",
"switch_ports.created_at"=>"1",
"switch_ports.updated_at"=>"1",
"tablename.servers"=>"2",
"servers.id"=>"1",
"servers.idc_id"=>"1",
"servers.rack_id"=>"1",
"servers.rack_pos"=>"1",
"servers.hostname"=>"1",
"servers.managerip"=>"1",
"servers.matian_status"=>"1",
"servers.department_id"=>"1",
"servers.user_id"=>"1",
"servers.hw_brand"=>"1",
"servers.hw_model"=>"1",
"servers.cpu"=>"1",
"servers.ram"=>"1",
"servers.disk"=>"1",
"servers.raid"=>"1",
"servers.other"=>"1",
"servers.fixed_asset"=>"1",
"servers.sn"=>"1",
"servers.starttime"=>"1",
"servers.endtime"=>"1",
"servers.supplier_id"=>"1",
"servers.contract_id"=>"1",
"servers.created_at"=>"1",
"servers.updated_at"=>"1",
"tablename.componets"=>"2",
"componets.id"=>"1",
"componets.dev_add_type"=>"1",
"componets.dev_type"=>"1",
"componets.dev_model"=>"1",
"componets.sn"=>"1",
"componets.starttime"=>"1",
"componets.endtime"=>"1",
"componets.supplier_id"=>"1",
"componets.contract_id"=>"1",
"componets.line_id"=>"1",
"componets.created_at"=>"1",
"componets.updated_at"=>"1",
"tablename.vm_servers"=>"2",
"vm_servers.id"=>"1",
"vm_servers.server_id"=>"1",
"vm_servers.real_server_name"=>"1",
"vm_servers.hostname"=>"1",
"vm_servers.w_ip"=>"1",
"vm_servers.i_ip"=>"1",
"vm_servers.matian_status"=>"1",
"vm_servers.department_id"=>"1",
"vm_servers.user_id"=>"1",
"vm_servers.cpu"=>"1",
"vm_servers.ram"=>"1",
"vm_servers.disk"=>"1",
"vm_servers.os"=>"1",
"vm_servers.memo"=>"1",
"vm_servers.created_at"=>"1",
"vm_servers.updated_at"=>"1",
"tablename.suppliers"=>"2",
"suppliers.id"=>"1",
"suppliers.zh_name"=>"1",
"suppliers.address"=>"1",
"suppliers.contact"=>"1",
"suppliers.goods"=>"1",
"suppliers.created_at"=>"1",
"suppliers.updated_at"=>"1",
"tablename.budgets"=>"2",
"budgets.id"=>"1",
"budgets.begin_year"=>"1",
"budgets.begin_month"=>"1",
"budgets.idc_id"=>"1",
"budgets.budget_type"=>"1",
"budgets.infos"=>"1",
"budgets.premoney"=>"1",
"budgets.created_at"=>"1",
"budgets.updated_at"=>"1",
"tablename.contracts"=>"2",
"contracts.id"=>"1",
"contracts.budget_id"=>"1",
"contracts.contract_number"=>"1",
"contracts.infos"=>"1",
"contracts.supplier_id"=>"1",
"contracts.created_at"=>"1",
"contracts.updated_at"=>"1",
"tablename.contract_details"=>"2",
"contract_details.id"=>"1",
"contract_details.contract_id"=>"1",
"contract_details.buy_type"=>"1",
"contract_details.unit_price"=>"1",
"contract_details.buy_num"=>"1",
"contract_details.created_at"=>"1",
"contract_details.updated_at"=>"1",
"tablename.departments"=>"2",
"departments.id"=>"1",
"departments.department"=>"1",
"departments.memo"=>"1",
"departments.created_at"=>"1",
"departments.updated_at"=>"1",
"tablename.roles"=>"2",
"roles.id"=>"1",
"roles.rolename"=>"1",
"roles.roleauth"=>"1",
"roles.memo"=>"1",
"roles.created_at"=>"1",
"roles.updated_at"=>"1",
"tablename.users"=>"2",
"users.id"=>"1",
"users.department_id"=>"1",
"users.role_id"=>"1",
"users.login"=>"1",
"users.pass"=>"1",
"users.zh_name"=>"1",
"users.email"=>"1",
"users.phone"=>"1",
"users.created_at"=>"1",
"users.updated_at"=>"1",
"tablename.oplogs"=>"2",
"oplogs.id"=>"1",
"oplogs.user_id"=>"1",
"oplogs.ops_table"=>"1",
"oplogs.table_id"=>"1",
"oplogs.ops_sql"=>"1",
"oplogs.before_ops"=>"1",
"oplogs.after_ops"=>"1",


	);
	*/

	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$list = $usersModel->getById($userId);

	$auth = json_decode($list["define_auth"],true);




	if(!isset( $auth[$idName])) $auth[$idName]=1 ;


	return $auth[$idName];

}


public static function getSelfPage($idName)

{


	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$list = $usersModel->getById($userId);

	$auth = json_decode($list["define_auth"],true);



	if(!isset( $auth[$idName])) $auth[$idName]=40 ;

	return $auth[$idName];

}


public static function getUserDepartId()
{

	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$list = $usersModel->getById($userId);
	$departId = $list["department_id"];
	return $departId;
}

public static function addServerUnit($type,$server_id)
{
 	$serverUnitsModel = D("ServerUnits");
 	$id=1000000*$type+$server_id;
 	$data = array();
 	$data["id"]=$id;
 	$data["type"]=$type;
 	$data["server_id"]=$server_id;
 	$count = $serverUnitsModel->where("id=$id")->count();
 	if($count==0)
 	{
 		$serverUnitsModel->data($data)->add();
 	}

}

public static function getServerUnitId($host)
{
 	$serversModel = D("Servers");
 	$switchesModel = D("Switches");
 	$vmServersModel = D("VmServers");
 	$tmpList =  $serversModel->where("hostname='$host'")->select();
 	if(count($tmpList)>0)
 	{
 		return $tmpList[0]["id"];
 	}
  	$tmpList =  $switchesModel->where("hostname='$host'")->select();
 	if(count($tmpList)>0)
 	{
 		return 1000000+$tmpList[0]["id"];
 	}
  	$tmpList =  $vmServersModel->where("hostname='$host'")->select();
 	if(count($tmpList)>0)
 	{
 		return 2000000+$tmpList[0]["id"];
 	}
}

public static function getUserPass()
{

	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$list = $usersModel->getById($userId);
	$pass = $list["pass"];
	return $pass;
}
public static function getUserCompId()
{

	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$list = $usersModel->getById($userId);
	$departId = $list["comp_id"];
	return $departId;
}

public static function getUserGroupId()
{

	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$list = $usersModel->getById($userId);
	$departId = $list["group_id"];
	return $departId;
}

     public static function getTableAuth( )

{


	//上面是全权限，下面给出个人实际权限
	$userId = $_SESSION[DBNAME."user_id"];
	$usersModel = D("Users");
	$rolesModel = D("Roles");
	$list = $usersModel->getById($userId);
	$roleId = $list["role_id"];
	$list = $rolesModel->getById($roleId);
	$roleId = $list["role_id"];
	$auth = json_decode($list["roleauth"],true);

	$tableArr = array();
	foreach($auth as $idName => $v)
	{
		if(preg_match('/tablename/',$idName,$match) && $v>0)
		{
			$idName = str_replace('tablename.','',$idName);
			$idName = str_replace('tablename_','',$idName);
			$actionName =  Util::getActionTableName($idName);
				$tableArr[$idName]=1;
		}
	}

	return $tableArr;


}
public static function getDest(&$listData,$fieldName,$baseIdName)
{
	$tmpRemberArr = array();
 	for($i=0;$i<count($listData);$i++)
 	{
		$fieldValue =  $listData[$i][$fieldName ] ;

		$listData[$i][$fieldName ."Src"] = $listData[$i][$fieldName ];
		if(isset($tmpRemberArr ["$fieldName=".$fieldValue]))
		{
			$listData[$i][$fieldName."Dest" ] = $tmpRemberArr ["$fieldName=".$fieldValue];
		}
		else
		{
			$listData[$i][$fieldName."Dest" ] = Util::getNameById($baseIdName,$fieldValue);
			$tmpRemberArr ["$fieldName=".$fieldValue] = $listData[$i][$fieldName."Dest" ] ;
		}
   }
}




public static  function vcurlHttpsPostHeaderArr($url, $addHeaderArr = '', $post='',$cookie = '', $cookiejar = ''){
        $tmpInfo = '';
        $cookiepath = getcwd().'./'.$cookiejar;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');

        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }

        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        if($cookiejar) {
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        }
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


		     $headerArr = array(
	);

	foreach($addHeaderArr as $k=>$v) {
		$headerArr[]="$k:$v";
	}

	curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );



		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
//curl_setopt($ch, CURLOPT_SSLVERSION, 3);


        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>curl错误:</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
    }


public static  function vcurlGetHeaderArr($url, $addHeaderArr = '', $cookie = '', $cookiejar = ''){
        $tmpInfo = '';
        $cookiepath = getcwd().'./'.$cookiejar;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');

        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);


        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        if($cookiejar) {
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        }
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		    $headerArr = array(
	);

	foreach($addHeaderArr as $k=>$v) {
		$headerArr[]="$k:$v";
	}

	curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr );

        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>curl错误:</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
    }

public static  function vcurl($url, $post = '', $cookie = '', $cookiejar = '', $referer = ''){
        $tmpInfo = '';
        $cookiepath = getcwd().'./'.$cookiejar;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
        if($referer) {
        curl_setopt($curl, CURLOPT_REFERER, $referer);
        } else {
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        }
        if($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        if($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        if($cookiejar) {
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
        }
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
           echo '<pre><b>curl错误:</b><br />'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
    }


	
public static  function vcurlMax($url, $post = '', $cookie = '', $cookiejar = '', $referer = ''){
	$tmpInfo = '';
	$cookiepath = getcwd().'./'.$cookiejar;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; TencentTraveler ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727)');
	if($referer) {
	curl_setopt($curl, CURLOPT_REFERER, $referer);
	} else {
	curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	}
	if($post) {
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	}
	if($cookie) {
	curl_setopt($curl, CURLOPT_COOKIE, $cookie);
	}
	if($cookiejar) {
	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
	curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
	}
	//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 1000);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$tmpInfo = curl_exec($curl);
	if (curl_errno($curl)) {
	   echo '<pre><b>curl错误:</b><br />'.curl_error($curl);
	}
	curl_close($curl);
	return $tmpInfo;
}

    public static function send_content_mail($maillist, $subject, $content)
    {
				// 当发送 HTML 电子邮件时，请始终设置 content-type
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
			$headers .= 'From: stat@meilishuo.com' . "\r\n";

			$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

			$content.="<center>如有疑问，咨询管理员曾文杰wenjiezeng@meilishuo.com</center";
		 //如有疑问，咨询管理员曾文杰
		 	$ip  = $_SERVER["REMOTE_ADDR"];
		 	 if($ip != "127.0.0.1") mail($maillist, $subject, $content, $headers);

    }




    public static function getSearchShowJsonData($objId,$myselectId) {

		header ( "Content-Type:text/html;charset=utf-8" );

    	$tableName = $objId;

    	$tableName = preg_replace('/^addData_/','',$tableName);
    	$tableName = preg_replace('/^editData_/','',$tableName);

    	$srctableName = Util::getTableByIdName($tableName);
    	$srctableName = preg_replace('/:.*/','',$srctableName);
    	$tableName = preg_replace('/:.*/','',$srctableName);
    	$showField =  preg_replace('/.*:/','',$srctableName);

    	$tableName =  Util::getActionTableName($tableName);

    	if(empty($tableName)) die("error");

        $idName = "tablename."."$srctableName" ;

        $tableTitle =  Util::getTableFieldTitle($idName)
;

        $sqlModel = D($tableName );

        $listData =   $sqlModel->where("id=$myselectId")->select();

        for($i=0;$i<count($listData);$i++)
       	{
       		foreach($listData[$i] as $fieldName => $fieldValue)
       		{
       			$tableName = Util::getTableByIdName($fieldName);
       			if(!empty($tableName))
       			{

       				$listData[$i][$fieldName ] = Util::getNameById($fieldName,$fieldValue);
       			}

       			if(preg_match('/user_id/',$fieldName,$match))
       			{

       				$listData[$i][$fieldName ] = Util::getNameById("user_id",$fieldValue);
       			}


				if(preg_match('/asureflag|doing_flag/',$fieldName,$match))
				{
					if($listData[$i][$fieldName ]==1)
					{
						$listData[$i][$fieldName ]="是";
					}
					else
					{

						$listData[$i][$fieldName ]="否";
					}
				}

				 if(preg_match('/doingret|asureret/',$fieldName,$match))
				{
					if($listData[$i][$fieldName ]==1)
					{
						$listData[$i][$fieldName ]="同意";
					}
					else
					{

						$listData[$i][$fieldName ]="不同意";
					}
				}

					 if(preg_match('/处理结果/',$fieldName,$match))
				{
					if($listData[$i][$fieldName ]==1)
					{
						$listData[$i][$fieldName ]="同意";
					}
					else
					{

						$listData[$i][$fieldName ]="不同意";
					}
				}
       		}

       	}

  	    $content= "<table border=1 width=100% cellSpacing=0 cellPadding=1 style=\"background: #eef3f8;\">"
  	    ."<tr><td>数据模块</td><td>$tableTitle</td></tr>";
		foreach($listData[0] as $fieldName => $value)
		{
			if($fieldName == "id") continue;
			if(preg_match('/pass/',$fieldName,$match)) continue;
			$idName = "$srctableName.$fieldName";
			$title = Util::getTableFieldTitle($idName)
;
			$content.= "<tr><td>$title</td><td>$value</td></tr>";
		}
		$content.= "</table>";

        return $content;
    }


    public static function requestMail($userArr,$other,$request_id,$addInfo="")
    {
    	$detail =$addInfo;

    	 $detail .= Util::getSearchShowJsonData("request_id",$request_id);

		$mailArr = array();
    	$alertArr = array();
    	$usersModel = D("Users");
    	foreach($userArr as $user_id)
    	{
    		$tmpList = $usersModel->getById($user_id);

    		$mailArr[]=$tmpList["email"];
    		$alertArr[]= $tmpList["zh_name"] ;
    	}

    	$allMails = implode(",",$mailArr);
    	$allUser = implode(",",$alertArr);

    	$detail .= "\n\n<br>url地址:". COMPONET_REQUEST;



		Util::send_content_mail($allMails, $other, $detail);
    }

        public static function requestMachineMail($userArr,$other,$request_id,$addInfo="")
    {
     	$detail =$addInfo;

    	 $detail .= Util::getSearchShowJsonData("mr_id",$request_id);

		$mailArr = array();
    	$alertArr = array();
    	$usersModel = D("Users");
    	foreach($userArr as $user_id)
    	{
    		$tmpList = $usersModel->getById($user_id);

    		$mailArr[]=$tmpList["email"];
    		$alertArr[]= $tmpList["zh_name"] ;
    	}

    	$allMails = implode(",",$mailArr);
    	$allUser = implode(",",$alertArr);

    	$detail .="\n\n<br>url地址:". MACHINE_REQUEST;




		Util::send_content_mail($allMails, $other, $detail);
    }


          public static function rsyncNameById($objId,$id) {


		return Util::getNameById($objId,$id);
       }
    ##############generate



public static function getTableByIdName($idName)

{

 	return GenFunc::getTableByIdName($idName)
;

}



public static function getTableFieldTitle($idName)

{


	return GenFunc::getTableFieldTitle($idName)
;
}



public static function getTableFieldBase( )

{



	return GenFunc::getTableFieldBase()
;
}





public static function getTFAuthBase( )

{



	return GenFunc::getTFAuthBase()
;
}

	
/**
     +----------------------------------------------------------
     * Export Excel | 2013.08.23
     * Author:HongPing <hongping626@qq.com>
     +----------------------------------------------------------
     * @param $expTitle     string File name
     +----------------------------------------------------------
     * @param $expCellName  array  Column name
     +----------------------------------------------------------
     * @param $expTableData array  Table data
     +----------------------------------------------------------
     */
    public static function exportExcel($expTitle,$expCellName,$expTableData,$markdown,$saveFile){

		//	print_r($expCellName);
			$fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
			$txtStr="#".$expTitle."\n";
			if($markdown==1&&empty($saveFile)){
		 
				header("Content-type:application/octet-stream");
	
				header("Accept-Ranges:bytes"); 
			
				header("Content-Disposition:attachment;filename=$fileName.md"); 
			
				header("Expires:0"); 
			
				header("Cache-Control:must-revalidate,post-check=0,pre-check=0 "); 
			
				header("Pragma:public"); 
	
				$txtStr.= "|"; 
				for($i=0;$i<count($expCellName);$i++){
					$title = " ".$expCellName[$i][1];
					$len = 40-mb_strlen($title,'UTF-8');
					$txtStr.=  $title ;
					for($j=0;$j<$len;$j++) {
						$txtStr.=" ";
					}
					$txtStr.= "|";
				}
				$txtStr.= "\n";
	
				print $txtStr;$txtStr="";
	
	
	
				$txtStr.= "|";
				for($i=0;$i<count($expCellName);$i++){ 
					 
					for($j=0;$j<40;$j++) {
						$txtStr.="-";
					}
					
					$txtStr.= "|";
	
				}
				$txtStr.= "\n";
				
				print $txtStr;$txtStr="";
				$cellNum = count($expCellName);
				$dataNum = count($expTableData);
				for($i=0;$i<$dataNum;$i++){
					$txtStr.= "|"; 
					for($j=0;$j<$cellNum;$j++){
						//$expTableData[$i][$expCellName[$j][0]]
						$titleValue = " ".$expTableData[$i][$expCellName[$j][0]];
						
						$txtStr.= $titleValue;
	
						$len = 40-mb_strlen( $titleValue,'UTF-8');;
						for($k=0;$k<$len;$k++) {
							$txtStr.=" ";
						}
						$txtStr.= "|";
	 
					}   
					$txtStr.= "\n"; 
					
					print $txtStr;$txtStr="";         
				  }   
				die;
			}
	
	
			if($markdown==1&&!empty($saveFile)){
		 
				if(is_file($saveFile)){
					unlink($saveFile);
				}
	
				$txtStr.= "|"; 
				for($i=0;$i<count($expCellName);$i++){
					$title = " ".$expCellName[$i][1];
					$len = 40-mb_strlen($title,'UTF-8');
					$txtStr.=  $title ;
					for($j=0;$j<$len;$j++) {
						$txtStr.=" ";
					}
					$txtStr.= "|";
				}
				$txtStr.= "\n";
	
				file_put_contents($saveFile,  $txtStr ,FILE_APPEND  );$txtStr="";
	
	
	
				$txtStr.= "|";
				for($i=0;$i<count($expCellName);$i++){ 
					 
					for($j=0;$j<40;$j++) {
						$txtStr.="-";
					}
					
					$txtStr.= "|";
	
				}
				$txtStr.= "\n";
				file_put_contents($saveFile,  $txtStr ,FILE_APPEND  );$txtStr="";
	
				$cellNum = count($expCellName);
				$dataNum = count($expTableData);
				for($i=0;$i<$dataNum;$i++){
					$txtStr.= "|"; 
					for($j=0;$j<$cellNum;$j++){
						//$expTableData[$i][$expCellName[$j][0]]
						$titleValue = " ".$expTableData[$i][$expCellName[$j][0]];
						
						$txtStr.= $titleValue;
	
						$len = 40-mb_strlen( $titleValue,'UTF-8');;
						for($k=0;$k<$len;$k++) {
							$txtStr.=" ";
						}
						$txtStr.= "|";
	 
					}   
					$txtStr.= "\n"; 
					file_put_contents($saveFile,  $txtStr ,FILE_APPEND  );$txtStr="";
		  
				  }   
				  print "$expTitle 完成\n<br>";
				return;
			}
	
			//以下为xls
	 
	
			$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
			$fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
			$cellNum = count($expCellName);
			$dataNum = count($expTableData);
			vendor("PHPExcel.PHPExcel");
			$objPHPExcel = new PHPExcel();
			$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
			
			$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
			for($i=0;$i<$cellNum;$i++){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
			} 

		

			  // Miscellaneous glyphs, UTF-8   
			for($i=0;$i<$dataNum;$i++){
			  for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
			  }             
			}  
			
			/*
			
			*/
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  

 
			
 	header('pragma:public');
	 		header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
	 	header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
	
  
 
				$objWriter->save('php://output'); 
				
		 
	 
			exit;   
		}


		public static function exportExcel2($expTitle,$expCellName,$expTableData,$markdown,$saveFile){

			//	print_r($expCellName);
				$fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
				$txtStr="#".$expTitle."\n";
			 
				 
				//以下为xls
		 
		
				$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
				$fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
				$cellNum = count($expCellName);
				$dataNum = count($expTableData);
				vendor("PHPExcel.PHPExcel");
				$objPHPExcel = new PHPExcel();
				$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
				
				$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
				for($i=0;$i<$cellNum;$i++){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
				} 
	
			
				$dbArr=array(
					"jsz-infra-k8s-slave-34"=>"MySQL 5.7.37",
					"jsz-infra-k8s-slave-35"=>"MySQL 5.7.37",
					"jsz-infra-k8s-slave-36"=>"MySQL 5.7.37",
					
					
					"k8s-jzb013"=>"MongoDB v3.6.17-4.0",
					"k8s-jzb011"=>"MongoDB v3.6.17-4.0",
					"k8s-jzb012"=>"MongoDB v3.6.17-4.0",
		
					"jzb-hbase-namenode1"=>"HBase2.2.4",
					"jzb-hbase-namenode2"=>"HBase2.2.4",
					"jzb-hbase-datanode7"=>"HBase2.2.4",
					"jzb-hbase-datanode8"=>"HBase2.2.4",
					"jzb-hbase-datanode9"=>"HBase2.2.4",
					"jzb-hbase-datanode10"=>"HBase2.2.4",
					"jzb-hbase-datanode11"=>"HBase2.2.4",
					"jzb-hbase-datanode12"=>"HBase2.2.4",
					"jzb-hbase-datanode13"=>"HBase2.2.4",
					"jzb-hbase-datanode14"=>"HBase2.2.4",
					"jzb-hbase-datanode15"=>"HBase2.2.4",
					"jzb-hbase-datanode16"=>"HBase2.2.4",
					"jzb-hbase-datanode17"=>"HBase2.2.4",
					"jzb-hbase-datanode18"=>"HBase2.2.4",
				   
					);
		
					$mArr=array(
		 
						"k8s-jzb010"=>"ElasticSearch6.8.13",
						"k8s-jzb05"=>"ElasticSearch6.8.13",
						"k8s-jzb09"=>"ElasticSearch6.8.13",
						"k8s-jzb010"=>"Redis5.0.10",
						"k8s-jzb05"=>"Redis5.0.10",
						"k8s-jzb09"=>"Redis5.0.10",
						"k8s-jzb013"=>"Redis5.0.10",
						"k8s-jzb012"=>"Redis5.0.10",
						"k8s-jzb011"=>"Redis5.0.10",
						"k8s-jzb08"=>"Redis5.0.10",
						"k8s-jzb07"=>"Redis5.0.10",
						"k8s-jzb06"=>"Redis5.0.10",
						"k8s-jzb014"=>"Redis5.0.10",
						"k8s-jzb016"=>"Redis5.0.10",
						"k8s-jzb015"=>"Redis5.0.10",
						"k8s-jzb03"=>"JCQ3.0.11",
						"k8s-jzb04"=>"JCQ3.0.11",
						"k8s-jzb02"=>"JCQ3.0.11",
						"k8s-jzb026"=>"JCQ3.0.11",
						"k8s-jzb028"=>"JCQ3.0.11",
						"k8s-jzb027"=>"JCQ3.0.11",
						"k8s-jzb01"=>"JCQ3.0.11",
					   
		
					);

					
				  // Miscellaneous glyphs, UTF-8   
				for($i=0;$i<$dataNum;$i++){
					//修改数据

					$mname=$expTableData[$i][ "mname"];
					$display_name = $expTableData[$i][ "display_name"];
					if(preg_match('/k8s/',$display_name,$match)
					|| preg_match('/k8s/',$mname,$match)
					){
						$expTableData[$i][ "yesmark"]="否";
					}
					if(!isset($mArr[$mname])) {
						$expTableData[$i][ "mname"]="";
					}else{
						
						$expTableData[$i][ "mname"]=$mArr[$mname];
					}
					
					
					$os_type = $expTableData[$i][ "os_type"];
					if(!preg_match('/windows/si',$os_type,$match)){
						$expTableData[$i][ "os_type"]="centos7.9";
					}
					$expTableData[$i][ "id"]=$i+1;

					$display_name = str_replace('经信局-京智办--','',$display_name);
					$display_name = str_replace('经信局-京智办-','',$display_name);
					$display_name = str_replace('经信局-京智办','',$display_name);
					$expTableData[$i][ "display_name"]=$display_name;

				
					$dbname=$expTableData[$i][ "dbname"];
					if(!isset($dbArr[$dbname])) {
						$expTableData[$i][ "dbname"]="";
					}else{
						
						$expTableData[$i][ "dbname"]=$dbArr[$mname];
					}
				  for($j=0;$j<$cellNum;$j++){
					$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
				  }             
				}  
				
				/*
				
				*/
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
	
	 
				
		 header('pragma:public');
				 header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
			 header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
		
	  
	 
					$objWriter->save('php://output'); 
					
			 
		 
				exit;   
			}

}