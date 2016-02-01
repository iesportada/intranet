<?php 
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

require('../../lib/trendoo/credits.php');
require('../../lib/trendoo/sms_history.php');
require('../../lib/trendoo/sms_status.php');

function sms_status($status) {

	switch ($status) {
		case 'SCHEDULED'	: return 'Pendiente de envío'; break;
		case 'SENT' 		: return 'Enviado, sin reporte de entrega'; break;
		case 'DLVRD' 		: return 'Recibido'; break;
		case 'ERROR' 		: return 'Error de entrega'; break;
		case 'TIMEOUT' 		: return 'Sin información del operador'; break;
		case 'TOOM4NUM' 	: return 'Demasiados SMS para el mismo destinatario'; break;
		case 'TOOM4USER' 	: return 'Demasiados SMS enviados por el usuario'; break;
		case 'UNKNPFX'	 	: return 'Prefijo SMS no válido'; break;
		case 'UNKNRCPT'	 	: return 'Número de teléfono no válido'; break;
		case 'WAIT4DLVR'	: return 'Mensaje enviado, en espera del reporte'; break;
		case 'WAITING'		: return 'Pendiente, no enviado todavía'; break;
		case 'UNKNOWN'		: return 'Estado desconocido'; break;
	}
	
}


$credits = trendoo_get_credits();
$history = trendoo_get_sms_history(time()-(7*24*60*60),time());

include('../../menu.php');
?>

	<div class="container">
	
		<div class="page-header">
			<h2>Información de envíos SMS</h2>
		</div>
		
		
		<?php if ($credits['ok']): ?>
		<div class="row">
			<div class="col-sm-6 text-center">
				<h3>
					<span class="lead text-info"><?php echo $credits[0]->availability; ?></span><br>
					<small class="text-uppercase text-muted">SMS Gold</small>
				</h3>
			</div>
			
			<div class="col-sm-6 text-center">
				<h3>
					<span class="lead text-info"><?php echo $credits[1]->availability; ?></span><br>
					<small class="text-uppercase text-muted">SMS Gold+</small>
				</h3>
			</div>
		</div><!-- /.row -->
		<?php endif; ?>
		
		<br>
		
		<h3>Histórico de envíos <small>Del <?php echo date('d/m/Y H:i:s', time()-(7*24*60*60)); ?> al <?php echo date('d/m/Y H:i:s', time()); ?></small></h3>
		
		<div class="row">
		
			<div class="col-sm-12">
			
				<?php if ($history['ok']): ?>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID Orden</th>
							<th>Tipo SMS</th>
							<th>Fecha de envío</th>
							<th>Destinatarios</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i=0; $i < $history['count']; $i++): ?>
						<?php if($history[$i]->order_id): ?>
						<?php
						$anio = substr($history[$i]->create_time, 0, 4); 
						$mes = substr($history[$i]->create_time, 4, 2);
						$dia = substr($history[$i]->create_time, 6, 2);
						$hora = substr($history[$i]->create_time, 8, 2);
						$minuto = substr($history[$i]->create_time, 10, 2);
						$segundo = substr($history[$i]->create_time, 12, 2);
						?>
						<?php $status = trendoo_get_message_status($history[$i]->order_id); ?>
						<tr>
							<td><?php echo $history[$i]->order_id; ?></td>
							<td><?php echo ($history[$i]->sms_type == 'GS') ? 'Gold' : 'Gold+'; ?></td>
							<td><?php echo $dia.'/'.$mes.'/'.$anio.' '.$hora.':'.$minuto.':'.$segundo; ?></td>
							<td>
							<?php for ($j = 0; $j < count($status); $j++): ?>
								<span style="display: block;"><?php echo $status[$j]->recipient; ?></span>
							<?php endfor; ?>
							</td>
							<td>
							<?php for ($j = 0; $j < count($status); $j++): ?>
								<span style="display: block;"><?php echo sms_status($status[$j]->status); ?></span>
							<?php endfor; ?>
							</td>
						</tr>
						<?php endif; ?>
						<?php endfor; ?>
					</tbody>
				</table>
				<?php else: ?>
				
				<br><br>
				<div class="text-center">
					
					<span class="fa fa-mobile fa-4x text-muted"></span>
					<p class="lead text-muted">No se han enviado mensajes en esta semana</p>
					
				</div>
				<br><br>
				
				<?php endif; ?>
			
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		
		<div class="row">
			
			<div class="col-sm-12">
				<a href="../index.php" class="btn btn-default">Volver</a>
				<a href="https://extranet.trendoo.es/s/user/login" class="btn btn-danger" target="_blank">Ir a Trendoo</a>
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container -->

	<?php include('../../pie.php'); ?>
</body>
</html>
