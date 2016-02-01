<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$page_header = "Reservas <small>Administración de recursos</small>";


// ENVÍO DE FORMULARIO
if (isset($_POST['aceptar'])) {

	// LIMPIAMOS CARACTERES
	if (isset($_POST['id_recurso'])) $id_recurso = mysqli_real_escape_string($db_con, trim($_POST['id_recurso']));
	$nombre_recurso	= mysqli_real_escape_string($db_con, trim($_POST['nombre_recurso']));
	$obs_recurso 	= mysqli_real_escape_string($db_con, trim($_POST['obs_recurso']));
	
	// COMPROBAMOS QUE LOS CAMPOS OBLIGATORIOS NO ESTÉN VACÍOS
	if (! empty($nombre_recurso)) {
	
		// COMPROBAMOS SI SE TRATA DE UNA EDICIÓN DE RECURSOS O INSERCIÓN
		if (isset($id_recurso)) {
			
			$result = mysqli_query($db_con, "SELECT id FROM reservas_tipos WHERE id='$id_recurso' LIMIT 1");
			if (mysqli_num_rows($result)) {
				$result_update = mysqli_query($db_con, "UPDATE reservas_tipos SET tipo='$nombre_recurso', observaciones='$obs_recurso' WHERE id='$id_recurso' LIMIT 1");
				
				if (! $result_update) $msg_error = 'No se ha podido modificar el recurso. Error: '.mysqli_error($db_con);
				else $msg_success = 'El recurso ha sido modificado';
			}
			mysqli_free_result($result);
			
		}
		else {
			$result_insert = mysqli_query($db_con, "INSERT INTO reservas_tipos (tipo, observaciones) VALUES ('$nombre_recurso', '$obs_recurso')");
			
			if (! $result_insert) $msg_error = 'No se ha podido añadir el recurso. Error: '.mysqli_error($db_con);
			else $msg_success = 'El recurso ha sido creado';
		}
	}
	else {
		$msg_error = 'El nombre del recurso es obligatorio.';
	}
	
}


// ELIMINAR UN RECURSO
if (isset($_GET['id']) && (isset($_GET['action']) && $_GET['action'] == 'delete')) {
	
	$id_recurso = mysqli_real_escape_string($db_con, $_GET['id']);
	
	$result = mysqli_query($db_con, "SELECT id FROM reservas_tipos WHERE id='$id_recurso' LIMIT 1");
	if (mysqli_num_rows($result) && $id_recurso > 2) {
		
		// COMPROBAMOS LOS ELEMENTOS Y LOS ELIMINAMOS
		$result_elementos = mysqli_query($db_con, "SELECT id FROM reservas_elementos WHERE id_tipo='$id_recurso'");
		if (mysqli_num_rows($result_elementos)) {
			while ($row = mysqli_fetch_array($result_elementos)) {
				mysqli_query($db_con, "DELETE FROM reservas_elementos WHERE id='".$row['id']."' LIMIT 1");
			}
		}
		mysqli_free_result($result_elementos);
		
		$result_delete = mysqli_query($db_con, "DELETE FROM reservas_tipos WHERE id='$id_recurso' LIMIT 1");
		
		if (! $result_delete) $msg_error = 'No se ha podido eliminar el recurso. Error: '.mysqli_error($db_con);
		else $msg_success = 'El recurso ha sido eliminado';
	}
	else {
		$msg_error = 'No se puede eliminar este recurso.';
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
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoTipo">Nuevo recurso</a>
				</div>
				
				<br>
				
				<?php $result = mysqli_query($db_con, "SELECT DISTINCT reservas_tipos.id, reservas_tipos.tipo, reservas_tipos.observaciones FROM reservas_tipos ORDER BY id ASC"); ?>
				<?php if(mysqli_num_rows($result)): ?>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Recurso</th>
								<th>Observaciones</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php while ($row = mysqli_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['tipo']; ?></td>
								<td><?php echo (! empty($row['observaciones'])) ? $row['observaciones'] : '<em class="text-muted">Sin observaciones</em>'; ?></td>
								<td class="text-right">
									<a href="gestion_elementos.php?id=<?php echo $row['id']; ?>" data-bs="tooltip" title="Administrar elementos"><span class="fa fa-cogs fa-fw fa-lg"></span></a>
									<?php if($row['id'] > 2): ?>
									<a href="#" data-bs="tooltip" title="Editar" data-toggle="modal" data-target="#modalNuevoTipo" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['tipo']; ?>" data-obs="<?php echo $row['observaciones']; ?>"><span class="fa fa-edit fa-fw fa-lg"></span></a>
									<a href="gestion_tipo.php?id=<?php echo $row['id']; ?>&action=delete" data-bb="confirm-delete" data-bs="tooltip" title="Eliminar"><span class="fa fa-trash-o fa-fw fa-lg"></span></a>
									<?php endif; ?>
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
					<p class="lead text-muted">No hay recursos compartidos en el centro</p>
				</div>
				<br><br><br><br>
				
				<?php endif; ?>
				
			</div><!-- /.col-sm-12 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container -->

	
	<div class="modal fade" id="modalNuevoTipo" tabindex="-1" role="dialog" aria-labelledby="modalNuevoTipoTitle">
	  <div class="modal-dialog">
	  	<form action="gestion_tipo.php" method="post">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modalNuevoTipoTitle">Crear nuevo recurso</h4>
		      </div>
		      <div class="modal-body">
	      		
	      		<div class="form-group"> 
	      			<label for="nombre_recurso">Nombre del recurso</label>
	      			<input type="text" class="form-control" id="nombre_recurso" name="nombre_recurso" required>
	      		</div>
	      		
	      		<div class="form-group"> 
	      			<label for="obs_recurso">Observaciones</label>
	      			<textarea class="form-control" id="obs_recurso" name="obs_recurso" rows="2"></textarea>
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
		$('#modalNuevoTipo').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget);
		  var id = button.data('id');
		  var nombre = button.data('name');
		  var obs = button.data('obs');

		  var modal = $(this);
		  modal.find('.modal-title').text(nombre);
		  modal.find('.modal-body input[name=nombre_recurso]').val(nombre);
		  modal.find('.modal-body textarea[name=obs_recurso]').val(obs);
		  if(id) {
		  	$('.modal-body').append('<input type="hidden" name="id_recurso" value="' + id + '">');
		  }
		})
	</script>

</body>
</html>