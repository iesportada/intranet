<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- MODULO PROBLEMAS DE CONVIVENCIA -->

<a name="convivencia"></a>
<h3>Problemas de convivencia</h3>

<?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, Fechoria.fecha, 
Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.claveal, grave FROM Fechoria, FALUMNOS WHERE FALUMNOS.claveal = Fechoria.claveal
 AND FALUMNOS.claveal = $claveal ORDER BY Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos"); ?>
<?php if (mysqli_num_rows($result)): ?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover datatable2">
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Conducta contraria</th>
				<th>Gravedad</th>
				<th>Profesor</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($result)): ?>
			<tr>
				<td><?php echo $row['fecha']; ?></td>
				<td><?php echo $row['asunto']; ?></td>
				<td><?php echo $row['grave']; ?></td>
				<td><?php echo $row['informa']; ?></td>
			</tr>
			<?php endwhile; ?>
			<?php mysqli_free_result($result); ?>
		</tbody>
	</table>
</div>

<?php $result = mysqli_query($db_con, "SELECT expulsion, inicio, fin, asunto, aula_conv, inicio_aula, fin_aula FROM Fechoria WHERE Fechoria.claveal = '$claveal' AND (expulsion > '0' OR aula_conv>0) AND Fechoria.fecha >= '".$config['curso_inicio']."' ORDER BY Fechoria.fecha"); ?>
<?php if (mysqli_num_rows($result)): ?>
<h3>Expulsiones</h3>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th>Expulsión</th>
				<th>Inicio</th>
				<th>Final</th>
				<th>Conducta contraria</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($result)): ?>
			<tr>
				<td><?php echo ($row['expulsion'] > '1') ? 'Expulsión del centro' : 'Aula de convivencia'; ?></td>
				<td><?php echo ($row['expulsion'] > '1') ? cambia_fecha($row['inicio']) : cambia_fecha($row['inicio_aula']); ?></td>
				<td><?php echo ($row['expulsion'] > '1') ? cambia_fecha($row['fin']) : cambia_fecha($row['fin_aula']); ?></td>
				<td><?php echo $row['asunto']; ?></td>
			</tr>
			<?php endwhile; ?>
			<?php mysqli_free_result($result); ?>
		</tbody>
	</table>
</div>
<?php endif; ?>


<?php else: ?>

<h3 class="text-muted">El alumno/a no tiene problemas de convivencia</h3>
<br>

<?php endif; ?>
  
<!-- FIN MODULO PROBLEMAS DE CONVIVENCIA -->
