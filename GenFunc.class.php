<?php
/*

Tablename	store_stat	存储统计配置表
id	bigint(20) unsigned	主键id  
tenant_code   varchar(255) 租户编码
biz_list   longtext 分类划分  biz_tag=table1,table2,table3
status    int(11)  启用状态  0 只统计日志 1 进行正式统计
updated_at	datetime	修改时间 
created_at	datetime	纪录创建时间 

Tablename	store_log	存储统计日志表
id	bigint(20) unsigned	主键id  
tenant_code   varchar(255) 租户编码
doris_db   varchar(255) 数据库
table_name   varchar(255) 表名
storage decimal(11,2)  存储M
rows_number  int(11) 条数
updated_at	datetime	修改时间 
created_at	datetime	纪录创建时间 

*/
import("@.Utils.Smtp");
import("@.Utils.CertificationAction");

include_once 'Conf/enum_config.php';
include_once 'Conf/define_config.php';
include_once 'Conf/authorization_config.php';


class GenFunc { 
 
public static function getTableByIdName($idName)

{

	$tableArr = array(

	"isp_id"=>"isps",
"idc_id"=>"idcs",
"contract_id"=>"contracts",
"rack_id"=>"racks",
"user_id"=>"users",
"switch_id"=>"switches",
"department_id"=>"departments:department",
"server_id"=>"servers",
"budget_id"=>"budgets:begin_year:begin_month",
"supplier_id"=>"suppliers",
"role_id"=>"roles",
"comp_id"=>"companies",
"group_id"=>"groups",
"request_id"=>"component_request",
"detail_id"=>"componets_detail",
"model_id"=>"componet_model",

 
	);

	return $tableArr[$idName];


}

 
 
public static function getTableFieldTitle($idName)

{

	$tableArr = array(

	"tablename.store_stat"=>"存储统计配置表",
"store_stat.id"=>"id",
"store_stat.tenant_code"=>"租户编码",
"store_stat.biz_list"=>"分类划分",
"store_stat.status"=>"启用状态",
"store_stat.updated_at"=>"修改时间",
"store_stat.created_at"=>"纪录创建时间",
"tablename.store_log"=>"存储统计日志表",
"store_log.id"=>"id",
"store_log.tenant_code"=>"租户编码",
"store_log.doris_db"=>"数据库",
"store_log.table_name"=>"表名",
"store_log.storage"=>"存储m",
"store_log.rows_number"=>"条数",
"store_log.updated_at"=>"修改时间",
"store_log.created_at"=>"纪录创建时间",

  
	);

	return $tableArr[$idName];


}

 
 
public static function getTableFieldBase( )

{

	$tableArr = array(

	"tablename.store_stat"=>"存储统计配置表",
"store_stat.id"=>"id",
"store_stat.tenant_code"=>"租户编码",
"store_stat.biz_list"=>"分类划分",
"store_stat.status"=>"启用状态",
"store_stat.updated_at"=>"修改时间",
"store_stat.created_at"=>"纪录创建时间",
"tablename.store_log"=>"存储统计日志表",
"store_log.id"=>"id",
"store_log.tenant_code"=>"租户编码",
"store_log.doris_db"=>"数据库",
"store_log.table_name"=>"表名",
"store_log.storage"=>"存储m",
"store_log.rows_number"=>"条数",
"store_log.updated_at"=>"修改时间",
"store_log.created_at"=>"纪录创建时间",

  
	);

	return $tableArr ;


}

 
 /*
public static function getTFAuth($idName)

{

	$tableArr = array(

	"tablename.store_stat"=>"2",
"store_stat.id"=>"1",
"store_stat.tenant_code"=>"1",
"store_stat.biz_list"=>"1",
"store_stat.status"=>"1",
"store_stat.updated_at"=>"1",
"store_stat.created_at"=>"1",
"tablename.store_log"=>"2",
"store_log.id"=>"1",
"store_log.tenant_code"=>"1",
"store_log.doris_db"=>"1",
"store_log.table_name"=>"1",
"store_log.storage"=>"1",
"store_log.rows_number"=>"1",
"store_log.updated_at"=>"1",
"store_log.created_at"=>"1",

  
	);

	return $tableArr[$idName];


}

*/
 
 
public static function getTFAuthBase( )

{

	$tableArr = array(

	"tablename.store_stat"=>"2",
"store_stat.id"=>"1",
"store_stat.tenant_code"=>"1",
"store_stat.biz_list"=>"1",
"store_stat.status"=>"1",
"store_stat.updated_at"=>"1",
"store_stat.created_at"=>"1",
"tablename.store_log"=>"2",
"store_log.id"=>"1",
"store_log.tenant_code"=>"1",
"store_log.doris_db"=>"1",
"store_log.table_name"=>"1",
"store_log.storage"=>"1",
"store_log.rows_number"=>"1",
"store_log.updated_at"=>"1",
"store_log.created_at"=>"1",

  
	);

	return $tableArr ;


}


}