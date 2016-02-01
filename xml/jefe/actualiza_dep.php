<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

$n_dep = array("inventario","actividades","mem_dep","r_departamento","Textos");
foreach ($n_dep as $sust_dep){
$dep0 = mysqli_query($db_con, "select id, departamento from $sust_dep");
while ($dep = mysqli_fetch_array($dep0)) {
	if(strstr($dep[1],"P.E.S.")==TRUE){
	$depart = str_replace("P.E.S.","",$dep[1]);
	$departa = trim($depart);
	mysqli_query($db_con, "update $sust_dep set departamento = '$departa' where id = '$dep[0]'");
}
}
}
$dep0 = mysqli_query($db_con, "select distinct departamento from departamentos");
while ($dep = mysqli_fetch_array($dep0)) {
	if(strstr($dep[0],"P.E.S.")==TRUE){
	$depart = str_replace("P.E.S.","",$dep[0]);
	$departa = trim($depart);
	mysqli_query($db_con, "update departamentos set departamento = '$departa' where departamento = '$dep[0]'");
	}
}
?>