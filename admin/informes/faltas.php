<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- MODULO RESUMEN FALTAS DE ASISTENCIA -->

<a name="faltas"></a>
<h3>Resumen de faltas de asistencia</h3>

<div class="row">
	
	<div class="col-sm-3">
	
		<?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal and FALTAS.falta = 'F' and FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos"); ?>
		<?php $total = 0; ?>
		<?php if (mysqli_num_rows($result)): ?>
		<?php $row = mysqli_fetch_array($result); ?>
		<?php $total = $row['total']; ?>
		<?php mysqli_free_result($result); ?>
		<?php endif; ?>
		
		<h3 class="text-info text-center">
			<?php echo $total; ?><br>
			<small class="text-uppercase">faltas injustificadas</small>
		</h3>
		
	</div>
	
	<div class="col-sm-3">
		
		<?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal AND FALTAS.falta = 'J' AND  FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos"); ?>
		<?php $total = 0; ?>
		<?php if (mysqli_num_rows($result)): ?>
		<?php $row = mysqli_fetch_array($result); ?>
		<?php $total = $row['total']; ?>
		<?php mysqli_free_result($result); ?>
		<?php endif; ?>
		
		<h3 class="text-info text-center">
			<?php echo $total; ?><br>
			<small class="text-uppercase">faltas justificadas</small>
		</h3>
		
	</div>

	<div class="col-sm-3">
	
		<?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal and FALTAS.falta = 'R' and FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos"); ?>
		<?php $total = 0; ?>
		<?php if (mysqli_num_rows($result)): ?>
		<?php $row = mysqli_fetch_array($result); ?>
		<?php $total = $row['total']; ?>
		<?php mysqli_free_result($result); ?>
		<?php endif; ?>
		
		<h3 class="text-info text-center">
			<?php echo $total; ?><br>
			<small class="text-uppercase">retrasos injustificados</small>
		</h3>
		
	</div>
	
	<div class="col-sm-3">
		
		<?php $result = mysqli_query($db_con, "SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.falta, FALTAS.fecha FROM FALUMNOS, FALTAS where FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.falta = 'F' and  FALUMNOS.claveal = $claveal group by FALUMNOS.APELLIDOS, FALTAS.fecha"); ?>
		<?php $total = 0; ?>
		<?php $total = mysqli_num_rows($result); ?>
		
		<h3 class="text-info text-center">
			<?php echo $total; ?><br>
			<small class="text-uppercase">días completos injustificados</small>
		</h3>
		
	</div>

</div>

<br>

<!-- FIN MODULO RESUMEN FALTAS DE ASISTENCIA -->
