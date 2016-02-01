<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tareas <small> Borrar Informe</small></h2>
</div>
<br />
<?php
$alumno=mysqli_query($db_con, "SELECT APELLIDOS, NOMBRE, unidad, id, profesor, fecha FROM tareas_alumnos WHERE ID='$id_alumno'");
$dalumno = mysqli_fetch_array($alumno);
echo "
<h4 align='center'>$dalumno[1] $dalumno[0] ($dalumno[2])<br> Visita: $dalumno[5]<br>Tutor: $dalumno[4]</h4><br />";
if ($del=='1') {
	mysqli_query($db_con, "delete from tareas_profesor where id = '$id_del'");
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido borrado sin problemas.
		</div></div>';
}
?>
</div>
</div>
<?php include("../../pie.php");?>
</body>
</html>
