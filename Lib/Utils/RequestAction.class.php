<?php

include_once 'Conf/enum_config.php';
include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';

import("@.Utils.Util");
import("ORG.Util.Page");
import("@.Caller.Caller");
define("PAGE_LIMIT", 20);

class RequestAction extends Action {
   
    function _initialize() {
       
    }
    
    public function autoStartForm() {
        $taskId      = $_REQUEST["task_id"];
        $orderDataId = $_REQUEST["order_data_id"];
		
        $tasksModel           = D("tasks");
        $workflowDefinesModel = D("WorkflowDefines");
        
        $taskinfo = $tasksModel->getByid($taskId);
	    $workflowDefine = $workflowDefinesModel->relation(true)->getByid($taskinfo["workflow_define_id"]); 
        $orderDataModel = D($workflowDefine["bind_order"]["order_model_name"]);
        //取得所有需要编辑的数据
        $orderData = $orderDataModel->getByid($orderDataId);
        $info = unserialize($orderData["info"]);  
        //发送 autoStartForm
        /* * "request" => $request,
 * "username" => $username,
 * "workflow_id" => $workflow_id,*/
        $request = $info;
        $username = $_SESSION["name"];
        $workflow_id = $workflowDefine["id"];
        $c = new Caller();
        $c->autoStartForm($request, $username, $workflow_id);
    }
    
     
    private function get_user_by_role($role_id) {
        $arr_user = array();
        $userplayroleModel = D("UserPlayRoles");
        $list = $userplayroleModel->where("role_id=" . $role_id . "  ")->select();
        
        $user = D("User");
        for ($i = 0; $i < count($list); $i++) {
            $info = $user->getbyid($list[$i]["user_id"]);
            if ($info["status_flag"] == 0)
                $arr_user[$list[$i]["user_id"]] = $info["zh_name"];
        }
        return $arr_user;
    }
    
    
    private function init_default_value($info, $dataModel) {
        $arr_fields = init_form_fields($dataModel);
        foreach ($arr_fields as $title) {
            $arr[$title] = get_enum_arr($title);
        }
        
        if (!isset($info) || $info == NULL) {
            return $arr;
        }
        
        # 依次查出默认值 有数据的时候 $info里面有所有的字段名，这样以后很多表单可以不加那个init_form_fields，除非需要在新单的时候初始化某些固定的东西,例如os类型
        foreach ($info as $title => $value) {
            $countv       = count($arr[$title]);
            $countdefault = count($info[$title]);
            $arr[$title."_is_array"] = is_array($info[$title]);
            for ($j = 0; $j < $countdefault; $j++) {
                $arr["default_value"][$j][$title . "_value"] = $info[$title][$j];
            }
            
            if ($countv == 0) {
                for ($j = 0; $j < $countdefault; $j++) {
                    $arr["default_value"][$j][$title] = $info[$title][$j];
                }
                continue;
            }
            //is_array 
            
            for ($i = 0; $i < $countv; $i++) {
                $v = $arr[$title][$i];
                for ($j = 0; $j < $countdefault; $j++) {
                    $arr["default_value"][$j][$title] .= "<option value='".$v."' ";
                    if (strlen($info[$title][$j]) > 0 && $info[$title][$j] == $v) {
                        $arr["default_value"][$j][$title] .= " selected ";
                    }
                    $arr["default_value"][$j][$title] .= " >".$v."</option>";
                }
            }
        }   
        return $arr;
    }
    
    public function edit() {
        $taskId      = $_REQUEST["task_id"];
        $orderDataId = $_REQUEST["order_data_id"];
       
        if ($_REQUEST["act"] == "save") {
        	$tasksModel           = D("tasks");
          	$workflowDefinesModel = D("WorkflowDefines");
          	$taskinfo = $tasksModel->getByid($taskId);
	        $workflowDefine = $workflowDefinesModel->relation(true)->getByid($taskinfo["workflow_define_id"]); 
	        
	        $notify_ids = $_REQUEST["notify_ids"];
	        
	        $DATA_PREFIX      = $workflowDefine["bind_order"]["order_short_name"];
	        $ORDER_DATA_MODEL = $workflowDefine["bind_order"]["order_model_name"];
	        $ORDER_FLOW_NAME  = $workflowDefine["bind_order"]["order_name"];  
            
            //任务入库,放到 ORDER_DATA_MODEL.表中     		 
            $orderDataModel = D($ORDER_DATA_MODEL);
            $data["info"] = serialize($_REQUEST);
            $data["updated_at"] = date("Y-m-d H:i:s");
            $sc = $orderDataModel->where("id=$orderDataId")->data($data)->save();
            if ($sc) {
                $_SESSION["msg"] = array("msg"=>"发送成功", "flag"=>1);
            } else {
                $_SESSION["msg"] = array("msg"=>"发送失败", "flag"=>2);
            }
            
            if ($_REQUEST["end_flow_flag"] == 0) {
                if ($sc) {
                    $_SESSION["msg"] = array("msg"=>"保存成功", "flag"=>1);
                } else {
                    $_SESSION["msg"] = array("msg"=>"保存失败", "flag"=>2);
                }
            }
            unset($data);
            
            $workflowDefinesModel = D("WorkflowDefines");
           
            $workflowDefineId = $taskinfo["workflow_define_id"];  
            
            $flow_arr    = $workflowDefinesModel->getByid($workflowDefineId);
            $flow_define = $flow_arr["flow_define"];
           
            $workflowDefine = unserialize($flow_define); # define
            $workflowWork   = unserialize($flow_define); # task workflow
            
            //清空工作流
            $this->clearWorkFlow($workflowWork);
            
            if ($_REQUEST["end_flow_flag"]==1) {
            	//初始化发起人
            	$this->setWorkFlow( $workflowWork, 0,$workflowDefine[0]["role_id"], $_SESSION["user_id"], 1); 		
            
            }
            
            $data = array();
            $data["id"] = $taskId;
            $data["updated_at"]         = date("Y-m-d H:i:s");
            $data["workflow_define_id"] = $workflowDefineId;
            $data["order_data_id"]      = $orderDataId;
            
            $data["workflow"]        = serialize($workflowWork);
            $data["workflow_define"] = $flow_define;
            $data["now_role_id"]     = $workflowDefine[1]["role_id"];     // 到达下一个节点
            //now_role_cursor
            if($_REQUEST["end_flow_flag"]==1) {
            	 $data["now_role_id"] = $workflowDefine[1]["role_id"];
            	 $data["now_role_cursor"] = 1;                            // 到达下一个节点
             } else {//暂存待办
             	 $data["now_role_cursor"] = 0;
             } 
            $now_role_type = $workflowDefine[1]["role_type"];
            //$now_user_id
            $now_role_id = $workflowDefine[1]["role_id"];
            $user_list = $this->get_user_by_role($now_role_id);
            
            $tmpuserid_arr = array();
            foreach ($user_list as $user_id=>$user_name) {
                $tmpuserid_arr[] = $user_id;
            }
            
            $now_user_id = implode("#", $tmpuserid_arr);
            
            $nextExecPerson = $_REQUEST["next_exec_peron"];  
  			if (isset($nextExecPerson) && $nextExecPerson > 0) {
                $now_user_id = $nextExecPerson;
  			}
  			 
            if ($_REQUEST["end_flow_flag"]==0) {
                $now_user_id=$_SESSION["user_id"];
            }
            
            $str_notify_id = "";
            foreach ($notify_ids as $key=>$notify_id) {
                if($key == 0){
                    $str_notify_id = $notify_id;
                } else {
                    $str_notify_id .= "#".$notify_id;
                }
            }
            
            $data["now_user_id"]   = $now_user_id;
            $data["end_flow_flag"] = $_REQUEST["end_flow_flag"];       # 0:未提交 1：已提交 2:流程结束
            $data["status_flag"]   = 0;                                 # 0:启用 2：删除  
            $data["notify_user_ids"] = $str_notify_id;
            if ($_REQUEST["end_flow_flag"] == 0) {
                $data["status_flag"] = 1;  #保存待发
            }
            
            $tasksModel->data($data)->save();
            
            if ($_REQUEST["end_flow_flag"] == 0) {
                $_SESSION["msg"] = array("msg"=>"保存成功", "flag"=>1);
            } else {
                $this->addStart($taskinfo["task_no"], $_REQUEST);
                
                Util::addTaskLog($taskinfo["id"], $data["task_name"], $workflowDefine[0]["role_id"], 1, "编辑后重新发送申请"); //task_log 1：同意  2：回退   3：终止    4：暂存待办
				$taskinfo = $tasksModel->getByid($taskId);
                
				$c = new Caller();
              	$success = $c->start($taskinfo["id"], $taskinfo, $_REQUEST);
              	if ($success["RESULT"] == 0) {
              		$_SESSION["msg"] = array("msg"=>"申请成功", "flag"=>1);
              	} else {
              		$_SESSION["msg"] = array("msg"=>"申请失败，".$success["ERROR_MESSAGE"], "flag"=>2);
              	}
            }
            unset($data);
            
            $this->redirect("Index/index");
        } else {
            $userModel            = D("User");
            $tasksModel           = D("tasks");                  // 实例化IdcInfos对象
            $userPlayRolesModel   = D("UserPlayRoles");
            $workflowDefinesModel = D("WorkflowDefines");
            $announceDefinesModel = D("AnnounceDefines"); 
            
            $taskinfo = $tasksModel->getByid($taskId);
            
            $workflowDefineId = $taskinfo["workflow_define_id"];  
            $workflowDefine   = $workflowDefinesModel->relation(true)->getByid($workflowDefineId);
          
            $workflow = unserialize($workflowDefine["flow_define"]);
            $nextNode = $workflow[1];
            if ($nextNode["role_id"] == -1) { # error flow
                $_SESSION["msg"] = array("msg"=>"错误流程，请联系管理员！", "flag"=>2);
                $this->redirect("Index/index");
            }
            
            $nextUser = array();
            if ($nextNode["role_type"] == 0) { # single man exec
                $nextUsers = $this->getSingleExecUser($nextNode["role_id"]);
            }
            
           $roleDefinesModel     = D("RoleDefines");

            $id = $nextNode["role_id"];
            if($id != "-1"){
                $resultRole = $roleDefinesModel->where("id='$id'")->select();
                $resultRole = $resultRole[0];
                $nextNode["next_role_name"] = $resultRole["role_name"];
            } else {
                $nextNode["next_role_name"] = "发起人确认";
            }
            
            $iCanDo = 0; //是否白名单审核人
            foreach($nextUsers as $u) {
            	if($_SESSION["user_id"]==$u["id"]) {
            		$iCanDo = 1;
            		break;
            	}
            }
            
            ///分拆成，部门和用户
            $arrdepart = array();
            foreach($nextUsers as $u) {
            	 $arrdepart[$u["department"]]["name"] = $u["department"];
            	 $arrdepart[$u["department"]]["value"] .=  $u["id"]."|".$u["zh_name"].";";
            }
            $orderDataModel = D($workflowDefine["bind_order"]["order_model_name"]);
            
            $nav = Util::navigator("dashboard");
            $create_at = date("Y-m-d", time());
            
            $userModel = D("user");
            $userinfo  = $userModel->getByid($_SESSION["user_id"]);
            
            $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "next_node"=>$nextNode, "next_users"=>$nextUsers,"arrdepart"=>$arrdepart);
            
            $pageElement["task_id"]       = $taskId;
            $pageElement["order_data_id"] = $orderDataId; 
            $pageElement["create_at"]     = $create_at;
            //取得所有需要编辑的数据
            $orderData = $orderDataModel->getByid($orderDataId);
            $info = unserialize($orderData["info"]); 
            $pageElement["orderData"] = $info;
            
            $init_arg = $this->init_default_value($info, $workflowDefine["bind_order"]["order_model_name"]);
            
            //添加idc列表
	        $idc_list = $this->getIdcList();
	        
	        $init_arg["idc_list"] = $idc_list;
	        
	        # 将已经被通知的人放在最前面
            $hasNotifiedUsers = array();
            $hasNotified = explode("#", $taskinfo["notify_user_ids"]);
            // var_dump($hasNotified);die;
            $users = $userModel->where("status_flag=0 order by name asc")->select();
            foreach ($users as $key=>$user) {
                if (in_array($user["id"], $hasNotified)) {      //排除已经
                    $hasNotifiedUsers[] = $users[$key];
                    unset($users[$key]);
                } else {
                    continue;
                }
            }
        
            foreach ($hasNotifiedUsers as $notifiedUser) {
                array_unshift($users, $notifiedUser);
            }
           
            $pageElement["init_arg"]         = $init_arg;
            $pageElement["ORDER_DATA_MODEL"] = $workflowDefine["bind_order"]["order_model_name"];
            $pageElement["ORDER_FLOW_NAME"]  = $workflowDefine["flow_name"];
            $pageElement["iCanDo"]           = $iCanDo;
            $pageElement["iuserid"]          = $_SESSION["user_id"];
            $pageElement["left_count"] = Util::getDashboardLeftCount();
            $pageElement["announce"] = Util::getAnnouncement();
            $pageElement["selected"] = "waitsend";   
            $pageElement["editMode"]    = "edit";
            $pageElement["notify_users"] = $users;
            $pageElement["has_notified"] = $hasNotified;
            
            $userinfo  = $userModel->getByid($_SESSION["user_id"]);
            $pageElement["request_name"] = $userinfo["zh_name"];
            $pageElement["userinfo"]  = $userinfo;
            
            $this->addEditPe($pageElement);
             $pageElement["AUTH_MARK_STR"]=$_SESSION[DBNAME."auth"];$this->assign("pe", $pageElement);
          
            $this->display("edit");
        }
    }
    
    
    public function index() {
        $workflowDefineId = $_REQUEST["workflow_id"];
        
        $orderDefinesModel    = D("OrderDefines");    
        $workflowDefinesModel = D("WorkflowDefines");       
         
        $workflow = $workflowDefinesModel->getByid($workflowDefineId);
        if (!$workflow) {
            $_SESSION["msg"] = array("msg"=>"不存在的模板", "flag"=>2);
            $this->redirect("Index/index");
        }
        
        $orderinfo = $orderDefinesModel->getByid($workflow["order_id"]);
         
        $DATA_PREFIX      = $orderinfo["order_short_name"];
        $ORDER_DATA_MODEL = $orderinfo["order_model_name"];
        $ORDER_FLOW_NAME  = $orderinfo["order_name"];
        
        /**
		 * 1)把数据放入对应的数据表中
		 * 2)计算工作流，添加任务
		 * 3)添加任务日志
		 **/        
        if ($_REQUEST["act"] == "save") {
            $notify_ids = $_REQUEST["notify_ids"];
            # 1.将表单数据存入对应的数据表中
        	$tasksModel = D("Tasks");
           
            # 持久化用户部门和手机
            $this->saveDepartTelephone($_REQUEST["depart_name"],$_REQUEST["telephone"]);   
            
            # 存放表单数据
            $orderDataId =  $this->saveOrderData($ORDER_DATA_MODEL,$_REQUEST);       
   
            # 2.add new task in tasks
            $nextExecPerson = $_REQUEST["next_exec_peron"];            
            $flow_arr    = $workflowDefinesModel->getByid($workflowDefineId);             
            $flow_define = $flow_arr["flow_define"]; 
            
            $task_no = $this->genarateTaskNo($DATA_PREFIX ,$workflowDefineId);
            
            $task_name = $flow_arr["flow_name"]."-".$task_no."-".$_REQUEST["request_name"];
            $workflowDefine = unserialize($flow_define); # define
            $workflowWork   = unserialize($flow_define); # task workflow
            
            $str_notify_id = "";
            foreach ($notify_ids as $key=>$notify_id){
               // var_dump($notify_id);
                if($key == 0){
                    $str_notify_id = $notify_id;
                } else {
                    $str_notify_id .= "#".$notify_id;
                }
            }
            
            // 清空工作流
            $this->clearWorkFlow($workflowWork);
            
            if($_REQUEST["end_flow_flag"] == 1) {
	           //初始化发起人
            	$this->setWorkFlow( $workflowWork, 0,$workflowDefine[0]["role_id"], $_SESSION["user_id"], 1);                      # 已处理				
            }
            
            $tmparr["mail"] = $_SESSION["mail"];
            $tmparr["name"] = $_SESSION["name"];
            $tmparr["user_id"] = $_SESSION["user_id"];
            $workflowWork[0]["user_info"] = serialize($tmparr);
            
            $data = array();
            $data["workflow_define_id"] = $workflowDefineId;
            $data["order_data_id"]   = $orderDataId;
            $data["task_no"]         = $task_no;
            $data["task_name"]       = $task_name;
            $data["memo"]            = "";
            $data["workflow"]        = serialize($workflowWork);
            $data["workflow_define"] = $flow_define;
            if($_REQUEST["end_flow_flag"] == 1) {
            	 $data["now_role_id"]     = $workflowDefine[1]["role_id"];
            	 $data["now_role_cursor"] = 1;
             } else {                            # 暂存待办
             	 $data["now_role_cursor"] = 0;
             }
            $now_role_type = $workflowDefine[1]["role_type"];
            
            # $now_user_id
            $now_role_id = $workflowDefine[1]["role_id"];
            $user_list   = $this->get_user_by_role($now_role_id);
            
            $tmpuserid_arr = array();
            foreach ($user_list as $user_id=>$user_name) {
                $tmpuserid_arr[] = $user_id;
            }
            
            $now_user_id = implode("#", $tmpuserid_arr);
            
            if (isset($nextExecPerson) && $nextExecPerson > 0) {
                $now_user_id = $nextExecPerson;
            }
            
            if ($_REQUEST["end_flow_flag"] == 0) {
                $now_user_id=$_SESSION["user_id"];
            }
            $data["now_user_id"]   = $now_user_id;
            $data["end_flow_flag"] = $_REQUEST["end_flow_flag"];  # 0:未提交 1：已提交 2:流程结束
            $data["status_flag"]   = 0;                            # 0:启用 2：删除
            if ($_REQUEST["end_flow_flag"] == 0) {
                $data["status_flag"] = 1;  #保存待发
            }
            
            $data["create_user_id"] = $_SESSION["user_id"];  
            $data["created_at"] = date("Y-m-d H:i:s");
            $data["updated_at"] = date("Y-m-d H:i:s");
            $data["notify_user_ids"] = $str_notify_id;
            
            $sc = $tasksModel->data($data)->add();
          
          
            $task_id = $tasksModel->getLastInsID();
            if ($sc) {
                $_SESSION["msg"] = array("msg"=>"申请成功", "flag"=>1);
            } else {
                $_SESSION["msg"] = array("msg"=>"申请失败", "flag"=>2);
            }
            
            if ($_REQUEST["end_flow_flag"] == 0) {
                if ($sc) {
                    $_SESSION["msg"] = array("msg"=>"保存成功", "flag"=>1);
                } else {
                    $_SESSION["msg"] = array("msg"=>"保存失败", "flag"=>2);
                }
            } else {
            	$this->addStart($task_no, $_REQUEST);
        	    Util::addTaskLog($task_id, $data["task_name"],  $workflowDefine[0]["role_id"], 1, ''); //task_log 1：同意  2：回退   3：终止 4:暂停待办
             
        	    $c = new Caller();
       			$success = $c->start($task_id, $data, $_REQUEST);
               	if ($success["RESULT"] == 0) {
              		$_SESSION["msg"] = array("msg"=>"申请成功", "flag"=>1);
              	} else {
              		$_SESSION["msg"] = array("msg"=>"申请失败。".$success["ERROR_MESSAGE"], "flag"=>2);
              	}
            }
            
            $flow_title   = $ORDER_FLOW_NAME;
            $flow_role_id = $workflowDefine[0]["role_id"];
            
            $this->redirect("Index/index");
        } else {
            $userModel            = D("user");
            $idcInfosModel        = D("IdcInfos"); 
            $userPlayRolesModel   = D("UserPlayRoles");
            $announceDefinesModel = D("AnnounceDefines");
            
            $workflowDefine = $workflowDefinesModel->relation(true)->getByid($workflowDefineId);
            
            $workflow = unserialize($workflowDefine["flow_define"]);
            $nextNode = $workflow[1];
            if ($nextNode["role_id"] == -1) { # error flow
                $_SESSION["msg"] = array("msg"=>"错误流程，请联系管理员！", "flag"=>2);
                $this->redirect("Index/index");
            }
            
            $nextUser = array();
            if ($nextNode["role_type"] == 0) { # single man exec
                $nextUsers = $this->getSingleExecUser($nextNode["role_id"]);
            }
             
            $roleDefinesModel     = D("RoleDefines");

            $id = $nextNode["role_id"];
            if ($id != "-1") {
                $resultRole = $roleDefinesModel->where("id='$id'")->select();
                $resultRole = $resultRole[0];
                $nextNode["next_role_name"] = $resultRole["role_name"];
            } else {
                $nextNode["next_role_name"] = "发起人确认";
            }
            
            $iCanDo = 0;
            foreach($nextUsers as $u) {
            	if($_SESSION["user_id"]==$u["id"]) {
            		$iCanDo = 1;
            		break;
            	}
            }
            
      /*      # 将已经被通知的人放在最前面
            $hasNotifiedUsers = array();
            $users = $userModel->where("status_flag=0 order by name asc")->select();
            foreach ($users as $key=>$user) {
                if (in_array($user["id"], $hasNotified)) {      //排除已经
                    $hasNotifiedUsers[] = $users[$key];
                    unset($users[$key]);
                } else {
                    continue;
                }
            }
        
            foreach ($hasNotifiedUsers as $notifiedUser) {
                array_unshift($users, $notifiedUser);
            }
            */
            $users = $userModel->where("status_flag=0 order by name asc")->select();
            # 分拆成，部门和用户
            $arrdepart = array();
            foreach($nextUsers as $u) {
            	 $arrdepart[$u["department"]]["name"] = $u["department"];
            	 $arrdepart[$u["department"]]["value"] .=  $u["id"]."|".$u["zh_name"].";";
            }
            
            $nav = Util::navigator("dashboard");
            
            
            $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$_SESSION["mail"], "nav"=>$nav, "next_node"=>$nextNode, "next_users"=>$nextUsers, "arrdepart"=>$arrdepart);
            $userinfo  = $userModel->getByid($_SESSION["user_id"]);
            $pageElement["request_name"] = $userinfo["zh_name"];
            $pageElement["userinfo"]  = $userinfo;
            $pageElement["create_at"] = date("Y-m-d", time());
            $pageElement["iCanDo"]  = $iCanDo;
            $pageElement["iuserid"] = $_SESSION["user_id"]; 
              
            $init_arg = $this->init_default_value(NULL, $ORDER_DATA_MODEL);
            
	        $idc_list = $this->getIdcList();
	                    
            $init_arg["idc_list"]    = $idc_list;
            $pageElement["init_arg"] = $init_arg;
            $pageElement["ORDER_DATA_MODEL"] = $ORDER_DATA_MODEL;
            $pageElement["ORDER_FLOW_NAME"]  = $workflowDefine["flow_name"];
            $pageElement["workflow_id"] = $workflowDefineId;
            $pageElement["left_count"] = Util::getDashboardLeftCount();
            $pageElement["announce"] = Util::getAnnouncement();
            $pageElement["selected"] = "newtask";
            $pageElement["notify_users"] = $users;
            $pageElement["editMode"]     = "add";    
	        
       		$this->addIndexPe($pageElement);
            $this->autoStartInit($pageElement, $workflowDefineId, $_SESSION["name"]);
             $pageElement["AUTH_MARK_STR"]=$_SESSION[DBNAME."auth"];$this->assign("pe", $pageElement);
            
            $this->display();
        }
    }
    
    
    /**
     * if roleId = -1, that means the node is now at the 发起者确认, needs taskId to find the create user
     * else we only need roleId to find the exec user
     * 
     * @param int $roleId
     * @param int $taskId
     */
    private function getSingleExecUser($roleId, $taskId = -1) {
        $users = array();
        
        if ($roleId != -1) { # 流程为到发起者确认环节
            $userPlayRolesModel = D("UserPlayRoles");
            
            $nextNodePersons = $userPlayRolesModel->relation(true)->where("role_id=$roleId")->select();
            foreach ($nextNodePersons as $nextNodePerson) {
                if ($nextNodePerson["authed_user"]["status_flag"] == 0) {
                    if (isset($nextNodePerson["authed_user"])) {
                        $users[] = $nextNodePerson["authed_user"];
                    }
                } else {
                    continue;
                }
            }
        } else { # 流程已经到达发起者确认环节，返回发起者
            $tasksModel = D("Tasks");
            
            $task = $tasksModel->relation(true)->getById($taskId);
            if ($task) {
                $users[] = $task["create_user"];
            }
        }
        
        //var_dump($users);
        //排序
        $arr_user = array();
        $arr_sort = array();
        for($i=0; $i<count($users); $i++) {
        	$arr_sort[$users[$i]["department"].$users[$i]["name"]]=$i;
        }
        
        ksort($arr_sort);
        
        foreach($arr_sort as $name => $i) {
        	$arr_user[] = $users[$i];
        } 
        
        return $arr_user;
    }
    
  
    
   /**
	* 节点处理人，对节点进行处理 
	* 1) 获得工作流，计算发起人，上一节点及上一节点处理人，下一节点，及下一节点所有可处理人列表
	* 2) 计算处理结果
	* 3) 更新tasks
	* 4）更新数据表
	* 5）添加日志
	**/ 
    public function editTask() {
        $taskId      = $_REQUEST["task_id"];
        $nowRoleId   = $_REQUEST["now_role_id"];
        $readonly    = $_REQUEST["readonly"];
        $orderDataId = $_REQUEST["order_data_id"];           
        $nowRoleCursor = $_REQUEST["now_role_cursor"];
        
        $userModel            = D("User");
        $tasksModel           = D("Tasks");
        $taskLogModel         = D("TaskLog"); 
        $roleDefinesModel     = D("RoleDefines");
        $userPlayRolesModel   = D("UserPlayRoles");
        $workflowDefinesModel = D("WorkflowDefines");
        
        $taskInfo = $tasksModel->getByid($taskId);
        if($nowRoleCursor != $taskInfo["now_role_cursor"] && $readonly != 1) {
			header ("Content-Type:text/html;charset=utf-8");
        	echo "<script language=javascript>alert('该流程已被他人处理');</script>";
        	echo "<script language=javascript>window.close();</script>";
        	return;
        }
         
        $workflowDefine = $workflowDefinesModel->relation(true)->getByid($taskInfo["workflow_define_id"]);
        
        $DATA_PREFIX      = $workflowDefine["bind_order"]["order_short_name"];
        $ORDER_DATA_MODEL = $workflowDefine["bind_order"]["order_model_name"];
        $ORDER_FLOW_NAME  = $workflowDefine["bind_order"]["order_name"];
        
        $orderDataModel = D($ORDER_DATA_MODEL); 
        
        $workflow = unserialize($workflowDefine["flow_define"]);
        $nextNode = $this->getTaskNextNode($taskId);
        
        $nextUser = array();
        if ($nextNode["role_type"] == 0) { # single man exec
            $nextUsers = $this->getSingleExecUser($nextNode["role_id"], $taskId);
        }
        $roleDefinesModel     = D("RoleDefines");

        $id = $nextNode["role_id"];
        if($id != -1){
            $resultRole = $roleDefinesModel->where("id='$id'")->select();
            $resultRole = $resultRole[0];
            $nextNode["next_role_name"] = $resultRole["role_name"];
        }
        else{
            $nextNode["next_role_name"] = "发起人确认";
        }
        
        
        #print_r($nextUsers);
        $userinfo = $userModel->getByid($_SESSION["user_id"]);
        
        $pageElement = array("next_node"=>$nextNode, "next_users"=>$nextUsers);
        $pageElement["task_id"]       = $taskId;
        $pageElement["order_data_id"] = $orderDataId;
        
        $orderData = $orderDataModel->getByid($orderDataId);
         
        $info = unserialize($orderData["info"]);
        $this->addInfo($info);
        $pageElement["orderData"] = $info;

        # created_at 
        $taskInfo["created_at"]   = date("Y-m-d", strtotime($taskInfo["created_at"]));
        $pageElement["task_info"] = $taskInfo;
     
        $initArg = $this->init_default_value($info, $workflowDefine["bind_order"]["order_model_name"]);
        
         $idcs =   $this->getIdcList();
        
        $initArg["idc_list"]     = $idcs;
        
        $pageElement["init_arg"] = $initArg;
        
        $flow_zh_name = $$workflowDefine["flow_name"];
        
        # 当前角色信息
        $nowRole = $roleDefinesModel->getByid($nowRoleId);
        $pageElement["nowrole"]     = $nowRole;
        $pageElement["readonly"]    = $readonly;
        $pageElement["now_role_id"] = $nowRoleId;
        
        $OrderDataModel = D($workflowDefine["bind_order"]["order_model_name"]);
        $info    = $OrderDataModel->field("info")->where("id=$orderDataId")->select();
        $infoArr = unserialize($info[0]["info"]);
        
        # opsAssign的附加处理
        if (!empty($infoArr["ops_idc_id"]) || $nowRole["role_short_name"] == "opsAssign") { //查出需要的机器，并列表
            $pageElement["need_opsAssign_detail"] = 1;
            
            $myreadonly = "";
            if ($nowRole["role_short_name"] != "opsAssign") {
                $myreadonly = " readonly=\"readonly\" ";
                $pageElement["readonlystr"]   = " disabled=\"disabled\" ";
                $pageElement["need_readonly"] = 1;
            }
        }
        
        $taskLogs = $taskLogModel->relation(true)->where("task_id=$taskId")->order("action_at desc,id desc")->select();
        for ($i = 0; $i < count($taskLogs); $i++) {
            $taskLogs[$i]["action_info"] = unserialize($taskLogs[$i]["action_info"]);
        }
        
        $hasNotified = explode("#", $taskInfo["notify_user_ids"]);
        
        # 将已经被通知的人放在最前面
        $showNotifiedUsers="";
        $hasNotifiedUsers = array();
        $users = $userModel->where("status_flag=0 order by name asc")->select();
        foreach ($users as $key=>$user) {
            if (in_array($user["id"], $hasNotified)) {
                $hasNotifiedUsers[] = $users[$key];
                if(strlen($showNotifiedUsers)>0) $showNotifiedUsers .= ",";
                $showNotifiedUsers .= $users[$key]["zh_name"] ;
                unset($users[$key]);
            } else {
                continue;
            }
        }
       
        foreach ($hasNotifiedUsers as $notifiedUser) {
            array_unshift($users, $notifiedUser);
        }
        
        
        $pageElement["editMode"]    = "edit";
   
        $pageElement["showNotifiedUsers"]     = $showNotifiedUsers;
        $pageElement["has_notified"]     = $hasNotified;
        $pageElement["notify_users"]     = $users;
        $pageElement["task_log"]         = $taskLogs;
        $pageElement["ORDER_DATA_MODEL"] = $workflowDefine["bind_order"]["order_model_name"];
        $pageElement["ORDER_FLOW_NAME"]  = $workflowDefine["flow_name"];
        $pageElement["now_role_cursor"]  = $taskInfo["now_role_cursor"] ;
         
                 
        $this->addEditTaskPe($nowRole, $taskId, $infoArr, $pageElement);
        
         $pageElement["AUTH_MARK_STR"]=$_SESSION[DBNAME."auth"];$this->assign("pe", $pageElement);
        
        $this->display("editTask");
    }
    
    
    /**
     * if $prevNode == null, this means the now node is end or the flow is end
     * 
     * @param int $taskId
     */
    private function getTaskNextNode($taskId) {
        $tasksModel = D("Tasks");
        $task = $tasksModel->relation(true)->where("id=$taskId")->find();
        
        $nowRoleId = $task["now_role_id"];
        $workflow = unserialize($task["workflow"]);
        $workflowDefine = unserialize($task["workflow_define"]);
        $nextNode = array();
        
        $endFlowFlag = $task["end_flow_flag"];
        if ($endFlowFlag == 3) { # workflow is already end
            return $nextNode;
        }
        
        foreach ($workflowDefine as $key=>$node) {
            if ($node["role_id"] == $nowRoleId && $workflow[$key]["role_status"] == 0) {
                if (count($workflowDefine) > $key + 1) {
                    $nextNode = $workflowDefine[$key + 1];
                    break;
                } else {
                    break;
                }
            } else {
                continue;
            }
        }
        
        return $nextNode;
    }
    
    
    /**
     * if $prevNode == null, this means the now node is begining
     * 
     * @param int $taskId
     */
    private function getTaskPrevNode($taskId) {
        $tasksModel = D("Tasks");
        $task = $tasksModel->relation(true)->where("id=$taskId")->find();
        
        $nowRoleId = $task["now_role_id"];
        $workflow = $task["workflow"];
        $workflowDefine = $task["workflow_define"];
        
        $prevNode = array();
        foreach ($workflowDefine as $key=>$node) {
            if ($node["role_id"] == $nowRoleId && $workflow[$key]["role_status"] == 0) {
                if ($key - 1 >= 0) {
                    $prevNode = $workflowDefine[$key - 1];
                    break;
                } else {
                    break;
                }
            } else {
                continue;
            }
        }
        
        return $prevNode;
    }
    
    
    /**
     * 删除任务
     * 
     */   
    public function delete() {
        $taskId      = $_REQUEST["task_id"];
        $orderDataId = $_REQUEST["order_data_id"];
        
        $tasksModel           = D("tasks");    
        $workflowDefinesModel = D("WorkflowDefines");
        
        $taskInfo = $tasksModel->getByid($taskId);
        $workflowDefine = $workflowDefinesModel->relation(true)->getByid($taskInfo["workflow_define_id"]); 
        
        $DATA_PREFIX      = $workflowDefine["bind_order"]["order_short_name"];
        $ORDER_DATA_MODEL = $workflowDefine["bind_order"]["order_model_name"];
        $ORDER_FLOW_NAME  = $workflowDefine["bind_order"]["order_name"];  
        
        $orderDataModel = D($ORDER_DATA_MODEL);
        
        $data = array();
        $data["id"]          = $orderDataId;
        $data["status_flag"] = 2;
        
        $orderDataModel->data($data)->save();
        unset($data);
        
        $data["id"]          = $taskId;
        $data["status_flag"] = 2;
        $tasksModel->data($data)->save();
        
        Util::addTaskLog($taskId, "删除", 0, 3,"删除");     # task_log 1：同意  2：回退   3：终止 4:暂停待办        
        

        $sc = $orderDataModel->where("id='$orderDataId' and status_flag=2")->find();
        if ($sc) {
            $_SESSION["msg"] = array("msg"=>"删除成功", "flag"=>1);
        } else {
            $_SESSION["msg"] = array("msg"=>"删除失败", "flag"=>2);
        }
        
      	$ref = $_SERVER ['HTTP_REFERER']; 
		header("location:$ref");	
    }
	
    
    private function saveDepartTelephone($depart_name, $telephone) {
        $userModel = D("User");
        
        $createUserId = $_SESSION["user_id"];
        $data["id"] = $createUserId;
        $depart_name = trim($depart_name);
        $telephone = trim($telephone);
        
        if (!empty($depart_name)) {
            $data["department"] = $depart_name;
            $userModel->data($data)->save();
        }
        
        if (!empty($telephone)) {
            $data["telephone"] = $telephone;
            $userModel->data($data)->save();
        }
    }
    
    
    private function  saveOrderData($ORDER_DATA_MODEL, $_REQUEST) {
        $orderDataModel = D($ORDER_DATA_MODEL);
        
        $data = array();
        $data["info"] = serialize($_REQUEST);
        $data["created_at"] = date("Y-m-d H:i:s");
        $data["updated_at"] = date("Y-m-d H:i:s");
        $data["status_flag"] = 0; # 0->ok,2->delete
        $data["create_user_id"] = $_SESSION["user_id"];
        $orderDataModel->data($data)->add();
        
        return $orderDataModel->getLastInsID();
    }
    
    
    private function genarateTaskNo($DATA_PREFIX, $workflowDefineId) {
        $tasksModel = D("Tasks");
        
        $today    = date("Y-m-d");
        $sr_count = $tasksModel->where("workflow_define_id=$workflowDefineId and created_at>'$today'")->count();
        
        $sr_count++;
        
        $task_no = $DATA_PREFIX."_".date("Ymd");
        $addzero = "";
        $leftzero = 4 - strlen($sr_count);
        for ($i = 0; $i < $leftzero; $i++) {
            $addzero .= "0";
        }
        $task_no .= $addzero.$sr_count;
        
        return $task_no;
    }
    
    
    public function getIdcList() {
        $idcinfoModel = D("IdcInfos");
        $idc_list = $idcinfoModel->where("disp_type=0")->order('disp_ord')->select();
        for ($i = 0; $i < count($idc_list); $i++) {
            $idc_list[$i]["idc_id"] = $idc_list[$i]["id"];
            $short_name = $idc_list[$i]["name"];
            $short_name = str_replace("idc-", "", $short_name);
            
            $idc_list[$i]["idc_name"] = $idc_list[$i]["zh_name"]."|".$short_name;
        }
        return $idc_list;
    }
    
    
    public function clearWorkFlow(&$workflowWork) {
        for ($i = 0; $i < count($workflowWork); $i++) { # role id 正常
            $workflowWork[$i]['user_info'] = "";
            $workflowWork[$i]['role_action'] = "0";
            $workflowWork[$i]['role_status'] = "0";
        }
    }
    
    
    public function setWorkFlow(&$workflowWork, $i, $role_id, $user_id, $role_status) {
        $workflowWork[$i]["role_id"]     = $role_id; # 回退会退到这个用户		 
        $workflowWork[$i]["now_user_id"] = $user_id; # 回退会退到这个用户
        $workflowWork[$i]["role_status"] = 1;        # 已处理		
    }
    
    
    # 附加流程开始操作
    public function addStart($task_no, $_REQUEST) {
        
    }
    
    
    # 附加展示的sa操作表单中的信息
    public function addInfo(&$info) {
        
    }
    
    
    # 附加editTask $pageElement 中的信息
    public function addEditTaskPe($nowRole, $taskId, $infoArr, &$pageElement) {
        
    }
    
    
    # 附加index初始化 $pageElement 中的信息
    public function addIndexPe(&$pageElement) {
        
    }
    
    
    # 附加edit初始化 $pageElement 中的信息
    public function addEditPe(&$pageElement) {
        
    }
    
    
    /**
     * 根据$request数据，将表单数据暂时存入session之中
     * 用workflow_id作为key，不过可能会出现SESSION出现串行的情况
     * 
     * @param Array $request
     * @param Int   $workflowId
     * @param String $username
     */
    public function saveRequest($formData, $workflowId, $username) {
    	$filelog = AUTO_START_PATH .$username."_".$workflowId;
 
        file_put_contents($filelog, $formData);
        
        return true;
    }
    
    
    /**
     * 用于外部发起表单时初始化发起表单的相关数据
     * 切记字段必须一致，否则无法正确初始化表单
     * 
     * @param Array $pageElement
     * @param Int   $workflowId
     * @param String $username
     */
    private function autoStartInit(&$pageElement, $workflowId, $username) {
    	$filelog = AUTO_START_PATH.$username."_".$workflowId;
    	if(is_file($filelog))
    	{
	        $cc = file_get_contents($filelog);
	        $formDataArr = json_decode($cc,true);
	        $request =  $formDataArr["request"];
	        //整理字段，凡是数组的，只保留第一个
	        foreach($request as $key => $value)
	        {
	        	if(is_array($value)) $request[$key]=$value[0];
	        }
	    	$pageElement["orderData"] = $request;
	    	 
	    	 unlink( $filelog);
    	}
    
    }
}