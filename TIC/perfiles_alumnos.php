<?php
require('../bootstrap.php');


if (isset($_POST['profe'])) $profe = $_POST['profe'];
if (isset($_POST['curso'])) $curso = $_POST['curso'];


include("../menu.php");
include("menu.php");
?>

<?php
if(isset($_POST['enviar'])) :
$exp_unidad = explode('-->',$curso);
$unidad = $exp_unidad[0];
$asignatura = $exp_unidad[3];
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Centro TIC <small>Perfiles de alumnos de <?php echo $unidad; ?></small></h2>
		</div>
		
		<div class="alert alert-info hidden-print">
			<h4>Cambio de contraseña</h4>
			Los alumnos/as podrán cambiar su contraseña de acceso accediendo a la página web <a href="http://c0/gesuser/" class="alert-link" target="_blank">http://c0/gesuser/</a> desde la red local del centro. En caso de olvido deben ponerse en contacto con el Coordinador TIC para restablecer la contraseña.
		</div>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-8 col-sm-offset-2">
				
				<div class="table-responsive">	
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Alumno/a</th>
								<th>Usuario</th>
								<th>Contraseña</th>
							</tr>
						</thead>
						<tbody>
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT usuarioalumno.nombre, usuarioalumno.usuario, usuarioalumno.unidad, FALUMNOS.nombre, FALUMNOS.apellidos, usuarioalumno.pass, FALUMNOS.claveal FROM usuarioalumno, FALUMNOS, alma WHERE FALUMNOS.claveal = alma.claveal AND FALUMNOS.claveal = usuarioalumno.claveal AND usuarioalumno.unidad = '$unidad' AND combasi LIKE '%$asignatura%'ORDER BY nc ASC"); ?>
							<?php while ($row = mysqli_fetch_array($result)): ?>
							<tr>
								<td><?php echo $row['apellidos'].', '.$row['nombre']; ?></td>
								<td><?php echo $row['usuario']; ?></td>
								<td><?php echo $row['pass']; ?></td>
							</tr>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</tbody>
					</table>
				</div>
				
				<div class="hidden-print">
					<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
					<a href="perfiles_alumnos.php" class="btn btn-default">Volver</a>
				</div>
					
				
			</div><!-- /.col-sm-6 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php else: ?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Centro TIC <small>Perfiles de alumnos</small></h2>
		</div>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-6 col-sm-offset-3">
				
				<div class="well">
					
					<form method="post" action="">
						<fieldset>
							<legend>Perfiles de alumnos</legend>
							
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<div class="form-group">
						    <label for="profe">Profesor</label>
						    <?php $result = mysqli_query($db_con, "SELECT DISTINCT PROFESOR FROM profesores ORDER BY PROFESOR ASC"); ?>
						    <?php if(mysqli_num_rows($result)): ?>
						    <select class="form-control" id="profe" name="profe" onchange="submit()">
						    <option></option>
							    <?php while($row = mysqli_fetch_array($result)): ?>
							    <option value="<?php echo $row['PROFESOR']; ?>" <?php echo (isset($profe) && $profe == $row['PROFESOR']) ? 'selected' : ''; ?>><?php echo $row['PROFESOR']; ?></option>
							    <?php endwhile; ?>
							    <?php mysqli_free_result($result); ?>
							   </select>
							   <?php else: ?>
							   <select class="form-control" id="profe" name="profe" disabled>
							   	<option value=""></option>
							   </select>
							   <?php endif; ?>
						  </div>
						  <?php else: ?>
						  <?php $profe = $_SESSION['profi']; ?>
						  <?php endif; ?>
						  
						  <div class="form-group">
						    <label for="curso">Unidad (Asignatura)</label>
						    
						    <?php 
						    $result = mysqli_query($db_con, "SELECT DISTINCT GRUPO, MATERIA, NIVEL, codigo FROM profesores, asignaturas WHERE materia = nombre AND abrev NOT LIKE '%\_%' AND PROFESOR = '$profe' AND nivel = curso ORDER BY grupo ASC"); ?>
						    <?php if(mysqli_num_rows($result)): ?>
						    <select class="form-control" id="curso" name="curso">
						      <?php while($row = mysqli_fetch_array($result)): ?>
						      <?php $key = $row['GRUPO'].'-->'.$row['MATERIA'].'-->'.$row['NIVEL'].'-->'.$row['codigo']; ?>
						      <option value="<?php echo $key; ?>" <?php echo (isset($curso) && $curso == $key) ? 'selected' : ''; ?>><?php echo $row['GRUPO'].' ('.$row['MATERIA'].')'; ?></option>
						      <?php endwhile; ?>
						      <?php mysqli_free_result($result); ?>
						     </select>
						     <?php else: ?>
						     <select class="form-control" id="profesor" name="profesor" disabled>
						     	<option value=""></option>
						     </select>
						     <?php endif; ?>
						  </div>
						  
						  <button type="submit" class="btn btn-primary" name="enviar">Consultar</button>
					  </fieldset>
					</form>
					
				</div><!-- /.well -->
				
			</div><!-- /.col-sm-6 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
<?php endif; ?>
  
<?php include("../pie.php"); ?>

</body>
</html>
