<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

$alumnos = "select distinct CLAVEAL, APELLIDOS, NOMBRE, UNIDAD from alma where claveal not in (select claveal from usuarioalumno)";
$sqlal = mysqli_query($db_con, $alumnos);
while ($sqlprof0 = mysqli_fetch_array($sqlal)) {
	$apellidos = $sqlprof0[1];
	$apellido = explode(" ",$sqlprof0[1]);
	$alternativo = strtolower(substr($sqlprof0[3],0,2));
	$nombreorig = $sqlprof0[2] . " " . $sqlprof0[1];
	$nombre = $sqlprof0[2];
	$claveal = $sqlprof0[0];
	if (substr($nombre,0,1) == "Á") {$nombre = str_replace("Á","A",$nombre);}
	if (substr($nombre,0,1) == "É") {$nombre = str_replace("É","E",$nombre);}
	if (substr($nombre,0,1) == "Í") {$nombre = str_replace("Í","I",$nombre);}
	if (substr($nombre,0,1) == "Ó") {$nombre = str_replace("Ó","O",$nombre);}
	if (substr($nombre,0,1) == "Ú") {$nombre = str_replace("Ú","U",$nombre);}
	
	$apellido[0] = str_replace("Á","A",$apellido[0]);
	$apellido[0] = str_replace("É","E",$apellido[0]);
	$apellido[0] = str_replace("Í","I",$apellido[0]);
	$apellido[0] = str_replace("Ó","O",$apellido[0]);
	$apellido[0] = str_replace("Ú","U",$apellido[0]);
	$apellido[0] = str_replace("á","a",$apellido[0]);
	$apellido[0] = str_replace("é","e",$apellido[0]);
	$apellido[0] = str_replace("í","i",$apellido[0]);
	$apellido[0] = str_replace("ó","o",$apellido[0]);
	$apellido[0] = str_replace("ú","u",$apellido[0]);
	$apellido[0] = str_replace("ü","u",$apellido[0]);
	$apellido[0] = str_replace("ö","o",$apellido[0]);
	$apellido[0] = str_replace("'","",$apellido[0]);

	
	$userpass = "a".strtolower(substr($nombre,0,1)).strtolower($apellido[0]);
	$userpass = str_replace("ª","",$userpass);
	$userpass = str_replace("ñ","n",$userpass);
	$userpass = str_replace("-","",$userpass);
	$userpass = str_replace("-","",$userpass);
	$userpass = str_replace("'","",$userpass);
	$userpass = str_replace("º","",$userpass);
	
	$usuario  = $userpass;
	$passw = $userpass . preg_replace('/([ ])/e', 'rand(0,9)', '   ');
	$unidad = $sqlprof0[3];
	$claveal = $sqlprof0[0];
	
	$insertar = "insert into usuarioalumno set nombre = '$nombreorig', usuario = '$usuario', pass = '$passw', perfil = 'a', unidad = '$unidad', claveal = '$claveal'";
	mysqli_query($db_con, $insertar);
}


$repetidos = mysqli_query($db_con, "select usuario from usuarioalumno");
while($num = mysqli_fetch_row($repetidos))
{
$n_a = "";
$repetidos1 = mysqli_query($db_con, "select usuario, claveal, unidad from usuarioalumno where usuario = '$num[0]'");
if (mysqli_num_rows($repetidos1) > 1) {
while($num1 = mysqli_fetch_row($repetidos1))
{
$n_a = $n_a +1;
$nuevo = $num1[0].$n_a;
mysqli_query($db_con, "update usuarioalumno set usuario = '$nuevo' where claveal = '$num1[1]'");
}	
}
}
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5>CENTRO TIC:</h5>
Los datos de los alumnos se han importado correctamente en la tabla "usuarioalumno".<br> Se ha generado un fichero (alumnos.txt) en el subdirectorio "xml/jefe/TIC/" preparado para el alta masiva en el Servidor TIC.
</div></div><br />';

// Código y abreviatura de la asignatura.
$codigo = "select  usuario, nombre, perfil from usuarioalumno";
//echo $codigo . "<br>";
$sqlcod = mysqli_query($db_con, $codigo);
while($row = mysqli_fetch_array($sqlcod))
{

$linea = "$row[0];$row[1];$row[2];\n";
$todo .= $linea;
		}
 if (!(file_exists("TIC/alumnos.txt")))
{
$fp=fopen("TIC/alumnos.txt","w+");
 }
 else
 {
 $fp=fopen("TIC/alumnos.txt","w+");
 }
 $pepito=fwrite($fp,$todo);
 fclose ($fp);
   
// Moodle
$codigo1 = "select usuario, pass, alma.apellidos, alma.nombre, alma.unidad from usuarioalumno, alma where alma.claveal=usuarioalumno.claveal";
$sqlcod1 = mysqli_query($db_con, $codigo1);
$todos_moodle="username;password;firstname;lastname;email;city;country\n";
while($rowprof = mysqli_fetch_array($sqlcod1))
{
$linea_moodle = "$rowprof[0];$rowprof[1];$rowprof[3];$rowprof[2];$rowprof[0]@".$config['dominio'].";".$config['centro_localidad'].";ES\n";
$todos_moodle.=$linea_moodle;
}

if (!(file_exists("TIC/alumnos_moodle.txt")))
{
$fpprof1=fopen("TIC/alumnos_moodle.txt","w+");
 }
 else
 {
 $fpprof1=fopen("TIC/alumnos_moodle.txt","w+") or die('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido escribir en el archivo TIC/profesores.txt. Has concedido permiso de escritura en ese directorio?
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><br />'); 
 }
 $pepito1=fwrite($fpprof1,$todos_moodle);
 fclose ($fpprof1);
 echo '<div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5>MOODLE:</h5>
 Se ha generado un fichero (alumnos_moodle.txt) en el subdirectorio "xml/jefe/TIC/" preparado para el alta masiva de usuarios en cualquier Plataforma Moodle distinta a la de la Red TIC de la Junta de Andalucía.
</div><br />'; 
 
 ?>

