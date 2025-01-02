<?php
include_once 'Conf/authorization_config.php';

vendor("CAS.CAS");

class AuthorizationAction extends Action{

    public function loginCheck() {



        
        if(empty($_SESSION[DBNAME."user_id"]) && ! empty($_SESSION[DBNAME."myname"])) {
            $this->userLogin();
        } else  if(empty($_SESSION[DBNAME."user_id"])){
			 $this->logout();
			 die;

		}
		else {
            # no need to do


        }

    }

    public function logout() {
        unset($_SESSION[DBNAME."mail"]);
        unset($_SESSION[DBNAME."user_id"]);
        unset($_SESSION[DBNAME."name"]);
        unset($_SESSION[DBNAME."login"]);
        unset($_SESSION[DBNAME."myname"]);

              echo "<script language='javascript'>document.location='../../login';</script>";
    }


    private function userLogin() {


        $loginUser =  $_SESSION [DBNAME."myname"] ; //登录提交的用户登录名




           		$_SESSION [ "mail"]    = $loginUser ;
                $_SESSION [DBNAME."mail"]    = $loginUser ;
                $_SESSION [DBNAME."user_id"] = $loginUser;
                $_SESSION [DBNAME."name"]    = $loginUser;
                $_SESSION [DBNAME."login"]    = $loginUser;
                $_SESSION [DBNAME."role_id"]    = $loginUser;




    }

    /**
     * Cas single pot login
     *
     * @param String $flag
     */
    private function casLogin() {
        phpCAS::client(CAS_VERSION_2_0, CAS_SERVER, 4430, "");
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();

        return trim(phpCAS::getUser());
    }


    /**
     * Sec department ldap login, Support http and https, default is http
     *
     * @param String $D_URL
     * @param String $B_URL
     * @param String $Flag
     */
    private function secLogin($flag='http', $D_URL='https://login.ops.qihoo.net:4430/sec/login', $B_URL='https://tool4.ops.dxt.qihoo.net:4430/sec/login') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $D_URL);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);         # allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         # return into a variable
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $contents  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if($http_code != 200) {
            $D_URL = $B_URL;
        }

        $sid = $_GET['sid'];
        if(empty($sid)) {
            $S_URL = $flag.'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            $d_url = $D_URL.'?ref='.$S_URL;
            header("Location:$d_url");
        } else {
            $url = $D_URL.'?sid='.$sid;
            $ch  = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            $result = curl_exec($ch);
            curl_close($ch);

            $mail='';
            if($result != 'None') {
                $decodedArray = json_decode($result, true);
                $mail = $decodedArray['mail'];
                $user = $decodedArray['user'];
            }

            return $user;
        }
    }
}