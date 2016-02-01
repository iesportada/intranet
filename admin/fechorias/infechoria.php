<?php
require('../../bootstrap.php');
require('../../lib/trendoo/sendsms.php');

include("../../menu.php");
include("menu.php");

?>
<script type="text/javascript">
      function GoBackTo(formulario, anchor)
      {
            formulario.action = 'infechoria.php#' + anchor;
            formulario.submit();
      }
</script>

<div class="container">

	<div class="page-header">
		<h2 style="display: inline;">Problemas de convivencia <small>Registro de un Problema de Convivencia</small></h2>
		
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
						<p>El registro de un Problema de Convivencia comienza con la selección de la 
						<em><strong>fecha</strong></em> en que sucedió. <br>Continúa con la selección de la 
						<em><strong>Unidad o Grupo de alumnos</strong></em> dentro del cual se encuentra el 
						autor del problema. El Grupo no es un campo obligatorio, simplemente facilita la 
						búsqueda al reducir la lista de alumnos.</p>
						<p>El campo <em><strong>Alumno/a</strong></em> presenta al principio la lista de todos 
						los alumnos del Centro ordenada alfabéticamente. Si elegimos un Grupo aparecerán los 
						alumnos de ese Grupo. Tanto en la lista total como en la lista de un Grupo podemos 
						seleccionar uno o varios alumnos. Como se señala en el texto de ayuda del formulario, 
						se pueden seleccionar múltiples alumnos mediante el uso de la tecla <kbd>CTRL</kbd> + 
						click sobre los distintos elementos; si queremos seleccionar a todo el Grupo, hacemos 
						click sobre el primero de la lista y, manteniendo presionada la tecla Mayúsculas 
						(<kbd>SHIFT</kbd>), seleccionamos el último de la lista.</p>
						<p>El segundo bloque de campos del formulario comienza con la elección de la 
						<em><strong>Gravedad</strong></em> del Problema que vamos a registrar. La Gravedad 
						puede ser: Leve, Grave, Muy Grave o Felicitar. Cada categoría va asociada a un conjunto de 
						<em><strong>Conductas Negativas, salvo la Felicitación, </strong></em> que aparecen en el ROF 
						del Centro y que puede ser editado por parte de los Administradores de la Intranet 
						(Administración de la Intranet --> A principio de 
						Curso --> Modificar ROF). Al cargar una de las categorías, el desplegable muestra las 
						Conductas Negativas propias de esa categoría. Seleccionamos una Conducta y aparecerán 
						al mismo tiempo la <em><strong>Medida Adoptada</strong></em> administrativamente (si 
						procede según el ROF) y las <em><strong>Medidas Complementarias</strong></em> que deben 
						tomarse (según el ROF). Si el alumno ha sido <em><strong>expulsado del Aula</strong></em>, 
						debe marcarse la opción correspondiente.</p>
						<p>En el campo <em><strong>Observaciones</strong></em> describimos el acontecimiento que 
						hemos tipificado. La descripción debe ser precisa y completa, de tal modo que tanto el 
						Tutor como el Jefe de Estudios como los propios Padres del alumno puedan hacerse una 
						idea ajustada de lo sucedido.</p>
						<p>El <em><strong>Profesor</strong></em> que informa del Problema y el Profesor que atiende 
						pueden ser elegidos de la lista con total libertad, aunque solamente los problemas distintos
						de 'leve' son atendidos en el Aula de Convivencia.</p>
						<p>El botón <em><strong>Registrar</strong></em> envía los datos del formulario y completa 
						el proceso de registro.</p>
						<p>Hay que tener en cuenta algunos detalles que suceden al registrar un Problema 
						de Convivencia:</p>
						<ul>
							<li>El Tutor recibe un mensaje en la Página principal cuando se 
							registra un Problema Grave o Muy Grave de alguno de sus alumnos. El mensaje ofrece 
							datos sobre el problema e indica el procedimiento a seguir. El Jefe de Estudios 
							también ve los Problemas que se van registrando en el momento de producirse.</li>
							<li>Los Problemas de Convivencia caducan según el tiempo 
							especificado en el ROF. Los valores por defecto de la aplicación son los siguientes: 
							30 días para los Leves y Graves; 60 días para los Muy Graves.</li>
							<li>Se puede editar el Problema registrado en los dos días 
							siguientes a la fecha en la que sucedió. Posteriormente, la edición queda bloqueada.</li>
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>

<div class="row">
<?php
//variables();

if (isset($_GET['id'])) { $id = $_GET['id'];}elseif (isset($_POST['id'])) { $id = $_POST['id'];}
if (isset($_GET['nombre'])) { $nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) { $nombre = $_POST['nombre'];}
if (isset($_GET['claveal'])) { $claveal = $_GET['claveal'];}elseif (isset($_POST['claveal'])) { $claveal = $_POST['claveal'];}
if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}
if (isset($_POST['informa'])) { $informa = $_POST['informa']; } else { $informa = $_SESSION['profi'];}
if (isset($_POST['horaEnvia'])) { $horaEnvia = $_POST['horaEnvia']; } else { $horaEnvia = getHora($db_con);}

//echo "\nHORA: ".$horaEnvia;

$notas = $_POST['notas']; 
$grave = $_POST['grave']; 
$asunto = $_POST['asunto'];
$fecha = $_POST['fecha'];
$medidaescr = $_POST['medidaescr'];
$medida = $_POST['medida'];
$expulsionaula = $_POST['expulsionaula'];
$atiende = $_POST['atiende'];
$horaAtiende = $_POST['horaAtiende'];

if (isset($_POST['submit1'])) {
	if (isset($_POST['felicitar']))
		include("felicitacion.php");
	else
		include("fechoria25.php");
}

// Actualizar datos
if ($_POST['submit2']) {
	mysqli_query($db_con, "update Fechoria set claveal='$nombre', asunto = '$asunto', notas = '$notas', grave = '$grave', medida = '$medida', expulsionaula = '$expulsionaula', informa='$informa', atiende='$atiende', horaEnvia='$horaEnvia', horaAtiende='$horaAtiende' where id = '$id'");

	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han actualizado correctamente.
          </div></div><br />';
}

// Si se envian datos desde el campo de búsqueda de alumnos, se separa claveal para procesarlo.
if ($_GET['seleccionado']=="1") {
	$claveal=$_GET['nombre'];
	$ng_al0=mysqli_query($db_con, "select unidad, apellidos, nombre from FALUMNOS where claveal = '$claveal'");
	$ng_al=mysqli_fetch_array($ng_al0);
	$unidad=$ng_al[0];
	$nombre_al=$ng_al[1].", ".$ng_al[2];
}
if ($_GET['id'] or $_POST['id']) {
	$result = mysqli_query($db_con, "select FA.apellidos, FA.nombre, FA.unidad, FA.nc, Fe.fecha, Fe.notas, Fe.asunto, Fe.informa, Fe.grave, Fe.medida, lf.medidas2, Fe.expulsion, Fe.tutoria, Fe.inicio, Fe.fin, aula_conv, inicio_aula, fin_aula, Fe.horas, expulsionaula, Fe.atiende, Fe.horaEnvia, Fe.horaAtiende from Fechoria Fe, FALUMNOS FA, listafechorias lf where Fe.claveal = FA.claveal and lf.fechoria = Fe.asunto  and Fe.id = '$id' order by Fe.fecha DESC");

	if ($row = mysqli_fetch_array($result))
	{

	$nombre_al = "$row[0], $row[1]";
	$unidad = $row[2];
	$fecha = $row[4];
	$notas = $row[5];

	$informa = $row[7];
	if ($asunto or $grave) 
		{}
	else{
		$grave = $row[8];
		$asunto = $row[6];
	}
	
	$medida = $row[9];
	$medidas2 = $row[10];
	$expulsion = $row[11];
	$tutoria = $row[12];
	$inicio = $row[13];
	$fin = $row[14];
	$convivencia = $row[15];
	$inicio_aula = $row[16];
	$fin_aula = $row[17];
	$horas = $row[18];
	$expulsionaula = $row[19];
	$atiende = $row[20];
	$horaEnvia = $row[21];
	$horaAtiende = $row[22];
	}
}
?>

<form method="post" action="infechoria.php" name="Cursos">
	<fieldset>
	<div class="col-sm-6">
	<div class="well">

	<div class="form-group" id="datetimepicker1">
		<label for="fecha">Fecha</label>
		<div class="input-group">
			<input name="fecha" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fecha" 
				value="<?php if($fecha == "") { echo date('d-m-Y'); } else { echo $fecha;}?>"	required> 
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>
	</div>

	<div class="row">	
		<div class="col-sm-7">

			<div class="form-group"><label class="informa">Profesor que envía</label> 
      			<select class="form-control" id="informa" name="informa">
					<option></option>
					<?php 
					$prof = mysqli_query($db_con, "SELECT distinct prof FROM horw order by prof asc");
					while($filaprofe = mysqli_fetch_array($prof))
					{
						$sel="";
						$nombreprof = nomprofesor($filaprofe[0]);
						if ($informa==$nombreprof)
							$sel = " selected ";
						echo "<option value='$nombreprof' $sel>".$nombreprof."</option>";
					}?>
    			</select>
			</div>
		</div><!-- /.col-sm-7 -->

		<div class="col-sm-5">
			<div class="form-group">
				<label for="hora">Hora</label>
				<select class="form-control" id="horaEnvia" name="horaEnvia">
					<option></option>
					<?php 
					$result_horas = mysqli_query($db_con,"SELECT hora_inicio, hora_fin, hora FROM tramos");
					while ($horas = mysqli_fetch_array($result_horas))
					{
						$sel = "";
						if ($horas['hora'] == $horaEnvia) 
							$sel = " selected ";
						echo "<option value='".$horas['hora']."'".$sel.">"."(".$horas['hora']."ª) ". $horas['hora_inicio']." - ".$horas['hora_fin']."</option>";
					}?>
	    	    </select>
			</div>
		</div><!-- /.col-sm-5 -->
	</div><!-- /.row -->

	<div class="row">	
		<div class="col-sm-7">

			<div class="form-group"><label for="atiende">Profesor que atiende en A.C. (solo graves)</label> 
    	    	<select	class="form-control" id="atiende" name="atiende">
					<?php echo '<OPTION value="'.$atiende.'">'.nomprofesor($atiende).'</OPTION>';
					$profe = mysqli_query($db_con, " SELECT distinct prof FROM horw order by prof asc");
					while($filaprofe = mysqli_fetch_array($profe)) {
						echo '<OPTION value="'.$filaprofe[0].'">'.nomprofesor($filaprofe[0]).'</OPTION>';
					}?>
       			</select>
			</div>
		</div><!-- /.col-sm-7 -->
		
		<div class="col-sm-5">
			<div class="form-group"><label for="hora">Hora en A.C.</label>
				<select class="form-control" id="horaAtiende" name="horaAtiende">
					<option value=""></option>
					<?php $result_horas = mysqli_query($db_con,"SELECT hora_inicio, hora_fin, hora FROM tramos"); ?>
					<?php while ($horas = mysqli_fetch_array($result_horas)): ?>
					<option value="<?php echo $horas['hora']; ?>" <?php echo (isset($horaAtiende) && $horas['hora'] == $horaAtiende) ? 'selected' : ''; ?>>
	         		               <?php echo '('.$horas['hora'].'ª) '. $horas['hora_inicio'].' - '.$horas['hora_fin']; ?>
	        		</option>
					<?php endwhile; ?>
	        	</select>
			</div>
		</div><!-- /.col-sm-5 -->
	</div><!-- /.row -->

	<a name="unidad"></a>
	<div class="form-group">
		
		<label for="unidad">Unidad</label> 
		<select class="form-control" id="unidad" name="unidad" onchange="javascript:GoBackTo(this.form,'unidad');">
			<option><?php echo $unidad;?></option>
			<?php unidad($db_con);?>
		</select>
	</div>
	
	<label for="nombre">Alumno/a</label> 
		<?php if ((isset($nombre)) and isset($unidad) and !(is_array($nombre)))
		{
		//echo "<OPTION value='$claveal' selected>$nombre_al</OPTION>";

		echo '<select class="form-control" id="nombre" name="nombre" required>';
		$alumnos = mysqli_query($db_con, "SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE unidad = '$unidad' order by APELLIDOS asc");

		while($falumno = mysqli_fetch_array($alumnos))
		{
			if ($nombre==$falumno[2]){
			$sel = " selected ";
			}
			else{
				$sel="";
			}
			echo "<OPTION value='$falumno[2]'  $sel>$falumno[0], $falumno[1]</OPTION>";
		}
		?>
		</select>
		<?php
	}
	else {
		?>
		<select class="form-control" id="nombre" name="nombre[]" multiple="multiple" style="height: 450px;" required>
		<?php
		if ($unidad) {
			$uni = " WHERE unidad like '$unidad%'";
		}
		else{
			$uni="";
		}
		$alumnos = mysqli_query($db_con, " SELECT APELLIDOS, NOMBRE, claveal FROM FALUMNOS $uni order by APELLIDOS asc");
		while($falumno = mysqli_fetch_array($alumnos))
		{
			$sel="";
			if (is_array($nombre)) {
				foreach($nombre as $n_alumno){
					
					if ($n_alumno==$falumno[2]){
						$sel = " selected ";
					}
				}
			}
			echo "<OPTION value='$falumno[2]'  $sel>$falumno[0], $falumno[1]</OPTION>";
		}
		?>
		</select>
		
	<?php
	}
	?>
	</div>
</div>

<div class="col-sm-6">
<div class="well">

<a name="tipo"></a>
<div class="form-group">
	
	<label for="grave">Tipo</label>
	<select	class="form-control" id="grave" name="grave" onchange="javascript:GoBackTo(this.form,'tipo');" required>

		<?php $sql0 = mysqli_query($db_con, "select distinct(tipo) from listafechorias");
				echo "<option></option>";
				while($fecho = mysqli_fetch_array($sql0))
				{
					if ($grave==$fecho[0])
						$sel = " selected ";
					else
						$sel="";
					echo "<OPTION value='$fecho[0]' $sel>$fecho[0]</OPTION>";
				}
		?>

	</select>
</div>

<a name="hecho"></a>
<div class="form-group">	
	<label for="asunto">Hecho Detectado</label>
	<select	class="form-control" id="asunto" name="asunto" onchange="javascript:GoBackTo(this.form,'descripcion');" required>
		<?php $sql0 = mysqli_query($db_con, "select fechoria, medidas from listafechorias where tipo = '$grave'");
				echo "<option></option>";
				while($fecho = mysqli_fetch_array($sql0))
				{
					if ($asunto==$fecho[0]) {
						$sel = " selected ";
						$medidaNueva = $fecho[1];
					}
					else {
						$sel="";
					}
					echo "<OPTION value='$fecho[0]' $sel>$fecho[0]</OPTION>";
				}
				if ($medidaNueva) 
					$medida = $medidaNueva;
		?>
	</select>
</div>

<div class="form-group">
	
	<label class="medida">Medida a Tomar</label>
		<input type="hidden" id="medida" name="medida" value="<?php echo $medida?>">
		<input type="text" value="<?php echo $medida;?>" readonly class="form-control" />
</div>

<div class="form-group">
	<label for="medidas">Explicación/Medidas complementarias</label>
	<textarea class="form-control" id="medidas"	name="medidas" rows="7" disabled><?php if($medidas) {echo $medidas;}else {medida2($db_con, $asunto);} ?>
	</textarea>
</div>
 
<a name="descripcion"></a>
<?php
if($grave == 'grave' or $grave == 'muy grave')
{	?> 
	<div class="checkbox">
		<label> <input type="checkbox" id="expulsionaula" name="expulsionaula" value="1" checked
		<?php  if ($expulsionaula == "1") { echo " checked ";}?>> El alumno ha sido <u>expulsado</u> del aula </label>
	</div>
<?php
}
if ($grave == 'felicitar' or $grave == 'leve')
{ ?>
	<?php if ($grave == 'felicitar') {echo "<input type='hidden' id='felicitar' name='felicitar' value='1'>";} ?>
	<div class="form-group">
		<label for="notas">Descripción:</label><textarea class="form-control" id="notas" name="notas" rows="7" placeholder="Describe aquí los detalles [opcional]..." ><?php echo $notas; ?></textarea>
	</div>
<?php
} else {
?>
<div class="form-group">
	
	<label for="notas">Descripción:</label><textarea class="form-control" id="notas" name="notas" rows="7" placeholder="Describe aquí los detalles del incidente...[obligatorio]" required><?php echo $notas; ?></textarea>
</div>
<?php } ?>

<hr />
<?php
if ($id) {
	echo '<input type="hidden" name="id" value="'.$id.'">';
	echo '<input type="hidden" name="claveal" value="'.$claveal.'">';
	echo '<input name = "submit2" type="submit" value="Actualizar datos" class="btn btn-warning btn-lg">';
}
else{
	echo '<input name=submit1 type=submit value="Registrar" class="btn btn-primary btn-lg">';
}
?>

</fieldset>
</form>



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
