<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];

if (isset($_POST['enviar'])) {
	if (empty($_POST['sustituido'])) {
		$msg_error = "Debe seleccionar el profesor sustituido.";
	}
	elseif (empty($_POST['sustituto'])){
		$msg_error = "Debe seleccionar el profesor sustituto.";
	}
	else{
		$sustituido = $_POST['sustituido'];
		$sustituto = $_POST['sustituto'];
		$ok = 1;
		
		// ACTUALIZACION EN HORARIOS
		$result1 = mysqli_query($db_con, "UPDATE horw SET prof='$sustituto' WHERE prof='$sustituido'");
		if(!$result1) {
			$msg_error = "No se han podido cambiar los datos del horario. Error: ".mysqli_error($db_con);
			$ok = 0;
		}
		
		
		// ACTUALIZACION EN HORARIOS DE FALTAS
		$result2 = mysqli_query($db_con, "UPDATE horw_faltas SET prof='$sustituto' WHERE prof='$sustituido'");
		if(!$result2) {
			$msg_error = "No se han podido cambiar los datos del horario de faltas. Error: ".mysqli_error($db_con);
			$ok = 0;
		}
		
                
                // DEPARTAMENTO Y CARGOS
                $crg = mysqli_query($db_con,"select cargo from departamentos where nombre = '$sustituido'");
                $cargo_sust = mysqli_fetch_array($crg);
		$result6 = mysqli_query($db_con,"update departamentos set cargo = '$cargo_sust[0]' where nombre = '$sustituto'");
		if(!$result6) {
			$msg_error = "No se han podido cambiar los datos de la tabla Departamentos. Error: ".mysqli_error($db_con);
			$ok = 0;
		}
		
		// ACTUALIZACION EN TUTORIAS
		$result3 = mysqli_query($db_con, "UPDATE FTUTORES SET tutor='$sustituto' WHERE tutor='$sustituido'");
		if(!$result3) {
			$msg_error = "No se han podido cambiar los datos de la tabla Departamentos. Error: ".mysqli_error($db_con);
			$ok = 0;
		}
		
		// ACTUALIZACION EN PROFESORES
		$result4 = mysqli_query($db_con, "UPDATE profesores SET profesor='$sustituto' WHERE profesor='$sustituido'");
		if(!$result4) {
			$msg_error = "No se han podido cambiar los datos de la tabla Profesores. Error: ".mysqli_error($db_con);
			$ok = 0;
		}
		
		
		// ACTUALIZACION EN GUARDIAS
		$result5 = mysqli_query($db_con, "UPDATE guardias SET profesor='$sustituto' WHERE profesor='$sustituido'");
		if(!$result5) {
			$msg_error = "No se han podido cambiar los datos de las guardias. Error: ".mysqli_error($db_con);
			$ok = 0;
		}
		
		if($ok==1) $msg_success = "Los datos han sido modificados correctamente.";
		
	}

}

include("../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Copiar datos de un profesor a otro</small></h2>
	</div>
	
	<!-- MENSAJES -->
	<?php if(isset($msg_success)): ?>
	<div class="alert alert-success">
		<?php echo $msg_success; ?>
	</div>
	<?php endif; ?>
	
	<?php if(isset($msg_error)): ?>
	<div class="alert alert-danger">
		<?php echo $msg_error; ?>
	</div>
	<?php endif; ?>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Copiar datos de un profesor a otro</legend>
						
						<div class="form-group">
						  <label for="sustituido">Profesor sustituido</label>
						  <?php $result = mysqli_query($db_con, "SELECT DISTINCT prof FROM horw ORDER BY prof ASC"); ?>
						  <?php if(mysqli_num_rows($result)): ?>
						  <select class="form-control" name="sustituido">
						  	<option value=""></option>
						  	<?php while($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['prof']; ?>"><?php echo $row['prof']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="sustituido" disabled>
						   	<option value=""></option>
						   </select>
						  <?php endif; ?>
						  <?php mysqli_free_result($result); ?>
						</div>
						
						<div class="form-group">
						  <label for="sustituto">Profesor sustituto</label>
						  <?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE nombre NOT LIKE 'admin' AND nombre NOT LIKE 'conserje' AND departamento NOT LIKE 'Administ%' ORDER BY nombre ASC"); ?>
						  <?php if(mysqli_num_rows($result)): ?>
						  <select class="form-control" name="sustituto">
						  	<option value=""></option>
						  	<?php while($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['nombre']; ?>"><?php echo $row['nombre']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" name="sustituto" disabled>
						   	<option value=""></option>
						   </select>
						  <?php endif; ?>
						  <?php mysqli_free_result($result); ?>
						</div>
						
						
					  <button type="submit" class="btn btn-primary" name="enviar">Copiar</button>
					  <a class="btn btn-default" href="../index.php">Volver</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre las sustituciones</h3>
			
			<p>Para copiar los datos de un profesor que se ha dado de baja al profesor que lo sustituye, es necesario en primer lugar copiar el horario de un profesor a otro en Séneca.</p>
			
			<p>A continuación, debes actualizar los Departamentos y los Profesores en la página de Administración de la Intranet. Si ya lo has hecho, en este formulario selecciona el profesor de baja y luego el profesor que lo sustituye, y envía los datos.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
