<?php
require('../../bootstrap.php');

if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}
if (isset($_GET['submit2'])) {$submit2 = $_GET['submit2'];}elseif (isset($_POST['submit2'])) {$submit2 = $_POST['submit2'];}else{$submit2="";}
if (isset($_GET['inicio'])) {$inicio = $_GET['inicio'];}elseif (isset($_POST['inicio'])) {$inicio = $_POST['inicio'];}else{$inicio="";}
if (isset($_GET['fin'])) {$fin = $_GET['fin'];}elseif (isset($_POST['fin'])) {$fin = $_POST['fin'];}else{$fin="";}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];}elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}else{$profesor="";}
if (isset($_GET['observaciones'])) {$observaciones = $_GET['observaciones'];}elseif (isset($_POST['observaciones'])) {$observaciones = $_POST['observaciones'];}else{$observaciones="";}
if (isset($_GET['tareas'])) {$tareas = $_GET['tareas'];}elseif (isset($_POST['tareas'])) {$tareas = $_POST['tareas'];}else{$tareas="";}
if (isset($_GET['horas'])) {$horas = $_GET['horas'];}elseif (isset($_POST['horas'])) {$horas = $_POST['horas'];}else{$horas="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['pra'])) {$pra = $_GET['pra'];}elseif (isset($_POST['pra'])) {$pra = $_POST['pra'];}else{$pra="";}
if (isset($_GET['hora1'])) {$hora1 = $_GET['hora1'];}elseif (isset($_POST['hora1'])) {$hora1 = $_POST['hora1'];}else{$hora1="";}
if (isset($_GET['hora2'])) {$hora2 = $_GET['hora2'];}elseif (isset($_POST['hora2'])) {$hora2 = $_POST['hora2'];}else{$hora2="";}
if (isset($_GET['hora3'])) {$hora3 = $_GET['hora3'];}elseif (isset($_POST['hora3'])) {$hora3 = $_POST['hora3'];}else{$hora3="";}
if (isset($_GET['hora4'])) {$hora4 = $_GET['hora4'];}elseif (isset($_POST['hora4'])) {$hora4 = $_POST['hora4'];}else{$hora4="";}
if (isset($_GET['hora5'])) {$hora5 = $_GET['hora5'];}elseif (isset($_POST['hora5'])) {$hora5 = $_POST['hora5'];}else{$hora5="";}
if (isset($_GET['hora6'])) {$hora6 = $_GET['hora6'];}elseif (isset($_POST['hora6'])) {$hora6 = $_POST['hora6'];}else{$hora6="";}

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2 style="display:inline;">Ausencias del profesorado <small>Registro de ausencias <?php echo (isset($profesor)) ? $profesor : ''; ?></small></h2>
		
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
						<p>El módulo de Ausencias permite al profesor comunicar que no va a asistir al Centro en un rango de 
						horas o fechas. Facilita sobre todo la tarea de los Profesores de Guardia y del Equipo Directivo.</p>
						El formulario de registro es muy sencillo: seleccionamos la fecha o rango de fechas de la baja; si 
						la baja se va a limitar a ciertas horas sueltas elegimos las horas que vamos a estar ausentes (en 
						caso de días completos no es necesario marcar las casillas de las horas sueltas); e introducimos la 
						descripción de las tareas encargadas para los grupos de alumnos afectados, o bien subimos un documento 
						con las tareas.</p>
						<p>A la derecha del formulario aparecen las ausencias de los profesores, ordenadas temporalmente. Al 
						hacer click con el ratón sobre el nombre de un profesor podemos ver las ausencias del mismo a lo largo 
						del Curso Escolar.</p>
						<p>Las ausencias aparecen bajo el menú de la página de inicio de la aplicación y un icono señala si el 
						profesor ha dejado o no tareas para los alumnos. Al hacer click con el ratón sobre el profesor ausente 
						entraremos en una página donde podremos ver el horario del día del profesor ausente, así como las tareas 
						o documento con las mismas para poder atender a los alumnos durante esa hora.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>

	</div>
<br>

<?php 
if ($borrar == '1') {
	$del = mysqli_query($db_con, "delete from ausencias where id = '$id'");
	echo '
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	Los datos se han borrado correctamente.
</div>';
}
if (isset($_POST['submit2'])) {
	// Cambiamos fecha
	$fech1=explode("-",$inicio);
	$fech2=explode("-",$fin);
	$inicio1 = "$fech1[2]-$fech1[1]-$fech1[0]";
	$fin1 = "$fech2[2]-$fech2[1]-$fech2[0]";
	//Horas
	for ($i=1;$i<7;$i++){
		$horas.=${hora.$i};
	}
	// Comprobamos datos enviados
	if ($profesor and $inicio and $fin) {
		$ya = mysqli_query($db_con, "select * from ausencias where profesor = '$profesor' and inicio = '$inicio1' and fin = '$fin1' and observaciones = '$observaciones'");
		if (mysqli_num_rows($ya) > '0') {
			$ya_hay = mysqli_fetch_array($ya);
			$actualiza = mysqli_query($db_con, "update ausencias set tareas = '$tareas', horas = '$horas', observaciones = '$observaciones' where id = '$ya_hay[0]'");
			echo '<div align="center"><div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente.
          </div></div>';			
		}
			else{
			if ($_FILES['userfile']['name'] != ''){
				$nombre_archivo = $_FILES['userfile']['name'];
				$tipo_archivo = $_FILES['userfile']['type'];
				$tamano_archivo = $_FILES['userfile']['size'];
				#esta es la extension
				
				// Sanitizamos el nombre del archivo
				$caracteres_no_permitidos = array(' ', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
				$caracteres_permitidos = array('_', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
				$nombre_archivo = str_replace($caracteres_no_permitidos, $caracteres_permitidos, $nombre_archivo);
				
				if (move_uploaded_file($_FILES['userfile']['tmp_name'], "./archivos/".$nombre_archivo)){}
				else{
					echo '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />Ha ocurrido un error al subir el aechivo. Busca ayuda.
          </div>';
				}
				}
				$inserta = mysqli_query($db_con, "insert into ausencias VALUES ('', '$profesor', '$inicio1', '$fin1', '$horas', '$tareas', NOW(), '$nombre_archivo', '$observaciones')");
				echo '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han registrado correctamente.
          </div>';		
			}
			
	}
	else{
		echo '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No se pueden procesar los datos. Has dejado campos vacíos en el formulario que es necesario rellenar. Vuelve atrás e inténtalo de nuevo.
          </div>';

		exit();
	}
}
?>
	
	<!-- SCAFFOLDING -->
	<div class="row">
		
		<div class="col-sm-5">
			
			<legend>Registro de ausencias</legend>
			
			<div class="well well-large">

			<form method="post" action="" enctype="multipart/form-data">
				
				<div class="form-group">
					<label for="profesor">Profesor/a</label>
					<?php
					$hora = date('G');
					$minuto = date('i');
					$hora_min = $hora.":".$minuto;
					$dia_sem = date('w');
					$hor=mysqli_query($db_con,"select hora from tramos where hora_inicio <= '$hora_min' and hora_fin >= '$hora_min'");
					$hora_act = mysqli_fetch_array($hor);
					$hora_actual = $hora_act[0];
					$gu = mysqli_query($db_con, "select * from horw where dia = '$dia_sem' and hora = '$hora_actual' and prof = '".$_SESSION['profi']."' and c_asig = '25'");
					$guardia = mysqli_num_rows($gu);
					if(stristr($_SESSION['cargo'],'1') == TRUE or $guardia > 0)
					{
						echo "<select class='form-control' id='profesor' name='profesor'>";
						if ($profesor) {
							echo "<option>$profesor</option>";
						}
						else{
							echo "<option></option>";
						}
						$profe = mysqli_query($db_con, "SELECT distinct profesor FROM profesores order by profesor asc");
						while($filaprofe = mysqli_fetch_array($profe)) {
							echo "<option>$filaprofe[0]</option>";
						}
						echo "</select>";
					
						$fecha = (date("d").-date("m").-date("Y"));
						$comienzo=explode("-",$config['curso_inicio']);
						$comienzo_curso=$comienzo[2]."-".$comienzo[1]."-".$comienzo[0];
						$fecha2 = date("m");
						?> </select> <?php
					}
					else{
						$profesor = $_SESSION['profi'];
						echo '<input type="text" class="form-control" name="profesor" value="'.$profesor.'" readonly>';
					}
					?>
				</div>
				
				<div class="row">
				
					<div class="col-sm-6">
					
						<div class="form-group" id="datimepicker1">
							<label for="inicio">Inicio de la ausencia</label>
							<div class="input-group">
								<input type="text" class="form-control" id="inicio" name="inicio" value="<?php echo (isset($inicio) && $inicio) ? $inicio : date('d-m-Y'); ?>" data-date-format="DD-MM-YYYY">
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					
					</div>
					
					<div class="col-sm-6">
					
						<div class="form-group" id="datimepicker2">
							<label for="inicio">Fin de la ausencia</label>
							<div class="input-group">
								<input type="text" class="form-control" id="fin" name="fin" value="<?php echo (isset($fin) && $fin) ? $fin : date('d-m-Y'); ?>" data-date-format="DD-MM-YYYY">
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					
					</div>
					
				</div>
								
				<div class="form-group">
				<label>Horas sueltas</label><br>
				<?php
				for ($i=1;$i<7;$i++){
				$hor = mysqli_query($db_con,"select horas from ausencias where inicio='$inicio1' and fin='$fin1' and profesor='$profesor' and horas like '%$i%'");
				$hori=mysqli_fetch_array($hor);
				if (strlen($hori[0])>0) {
						$extra_hor=" checked";
					}	
					else{
						$extra_hor="";
					}
				?>
				
				<div class="checkbox-inline"> 
<label>
<input name="<?php echo "hora".$i;?>" type="checkbox" value="<?php echo $i;?>" <?php echo $extra_hor;?>>
                   <?php 
                  echo "".$i."</label> </div>&nbsp;";
					
				}
				?>
				</div>
				<div class="form-group">
					<label for="observaciones">Tipo y/o Razón de la Ausencia.</label>
					<textarea class="form-control" id="observaciones" name="observaciones" rows="6" placeholder="ATENCIÓN: La información registrada en este campo sólo es visible para el Equipo Directivo."><?php echo $observaciones;?></textarea>
				</div>


				<div class="form-group">
					<label for="tareas">Tareas para los alumnos</label>
					<textarea class="form-control" id="tareas" name="tareas" rows="6"></textarea>
				</div>
				
				<div class="form-group">
					<label for="userfile">Adjuntar archivo con tareas</label>
					<input type="file" id="userfile" name="userfile">
					<br>
					<p class="block-help">Para adjuntar múltiples archivos es necesario comprimirlos en uno solo. El tamaño máximo permitido es de <?php echo ini_get('post_max_size'); ?>b.</p>
				</div>

				<button type="submit" class="btn btn-primary" name="submit2">Registrar</button>
				<button type="reset" class="btn btn-default">Cancelar</button>
				
			</form>
			
			</div>

		</div>
		
		
		<div class="col-sm-7">

			<legend>Historial de ausencias del profesorado</legend>
			
			<div class="table-responsive">
				<table class="table table-striped table-hover datatable">
					<thead>
						<tr>
							<th>Profesor</th>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Horas</th>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<th>&nbsp;</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php $result = mysqli_query($db_con, "SELECT inicio, fin, tareas, id, profesor, horas, archivo FROM ausencias ORDER BY fin DESC LIMIT 50"); ?>
						<?php while ($row = mysqli_fetch_array($result)): ?>
						<tr>
							<td nowrap><a href='index.php?pra=<?php echo $row['profesor']; ?>#history'><?php echo $row['profesor']; ?></a></td>
							<td nowrap><?php echo $row['inicio']; ?></td>
							<td nowrap><?php echo $row['fin']; ?></td>
							<td>
							<?php if ($row['horas'] != '0') { 
							$hr = str_split($row['horas']);
							foreach ($hr as $hora){
								echo $hora."ª ";
							}
							}; ?>
							</td>
							
							
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>							
								<td>
								<a href="index.php?borrar=1&id=<?php echo $row['id']; ?>&profesor=<?php echo $profesor; ?>" data-bb='confirm-delete'>
									<span class="fa fa-trash-o fa-fw fa-lg" data-bs="tooltip" title="Borrar"></span>
								</a>
								</td>
							<?php endif; ?>							
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

		</div><!-- /.col-sm-7 -->
		
	</div><!-- /.row -->
	
	<?php if (isset($pra) && !empty($pra)): ?>
	<div class="row">
		
		<div class="col-sm-12">
			<?php $exp_profesor = explode(", ", $pra); ?>
			<?php $nomprof = $exp_profesor[1].' '.$exp_profesor[0]; ?>
			
			<a name="history"></a>
			<legend>Historial de ausencias de <?php echo $nomprof; ?></legend>
			
			<div class="table-responsive">
				<table class="table table-striped table-hover" >
					<thead>
						<tr>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Horas</th>
							<th>Tareas</th>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<th>Observaciones</th>
							<th>&nbsp;</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php $result = mysqli_query($db_con, "SELECT inicio, fin, tareas, id, profesor, horas, archivo, observaciones FROM ausencias WHERE profesor = '$pra' ORDER BY fin ASC"); ?>
						<?php while ($row = mysqli_fetch_array($result)): ?>
						<tr>
							<td nowrap><?php echo $row['inicio']; ?></td>
							<td nowrap><?php echo $row['fin']; ?></td>
							<td nowrap>
							<?php if ($row['horas'] != '0') { 
							$hr = str_split($row['horas']);
							foreach ($hr as $hora){
								echo $hora."ª ";
							}
							}; ?>
							</td>
							<td>
							<?php echo (strlen($row['tareas']) > 0 or strlen($row['archivo'])>0) ? $row['tareas'] : 'No'; ?>
							<?php
							if(strlen($row['archivo'])>0){
							echo "<hr><span class='text-warning'>Archivo adjunto con las Tareas: </span><a href='archivos/".$row['archivo']."'><i class='fa fa-file fa-lg' data-bs='tooltip' title='Archivo adjunto con las tareas del profesor'> </i>";
							echo '</a>';
							}?>
							</td>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<td>
							<?php echo $row['observaciones']; ?>	
							</td>
							<td>
								<a href="index.php?borrar=1&id=<?php echo $row['id']; ?>&profesor=<?php echo $profesor; ?>" data-bb='confirm-delete'>
									<span class="fa fa-trash-o fa-fw fa-lg" data-bs="tooltip" title="Borrar"></span>
								</a>
							</td>
							<?php endif; ?>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

		</div><!-- /.col-sm-12 -->
				
	</div><!-- /.row -->
	<?php endif; ?>
	
</div><!-- /.container -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include("../../pie.php"); ?> 
<?php 
$exp_inicio_curso = explode('-', $config['curso_inicio']);
$inicio_curso = $exp_inicio_curso[2].'/'.$exp_inicio_curso[1].'/'.$exp_inicio_curso[0];

$exp_fin_curso = explode('-', $config['curso_fin']);
$fin_curso = $exp_fin_curso[2].'/'.$exp_fin_curso[1].'/'.$exp_fin_curso[0];

$result = mysqli_query($db_con, "SELECT fecha FROM festivos ORDER BY fecha ASC");
$festivos = '';
while ($row = mysqli_fetch_array($result)) {
	$exp_festivo = explode('-', $row['fecha']);
	$dia_festivo = $exp_festivo[2].'/'.$exp_festivo[1].'/'.$exp_festivo[0];
	
	$festivos .= '"'.$dia_festivo.'", ';
}

$festivos = substr($festivos,0,-2);
?>
	<script>  
	$(function ()  
	{ 
		$('#datimepicker1').datetimepicker({
			language: 'es',
			pickTime: false,
			minDate:'<?php echo $inicio_curso; ?>',
			maxDate:'<?php echo $fin_curso; ?>',
			disabledDates: [<?php echo $festivos; ?>],
			daysOfWeekDisabled:[0,6] 
		});
		
		$('#datimepicker2').datetimepicker({
			language: 'es',
			pickTime: false,
			minDate:'<?php echo $inicio_curso; ?>',
			maxDate:'<?php echo $fin_curso; ?>',
			disabledDates: [<?php echo $festivos; ?>],
			daysOfWeekDisabled:[0,6] 
		});
	});  
	</script>
	
	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  		"paging":   true,
	      "ordering": true,
	      "info":     false,
	      
	  		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
	  		
	  		"order": [[ 1, "desc" ]],
	  		
	  		"language": {
	  		            "lengthMenu": "_MENU_",
	  		            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
	  		            "info": "Página _PAGE_ de _PAGES_",
	  		            "infoEmpty": "No hay resultados disponibles.",
	  		            "infoFiltered": "(filtrado de _MAX_ resultados)",
	  		            "search": "Buscar: ",
	  		            "paginate": {
	  		                  "first": "Primera",
	  		                  "next": "Última",
	  		                  "next": "",
	  		                  "previous": ""
	  		                }
	  		        }
	  	});
	});
	</script>
	
</body>
</html>
