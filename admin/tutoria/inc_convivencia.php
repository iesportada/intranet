<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- PROBLEMAS DE CONVIVENCIA -->

<h3 class="text-info">Problemas de convivencia</h3>

<?php $result = mysqli_query($db_con, "SELECT FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.claveal FROM FALUMNOS WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."'"); ?>

<?php if (mysqli_num_rows($result)): ?>
<table class="table table-hover" style="margin-bottom: 5px">
	<thead>
		<tr>
			<th>Alumno/a</th>
			<th>Fecha</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = mysqli_fetch_array($result)): ?>
		<?php $result1 = mysqli_query($db_con, "SELECT DISTINCT Fechoria.fecha, Fechoria.grave FROM Fechoria WHERE claveal='".$row['claveal']."' ORDER BY Fechoria.fecha DESC LIMIT 1"); ?>
		<?php while ($row2 = mysqli_fetch_array($result1)): ?>
		<tr>
			<td><a href="../fechorias/fechorias.php?claveal=<?php echo $row['claveal']; ?>&submit1=1"><?php echo $row['nombre'].' '.$row['apellidos']; ?></a></td>
			<td><span class="<?php echo (stristr($row2['grave'], 'grave') == true) ? 'text-danger' : 'text-info'; ?>"><?php echo strftime('%e %b',strtotime($row2['fecha'])); ?></span></td>
			<?php $result2 = mysqli_query($db_con, "SELECT Fechoria.claveal FROM Fechoria WHERE Fechoria.claveal='".$row['claveal']."'"); ?>
			<td class="text-center"><div class="badge"><?php echo mysqli_num_rows($result2); ?></div></td>
		</tr>
		<?php mysqli_free_result($result2); ?>
		<?php endwhile; ?>
		<?php mysqli_free_result($result1); ?>
		<?php endwhile; ?>
		<?php mysqli_free_result($result); ?>
	</tbody>
</table>

<p><small class="text-muted">En azul problemas leves y en rojo graves y muy graves</small></p>
<?php endif; ?>

<!-- FIN PROBLEMAS DE CONVIVENCIA -->
