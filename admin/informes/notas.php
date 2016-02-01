<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 
  
echo "<h3>Evaluaciones</h3><br>";
echo "<div class='table-responsive'><table class='table table-bordered table-striped table-hover'>
		<thead><tr><th>Asignatura / Materia</th><th>1Ev.</th><th>2Ev.</th><th>Ord.</th><th>Ext.</th></tr></thead>";

// Evaluaciones
$notas1 = "select notas1, notas2, notas3, notas4, unidad from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.CLAVEAL = '$claveal'";
//echo $notas1;
$result1 = mysqli_query($db_con, $notas1);
$row1 = mysqli_fetch_array($result1);
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$trozos1 = explode(";", $asignatura1);
$num = count($trozos1);
 for ($i=0;$i<$num; $i++)
  {
$nombre_asig ="";
$bloque = explode(":", $trozos1[$i]);
$nombreasig = "select NOMBRE, ABREV, CURSO, CODIGO from asignaturas where CODIGO = '" . $bloque[0] . "'  order by CURSO";
$asig = mysqli_query($db_con, $nombreasig);
if(mysqli_num_rows($asig) < 1)	{$nombre_asig = "Asignatura sin código"; }
while($rowasig = mysqli_fetch_array($asig))	{
  if ($rowasig[3] == "")
  {$nombre_asig = "Asignatura sin código"; }
else{
$nombre_asig = $rowasig[0];
}	
	if(strlen(strstr($rowasig[1],'_')) > 0)	{	}

	else 	{	$asig_pend = $rowasig[2];	}	
	}
$califica1 = "select nombre from calificaciones where codigo = '" . $bloque[1] . "'";

$numero1 = mysqli_query($db_con, $califica1);
$rown1 = mysqli_fetch_array($numero1);




$asignatura2 = substr($row1[1], 0, strlen($row1[1])-1);
$trozos2 = explode(";", $asignatura2);
	if (strstr($row1[1],$bloque[0])) {
	foreach($trozos2 as $codi2)
	{
	$bloque2 = explode(":", $codi2);
	if($bloque2[0] == $bloque[0])
	{
$califica2 = "select nombre from calificaciones where codigo = '" . $bloque2[1]. "'";
$numero2 = mysqli_query($db_con, $califica2);
$rown2 = mysqli_fetch_array($numero2);
	}
	}	
	}
	else{
		$rown2[0]=" ";
	}
	
	
	
$asignatura3 = substr($row1[2], 0, strlen($row1[2])-1);
$trozos3 = explode(";", $asignatura3);
	if (strstr($row1[2],$bloque[0])) {
	foreach($trozos3 as $codi3)
	{
	$bloque3 = explode(":", $codi3);
	if($bloque3[0] == $bloque[0])
	{
$califica3 = "select nombre from calificaciones where codigo = '" . $bloque3[1]. "'";
$numero3 = mysqli_query($db_con, $califica3);
$rown3 = mysqli_fetch_array($numero3);
//if($rown3[0] == "No Presentado"){
//	$rown3[0] = "NP";
//}
	}
	}
	}
	else{
		$rown3[0]=" ";
	}
	
	
	
$asignatura4 = substr($row1[3], 0, strlen($row1[3])-1);
$trozos4 = explode(";", $asignatura4);
	if (strstr($row1[3],$bloque[0])) {
		foreach($trozos4 as $codi4)
	{
	$bloque4 = explode(":", $codi4);
	
	if($bloque[0] == $bloque4[0])
	{
$califica4 = "select nombre from calificaciones where codigo = '" . $bloque4[1]. "'";
$numero4 = mysqli_query($db_con, $califica4);
$rown4 = mysqli_fetch_array($numero4);
	}
	}
	}
	else{
		$rown4[0]=" ";
	}


	
	
	
	
if($rown1[0] == "" and $rown2[0] == "" and $rown3[0] == "" and $rown4[0] == "")
	{
			}
	else
		{
	echo "<tr><td>";
	if ($nombre_asig == "Asignatura sin código")  $asig_pend = "Consultar con Administración";
	$trozo_curso=explode("(",$asig_pend);
	$asig_curso=$trozo_curso[0];
	echo $nombre_asig . " <span  class='small'>(" . $asig_curso . ")</span></td>"; 
	echo "<td>";
	echo $rown1[0] ."</td>";
		echo "<td>";
	echo $rown2[0] ." </td>";
		echo "<td>";
	echo $rown3[0] . " </td>";
	echo "<td>";
	 echo $rown4[0] . "</td></tr>";

			}
	}
	echo "</table></div>";

  
?>
