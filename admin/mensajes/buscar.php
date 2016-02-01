<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

if (isset($_GET['q'])) $search_query = urldecode($_GET['q']); else $search_query = '';
$expresion = explode(' ', $search_query);

$i = 0;
$sql_where = "";

while (false != $expresion[$i]) {

	if ($i == 0) $sql_where .= "WHERE"; else $sql_where .= " AND";
	$sql_where .= " (asunto LIKE '%".$expresion[$i]."%' OR texto LIKE '%".$expresion[$i]."%' OR destino LIKE '%".$expresion[$i]."%')";
	
	$i++;
}

include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Mensajes <small>Resultados de la búsqueda</small></h2>
		</div>
		
		<!-- MENSAJES -->
		<?php if(isset($msg_error)): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		<?php if(isset($msg_success)): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		
		<div class="row">
			
			<div class="col-sm-10 col-sm-offset-1">
			
				<form method="get" action="">
				   <div class="input-group">
				     <input type="text" class="form-control" id="q" name="q" maxlength="60" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : '' ; ?>" placeholder="Buscar por título, contenido o destinatario del mensaje">
				     <span class="input-group-btn">
				       <button class="btn btn-default" type="submit"><span class="fa fa-search fa-lg"></span></button>
				     </span>
				   </div><!-- /input-group -->
				</form>
				
				<br>
				
				<?php $result = mysqli_query($db_con, "SELECT id, ahora, asunto, destino FROM mens_texto $sql_where and (origen = '$profesor' or destino like '%Claustro%' or destino like '%$profesor%') ORDER BY ahora DESC"); ?>
				
				<?php if (mysqli_num_rows($result)): ?>
					
					<style class="text/css">
						a.link-msg, a.link-msg:hover { color: #444; display: block; text-decoration:none; }
					</style>
					
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Fecha</th>
									<th>Título</th>
									<th>Destino</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($row = mysqli_fetch_array($result)): ?>
									<tr>
										<td nowrap><a class="link-msg" href="mensaje.php?id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
										<td nowrap><a class="link-msg" href="mensaje.php?id=<?php echo $row['id']; ?>"><?php echo strftime('%d-%m-%G',strtotime($row['ahora'])); ?></a></td>
										<td nowrap><a class="link-msg" href="mensaje.php?id=<?php echo $row['id']; ?>"><?php echo (strlen($row['asunto']) > 60) ? substr($row['asunto'],0,60).'...' : $row['asunto']; ?></a></td>

										<td><a class="link-msg" href="mensaje.php?id=<?php echo $row['id']; ?>"><?php echo (strlen($row['destino']) > 80) ? substr($row['destino'],0,80).'...' : $row['destino']; ?></a></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
						<tfoot>
							<tr>
								<td colspan="5">
									<div class="text-right text-muted">Total: <?php echo mysqli_num_rows($result); ?> resultados</div>
								</td>
							</tr>
						</tfoot>
					</div>
					
					<?php mysqli_free_result($result); ?>
					
				<?php else: ?>
					
					<h3>No se han encontrado resultados.</h3>
					
					
				<?php endif; ?>
				
			</div><!-- /.col-sm-12 -->
					
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>
