<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<div class="container">

	<ul class="nav nav-tabs" role="tablist">
	  <li<?php echo (strstr($_SERVER['REQUEST_URI'],'index')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php">Evaluar una unidad</a></li>
	  <li<?php echo (strstr($_SERVER['REQUEST_URI'],'consulta')==TRUE) ? ' class="active"' : ''; ?>><a href="consulta.php">Sesiones de evaluación</a></li>
	  <?php if ((stristr($_SESSION['cargo'],'1') == true) || (stristr($_SESSION['cargo'],'2') == true)): ?>
	  <li<?php echo (strstr($_SERVER['REQUEST_URI'],'actas')==TRUE) ? ' class="active"' : ''; ?>><a href="actas.php">Actas de sesiones</a></li>
	  <?php endif; ?>
	</ul>
	
</div>