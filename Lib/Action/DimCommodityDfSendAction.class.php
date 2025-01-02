<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$dimCommodityDfSendModel = D("DimCommodityDfSend"); //BASECIDE0
// |DimCommodityDfSend\/queryOneMyData$
// |DimCommodityDfSend\/delMyData$
// |DimCommodityDfSend\/addMyData$
// |DimCommodityDfSend\/updateMyData$
// |DimCommodityDfSend\/queryList$
/*
  id  id 
  tenantCode  租户编码 
  commodityId  商品id 
  provider  服务商 
  commodityProvider  商品供应商 
  commodityCode  商品编码 
  commodityName  商品名称 
  commodityBarcode  商品条码 
  unit  单位 
  sellPrice  售价 
  cost  成本 
  aliasCommodityName  商品别名 
  status  商品状态 
  categoryIdLv1  一级品类id 
  categoryCodeLv1  一级品类code 
  categoryNameLv1  一级品类名称 
  categoryId  品类id 
  categoryCode  品类code 
  categoryName  品类名称 
  isCombo  是否是套餐 
  specs  规格 
  etlTime  数仓处理时间 
  commodityCnt30day  近30天内销量 */

class DimCommodityDfSendAction extends  Action {
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

	//DimCommodityDfSend\/getActionTableName$
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

			
			

					   	$dimCommodityDfSendModel = D("DimCommodityDfSend");
				$editData = $dimCommodityDfSendModel->getById($id);




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

					   	$dimCommodityDfSendModel = D("DimCommodityDfSend");
					$sc = 	$dimCommodityDfSendModel->where("id='$id'")->delete();

				
					

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

					   	$dimCommodityDfSendModel = D("DimCommodityDfSend");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["tenantCode"]))		$data["tenant_code"] =    $this->addslashesx($jsonArr["tenantCode"]); 
		if(isset($jsonArr["commodityId"]))		$data["commodity_id"] =    $this->addslashesx($jsonArr["commodityId"]); 
		if(isset($jsonArr["provider"]))		$data["provider"] =    $this->addslashesx($jsonArr["provider"]); 
		if(isset($jsonArr["commodityProvider"]))		$data["commodity_provider"] =    $this->addslashesx($jsonArr["commodityProvider"]); 
		if(isset($jsonArr["commodityCode"]))		$data["commodity_code"] =    $this->addslashesx($jsonArr["commodityCode"]); 
		if(isset($jsonArr["commodityName"]))		$data["commodity_name"] =    $this->addslashesx($jsonArr["commodityName"]); 
		if(isset($jsonArr["commodityBarcode"]))		$data["commodity_barcode"] =    $this->addslashesx($jsonArr["commodityBarcode"]); 
		if(isset($jsonArr["unit"]))		$data["unit"] =    $this->addslashesx($jsonArr["unit"]); 
		if(isset($jsonArr["sellPrice"]))		$data["sell_price"] =    $this->addslashesx($jsonArr["sellPrice"]); 
		if(isset($jsonArr["cost"]))		$data["cost"] =    $this->addslashesx($jsonArr["cost"]); 
		if(isset($jsonArr["aliasCommodityName"]))		$data["alias_commodity_name"] =    $this->addslashesx($jsonArr["aliasCommodityName"]); 
		if(isset($jsonArr["status"]))		$data["status"] =    $this->addslashesx($jsonArr["status"]); 
		if(isset($jsonArr["categoryIdLv1"]))		$data["category_id_lv1"] =    $this->addslashesx($jsonArr["categoryIdLv1"]); 
		if(isset($jsonArr["categoryCodeLv1"]))		$data["category_code_lv1"] =    $this->addslashesx($jsonArr["categoryCodeLv1"]); 
		if(isset($jsonArr["categoryNameLv1"]))		$data["category_name_lv1"] =    $this->addslashesx($jsonArr["categoryNameLv1"]); 
		if(isset($jsonArr["categoryId"]))		$data["category_id"] =    $this->addslashesx($jsonArr["categoryId"]); 
		if(isset($jsonArr["categoryCode"]))		$data["category_code"] =    $this->addslashesx($jsonArr["categoryCode"]); 
		if(isset($jsonArr["categoryName"]))		$data["category_name"] =    $this->addslashesx($jsonArr["categoryName"]); 
		if(isset($jsonArr["isCombo"]))		$data["is_combo"] =    $this->addslashesx($jsonArr["isCombo"]); 
		if(isset($jsonArr["specs"]))		$data["specs"] =    $this->addslashesx($jsonArr["specs"]); 
		if(isset($jsonArr["etlTime"]))		$data["etl_time"] =    $this->addslashesx($jsonArr["etlTime"]); 
		if(isset($jsonArr["commodityCnt30day"]))		$data["commodity_cnt_30day"] =    $this->addslashesx($jsonArr["commodityCnt30day"]); 

            $su = $dimCommodityDfSendModel->data($data)->save();

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

					   	$dimCommodityDfSendModel = D("DimCommodityDfSend");

 				$data = array();


									$data["tenant_code"] = $this->addslashesx(  $jsonArr["TenantCode"]); 
				$data["commodity_id"] = $this->addslashesx(  $jsonArr["CommodityId"]); 
				$data["provider"] = $this->addslashesx(  $jsonArr["Provider"]); 
				$data["commodity_provider"] = $this->addslashesx(  $jsonArr["CommodityProvider"]); 
				$data["commodity_code"] = $this->addslashesx(  $jsonArr["CommodityCode"]); 
				$data["commodity_name"] = $this->addslashesx(  $jsonArr["CommodityName"]); 
				$data["commodity_barcode"] = $this->addslashesx(  $jsonArr["CommodityBarcode"]); 
				$data["unit"] = $this->addslashesx(  $jsonArr["Unit"]); 
				$data["sell_price"] = $this->addslashesx(  $jsonArr["SellPrice"]); 
				$data["cost"] = $this->addslashesx(  $jsonArr["Cost"]); 
				$data["alias_commodity_name"] = $this->addslashesx(  $jsonArr["AliasCommodityName"]); 
				$data["status"] = $this->addslashesx(  $jsonArr["Status"]); 
				$data["category_id_lv1"] = $this->addslashesx(  $jsonArr["CategoryIdLv1"]); 
				$data["category_code_lv1"] = $this->addslashesx(  $jsonArr["CategoryCodeLv1"]); 
				$data["category_name_lv1"] = $this->addslashesx(  $jsonArr["CategoryNameLv1"]); 
				$data["category_id"] = $this->addslashesx(  $jsonArr["CategoryId"]); 
				$data["category_code"] = $this->addslashesx(  $jsonArr["CategoryCode"]); 
				$data["category_name"] = $this->addslashesx(  $jsonArr["CategoryName"]); 
				$data["is_combo"] = $this->addslashesx(  $jsonArr["IsCombo"]); 
				$data["specs"] = $this->addslashesx(  $jsonArr["Specs"]); 
				$data["etl_time"] = $this->addslashesx(  $jsonArr["EtlTime"]); 
				$data["commodity_cnt_30day"] = $this->addslashesx(  $jsonArr["CommodityCnt30day"]); 



				$su =  $dimCommodityDfSendModel->data($data)->add();

	
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
		
		

      

		$dimCommodityDfSendModel = D("DimCommodityDfSend");
 

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or commodity_id like '%$searchkey%' or provider like '%$searchkey%' or commodity_provider like '%$searchkey%' or commodity_code like '%$searchkey%' or commodity_name like '%$searchkey%' or commodity_barcode like '%$searchkey%' or unit like '%$searchkey%' or sell_price like '%$searchkey%' or cost like '%$searchkey%' or alias_commodity_name like '%$searchkey%' or status like '%$searchkey%' or category_id_lv1 like '%$searchkey%' or category_code_lv1 like '%$searchkey%' or category_name_lv1 like '%$searchkey%' or category_id like '%$searchkey%' or category_code like '%$searchkey%' or category_name like '%$searchkey%' or is_combo like '%$searchkey%' or specs like '%$searchkey%' or etl_time like '%$searchkey%' or commodity_cnt_30day like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $dimCommodityDfSendModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $dimCommodityDfSendModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."dim_commodity_df_send" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$dimCommodityDfSendModel = D("DimCommodityDfSend");
    	$tmpArr = $dimCommodityDfSendModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "dim_commodity_df_send".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or commodity_id like '%$searchkey%' or provider like '%$searchkey%' or commodity_provider like '%$searchkey%' or commodity_code like '%$searchkey%' or commodity_name like '%$searchkey%' or commodity_barcode like '%$searchkey%' or unit like '%$searchkey%' or sell_price like '%$searchkey%' or cost like '%$searchkey%' or alias_commodity_name like '%$searchkey%' or status like '%$searchkey%' or category_id_lv1 like '%$searchkey%' or category_code_lv1 like '%$searchkey%' or category_name_lv1 like '%$searchkey%' or category_id like '%$searchkey%' or category_code like '%$searchkey%' or category_name like '%$searchkey%' or is_combo like '%$searchkey%' or specs like '%$searchkey%' or etl_time like '%$searchkey%' or commodity_cnt_30day like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"dim_commodity_df_send",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $dimCommodityDfSendModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $dimCommodityDfSendModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $dimCommodityDfSendModel->getDbFields()  ;
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
       $idName = "tablename."."dim_commodity_df_send" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$dimCommodityDfSendModel = D("DimCommodityDfSend");
				$data = array();


				$data["tenant_code"] = addslashes(  $_REQUEST["addData_tenant_code"] ); 
				$data["commodity_id"] = addslashes(  $_REQUEST["addData_commodity_id"] ); 
				$data["provider"] = addslashes(  $_REQUEST["addData_provider"] ); 
				$data["commodity_provider"] = addslashes(  $_REQUEST["addData_commodity_provider"] ); 
				$data["commodity_code"] = addslashes(  $_REQUEST["addData_commodity_code"] ); 
				$data["commodity_name"] = addslashes(  $_REQUEST["addData_commodity_name"] ); 
				$data["commodity_barcode"] = addslashes(  $_REQUEST["addData_commodity_barcode"] ); 
				$data["unit"] = addslashes(  $_REQUEST["addData_unit"] ); 
				$data["sell_price"] = addslashes(  $_REQUEST["addData_sell_price"] ); 
				$data["cost"] = addslashes(  $_REQUEST["addData_cost"] ); 
				$data["alias_commodity_name"] = addslashes(  $_REQUEST["addData_alias_commodity_name"] ); 
				$data["status"] = addslashes(  $_REQUEST["addData_status"] ); 
				$data["category_id_lv1"] = addslashes(  $_REQUEST["addData_category_id_lv1"] ); 
				$data["category_code_lv1"] = addslashes(  $_REQUEST["addData_category_code_lv1"] ); 
				$data["category_name_lv1"] = addslashes(  $_REQUEST["addData_category_name_lv1"] ); 
				$data["category_id"] = addslashes(  $_REQUEST["addData_category_id"] ); 
				$data["category_code"] = addslashes(  $_REQUEST["addData_category_code"] ); 
				$data["category_name"] = addslashes(  $_REQUEST["addData_category_name"] ); 
				$data["is_combo"] = addslashes(  $_REQUEST["addData_is_combo"] ); 
				$data["specs"] = addslashes(  $_REQUEST["addData_specs"] ); 
				$data["etl_time"] = addslashes(  $_REQUEST["addData_etl_time"] ); 
				$data["commodity_cnt_30day"] = addslashes(  $_REQUEST["addData_commodity_cnt_30day"] ); 



				$su =  $dimCommodityDfSendModel->data($data)->add();

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
       $idName = "tablename."."dim_commodity_df_send" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$dimCommodityDfSendModel = D("DimCommodityDfSend");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["provider"] =  addslashes( $_REQUEST["editData_provider"]); 
				$data["commodity_provider"] =  addslashes( $_REQUEST["editData_commodity_provider"]); 
				$data["commodity_code"] =  addslashes( $_REQUEST["editData_commodity_code"]); 
				$data["commodity_name"] =  addslashes( $_REQUEST["editData_commodity_name"]); 
				$data["commodity_barcode"] =  addslashes( $_REQUEST["editData_commodity_barcode"]); 
				$data["unit"] =  addslashes( $_REQUEST["editData_unit"]); 
				$data["sell_price"] =  addslashes( $_REQUEST["editData_sell_price"]); 
				$data["cost"] =  addslashes( $_REQUEST["editData_cost"]); 
				$data["alias_commodity_name"] =  addslashes( $_REQUEST["editData_alias_commodity_name"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["category_id_lv1"] =  addslashes( $_REQUEST["editData_category_id_lv1"]); 
				$data["category_code_lv1"] =  addslashes( $_REQUEST["editData_category_code_lv1"]); 
				$data["category_name_lv1"] =  addslashes( $_REQUEST["editData_category_name_lv1"]); 
				$data["category_id"] =  addslashes( $_REQUEST["editData_category_id"]); 
				$data["category_code"] =  addslashes( $_REQUEST["editData_category_code"]); 
				$data["category_name"] =  addslashes( $_REQUEST["editData_category_name"]); 
				$data["is_combo"] =  addslashes( $_REQUEST["editData_is_combo"]); 
				$data["specs"] =  addslashes( $_REQUEST["editData_specs"]); 
				$data["etl_time"] =  addslashes( $_REQUEST["editData_etl_time"]); 
				$data["commodity_cnt_30day"] =  addslashes( $_REQUEST["editData_commodity_cnt_30day"]); 




            $su = $dimCommodityDfSendModel->data($data)->save();

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

        	$dimCommodityDfSendModel = D("DimCommodityDfSend");
        $editData = $dimCommodityDfSendModel->getById($params);
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
         $idName = "tablename."."dim_commodity_df_send" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$dimCommodityDfSendModel = D("DimCommodityDfSend");
        $sc = $dimCommodityDfSendModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("DimCommodityDfSend/index");



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

				$dim_commodity_df_sendModel = D ( "DimCommodityDfSend" );
				$tmpArr = $dim_commodity_df_sendModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "dim_commodity_df_send" . "." . $field;
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

							$dim_commodity_df_sendModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $dim_commodity_df_sendModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../DimCommodityDfSend'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."dim_commodity_df_send" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$dimCommodityDfSendModel = D("DimCommodityDfSend");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["provider"] =  addslashes( $_REQUEST["editData_provider"]); 
				$data["commodity_provider"] =  addslashes( $_REQUEST["editData_commodity_provider"]); 
				$data["commodity_code"] =  addslashes( $_REQUEST["editData_commodity_code"]); 
				$data["commodity_name"] =  addslashes( $_REQUEST["editData_commodity_name"]); 
				$data["commodity_barcode"] =  addslashes( $_REQUEST["editData_commodity_barcode"]); 
				$data["unit"] =  addslashes( $_REQUEST["editData_unit"]); 
				$data["sell_price"] =  addslashes( $_REQUEST["editData_sell_price"]); 
				$data["cost"] =  addslashes( $_REQUEST["editData_cost"]); 
				$data["alias_commodity_name"] =  addslashes( $_REQUEST["editData_alias_commodity_name"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["category_id_lv1"] =  addslashes( $_REQUEST["editData_category_id_lv1"]); 
				$data["category_code_lv1"] =  addslashes( $_REQUEST["editData_category_code_lv1"]); 
				$data["category_name_lv1"] =  addslashes( $_REQUEST["editData_category_name_lv1"]); 
				$data["category_id"] =  addslashes( $_REQUEST["editData_category_id"]); 
				$data["category_code"] =  addslashes( $_REQUEST["editData_category_code"]); 
				$data["category_name"] =  addslashes( $_REQUEST["editData_category_name"]); 
				$data["is_combo"] =  addslashes( $_REQUEST["editData_is_combo"]); 
				$data["specs"] =  addslashes( $_REQUEST["editData_specs"]); 
				$data["etl_time"] =  addslashes( $_REQUEST["editData_etl_time"]); 
				$data["commodity_cnt_30day"] =  addslashes( $_REQUEST["editData_commodity_cnt_30day"]); 


	 		 $data["id"]="";


            $su = $dimCommodityDfSendModel->data($data)->add();

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

        	$dimCommodityDfSendModel = D("DimCommodityDfSend");
        $editData = $dimCommodityDfSendModel->getById($params);
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