<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2, 8));

// COMPROBAMOS SI ES EL TUTOR, SINO ES DEL EQ. DIRECTIVO U ORIENTADOR
if (stristr($_SESSION['cargo'],'2') == TRUE) {
	
	$_SESSION['mod_tutoria']['tutor']  = $_SESSION['mod_tutoria']['tutor'];
	$_SESSION['mod_tutoria']['unidad'] = $_SESSION['mod_tutoria']['unidad'];
	
}
else {

	if(isset($_POST['tutor'])) {
		$exp_tutor = explode('==>', $_POST['tutor']);
		$_SESSION['mod_tutoria']['tutor'] = trim($exp_tutor[0]);
		$_SESSION['mod_tutoria']['unidad'] = trim($exp_tutor[1]);
	}
	else{
		if (!isset($_SESSION['mod_tutoria'])) {
			header('Location:'.'tutores.php');
		}
	}
	
}


// ENVIO DEL FORMULARIO
if (isset($_POST['submit'])) {

	$texto = $_POST['texto'];
	$claveal = $_POST['claveal'];
	$mes = $_POST['mes'];
	
	if (empty($texto) || empty($claveal) || empty($mes)) {
		$msg_error = "Todos los campos del formulario son obligatorios.";
	}
	else {
		$result = mysqli_query($db_con, "UPDATE absentismo SET tutoria='$texto' WHERE claveal='$claveal' AND mes='$mes'")	;
		
		if (!$result) $msg_error = "El informe de absentismo no ha sido enviado. Error: ".mysqli_error($db_con);
		$msg_success = "El informe de absentismo ha sido enviado.";
	}
	
}


include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Tutoría de <?php echo $_SESSION['mod_tutoria']['unidad']; ?> <small>Alumnos/as absentistas</small></h2>
			<h4 class="text-info">Tutor/a: <?php echo nomprofesor($_SESSION['mod_tutoria']['tutor']); ?></h4>
		</div>
		
		<!-- MENSAJES -->
		<?php if(isset($msg_error)): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		<?php if(isset($msg_success)): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		
		<!-- SCAFFOLDING -->			
		<div class="row">
			
			<?php $result = mysqli_query($db_con, "SELECT absentismo.claveal, apellidos, nombre, absentismo.unidad, alma.matriculas, numero, mes, jefatura, orientacion, tutoria FROM absentismo, alma WHERE alma.claveal = absentismo.claveal AND absentismo.unidad='".$_SESSION['mod_tutoria']['unidad']."' ORDER BY mes ASC"); ?>
			<?php if (mysqli_num_rows($result)): ?>
			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-6">
				
				<h3>Informes de absentismo</h3>
				
				<table class="table table-bordered table-striped">
					<thead>
						<th>Alumno</th>
						<th>Mes</th>
						<th>Total faltas</th>
						<th>&nbsp;</th>
					</thead>
					<tbody>
					<?php while ($row = mysqli_fetch_array($result)): ?>
						<tr>
							<td><?php echo $row['nombre'].' '.$row['apellidos']; ?></td>
							<td><?php echo $row['mes']; ?></td>
							<td><?php echo $row['numero']; ?></td>
							<td>
								<a href="consulta_absentismo.php?claveal=<?php echo $row['claveal']; ?>&mes=<?php echo $row['mes']; ?>&inf=1"><span class="fa fa-pencil fa-fw fa-lg" data-bs="tooltip" title="Rellenar"></span></a>
							</td>
						</tr>
					<?php endwhile; ?>
					</tbody>
				</table>
				
			</div><!-- /.col-sm-6 -->
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-6">
				
				<?php if (isset($_GET['inf']) && isset($_GET['claveal']) && isset($_GET['mes'])): ?>
				<?php $result = mysqli_query($db_con, "SELECT distinct apellidos, nombre, absentismo.unidad, alma.matriculas, numero, jefatura, orientacion, tutoria FROM absentismo, alma WHERE alma.claveal = absentismo.claveal and absentismo.claveal='".$_GET['claveal']."' AND mes='".$_GET['mes']."'"); ?>
				
				<?php if (mysqli_num_rows($result)): ?>
				<?php $row = mysqli_fetch_array($result); ?>
				<div class="well">
				
					<form method="post" action="">
					
						<fieldset>
							<legend>Informe de absentismo de <?php echo $row['nombre'].' '.$row['apellidos']; ?></legend>
							
							<input type="hidden" name="claveal" value="<?php echo $_GET['claveal']; ?>">
							<input type="hidden" name="mes" value="<?php echo $_GET['mes']; ?>">
							
							<div class="form-group">
								<label for="texto">Observaciones del tutor/a</label>
								<textarea class="form-control" id="texto" name="texto" rows="7"><?php echo ($row['tutoria'] != '') ? $row['tutoria'] : ''; ?></textarea>
							</div>
							
							<div class="form-group">
								<label for="texto_jefe">Observaciones de Jefatura de estudios</label>
								<textarea class="form-control" id="texto_jefe" name="texto_jefe" rows="7" readonly><?php echo ($row['jefatura'] != '') ? $row['jefatura'] : ''; ?></textarea>
							</div>
							
							<div class="form-group">
								<label for="texto_orienta">Observaciones de Orientación</label>
								<textarea class="form-control" id="texto_orienta" name="texto_orienta" rows="7" readonly><?php echo ($row['orientacion'] != '') ? $row['orientacion'] : ''; ?></textarea>
							</div>
							
							<input type="submit" name="submit" value="Enviar Informe" class="btn btn-primary">
							
						</fieldset>
					
					</form>
				
				</div><!-- /.well -->
				<?php endif; ?>
				<?php endif; ?>
				
			</div><!-- /.col-sm-6 -->
			
			<?php else: ?>
			<div class="col-sm-12">
			
			<h3>No hay alumnos absentistas en esta unidad.</h3>
			
			</div>
			<?php endif; ?>
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
