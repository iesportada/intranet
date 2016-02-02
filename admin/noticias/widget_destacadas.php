<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- MODULO DE NOTICIAS DESTACADAS -->

<br>
<h4><span class="fa fa-fire fa-fw"></span> Noticias destacadas</h4>

<?php $result = mysqli_query($db_con, "SELECT id, slug, timestamp, clase from noticias where pagina like '%1%' and fechafin >= '".date('Y-m-d H:i:s')."' ORDER BY timestamp DESC"); ?>
<?php if(mysqli_num_rows($result)): ?>

<div class="list-group">
<?php while ($row = mysqli_fetch_array($result)): ?>
	<a class="list-group-item" href="//<?php echo $config['dominio']; ?>/intranet/admin/noticias/noticia.php?id=<?php echo $row['id']; ?>&widget=1">
		<small class="text-muted pull-right"><?php echo strftime('%e %b',strtotime($row['timestamp'])); ?></small>
		<span class="text-info"><?php echo $row['slug']; ?></span>
	</a>
<?php endwhile; ?>
<?php mysqli_free_result($result); ?>
</div>
<?php else: ?>

<?php if (isset($_GET['tour']) && $_GET['tour']): ?>
<div class="list-group">
	<a class="list-group-item" href="#">
		<small class="text-muted pull-right"><?php echo strftime('%e %b',strtotime(date('Y-m-d H:i:s'))); ?></small>
		<span class="text-info">Claustro de profesores</span>
	</a>
</div>
<?php else: ?>
<br>
<p class="lead text-center text-muted">No hay noticias destacadas</p>
<br>
<?php endif; ?>

<?php endif; ?>
<!-- FIN MODULO DE NOTICIAS DESTACADAS -->
