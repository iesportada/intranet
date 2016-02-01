<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$activo1="";
$activo2="";

if (strstr($_SERVER['REQUEST_URI'],'/admin.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'guardias_admin.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'hor_guardias.php')==TRUE) {$activo3 = ' class="active" ';}
?>
		<div class="container hidden-print">			
			<ul class="nav nav-tabs">
				<li <?php echo $activo1;?>> <a href="admin.php">Registrar Guardia</a></li>
				<li <?php echo $activo2;?>> <a href="guardias_admin.php?todos=1">Consultar Guardias</a></li>
				<li <?php echo $activo3;?>> <a href="../cursos/hor_guardias.php">Informe sobre las Guardias</a></li>
			</ul>
		</div>
