<?php
require('../../bootstrap.php');

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
if (isset($_POST['evaluacion']) && !empty($_POST['evaluacion'])) $evaluacion = $_POST['evaluacion'];



$esTutorUnidad = 0;
if (stristr($_SESSION['cargo'],'2') == true) {
	
	if (isset($curso) && $curso == $_SESSION['mod_tutoria']['unidad']) {
		$esTutorUnidad = 1;
	}
	
}

include("../../menu.php");
include("menu.php");
?>
	
	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Evaluaciones <small>Sesiones de evaluación</small></h2>
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
		
		
		<div class="row hidden-print">
		
			<div class="col-sm-12">
			
				<form id="form" method="post" action="">
					
					<fieldset>
					
						<div class="well">
							
							<legend>Seleccione unidad y evaluación</legend>
							
							<div class="row">
								
								<div class="col-sm-6">
								
									<div class="form-group">
										<label for="curso">Unidad</label>
										<?php if (strstr($_SESSION['cargo'], '1') == true): ?>
										<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_grupo FROM horw WHERE c_asig != '2' AND c_asig not in (select distinct idactividad from actividades_seneca) ORDER BY a_grupo ASC"); ?>
										<?php else: ?>
										<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_grupo FROM horw WHERE prof='".mb_strtoupper($_SESSION['profi'], 'iso-8859-1')."' AND c_asig != '2' AND c_asig not in (select distinct idactividad from actividades_seneca) ORDER BY a_grupo ASC"); ?>
										<?php endif; ?>
										<select class="form-control" id="curso" name="curso" onchange="submit()">
											<option value=""></option>
											<?php while ($row = mysqli_fetch_array($result)): ?>
											<option value="<?php echo $row['a_grupo']; ?>" <?php echo (isset($curso) && $curso == $row['a_grupo']) ? 'selected' : ''; ?>><?php echo $row['a_grupo']; ?></option>
											<?php endwhile; ?>
										</select>
									</div>
									
								</div>
								
								<div class="col-sm-6">
									
									<div class="form-group">
										<label for="evaluacion">Evaluación</label>
										<select class="form-control" id="evaluacion" name="evaluacion" onchange="submit()">
											<option value=""></option>
											<?php foreach ($evaluaciones as $eval => $desc): ?>
											<option value="<?php echo $eval; ?>" <?php echo (isset($evaluacion) && $evaluacion == $eval) ? 'selected' : ''; ?>><?php echo $desc; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									
								</div>
								
							</div>
								
							
						</div><!-- /.well -->
						
					</fieldset>
					
				</form>
				
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		

		<?php if (isset($curso) && isset($evaluacion)): ?>
		<div class="row">
		
			<div class="col-sm-12">
			
				<div class="visible-print">
					<h3><?php echo $evaluaciones[$evaluacion]; ?>  de <?php echo $curso; ?></h3>
				</div>
								
				<table class="table table-bordered table-striped table-hover table-vcentered">
					<thead>
						<tr>
							<th>Alumno/a</th>
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_asig, asig, c_asig FROM horw WHERE a_grupo='$curso' AND c_asig NOT LIKE '2' ORDER BY asig ASC") or die (mysqli_error($db_con)); ?>
							<?php while ($row = mysqli_fetch_array($result)): ?>
							<th><abbr data-bs="tooltip" title="<?php echo $row['asig']; ?>"><?php echo $row['a_asig']; ?></abbr></th>
							<?php endwhile; ?>
						</tr>
					</thead>
					<tbody>
						<?php $result = mysqli_query($db_con, "SELECT apellidos, nombre, claveal FROM alma WHERE unidad='$curso' AND (combasi NOT LIKE '%25204%' AND combasi NOT LIKE '%25226%' AND combasi NOT LIKE '%31307%')"); ?>
						<?php if (!mysqli_num_rows($result)): ?>
						<?php $result = mysqli_query($db_con, "SELECT apellidos, nombre, claveal FROM alma WHERE unidad='".substr($curso, 0, -1)."' AND (combasi like '%25204%' or combasi LIKE '%25226%' or combasi LIKE '%31307%')"); ?>
						<?php endif; ?>
						<?php $i = 0; ?>
						<?php while ($row = mysqli_fetch_array($result)): ?>
						<tr>
							<td nowrap><?php echo $row['apellidos'].', '.$row['nombre']; ?></td>
							<?php $result1 = mysqli_query($db_con, "SELECT DISTINCT c_asig FROM horw WHERE a_grupo='$curso' AND c_asig NOT LIKE '2' ORDER BY asig ASC") or die (mysqli_error($db_con)); ?>
							<?php while ($row1 = mysqli_fetch_array($result1)): ?>
								
							<?php $result2 = mysqli_query($db_con, "SELECT calificaciones FROM evaluaciones WHERE unidad='$curso' AND evaluacion='$evaluacion' AND asignatura='".$row1['c_asig']."'"); ?>
							<?php if (mysqli_num_rows($result2)): ?>
							<?php $row2 = mysqli_fetch_array($result2); ?>
							<?php $calificaciones = unserialize($row2['calificaciones']); ?>
							<td>
								<?php echo ($calificaciones[$i]['obs'] != "") ? '<span class="pull-right fa fa-question-circle" data-bs="tooltip" title="'.$calificaciones[$i]['obs'].'"></span>' : ''; ?>
								<?php echo ($calificaciones[$i]['nota'] > 5) ? '<span class="text-success">'.$calificaciones[$i]['nota'].'</span>' : '<span class="text-danger">'.$calificaciones[$i]['nota'].'</span>'; ?>
							</td>
							<?php else: ?>
							<td>&nbsp;</td>
							<?php endif; ?>
							
							<?php endwhile; ?>
						</tr>
						<?php $i++; ?>
						<?php endwhile; ?>
					</tbody>
				</table>
				
				<div class="hidden-print">
					<?php if (stristr($_SESSION['cargo'],'1') == true || (stristr($_SESSION['cargo'],'2') == true && $esTutorUnidad)): ?>
					<form class="form-horizontal" method="post" action="actas.php">
						<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
						<button type="submit" class="btn btn-primary" formaction="imprimir_notas.php">Imprimir boletines</button>
						<input type="hidden" name="curso" value="<?php echo $curso; ?>">
						<input type="hidden" name="evaluacion" value="<?php echo $evaluacion; ?>">
						<button type="submit" class="btn btn-primary" name="enviar">Redactar acta</button>
					</form>
					<?php else: ?>
					<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
					<?php endif; ?>
				</div>
				
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		<?php endif; ?>
	
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>
 
</body>
</html>
