<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
include("../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Importación de datos del centro</small></h2>
	</div>
	
	<?php $result = mysqli_query($db_con, "SELECT * FROM cursos LIMIT 1"); ?>
	<?php if(mysqli_num_rows($result) && !isset($_FILES['ExpGenHor'])): ?>
	<div class="alert alert-warning">
		Ya existe información relativa a este curso escolar. Este proceso sustituirá parte de la información almacenada. Los cambios realizados manualmente en las dependencias y departamentos no se verán afectadas. Es recomendable realizar una <a href="copia_db/index.php" class="alert-link">copia de seguridad</a> antes de proceder a la importación de los datos.
	</div>
	<?php endif; ?>
	
	<?php if(isset($_FILES['ExpGenHor'])): ?>
	<div class="alert alert-success">
		Los datos del centro han sido importados.
	</div>
	<?php endif; ?>
	
	<?php if(isset($_FILES['ExpGenHor'])): ?>
	<div id="status-loading" class="text-center">
		<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
	</div>
	<?php endif; ?>
	
	<!-- SCAFFOLDING -->
	<div id="wrap" class="row" style="display: none;">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Importación de datos del centro</legend>
						
						<input type="hidden" name="curso_escolar" value="<?php echo $config['curso_actual']; ?>">
						
						<div class="form-group">
						  <label for="ExpGenHor"><span class="text-info">ExportacionHorarios.xml</span></label>
						  <input type="file" id="ExpGenHor" name="ExpGenHor" accept="text/xml">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
			<?php $ExpGenHor = $_FILES['ExpGenHor']['tmp_name']; ?>
			<?php if (isset($ExpGenHor)): ?>
			<?php	include ('importacion_xml.php'); ?>
			<?php	importarDatos($db_con); ?>
			<?php	endif; ?>
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Este módulo se encarga de importar la relación de <strong>cursos</strong> y <strong>unidades</strong> del centro registrados en Séneca, así como la relación de <strong>materias</strong> que se imparten y <strong>actividades</strong> del personal docente, necesarias para comprobar la coherencia de los horarios y poder realizar tareas de depuración. Se importará también la relación de <strong>dependencias</strong>, que se utilizará para realizar reservas de aulas o consultar el horario de aulas.</p>
			
			<p>Para obtener el archivo de exportación debe dirigirse al apartado <strong>Utilidades</strong>, <strong>Importación/Exportación de datos</strong>. Seleccione <strong>Exportación hacia generadores de horario</strong> y proceda a descargar el archivo XML.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

<script>
function espera() {
	document.getElementById("wrap").style.display = '';
	document.getElementById("status-loading").style.display = 'none';        
}
window.onload = espera;
</script>  
	
</body>
</html>
