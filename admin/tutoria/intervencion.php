<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2, 8));

// COMPROBAMOS SI ES EL TUTOR, SINO ES DEL EQ. DIRECTIVO U ORIENTADOR
if (stristr($_SESSION['cargo'],'2') == TRUE) {
	
	$_SESSION['mod_tutoria']['tutor']  = $_SESSION['mod_tutoria']['tutor'];
	$_SESSION['mod_tutoria']['unidad'] = $_SESSION['mod_tutoria']['unidad'];
	
}
else {

	if(isset($_POST['tutor'])) {
		$exp_tutor = explode('==>', $_POST['tutor']);
		$_SESSION['mod_tutoria']['tutor'] = trim($exp_tutor[0]);
		$_SESSION['mod_tutoria']['unidad'] = trim($exp_tutor[1]);
	}
	else{
		if (!isset($_SESSION['mod_tutoria'])) {
			header('Location:'.'tutores.php');
		}
	}
	
}

if (isset($_POST['alumno'])) $alumno = $_POST['alumno'];
if (isset($_GET['alumno'])) $alumno = $_GET['alumno'];


// COMPROBAMOS SI SE PASA UN ID DE INTERVENCION
if (isset($_GET['id'])) {
	$result = mysqli_query($db_con, "SELECT apellidos, nombre, fecha, accion, causa, observaciones, tutoria.unidad, FTUTORES.tutor, id, prohibido, orienta, jefatura, claveal FROM tutoria, FTUTORES WHERE tutoria.unidad = FTUTORES.unidad AND id='".$_GET['id']."' AND tutoria.unidad = '".$_SESSION['mod_tutoria']['unidad']."'");
	
	if (mysqli_num_rows($result)) {
		$row = mysqli_fetch_array($result);
		
		$alumno = $row['apellidos'].", ".$row['nombre']." --> ".$row['claveal'];
		$apellidos = $row['apellidos'];
		$nombre = $row['nombre'];
		$claveal = $row['claveal'];
		$unidad = $row['unidad'];
		$tutor = $row['tutor'];
		$exp_fecha_reg = explode("-", $row['fecha']);
		$fecha_reg = $exp_fecha_reg[2].'-'.$exp_fecha_reg[1].'-'.$exp_fecha_reg[0];
		$observaciones = $row['observaciones'];
		$accion = $row['accion'];
		$causa = $row['causa'];
		$prohibido = $row['prohibido'];
		$orientacion = $row['orienta'];
		$jefatura = $row['jefatura'];
		
		mysqli_free_result($result);
	}
	else {
		$msg_error = "La intervención que intenta editar no existe o no tiene privilegios administrativos para editarlo.";
		unset($_GET['id']);
	}
}


// ENVIO DEL FORMULARIO
if (isset($_POST['enviar'])) {
	
	// VARIABLES DEL FORMULARIO
	$alumno = $_POST['alumno'];
	$fecha_reg = $_POST['fecha_reg'];
	$observaciones = $_POST['observaciones'];
	$causa = $_POST['causa'];
	$accion = $_POST['accion'];
	
	if (empty($alumno) || empty($fecha_reg) || empty($observaciones) || empty($causa) || empty($accion)) {
		$msg_error = "Todos los campos del formulario son obligatorios.";
	}
	else {
		
		$exp_fecha_reg = explode("-", $fecha_reg);
		$fecha_sql = $exp_fecha_reg[2].'-'.$exp_fecha_reg[1].'-'.$exp_fecha_reg[0];
		
		
		// COMPROBAMOS SI SE TRATA DE UNA ACTUALIZACIÓN O INSERCIÓN
		if (isset($_GET['id'])) {
		
			$result = mysqli_query($db_con, "UPDATE tutoria SET observaciones='$observaciones', causa='$causa', accion='$accion', fecha='$fecha_sql' WHERE id='".$_GET['id']."'");
			
			if (!$result) $msg_error = "La intervención no se ha podido actualizar. Error: ".mysqli_error($db_con);
			else $msg_success = "La intervención ha sido actualizada.";
			
		}
		else {
			
			if ($alumno == "Todos, todos") {
				
				$result = mysqli_query($db_con, "SELECT apellidos, nombre, claveal FROM FALUMNOS WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."'");
				
				while ($row = mysqli_fetch_array($result)) {
					$apellidos = $row[0];
					$nombre = $row[1];
					$claveal = $row[2];
					
					$result1 = mysqli_query($db_con, "INSERT INTO tutoria (apellidos, nombre, tutor, unidad, observaciones, causa, accion, fecha, claveal) VALUES ('$apellidos', '$nombre', '".$_SESSION['mod_tutoria']['tutor']."', '".$_SESSION['mod_tutoria']['unidad']."', '$observaciones', '$causa', '$accion', '$fecha_sql', '$claveal')");
					
					if (!$result) $msg_error = "La intervención al alumno $nombre $apellidos no ha podido registrarse. Error: ".mysqli_error($db_con);
					else $msg_success = "La intervención ha sido registrada a todos los alumnos de la undidad.";
				}
				
				mysqli_free_result($result);
			}
			else {
				
				$exp_alumno = explode(' --> ', $alumno);
				$exp_nombre = explode(', ', $exp_alumno[0]);
				$apellidos = trim($exp_nombre[0]);
				$nombre = trim($exp_nombre[1]);
				$claveal = trim($exp_alumno[1]);
				
				$result = mysqli_query($db_con, "INSERT INTO tutoria (apellidos, nombre, tutor, unidad, observaciones, causa, accion, fecha, claveal) VALUES 
						('".$apellidos."', '".$nombre."', '".$_SESSION['mod_tutoria']['tutor']."', '".$_SESSION['mod_tutoria']['unidad']."', '$observaciones', '$causa', '$accion', '$fecha_sql', '$claveal')");
						
				if (!$result) $msg_error = "La intervención no se ha podido registrar. Error: ".mysqli_error($db_con);
				else $msg_success = "La intervención ha sido registrada.";
			}
			
		}
		
	}
}


// ELIMINAR INTERVENCIÓN
if (isset($_GET['eliminar']) && isset($_GET['id'])) {
	$result = mysqli_query($db_con, "DELETE FROM tutoria WHERE id='".$_GET['id']."' LIMIT 1");
	
	if (!$result) $msg_error = "No se ha podido eliminar la intervención. Error: ".mysqli_error($db_con);
	else $msg_success = "La intervención ha sido eliminada.";
}


// INFORMAMOS AL TUTOR QUIEN HA REGISTRADO LA INTERVENCIÓN
if (isset($orientacion) && $orientacion == 1) {
	$msg_info = "El departamento de Orientacion ha registrado esta intervención tutorial.";
}

if (isset($accion) && $accion == 'Registro de Jefatura de Estudios') {
	$msg_info = "Jefatura de estudios ha registrado esta intervención tutorial.";
}

if (isset($jefatura) && $jefatura == 1) {
	$msg_info = "Jefatura de estudios ha registrado esta intervención tutorial.";
}


// PLUGINS
$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2 style="display:inline;">Tutoría de <?php echo $_SESSION['mod_tutoria']['unidad']; ?> <small>Intervenciones sobre los alumnos</small></h2>
			
			<!-- Button trigger modal -->
			<a href="#"class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
				<span class="fa fa-question fa-lg"></span>
			</a>
		
			<!-- Modal -->
			<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modal_ayuda_titulo" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
							<h4 class="modal-title" id="modal_ayuda_titulo">Instrucciones de uso</h4>
						</div>
						<div class="modal-body">
							<p>Las Intervenciones del Tutor funcionan a modo de Diario de Tutoría 
							donde se registran las actividades de distinto tipo (entrevistas con 
							Padres o Alumnos, llamadas de teléfono, etc.) que el Tutor realiza dentro 
							de sus funciones.</p>
							<p>El Tutor recoge los datos de las intervenciones en el formulario de 
							tal modo que pueda hacer un seguimiento de sus actividades con los 
							alumnos de su tutoría. También aparecen registradas como Intervenciones 
							los mensajes SMS enviados a los Padres con motivo de Problemas de 
							Convivencia o Faltas de Asistencia. Estas intervenciones aparecen 
							recogidas a final de Curso en la Memoria de Tutoría.</p>
							<p>La página presenta el formulario de intervenciones y una lista con 
							todas las intervenciones realizadas ordenadas por fecha. Al hacer click 
							sobre un alumno de esta lista, se visualiza la intervención en el 
							formulario (pudiendo editarla, borrarla, etc.) y aparece el historial 
							de las intervenciones sobre el alumno bajo el formulario.</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
						</div>
					</div>
				</div>
			</div>

			<h4 class="text-info">Tutor/a: <?php echo nomprofesor($_SESSION['mod_tutoria']['tutor']); ?></h4>
		</div>
		
		
		<!-- MENSAJES -->
		<?php if(isset($msg_error)): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $msg_error; ?>
		</div>
		
		<br>
		<?php endif; ?>
		
		<?php if(isset($msg_success)): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_success; ?>
		</div>
		
		<br>
		<?php endif; ?>
		
		<?php if(isset($msg_info)): ?>
		<div class="alert alert-info" role="alert">
			<?php echo $msg_info; ?>
		</div>
		
		<br>
		<?php endif; ?>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-7">
			
				<?php if($alumno && !($alumno == "Todos los Alumnos")): ?>
				<?php $exp_alumno = explode(" --> ", $alumno); ?>
				<?php $claveal = $exp_alumno[1]; ?>
				<?php $foto = '../../xml/fotos/'.$claveal.'.jpg'; ?>
				<?php if(file_exists($foto)): ?>
				<img class="img-thumbnail" src="<?php echo $foto; ?>" alt="" width="65" style="position: absolute; top: 5px; right: 0; margin-right: 35px;">
				<?php endif; ?>
				<?php endif; ?>
				
				<div class="well">
					
					<form method="post" action="">
						<fieldset>
							<legend>Registro de datos</legend>
	
							<div class="row">
								<div class="col-sm-7">
									<div class="form-group">
									  <label for="alumno">Alumno/a</label>
									  <?php $result = mysqli_query($db_con, "SELECT DISTINCT APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."' ORDER BY NC ASC"); ?>
									  <?php if(mysqli_num_rows($result)): ?>
									  <select class="form-control" id="alumno" name="alumno" onchange="submit()">
									  	<option value="Todos, todos">Todos los Alumnos</option>
									  	<?php while($row = mysqli_fetch_array($result)): ?>
									  	<option value="<?php echo $row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['claveal']; ?>" <?php echo (isset($alumno) && $row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['claveal'] == $alumno) ? 'selected' : ''; ?>><?php echo $row['APELLIDOS'].', '.$row['NOMBRE']; ?></option>
									  	<?php endwhile; ?>
									  	<?php mysqli_free_result($result); ?>
									  </select>
									  <?php else: ?>
									  <select class="form-control" name="alumno" disabled>
									  	<option></option>
									  </select>
									  <?php endif; ?>
									</div>
								</div>
								
								<div class="col-sm-5">
									<div class="form-group" id="datetimepicker1">
									  <label for="fecha_reg">Fecha</label>
										<div class="input-group">
											<input name="fecha_reg" type="text" class="input form-control" value="<?php echo (isset($fecha_reg) && $fecha_reg) ? $fecha_reg : date('d-m-Y'); ?>" data-date-format="DD-MM-YYYY" id="fecha_reg" >
										  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
							
						  
						  <div class="form-group">
						  	<label for="observaciones">Observaciones</label>
						    <textarea class="form-control" id="observaciones" name="observaciones" placeholder="Escriba la intervención realizada sobre el alumno..." rows="10"><?php echo (isset($observaciones) && $observaciones) ? $observaciones : ''; ?></textarea>
						  </div>
						  
						  <div class="row">
						  	<div class="col-sm-6">
						  		<div class="form-group">
						  		  <label for="causa">Causa</label>
						  		  <select class="form-control" id="causa" name="causa">
						  		  	<option value="Estado general del Alumno" <?php echo (isset($causa) && $causa == 'Estado general del Alumno') ? 'selected' : ''; ?>>Estado general del Alumno</option>
						  		  	<option value="Evolución académica" <?php echo (isset($causa) && $causa == 'Evolución académica') ? 'selected' : ''; ?>>Evolución académica</option>
						  		  	<option value="Faltas de Asistencia" <?php echo (isset($causa) && $causa == 'Faltas de Asistencia') ? 'selected' : ''; ?>>Faltas de Asistencia</option>
						  		  	<option value="Problemas de convivencia" <?php echo (isset($causa) && $causa == 'Problemas de convivencia') ? 'selected' : ''; ?>>Problemas de convivencia</option>
						  		  	<option value="Llamada por Enfermedad" <?php echo (isset($causa) && $causa == 'Llamada por Enfermedad') ? 'selected' : ''; ?>>Llamada por Enfermedad</option>
						  		  	<option value="Robo, hurto" <?php echo (isset($causa) && $causa == 'Robo, hurto') ? 'selected' : ''; ?>>Robo, hurto</option>
						  		  	<option value="Otras" <?php echo (isset($causa) && $causa == 'Otras') ? 'selected' : ''; ?>>Otras</option>
						  		  </select>
						  		</div>
						  	</div>
						  	
						  	<div class="col-sm-6">
						  		<div class="form-group">
						  		  <label for="accion">Tipo</label>
						  			<select class="form-control" id="accion" name="accion">
						  				<option value="Entrevista telefónica" <?php echo (isset($accion) && $accion == 'Entrevista telefónica') ? 'selected' : ''; ?>>Entrevista telefónica</option>
						  				<option value="Entrevista personal" <?php echo (isset($accion) && $accion == 'Entrevista personal') ? 'selected' : ''; ?>>Entrevista personal</option>
						  				<option value="Comunicación por escrito" <?php echo (isset($accion) && $accion == 'Comunicación por escrito') ? 'selected' : ''; ?>>Comunicación por escrito</option>
						  			</select>
						  		</div>
						  	</div>
						  </div>
						  
						  <?php if(isset($_GET['id'])): ?>
						  <button type="submit" class="btn btn-primary" name="enviar">Actualizar</button>
						  <a href="intervencion.php?id=<?php echo $_GET['id']; ?>&eliminar=1" class="btn btn-danger" data-bb="confirm-delete">Eliminar</a>
						  <a class="btn btn-default" href="intervencion.php">Nueva intervención</a>
						  <?php else: ?>
						  <button type="submit" class="btn btn-primary" name="enviar">Registrar</button>
						  <?php endif; ?>
						</fieldset>
							
					</form>
					
				</div><!-- /.well -->
				
				<?php
				if($alumno && $alumno != 'Todos, todos'){
					$tr = explode(" --> ",$alumno);
					$al = $tr[0];
					$clave = $tr[1];
					$trozos = explode (", ", $al);
					$apellidos = $trozos[0];
					$nombre = $trozos[1];
				?>
				<div class="well">
					<h4>Historial de intervenciones de <?php echo $nombre." ".$apellidos; ?></h4>
				<?php
					$result = mysqli_query($db_con, "SELECT apellidos, nombre, fecha, accion, causa, observaciones, id FROM tutoria WHERE claveal='$claveal' AND prohibido = '0' ORDER BY fecha DESC");
				
					if ($row = mysqli_fetch_array($result)) {
						echo '<table class="table table-striped">';
						echo "<thead><tr><th>Fecha</th><th>Tipo</th><th>Causa</th><th></th></tr></thead><tbody>";
						
						do{
						  $obs=substr($row[5],0,80)."...";
						  $dia3 = explode("-",$row[2]);
						  $fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
							echo "<tr><td>$fecha3</td><td>$row[3]</a></td><td>$row[4]</a></td><td >
							<a href='intervencion.php?id=$row[6]' data-bs='tooltip' title='Ver informe'><i class='fa fa-search fa-lg fa-fw'></i></a>
							</td></tr>";
						}
						while($row = mysqli_fetch_array($result));
					
						echo "</table>";
					}
					else {
						echo '<br><p class="lead text-center text-muted">El alumno/a no tiene intervenciones registradas.</p>';
					}
				?>
				</div><!-- /.well -->
				<?php
				}
				?>
				
			</div><!-- /.col-sm-7 -->
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-5">
				
				<legend>Intervenciones registradas</legend>
				
				<?php $result = mysqli_query($db_con, "SELECT DISTINCT apellidos, nombre, claveal FROM tutoria WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."' AND DATE(fecha) > '".$config['curso_inicio']."' ORDER BY apellidos ASC, nombre ASC"); ?>
				<?php if (mysqli_num_rows($result)): ?>
				<table class="table table-striped datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>Alumno/a</th>
							<th>Fecha</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_array($result)): ?>
						<?php $result1 = mysqli_query($db_con, "SELECT fecha, id FROM tutoria WHERE claveal = '".$row['claveal']."' AND prohibido = '0' AND unidad = '".$_SESSION['mod_tutoria']['unidad']."' AND DATE(fecha)> '".$config['curso_inicio']."' ORDER BY fecha DESC LIMIT 1"); ?>
						<?php while ($row1 = mysqli_fetch_array($result1)): ?>
						<tr>
							<td><?php echo $row1['id']; ?></td>
							<td><a href="intervencion.php?id=<?php echo $row1['id']; ?>"><?php echo ($row['apellidos'] == 'Todos') ? 'Todos los alumnos' : $row['nombre'].' '.$row['apellidos']; ?></a></td>
							<td><?php echo strftime('%e %b',strtotime($row1['fecha'])); ?></td>
						</tr>
						<?php endwhile; ?>
						<?php mysqli_free_result($result1); ?>
						<?php endwhile; ?>
						<?php mysqli_free_result($result); ?>
					</tbody>
				</table>
				
				<?php else: ?>
				
				<br>
				<p class="lead text-muted">No hay intervenciones registradas para esta unidad.</p>
				<br>
				
				<?php endif; ?>
				
			</div><!-- /.col-sm-5 -->
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php");?>

	<script>  
	$(document).ready(function() {
		var table = $('.datatable').DataTable({
			"paging":   true,
	    "ordering": true,
	    "info":     false,
	    
			"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
			
			"order": [[ 0, "desc" ]],
			
			"language": {
			            "lengthMenu": "_MENU_",
			            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
			            "info": "Página _PAGE_ de _PAGES_",
			            "infoEmpty": "No hay resultados disponibles.",
			            "infoFiltered": "(filtrado de _MAX_ resultados)",
			            "search": "Buscar: ",
			            "paginate": {
			                  "first": "Primera",
			                  "next": "Última",
			                  "next": "",
			                  "previous": ""
			                }
			        }
		});
	});
	
	// DATETIMEPICKER
	$(function () {
	    $('#datetimepicker1').datetimepicker({
	    	language: 'es',
	    	pickTime: false
	    });
	});
	</script>

</body>
</html>
