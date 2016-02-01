<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Importación de departamentos</small></h2>
	</div>
	
	<?php $result = mysqli_query($db_con, "SELECT * FROM departamentos LIMIT 1"); ?>
	<?php if(mysqli_num_rows($result)): ?>
	<div class="alert alert-warning">
		Ya existe información en la base de datos. Este proceso actualizará la información de los departamentos. Es recomendable realizar una <a href="copia_db/index.php" class="alert-link">copia de seguridad</a> antes de proceder a la importación de los datos.
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="departamentos.php">
					<fieldset>
						<legend>Importación de departamentos</legend>
						
						<div class="form-group">
						  <label for="archivo"><span class="text-info">RelPerCen.txt</span></label>
						  <input type="file" id="archivo" name="archivo" accept="text/plain">
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
			
			<p>Este apartado se encarga de importar los <strong>Departamentos</strong> de los profesores que trabajan en el Centro.</p>
			
			<p>Una vez importados los datos es conveniente ir a la página de <strong>Gestión de los Departamentos</strong> para personalizar los datos y adaptar a la estructura real del Centro. Esta tarea debe realizarse cada vez que se importan o actualizan los Departamentos y profesores.</p>
			
			<p>Para obtener el archivo de exportación de profesores debe dirigirse al apartado <strong>Personal</strong>, <strong>Personal del centro</strong>. Muestre todos los profesores del centro y haga clic en el botón <strong>Exportar datos</strong>. El formato de exportación debe ser <strong>Texto plano</strong>.</p>
						
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
