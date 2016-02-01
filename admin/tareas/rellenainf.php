<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");

$id_alumno = mysqli_real_escape_string($db_con, $_POST['ident']);
$asignatura = mysqli_real_escape_string($db_con, $_POST['asignatura']);
$informe = mysqli_real_escape_string($db_con, $_POST['informe']);
$profesor = mysqli_real_escape_string($db_con, $_POST['profesor']);
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tareas <small> Redactar Informe por asignatura</small></h2>
</div>
<br>

<div class="col-md-8 col-md-offset-2">	
<?php
if (empty($informe) or empty($asignatura) or empty($id_alumno)) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
Los datos no están completos.<br>Debes seleccionar Asignatura y rellenar el Informe de Tareas.<br>Vuelve a la página anterior y rellena todos los datos.
<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
		</div></div>';
	exit;

}
else
{
$ya_hay=mysqli_query($db_con, "select tarea from tareas_profesor where asignatura = '$asignatura' and id_alumno = '$id'");
$ya_hay1=mysqli_fetch_row($ya_hay);
if (strlen($ya_hay1[0]) > '0') {
	mysqli_query($db_con, "update tareas_profesor set tarea = '$informe' where id_alumno = '$id' and asignatura = '$asignatura'") or die("<br><center><p>El Informe no ha podido ser actualizado. Busca ayuda. </p></center>");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido actualizado correctamente. Puedes comprobar los datos más abajo. 
		</div></div>';
}
else{
	mysqli_query($db_con, "insert into tareas_profesor (id_alumno,profesor,asignatura,tarea) values ('$id_alumno','$profesor','$asignatura','$informe')") or die("<center><p>El Informe no ha podido ser registrado. Busca ayuda. </p></center>");
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido guardado correctamente. Puedes comprobar los datos más abajo. 
		</div></div>';	}	
}
	
	


$alumno=mysqli_query($db_con, "SELECT APELLIDOS,NOMBRE,tareas_alumnos.unidad,tareas_alumnos.id,tutor, FECHA, duracion FROM tareas_alumnos, FTUTORES WHERE FTUTORES.unidad = tareas_alumnos.unidad and ID='$id_alumno'");
$dalumno = mysqli_fetch_array($alumno);
echo "<br><h4>Alumno: $dalumno[1] $dalumno[0] ($dalumno[2])</h4><h4> Fecha de Expulsión: $dalumno[5] ($dalumno[6] días)</h4><h4>Tutor: $dalumno[4]</h4><br />";
$datos=mysqli_query($db_con, "SELECT asignatura, tarea, id FROM tareas_profesor WHERE id_alumno='$id_alumno'");
// echo "SELECT asignatura, tarea FROM tareas_profesor WHERE id_alumno='$id'";
if(mysqli_num_rows($datos) > 0)
{
echo "<table class='table' align='center'>";
	while($informe = mysqli_fetch_array($datos))
{
$fondo = "";
if($informe[0] == $asignatura){$fondo=" class='info' ";}
	echo "<tr $fondo><td nowrap >".stripslashes($informe[0])."</td>
		  <td>".stripslashes($informe[1])."</td>";
	echo "<td><a href='borrar.php?del=1&id_del=$informe[2]&id_alumno=$id_alumno&asignatura=".stripslashes($asignatura)."&profesor=".stripslashes($profesor)."' data-bb='confirm-delete'><i class='fa fa-trash-o' title='Borrar' > </i> </a></td>";
	echo"</tr>";
}
echo"</table>";
}
?>
</div>
</div>
</div>

<?php include("../../pie.php");?>		

</body>
</html>
