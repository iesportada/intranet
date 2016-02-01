<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- INTERVENCIONES DE TUTORIA -->

<h3 class="text-info">Intervenciones de tutoría</h3>

<?php $result = mysqli_query($db_con, "SELECT DISTINCT apellidos, nombre, claveal FROM tutoria WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."' AND DATE(fecha) > '".$config['curso_inicio']."' ORDER BY apellidos ASC, nombre ASC"); ?>
<?php if (mysqli_num_rows($result)): ?>
<table class="table table-hover dt-tutor">
	<thead>
		<tr>
			<th>Alumno/a</th>
			<th>Fecha</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = mysqli_fetch_array($result)): ?>
		<?php $result1 = mysqli_query($db_con, "SELECT fecha, id FROM tutoria WHERE claveal = '".$row['claveal']."' AND prohibido = '0' AND unidad = '".$_SESSION['mod_tutoria']['unidad']."' AND DATE(fecha)> '".$config['curso_inicio']."' ORDER BY fecha DESC LIMIT 1"); ?>
		<?php while ($row1 = mysqli_fetch_array($result1)): ?>
		<tr>
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

<?php endif; ?>

<!-- FIN INTERVENCIONES DE TUTORIA -->