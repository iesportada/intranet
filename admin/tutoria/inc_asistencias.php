<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- FALTAS DE ASISTENCIA -->

<h3 class="text-info">Faltas sin justificar</h3>

<?php $exp_inicio_curso = explode('-', $config['curso_inicio']); ?>
<?php $inicio_curso = $exp_inicio_curso[2].'-'.$exp_inicio_curso[1].'-'.$exp_inicio_curso[0]; ?>

<?php $result = mysqli_query($db_con, "CREATE TABLE FALTASTEMP SELECT DISTINCT FALTAS.claveal, FALTAS.falta, COUNT(*) AS NUMERO, apellidos, nombre FROM FALTAS, FALUMNOS  
 WHERE FALTAS.claveal = FALUMNOS.claveal AND FALTAS.falta = 'F' AND FALTAS.unidad = '".$_SESSION['mod_tutoria']['unidad']."' GROUP BY FALTAS.claveal"); ?>

<?php $result = mysqli_query($db_con, "SELECT FALTASTEMP.claveal, FALTASTEMP.apellidos, FALTASTEMP.nombre, FALTASTEMP.NUMERO FROM FALTASTEMP ORDER BY FALTASTEMP.numero DESC"); ?>
<?php if (mysqli_num_rows($result)): ?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Alumno/a</th>
			<th class="text-center">Total</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = mysqli_fetch_array($result)): ?>
		<tr>
			<td><a href="../faltas/informes.php?claveal=<?php echo $row['claveal']; ?>&fecha4=<?php echo $inicio_curso; ?>&fecha3=<?php echo date('d-m-Y'); ?>&submit2=2"><?php echo $row['nombre'].' '.$row['apellidos']; ?></a></td>
			<td class="text-center"><div class="badge"><?php echo $row['NUMERO']; ?></div></td>
		</tr>
		<?php endwhile; ?>
		<?php mysqli_free_result($result); ?>
	</tbody>
</table>

<?php else: ?>

<br>
<p class="lead text-muted">No hay faltas de asistencias registradas para esta unidad.</p>

<?php endif; ?>

<?php mysqli_query($db_con, "DROP TABLE FALTASTEMP"); ?>

<!-- FIN FALTAS DE ASISTENCIA -->