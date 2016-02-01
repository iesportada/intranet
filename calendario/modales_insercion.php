<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<!-- MODAL NUEVO CALENDARIO -->
<form id="formNuevoCalendario" method="post" action="post/nuevoCalendario.php?mes=<?php echo $mes; ?>&anio=<?php echo $anio; ?>" data-toggle="validator">
	<div id="modalNuevoCalendario" class="modal fade">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Nuevo calendario</h4>
	      </div>
	      <div class="modal-body">
        
        	<fieldset>
        		
        		<div class="form-group">
        			<label for="cmp_calendario_nombre" class="visible-xs">Nombre</label>
        			<input type="text" class="form-control" id="cmp_calendario_nombre" name="cmp_calendario_nombre" placeholder="Nombre del calendario" maxlength="30" required autofocus>
        		</div>
        		
        		<div class="form-group" id="colorpicker1">
        			<label for="cmp_calendario_color">Color</label>
        			<div class="input-group">
        				<input type="text" class="form-control" id="cmp_calendario_color" name="cmp_calendario_color" value="<?php echo randomColor(); ?>" required>
        				<span class="input-group-addon"><i></i></span>
        			</div>
        		</div>
        		
        		<?php if (stristr($_SESSION['cargo'],'1')): ?>
        		<div class="checkbox">
        		   <label>
        		     <input type="checkbox" id="cmp_calendario_publico" name="cmp_calendario_publico"> Hacer público este calendario.<br>
        		     <small class="text-muted">Será visible por todos los profesores del centro. Solo el Equipo directivo puede crear y editar eventos en este calendario.</small>
        		   </label>
        		</div>
        		<?php endif; ?>
        				        		
        	</fieldset>
        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Crear</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</form>
<!-- FIN MODAL NUEVO CALENDARIO -->


<!-- MODAL NUEVO EVENTO -->
<form id="formNuevoEvento" method="post" action="post/nuevoEvento.php?mes=<?php echo $mes; ?>&anio=<?php echo $anio; ?>" data-toggle="validator">
	<div id="modalNuevoEvento" class="modal fade">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Nuevo evento o actividad</h4>
	      </div>
	      <div class="modal-body">
        
        	<fieldset>
        		
        		<div class="form-group">
        			<label for="cmp_nombre" class="visible-xs">Nombre</label>
        			<input type="text" class="form-control" id="cmp_nombre" name="cmp_nombre" placeholder="Nombre del evento o actividad" maxlength="120" required autofocus>
        		</div>
        		
        		
    			<div class="row">
    				<div class="col-xs-12">
	    				<div class="form-group">
	    					<div class="checkbox">
		    					<label>
		    						<input type="checkbox" id="cmp_fecha_diacomp" name="cmp_fecha_diacomp" value="1">
		    						<strong>Todo el día</strong>
		    					</label>
		    				</div>
	    				</div>
    				</div>
    				
    				
    				<div class="col-xs-6 col-sm-3">
    					<div class="form-group datetimepicker1">
        					<label for="cmp_fecha_ini">Fecha inicio</label>
        					<div class="input-group">
	        					<input type="text" class="form-control" id="cmp_fecha_ini" name="cmp_fecha_ini" value="<?php echo date('d/m/Y'); ?>" data-date-format="DD/MM/YYYY" required>
	        					<span class="input-group-addon"><span class="fa fa-calendar">
	        				</div>
	        			</div>
    				</div>
        			<div class="col-xs-6 col-sm-3">
        				<div class="form-group datetimepicker2">
	        				<label for="cmp_hora_ini">Hora inicio</label>
	        				<div class="input-group">
	        					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_hora_ini" name="cmp_hora_ini" value="<?php echo date('H:i'); ?>" data-date-format="HH:mm">
	        					<span class="input-group-addon"><span class="fa fa-clock-o">
	        				</div>
	        			</div>
        			</div>
        			<div class="col-xs-6 col-sm-3">
        				<div class="form-group datetimepicker3">
	        				<label for="cmp_fecha_fin">Fecha fin</label>
	        				<div class="input-group">
	        					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_fecha_fin" name="cmp_fecha_fin" value="<?php echo date('d/m/Y'); ?>" data-date-format="DD/MM/YYYY">
	        					<span class="input-group-addon"><span class="fa fa-calendar">
	        				</div>
	        			</div>
        			</div>
        			<div class="col-xs-6 col-sm-3">
        				<div class="form-group datetimepicker4">
	        				<label for="cmp_hora_fin">Hora fin</label>
	        				<div class="input-group">
	        					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_hora_fin" name="cmp_hora_fin" value="<?php echo date('H:i', strtotime('+1 hour', strtotime(date('H:i')))); ?>" data-date-format="HH:mm">
	        					<span class="input-group-addon"><span class="fa fa-clock-o">
	        				</div>
	        			</div>
        			</div>
        		</div>
        		
        		<div class="form-group">
        			<label for="cmp_descripcion">Descripción</label>
        			<textarea type="text" class="form-control" id="cmp_descripcion" name="cmp_descripcion" rows="3"></textarea>
        		</div>
        		
        		<div class="form-group">
        			<label for="cmp_lugar">Lugar</label>
        			<input type="text" class="form-control" id="cmp_lugar" name="cmp_lugar">
        		</div>
        		
        		<div class="form-group">
        			<label for="cmp_calendario">Calendario</label>
        			<select class="form-control" id="cmp_calendario" name="cmp_calendario" required>
        				<optgroup label="Mis calendarios">
        					<?php $result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE profesor='".$_SESSION['ide']."' AND espublico=0"); ?>
        					<?php while ($row = mysqli_fetch_assoc($result)): ?>
        					<option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
        					<?php endwhile; ?>
        					<?php mysqli_free_result($result); ?>
        				</optgroup>
        				<?php if (stristr($_SESSION['cargo'],'1')): ?>
        				<optgroup label="Otros calendarios">
        					<?php $result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE espublico=1 $sql_where"); ?>
        					<?php while ($row = mysqli_fetch_assoc($result)): ?>
        					<option value="<?php echo $row['id']; ?>" <?php echo (isset($_GET['calendario']) && ($_GET['calendario'] == 'Extraescolares' && $row['id'] == 2)) ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
        					<?php endwhile; ?>
        					<?php mysqli_free_result($result); ?>
        				</optgroup>
        				<?php endif; ?>
        				
        				<?php if (stristr($_SESSION['cargo'],'2') || stristr($_SESSION['cargo'],'4') || stristr($_SESSION['cargo'],'5')): ?>
        				<optgroup label="Otros calendarios">
        					<?php $result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE id='2' $sql_where"); ?>
        					<?php while ($row = mysqli_fetch_assoc($result)): ?>
        					<option value="<?php echo $row['id']; ?>" <?php echo (isset($_GET['calendario']) && ($_GET['calendario'] == 'Extraescolares' && $row['id'] == 2)) ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
        					<?php endwhile; ?>
        					<?php mysqli_free_result($result); ?>
        				</optgroup>
        				<?php endif; ?>
        				
        			</select>
        		</div>
        		
        		<div id="opciones_diario">
        			<?php $result = mysqli_query($db_con, "SELECT DISTINCT grupo, materia FROM profesores WHERE profesor='".$_SESSION['profi']."' order by materia, grupo"); ?>
        			<?php if (mysqli_num_rows($result)): ?>
        			<div class="form-group">
        				<label for="cmp_unidad_asignatura">Unidad y asignatura</label>
        				
        				<select class="form-control" id="cmp_unidad_asignatura" name="cmp_unidad_asignatura[]" size="5" multiple>
        				<?php while ($row = mysqli_fetch_array($result)): ?>
        					<option value="<?php echo $row['grupo'].' => '.$row['materia']; ?>" <?php echo (isset($grupos) && in_array($row['grupo'].' => '.$row['materia'], $grupos)) ? 'selected' : ''; ?>><?php echo $row['grupo'].' ('.$row['materia'].')'; ?></option>
        				<?php endwhile; ?>
        				</select>
        			</div>
        			
        		    <div class="form-group">
        				<div class="checkbox">
        					<label for="cmp_cuaderno">
        						<input type="checkbox" id="cmp_cuaderno" name="cmp_cuaderno" value="1"> Crear columna en mi cuaderno de notas<br>
        						<small class="text-muted">Se creará una columna de tipo numérico y no visible para las familias. Puede modificar estos valores en el cuaderno de notas.</small><br>
        						<small class="text-danger">Importante: Si la asignatura tiene desdoble de unidades, debe marcar todas las unidades afectadas. Deben ser del mismo curso y tener el mismo nombre de asignatura.</small>
        					</label>
        				</div>
        			</div>
        			<?php endif; ?>
        		</div>
        		
        		<?php if (stristr($_SESSION['cargo'],'1') || stristr($_SESSION['cargo'],'4') || stristr($_SESSION['cargo'],'5') || stristr($_SESSION['cargo'],'2')): ?>
        		<div id="opciones_actividades" class="row">
        			
        			<div class="col-sm-6">
        		
		        		<div class="form-group">
		        			<label for="cmp_departamento">Departamento que lo organiza</label>
		        			<select class="form-control" id="cmp_departamento" name="cmp_departamento">
		        				<?php if (stristr($_SESSION['cargo'],'2') == TRUE and !(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE)){ ?>
		        				<option value="Orientación">Orientación</option>
		        				<?php } else{ ?>
		        				<?php if (!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE) and !(stristr($_SESSION['cargo'],'d') == TRUE)): ?>
		        				<?php $result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos WHERE departamento='".$_SESSION['dpt']."' ORDER BY departamento ASC"); ?>
		        				
		        				<?php while ($row = mysqli_fetch_assoc($result)): ?>
		        				<option value="<?php echo $row['departamento']; ?>"><?php echo $row['departamento']; ?></option>
		        				<?php endwhile; ?>
		        				<?php elseif (stristr($_SESSION['cargo'],'d') == TRUE): ?>
		        				<option value="Relaciones de Género">Relaciones de Género</option>
		        				<?php else: ?>
		        				<option value="Múltiples Departamentos">Múltiples Departamentos</option>
		        				<option value="Actividades Extraescolares">Actividades Extraescolares</option>
		        				<option value="Relaciones de Género">Relaciones de Género</option>
		        				<?php $result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos WHERE departamento <> 'Admin' AND departamento <> 'Conserjeria' AND departamento <> 'Administracion' ORDER BY departamento ASC"); ?>
		        				<?php while ($row = mysqli_fetch_assoc($result)): ?>
		        				<option value="<?php echo $row['departamento']; ?>"><?php echo $row['departamento']; ?></option>
		        				<?php endwhile; ?>
		        				<?php endif; ?>
		        				<?php } ?>

		        			</select>
		        		</div>
		        		
		        		<div class="form-group">
		        			<label for="cmp_profesores">Profesores que asistirán a la actividad</label>
		        			<select class="form-control" id="cmp_profesores" name="cmp_profesores[]" size="21" multiple>
		        				<?php $result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos WHERE departamento <> 'Admin' AND departamento <> 'Conserjeria' AND departamento <> 'Administracion' ORDER BY departamento ASC"); ?>
		        				<?php while ($row = mysqli_fetch_assoc($result)): ?>
		        				<?php $result_depto = mysqli_query($db_con, "SELECT nombre, idea FROM departamentos WHERE departamento = '".$row['departamento']."' ORDER BY nombre ASC"); ?>
		        				<optgroup label="<?php echo $row['departamento']; ?>">
		        					<?php while ($row_profe = mysqli_fetch_assoc($result_depto)): ?>
		        					<option value="<?php echo $row_profe['nombre']; ?>"><?php echo $row_profe['nombre']; ?></option>
		        					<?php endwhile; ?>
		        				</optgroup>
		        				<?php endwhile; ?>
		        			</select>
		        			<p class="help-block">Para seleccionar varios profesores, mantén apretada la tecla <kbd>Ctrl</kbd> mientras los vas marcando con el ratón.</p>
		        		</div>
		        		<div class="form-group">
		        		<label for="cmp_descripcion">Observaciones (Precio de la Actividad, Recomendaciones para la misma, etc.)</label>
        				<textarea type="text" class="form-control" id="cmp_observaciones" name="cmp_observaciones" rows="3"></textarea>
		        		</div>
		        	</div><!-- /.col-sm-6 -->
		        	
		        	<div class="col-sm-6">
		        		
		        		<div class="form-group">
		        			<label for="">Unidades que asistirán a la actividad</label>
		        			<?php 	if (stristr($_SESSION['cargo'],'2') and !(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE)) {	$extra_tutor = "and unidad = '".$_SESSION['mod_tutoria']['unidad']."'";	}else{ $extra_tutor = ""; }?>
			        		<?php $result = mysqli_query($db_con, "SELECT DISTINCT curso FROM alma ORDER BY curso ASC"); ?>
			        		<?php while($row = mysqli_fetch_assoc($result)): ?>
			        			<?php echo '<p class="text-info">'.$row['curso'].'</p>'; ?>
			        			<?php $result1 = mysqli_query($db_con, "SELECT DISTINCT unidad FROM alma WHERE curso = '".$row['curso']."' $extra_tutor ORDER BY unidad ASC"); ?>
			        			<?php while($row1 = mysqli_fetch_array($result1)): ?>
			        		                 
			        			<div class="checkbox-inline"> 
			        				<label>
			        					<input name="cmp_unidades[]" type="checkbox" value="<?php echo $row1['unidad']; ?>">
			        		            <?php echo $row1['unidad']; ?>
			        		        </label>
			        		    </div>
			        		    
			        		<?php endwhile; ?>         
			        		<?php endwhile ?>
			        	</div>
		        		
		        	</div><!-- /.col-sm-6 -->
		        </div><!-- /.row -->
		        <?php endif; ?>
        				        		
        	</fieldset>
        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Crear</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</form>
<!-- FIN MODAL NUEVO EVENTO -->