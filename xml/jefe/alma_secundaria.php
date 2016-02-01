<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Administración <small> Alumnos de ESO</small></h2>
</div>
<br />
<div class="well well-large" style="width:600px;margin:auto;text-align:left">
<?php
if($_FILES['archivo1']){
// Creamos Base de datos y enlazamos con ella.
 $base0 = "DROP TABLE `alma_secundaria`";
 mysqli_query($db_con, $base0);

 // Creación de la tabla alma
 $alumnos = "CREATE TABLE  `alma_secundaria` (
`Alumno/a` varchar( 255 ) default NULL ,
 `ESTADOMATRICULA` varchar( 255 ) default NULL ,
 `CLAVEAL` varchar( 12 ) default NULL ,
 `DNI` varchar( 10 ) default NULL ,
 `DOMICILIO` varchar( 255 ) default NULL ,
 `CODPOSTAL` varchar( 255 ) default NULL ,
 `LOCALIDAD` varchar( 255 ) default NULL ,
 `FECHA` varchar( 255 ) default NULL ,
 `PROVINCIARESIDENCIA` varchar( 255 ) default NULL ,
 `TELEFONO` varchar( 255 ) default NULL ,
 `TELEFONOURGENCIA` varchar( 255 ) default NULL ,
 `CORREO` varchar( 64 ) default NULL ,
 `CURSO` varchar( 255 ) default NULL ,
 `NUMEROEXPEDIENTE` varchar( 255 ) default NULL ,
 `UNIDAD` varchar( 255 ) default NULL ,
 `apellido1` varchar( 255 ) default NULL ,
 `apellido2` varchar( 255 ) default NULL ,
 `NOMBRE` varchar( 30 ) default NULL ,
 `DNITUTOR` varchar( 255 ) default NULL ,
 `PRIMERAPELLIDOTUTOR` varchar( 255 ) default NULL ,
 `SEGUNDOAPELLIDOTUTOR` varchar( 255 ) default NULL ,
 `NOMBRETUTOR` varchar( 255 ) default NULL ,
 `SEXOPRIMERTUTOR` varchar( 255 ) default NULL ,
 `DNITUTOR2` varchar( 255 ) default NULL ,
 `PRIMERAPELLIDOTUTOR2` varchar( 255 ) default NULL ,
 `SEGUNDOAPELLIDOTUTOR2` varchar( 255 ) default NULL ,
 `NOMBRETUTOR2` varchar( 255 ) default NULL ,
 `SEXOTUTOR2` varchar( 255 ) default NULL ,
 `LOCALIDADNACIMIENTO` varchar( 255 ) default NULL ,
  `FECHAMATRICULA` varchar( 255 ) default NULL ,
 `MATRICULAS` varchar( 255 ) default NULL ,
 `OBSERVACIONES` varchar( 255 ) default NULL,
 `PROVINCIANACIMIENTO` varchar( 255 ) default NULL ,
 `PAISNACIMIENTO` varchar( 255 ) default NULL ,
 `EDAD` varchar( 2 ) default NULL ,
 `NACIONALIDAD` varchar( 32 ) default NULL,
 `SEXO` varchar( 1 ) default NULL ,
 `COLEGIO` varchar( 32 ) default NULL 
 ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci ";

 
 //echo $alumnos;
mysqli_query($db_con, $alumnos) or die ('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear la tabla <strong>Alma_secundaria</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');

  $SQL6 = "ALTER TABLE  `alma_secundaria` ADD INDEX (  `CLAVEAL` )";
  $result6 = mysqli_query($db_con, $SQL6) or die ('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear el índice de la tabla. Busca ayuda.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');

  // Borramos archivos antiguos
$d = opendir('../secundaria/'); 
while (false !== ($f = readdir($d))) {
if (stristr($f, ".txt")){
	//echo "$f<br>";
	unlink($f);
} 
}
closedir($d);

// Descomprimimos el zip de las calificaciones en el directorio exporta/
include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo1']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH, '../secundaria') == 0) 
	  {
        die("Error : ".$archive->errorInfo(true));
      } 

// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir('../secundaria')) {
   while (false !== ($file = readdir($handle))) {   	
      if ($file != "." && $file != ".." && $file != ".txt") { 
      $colegio = substr($file,0,-4); 
// Importamos los datos del fichero CSV (todos_alumnos.csv) en la tabña alma.

$fp = fopen ('../secundaria/'.$file , "r" ) or die('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se han podido abrir los archivos de datos. ¿Están los archivos de los Centros en el directorio ../secundaria?
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>'); 
$row = 1;
 while (!feof($fp))
{
  	$linea="";
  	$lineasalto="";
  	$dato="";
    $linea=fgets($fp);
    $lineasalto = "INSERT INTO alma_secundaria VALUES (";
    $tr=explode("|",$linea);
    
    foreach ($tr as $valor){ 
      $dato.= "\"". trim($valor) . "\", ";
        }
    $dato=substr($dato,0,strlen($dato)-2); 
    $lineasalto.=$dato; 
    $lineasalto.=", \"I.E.S. $colegio\"";
    $lineasalto.=");";
    //echo $lineasalto."<br>";
    mysqli_query($db_con, $lineasalto);
}
fclose($fp);




      }
      
   }
   closedir($handle);
}  
 
// Procesamos datos
$crear = "ALTER TABLE  alma_secundaria
ADD  `APELLIDOS` VARCHAR( 40 ) NULL AFTER  `UNIDAD` ,
ADD  `NIVEL` VARCHAR( 5) NULL AFTER  `NOMBRE` ,
ADD  `GRUPO` VARCHAR( 1 ) NULL AFTER  `NIVEL`,
ADD  `PADRE` VARCHAR( 78 ) NULL AFTER  `GRUPO`
";
mysqli_query($db_con, $crear);

// Separamos Nivel y Grupo si sigue el modelo clásico del guión (1E-F, 2B-C, etc)
  $SQL_1 = "SELECT UNIDAD, CLAVEAL  FROM  alma_secundaria";
  $result_1 = mysqli_query($db_con, $SQL_1);  
 while  ($row0 = mysqli_fetch_array($result_1))
 {
if (substr($row0[0],-1)=="A") {
	$unidad_cole = "4E-A";
}
elseif (substr($row0[0],-1)=="B") {
	$unidad_cole = "4E-B";
}
 elseif (substr($row0[0],-1)=="C") {
	$unidad_cole = "4E-C";
}
 elseif (substr($row0[0],-1)=="D") {
	$unidad_cole = "4E-A";
}
  elseif (substr($row0[0],-1)=="E") {
	$unidad_cole = "4E-E";
}
  elseif (substr($row0[0],-1)=="F") {
	$unidad_cole = "4E-F";
}
ELSE{
	$unidad_cole = "4E-A";
} 	
$trozounidad0 = explode("-",$unidad_cole);
$actualiza= "UPDATE alma_secundaria SET UNIDAD = '$unidad_cole', NIVEL = '$trozounidad0[0]', GRUPO = '$trozounidad0[1]' where CLAVEAL = '$row0[1]'";
mysqli_query($db_con, $actualiza);
 }

  
 // Apellidos unidos formando un solo campo.
   $SQL2 = "SELECT apellido1, apellido2, CLAVEAL, NOMBRE FROM  alma_secundaria";
  $result2 = mysqli_query($db_con, $SQL2);
 while  ($row2 = mysqli_fetch_array($result2))
 {
 	$apellidos = trim($row2[0]). " " . trim($row2[1]);
	$apellidos1 = trim($apellidos);
	$nombre = $row2[3];
	$nombre1 = trim($nombre);
	$actualiza1= "UPDATE alma_secundaria SET APELLIDOS = \"". $apellidos1 . "\", NOMBRE = \"". $nombre1 . "\" where CLAVEAL = \"". $row2[2] . "\"";
	mysqli_query($db_con, $actualiza1);
 }
 
 // Apellidos y nombre del padre.
   $SQL3 = "SELECT PRIMERAPELLIDOTUTOR, SEGUNDOAPELLIDOTUTOR, NOMBRETUTOR, CLAVEAL FROM  alma_secundaria";
  $result3 = mysqli_query($db_con, $SQL3);
 while  ($row3 = mysqli_fetch_array($result3))
 {
 	$apellidosP = trim($row3[2]). " " . trim($row3[0]). " " . trim($row3[1]);
	$apellidos1P = trim($apellidosP);
	$actualiza1P= "UPDATE alma_secundaria SET PADRE = \"". $apellidos1P . "\" where CLAVEAL = \"". $row3[3] . "\"";
	mysqli_query($db_con, $actualiza1P);
 }
 
  // Eliminación de campos innecesarios por repetidos
  $SQL3 = "ALTER TABLE alma_secundaria
  DROP `apellido1`,
  DROP `Alumno/a`,
  DROP `apellido2`,
  DROP `estadomatricula`";
  $result3 = mysqli_query($db_con, $SQL3);

  // Eliminación de alumnos dados de baja
    $SQL4 = "DELETE FROM alma_secundaria WHERE `unidad` = ''";
    $SQL5 = "DELETE FROM alma_secundaria WHERE `claveal` = 'Nº Id. Escol'";
    $result4 = mysqli_query($db_con, $SQL4);
    $result5 = mysqli_query($db_con, $SQL5);
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La tabla de Alumnos de Secundaria para la Matriculación ha sido creada.<br />Ya puedes proceder a matricular a los niños de los Centros.
</div></div><br />';
}
else
{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que te estás olvidando de enviar el archivo con los datos de los alumnos. Asegúrate de enviar el archivo comprimido con los datos de los Centros.
</div></div><br />';
}
?>
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div></div>
</div>
</body>
</html>