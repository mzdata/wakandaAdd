<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$evaluationModel = D("Evaluation"); //BASECIDE0
// |Evaluation\/queryOneMyData$
// |Evaluation\/delMyData$
// |Evaluation\/addMyData$
// |Evaluation\/updateMyData$
// |Evaluation\/queryList$
/*
  id  id 
  evaluationTime  评价时间 
  evaluationTags  评价标签 
  evaluationDetails  评价详情 
  starRating  星级分 
  tasteRating  口味分 
  environmentRating  环境分 
  serviceRating  服务分 
  categoryRating  品类分 
  ingredientRating  食材分 
  costPerformanceRating  性价比分 
  viewCount  浏览人数 
  city  城市 
  storeName  评价门店 
  storeMeituanId  门店美团id 
  authorizationNumber  授权号 
  groupBuyingId  团购id 
  groupBuyingEvaluation  评价团购 
  evaluationSource  评价来源 
  userNickname  用户昵称 
  isVip  是否vip 
  userLevel  用户等级 
  replyStatus  回复状态 
  merchantReplyContent  商户回复内容 
  merchantReplyTime  商户回复时间 
  buildingContent  盖楼内容 
  isNegative  是否差评 
  evaluationType  评价类型 
  dineWay  就餐方式 
  department  归属部门 
  evaluationLevel  评价等级 
  think  思考过程 
  tenantCode  租户 */

class EvaluationAction extends  Action {
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

	//Evaluation\/getActionTableName$
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

			
			

					   	$evaluationModel = D("Evaluation");
				$editData = $evaluationModel->getById($id);




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

					   	$evaluationModel = D("Evaluation");
					$sc = 	$evaluationModel->where("id='$id'")->delete();

				
					

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

					   	$evaluationModel = D("Evaluation");
				 $data = array();

							if(isset($jsonArr["id"]))		$data["id"] =    $this->addslashesx($jsonArr["id"]); 
		if(isset($jsonArr["evaluationTime"]))		$data["evaluation_time"] =    $this->addslashesx($jsonArr["evaluationTime"]); 
		if(isset($jsonArr["evaluationTags"]))		$data["evaluation_tags"] =    $this->addslashesx($jsonArr["evaluationTags"]); 
		if(isset($jsonArr["evaluationDetails"]))		$data["evaluation_details"] =    $this->addslashesx($jsonArr["evaluationDetails"]); 
		if(isset($jsonArr["starRating"]))		$data["star_rating"] =    $this->addslashesx($jsonArr["starRating"]); 
		if(isset($jsonArr["tasteRating"]))		$data["taste_rating"] =    $this->addslashesx($jsonArr["tasteRating"]); 
		if(isset($jsonArr["environmentRating"]))		$data["environment_rating"] =    $this->addslashesx($jsonArr["environmentRating"]); 
		if(isset($jsonArr["serviceRating"]))		$data["service_rating"] =    $this->addslashesx($jsonArr["serviceRating"]); 
		if(isset($jsonArr["categoryRating"]))		$data["category_rating"] =    $this->addslashesx($jsonArr["categoryRating"]); 
		if(isset($jsonArr["ingredientRating"]))		$data["ingredient_rating"] =    $this->addslashesx($jsonArr["ingredientRating"]); 
		if(isset($jsonArr["costPerformanceRating"]))		$data["cost_performance_rating"] =    $this->addslashesx($jsonArr["costPerformanceRating"]); 
		if(isset($jsonArr["viewCount"]))		$data["view_count"] =    $this->addslashesx($jsonArr["viewCount"]); 
		if(isset($jsonArr["city"]))		$data["city"] =    $this->addslashesx($jsonArr["city"]); 
		if(isset($jsonArr["storeName"]))		$data["store_name"] =    $this->addslashesx($jsonArr["storeName"]); 
		if(isset($jsonArr["storeMeituanId"]))		$data["store_meituan_id"] =    $this->addslashesx($jsonArr["storeMeituanId"]); 
		if(isset($jsonArr["authorizationNumber"]))		$data["authorization_number"] =    $this->addslashesx($jsonArr["authorizationNumber"]); 
		if(isset($jsonArr["groupBuyingId"]))		$data["group_buying_id"] =    $this->addslashesx($jsonArr["groupBuyingId"]); 
		if(isset($jsonArr["groupBuyingEvaluation"]))		$data["group_buying_evaluation"] =    $this->addslashesx($jsonArr["groupBuyingEvaluation"]); 
		if(isset($jsonArr["evaluationSource"]))		$data["evaluation_source"] =    $this->addslashesx($jsonArr["evaluationSource"]); 
		if(isset($jsonArr["userNickname"]))		$data["user_nickname"] =    $this->addslashesx($jsonArr["userNickname"]); 
		if(isset($jsonArr["isVip"]))		$data["is_vip"] =    $this->addslashesx($jsonArr["isVip"]); 
		if(isset($jsonArr["userLevel"]))		$data["user_level"] =    $this->addslashesx($jsonArr["userLevel"]); 
		if(isset($jsonArr["replyStatus"]))		$data["reply_status"] =    $this->addslashesx($jsonArr["replyStatus"]); 
		if(isset($jsonArr["merchantReplyContent"]))		$data["merchant_reply_content"] =    $this->addslashesx($jsonArr["merchantReplyContent"]); 
		if(isset($jsonArr["merchantReplyTime"]))		$data["merchant_reply_time"] =    $this->addslashesx($jsonArr["merchantReplyTime"]); 
		if(isset($jsonArr["buildingContent"]))		$data["building_content"] =    $this->addslashesx($jsonArr["buildingContent"]); 
		if(isset($jsonArr["isNegative"]))		$data["is_negative"] =    $this->addslashesx($jsonArr["isNegative"]); 
		if(isset($jsonArr["evaluationType"]))		$data["evaluation_type"] =    $this->addslashesx($jsonArr["evaluationType"]); 
		if(isset($jsonArr["dineWay"]))		$data["dine_way"] =    $this->addslashesx($jsonArr["dineWay"]); 
		if(isset($jsonArr["department"]))		$data["department"] =    $this->addslashesx($jsonArr["department"]); 
		if(isset($jsonArr["evaluationLevel"]))		$data["evaluation_level"] =    $this->addslashesx($jsonArr["evaluationLevel"]); 
		if(isset($jsonArr["think"]))		$data["think"] =    $this->addslashesx($jsonArr["think"]); 
		if(isset($jsonArr["tenantCode"]))		$data["tenant_code"] =    $this->addslashesx($jsonArr["tenantCode"]); 

            $su = $evaluationModel->data($data)->save();

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

					   	$evaluationModel = D("Evaluation");

 				$data = array();


									$data["evaluation_time"] = $this->addslashesx(  $jsonArr["EvaluationTime"]); 
				$data["evaluation_tags"] = $this->addslashesx(  $jsonArr["EvaluationTags"]); 
				$data["evaluation_details"] = $this->addslashesx(  $jsonArr["EvaluationDetails"]); 
				$data["star_rating"] = $this->addslashesx(  $jsonArr["StarRating"]); 
				$data["taste_rating"] = $this->addslashesx(  $jsonArr["TasteRating"]); 
				$data["environment_rating"] = $this->addslashesx(  $jsonArr["EnvironmentRating"]); 
				$data["service_rating"] = $this->addslashesx(  $jsonArr["ServiceRating"]); 
				$data["category_rating"] = $this->addslashesx(  $jsonArr["CategoryRating"]); 
				$data["ingredient_rating"] = $this->addslashesx(  $jsonArr["IngredientRating"]); 
				$data["cost_performance_rating"] = $this->addslashesx(  $jsonArr["CostPerformanceRating"]); 
				$data["view_count"] = $this->addslashesx(  $jsonArr["ViewCount"]); 
				$data["city"] = $this->addslashesx(  $jsonArr["City"]); 
				$data["store_name"] = $this->addslashesx(  $jsonArr["StoreName"]); 
				$data["store_meituan_id"] = $this->addslashesx(  $jsonArr["StoreMeituanId"]); 
				$data["authorization_number"] = $this->addslashesx(  $jsonArr["AuthorizationNumber"]); 
				$data["group_buying_id"] = $this->addslashesx(  $jsonArr["GroupBuyingId"]); 
				$data["group_buying_evaluation"] = $this->addslashesx(  $jsonArr["GroupBuyingEvaluation"]); 
				$data["evaluation_source"] = $this->addslashesx(  $jsonArr["EvaluationSource"]); 
				$data["user_nickname"] = $this->addslashesx(  $jsonArr["UserNickname"]); 
				$data["is_vip"] = $this->addslashesx(  $jsonArr["IsVip"]); 
				$data["user_level"] = $this->addslashesx(  $jsonArr["UserLevel"]); 
				$data["reply_status"] = $this->addslashesx(  $jsonArr["ReplyStatus"]); 
				$data["merchant_reply_content"] = $this->addslashesx(  $jsonArr["MerchantReplyContent"]); 
				$data["merchant_reply_time"] = $this->addslashesx(  $jsonArr["MerchantReplyTime"]); 
				$data["building_content"] = $this->addslashesx(  $jsonArr["BuildingContent"]); 
				$data["is_negative"] = $this->addslashesx(  $jsonArr["IsNegative"]); 
				$data["evaluation_type"] = $this->addslashesx(  $jsonArr["EvaluationType"]); 
				$data["dine_way"] = $this->addslashesx(  $jsonArr["DineWay"]); 
				$data["department"] = $this->addslashesx(  $jsonArr["Department"]); 
				$data["evaluation_level"] = $this->addslashesx(  $jsonArr["EvaluationLevel"]); 
				$data["think"] = $this->addslashesx(  $jsonArr["Think"]); 
				$data["tenant_code"] = $this->addslashesx(  $jsonArr["TenantCode"]); 



				$su =  $evaluationModel->data($data)->add();

	
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
		
		

      

		$evaluationModel = D("Evaluation");
 

        $selectWhere = " id like '%$searchkey%'  or evaluation_time like '%$searchkey%' or evaluation_tags like '%$searchkey%' or evaluation_details like '%$searchkey%' or star_rating like '%$searchkey%' or taste_rating like '%$searchkey%' or environment_rating like '%$searchkey%' or service_rating like '%$searchkey%' or category_rating like '%$searchkey%' or ingredient_rating like '%$searchkey%' or cost_performance_rating like '%$searchkey%' or view_count like '%$searchkey%' or city like '%$searchkey%' or store_name like '%$searchkey%' or store_meituan_id like '%$searchkey%' or authorization_number like '%$searchkey%' or group_buying_id like '%$searchkey%' or group_buying_evaluation like '%$searchkey%' or evaluation_source like '%$searchkey%' or user_nickname like '%$searchkey%' or is_vip like '%$searchkey%' or user_level like '%$searchkey%' or reply_status like '%$searchkey%' or merchant_reply_content like '%$searchkey%' or merchant_reply_time like '%$searchkey%' or building_content like '%$searchkey%' or is_negative like '%$searchkey%' or evaluation_type like '%$searchkey%' or dine_way like '%$searchkey%' or department like '%$searchkey%' or evaluation_level like '%$searchkey%' or think like '%$searchkey%' or tenant_code like '%$searchkey%'";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $evaluationModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $evaluationModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."evaluation" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$evaluationModel = D("Evaluation");
    	$tmpArr = $evaluationModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "evaluation".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%'  or evaluation_time like '%$searchkey%' or evaluation_tags like '%$searchkey%' or evaluation_details like '%$searchkey%' or star_rating like '%$searchkey%' or taste_rating like '%$searchkey%' or environment_rating like '%$searchkey%' or service_rating like '%$searchkey%' or category_rating like '%$searchkey%' or ingredient_rating like '%$searchkey%' or cost_performance_rating like '%$searchkey%' or view_count like '%$searchkey%' or city like '%$searchkey%' or store_name like '%$searchkey%' or store_meituan_id like '%$searchkey%' or authorization_number like '%$searchkey%' or group_buying_id like '%$searchkey%' or group_buying_evaluation like '%$searchkey%' or evaluation_source like '%$searchkey%' or user_nickname like '%$searchkey%' or is_vip like '%$searchkey%' or user_level like '%$searchkey%' or reply_status like '%$searchkey%' or merchant_reply_content like '%$searchkey%' or merchant_reply_time like '%$searchkey%' or building_content like '%$searchkey%' or is_negative like '%$searchkey%' or evaluation_type like '%$searchkey%' or dine_way like '%$searchkey%' or department like '%$searchkey%' or evaluation_level like '%$searchkey%' or think like '%$searchkey%' or tenant_code like '%$searchkey%'";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"evaluation",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $evaluationModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $evaluationModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $evaluationModel->getDbFields()  ;
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
       $idName = "tablename."."evaluation" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$evaluationModel = D("Evaluation");
				$data = array();


				$data["evaluation_time"] = addslashes(  $_REQUEST["addData_evaluation_time"] ); 
				$data["evaluation_tags"] = addslashes(  $_REQUEST["addData_evaluation_tags"] ); 
				$data["evaluation_details"] = addslashes(  $_REQUEST["addData_evaluation_details"] ); 
				$data["star_rating"] = addslashes(  $_REQUEST["addData_star_rating"] ); 
				$data["taste_rating"] = addslashes(  $_REQUEST["addData_taste_rating"] ); 
				$data["environment_rating"] = addslashes(  $_REQUEST["addData_environment_rating"] ); 
				$data["service_rating"] = addslashes(  $_REQUEST["addData_service_rating"] ); 
				$data["category_rating"] = addslashes(  $_REQUEST["addData_category_rating"] ); 
				$data["ingredient_rating"] = addslashes(  $_REQUEST["addData_ingredient_rating"] ); 
				$data["cost_performance_rating"] = addslashes(  $_REQUEST["addData_cost_performance_rating"] ); 
				$data["view_count"] = addslashes(  $_REQUEST["addData_view_count"] ); 
				$data["city"] = addslashes(  $_REQUEST["addData_city"] ); 
				$data["store_name"] = addslashes(  $_REQUEST["addData_store_name"] ); 
				$data["store_meituan_id"] = addslashes(  $_REQUEST["addData_store_meituan_id"] ); 
				$data["authorization_number"] = addslashes(  $_REQUEST["addData_authorization_number"] ); 
				$data["group_buying_id"] = addslashes(  $_REQUEST["addData_group_buying_id"] ); 
				$data["group_buying_evaluation"] = addslashes(  $_REQUEST["addData_group_buying_evaluation"] ); 
				$data["evaluation_source"] = addslashes(  $_REQUEST["addData_evaluation_source"] ); 
				$data["user_nickname"] = addslashes(  $_REQUEST["addData_user_nickname"] ); 
				$data["is_vip"] = addslashes(  $_REQUEST["addData_is_vip"] ); 
				$data["user_level"] = addslashes(  $_REQUEST["addData_user_level"] ); 
				$data["reply_status"] = addslashes(  $_REQUEST["addData_reply_status"] ); 
				$data["merchant_reply_content"] = addslashes(  $_REQUEST["addData_merchant_reply_content"] ); 
				$data["merchant_reply_time"] = addslashes(  $_REQUEST["addData_merchant_reply_time"] ); 
				$data["building_content"] = addslashes(  $_REQUEST["addData_building_content"] ); 
				$data["is_negative"] = addslashes(  $_REQUEST["addData_is_negative"] ); 
				$data["evaluation_type"] = addslashes(  $_REQUEST["addData_evaluation_type"] ); 
				$data["dine_way"] = addslashes(  $_REQUEST["addData_dine_way"] ); 
				$data["department"] = addslashes(  $_REQUEST["addData_department"] ); 
				$data["evaluation_level"] = addslashes(  $_REQUEST["addData_evaluation_level"] ); 
				$data["think"] = addslashes(  $_REQUEST["addData_think"] ); 
				$data["tenant_code"] = addslashes(  $_REQUEST["addData_tenant_code"] ); 



				$su =  $evaluationModel->data($data)->add();

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
       $idName = "tablename."."evaluation" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$evaluationModel = D("Evaluation");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["evaluation_time"] =  addslashes( $_REQUEST["editData_evaluation_time"]); 
				$data["evaluation_tags"] =  addslashes( $_REQUEST["editData_evaluation_tags"]); 
				$data["evaluation_details"] =  addslashes( $_REQUEST["editData_evaluation_details"]); 
				$data["star_rating"] =  addslashes( $_REQUEST["editData_star_rating"]); 
				$data["taste_rating"] =  addslashes( $_REQUEST["editData_taste_rating"]); 
				$data["environment_rating"] =  addslashes( $_REQUEST["editData_environment_rating"]); 
				$data["service_rating"] =  addslashes( $_REQUEST["editData_service_rating"]); 
				$data["category_rating"] =  addslashes( $_REQUEST["editData_category_rating"]); 
				$data["ingredient_rating"] =  addslashes( $_REQUEST["editData_ingredient_rating"]); 
				$data["cost_performance_rating"] =  addslashes( $_REQUEST["editData_cost_performance_rating"]); 
				$data["view_count"] =  addslashes( $_REQUEST["editData_view_count"]); 
				$data["city"] =  addslashes( $_REQUEST["editData_city"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["store_meituan_id"] =  addslashes( $_REQUEST["editData_store_meituan_id"]); 
				$data["authorization_number"] =  addslashes( $_REQUEST["editData_authorization_number"]); 
				$data["group_buying_id"] =  addslashes( $_REQUEST["editData_group_buying_id"]); 
				$data["group_buying_evaluation"] =  addslashes( $_REQUEST["editData_group_buying_evaluation"]); 
				$data["evaluation_source"] =  addslashes( $_REQUEST["editData_evaluation_source"]); 
				$data["user_nickname"] =  addslashes( $_REQUEST["editData_user_nickname"]); 
				$data["is_vip"] =  addslashes( $_REQUEST["editData_is_vip"]); 
				$data["user_level"] =  addslashes( $_REQUEST["editData_user_level"]); 
				$data["reply_status"] =  addslashes( $_REQUEST["editData_reply_status"]); 
				$data["merchant_reply_content"] =  addslashes( $_REQUEST["editData_merchant_reply_content"]); 
				$data["merchant_reply_time"] =  addslashes( $_REQUEST["editData_merchant_reply_time"]); 
				$data["building_content"] =  addslashes( $_REQUEST["editData_building_content"]); 
				$data["is_negative"] =  addslashes( $_REQUEST["editData_is_negative"]); 
				$data["evaluation_type"] =  addslashes( $_REQUEST["editData_evaluation_type"]); 
				$data["dine_way"] =  addslashes( $_REQUEST["editData_dine_way"]); 
				$data["department"] =  addslashes( $_REQUEST["editData_department"]); 
				$data["evaluation_level"] =  addslashes( $_REQUEST["editData_evaluation_level"]); 
				$data["think"] =  addslashes( $_REQUEST["editData_think"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 




            $su = $evaluationModel->data($data)->save();

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

        	$evaluationModel = D("Evaluation");
        $editData = $evaluationModel->getById($params);
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
         $idName = "tablename."."evaluation" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$evaluationModel = D("Evaluation");
        $sc = $evaluationModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("Evaluation/index");



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

				$evaluationModel = D ( "Evaluation" );
				$tmpArr = $evaluationModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "evaluation" . "." . $field;
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

							$evaluationModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $evaluationModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../Evaluation'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."evaluation" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$evaluationModel = D("Evaluation");
            $data = array();
				$data["id"] =  addslashes( $_REQUEST["editData_id"]); 
				$data["evaluation_time"] =  addslashes( $_REQUEST["editData_evaluation_time"]); 
				$data["evaluation_tags"] =  addslashes( $_REQUEST["editData_evaluation_tags"]); 
				$data["evaluation_details"] =  addslashes( $_REQUEST["editData_evaluation_details"]); 
				$data["star_rating"] =  addslashes( $_REQUEST["editData_star_rating"]); 
				$data["taste_rating"] =  addslashes( $_REQUEST["editData_taste_rating"]); 
				$data["environment_rating"] =  addslashes( $_REQUEST["editData_environment_rating"]); 
				$data["service_rating"] =  addslashes( $_REQUEST["editData_service_rating"]); 
				$data["category_rating"] =  addslashes( $_REQUEST["editData_category_rating"]); 
				$data["ingredient_rating"] =  addslashes( $_REQUEST["editData_ingredient_rating"]); 
				$data["cost_performance_rating"] =  addslashes( $_REQUEST["editData_cost_performance_rating"]); 
				$data["view_count"] =  addslashes( $_REQUEST["editData_view_count"]); 
				$data["city"] =  addslashes( $_REQUEST["editData_city"]); 
				$data["store_name"] =  addslashes( $_REQUEST["editData_store_name"]); 
				$data["store_meituan_id"] =  addslashes( $_REQUEST["editData_store_meituan_id"]); 
				$data["authorization_number"] =  addslashes( $_REQUEST["editData_authorization_number"]); 
				$data["group_buying_id"] =  addslashes( $_REQUEST["editData_group_buying_id"]); 
				$data["group_buying_evaluation"] =  addslashes( $_REQUEST["editData_group_buying_evaluation"]); 
				$data["evaluation_source"] =  addslashes( $_REQUEST["editData_evaluation_source"]); 
				$data["user_nickname"] =  addslashes( $_REQUEST["editData_user_nickname"]); 
				$data["is_vip"] =  addslashes( $_REQUEST["editData_is_vip"]); 
				$data["user_level"] =  addslashes( $_REQUEST["editData_user_level"]); 
				$data["reply_status"] =  addslashes( $_REQUEST["editData_reply_status"]); 
				$data["merchant_reply_content"] =  addslashes( $_REQUEST["editData_merchant_reply_content"]); 
				$data["merchant_reply_time"] =  addslashes( $_REQUEST["editData_merchant_reply_time"]); 
				$data["building_content"] =  addslashes( $_REQUEST["editData_building_content"]); 
				$data["is_negative"] =  addslashes( $_REQUEST["editData_is_negative"]); 
				$data["evaluation_type"] =  addslashes( $_REQUEST["editData_evaluation_type"]); 
				$data["dine_way"] =  addslashes( $_REQUEST["editData_dine_way"]); 
				$data["department"] =  addslashes( $_REQUEST["editData_department"]); 
				$data["evaluation_level"] =  addslashes( $_REQUEST["editData_evaluation_level"]); 
				$data["think"] =  addslashes( $_REQUEST["editData_think"]); 
				$data["tenant_code"] =  addslashes( $_REQUEST["editData_tenant_code"]); 


	 		 $data["id"]="";


            $su = $evaluationModel->data($data)->add();

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

        	$evaluationModel = D("Evaluation");
        $editData = $evaluationModel->getById($params);
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