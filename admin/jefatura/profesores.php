<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$cargo = $_SESSION['cargo'];

// Tabla
mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `intervenciones_profesores` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `idea` varchar(12) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
	  `nombre` varchar(60) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
	  `observaciones` text COLLATE latin1_spanish_ci NOT NULL,
	  `causa` varchar(42) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
	  `accion` varchar(200) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
	  `fecha` date NOT NULL DEFAULT '0000-00-00',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// VARIABLES DEL FORMULARIO

if (isset($_GET['id'])) $id = mysqli_real_escape_string($db_con, $_GET['id']);
$profesor = mysqli_real_escape_string($db_con, $_POST['profesor']);
$fecha_reg = (isset($_POST['fecha_reg'])) ? mysqli_real_escape_string($db_con, $_POST['fecha_reg']) : date('d-m-Y');
$observaciones = mysqli_real_escape_string($db_con, trim($_POST['observaciones']));
$causa = mysqli_real_escape_string($db_con, $_POST['causa']);
$accion = mysqli_real_escape_string($db_con, $_POST['accion']);

// INSERCIÓN
if (isset($_POST['submit1'])) {
	
	if (! empty($profesor) && ! empty($fecha_reg) && ! empty($observaciones) && ! empty($causa) && ! empty($accion)) {
		
		$result = mysqli_query($db_con, "SELECT nombre FROM departamentos WHERE idea = '$profesor'");
		$row = mysqli_fetch_array($result);
		$nombre_profesor = $row['nombre'];
		mysqli_free_result($result);
		
		$exp_fecha_sql = explode('-', $fecha_reg);
		$fecha_sql = $exp_fecha_sql[2].''.$exp_fecha_sql[1].''.$exp_fecha_sql[0];
		
		$result = mysqli_query($db_con, "INSERT intervenciones_profesores (idea, nombre, observaciones, causa, accion, fecha) VALUES ('$profesor', '$nombre_profesor', '$observaciones', '$causa', '$accion', '$fecha_sql')");
		
		if (! $result) {
			$msg_error = "No se ha podido registrar la intervención. Error: ".mysqli_error($db_con);
		}
		else {
			$msg_success = "La intervención ha sido registrada.";
		}
		
	}
	else {
		$msg_error = "Todos los campos del formulario son obligatorios.";
	}
	
}

// ACTUALIZACIÓN
if (isset($_POST['submit2'])) {
	
	if (! empty($id) && ! empty($profesor) && ! empty($fecha_reg) && ! empty($observaciones) && ! empty($causa) && ! empty($accion)) {
		
		$result = mysqli_query($db_con, "SELECT nombre FROM departamentos WHERE idea = '$profesor'");
		$row = mysqli_fetch_array($result);
		$nombre_profesor = $row['nombre'];
		
		$exp_fecha_sql = explode('-', $fecha_reg);
		$fecha_sql = $exp_fecha_sql[2].'-'.$exp_fecha_sql[1].'-'.$exp_fecha_sql[0];
		
		$result = mysqli_query($db_con, "UPDATE intervenciones_profesores SET idea = '$profesor', nombre = '$nombre_profesor', observaciones = '$observaciones', causa = '$causa', accion = '$accion', fecha = '$fecha_sql' WHERE id = '$id'");
		
		if (! $result) {
			$msg_error = "No se ha podido actualizar la intervención. Error: ".mysqli_error($db_con);
		}
		else {
			$msg_success = "La intervención ha sido actualizar.";
		}
	}
	else {
		$msg_error = "Todos los campos del formulario son obligatorios.";
	}
	
}

// ELIMINACIÓN
		
if (isset($_POST['submit3'])) {
	
	if (! empty($id)) {
		$result = mysqli_query($db_con, "DELETE FROM intervenciones_profesores WHERE id = '$id' LIMIT 1");
		
		if (! $result) {
			$msg_error = "No se ha podido eliminar la intervención. Error: ".mysqli_error($db_con);
		}
		else {
			$msg_success = "La intervención ha sido eliminada correctamente.";
		}
	}
	
}


if (isset($_GET['id'])) {
	$id = mysqli_real_escape_string($db_con, $_GET['id']);
	
	$result = mysqli_query($db_con, "SELECT idea, nombre, fecha, observaciones, causa, accion FROM intervenciones_profesores WHERE id = '$id' LIMIT 1");
	$row = mysqli_fetch_array($result);
	
	$profesor = $row['idea'];
	$fecha_sql = $row['fecha'];
	$observaciones = $row['observaciones'];
	$causa = $row['causa'];
	$accion = $row['accion'];
	
	$exp_fecha_reg = explode('-', $fecha_sql);
	$fecha_reg = $exp_fecha_reg[2].'-'.$exp_fecha_reg[1].'-'.$exp_fecha_reg[0];
}


// PLUGINS
$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Jefatura de estudios <small>Intervenciones sobre los profesores</small></h2>
	</div>

	<!-- SCAFFOLDING -->
	<div class="row">
		
		<?php if (isset($msg_success)): ?>
		<div class="alert alert-success">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		<?php if (isset($msg_error)): ?>
		<div class="alert alert-danger">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-7">
			
			<legend>Registro de datos</legend>
			
			<div class="well">
			
				<form method="post" action="">
				
					<fieldset>
					
						<div class="row">
						
							<div class="col-sm-7">
								<div class="form-group">
									<label for="profesor">Profesor/a</label> 
									<?php $result = mysqli_query($db_con, "SELECT nombre, idea FROM departamentos WHERE departamento <> 'Admin' AND departamento <> 'Administracion' AND departamento <> 'Conserjeria' ORDER BY nombre ASC"); ?>
									<?php if(mysqli_num_rows($result)): ?> 
									<select class="form-control" id="profesor" name="profesor" onchange="submit()">
										<option></option>
										<?php while($row = mysqli_fetch_array($result)): ?>
										<option value="<?php echo $row['idea']; ?>" <?php echo ($row['idea'] == $profesor) ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
										<?php endwhile; ?>
										<?php mysqli_free_result($result); ?>
									</select>
									<?php else: ?>
									<select class="form-control" name="profesor" disabled>
										<option></option>
									</select> <?php endif; ?>
								</div>
							</div>
							
							<div class="col-sm-5">
								<div class="form-group" id="datetimepicker1"><label for="fecha_reg">Fecha</label>
									<div class="input-group">
										<input name="fecha_reg" type="text" class="input form-control" value="<?php echo (isset($fecha_reg)) ? $fecha_reg : '' ?>" data-date-format="DD-MM-YYYY" id="fecha_reg">
										<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
									</div>
								</div>
							</div>
							
						</div>

						<div class="form-group">
							<label for="observaciones">Observaciones</label>
							<textarea class="form-control" id="observaciones" name="observaciones" placeholder="Escribe la intervención realizada sobre el profesor/a..." rows="10"><?php echo (isset($observaciones)) ? $observaciones : ''; ?></textarea>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<?php $array_causas = array('Temas Académicos-Pedagógicos', 'Temas Metodológicos', 'Tema Disciplinario', 'Tutorías con Familias', 'Problemas de Convivencia', 'Faltas de Asistencia', 'Otros...'); ?>
									<label for="causa">Causa</label>
									<select class="form-control" id="causa" name="causa">
										<?php for($i = 0; $i < count($array_causas); $i++): ?>
										<option value="<?php echo $array_causas[$i]; ?>" <?php echo (isset($causa) && $causa == $array_causas[$i]) ? 'selected' : ''; ?>><?php echo $array_causas[$i]; ?></option>
										<?php endfor; ?>
									</select>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<?php $array_tipos = array('Entrevista telefónica', 'Entrevista personal', 'Comunicación por escrito'); ?>
									
									<label for="accion">Tipo</label>
									<select class="form-control" id="accion" name="accion">
										<?php for($i = 0; $i < count($array_tipos); $i++): ?>
										<option value="<?php echo $array_tipos[$i]; ?>" <?php echo (isset($accion) && $accion == $array_tipos[$i]) ? 'selected' : ''; ?>><?php echo $array_tipos[$i]; ?></option>
										<?php endfor; ?>
									</select>
								</div>
							</div>
						</div>
						
						<?php if(isset($id)): ?>
						<button type="submit" class="btn btn-primary" name="submit2">Actualizar</button>
						<button type="submit" class="btn btn-danger" name="submit3">Eliminar</button>
						<a class="btn btn-default" href="profesores.php">Nueva intervención</a>
						<?php else: ?>
						<button type="submit" class="btn btn-primary" name="submit1">Registrar</button>
						<?php endif; ?>
					</fieldset>

				</form>

			</div><!-- /.well -->
		
			<?php if($profesor): ?>
			<div class="well">
			
				<?php $result = mysqli_query($db_con, "SELECT id, idea, nombre, fecha, observaciones, accion, causa FROM intervenciones_profesores WHERE idea = '$profesor' ORDER BY fecha DESC"); ?>

				<?php if (mysqli_num_rows($result)>0): ?>
				<h4>Historial de intervenciones de <?php echo $row['nombre']; ?></h4>
				
				<br>
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Tipo</th>
							<th>Causa</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_array($result)): ?>
						<tr>
							<td><?php echo $row['fecha']; ?></td>
							<td><?php echo $row['accion']; ?></td>
							<td><?php echo $row['causa']; ?></td>
							<td>
							<a href="profesores.php?id=<?php echo $row['id']; ?>" data-bs="tooltip" title="Ver informe"><span class="fa fa-search fa-lg fa-fw"></span></a>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
				<?php else: ?>
				
				<div>
					<p class="lead text-muted text-center">El profesor no tiene más intervenciones registradas.</p>
				</div>
				
				<?php endif; ?>

			</div><!-- /.well -->
			<?php endif; ?>
				
		</div><!-- /.col-sm-7 -->
			
			
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-5">
			
			<legend>Intervenciones</legend>
			
			<?php $result = mysqli_query($db_con, "SELECT DISTINCT idea, nombre FROM intervenciones_profesores ORDER BY fecha DESC"); ?>
			<?php if (mysqli_num_rows($result)): ?>
			<table class="table table-striped table-bordered datatable">
				<thead>
					<tr>
						<th>#</th>
						<th>Profesor/a</th>
						<th>Fecha</th>
					</tr>
				</thead>
				<tbody>
				<?php while ($row = mysqli_fetch_array($result)): ?>
				<?php $result1 = mysqli_query($db_con, "SELECT DISTINCT id, idea, nombre, fecha FROM intervenciones_profesores WHERE idea = '".$row['idea']."' ORDER BY fecha DESC LIMIT 1"); ?>
					<?php while ($row1 = mysqli_fetch_array($result1)): ?>
					<tr>
						<td><?php echo $row1['id']; ?></td>
						<td><a href="profesores.php?id=<?php echo $row1['id']; ?>"><?php echo $row1['nombre']; ?></a></td>
						<td nowrap><?php echo $row1['fecha']; ?></td>
					</tr>
					<?php endwhile; ?>
				<?php endwhile; ?>
				</tbody>
			</table>
			<?php else: ?>
			
			<div style="margin-top: 150px;">
				<p class="lead text-muted text-center">No hay intervenciones registradas.</p>
			</div>
			
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