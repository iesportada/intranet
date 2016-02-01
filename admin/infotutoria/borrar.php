<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>

<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tutoría <small> Borrar Informe</small></h2>
</div>
<br />
    
<?php
$alumno=mysqli_query($db_con, "SELECT APELLIDOS,NOMBRE,unidad,id,TUTOR, F_ENTREV FROM infotut_alumno WHERE ID='$id_alumno'");
$dalumno = mysqli_fetch_array($alumno);
echo "
<h4 align='center'>$dalumno[1] $dalumno[0] ($dalumno[2])<br> Visita: $dalumno[5]<br>Tutor: $dalumno[4]</h4><br />";
if ($del=='1') {
	mysqli_query($db_con, "delete from infotut_profesor where id = '$id_del'");
	if (mysqli_affected_rows()>'0') {
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido borrado sin problemas.
		</div></div>';
	}
}
$datos=mysqli_query($db_con, "SELECT asignatura, informe, id FROM infotut_profesor WHERE id_alumno='$id_alumno'");
if(mysqli_num_rows($datos) > 0)
{
echo "<table class='table table-striped' align='center' style='width:700px;'>";
while($informe = mysqli_fetch_array($datos))
{
$fondo = "";
if($informe[0] == $asignatura){$fondo="background-color:#FFFF66;";}
	echo "<tr><td style='color:black;$fondo'>$informe[0]</td>
		  <td style='$fondo'>$informe[1]</td>";
	if (strlen($fondo) > '0') {
		echo "<td><a href='borrar.php?del=1&id_del=$informe[2]&id_alumno=$id_alumno&asignatura=$asignatura&profesor=$profesor'><i class='fa fa-trash-o' title='Borrar'> </i> </a></td>";
	}
	echo"</tr>";
}
echo"</table>";
}
?>
</div>
</div>
<?php include("../../pie.php");?>
</body>
</html>
