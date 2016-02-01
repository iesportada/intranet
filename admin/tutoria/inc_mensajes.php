<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- MENSAJES DE TUTORIA -->

<h3 class="text-info">Mensajes de tutoría</h3>

<?php setlocale(LC_ALL, 'es_ES'); ?>
<?php $result = mysqli_query($db_con, "SELECT id, ahora, apellidos, nombre, asunto, texto FROM alma, mensajes WHERE alma.claveal = mensajes.claveal AND mensajes.unidad = '".$_SESSION['mod_tutoria']['unidad']."' AND DATE(ahora) > '".$config['curso_inicio']."' ORDER BY ahora desc"); ?>

<?php if (mysqli_num_rows($result) > 0): ?>
<table class="table table-hover datatable">
	<thead>
		<tr>
			<th>De</th>
			<th>Fecha</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		<?php while ($row = mysqli_fetch_array($result)): ?>
		<tr>
			<td><a href="#mensaje<?php echo $i; ?>" data-toggle="modal"><?php echo $row['nombre'].' '.$row['apellidos']; ?></a></td>
			<td><?php $tr_dia = explode(" ",$row['ahora']); echo $tr_dia[0]; ?></td>
		</tr>
		<?php $i++; ?>
		<?php endwhile; ?>
	</tbody>
</table>

<!-- MODAL -->
<?php $i = 1; ?>
<?php mysqli_data_seek($result,0); ?>
<?php while ($row = mysqli_fetch_array($result)): ?>
<div id="mensaje<?php echo $i; ?>" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title"><?php echo $row['asunto']; ?><br /><small>Enviado por <?php echo $row['nombre'].' '.$row['apellidos']; ?> el <?php         echo mb_convert_encoding(strftime('%A, %e de %B',strtotime($row['ahora'])), 'ISO-8859-1', 'UTF-8'); ?>.</small></h4>
      </div>
      <div class="modal-body">
        <p><?php echo html_entity_decode($row['texto']); ?></p>
      </div>
      <div class="modal-footer">
        <form method="post" name="mensaje_enviado" action="index.php" class="form-inline">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <a class="btn btn-primary" href="../mensajes/redactar.php?padres=1&asunto=<?php echo $row['asunto']; ?>&origen=<?php echo $row['apellidos'].', '.$row['nombre']; ?>">Responder</a>
	        <input type="hidden" name="id_ver" value="<?php echo $id; ?>">
	      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $i++; ?>
<?php endwhile; ?>
<?php mysqli_free_result($result); ?>

<?php else: ?>

<br>
<p class="lead text-muted">No hay mensajes para el tutor.</p>

<?php endif; ?>

<!-- FIN MENSAJES DE TUTORIA -->