<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

// TITULO DE LA PAGINA
$page_header = 'Bases de datos de cursos anteriores';

$config_datos_nuevo = 0;

function limpiar_string($string)
{
	return trim(htmlspecialchars($string, ENT_QUOTES,'ISO-8859-1'));
}

// PROCESAMOS EL FORMULARIO
if (isset($_POST['config']))
{
	
	// LIMPIAMOS CARACTERES
	foreach ($_POST as $key => $value) {
		if($key != 'config') {
			${$key} = limpiar_string($value);
		}
	}
	
	$curso_bd = substr($config['curso_actual'], 0, 4);
	$curso_bd -= 1;
	
	// CREACIÓN DEL ARCHIVO DE CONFIGURACIÓN
	$archivo_bd = INTRANET_DIRECTORY . '/config_datos.php';
	if($file = fopen($archivo_bd, 'w+'))
	{
		fwrite($file, "<?php \r\n");
		
		for($i=0; $i<6; $i++) {
			$curso_ini = $curso_bd - $i;
			$curso_fin = $curso_bd - $i + 1;
			
			fwrite($file, "\r\n// BASE DE DATOS - CURSO ".$curso_ini." / ".$curso_fin."\r\n");
			fwrite($file, "\$config['db_host_c".$curso_ini."']\t= '".${'db_host_c'.$curso_ini}."';\r\n");
			fwrite($file, "\$config['db_name_c".$curso_ini."']\t= '".${'db_name_c'.$curso_ini}."';\r\n");
			fwrite($file, "\$config['db_user_c".$curso_ini."']\t= '".${'db_user_c'.$curso_ini}."';\r\n");
			fwrite($file, "\$config['db_pass_c".$curso_ini."']\t= '".${'db_pass_c'.$curso_ini}."';\r\n");
		}
		
		fwrite($file, "\r\n\r\n// Fin del archivo de configuración de bases de datos");
		
		$config_datos_nuevo = 1;
		fclose($file);
		
		include('../config_datos.php');
	}
	
	unset($curso_ini);
	unset($curso_fin);
	unset($curso_bd);
	
}

include('../menu.php');
?>
	
	<div class="container">
		
		<div class="page-header">
			<h2><?php echo $page_header; ?></h2>
		</div>
		
		<?php if($config_datos_nuevo): ?>
		<div class="alert alert-success">
			Los cambios han sido guardados correctamente.
		</div>
		<?php endif; ?>
		
		<form id="form-configuracion" data-toggle="validator" class="form-horizontal" method="post" action="" autocomplete="off">
			
			<div class="row">
				
				<div class="col-sm-12">
					
					<div class="well">
						<?php $curso_bd = substr($config['curso_actual'], 0, 4); ?>
						<?php $curso_bd -= 1; ?>
						 						
						<?php for($i=0; $i<6; $i++): ?>
						<h3>Curso <?php echo ($curso_ini = $curso_bd - $i); ?>/<?php echo ($curso_fin = $curso_bd - $i + 1); ?></h3>
						<br>

						<div class="row" style="margin: 0 8px;">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="db_host_c<?php echo $curso_ini; ?>">Servidor</label>
									<input type="text" class="form-control" id="db_host_c<?php echo $curso_ini; ?>" name="db_host_c<?php echo $curso_ini; ?>" value="<?php echo $config['db_host_c'.$curso_ini]; ?>" data-error="La dirección servidor de base de datos no es válida">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">
									<label for="db_name_c<?php echo $curso_ini; ?>">Base de datos</label>
									<input type="text" class="form-control" id="db_name_c<?php echo $curso_ini; ?>" name="db_name_c<?php echo $curso_ini; ?>" value="<?php echo $config['db_name_c'.$curso_ini]; ?>" data-error="El nombre de la base de datos no es válido">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">
									<label for="db_user_c<?php echo $curso_ini; ?>">Usuario</label>
									<input type="text" class="form-control" id="db_user_c<?php echo $curso_ini; ?>" name="db_user_c<?php echo $curso_ini; ?>" value="<?php echo $config['db_user_c'.$curso_ini]; ?>" data-error="El nombre de usuario de la base de datos no es válido">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">
									<label for="db_pass_c<?php echo $curso_ini; ?>">Contraseña</label>
									<input type="password" class="form-control" id="db_pass_c<?php echo $curso_ini; ?>" name="db_pass_c<?php echo $curso_ini; ?>" value="<?php echo $config['db_pass_c'.$curso_ini]; ?>" data-error="La contraseña de la base de datos no es válido">
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<?php endfor; ?>
						
					</div><!-- /.well -->
					
												
				</div><!-- /.col-sm-12 -->
				
			</div><!-- /.row -->
				
							
			<div class="row">
				
				<div class="col-sm-12">
				
					<button type="submit" class="btn btn-primary" name="config">Guardar cambios</button>
					<a href="../xml/index.php" class="btn btn-default">Volver</a>
					
				</div>
				
			</div>
			
		</form>
		
	</div><!-- /.container -->
	
	
	<?php include('../pie.php'); ?>
	
	<script src="../js/validator/validator.min.js"></script>
	<script>
	$(document).ready(function()
	{
	    $('#form-instalacion').validator();
	});
	</script>
	

</body>
</html>