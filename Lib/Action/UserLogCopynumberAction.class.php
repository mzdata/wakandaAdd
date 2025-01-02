<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
//$userLogCopynumberModel = D("UserLogCopynumber"); //BASECIDE0
// |UserLogCopynumber\/queryOneMyData$
// |UserLogCopynumber\/delMyData$
// |UserLogCopynumber\/addMyData$
// |UserLogCopynumber\/updateMyData$
// |UserLogCopynumber\/queryList$
/**/

class UserLogCopynumberAction extends  Action {
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

	//UserLogCopynumber\/getActionTableName$
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

			
			

					   	$userLogCopynumberModel = D("UserLogCopynumber");
				$editData = $userLogCopynumberModel->getById($id);




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

					   	$userLogCopynumberModel = D("UserLogCopynumber");
					$sc = 	$userLogCopynumberModel->where("id='$id'")->delete();

				
					

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

					   	$userLogCopynumberModel = D("UserLogCopynumber");
				 $data = array();

					
            $su = $userLogCopynumberModel->data($data)->save();

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

					   	$userLogCopynumberModel = D("UserLogCopynumber");

 				$data = array();


					


				$su =  $userLogCopynumberModel->data($data)->add();

	
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
		
		

      

		$userLogCopynumberModel = D("UserLogCopynumber");
 

        $selectWhere = " id like '%$searchkey%' ";
		if(empty($searchkey))
		{
			$selectWhere = "1=1";
		} 


        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $userLogCopynumberModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $this->addslashesx($jsonArr["orderby"]);
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);


		$listData = $userLogCopynumberModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

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
        $idName = "tablename."."user_log_copynumber" ;
        $showTable = Util::getTFAuth($idName)
;
        $tableTitle =  Util::getTableFieldTitle($idName)
;


		$userLogCopynumberModel = D("UserLogCopynumber");
    	$tmpArr = $userLogCopynumberModel ->getDbFields()  ;
		$showFieldsArr = array();
		foreach($tmpArr as $field)
		{
			$idName =  "user_log_copynumber".".".$field;
			$showFieldsArr[$field] = Util::getTFAuth($idName)
;
		}

        $selectWhere = " id like '%$searchkey%' ";
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


			  	$selectWhere = $this->getFFSearch($FFArr ,$_REQUEST,"user_log_copynumber",$oldFFArr,$FF);


		}
		else
		{

			   $_SESSION["FFArr"] = array();
		}
		 //FF

         // if(empty($searchkey))  $selectWhere ="1=1";

        $_SESSION["selectWhere"] = $selectWhere; //供条件下载使用


        $count = $userLogCopynumberModel->where($selectWhere )->count();
        $page  = new Page($count, $pagelimit,$pageWhere);
        $page->setConfig("theme", "%nowPage%/%totalPage% 页 %upPage% %first% %linkPage% %end% %downPage%");
        $orderby = $_REQUEST["orderby"];
        if(empty( $orderby))  $orderby="id";
        $orderbyDesc = Util::getOrderDesc($p);

		$p=$_REQUEST["p"];

		$listData = $userLogCopynumberModel->where(  $selectWhere)->order("id desc")->limit($page->firstRow.','.$page->listRows)->select();

		$_SESSION["orderbyDesc"]=$orderbyDesc;


        if (isset($_SESSION["msg"])) {
            $msg = $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }

        $show = $page->show();

        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "msg"=>$msg,  "page"=>$show);


      	$tmpArr = $userLogCopynumberModel->getDbFields()  ;
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
       $idName = "tablename."."user_log_copynumber" ;
        $showTable = Util::getTFAuth($idName)
;


			if ($_REQUEST["act"] == "add") {
				header("Content-Type:text/html;charset=utf-8");

				$userLogCopynumberModel = D("UserLogCopynumber");
				$data = array();





				$su =  $userLogCopynumberModel->data($data)->add();

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
       $idName = "tablename."."user_log_copynumber" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$userLogCopynumberModel = D("UserLogCopynumber");
            $data = array();




            $su = $userLogCopynumberModel->data($data)->save();

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

        	$userLogCopynumberModel = D("UserLogCopynumber");
        $editData = $userLogCopynumberModel->getById($params);
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
         $idName = "tablename."."user_log_copynumber" ;
        $showTable = Util::getTFAuth($idName)
;

        $id                = $_REQUEST["id"];

		$userLogCopynumberModel = D("UserLogCopynumber");
        $sc = $userLogCopynumberModel->where("id='$id'")->delete();

        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }

        $this->redirect("UserLogCopynumber/index");



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

				$user_log_copynumberModel = D ( "UserLogCopynumber" );
				$tmpArr = $user_log_copynumberModel->getDbFields ();
				$authBase = Util::getTFAuthBase ();

				$fieldArr = array ();
				foreach ( $tmpArr as $field ) {
					if ($field == "_autoinc")
						break;
					if ($field == "_pk")
						break;
					$idName = "user_log_copynumber" . "." . $field;
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

							$user_log_copynumberModel->data ( $data )->save ();

							$sucessNum ++;
						} else { // insert

							$su = $user_log_copynumberModel->data ( $data )->add ();
							if ($su) {
								$sucessNum ++;
							}
						}
					} // $k>2
				} // foreach
				print "finish,sucessNum=$sucessNum <br>";
				print "<a href='../UserLogCopynumber'>返回</a>";
			}
		} else {
			print "upload error";
		}
	}


	public function copyData() {
		//是否有表权限
       $idName = "tablename."."user_log_copynumber" ;
        $showTable = Util::getTFAuth($idName)
;


        if ($_REQUEST["act"] == "edit") {
            header("Content-Type:text/html;charset=utf-8");
           	$userLogCopynumberModel = D("UserLogCopynumber");
            $data = array();


	 		 $data["id"]="";


            $su = $userLogCopynumberModel->data($data)->add();

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

        	$userLogCopynumberModel = D("UserLogCopynumber");
        $editData = $userLogCopynumberModel->getById($params);
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