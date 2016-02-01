<?php
ini_set("session.cookie_lifetime","5600");
ini_set("session.gc_maxlifetime","7200");

require('../../bootstrap.php');

$profesor = $_SESSION ['profi'];
if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = 'disabled'; }

include ("../../menu.php");
include ("menu.php");

// PLUGINS
$PLUGIN_DATATABLES = 1;

if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE){
	$departament="Dirección del Centro";
}
else{
	if (empty($departamento)) {
		$departamento=$_SESSION['dpt'];
		$departament=$departamento;
	}
}
?>
<div class="container"><?php
echo '<div class="page-header">
  <h2>Actas del Departamento <small> Registro de Reuniones</small></h2>
  <h3 class="text-info">'.$departament.'</h3>
</div>';
?> <?php
if($borrar=="1"){
	$query = "DELETE from r_departamento WHERE id = '$id'";
	$result = mysqli_query($db_con, $query) or die ('<div align="center">
<div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Se ha borrado el registro de la base de datos.          
</div>
</div>');
}
if($edicion=="1"){
	$ed0 = mysqli_query($db_con, "select * from r_departamento where id = '$id'");
	$ed = mysqli_fetch_object($ed0);
}
if($submit=="Registrar Acta del Departamento")
{
	$errorList = array ();
	$count = 0;
	if (!$contenido) { $errorList[$count] = "Entrada inválida: Contenido del Acta"; $count++; }
	if (!$fecha) { $errorList[$count] = "Entrada inválida: Fecha"; $count++; }
	$tr_fecha = explode("-",$fecha);
	$fecha = "$tr_fecha[2]-$tr_fecha[1]-$tr_fecha[0]";
	if (sizeof ( $errorList ) == 0) {
		if (strstr($contenido,"FECHA_DE_LA_REUNIÓN")==TRUE) {
			$fecha_real = formatea_fecha($fecha);
			$contenido = str_replace("FECHA_DE_LA_REUNIÓN", $fecha_real, $contenido);
			$contenido = mysqli_real_escape_string($db_con, $contenido);
		}
		$query1 = "INSERT INTO r_departamento ( contenido, jefedep, timestamp, departamento, fecha, numero) VALUES( '$contenido', '$jefedep', NOW(), '$departament', '$fecha', '$numero')";
		//echo $query1;
		$query2 = "INSERT INTO r_departamento_backup ( contenido, jefedep, timestamp, departamento, fecha, numero) VALUES('$contenido', '$jefedep', NOW(), '$departament', '$fecha', '$numero')";
		$result1 = mysqli_query($db_con, $query1 ) or die ( '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Se ha producido un error grave al registar el Acta en la base de datos. Busca ayuda.<br><br>'.mysqli_error($db_con).'</div></div>' );
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Acta del Departamento ha sido registrada correctamente.
</div></div><br>';
		$result2 = mysqli_query($db_con, $query2 );
		echo '<div align="center"><a href="add.php" class="btn btn-primary">Volver atrás</a></div>';
		exit();
	}
	else {
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">Se encontraron los siguientes errores al enviar los datos del formulario: <br>';
		echo "<div align='left'><ul>";
		for($x = 0; $x < sizeof ( $errorList ); $x ++) {
			echo "<li>$errorList[$x]</li>";
		}
		echo "</ul></div></div></div><br>";
	}
}

elseif ($actualiza) {
	$tr_fecha = explode("-",$fecha);
	$fecha = "$tr_fecha[2]-$tr_fecha[1]-$tr_fecha[0]";
	mysqli_query($db_con, "update r_departamento set contenido = '$contenido', fecha='$fecha', numero='$numero' where id = '$id'") ;
	if (mysqli_affected_rows($db_con)>0) {
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
		El Acta del Departamento ha sido actualizada correctamente.
		</div></div><br>';
	}
	else{
		echo '<div align="center"><div class="alert alert-error alert-block fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
		El Acta del Departamento no ha podido ser actualizada. Busca ayuda.
		</div></div><br>';
	}

}
$nm0 = mysqli_query($db_con, "select max(numero) from r_departamento where departamento = '$departament'");
$numer = mysqli_fetch_array($nm0);
if ($edicion=="1") {
	$numero = $ed->numero;
}
else{
	$numero = $numer[0]+1;
}
$fecha2 = date ( 'Y-m-d' );
$hoy = formatea_fecha ( $fecha2 );
$d_rd0 = mysqli_query($db_con, "select hora, hora_inicio from tramos where tramos.hora = (select horw.hora from horw where prof = '$profesor' and c_asig = '51')");
$d_rd = mysqli_fetch_array($d_rd0);
$hor = $d_rd[0];
$hora = $d_rd[1];

if ($edicion=="1") {
	$exp_fecha_reg = explode('-', $ed->fecha);
	$fecha_r =  $exp_fecha_reg[2].'-'.$exp_fecha_reg[1].'-'.$exp_fecha_reg[0];
}

?>
<div class="row">


<div class="col-sm-8">

<div class="well">

<form method="post" action="add.php" name="f1">

<div class="row">

<div class="col-sm-5">

<div class="form-group" id="datetimepicker1"><label for="fecha">Fecha de
la Reunión</label>
<div class="input-group"><input type="text" class="form-control"
	name="fecha" id="fecha"
	value="<?php echo (isset($fecha_r)) ? $fecha_r : date('d-m-Y'); ?>"
	data-date-format="DD-MM-YYYY" required> <span class="input-group-addon"><span
	class="fa fa-calendar"></span></span></div>
</div>

</div>

<div class="col-sm-3 col-sm-offset-4">

<div class="form-group"><label for="numero">Nº de Acta</label> <input
	type="text" class="form-control" id="numero" name="numero"
	value="<?php echo $numero; ?>"></div>

</div>

</div>

<div class="form-group"><label for="editor">Acta</label> <textarea
	class="form-control" id="editor" name="contenido">
<?php if ($edicion=="1") {
	echo $ed->contenido;
}
else{
	?>
<p>
<?php
if ($departament == "Dirección del Centro") {
	$texto_dep = $departament;
}
else{
	$texto_dep = "Departamento de $departament";
}
?></p>

<?php echo $texto_dep; ?><br><?php echo $config['centro_denominacion'] ?> (<?php echo $config['centro_localidad'] ?>) <br>Curso Escolar: <?php echo $config['curso_actual'];?><br> Acta N&ordm; <?php echo $numero; ?>
</p>
<p><br></p>
<p style="text-align: center;"><strong
	style="text-decoration: underline;">ACTA DE REUNIÓN DEL DEPARTAMENTO</strong></p>
<p><br></p>
<p>En <?php echo $config['centro_localidad'] ?>, a las <?php echo $hora; ?> horas del FECHA_DE_LA_REUNIÓN, se re&uacute;ne el Departamento de <?php echo $departament; ?> del <?php echo $config['centro_denominacion'] ?> de <?php echo $config['centro_localidad'] ?>, con el siguiente <span
	style="text-decoration: underline;">orden del d&iacute;a</span>:</p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p><u>Profesores Asistentes:</u></p>
<p><br></p>
<p><br></p>
<p><u>Profesores Ausentes:</u></p>
<p><br></p>
<p><br></p>
<p><br></p>
<p>Sin más asuntos que tratar, se levanta la sesión a las <?php echo $hora+1; ?> horas.</p>
<p><br></p>
<p><br></p>
<p><br></p>
<?php if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
	$rd_profesor=$profesor;
}
else{
	$rd_profe = mysqli_query($db_con,"select nombre from departamentos where cargo like '%4%' and departamento = '$departament'");
	$rd_profes = mysqli_fetch_array($rd_profe);
	$rd_profesor = $rd_profes[0];
}
?>
<p>Fdo.: <?php echo $rd_profesor; ?></p>
<?php
}
?>
        		</textarea></div>

<div class="form-group"><label for="jefedep">Jefe del Departamento</label>
<input type="text" class="form-control" id="jefedep" name="jefedep"
	value="<?php echo $rd_profesor; ?>" readonly></div>

<?php
if ($edicion=="1") {
	echo '<input type="hidden" name="id" value="'.$id.'" class="btn btn-primary">';
	echo '<input type="submit" name="actualiza" value="Actualizar Acta del Departamento" class="btn btn-primary"'.$j_s.'>';
}
else{
	echo '<input type="submit" name="submit" value="Registrar Acta del Departamento" class="btn btn-primary" '.$j_s.'>';
}
?></form>

</div>
<!-- /.well --></div>
<!-- /.col-sm-8 -->

<div class="col-sm-4"><?php
$query = "SELECT id, fecha, departamento, contenido, numero, impreso FROM r_departamento where departamento = '$departament' ORDER BY numero DESC";
$result = mysqli_query($db_con, $query) or die ("Error in query: $query. " . mysqli_error($db_con));
$n_actas = mysqli_num_rows($result);
if (mysqli_num_rows($result) > 0)
{
	?> <legend>Actas del departamento</legend>
<table class="table table-striped datatable">
	<thead>
		<th style="width: 60px">Nº</th>
		<th>Fecha</th>
		<th></th>
	</thead>
	<?php while($row = mysqli_fetch_object($result)) { ?>
	<tr>
		<td nowrap><?php echo $row->numero; ?></td>
		<td nowrap><?php echo fecha_sin($row->fecha); ?></td>
		<td nowrap><a href="story.php?id=<?php echo $row->id; ?>"><span
			class="fa fa-search fa-fw fa-lg" data-bs="tooltip" title='Ver'></span></a>
			<?php
			if($row->impreso<>1){
				if ($j_s == 'disabled') {} else {
					?> <a href="pdf.php?id=<?php echo $row->id; ?>&imprimir=1"><span
			class="fa fa-print fa-fw fa-lg" data-bs="tooltip" title='Imprimir'> </span></a>
		<a href="add.php?borrar=1&id=<?php echo $row->id; ?>"
			data-bb="confirm-delete"><span class="fa fa-trash-o fa-fw fa-lg"
			data-bs="tooltip" title="Borrar el Acta"></span></a> <a
			href="add.php?edicion=1&id=<?php echo $row->id; ?>"><span
			class="fa fa-pencil fa-fw fa-lg" data-bs="tooltip" title="Editar"></span></a>
			<?php
				}
			}
			else{
				?> <a href="#"><span class="fa fa-check fa-fw fa-lg"
			data-bs="tooltip" title="El acta ha sido impresa"></span></a> <?php
			if ($j_s == 'disabled') {} else {
				?> <a href="pdf.php?id=<?php echo $row->id; ?>"><span
			class="fa fa-print fa-fw fa-lg" data-bs="tooltip" title="Imprimir"></span></a>
			<?php
			}
			}
			?></td>
	</tr>
	<?php
	}
	?>
</table>
	<?php
}
else
{
	?>
<div class="alert alert-warning alert-block fade in">
<button type="button" class="close" data-disiss="alert">&times;</button>
<h5>ATENCIÓN:</h5>
No hay Actas disponibles en la base de datos. Tu puedes ser el primero
en inaugurar la lista.</div>
	<?php
}
?></div>
</div>
</div>

<?php include("../../pie.php"); ?>

<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  

	$(document).ready(function() {
	
		// EDITOR DE TEXTO
		$('#editor').summernote({
			height: 360,
			lang: 'es-ES'
		});
	});

	$(document).ready(function() {
		var table = $('.datatable').DataTable({
		"paging":   true,
	    "ordering": false,
	    "info":     false,
	    "searching":   false,	    

		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
			
		"order": [[ 0, "desc" ]],
			
		"language": {
			            "lengthMenu": "_MENU_",
			            "zeroRecords": "Sin resultados.",
			            "info": "Página _PAGE_ de _PAGES_",
			            "infoEmpty": "No hay resultados disponibles.",
			            "infoFiltered": "(filtrado de _MAX_ resultados)",
			            "search": "",
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
