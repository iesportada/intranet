<?php 
require('../../bootstrap.php');

require_once("../../includes/php-excel/excel.php"); 
require_once("../../includes/php-excel/excel-ext.php");


if (isset($_POST['tipo'])) {
	$tipo=$_POST['tipo'];
}
else{
	$tipo="1";
}
$grupo=$_POST['select'];
//echo $tipo." ".$grupo;
$uni = substr($grupo,0,1);

	if($tipo==1) {
		$sql="SELECT nc as num, concat(alma.apellidos,', ',alma.nombre) as alumno FROM alma, FALUMNOS WHERE FALUMNOS.claveal=alma.claveal and alma.unidad='".$grupo."' ORDER BY nc";}
	
		if($tipo==2) {
		$sql="SELECT concat(alma.apellidos,', ',alma.nombre) as alumno, combasi as asignaturas, nc as num FROM alma, FALUMNOS WHERE alma.claveal=FALUMNOS.claveal and alma.Unidad='".$grupo."' ORDER BY nc";
	}	


$resEmp = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));
$totEmp = mysqli_num_rows($resEmp);

if ($tipo==1){
while($datatmp = mysqli_fetch_assoc($resEmp)) { 
	$data[] = $datatmp; 
}  
}
 
if ($tipo==2){
	while($datatmp = mysqli_fetch_array($resEmp)) { 
		$mat="";
		$asig0 = explode(":",$datatmp[1]);
		foreach($asig0 as $asignatura){		
		$unidadn = substr($grupo,0,1);			
		$consulta = "select distinct abrev, curso from asignaturas where codigo = '$asignatura' and curso like '%$unidadn%' limit 1";
		$abrev = mysqli_query($db_con, $consulta);		
		$abrev0 = mysqli_fetch_array($abrev);
		$curs=substr($abrev0[1],0,2);
		$mat.=$abrev0[0]."; ";
		}
		is_numeric($datatmp[2]);
	$data[] = array($datatmp[2],$datatmp[0],$mat);
}
} 
createExcel("listado_$grupo.xls", $data);
exit;
?>