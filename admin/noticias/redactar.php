<?php
require('../../bootstrap.php');

$profesor = $_SESSION ['profi'];

if($_POST['token']) $token = $_POST['token'];
if(!isset($token)) $token = time(); 


if (isset($_GET['id'])) $id = $_GET['id'];

// ENVIO DEL FORMULARIO
if (isset($_POST['enviar'])) {
	
	// VARIABLES DEL FORMULARIO
	$slug = $_POST['slug'];
	$content = addslashes($_POST['content']);
	$contact = $_POST['contact'];
	$fecha_pub = $_POST['fecha_pub'];
	$clase = $_POST['clase'];
	$ndias = $_POST['ndias'];
	$intranet = $_POST['intranet'];
	$principal = $_POST['principal'];
	$pagina = $intranet.$principal;
	
	if (empty($slug) || empty($content) || empty($fecha_pub)) {
		$msg_error = "Todos los campos del formulario son obligatorios.";
	}
	else {
		
		if ($ndias != 0 && !intval($ndias)) {
			$msg_error = "Debe indicar el número de días que desea que la noticia sea destacada.";
		}
		else {
			
			if ($ndias == 0) $fechafin = '0000-00-00';
			else $fechafin = date("Y-m-d", strtotime("$fecha_pub +$ndias days"));
			
			if(empty($intranet) && empty($principal)) {
				$msg_error = "Debe indicar dónde desea publicar la noticia.";
			}
			else {
				// COMPROBAMOS SI INSERTAMOS O ACTUALIZAMOS
				if(isset($id)) {
					// ACTUALIZAMOS LA NOTICIA
					$result = mysqli_query($db_con, "UPDATE noticias SET slug='$slug', content='$content', contact='$contact', timestamp='$fecha_pub', clase='$clase', fechafin='$fechafin', pagina=$pagina WHERE id=$id LIMIT 1");
					if (!$result) $msg_error = "No se ha podido actualizar la noticia. Error: ".mysqli_error($db_con);
					else $msg_success = "La noticia ha sido actualizada correctamente.";
				}
				else {
					// INSERTAMOS LA NOTICIA
					$result = mysqli_query($db_con, "INSERT INTO noticias (slug, content, contact, timestamp, clase, fechafin, pagina) VALUES ('$slug','$content','$contact','$fecha_pub','$clase','$fechafin',$pagina)");
					if (!$result) $msg_error = "No se ha podido publicar la noticia. Error: ".mysqli_error($db_con);
					else $msg_success = "La noticia ha sido publicada correctamente.";
				}
			}
			
		}
		
	}
	
}

// OBTENEMOS LOS DATOS SI SE OBTIENE EL ID DE LA NOTICIA
if (isset($id) && (int) $id) {
	
	$result = mysqli_query($db_con, "SELECT slug, content, contact, timestamp, DATEDIFF(fechafin, timestamp) AS ndias, clase, pagina FROM noticias WHERE id=$id LIMIT 1");
	if (!mysqli_num_rows($result)) {
		$msg_error = "La noticia que intenta editar no existe.";
		unset($id);
	}
	else {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (stristr($_SESSION['cargo'],'1') == TRUE || $row['contact'] == $_SESSION['profi']) {
			$slug = ((strstr($row['slug'], ' [Actualizado]') == true) || (strstr($row['slug'], ' (Actualizado)') == true)) ? $row['slug'] : $row['slug'].' [Actualizado]';
			$content = $row['content'];
			$contact = $row['contact'];
			$fecha_pub = $row['timestamp'];
			$clase = $row['clase'];
			$ndias = $row['ndias'];
			$pagina = $row['pagina'];
			
			// OBTENEMOS LOS LUGARES DONDE SE HA PUBLICADO LA NOTICIA
			if (strstr($pagina, '1') == true) $intranet = 1;
			if (strstr($pagina, '2') == true) $principal = 2;
		}
		else {
			$msg_error = "No eres el autor o no tienes privilegios administrativos para editar esta noticia.";
			unset($id);
		}
		
		mysqli_free_result($result);
	}
	
}


include ("../../menu.php");
include ("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Noticias <small>Redactar nueva noticia</small></h2>
		</div>
		
		<!-- MENSAJES -->
		<?php if (isset($msg_error)): ?>
		<div class="alert alert-danger">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		<?php if (isset($msg_success)): ?>
		<div class="alert alert-success">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
			
			
			<form method="post" action="">
			
				<!-- COLUMNA IZQUIERDA -->
				<div class="col-sm-8">
					
					<div class="well">
						
						<fieldset>
							<legend>Redactar nueva noticia</legend>
							
							<input type="hidden" name="token" value="<?php echo $token; ?>">
							
								<div class="form-group">
									<label for="slug">Título</label>
									<input type="text" class="form-control" id="slug" name="slug" placeholder="Título de la noticia" value="<?php echo (isset($slug) && $slug) ? $slug : ''; ?>" maxlength="120" autofocus>
								</div>
								
								<div class="form-group">
									<label for="content" class="sr-only">Contenido</label>
									<textarea class="form-control" id="content" name="content" rows="10" maxlength="3000"><?php echo (isset($content) && $content) ? stripslashes($content) : ''; ?></textarea>
								</div>
								
								<button type="submit" class="btn btn-primary" name="enviar"><?php echo (isset($id) && $id) ? 'Actualizar' : 'Publicar'; ?></button>
								<button type="reset" class="btn btn-default">Cancelar</button>
							
						</fieldset>
						
					</div>
					
				</div><!-- /.col-sm-8 -->
				
				
				<!-- COLUMNA DERECHA -->
				<div class="col-sm-4">
					
					<div class="well">
						
						<fieldset>
							<legend>Opciones de publicación</legend>
							
							
							<div class="form-group">
								<label for="autor">Autor</label>
								<input type="text" class="form-control" id="autor" name="autor" value="<?php echo (isset($contact) && $contact) ? $contact : $_SESSION['profi']; ?>" readonly>
									<input type="hidden" name="contact" value="<?php echo (isset($contact) && $contact) ? $contact : $_SESSION['profi']; ?>">
							</div>
							
							<div class="form-group" id="datetimepicker1">
								<label for="fecha_pub">Fecha de publicación</label>
								<div class="input-group">
									<input type="text" class="form-control" id="fecha_pub" name="fecha_pub" value="<?php echo (isset($fecha_pub) && $fecha_pub) ? $fecha_pub : date('Y-m-d H:i:s'); ?>" data-date-format="YYYY-MM-DD HH:mm:ss">
									<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								</div>
							</div>
							
							<?php $categorias = array('Dirección del Centro', 'Jefatura de Estudios', 'Secretaría', 'Actividades Extraescolares', 'Proyecto Escuela de Paz', 'Centro Bilingüe', 'Centro TIC', 'Ciclos Formativos'); ?>
							
							<div class="form-group">
								<label for="clase">Categoría</label>
								<select class="form-control" id="clase" name="clase">
								<?php foreach ($categorias as $categoria): ?>
									<option value="<?php echo $categoria; ?>" <?php echo (isset($clase) && $categoria == $clase) ? 'selected' : ''; ?>><?php echo $categoria; ?></option>
								<?php endforeach; ?>
								</select>
							</div>
							
							<?php if (stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<br>
							
							<div class="form-horizontal">
								<div class="form-group">
							    <label for="ndias" class="col-sm-8 control-label"><div class="text-left">Noticia destacada (en días)</div></label>
							    <div class="col-sm-4">
							      <input type="number" class="form-control" id="ndias" name="ndias" value="<?php echo (isset($ndias) && $ndias) ? $ndias : '0'; ?>" min="0" max="31" maxlength="2">
							    </div>
							  </div>
							</div>
							
							<br>
							
							<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="intranet" value="1" <?php echo (isset($intranet) && $intranet) ? 'checked' : ''; ?>> Publicar en la Intranet
									</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="principal" value="2" <?php echo (isset($principal) && $principal) ? 'checked' : ''; ?>> Publicar en la página externa
									</label>
								</div>
							</div>
							<?php else: ?>
							
							<input type="hidden" name="intranet" value="1">
							
							<?php endif; ?>
							
						</fieldset>
						
					</div>
					
				</div><!-- /.col-sm-4 -->
			
			</form>
			
					
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>
	
	<script>
	$(document).ready(function() {
		
		// EDITOR DE TEXTO
		$('#content').summernote({
			height: 300,
			lang: 'es-ES',
			
			onChange: function(content) {
				var sHTML = $('#content').code();
		    localStorage['summernote-<?php echo $token; ?>'] = sHTML;
			}
		});
		
		$('#content').code(localStorage['summernote-<?php echo $token; ?>']);
		
		
		
	});
	
	// DATETIMEPICKER
	$(function () {
	    $('#datetimepicker1').datetimepicker({
	    	language: 'es',
	    	useSeconds: true,
	    });
	});
	</script>

</body>
</html>
