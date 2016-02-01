<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'aula')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'morosos')==TRUE or strstr($_SERVER['REQUEST_URI'],'edicion')==TRUE or strstr($_SERVER['REQUEST_URI'],'consulta')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'biblioteca/index.php')==TRUE or strstr($_SERVER['REQUEST_URI'],'biblioteca/biblioteca.php')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'_biblio.php')==TRUE){ $activo4 = ' class="active" ';}
?>
    <div class="container hidden-print">  
		<ul class="nav nav-tabs">
			<?php if ($config['mod_biblioteca_web'] != ""): ?>
			<li><a href="http://<?php echo $config['mod_biblioteca_web']; ?>" target="_blank">Página de la Biblioteca</a></li>	
			<?php endif; ?>
			<li<?php echo $activo1;?>><a href="../cursos/hor_aulas.php?aula=Biblioteca" target="_blank">Horario de la Biblioteca</a></li>	
			<li<?php echo $activo2;?>><a href="consulta.php">Gestión de los Préstamos</a></li>
			<li<?php echo $activo3;?>><a href="index.php">Fondos de la Biblioteca</a></li>     
			<li<?php echo $activo4;?>><a href="index_biblio.php">Importación de datos</a></li>
		</ul>
	</div>