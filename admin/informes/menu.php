<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$activo1="";
$activo2="";
$activo3="";
$activo4="";
$activo5="";
$activo6="";
if (strstr($_SERVER['REQUEST_URI'],'1')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'2')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'3')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'4')==TRUE){ $activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'5')==TRUE){ $activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'6')==TRUE){ $activo6 = ' class="active" ';}
?>
    <div class="container">  
		<ul class="nav nav-tabs">
			<li<?php echo $activo1;?>><a href="informe_notas1.php">Alumnos y Nivel</a></li>	
			<li<?php echo $activo2;?>><a href="informe_notas2.php">Alumnos y Grupo</a></li>
			<li<?php echo $activo3;?>><a href="informe_notas3.php">Materias y Nivel</a></li>     
			<li<?php echo $activo4;?>><a href="informe_notas4.php">Materias / Nivel / Grupo</a></li>	
			<li<?php echo $activo5;?>><a href="informe_notas5.php">Materias y Grupo</a></li>	
			<li<?php echo $activo6;?>><a href="informe_notas6.php">Alumnos con Pendientes</a></li>	
		</ul>
	</div>