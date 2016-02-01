<?php
require('../bootstrap.php');


// ELIMINAR INCIDENCIA
if (isset($_GET['parte']) && isset($_GET['borrar']) && $_GET['borrar'] == 1) {
	$result = mysqli_query($db_con, "DELETE FROM partestic WHERE parte=".$_GET['parte']." LIMIT 1");
	
	if(!$result) $msg_error = "No se ha podido eliminar la incidencia. Error: ".mysqli_error($db_con);
	else $msg_success = "La incidencia ha sido eliminada.";
}


// PAGINACION
if (isset($_GET['pag'])) $pag = $_GET['pag']; else $pag = 0;

$result = mysqli_query($db_con, "SELECT parte FROM partestic");
$total = mysqli_num_rows($result);
mysqli_free_result($result);


$limit = 20;
$limit_ini = $pag * $limit;
$n_paginas = round($total / $limit)-1;
$pag_sig = $pag+1;
$pag_ant = $pag-1;


include("../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Centro TIC <small>Lista de incidencias</small></h2>
		</div>
		
		
		<!-- MENSAJES -->
		<?php if(isset($msg_success) && $msg_success): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		<?php if(isset($msg_error) && $msg_error): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-12">
				
				<?php if (stristr($_SESSION['cargo'],'1') == TRUE) $sql_where = ''; else $sql_where = 'WHERE profesor=\''.$_SESSION['profi'].'\''; ?>
				<?php $result = mysqli_query($db_con, "SELECT parte, nincidencia, carro, nserie, fecha, hora, profesor, descripcion, estado FROM partestic $user ORDER BY parte DESC LIMIT $limit_ini, $limit"); ?>
				
				<?php if (mysqli_num_rows($result)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Fecha</th>
								<th>Recurso</th>
								<th>Ordenador</th>
								<th>Incidencia</th>
								<th>Profesor/a</th>
								<th>Estado</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = mysqli_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row['parte']; ?></td>
								<td nowrap><?php echo $row['fecha']; ?></td>
								<td><?php echo $row['carro']; ?></td>
								<td><?php echo $row['nserie']; ?></td>
								<td><?php echo $row['descripcion']; ?></td>
								<td><?php echo $row['profesor']; ?></td>
								<td>
									<?php echo ($row['estado'] == 'activo' || $row['estado'] == 'Activo') ? '<span class="fa fa-exclamation-triangle fa-fw fa-lg" data-bs="tooltip" title="Pendiente"></span>' : ''; ?>
									<?php echo ($row['estado'] == 'solucionado' || $row['estado'] == 'Solucionado') ? '<span class="fa fa-check-circle fa-fw fa-lg" data-bs="tooltip" title="Solucionado"></span>' : ''; ?>
								</td>
								<td nowrap>
									<a href="index.php?id=<?php echo $row['parte']; ?>"><span class="fa fa-edit fa-fw fa-lg" data-bs="tooltip" title="Editar"></span></a>
									<a href="incidencias.php?parte=<?php echo $row['parte']; ?>&borrar=1" data-bb="confirm-delete"><span class="fa fa-trash-o fa-fw fa-lg" data-bs="tooltip" title="Eliminar"></span></a>
								</td>
							</tr>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="8">
									<div class="text-right text-muted">Mostrando <?php echo mysqli_num_rows($result); ?> de <?php echo $limit; ?>. Total: <?php echo $total; ?> resultados</div>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
					
				<ul class="pager">
				  <li class="previous<?php echo ($pag == $n_paginas || $total < $limit) ? ' disabled' : ''; ?>"><a href="<?php echo ($pag == $n_paginas || $total < $limit) ? '#' : 'incidencias.php?pag='.$pag_sig; ?>">&larr; Antiguas</a></li>
				  <li class="next<?php echo ($pag == 0) ? ' disabled' : '' ?>"><a href="<?php echo ($pag == 0) ? '#' : 'incidencias.php?pag='.$pag_ant; ?>">Recientes &rarr;</a></li>
				</ul>
				
				
				<div class="hidden-print">
					<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
					<a href="index.php" class="btn btn-default">Volver</a>
				</div>
				
				
				<?php else: ?>
				
				<h3>No se ha registrado ninguna incidencia</h3>
				
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				
				
				<?php endif; ?>
				
								
			</div><!-- /.col-sm-12 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
  
<?php include("../pie.php"); ?>

</body>
</html>
