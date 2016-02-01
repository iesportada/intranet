<?php 
require_once("excel.php");  
require_once("excel-ext.php"); 

$assoc = array(  
			array("Nombre"=>"Mattias", "IQ"=>250),  
			array("Nombre"=>"Tony", "IQ"=>100),  
			array("Nombre"=>"Peter", "IQ"=>100),  
			array("Nombre"=>"Edvard", "IQ"=>100)
		 );  
   
createExcel("excel-mysql.xls", $data);
exit;
?>