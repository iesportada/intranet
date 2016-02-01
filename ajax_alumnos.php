<?php
require_once('bootstrap.php');

header('Content-Type: text/html; charset=ISO-8859-1');
// Fichero que realiza la consulta en la base de datos y devuelve los resultados
if(isset($_POST["word"]))
{

	if($_POST["word"]{0}=="*"){
		$result=mysqli_query($db_con, "SELECT CONCAT(apellidos,', ',nombre) AS alumno, claveal, unidad FROM alma WHERE CONCAT(apellidos,' ',nombre) LIKE '%".substr($_POST["word"],1)."%' and CONCAT(apellidos,' ',nombre)<>'".$_POST["word"]."' OR claveal like '".$_POST["word"]."%' ORDER BY alumno LIMIT 10");}
	else{
		$result=mysqli_query($db_con, "SELECT CONCAT(apellidos,', ',nombre) AS alumno, claveal, unidad FROM alma WHERE (CONCAT(apellidos,' ',nombre) LIKE '%".$_POST["word"]."%' and CONCAT(apellidos,' ',nombre) like '%".$_POST["word"]."%') or (CONCAT(nombre,' ',apellidos) LIKE '%".$_POST["word"]."%' and CONCAT(nombre,' ',apellidos) like '%".$_POST["word"]."%') OR claveal like '".$_POST["word"]."%' ORDER BY alumno LIMIT 10");
	}
	echo '<ul class="nav nav-pills nav-stacked">';
	while($row=mysqli_fetch_array($result))
	{
		// Mostramos las lineas que se mostraran en el desplegable.
		$datos=$row[0];
		$clave_al=$row[1];
		$curso_al=$row[2];
		echo '
<li><a href="admin/datos/datos.php?seleccionado=1&alumno='.$datos.' --> '.$clave_al.'"><span class="pull-right">'.$curso_al.'</span> '.$datos.' </a></li>';
	}
	echo '</ul>';
}
?>
