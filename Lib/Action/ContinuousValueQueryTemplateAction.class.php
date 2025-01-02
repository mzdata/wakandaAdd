<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate"); //BASECIDE0
// |ContinuousValueQueryTemplate\/queryOneMyData$
// |ContinuousValueQueryTemplate\/delMyData$
// |ContinuousValueQueryTemplate\/addMyData$
// |ContinuousValueQueryTemplate\/updateMyData$
// |ContinuousValueQueryTemplate\/queryList$
/*
  id  id 
  catalogName  值分类 
  catalogEnum  值分类枚举值 
  metricName  指标名 
  metricEnum  指标值 
  metricUnit  指标单位 
  tableName  数仓数据表名 
  timeField  时间字段 
  valueField  查询字段 
  deleted  是否已删除 
  sort  排序 
  selected  是否选中 */

class ContinuousValueQueryTemplateAction extends  Action {
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

	//ContinuousValueQueryTemplate\/getActionTableName$
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

			
			

					   	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
				$editData = $continuousValueQueryTemplateModel->getById($id);




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

					   	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
					$sc = 	$continuousValueQueryTemplateModel->where("id='$id'")->delete();

				
					

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

					   	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["catalogName"]))		$data["catalog_name"] =    $this->addslashesx($jsonArr["catalogName"]); 
		if(isset($jsonArr["catalogEnum"]))		$data["catalog_enum"] =    $this->addslashesx($jsonArr["catalogEnum"]); 
		if(isset($jsonArr["metricName"]))		$data["metric_name"] =    $this->addslashesx($jsonArr["metricName"]); 
		if(isset($jsonArr["metricEnum"]))		$data["metric_enum"] =    $this->addslashesx($jsonArr["metricEnum"]); 
		if(isset($jsonArr["metricUnit"]))		$data["metric_unit"] =    $this->addslashesx($jsonArr["metricUnit"]); 
		if(isset($jsonArr["tableName"]))		$data["table_name"] =    $this->addslashesx($jsonArr["tableName"]); 
		if(isset($jsonArr["timeField"]))		$data["time_field"] =    $this->addslashesx($jsonArr["timeField"]); 
		if(isset($jsonArr["valueField"]))		$data["value_field"] =    $this->addslashesx($jsonArr["valueField"]); 
		if(isset($jsonArr["deleted"]))		$data["deleted"] =    $this->addslashesx($jsonArr["deleted"]); 
		if(isset($jsonArr["sort"]))		$data["sort"] =    $this->addslashesx($jsonArr["sort"]); 
		if(isset($jsonArr["selected"]))		$data["selected"] =    $this->addslashesx($jsonArr["selected"]); 

            $su = $continuousValueQueryTemplateModel->data($data)->save();

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

					   	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");

 				$data = array();


									$data["catalog_name"] = $this->addslashesx(  $jsonArr["CatalogName"]); 
				$data["catalog_enum"] = $this->addslashesx(  $jsonArr["CatalogEnum"]); 
				$data["metric_name"] = $this->addslashesx(  $jsonArr["MetricName"]); 
				$data["metric_enum"] = $this->addslashesx(  $jsonArr["MetricEnum"]); 
				$data["metric_unit"] = $this->addslashesx(  $jsonArr["MetricUnit"]); 
				$data["table_name"] = $this->addslashesx(  $jsonArr["TableName"]); 
				$data["time_field"] = $this->addslashesx(  $jsonArr["TimeField"]); 
				$data["value_field"] = $this->addslashesx(  $jsonArr["ValueField"]); 
				$data["deleted"] = $this->addslashesx(  $jsonArr["Deleted"]); 
				$data["sort"] = $this->addslashesx(  $jsonArr["Sort"]); 
				$data["selected"] = $this->addslashesx(  $jsonArr["Selected"]); 



				$su =  $continuousValueQueryTemplateModel->data($data)->add();

	
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
		
		

      

		$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
 

        $selectWhere = " id like '%$searchkey%'  or catalog_name like '%$searchkey%' or catalog_enum like '%$searchkey%' or metric_name like '%$searchkey%' or metric_enum like '%$searchkey%' or metric_unit like '%$searchkey%' or table_name like '%$searchkey%' or time_field like '%$searchkey%' or value_field like '%$searchkey%' or deleted like '%$searchkey%' or sort like '%$searchkey%' or selected like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $continuousValueQueryTemplateModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $continuousValueQueryTemplateModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."continuous_value_query_template" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
    	$tmpArr = $continuousValueQueryTemplateModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "continuous_value_query_template".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or catalog_name like '%$searchkey%' or catalog_enum like '%$searchkey%' or metric_name like '%$searchkey%' or metric_enum like '%$searchkey%' or metric_unit like '%$searchkey%' or table_name like '%$searchkey%' or time_field like '%$searchkey%' or value_field like '%$searchkey%' or deleted like '%$searchkey%' or sort like '%$searchkey%' or selected like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"continuous_value_query_template",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $continuousValueQueryTemplateModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $continuousValueQueryTemplateModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $continuousValueQueryTemplateModel->getDbFields()  ;
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
       $idName = "tablename."."continuous_value_query_template" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
				$data = array();


				$data["catalog_name"] = addslashes(  $_REQUEST["addData_catalog_name"] ); 
				$data["catalog_enum"] = addslashes(  $_REQUEST["addData_catalog_enum"] ); 
				$data["metric_name"] = addslashes(  $_REQUEST["addData_metric_name"] ); 
				$data["metric_enum"] = addslashes(  $_REQUEST["addData_metric_enum"] ); 
				$data["metric_unit"] = addslashes(  $_REQUEST["addData_metric_unit"] ); 
				$data["table_name"] = addslashes(  $_REQUEST["addData_table_name"] ); 
				$data["time_field"] = addslashes(  $_REQUEST["addData_time_field"] ); 
				$data["value_field"] = addslashes(  $_REQUEST["addData_value_field"] ); 
				$data["deleted"] = addslashes(  $_REQUEST["addData_deleted"] ); 
				$data["sort"] = addslashes(  $_REQUEST["addData_sort"] ); 
				$data["selected"] = addslashes(  $_REQUEST["addData_selected"] ); 



				$su =  $continuousValueQueryTemplateModel->data($data)->add();

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
       $idName = "tablename."."continuous_value_query_template" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["catalog_name"] =  addslashes( $_REQUEST["editData_catalog_name"]); 
				$data["catalog_enum"] =  addslashes( $_REQUEST["editData_catalog_enum"]); 
				$data["metric_name"] =  addslashes( $_REQUEST["editData_metric_name"]); 
				$data["metric_enum"] =  addslashes( $_REQUEST["editData_metric_enum"]); 
				$data["metric_unit"] =  addslashes( $_REQUEST["editData_metric_unit"]); 
				$data["table_name"] =  addslashes( $_REQUEST["editData_table_name"]); 
				$data["time_field"] =  addslashes( $_REQUEST["editData_time_field"]); 
				$data["value_field"] =  addslashes( $_REQUEST["editData_value_field"]); 
				$data["deleted"] =  addslashes( $_REQUEST["editData_deleted"]); 
				$data["sort"] =  addslashes( $_REQUEST["editData_sort"]); 
				$data["selected"] =  addslashes( $_REQUEST["editData_selected"]); 




            $su = $continuousValueQueryTemplateModel->data($data)->save();

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

        	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
        $editData = $continuousValueQueryTemplateModel->getById($params);
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
         $idName = "tablename."."continuous_value_query_template" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
        $sc = $continuousValueQueryTemplateModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("ContinuousValueQueryTemplate/index");



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

				$continuous_value_query_templateModel = D ( "ContinuousValueQueryTemplate" );
				$tmpArr = $continuous_value_query_templateModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "continuous_value_query_template" . "." . $field;
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

							$continuous_value_query_templateModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $continuous_value_query_templateModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../ContinuousValueQueryTemplate'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."continuous_value_query_template" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["catalog_name"] =  addslashes( $_REQUEST["editData_catalog_name"]); 
				$data["catalog_enum"] =  addslashes( $_REQUEST["editData_catalog_enum"]); 
				$data["metric_name"] =  addslashes( $_REQUEST["editData_metric_name"]); 
				$data["metric_enum"] =  addslashes( $_REQUEST["editData_metric_enum"]); 
				$data["metric_unit"] =  addslashes( $_REQUEST["editData_metric_unit"]); 
				$data["table_name"] =  addslashes( $_REQUEST["editData_table_name"]); 
				$data["time_field"] =  addslashes( $_REQUEST["editData_time_field"]); 
				$data["value_field"] =  addslashes( $_REQUEST["editData_value_field"]); 
				$data["deleted"] =  addslashes( $_REQUEST["editData_deleted"]); 
				$data["sort"] =  addslashes( $_REQUEST["editData_sort"]); 
				$data["selected"] =  addslashes( $_REQUEST["editData_selected"]); 


	 		 $data["id"]="";


            $su = $continuousValueQueryTemplateModel->data($data)->add();

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

        	$continuousValueQueryTemplateModel = D("ContinuousValueQueryTemplate");
        $editData = $continuousValueQueryTemplateModel->getById($params);
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