<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['alumno'])) {$alumno = $_GET['alumno'];}elseif (isset($_POST['alumno'])) {$alumno = $_POST['alumno'];}else{$alumno="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['tutor'])) {$tutor = $_GET['tutor'];}elseif (isset($_POST['tutor'])) {$tutor = $_POST['tutor'];}else{$tutor="";}
if (isset($_GET['duracion'])) {$duracion = $_GET['duracion'];}elseif (isset($_POST['duracion'])) {$duracion = $_POST['duracion'];}else{$duracion="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['del'])) {$del = $_GET['del'];}elseif (isset($_POST['del'])) {$del = $_POST['del'];}else{$del="";}
if (isset($_GET['todos'])) {$todos = $_GET['todos'];}elseif (isset($_POST['todos'])) {$todos = $_POST['todos'];}else{$todos="";}
if (isset($_GET['id_del'])) {$id_del = $_GET['id_del'];}elseif (isset($_POST['id_del'])) {$id_del = $_POST['id_del'];}else{$id_del="";}
if (isset($_GET['id_alumno'])) {$id_alumno = $_GET['id_alumno'];}elseif (isset($_POST['id_alumno'])) {$id_alumno = $_POST['id_alumno'];}else{$id_alumno="";}
if (isset($_GET['c_asig'])) {$c_asig = $_GET['c_asig'];}elseif (isset($_POST['c_asig'])) {$c_asig = $_POST['c_asig'];}else{$c_asig="";}

$activo1="";
$activo2="";
$activo3="";
$activo5="";
$activo4="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infotut.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'buscar.php')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_buscar.php')==TRUE){ $activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'control.php')==TRUE){ $activo5 = ' class="active" ';}
?>      
    <div class="container hidden-print">
    	
    	<!-- Button trigger modal -->
		<a href="#"class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
			<span class="fa fa-question fa-lg"></span>
		</a>
	
		<!-- Modal -->
		<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modal_ayuda_titulo" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
						<h4 class="modal-title" id="modal_ayuda_titulo">Instrucciones de uso</h4>
					</div>
					<div class="modal-body">
						<p>Los Informes de Tareas son activados por la Jefatura de Estudios cuando 
						un alumno va a ser expulsado del Centro por algún Problema de Convivencia 
						de tipo Grave o Muy Grave; también pueden ser activados por el Tutor cuando 
						un alumno se va a ausentar del Centro un tiempo por motivos diversos 
						(enfermedad, viaje, etc.). Cuando han sido activados mediante el formulario 
						correspondiente (en el que el Tutor selecciona al alumno y las fechas de 
						comienzo y fin de la ausencia o expulsión), los profesores del Equipo 
						Educativo del alumno reciben una solicitud de información para que propongan 
						tareas en su asignatura durante la ausencia del alumno. La notificación a 
						los profesores aparece en la página de inicio de la Intranet, o bien en la 
						página de Informes de Tareas. La notificación desaparece cuando hemos 
						rellenado el Informe o la fecha de regreso ha pasado.</p>
						<p>Una vez recibida la notificación de tareas, el profesor entra en un 
						formulario en el que aparece la asignatura (o asignaturas, en el caso de que 
						el profesor imparta más de una al alumno, o éste tenga una asignatura 
						pendiente de continuidad), escribe sus tareas para el alumno y envía los 
						datos. Los Informes son visibles en todo momento para el resto de los 
						profesores del alumno.</p>
						<p>Cuando el alumno ha regresado, una nueva notificación aparece preguntando 
						a los profesores del mismo si este ha realizado las tareas o no para que el 
						Tutor y Jefatura de Estudios estén informados y determinen las acciones a tomar.</p>
						<p>El módulo contiene la posibilidad de ver la totalidad de los Informes de 
						Tareas a lo largo del Curso Escolar, o bien de buscar entre los Informes los 
						correspondientes a un alumno determinado. Hay que tener en cuenta que, una 
						vez pasada la fecha de regreso del alumno, los Informes de Tareas quedan 
						bloqueados, aunque siguen siendo visibles.</p>
						<p>El Equipo Directivo dispone de una opción, <strong>Control de Informes</strong>, 
						que presenta estadísticas por alumno y profesor sobre los Informes de Tareas.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
    	
		<ul class="nav nav-tabs">
			<li <?php echo $activo1;?>> <a href="index.php">Página de Informes de Tareas</a></li>
			<?php
			if(stristr($_SESSION ['cargo'],'1') == TRUE or stristr($_SESSION ['cargo'],'2') == TRUE)
			{
			if(stristr($_SESSION ['cargo'],'2') == TRUE){
			$tutor = $_SESSION['mod_tutoria']['tutor'];
			}
			?>
			<li <?php echo $activo2;?>><a href="infotut.php?<?php if (isset($_SESSION['mod_tutoria']['unidad'])) {echo  "unidad=".$_SESSION['mod_tutoria']['unidad'];}?>">Activar Nuevo Informe</a></li>
			<?php }?>
			<li <?php echo $activo3;?>> <a href="buscar.php?todos=1">Ver Todos los Informes</a></li>
			<li <?php echo $activo4;?>> <a href="index_buscar.php">Buscar Informes</a></li>
			<?php
			if(stristr($_SESSION ['cargo'],'1') == TRUE){?>
			<li <?php echo $activo5;?>> <a href="control.php">Control de Informes</a></li>
			<?php }?>
		</ul>
		
	</div>      