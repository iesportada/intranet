<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administraci�n <small>Depuraci�n de horarios</small></h2>
	</div>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6 col-sm-offset-3">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="limpia_hor.php">
					<fieldset>
						<legend>Depuraci�n de horarios</legend>
						
						<p class="help-block">La depuraci�n del horario se debe realizar cuando los horarios de los profesores se encuentran en S�neca y han sido completamente revisados. Si consideras que ya no caben m�s cambios en los horarios, comienza actualizando los profesores con el archivo RelPerCen.txt de S�neca. Una vez actualizados los profesores, puedes proceder a ejecutar esta funci�n, la cual eliminar� los elementos del horario generado por Horw que ya no son necesarios.</p>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Depurar horarios</button>
					  <a class="btn btn-default" href="../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
