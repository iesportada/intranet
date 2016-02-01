<?php
require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$config['dominio'].'/intranet/salir.php');
exit;	
}
?>
<?php
include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Administración <small> Importación de calificaciones por Evaluación</small></h2>
</div>
<br />
<div class="well well-large" style="width:700px;margin:auto;text-align:left">
<?php
$directorio = $_GET['directorio'];
//echo $directorio."<br>";
if ($directorio=="../exporta1") {
	mysqli_query($db_con, "TRUNCATE TABLE notas");
}

// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir($directorio)) {
   while (false !== ($file = readdir($handle))) {   	
      if ($file != "." && $file != ".." && $file != "index.php") {
       	
$doc = new DOMDocument('1.0', 'utf-8');

$doc->load( $directorio.'/'.$file );

$claves = $doc->getElementsByTagName( "ALUMNO" );
 
/*Al ser $materias una lista de nodos
lo puedo recorrer y obtener todo
su contenido*/
foreach( $claves as $clave )
{	
$clave2 = $clave->getElementsByTagName( "X_MATRICULA" );
$clave3 = $clave2->item(0)->nodeValue;
//$codigo = "";
$materias = $clave->getElementsByTagName( "MATERIA_ALUMNO" );
if ($directorio=="../exporta1") {
$cod = "INSERT INTO notas VALUES ('$clave3', '";
}
if ($directorio=="../exporta2") {
	$cod = "update notas set notas2 = '";
}
if ($directorio=="../exportaO") {
	$cod = "update notas set notas3 = '";
}
if ($directorio=="../exportaE") {
	$cod = "update notas set notas4 = '";
}
foreach( $materias as $materia )
{		
$codigos = $materia->getElementsByTagName( "X_MATERIAOMG" );
$codigo = $codigos->item(0)->nodeValue;
$notas = $materia->getElementsByTagName( "X_CALIFICA" );
$nota = $notas->item(0)->nodeValue;
$codigo.=":";
$nota.=";";
$cod.=$codigo.$nota;
}
if ($directorio=="../exporta1") {
$cod.="', '', '', '')";
	}
	else{
$cod.="' where claveal = '$clave3'";
	}
// echo $cod."<br>";
mysqli_query($db_con, $cod);
}   	       
  }
   }
   closedir($handle);
   echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Las Notas de Evaluación se han importado correctamente en la base de datos.
</div></div>';
}  
else
{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que no hay archivos en el directorio correspondiente.<br> O bien no has enviado el archivo correcto descargado de Séneca o bien el archivo está corrompido.
</div></div>';
exit;
}

?>
<div align="center">
<input type="button" value="Volver atrás" name="boton" onclick="history.back(2)" class="btn btn-inverse" />
</div>
</div>
</div>
<?php include("../../pie.php");?>
</body>
</html>
