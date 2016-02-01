<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 8));

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
?>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
  		<h2 style="display:inline;">Orientación <small>Intervenciones sobre los alumnos</small></h2>
  		
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
						<p>Las Intervenciones del Departamento de Orientación funcionan a modo de
						Diario donde se registran las actividades de distinto tipo (entrevistas 
						con Padres o Alumnos, llamadas de teléfono, etc.) asociadas a determinadas 
						causas (Orientación académica, evolución de estudios, técnicas de estudio, 
						etc.) que el Departamento realiza dentro de sus funciones. El Orientador 
						recoge los datos de las intervenciones de tal modo que pueda hacer un 
						seguimiento de sus actividades con los alumnos del Centro.</p>
						<p>Además de sus propias Intervenciones (color azul), el Departamento puede 
						ver las Intervenciones del Tutor (color naranja) así como otras intervenciones 
						generadas por procesos automatizadas (envío de SMS por faltas de asistencia, 
						problemas de convivencia, etc.) sobre un determinado alumno dentro del 
						historial del mismo.</p>
						<p>La página presenta el formulario de intervenciones y una lista con todas 
						las intervenciones realizadas ordenadas por fecha. Al hacer click sobre un 
						alumno de esta lista, se visualiza la intervención en el formulario 
						(pudiendo editarla, borrarla, etc.) y aparece el historial de las 
						intervenciones sobre el alumno bajo el formulario.</p>
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
	
<?php
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
elseif(isset($_POST['id'])){
	$id = $_POST['id'];
}
else{
	$id = "";
}
if (isset($_GET['eliminar'])) {
	$eliminar = $_GET['eliminar'];
}

if (isset($_POST['fecha_reg'])) {
	$fecha_reg = $_POST['fecha_reg'];
} else{$fecha_reg="";}
if (isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
} elseif (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
} else{$unidad="";}

if (isset($_POST['alumno'])) {
	$alumno = $_POST['alumno'];
} elseif (isset($_GET['alumno'])) {
	$alumno = $_GET['alumno'];
}   else{$alumno="";}
if (isset($_POST['observaciones'])) {
	$observaciones = $_POST['observaciones'];
} else{$observaciones="";}
if (isset($_POST['accion'])) {
	$accion = $_POST['accion'];
} else{$accion="";}
if (isset($_POST['causa'])) {
	$causa = $_POST['causa'];
} else{$causa="";}
if (isset($_POST['id2'])) {
	$id2 = $_POST['id2'];
} else{$id2="";}
if (isset($_GET['id3'])) {
	$id2 = $_GET['id3'];
} else{$id3="";}
if (isset($_POST['unidad0'])) {
	$unidad0 = $_POST['unidad0'];
} else{$unidad0="";}
if (isset($_POST['prohibido'])) {
	$prohibido = $_POST['prohibido'];
}else{$prohibido="";}

if (isset($_POST['submit1'])) {
	$submit1 = $_POST['submit1'];
		include("insertar.php");
}

if ($id) {
	$result = mysqli_query($db_con, "select apellidos, nombre, fecha, accion, causa, observaciones, unidad, tutor, id, prohibido, claveal from tutoria where id = '$id'");
	$row = mysqli_fetch_array($result);
	$alumno = $row[0].", ".$row[1]." --> ".$row[10];
	$fecha0 = $row[2];
	$dia = explode("-",$fecha0);
	$fecha_reg = "$dia[2]-$dia[1]-$dia[0]";
	$accion0 = $row[3];
	$causa = $row[4];
	$observaciones = $row[5];
	$unidad = $row[6];
	$tutor = $row[7];
	$id = $row[8];
	$prohibido = $row[9];
	$clave = $row[10];
}

if ($eliminar=="1") {
	mysqli_query($db_con, "delete from tutoria where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';	
}

if (isset($_POST['submit2'])) {  
	foreach($accion as $tipos)
	{
		$completo .= $tipos."; ";
	}
	$dia = explode("-",$fecha_reg);
	$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
	$actualizar ="UPDATE  tutoria SET observaciones = '$observaciones', causa = '$causa', accion = '$completo', fecha = '$fecha2', prohibido = '$prohibido' WHERE  id = '$id2'";
	//echo $actualizar;
	mysqli_query($db_con, $actualizar);
}
if (isset($_POST['submit3'])) {
	$actualizar ="delete from tutoria WHERE  id = '$id2'";
	mysqli_query($db_con, $actualizar);
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido actualizado en la Base de datos.
</div></div><br />';	
}

?>
<div class="col-sm-7">
<legend>Registro de datos</legend>
<div class="well well-large">

<FORM action="tutor.php" method="POST" name="Tutor">

<fieldset>
<div class="row">
<div class="col-md-10">
<div class="form-group">
<label> Grupo </label>
<SELECT name="unidad"
	onChange="submit()" class="form-control">
	<option><?php echo $unidad;?></option>
	<?php unidad($db_con);?>
</SELECT> 
</div>
</div>
<div class="col-md-2">
<?php    
if ($alumno) {
	$tr = explode(" --> ",$alumno);
	$al = $tr[0];
	$clave = $tr[1];
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<img src='../../xml/fotos/$clave.jpg' width='120' height='145' class='img-thumbnail pull-right'  />";
	}
	else{
		echo "<i class='fa fa-user fa-5x fa-fw'></i>";
	}
}
?> 
</div>
</div>


<div class="row">
<div class="col-sm-7">
<div class="form-group"><label for="alumno">Alumno/a</label> 
<?php $result = mysqli_query($db_con, "SELECT DISTINCT APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE unidad='$unidad' ORDER BY NC ASC"); ?>
<?php if(mysqli_num_rows($result)): ?> <select class="form-control"
	id="alumno" name="alumno" onchange="submit()">
	<option></option>
	<option value="Todos los Alumnos">Todos los Alumnos</option>
	<?php while($row = mysqli_fetch_array($result)): ?>
	<option
		value="<?php echo $row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['claveal']; ?>"
		<?php echo (isset($alumno) && ($row['APELLIDOS'].', '.$row['NOMBRE'].' --> '.$row['claveal']) == $alumno) ? 'selected' : ''; ?>><?php echo $row['APELLIDOS'].', '.$row['NOMBRE']; ?></option>
		<?php endwhile; ?>
		<?php mysqli_free_result($result); ?>
</select> <?php else: ?> <select class="form-control" name="alumno"
	disabled>
	<option></option>
</select> <?php endif; ?></div>
</div>

<div class="col-sm-5">
<div class="form-group" id="datetimepicker1"><label for="fecha_reg">Fecha</label>
<div class="input-group"><input name="fecha_reg" type="text"
	class="input form-control"
	value="<?php echo (isset($id) && $fecha_reg) ? $fecha_reg : date('d-m-Y'); ?>"
	data-date-format="DD-MM-YYYY" id="fecha_reg"> <span
	class="input-group-addon"><i class="fa fa-calendar"></i></span></div>
</div>
</div>
</div>
<?php

	$index = substr($config['curso_actual'],0,4)+1;
	for ($i = 0; $i < 6; $i++) {
	$ano = $db."".($index-$i);
		$rep=mysqli_query($db_con,"select matriculas from $ano.alma where claveal='$clave' and matriculas>'1'");
		//echo "select matriculas from $ano.alma where claveal='$clave' and matriculas>'1'<br>";
		if (mysqli_num_rows($rep)>0) {
		$repite.= (($index-$i)-1)."/".($index-$i)." ";
	}
	}
	if (strlen($repite)>0) {
		echo '<div class="row">
							<div class="col-sm-12">
							<div class="form-group has-warning">';
			echo "<input type ='text' disabled class='form-control' placeholder='Cursos repetidos: $repite' />"; 
			echo '</div></div></div>';
	}
?>	
<div class="form-group">
<label> Observaciones </label>
<textarea name='observaciones' rows='8' class='form-control'><?php echo $observaciones; ?></textarea>
</div>

<div class="checkbox">
  <label class="text-danger">
    <input name="prohibido" type="checkbox" <?php if ($prohibido == "1"){echo "checked";}
 ?> id="prohibido" value="1"> Informe privado </label>
</div>

  <div class="row">
  <div class="col-sm-6">
  
<div class="form-group">  
<label>Causa </label>
<select name="causa" class='form-control'>
	<option><?php echo $causa; ?></option>
	<option>Orientación académica y profesional</option>
	<option>Evoluci&oacute;n acad&eacute;mica</option>
	<option>T&eacute;cnicas de estudio</option>
	<option>Problemas de convivencia</option>
	<option>Dificultades de integraci&oacute;n</option>
	<option>Problemas familiares, personales</option>
	<option>Dificultades de Aprendizaje</option>
	<option>Faltas de Asistencia</option>
	<option>Otras</option>
</select> 
</div> 
</div>
<div class="col-sm-6">
  
<div class="form-group">  
<label>Tipo</label>
<select name="accion[]" multiple class='form-control'>


<?php
$opcion = array(   'Entrevista con el Alumno',
		      'Entrevista personal con la Familia',
                          'Entrevista con el Equipo Educativo',
                          'Entrevista telefónica con la familia',
                          'Derivación a Servicios Sociales',
                          'Derivación a Asistencia médica',
                          'Derivación a Asistencia psicológica ',
                          'Contacto con Servicios Sociales',
                          'Contacto con Equipo de Tratamiento Familiar',
                          'Contacto con Del. de Juventud ',
                          'Contacto con EOE');
foreach ($opcion as $opc)
{
	$sel = "";
	if (!(strstr($accion0,$opc) == FALSE)) {
		$sel = "selected";
	}
	echo "<option $sel>$opc</option>";
}
?>
</select>
</label>
</div>
</div>
</div>
</div>



<input name="id2" type="hidden" value="<?php echo $id; ?>" /> <input
	name='submit1' type='submit'
	value='Registrar intervención' class='btn btn-primary'>
&nbsp; <input name='submit2' type='submit'
	value='Actualizar datos' class='btn btn-warning'>
&nbsp;<input name=submit3 type=submit
	value='Eliminar' class='btn btn-danger'>
</form>

<?php
if($alumno){
	$tr = explode(" --> ",$alumno);
	$al = $tr[0];
	$clave = $tr[1];
	$trozos = explode (", ", $al);
	$apellidos = $trozos[0];
	$nombre = $trozos[1];
	?>
<hr>
<div class="well">
<h4>Historial de Intervenciones sobre <?php echo $nombre." ".$apellidos." (".$unidad.")"; ?></h4><br>
	<?php

	$result = mysqli_query($db_con, "select apellidos, nombre, fecha, accion, causa, observaciones, id, orienta, jefatura, prohibido from tutoria where claveal='$clave' order by fecha");
	if ($row = mysqli_fetch_array($result))
	{
		echo '<table class="table table-striped">';
		echo "<thead><tr><th>Fecha</th><th>Clase</th><th>Causa</th><th></th></tr></thead><tbody>";
		do{

			$obs=substr($row[5],0,80)."...";
			$dia3 = explode("-",$row[2]);
			$fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
			if($row[7]=="1"){$orienta = " class='info'";}elseif($row[8]=="1"){$orienta = " class='warning'";}else{$orienta="";}
			echo "<tr $orienta><td>$fecha3</td><td>$row[3]</td><td>$row[4]</a></td><td >
<a href='tutor.php?id=$row[6]'><i class='fa fa-search' title='Detalles'> </i> </a>
<a href='tutor.php?id=$row[6]&eliminar=1'><i class='fa fa-trash-o </i> ' title='Borrar'></a></td></tr>";
		}while($row = mysqli_fetch_array($result));
		echo "</tbody></table>";
	}
	echo "</div>";
}
?>

</div>



<div class="col-sm-5">
<legend>Intervenciones de Orientación</legend>
<?php include("ultimos.php");?>
</div>
</div>
</div>
<?php include("../../pie.php");?>
	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
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
