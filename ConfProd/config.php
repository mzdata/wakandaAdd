<?php


    return array(
        'TMPL_ENGINE_TYPE' => 'Smarty',
        'TMPL_ENGINE_CONFIG' => array(
                  'caching'      => false,
                  'template_dir' => TMPL_PATH,
                  'cache_dir'    => TEMP_PATH,
                  'compile_dir'  => CACHE_PATH
                   ),
        
        # MySQL config
        'DB_TYPE'    => 'mysqli', 
        'DB_HOST'    => 'rm-8vbszau5ftled8pn7.mysql.zhangbei.rds.aliyuncs.com',  
        'DB_NAME'    => 'wakanda_api',
        'DB_USER'    => 'mzwriter',
        'DB_PWD'     => 'i8T40uq2FHENkQRp',            # ops_work_20130205
        'DB_PORT'    => '3306',
        'DB_PREFIX'  => '',
        'DB_FIELDS_CACHE'=>    false,
        
        'APP_DEBUG'  => false,
        //'show_error_msg'         => true,
        'URL_MODEL'  => 1,
        'URL_PATHINFO_DEPR' => '/',
        
        'LOG_RECORD'         => true,
#       'LOG_RECORD_LEVEL'  => array('EMERG','ALERT','CRIT','ERR'),
        
        # default
        'DEFAULT_THEME'       => 'default',
        'URL_HTML_SUFFIX'     => '',  
        'DEFAULT_CHARSET'     => 'utf-8', 
        'DEFAULT_TIMEZONE'    => 'PRC',
        'DEFAULT_AJAX_RETURN' => 'JSON',
        
        # cookie
        'COOKIE_EXPIRE'        => 3600000000,
        'COOKIE_DOMAIN'        => '',
        'COOKIE_PATH'          => '/',
        'COOKIE_PREFIX'        => '',
        
        # session
        'SESSION_AUTO_START' =>true,
        'SESSION_NAME' => 'ThinkID' , 
        'SESSION_PATH' => '' , 
        'SESSION_TYPE' => 'File' ,
        'SESSION_EXPIRE' => 3600000000 ,
        'SESSION_TABLE'  => '' ,
        
        'HTML_CACHE_ON'    => false,
        'HTML_CACHE_TIME'  => 60,
        'HTML_READ_TYPE'   => 0,                   # 0 readfile 1 redirect
        'HTML_FILE_SUFFIX' => '.shtml',
        
        'ERROR_MESSAGE' => 'error page~',
        
        'TITLE'   => 'dbAuth插件系统',
        'VERSION' => '1.0',
		
        'INDEX_CONFIG_URL' => 'http://127.0.0.1/get_index_navi_config.php',
        
        # code   zh_name   path   is_drop

        'NAVIGATOR'               => array(array('index', 'mk', '#', 1), 
                                      ),

                                   
        'NAVIGATOR_AUTH'       => array("index"     => 0,
                                        "dashboard" => 0, 
                                        "defines"   => 1,
                                        "manager"   => 1,
                                        ),
                                        
        'MODULE_AUTH'           => array(),
                                        
        'MAILING'               => array('switch' => false,
                                         'from'   => 'od@360.cn',
                                         'cc' 	  => ''
                                          ),   
                                              
         
    );
