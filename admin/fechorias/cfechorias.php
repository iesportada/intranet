<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2 style="display:inline;">Problemas de convivencia <small>Consultas</small></h2>
		
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
						<p>Las Consultas de Problemas de Convivencia no tienen ningún campo obligatorio, pero al menos uno 
						de los campos debe contener criterios de búsqueda. Hay campos con criterios de tiempo 
						(<strong>Mes</strong>, <strong>Fecha</strong>); criterios relacionados con un alumno o grupo de 
						alumnos (<strong>Unidad</strong>, <strong>Apellidos</strong>, etc.); o podemos elegir entre criterios 
						relacionados con los <strong>Problemas de Convivencia</strong>.</p>
						<p>Hay que tener en cuenta que los campos de búsqueda se pueden sumar: como regla general, cuanto mayor 
						sea el número de criterios, más reducido será el resultado de la búsqueda.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-8 col-sm-offset-2">
			
			<div class="well">
				
				<form method="POST" action="fechorias.php">
					<fieldset>
						<legend>Criterios de búsqueda</legend>
						
						<div class="row">
							<!-- FORMULARIO COLUMNA IZQUIERDA -->
							<div class="col-sm-7">
							
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="unidad">Unidad</label>
											<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_grupo FROM horw WHERE a_grupo NOT LIKE 'G%' AND a_grupo NOT LIKE '' ORDER BY a_grupo"); ?>
											<?php if(mysqli_num_rows($result)): ?>
											<select class="form-control" name="unidad">
												<option value=""></option>
												<?php while($row = mysqli_fetch_array($result)): ?>
												<option value="<?php echo $row['a_grupo']; ?>"><?php echo $row['a_grupo']; ?></option>
												<?php endwhile; ?>
											</select>
											<?php else: ?>
											<select class="form-control" name="unidad" disabled></select>
											<?php endif; ?>
											<?php mysqli_free_result($result); ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="mes">Mes</label>
											<?php $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'); ?>
											<select class="form-control" name="mes">
												<option value=""></option>
												<?php for ($i = 1; $i <= count($meses); $i++): ?>
												<option value="<?php echo $i; ?>"><?php echo $meses[$i-1]; ?></option>
												<?php endfor; ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
								  <label for="apellido">Apellidos</label>
								  <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellidos" maxlength="60">
								</div>
								
								<div class="form-group">
								  <label for="nombre">Nombre</label>
								  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" maxlength="60">
								</div>
								
							</div>
							
							<!-- FORMULARIO COLUMNA DERECHA -->
							<div class="col-sm-5">
								
								<div class="form-group" id="datetimepicker1">
								  <label for="dia">Fecha</label>
								  <div class="input-group">
								  	<input type="text" class="form-control" name="dia" id="dia" placeholder="Fecha" data-date-format="DD-MM-YYYY">
								  	<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								  </div>
								</div>
								
								<div class="form-group">
									<label for="clase">Otros criterios</label>
									<select class="form-control" id="clase" name="clase[]" multiple size="6">
										<option value="Expulsion del Centro">Expulsión del centro</option>
										<option value="Expulsion del Aula">Expulsión del aula</option>
										<option value="A.T.I.">A.T.I.: Profesor</option>
										<option value="A.T.I. Jefatura">A.T.I.: Jefatura</option>
										<option value="Falta Grave">Falta grave</option>
										<option value="Falta Muy Grave">Falta muy grave</option>
									</select>
								</div>
								
							</div>
							
						</div>
						
					  <button type="submit" class="btn btn-primary" name="submit1">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-8 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  
	</script>
	
</body>
</html>
