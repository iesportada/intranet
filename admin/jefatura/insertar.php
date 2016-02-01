<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

// Control de errores
if (!$fecha_reg or !$observaciones or !$causa or !$accion)
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has introducido datos en alguno de los campos , y <strong> todos son obligatorios</strong>.<br> Vuelve atrás e inténtalo de nuevo.
</div></div><br />';
exit();
}

if ($alumno == "Todos los Alumnos") {
$todos0 = mysqli_query($db_con, "select distinct claveal, apellidos, nombre from FALUMNOS where unidad = '$unidad'");
while ($todos = mysqli_fetch_array($todos0)) {
$clave=$todos[0];	
if (empty($prohibido)){$prohibido = "0";}
$tutor = "Jefatura de Estudios";
$apellidos = $todos[1];
$nombre = $todos[2];
$dia = explode("-",$fecha_reg);
$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
		$query="insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha, jefatura, prohibido, claveal) values 
		('".$apellidos."','".$nombre."','".$tutor."','".$unidad."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','1','".$prohibido."','".$clave."')";
		 // echo $query;
mysqli_query($db_con, $query);
//echo $query."<br>";
}
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han introducido correctamente.
</div></div><br />';
}
else{
if (empty($prohibido)){$prohibido = "0";}
$tutor = "Jefatura de Estudios";
$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
$trozos = explode (", ", $al);
$apellidos = $trozos[0];
$nombre = $trozos[1];
$dia = explode("-",$fecha_reg);
$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
if($fecha2=="0000-00-00"){$fecha2=date('Y-m-d');}
		$query="insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha, jefatura, prohibido, claveal) values 
		('".$apellidos."','".$nombre."','".$tutor."','".$unidad."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','1','".$prohibido."','".$clave."')";
		 // echo $query;
mysqli_query($db_con, $query);
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han introducido correctamente.
</div></div><br />';
}
  $al0 = mysqli_query($db_con, "select distinct id, FALUMNOS.claveal, tutoria.claveal from tutoria, FALUMNOS where tutoria.apellidos=FALUMNOS.apellidos and tutoria.nombre=FALUMNOS.nombre and tutoria.unidad=FALUMNOS.unidad order by id");
  while($al1 = mysqli_fetch_array($al0))
  {
 $claveal = $al1[1];
 $clave_tut = $al1[2];
 $id = $al1[0];
 if (empty($clave_tut)) {
 	mysqli_query($db_con, "update tutoria set claveal='$claveal' where id='$id'");
 }
}
$id="";
?>
