<?php
// VALIDACION DE FORMULARIOS
if (isset($_POST['submit1'])) {
	include 'datos.php';
	exit();
}
elseif (isset($_POST['submit2'])) {
	include 'lista_grupo.php';
	exit();
}
elseif (isset($_POST['submit0'])) {
	include 'datos.php';
	exit();
}


require('../../bootstrap.php');


include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Alumnos del centro <small>Consultas</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="">
					<fieldset>
						<legend>Criterios de búsqueda</legend>
						
						<div class="form-group">
					    <label for="campoApellidos">Apellidos</label>
					    <input type="text" class="form-control" name="apellidos" id="campoApellidos" placeholder="Apellidos" maxlength="60">
					  </div>
					  
					  <div class="form-group">
					    <label for="campoNombre">Nombre</label>
					    <input type="text" class="form-control" name="nombre" id="campoNombre" placeholder="Nombre" maxlength="60">
					    <p class="help-block">No es necesario escribir el nombre o los apellidos completos de los alumnos.</p>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="submit0">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="">
					<fieldset>
						<legend>Información por grupos</legend>
						
						<div class="form-group">
					    <select class="form-control" name="unidad[]" multiple size="6">
					    	 <?php unidad($db_con); ?>
					    </select>
					    <p class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples grupos.</p>
					  </div>
					  <div class="checkbox">
					  <label>
					    <input type="checkbox" name="sin_foto" value="1" checked> Con foto</label>
					  </div>
					  <button type="submit" class="btn btn-primary" name="submit1">Consultar</button>
					  <button type="submit" class="btn btn-primary" name="submit2">Imprimir</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
