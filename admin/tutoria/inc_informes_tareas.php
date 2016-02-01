<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- INFORMES DE TAREAS -->

<h3 class="text-info">Informes de tareas</h3>

<?php $result = mysqli_query($db_con, "SELECT id, apellidos, nombre, fecha FROM tareas_alumnos WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."' ORDER BY fecha DESC"); ?>

<?php if (mysqli_num_rows($result)): ?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Alumno/a</th>
			<th>Fecha</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = mysqli_fetch_array($result)): ?>
		<tr>
			<td><a href="../tareas/infocompleto.php?id=<?php echo $row['id']; ?>"><?php echo $row['nombre'].' '.$row['apellidos']; ?></a></td>
			<td nowrap><?php echo strftime('%e %b',strtotime($row['fecha'])); ?></td>
		</tr>
		<?php endwhile; ?>
		<?php mysqli_free_result($result); ?>
	</tbody>
</table>

<?php else: ?>

<br>
<p class="lead text-muted">No hay informes de tareas registradas para esta unidad.</p>

<?php endif; ?>
            
<!-- FIN INFORMES DE TAREAS -->