<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 'c'));

include("../../menu.php");
include("menu.php");

$crea ="CREATE TABLE IF NOT EXISTS `morosos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `curso` varchar(64) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `ejemplar` varchar(100) NOT NULL,
  `devolucion` varchar(10) NOT NULL,
  `hoy` date NOT NULL ,
  `amonestacion` varchar(2) NOT NULL DEFAULT 'NO',
  `sms` VARCHAR( 2 ) NOT NULL DEFAULT  'NO', 
  PRIMARY KEY (`id`)
) ";
mysqli_query($db_con, $crea);
?>
	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Biblioteca <small>Importación de datos desde Abies</small></h2>
		</div>
	
		<!-- SCAFFOLDING -->
		<div class="row">
	
			<div class="col-sm-12">
				
				
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Prestamos de Ejemplares</a></li>
					<li><a href="#tab2" data-toggle="tab">Catálogo de Fondos</a></li>
					<li><a href="#tab3" data-toggle="tab">Lectores de la Biblioteca</a></li>
					
				</ul>
			
				<br>
				
				<div class="tab-content">
					<div class="tab-pane in active" id="tab1">
						
							<div class="row">
							
								<div class="col-sm-6">
									
									<div class="well">
									
										<form method="post" action="morosos.php" enctype="multipart/form-data">
												
												<fieldset>
													<legend>Préstamos de Ejemplares</legend>
													
													<div class="form-group">
														<label for="archivo">Archivo</label>
														<input type="file" id="archivo" name="archivo">
													</div>
													
													<br>
													
													<button type="submit" class="btn btn-primary" name="enviar">Importar</button>
												
											</fieldset>
											
										</form>
										
									</div><!-- /well -->
								
								</div><!-- /.col-sm-6 -->
								
								
								<div class="col-sm-6">
									
									<h3>Información sobre la importación</h3>
									
									<p>La importación de los Préstamos de ejemplares permite gestionar las Devoluciones de los libros como asuntos de Disciplina (considerar el retraso en la devolución como falta grave, enviar SMS de advertencia, etc.) en <em>Gestión de Préstamos</em>.</p>
									
									<p>El archivo que se solicita es el informe de <b>Préstamos</b> que genera el programa Abies siguiendo los siguientes pasos:
									</p>
									
									<ul>
										<li>En Abies vamos a Préstamos-Informes y una vez en el asistente de creación de informes pulsamos Siguiente.</li>
										<li>Seleccionamos de la lista de campos disponibles los siguientes: Curso, Apellidos, Nombre, Título, Devolución. Pulsamos Siguiente.</li>
										<li>En la siguiente pantalla elegimos "Archivo de Texto (campos delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
										<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
										<li>Finalizamos guardando el documento generado en formato .txt.</li>
									</ul>
								
								</div><!-- /.col-sm-6 -->
							
							</div><!-- /.row -->
					
						</div>
					
					<div class="tab-pane" id="tab2">
					
						<div class="row">
						
							<div class="col-sm-6">
								
								<div class="well">
								
									<form method="post" action="importa_biblio.php" enctype="multipart/form-data">
											
											<fieldset>
												<legend>Catálogo de Fondos</legend>
												
												<div class="form-group">
													<label for="archivo1">Archivo</label>
													<input type="file" id="archivo1" name="archivo1">
												</div>
												
												<br>
												
												<button type="submit" class="btn btn-primary" name="enviar1">Importar</button>
											
										</fieldset>
										
									</form>
									
								</div><!-- /well -->
							
							</div><!-- /.col-sm-6 -->
							
							
							<div class="col-sm-6">
								
								<h3>Información sobre la importación</h3>
								
								<p>La importación de los Fondos de la Biblioteca permite consultar en la Intranet, pero también en la página pública del Centro, los fondos de la Biblioteca del Centro.</p>
								
								<p>El archivo que se solicita es el informe del <b>Catálogo</b> que genera el programa Abies siguiendo los siguientes pasos:</p>
								
								<ul>
									<li>En Abies vamos a Catalogo-Informes y una vez en el asistente de creación de informes pulsamos Siguiente.</li>
									<li>Seleccionamos de la lista de campos disponibles los siguientes: Autor, Titulo, Editorial, ISBN, TipoFondo, anoEdicion, extension, serie, lugaredicion, tipoEjemplar, Ubicacion. Pulsamos Siguiente.</li>
									<li>En la siguiente pantalla elegimos "Archivo de Texto (campos delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
									<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
									<li>Finalizamos guardando el documento generado en formato .txt.</li>
								</ul>
							
							</div><!-- /.col-sm-6 -->
						
						</div><!-- /.row -->
					
					</div>
				
					<div class="tab-pane" id="tab3">
					
						<div class="row">
						
							<div class="col-sm-6">
								
								<div class="well">
								
									<form method="post" action="importa_biblio.php" enctype="multipart/form-data">
											
											<fieldset>
												<legend>Lectores de la Biblioteca</legend>
												
												<div class="form-group">
													<label for="archivo2">Archivo</label>
													<input type="file" id="archivo2" name="archivo2">
												</div>
												
												<br>
												
												<button type="submit" class="btn btn-primary" name="enviar2">Importar</button>
											
										</fieldset>
										
									</form>
									
								</div><!-- /well -->
							
							</div><!-- /.col-sm-6 -->
							
							
							<div class="col-sm-6">
								
								<h3>Información sobre la importación</h3>
								
								<p>La importación de los Lectores permite incorporar el código del alumno en su Carnet, de tal modo que se pueda utilizar el Carnet también en la Biblioteca del Centro.</p>
								
								<p>El archivo que se solicita es el informe de <b>Lectores</b> que genera el programa Abies siguiendo los siguientes pasos:</p>
								
								<ul>
									<li>En Abies vamos a Lectores-Informes y una vez en el asistente de creación de informes pulsamos Siguiente.</li>
									<li>Seleccionamos de la lista de campos disponibles los siguientes: Código, DNI, Apellidos, Nombre, Grupo. Pulsamos Siguiente.</li>
									<li>En la siguiente pantalla elegimos "Archivo de Texto (campos delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
									<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
									<li>Finalizamos guardando el documento generado en formato .txt.</li>
								</ul>
								
								<p>Es importante tener en cuenta que al importar los <b>Lectores de la Biblioteca</b> a la Base de datos, <em><b>el Carnet del Alumno incorporará el Código de la Biblioteca tras el NIE</b></em>. De este modo, se genera un Carnet que es válido también para su uso en la Biblioteca del Centro.</p>
							
							</div><!-- /.col-sm-6 -->
						
						</div><!-- /.row -->
				
					</div>
			
				</div><!-- /.tab-content -->
				
			</div><!-- /.col-sm-12 -->
		
		</div><!-- /.row -->
	
	</div><!-- /.container -->

<?php include('../../pie.php'); ?>

</body>
</html>
