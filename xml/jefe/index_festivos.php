<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
include("../../menu.php");
?>

	<div class="container">
	
		<div class="page-header">
		  <h2>Administración <small> Días Festivos</small></h2>
		</div>
		
		<div class="row">
			
			<div class="col-sm-6">
				
				<div class="well">
					<form action="festivos.php" method="post" enctype="multipart/form-data">
						
						<fieldset>
							<legend>Días festivos</legend>
							
							<div class="form-group">
								<label class="text-info" for="file">200CalEscCent.txt</label>
								<input type="file" id="file" name="archivo" accept="text/plain">
							</div>
							
							<br>
								
							<button type="submit" class="btn btn-primary" name="enviar">Importar</button>
							<a href="../index.php" class="btn btn-default">Volver</a>
							
						</fieldset>
						
					</form>
				</div><!-- /.well -->
			
			</div><!-- /.col-sm-6 -->
			
			<div class="col-sm-6">
				
				<h3>Información sobre la importación</h3>
				
				<p class="help-block"><span style="color:#9d261d">(*) </span>Si has descargado el archivo <strong>200CalEscCent</strong> de Séneca (desde Séneca --> Centro --> Días festivos), puedes continuar con el segundo paso.</p>
			
			</div><!-- /.col-sm-6 -->
		
		</div><!-- /.row -->
	
	</div>
	
	<?php include("../../pie.php"); ?>

</body>
</html>
