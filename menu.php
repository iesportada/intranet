<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');


// FEED RSS
$feed = new SimplePie();
	 
$feed->set_feed_url("http://www.juntadeandalucia.es/educacion/www/novedades.xml");
$feed->set_output_encoding('ISO-8859-1');
$feed->enable_cache(false);
$feed->set_cache_duration(600);
$feed->init();
$feed->handle_content_type();

($feed->get_title()) ? $feed_title = $feed->get_title() : $feed_title = 'Novedades - Consejería Educación';

$first_items = array();
$items_per_feed = 5;

for ($x = 0; $x < $feed->get_item_quantity($items_per_feed); $x++)
{
	$first_items[] = $feed->get_item($x);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="iso-8859-1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Intranet del <?php echo $config['centro_denominacion']; ?>">
	<meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
	<meta name="robots" content="noindex, nofollow">
	
	<title>Intranet &middot; <?php echo $config['centro_denominacion']; ?></title>
	

	<!-- BOOTSTRAP CSS CORE -->
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/<?php echo (isset($_SESSION['tema'])) ? $_SESSION['tema'] : 'bootstrap.min.css'; ?>" rel="stylesheet">
	
	<!-- CUSTOM CSS THEME -->
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/animate.css" rel="stylesheet">
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/otros.css" rel="stylesheet">
	
	<!-- PLUGINS CSS -->
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/font-awesome.min.css" rel="stylesheet">
	<link href="//<?php echo $config['dominio']; ?>/intranet/js/summernote/summernote.css" rel="stylesheet">
	<link href="//<?php echo $config['dominio']; ?>/intranet/js/datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet">
	<?php if(isset($PLUGIN_DATATABLES) && $PLUGIN_DATATABLES): ?>
	<link href="//<?php echo $config['dominio']; ?>/intranet/js/datatables/dataTables.bootstrap.css" rel="stylesheet">
	<?php endif; ?>
	<?php if(isset($PLUGIN_COLORPICKER) && $PLUGIN_COLORPICKER): ?>
	<link href="//<?php echo $config['dominio']; ?>/intranet/js/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<?php endif; ?>
	<?php if(isset($_GET['tour']) && $_GET['tour']): ?>
	<link href="//<?php echo $config['dominio']; ?>/intranet/js/bootstrap-tour/bootstrap-tour.min.css" rel="stylesheet">
	<?php endif; ?>
</head>

<body>

	<nav id="topmenu" class="navbar <?php echo (isset($_SESSION['fondo'])) ? $_SESSION['fondo'] : 'navbar-default'; ?> navbar-fixed-top hidden-print" role="navigation">
		<div class="container-fluid">
			
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar"><span class="sr-only">Cambiar navegación</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<a class="navbar-brand" href="//<?php echo $config['dominio']; ?>/intranet/"><?php echo $config['centro_denominacion']; ?></a>
			</div>
		
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li <?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/index.php')) ? 'class="active"' : ''; ?>><a href="//<?php echo $config['dominio']; ?>/intranet/index.php">Inicio</a></li>
					<li <?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/upload/')) ? 'class="active"' : ''; ?>><a href="//<?php echo $config['dominio']; ?>/intranet/upload/">Documentos</a></li>
					<li><a href="https://www.juntadeandalucia.es/educacion/portalseneca/web/seneca/inicio" target="_blank">Séneca</a></li>
				</ul>
		
				<div class="navbar-right">
					<ul class="nav navbar-nav">					
						
						<!-- CONSEJERIA DE EDUCACION -->
						<li class="visible-xs"><a href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6"><?php echo $feed_title; ?></a></li>
						<li id="bs-tour-consejeria" class="dropdown hidden-xs">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-bs="tooltip" title="<?php echo $feed_title; ?>" data-placement="bottom" data-container="body">
								<span class="fa fa-rss fa-fw"></span> <b class="caret"></b>
							</a>
							
							<ul class="dropdown-menu dropdown-feed">
								<li class="dropdown-header"><h5><?php echo $feed_title; ?></h5></li>
								<li class="divider"></li>
								<?php if (count($first_items)): ?>
								<?php foreach ($first_items as $item): ?>
								<li>
									<a href="<?php echo $item->get_permalink(); ?>" target="_blank">
										<span class="pull-right text-muted"><em><?php echo strftime('%e %b',strtotime($item->get_date('j M Y, g:i a'))); ?></em></span>
										<?php echo $item->get_title(); ?>
									</a>
								</li>
								<li class="divider"></li>
								<?php endforeach; ?>
								<?php else: ?>
								<li><p class="text-center text-muted">Este módulo no está disponible en estos momentos. Disculpen las molestias.</p></li>
								<li class="divider"></li>
								<?php endif; ?>
								<li><a class="text-center"
									href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6" target="_blank"><strong>Ver
								todas las novedades <span class="fa fa-angle-right"></span></strong></a></li>
							</ul>
						</li>
						
						<!-- MENSAJES -->
						<li class="visible-xs <?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/admin/mensajes/')) ? 'active' : ''; ?>"><a href="//<?php echo $config['dominio']; ?>/intranet/admin/mensajes/index.php">Mensajes</a></li>
						<li id="bs-tour-mensajes" class="dropdown hidden-xs">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-bs="tooltip" title="Mensajes recibidos" data-placement="bottom" data-container="body">
								<span id="icono_notificacion_mensajes" class="fa fa-envelope fa-fw"></span> <b class="caret"></b>
							</a>
							
							<ul class="dropdown-menu dropdown-messages">
								<li class="dropdown-header"><h5>Últimos mensajes</h5></li>
								<li class="divider"></li>
								<?php $result_mens = mysqli_query($db_con, "SELECT ahora, asunto, id, id_profe, recibidoprofe, texto, origen FROM mens_profes, mens_texto WHERE mens_texto.id = mens_profes.id_texto AND profesor='".$_SESSION['ide']."' ORDER BY ahora DESC LIMIT 0, 5"); ?>
								<?php if(mysqli_num_rows($result_mens)): ?>
								<?php while ($row_mens = mysqli_fetch_array($result_mens)): ?>
								<li id="menu_mensaje_<?php echo $row_mens['id_profe']; ?>">
									<a href="//<?php echo $config['dominio']; ?>/intranet/admin/mensajes/mensaje.php?id=<?php echo $row_mens['id']; ?>&idprof=<?php echo $row_mens['id_profe']; ?>">
										<div <?php echo ($row_mens['recibidoprofe']==0) ? 'class="text-warning"' : ''; ?>>
										<?php $result_dest = mysqli_query($db_con, "SELECT nombre FROM departamentos WHERE idea='".$row_mens['origen']."' LIMIT 1"); ?>
										<?php $row_dest = mysqli_fetch_array($result_dest); ?>
											<span class="pull-right text-muted"><em><?php echo strftime('%e %b',strtotime($row_mens['ahora'])); ?></em></span>
											<strong><?php echo nomprofesor($row_dest['nombre']); ?></strong>
										</div>
										<div <?php echo ($row_mens['recibidoprofe']==0) ? 'class="text-warning"' : ''; ?>>
											<?php echo substr(stripslashes($row_mens['asunto']),0 , 96); ?>
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<?php endwhile; ?>
								<?php mysqli_free_result($result_mens); ?>
								<?php else: ?>
								<li><p class="text-center text-muted">No tienes mensajes pendientes.</p></li>
								<li class="divider"></li>
								<?php endif; ?>
								<li style="padding: 0 20px; font-size: 0.9em;">
									<div class="row">
										<div class="col-sm-6" style="border-right: 1px solid #dedede; padding: 11px 0 !important;">
											<a class="text-block text-center" href="//<?php echo $config['dominio']; ?>/intranet/admin/mensajes/" style="display: block;"><strong>Ver mensajes</strong></a>
										</div>
										<div class="col-sm-6" style="padding: 11px 0 !important;">
											<a class="text-center" href="//<?php echo $config['dominio']; ?>/intranet/admin/mensajes/redactar.php" style="display: block;"><strong>Redactar</strong></a>
										</div>
									</div>
								</li>
							</ul>
						</li>
						
						<!-- MENÚ DE USUARIO -->
						<li class="dropdown" id="bs-tour-usermenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="fa fa-user fa-fw"></span> <?php echo $idea; ?> <b class="caret"></b> </a>
							
							<ul class="dropdown-menu" style="min-width: 340px !important;">
								<li class="hidden-xs">
									<div style="padding: 3px 20px;">
										<?php if(file_exists(INTRANET_DIRECTORY . '/xml/fotos_profes/' . $idea . '.jpg')) {
											$foto_usuario = 'data:image/png;base64,'.base64_encode(file_get_contents(INTRANET_DIRECTORY . '/xml/fotos_profes/' . $idea . '.jpg'));
										}
										else {
										
											$foto_usuario = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIE1hY2ludG9zaCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDowNTIxRkVGOTNFQ0QxMUU1QjM2MEYzNTlBMTA0RkI2NiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDowNTIxRkVGQTNFQ0QxMUU1QjM2MEYzNTlBMTA0RkI2NiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjA1MjFGRUY3M0VDRDExRTVCMzYwRjM1OUExMDRGQjY2IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjA1MjFGRUY4M0VDRDExRTVCMzYwRjM1OUExMDRGQjY2Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+DgqUZgAAA8pJREFUeNrsWE0rbVEYfs+2EaEYnKmJgXwN5SNFJ5kw8AcwkKkZf8BEiqlSJvwAQ1HiJN8ThWSIASUpIl/nXM+63nXfs+/+WHufLbebVauzz957rfWs93nej7UTl5eXWfps2ay+/JaWSCScGDL2d4OSzQWLZdE/3n4A5tvsuEXOWrI+1YPrfHRuxwFIAsN1QUEBZTIZ1b+NYgBhYGgAxe39/f337m1bWRJdvvtlFpRxSi64sbFBOzs7dHZ2Ri8vL1RTU0Pt7e3U1dX1F9VhgSYuLi6yUSyHhe/u7mh6epoODg7o7e1NdViPnzc3N9P4+DhVVFTosWFpt6JoDosAzMzMDG1tbdHDwwM9PT3R8/Ozuv/6+qr69vY2TU1NacByg6aWjKRBLJZOp2lvb09R6uYQfA8gl5eXFXDp3V/mJCx4Cc4rjOAZLLm5uamcSDqSm5ZjsyB0dnx8rL01KL+enJxoJ2Fgpp5thXUOqcMwARjjeEMcDZxxNBJACUoGYoQSU5D19fVqXHFxsaZZzuk3h2VCEXshWwG/HR0dxhbs7OzUY+EsHrVfeIBsPTft9PX1UUtLS+ACra2t1Nvbq+llC8rAnRfFDIhDBNMKD56cnFQA/MDhHcTHwsLCHM2ZhhzbhGKeFAF5fn6ednd31fXIyAjNzc3R0tISra6uKm9Fq6uro+7uburv76fFxUX1TllZGbW1tdHg4CCVlpbmAPWj2jfVSUHf398rQOfn5znv1NbW0sDAAKVSKaqqqlL3bm5uaG1tjRYWFuj09PSPNT6Kh+rqapqdnVUgAYwDvBdIT4AyPaFNTEzQysqKby5lgLe3t55yAdU9PT00NjamQbHjhdYg6+T6+lpZJKgBmBc4mcPX19fp6upKb9ZPi1aQ9jif5lsZy3nhYEiVMvWFsqAzvKDOi/NoCUqPjo60Afw0aAWdT2H+j8O9UWI3BQhQ7GxBRYMRxfDKuA/o0CA7TV6BGg3CjsN6EuDj46O2pl/as0yKhMrKytCFZhBAHAMYFOfnSBTD0xoaGnQlErZk94qvjY2Nynp86ouU6tjjhoaGaH9/X4cIzsfO7oyfznzO90pKSmh0dFRTzDSHTnU8CBPjUITUdXh4qAQOWjAxNsBdguS6EfeQ4tCTySQ1NTXR8PAwlZeXa2p5nJsOjQDyL3ZeVFSUQ4sb5VL00sJcD2KzvCnM45cAAimWRSs8D10Cl/Twe7LOc1LvzM2xfVmQAVWCkv+d4JygnF8WTFKnHSVEuH3KcALxim9h87kdR0zzWjyO4uLnC+t/D/CXAAMA50LM8ZPAGicAAAAASUVORK5CYII=';
										}
										?>
										<img class="img-thumbnail pull-left" width="40" src="<?php echo $foto_usuario; ?>" alt="" style="margin-right: 10px;">
										
										<span style="font-weight: bold;"><?php echo $pr; ?></span><br>
										<small class="text-muted">
											Último acceso: 
											<?php
											$time = mysqli_query($db_con, "select fecha from reg_intranet where profesor = '".$idea."' order by fecha desc limit 2");
											$num = 0;
											while($last = mysqli_fetch_array($time)) {
												$num+=1;
													
												if($num == 2) {
													$t_r0 = explode(" ",$last[0]);
													$dia_hora = cambia_fecha($t_r0[0]);
													echo "$dia_hora $t_r0[1]";
												}
											}
											?>
										</small>
										<div class="clearfix"></div>
									</div>
								</li>
								<li class="divider hidden-xs"></li>
								<li><a href="//<?php echo $config['dominio']; ?>/intranet/clave.php"><span class="fa fa-key fa-fw"></span> Cambiar contraseña</a></li>
								<li><a href="//<?php echo $config['dominio']; ?>/intranet/admin/fotos/fotos_profes.php"><span class="fa fa-camera fa-fw"></span> Cambiar fotografía</a></li>
								<li><a href="//<?php echo $config['dominio']; ?>/intranet/xml/jefe/index_temas.php"><span class="fa fa-paint-brush fa-fw"></span> Cambiar tema</a></li>
								<li class="divider"></li>
								<li><a href="//<?php echo $config['dominio']; ?>/intranet/salir.php"><span class="fa fa-sign-out fa-fw"></span> Desconectar</a></li>
							</ul>
						</li>
					</ul>

				</div><!-- /.navbar-right -->
		
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	
	<?php unset($foto_usuario); ?>
