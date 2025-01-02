<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic"); //BASECIDE0
// |SqoopIllegalProcurementBasic\/queryOneMyData$
// |SqoopIllegalProcurementBasic\/delMyData$
// |SqoopIllegalProcurementBasic\/addMyData$
// |SqoopIllegalProcurementBasic\/updateMyData$
// |SqoopIllegalProcurementBasic\/queryList$
/*
  id  id 
  tenantCode  租户code 
  material  原材料 
  tenantType  类型 
  warehouseName  仓库 
  subCompany  分公司 
  agent  代理 
  storeId  id 
  storeName  门店名称 
  ydbId  鱼店宝授权码 
  province  省份 
  city  城市 
  county  区域 
  yl  理论用量 
  dt  时间 
  updatedTime  更新时间 */

class SqoopIllegalProcurementBasicAction extends  Action {
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

	//SqoopIllegalProcurementBasic\/getActionTableName$
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

			
			

					   	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
				$editData = $sqoopIllegalProcurementBasicModel->getById($id);




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

					   	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
					$sc = 	$sqoopIllegalProcurementBasicModel->where("id='$id'")->delete();

				
					

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

					   	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["tenantCode"]))		$data["tenant_code"] =    $this->addslashesx($jsonArr["tenantCode"]); 
		if(isset($jsonArr["material"]))		$data["material"] =    $this->addslashesx($jsonArr["material"]); 
		if(isset($jsonArr["tenantType"]))		$data["tenant_type"] =    $this->addslashesx($jsonArr["tenantType"]); 
		if(isset($jsonArr["warehouseName"]))		$data["warehouse_name"] =    $this->addslashesx($jsonArr["warehouseName"]); 
		if(isset($jsonArr["subCompany"]))		$data["sub_company"] =    $this->addslashesx($jsonArr["subCompany"]); 
		if(isset($jsonArr["agent"]))		$data["agent"] =    $this->addslashesx($jsonArr["agent"]); 
		if(isset($jsonArr["storeId"]))		$data["store_id"] =    $this->addslashesx($jsonArr["storeId"]); 
		if(isset($jsonArr["storeName"]))		$data["store_name"] =    $this->addslashesx($jsonArr["storeName"]); 
		if(isset($jsonArr["ydbId"]))		$data["ydb_id"] =    $this->addslashesx($jsonArr["ydbId"]); 
		if(isset($jsonArr["province"]))		$data["province"] =    $this->addslashesx($jsonArr["province"]); 
		if(isset($jsonArr["city"]))		$data["city"] =    $this->addslashesx($jsonArr["city"]); 
		if(isset($jsonArr["county"]))		$data["county"] =    $this->addslashesx($jsonArr["county"]); 
		if(isset($jsonArr["yl"]))		$data["yl"] =    $this->addslashesx($jsonArr["yl"]); 
		if(isset($jsonArr["dt"]))		$data["dt"] =    $this->addslashesx($jsonArr["dt"]); 
		if(isset($jsonArr["updatedTime"]))		$data["updated_time"] =    $this->addslashesx($jsonArr["updatedTime"]); 

            $su = $sqoopIllegalProcurementBasicModel->data($data)->save();

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

					   	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");

 				$data = array();


									$data["tenant_code"] = $this->addslashesx(  $jsonArr["TenantCode"]); 
				$data["material"] = $this->addslashesx(  $jsonArr["Material"]); 
				$data["tenant_type"] = $this->addslashesx(  $jsonArr["TenantType"]); 
				$data["warehouse_name"] = $this->addslashesx(  $jsonArr["WarehouseName"]); 
				$data["sub_company"] = $this->addslashesx(  $jsonArr["SubCompany"]); 
				$data["agent"] = $this->addslashesx(  $jsonArr["Agent"]); 
				$data["store_id"] = $this->addslashesx(  $jsonArr["StoreId"]); 
				$data["store_name"] = $this->addslashesx(  $jsonArr["StoreName"]); 
				$data["ydb_id"] = $this->addslashesx(  $jsonArr["YdbId"]); 
				$data["province"] = $this->addslashesx(  $jsonArr["Province"]); 
				$data["city"] = $this->addslashesx(  $jsonArr["City"]); 
				$data["county"] = $this->addslashesx(  $jsonArr["County"]); 
				$data["yl"] = $this->addslashesx(  $jsonArr["Yl"]); 
				$data["dt"] = $this->addslashesx(  $jsonArr["Dt"]); 
				$data["updated_time"] = $this->addslashesx(  $jsonArr["UpdatedTime"]); 



				$su =  $sqoopIllegalProcurementBasicModel->data($data)->add();

	
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
		
		

      

		$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
 

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or material like '%$searchkey%' or tenant_type like '%$searchkey%' or warehouse_name like '%$searchkey%' or sub_company like '%$searchkey%' or agent like '%$searchkey%' or store_id like '%$searchkey%' or store_name like '%$searchkey%' or ydb_id like '%$searchkey%' or province like '%$searchkey%' or city like '%$searchkey%' or county like '%$searchkey%' or yl like '%$searchkey%' or dt like '%$searchkey%' or updated_time like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $sqoopIllegalProcurementBasicModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $sqoopIllegalProcurementBasicModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."sqoop_illegal_procurement_basic" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
    	$tmpArr = $sqoopIllegalProcurementBasicModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "sqoop_illegal_procurement_basic".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or material like '%$searchkey%' or tenant_type like '%$searchkey%' or warehouse_name like '%$searchkey%' or sub_company like '%$searchkey%' or agent like '%$searchkey%' or store_id like '%$searchkey%' or store_name like '%$searchkey%' or ydb_id like '%$searchkey%' or province like '%$searchkey%' or city like '%$searchkey%' or county like '%$searchkey%' or yl like '%$searchkey%' or dt like '%$searchkey%' or updated_time like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"sqoop_illegal_procurement_basic",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $sqoopIllegalProcurementBasicModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $sqoopIllegalProcurementBasicModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $sqoopIllegalProcurementBasicModel->getDbFields()  ;
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
       $idName = "tablename."."sqoop_illegal_procurement_basic" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
				$data = array();


				$data["tenant_code"] = addslashes(  $_REQUEST["addData_tenant_code"] ); 
				$data["material"] = addslashes(  $_REQUEST["addData_material"] ); 
				$data["tenant_type"] = addslashes(  $_REQUEST["addData_tenant_type"] ); 
				$data["warehouse_name"] = addslashes(  $_REQUEST["addData_warehouse_name"] ); 
				$data["sub_company"] = addslashes(  $_REQUEST["addData_sub_company"] ); 
				$data["agent"] = addslashes(  $_REQUEST["addData_agent"] ); 
				$data["store_id"] = addslashes(  $_REQUEST["addData_store_id"] ); 
				$data["store_name"] = addslashes(  $_REQUEST["addData_store_name"] ); 
				$data["ydb_id"] = addslashes(  $_REQUEST["addData_ydb_id"] ); 
				$data["province"] = addslashes(  $_REQUEST["addData_province"] ); 
				$data["city"] = addslashes(  $_REQUEST["addData_city"] ); 
				$data["county"] = addslashes(  $_REQUEST["addData_county"] ); 
				$data["yl"] = addslashes(  $_REQUEST["addData_yl"] ); 
				$data["dt"] = addslashes(  $_REQUEST["addData_dt"] ); 
				$data["updated_time"] = addslashes(  $_REQUEST["addData_updated_time"] ); 



				$su =  $sqoopIllegalProcurementBasicModel->data($data)->add();

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
       $idName = "tablename."."sqoop_illegal_procurement_basic" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["material"] =  addslashes( $_REQUEST["editData_material"]); 
				$data["tenant_type"] =  addslashes( $_REQUEST["editData_tenant_type"]); 
				$data["warehouse_name"] =  addslashes( $_REQUEST["editData_warehouse_name"]); 
				$data["sub_company"] =  addslashes( $_REQUEST["editData_sub_company"]); 
				$data["agent"] =  addslashes( $_REQUEST["editData_agent"]); 
				$data["store_id"] =  addslashes( $_REQUEST["editData_store_id"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["ydb_id"] =  addslashes( $_REQUEST["editData_ydb_id"]); 
				$data["province"] =  addslashes( $_REQUEST["editData_province"]); 
				$data["city"] =  addslashes( $_REQUEST["editData_city"]); 
				$data["county"] =  addslashes( $_REQUEST["editData_county"]); 
				$data["yl"] =  addslashes( $_REQUEST["editData_yl"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 
				$data["updated_time"] =  addslashes( $_REQUEST["editData_updated_time"]); 




            $su = $sqoopIllegalProcurementBasicModel->data($data)->save();

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

        	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
        $editData = $sqoopIllegalProcurementBasicModel->getById($params);
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
         $idName = "tablename."."sqoop_illegal_procurement_basic" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
        $sc = $sqoopIllegalProcurementBasicModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("SqoopIllegalProcurementBasic/index");



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

				$sqoop_illegal_procurement_basicModel = D ( "SqoopIllegalProcurementBasic" );
				$tmpArr = $sqoop_illegal_procurement_basicModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "sqoop_illegal_procurement_basic" . "." . $field;
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

							$sqoop_illegal_procurement_basicModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $sqoop_illegal_procurement_basicModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../SqoopIllegalProcurementBasic'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."sqoop_illegal_procurement_basic" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["material"] =  addslashes( $_REQUEST["editData_material"]); 
				$data["tenant_type"] =  addslashes( $_REQUEST["editData_tenant_type"]); 
				$data["warehouse_name"] =  addslashes( $_REQUEST["editData_warehouse_name"]); 
				$data["sub_company"] =  addslashes( $_REQUEST["editData_sub_company"]); 
				$data["agent"] =  addslashes( $_REQUEST["editData_agent"]); 
				$data["store_id"] =  addslashes( $_REQUEST["editData_store_id"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["ydb_id"] =  addslashes( $_REQUEST["editData_ydb_id"]); 
				$data["province"] =  addslashes( $_REQUEST["editData_province"]); 
				$data["city"] =  addslashes( $_REQUEST["editData_city"]); 
				$data["county"] =  addslashes( $_REQUEST["editData_county"]); 
				$data["yl"] =  addslashes( $_REQUEST["editData_yl"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 
				$data["updated_time"] =  addslashes( $_REQUEST["editData_updated_time"]); 


	 		 $data["id"]="";


            $su = $sqoopIllegalProcurementBasicModel->data($data)->add();

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

        	$sqoopIllegalProcurementBasicModel = D("SqoopIllegalProcurementBasic");
        $editData = $sqoopIllegalProcurementBasicModel->getById($params);
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