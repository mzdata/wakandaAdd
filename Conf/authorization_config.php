<?php

define ("ENV",   "DEV");

define ("SERVER",   "127.0.0.1");                                  # localhost
define ("USERNAME", "root");
define ("PASSWORD", "");            # ops_KatrinA_20130205
define ("DBNAME",   "wakanda_api");



#以下在美丽说无用
define("AUTHORIZATION_MOD", "CAS");
define ("CAS_SERVER",   "login.ops.qihoo.net");
define ("CAS_PORT",     4430);
define ("REDIRCT_URL",  "smarte.corp.qihoo.net:8360/katrina/Index/index");        # use for CAS login and redirct

# http conf
define ("PAGE_MODE", "http");                # use http or https

define ("MAIL_ACCESS_URL",   "http://smarte.corp.qihoo.net:8360/katrina/Index/wait");


###系统登录
define ("SYSUSER",   "sysop");
define ("SYSPASSWORD", '234sysop5@#$%');


define ("OPUSER",   "opuser");
define ("OPPASSWORD", 'opuser@#$%');

define ("REDIS_HOST",   "127.0.0.1");
define ("REDIS_PORT", "6379");
define ("REDIS_PASSWORD", "");

define ("SHOW_ME_TEST", "1");


define ("JYDX_AGENT_LOGIN_URL",   "http://127.0.0.1:8443/api/agentApi/agentLogin");
define ("JYDX_PREFIX",   "jzbjydxpre");

define ("OPEN_ADMIN",   "1");


define ("ALARM_KEY",   "7832243%%2");
define ("ALARM_KEY_2",   "abcde112");


define ("MYBACKGROUPD",   "1");  //0测试 1预发  2线上
define("MYAPPROOT","D:/wamp7/www/db_auth");


define ("KING_GJ_USER",   "jzb");  
define ("KING_GJ_PASSWORD",   "z9BptZ2Q");   

 
define ("SERVER_MODEL",   "127.0.0.1");                                  # localhost
define ("USERNAME_MODEL", "root");
define ("PASSWORD_MODEL", "");            
define ("DBNAME_MODEL",   "db_speech_model");


define ("SERVER_DORIS",   "127.0.0.1");   
define ("PORT_DORIS",   "3306");                                  # localhost
define ("USERNAME_DORIS", "root");
define ("PASSWORD_DORIS", "");    
