<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

echo "<h3>Informes de Tutoría</h3>";

$alumno=mysqli_query($db_con, "SELECT APELLIDOS,NOMBRE,unidad,TUTOR,CLAVEAL, F_ENTREV, ID FROM infotut_alumno WHERE CLAVEAL = '$claveal'");

if (mysqli_num_rows($alumno) < 1)
{ 
echo '<h3 class="text-muted">El alumno/a no tiene informes de tutoría.</h3>
<br>';
}
else 
{
$tuto = mysqli_query($db_con, "select tutor from FTUTORES where unidad = '$unidad'");
$tut = mysqli_fetch_array($tuto);
$tutor = $tut[0];
echo "<h4 class=\"text-info\">Tutor/a: ".mb_convert_case($tutor, MB_CASE_TITLE, "iso-8859-1")."</h4>
<br />";

while ($dalumno = mysqli_fetch_array($alumno))
{
$id = $dalumno[6];
echo "<br /><h4>Fecha: $dalumno[5]</h4><br />";
$datos=mysqli_query($db_con, "SELECT asignatura, informe FROM infotut_profesor WHERE id_alumno = '$id'");
echo "<table class='table table-striped' style='width:95%'>
		<TR><Th nowrap>Asignatura</th>
  <Th>Informe del profesor</th></tr>";
while($informe = mysqli_fetch_array($datos))
{
			    echo "<tr><td>$informe[0]</td>
			      <td>$informe[1]</td>";
				echo"</tr>";
				
				  }
echo"</table>";

				  }
				  
}
?>
