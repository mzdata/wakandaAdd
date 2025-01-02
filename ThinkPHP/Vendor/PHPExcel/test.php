<?php

	
include_once 'PHPExcel.php';
	 
		$expCellName=array("t1","t2");
		$expTableData=array(
		  array("t11","t21"),
		  array("t12","t22"),	
		);
		 exportExcel("测试",$expCellName,$expTableData);
	 
 
/**
     +----------------------------------------------------------
     * @param $expTitle     string File name
     +----------------------------------------------------------
     * @param $expCellName  array  Column name
     +----------------------------------------------------------
     * @param $expTableData array  Table data
     +----------------------------------------------------------
     */
      function exportExcel($expTitle,$cellArr,$dataArr){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($cellArr);
        $dataNum = count($dataArr);

        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
      //      $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i]. '1', $cellArr[$i]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
			  $line = $i+1;
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j]. $line, $dataArr[$i][$j]);
          }             
        } 

	

        
     //   header('pragma:public');
       // header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        //header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //上面是通过PHPExcel_IOFactory的写函数将上面数据
        
        $outputFileName = "测试.xls";
        
        //标头您的浏览器并告诉它强制下载，而不是在浏览器中运行的文件
        
        header("Content-Type: application/force-download");
        
        header("Content-Type: application/octet-stream");//文件流
        
        header("Content-Type: application/download"); //下载文件
        
        header('Content-Disposition:attachment;filename=" $outputFileName');
        
        header("Content-Transfer-Encoding: binary");
        
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");//上一次修改时间
        
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        
        header("Pragma: no-cache"); //不缓存页面
        
        $objWriter->save('php://output'); //输出到浏览器
        exit;   
    }
?>