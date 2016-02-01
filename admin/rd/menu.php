<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['edicion'])) {$edicion = $_GET['edicion'];}elseif (isset($_POST['edicion'])) {$edicion = $_POST['edicion'];}else{$edicion="";}
if (isset($_GET['submit'])) {$submit = $_GET['submit'];}elseif (isset($_POST['submit'])) {$submit = $_POST['submit'];}else{$submit="";}
if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}
if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (isset($_GET['contenido'])) {$contenido = $_GET['contenido'];}elseif (isset($_POST['contenido'])) {$contenido = $_POST['contenido'];}else{$contenido="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['actualiza'])) {$actualiza = $_GET['actualiza'];}elseif (isset($_POST['actualiza'])) {$actualiza = $_POST['actualiza'];}else{$actualiza="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}
if (isset($_GET['jefedep'])) {$jefedep = $_GET['jefedep'];}elseif (isset($_POST['jefedep'])) {$jefedep = $_POST['jefedep'];}else{$jefedep="";}
if (isset($_GET['pag'])) {$pag = $_GET['pag'];}elseif (isset($_POST['pag'])) {$pag = $_POST['pag'];}else{$pag="";}
if (isset($_GET['q'])) {$expresion = $_GET['q'];}elseif (isset($_POST['q'])) {$expresion = $_POST['q'];}else{$expresion="";}

$activo1="";
$activo2="";
if (strstr($_SERVER['REQUEST_URI'],'add.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_admin.php')==TRUE) {$activo2 = ' class="active" ';}
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
						<p>Este módulo permite a los Jefes de Departamento crear un documento 
						digital para las Reuniones del mismo, visible tanto por los miembros 
						del Departamento como por el Equipo directivo. Sustituye al método 
						tradicional del Libro de Actas, y puede ser imprimido en caso de 
						necesidad por el Departamento o la Dirección.</p>
						<p>Seleccionamos en primer lugar la fecha de la reunión. Las Actas se 
						numeran automáticamente por lo que no es necesario intervenir manualmente 
						en ese campo. El formulario contiene un texto prefijado con el esquema 
						de cualquier Acta: Departamento, Curso escolar, Nº de Acta, Asistentes etc. 
						El texto comienza con el Orden del día, y continúa con la descripción de 
						los contenidos tratados en la reunión. No es necesario escribir la fecha 
						de la misma (FECHA_DE_LA_REUNIÓN) puesto que se coloca posteriormente con 
						la fecha elegida.</p>
						<p>A la derecha del formulario van apareciendo en su orden las Actas, 
						visibles para todos los miembros del Departamento. El Jefe del Departamento 
						puede editar las Actas <strong>hasta el momento en que se impriman</strong> 
						para entregar al Director: en ese momento el Acta queda bloqueada y sólo 
						puede ser visualizada o imprimida. Al ser imprimida aparece un icono de 
						verificación sustituyendo al icono de edición en la lista de actas. Por 
						esta razón, hay que se muy cuidadoso e imprimir el Acta sólo cuando la misma 
						esté completada.</p>
						<p>Los Administradores de la Intranet (Equipo Directivo, por ejemplo) tiene 
						acceso a una opción, 'Todas las Actas', que les abre una página con todas 
						las Actas de todos los Departamentos. La edición está prohibida, pero pueden 
						verlas e imprimirlas.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
		
	 	<form method="get" action="buscar.php">
			<div class="navbar-search pull-right col-sm-3">
				<div class="input-group">
					<input type="text" class="form-control input-sm" id="q" name="q" maxlength="60" value="<?php echo (isset($_GET['q'])) ? $_GET['q'] : '' ; ?>" placeholder="Buscar...">
 		     		<span class="input-group-btn">
 		      			<button class="btn btn-default btn-sm" type="submit"><span class="fa fa-search fa-lg"></span></button>
 		     		</span>
 		  		 </div><!-- /input-group -->
 		  	</div><!-- /.col-lg-3--> 		 
		</form>  
 	
  	 	<ul class="nav nav-tabs">
 			<li <?php echo $activo1;?>><a href="add.php">Nueva Acta / Lista de Actas</a></li>                 		
 			<?php if (strstr($_SESSION['cargo'],"1") == TRUE): ?>
          	<li <?php echo $activo2; ?>><a href="index_admin.php">Todas las Actas</a></li>
          	<?php endif; ?>
		</ul>
	</div>