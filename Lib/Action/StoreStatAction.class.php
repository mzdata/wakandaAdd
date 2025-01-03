<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$storeStatModel = D("StoreStat"); //BASECIDE0
// |StoreStat\/queryOneMyData$
// |StoreStat\/delMyData$
// |StoreStat\/addMyData$
// |StoreStat\/updateMyData$
// |StoreStat\/storeLog$
/*
  id  id 
  tenantCode  租户编码 
  bizList  分类划分 
  status  启用状态 
  updatedAt  修改时间 
  createdAt  纪录创建时间 */

class StoreStatAction extends  Action {

	
	public function lookData() {
		//是否有表权限
       $idName = "tablename."."store_stat" ;
        $showTable = Util::getTFAuth($idName)
;


        

		$addpara = $_SERVER['REQUEST_URI'];
		$addpara = preg_replace('/.*\?/','',$addpara);
		$_SESSION['addpara'] = $addpara;

        $params                = $_REQUEST["params"];

        $storeStatModel = D("StoreStat");
        $editData = $storeStatModel->getById($params);
		$tenant_code=$editData["tenant_code"];

		
		$ip =   SERVER_DORIS; 
		$port =     PORT_DORIS; 
		$user =   USERNAME_DORIS; 
		$pwd =  PASSWORD_DORIS;
		$dbName =   "timestone_".$tenant_code; 

		$dbNameStr  = "$ip:$port|".$dbName;  
		$tableTitle1Arr=array();
		

		echo "正在计算表结构<br>"; // 输出换行符
		flush(); // 刷新输出缓冲区，将数据发送给客户端

		$retArr = Util::getTblStruct($user, $pwd ,$dbNameStr,$tableTitleArr );
		
		
		print '<textarea name="cc" type="text" class="xxlarge" id="cc"    rows=50 cols=20 readonly="readonly" >';
		foreach($retArr as $tbl => $tblArr)
		{

			$tblTitle = $tbl;
			if(isset($tableTitleArr[$tbl])) $tblTitle=$tableTitleArr[$tbl];

	
			
			print "#############################\n";
			print "Tablename	$tbl	".$tblTitle."\n";
			foreach($tblArr as $f => $fArr)
			{
				$COLUMN_TYPE = $fArr["COLUMN_TYPE"];
				$COLUMN_COMMENT = $fArr["COLUMN_COMMENT"];
				if(empty($COLUMN_COMMENT ))$COLUMN_COMMENT =$f;
				print "$f	$COLUMN_TYPE	$COLUMN_COMMENT \n";
			}
		}

		print ' </textarea>';
			


		
		die;
    }

	function diffLog() {
		$statDay = $_REQUEST["statDay"];
		date_default_timezone_set('PRC');
		$today = date("Y-m-d",time());
		$yesterday =  date("Y-m-d",time()-86400);
		if(empty($statDay)){
			$statDay=$today;
		}

		
		$tbDataassetsStatisticsModel = D("TbDataassetsStatistics");

		
		$preDay= date("Y-m-d",strtotime($statDay)-86400);

		
		$year_str= date("Y",strtotime($statDay));

		$storeLogModel = D("StoreLog"); 
		$storeStatModel = D("StoreStat");
		$list = $storeStatModel->where("status=1")->select(); 

		foreach ($list as $row) {
			$tenant_code=$row["tenant_code"];
			$tenant_code=trim($tenant_code);
			$biz_list = $row["biz_list"];
			$bizArr = preg_split('/\r|\n/',$biz_list,-1,PREG_SPLIT_NO_EMPTY);


			print "start tenant_code=$tenant_code\n";
			$resultArr = array();
			$destArr = array();
			

			$tmpList = $storeLogModel->where("tenant_code='$tenant_code' and  DATE_FORMAT(created_at, '%Y-%m-%d')='$statDay'")->select();
 

			foreach($tmpList as $row2) {
				$tenant_code=$row2["tenant_code"]; 
				$table_name=$row2["table_name"];
				$storage=$row2["storage"];
				$rows_number=$row2["rows_number"]; 
				$resultArr[$table_name]["storage"]=$storage;
				$resultArr[$table_name]["rows_number"]=$rows_number; 


			}

			
			$preList = $storeLogModel->where("tenant_code='$tenant_code' and  DATE_FORMAT(created_at, '%Y-%m-%d')='$preDay'")->select();

			foreach($preList as $row2) {
				$tenant_code=$row2["tenant_code"]; 
				$table_name=$row2["table_name"];
				$storage=$row2["storage"];
				$rows_number=$row2["rows_number"]; 
				$resultArr[$table_name]["storage"]-=$storage;
				$resultArr[$table_name]["rows_number"]-=$rows_number; 


			}

			//print_r($resultArr);

			foreach($bizArr as $line){
				$lineArr = preg_split('/\=/',$line,-1,PREG_SPLIT_NO_EMPTY);
				$biz_name=$lineArr[0];
				$biz_table=$lineArr[1];
				$bizTableArr = preg_split('/\,/',$biz_table,-1,PREG_SPLIT_NO_EMPTY);
				$destArr[$biz_name]["md5"]=md5($line); 
				foreach($bizTableArr as $tbl){	
					if(isset($resultArr[$tbl])){
						$storage=$resultArr[$tbl]["storage"];
						$rows_number=$resultArr[$tbl]["rows_number"]; 
						$destArr[$biz_name]["storage"]+=$storage;
						$destArr[$biz_name]["rows_number"]+=$rows_number; 
						

					}
				}

			}

			print_r($destArr);

			foreach($destArr as $biz_name=>$row2){
				$storage=$row2["storage"]*1024*1024;
				$rows_number=$row2["rows_number"]; 
				$md5str=$row2["md5"]; 

				$count=$tbDataassetsStatisticsModel->where("tenant_code='$tenant_code' and biz_tag='$biz_name' and date_str='$statDay'")->count();
 

				if($count==0){
					$data = array();


					$data["tenant_code"] =$tenant_code;
					$data["biz_tag"] = $biz_name;
					$data["table_name"] = $md5str; 
					$data["table_type"] = "di"; 
					$data["date_str"] = $statDay;
					$data["year_str"] = $year_str;
					$data["storage"] = $storage;
					$data["number"] = $rows_number;
					$data["update_time"] =  date("Y-m-d H:i:s");  



					$su =  $tbDataassetsStatisticsModel->data($data)->add();
				}

			}
			

	
		}



		print "finish";
	}

	function storeLog() {
		set_time_limit(0);
		$storeLogModel = D("StoreLog"); 
		$storeStatModel = D("StoreStat");
		$list = $storeStatModel->select();
		
		date_default_timezone_set('PRC');

		$today = date("Y-m-d",time());

		$resultArr = array();
		foreach ($list as $row) {

			$tenant_code=$row["tenant_code"];
			$tenant_code=trim($tenant_code);
			print "start tenant_code=$tenant_code\n";

			$sql="SELECT 
    table_schema AS 'doris_db',
    table_name  ,
    ROUND((ifnull(data_length,0) + ifnull(index_length,0)) / 1024 / 1024, 2) AS 'storage'
FROM 
    information_schema.tables
WHERE 
    table_schema = 'timestone_".$tenant_code."'  ";
			$tmpList = Util::getDorisDbResult($tenant_code,$sql);
			$doris_db="";
			foreach ($tmpList as $row2) {
				$doris_db=$row2["doris_db"];
				$table_name=$row2["table_name"];
				$storage=$row2["storage"];

				$resultArr[$table_name]["storage"]=$storage;
			}

			
			$sql=" SELECT 
    table_schema AS 'doris_db',
    table_name ,
    table_rows
FROM 
    information_schema.tables
WHERE 
    table_schema = 'timestone_".$tenant_code."'  ";

			$tmpList = Util::getDorisDbResult($tenant_code,$sql);
			foreach ($tmpList as $row2) {
				$doris_db=$row2["doris_db"];
				$table_name=$row2["table_name"];
				$table_rows=$row2["table_rows"];

				$resultArr[$table_name]["table_rows"]=$table_rows;
			}

			foreach($resultArr as $table_name=>$row2){
				
				$storage=$row2["storage"];
				$table_rows=$row2["table_rows"];

				$count = $storeLogModel->where("created_at='$today' and table_name='$table_name' and tenant_code='$tenant_code'")->count();
				if($count==0){
					
					$data = array(); 
					$data["tenant_code"] = $tenant_code;
					$data["doris_db"] = $doris_db;
					$data["table_name"] = $table_name; 
					$data["storage"] = $storage;
					$data["rows_number"] = $table_rows; 
					$data["updated_at"] =   date("Y-m-d H:i:s");  
					$data["created_at"] =  date("Y-m-d H:i:s");  
					$su =  $storeLogModel->data($data)->add();
				}



			}


 
				print "finish tenant_code=$tenant_code\n";
		}//tenant_code


		
		print "finish\n";

		
	}


	function stripslashesx($value){
		return stripslashes($value);
	}

	function addslashesx($value){
		return addslashes($value);
	}


	function getTfFieldName($fieldName)
	{
		$tfFieldName            = "";
		   for ($i = 0; $i < strlen($fieldName); $i++) {
			   $tmp  = substr($fieldName, $i, 1);
			   $tmppre = "";
			   if($i>0) $tmppre = substr($fieldName, $i-1, 1);
			   if($tmppre == "_")
			   {
				   $tfFieldName .= strtoupper($tmp);
			   }
			   else if($tmp != "_" && $tmppre != "_")
			   {
				   $tfFieldName .= $tmp;
			   }
   
		   }
		   return   $tfFieldName ;
	}

	//StoreStat\/getActionTableName$
 function getActionTableName($tablename)
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
 	    public function queryOneMyData() {


			date_default_timezone_set('PRC');

			$json = file_get_contents("php://input"); 
			$jsonArr = json_decode($json,true); 
			$id=$jsonArr["id"];

			
			

					   	$storeStatModel = D("StoreStat");
				$editData = $storeStatModel->getById($id);




			$dataArr = array();

			foreach($editData as $k =>$v)
			{
				$Afield = $this->getTfFieldName($k);
				$dataArr[$Afield]=$v;
			}

		
 
			if(count($dataArr)==0){

				$retArr=array(
					"code"=>-1,
					"message"=>"未找到数据"
				);
				print json_encode($retArr,JSON_UNESCAPED_UNICODE);

			}else{

				$retArr=array(
					"code"=>0,
					"data"=>$dataArr
				);
				print json_encode($retArr,JSON_UNESCAPED_UNICODE);

			}

			die;
		}


	    public function delMyData() {

			$json = file_get_contents("php://input"); 
			$jsonArr = json_decode($json,true); 
			$id=$jsonArr["id"];

					   	$storeStatModel = D("StoreStat");
					$sc = 	$storeStatModel->where("id='$id'")->delete();

				
					

					$retArr=array(
						"code"=>0,
						"message"=>"删除成功",
						"data"=>$sc
					);
					print json_encode($retArr,JSON_UNESCAPED_UNICODE);

			die;
		}

	    public function updateMyData() {
			
			$json = file_get_contents("php://input"); 
			$jsonArr = json_decode($json,true);  

					   	$storeStatModel = D("StoreStat");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["tenantCode"]))		$data["tenant_code"] =    $this->addslashesx($jsonArr["tenantCode"]); 
		if(isset($jsonArr["bizList"]))		$data["biz_list"] =    $this->addslashesx($jsonArr["bizList"]); 
		if(isset($jsonArr["status"]))		$data["status"] =    $this->addslashesx($jsonArr["status"]); 
				$data["updated_at"] =   date("Y-m-d H:i:s");  

            $su = $storeStatModel->data($data)->save();

            if ($su) {
 			 
				$retArr=array(
					"code"=>0,
					"message"=>"编辑成功",
					"data"=>$su
				);
				print json_encode($retArr,JSON_UNESCAPED_UNICODE);

            } else {
 			 
				$retArr=array(
					"code"=>-1,
					"message"=>"编辑失败",
					"data"=>$su
				);
				print json_encode($retArr,JSON_UNESCAPED_UNICODE);

            }
 
			die;
		}

	    public function addMyData() {
			
			
			$json = file_get_contents("php://input"); 
			$jsonArr = json_decode($json,true);  

					   	$storeStatModel = D("StoreStat");

 				$data = array();


									$data["tenant_code"] = $this->addslashesx(  $jsonArr["TenantCode"]); 
				$data["biz_list"] = $this->addslashesx(  $jsonArr["BizList"]); 
				$data["status"] = $this->addslashesx(  $jsonArr["Status"]); 
				$data["updated_at"] =   date("Y-m-d H:i:s");  
				$data["created_at"] =  date("Y-m-d H:i:s"); 



				$su =  $storeStatModel->data($data)->add();

	
				if ($su) {
 			 
					$retArr=array(
						"code"=>0,
						"message"=>"编辑成功",
						"data"=>$su
					);
					print json_encode($retArr,JSON_UNESCAPED_UNICODE);
	
				} else {
				  
					$retArr=array(
						"code"=>-1,
						"message"=>"编辑失败",
						"data"=>$su
					);
					print json_encode($retArr,JSON_UNESCAPED_UNICODE);
	
				}
			die;
		}




    public function queryList() {
		//page 第几页 size 一页多少条 searchKey 搜索关键字 
		//{"page":1,"size":20,"searchKey":""}
		$json = file_get_contents("php://input"); 
		$jsonArr = json_decode($json,true);  
 
        $searchkey = $this->addslashesx($jsonArr["searchKey"]);
        if(empty($searchkey)) $searchkey="";
        $searchkey=trim($searchkey);

		$pagelimit = $jsonArr["size"]; 
		if(empty($pagelimit)){
			$pagelimit = 20;
		}
		$p=$jsonArr["page"];
		if(empty($p)){
			$p = 1;
		}
		
		

      

		$storeStatModel = D("StoreStat");
 

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or biz_list like '%$searchkey%' or status like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $storeStatModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $storeStatModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

	 		$dataArr = array();
		for($i=0;$i<count($listData);$i++)
		{

			 $editData = $listData[$i];
			 foreach($editData as $k =>$v){
				$Afield = $this->getTfFieldName($k);
				$dataArr[$i][$Afield]=$v;
			 }

		}

		$pageCount = ceil($count/$pagelimit);

			  
		$retArr=array(
			"code"=>0,
			"totalCount"=>"$count",
			"pageCount"=>"$pageCount",
			"data"=>$dataArr
		);
		print json_encode($retArr,JSON_UNESCAPED_UNICODE);
		die;
    }


    public function index() {
        $nav = Util::navigator("index");
        $pagelimit =  Util::getSelfPage( str_replace("Action","", get_class( $this )))
;

        $searchkey = $this->addslashesx($_REQUEST["searchkey"]);
        if(empty($searchkey)) $searchkey="";
        $searchkey=trim($searchkey);

        $FFSearch = $_REQUEST["FFSearch"];
        if(empty($FFSearch)) $FFSearch="";


        //是否有表查看权限
        $idName = "tablename."."store_stat" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$storeStatModel = D("StoreStat");
    	$tmpArr = $storeStatModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "store_stat".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or biz_list like '%$searchkey%' or status like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		}
		//FF过滤器
		$pageWhere = "";
        $oldFFArr = array();
      	if($FFSearch==-1)
        {
        	$_SESSION["FFArr"]= array();

        }
		if($FFSearch==1)
	 	{
	 			$FF="";

			  	$FFArr = $_REQUEST["FFArr"];
			   	if(empty($FFArr)) $FFArr= $_SESSION["FFArr"];
			   	$_SESSION["FFArr"] = $FFArr;


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"store_stat",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $storeStatModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $storeStatModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $storeStatModel->getDbFields()  ;
    	$tableNameArr = array();
		foreach($tmpArr as $field)
		{
			$tableName = Util::getTableByIdName($field);
			if(!empty($tableName))
			{
				$tableNameArr[$field]=1;
			}
		}

 		$listData = $this->idRelation($tableNameArr,$listData); //一些关联id对应的div展示

		//$this->stripslashesx
		for($i=0;$i<count($listData);$i++) {

			foreach($listData[$i] as $field=>$v) {
				$listData[$i][$field]=$this->stripslashesx($listData[$i][$field]);
			}
		}



       	$pageElement["count"]=$count;
 		$pageElement["FF"] = $FF;
 		$pageElement["oldFFArr"] = $oldFFArr;
		 $pageElement["AUTH_MARK_STR"]=$_SESSION[DBNAME."auth"]; 

 		$pageElement["FFSearch"] = $FFSearch;
 		$pageElement["searchkey"] = $searchkey;
 		$pageElement["pageWhere"] = $pageWhere;

          	//整理$showFieldsArr;
       	$tableName =  str_replace("Action","", get_class( $this ));
       	$tableName = Util::getBaseTableName($tableName);
       	$editFieldsArr = $showFieldsArr;


       $realshowFieldsArr=array();
       $editFieldsArr=array();

        foreach($showFieldsArr as $field => $value)
        {
        	if($value==1)
        	{

        		$idName =  	$tableName .".".$field;
        		$realvalue = Util::getSelfAuth($idName)
;
				$realshowFieldsArr[$field] = $realvalue
;

				$showIdName = $tableName ."__".$field;
				$tmpTitle =  Util::getTableFieldTitle($idName)
;
				if(!empty($tmpTitle))
				{

					$editFieldsArr[$showIdName]["title"] = $tmpTitle;
        			$editFieldsArr[ $showIdName]["value"]= $realvalue;
        		}
        	}
        }


        $pageElement["editFieldsArr"]= $editFieldsArr;
        $pageElement["showFieldsArr"]=$realshowFieldsArr;
        //整理$showFieldsArr完毕
        $pageElement["listData"]=$listData;

        $pageElement["tableAuth"]= Util::getTableAuth( )
;
        $pageElement["selected"]= str_replace("Action","", get_class( $this ));


        $pageElement["pagelimit"]= $pagelimit;
        $pageElement["showTable"]= $showTable 
;
$pageElement["AUTH_MARK_STR"]=$_SESSION[DBNAME."auth"];

        $this->assign("pe", $pageElement);
        $this->display();
    }

	public function add() {
		 //是否有表权限
       $idName = "tablename."."store_stat" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$storeStatModel = D("StoreStat");
				$data = array();


				$data["tenant_code"] = addslashes(  $_REQUEST["addData_tenant_code"] ); 
				$data["biz_list"] = addslashes(  $_REQUEST["addData_biz_list"] ); 
				$data["status"] = addslashes(  $_REQUEST["addData_status"] ); 
				$data["updated_at"] =   date("Y-m-d H:i:s");  
				$data["created_at"] =  date("Y-m-d H:i:s"); 



				$su =  $storeStatModel->data($data)->add();

				if ($su) {
					print "<script language='javascript'>alert('数据添加成功');self.opener.location.reload();window.close();</script>";
				} else {
					print "<script language='javascript'>alert('数据添加失败');self.opener.location.reload();window.close();</script>";

				}
				return;

        }
        $nav = Util::navigator("add");

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);
        $pageElement["selected"]= str_replace("Action","", get_class( $this ));
        $this->assign("pe", $pageElement);
        $this->display();
    }

	public function edit() {
		//是否有表权限
       $idName = "tablename."."store_stat" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$storeStatModel = D("StoreStat");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["biz_list"] =  addslashes( $_REQUEST["editData_biz_list"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["updated_at"] =   date("Y-m-d H:i:s");  




            $su = $storeStatModel->data($data)->save();

              if ($su) {
 				$addpara = $_SESSION['addpara'];

         		print "<script language='javascript'>alert('数据更新成功');window.opener.location.href=self.opener.location+'?".$addpara."';window.close();</script>";
            } else {
                print "<script language='javascript'>alert('数据更新失败');self.opener.location.reload();window.close();</script>";

            }
            return;
        }


		$addpara = $_SERVER['REQUEST_URI'];
		$addpara = preg_replace('/.*\?/','',$addpara);
		$_SESSION['addpara'] = $addpara;

        $params                = $_REQUEST["params"];

        	$storeStatModel = D("StoreStat");
        $editData = $storeStatModel->getById($params);
		foreach($editData as $field=>$value) {
			$editData[$field]=$this->stripslashesx($editData[$field]);
		}

        $nav = Util::navigator("edit");

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);
        $pageElement["editData"]=$editData;
        $pageElement["selected"]= str_replace("Action","", get_class( $this ));
        $this->assign("pe", $pageElement);
        $this->display();
    }

	public function delete() {
	       //是否有表权限
         $idName = "tablename."."store_stat" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$storeStatModel = D("StoreStat");
        $sc = $storeStatModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("StoreStat/index");



    }

    public function getFFSearch($FFArr ,$request,$tablename,&$oldFFArr,&$FF)
    {
    		 $selectWhere="";
    	  	$pageWhere = "FFSearch=1";
			  	foreach($FFArr as $ff)
			  	{
			  		$field = str_replace("FF_","",$ff);
			  		$fieldSearch = str_replace("$tablename__","",$field);
			  		$fvalue =  trim($request[$ff]);
			  		$pageWhere .=  "&".$ff."=".$fvalue;

			  		$oldFFArr[$field]["checked"]=" checked=\"checked\"";
			  		$oldFFArr[$field]["value"]=$fvalue;

			  		$idName =   $tablename .".".$fieldSearch;
			  		$showFields  = Util::getTableFieldTitle($idName)
;

			  		$FF .=$showFields."=".  Util::getNameById($field,$fvalue).";";
			  		//字段特殊处理

			  		{

			  			$partWhere = " $fieldSearch='$fvalue'";
			  		}
			  		if(!empty($selectWhere )) $selectWhere .=" and ";
			  		$selectWhere .= $partWhere;

			  	}

			  	return $selectWhere;
    }

    public function idRelation($tableNameArr,$listData)
    {
    	$tmpRemberArr = array();
        for($i=0;$i<count($listData);$i++)
       	{
       		foreach($listData[$i] as $fieldName => $fieldValue)
       		{
       			//$tableName = Util::getTableByIdName($fieldName);
       			if($tableNameArr[$fieldName]==1)
       			{

       				$listData[$i][$fieldName ."Src"] = $listData[$i][$fieldName ];
       				if(isset($tmpRemberArr ["$fieldName=".$fieldValue]))
       				{
       					$listData[$i][$fieldName."Dest" ] = $tmpRemberArr ["$fieldName=".$fieldValue];
       				}
       				else
       				{
       					$listData[$i][$fieldName."Dest" ] = Util::getNameById($fieldName,$fieldValue);
       					$tmpRemberArr ["$fieldName=".$fieldValue] = $listData[$i][$fieldName."Dest" ] ;
       				}
       			}
       		}
       	}

       	return $listData;
    }

	public function upServerModel() {
		header ( "Content-Type:text/html;charset=utf-8" );
		if (isset ( $_FILES ["import"] ) && ($_FILES ["import"] ["error"] == 0)) {

			$result = Util::importExecl ( $_FILES ["import"] ["tmp_name"] );
			$sucessNum = 0;
			if ($result ["error"] == 1) {
				$execl_data = $result ["data"] [0] ["Content"];

				$store_statModel = D ( "StoreStat" );
				$tmpArr = $store_statModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "store_stat" . "." . $field;
					$auth = $authBase [$idName];
					if ($auth > 0) {
						$fieldArr [] = $field;
					}
				}

				foreach ( $execl_data as $k => $v ) {
					// ..这里写你的业务代码..
					// $k==1 列时间
					// $k==2 列标题

					if ($k > 2) {

						for($i = 0; $i < count ( $fieldArr ); $i ++) {
							if ($v [$i] instanceof PHPExcel_RichText) // 富文本转换字符串
								$v [$i] = $v [$i]->__toString ();
						}

						$data = array ();

						for($i = 0; $i < count ( $fieldArr ); $i ++) {

							// 整理反向数据
							$v [$i] = preg_replace ( '/\=.*/', '', $v [$i] );
							$data [$fieldArr [$i]] = $v [$i];
						}

						if (isset ( $data ["id"] ) && $data ["id"] > 0) { // update

							$store_statModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $store_statModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../StoreStat'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."store_stat" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$storeStatModel = D("StoreStat");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["biz_list"] =  addslashes( $_REQUEST["editData_biz_list"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["updated_at"] =   date("Y-m-d H:i:s");  


	 		 $data["id"]="";


            $su = $storeStatModel->data($data)->add();

              if ($su) {
 				$addpara = $_SESSION['addpara'];

         		print "<script language='javascript'>alert('数据更新成功');window.opener.location.href=self.opener.location+'?".$addpara."';window.close();</script>";
            } else {
                print "<script language='javascript'>alert('数据更新失败');self.opener.location.reload();window.close();</script>";

            }
            return;
        }


		$addpara = $_SERVER['REQUEST_URI'];
		$addpara = preg_replace('/.*\?/','',$addpara);
		$_SESSION['addpara'] = $addpara;

        $params                = $_REQUEST["params"];

        	$storeStatModel = D("StoreStat");
        $editData = $storeStatModel->getById($params);
foreach($editData as $field=>$value) {
			$editData[$field]=$this->stripslashesx($editData[$field]);
		}

        $nav = Util::navigator("edit");

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);
        $pageElement["editData"]=$editData;
        $pageElement["selected"]= str_replace("Action","", get_class( $this ));
        $this->assign("pe", $pageElement);
        $this->display();
    }

}