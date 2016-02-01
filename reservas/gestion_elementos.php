<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));


if (isset($_GET['id'])) $id_recurso = mysqli_real_escape_string($db_con, trim($_GET['id']));
$result = mysqli_query($db_con, "SELECT tipo FROM reservas_tipos WHERE id='$id_recurso' LIMIT 1");
if (! mysqli_num_rows($result)) header('Location:'.'gestion_tipo.php');

$row = mysqli_fetch_array($result);
$nombre_tipo = $row['tipo'];

$page_header = "Reservas <small>".$nombre_tipo."</small>";


// ENVÍO DE FORMULARIO
if (isset($_POST['aceptar'])) {

	// LIMPIAMOS CARACTERES
	if (isset($_POST['id_elemento'])) $id_elemento = mysqli_real_escape_string($db_con, trim($_POST['id_elemento']));
	$nombre_elemento	= mysqli_real_escape_string($db_con, trim($_POST['nombre_elemento']));
	$obs_elemento 		= mysqli_real_escape_string($db_con, trim($_POST['obs_elemento']));
	(isset($_POST['visible_elemento'])) ? $oculto_elemento = 0 : $oculto_elemento = 1;
	
	// COMPROBAMOS QUE LOS CAMPOS OBLIGATORIOS NO ESTÉN VACÍOS
	if (! empty($nombre_elemento)) {
	
		// COMPROBAMOS SI SE TRATA DE UNA EDICIÓN DE ELEMENTOS O INSERCIÓN
		if (isset($id_elemento)) {
			
			$result = mysqli_query($db_con, "SELECT id FROM reservas_elementos WHERE id='$id_elemento' LIMIT 1");
			if (mysqli_num_rows($result)) {
				$result_update = mysqli_query($db_con, "UPDATE reservas_elementos SET elemento='$nombre_elemento', observaciones='$obs_elemento', oculto='$oculto_elemento' WHERE id='$id_elemento' LIMIT 1");
				
				if (! $result_update) $msg_error = 'No se ha podido modificar el elemento. Error: '.mysqli_error($db_con);
				else $msg_success = 'El elemento ha sido modificado';
			}
			mysqli_free_result($result);
			
		}
		else {
			$result_insert = mysqli_query($db_con, "INSERT INTO reservas_elementos (elemento, id_tipo, observaciones, oculto) VALUES ('$nombre_elemento', '$id_recurso', '$obs_elemento', '$oculto_elemento')");
			
			if (! $result_insert) $msg_error = 'No se ha podido añadir el elemento. Error: '.mysqli_error($db_con);
			else $msg_success = 'El elemento ha sido creado';
		}
	}
	else {
		$msg_error = 'El nombre del elemento es obligatorio.';
	}
	
}


// ELIMINAR UN ELEMENTO
if (isset($_GET['item_id']) && (isset($_GET['action']) && $_GET['action'] == 'delete')) {
	
	$id_elemento = mysqli_real_escape_string($db_con, $_GET['item_id']);
	
	$result = mysqli_query($db_con, "SELECT id FROM reservas_elementos WHERE id='$id_elemento' LIMIT 1");
	if (mysqli_num_rows($result)) {
		$result_delete = mysqli_query($db_con, "DELETE FROM reservas_elementos WHERE id='$id_elemento' LIMIT 1");
		
		if (! $result_delete) $msg_error = 'No se ha podido eliminar el recurso. Error: '.mysqli_error($db_con);
		else $msg_success = 'El recurso ha sido eliminado';
	}
	else {
		$msg_error = 'No se puede eliminar este elemento.';
	}
	mysqli_free_result($result);
}

include("../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2><?php echo $page_header; ?></h2>
		</div>
		
		<?php if (isset($msg_error)): ?>
		<div class="alert alert-danger">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		<?php if (isset($msg_success)): ?>
		<div class="alert alert-success">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<div class="col-sm-12">	
				
				<div class="hidden-print">
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoElemento">Nuevo elemento</a>
					<a href="gestion_tipo.php" class="btn btn-default">Volver</a>
				</div>
				
				<br>
				
				<?php $result = mysqli_query($db_con, "SELECT id, elemento, observaciones, oculto FROM reservas_elementos WHERE id_tipo='".$id_recurso."' ORDER BY id ASC"); ?>
				<?php if(mysqli_num_rows($result)): ?>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Elemento</th>
								<th>Observaciones</th>
								<th>Visibilidad</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php while ($row = mysqli_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['elemento']; ?></td>
								<td><?php echo (! empty($row['observaciones'])) ? $row['observaciones'] : '<em class="text-muted">Sin observaciones</em>'; ?></td>
								<td><?php echo (! $row['oculto']) ? 'Visible' : 'Oculto'; ?></td>
								<td class="text-right">
									<a href="#" data-bs="tooltip" title="Editar" data-toggle="modal" data-target="#modalNuevoElemento" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['elemento']; ?>" data-obs="<?php echo $row['observaciones']; ?>" data-visibility="<?php echo $row['oculto']; ?>"><span class="fa fa-edit fa-fw fa-lg"></span></a>
									<a href="gestion_elementos.php?id=<?php echo $id_recurso; ?>&item_id=<?php echo $row['id']; ?>&action=delete" data-bb="confirm-delete" data-bs="tooltip" title="Eliminar"><span class="fa fa-trash-o fa-fw fa-lg"></span></a>
								</td>
							</tr>
						<?php endwhile; ?>
						</tbody>
					</table>
				</div>
				<?php else: ?>
				
				<br><br>
				<div class="text-center">
					<span class="fa fa-frown-o fa-4x text-muted"></span>
					<p class="lead text-muted">No hay elementos de tipo <?php echo $nombre_tipo; ?></p>
				</div>
				<br><br><br><br>
				
				<?php endif; ?>
				
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container -->

	
	<div class="modal fade" id="modalNuevoElemento" tabindex="-1" role="dialog" aria-labelledby="modalNuevoElementoTitle">
	  <div class="modal-dialog">
	  	<form action="gestion_elementos.php?id=<?php echo $id_recurso; ?>" method="post">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modalNuevoElementoTitle">Crear nuevo elemento</h4>
		      </div>
		      <div class="modal-body">
	      		
	      		<div class="form-group"> 
	      			<label for="nombre_elemento">Nombre del elemento</label>
	      			<input type="text" class="form-control" id="nombre_elemento" name="nombre_elemento" required>
	      		</div>
	      		
	      		<div class="form-group"> 
	      			<label for="obs_elemento">Observaciones</label>
	      			<textarea class="form-control" id="obs_elemento" name="obs_elemento" rows="2"></textarea>
	      		</div>
	      		
	      		<div class="checkbox"> 
      				<label>
      					<input type="checkbox" id="visible_elemento" name="visible_elemento" value="1" checked>
      					Visible para todos
      				</label>
      			</div>
		      	
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="submit" class="btn btn-primary" name="aceptar">Aceptar</button>
		      </div>
		    </div>
	    </form>
	  </div>
	</div>
	

	<?php include("../pie.php"); ?>
	
	<script>
		$('#modalNuevoElemento').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget);
		  var id = button.data('id');
		  var nombre = button.data('name');
		  var obs = button.data('obs');
		  var oculto = button.data('visibility');
		  
		  if (oculto == 1) {
		  	var visibility = false;
		  }
		  else {
		  	var visibility = true;
		  }

		  var modal = $(this);
		  modal.find('.modal-title').text(nombre);
		  modal.find('.modal-body input[name=nombre_elemento]').val(nombre);
		  modal.find('.modal-body textarea[name=obs_elemento]').val(obs);
		  modal.find('.modal-body input[name=visible_elemento]').prop('checked', visibility);
		  if(id) {
		  	$('.modal-body').append('<input type="hidden" name="id_elemento" value="' + id + '">');
		  }
		})
	</script>

</body>
</html>