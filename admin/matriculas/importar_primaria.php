<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];


include("../../menu.php");
include("menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Matriculación de alumnos <small>Importación de alumnos/as de Primaria</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" enctype="multipart/form-data" action="../../xml/jefe/alma_primaria.php">
					<fieldset>
						<legend>Importación de alumnos/as de Primaria</legend>
						
					  
					  <div class="form-group">
					    <label for="archivo1">RegAlum.txt</label>
					    <input type="file" name="archivo1" id="archivo1" accept="text/plain">
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="index.php">Cancelar</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
			<h3>Información sobre la importación de datos</h3>
			
			<p>Para contar con los datos de los colegios, los directores de los mismos deben proporcionar el archivo de Séneca RegAlum.txt (lo descargamos desde Séneca: Alumnado --> Alumnado del Centro --> Aceptar (arriba a la derecha) --> Exportar (arriba a la izquierda) --> Exportar datos al formato: Texto plano). Una vez en nuestras manos, le cambiamos el nombre por el del colegio respectivo, y comprimimos todos los archivos en formato .zip. Este es el archivo que debes seleccionar en el formulario.</p>
			
			<p>Hay que tener en cuenta que el módulo de importación supone que el formato de las grupos de los colegios es semejante al de los institutos, por lo que se espera que el nombre sea del tipo 6P-A, 6P-B, etc. Si el colegio no sigue ese criterio, es necesario editar los archivos de Séneca y Buscar/Reemplazar el nombre de las unidades para ajustarlo a los criterios de la Intranet antes de proceder a la importación. También se les puede pedir a los Colegios que normalicen el nombre de los grupos a largo plazo con el nuevo sistema de nombres, considerando los beneficios que derivan del proceso de matriculación de la Intranet.</p>
			
		</div><!-- /.col-sm-6 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
