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
if (isset($_POST['enviar'])) {
	
	$claveal = $_POST['alumno'];
	$fotografia = $_FILES['foto']['tmp_name'];
	
	if (empty($claveal) || empty($fotografia)) {
		$msg_error = "Todos los campos del formulario son obligatorios.";
	}
	else {
		
		require('../../lib/class.Images.php');
		$image = new Image($fotografia);
		$image->resize(240,320,'crop');
		$image->save($claveal, '../../xml/fotos/', 'jpg');
		
		$file_content = mysqli_real_escape_string($db_con, file_get_contents('../../xml/fotos/'.$claveal.'.jpg'));
		$file_size = filesize('../../xml/fotos/'.$claveal.'.jpg');
		
		// Eliminamos posibles imagenes que hayan en la tabla
		mysqli_query($db_con, "DELETE FROM fotos WHERE nombre='".$claveal.".jpg'");
		
		// Insertamos la foto en la tabla, esto es útil para la página externa
		mysqli_query($db_con, "INSERT fotos (nombre, datos, fecha, tamaño) VALUES ('".$claveal.".jpg', '$file_content', '".date('Y-m-d H:i:s')."', '".$file_size."')");
		
		$msg_success = "La fotografía se ha actualizado.";
	}
	
}


include("../../menu.php");
include("menu.php");
?>
	
	<style type="text/css">
	.img-thumbnail {
		margin-bottom: 5px;
	}
	
	@media print {
		.container {
			width: 100%;
		}
		
		body {
			font-size: 10px;
		}
		
		h2 {
			font-size: 22px;
		}
		
		h4 {
			font-size: 14px;
		}
	}
	</style>
	

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Tutoría de <?php echo $_SESSION['mod_tutoria']['unidad']; ?> <small>Fotografías de los alumnos</small></h2>
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
		<div class="row hidden-print">
		
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-6">
			
				<div class="well">
				
					<form method="post" action="" enctype="multipart/form-data">
						
						<fieldset>
							<legend>Actualizar la fotografía del alumno/a</legend>
							
							<div class="form-group">
								<label for="alumno">Alumno/a</label>
								<?php $result = mysqli_query($db_con, "SELECT claveal, apellidos, nombre FROM alma WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."' ORDER BY apellidos ASC, nombre ASC"); ?>
								<?php if(mysqli_num_rows($result)): ?>
							  <select class="form-control" id="alumno" name="alumno">
							  	<option value=""></option>
							  	<?php while($row = mysqli_fetch_array($result)): ?>
							  	<option value="<?php echo $row['claveal']; ?>"><?php echo $row['apellidos'].', '.$row['nombre']; ?></option>
							  	<?php endwhile; ?>
							  </select>
							  <?php else: ?>
							   <select class="form-control" id="alumno" name="alumno" disabled></select>
							  <?php endif; ?>
							  <?php mysqli_free_result($result); ?>
							</div>
							
							<div class="form-group">
								<label for="foto">Fotografía (formato JPEG)</label>
								<input type="file" id="foto" name="foto" accept="image/jpeg">
							</div>
							
							<button type="submit" class="btn btn-primary" name="enviar">Actualizar</button>
						
						</fieldset>
					
					</form>
				
				</div><!-- /.well -->
			
			</div><!-- /.col-sm-6 -->
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-6">
			
				<h3>Información sobre las fotografías</h3>
				
				<p>Utilizamos esta página para subir las fotos de los alumnos de la Tutoría. Preparamos en primer lugar las fotos que hemos hecho a los alumnos, en formato JPG; seleccionamos un alumno en el desplegable; hacemos click sobre el botón de <em>Seleccionar archivo</em> y elegimos el archivo de foto correspondiente al alumno en cuestion; hacemos click sobre el boton de <em>Actualizar</em>.</p>
				
				<p>La foto debe cumplir la norma especificada:<p>
				 	
				<ul>
					<li>Tener el fondo de un único color, liso y claro.</li>
					<li>La foto ha de ser reciente y tener menos de 6 meses de antigüedad.</li>
					<li>Foto tipo carnet, la imagen no puede estar inclinada, tiene que mostrar la cara claramente de frente.</li>
					<li>Fotografía de cerca que incluya la cabeza y parte superior de los hombros, la cara ocuparía un 70-80% de la fotografía.</li>
					<li>Fotografía perfectamente enfocada y clara.</li>
				</ul>
			
			</div><!-- /.col-sm-6 -->
		
		</div>
		
				
		<div class="row">
			
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-12">

				<?php $result = mysqli_query($db_con, "SELECT claveal, apellidos, nombre FROM alma WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."'"); ?>
				<?php $columnas = 6; ?>
				<?php $fila = 0; ?>
				<?php $num = 0; ?>
				<?php while ($row = mysqli_fetch_array($result)): ?>
				
				<?php if ($num == 0 || (($num % $columnas) == 0)): ?>
				<div class="row">
				<?php $fila++; ?>
				<?php endif; ?>
					
					<?php $foto = '../../xml/fotos/'.$row['claveal'].'.jpg'; ?>
					<?php if (file_exists($foto)): ?>
					<div class="col-sm-2 text-center">
						<img class="img-thumbnail" src="<?php echo $foto; ?>?t=<?php echo time(); ?>" alt="<?php echo $row['apellidos'].', '.$row['nombre']; ?>" width="165">
						<?php echo $row['apellidos'].', '.$row['nombre']; ?>
					</div>
					<?php else: ?>
					<div class="col-sm-2 text-center">
						<div class="img-thumbnail" style="display: block;">
							<br><br><br>
							<span class="fa fa-user fa-5x"></span>
							<br><br><br><br>
						</div>
						<?php echo $row['apellidos'].', '.$row['nombre']; ?>
					</div>
					<?php endif; ?>
				
				<?php $num++; ?>
				
				<?php if (($num % $columnas) == 0): ?>
				</div>
				
				<hr>
				<?php endif; ?>				
				
				<?php endwhile; ?>
				
				<?php echo (mysqli_num_rows($result) < ($columnas * $fila)) ? '</div><hr>' : ''; ?>
				
				
				<div class="hidden-print">
					<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
				</div>

			</div><!-- /.col-sm-12 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
