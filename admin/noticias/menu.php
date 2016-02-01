<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

	<div class="container">
		
		<form method="get" action="buscar.php">
		
			<div class="pull-right col-sm-3">
			   <div class="input-group">
			     <input type="text" class="form-control input-sm" id="q" name="q" maxlength="60" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : '' ; ?>" placeholder="Buscar...">
			     <span class="input-group-btn">
			       <button class="btn btn-default btn-sm" type="submit"><span class="fa fa-search fa-lg"></span></button>
			     </span>
			   </div><!-- /input-group -->
			 </div><!-- /.col-lg-3-->
			 
		</form>
		
		<ul class="nav nav-tabs">
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'redactar.php')==TRUE) ? ' class="active"' : ''; ?>><a href="redactar.php">Redactar noticia</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php">Listado de noticias</a></li>
		</ul>
		
	</div>
	