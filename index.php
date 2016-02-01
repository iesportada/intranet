<?php
require('bootstrap.php');

// Variable del cargo del Profesor
$pr = $_SESSION['profi']; // Nombre
$carg = $_SESSION['cargo']; // Perfil
$dpto = $_SESSION['dpt']; // Departamento
$idea = $_SESSION['ide']; // Usuario iDea de Séneca
$n_curso = $_SESSION['n_cursos']; // Tiene Horario

include("menu.php");
?>	

	<div class="container-fluid" style="padding-top: 15px;">
		
		<div class="row">
			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-md-3">
				
				<div id="bs-tour-menulateral">
				<?php include("menu_lateral.php"); ?>
				</div>
				
				<div id="bs-tour-ausencias">
				<?php include("admin/ausencias/widget_ausencias.php"); ?>
				</div>
				
				<div id="bs-tour-destacadas" class="hidden-xs">
				<?php include ("admin/noticias/widget_destacadas.php"); ?>
				</div>
	
			</div><!-- /.col-md-3 -->
			
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-md-5">
				
				<?php 
				if (stristr($carg, '2')==TRUE) {
					include("admin/tutoria/inc_pendientes.php");
				}
				?>
				<div id="bs-tour-pendientes">
				<?php include ("pendientes.php"); ?>
				</div>
				
				<?php if (stristr($carg, '1')==TRUE): ?>
				<?php include('widget_estadisticas.php'); ?>
				<?php endif; ?>     
				
		        <div class="bs-module">
		        <?php include("admin/noticias/widget_noticias.php"); ?>
		        </div>
		        
		        <br>
				
			</div><!-- /.col-md-5 -->
			
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-md-4">
				
				<div id="bs-tour-buscar">
				<?php include("buscar.php"); ?>
				</div>
				
				<br><br>
				
				<div id="bs-tour-calendario">
				<?php
				define('MOD_CALENDARIO', 1);
				include("calendario/widget_calendario.php");
				?>
				</div>
				
				<br><br>
				
				<?php if($config['mod_horarios'] and ($n_curso > 0)): ?>
				<div id="bs-tour-horario">
				<?php include("horario.php"); ?>
				</div>
				<?php endif; ?>
				
			</div><!-- /.col-md-4 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container-fluid -->

<?php include("pie.php"); ?>
	
	<script>
	function notificar_mensajes(nmens) {
		if(nmens > 0) {
			$('#icono_notificacion_mensajes').addClass('text-warning');
		}
		else {
			$('#icono_notificacion_mensajes').removeClass('text-warning');
		}	
	}
	
	<?php if (isset($mensajes_pendientes) && $mensajes_pendientes): ?>
	var mensajes_familias = $("#lista_mensajes_familias li").size();
	var mensajes_profesores = $("#lista_mensajes li").size();
	var mensajes_pendientes = <?php echo $mensajes_pendientes; ?>;
	notificar_mensajes(mensajes_pendientes);
	<?php endif; ?>
	
	$('.modalmens').on('hidden.bs.modal', function (event) {
		var idp = $(this).data('verifica');
	  var noleido = $(this).find('#noleido-' + idp).attr('aria-pressed');
	  
	  // OJO: true o false se pasa como cadena de texto, no como binario
	  if (noleido == 'false') {
	  	
		  $.post( "./admin/mensajes/post_verifica.php", { "idp" : idp }, null, "json" )
		      .done(function( data, textStatus, jqXHR ) {
		          if ( data.status ) {
		              if (mensajes_profesores < 2) {
		              	$('#alert_mensajes').slideUp();
		              }
		              else {
		              	$('#mensaje_link_' + idp).slideUp();
		              }
		              $('#menu_mensaje_' + idp + ' div').removeClass('text-warning');
		              mensajes_profesores--;
		              mensajes_pendientes--;
		              notificar_mensajes(mensajes_pendientes);
		          }
		  });
		  
		 
		}
		
	});
	
	$('.modalmensfamilia').on('hidden.bs.modal', function (event) {
		var idf = $(this).data("verifica-familia");
	  
	  $.post( "./admin/mensajes/post_verifica.php", { "idf" : idf }, null, "json" )
	      .done(function( data, textStatus, jqXHR ) {
	          if ( data.status ) {
	              if (mensajes_familias < 2 ) {
	              	$('#alert_mensajes_familias').slideUp();
	              }
	              else {
	              	$('#mensaje_link_familia_' + idf).slideUp();
	              }
	              mensajes_familias--;
	              mensajes_pendientes--;
	              notificar_mensajes(mensajes_pendientes);
	          }
	  });
	});
	</script>
	
	<?php if (isset($_GET['tour']) && $_GET['tour']): ?>
	<script>
	// Instance the tour
	var tour = new Tour({
		
		onEnd: function() {
			localStorage.removeItem('tour_current_step');
		  return window.location.href = '//<?php echo $config['dominio']; ?>/intranet/index.php';
		},
		
		keyboard: true,
		
	  steps: [
	  {
	    title: "<h1 class=\"text-center\">Primeros pasos</h1>",
	    content: "<p>Antes de comenzar, realiza un tour por la portada de la Intranet para conocer las características de los módulos que la componen y la información de la que dispone.</p><p>Haz click en <strong>Siguiente</strong> para continuar o haz click en <strong>Omitir</strong> para saltarse el tour.",
	    container: "body",
	    template: "<div class='popover tour' style='max-width: 670px !important;'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='end'>Omitir</button><button class='btn btn-primary' data-role='next'>Siguiente »</button></div></div>",
	    orphan: true,
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-usermenu",
	    title: "Menú de usuario",
	    content: "Desde este menú podrás volver a cambiar la contraseña, correo electrónico y fotografía.",
	    container: "body",
	    placement: "bottom",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: false,
	  },
	  {
	    element: "#bs-tour-consejeria",
	    title: "Novedades de la Consejería",
	    content: "Consulta las últimas novedades de la Consejería de Educación, Cultura y Deporte de la Junta de Andalucía. Este icono solo será visible desde la portada de la Intranet.",
	    container: "body",
	    placement: "bottom",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: false,
	  },
	  {
	    element: "#bs-tour-mensajes",
	    title: "Mensajes",
	    content: "Consulta los últimos mensajes recibidos. Cuando recibas un mensaje, el icono cambiará de color para avisarte. Para leer el mensaje haz click en este icono o dirígete a la portada de la Intranet para ver todos los avisos.",
	    container: "body",
	    placement: "bottom",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: false,
	  },
	  {
	    element: "#bs-tour-menulateral",
	    title: "Menú de opciones",
	    content: "Según tu perfil de trabajo tendrás un menú con las opciones que necesitas en tu día a día.<br>Desde el menú <strong>Consultas</strong> tendrás acceso a la información de los alumnos, horarios, estadísticas y fondos de la Biblioteca del centro.<br>El menú <strong>Trabajo</strong> contiene las acciones de registro de Problemas de Convivencia, Faltas de Asistencia, Informes de tareas, Informes de tutoría, Reservas de aulas y medios audiovisuales, Ausencias, etc.<br>El menú <strong>Departamento</strong> contiene las opciones necesarias para la gestión de tu departamento.<br>Y por último, <strong>Páginas de interes</strong> contiene enlaces a páginas externas de información y recursos educativos.",
	    container: "body",
	    placement: "right",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-ausencias",
	    title: "Profesores de baja",
	    content: "Este módulo ofrece información sobre los profesores ausentes en el día. Si el profesor ha registrado tareas para los alumnos aparecerá marcado con el icono chequeado. Para registrar una ausencia debes dirigirte al menú <strong>Trabajo</strong>, <strong>Profesores ausentes</strong>.",
	    container: "body",
	    placement: "right",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-destacadas",
	    title: "Noticias destacadas",
	    content: "Este módulo ofrece un listado de las noticias mas importantes. Puede aparecer durante varios días, según lo establezca el Equipo directivo.",
	    container: "body",
	    placement: "right",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-pendientes",
	    title: "Tareas pendientes",
	    content: "Aquí aparecerán los avisos de tareas pendientes que debes realizar.",
	    container: "body",
	    placement: "bottom",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-buscar",
	    title: "Buscar alumnos y noticias",
	    content: "Este buscador te permite buscar alumnos para consultar su expediente o realizar alguna acción como registrar un Problema de Convivencia o Intervención. Puedes buscar tanto por nombre como apellidos. <br>Si presionas la tecla <kbd>Intro</kbd> buscará coincidencias en las noticias publicadas.",
	    container: "body",
	    placement: "left",
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-calendario",
	    title: "Calendario",
	    content: "El calendario mostrará información sobre los eventos del Centro, Actividades extraescolares y tus anotaciones personales. Cada evento está identificado con una bola de color; al pasar el ratón por encima aparecerá la descripción del evento. Debajo del calendario aparerán los eventos programados para el día de hoy. Para programar un evento haz click en <strong>Ver calendario</strong> o dirígite al menú <strong>Trabajo</strong>, <strong>Calendario</strong>, <strong>Ver calendario</strong>.",
	    container: "body",
	    placement: "left",
	    <?php if($config['mod_horarios'] and ($n_curso > 0)): ?>
	    template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button></div></div>",
	    <?php else: ?>
	    template: "<div class='popover tour' style='max-width: 600px !important;'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button><button class='btn btn-primary' data-role='end'>Entendido</button></div></div>",
	    <?php endif; ?>
	    backdrop: true,
	  },
	  <?php if($config['mod_horarios'] and ($n_curso > 0)): ?>
	  {
	    element: "#bs-tour-horario",
	    title: "Horario y cuaderno de notas",
	    content: "Por último, el horario contiene enlaces para acceder al <strong>Cuaderno de notas</strong> o a la <strong>Gestión de guardias</strong> si se trata de un grupo de alumnos o de una guardia (GU).",
	    container: "body",
	    placement: "left",
	    template: "<div class='popover tour' style='max-width: 600px !important;'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default' data-role='next'>Siguiente »</button><button class='btn btn-primary' data-role='end'>Entendido</button></div></div>",
	    backdrop: true,
	  }
	  <?php endif; ?>
	  ],
	 	});
	 	
	 
	
	// Initialize the tour
	tour.init();
	
	// Start the tour
	tour.start(true);
	</script>
	<?php endif; ?>

</body>
</html>
