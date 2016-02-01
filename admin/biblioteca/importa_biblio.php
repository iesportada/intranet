<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 'c'));

include("../../menu.php");
include("menu.php");
?>
<br>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Biblioteca <small> Importación de libros desde Abies</small></h2>
</div>
<br>

<div class="col-sm-6 col-sm-offset-3">
<div class="well">

<?php
if (isset($_POST['enviar1'])) {	

ini_set('auto_detect_line_endings', true);
$fp = fopen ($_FILES['archivo1']['tmp_name'] , "r" ) or die ("<br><blockquote>No se ha podido abrir el fichero.<br> Asegúrate de que su formato es correcto.</blockquote>");
mysqli_query($db_con, "drop table biblioteca_seg");
mysqli_query($db_con, "create table biblioteca_seg select * from biblioteca");
mysqli_query($db_con, "drop table biblioteca");
mysqli_query($db_con, "CREATE TABLE if not exists `biblioteca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Autor` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `Titulo` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `Editorial` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `ISBN` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `Tipo` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `anoEdicion` int(4) NOT NULL,
  `extension` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `serie` int(11) NOT NULL,
  `lugaredicion` varchar(48) COLLATE latin1_spanish_ci NOT NULL,
  `tipoEjemplar` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `ubicacion` varchar(32) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ");

$reg=0;

echo "<legend align='center'>Listados de libros procesados</legend>";

while (( $data = fgetcsv ( $fp , 1000, ';' )) !== FALSE ) {
	$reg+=1;
	$sql="	INSERT INTO  biblioteca (Autor, Titulo, Editorial, ISBN, Tipo, anoEdicion, extension, serie, lugaredicion, tipoEjemplar, Ubicacion) VALUES (";
	$sql.="	'$data[0]',  '$data[1]',  '$data[2]',  '$data[3]',  '$data[4]',  '$data[5]',  '$data[6]',  '$data[7]',  '$data[8]',  '$data[9]',  '$data[10]')";

	mysqli_query($db_con, $sql);    
} 
fclose ( $fp ); 
mysqli_query($db_con, "delete from biblioteca where titulo='' and editorial='' and ubicacion=''");
mysqli_close();
echo "<div align='center' class='text-success'><b>Se han importado un total de ",$reg," libros a la base de datos</b></div>";
}


if (isset($_POST['enviar2'])) {	

ini_set('auto_detect_line_endings', true);
$fp = fopen ($_FILES['archivo2']['tmp_name'] , "r" ) or die ("<br><blockquote>No se ha podido abrir el fichero.<br> Asegúrate de que su formato es correcto.</blockquote>");
mysqli_query($db_con, "drop table biblioteca_lectores_seg");
mysqli_query($db_con, "create table biblioteca__lectores_seg select * from biblioteca_lectores");
mysqli_query($db_con, "drop table biblioteca_lectores");
mysqli_query($db_con, "CREATE TABLE if not exists `biblioteca_lectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `DNI` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `Apellidos` varchar(48) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre` varchar(32) COLLATE latin1_spanish_ci NOT NULL,
  `Grupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ");

$reg=0;

echo "<legend align='center'>Listados de libros procesados</legend>";

while (( $data = fgetcsv ( $fp , 1000, ';' )) !== FALSE ) {
	$reg+=1;
	$sql="	INSERT INTO  biblioteca_lectores (Codigo, DNI, Apellidos, Nombre, Grupo) VALUES (";
	$sql.="	'$data[0]',  '$data[1]',  '$data[2]',  '$data[3]',  '$data[4]')";
	mysqli_query($db_con, $sql);    
} 
mysqli_query($db_con, "delete from biblioteca_lectores where grupo=''");
fclose ( $fp ); 
mysqli_close();
echo "<div align='center' class='text-success'><b>Se han importado un total de ",$reg," Lectores a la base de datos</b></div>";
}
echo "</div></div></div></div>";
?>

	<?php include("../../pie.php"); ?>
	
</body>
</html>