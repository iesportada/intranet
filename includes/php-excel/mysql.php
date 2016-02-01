<?php 
require_once("excel.php"); 
require_once("excel-ext.php"); 
include("../../includes/conexion.inc.php");
$queEmp = $_GET['sentencia'];
#$queEmp = "SELECT * FROM alumnos";
$resEmp = mysqli_query($db_con, $queEmp, $c) or die(mysqli_error($db_con));
$totEmp = mysqli_num_rows($resEmp);

while($datatmp = mysqli_fetch_assoc($resEmp)) { 
	$data[] = $datatmp; 
}  
createExcel("datos_excel.xls", $data);
exit;
?>