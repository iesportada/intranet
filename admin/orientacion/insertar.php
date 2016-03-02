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
foreach($accion as $tipos)
{
$completo .= $tipos."; ";
}

if (empty($prohibido)){$prohibido = "0";}
$tutor = "Departamento de Orientación";
$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
$trozos = explode (", ", $al);
$apellidos = $trozos[0];
$nombre = $trozos[1];

$dia = explode("-",$fecha_reg);
$fecha2 = "$dia[2]-$dia[1]-$dia[0]";

$query="insert into tutoria (apellidos, nombre, tutor, unidad, observaciones,causa,accion,fecha, orienta, prohibido,claveal) values ('".$apellidos."','".$nombre."','".$tutor."','".$unidad."','".$observaciones."','".$causa."','".$completo."','".$fecha2."','1','".$prohibido."','".$clave."')";
mysqli_query($db_con, $query);
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han introducido correctamente.
</div></div><br />';

// Mensaje al Tutor
if($prohibido=="0") {
$tt = mysqli_query($db_con,"select idea from departamentos where nombre like (select tutor from FTUTORES where unidad = '$unidad')");
$tt0 = mysqli_fetch_row($tt);
$tutor_real = $tt0[0];

$asunto = "Nueva Intervención de Tutoría desde el Departamento de Orientación";
$texto = "El Departamento de Orientación ha registrado una intervención sobre el alumno $nombre $apellidos de tu Tutoría. Podrás leerla en la lista de intervenciones del alumno de la página del tutor.";
$profesor = $_SESSION['profi'];

$query0="insert into mens_texto (asunto, texto, origen) values ('".$asunto."','".$texto."','".$profesor."')";
mysqli_query($db_con, $query0);
$id0 = mysqli_query($db_con, "select id from mens_texto where asunto = '$asunto' and texto = '$texto' and origen = '$profesor'");
$id1 = mysqli_fetch_array($id0);
$id = $id1[0];
			
$query1="insert into mens_profes (id_texto, profesor) values ('".$id."','".$tutor_real."')";
mysqli_query($db_con, $query1);
}

?>