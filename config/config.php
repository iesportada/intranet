<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

// TITULO DE LA PAGINA
$page_header = 'Configuración de la Intranet';

$config_nuevo = 0;

$provincias = array('Almería', 'Cádiz', 'Córdoba', 'Granada', 'Huelva', 'Jaén', 'Málaga', 'Sevilla');

function forzar_ssl() {
	$ssl = ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) ? 'https://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/intranet/config/ssl.json' : 'https://'.$_SERVER['SERVER_NAME'].'/intranet/config/ssl.json';
	
	$context = array(
	  'http' => array(
	  	'header' => "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n"
	  )
	);
	
	$file = @json_decode(@file_get_contents($ssl, false, stream_context_create($context)));
	return sprintf("%s", $file ? reset($file)->ssl : 0);
}

function limpiar_string($string)
{
	return trim(htmlspecialchars($string, ENT_QUOTES,'ISO-8859-1'));
}

// PROCESAMOS EL FORMULARIO
if (isset($_POST['config']))
{
	
	// LIMPIAMOS CARACTERES
	$dominio_centro	= limpiar_string($_POST['dominio_centro']);
	(isset($_POST['forzar_ssl'])) ? $forzar_ssl = 1 : $forzar_ssl = 0;
	(isset($_POST['mantenimiento'])) ? $mantenimiento = 1 : $mantenimiento = 0;
	
	$nombre_centro		= limpiar_string($_POST['nombre_centro']);
	$codigo_centro		= limpiar_string($_POST['codigo_centro']);
	$email_centro		= limpiar_string($_POST['email_centro']);
	$direccion_centro	= limpiar_string($_POST['direccion_centro']);
	$codpostal_centro	= limpiar_string($_POST['codpostal_centro']);
	$localidad_centro	= limpiar_string($_POST['localidad_centro']);
	$provincia_centro	= limpiar_string($_POST['provincia_centro']);
	$telefono_centro	= limpiar_string($_POST['telefono_centro']);
	$fax_centro			= limpiar_string($_POST['fax_centro']);
	
	$direccion_director			= limpiar_string($_POST['direccion_director']);
	$direccion_jefe_estudios	= limpiar_string($_POST['direccion_jefe_estudios']);
	$direccion_secretaria		= limpiar_string($_POST['direccion_secretaria']);
	
	$db_host	= limpiar_string($_POST['db_host']);
	$db_name	= limpiar_string($_POST['db_name']);
	$db_user	= limpiar_string($_POST['db_user']);
	$db_pass	= limpiar_string($_POST['db_pass']);
	
	$curso_escolar	= limpiar_string($_POST['curso_escolar']);
	$fecha_inicio	= limpiar_string($_POST['fecha_inicio']);
	$fecha_final	= limpiar_string($_POST['fecha_final']);
	
	(isset($_POST['mod_biblioteca'])) ? $modulo_biblioteca = 1 : $modulo_biblioteca = 0;
	$modulo_biblioteca_web	= limpiar_string($_POST['mod_biblioteca_web']);
	
	(isset($_POST['mod_bilingue'])) ? $modulo_bilingue = 1 : $modulo_bilingue = 0;
	
	(isset($_POST['mod_centrotic'])) ? $modulo_centrotic = 1 : $modulo_centrotic = 0;
	
	(isset($_POST['mod_documentos'])) ? $modulo_documentos = 1 : $modulo_documentos = 0;
	$modulo_documentos_dir	= limpiar_string($_POST['mod_documentos_dir']);
	(isset($_POST['mod_documentos_biblioteca'])) ? $mod_documentos_biblioteca = 1 : $mod_documentos_biblioteca = 0;
	(isset($_POST['mod_documentos_recursos'])) ? $mod_documentos_recursos = 1 : $mod_documentos_recursos = 0;
	(isset($_POST['mod_documentos_departamentos'])) ? $mod_documentos_departamentos = 1 : $mod_documentos_departamentos = 0;
	
	(isset($_POST['mod_sms'])) ? $modulo_sms = 1 : $modulo_sms = 0;
	$modulo_sms_id		= limpiar_string($_POST['mod_sms_id']);
	$modulo_sms_user	= limpiar_string($_POST['mod_sms_user']);
	$modulo_sms_pass	= limpiar_string($_POST['mod_sms_pass']);
	
	(isset($_POST['mod_asistencia'])) ? $modulo_asistencia = 1 : $modulo_asistencia = 0;
	
	(isset($_POST['mod_horarios'])) ? $modulo_horarios = 1 : $modulo_horarios = 0;
	
	(isset($_POST['mod_matriculacion'])) ? $modulo_matriculacion = 1 : $modulo_matriculacion = 0;
	(isset($_POST['mod_transporte_escolar'])) ? $modulo_transporte_escolar = 1 : $modulo_transporte_escolar = 0;
	
	
	// CREACIÓN DEL ARCHIVO DE CONFIGURACIÓN
	if($file = fopen(CONFIG_FILE, 'w+'))
	{
		fwrite($file, "<?php \r\n");
		
		fwrite($file, "\r\n// CONFIGURACIÓN INTRANET\r\n");
		fwrite($file, "\$config['dominio']\t\t\t= '$dominio_centro';\r\n");
		fwrite($file, "\$config['forzar_ssl']\t\t= $forzar_ssl;\r\n");
		fwrite($file, "\$config['mantenimiento']\t= $mantenimiento;\r\n");
		
		fwrite($file, "\r\n// INFORMACIÓN DEL CENTRO\r\n");
		fwrite($file, "\$config['centro_denominacion']\t= '$nombre_centro';\r\n");
		fwrite($file, "\$config['centro_codigo']\t\t= '$codigo_centro';\r\n");
		fwrite($file, "\$config['centro_email']\t\t\t= '$email_centro';\r\n");
		fwrite($file, "\$config['centro_direccion']\t\t= '$direccion_centro';\r\n");
		fwrite($file, "\$config['centro_codpostal']\t\t= '$codpostal_centro';\r\n");
		fwrite($file, "\$config['centro_localidad']\t\t= '$localidad_centro';\r\n");
		fwrite($file, "\$config['centro_provincia']\t\t= '$provincia_centro';\r\n");
		fwrite($file, "\$config['centro_telefono']\t\t= '$telefono_centro';\r\n");
		fwrite($file, "\$config['centro_fax']\t\t\t= '$fax_centro';\r\n");
		
		fwrite($file, "\r\n// EQUIPO DIRECTIVO\r\n");
		fwrite($file, "\$config['directivo_direccion']\t= '$direccion_director';\r\n");
		fwrite($file, "\$config['directivo_jefatura']\t= '$direccion_jefe_estudios';\r\n");
		fwrite($file, "\$config['directivo_secretaria']\t= '$direccion_secretaria';\r\n");
		
		fwrite($file, "\r\n// BASE DE DATOS\r\n");
		fwrite($file, "\$config['db_host']\t= '$db_host';\r\n");
		fwrite($file, "\$config['db_name']\t= '$db_name';\r\n");
		fwrite($file, "\$config['db_user']\t= '$db_user';\r\n");
		fwrite($file, "\$config['db_pass']\t= '$db_pass';\r\n");
		
		fwrite($file, "\r\n// CURSO ESCOLAR\r\n");
		fwrite($file, "\$config['curso_actual']\t= '$curso_escolar';\r\n");
		fwrite($file, "\$config['curso_inicio']\t= '$fecha_inicio';\r\n");
		fwrite($file, "\$config['curso_fin']\t= '$fecha_final';\r\n");
		
		fwrite($file, "\r\n// MÓDULO: BIBLIOTECA\r\n");
		fwrite($file, "\$config['mod_biblioteca']\t\t= $modulo_biblioteca;\r\n");
		fwrite($file, "\$config['mod_biblioteca_web']\t= '$modulo_biblioteca_web';\r\n");
		
		fwrite($file, "\r\n// MÓDULO: BILINGÜE\r\n");
		fwrite($file, "\$config['mod_bilingue']\t\t\t= $modulo_bilingue;\r\n");
		
		fwrite($file, "\r\n// MÓDULO: CENTRO TIC\r\n");
		fwrite($file, "\$config['mod_centrotic']\t\t= $modulo_centrotic;\r\n");
		
		fwrite($file, "\r\n// MÓDULO: DOCUMENTOS\r\n");
		fwrite($file, "\$config['mod_documentos']\t\t= $modulo_documentos;\r\n");
		fwrite($file, "\$config['mod_documentos_dir']\t= '$modulo_documentos_dir';\r\n");
		fwrite($file, "\$config['mod_documentos_biblioteca']\t= '$mod_documentos_biblioteca';\r\n");
		fwrite($file, "\$config['mod_documentos_recursos']\t= '$mod_documentos_recursos';\r\n");
		fwrite($file, "\$config['mod_documentos_departamentos']\t= '$mod_documentos_departamentos';\r\n");
		
		fwrite($file, "\r\n// MÓDULO: SMS\r\n");
		fwrite($file, "\$config['mod_sms']\t\t\t\t= $modulo_sms;\r\n");
		fwrite($file, "\$config['mod_sms_id']\t\t\t= '$modulo_sms_id';\r\n");
		fwrite($file, "\$config['mod_sms_user']\t\t\t= '$modulo_sms_user';\r\n");
		fwrite($file, "\$config['mod_sms_pass']\t\t\t= '$modulo_sms_pass';\r\n");
		
		fwrite($file, "\r\n// MÓDULO: FALTAS DE ASISTENCIA\r\n");
		fwrite($file, "\$config['mod_asistencia']\t\t= $modulo_asistencia;\r\n");
		
		fwrite($file, "\r\n// MÓDULO: HORARIOS\r\n");
		fwrite($file, "\$config['mod_horarios']\t\t\t= $modulo_horarios;\r\n");
		
		fwrite($file, "\r\n// MÓDULO: MATRICULACIÓN\r\n");
		fwrite($file, "\$config['mod_matriculacion']\t\t= $modulo_matriculacion;\r\n");
		fwrite($file, "\$config['mod_transporte_escolar']\t= $modulo_transporte_escolar;\r\n");
		
		fwrite($file, "\r\n\r\n// Fin del archivo de configuración");
		
		$config_nuevo = 1;
		fclose($file);
		
		include('../config.php');
	}
	
	// FORZAR USO DE HTTPS
	if($forzar_ssl)
	{
		if($file = fopen('../.htaccess', 'w+'))
		{
			fwrite($file, "Options +FollowSymLinks\r\n");
			fwrite($file, "RewriteEngine On\r\n");
			fwrite($file, "RewriteCond %{SERVER_PORT} 80\r\n");
			fwrite($file, "RewriteCond %{REQUEST_URI} intranet\r\n");
			fwrite($file, "RewriteRule ^(.*)$ https://".$dominio_centro."/intranet/$1 [R,L]\r\n");
		}
		fclose($fp);
	}
	
}

include('../menu.php');
?>
	
	<div class="container">
		
		<div class="page-header">
			<h2><?php echo $page_header; ?></h2>
		</div>
		
		<?php if($config_nuevo): ?>
		<div class="alert alert-success">
			Los cambios han sido guardados correctamente.
		</div>
		<?php endif; ?>
		
		
		<form id="form-configuracion" class="form-horizontal" data-toggle="validator" class="form-horizontal" method="post" action="" autocomplete="off">
			
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#configuracion" aria-controls="configuracion" role="tab" data-toggle="tab">Configuración general</a></li>
				<li><a href="#modulos" aria-controls="modulos" role="tab" data-toggle="tab">Módulos</a></li>
			</ul>
			
			<br>
			
			<div id="tabs-configuracion" class="tab-content">
			
				<!-- CONFIGURACIÓN GENERAL -->
				<div role="tabpanel" class="tab-pane active" id="configuracion">
					<div class="row">
					
						<div class="col-sm-6">
							
							<div class="well">
							
								<h3><span class="fa fa-university fa-fw"></span> Información de su centro educativo</h3>
								<br>
								
								<input type="hidden" name="dominio_centro" value="<?php echo ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) ? $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'] : $_SERVER['SERVER_NAME']; ?>">
								
								<?php if(forzar_ssl()): ?>
								<input type="hidden" name="forzar_ssl" value="1">
								<?php endif; ?>
								
								<?php $tam_label = 4; ?>
								<?php $tam_control = 7; ?>
								
								<div class="form-group">
								  <label for="nombre_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Denominación <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="nombre_centro" name="nombre_centro" value="<?php echo $config['centro_denominacion']; ?>" data-error="La denominación del centro no es válida" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="codigo_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Centro código <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="codigo_centro" name="codigo_centro" value="<?php echo $config['centro_codigo']; ?>" maxlength="8" data-minlength="8" data-error="El código del centro no es válido" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="email_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Correo electrónico <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="email" class="form-control" id="email_centro" name="email_centro" value="<?php echo $config['centro_email']; ?>" data-error="La dirección de correo electrónico no es válida" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="direccion_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Dirección postal <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="direccion_centro" name="direccion_centro" value="<?php echo $config['centro_direccion']; ?>" data-error="La dirección postal no es válida" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="codpostal_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Código postal <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="codpostal_centro" name="codpostal_centro" value="<?php echo $config['centro_codpostal']; ?>" maxlength="5" data-minlength="5" data-error="El código postal no es válido" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="localidad_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Localidad <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="localidad_centro" name="localidad_centro" value="<?php echo $config['centro_localidad']; ?>" data-error="La localidad no es válida" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="provincia_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Provincia <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <select class="form-control" id="provincia_centro" name="provincia_centro" data-error="La provincia no es válida" required>
								    	<option value=""></option>
								    	<?php foreach($provincias as $provincia): ?>
								    	<option value="<?php echo $provincia; ?>" <?php echo ($provincia == $config['centro_provincia']) ? 'selected' : ''; ?>><?php echo $provincia; ?></option>
								    	<?php endforeach; ?>
								    </select>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="telefono_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Teléfono <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="tel" class="form-control" id="telefono_centro" name="telefono_centro" value="<?php echo $config['centro_telefono']; ?>" maxlength="9" data-minlength="9" data-error="El télefono no es válido" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="fax_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Fax</label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="tel" class="form-control" id="fax_centro" name="fax_centro" value="<?php echo $config['centro_fax']; ?>" maxlength="9" data-minlength="9" data-error="El fax no es válido">
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="direccion_director" class="col-sm-<?php echo $tam_label; ?> control-label">Director/a <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="direccion_director" name="direccion_director" value="<?php echo $config['directivo_direccion']; ?>" maxlength="60" data-error="Este campo es obligatorio" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="direccion_jefe_estudios" class="col-sm-<?php echo $tam_label; ?> control-label">Jefe/a de Estudios <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="direccion_jefe_estudios" name="direccion_jefe_estudios" value="<?php echo $config['directivo_jefatura']; ?>" maxlength="60" data-error="Este campo es obligatorio" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
								<div class="form-group">
								  <label for="direccion_secretaria" class="col-sm-<?php echo $tam_label; ?> control-label">Secretario/a <span class="text-danger">*</span></label>
								  <div class="col-sm-<?php echo $tam_control; ?>">
								    <input type="text" class="form-control" id="direccion_secretaria" name="direccion_secretaria" value="<?php echo $config['directivo_secretaria']; ?>" maxlength="60" data-error="Este campo es obligatorio" required>
								    <div class="help-block with-errors"></div>
								  </div>
								</div>
								
							</div>
							
							
						</div><!-- /.col-sm-6 -->
						
						
						<div class="col-sm-6">
							
							<div class="well">
							
								<h3><span class="fa fa-database fa-fw"></span> Base de datos</h3>
								<br>
								
								<?php $tam_label = 4; ?>
								<?php $tam_control = 7; ?>
								
								<div class="form-group">
									<label for="db_host" class="col-sm-<?php echo $tam_label; ?> control-label">Servidor <span class="text-danger">*</span></label>
									<div class="col-sm-<?php echo $tam_control; ?>">
									  <input type="text" class="form-control" id="db_host" name="db_host" value="<?php echo $config['db_host']; ?>" data-error="La dirección servidor de base de datos no es válida" required>
									  <div class="help-block with-errors"></div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="db_name" class="col-sm-<?php echo $tam_label; ?> control-label">Base de datos <span class="text-danger">*</span></label>
									<div class="col-sm-<?php echo $tam_control; ?>">
									  <input type="text" class="form-control" id="db_name" name="db_name" value="<?php echo $config['db_name']; ?>" data-error="El nombre de la base de datos no es válido" required>
									  <div class="help-block with-errors"></div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="db_user" class="col-sm-<?php echo $tam_label; ?> control-label">Usuario <span class="text-danger">*</span></label>
									<div class="col-sm-<?php echo $tam_control; ?>">
									  <input type="text" class="form-control" id="db_user" name="db_user" value="<?php echo $config['db_user']; ?>" data-error="El nombre de usuario de la base de datos no es válido" required>
									  <div class="help-block with-errors"></div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="db_pass" class="col-sm-<?php echo $tam_label; ?> control-label">Contraseña <span class="text-danger">*</span></label>
									<div class="col-sm-<?php echo $tam_control; ?>">
									  <input type="password" class="form-control" id="db_pass" name="db_pass" value="<?php echo $config['db_pass']; ?>" data-error="La contraseña de la base de datos no es válido" required>
									  <div class="help-block with-errors"></div>
									</div>
								</div>
								
							</div>
							
							<div class="well">
								
								<h3><span class="fa fa-graduation-cap fa-fw"></span> Curso escolar</h3>
								<br>
								  
								  <?php $tam_label = 4; ?>
								  <?php $tam_control = 7; ?>
								  
								  <div class="form-group">
								    <label for="curso_escolar" class="col-sm-<?php echo $tam_label; ?> control-label">Curso escolar <span class="text-danger">*</span></label>
								    <div class="col-sm-<?php echo $tam_control; ?>">
								      <input type="text" class="form-control" id="curso_escolar" name="curso_escolar" value="<?php echo $config['curso_actual']; ?>" required>
								      <div class="help-block with-errors"></div>
								    </div>
								  </div>
								  
								  <div class="form-group">
								    <label for="fecha_inicio" class="col-sm-<?php echo $tam_label; ?> control-label">Fecha de inicio <span class="text-danger">*</span></label>
								    <div class="col-sm-<?php echo $tam_control; ?>">
								      <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $config['curso_inicio']; ?>" required>
								      <div class="help-block with-errors"></div>
								    </div>
								  </div>
								  
								  <div class="form-group">
								    <label for="fecha_final" class="col-sm-<?php echo $tam_label; ?> control-label">Fecha final <span class="text-danger">*</span></label>
								    <div class="col-sm-<?php echo $tam_control; ?>">
								      <input type="text" class="form-control" id="fecha_final" name="fecha_final" value="<?php echo $config['curso_fin']; ?>" required>
								      <div class="help-block with-errors"></div>
								    </div>
								  </div>
								
							</div>
							
							<div class="well">
								
								<h3><span class="fa fa-exclamation-triangle fa-fw"></span> Mantenimiento</h3>
								<br>
								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="mantenimiento" value="1" <?php echo (isset($config['mantenimiento']) && $config['mantenimiento']) ? 'checked' : ''; ?>>
										Activar estado de mantenimiento.
										<p class="help-block">Solo los miembros del equipo directivo pueden acceder a la Intranet.</p>
									</label>
								</div>
							
							</div>
							
						</div><!-- /.col-sm-6 -->
						
					</div><!-- /.row -->
					
				</div><!-- /.tab-pane -->
				
				<!-- CONFIGURACIÓN MÓDULOS -->
				<div role="tabpanel" class="tab-pane" id="modulos">
					
					<div class="well">
						<h3><span class="fa fa-cubes fa-fw"></span> Configuración de módulos</h3>
						<br>
					    
						<div class="row">
							<div class="col-sm-4" style="border-right: 3px solid #dce4ec; margin-right: -3px;">
								<ul class="nav nav-pills nav-stacked" role="tablist">
									<li class="active"><a href="#mod_biblioteca" aria-controls="mod_biblioteca" role="tab" data-toggle="tab">Biblioteca</a></li>
									<li><a href="#mod_bilingue" aria-controls="mod_bilingue" role="tab" data-toggle="tab">Centro Bilingüe</a></li>
									<li><a href="#mod_centrotic" aria-controls="mod_centrotic" role="tab" data-toggle="tab">Centro TIC</a></li>
									<li><a href="#mod_documentos" aria-controls="mod_documentos" role="tab" data-toggle="tab">Documentos</a></li>
									<li><a href="#mod_sms" aria-controls="mod_sms" role="tab" data-toggle="tab">Envío SMS</a></li>
									<li><a href="#mod_asistencia" aria-controls="mod_asistencia" role="tab" data-toggle="tab">Faltas de Asistencia</a></li>
									<li><a href="#mod_horarios" aria-controls="mod_horarios" role="tab" data-toggle="tab">Horarios</a></li>
									<li><a href="#mod_matriculacion" aria-controls="mod_matriculacion" role="tab" data-toggle="tab">Matriculación</a></li>
								</ul>
							</div>
							
							<div class="tab-content col-sm-7" style="border-left: 3px solid #dce4ec; padding-left: 45px;">
								
								<!-- MÓDULO: BIBLIOTECA -->
							    <div role="tabpanel" class="tab-pane active" id="mod_biblioteca">
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
					    			    		<input type="checkbox" name="mod_biblioteca" value="1" <?php echo (isset($config['mod_biblioteca']) && $config['mod_biblioteca']) ? 'checked' : ''; ?>>
					    			    		<strong>Biblioteca</strong>
					    			    		<p class="help-block">Si el Centro dispone de Biblioteca que funciona con Abies, y cuenta con un equipo de profesores dedicados a su mantenimiento, este módulo permite consultar e importar los fondos, lectores y préstamos, así como hacer un seguimiento de los alumnos morosos. También incorpora el código de barras generado por Abies al Carnet del Alumno para facilitar la lectura por parte del scanner de la Biblioteca.</p>
					    			    	</label>
								    	</div>
								    </div>
							    	
							    	<br>
							    	
							    	<div class="form-group">
							    		<label for="mod_biblioteca_web">Página web de la Biblioteca</label>
							    		<div class="input-group">
						    		      <div class="input-group-addon">http://</div>
						    		      <input type="text" class="form-control" id="mod_biblioteca_web" name="mod_biblioteca_web" value="<?php echo $config['mod_biblioteca_web']; ?>">
						    		    </div>
							    	</div>
							    	
							    </div>
							    
							    
							    <!-- MÓDULO: CENTRO BILINGÜE -->
							    <div role="tabpanel" class="tab-pane" id="mod_bilingue">
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
					    			    		<input type="checkbox" name="mod_bilingue" value="1" <?php echo (isset($config['mod_bilingue']) && $config['mod_bilingue']) ? 'checked' : ''; ?>>
					    			    		<strong>Centro Bilingüe</strong>
					    			    		<p class="help-block">Activa características para los Centros Bilingües, como el envío de mensajes a los profesores que pertenecen al programa bilingüe.</p>
					    			    	</label>
								    	</div>
								    </div>
							    	
							    </div>
							    
							    
							    <!-- MÓDULO: CENTRO TIC -->
							    <div role="tabpanel" class="tab-pane" id="mod_centrotic">
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
					    			    		<input type="checkbox" name="mod_centrotic" value="1" <?php echo (isset($config['mod_centrotic']) && $config['mod_centrotic']) ? 'checked' : ''; ?>>
					    			    		<strong>Centro TIC</strong>
					    			    		<p class="help-block">Aplicaciones propias de un Centro TIC: Incidencias, usuarios, etc.</p>
					    			    	</label>
								    	</div>
								    </div>
							    	
							    </div>
							    
							    
							    <!-- MÓDULO: DOCUMENTOS --> 
							    <div role="tabpanel" class="tab-pane" id="mod_documentos" <?php echo (isset($config['mod_documentos']) && $config['mod_documentos']) ? 'checked' : ''; ?>>
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
								    			<input type="checkbox" name="mod_documentos" value="1" checked>
								    			<strong>Documentos</strong>
								    			<p class="help-block">Directorio en el Servidor local donde tenemos documentos públicos que queremos administrar (visualizar, eliminar, subir, compartir, etc.) con la Intranet.</p>
								    		</label>
								    	</div>
								    </div>
							    				    			    	
							    	<div class="form-group">
							    		<label for="mod_documentos_dir">Directorio público</label>
							    	    <input type="text" class="form-control" id="mod_documentos_dir" name="mod_documentos_dir" value="<?php echo $config['mod_documentos_dir']; ?>">
							    	</div>
							    	
							    	<div class="checkbox">
							    		<label>
							    			<input type="checkbox" name="mod_documentos_biblioteca" value="1" <?php echo (isset($config['mod_documentos_biblioteca']) && $config['mod_documentos_biblioteca']) ? 'checked' : ''; ?>>
							    			<strong>Biblioteca</strong>
							    			<p class="help-block">Creará una carpeta donde el personal de Biblioteca puede subir documentos de interés para la comunidad educativa.</p>
							    		</label>
							    	</div>
							    	
							    	<div class="checkbox">
							    		<label>
							    			<input type="checkbox" name="mod_documentos_recursos" value="1" <?php echo (isset($config['mod_documentos_recursos']) && $config['mod_documentos_recursos']) ? 'checked' : ''; ?>>
							    			<strong>Recursos educativos</strong>
							    			<p class="help-block">Creará una carpeta <strong>Recursos</strong>, con el nombre de cada Grupo de Alumnos en el que los miembros de un Equipo Educativo pueden subir archivos visibles para Padres y Alumnos en <u>Acceso para Alumnos</u> de la <em>Página del Centro</em>.</p>
							    		</label>
							    	</div>
							    	
							    	<div class="checkbox">
							    		<label>
							    			<input type="checkbox" name="mod_documentos_departamentos" value="1" <?php echo (isset($config['mod_documentos_departamentos']) && $config['mod_documentos_departamentos']) ? 'checked' : ''; ?>>
							    			<strong>Departamentos</strong>
							    			<p class="help-block">Creará una carpeta para los Departamentos del Centro donde estos pueden colocar documentos importantes y públicos (Programaciones, etc.) visibles desde la <em>Página del Centro</em>.</p>
							    		</label>
							    	</div>
							    	
							    </div>
							    
							    
							    <!-- MÓDULO: ENVÍO DE SMS -->
							    <div role="tabpanel" class="tab-pane" id="mod_sms">
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
								    			<input type="checkbox" name="mod_sms" value="1" <?php echo (isset($config['mod_sms']) && $config['mod_sms']) ? 'checked' : ''; ?>>
								    			<strong>Envío de SMS</strong>
								    			<p class="help-block">Pone en funcionamiento el envío de SMS en distintos lugares de la Intranet (Problemas de convivencia, faltas de asistencia, etc.). La aplicación está preparada para trabajar con la API de <a href="http://www.trendoo.es/" target="_blank">Trendoo</a>.</p>
								    		</label>
								    	</div>
								    </div>
							    	
							    	<div class="form-group">
							    		<label for="mod_sms_id">Nombre de identificación (<abbr title="Transmission Path Originating Address">TPOA</abbr>)</label>
							    	    <input type="text" class="form-control" id="mod_sms_id" name="mod_sms_id" value="<?php echo $config['mod_sms_id']; ?>" maxlength="11">
							    	    <p class="help-block">11 caracteres como máximo.</p>
							    	</div>
							    	
							    	<div class="form-group">
							    		<label for="mod_sms_user">Usuario</label>
							    	    <input type="text" class="form-control" id="mod_sms_user" name="mod_sms_user" value="<?php echo $config['mod_sms_user']; ?>">
							    	</div>
							    	
							    	<div class="form-group">
							    		<label for="mod_sms_pass">Contraseña</label>
							    	    <input type="password" class="form-control" id="mod_sms_pass" name="mod_sms_pass" value="<?php echo $config['mod_sms_pass']; ?>">
							    	</div>
							    	
							    </div>
							    
							    
							    <!-- MÓDULO: FALTAS DE ASISTENCIA -->
							    <div role="tabpanel" class="tab-pane" id="mod_asistencia">
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
								    			<input type="checkbox" id="check_asistencia" name="mod_asistencia" value="1" <?php echo (isset($config['mod_asistencia']) && $config['mod_asistencia']) ? 'checked' : ''; ?>>
								    			<strong>Faltas de Asistencia</strong>
								    			<p class="help-block">El módulo de Faltas gestiona las asistencia de los alumnos. Permite registrar las ausencias diarias, al modo de <em>iSeneca</em>), que luego podremos gestionar (Consultar, Justificar, crear Informes, enviar SMS, etc.) y subir finalmente a Séneca. <br>O bien podemos descargar las faltas desde Séneca para utilizar los módulos de la aplicación basados en faltas de asistencia (Informes de alumnos, Tutoría, Absentismo, etc.).</p>
								    		</label>
								    	</div>
								    </div>
							    	
							    	<div class="alert alert-warning">Este módulo depende del módulo de Horarios. Si decide utilizarlo se activará el módulo de Horarios automáticamente.</div>
							    	
							    </div>
							    
							    
							    <!-- MÓDULO: HORARIOS -->
							    <div role="tabpanel" class="tab-pane" id="mod_horarios">
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
								    			<input type="checkbox" id="check_horarios" name="mod_horarios" value="1" <?php echo (isset($config['mod_horarios']) && $config['mod_horarios']) ? 'checked' : ''; ?>>
								    			<strong>Horarios</strong>
								    			<p class="help-block">Si disponemos de un archivo de Horario en formato XML (como el que se utiliza para subir a Séneca) o DEL (como el que genera el programa Horw) para importar sus datos a la Intranet. Aunque no obligatoria, esta opción es necesaria si queremos hacernos una idea de todo lo que la aplicación puede ofrecer.</p>
								    		</label>
								    	</div>
								    </div>
							    	
							    </div>
							    
							    
							    <!-- MÓDULO: MATRICULACIÓN -->
							    <div role="tabpanel" class="tab-pane" id="mod_matriculacion">
							    	
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
								    			<input type="checkbox" name="mod_matriculacion" value="1" <?php echo (isset($config['mod_matriculacion']) && $config['mod_matriculacion']) ? 'checked' : ''; ?>>
								    			<strong>Matriculación</strong>
								    			<p class="help-block">Este módulo permite matricular a los alumnos desde la propia aplicación o bien desde la página pública del Centro incluyendo el código correspondiente. Requiere que cada Centro personalice las materias y optativas que va a ofrecer a sus Alumnos.</p>
								    		</label>
								    	</div>
								    </div>
								    
							    	<div class="form-group">
								    	<div class="checkbox">
								    		<label>
								    			<input type="checkbox" name="mod_transporte_escolar" value="1" <?php echo (isset($config['mod_transporte_escolar']) && $config['mod_transporte_escolar']) ? 'checked' : ''; ?>>
								    			<strong>Transporte escolar</strong>
								    			<p class="help-block">Activa la selección de transporte escolar</p>
								    		</label>
								    	</div>
								    </div>
							    	
							    </div>
							  </div>
						</div>
						
					</div>
					
				</div><!-- /.tab-pane -->
				
				
				<div class="row">
					
					<div class="col-sm-12">
					
						<button type="submit" class="btn btn-primary" name="config">Guardar cambios</button>
						<a href="../xml/index.php" class="btn btn-default">Volver</a>
						
					</div>
					
				</div>
				
			</div><!-- /.tab-content -->
			
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