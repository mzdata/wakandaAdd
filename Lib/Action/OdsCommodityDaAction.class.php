<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$odsCommodityDaModel = D("OdsCommodityDa"); //BASECIDE0
// |OdsCommodityDa\/queryOneMyData$
// |OdsCommodityDa\/delMyData$
// |OdsCommodityDa\/addMyData$
// |OdsCommodityDa\/updateMyData$
// |OdsCommodityDa\/queryList$
/*
  tenantCode  租户code 
  commodityId  商品id 
  provider  服务商 
  commodityCode  商品编码 
  commodityName  商品名称 
  commodityBarcode  商品条码 
  unit  单位 
  sellPrice  售价 
  cost  成本 
  aliasGoodsNames  商品别名 
  brandId  品牌id 
  brandCode  品牌code 
  brandName  品牌名 
  status  商品状态 
  isCombo  是否为套餐 
  commodityCategoryId1  商品一级分类id 
  commodityCategoryCode1  商品一级分类code 
  commodityCategoryName1  商品一级分类名称 
  commodityCategoryId2  商品二级分类id 
  commodityCategoryCode2  商品二级分类code 
  commodityCategoryName2  商品二级分类名称 
  commodityCategoryId3  商品三级分类id 
  commodityCategoryCode3  商品三级分类code 
  commodityCategoryName3  商品三级分类名称 
  commodityCategoryId4  商品四级分类id 
  commodityCategoryCode4  商品四级分类code 
  commodityCategoryName4  商品四级分类名称 
  dt  dt */

class OdsCommodityDaAction extends  Action {
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

	//OdsCommodityDa\/getActionTableName$
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

			
			

					   	$odsCommodityDaModel = D("OdsCommodityDa");
				$editData = $odsCommodityDaModel->getById($id);




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

					   	$odsCommodityDaModel = D("OdsCommodityDa");
					$sc = 	$odsCommodityDaModel->where("id='$id'")->delete();

				
					

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

					   	$odsCommodityDaModel = D("OdsCommodityDa");
				 $data = array();

							if(isset($jsonArr["tenantCode"]))		$data["tenant_code"] =    $this->addslashesx($jsonArr["tenantCode"]); 
		if(isset($jsonArr["commodityId"]))		$data["commodity_id"] =    $this->addslashesx($jsonArr["commodityId"]); 
		if(isset($jsonArr["provider"]))		$data["provider"] =    $this->addslashesx($jsonArr["provider"]); 
		if(isset($jsonArr["commodityCode"]))		$data["commodity_code"] =    $this->addslashesx($jsonArr["commodityCode"]); 
		if(isset($jsonArr["commodityName"]))		$data["commodity_name"] =    $this->addslashesx($jsonArr["commodityName"]); 
		if(isset($jsonArr["commodityBarcode"]))		$data["commodity_barcode"] =    $this->addslashesx($jsonArr["commodityBarcode"]); 
		if(isset($jsonArr["unit"]))		$data["unit"] =    $this->addslashesx($jsonArr["unit"]); 
		if(isset($jsonArr["sellPrice"]))		$data["sell_price"] =    $this->addslashesx($jsonArr["sellPrice"]); 
		if(isset($jsonArr["cost"]))		$data["cost"] =    $this->addslashesx($jsonArr["cost"]); 
		if(isset($jsonArr["aliasGoodsNames"]))		$data["alias_goods_names"] =    $this->addslashesx($jsonArr["aliasGoodsNames"]); 
		if(isset($jsonArr["brandId"]))		$data["brand_id"] =    $this->addslashesx($jsonArr["brandId"]); 
		if(isset($jsonArr["brandCode"]))		$data["brand_code"] =    $this->addslashesx($jsonArr["brandCode"]); 
		if(isset($jsonArr["brandName"]))		$data["brand_name"] =    $this->addslashesx($jsonArr["brandName"]); 
		if(isset($jsonArr["status"]))		$data["status"] =    $this->addslashesx($jsonArr["status"]); 
		if(isset($jsonArr["isCombo"]))		$data["is_combo"] =    $this->addslashesx($jsonArr["isCombo"]); 
		if(isset($jsonArr["commodityCategoryId1"]))		$data["commodity_category_id_1"] =    $this->addslashesx($jsonArr["commodityCategoryId1"]); 
		if(isset($jsonArr["commodityCategoryCode1"]))		$data["commodity_category_code_1"] =    $this->addslashesx($jsonArr["commodityCategoryCode1"]); 
		if(isset($jsonArr["commodityCategoryName1"]))		$data["commodity_category_name_1"] =    $this->addslashesx($jsonArr["commodityCategoryName1"]); 
		if(isset($jsonArr["commodityCategoryId2"]))		$data["commodity_category_id_2"] =    $this->addslashesx($jsonArr["commodityCategoryId2"]); 
		if(isset($jsonArr["commodityCategoryCode2"]))		$data["commodity_category_code_2"] =    $this->addslashesx($jsonArr["commodityCategoryCode2"]); 
		if(isset($jsonArr["commodityCategoryName2"]))		$data["commodity_category_name_2"] =    $this->addslashesx($jsonArr["commodityCategoryName2"]); 
		if(isset($jsonArr["commodityCategoryId3"]))		$data["commodity_category_id_3"] =    $this->addslashesx($jsonArr["commodityCategoryId3"]); 
		if(isset($jsonArr["commodityCategoryCode3"]))		$data["commodity_category_code_3"] =    $this->addslashesx($jsonArr["commodityCategoryCode3"]); 
		if(isset($jsonArr["commodityCategoryName3"]))		$data["commodity_category_name_3"] =    $this->addslashesx($jsonArr["commodityCategoryName3"]); 
		if(isset($jsonArr["commodityCategoryId4"]))		$data["commodity_category_id_4"] =    $this->addslashesx($jsonArr["commodityCategoryId4"]); 
		if(isset($jsonArr["commodityCategoryCode4"]))		$data["commodity_category_code_4"] =    $this->addslashesx($jsonArr["commodityCategoryCode4"]); 
		if(isset($jsonArr["commodityCategoryName4"]))		$data["commodity_category_name_4"] =    $this->addslashesx($jsonArr["commodityCategoryName4"]); 
		if(isset($jsonArr["dt"]))		$data["dt"] =    $this->addslashesx($jsonArr["dt"]); 

            $su = $odsCommodityDaModel->data($data)->save();

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

					   	$odsCommodityDaModel = D("OdsCommodityDa");

 				$data = array();


									$data["tenant_code"] = $this->addslashesx(  $jsonArr["TenantCode"]); 
				$data["commodity_id"] = $this->addslashesx(  $jsonArr["CommodityId"]); 
				$data["provider"] = $this->addslashesx(  $jsonArr["Provider"]); 
				$data["commodity_code"] = $this->addslashesx(  $jsonArr["CommodityCode"]); 
				$data["commodity_name"] = $this->addslashesx(  $jsonArr["CommodityName"]); 
				$data["commodity_barcode"] = $this->addslashesx(  $jsonArr["CommodityBarcode"]); 
				$data["unit"] = $this->addslashesx(  $jsonArr["Unit"]); 
				$data["sell_price"] = $this->addslashesx(  $jsonArr["SellPrice"]); 
				$data["cost"] = $this->addslashesx(  $jsonArr["Cost"]); 
				$data["alias_goods_names"] = $this->addslashesx(  $jsonArr["AliasGoodsNames"]); 
				$data["brand_id"] = $this->addslashesx(  $jsonArr["BrandId"]); 
				$data["brand_code"] = $this->addslashesx(  $jsonArr["BrandCode"]); 
				$data["brand_name"] = $this->addslashesx(  $jsonArr["BrandName"]); 
				$data["status"] = $this->addslashesx(  $jsonArr["Status"]); 
				$data["is_combo"] = $this->addslashesx(  $jsonArr["IsCombo"]); 
				$data["commodity_category_id_1"] = $this->addslashesx(  $jsonArr["CommodityCategoryId1"]); 
				$data["commodity_category_code_1"] = $this->addslashesx(  $jsonArr["CommodityCategoryCode1"]); 
				$data["commodity_category_name_1"] = $this->addslashesx(  $jsonArr["CommodityCategoryName1"]); 
				$data["commodity_category_id_2"] = $this->addslashesx(  $jsonArr["CommodityCategoryId2"]); 
				$data["commodity_category_code_2"] = $this->addslashesx(  $jsonArr["CommodityCategoryCode2"]); 
				$data["commodity_category_name_2"] = $this->addslashesx(  $jsonArr["CommodityCategoryName2"]); 
				$data["commodity_category_id_3"] = $this->addslashesx(  $jsonArr["CommodityCategoryId3"]); 
				$data["commodity_category_code_3"] = $this->addslashesx(  $jsonArr["CommodityCategoryCode3"]); 
				$data["commodity_category_name_3"] = $this->addslashesx(  $jsonArr["CommodityCategoryName3"]); 
				$data["commodity_category_id_4"] = $this->addslashesx(  $jsonArr["CommodityCategoryId4"]); 
				$data["commodity_category_code_4"] = $this->addslashesx(  $jsonArr["CommodityCategoryCode4"]); 
				$data["commodity_category_name_4"] = $this->addslashesx(  $jsonArr["CommodityCategoryName4"]); 
				$data["dt"] = $this->addslashesx(  $jsonArr["Dt"]); 



				$su =  $odsCommodityDaModel->data($data)->add();

	
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
		
		

      

		$odsCommodityDaModel = D("OdsCommodityDa");
 

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or commodity_id like '%$searchkey%' or provider like '%$searchkey%' or commodity_code like '%$searchkey%' or commodity_name like '%$searchkey%' or commodity_barcode like '%$searchkey%' or unit like '%$searchkey%' or sell_price like '%$searchkey%' or cost like '%$searchkey%' or alias_goods_names like '%$searchkey%' or brand_id like '%$searchkey%' or brand_code like '%$searchkey%' or brand_name like '%$searchkey%' or status like '%$searchkey%' or is_combo like '%$searchkey%' or commodity_category_id_1 like '%$searchkey%' or commodity_category_code_1 like '%$searchkey%' or commodity_category_name_1 like '%$searchkey%' or commodity_category_id_2 like '%$searchkey%' or commodity_category_code_2 like '%$searchkey%' or commodity_category_name_2 like '%$searchkey%' or commodity_category_id_3 like '%$searchkey%' or commodity_category_code_3 like '%$searchkey%' or commodity_category_name_3 like '%$searchkey%' or commodity_category_id_4 like '%$searchkey%' or commodity_category_code_4 like '%$searchkey%' or commodity_category_name_4 like '%$searchkey%' or dt like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $odsCommodityDaModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $odsCommodityDaModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."ods_commodity_da" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$odsCommodityDaModel = D("OdsCommodityDa");
    	$tmpArr = $odsCommodityDaModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "ods_commodity_da".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or tenant_code like '%$searchkey%' or commodity_id like '%$searchkey%' or provider like '%$searchkey%' or commodity_code like '%$searchkey%' or commodity_name like '%$searchkey%' or commodity_barcode like '%$searchkey%' or unit like '%$searchkey%' or sell_price like '%$searchkey%' or cost like '%$searchkey%' or alias_goods_names like '%$searchkey%' or brand_id like '%$searchkey%' or brand_code like '%$searchkey%' or brand_name like '%$searchkey%' or status like '%$searchkey%' or is_combo like '%$searchkey%' or commodity_category_id_1 like '%$searchkey%' or commodity_category_code_1 like '%$searchkey%' or commodity_category_name_1 like '%$searchkey%' or commodity_category_id_2 like '%$searchkey%' or commodity_category_code_2 like '%$searchkey%' or commodity_category_name_2 like '%$searchkey%' or commodity_category_id_3 like '%$searchkey%' or commodity_category_code_3 like '%$searchkey%' or commodity_category_name_3 like '%$searchkey%' or commodity_category_id_4 like '%$searchkey%' or commodity_category_code_4 like '%$searchkey%' or commodity_category_name_4 like '%$searchkey%' or dt like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"ods_commodity_da",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $odsCommodityDaModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $odsCommodityDaModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $odsCommodityDaModel->getDbFields()  ;
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
       $idName = "tablename."."ods_commodity_da" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$odsCommodityDaModel = D("OdsCommodityDa");
				$data = array();


				$data["tenant_code"] = addslashes(  $_REQUEST["addData_tenant_code"] ); 
				$data["commodity_id"] = addslashes(  $_REQUEST["addData_commodity_id"] ); 
				$data["provider"] = addslashes(  $_REQUEST["addData_provider"] ); 
				$data["commodity_code"] = addslashes(  $_REQUEST["addData_commodity_code"] ); 
				$data["commodity_name"] = addslashes(  $_REQUEST["addData_commodity_name"] ); 
				$data["commodity_barcode"] = addslashes(  $_REQUEST["addData_commodity_barcode"] ); 
				$data["unit"] = addslashes(  $_REQUEST["addData_unit"] ); 
				$data["sell_price"] = addslashes(  $_REQUEST["addData_sell_price"] ); 
				$data["cost"] = addslashes(  $_REQUEST["addData_cost"] ); 
				$data["alias_goods_names"] = addslashes(  $_REQUEST["addData_alias_goods_names"] ); 
				$data["brand_id"] = addslashes(  $_REQUEST["addData_brand_id"] ); 
				$data["brand_code"] = addslashes(  $_REQUEST["addData_brand_code"] ); 
				$data["brand_name"] = addslashes(  $_REQUEST["addData_brand_name"] ); 
				$data["status"] = addslashes(  $_REQUEST["addData_status"] ); 
				$data["is_combo"] = addslashes(  $_REQUEST["addData_is_combo"] ); 
				$data["commodity_category_id_1"] = addslashes(  $_REQUEST["addData_commodity_category_id_1"] ); 
				$data["commodity_category_code_1"] = addslashes(  $_REQUEST["addData_commodity_category_code_1"] ); 
				$data["commodity_category_name_1"] = addslashes(  $_REQUEST["addData_commodity_category_name_1"] ); 
				$data["commodity_category_id_2"] = addslashes(  $_REQUEST["addData_commodity_category_id_2"] ); 
				$data["commodity_category_code_2"] = addslashes(  $_REQUEST["addData_commodity_category_code_2"] ); 
				$data["commodity_category_name_2"] = addslashes(  $_REQUEST["addData_commodity_category_name_2"] ); 
				$data["commodity_category_id_3"] = addslashes(  $_REQUEST["addData_commodity_category_id_3"] ); 
				$data["commodity_category_code_3"] = addslashes(  $_REQUEST["addData_commodity_category_code_3"] ); 
				$data["commodity_category_name_3"] = addslashes(  $_REQUEST["addData_commodity_category_name_3"] ); 
				$data["commodity_category_id_4"] = addslashes(  $_REQUEST["addData_commodity_category_id_4"] ); 
				$data["commodity_category_code_4"] = addslashes(  $_REQUEST["addData_commodity_category_code_4"] ); 
				$data["commodity_category_name_4"] = addslashes(  $_REQUEST["addData_commodity_category_name_4"] ); 
				$data["dt"] = addslashes(  $_REQUEST["addData_dt"] ); 



				$su =  $odsCommodityDaModel->data($data)->add();

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
       $idName = "tablename."."ods_commodity_da" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$odsCommodityDaModel = D("OdsCommodityDa");
            $data = array();
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["provider"] =  addslashes( $_REQUEST["editData_provider"]); 
				$data["commodity_code"] =  addslashes( $_REQUEST["editData_commodity_code"]); 
				$data["commodity_name"] =  addslashes( $_REQUEST["editData_commodity_name"]); 
				$data["commodity_barcode"] =  addslashes( $_REQUEST["editData_commodity_barcode"]); 
				$data["unit"] =  addslashes( $_REQUEST["editData_unit"]); 
				$data["sell_price"] =  addslashes( $_REQUEST["editData_sell_price"]); 
				$data["cost"] =  addslashes( $_REQUEST["editData_cost"]); 
				$data["alias_goods_names"] =  addslashes( $_REQUEST["editData_alias_goods_names"]); 
				$data["brand_id"] =  addslashes( $_REQUEST["editData_brand_id"]); 
				$data["brand_code"] =  addslashes( $_REQUEST["editData_brand_code"]); 
				$data["brand_name"] =  addslashes( $_REQUEST["editData_brand_name"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["is_combo"] =  addslashes( $_REQUEST["editData_is_combo"]); 
				$data["commodity_category_id_1"] =  addslashes( $_REQUEST["editData_commodity_category_id_1"]); 
				$data["commodity_category_code_1"] =  addslashes( $_REQUEST["editData_commodity_category_code_1"]); 
				$data["commodity_category_name_1"] =  addslashes( $_REQUEST["editData_commodity_category_name_1"]); 
				$data["commodity_category_id_2"] =  addslashes( $_REQUEST["editData_commodity_category_id_2"]); 
				$data["commodity_category_code_2"] =  addslashes( $_REQUEST["editData_commodity_category_code_2"]); 
				$data["commodity_category_name_2"] =  addslashes( $_REQUEST["editData_commodity_category_name_2"]); 
				$data["commodity_category_id_3"] =  addslashes( $_REQUEST["editData_commodity_category_id_3"]); 
				$data["commodity_category_code_3"] =  addslashes( $_REQUEST["editData_commodity_category_code_3"]); 
				$data["commodity_category_name_3"] =  addslashes( $_REQUEST["editData_commodity_category_name_3"]); 
				$data["commodity_category_id_4"] =  addslashes( $_REQUEST["editData_commodity_category_id_4"]); 
				$data["commodity_category_code_4"] =  addslashes( $_REQUEST["editData_commodity_category_code_4"]); 
				$data["commodity_category_name_4"] =  addslashes( $_REQUEST["editData_commodity_category_name_4"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 




            $su = $odsCommodityDaModel->data($data)->save();

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

        	$odsCommodityDaModel = D("OdsCommodityDa");
        $editData = $odsCommodityDaModel->getById($params);
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
         $idName = "tablename."."ods_commodity_da" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$odsCommodityDaModel = D("OdsCommodityDa");
        $sc = $odsCommodityDaModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("OdsCommodityDa/index");



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

				$ods_commodity_daModel = D ( "OdsCommodityDa" );
				$tmpArr = $ods_commodity_daModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "ods_commodity_da" . "." . $field;
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

							$ods_commodity_daModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $ods_commodity_daModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../OdsCommodityDa'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."ods_commodity_da" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$odsCommodityDaModel = D("OdsCommodityDa");
            $data = array();
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["provider"] =  addslashes( $_REQUEST["editData_provider"]); 
				$data["commodity_code"] =  addslashes( $_REQUEST["editData_commodity_code"]); 
				$data["commodity_name"] =  addslashes( $_REQUEST["editData_commodity_name"]); 
				$data["commodity_barcode"] =  addslashes( $_REQUEST["editData_commodity_barcode"]); 
				$data["unit"] =  addslashes( $_REQUEST["editData_unit"]); 
				$data["sell_price"] =  addslashes( $_REQUEST["editData_sell_price"]); 
				$data["cost"] =  addslashes( $_REQUEST["editData_cost"]); 
				$data["alias_goods_names"] =  addslashes( $_REQUEST["editData_alias_goods_names"]); 
				$data["brand_id"] =  addslashes( $_REQUEST["editData_brand_id"]); 
				$data["brand_code"] =  addslashes( $_REQUEST["editData_brand_code"]); 
				$data["brand_name"] =  addslashes( $_REQUEST["editData_brand_name"]); 
				$data["status"] =  addslashes( $_REQUEST["editData_status"]); 
				$data["is_combo"] =  addslashes( $_REQUEST["editData_is_combo"]); 
				$data["commodity_category_id_1"] =  addslashes( $_REQUEST["editData_commodity_category_id_1"]); 
				$data["commodity_category_code_1"] =  addslashes( $_REQUEST["editData_commodity_category_code_1"]); 
				$data["commodity_category_name_1"] =  addslashes( $_REQUEST["editData_commodity_category_name_1"]); 
				$data["commodity_category_id_2"] =  addslashes( $_REQUEST["editData_commodity_category_id_2"]); 
				$data["commodity_category_code_2"] =  addslashes( $_REQUEST["editData_commodity_category_code_2"]); 
				$data["commodity_category_name_2"] =  addslashes( $_REQUEST["editData_commodity_category_name_2"]); 
				$data["commodity_category_id_3"] =  addslashes( $_REQUEST["editData_commodity_category_id_3"]); 
				$data["commodity_category_code_3"] =  addslashes( $_REQUEST["editData_commodity_category_code_3"]); 
				$data["commodity_category_name_3"] =  addslashes( $_REQUEST["editData_commodity_category_name_3"]); 
				$data["commodity_category_id_4"] =  addslashes( $_REQUEST["editData_commodity_category_id_4"]); 
				$data["commodity_category_code_4"] =  addslashes( $_REQUEST["editData_commodity_category_code_4"]); 
				$data["commodity_category_name_4"] =  addslashes( $_REQUEST["editData_commodity_category_name_4"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 


	 		 $data["id"]="";


            $su = $odsCommodityDaModel->data($data)->add();

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

        	$odsCommodityDaModel = D("OdsCommodityDa");
        $editData = $odsCommodityDaModel->getById($params);
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