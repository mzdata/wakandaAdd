<?php

		error_reporting(E_ERROR);
 session_start();
    define('THINK_PATH','./ThinkPHP');
    define('APP_NAME', 'mk');             # needs change
    define('APP_PATH', '.');
    define('NO_CACHE_RUNTIME', false);       # devlopment cache

    require(THINK_PATH.'/ThinkPHP.php');     # entry file



    $author = new AuthorizationAction();


   // $author->loginCheck();

   $ip  = $_SERVER["REMOTE_ADDR"];
    $uri = $_SERVER['REQUEST_URI'];

	$uri = preg_replace('/\?.*/','',$uri);

//print $uri;
$deArr = preg_split('/\//',$uri,-1,PREG_SPLIT_NO_EMPTY);
//print_r($deArr);
$uri=$deArr[2]."/".$deArr[3];;



//https://jzb-app-pre.jdcloud.com/jzbadd/index.php/QianpiList/outListApi
 if( preg_match(
	 '/BzhXunjian\/addBatch$|ZywItemHistory\/getMachineBase$|ZywItemHistory\/getLastMark$|ZywItemHistory\/redGroupIp$|ZywItemHistory\/redList$|QianpiList\/outMenu2_token$|QianpiList\/agetLocalQianpiApi$|Ajax\/getJsonAgentLoginJydx$|ZywItemHistory\/addMarkHistoryBatchPost$|QianpiList\/readFileApi$|QianpiHistory\/outListApi$|QianpiList\/outListApi$|QianpiList\/agentReadFileApi$|QianpiList\/folderListApi$|QianpiList\/subFloderList$|QianpiList\/agentReadFile$|'
	 .'DemoProject\/checkApplicationId$|DemoProject\/getApplicationDemoTools$|DemoProject\/getCmdResult$'
	 .'|RealItem\/addBatch$|RealItem\/getItemOps$|AlarmData\/add$|RedData\/add$'
	 .'|ItemTbl\/getCreateSqlResult$|ItemTbl\/updateAppSQL$|RealProject\/checkRealApplicationId$|ItemTbl\/getSqlResult$'
	 .'|AgentApp\/checkAgentApp$|AgentApp\/addAgentTools$|RealItem\/checkDevApp$'
	 .'|RedData\/getRedAlarm$|RedData\/clearRedAlarm$|AutoOps\/add$|MyBook\/searchData$'
	 .'|AddknowledgeProject\/checkAddApplicationId$|AddknowledgeProject\/getQueryKnowledage$'
	 .'|GprpProject\/checkGpfxApplicationId$|GprpProject\/getGpfx$|GprpProject\/updateGpfxResponse$'
	 .'|PptProject\/getPwModelByName$|TocProject\/addTocAssistant$|TocAssistant\/checkTocAssistantId$|TocProject\/addTocApp$|Movie\/searchOneRow$'
	 .'|TocProject\/checkTocApplicationId$|Movie\/addMovie$|CepingProject\/getFenlei$|CepingProject\/getFenleiList$|CepingProject\/getCeshiData$'
	 .'|CepingProject\/getCepingResponseStr$|Dining\/addDining$|Dining\/updateXX$'
	 .'|DrawStat\/drawLine$|DrawStat\/drawBar$|DrawStat\/drawPie$|BiDbSet\/drawOnePic\?'
	 .'|WxBaseinfo\/addTenant$|WxBaseinfo\/checkPhoneTenant$|WxBaseinfo\/checkUnionId$|WxStaff\/addStaff$'
	 .'/',$uri,$match))
    {

		 App::run();


    }
    else
    {
		if(OPEN_ADMIN!=null&&OPEN_ADMIN=="1"){

			//限制ip
			$ip = $_SERVER["REMOTE_ADDR"];
			if(!preg_match('/^127|^172|^192/',$ip,$match)){
				die;
			}

			$author->loginCheck();
			App::run();

		}else
		{ 
				//限制ip
			$ip = $_SERVER["REMOTE_ADDR"];
			if(!preg_match('/^127|^172|^192/',$ip,$match)){
				die;
			}

			$author->loginCheck();
			App::run();

		}
    }


