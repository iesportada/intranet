<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

// Creamos versión corta para FALTAS
mysqli_query($db_con, "CREATE TABLE almafaltas select CLAVEAL, NOMBRE,
APELLIDOS, Unidad from alma") or die('<div align="center"><div class="alert 
alert-danger alert-block fade in">
            <button type="button" class="close" 
data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear la tabla <strong>AlmaFaltas</strong> en la base de datos. 
Ponte en contacto con quien pueda resolver el problema.
</div></div><br /><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" 
onClick="../index.php" class="btn btn-primary" />
</div>');
mysqli_query($db_con, "ALTER TABLE almafaltas ADD PRIMARY KEY (  `CLAVEAL` )");

$elimina = "select distinct FALUMNOS.claveal, FALUMNOS.apellidos,
FALUMNOS.nombre, FALUMNOS.unidad from FALUMNOS, almafaltas where 
FALUMNOS.claveal NOT IN (select distinct claveal from almafaltas)";
$elimina1 = mysqli_query($db_con, $elimina);
if(mysqli_num_rows($elimina1) > 0)
{
	echo "<div align='center'><div class='alert alert-warning alert-block fade in'>
            <button type='button'' class='close' data-dismiss='alert'>&times;</button>
            Tabla FALUMNOS: los siguientes alumnos han sido 
eliminados de la tabla FALUMNOS. <br>Comprueba los registros 
creados:</div></div><br />";
	while($elimina2 = mysqli_fetch_array($elimina1))
	{
		echo "<li>".$elimina2[2] . " " . $elimina2[1] . " -- " . $elimina2[3] . "</li>";
		$SQL6 = "DELETE FROM FALUMNOS where claveal = '$elimina2[0]'";
		$SQL16 = "DELETE FROM usuarioalumno where claveal = '$elimina2[0]'";
		$result6 = mysqli_query($db_con, $SQL6);
		$result16 = mysqli_query($db_con, $SQL16);
	}
}
echo "<br />";

$SQL1 = "select distinct almafaltas.claveal, almafaltas.apellidos,
almafaltas.nombre, almafaltas.unidad from almafaltas, FALUMNOS where 
almafaltas.claveal NOT IN (select distinct claveal from FALUMNOS)";
$result1 = mysqli_query($db_con, $SQL1);
$total = mysqli_num_rows($result1);
if ($total !== 0)
{
	echo "<div align='center'><div class='alert alert-success alert-block fade in'>
            <button type='button'' class='close' data-dismiss='alert'>&times;</button>
            Tabla FALUMNOS: los nuevos alumnos han sido añadidos a 
la tabla FALUMNOS. <br>Comprueba en la lista de abajo los registros 
creados:</div></div><br />";
	while  ($row1= mysqli_fetch_array($result1))
	{
		// Buscamos el ultimo numero del Grupo del Alumno
		$SQL3 = "select MAX(NC) from FALUMNOS where unidad = '$row1[3]'";
		$result3 = mysqli_query($db_con, $SQL3);
		while ($row3= mysqli_fetch_row($result3))
		{
			// Aumentamos el NC del ultimo en 1
			$numero = $row3[0] + 1;
			// Insertamos los datos en FALUMNOS
			$SQL2 = "INSERT INTO FALUMNOS (CLAVEAL, APELLIDOS, NOMBRE, unidad, NC) VALUES
(\"". $row1[0] . "\",\"". $row1[1] . "\",\"". $row1[2] . "\",\"". $row1[3] . 
"\",\"". $numero . "\")";
			//echo $SQL2.";<br>";
			echo "<li>".$row1[2] . " " . $row1[1] . " -- " . $row1[3] . " -- " . $numero ."</li>";
			$result2 = mysqli_query($db_con, $SQL2);

			// Usuario TIC
			$apellidos = $row1[1] ;
			$apellido = explode(" ",$row1[1] );
			$alternativo = strtolower(substr($row1[3],0,2));
			$nombreorig = $row1[2]  . " " . $row1[1] ;
			$nombre = $row1[2] ;
			$claveal = $row1[0] ;
			if (substr($nombre,0,1) == "Á") {$nombre =
			str_replace("Á","A",$nombre);}
			if (substr($nombre,0,1) == "É") {$nombre =
			str_replace("É","E",$nombre);}
			if (substr($nombre,0,1) == "Í") {$nombre =
			str_replace("Í","I",$nombre);}
			if (substr($nombre,0,1) == "Ó") {$nombre =
			str_replace("Ó","O",$nombre);}
			if (substr($nombre,0,1) == "Ú") {$nombre =
			str_replace("Ú","U",$nombre);}

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

			$userpass =
"a".strtolower(substr($nombre,0,1)).strtolower($apellido[0]);
			$userpass = str_replace("ª","",$userpass);
			$userpass = str_replace("ñ","n",$userpass);
			$userpass = str_replace("-","_",$userpass);
			$userpass = str_replace("'","",$userpass);
			$userpass = str_replace("º","",$userpass);
			$userpass = str_replace("ö","o",$userpass);

			$usuario  = $userpass;
			$passw = $userpass . preg_replace('/([ ])/e', 'rand(0,9)', '   ');
			$unidad = $row1[3];

			$repetidos = mysqli_query($db_con, "select usuario from usuarioalumno where
usuario like '$usuario%'");
			$n_a=0;
			while($num = mysqli_fetch_array($repetidos))
			{
				$n_a+=1;
			}
			$n_a+=1;
			$usuario = $usuario.$n_a;
			mysqli_query($db_con, "insert into usuarioalumno set nombre = \"".$nombreorig. "\",
usuario = \"".$usuario. "\", pass = '$passw', perfil = 'a', unidad = '$unidad', claveal 
= '$claveal'");
			echo "<li>TIC: ".$nombreorig . " " . $usuario . " -- " . $unidad . "  " .$claveal. "</li>";
		}
	}
	echo "<br />";
}
else
{
	echo "<div align='center'><div class='alert alert-warning alert-block fade in'>
            <button type='button'' class='close' data-dismiss='alert'>&times;</button>
            Tabla FALUMNOS: No se ha encontrado ningun registro 
nuevo para añadir en FALUMNOS.<br>Si crees que hay un problema, ponte en 
contacto con quien sepa arreglarlo</div></div><br />";	
}

// Cambio de grupo de un alumno.
$cambio0 = mysqli_query($db_con, "select claveal, unidad, apellidos, nombre from
alma");
while($cambio = mysqli_fetch_array($cambio0)){
	$f_cambio0 = mysqli_query($db_con, "select unidad from FALUMNOS where claveal =
'$cambio[0]'");
	$f_cambio = mysqli_fetch_array($f_cambio0);
	if($cambio[1] == $f_cambio[0]){}
	else{
		$cambio_al+=1;
		$resultf = mysqli_query($db_con, "select MAX(NC) from FALUMNOS where unidad =
'$cambio[1]'");
		$f_result = mysqli_fetch_array($resultf);
		$f_numero = $f_result[0] + 1;
		mysqli_query($db_con, "update FALUMNOS set NC = '$f_numero', unidad =
'$cambio[1]' where claveal = '$cambio[0]'");
	}	
}

$cambio0 = mysqli_query($db_con, "select claveal, unidad, apellidos, nombre from
alma");
while($cambio = mysqli_fetch_array($cambio0)){
	$f_cambio0 = mysqli_query($db_con, "select unidad from usuarioalumno where claveal =
'$cambio[0]'");
	$f_cambio = mysqli_fetch_array($f_cambio0);
	if($cambio[1] == $f_cambio[0]){}
	else{
		mysqli_query($db_con, "update usuarioalumno set unidad = '$cambio[1]' where claveal = '$cambio[0]'");
	}	
}

mysqli_query($db_con, "drop table almafaltas");
?>

