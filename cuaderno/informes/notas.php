<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

echo "<h4 class='text-info'>Evaluaciones del Alumno</h4><br />";

 echo "<table class='table table-striped' style='width:auto'>
		<TR><Th nowrap>Asignatura</th><th>1ª </th><th>2ª </th><th>Jun. </th><th>Sept. </th></tr>";

// Evaluaciones  
$notas1 = "select notas1, notas2, notas3, notas4 from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.CLAVEAL like '%" . $claveal . "%'";
//echo $notas1;
$result1 = mysqli_query($db_con, $notas1);
$row1 = mysqli_fetch_array($result1);
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$trozos1 = explode(";", $asignatura1);
$num = count($trozos1);
 for ($i=0;$i<$num; $i++)
  {
$bloque = explode(":", $trozos1[$i]);
$nombreasig = "select NOMBRE, ABREV, CURSO, CODIGO from asignaturas where CODIGO = '" . $bloque[0] . "'  order by CURSO";
//echo "$nombreasig"."<br>";
$asig = mysqli_query($db_con, $nombreasig);
if(mysqli_num_rows($asig) < 1)	{$nombre_asig = "Asignatura sin código"; }
while($rowasig = mysqli_fetch_array($asig))	{
  if ($rowasig[3] == "")
  {$nombre_asig = "Asignatura sin código"; }
else{$nombre_asig = $rowasig[0];}
	
	if(strlen(strstr($rowasig[1],'_')) > 0)	{	}

	else 	{	$asig_pend = $rowasig[2];	}	}
$califica1 = "select nombre from calificaciones where codigo = '" . $bloque[1] . "'";
$numero1 = mysqli_query($db_con, $califica1);
$rown1 = mysqli_fetch_array($numero1);

$asignatura2 = substr($row1[1], 0, strlen($row1[1])-1);
$trozos2 = explode(";", $asignatura2);
	foreach($trozos2 as $codi)
	{
	$bloque2 = explode(":", $codi);
	if($bloque2[0] == $bloque[0])
	{
$califica2 = "select nombre from calificaciones where codigo = '" . $bloque2[1]. "'";
$numero2 = mysqli_query($db_con, $califica2);
$rown2 = mysqli_fetch_array($numero2);
	}
	}	

$asignatura3 = substr($row1[2], 0, strlen($row1[2])-1);
$trozos3 = explode(";", $asignatura3);
	foreach($trozos3 as $codi)
	{
	$bloque3 = explode(":", $codi);
	if($bloque3[0] == $bloque[0])
	{
$califica3 = "select nombre from calificaciones where codigo = '" . $bloque3[1]. "'";
$numero3 = mysqli_query($db_con, $califica3);
$rown3 = mysqli_fetch_array($numero3);
	}
	}

$asignatura4 = substr($row1[3], 0, strlen($row1[3])-1);
$trozos4 = explode(";", $asignatura4);
	foreach($trozos4 as $codi)
	{
	$bloque4 = explode(":", $codi);
	if($bloque4[0] == $bloque[0])
	{
$califica4 = "select nombre from calificaciones where codigo = '" . $bloque4[1]. "'";
$numero4 = mysqli_query($db_con, $califica4);
$rown4 = mysqli_fetch_array($numero4);
	}
	}
		
if($rown1[0] == "" and $rown2[0] == "" and $rown3[0] == "" and $rown4[0] == "")
	{
			}
	else
		{
	echo "<tr><td>";
	if ($nombre_asig == "Asignatura sin código")  $asig_pend = "Consultar con Administración";
	echo $nombre_asig . "</td>"; 
	echo "<td>";
	echo $rown1[0] ."</td>";
		echo "<td>";
	echo $rown2[0] ."</td>";
		echo "<td>";
	echo $rown3[0] . "</td>";
	echo "<td>";
	echo $rown4[0] . "</td></tr>";
			}
	}
	echo "</table>";
?>
