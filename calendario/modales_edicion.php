<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

// CALENDARIOS PRIVADOS DEL PROFESOR
$result_calendarios1 = mysqli_query($db_con, "SELECT id, color FROM calendario_categorias WHERE profesor='".$_SESSION['ide']."' AND espublico=0");
while ($calendario1 = mysqli_fetch_assoc($result_calendarios1)) {

	$result_eventos1 = mysqli_query($db_con, "SELECT * FROM calendario WHERE categoria='".$calendario1['id']."' AND YEAR(fechaini)=$anio AND '$mes' BETWEEN MONTH(fechaini) AND MONTH(fechafin)");

	while ($eventos1 = mysqli_fetch_assoc($result_eventos1)) {

		$exp_fechaini_evento = explode('-', $eventos1['fechaini']);
		$fechaini_evento = $exp_fechaini_evento[2].'/'.$exp_fechaini_evento[1].'/'.$exp_fechaini_evento[0];

		$exp_fechafin_evento = explode('-', $eventos1['fechafin']);
		$fechafin_evento = $exp_fechafin_evento[2].'/'.$exp_fechafin_evento[1].'/'.$exp_fechafin_evento[0];

		echo '<form id="formEditarEvento" method="post" action="post/editarEvento.php?mes='.$mes.'&anio='.$anio.'" data-toggle="validator">
			<div id="modalEvento'.$eventos1['id'].'" class="modal fade">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">'.stripslashes($eventos1['nombre']).'</h4>
			      </div>
			      <div class="modal-body">
		        
		        	<fieldset>
		        		
		        		<input type="hidden" name="cmp_evento_id" value="'.$eventos1['id'].'">
		        		
		        		<div class="form-group">
		        			<label for="cmp_nombre" class="visible-xs">Nombre</label>
		        			<input type="text" class="form-control" id="cmp_nombre" name="cmp_nombre" placeholder="Nombre del evento o actividad" value="'.stripslashes($eventos1['nombre']).'" maxlength="120" autofocus required>
		        		</div>
		        		
		        		
		        		<div class="row">
		        			<div class="col-xs-12">
		        				<div class="form-group">
		        					<div class="checkbox">
		        						<label>
		        							<input type="checkbox" id="cmp_fecha_diacomp_'.$eventos1['id'].'" name="cmp_fecha_diacomp" value="1"';
		if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' checked';
		echo '>
		        							<strong>Todo el día</strong>
		        						</label>
		        					</div>
		        				</div>
		        			</div>
		        			
		        			<div class="col-xs-6 col-sm-3">
		        				<div class="form-group datetimepicker1">
		        					<label for="cmp_fecha_ini">Fecha inicio</label>
		        					<div class="input-group">
		            					<input type="text" class="form-control" id="cmp_fecha_ini" name="cmp_fecha_ini" value="'.$fechaini_evento.'" data-date-format="DD/MM/YYYY" required>
		            					<span class="input-group-addon"><span class="fa fa-calendar">
		            				</div>
		            			</div>
		        			</div>
		        			<div class="col-xs-6 col-sm-3">
		        				<div class="form-group datetimepicker2">
		            				<label for="cmp_hora_ini">Hora inicio</label>
		            				<div class="input-group">
		            					<input type="text" class="form-control" id="cmp_hora_ini" name="cmp_hora_ini" value="'.substr($eventos1['horaini'], 0, -3).'" data-date-format="HH:mm"';
		if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' disabled';
		echo '>
		            					<span class="input-group-addon"><span class="fa fa-clock-o">
		            				</div>
		            			</div>
		        			</div>
		        			<div class="col-xs-6 col-sm-3">
		        				<div class="form-group datetimepicker3">
		            				<label for="cmp_fecha_fin">Fecha fin</label>
		            				<div class="input-group">
		            					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_fecha_fin" name="cmp_fecha_fin" value="'.$fechafin_evento.'" data-date-format="DD/MM/YYYY"';
		if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' disabled';
		echo '>
		            					<span class="input-group-addon"><span class="fa fa-calendar">
		            				</div>
		            			</div>
		        			</div>
		        			<div class="col-xs-6 col-sm-3">
		        				<div class="form-group datetimepicker4">
		            				<label for="cmp_hora_fin">Hora fin</label>
		            				<div class="input-group">
		            					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_hora_fin" name="cmp_hora_fin" value="'.substr($eventos1['horafin'], 0, -3).'" data-date-format="HH:mm"';
		if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' disabled';
		echo '>
		            					<span class="input-group-addon"><span class="fa fa-clock-o">
		            				</div>
		            			</div>
		        			</div>
		        		</div>
		        		
		        		<div class="form-group">
		        			<label for="cmp_descripcion">Descripción</label>
		        			<textarea type="text" class="form-control" id="cmp_descripcion" name="cmp_descripcion" rows="3">'.stripslashes($eventos1['descripcion']).'</textarea>
		        		</div>
		        		
		        		<div class="form-group">
		        			<label for="cmp_lugar">Lugar</label>
		        			<input type="text" class="form-control" id="cmp_lugar" name="cmp_lugar" value="'.stripslashes($eventos1['lugar']).'">
		        		</div>
		        		
		        		<div class="form-group">
		        			<label for="cmp_calendario">Calendario</label>
		        			<select class="form-control" id="cmp_calendario" name="cmp_calendario" required>
		        				<optgroup label="Mis calendarios">';
		$result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE profesor='".$_SESSION['ide']."' AND espublico=0");
		while ($row = mysqli_fetch_assoc($result)):
		echo '<option value="'.$row['id'].'"';
		if ($eventos1['categoria'] == $row['id']) echo ' selected';
		echo '>'.$row['nombre'].'</option>';
		endwhile;
		mysqli_free_result($result);
		echo '</optgroup>';
		if (stristr($_SESSION['cargo'],'1') || stristr($_SESSION['cargo'],'4') || stristr($_SESSION['cargo'],'5')):
		echo '<optgroup label="Otros calendarios">';
		$result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE espublico=1 $sql_where");
		while ($row = mysqli_fetch_assoc($result)):
		echo '<option value="'.$row['id'].'"';
		if ($eventos1['categoria'] == $row['id']) echo ' selected';
		echo '>'.$row['nombre'].'</option>';
		endwhile;
		mysqli_free_result($result);
		echo '</optgroup>';
		endif;
		echo '</select>
		        		</div>
		        		
		        		
		        		<div id="opciones_diario">';

		$result = mysqli_query($db_con, "SELECT DISTINCT grupo, materia FROM profesores WHERE profesor='".$_SESSION['profi']."' order by materia, grupo");
		if (mysqli_num_rows($result)):

		if ($eventos1['unidades'] != "" && $eventos1['asignaturas'] != "") {
			$eventos1['unidades'] = str_replace('; ', ';', $eventos1['unidades']);
			$eventos1['asignaturas'] = str_replace('; ', ';', $eventos1['asignaturas']);
			 
			$exp_unidades = explode(';', $eventos1['unidades']);
			$exp_asignaturas = explode(';', $eventos1['asignaturas']);
		}

		echo '<div class="form-group">
		        				<label for="cmp_unidad_asignatura">Unidad y asignatura</label>
		        				
		        				<select class="form-control" id="cmp_unidad_asignatura" name="cmp_unidad_asignatura[]" size="5" multiple>';
		 
		$i = 0;
		 
		while ($row = mysqli_fetch_array($result)):
		echo '<option value="'.$row['grupo'].' => '.$row['materia'].'"';
		if (in_array($row['grupo'], $exp_unidades) && in_array($row['materia'], $exp_asignaturas)) echo ' selected';
		echo '>'.$row['grupo'].' ('.$row['materia'].')'.'</option>';
		$i++;
		endwhile;
		echo'</select>
		        			</div>';
		 
		if ($eventos1['unidades'] != "") {
			$eventos1['unidades'] = str_replace(';', ',', $eventos1['unidades']);
		}
		 
		$result_cuaderno = mysqli_query($db_con, "SELECT id FROM notas_cuaderno WHERE nombre='".$eventos1['nombre']."' AND fecha='".substr($eventos1['fechareg'], 0, 10)."' AND curso='".$eventos1['unidades']."'");
		 
		/*echo '<div class="form-group">
		 <div class="checkbox">
		 <label for="cmp_cuaderno">
		 <input type="checkbox" id="cmp_cuaderno" name="cmp_cuaderno" value="1"';*/
		if (mysqli_num_rows($result_cuaderno)) echo ' ';
		/*echo '> Crear columna en mi cuaderno de notas<br>
		 <small class="text-muted">Se creará una columna de tipo numérico y no visible para las familias. Puede modificar estos valores en el cuaderno de notas.</small><br>
		 <small class="text-danger">Importante: Si la asignatura tiene desdoble de unidades, debe marcar todas las unidades afectadas. Deben ser del mismo curso y tener el mismo nombre de asignatura.</small>
		 </label>
		 </div>
		 </div>';*/
		endif;
		echo '</div>
		        						        				        		
		        	</fieldset>
		        
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button type="submit" class="btn btn-danger" formaction="post/eliminarEvento.php?mes='.$mes.'&anio='.$anio.'">Eliminar</button>
			        <button type="submit" class="btn btn-primary">Modificar</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</form>';	
	}
	mysqli_free_result($result_eventos1);
}
mysqli_free_result($result_calendarios1);

// CALENDARIOS PUBLICOS
$result_calendarios1 = mysqli_query($db_con, "SELECT id, color FROM calendario_categorias WHERE espublico=1");
while ($calendario1 = mysqli_fetch_assoc($result_calendarios1)) {

	$result_eventos1 = mysqli_query($db_con, "SELECT * FROM calendario WHERE categoria='".$calendario1['id']."' AND YEAR(fechaini)=$anio AND '$mes' BETWEEN MONTH(fechaini) AND MONTH(fechafin)");

	while ($eventos1 = mysqli_fetch_assoc($result_eventos1)) {

		$exp_fechaini_evento = explode('-', $eventos1['fechaini']);
		$fechaini_evento = $exp_fechaini_evento[2].'/'.$exp_fechaini_evento[1].'/'.$exp_fechaini_evento[0];

		$exp_fechafin_evento = explode('-', $eventos1['fechafin']);
		$fechafin_evento = $exp_fechafin_evento[2].'/'.$exp_fechafin_evento[1].'/'.$exp_fechafin_evento[0];

		if (stristr($_SESSION['cargo'],'1') || ($calendario1['id'] == 2 && (stristr($_SESSION['cargo'],'4') || stristr($_SESSION['cargo'],'5') || stristr($_SESSION['cargo'],'2')))) {
			echo '<form id="formEditarEvento" method="post" action="post/editarEvento.php?mes='.$mes.'&anio='.$anio.'" data-toggle="validator">
				<div id="modalEvento'.$eventos1['id'].'" class="modal fade">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">'.stripslashes($eventos1['nombre']).'</h4>
				      </div>
				      <div class="modal-body">
			        
			        	<fieldset>
			        		
			        		<input type="hidden" name="cmp_evento_id" value="'.$eventos1['id'].'">
			        		
			        		<div class="form-group">
			        			<label for="cmp_nombre" class="visible-xs">Nombre</label>
			        			<input type="text" class="form-control" id="cmp_nombre" name="cmp_nombre" placeholder="Nombre del evento o actividad" value="'.stripslashes($eventos1['nombre']).'" maxlength="120" autofocus required>
			        		</div>
			        		
			        		
			        		<div class="row">
			        			<div class="col-xs-12">
			        				<div class="form-group">
			        					<div class="checkbox">
			        						<label>
			        							<input type="checkbox" id="cmp_fecha_diacomp_'.$eventos1['id'].'" name="cmp_fecha_diacomp" value="1"';
			if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' checked';
			echo '>
			        							<strong>Todo el día</strong>
			        						</label>
			        					</div>
			        				</div>
			        			</div>
			        			
			        			<div class="col-xs-6 col-sm-3">
			        				<div class="form-group datetimepicker1">
			        					<label for="cmp_fecha_ini">Fecha inicio</label>
			        					<div class="input-group">
			            					<input type="text" class="form-control" id="cmp_fecha_ini" name="cmp_fecha_ini" value="'.$fechaini_evento.'" data-date-format="DD/MM/YYYY" required>
			            					<span class="input-group-addon"><span class="fa fa-calendar">
			            				</div>
			            			</div>
			        			</div>
			        			<div class="col-xs-6 col-sm-3">
			        				<div class="form-group datetimepicker2">
			            				<label for="cmp_hora_ini">Hora inicio</label>
			            				<div class="input-group">
			            					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_hora_ini" name="cmp_hora_ini" value="'.substr($eventos1['horaini'], 0, -3).'" data-date-format="HH:mm"';
			if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' disabled';
			echo '>
			            					<span class="input-group-addon"><span class="fa fa-clock-o">
			            				</div>
			            			</div>
			        			</div>
			        			<div class="col-xs-6 col-sm-3">
			        				<div class="form-group datetimepicker3">
			            				<label for="cmp_fecha_fin">Fecha fin</label>
			            				<div class="input-group">
			            					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_fecha_fin" name="cmp_fecha_fin" value="'.$fechafin_evento.'" data-date-format="DD/MM/YYYY"';
			if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' disabled';
			echo '>
			            					<span class="input-group-addon"><span class="fa fa-calendar">
			            				</div>
			            			</div>
			        			</div>
			        			<div class="col-xs-6 col-sm-3">
			        				<div class="form-group datetimepicker4">
			            				<label for="cmp_hora_fin">Hora fin</label>
			            				<div class="input-group">
			            					<input type="text" class="form-control cmp_fecha_toggle" id="cmp_hora_fin" name="cmp_hora_fin" value="'.substr($eventos1['horafin'], 0, -3).'" data-date-format="HH:mm"';
			if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') echo ' disabled';
			echo '>
			            					<span class="input-group-addon"><span class="fa fa-clock-o">
			            				</div>
			            			</div>
			        			</div>
			        		</div>
			        		
			        		<div class="form-group">
			        			<label for="cmp_descripcion">Descripción</label>
			        			<textarea type="text" class="form-control" id="cmp_descripcion" name="cmp_descripcion" rows="3">'.stripslashes($eventos1['descripcion']).'</textarea>
			        		</div>
			        		
			        		<div class="form-group">
			        			<label for="cmp_lugar">Lugar</label>
			        			<input type="text" class="form-control" id="cmp_lugar" name="cmp_lugar" value="'.stripslashes($eventos1['lugar']).'">
			        		</div>
			        		
			        		<div class="form-group">
			        			<label for="cmp_calendario">Calendario</label>
			        			<select class="form-control" id="cmp_calendario" name="cmp_calendario" required>
			        				<optgroup label="Mis calendarios">';
			$result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE profesor='".$_SESSION['ide']."' AND espublico=0");
			while ($row = mysqli_fetch_assoc($result)):
			echo '<option value="'.$row['id'].'"';
			if ($eventos1['categoria'] == $row['id']) echo ' selected';
			echo '>'.$row['nombre'].'</option>';
			endwhile;
			mysqli_free_result($result);
			echo '</optgroup>';
			if (stristr($_SESSION['cargo'],'1')):
			echo '<optgroup label="Otros calendarios">';
			$result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE espublico=1 $sql_where");
			while ($row = mysqli_fetch_assoc($result)):
			echo '<option value="'.$row['id'].'"';
			if ($eventos1['categoria'] == $row['id']) echo ' selected';
			echo '>'.$row['nombre'].'</option>';
			endwhile;
			mysqli_free_result($result);
			echo '</optgroup>';
			endif;
			
			
			if (stristr($_SESSION['cargo'],'4') || stristr($_SESSION['cargo'],'5') || stristr($_SESSION['cargo'],'2')):
			echo '<optgroup label="Otros calendarios">';
			$result = mysqli_query($db_con, "SELECT id, nombre, color FROM calendario_categorias WHERE id='2' $sql_where");
			while ($row = mysqli_fetch_assoc($result)):
			echo '<option value="'.$row['id'].'"';
			if ($eventos1['categoria'] == $row['id']) echo ' selected';
			echo '>'.$row['nombre'].'</option>';
			endwhile;
			mysqli_free_result($result);
			echo '</optgroup>';
			endif;
			echo '</select>
			        		</div>';
			 
			if ($eventos1['categoria'] == 2 && (stristr($_SESSION['cargo'],'1') || stristr($_SESSION['cargo'],'4') || stristr($_SESSION['cargo'],'5')  || stristr($_SESSION['cargo'],'2'))):
			echo '<div id="opciones_actividades" class="row">
			        			
			        			<div class="col-sm-6">
			        		
			        				<div class="form-group">
			        					<label for="cmp_departamento">Departamento que lo organiza</label>
			        					<select class="form-control" id="cmp_departamento" name="cmp_departamento">';
			if (stristr($_SESSION['cargo'],'2') == TRUE  and !(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE)){ 
		       echo '<option value="Orientación">Orientación</option>';
		    } 
		    else{ 		        				
			if (!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE) and !(stristr($_SESSION['cargo'],'d') == TRUE)):
			$result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos WHERE departamento='".$_SESSION['dpt']."' ORDER BY departamento ASC");
			while ($row = mysqli_fetch_assoc($result)):
			echo '<option value="'.$row['departamento'].'"';
			if ($eventos1['departamento'] == $row['departamento']) echo ' selected';
			echo '>'.$row['departamento'].'</option>';
			endwhile;
			elseif (stristr($_SESSION['cargo'],'d') == TRUE):
			echo '<option value="Relaciones de Género"';
			if ("Relaciones de Género" == $row['departamento']) echo ' selected';
			echo '>Relaciones de Género</option>';
			else:
			echo '<option value="Múltiples Departamentos"';
			if ("Múltiples Departamentos" == $row['departamento']) echo ' selected';
			echo '>Múltiples Departamentos</option>
			        						<option value="Actividades Extraescolares"';
			if ("Actividades Extraescolares" == $row['departamento']) echo ' selected';
			echo '>Actividades Extraescolares</option>
			        						<option value="Relaciones de Género"';
			if ("Relaciones de Género" == $row['departamento']) echo ' selected';
			echo '>Relaciones de Género</option>';
			$result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos WHERE departamento <> 'Admin' AND departamento <> 'Conserjeria' AND departamento <> 'Administracion' ORDER BY departamento ASC");
			while ($row = mysqli_fetch_assoc($result)):
			echo '<option value="'.$row['departamento'].'"';
			if ($eventos1['departamento'] == $row['departamento']) echo ' selected';
			echo '>'.$row['departamento'].'</option>';
			endwhile;
			endif;
		    }
			echo'			</select>
			        				</div>
			        				
			        				<div class="form-group">
			        					<label for="cmp_profesores">Profesores que asistirán a la actividad</label>
			        					<select class="form-control" id="cmp_profesores" name="cmp_profesores[]" size="21" multiple>';
			$result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos WHERE departamento <> 'Admin' AND departamento <> 'Conserjeria' AND departamento <> 'Administracion' ORDER BY departamento ASC");
			while ($row = mysqli_fetch_assoc($result)):
			$result_depto = mysqli_query($db_con, "SELECT nombre, idea FROM departamentos WHERE departamento = '".$row['departamento']."' ORDER BY nombre ASC");
			echo '<optgroup label="'.$row['departamento'].'">';
			while ($row_profe = mysqli_fetch_assoc($result_depto)):
			echo '<option value="'.$row_profe['nombre'].'"';
			$exp_profesores = explode (';',str_replace('; ',';',$eventos1['profesores']));
			if (in_array($row_profe['nombre'], $exp_profesores)) echo ' selected';
			echo '>'.$row_profe['nombre'].'</option>';
			endwhile;
			echo '</optgroup>';
			endwhile;
			echo '</select>
			        					<p class="help-block">Para seleccionar varios profesores, mantén apretada la tecla <kbd>Ctrl</kbd> mientras los vas marcando con el ratón.</p>
			        				</div>
			        			
			        	<div class="form-group">
		        			<label for="cmp_descripcion">Observaciones (Precio de la Actividad, Recomendaciones para la misma, etc.)</label>
		        			<textarea type="text" class="form-control" id="cmp_observaciones" name="cmp_observaciones" rows="3">'.stripslashes($eventos1['observaciones']).'</textarea>
		        		</div>	
			        			</div><!-- /.col-sm-6 -->
			        			
			        			<div class="col-sm-6">
			        				
			        				<div class="form-group">
			        					<label for="">Unidades que asistirán a la actividad</label>';
			if (stristr($_SESSION['cargo'],'2')) {	$extra_tutor = "and unidad = '".$_SESSION['mod_tutoria']['unidad']."'";	}else{ $extra_tutor = ""; }
			$result = mysqli_query($db_con, "SELECT DISTINCT curso FROM alma ORDER BY curso ASC");
			while($row = mysqli_fetch_assoc($result)):
			echo '<p class="text-info">'.$row['curso'].'</p>';
			$result1 = mysqli_query($db_con, "SELECT DISTINCT unidad FROM alma WHERE curso = '".$row['curso']."' $extra_tutor ORDER BY unidad ASC");
			while($row1 = mysqli_fetch_array($result1)):

			echo '<div class="checkbox-inline">
			        		    				<label>
			        		    					<input name="cmp_unidades[]" type="checkbox" value="'.$row1['unidad'].'"';
			$exp_unidades = explode (';',str_replace('; ',';',$eventos1['unidades']));
			if (in_array($row1['unidad'], $exp_unidades)) echo ' checked';
			echo '>'.$row1['unidad'].'
			        		    		        </label>
			        		    		    </div>';
				
			endwhile;
			endwhile;
			echo'</div>
			        				
			        			</div><!-- /.col-sm-6 -->
			        		</div><!-- /.row -->';
			endif;
			 
			 
			echo '</fieldset>';
			 
			echo '   </div>
				      	  <div class="modal-footer">';
			if ($eventos1['categoria'] == 2):
			$result_actividad = mysqli_query($db_con, "SELECT cod_actividad FROM `actividadalumno` WHERE cod_actividad = (SELECT id FROM calendario WHERE nombre = '".$eventos1['nombre']."')  LIMIT 1");

			if (mysqli_num_rows($result_actividad)):
			 
			$row_idact = mysqli_fetch_row($result_actividad);
			$idact = $row_idact[0];

			echo '<div class="pull-left">
				      				<a class="btn btn-info" href="../admin/actividades/extraescolares.php?id='.$idact.'" target="_blank">Listado de alumnos</a>
				      			</div>';
			 
			endif;

			endif;

			echo '<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				        <button type="submit" class="btn btn-danger" formaction="post/eliminarEvento.php?mes='.$mes.'&anio='.$anio.'">Eliminar</button>
				        <button type="submit" class="btn btn-primary">Modificar</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</form>';
		}
		else {
			$exp_fechaini_evento = explode('-', $eventos1['fechaini']);
			$fechaini_evento = $exp_fechaini_evento[2].'/'.$exp_fechaini_evento[1].'/'.$exp_fechaini_evento[0];
				
			$exp_fechafin_evento = explode('-', $eventos1['fechafin']);
			$fechafin_evento = $exp_fechafin_evento[2].'/'.$exp_fechafin_evento[1].'/'.$exp_fechafin_evento[0];
				
			echo '<div id="modalEvento'.$eventos1['id'].'" class="modal fade">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">'.stripslashes($eventos1['nombre']).'</h4>
			      </div>
			      <div class="modal-body">
	        		
	        		<div class="row">';
			 
			if ($eventos1['fechaini'] == $eventos1['fechafin'] && substr($eventos1['horaini'], 0, -3)=='00:00' && substr($eventos1['horafin'], 0, -3)=='00:00') {
				 
				echo '
	        			<div class="col-xs-12">
	        				<div class="form-group">
	        					<label for="">Fecha inicio</label>
	        					<p class="form-control-static text-info">'.$fechaini_evento.', todo el día.</p>
	        				</div>
	        			</div>';
			}
			else {

				echo'
	        			<div class="col-xs-6 col-sm-3">
	        				<div class="form-group">
	        					<label for="">Fecha inicio</label>
	            				<p class="form-control-static text-info">'.$fechaini_evento.'</p>
	            			</div>
	        			</div>
	        			<div class="col-xs-6 col-sm-3">
	        				<div class="form-group">
	            				<label for="">Hora inicio</label>
	            				<p class="form-control-static text-info">'.substr($eventos1['horaini'], 0, -3).'</p>
	            			</div>
	        			</div>
	        			<div class="col-xs-6 col-sm-3">
	        				<div class="form-group">
	            				<label for="">Fecha fin</label>
	            				<p class="form-control-static text-info">'.$fechafin_evento.'</p>
	            			</div>
	        			</div>
	        			<div class="col-xs-6 col-sm-3">
	        				<div class="form-group">
	            				<label for="">Hora fin</label>
	            				<p class="form-control-static text-info">'.substr($eventos1['horafin'], 0, -3).'</p>
	            			</div>
	        			</div>';
			}
			echo '</div>
	        		
	        		<div class="form-group">
	        			<label for="">Descripción</label>
	        			<p class="form-control-static text-info">'.stripslashes($eventos1['descripcion']).'</p>
	        		</div>
	        		
	        		<div class="form-group">
	        			<label for="">Lugar</label>
	        			<p class="form-control-static text-info lead">'.stripslashes($eventos1['lugar']).'</p>
	        		</div>';
			if($eventos1['categoria'] == 2) {
				echo'	<div class="form-group">
	        			<label for="">Departamento que lo organiza</label>
	        			<p class="form-control-static text-info">'.$eventos1['departamento'].'</p>
	        		</div>
	        		
	        		<div class="form-group">
	        			<label for="">Profesores que asistirán a la actividad</label>
	        			<p class="form-control-static text-info">'.str_replace(';', ' | ',$eventos1['profesores']).'</p>
	        		</div>
	        		
	        		<div class="form-group">
		        		<label for="cmp_descripcion">Observaciones (Precio de la Actividad, Recomendaciones para la misma, etc.)</label>
		        		<p class="form-control-static text-info">'.str_replace(';', ' | ',$eventos1['observaciones']).'</p>
		        	</div>	
		        		
	        		<div class="form-group">
	        			<label for="">Unidades que asistirán a la actividad</label>
	        			<p class="form-control-static text-info">'.str_replace(';', ' | ',$eventos1['unidades']).'</p>
	        		</div>';
			}
			 
			echo '   </div>
				  <div class="modal-footer">';
			if ($eventos1['categoria'] == 2):
			$result_actividad = mysqli_query($db_con, "SELECT cod_actividad FROM `actividadalumno` WHERE cod_actividad = (SELECT id FROM calendario WHERE nombre = '".$eventos1['nombre']."') LIMIT 1");
				
			if (mysqli_num_rows($result_actividad)):

			$row_idact = mysqli_fetch_row($result_actividad);
			$idact = $row_idact[0];

			echo '<div class="pull-left">
							<a class="btn btn-info" href="../admin/actividades/extraescolares.php?id='.$idact.'" target="_blank">Listado de alumnos</a>
						</div>';

			endif;
				
			endif;

			echo '      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->';	
		}
	}
	mysqli_free_result($result_eventos1);
}
mysqli_free_result($result_calendarios1);
?>