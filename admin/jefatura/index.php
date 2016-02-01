<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];

// PLUGINS
$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");
?>

<div
	class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Jefatura de estudios <small>Intervenciones sobre los alumnos</small></h2>
</div>

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

if (isset($_POST['nivel'])) {
	$nivel = $_POST['nivel'];
}
elseif (isset($_GET['nivel'])) {
	$nivel = $_GET['nivel'];
}
else {
	$nivel = "";
}

if (isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
}
elseif (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
}
else {
	$unidad = "";
}

if (isset($_POST['alumno'])) {
	$alumno = $_POST['alumno'];
}
elseif (isset($_GET['alumno'])) {
	$alumno = $_GET['alumno'];
}
else {
	$alumno = "";
}


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
if (isset($_POST['nivel0'])) {
	$nivel0 = $_POST['nivel0'];
} else{$nivel0="";}
if (isset($_POST['grupo0'])) {
	$grupo0 = $_POST['grupo0'];
} else{$grupo0="";}
if (isset($_POST['prohibido'])) {
	$prohibido = $_POST['prohibido'];
}else{$prohibido="";}

if (isset($_POST['submit1'])) {
	include("insertar.php");
}

if (isset($_POST['submit2'])) {
	$dia = explode("-",$fecha);
	$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
	$actualizar ="UPDATE  tutoria SET observaciones = '$observaciones', causa = '$causa', accion = '$accion', fecha = '$fecha2', prohibido = '$prohibido' WHERE  id = '$id2'";
	mysqli_query($db_con, $actualizar);
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido actualizado en la Base de datos.
</div></div><br />';
}

if (isset($_POST['submit3']) or $eliminar=="1") {
	$borrar ="delete from tutoria WHERE  id = '$id2'";
	mysqli_query($db_con, $borrar);
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';
}

if ($id and ($unidad=='' and $alumno=='')) {
	$result = mysqli_query($db_con, "select apellidos, nombre, fecha, accion, causa, observaciones, unidad, tutor, id, prohibido, claveal from tutoria where id = '$id'");
	$row = mysqli_fetch_array($result);
	$alumno = $row[0].", ".$row[1]." --> ".$row[10];
	$fecha0 = $row[2];
	$dia = explode("-",$fecha0);
	$fecha_reg = "$dia[2]-$dia[1]-$dia[0]";
	$accion = $row[3];
	$causa = $row[4];
	$observaciones = $row[5];
	$unidad = $row[6];
	$tutor = $row[7];
	$id = $row[8];
	$prohibido = $row[9];
	$clave = $row[10];
}


?> <!-- SCAFFOLDING -->
<div class="row"><!-- COLUMNA IZQUIERDA -->
<div class="col-sm-7"><?php if(isset($id) && $alumno && !($alumno == "Todos los Alumnos")): ?>
<?php $tr = explode(" --> ",$alumno); ?> <?php $al = $tr[0]; ?> <?php $clave = $tr[1]; ?>
<?php endif; ?> <legend>Registro de datos</legend>

<div class="well">

<form method="post" action="index.php">
<fieldset><?php if(isset($id)): ?> <input type="hidden" name="id2"
	value="<?php echo $id; ?>"> <?php endif; ?>

<div class="row"><!--FORMLISTACURSOS
							<div class="col-sm-6">
									<div class="form-group">
										<label for="curso">Curso</label>
									</div>
							</div>
							FORMLISTACURSOS//-->

<div class="col-sm-10">
<div class="form-group"><label for="unidad">Unidad</label> <?php $result = mysqli_query($db_con, "SELECT DISTINCT unidad, SUBSTRING(unidad,2,1) AS orden FROM alma ORDER BY orden ASC"); ?>
<?php if(mysqli_num_rows($result)): ?> <select class="form-control"
	id="unidad" name="unidad" onchange="submit()">
	<option></option>
	<?php while($row = mysqli_fetch_array($result)): ?>
	<option value="<?php echo $row['unidad']; ?>"
	<?php echo ($row['unidad'] == $unidad) ? 'selected' : ''; ?>><?php echo $row['unidad']; ?></option>
	<?php endwhile; ?>
	<?php mysqli_free_result($result); ?>
</select> <?php else: ?> <select class="form-control" name="unidad"
	disabled>
	<option></option>
</select> <?php endif; ?></div>
</div>
<div class="col-md-2"><?php    
if ($clave !== "") {
	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<img src='../../xml/fotos/$clave.jpg' width='120' height='145' class='img-thumbnail pull-right'  />";
	}
	else{
		echo "<i class='fa fa-user fa-5x fa-fw'></i>";
	}
}
?></div>
</div>

<div class="row">
<div class="col-sm-7">
<div class="form-group"><label for="alumno">Alumno/a</label> <?php $result = mysqli_query($db_con, "SELECT DISTINCT APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE unidad='$unidad' ORDER BY NC ASC"); ?>
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
<div class="form-group" id="datetimepicker1"><label for="fecha_reg">Fecha
</label>
<div class="input-group"><input name="fecha_reg" type="text"
	class="form-control"
	value="<?php echo (isset($id) && $fecha_reg) ? $fecha_reg : date('d-m-Y'); ?>"
	data-date-format="DD-MM-YYYY" id="fecha_reg" required> <span
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

<div class="form-group"><label for="observaciones">Observaciones</label>
<textarea class="form-control" id="observaciones" name="observaciones"
	placeholder="Escriba la intervención realizada sobre el alumno..."
	rows="10"><?php echo (isset($id) && $observaciones) ? $observaciones : ''; ?></textarea>
</div>

<div class="row">
<div class="col-sm-6">
<div class="form-group"><label for="causa">Causa</label> <select
	class="form-control" id="causa" name="causa">
	<option value="Estado general del Alumno"
	<?php echo (isset($id) && $causa == 'Estado general del Alumno') ? 'selected' : ''; ?>>Estado
	general del Alumno</option>
	<option value="Evolución académica"
	<?php echo (isset($id) && $causa == 'Evolución académica') ? 'selected' : ''; ?>>Evolución
	académica</option>
	<option value="Faltas de Asistencia"
	<?php echo (isset($id) && $causa == 'Faltas de Asistencia') ? 'selected' : ''; ?>>Faltas
	de Asistencia</option>
	<option value="Problemas de convivencia"
	<?php echo (isset($id) && $causa == 'Problemas de convivencia') ? 'selected' : ''; ?>>Problemas
	de convivencia</option>
	<option value="Llamada por Enfermedad"
	<?php echo (isset($id) && $causa == 'Llamada por Enfermedad') ? 'selected' : ''; ?>>Llamada
	por Enfermedad</option>
	<option value="Robo, hurto"
	<?php echo (isset($id) && $causa == 'Robo, hurto') ? 'selected' : ''; ?>>Robo,
	hurto</option>
	<option value="Otras"
	<?php echo (isset($id) && $causa == 'Otras') ? 'selected' : ''; ?>>Otras</option>
</select></div>
</div>

<div class="col-sm-6">
<div class="form-group"><label for="accion">Tipo</label> <select
	class="form-control" id="accion" name="accion">
	<option value="Entrevista telefónica"
	<?php echo (isset($id) && $accion == 'Entrevista telefónica') ? 'selected' : ''; ?>>Entrevista
	telefónica</option>
	<option value="Entrevista personal"
	<?php echo (isset($id) && $accion == 'Entrevista personal') ? 'selected' : ''; ?>>Entrevista
	personal</option>
	<option value="Comunicación por escrito"
	<?php echo (isset($id) && $accion == 'Comunicación por escrito') ? 'selected' : ''; ?>>Comunicación
	por escrito</option>
</select></div>
</div>
</div>

<div class="checkbox"><label> <input type="checkbox" name="prohibido"
	value="1" <?php echo (isset($id) && $prohibido) ? 'checked' : ''; ?>>
Informe privado </label></div>


	<?php if(isset($id) && $id): ?>
<button type="submit" class="btn btn-primary" name="submit2">Actualizar</button>
<button type="submit" class="btn btn-danger" name="submit3"
	onclick="confirmacion();">Eliminar</button>
<a class="btn btn-default" href="index.php">Nueva intervención</a> <?php else: ?>
<button type="submit" class="btn btn-primary" name="submit1">Registrar</button>
	<?php endif; ?></fieldset>

</form>

</div>
<!-- /.well --> <?php
if($alumno){
	$tr = explode(" --> ",$alumno);
	$al = $tr[0];
	$clave = $tr[1];
	$trozos = explode (", ", $al);
	$apellidos = $trozos[0];
	$nombre = $trozos[1];
	?>
<div class="well">
<h4>Historial de intervenciones de <?php echo $nombre." ".$apellidos; ?></h4>
<br>
	<?php
	$result = mysqli_query($db_con, "select apellidos, nombre, fecha, accion, causa, observaciones, id, orienta, prohibido from tutoria where claveal = '$clave' order by fecha");

	if ($row = mysqli_fetch_array($result)) {
		echo '<table class="table table-striped">';
		echo "<thead><tr><th>Fecha</th><th>Clase</th><th>Causa</th><th></th></tr></thead><tbody>";
			
		do{
			$obs=substr($row[5],0,80)."...";
			$dia3 = explode("-",$row[2]);
			$fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
			echo "<tr><td>$fecha3</td><td>$row[3]</a></td><td>$row[4]</a></td><td >
						<a href='index.php?id=$row[6]' data-bs='tooltip' title='Ver informe'><i class='fa fa-search fa-lg fa-fw'></i></a>
						</td></tr>";
		}
		while($row = mysqli_fetch_array($result));

		echo "</table>";
	}
	else {
		echo '<br><p class="lead text-center text-muted">El alumno/a no tiene intervenciones registradas.</p>';
	}
	?></div>
<!-- /.well --> <?php
}
?></div>
<!-- /.col-sm-7 --> <!-- COLUMNA DERECHA -->
<div class="col-sm-5"><legend>Intervenciones</legend> <?php include("ultimos.php");?>

</div>
<!-- /.col-sm-5 --></div>
<!-- /.row --></div>
<!-- /.container -->

<?php include("../../pie.php");?>

<script>  
	$(document).ready(function() {
		var table = $('.datatable').DataTable({
			"paging":   true,
	    "ordering": true,
	    "info":     false,
	    
			"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
			
			"order": [[ 0, "desc" ]],
			
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
	
	// DATETIMEPICKER
	$(function () {
	    $('#datetimepicker1').datetimepicker({
	    	language: 'es',
	    	pickTime: false
	    });
	});
	</script>
	
</body>
</html>
