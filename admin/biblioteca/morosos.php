<?php
require('../../bootstrap.php');

include("../../menu.php");
include("menu.php");
?>
<br>
<div class="container">
<div class="row">
<div class="page-header">
<h2>Biblioteca <small> Edición de morosos</small></h2>
</div>
<br>

<div class="col-sm-6 col-sm-offset-3"><?php
if(isset($_FILES['archivo'])){
	mysqli_query($db_con,"create table morosos_tmp select * from morosos");
	mysqli_query($db_con,"truncate table morosos_tmp");
	$archivo = $_FILES['archivo'];
	
	ini_set('auto_detect_line_endings',TRUE);
	$handle = fopen ($_FILES['archivo']['tmp_name'] , 'r' ) or die
	('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No se ha podido abrir el archivo exportado. O bien te has olvidado de enviarlo o el archivo está corrompido.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
	while (($data1 = fgetcsv($handle, 1000, ";")) !== FALSE)
	{

		$tr_f = explode("/",$data1[4]);
		$fecha_ed = $tr_f[2]."-".$tr_f[1]."-".$tr_f[0];
		$hoy = date('Y-m-d');
		
		mysqli_query($db_con, "INSERT INTO morosos_tmp (curso, apellidos, nombre, ejemplar, devolucion, hoy) VALUES ('". $data1[0]. "','". $data1[1]. "','". $data1[2] . "','". $data1[3] ."','". $fecha_ed ."', '".$hoy."')");		

		$dup = mysqli_query($db_con, "select * from morosos where curso = '$data1[0]' and apellidos = '$data1[1]' and nombre = '$data1[2]' and ejemplar = '$data1[3]' and devolucion = '$fecha_ed'");

		if (mysqli_num_rows($dup)>0) {}
		else{
			$datos1 = mysqli_query($db_con, "INSERT INTO morosos (curso, apellidos, nombre, ejemplar, devolucion, hoy) VALUES ('". $data1[0]. "','". $data1[1]. "','". $data1[2] . "','". $data1[3] ."','". $fecha_ed ."', '".$hoy."')");
		}
	}

	mysqli_query($db_con, "delete from morosos where apellidos = '' and nombre = '' and ejemplar = ''");
	mysqli_query($db_con, "delete from morosos_tmp where apellidos = '' and nombre = '' and ejemplar = ''");

	fclose($handle);
	
	$del = mysqli_query($db_con, "select curso, apellidos, nombre, ejemplar, devolucion from morosos");
	while ($delete = mysqli_fetch_array($del)) {
		$dup = mysqli_query($db_con, "select * from morosos_tmp where curso = '$delete[0]' and apellidos = '$delete[1]' and nombre = '$delete[2]' and ejemplar = '$delete[3]' and devolucion = '$delete[4]'");
		if (mysqli_num_rows($dup)>0) {}
		else{
                    mysqli_query($db_con, "delete from morosos where curso = '$delete[0]' and apellidos = '$delete[1]' and nombre = '$delete[2]' and ejemplar = '$delete[3]' and devolucion = '$delete[4]'");
		}
	}

		
	$borrar1 = mysqli_query($db_con, "delete from morosos where curso='Informe' or curso like 'Abies%' or apellidos like 'Depósito'");
	
	?>
<div align="center">
<div class="alert alert-success alert-block fade in"><legend>ATENCI&Oacute;N:</legend>
La actualizaci&oacute;n se ha realizado con &eacute;xito. Vuelve
atr&aacute;s y compru&eacute;balo. </div>
</div>
<br />
<div align="center"><input type="button" value="Volver atr&aacute;s"
	name="boton" onClick="history.back(2)" class="btn btn-inverse" /></div>

	<?php
}
mysqli_query($db_con,"drop table morosos_tmp");
?></div>
</div>
</div>

	<?php include("../../pie.php"); ?>
	
</body>
</html>