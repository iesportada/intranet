<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$total0 = count($_POST);
$clavesw = array_values($_POST);
// Misma operación que en el fichero insertar.php
$x=4;
while($x < $total0 - 2)
{
	// Dividimos los valores en grupos de 6, cada uno conteniendo todos los datos necesarios para una hora de un dia de la semana, con su fecha, nivel grupo, etc.
$trozos0 = array_slice($clavesw, $x, 6);

// Pasamos fecha española a formato MySql
$fecha0 = explode('-',$trozos0[0]);
$dia0 = $fecha0[0];
$mes = $fecha0[1];
$ano = $fecha0[2];
$fecha1 = $ano . "-" . $mes . "-" . $dia0;
$trozos = explode("_ ",$profesor) ;
$id = $trozos[0];
$profesores = $trozos[1]; 
$fecha_dia = date('N', strtotime($fecha1)); 

// Borramos registros que no coincidan con los que se mantienen.
$del ="DELETE FROM FALTAS WHERE FECHA = '$fecha1' and unidad = '$trozos0[3]' and hora = '$trozos0[5]' and dia =  '$fecha_dia' and PROFESOR = '$id' and FALTA = 'F' and NC not like '$trozos0[2]'";
$del0 = mysqli_query($db_con, $del);	
// Pasamos al siguiente bloque de 6 variables hasta el final
$x += 6;	
}	
?>