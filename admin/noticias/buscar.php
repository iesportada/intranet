<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

if (isset($_GET['q'])) $search_query = urldecode($_GET['q']); else $search_query = '';
$expresion = explode(' ', $search_query);

$i = 0;
$sql_where = "";

while (false != $expresion[$i]) {

	if ($i == 0) $sql_where .= "WHERE"; else $sql_where .= " AND";
	$sql_where .= " (slug LIKE '%".$expresion[$i]."%' OR content LIKE '%".$expresion[$i]."%')";
	
	$i++;
}

include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Noticias <small>Resultados de la búsqueda</small></h2>
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
			
			<div class="col-sm-12">
			
				<form method="get" action="">
				   <div class="input-group">
				     <input type="text" class="form-control" id="q" name="q" maxlength="60" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : '' ; ?>" placeholder="Buscar por título o contenido de la noticia">
				     <span class="input-group-btn">
				       <button class="btn btn-default" type="submit"><span class="fa fa-search fa-lg"></span></button>
				     </span>
				   </div><!-- /input-group -->
				</form>
				
				<br>
				
				<?php $result = mysqli_query($db_con, "SELECT id, slug, timestamp, contact, pagina FROM noticias $sql_where ORDER BY timestamp DESC"); ?>
				
				<?php if (mysqli_num_rows($result)): ?>
					
					<style class="text/css">
						a.link-msg, a.link-msg:hover { color: #444; display: block; text-decoration:none; }
					</style>
					
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Título</th>
									<th nowrap>Fecha publicación</th>
									<th>Autor</th>
									<th>Int.</th>
									<th>Ext.</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($row = mysqli_fetch_array($result)): ?>
									<tr>
										<td><a class="link-msg" href="noticia.php?id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
										<td><a class="link-msg" href="noticia.php?id=<?php echo $row['id']; ?>"><?php echo (strlen($row['slug']) > 60) ? substr($row['slug'],0,60).'...' : $row['slug']; ?></a></td>
										<td><a class="link-msg" href="noticia.php?id=<?php echo $row['id']; ?>"><?php echo strftime('%d-%m-%G',strtotime($row['timestamp'])); ?></a></td>
										<td><a class="link-msg" href="noticia.php?id=<?php echo $row['id']; ?>"><?php echo nomprofesor($row['contact']); ?></a></td>
										<td class="text-center">
											<span class="fa <?php echo (strstr($row['pagina'],'1')==TRUE) ? 'fa-check-square-o' : 'fa-square-o'; ?> fa-lg" data-bs="tooltip" title="<?php echo (strstr($row['pagina'],'1')==TRUE) ? 'Publicada en la intranet' : 'No publicada en la intranet'; ?>"></span>
										</td>
										<td class="text-center">
											<span class="fa <?php echo (strstr($row['pagina'],'2')==TRUE) ? 'fa-check-square-o' : 'fa-square-o'; ?> fa-lg" data-bs="tooltip" title="<?php echo (strstr($row['pagina'],'2')==TRUE) ? 'Publicada en la página externa' : 'No publicada en la página externa'; ?>"></span>
										</td>
										<td nowrap>
											<?php if(stristr($_SESSION['cargo'],'1') == TRUE || $_SESSION['profi'] == $row['contact']): ?>
											<a href="redactar.php?id=<?php echo $row['id']; ?>"><span class="fa fa-edit fa-fw fa-lg" data-bs="tooltip" title="Editar"></span></a>
											<a href="index.php?id=<?php echo $row['id']; ?>&timestamp=<?php echo $row['timestamp']; ?>&borrar=1" data-bb="confirm-delete"><span class="fa fa-trash-o fa-fw fa-lg" data-bs="tooltip" title="Eliminar"></span></a>
											<?php endif; ?>
										</td>
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
