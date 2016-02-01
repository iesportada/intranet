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
  <h2>Informes de Tutoría <small> Redactar Informe por asignatura</small></h2>
</div>
<br>

<div class="col-md-8 col-md-offset-2">	
<?php
if (empty($informe) or empty($asignatura)) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
Los datos no están completos.<br>Debes seleccionar Asignatura y rellenar el Informe.<br>Vuelve a la página anterior y rellena todos los datos.
<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
		</div></div>';
	exit;
}
$ya_hay=mysqli_query($db_con, "select informe from infotut_profesor where asignatura = '$asignatura' and id_alumno = '$id'");
$ya_hay1=mysqli_fetch_row($ya_hay);
if (strlen($ya_hay1[0]) > '0') {
mysqli_query($db_con, "update infotut_profesor set informe = '$informe' where id_alumno = '$id' and asignatura = '$asignatura'") or die("<br><center><p>El Informe no ha podido ser actualizado. Busca ayuda. </p></center>");
echo '<div align="center"><div class="alert alert-success alert-block fade in" >
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido actualizado correctamente. Puedes comprobar los datos más abajo. 
		</div></div>';
}
else{
mysqli_query($db_con, "insert into infotut_profesor (id_alumno,profesor,asignatura,informe) values ('$id_alumno','$profesor','$asignatura','$informe')") or die("<br><center><p>El Informe no ha podido ser registrado. Busca ayuda. </p></center>");
echo '<div align="center"><div class="alert alert-success alert-block fade in" >
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido guardado correctamente. Puedes comprobar los datos más abajo. 
		</div></div>';	
}

$alumno=mysqli_query($db_con, "SELECT APELLIDOS,NOMBRE,unidad,id,TUTOR, F_ENTREV FROM infotut_alumno WHERE ID='$id_alumno'");
$dalumno = mysqli_fetch_array($alumno);
echo "<br /><h4>$dalumno[1] $dalumno[0] ($dalumno[2])</h4> <h4>Visita: $dalumno[5]</h4><h4>Tutor: $dalumno[4]</h4><br />";
$datos=mysqli_query($db_con, "SELECT asignatura, informe, id FROM infotut_profesor WHERE id_alumno='$id_alumno'");
if(mysqli_num_rows($datos) > 0)
{
echo "<table class='table'>";
while($informe = mysqli_fetch_array($datos))
{
$fondo = "";
if($informe[0] == $asignatura){$fondo=" class='info' ";}
	echo "<tr $fondo><td nowrap>".stripslashes($informe[0])."</td>
		  <td>".stripslashes($informe[1])."</td>";
	if (strlen($fondo) > '0') {
		echo "<td><a href='borrar.php?del=1&id_del=$informe[2]&id_alumno=$id_alumno&asignatura=$asignatura&profesor=$profesor' data-bb='confirm-delete'><i class='fa fa-trash-o' title='Borrar' > </i> </a></td>";
	}
	echo"</tr>";
}
echo"</table>";
}
?>
<?php include("../../pie.php");?>		
</body>
</html>
