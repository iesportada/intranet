
<!-- MODULO DE AUSENCIAS -->
<?php 
$hora = date('G');
$minuto = date('i');
$hora_min = $hora.":".$minuto;
$dia_sem = date('w');
$hor=mysqli_query($db_con,"select hora from tramos where hora_inicio <= '$hora_min' and  hora_fin >= '$hora_min'");
$hora_act = mysqli_fetch_array($hor);
$hora_actual = $hora_act[0];
//echo $hora_actual;
?>
<?php $result = mysqli_query($db_con, "SELECT profesor, id, tareas from ausencias where  date(inicio) <= '".date('Y-m-d')."' and date(fin) >= '".date('Y-m-d')."' and (horas like '%$hora_actual%' or horas = '0')"); 
?>
<?php if (mysqli_num_rows($result)): ?>

<div class="well well-sm">
	
	<h4><span class="fa fa-users fa-fw"></span> Profesores ausentes</h4>
	
	<div class="list-group">
		<?php while ($row = mysqli_fetch_array($result)): ?>
		<?php $exp_profesor = explode(',', $row['profesor']); ?>
		<?php $profesor = $exp_profesor[1].' '.$exp_profesor[0]; ?>
		
		<a class="list-group-item" href="admin/ausencias/baja.php?profe_baja=<?php echo $row['profesor']; ?>&id=<?php echo $row['id']; ?>">
			<?php if (strlen($row['tareas']) > 1): ?>
			<span class="pull-right fa fa-check-square-o fa-fw fa-lg" data-bs="tooltip" title="Hay tareas para los alumnos"></span>
			<?php else: ?>
			<span class="pull-right fa fa-square-o fa-fw fa-lg" data-bs="tooltip" title="No hay tareas para los alumnos"></span>
			<?php endif; ?>
			<?php echo nomprofesor($profesor); ?>
		</a>
		<?php endwhile; ?>
	</div>

	<a href="admin/ausencias/diario.php" class="btn btn-default btn-sm">Ver profesores ausentes</a>
</div>
<?php else: ?>

<?php if (isset($_GET['tour']) && $_GET['tour']): ?>
<div class="well well-sm">
	
	<h4><span class="fa fa-users fa-fw"></span> Profesores de baja</h4>
	
	<div class="list-group">
		<a class="list-group-item" href="#">
			<span class="pull-right fa fa-check-square-o fa-fw fa-lg" data-bs="tooltip" title="Hay tareas para los alumnos"></span>
			Juan Pérez
		</a>
	</div>

</div>
<?php endif; ?>

<?php endif; ?>

<!-- FIN MODULO DE AUSENCIAS -->
