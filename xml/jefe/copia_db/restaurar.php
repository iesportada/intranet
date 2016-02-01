<?php
include("../../../bootstrap.php");

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];

function restaurar_bd($backup_file,$host,$user,$pass,$name) {
   
   $command = "gunzip < $backup_file | mysql -h $host -u $user -p$pass $name";
   system($command,$output);
   
   return $output;
}


// RESTAURAR COPIA GUARDADA EN LOCAL
if (isset($_GET['archivo']) && file_exists($_GET['archivo'])) {
	$backup_file = $_GET['archivo'];
	$result = restaurar_bd($backup_file, $config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
	
	if (!$result) $msg_success = "La copia de seguridad ha sido restaurada.";
	else $msg_error = "No se ha podido restaurar la copia de seguridad. Utilice un Gestor de Base de Datos para restaurar la copia de seguridad.";	
}

// RESTAURAR COPIA SUBIDO MEDIANTE FORMULARIO
if (isset($_POST['enviar'])) {

	if (isset($_FILES['archivo']['tmp_name'])) {
		$backup_file = $_FILES['archivo']['tmp_name'];
		
		$result = restaurar_bd($backup_file, $config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
		
		if (!$result) $msg_success = "La copia de seguridad ha sido restaurada.";
		else $msg_error = "No se ha podido restaurar la copia de seguridad. Utilice un Gestor de Base de Datos para restaurar la copia de seguridad.";	
	}
}

include("../../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Restaurar base de datos</small></h2>
	</div>
	
	<!-- MENSAJES -->
	<?php if(isset($msg_success)): ?>
	<div class="alert alert-success">
		<?php echo $msg_success; ?>
	</div>
	<?php endif; ?>
	
	<?php if(isset($msg_error)): ?>
	<div class="alert alert-danger">
		<?php echo $msg_error; ?>
	</div>
	<?php endif; ?>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form id="form" enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Restaurar base de datos</legend>
						
						<div class="form-group">
						  <label for="archivo"><span class="text-info">db-backup.gz</span></label>
						  <input type="file" id="archivo" name="archivo" accept="application/gzip">
						</div>
						
						<p class="block-help"><small>Tamaño máximo del archivo: <?php echo ini_get('post_max_size'); ?>B.</small></p>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Restaurar</button>
					  <a class="btn btn-default" href="index.php">Volver</a>
					  
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la restauración</h3>
			
			<p>Si dispones de una copia de seguridad de la base de datos puedes realizar su restauración. Recuerda que los datos actuales se eliminarán. Una vez enviado el archivo el proceso tardará unos segundos, ten paciencia.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../../pie.php"); ?>

</body>
</html>
