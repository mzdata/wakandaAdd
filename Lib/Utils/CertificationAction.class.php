<?php
 

include_once 'Conf/enum_config.php';

class CertificationAction extends Action {
    
    public function checkNavigatorCert($userId, $naviName) {
        $naviAuth  = C("NAVIGATOR_AUTH");
        $certLevel = $naviAuth[$naviName];
        
        $userModel = D("Users");
        $cc = $userModel->where("id='$userId'")->count();
        if ($cc>0) {
            return true;
        } else {
            $_SESSION["msg"] = array("msg"=>"无权限访问此页面", flag=>2);
            $this->redirect("Index/index");
        }
    }
    
  
    
 
}