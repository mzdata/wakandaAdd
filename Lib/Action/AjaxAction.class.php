<?php

import("@.Utils.Util");
import("ORG.Util.Page");

include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';
class AjaxAction extends  Action {



	public function getUserAccessToken() {

 		header ( "Content-Type:text/html;charset=utf-8" );

		print " ";
		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,CLXX_AK,CLXX_SK);
		 //其中 openUserId 是用户唯一标识
		 $appAccessToken= $argArr["appAccessToken"];
		 $userAccessToken  = $argArr["accessToken"]; //userAccessToken

		 if(empty($appAccessToken)) {

			 $returnArr = array(
								"code"=>0,
									"msg"=>"失败",
									"data"=> "无法取得appAccessToken"
								);

					print json_encode($returnArr);
					return;
		 }
		 if(empty($userAccessToken)) {

			 $returnArr = array(
								"code"=>0,
									"msg"=>"失败",
									"data"=> "无法取得userAccessToken"
								);

					print json_encode($returnArr);
					return;
		 }

		 	 $returnArr = array(
					"code"=>0,
						"msg"=>"成功",
						"data"=>  $userAccessToken
					);

		print json_encode($returnArr);
	}

	public function getUserDeptList() {
 		header ( "Content-Type:text/html;charset=utf-8" );

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,JYDX_AK,JYDX_SK);
		 //其中 openUserId 是用户唯一标识
		 $accessToken  = $argArr["accessToken"]; //userAccessToken
		 $openUserId = $argArr["openUserId"];
		 $openTeamId = $argArr["openTeamId"];
		 $thirdUserId = $argArr["thirdUserId"];


		 if(empty($openUserId)) {
		 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getOpenUserIdAndArgs 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }
		 //获得用户部门列表


		 $retArr = Util::getUserDeptList($accessToken );

		 	 $returnArr = array(
					"code"=>0,
						"msg"=>"成功",
						"data"=>  $retArr
					);

		print json_encode($returnArr);
	}


	public function getUserContactList() {
 		header ( "Content-Type:text/html;charset=utf-8" );

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,JYDX_AK,JYDX_SK);
		 //其中 openUserId 是用户唯一标识
		 $accessToken  = $argArr["accessToken"]; //userAccessToken
		 $openUserId = $argArr["openUserId"];
		 $openTeamId = $argArr["openTeamId"];
		 $thirdUserId = $argArr["thirdUserId"];


		 if(empty($openUserId)) {
		 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getOpenUserIdAndArgs 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }
		 //获得常用联系人列表
		 $retArr = Util::getUserContactList($accessToken );

		 	 $returnArr = array(
					"code"=>0,
						"msg"=>"成功",
						"data"=>  $retArr
					);

		print json_encode($returnArr);
	}





	public function getJsonAgentLoginJydx() {
 		header ( "Content-Type:text/html;charset=utf-8" );

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,JYDX_AK,JYDX_SK);
		 //其中 openUserId 是用户唯一标识
		 $accessToken  = $argArr["accessToken"]; //userAccessToken
		 $openUserId = $argArr["openUserId"];
		 $openTeamId = $argArr["openTeamId"];
		 $thirdUserId = $argArr["thirdUserId"];


		 if(empty($openUserId)) {
		 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getOpenUserIdAndArgs 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }

		 //可能需要另外获取deptId
		$retArr = Util::getOpenUserInfo($accessToken );
		 $retCode = $retArr["code"];
		 $msg = $retArr["msg"];
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getOpenUserInfo 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }
		 $deptId = $retArr["data"]["deptId"];
		 $name = $retArr["data"]["name"];
		 $enName = $retArr["data"]["enName"];
		 $mobile = $retArr["data"]["mobile"];
		 $name = $name.$mobile;
		 //获取deptId 完毕
		 //获取  teamAccessToken



		 $retArr = Util::getTeamAccessTokenArr(  $openTeamId,JYDX_AK,JYDX_SK);
		// print_r($retArr);
		 $retCode = $retArr["code"];
		 $msg = $retArr["msg"];
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getTeamAccessTokenArr 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }
		  $teamAccessToken = $retArr["data"]["teamAccessToken"];

		 //性别,获取单个用户详情
		//  print_r( $retArr);
		 $retArr = Util::getSigleUser($teamAccessToken, $openUserId);
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getTeamAccessTokenArr 获得授权失败" ,
						"data"=>"getSigleUser 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }


		$email = $retArr["data"]["userDetail"]["email"];
		if(empty($mobile)) {
			$mobile = $retArr["data"]["userDetail"]["mobile"];
		}
		$deptId = $retArr["data"]["userDetail"]["deptId"];
		 // print "getSigleUser=";
		 // print_r( $retArr);

		  //获取部门详情
		 $retArr = Util::getDeptInfo($teamAccessToken, $deptId);
		 $deptName = $retArr["data"]["deptInfo"]["name"];

		$gender = $retArr["data"]["userDetail"]["gender"];  //1男 2 女  3未知
		$sex = 1;//性别，1男，0女,
		if($gender==2) {
			$sex=0;
		}


		 	$jydxUserModel = D("JydxUser");
			$list = $jydxUserModel->where("open_user_id='$openUserId'")->select();
			if(empty($thirdUserId)) {
				//如果没读到京智办第三方id，读本地的，尽可能有 third_id
				$thirdUserId =  $list[0]["third_id"];
			}
			$myNumber=0;
			if(count($list)>0) { 	//更新本地
				  $data = array();
				$data["id"] =  $list[0]["id"];
				$data["open_team_id"] = $openTeamId;
				$data["dept_id"] =   $deptId;
				$data["third_id"] =   $thirdUserId;
				$su = $jydxUserModel->data($data)->save();
		 		$myNumber=  $list[0]["id"];
			}
			else{ 	//插入本地
				 $data = array();
				$data["open_user_id"] =   $openUserId;
				$data["open_team_id"] =  $openTeamId;
				$data["dept_id"] =   $deptId;
				$data["third_id"] =   $thirdUserId;

				$su = $jydxUserModel->data($data)->add();
		 		$myNumber= $su;
			}




			if(empty($enName)) {
				$enName = JYDX_PREFIX.$myNumber;
			}

			$loginId=$thirdUserId;
			if(empty($loginId)) {

				$loginId = JYDX_PREFIX.$myNumber ."d".Util::randomcode(3);
			}



			if(empty($name)) {
				$name = JYDX_PREFIX.$myNumber;
			}

			$name = $name ."-".$deptName ;

			$email=$loginId."@jzbjdcloud.com";


			if(empty($mobile)) {
				$mobile = $loginId;
			}



			//把name ,enName,openUserId  third_id 送给java，换回来 loginUrl
			//JYDX_AGENT_LOGIN_URL

			$loginUrl = "loginUrl_php";
			$postUrl = JYDX_AGENT_LOGIN_URL;
			$postArr = array(
			"name"=>$name,
			"enName"=>$enName,
			"loginId"=>$loginId,
			"openUserId"=>$openUserId,
			"thirdUserId"=>$thirdUserId,
			"deptId"=>$deptId,
				"openTeamId"=>$openTeamId,
				"sex"=>$sex,
				"email"=>$email,
				"mobile"=>$mobile

			);
			$postJsonStr = json_encode($postArr);

			//获取java返回来的数据
		//	print "postJsonStr=".$postJsonStr."\n";
			$ret = Util::sendPostData($postUrl,$postJsonStr,"");
		//	print "ret=".$ret;


			$retArr = json_decode($ret,true);
			$success = $retArr["success"];
			$message = $retArr["message"];
			$loginUrl = $retArr["data"];
			if(!$success) {
					 $returnArr = array(
					"code"=>1,
						"msg"=>$message ,
						"data"=>$loginUrl
					);

					print json_encode($returnArr);
					die;
			}



		 	 $returnArr = array(
					"code"=>0,
						"msg"=>"成功",
			//	 		"postJsonStr"=>$postJsonStr,
						"data"=>"$loginUrl"
					);

		print json_encode($returnArr);
	}




	public function getJsonAgentLogin() {
		header ( "Content-Type:text/html;charset=utf-8" );
 		header ( "Content-Type:text/html;charset=utf-8" );

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,CLXX_AK,CLXX_SK);
		 //其中 openUserId 是用户唯一标识
		 $accessToken  = $argArr["accessToken"]; //userAccessToken
		 $openUserId = $argArr["openUserId"];
		 $openTeamId = $argArr["openTeamId"];
		 $thirdUserId = $argArr["thirdUserId"];


		 if(empty($openUserId)) {
		 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getOpenUserIdAndArgs 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }

		 //可能需要另外获取deptId
		$retArr = Util::getOpenUserInfo($accessToken );
		 $retCode = $retArr["code"];
		 $msg = $retArr["msg"];
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getOpenUserInfo 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }
		 $deptId = $retArr["data"]["deptId"];
		 $name = $retArr["data"]["name"];
		 $enName = $retArr["data"]["enName"];
		 //获取deptId 完毕
		 //获取  teamAccessToken



		 $retArr = Util::getTeamAccessTokenArr(  $openTeamId,CLXX_AK,CLXX_SK);
		// print_r($retArr);
		 $retCode = $retArr["code"];
		 $msg = $retArr["msg"];
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getTeamAccessTokenArr 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }
		  $teamAccessToken = $retArr["data"]["teamAccessToken"];
		 //性别,获取单个用户详情
		//  print_r( $retArr);
		 $retArr = Util::getSigleUser($teamAccessToken, $openUserId);
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"getTeamAccessTokenArr 获得授权失败" ,
						"data"=>"getSigleUser 获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }


		$email = $retArr["data"]["userDetail"]["email"];
		$mobile = $retArr["data"]["userDetail"]["mobile"];
		 // print "getSigleUser=";
		 // print_r( $retArr);

		$gender = $retArr["data"]["userDetail"]["gender"];  //1男 2 女  3未知
		$sex = 1;//性别，1男，0女,
		if($gender==2) {
			$sex=0;
		}


		 	$jydxUserModel = D("JydxUser");
			$list = $jydxUserModel->where("open_user_id='$openUserId'")->select();
			if(empty($thirdUserId)) {
				//如果没读到京智办第三方id，读本地的，尽可能有 third_id
				$thirdUserId =  $list[0]["third_id"];
			}
			$myNumber=0;
			if(count($list)>0) { 	//更新本地
				  $data = array();
				$data["id"] =  $list[0]["id"];
				$data["open_team_id"] = $openTeamId;
				$data["dept_id"] =   $deptId;
				$data["third_id"] =   $thirdUserId;
				$su = $jydxUserModel->data($data)->save();
		 		$myNumber=  $list[0]["id"];
			}
			else{ 	//插入本地
				 $data = array();
				$data["open_user_id"] =   $openUserId;
				$data["open_team_id"] =  $openTeamId;
				$data["dept_id"] =   $deptId;
				$data["third_id"] =   $thirdUserId;

				$su = $jydxUserModel->data($data)->add();
		 		$myNumber= $su;
			}


			if(empty($name)) {
				$name = JYDX_PREFIX.$myNumber;
			}

			if(empty($enName)) {
				$enName = JYDX_PREFIX.$myNumber;
			}

			$loginId=$thirdUserId;
			if(empty($loginId)) {

				$loginId = JYDX_PREFIX.$myNumber ."d".Util::randomcode(3);
			}



			$email=$loginId."@jzbjdcloud.com";



			$mobile = $loginId;



			//把name ,enName,openUserId  third_id 送给java，换回来 loginUrl
			//JYDX_AGENT_LOGIN_URL

			$loginUrl = "loginUrl_php";
			$postUrl = JYDX_AGENT_LOGIN_URL;
			$postArr = array(
			"name"=>$name,
			"enName"=>$enName,
			"loginId"=>$loginId,
			"openUserId"=>$openUserId,
			"thirdUserId"=>$thirdUserId,
			"deptId"=>$deptId,
				"openTeamId"=>$openTeamId,
				"sex"=>$sex,
				"email"=>$email,
				"mobile"=>$mobile

			);
			$postJsonStr = json_encode($postArr);

			//获取java返回来的数据
			print "postJsonStr=".$postJsonStr."\n";
			$ret = Util::sendPostData($postUrl,$postJsonStr,"");
			print "ret=".$ret;


			$retArr = json_decode($ret,true);
			$success = $retArr["success"];
			$message = $retArr["message"];
			$loginUrl = $retArr["data"];
			if(!$success) {
					 $returnArr = array(
					"code"=>1,
						"msg"=>$message ,
						"data"=>$loginUrl
					);

					print json_encode($returnArr);
					die;
			}



		 	 $returnArr = array(
					"code"=>0,
						"msg"=>"成功",
				 		"postJsonStr"=>$postJsonStr,
						"data"=>"$loginUrl"
					);

		print json_encode($returnArr);
	}
	function  uuid()
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr ( $chars, 0, 8 ) . '-'
            . substr ( $chars, 8, 4 ) . '-'
            . substr ( $chars, 12, 4 ) . '-'
            . substr ( $chars, 16, 4 ) . '-'
            . substr ( $chars, 20, 12 );
    return $uuid ;
}

	public function getJsonSendMe() {
		header ( "Content-Type:text/html;charset=utf-8" );

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,CLXX_AK,CLXX_SK);
		 //其中 openUserId 是用户唯一标识
		 $accessToken  = $argArr["accessToken"];
		 $openUserId = $argArr["openUserId"];
		 $openTeamId = $argArr["openTeamId"];

		 //可能需要另外获取deptId
		$retArr = Util::getOpenUserInfo($accessToken );
		 $retCode = $retArr["code"];
		 $msg = $retArr["msg"];
		 if( $retCode!=0) {
			 		 $returnArr = array(
					"code"=>1,
						"msg"=>"获得授权失败"
					);

					print json_encode($returnArr);
					die;
		 }
		 $deptId = $retArr["data"]["deptId"];
		 //获取deptId 完毕

		//print " user_info deptId=".$deptId."\n";

 		$time = microtime(1);
		 $title = "测试卡片标题".$time;
		 $content = "测试消息卡片的内容".$time;
		 /*
$bodyStr=<<<STR
{
	"deepLink":"http://www.baidu.com",
    "content": "${content}",
    "extend": {"pic":"https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png"},
    "imgUrl": "https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png",
    "title": "${title}",
    "isClick": "0",
    "tos": {
       "users": [
          {
             "openTeamId": "${openTeamId}" ,
             "openUserId": "${openUserId}"
          }
       ],
       "depts": [
          {
             "openTeamId": "${openTeamId}" ,
             "deptId": "${deptId}"
          }
       ],
      "app":""
    },
  "appParams":{
      "minVersion":"000.000.000.000" ,
      "mobileHomeUrl":"",
      "pcHomeUrl":""
  }
}
STR; */

$uuid = $this->uuid();

$bodyStr=<<<STR
{
	 "extend": {"pic":"https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png"},


    "imgUrl": "https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png",
    "isClick":"1",
    "infox":{
    },
    "client":"",
    "toTerminal":"7",
    "tos":{
        "users":[
             {
           "openTeamId": "${openTeamId}" ,
             "openUserId": "${openUserId}"
      }
        ],

        "app":"gwork"
    },
       "title": "${title}",
    "appParams":{
        "minVersion":"000.000.000.000",
   "mobileHomeUrl":"https://jzb-app-pre.jdcloud.com/jzbadd/index.php/WeatherData/bjTele",
"pcHomeUrl":"https://jzb-app-pre.jdcloud.com/jzbadd/index.php/WeatherData/bjPc"
    },
    "content":"${content}"
}
STR;


		$teamAccessToken=  Util::getTeamAccessToken($openTeamId,CLXX_AK,CLXX_SK);



		$retArr=array();

	//	$retArr["code"]=$code;
	//	$retArr["openUserId"]=$openUserId;
	//	$retArr["openTeamId"]=$openTeamId;
	//	$retArr["deptId"]=$deptId;
	//	$retArr["teamAccessToken"]=$teamAccessToken;

//json

		 $url = TOKENBASE_URL."/open-api/message/v1/send";
		$post = $bodyStr;
		$addHeaderArr = array("Authorization"=>"Bearer ".$teamAccessToken);
		$retStr = Util::getHttpsHeaderRet($url,$post ,$addHeaderArr); //addHeaderArr k=>v 形式

		print "bodyStr=$bodyStr";
		print "retStr=".$retStr;
		$retArr = json_decode($retStr,true);

		print "\n\n";

		 	 $returnArr = array(
					"code"=>0,
						"msg"=>"成功",
						"data"=>$retArr
					);

		print json_encode($returnArr);

	}

		public function getJsonDeleteMe() {
		header ( "Content-Type:text/html;charset=utf-8" );

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,CLXX_AK,CLXX_SK);
		 //其中openUserId是用户唯一标识
		 //其中test是用户送来的参数

		 //根据送来的参数，计算真正需要返回的数据


		print json_encode($retArr);

	}





	public function getJsonListMe() {
		header ( "Content-Type:text/html;charset=utf-8" );

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,CLXX_AK,CLXX_SK);
		 //其中 openUserId 是用户唯一标识
		 //其中test是用户送来的参数

		 //根据送来的参数，计算真正需要返回的数据
			$creator =	 $argArr["openUserId"];
				$cpxxPlateModel = D("CpxxPlate");

				$list = $cpxxPlateModel->where("creator='$creator'")->select();


				$date = date("Y-m-d",time());
				$cpxxHolidayModel = D("CpxxHoliday");
				$cpxxLimitModel = D("CpxxLimit");
				$editData = $cpxxLimitModel->where("limit_day='$date'")->select();
				$limit_last = $editData[0]["limit_last"];// varchar(255) 限行尾号  7|9 如果为空表示不限行
				$weekday  = $editData[0]["weekday"];//  varchar(255) 星期几

				$lastShow = "不限行";
				$needLast = 0;
				$limitArr = array();
				if(!empty($limit_last)) {
					$limitArr = preg_split('/\|/',$limit_last,-1,PREG_SPLIT_NO_EMPTY);
					if(count($limitArr)>=2)  {
						$exist =  $cpxxHolidayModel->where("holiday='$date'")->count();
						if($exist==0) {
							$needLast = 1;
							$lastShow = str_replace("|","和",$limit_last);
						}
					}
				}

			    $dataArr = Util::getLimitByDate($date);



				$retArr = array();
				$retArr["date"]=$date;
				foreach($list as $row) {
					//plate  varchar(255)  用户车牌号
					$plate = $row["plate"];
					$plate_type = $row["plate_type"];
					if($needLast==1) {

						//判断是京牌，还是外地牌
						$first = mb_substr( $plate, 0, 1 );
						$last = substr($plate,strlen($plate)-1,1);
						//print " $plate =$first,$last\n";
						if($first=="京" && in_array($last,$limitArr)) {
							//京牌限行
							if($plate_type==2) {
								//京牌公务车
									$retArr["plate"][$plate]="京牌公务车限行：".$dataArr["gwLimit"];
							}else if($plate_type==3) {
								//京牌新能源
									$retArr["plate"][$plate]="京牌新能源不限行";
							}else
							{

									$retArr["plate"][$plate]="京牌限行：".$dataArr["bjLimit"];
							}

						}
						else if( in_array($last,$limitArr)){
							//外埠牌限行

							if($plate_type==1) {
								//外埠客车
									$retArr["plate"][$plate]="外埠客车牌限行：".$dataArr["outCustomerLimit"];
							}else
							{

									$retArr["plate"][$plate]="外埠牌限行：".$dataArr["outLittleLimit"];
							}
						}
						else {//不限行
							$retArr["plate"][$plate]="不限行";

						}


					}else
					{ //不限行
						$retArr[$plate]="不限行";
					}

				}


		 	 $returnArr = array(
					"code"=>0,
						"msg"=>"成功",
						"data"=>$retArr
					);

		print json_encode($returnArr);

	}
		public function getJsonAddMe() {
		header ( "Content-Type:text/html;charset=utf-8" );


		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,CLXX_AK,CLXX_SK);
		 //其中openUserId是用户唯一标识
		 //其中test是用户送来的参数

		 //根据送来的参数，计算真正需要返回的数据


		//print json_encode($retArr);

			$cpxxPlateModel = D("CpxxPlate");
				$data = array();

				$creator= $argArr["openUserId"]; //单点登录获得


				$data["plate"] =  addslashes( $argArr["addData_plate"]);
				$data["plate_type"] =  addslashes(   $argArr["addData_plate_type"]);
				$data["mark_flag"] =  addslashes(   $argArr["addData_mark_flag"]);
				$data["mark_way"] =   addslashes(  $argArr["addData_mark_way"]);
				$data["creator"] = $creator;
				$data["created_time"] =  date("Y-m-d H:i:s");

				$plate =  $data["plate"];

				$count =  $cpxxPlateModel->where("creator='$creator' ")->count();
				if($count>5) {

						$retArr = array(
						"code"=>1,
							"msg"=>"添加失败，您的车牌添加太多了",
							"data"=>null
						);

						print json_encode($retArr);
					return;
				}
				$count =  $cpxxPlateModel->where("creator='$creator' and plate='$plate'")->count();
				if($count>0) {

						$retArr = array(
						"code"=>1,
							"msg"=>"添加失败，您的车牌".$plate."已存在",
							"data"=>null
						);

						print json_encode($retArr);
					return;
				}

				$su =  $cpxxPlateModel->data($data)->add();



				if ($su) {
					$retArr = array(
					"code"=>0,
						"msg"=>"添加成功",
						"data"=>null
					);
				} else {
					$retArr = array(
					"code"=>1,
						"msg"=>"添加失败",
						"data"=>null
					);
				}




				print json_encode($retArr);

	}

	public function getJsonExTest() {

		$code= $_REQUEST["code"];
		$jsonStr= $_REQUEST["jsonStr"];
		 $argArr = Util::getOpenUserIdAndArgs($code,$jsonStr,CLXX_AK,CLXX_SK);
		 //其中openUserId是用户唯一标识
		 //其中test是用户送来的参数

		 //根据送来的参数，计算真正需要返回的数据


		print json_encode($retArr);

	}
	public function getThirdAccessToken() {

		$code= $_REQUEST["code"];
		 $appAccessToken = Util::getThirdAppAccessToken(CLXX_AK,CLXX_SK);
		 $url = TOKENBASE_URL."/open-api/auth/v1/access_token";
		$postArr = array(
		"appAccessToken"=>$appAccessToken,
		"code"=>$code,
		);
		$post = json_encode($postArr);
	 	$ret = Util::getHttpsRet($url,$post);
		$retArr=json_decode($ret,true);
		//print_r($retArr);
		$openUserId = $retArr["data"]["openUserId"];

		$openUserIdShow = substr($openUserId,0,3)."****";
		if(strlen($openUserId)>5) {
			print "success openUserIdShow=".$openUserIdShow;
		}else {
			print "fail";
		}
	}

	public function updateData()
	{

		header ( "Content-Type:text/html;charset=utf-8" );
		 date_default_timezone_set('PRC');

		$tblname = "screen_".date("Ym",time());
		$screenModel = D ( $tblname );

		$domainModel=D("domain_set");
		$dbModel=D("db_set");

		$dataArr = array();
		 if( ENV=="DEV")
		{

					$lineArr = array();
					$sortArr = array();
					for($i=0;$i<3;$i++)
					{
						$lineArr["test$i.jd.com"]=$this->getTestLine();
						$sortArr["test$i.jd.com"] = $lineArr["test$i.jd.com"]["error_percent"];
					}
					arsort($sortArr);
					$getArr = array();
					foreach($sortArr as $domain=>$v)
					{
						$getArr [$domain]=$lineArr[$domain];
					}
					$dataArr["product_line"]=$getArr;
		}
		else
		{

			$listData = $screenModel->where ( "type=1 and created_at > now() -  interval 5 MINUTE" )->order ( "id desc" )->limit ( 1 )->select ();

			$screenArr = json_decode($listData[0]["screen_data"],true);

			foreach($screenArr as $domain => $domainArr)
			{
				$error_percent = $domainArr["error_percent"];
				//,"alarm_limit"=>$alarm_limit,"big_limit"=>$big_limit,"show_color"=>$show_color);
				$alarmArr = $domainModel->where ( "domain_name='$domain'" )->select ();



				$alarm_limit = $alarmArr[0]["alarm_limit"];if(empty($alarm_limit))$alarm_limit=10;
				$big_limit = $alarmArr[0]["big_limit"];if(empty($big_limit))$big_limit=20;
				$show_color="green";
				if($error_percent*100>$alarm_limit) 	$show_color="yellow";
				if($error_percent*100>$big_limit) 	$show_color="red";
				$screenArr[$domain]["alarm_limit"]=$alarm_limit;
				$screenArr[$domain]["big_limit"]=$big_limit;
				$screenArr[$domain]["show_color"]=$show_color;



			}
			$dataArr["product_line"]=$screenArr;
		}


		$listData = $screenModel->where ( "type=2 and created_at > now() -  interval 5 MINUTE" )->order ( "id desc" )->limit ( 1 )->select ();



		if(empty(	$listData) && ENV=="DEV")
		{
			$ret=Util::vcurl("http://127.0.0.1/serviceview/interface/checkMiddlewareIpPort.php");
			//print $ret;

		}
		else
		{

			$middlewareArr = json_decode($listData[0]["screen_data"],true);
			$dataArr["middleware"]= $middlewareArr;
		}


		if( ENV=="DEV")
		{

				$dataArr["database"]["tcp_connect"]=array(  ####tcp连接100次中间件，连不上2次就yellow，5次就red
						   "product1_db"=>array("total"=>10,"error"=>5,"error_percent"=>0.1,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"red"),
						   "product2_db"=>array("total "=>10,"error"=>0,"error_percent"=>0.0,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"green"),
						   "product3_db"=>array("total "=>10,"error"=>0,"error_percent"=>0.0,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"green"),
				   );

				$dataArr["database"]["slow_query"]=array(
						   "product2_db"=>array( "error"=>5,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"red"),
						   "product1_db"=>array( "error"=>2,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"yellow"),
						   "product3_db"=>array( "error"=>1,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"green"),

				   );
				$dataArr["database"]["db_error"]=array(
						   "product1_db"=>array( "error"=>5,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"red"),
						   "product2_db"=>array( "error"=>2,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"yellow"),
						   "product3_db"=>array( "error"=>1,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"green"),

				   );


				$dataArr["database"]["db_other"]=array(
						   "product1_db"=>array( "error"=>5,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"red"),
						   "product2_db"=>array( "error"=>2,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"yellow"),
						   "product3_db"=>array( "error"=>1,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"green"),

				   );

		}
		else
		{
			//查出最近的 31 32 33 34 type的数据
			$listData = $screenModel->where ( "type=31 and created_at > now() -  interval 5 MINUTE" )->order ( "id desc" )->limit ( 1 )->select ();
			$tmpArr = json_decode($listData[0]["screen_data"],true);
			$dataArr["database"]["tcp_connect"]= $tmpArr;


			$listData = $screenModel->where ( "type=32 and created_at > now() -  interval 5 MINUTE" )->order ( "id desc" )->select ();

			$dataArr["database"]["slow_query"]= $this->departAlarm( $listData, $dbModel);


			$listData = $screenModel->where ( "type=33 and created_at > now() -  interval 5 MINUTE" )->order ( "id desc" )->select ();

			$dataArr["database"]["db_error"]= $this->departAlarm( $listData, $dbModel);


			$listData = $screenModel->where ( "type=34 and created_at > now() -  interval 5 MINUTE" )->order ( "id desc" )->select ();

			$dataArr["database"]["db_other"]= $this->departAlarm( $listData, $dbModel);

			//处理 slow_query db_error  db_other  limit 和color



		}

	//	print_r(	$dataArr["database"]);



 		   foreach($dataArr["database"]["tcp_connect"] as $db =>$dbArr)
		   {
				  $color = $dbArr["show_color"];
				  $error = $dbArr["error"];
				  if(!isset($dataArr["database"]["show_color"][$db]["show_color"]))
				   {
					  $dataArr["database"]["show_color"][$db]["show_color"]= $color;
					  $dataArr["database"]["show_color"][$db]["error"]= "";
				   }
				  if($color=="red"){
					  $dataArr["database"]["show_color"][$db]["show_color"]="red";
					  $dataArr["database"]["show_color"][$db]["error"]= "tcp_connect:".$error ;
				  }
				  if($color=="yellow" &&  $dataArr["database"]["show_color"][$db]["show_color"]=="green")
				 {
					  $dataArr["database"]["show_color"][$db]["show_color"]="yellow";
					  $dataArr["database"]["show_color"][$db]["error"]= "tcp_connect:".$error ;
				  }

		   }
		      foreach($dataArr["database"]["slow_query"] as $db =>$dbArr)
		   {
			     $color = $dbArr["show_color"];
				  $error = $dbArr["error"];
				  if(!isset($dataArr["database"]["show_color"][$db]["show_color"]))
				   {
					  $dataArr["database"]["show_color"][$db]["show_color"]= $color;
					  $dataArr["database"]["show_color"][$db]["error"]= "";
				   }
				  if($color=="red"){
					  $dataArr["database"]["show_color"][$db]["show_color"]="red";
					  $dataArr["database"]["show_color"][$db]["error"]= "slow_query:".$error ;
				  }
				  if($color=="yellow" &&  $dataArr["database"]["show_color"][$db]["show_color"]=="green")
				 {
					  $dataArr["database"]["show_color"][$db]["show_color"]="yellow";
					  $dataArr["database"]["show_color"][$db]["error"]= "slow_query:".$error ;
				  }

		   }
		      foreach($dataArr["database"]["db_error"] as $db =>$dbArr)
		   {
				 $color = $dbArr["show_color"];
				  $error = $dbArr["error"];
				  if(!isset($dataArr["database"]["show_color"][$db]["show_color"]))
				   {
					  $dataArr["database"]["show_color"][$db]["show_color"]= $color;
					  $dataArr["database"]["show_color"][$db]["error"]= "";
				   }
				  if($color=="red"){
					  $dataArr["database"]["show_color"][$db]["show_color"]="red";
					  $dataArr["database"]["show_color"][$db]["error"]="db_error:".$error ;
				  }
				  if($color=="yellow" &&  $dataArr["database"]["show_color"][$db]["show_color"]=="green")
				 {
					  $dataArr["database"]["show_color"][$db]["show_color"]="yellow";
					  $dataArr["database"]["show_color"][$db]["error"] ="db_error:".$error ;
				  }
		   }



		      foreach($dataArr["database"]["db_other"] as $db =>$dbArr)
		   {
				 $color = $dbArr["show_color"];
				  $error = $dbArr["error"];
				  if(!isset($dataArr["database"]["show_color"][$db]["show_color"]))
				   {
					  $dataArr["database"]["show_color"][$db]["show_color"]= $color;
					  $dataArr["database"]["show_color"][$db]["error"]= "";
				   }
				  if($color=="red"){
					  $dataArr["database"]["show_color"][$db]["show_color"]="red";
					  $dataArr["database"]["show_color"][$db]["error"]="db_error:".$error ;
				  }
				  if($color=="yellow" &&  $dataArr["database"]["show_color"][$db]["show_color"]=="green")
				 {
					  $dataArr["database"]["show_color"][$db]["show_color"]="yellow";
					  $dataArr["database"]["show_color"][$db]["error"] ="db_error:".$error ;
				  }
		   }

		$dataArr["showtime"] = date("Y-m-d  H:i:s");


		$str = json_encode($dataArr, JSON_UNESCAPED_UNICODE);
		print $str;

	}

	public function departAlarm($listArr, $dbModel)
	{
		$retArr = array();
		foreach($listArr as $row)
		{
			$screen_data = $row["screen_data"];
			$tmpArr = json_decode($screen_data,true);
			$ware_name=$tmpArr["ware_name"];
			$error_type=$tmpArr["error_type"];
			$error_data=$tmpArr["error_data"];
			if(!isset($retArr[$ware_name]))
			{// "product2_db"=>array( "error"=>5,"alarm_limit"=>1,"big_limit"=>2, "show_color"=>"red"),
				$retArr[$ware_name]["error"]=$error_data;
				 $alarmArr = $dbModel->where ( "type=$error_type and ware_name='$ware_name'" )->select ();



				$alarm_limit = $alarmArr[0]["alarm_limit"];if(empty($alarm_limit))$alarm_limit=10;
				$big_limit = $alarmArr[0]["big_limit"];if(empty($big_limit))$big_limit=20;
				$show_color="green";
				if($error_data>$alarm_limit) 	$show_color="yellow";
				if($error_data>$big_limit) 	$show_color="red";
				$retArr[$ware_name]["alarm_limit"]=$alarm_limit;
				$retArr[$ware_name]["big_limit"]=$big_limit;
				$retArr[$ware_name]["show_color"]=$show_color;
			}
		}

		return $retArr;
	}

	public function getTestLine()
	{
		$lineArr = array();
		$total = rand(800,1000);
		$n4xx = rand(1,30);
		$n5xx = rand(1,30);
		$n4xx_percent=$n4xx/$total; $n4xx_percent = sprintf("%.2f",$n4xx_percent);
		$n5xx_percent=$n5xx/$total; $n5xx_percent = sprintf("%.2f",$n5xx_percent);
		$error_percent=($n4xx+$n5xx)/$total; $error_percent = sprintf("%.2f",$error_percent);



		$alarm_limit = 2;
		$big_limit =5;
		$show_color = "green";
		if($error_percent*100>$alarm_limit) $show_color="yellow";
		if($error_percent*100>$big_limit) $show_color="red";

		return array( "total"=>$total,"4xx"=>$n4xx,"5xx"=>$n5xx,"5xx_percent"=>$n5xx_percent,"4xx_percent"=>$n4xx_percent ,"error_percent"=>$error_percent ,"alarm_limit"=>$alarm_limit,"big_limit"=>$big_limit,"show_color"=>$show_color);

	}

	public function getProductLineConf()
	{

		header ( "Content-Type:text/html;charset=utf-8" );
		$product_line= $_REQUEST["product_line"];
		$productLineConfModel = D("ProductLineConf");
		$listData = $productLineConfModel->where(  "product_line_id=$product_line")->select();
	//	print_r($productLineConfModel);
		foreach($listData as $line)
		{
			$id=$line["id"];
			$conf_name=$line["conf_name"];
			print "$id|$conf_name\n";
		}

	}


		public function getProductLineConfDetail()
	{

		header ( "Content-Type:text/html;charset=utf-8" );
		$product_line_conf_id= $_REQUEST["product_line_conf_id"];
		$productLineConfModel = D("ProductLineConf");
		$listData = $productLineConfModel->where(  "id=$product_line_conf_id")->select();

		//print_r($productLineConfModel);

		foreach($listData as $line)
		{
			$conf_text=$line["conf_text"];
			print "$conf_text";
		}

	}
}