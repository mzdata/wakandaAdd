<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$storeBiModel = D("StoreBi"); //BASECIDE0
// |StoreBi\/queryOneMyData$
// |StoreBi\/delMyData$
// |StoreBi\/addMyData$
// |StoreBi\/updateMyData$
// |StoreBi\/queryList$
/*
  id  id 
  tenantCode  tenant_code 
  storeId  store_id 
  provider  provider 
  storeCode  store_code 
  storeName  store_name 
  aliasStoreNames  alias_store_names 
  province  province 
  city  city 
  country  country 
  address  address 
  phone  phone 
  longitude  longitude 
  latitude  latitude 
  square  square 
  rent  rent 
  employees  employees 
  onboardDate  onboard_date 
  shutdownDate  shutdown_date 
  storeType  store_type 
  status  status 
  dt  dt 
  deleted  deleted 
  updateTime  update_time 
  updateTimeBusiness  update_time_business 
  businessDistrict  business_district 
  tableCount  table_count 
  available  available */

class StoreBiAction extends  Action {
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

	//StoreBi\/getActionTableName$
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

			
			

					   	$storeBiModel = D("StoreBi");
				$editData = $storeBiModel->getById($id);




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

					   	$storeBiModel = D("StoreBi");
					$sc = 	$storeBiModel->where("id='$id'")->delete();

				
					

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

					   	$storeBiModel = D("StoreBi");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["tenantCode"]))		$data["tenant_code"] =    $this->addslashesx($jsonArr["tenantCode"]); 
		if(isset($jsonArr["storeId"]))		$data["store_id"] =    $this->addslashesx($jsonArr["storeId"]); 
		if(isset($jsonArr["provider"]))		$data["provider"] =    $this->addslashesx($jsonArr["provider"]); 
		if(isset($jsonArr["storeCode"]))		$data["store_code"] =    $this->addslashesx($jsonArr["storeCode"]); 
		if(isset($jsonArr["storeName"]))		$data["store_name"] =    $this->addslashesx($jsonArr["storeName"]); 
		if(isset($jsonArr["aliasStoreNames"]))		$data["alias_store_names"] =    $this->addslashesx($jsonArr["aliasStoreNames"]); 
		if(isset($jsonArr["province"]))		$data["province"] =    $this->addslashesx($jsonArr["province"]); 
		if(isset($jsonArr["city"]))		$data["city"] =    $this->addslashesx($jsonArr["city"]); 
		if(isset($jsonArr["country"]))		$data["country"] =    $this->addslashesx($jsonArr["country"]); 
		if(isset($jsonArr["address"]))		$data["address"] =    $this->addslashesx($jsonArr["address"]); 
		if(isset($jsonArr["phone"]))		$data["phone"] =    $this->addslashesx($jsonArr["phone"]); 
		if(isset($jsonArr["longitude"]))		$data["longitude"] =    $this->addslashesx($jsonArr["longitude"]); 
		if(isset($jsonArr["latitude"]))		$data["latitude"] =    $this->addslashesx($jsonArr["latitude"]); 
		if(isset($jsonArr["square"]))		$data["square"] =    $this->addslashesx($jsonArr["square"]); 
		if(isset($jsonArr["rent"]))		$data["rent"] =    $this->addslashesx($jsonArr["rent"]); 
		if(isset($jsonArr["employees"]))		$data["employees"] =    $this->addslashesx($jsonArr["employees"]); 
		if(isset($jsonArr["onboardDate"]))		$data["onboard_date"] =    $this->addslashesx($jsonArr["onboardDate"]); 
		if(isset($jsonArr["shutdownDate"]))		$data["shutdown_date"] =    $this->addslashesx($jsonArr["shutdownDate"]); 
		if(isset($jsonArr["storeType"]))		$data["store_type"] =    $this->addslashesx($jsonArr["storeType"]); 
		if(isset($jsonArr["status"]))		$data["status"] =    $this->addslashesx($jsonArr["status"]); 
		if(isset($jsonArr["dt"]))		$data["dt"] =    $this->addslashesx($jsonArr["dt"]); 
		if(isset($jsonArr["deleted"]))		$data["deleted"] =    $this->addslashesx($jsonArr["deleted"]); 
		if(isset($jsonArr["updateTime"]))		$data["update_time"] =    $this->addslashesx($jsonArr["updateTime"]); 
		if(isset($jsonArr["updateTimeBusiness"]))		$data["update_time_business"] =    $this->addslashesx($jsonArr["updateTimeBusiness"]); 
		if(isset($jsonArr["businessDistrict"]))		$data["business_district"] =    $this->addslashesx($jsonArr["businessDistrict"]); 
		if(isset($jsonArr["tableCount"]))		$data["table_count"] =    $this->addslashesx($jsonArr["tableCount"]); 
		if(isset($jsonArr["available"]))		$data["available"] =    $this->addslashesx($jsonArr["available"]); 

            $su = $storeBiModel->data($data)->save();

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

					   	$storeBiModel = D("StoreBi");

 				$data = array();


									$data["tenant_code"] = $this->addslashesx(  $jsonArr["TenantCode"]); 
				$data["store_id"] = $this->addslashesx(  $jsonArr["StoreId"]); 
				$data["provider"] = $this->addslashesx(  $jsonArr["Provider"]); 
				$data["store_code"] = $this->addslashesx(  $jsonArr["StoreCode"]); 
				$data["store_name"] = $this->addslashesx(  $jsonArr["StoreName"]); 
				$data["alias_store_names"] = $this->addslashesx(  $jsonArr["AliasStoreNames"]); 
				$data["province"] = $this->addslashesx(  $jsonArr["Province"]); 
				$data["city"] = $this->addslashesx(  $jsonArr["City"]); 
				$data["country"] = $this->addslashesx(  $jsonArr["Country"]); 
				$data["address"] = $this->addslashesx(  $jsonArr["Address"]); 
				$data["phone"] = $this->addslashesx(  $jsonArr["Phone"]); 
				$data["longitude"] = $this->addslashesx(  $jsonArr["Longitude"]); 
				$data["latitude"] = $this->addslashesx(  $jsonArr["Latitude"]); 
				$data["square"] = $this->addslashesx(  $jsonArr["Square"]); 
				$data["rent"] = $this->addslashesx(  $jsonArr["Rent"]); 
				$data["employees"] = $this->addslashesx(  $jsonArr["Employees"]); 
				$data["onboard_date"] = $this->addslashesx(  $jsonArr["OnboardDate"]); 
				$data["shutdown_date"] = $this->addslashesx(  $jsonArr["ShutdownDate"]); 
				$data["store_type"] = $this->addslashesx(  $jsonArr["StoreType"]); 
				$data["status"] = $this->addslashesx(  $jsonArr["Status"]); 
				$data["dt"] = $this->addslashesx(  $jsonArr["Dt"]); 
				$data["deleted"] = $this->addslashesx(  $jsonArr["Deleted"]); 
				$data["update_time"] = $this->addslashesx(  $jsonArr["UpdateTime"]); 
				$data["update_time_business"] = $this->addslashesx(  $jsonArr["UpdateTimeBusiness"]); 
				$data["business_district"] = $this->addslashesx(  $jsonArr["BusinessDistrict"]); 
				$data["table_count"] = $this->addslashesx(  $jsonArr["TableCount"]); 
				$data["available"] = $this->addslashesx(  $jsonArr["Available"]); 



				$su =  $storeBiModel->data($data)->add();

	
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
		
		

      

		$storeBiModel = D("StoreBi");
 

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or store_id like '%$searchkey%' or provider like '%$searchkey%' or store_code like '%$searchkey%' or store_name like '%$searchkey%' or alias_store_names like '%$searchkey%' or province like '%$searchkey%' or city like '%$searchkey%' or country like '%$searchkey%' or address like '%$searchkey%' or phone like '%$searchkey%' or longitude like '%$searchkey%' or latitude like '%$searchkey%' or square like '%$searchkey%' or rent like '%$searchkey%' or employees like '%$searchkey%' or onboard_date like '%$searchkey%' or shutdown_date like '%$searchkey%' or store_type like '%$searchkey%' or status like '%$searchkey%' or dt like '%$searchkey%' or deleted like '%$searchkey%' or update_time like '%$searchkey%' or update_time_business like '%$searchkey%' or business_district like '%$searchkey%' or table_count like '%$searchkey%' or available like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $storeBiModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $storeBiModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."store_bi" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$storeBiModel = D("StoreBi");
    	$tmpArr = $storeBiModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "store_bi".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or store_id like '%$searchkey%' or provider like '%$searchkey%' or store_code like '%$searchkey%' or store_name like '%$searchkey%' or alias_store_names like '%$searchkey%' or province like '%$searchkey%' or city like '%$searchkey%' or country like '%$searchkey%' or address like '%$searchkey%' or phone like '%$searchkey%' or longitude like '%$searchkey%' or latitude like '%$searchkey%' or square like '%$searchkey%' or rent like '%$searchkey%' or employees like '%$searchkey%' or onboard_date like '%$searchkey%' or shutdown_date like '%$searchkey%' or store_type like '%$searchkey%' or status like '%$searchkey%' or dt like '%$searchkey%' or deleted like '%$searchkey%' or update_time like '%$searchkey%' or update_time_business like '%$searchkey%' or business_district like '%$searchkey%' or table_count like '%$searchkey%' or available like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"store_bi",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $storeBiModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $storeBiModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $storeBiModel->getDbFields()  ;
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
       $idName = "tablename."."store_bi" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$storeBiModel = D("StoreBi");
				$data = array();


				$data["tenant_code"] = addslashes(  $_REQUEST["addData_tenant_code"] ); 
				$data["store_id"] = addslashes(  $_REQUEST["addData_store_id"] ); 
				$data["provider"] = addslashes(  $_REQUEST["addData_provider"] ); 
				$data["store_code"] = addslashes(  $_REQUEST["addData_store_code"] ); 
				$data["store_name"] = addslashes(  $_REQUEST["addData_store_name"] ); 
				$data["alias_store_names"] = addslashes(  $_REQUEST["addData_alias_store_names"] ); 
				$data["province"] = addslashes(  $_REQUEST["addData_province"] ); 
				$data["city"] = addslashes(  $_REQUEST["addData_city"] ); 
				$data["country"] = addslashes(  $_REQUEST["addData_country"] ); 
				$data["address"] = addslashes(  $_REQUEST["addData_address"] ); 
				$data["phone"] = addslashes(  $_REQUEST["addData_phone"] ); 
				$data["longitude"] = addslashes(  $_REQUEST["addData_longitude"] ); 
				$data["latitude"] = addslashes(  $_REQUEST["addData_latitude"] ); 
				$data["square"] = addslashes(  $_REQUEST["addData_square"] ); 
				$data["rent"] = addslashes(  $_REQUEST["addData_rent"] ); 
				$data["employees"] = addslashes(  $_REQUEST["addData_employees"] ); 
				$data["onboard_date"] = addslashes(  $_REQUEST["addData_onboard_date"] ); 
				$data["shutdown_date"] = addslashes(  $_REQUEST["addData_shutdown_date"] ); 
				$data["store_type"] = addslashes(  $_REQUEST["addData_store_type"] ); 
				$data["status"] = addslashes(  $_REQUEST["addData_status"] ); 
				$data["dt"] = addslashes(  $_REQUEST["addData_dt"] ); 
				$data["deleted"] = addslashes(  $_REQUEST["addData_deleted"] ); 
				$data["update_time"] = addslashes(  $_REQUEST["addData_update_time"] ); 
				$data["update_time_business"] = addslashes(  $_REQUEST["addData_update_time_business"] ); 
				$data["business_district"] = addslashes(  $_REQUEST["addData_business_district"] ); 
				$data["table_count"] = addslashes(  $_REQUEST["addData_table_count"] ); 
				$data["available"] = addslashes(  $_REQUEST["addData_available"] ); 



				$su =  $storeBiModel->data($data)->add();

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
       $idName = "tablename."."store_bi" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$storeBiModel = D("StoreBi");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["store_id"] =  addslashes( $_REQUEST["editData_store_id"]); 
				$data["provider"] =  addslashes( $_REQUEST["editData_provider"]); 
				$data["store_code"] =  addslashes( $_REQUEST["editData_store_code"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["alias_store_names"] =  addslashes( $_REQUEST["editData_alias_store_names"]); 
				$data["province"] =  addslashes( $_REQUEST["editData_province"]); 
				$data["city"] =  addslashes( $_REQUEST["editData_city"]); 
				$data["country"] =  addslashes( $_REQUEST["editData_country"]); 
				$data["address"] =  addslashes( $_REQUEST["editData_address"]); 
				$data["phone"] =  addslashes( $_REQUEST["editData_phone"]); 
				$data["longitude"] =  addslashes( $_REQUEST["editData_longitude"]); 
				$data["latitude"] =  addslashes( $_REQUEST["editData_latitude"]); 
				$data["square"] =  addslashes( $_REQUEST["editData_square"]); 
				$data["rent"] =  addslashes( $_REQUEST["editData_rent"]); 
				$data["employees"] =  addslashes( $_REQUEST["editData_employees"]); 
				$data["onboard_date"] =  addslashes( $_REQUEST["editData_onboard_date"]); 
				$data["shutdown_date"] =  addslashes( $_REQUEST["editData_shutdown_date"]); 
				$data["store_type"] =  addslashes( $_REQUEST["editData_store_type"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 
				$data["deleted"] =  addslashes( $_REQUEST["editData_deleted"]); 
				$data["update_time"] =  addslashes( $_REQUEST["editData_update_time"]); 
				$data["update_time_business"] =  addslashes( $_REQUEST["editData_update_time_business"]); 
				$data["business_district"] =  addslashes( $_REQUEST["editData_business_district"]); 
				$data["table_count"] =  addslashes( $_REQUEST["editData_table_count"]); 
				$data["available"] =  addslashes( $_REQUEST["editData_available"]); 




            $su = $storeBiModel->data($data)->save();

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

        	$storeBiModel = D("StoreBi");
        $editData = $storeBiModel->getById($params);
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
         $idName = "tablename."."store_bi" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$storeBiModel = D("StoreBi");
        $sc = $storeBiModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("StoreBi/index");



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

				$store_biModel = D ( "StoreBi" );
				$tmpArr = $store_biModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "store_bi" . "." . $field;
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

							$store_biModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $store_biModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../StoreBi'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."store_bi" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$storeBiModel = D("StoreBi");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["store_id"] =  addslashes( $_REQUEST["editData_store_id"]); 
				$data["provider"] =  addslashes( $_REQUEST["editData_provider"]); 
				$data["store_code"] =  addslashes( $_REQUEST["editData_store_code"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["alias_store_names"] =  addslashes( $_REQUEST["editData_alias_store_names"]); 
				$data["province"] =  addslashes( $_REQUEST["editData_province"]); 
				$data["city"] =  addslashes( $_REQUEST["editData_city"]); 
				$data["country"] =  addslashes( $_REQUEST["editData_country"]); 
				$data["address"] =  addslashes( $_REQUEST["editData_address"]); 
				$data["phone"] =  addslashes( $_REQUEST["editData_phone"]); 
				$data["longitude"] =  addslashes( $_REQUEST["editData_longitude"]); 
				$data["latitude"] =  addslashes( $_REQUEST["editData_latitude"]); 
				$data["square"] =  addslashes( $_REQUEST["editData_square"]); 
				$data["rent"] =  addslashes( $_REQUEST["editData_rent"]); 
				$data["employees"] =  addslashes( $_REQUEST["editData_employees"]); 
				$data["onboard_date"] =  addslashes( $_REQUEST["editData_onboard_date"]); 
				$data["shutdown_date"] =  addslashes( $_REQUEST["editData_shutdown_date"]); 
				$data["store_type"] =  addslashes( $_REQUEST["editData_store_type"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 
				$data["deleted"] =  addslashes( $_REQUEST["editData_deleted"]); 
				$data["update_time"] =  addslashes( $_REQUEST["editData_update_time"]); 
				$data["update_time_business"] =  addslashes( $_REQUEST["editData_update_time_business"]); 
				$data["business_district"] =  addslashes( $_REQUEST["editData_business_district"]); 
				$data["table_count"] =  addslashes( $_REQUEST["editData_table_count"]); 
				$data["available"] =  addslashes( $_REQUEST["editData_available"]); 


	 		 $data["id"]="";


            $su = $storeBiModel->data($data)->add();

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

        	$storeBiModel = D("StoreBi");
        $editData = $storeBiModel->getById($params);
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