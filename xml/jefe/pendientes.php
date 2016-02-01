<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

mysqli_query($db_con, "drop TABLE pendientes");
mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS pendientes (
  id int(11) NOT NULL auto_increment,
  claveal varchar(9) collate latin1_spanish_ci NOT NULL default '',
  codigo varchar(8) collate latin1_spanish_ci NOT NULL default '',
  grupo varchar(32) collate latin1_spanish_ci NOT NULL default '',  
  PRIMARY KEY  (id),
  KEY  claveal (claveal),
  KEY codigo (codigo)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci ");

$cur = mysqli_query($db_con,"select claveal, combasi, unidad, curso from alma where curso not like '1%'");
while ($uni = mysqli_fetch_array($cur)) {
	$claveal = $uni[0];
	$combasi = $uni[1];
	$unidad = $uni[2];
	$curso = $uni[3];
	
$trozos1 = explode(":", $combasi);
 foreach ($trozos1 as $asig)
  {
$nombreasig = "select NOMBRE, ABREV, CURSO, CODIGO from asignaturas where CODIGO = '" . $asig . "' and curso = '$curso' and abrev like '%\_%'";
$asig2 = mysqli_query($db_con, $nombreasig);
if (mysqli_num_rows($asig2)>0) {
	$cod = "INSERT INTO pendientes VALUES ('', '$claveal', '$asig', '$unidad')";	
	mysqli_query($db_con, $cod);
}
  }	
}
?>
<div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5>ALUMNOS CON ASIGNATURAS PENDIENTES:</h5>
Los alumnos con asignaturas pendientes han sido importados en la base de datos. Ya es posible realizar consultas y ver listados de pendientes por Grupo o Asignatura (Menú de la página principal ==> Consultas ==> Listados ==> Listas de Pendientes).
</div>
 <br />
