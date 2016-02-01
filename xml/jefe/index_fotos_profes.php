<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Importación de fotos de los profesores</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="fotos_profes.php">
					<fieldset>
						<legend>Importación de fotos de los profesores</legend>

						<div class="form-group">
						  <label for="archivo"><span class="text-info">Fotografias_profesores.zip</span></label>
						  <input type="file" id="archivo" name="archivo" accept="application/zip">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Para importar las fotos de todos los profesores, necesitaremos crear un archivo comprimido (.zip) conteniendo todos los archivos de fotos de los profesores.</p>
			
			<p>Cada archivo de foto tiene como nombre el usuario IdEA de Séneca seguido de la extensión .jpg o .jpeg. El nombre típico de un archivo de foto quedaría por ejemplo así: mgargon732.jpg.</p>
			
			<p>Los profesores podrán actualizar su fotografía desde el menú superior, Cambiar fotografía.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
