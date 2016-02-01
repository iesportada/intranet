<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Funciones, configuración, importación de datos,...</small></h2>
	</div>
	
	
	<div class="row">
		
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-4">
		
			<div class="well">
			<?php include("menu.php");?>
			</div>
			
		</div><!-- /.col-sm-4 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-8">
			
			<h3>Descripción de los módulos e instrucciones.</h3>
			
			<div class="text-justify">
			<p>	
			Esta es la pagina de Administración de la Intranet y de las Bases de Datos de la misma. A continuación siguen algunas explicaciones sobre la mayoría de los módulos de gestión.</p>
			<hr>
			<p>El <strong>primer grupo de opciones (<span class="text-info">Configuración</span>)</strong> permite editar y modificar los datos de la configuración que se crearon cuando se instaló la Intranet por primera vez (cambiar información del Centro o de la Base de datos, seleccionar módulos activos en la aplicación, entra en modo Mantenimiento, etc.).</p> 
			
			<hr>
			<p>	
			El <strong>segundo grupo de opciones (<span class="text-info">A Principio de curso...</span>)</strong> crea las tablas principales: Alumnos, Profesores, Asignaturas, Calificaciones y Horarios. Hay que tener a mano varios archivos que descargamos de Seneca y los programas generadores de horarios. </p>
			<ul>
			<li>Los <span class="text-info">Datos generales del Centro</span>. Este módulo se encarga de importar la relación de <strong>cursos</strong> y <strong>unidades</strong> del Centro registrados en Séneca, así como la relación de <strong>materias</strong> que se imparten y <strong>actividades</strong> del personal docente. Se importará también la relación de <strong>dependencias</strong>, que se utilizará para realizar reservas de aulas o consultar el horario de las mismas.</li>
			<li>Los <span class="text-info">Alumnos, Asignaturas y Sistemas de Calificaciones</span> se crean una sola vez a comienzo de curso, aunque luego podemos actualizarlos cuando queramos. En este proceso se crean las tablas de Alumnos y se les asigna un número de aula. También se generan dos archivos preparados para el Alta masiva de Alumnos y Profesores en Gesuser y en Moodle (los coloca en intranet/xml/jefe/TIC/), así como la tabla de Alumnos con asignaturas pendientes. Necesitamos dos archivos de Séneca: 
			<ul>
			  <li>Los <span class="text-info">Datos generales del Centro</span>. Este módulo se encarga de importar la relación de <strong>cursos</strong> y <strong>unidades</strong> del Centro registrados en Séneca, así como la relación de <strong>materias</strong> que se imparten y <strong>actividades</strong> del personal docente. Se importará también la relación de <strong>dependencias</strong>, que se utilizará para realizar reservas de aulas o consultar el horario de las mismas.</li><li>el de los alumnos. Lo descargamos desde Séneca. Alumnado --&gt; Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano. El archivo que se descarga se llama RelPerCen.txt</li>
			  <li>el de las evaluaciones. Se descarga de Seneca desde &quot;Intercambio de Información --&gt; Exportación desde Seneca --&gt; Exportación de Calificaciones&quot;. Arriba a la derecha hay un icono para crear un nuevo documento con los datos de las evaluaciones; seleccionar todos los grupos del Centro para una evaluación (la primera vale, por ejemplo) y añadirlos a la lista. Cuando hayáis terminado, pulsad en el icono de confirmación y al cabo de un minuto volved a la página de exportación de calificaciones y veréis que se ha generado un archivo comprimido que podéis descargar. </li>
			</ul>
			</li>
			<li><span class="text-info">Los Profesores y Departamentos</span>. Se descarga desde Séneca --&gt; Personal --&gt; Personal del centro  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.</li>
			<li><span class="text-info">Los Horarios</span>. Este es el único archivo que no se descarga de Séneca, sino de los Programas generadores de Horarios. Requiere el archivo con extensión XML que se genera con el programa generador de horarios para subir los datos del Horario a Séneca. Este módulo también se encarga de preparar el archivo para exportar a Séneca que crean los programas de Horarios (Horw, etc.), evitando tener que registrar manualmente los horarios de cada profesor. La adaptación que realiza este módulo es conveniente, ya que la compatibilidad con Séneca de los generadores de horarios tiene limitaciones (Código único de las asignaturas de Bachillerato, Diversificación, etc.). Es necesario tener a mano el archivo en formato XML que se exporta desde Horw o cualquier otro generador de Horarios. La Intranet puede funcionar sin horarios, pero sus funciones quedan muy limitadas. Por esta razón conviene hacer lo posible por importar un horario dentro de la aplicación. En caso de no poder hacerlo, todavía nos queda la posibilidad de crear el horario dentro de la aplicación con el módulo Profesores --&gt; Modificar / Crear Horarios.</li>			  
			<li><span class="text-info">Los Profesores, Unidades y Materias </span>. Se descarga desde Séneca --&gt; Personal --&gt; Personal del centro --&gt; Unidades y Materias  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.
			</li>
			<li>Los <span class="text-info">Días Festivos</span> deben importarse incluso si no contamos con horario, porque varios módulos de la misma (Calendario, etc.) dependen de los datos.
			</li>
			<li><span class="text-info">Modificar ROF</span> permite ajustar la lista y tipo de Problemas de Convivencia al Reglamento de Organización y Funcionamiento que está en vigor en nuestro Centro. </li>
			<li>La última opción, <span class="text-info">Limpiar Horarios</span>, se debe ejecutar cuando los cambios en los horarios se han dado por terminados y estos se encuentran en perfecto estado en Séneca. Supone que hemos actualizado en primer lugar los profesores.</li>			
			</ul>
			</p>
			<hr>
			<p>
			    El <strong>tercer grupo (<span class="text-info">Actualización</span>)</strong> permite actualizar los datos de Alumnos, Asignaturas, Profesores y Departamentos del Centro. Esta pensado para la actualización de los alumnos que se van matriculando a lo largo del Curso, así como para la puesta al día de la lista de Profesores y Departamentos. Los archivos requeridos son los mismos que hemos mencionado más arriba.</p>
			    <hr>
			    <p>
			El <strong>cuarto grupo de opciones</strong> afecta a los <strong><span class="text-info">Profesores</span></strong>.<br> 
			 Una vez se han creado los Departamentos y Profesores, es necesario seleccionar los <span class="text-info">Perfiles de los Profesores</span> para que la aplicación se ajuste a las funciones propias de cada profesor ( Tutor, Dirección, Jefe de Departamento, etc. ). <br>
			 También desde aquí se puede <span class="text-info">Restablecer las contraseñas</span> de los profesores que se hayan olvidado de la misma. Al restablecerla, el profesor deberá entrar de nuevo con el DNI como contraseña, lo que le llevará a la página desde la que tendrá que cambiarla con los criterios de Séneca. <br>
			 <span class="text-info">Sustitución de profesores</span> cambia los datos de un profesor que ha sido sustituido por los datos del profesor que lo sustituye, de tal manera que el nuevo profesor pueda entrar en la Intranet con los datos heredados del profesor sustituido.<br>
			 Podemos también <span class="text-info">Gestionar los Departamentos</span>, editar sus nombres, unirlos, y asignar profesores a los mismos. Es conveniente hacerlo a principio de curso.<br>
			 <span class="text-info">Subir fotos</span> nos permite realizar una descarga masiva de fotos de los profesores a la Intranet. Se comprimen todas las fotos en un archivo con la extensión <em>ZIP</em>. El nombre de la foto de un profesor se construye a partir del usuario IdEA ( <em>mgargon732.jpg</em>, por ejemplo). Si nuestro Servidor no permite subir un archivo de tanto tamaño, podemos crear varios archivos comprimidos más pequeños y subirlos uno a uno.<br>
			 <span class="text-info">Informe de accesos</span> ofrece información sobre el uso de la Intranet por parte de los Profesores.
			 </p>
			 <hr>
			 		 
			<p>El <strong>quinto grupo <span class="text-info">(Alumnos)</span></strong> toca asuntos varios relacionados con los mismos. </p>
			<ul>
			 <li><span class="text-info">Las Listas de Grupos</span>. Supone que se han realizado todas las tareas anteriores (Horario, Profesores, Alumnos, etc.). Presenta la lista de todos los Grupos del Centro en formato PDF, preparada para ser imprimida y entregada a los Profesores a principios de Curso. </li>
			<li><span class="text-info">Carnet de los Alumnos</span> genera los carnet de los alumnos del Centro preparados para ser imprimidos. Este módulo supone que se han subido las fotos de los alumnos a la intranet utilizando el enlace <span class="text-info">Subir fotos de alumnos</span>, a continuación.</li>
			<li><span class="text-info">Subir fotos de alumnos</span> permite hacer una subida en bloque de todas las fotos de los alumnos para sean utilizadas por los distintos módulos de la Intranet. Para ello, necesitaremos crear un archivo comprimido ( .zip ) con todos los archivos de fotos de los alumnos. Cada archivo de foto tiene como nombre el NIE de Séneca (el Número de Identificación que Séneca asigna a cada alumno ) seguido de la extensión <em>.jpg</em> o <em>.jpeg</em>. El nombre típico de un archivo de foto quedaría por ejemplo así: <em>1526530.jpg</em>. </li>
			  <li><span class="text-info">Libros de Texto gratuitos</span> es un conjunto de páginas pensadas para registrar el estado de los libros de cada alumno dentro del Programa de Ayudas al Estudio de la Junta, e imprimir los certificados correspondientes (incluidas las facturas en caso de mal estado o pérdida del material).</li>
			    <li><span class="text-info">Matriculación de alumnos</span> es un módulo que permite matricular a los alumnos a través de la intranet o, en su caso, a través de internet (si el módulo se ha incorporado a la página principal del Centro). Los tutores, a final de curso, ayudan a los alumnos a matricularse en una sesión de tutoría. Posteriormente el Centro imprime los formularios de la matrícula y se los entregan a los alumnos para ser firmados por sus padres y entregados de nuevo en el IES. El Equipo directivo cuenta entonces con la ventaja de poder administrar los datos fácilmente para formar los grupos de acuerdo a una gran variedad de criterios. El módulo incluye una página que realiza previsiones de matriculación de alumnos en las distintas evaluaciones.</li> 
			   <li> <span class="text-info">Informe de accesos</span> ofrece información sobre el uso del <em><b>Acceso para Alumnos</b></em> de la <b>Página pública del Centro</b> por parte de los Alumnos y sus Padres. Supone que la <em>Página del Centro</em> o su módulo de <em>Acceso para Alumnos</em> está operativa. La Página del Centro puede ser descargada desde <a href="https://github.com/IESMonterroso/pagina_centros" target="_blank">GitHub</a>. Posteriormente debemos leer el archivo README con información sobre la misma y editar el archivo de configuración (<em>conf_principal.php</em>) para ajustarlo a nuestro Centro.</li>
			    </ul>
			<hr>
			
			<p>El <strong>sexto grupo (<span class="text-info">Notas de Evaluación</span>)</strong> crea y actualiza la tabla de las Notas de Evaluación que aparecen en los Informes de la Intranet, pero también presenta las Calificaciones del alumno en la pagina principal. Los archivos necesarios se descargan de Séneca desde &quot;Intercambio de Información --&gt; Exportación desde Seneca --&gt; Exportación de Calificaciones&quot;.</p>
			<hr>
			
			<p>El <strong>séptimo grupo (<span class="text-info">Centro TIC</span>)</strong> proporciona los archivos de importación de usuarios alumnos y profesores para las plataformas Gesuser (creación de perfiles de usuario de los ordenadores portátiles con Guadalinex) y Moodle (Plataforma educativa propia del centro o de la Junta de Andalucía).</p>
			<hr>
			
			<p>El <strong>octavo grupo (<span class="text-info">Sistema de Reservas</span>)</strong> ofrece la posibilidad de gestionar el módulo de Reservas contenido en la aplicación (crear categorías, y dentro de estas Elementos para reservar).</p>
			<hr>
			
			<p>El <strong>noveno grupo (<span class="text-info">Base de datos</span></strong>) permite realizar copias de seguridad de las bases de datos que contienen los datos esenciales de la Intranet. La copia de seguridad crea un archivo, comprimido o en formato texto (SQL), en un directorio de la aplicación ( /intranet/xml/jefe/copia_db/ ). Esta copia puede ser descargada una vez creada. También podemos restaurar la copia de seguridad seleccionando el archivo que hemos creado anteriormente. 
			<br>Si el Centro ha tenido la aplicación funcionando durante varios cursos escolares, la opción <strong>Bases de datos de Cursos anteriores</strong> nos ofrece la posibilidad de incorporarlas a la Intranet. De este modo, podemos acceder a los datos de los alumnos a lo largo de los últimos años, especialmente en los <em>Informes de un Alumno</em>, o en el <em>Informe histórico del alumno</em> cuando vemos los <em>Datos de los alumnos</em>.</p>
			
		</div><!-- /.col-sm-8 -->
		
	</div><!-- /.col-sm-8 -->
		
	</div><!-- /.row-->

</div><!-- /.container -->


<?php include("../pie.php");?>  
</body>
</html>
