<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

 // Creamos tabla hermanos para enviar SMS al telefono de varios hermanos.
mysqli_query($db_con, "truncate table hermanos");
mysqli_query($db_con, "create table hermanos_temp select * from hermanos");
mysqli_query($db_con, "create table hermanos_temp2 select * from hermanos");
mysqli_query($db_con, "insert into hermanos_temp select distinct telefono, telefonourgencia, count(*) from alma group by telefono");
mysqli_query($db_con, "delete from hermanos_temp where hermanos < '2'");
$sel0 = mysqli_query($db_con, "select unidad, claveal, hermanos_temp.telefono, hermanos_temp.telefonourgencia from alma, hermanos_temp where alma.telefono=hermanos_temp.telefono and alma.telefonourgencia=hermanos_temp.telefonourgencia");
while ($sel=mysqli_fetch_array($sel0)) {
	$dup0=mysqli_query($db_con, "select claveal from alma where telefono = '$sel[2]' and telefonourgencia = '$sel[3]' and unidad = '$sel[0]'");
	$numero = mysqli_num_rows($dup0);
	if (mysqli_num_rows($dup0)>'1') {
		mysqli_query($db_con, "insert into hermanos_temp2 (telefono, telefonourgencia, hermanos ) VALUES ('$sel[2]','$sel[3]','$numero')");
	}
}
 mysqli_query($db_con, "insert into hermanos select distinct telefono, telefonourgencia, hermanos from hermanos_temp2");
 mysqli_query($db_con, "drop table hermanos_temp");
 mysqli_query($db_con, "drop table hermanos_temp2");
 ?>
 