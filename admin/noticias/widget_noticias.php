<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- MODULO DE NOTICIAS -->

<h4><span class="fa fa-th-list fa-fw"></span> Noticias</h4><hr>

<?php $result = mysqli_query($db_con, "SELECT id, slug, contact, timestamp, clase FROM noticias WHERE timestamp <= '".date('Y-m-d H:i:s')."' AND pagina LIKE '%1%' ORDER BY timestamp DESC LIMIT 8"); ?>
<?php if (mysqli_num_rows($result)): ?>
	
<?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)): ?>
		
<?php $exp_profesor = explode(',', $row['contact']); ?>
<?php $profesor = $exp_profesor[1].' '.$exp_profesor[0]; ?>
		
<div style="border-bottom: 1px solid #ecf0f1; margin-bottom: 15px;">
	
	<h5>
		<a href="admin/noticias/noticia.php?id=<?php echo $row['id']; ?>&widget=1"><?php echo $row['slug']; ?></a>
	</h5>

	<p>
		<small>
			<span class="fa fa-user fa-fw"></span> <?php echo nomprofesor($profesor); ?> &nbsp;&nbsp;&middot;&nbsp;&nbsp;
			<span class="fa fa-clock-o fa-fw"></span> <?php echo strftime('%e %b, %H:%M',strtotime($row['timestamp'])); ?>h &nbsp;&nbsp;&middot;&nbsp;&nbsp;
			<span class="fa fa-tag fa-fw"></span> <?php echo ($row['clase']) ? $row['clase'] : 'Sin categoría'; ?>
		</small>
	</p>
</div>
		
<?php endwhile; ?>
<?php mysqli_free_result($result); ?>
	
<?php else: ?>

	<div class="text-center">
		<br><br>
		<span class="fa fa-th-list fa-5x text-muted"></span>
		<p class="lead text-muted">No se ha publicado ninguna noticia.</p>
		<br><br>
	</div>

<?php endif; ?>

<a class="btn btn-primary btn-sm" href="admin/noticias/redactar.php">Nueva noticia</a>
<a class="btn btn-default btn-sm" href="admin/noticias/index.php">Ver noticias </a>

<!-- FIN MODULO DE NOTICIAS -->
