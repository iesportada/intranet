<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<a name="intervenciones"></a>
<?php
$tuto = mysqli_query($db_con, "SELECT tutor FROM FTUTORES WHERE unidad='$unidad'");
$tut = mysqli_fetch_array($tuto);
$tutor = $tut[0];
if (stristr($_SESSION['cargo'],'1') or stristr($_SESSION['cargo'],'2') or stristr($_SESSION['cargo'],'8') or $_SESSION['profi']==$tutor) {
echo "<h3>Intervenciones de tutoría</h3>";
if (stristr($_SESSION['cargo'],'1') or stristr($_SESSION['cargo'],'8')) {$prohibido="";}else{$prohibido=" and prohibido = '0'";}
$alumno=mysqli_query($db_con, "select tutoria.fecha, accion, causa, tutoria.observaciones from tutoria where tutoria.claveal = '$claveal' $prohibido");

if (mysqli_num_rows($alumno) < 1)
{ 
echo '<h3 class="text-muted">El alumno/a no tiene intervenciones de tutoría</h3>
<br>';
}
else 
{
echo "<h4 class=\"text-info\">Tutor/a: ".mb_convert_case($tutor, MB_CASE_TITLE, "iso-8859-1")."</h4><br />";

  
echo "<div class=\"table-responsive\"><table class='table table-bordered table-striped table-hover'>\n";  	
echo "<thead><tr>
<th>Fecha</th>
<th>Clase</th>
<th>Causa</th>
</tr></thead>";
while($row = mysqli_fetch_array($alumno)){
  $obs=$row[3];
  $dia3 = explode("-",$row[0]);
  $fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
echo "<tr><td>$fecha3</td><td>$row[1]</td><td>$row[2]</td></tr>";
}
echo "</table></div>";				  
}
}
?>
