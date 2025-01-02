<?php
  
  function getk8sArr() {

	$tmpArr = array(

     //   "IP"=>"主机名",
"172.16.252.20"=>"k8s-jzb-master1",
"172.16.252.139"=>"k8s-jzb-master2",
"172.16.252.167"=>"k8s-jzb-master3",
"172.16.252.56"=>"k8s-jzb01",
"172.16.252.83"=>"k8s-jzb02",
"172.16.252.135"=>"k8s-jzb03",
"172.16.252.108"=>"k8s-jzb04",
"172.16.252.8"=>"k8s-jzb05",
"172.16.252.210"=>"k8s-jzb06",
"172.16.252.47"=>"k8s-jzb07",
"172.16.252.170"=>"k8s-jzb08",
"172.16.252.243"=>"k8s-jzb09",
"172.16.252.12"=>"k8s-jzb010",
"172.16.252.130"=>"k8s-jzb011",
"172.16.252.70"=>"k8s-jzb012",
"172.16.252.194"=>"k8s-jzb013",
"172.16.252.157"=>"k8s-jzb014",
"172.16.252.92"=>"k8s-jzb015",
"172.16.252.22"=>"k8s-jzb016",
"172.16.252.96"=>"k8s-jzb017",
"172.16.252.43"=>"k8s-jzb018",
"172.16.252.64"=>"k8s-jzb019",
"172.16.252.164"=>"k8s-jzb020",
"172.16.252.72"=>"k8s-jzb021",
"172.16.86.150"=>"k8s-jzb022",
"172.16.86.99"=>"k8s-jzb024",
"172.16.86.40"=>"k8s-jzb026",
"172.16.86.53"=>"k8s-jzb027",
"172.16.86.14"=>"k8s-kafka01",
"172.16.86.162"=>"k8s-kafka02",
"172.16.86.248"=>"k8s-kafka03",
"172.16.86.123"=>"k8s-jzb028",
"172.16.86.129"=>"k8s-jzb029",
"172.16.86.252"=>"k8s-jzb030",
"172.16.86.111"=>"k8s-jzb031",
"172.16.86.136"=>"k8s-jzb032",

	
	);
	return $tmpArr;
 
}



function getBisiArr(){

	$BusiArr = array();

	$BusiArr["hyfzge"]["my_type"]="hyfzge";
	$BusiArr["hyfzge"]["my_desc"]="行业发展与改革报告";
 
	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"1. 报告摘要",
		"item_name"=>array("行业发展与改革的总体概述","主要发现和趋势预测")
	);

	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"2. 行业现状分析",
		"item_name"=>array("行业规模和增长趋势","主要参与者和市场份额","政策法规对行业的影响")
	);

	
	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"3. 技术与创新",
		"item_name"=>array("技术进步对行业的影响","创新趋势和发展前景")
	);
	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"4. 市场需求",
		"item_name"=>array("消费者需求变化趋势","新兴市场机会分析")
	);
	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"5. 改革政策",
		"item_name"=>array("政府颁布的行业改革政策","对行业发展的预期影响")
	);

	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"6. 竞争与合作",
		"item_name"=>array("行业内竞争态势","合作伙伴关系分析")
	);

	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"7. 发展趋势与预测",
		"item_name"=>array("行业未来发展趋势分析","预测未来几年的行业发展方向")
	);

	$BusiArr["hyfzge"]["L1"][]=array(
		"title"=>"8. 结论与建议",
		"item_name"=>array("对行业未来发展的建议","可能的行动计划")
	);


	#############商业模式分析
	
	$BusiArr["busiMode"]["my_type"]="busiMode";
	$BusiArr["busiMode"]["my_desc"]="企业商业模式分析";
	
	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"1. 企业概况",
		"item_name"=>array("公司简介和历史沿革","产品或服务介绍","公司使命和愿景")
	);
	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"2. 价值主张",
		"item_name"=>array("公司产品或服务的核心优势","为客户创造的价值","解决客户问题或满足客户需求的能力")
	);

	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"3. 客户群体",
		"item_name"=>array("主要客户群体和特征描述","客户需求和偏好分析","客户关系建立和维护策略")
	);
	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"4. 渠道",
		"item_name"=>array("产品销售和分发渠道","市场推广和宣传渠道","客户获取和留存策略")
	);

	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"5. 客户关系",
		"item_name"=>array("客户服务和支持体系","客户互动和反馈机制","客户忠诚度和关系维护策略")
	);

	
	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"6. 收入来源",
		"item_name"=>array("主要收入来源和盈利模式","定价策略和付款方式","未来收入增长预期")
	);

		
	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"7. 关键合作伙伴",
		"item_name"=>array("主要合作伙伴及其作用","合作关系管理策略","合作伙伴对企业商业模式的影响")
	);

			
	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"8. 核心资源",
		"item_name"=>array("公司核心资源和能力","关键资产和技术优势","资源整合和管理策略")
	);

	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"9. 成本结构",
		"item_name"=>array("主要成本和费用构成","成本控制和降低策略","成本与价值创造的关系")
	);

	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"10. 风险和机会",
		"item_name"=>array("商业模式面临的风险和挑战","新兴机会和发展趋势","对未来商业模式的发展预测")
	);

	$BusiArr["busiMode"]["L1"][]=array(
		"title"=>"11. 结论和建议",
		"item_name"=>array("对企业商业模式的总结和评价","针对性的发展建议和战略规划")
	);

	 ##############################
	 
	$BusiArr["hyqushi"]["my_type"]="hyqushi";
	$BusiArr["hyqushi"]["my_desc"]="行业趋势报告";
	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"1. 行业背景",
		"item_name"=>array("行业的概况进行介绍","市场规模","增长率","竞争格局")
	);

	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"2. 主要趋势分析",
		"item_name"=>array("主要趋势","技术变革","市场需求变化")
	);

	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"3. 市场机会与挑战",
		"item_name"=>array("新兴市场","政策变化","竞争加剧情况")
	);

	
	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"4. 技术创新",
		"item_name"=>array("技术创新趋势","新技术应用","研发投入")
	);

	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"5. 消费者行为变化",
		"item_name"=>array("消费习惯","偏好变化")
	);
	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"6. 竞争对手动向",
		"item_name"=>array("企业产品创新","企业市场拓展")
	);

	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"7. 未来展望",
		"item_name"=>array("行业发展趋势","机遇和挑战")
	);

	$BusiArr["hyqushi"]["L1"][]=array(
		"title"=>"8. 结论",
		"item_name"=>array("行业趋势结论","行业发展的关键因素和发展方向")
	);
	 
 

	return $BusiArr;
}

