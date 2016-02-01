<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
$trozos = explode (", ", $al);
$apellidos = $trozos[0];
$nombre = $trozos[1];

$result0 = mysqli_query($db_con, "select distinct apellidos, nombre, claveal from tutoria where orienta = '1' order by fecha desc");
//echo "select distinct apellidos, nombre, claveal from tutoria where orienta = '1' order by fecha asc";
$n_filas = mysqli_num_rows($result0);
if($n_filas > 0) 
{
	echo '<table class="table table-striped table-bordered datatable">';
	echo "<thead><tr><th>Alumno</th><th>Fecha</th></tr></thead><tbody>";
  	while($alumn = mysqli_fetch_array($result0))
  	{
 		$clave=$alumn[2];
    		$result = mysqli_query($db_con, "select distinct apellidos, nombre, fecha, accion, causa, observaciones, unidad, tutor, id, prohibido from tutoria where orienta = '1' and claveal = '$clave' order by fecha desc limit 1");
		while($row = mysqli_fetch_array($result))
		{
			$id3 = $row[8];
			$prohibido = $row[9];
			echo "<tr><td><a href='tutor.php?id=$id3'>$row[1] $row[0]</a></div></td><td nowrap>$row[2]</td></tr>";
		}	
  	}
	echo "</tbody></table>";
}
?>
