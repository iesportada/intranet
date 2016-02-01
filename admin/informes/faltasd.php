<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- MODULO DETALLADO FALTAS DE ASISTENCIA -->

<?php
function tipo_falta($falta) {
	
	switch ($falta) {
		case 'J' : $tipo = 'Justificada'; break;
		case 'F' : $tipo = 'Injustificada'; break;
		case 'I' : $tipo = 'Injustificada'; break;
		case 'R' : $tipo = 'Retraso'; break;
	}
	
	return $tipo;
}
?>

<h3>Informe detallado de faltas de asistencia</h3>
<br>

<?php $result = mysqli_query($db_con, "SELECT DISTINCT fecha FROM FALTAS WHERE claveal = '$claveal' ORDER BY fecha DESC"); ?>
<?php if (mysqli_num_rows($result)): ?>
<div class="table-responsive">
	<table class="table table-bordered table-condensed table-striped table-hover">
		<thead>
			<tr>
				<th>Fecha</th>
				<?php for ($i = 1; $i < 7; $i++): ?>
				<th><?php echo $i; ?>ª hora</th>
				<?php endfor; ?>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($result)): ?>
			<tr>
				<th><abbr data-bs="tooltip" title="<?php echo strftime('%A', strtotime($row['fecha'])); ?>"><?php echo $row['fecha']; ?></abbr></th>
				<?php for ($i = 1; $i < 7; $i++): ?>
				<?php $result_falta = mysqli_query($db_con, "SELECT DISTINCT asignaturas.abrev, asignaturas.nombre, falta FROM FALTAS JOIN asignaturas ON FALTAS.codasi = asignaturas.codigo  WHERE claveal = '$claveal' AND fecha = '".$row['fecha']."' AND hora = '$i' and abrev not like '%\_%'"); ?>
				<?php $row_falta = mysqli_fetch_array($result_falta); ?>
				<td>
					<abbr data-bs="tooltip" title="<?php echo $row_falta['nombre']; ?>">
						<span class="label label-default"><?php echo $row_falta['abrev']; ?></span>
					</abbr>
					
					<abbr data-bs="tooltip" title="<?php echo tipo_falta($row_falta['falta']); ?>">
					<?php echo ($row_falta['falta'] == "I" || $row_falta['falta'] == "F") ? '<span class="label label-danger">'.$row_falta['falta'].'</label>' : ''; ?>
					<?php echo ($row_falta['falta'] == "R") ? '<span class="label label-warning">'.$row_falta['falta'].'</label>' : ''; ?>
					<?php echo ($row_falta['falta'] == "J") ? '<span class="label label-success">'.$row_falta['falta'].'</label>' : ''; ?>
					</abbr>
				</td>
				<?php endfor; ?>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>

<!-- FIN MODULO DETALLADO FALTAS DE ASISTENCIA -->
