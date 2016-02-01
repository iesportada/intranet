<?php
require('../../bootstrap.php');


mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `evaluaciones_actas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unidad` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `evaluacion` char(3) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `texto_acta` text COLLATE latin1_spanish_ci NOT NULL,
  `impresion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ;");


if ($_SERVER['SERVER_NAME'] == 'iesantoniomachado.es') {
	$evaluaciones = array(
		'IN1' => 'Intermedia 1 (Febrero)',
		'IN2' => 'Intermedia 2 (Mayo)'
	);
}
else {
	$evaluaciones = array(
		'1EV' => '1ª Evaluación',
		'2EV' => '2ª Evaluación',
		'3EV' => '3ª Evaluación',
		'Ord' => 'Ordinaria',
		'FFP' => 'Final FP',
		'Ext' => 'Extraordinaria',
		'FE1' => 'Final Excepcional 1ª Convocatoria',
		'5CV' => '5º Convocatoria Extraordinaria de Evaluación',
		'OT1' => 'Obtención título ESO (Primer año)',
		'FE2' => 'Final Excepcional 2ª Convocatoria',
		'OT2' => 'Obtención título ESO (Segundo año)',
		'EP1' => 'Evaluación de pendientes 1ª Convovatoria',
		'EVI' => 'Evaluación inicial',
		'EP2' => 'Evaluación de pendientes 2ª Convovatoria',
	);
}


if (isset($_POST['curso'])) $curso = $_POST['curso'];
if (isset($_POST['curso'])) $evaluacion = $_POST['evaluacion'];
if (isset($_GET['id'])) $id = $_GET['id'];


// ENVIO DEL FORMULARIO
if (isset($_POST['submit'])) {
	
	$evaluacion = $_POST['evaluacion'];
	$curso = $_POST['unidad'];
	$fecha = $_POST['fecha'];
	$exp_fecha = explode('-', $fecha);
	$fecha_sql = $exp_fecha[2].'-'.$exp_fecha[1].'-'.$exp_fecha[0];
	$texto_acta = trim($_POST['texto_acta']);
	
	if (!empty($evaluacion) && !empty($curso) && !empty($fecha) && !empty($texto_acta)) {
		
		if (isset($id)) {
			
			$result = mysqli_query($db_con, "UPDATE evaluaciones_actas SET fecha='$fecha_sql', texto_acta='$texto_acta' WHERE id=$id LIMIT 1");
			
			if (!$result) $msg_error = "El acta no ha podido ser actualizado. Error: ".mysqli_error($db_con);
			else $msg_success = "El acta ha sido actualizado.";
		}
		else {
			
			$result = mysqli_query($db_con, "INSERT INTO evaluaciones_actas (unidad, evaluacion, fecha, texto_acta) VALUES ('$curso', '$evaluacion', '$fecha_sql', '$texto_acta')");
			
			if (!$result) $msg_error = "El acta no ha podido ser registrado. Error: ".mysqli_error($db_con);
			else $msg_success = "El acta ha sido registrado.";
		}
		
	}

}

// RECOGEMOS LOS DATOS SI SE TRATA DE UNA ACTUALIZACION
if (isset($id) && (isset($_GET['action']) && $_GET['action'] == 'edit')) {
	$result = mysqli_query($db_con, "SELECT unidad, evaluacion, texto_acta FROM evaluaciones_actas WHERE id=$id LIMIT 1");
	
	if (!$result) {
		$msg_error = "El acta a la que intenta acceder no existe.";
		unset($id);
	}
	else {
		$row = mysqli_fetch_array($result);
		
		$curso = $row['unidad'];
		$evaluacion = $row['evaluacion'];
		$texto_acta = $row['texto_acta'];
	}
}


// ELIMINAR UN ACTA
if (isset($id) && (isset($_GET['action']) && $_GET['action'] == 'delete')) {
	$result = mysqli_query($db_con, "DELETE FROM evaluaciones_actas WHERE id=$id LIMIT 1");
	
	if (!$result) $msg_error = "El acta no ha podido ser eliminado. Error: ".mysqli_error($db_con);
	else $msg_success = "El acta ha sido eliminado.";
}


$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");
?>
	
	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Evaluaciones <small>Actas de sesiones de evaluación</small></h2>
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
			
			<?php if (!empty($curso) && !empty($evaluacion)): ?>
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-12">
				
				<h3>Redactar acta</h3>
				
				<form method="post" action="">
						
					<div class="well">
						
						<fieldset>
							
							<div class="row">
								
								<div class="col-sm-4">
								
									<div class="form-group">
										<label for="evaluacion">Evaluación</label>
										<input type="hidden" name="evaluacion" value="<?php echo $evaluacion ?>">
										<input type="text" class="form-control" id="texto_evaluacion" name="texto_evaluacion" value="<?php echo $evaluaciones[$evaluacion]; ?>" readonly>
									</div>
								
								</div>
								
								<div class="col-sm-2">
								
									<div class="form-group">
										<label for="unidad">Unidad</label>
										<input type="text" class="form-control" id="unidad" name="unidad" value="<?php echo $curso; ?>" readonly>
									</div>
								
								</div>
								
								<div class="col-sm-3">
								
									<div class="form-group">
										<label for="tutor">Tutor/a</label>
										<?php $result = mysqli_query($db_con, "SELECT tutor FROM FTUTORES WHERE unidad='$curso'"); ?>
										<?php $row = mysqli_fetch_array($result); ?>
										<?php $tutor = mb_convert_case($row['tutor'], MB_CASE_TITLE, "iso-8859-1"); ?>
										<input type="text" class="form-control" id="tutor" name="tutor" value="<?php echo $tutor; ?>" readonly>
									</div>
								
								</div>
								
								<div class="col-sm-3">
									
									<div class="form-group" id="datetimepicker1">
										<label for="fecha">Fecha</label>
										<div class="input-group">
											<input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo (isset($fecha)) ? $fecha : date('d-m-Y'); ?>" data-date-format="DD-MM-YYYY">
											<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
										</div>
									</div>
									
								</div>
							
							</div>
							
							
							<div class="form-group">
								<textarea class="form-control" id="texto_acta" name="texto_acta">
								<?php if (isset($texto_acta)): ?>
								<?php echo $texto_acta; ?>
								<?php else: ?>
								<p><br></p>
								<?php endif; ?>
								</textarea>
							</div>
							
							<button type="submit" class="btn btn-primary" name="submit">Guardar</button>
							<button type="reset" class="btn btn-default">Cancelar</button>
							<a href="actas.php" class="btn btn-info">Ver actas</a> 	
						</fieldset>
						
					</div>
				
				</form>
				
				
			</div><!-- /.col-sm-12 -->
			
			<?php else: ?>
			
			<div class="col-sm-12">
				<?php if (stristr($_SESSION['cargo'],'2') == true): ?>
				<?php $result = mysqli_query($db_con, "SELECT ea.id, ea.unidad, t.tutor, ea.evaluacion, ea.fecha, ea.impresion FROM evaluaciones_actas AS ea JOIN FTUTORES AS t ON ea.unidad = t.unidad WHERE ea.unidad='".$_SESSION['mod_tutoria']['unidad']."'"); ?>
				<?php else: ?>
				<?php $result = mysqli_query($db_con, "SELECT ea.id, ea.unidad, t.tutor, ea.evaluacion, ea.fecha, ea.impresion FROM evaluaciones_actas AS ea JOIN FTUTORES AS t ON ea.unidad = t.unidad"); ?>
				<?php endif; ?>
				
				<?php if (mysqli_num_rows($result)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Unidad</th>
								<th>Tutor/a</th>
								<th>Evaluación</th>
								<th>Fecha</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = mysqli_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['unidad']; ?></td>
								<td><?php echo mb_convert_case($row['tutor'], MB_CASE_TITLE, "iso-8859-1"); ?></td>
								<td><?php echo $evaluaciones[$row['evaluacion']]; ?></td>
								<td><?php echo $row['fecha']; ?></td>
								<td>
									<?php if (!$row['impresion']): ?>
									<a href="acta.php?id=<?php echo $row['id']; ?>&action=edit" data-bs="tooltip" title="Editar"><span class="fa fa-edit fa-fw fa-lg"></span></a>
									<?php endif; ?>
									<a href="imprimir.php?id=<?php echo $row['id']; ?>" data-bs="tooltip" title="Imprimir"><span class="fa fa-print fa-fw fa-lg"></span></a>
									<a href="acta.php?id=<?php echo $row['id']; ?>&action=delete" data-bs="tooltip" title="Eliminar" data-bb="confirm-delete"><span class="fa fa-trash-o fa-fw fa-lg"></span></a>
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
					<?php else: ?>
					
					<h3>No se ha redactado ningún acta de sesión de evaluación.</h3>
					<br>
					<br>
					
					<?php endif; ?>
				</div>
			
			</div><!-- /.col-sm-12 -->
			
			<?php endif; ?>
			
						
		</div><!-- /.row -->
			
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>

 <script>
 $(document).ready(function() {
 
 	// DATATABLES
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
 	
 	// EDITOR DE TEXTO
 	$('#texto_acta').summernote({
 		height: 500,
 		lang: 'es-ES',
 	});
 	
 	// DATETIMEPICKER
 	$(function () {
 	    $('#datetimepicker1').datetimepicker({
 	    	language: 'es',
 	    	pickTime: false,
 	    });
 	});
 	
 });
 </script>

</body>
</html>
