<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$activo1="";
$activo3="";
$activo4="";
$activo5="";
$activo6="";
$activo7="";
if (strstr($_SERVER['REQUEST_URI'],'importar')==TRUE) {$activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'seneca/index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'faltas/index.php')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'justificar')==TRUE) {$activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'intranet/faltas/index.php')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'admin/faltas/index.php')==TRUE) {$activo6 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'absentismo')==TRUE) {$activo7 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_admin.php')==TRUE) {$activo2 = ' class="active" ';}

?>
<div class="container hidden-print">
	
	<!-- Button trigger modal -->
	<a href="#" class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
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
					<p>El módulo de <b><em>Faltas de Asistencia</em></b> incluye estas funciones: poner faltas; 
					justificarlas (si el cargo es Tutor); consultar las faltas de múltiples maneras; hacer un 
					seguimiento de los Alumnos Absentistas (Tutores, Jefatura, Orientación y Servicios Sociales 
					municipales); subir las faltas de asistencia registradas a Séneca (si utilizamos la 
					aplicación para poner las faltas, una vez al mes se suben a Séneca); y descargar las faltas 
					de asistencia desde Séneca (si no utilizamos la aplicación para poner las faltas pero 
					queremos incorporar las faltas a la Intranet para incluirlas en otros módulos -Informes de 
					alumnos, envío de SMS a las familias, Memoria de Tutoría, Cuaderno del Profesor, etc.).</p>
					
					<h5 style="font-weight: 600;">Poner faltas a los alumnos</h5>
					<p>La página por defecto para poner las faltas es un formulario muy simple (similar a la 
					aplicación <em>iSéneca</em> de la Consejería), pensado para ser utilizado en el tiempo real 
					de trabajo en el aula, pero que también puede ser utilizado en cualquier momento posterior. 
					Se ofrecen tres opciones: Falta No Justificada (F), Falta Justificada (J) o Retraso (R). 
					Está también adaptada para su uso en dispositivos móviles, y aparece en el Menú de iconos 
					específicos de estos dispositivos en la página de inicio de la Intranet.</p>
					
					<p>Si estamos en una aula con alumnos impartiendo una asignatura, el módulo detecta el 
					Grupo(s)/Asignatura y presenta una lista de los alumnos; de lo contrario, selecciona la 
					fecha y luego el Grupo o Grupos de una de tus asignaturas. Aparecerá la lista de tus 
					alumnos y podrás marcar las faltas. Envía las Faltas para guardarlas en la Base de datos. 
					Si el alumno está registrado en ese momento en una Actividad Complementaria o el Tutor 
					del mismo ya ha justificado de antemano la falta de esa hora, no podremos marcar la falta.</p>
					
					<p>Hay un método alternativo para registrar las faltas semanalmente. Si quieres utilizarlo, 
					pulsa en el Menú superior sobre <em><strong>Poner</strong></em> y se abrirá la página. Esta 
					página te presenta un cuadrante con la estructura de tu horario semanal. En cada día y hora 
					en que das clase aparecen los Grupos afectados. Selecciona en primer lugar un día de la 
					semana en la que quieres marcar las faltas. A continuación, escribe el número de aula de los 
					alumnos ausentes seguido de un punto (por ejemplo: 3.12.27.31.) en el campo de texto que 
					se abre bajo cada Grupo. Cuando hayas terminado con una semana envía los datos con el 
					botón (<strong><em>Registrar las faltas de asistencia</em></strong>). Selecciona otra semana 
					y repite el procedimiento.</p>
					
					<h5 style="font-weight: 600;">Consultas</h5>
					<p>El módulo incluye un conjunto de diferentes tipos de consulta que podemos hacer sobre las 
					faltas de asistencia: Faltas de un alumnos, de un Grupo, de una Asignatura, así como consultar 
					que alumnos tienen un determinado número mínimo de faltas en un rango de fechas. Cada 
					formulario de consulta contiene una descripción de su función específica.</p>
					
					<?php if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'2') == TRUE): ?>
					<h5 style="font-weight: 600;">Justificar faltas a los Alumnos</h5>
					<p>Para justificar como Tutor una falta de tu Grupo selecciona en primer lugar un alumno en 
					la columna de la derecha. Una vez el alumno aparece seleccionado elige el mes correspondiente. 
					Aparecerán en rojo las faltas de asistencia del alumno y en verde las faltas justificadas.</p>
					
					<p>Al hacer click sobre una celda del calendario cambiamos su estado: si está vacía se pone 
					roja, si está roja se pone verde, y si está verde la dejamos a cero.</p>
					
					<p>Si la falta no ha sido registrada todavía (el día del calendario no es verde ni rojo), 
					aparecerá un cuadro de diálogo en el que deberás seleccionar las horas en que el alumno ha 
					estado ausente. Una vez marcadas las horas de la falta podrás justificarlas haciendo click 
					de nuevo sobre el día elegido.</p>
					<?php endif; ?> 
					
					<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
					<h5 style="font-weight: 600;">Absentismo</h5>
					<p>El módulo de alumnos absentistas permite hacer un seguimiento de los alumnos con faltas de 
					asistencia frecuentes (Séneca habla de 25 faltas no justificadas al mes). El Equipo directivo 
					selecciona utiliza en primer lugar la Consulta para seleccionar a los alumnos con más de 25
					faltas de asistencia. Los marca de la lista y envía los datos. Una vez registrados, los Tutores 
					de los alumnos, Orientación y Equipo directivo reciben una notificación en la página de entrada 
					de la aplicación, invitándoles a informar sobre el alumno y las razones (o ausencia de las 
					mismas) por las que este falta a sus clases. El Equipo directivo puede añadir también 
					información proporcionada por los Servicio de Asistencia Social del Ayuntamiento.</p>
					
					<h5 style="font-weight: 600;">Administración</h5>
					<p>Las Faltas de asistencia registradas en la Intranet pueden subirse a Séneca. El enlace nos 
					lleva a una página desde la que procedemos a generar el archivo que posteriormente importamos 
					a Séneca. La página contiene información sobre la forma de hacerlo.</p>
					
					<p>Si no utilizamos la Intranet para poner las faltas, todavía podemos beneficiarnos de contar 
					con las faltas descargándolas desde Séneca e incorporándolas a la aplicación. Son muchos los 
					módulos que incluyen información sobre las faltas de asistencia, y de este modo podemos 
					suministrarles los datos necesarios. El enlace nos presenta una página para importar las faltas 
					de Séneca con la información necesaria para proceder.</p>
					
					<p>El <strong><em>Informe de Faltas para Padres</em></strong> presenta las cartas en formato 
					PDF que se envían a las familias con las faltas del alumno, preparadas para imprimir, cuando 
					proceda y por la razón que proceda. Presenta información sobre los días en que el alumno ha 
					faltado al Centro, así como la normativa correspondiente.</p>
					
					<p>Si utilizamos el servicio de SMS interno de la aplicación aparecerá también 
					<strong><em>SMS de Faltas para Padres</em></strong>. Nos permite hacer un envío masivo de SMS 
					a los padres de los alumnos de un determinado Nivel. Un alumno entra en la lista de envío cuando 
					tiene más de 5 faltas de asistencia sin justificar en el periodo seleccionado.</p>
					
					<p>Los <strong><em>Partes de Faltas</em></strong> ofrecen una lista completa de los partes de 
					asistencia que se dejan en el aula para que firme y registre las faltas el profesor, si se 
					sigue este método de control de la asistencia de los alumnos. El documento PDF se presenta 
					en formato diario o semanal.</p>
					
					<p><strong><em>Horario de faltas para profesores</em></strong> crea los horarios que los 
					profesores necesitan para registrar las faltas de asistencia de los alumnos. Cada profesor 
					marca en su horario el número de clase de los alumnos ausentes en una semana, y, o bien las 
					registra posteriormente en el módulo de <strong><em>Poner faltas</em></strong>, o bien lo 
					entrega para quelos Tutores de Faltas lo hagan.</p>
					<?php endif; ?> 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
				</div>
			</div>
		</div>
	</div>
	

	<ul class="nav nav-tabs">
	<?php
	if(stristr($_SESSION['cargo'],'3') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE)
	{
		?>
		<li <?php echo $activo3;?>><a
			href="//<?php echo $config['dominio']; ?>/intranet/faltas/poner2/index.php">
		Poner</a></li>
		<?php
	} else {
		?>
		<li <?php echo $activo3;?>><a
			href="//<?php echo $config['dominio']; ?>/intranet/faltas/index.php">
		Poner</a></li>
		<?php
	}
	?>
	
	<?php
	if(stristr($_SESSION['cargo'],'2') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	{
		?>
		<li <?php echo $activo5;?>><a
			href="//<?php echo $config['dominio']; ?>/intranet/faltas/justificar/index.php">
		Justificar</a></li>
		<?php
	}
	?>
		<li <?php echo $activo6;?>><a
			href="//<?php echo $config['dominio']; ?>/intranet/admin/faltas/index.php">
		Consultar</a></li>
		<?php
		if(stristr($_SESSION['cargo'],'2') == TRUE)
		{
			?>
		<li <?php echo $activo7;?>><a
			href="//<?php echo $config['dominio']; ?>/intranet/admin/tutoria/consulta_absentismo.php">
		Alumnos Absentistas</a></li>
		<?php
		}
		?>
		<?php
		if(stristr($_SESSION['cargo'],'1') == TRUE)
		{
			?>
		<li <?php echo $activo7;?>><a
			href="//<?php echo $config['dominio']; ?>/intranet/faltas/absentismo/index.php">
		Alumnos Absentistas</a></li>
	
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"
			href="#"> Administración <span class="caret"></span> </a>
		<ul class="dropdown-menu" role="menu">
			<li <?php echo $activo1;?>><a href="//<?php echo $config['dominio']; ?>/intranet/faltas/seneca/index.php"> Subir Faltas a S&eacute;neca</a></li>
			<li <?php echo $activo4;?>><a href="//<?php echo $config['dominio']; ?>/intranet/faltas/seneca/importarSeneca.php">Descargar Faltas de Séneca</a></li>
			<hr>
			<li><a href="//<?php echo $config['dominio']; ?>/intranet/admin/cursos/horariototal_faltas.php" target="_blank">Parte de faltas completo (por días)</a></li>
			<li><a href="//<?php echo $config['dominio']; ?>/intranet/admin/faltas/horario_semanal.php" target="_blank">Parte de faltas completo (semanal)</a></li>
			<li><a href="//<?php echo $config['dominio']; ?>/intranet/admin/faltas/horario_semanal_div.php" target="_blank">Parte de faltas completo Diversificación</a></li>
			<li><a href="//<?php echo $config['dominio']; ?>/intranet/admin/cursos/horariofaltas.php">Horario de Faltas para Profesores</a></li>
			<hr>
			<?php if ($config['mod_sms']) {?>
			<li><a href="//<?php echo $config['dominio']; ?>/intranet/sms/sms_cpadres.php">SMS de Faltas para Padres</a></li>
			<?}?>
			<li><a href="//<?php echo $config['dominio']; ?>/intranet/admin/faltas/cpadres.php">Informe de Faltas para
			Padres</a></li>
			<hr>
			<li><a href="//<?php echo $config['dominio']; ?>/intranet/admin/faltas/profesores.php">Profesores y Registro de Faltas</a></li>
		</ul>
		</li>
		<?php
		}
		?>
	</ul>
	
</div>

<?php
// Comprobación de Festivos
$festivos="";
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
{
	$repe0=mysqli_query($db_con, "select fecha from festivos");
	if (mysqli_num_rows($repe0)<'1') {
		$festivos='actualizar';
	}

	$repe=mysqli_query($db_con, "select fecha from festivos where date(fecha) < date('".$config['curso_inicio']."')");
	if (mysqli_num_rows($repe) > '0') {
		$festivos='actualizar';
	}
}

if($festivos == 'actualizar'){
	echo '<br /><div align="center"><a href="../xml/jefe/index_festivos.php"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
		<legend>Atenci&oacute;n:</legend>
No se han importado los <strong>Días festivos </strong>de este Curso Escolar en la Base de datos.</span> Hazlo antes de comenzar a utilizar la aplicación de Faltas de asistencia, o tendrás problemas para exportar posteriormente los datos a Séneca. Haz click para proceder a la importación de las fechas.
	</div></a></div>';	
}
?>