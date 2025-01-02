<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$cleaningSkuModel = D("CleaningSku"); //BASECIDE0
// |CleaningSku\/queryOneMyData$
// |CleaningSku\/delMyData$
// |CleaningSku\/addMyData$
// |CleaningSku\/updateMyData$
// |CleaningSku\/queryList$
/*
  id  id 
  commodityId  名字加规格 
  tenantCode  租户编号 
  dirtyId  原始商品 
  dirtyCode  原始商品编码 
  dirtyName  名称 
  cleaningId  编码 
  cleaningName  名称 
  cleaningCount  数量 
  isCombo  是否为套餐 
  updatedTime  更新时间 
  dirtySpec  规格 
  cleaningSpec  规格 */

class CleaningSkuAction extends  Action {
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

	//CleaningSku\/getActionTableName$
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

			
			

					   	$cleaningSkuModel = D("CleaningSku");
				$editData = $cleaningSkuModel->getById($id);




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

					   	$cleaningSkuModel = D("CleaningSku");
					$sc = 	$cleaningSkuModel->where("id='$id'")->delete();

				
					

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

					   	$cleaningSkuModel = D("CleaningSku");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["commodityId"]))		$data["commodity_id"] =    $this->addslashesx($jsonArr["commodityId"]); 
		if(isset($jsonArr["tenantCode"]))		$data["tenant_code"] =    $this->addslashesx($jsonArr["tenantCode"]); 
		if(isset($jsonArr["dirtyId"]))		$data["dirty_id"] =    $this->addslashesx($jsonArr["dirtyId"]); 
		if(isset($jsonArr["dirtyCode"]))		$data["dirty_code"] =    $this->addslashesx($jsonArr["dirtyCode"]); 
		if(isset($jsonArr["dirtyName"]))		$data["dirty_name"] =    $this->addslashesx($jsonArr["dirtyName"]); 
		if(isset($jsonArr["cleaningId"]))		$data["cleaning_id"] =    $this->addslashesx($jsonArr["cleaningId"]); 
		if(isset($jsonArr["cleaningName"]))		$data["cleaning_name"] =    $this->addslashesx($jsonArr["cleaningName"]); 
		if(isset($jsonArr["cleaningCount"]))		$data["cleaning_count"] =    $this->addslashesx($jsonArr["cleaningCount"]); 
		if(isset($jsonArr["isCombo"]))		$data["is_combo"] =    $this->addslashesx($jsonArr["isCombo"]); 
		if(isset($jsonArr["updatedTime"]))		$data["updated_time"] =    $this->addslashesx($jsonArr["updatedTime"]); 
		if(isset($jsonArr["dirtySpec"]))		$data["dirty_spec"] =    $this->addslashesx($jsonArr["dirtySpec"]); 
		if(isset($jsonArr["cleaningSpec"]))		$data["cleaning_spec"] =    $this->addslashesx($jsonArr["cleaningSpec"]); 

            $su = $cleaningSkuModel->data($data)->save();

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

					   	$cleaningSkuModel = D("CleaningSku");

 				$data = array();


									$data["commodity_id"] = $this->addslashesx(  $jsonArr["CommodityId"]); 
				$data["tenant_code"] = $this->addslashesx(  $jsonArr["TenantCode"]); 
				$data["dirty_id"] = $this->addslashesx(  $jsonArr["DirtyId"]); 
				$data["dirty_code"] = $this->addslashesx(  $jsonArr["DirtyCode"]); 
				$data["dirty_name"] = $this->addslashesx(  $jsonArr["DirtyName"]); 
				$data["cleaning_id"] = $this->addslashesx(  $jsonArr["CleaningId"]); 
				$data["cleaning_name"] = $this->addslashesx(  $jsonArr["CleaningName"]); 
				$data["cleaning_count"] = $this->addslashesx(  $jsonArr["CleaningCount"]); 
				$data["is_combo"] = $this->addslashesx(  $jsonArr["IsCombo"]); 
				$data["updated_time"] = $this->addslashesx(  $jsonArr["UpdatedTime"]); 
				$data["dirty_spec"] = $this->addslashesx(  $jsonArr["DirtySpec"]); 
				$data["cleaning_spec"] = $this->addslashesx(  $jsonArr["CleaningSpec"]); 



				$su =  $cleaningSkuModel->data($data)->add();

	
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
		
		

      

		$cleaningSkuModel = D("CleaningSku");
 

        $selectWhere = " id like '%$searchkey%'  or commodity_id like '%$searchkey%' or tenant_code like '%$searchkey%' or dirty_id like '%$searchkey%' or dirty_code like '%$searchkey%' or dirty_name like '%$searchkey%' or cleaning_id like '%$searchkey%' or cleaning_name like '%$searchkey%' or cleaning_count like '%$searchkey%' or is_combo like '%$searchkey%' or updated_time like '%$searchkey%' or dirty_spec like '%$searchkey%' or cleaning_spec like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $cleaningSkuModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $cleaningSkuModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."cleaning_sku" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$cleaningSkuModel = D("CleaningSku");
    	$tmpArr = $cleaningSkuModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "cleaning_sku".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or commodity_id like '%$searchkey%' or tenant_code like '%$searchkey%' or dirty_id like '%$searchkey%' or dirty_code like '%$searchkey%' or dirty_name like '%$searchkey%' or cleaning_id like '%$searchkey%' or cleaning_name like '%$searchkey%' or cleaning_count like '%$searchkey%' or is_combo like '%$searchkey%' or updated_time like '%$searchkey%' or dirty_spec like '%$searchkey%' or cleaning_spec like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"cleaning_sku",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $cleaningSkuModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $cleaningSkuModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $cleaningSkuModel->getDbFields()  ;
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
       $idName = "tablename."."cleaning_sku" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$cleaningSkuModel = D("CleaningSku");
				$data = array();


				$data["commodity_id"] = addslashes(  $_REQUEST["addData_commodity_id"] ); 
				$data["tenant_code"] = addslashes(  $_REQUEST["addData_tenant_code"] ); 
				$data["dirty_id"] = addslashes(  $_REQUEST["addData_dirty_id"] ); 
				$data["dirty_code"] = addslashes(  $_REQUEST["addData_dirty_code"] ); 
				$data["dirty_name"] = addslashes(  $_REQUEST["addData_dirty_name"] ); 
				$data["cleaning_id"] = addslashes(  $_REQUEST["addData_cleaning_id"] ); 
				$data["cleaning_name"] = addslashes(  $_REQUEST["addData_cleaning_name"] ); 
				$data["cleaning_count"] = addslashes(  $_REQUEST["addData_cleaning_count"] ); 
				$data["is_combo"] = addslashes(  $_REQUEST["addData_is_combo"] ); 
				$data["updated_time"] = addslashes(  $_REQUEST["addData_updated_time"] ); 
				$data["dirty_spec"] = addslashes(  $_REQUEST["addData_dirty_spec"] ); 
				$data["cleaning_spec"] = addslashes(  $_REQUEST["addData_cleaning_spec"] ); 



				$su =  $cleaningSkuModel->data($data)->add();

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
       $idName = "tablename."."cleaning_sku" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$cleaningSkuModel = D("CleaningSku");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["dirty_id"] =  addslashes( $_REQUEST["editData_dirty_id"]); 
				$data["dirty_code"] =  addslashes( $_REQUEST["editData_dirty_code"]); 
				$data["dirty_name"] =  addslashes( $_REQUEST["editData_dirty_name"]); 
				$data["cleaning_id"] =  addslashes( $_REQUEST["editData_cleaning_id"]); 
				$data["cleaning_name"] =  addslashes( $_REQUEST["editData_cleaning_name"]); 
				$data["cleaning_count"] =  addslashes( $_REQUEST["editData_cleaning_count"]); 
				$data["is_combo"] =  addslashes( $_REQUEST["editData_is_combo"]); 
				$data["updated_time"] =  addslashes( $_REQUEST["editData_updated_time"]); 
				$data["dirty_spec"] =  addslashes( $_REQUEST["editData_dirty_spec"]); 
				$data["cleaning_spec"] =  addslashes( $_REQUEST["editData_cleaning_spec"]); 




            $su = $cleaningSkuModel->data($data)->save();

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

        	$cleaningSkuModel = D("CleaningSku");
        $editData = $cleaningSkuModel->getById($params);
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
         $idName = "tablename."."cleaning_sku" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$cleaningSkuModel = D("CleaningSku");
        $sc = $cleaningSkuModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("CleaningSku/index");



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

				$cleaning_skuModel = D ( "CleaningSku" );
				$tmpArr = $cleaning_skuModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "cleaning_sku" . "." . $field;
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

							$cleaning_skuModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $cleaning_skuModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../CleaningSku'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."cleaning_sku" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$cleaningSkuModel = D("CleaningSku");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["commodity_id"] =  addslashes( $_REQUEST["editData_commodity_id"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 
				$data["dirty_id"] =  addslashes( $_REQUEST["editData_dirty_id"]); 
				$data["dirty_code"] =  addslashes( $_REQUEST["editData_dirty_code"]); 
				$data["dirty_name"] =  addslashes( $_REQUEST["editData_dirty_name"]); 
				$data["cleaning_id"] =  addslashes( $_REQUEST["editData_cleaning_id"]); 
				$data["cleaning_name"] =  addslashes( $_REQUEST["editData_cleaning_name"]); 
				$data["cleaning_count"] =  addslashes( $_REQUEST["editData_cleaning_count"]); 
				$data["is_combo"] =  addslashes( $_REQUEST["editData_is_combo"]); 
				$data["updated_time"] =  addslashes( $_REQUEST["editData_updated_time"]); 
				$data["dirty_spec"] =  addslashes( $_REQUEST["editData_dirty_spec"]); 
				$data["cleaning_spec"] =  addslashes( $_REQUEST["editData_cleaning_spec"]); 


	 		 $data["id"]="";


            $su = $cleaningSkuModel->data($data)->add();

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

        	$cleaningSkuModel = D("CleaningSku");
        $editData = $cleaningSkuModel->getById($params);
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