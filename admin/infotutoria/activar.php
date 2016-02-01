<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>
<div class="container">
<div class="row">
<div class="page-header">
<h2>Informes de Tutoría <small> Activar Informe</small></h2>
</div>
<br>
 <?php
if(empty($_POST['alumno']) or empty($_POST['tutor']))
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>
Debes rellenar todos los datos, y parece que te has olvidado del Alumno o del Tutor.<br>Vuelve atrás e inténtalo de nuevo.<br /><br />
<input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-primary">
</div></div><hr>';
exit;
}
#Vamos a rellenar los datos del alumno objeto del informe en la base de datos infotut
$fecha = cambia_fecha($fecha);
$trozos = explode (" --> ", $alumno);
$claveal = $trozos[1];
$nombre_comp = $trozos[0];
$trozos1 = explode (", ", $nombre_comp);
$apellidos = $trozos1[0];
$nombre = $trozos1[1];
$falumno=mysqli_query($db_con, "SELECT CLAVEAL, APELLIDOS, NOMBRE, unidad, matriculas, COMBASI FROM alma WHERE claveal ='$claveal'");
$dalumno = mysqli_fetch_array($falumno);
$asignaturas=chunk_split($dalumno[5],3,"-");
$asig=explode("-",$asignaturas);
$hoy = date('Y\-m\-d');

$duplicado = mysqli_query($db_con, "select claveal from infotut_alumno where claveal = '$claveal' and f_entrev = '$fecha'");
if(mysqli_num_rows($duplicado)>0)
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>';
			echo "Ya hay un <b>Informe Tutorial</b> activado para el alumno/a <b> $nombre $apellidos </b>para el día
<b>";
echo formatea_fecha($fecha);
echo "</b>, y no queremos duplicarlo, verdad?";
echo '<br /><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-primary">
		</div></div>';
exit;
}

 $insertar=mysqli_query($db_con, "INSERT infotut_alumno (CLAVEAL,APELLIDOS,NOMBRE,unidad,F_ENTREV,TUTOR,FECHA_REGISTRO,motivo)
VALUES ('$dalumno[0]',\"$dalumno[1]\",'$dalumno[2]','$dalumno[3]',
'$fecha','".$_POST['tutor']."', '$hoy', '$motivo')") or die ("Error en la activación del informe: " . mysqli_error($db_con));

 echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo "El <b>Informe Tutorial</b> del alumno/a <b> $nombre $apellidos </b>para el día <b>";
echo formatea_fecha($fecha);
echo "</b> se ha activado.";
echo '</div>
</div>';
exit;
?>
</div>
</div>

	<?php include("../../pie.php");?>								
</body>
</html>
