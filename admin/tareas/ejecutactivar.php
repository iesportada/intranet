<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tareas <small> Expulsión o ausencia del Alumno</small></h2>
</div>
<br>
          
<?php
$tutor = $_POST['tutor'];
$alumno = $_POST['alumno'];

if(empty($_POST['alumno']) or empty($_POST['tutor']))
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
						<legend>Atención:</legend>
Debes rellenar todos los datos, y parece que te has olvidado del Alumno o del Tutor.<br>Vuelve atrás e inténtalo de nuevo.<br /><br />
<input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-primary">
</div></div>';
exit;
}
?>
  <?php
#Vamos a rellenar los datos del alumno objeto del informe en la base de datos infotut
$duracion2 = $duracion + 1;
$fecha = cambia_fecha($fecha);
$trozos = explode (" --> ", $alumno);
$claveal = $trozos[1];
$nombre_comp = $trozos[0];
$trozos1 = explode (", ", $nombre_comp);
$apellidos = $trozos1[0];
$nombre = $trozos1[1];
$falumno=mysqli_query($db_con, "SELECT CLAVEAL, APELLIDOS, NOMBRE, unidad, matriculas,
COMBASI FROM alma WHERE claveal = '$claveal'");
$dalumno = mysqli_fetch_array($falumno);
$asignaturas=chunk_split($dalumno[5],3,"-");
$asig=explode("-",$asignaturas);

$duplicado = mysqli_query($db_con, "select claveal from tareas_alumnos where claveal = '$dalumno[0]' and fecha = '$fecha'");
if(mysqli_num_rows($duplicado)>0)
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
						<legend>Atención:</legend>';
			echo "Ya hay un <b>Informe de Tareas</b> activado para el alumno/a <b> $nombre $apellidos </b>para el día
<b>";
echo formatea_fecha($fecha);
			echo "</b>, y no queremos duplicarlo, verdad?";
echo '<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-primary">
		</div></div>';
}
else{

$insertar=mysqli_query($db_con, "INSERT tareas_alumnos (CLAVEAL,APELLIDOS,NOMBRE,unidad,FECHA,DURACION,PROFESOR,FIN)
 VALUES ('$dalumno[0]','$dalumno[1]','$dalumno[2]','$dalumno[3]','$fecha',$duracion,'$tutor',date_add('$fecha',interval $duracion2 day))") or die ("Error, no se ha podido activar el informe:".mysqli_error($db_con));
  echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo "El <b>Informe de tareas</b> del alumno/a <b> $nombre $apellidos </b>para el día <b>";
echo formatea_fecha($fecha);
echo "</b> se ha activado correctamente.";
echo '<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-primary">
		</div></div>';
}
mysqli_close();
?>
</div>
</div>
	<?php include("../../pie.php");?>								
</body>
</html>