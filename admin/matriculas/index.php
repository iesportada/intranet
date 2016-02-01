<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 7));


include("../../menu.php");
include("./menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Matriculación de alumnos <small>Alumnado de ESO</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6 col-sm-offset-3">
			
			<div class="well">
				
				<form method="post" action="">
					<fieldset>
						<legend>Información del alumno/a</legend>
						
						<div class="form-group">
					    <label for="curso">Curso</label>
					    <select class="form-control" id="curso" name="curso" onchange="submit()">
					    	<option value=""></option>
					    	<option value="1ESO" <?php echo (isset($curso) && $curso == "1ESO") ? 'selected' : ''; ?>>1º de ESO</option>
					    	<option value="2ESO" <?php echo (isset($curso) && $curso == "2ESO") ? 'selected' : ''; ?>>2º de ESO</option>
					    	<option value="3ESO" <?php echo (isset($curso) && $curso == "3ESO") ? 'selected' : ''; ?>>3º de ESO</option>
					    	<option value="4ESO" <?php echo (isset($curso) && $curso == "4ESO") ? 'selected' : ''; ?>>4º de ESO</option>
					    </select>
					    <p class="help-block">No es necesario si el alumno/a pertenece a nuestro centro o colegio adscrito.</p>
					  </div>
					  
					  <div class="form-group">
					    <label for="claveal">Número de Identificación Escolar</label>
					    <input type="text" class="form-control" name="claveal" id="claveal" placeholder="Número de Identificación Escolar" maxlength="12">
					  </div>
					  
					  <div class="form-group">
					    <label for="dni">DNI/Pasaporte del alumno/a o tutor/a legal</label>
					    <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI/Pasaporte del alumno/a o tutor/a legal" maxlength="12">
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="matricular" formaction="matriculas.php" formtarget="_blank">Matricular</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
