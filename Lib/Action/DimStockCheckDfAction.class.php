<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$dimStockCheckDfModel = D("DimStockCheckDf"); //BASECIDE0
// |DimStockCheckDf\/queryOneMyData$
// |DimStockCheckDf\/delMyData$
// |DimStockCheckDf\/addMyData$
// |DimStockCheckDf\/updateMyData$
// |DimStockCheckDf\/queryList$
/*
  id  id 
  storeId  门店id 
  storeName  门店name 
  categoryName  品类name 
  commodityId  商品id 
  commodityName  商品name 
  currentStock  库存 
  continuousNoSaleDay  连续未售卖天数 
  commodityTag  商品标签 
  dt  日期 
  createTime  创建时间 
  updateTime  更新时间 */

class DimStockCheckDfAction extends  Action {
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

	//DimStockCheckDf\/getActionTableName$
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

			
			

					   	$dimStockCheckDfModel = D("DimStockCheckDf");
				$editData = $dimStockCheckDfModel->getById($id);




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

					   	$dimStockCheckDfModel = D("DimStockCheckDf");
					$sc = 	$dimStockCheckDfModel->where("id='$id'")->delete();

				
					

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

					   	$dimStockCheckDfModel = D("DimStockCheckDf");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["storeId"]))		$data["store_id"] =    $this->addslashesx($jsonArr["storeId"]); 
		if(isset($jsonArr["storeName"]))		$data["store_name"] =    $this->addslashesx($jsonArr["storeName"]); 
		if(isset($jsonArr["categoryName"]))		$data["category_name"] =    $this->addslashesx($jsonArr["categoryName"]); 
		if(isset($jsonArr["commodityId"]))		$data["commodity_id"] =    $this->addslashesx($jsonArr["commodityId"]); 
		if(isset($jsonArr["commodityName"]))		$data["commodity_name"] =    $this->addslashesx($jsonArr["commodityName"]); 
		if(isset($jsonArr["currentStock"]))		$data["current_stock"] =    $this->addslashesx($jsonArr["currentStock"]); 
		if(isset($jsonArr["continuousNoSaleDay"]))		$data["continuous_no_sale_day"] =    $this->addslashesx($jsonArr["continuousNoSaleDay"]); 
		if(isset($jsonArr["commodityTag"]))		$data["commodity_tag"] =    $this->addslashesx($jsonArr["commodityTag"]); 
		if(isset($jsonArr["dt"]))		$data["dt"] =    $this->addslashesx($jsonArr["dt"]); 
		if(isset($jsonArr["createTime"]))		$data["create_time"] =    $this->addslashesx($jsonArr["createTime"]); 
		if(isset($jsonArr["updateTime"]))		$data["update_time"] =    $this->addslashesx($jsonArr["updateTime"]); 

            $su = $dimStockCheckDfModel->data($data)->save();

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

					   	$dimStockCheckDfModel = D("DimStockCheckDf");

 				$data = array();


									$data["store_id"] = $this->addslashesx(  $jsonArr["StoreId"]); 
				$data["store_name"] = $this->addslashesx(  $jsonArr["StoreName"]); 
				$data["category_name"] = $this->addslashesx(  $jsonArr["CategoryName"]); 
				$data["commodity_id"] = $this->addslashesx(  $jsonArr["CommodityId"]); 
				$data["commodity_name"] = $this->addslashesx(  $jsonArr["CommodityName"]); 
				$data["current_stock"] = $this->addslashesx(  $jsonArr["CurrentStock"]); 
				$data["continuous_no_sale_day"] = $this->addslashesx(  $jsonArr["ContinuousNoSaleDay"]); 
				$data["commodity_tag"] = $this->addslashesx(  $jsonArr["CommodityTag"]); 
				$data["dt"] = $this->addslashesx(  $jsonArr["Dt"]); 
				$data["create_time"] = $this->addslashesx(  $jsonArr["CreateTime"]); 
				$data["update_time"] = $this->addslashesx(  $jsonArr["UpdateTime"]); 



				$su =  $dimStockCheckDfModel->data($data)->add();

	
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
		
		

      

		$dimStockCheckDfModel = D("DimStockCheckDf");
 

        $selectWhere = " id like '%$searchkey%'  or store_id like '%$searchkey%' or store_name like '%$searchkey%' or category_name like '%$searchkey%' or commodity_id like '%$searchkey%' or commodity_name like '%$searchkey%' or current_stock like '%$searchkey%' or continuous_no_sale_day like '%$searchkey%' or commodity_tag like '%$searchkey%' or dt like '%$searchkey%' or create_time like '%$searchkey%' or update_time like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $dimStockCheckDfModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $dimStockCheckDfModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."dim_stock_check_df" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$dimStockCheckDfModel = D("DimStockCheckDf");
    	$tmpArr = $dimStockCheckDfModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "dim_stock_check_df".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or store_id like '%$searchkey%' or store_name like '%$searchkey%' or category_name like '%$searchkey%' or commodity_id like '%$searchkey%' or commodity_name like '%$searchkey%' or current_stock like '%$searchkey%' or continuous_no_sale_day like '%$searchkey%' or commodity_tag like '%$searchkey%' or dt like '%$searchkey%' or create_time like '%$searchkey%' or update_time like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"dim_stock_check_df",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $dimStockCheckDfModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $dimStockCheckDfModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $dimStockCheckDfModel->getDbFields()  ;
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
       $idName = "tablename."."dim_stock_check_df" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$dimStockCheckDfModel = D("DimStockCheckDf");
				$data = array();


				$data["store_id"] = addslashes(  $_REQUEST["addData_store_id"] ); 
				$data["store_name"] = addslashes(  $_REQUEST["addData_store_name"] ); 
				$data["category_name"] = addslashes(  $_REQUEST["addData_category_name"] ); 
				$data["commodity_id"] = addslashes(  $_REQUEST["addData_commodity_id"] ); 
				$data["commodity_name"] = addslashes(  $_REQUEST["addData_commodity_name"] ); 
				$data["current_stock"] = addslashes(  $_REQUEST["addData_current_stock"] ); 
				$data["continuous_no_sale_day"] = addslashes(  $_REQUEST["addData_continuous_no_sale_day"] ); 
				$data["commodity_tag"] = addslashes(  $_REQUEST["addData_commodity_tag"] ); 
				$data["dt"] = addslashes(  $_REQUEST["addData_dt"] ); 
				$data["create_time"] = addslashes(  $_REQUEST["addData_create_time"] ); 
				$data["update_time"] = addslashes(  $_REQUEST["addData_update_time"] ); 



				$su =  $dimStockCheckDfModel->data($data)->add();

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
       $idName = "tablename."."dim_stock_check_df" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$dimStockCheckDfModel = D("DimStockCheckDf");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["store_id"] =  addslashes( $_REQUEST["editData_store_id"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["category_name"] =  addslashes( $_REQUEST["editData_category_name"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["commodity_name"] =  addslashes( $_REQUEST["editData_commodity_name"]); 
				$data["current_stock"] =  addslashes( $_REQUEST["editData_current_stock"]); 
				$data["continuous_no_sale_day"] =  addslashes( $_REQUEST["editData_continuous_no_sale_day"]); 
				$data["commodity_tag"] =  addslashes( $_REQUEST["editData_commodity_tag"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 
				$data["create_time"] =  addslashes( $_REQUEST["editData_create_time"]); 
				$data["update_time"] =  addslashes( $_REQUEST["editData_update_time"]); 




            $su = $dimStockCheckDfModel->data($data)->save();

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

        	$dimStockCheckDfModel = D("DimStockCheckDf");
        $editData = $dimStockCheckDfModel->getById($params);
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
         $idName = "tablename."."dim_stock_check_df" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$dimStockCheckDfModel = D("DimStockCheckDf");
        $sc = $dimStockCheckDfModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("DimStockCheckDf/index");



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

				$dim_stock_check_dfModel = D ( "DimStockCheckDf" );
				$tmpArr = $dim_stock_check_dfModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "dim_stock_check_df" . "." . $field;
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

							$dim_stock_check_dfModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $dim_stock_check_dfModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../DimStockCheckDf'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."dim_stock_check_df" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$dimStockCheckDfModel = D("DimStockCheckDf");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["store_id"] =  addslashes( $_REQUEST["editData_store_id"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["category_name"] =  addslashes( $_REQUEST["editData_category_name"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["commodity_name"] =  addslashes( $_REQUEST["editData_commodity_name"]); 
				$data["current_stock"] =  addslashes( $_REQUEST["editData_current_stock"]); 
				$data["continuous_no_sale_day"] =  addslashes( $_REQUEST["editData_continuous_no_sale_day"]); 
				$data["commodity_tag"] =  addslashes( $_REQUEST["editData_commodity_tag"]); 
				$data["dt"] =  addslashes( $_REQUEST["editData_dt"]); 
				$data["create_time"] =  addslashes( $_REQUEST["editData_create_time"]); 
				$data["update_time"] =  addslashes( $_REQUEST["editData_update_time"]); 


	 		 $data["id"]="";


            $su = $dimStockCheckDfModel->data($data)->add();

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

        	$dimStockCheckDfModel = D("DimStockCheckDf");
        $editData = $dimStockCheckDfModel->getById($params);
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