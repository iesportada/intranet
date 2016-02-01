<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
$trozos = explode (", ", $al);
$apellidos = $trozos[0];
$nombre = $trozos[1];

?>

<?php $result = mysqli_query($db_con, "SELECT DISTINCT apellidos, nombre, claveal FROM tutoria WHERE jefatura = '1' ORDER BY fecha DESC"); ?>
<?php if(mysqli_num_rows($result) > 0): ?>
<table class="table table-striped table-bordered datatable">
	<thead>
		<tr>
			<th>#</th>
			<th>Alumno</th>
			<th>Fecha</th>
		</tr>
	</thead>
	<tbody>
  	<?php while ($row = mysqli_fetch_array($result)): ?>
    <?php $result_alumno = mysqli_query($db_con, "SELECT DISTINCT id, apellidos, nombre, fecha FROM tutoria WHERE jefatura = '1' AND claveal = '".$row['claveal']."' ORDER BY fecha DESC LIMIT 1"); ?>
	<?php while($row_alumno = mysqli_fetch_array($result_alumno)): ?>
		<tr>
			<td><?php echo $row_alumno['id']; ?></td>
			<td><a href="index.php?id=<?php echo $row_alumno['id']; ?>"><?php echo $row_alumno['nombre'].' '.$row_alumno['apellidos']; ?></a></td>
			<td nowrap><?php echo $row_alumno['fecha']; ?></td>
		</tr>
	<?php endwhile; ?>
	<?php endwhile; ?>
	</tbody>
</table>
<?php endif; ?>
