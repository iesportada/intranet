<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
include("../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Actualización de alumnos</small></h2>
	</div>
	
	<?php $result = mysqli_query($db_con, "SELECT * FROM alma LIMIT 1"); ?>
	<?php if(mysqli_num_rows($result)): ?>
	<div class="alert alert-warning">
		Ya existe información en la base de datos. Este proceso actualizará la información de los alumnos y asignaturas matriculadas. Es recomendable realizar una <a class="copia_db/index.php" class="alert-link">copia de seguridad</a> antes de proceder a la importación de los datos.
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="alma.php">
					<fieldset>
						<legend>Actualización de alumnos</legend>
						
						<div class="form-group">
						  <label for="archivo1"><span class="text-info">RegAlum.txt</span></label>
						  <input type="file" id="archivo1" name="archivo1" accept="text/plain">
						</div>
						
						<br>
						
						<div class="form-group">
						  <label for="archivo2"><span class="text-info">Exportacion_de_Calificaciones.zip</span></label>
						  <input type="file" id="archivo2" name="archivo2" accept="application/zip">
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
			
			<p>Este apartado se encarga de importar los <strong>alumnos matriculados</strong> en el centro. También se importarán los <strong>sistemas de calificaciones</strong> soportados por Séneca para mostrar los resultados de las evaluaciones de cada curso.</p>
			
			<p>El sistema importará la <strong>relación de materias matriculadas</strong> de cada alumno.</p>
			
			<p>Para obtener el archivo de exportación de alumnos debe dirigirse al apartado <strong>Alumnado</strong>, <strong>Alumnado</strong>, <strong>Alumnado del centro</strong>. Muestre todos los alumnos del centro y haga clic en el botón <strong>Exportar datos</strong>. El formato de exportación debe ser <strong>Texto plano</strong>.</p>
			
			<p>Para obtener el archivo de exportación de calificaciones debe dirigirse al apartado <strong>Utilidades</strong>, <strong>Importación/Exportación de datos</strong>. Seleccione <strong>Exportación de Calificaciones</strong>. Seleccione una convocatoria común para todas las unidades y añada todas las unidades de todos los cursos del centro. Proceda a descargar el archivo comprimido.<p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
