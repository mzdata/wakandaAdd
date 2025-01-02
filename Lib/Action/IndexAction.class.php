<?php
/**
 * Tasks table status_flag defines:
 * 
 *      status_flag = 0: task is in action;
 *      status_flag = 1: task is been paused;
 *      status_flag = 2: task is been deleted
 * 
 *      end_flow_flag = 0: waitsend
 *      end_flow_flag = 1: flow is normal
 *      end_flow_flag = 2: flow is end normally
 *      end_flow_flag = 3: flow is end by someone
 */


import ("@.Utils.Util");
import ("@.Utils.CertificationAction");
import ("ORG.Util.Page");

define ("$pagelimit",   20);
define ("LINE_DISPLAY", 4);

include_once 'Conf/enum_config.php';
 
 
class IndexAction extends Action {
    
    
    public function index() {
     
        $mail = trim($_SESSION["mail"]);
        $nav  = Util::navigator("dashboard");
        
 
        
        $msg = "";
        
        $pageElement = array("title"=>C("TITLE"), "version"=>C("VERSION"), "mail"=>$mail, "nav"=>$nav, "msg"=>$msg);
        $pageElement["systems"]=$system;
        $pageElement["requirements"]=$things;
   $pageElement["tableAuth"]= Util::getTableAuth( )
; 
     
        
         
  $this->assign("pe", $pageElement);
        $this->display();
    }
 
}