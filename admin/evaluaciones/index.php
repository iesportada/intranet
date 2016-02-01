<?php
require('../../bootstrap.php');


mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `evaluaciones` (
  `unidad` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `asignatura` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `evaluacion` char(3) COLLATE latin1_spanish_ci NOT NULL,
  `profesor` text COLLATE latin1_spanish_ci NOT NULL,
  `calificaciones` text COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`unidad`,`asignatura`,`evaluacion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;");


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


if (isset($_POST['curso'])) {
	$form_curso = $_POST['curso'];
	$exp_curso = explode('-->', $form_curso);
	$curso = $exp_curso[0];
	$asignatura = $exp_curso[1];
}
if (isset($_POST['evaluacion']) && !empty($_POST['evaluacion'])) $evaluacion = $_POST['evaluacion'];

// ENVIO DEL FORMULARIO
if (isset($_POST['submit'])) {

	$curso = $_POST['unidad'];
	$asignatura = $_POST['asignatura'];
	$evaluacion = $_POST['evaluacion'];

	$calificaciones = array();

	foreach ($_POST as $campo => $valor) {
		if ($campo != 'submit' && $campo != 'curso' && $campo != 'evaluacion') {
		
			$exp_campo = explode('-', $campo);
			$alumno = $exp_campo[1];
				
			if ($exp_campo[0] == 'nota') $alumno_nota = $valor;
			if ($exp_campo[0] == 'obs')  $alumno_obs  = $valor;
				
			if (isset($alumno_obs)) {
				$calif_alumno = array(
				array(
						'alumno' => $alumno,
						'nota'   => $alumno_nota,
						'obs'    => $alumno_obs,
				),
				);

				$calificaciones = array_merge($calificaciones, $calif_alumno);
				
				unset($alumno_obs);
			}
				
		}
	}
	
	
	$result = mysqli_query($db_con, "INSERT INTO evaluaciones (unidad, asignatura, evaluacion, profesor, calificaciones) VALUES ('$curso', '$asignatura', '$evaluacion', '".$_SESSION['profi']."', '".serialize($calificaciones)."')");

	if (!$result) {

		if (mysqli_errno($db_con) == 1062) {
			$result1 = mysqli_query($db_con, "UPDATE evaluaciones SET calificaciones='".serialize($calificaciones)."' WHERE unidad='$curso' AND asignatura='$asignatura' AND evaluacion='$evaluacion' LIMIT 1");
				
			if (!$result1) $msg_error = "No se ha podido actualizar las calificaciones de la ".$evaluaciones[$evaluacion].". Error: ".mysqli_error($db_con);
			else $msg_success = "Las calificaciones de la ".$evaluaciones[$evaluacion]." han sido actualizadas.";
		}
		else {
			$msg_error = "No se ha podido registrar las calificaciones de la ".$evaluaciones[$evaluacion].". Error: ".mysqli_error($db_con);
		}
	}
	else {
		$msg_success = "Las calificaciones de la ".$evaluaciones[$evaluacion]." han sido registradas.";
	}
	
}


// RECUPERAMOS LOS DATOS DE LA EVALUACION
if ((isset($curso) && isset($asignatura)) && isset($evaluacion)) {
	$result = mysqli_query($db_con, "SELECT calificaciones FROM evaluaciones WHERE unidad='$curso' AND asignatura='$asignatura' AND evaluacion='$evaluacion' LIMIT 1");

	if (mysqli_num_rows($result)) {
		$row = mysqli_fetch_array($result);

		$calificaciones = unserialize($row['calificaciones']);

		for ($i = 0; $i < count($calificaciones); $i++) {
			$nota{'-'.$calificaciones[$i]['alumno']} = $calificaciones[$i]['nota'];
			$obs{'-'.$calificaciones[$i]['alumno']} = $calificaciones[$i]['obs'];
		}
	}
}

include("../../menu.php");
include("menu.php");
?>

<div class="container">

	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Evaluaciones <small>Evaluar una unidad</small></h2>
	</div>

	<!-- MENSAJES -->
	<?php if (isset($msg_error)): ?>
	<div class="alert alert-danger"><?php echo $msg_error; ?></div>
	<?php endif; ?> <?php if (isset($msg_success)): ?>
	<div class="alert alert-success"><?php echo $msg_success; ?></div>
	<?php endif; ?>


	<div class="row hidden-print">

		<div class="col-sm-12">

			<form method="post" action="">
				
				<div class="well">
				
				<fieldset>
					<legend>Seleccione unidad y evaluación</legend>
				
					<div class="row">
					
						<div class="col-sm-6">
			
							<div class="form-group">
								<label for="curso">Unidad y asignatura</label>
								<select class="form-control" id="curso" name="curso" onchange="submit()">
									<option value=""></option>
									<optgroup label="Unidades donde imparto clase">
									<?php $result = mysqli_query($db_con, "SELECT DISTINCT c_asig, asig, a_grupo FROM horw WHERE prof='".mb_strtoupper($_SESSION['profi'], 'iso-8859-1')."' AND a_grupo <> '' AND c_asig not in (select distinct idactividad from actividades_seneca) ORDER BY a_grupo ASC"); ?>
									<?php while ($row = mysqli_fetch_array($result)): ?>
										<option value="<?php echo $row['a_grupo'].'-->'.$row['c_asig']; ?>"
										<?php echo (isset($form_curso) && $form_curso == $row['a_grupo'].'-->'.$row['c_asig']) ? 'selected' : (isset($curso) && isset($asignatura) && $curso.'-->'.$asignatura == $row['a_grupo'].'-->'.$row['c_asig']) ? 'selected' : ''; ?>><?php echo $row['a_grupo']; ?>
										- <?php echo $row['asig']; ?></option>
										<?php endwhile; ?>
									</optgroup>
									<?php if (strstr($_SESSION['cargo'], '1') == true): ?>
									<optgroup label="Todas las unidades">
									<?php $result = mysqli_query($db_con, "SELECT DISTINCT c_asig, asig, a_grupo FROM horw WHERE a_grupo <> '' AND c_asig not in (select distinct idactividad from actividades_seneca) ORDER BY a_grupo ASC"); ?>
									<?php while ($row = mysqli_fetch_array($result)): ?>
										<option value="<?php echo $row['a_grupo'].'-->'.$row['c_asig']; ?>"
										<?php echo (isset($form_curso) && $form_curso == $row['a_grupo'].'-->'.$row['c_asig']) ? 'selected' : (isset($curso) && isset($asignatura) && $curso.'-->'.$asignatura == $row['a_grupo'].'-->'.$row['c_asig']) ? 'selected' : ''; ?>><?php echo $row['a_grupo']; ?>
										- <?php echo $row['asig']; ?></option>
										<?php endwhile; ?>
									</optgroup>
									<?php endif; ?>
								</select>
							</div>
						
						</div> <!-- /.col-sm-6 -->
						
						<div class="col-sm-6">
						
							<div class="form-group">
								<label for="evaluacion">Evaluación</label>
								<select class="form-control" id="evaluacion" name="evaluacion" onchange="submit()">
									<option value=""></option>
									<?php foreach ($evaluaciones as $eval => $desc): ?>
									<option value="<?php echo $eval; ?>"
									<?php echo (isset($evaluacion) && $evaluacion == $eval) ? 'selected' : ''; ?>><?php echo $desc; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						
						</div> <!-- /.col-sm-6 -->
					
					</div> <!-- /.row -->
				
				</fieldset>
				
				</div> <!-- /.well -->
			
			</form>

		</div> <!-- /.col-sm-12 -->
		
	</div> <!-- /.row -->

	<?php if ((isset($curso) && isset($asignatura)) && isset($evaluacion)): ?>
	
	<div class="row">
	
		<div class="col-sm-12">
		
			<div class="visible-print">
				<h3><?php echo $evaluaciones[$evaluacion]; ?> de <?php echo $curso; ?></h3>
			</div>
		
			<form method="post" action="">
				
				<input type="hidden" name="unidad" value="<?php echo $curso; ?>">
				<input type="hidden" name="asignatura" value="<?php echo $asignatura; ?>">
				<input type="hidden" name="evaluacion" value="<?php echo $evaluacion; ?>">
			
				<table class="table table-bordered table-striped table-hover table-vcentered">
					<thead>
						<tr>
							<th class="col-sm-4" colspan="2">Alumno/a</th>
							<th class="col-sm-1">Nota</th>
							<th class="col-sm-7">Observaciones</th>
						</tr>
					</thead>
					<tbody>
					<?php $result = mysqli_query($db_con, "SELECT apellidos, nombre, claveal FROM alma WHERE unidad='$curso' AND (combasi NOT LIKE '%25204%' AND combasi NOT LIKE '%25226%' AND combasi NOT LIKE '%31307%')"); ?>
					<?php if (!mysqli_num_rows($result)): ?>
					<?php $result = mysqli_query($db_con, "SELECT apellidos, nombre, claveal FROM alma WHERE unidad='".substr($curso, 0, -1)."' AND (combasi like '%25204%' or combasi LIKE '%25226%' or combasi LIKE '%31307%')"); ?>
					<?php endif; ?>
					<?php while ($row = mysqli_fetch_array($result)): ?>
						<tr>
						<?php $foto = '../../xml/fotos/'.$row['claveal'].'.jpg'; ?>
						<?php if (file_exists($foto)): ?>
							<td class="text-center"><img class="img-thumbnail"
								src="<?php echo $foto; ?>"
								alt="<?php echo $row['apellidos'].', '.$row['nombre']; ?>"
								width="54"></td>
								<?php else: ?>
							<td class="text-center"><span class="fa fa-user fa-fw fa-3x"></span></td>
							<?php endif; ?>
							<td nowrap><?php echo $row['apellidos'].', '.$row['nombre']; ?></td>
							<td>
								<input type="text" class="form-control" id="nota-<?php echo $row['claveal']; ?>" name="nota-<?php echo $row['claveal']; ?>" value="<?php echo (isset($nota{'-'.$row['claveal']}) && $nota) ? $nota{'-'.$row['claveal']} : ''; ?>">
							</td>
							<td>
								<textarea class="form-control" name="obs-<?php echo $row['claveal']; ?>" rows="1"><?php echo (isset($obs{'-'.$row['claveal']}) && $obs{'-'.$row['claveal']}) ? $obs{'-'.$row['claveal']} : ''; ?></textarea>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			
				<div class="hidden-print">
					<button type="submit" class="btn btn-primary" name="submit">Registrar</button>
					<button type="reset" class="btn btn-default">Cancelar</button>
					<a href="#" class="btn btn-info" onclick="javascript:print();">Imprimir</a>
				</div>
			
			</form>
		
		</div> <!-- /.col-sm-12 -->
		
	</div> <!-- /.row -->
	
	<?php endif; ?>

</div> <!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>
