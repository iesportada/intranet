<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- INFORMES DE TUTORIA -->

<h3 class="text-info">Informes de tutoría</h3>

<?php $result = mysqli_query($db_con, "SELECT id, claveal, apellidos, nombre, f_entrev FROM infotut_alumno WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."' ORDER BY f_entrev DESC"); ?>
<?php if (mysqli_num_rows($result)): ?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Alumno/a</th>
			<th>Visita</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = mysqli_fetch_array($result)): ?>
		<tr>
			<td><a href="../infotutoria/infocompleto.php?id=<?php echo $row['id']; ?>"><?php echo $row['nombre'].' '.$row['apellidos']; ?></a></td>
			<td><?php echo strftime('%e %b',strtotime($row['f_entrev'])); ?></td>
		</tr>
		<?php endwhile; ?>
		<?php mysqli_free_result($result); ?>
	</tbody>
</table>

<?php else: ?>

<br>
<p class="lead text-muted">No hay informes de tutoría registradas para esta unidad.</p>

<?php endif; ?>

<!-- FIN INFORMES DE TUTORIA -->
