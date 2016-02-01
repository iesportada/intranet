<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2));

include("../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Programa de Ayudas al Estudio <small>Libros gratuitos de la ESO</small></h2>
	</div>
	

	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	<div class="col-sm-6">
		<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
	
	<?php $result = mysqli_query($db_con, "SELECT * FROM textos_gratis LIMIT 1"); ?>
	<?php if(mysqli_num_rows($result)): ?>
	<div class="alert alert-warning">
		Ya existe información en la base de datos. Este proceso actualizará el listado de libros de texto. Es recomendable realizar una <a class="../../admin/jefe/copia_db/index.php">copia de seguridad</a> antes de proceder a la importación de los datos.
	</div>
	<?php endif; ?>
	
	<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="in_textos.php">
					<fieldset>
						<legend>Importación de libros</legend>

						<div class="form-group">
						  <label for="archivo"><span class="text-info">1ESO.txt, 2ESO.txt, 3ESO.txt, 4ESO.txt</span></label>
						  <input type="file" id="archivo" name="archivo" accept="text/plain">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../../xml/index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
					<?php endif; ?>
			
				<div class="well">
				
				<form method="post" action="reposicion.php">
					<fieldset>
						<legend>Imprimir Certificados de Reposición</legend>

						<div class="form-group">
						  <label for="niv">Curso</label>
						  <?php $result = mysqli_query($db_con, "SELECT nomcurso FROM cursos WHERE nomcurso LIKE '%E.S.O.' ORDER BY nomcurso ASC"); ?>
						  <?php if(mysqli_num_rows($result)): ?>
						  <select class="form-control" name="niv">
						  	<?php while($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nomcurso']; ?>"><?php echo $row['nomcurso']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="niv" disabled></select>
						  <?php endif; ?>
						  <?php mysqli_free_result($result); ?>
						</div>
						
						
					  <button type="submit" class="btn btn-primary" name="enviar3">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
			<div class="well">
							
				<form method="post" action="libros.php">
					<fieldset>
						<legend>Consultar el estado de los libros</legend>
						
						<input type="hidden" name="jefe" value="1">

						<div class="form-group">
						  <label for="nivel">Curso</label>
						  <?php $result = mysqli_query($db_con, "SELECT nomcurso FROM cursos WHERE nomcurso LIKE '%E.S.O.' ORDER BY nomcurso ASC"); ?>
						  <?php if(mysqli_num_rows($result)): ?>
						  <select class="form-control" name="nivel">
						  	<?php while($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nomcurso']; ?>"><?php echo $row['nomcurso']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="nivel" disabled></select>
						  <?php endif; ?>
						  <?php mysqli_free_result($result); ?>
						</div>
						
						
					  <button type="submit" class="btn btn-primary" name="enviar2">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
				
	</div>
	<div class="col-sm-6">
	<h3>Información sobre la importación</h3>
			
			<p>En primer lugar, debemos obtener el catálogo de libros de texto del Programa de Gratuidad desde Séneca. Entramos en Séneca y en el Menú vamos a <strong>Alumnado</strong>, <strong>Ayuda al Estudio</strong>, <strong>Gratuidad en Libros de Texto</strong>, <strong>Asignación de libros a materias</strong>. Seleccionamos el curso y pulsamos en <strong>Exportar datos</strong>. El formato de exportación debe ser <strong>Texto plano</strong>. El archivo resultante se llama <em>RegAsiLibMat.txt</em>. <br>
			Con cada Curso descargado, renombramos el archivo  por el nombre del Curso seleccionado (1ESO.txt). Al final debemos tener cuatro archivos llamados 1ESO.txt, 2ESO.txt, 3ESO.txt y 4ESO.txt, que utilizamos para importar los libros de texto de cada Curso.</p>
			
			<p>El módulo permite a los Tutores Consultar el estado de los Libros de Texto, así como utilizar la aplicación para registrarlo al final de cada Curso Escolar. También permite Consultar el estado de los Libros por Nivel al Equipo Directivo, así como generar Certificados de Reposición (Facturas en su caso) en formato PDF preparados para entregar oficialmente a los Padres del Alumno. </p>
	</div>	
	
	</div>
	</div>
	
	<?php include("../../pie.php"); ?>
	
</body>
</html>
