<?php
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['unidad1'])) {$unidad1 = $_GET['unidad1'];}elseif (isset($_POST['unidad1'])) {$unidad1 = $_POST['unidad1'];}else{$unidad1="";}
if (isset($_GET['mes'])) {$mes = $_GET['mes'];}elseif (isset($_POST['mes'])) {$mes = $_POST['mes'];}else{$mes="";}
if (isset($_GET['FALTA'])) {$FALTA = $_GET['FALTA'];}elseif (isset($_POST['FALTA'])) {$FALTA = $_POST['FALTA'];}else{$FALTA="";}
if (isset($_GET['numero2'])) {$numero2 = $_GET['numero2'];}elseif (isset($_POST['numero2'])) {$numero2 = $_POST['numero2'];}else{$numero2="";}
if (isset($_GET['submit1'])) {$submit1 = $_GET['submit1'];}elseif (isset($_POST['submit1'])) {$submit1 = $_POST['submit1'];}else{$submit1="";}
if (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (isset($_GET['fecha4'])) {$fecha4 = $_GET['fecha4'];}elseif (isset($_POST['fecha4'])) {$fecha4 = $_POST['fecha4'];}else{$fecha4="";}
if (isset($_GET['fecha3'])) {$fecha3 = $_GET['fecha3'];}elseif (isset($_POST['fecha3'])) {$fecha3 = $_POST['fecha3'];}else{$fecha3="";}
if (isset($_GET['submit2'])) {$submit2 = $_GET['submit2'];}elseif (isset($_POST['submit2'])) {$submit2 = $_POST['submit2'];}else{$submit2="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}
if (isset($_GET['fecha10'])) {$fecha10 = $_GET['fecha10'];}elseif (isset($_POST['fecha10'])) {$fecha10 = $_POST['fecha10'];}else{$fecha10="";}
if (isset($_GET['fecha20'])) {$fecha20 = $_GET['fecha20'];}elseif (isset($_POST['fecha20'])) {$fecha20 = $_POST['fecha20'];}else{$fecha20="";}
if (isset($_GET['submit4'])) {$submit4 = $_GET['submit4'];}elseif (isset($_POST['submit4'])) {$submit4 = $_POST['submit4'];}else{$submit4="";}
if (isset($_GET['submit3'])) {$submit3 = $_GET['submit3'];}elseif (isset($_POST['submit3'])) {$submit3 = $_POST['submit3'];}else{$submit3="";}
if (isset($_GET['profe'])) {$profe = $_GET['profe'];}elseif (isset($_POST['profe'])) {$profe = $_POST['profe'];}else{$profe="";}
if (isset($_GET['materia'])) {$materia = $_GET['materia'];}elseif (isset($_POST['materia'])) {$materia = $_POST['materia'];}else{$materia="";}

if ($submit1)
{
	include("faltas.php");
	exit;
}
elseif ($submit2)
{
	include("informes.php");
	exit;
}
elseif ($submit3)
{
	include("asignaturas.php");
	exit;
}
elseif ($submit4)
{
	include("faltasdias.php");
	exit;
}
else
{
	require('../../bootstrap.php');
	
	include("../../menu.php");
	include("../../faltas/menu.php");
	?>

<div class="container">
<div class="page-header">
<h2 style="display:inline">Faltas de Asistencia <small> Consultas</small></h2>
</div>

<div class="row">

<div class="col-sm-6">

<div class="well well-large">

<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<legend>Faltas de un alumno</legend> 
<p class="help-block">( Faltas de asistencia justificadas y no justificadas de un alumno en un rango de fechas. )</p> 
<div class="form-group col-md-3">
<label for="grupo" class="control-label"> Grupo </label> 
<SELECT id="grupo"
	name="unidad1" onChange="submit()" class="form-control">
	<OPTION><?php echo $unidad1;?></OPTION>
	<?php unidad($db_con);?>
</SELECT>
</div>

<div class="form-group col-md-9">
<label for="al" class="control-label"> Alumno </label> 
<select id="al"	name='nombre' class="form-control" required>
	<?php
	printf ("<OPTION></OPTION>");

	// Datos del alumno que hace la consulta. No aparece el nombre del a&iuml;&iquest;&frac12; de la nota. Se podr&iuml;&iquest;&frac12; incluir.
	$alumnosql = mysqli_query($db_con, "SELECT distinct APELLIDOS, NOMBRE, CLAVEAL FROM FALUMNOS WHERE unidad like '$unidad1%' order by APELLIDOS asc");

	if ($falumno = mysqli_fetch_array($alumnosql))
	{

		do {
			$claveal = $falumno[2];
			global $claveal;
			$opcion = printf ("<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>");
			echo "$opcion";

		} while($falumno = mysqli_fetch_array($alumnosql));
	}
	$fecha = (date("d").-date("m").-date("Y"));
	$comienzo=explode("-",$config['curso_inicio']);
	$comienzo_curso=$comienzo[2]."-".$comienzo[1]."-".$comienzo[0];
	$fecha2 = date("m");
	?>
</select>
</div>

<legend><small>Rango de fechas...</small></legend>

<div class="form-group col-md-6"  id="datetimepicker1" style="display: inline;">
<label class="control-label"
	for="fecha4">Inicio </label>
<div class="input-group">
<input name="fecha4" type="text"
	class="form-control" value="" data-date-format="DD-MM-YYYY" id="fecha4"
	required> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group col-md-6"   id="datetimepicker2" style="display: inline;">
<label class="control-label"
	for="fecha3">Fin </label>
<div class="input-group">
<input name="fecha3" type="text"
	class="form-control" value="" data-date-format="DD-MM-YYYY" id="fecha3"
	required> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group col-md-4">
<input name=submit2 type=submit id="submit2"
	value='Lista detallada de Faltas' class="btn btn-primary"> 
</div>

</fieldset>

</form>

</div>

<br>

<div class="well well-large">

<legend>Faltas de un Grupo.</legend>
<p class="help-block">( Faltas justificadas o no justificadas de un grupo en un mes con posibilidad de elegir un número mínimo de faltas. )</p> 
<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<div class="form-group col-md-6">
<label class="control-label" for="unidad"> Grupo </label> 
<SELECT
	id="unidad" name="unidad" onChange="submit()" class="form-control">
	<OPTION><?php echo $_POST['unidad'];?></OPTION>
	<?php unidad($db_con);?>
</SELECT>
</div>

<div class="form-group col-md-6">
<label class="control-label" for="mes"> Mes </label> 
<SELECT name='mes' id='mes'
	class="form-control">
	<OPTION></OPTION>
	<?php
	for($i=1;$i<13;$i++){
		echo "<OPTION>$i</OPTION>";
	}
	?>
</SELECT> 
</div>

<div class="form-group col-md-6">
<label class="control-label" for="falta">Falta:</label> 
<SELECT id='falta'  name='FALTA' class="form-control">
	<OPTION>F</OPTION>
	<OPTION>J</OPTION>
</SELECT>
</div>

<div class="form-group col-md-6">
<label class="control-label" for='numero2'> N&uacute;mero m&iacute;nimo de Faltas</label> 
<INPUT id='numero2' name="numero2" type="text" class="form-control" maxlength="3" alt="Mes" value="1">
</div>

<div class="form-group col-md-4">
<input name="submit1" type="submit" id="submit1" value="Enviar Datos"
	class="btn btn-primary">
</div>

</fieldset>

</form>

</div>



</div>


<div class="col-md-6">

<div class="well well-large">

<legend>Faltas por Asignatura</legend>
<p class="help-block">( Alumnos con faltas de asistencia no justificadas en una asignatura propia de un determinado profesor. )</p> 
<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<div class="form-group col-md-12">
<label class="control-label" for="profe"> Profesor </label> 
<SELECT
	id="profe" name="profe" onChange="submit()" class="form-control" required>
<?php
if (isset($_POST['profe'])) {
	$profe = $_POST['profe'];
}
	printf ("<OPTION>$profe</OPTION>");

	$profesql = mysqli_query($db_con, "SELECT distinct profesor FROM profesores order by profesor asc");

	if ($fprofe = mysqli_fetch_array($profesql))
	{

		do {
			$opcion = printf ("<OPTION>$fprofe[0]</OPTION>");
			echo "$opcion";

		} while($fprofe = mysqli_fetch_array($profesql));
	}
?>
</SELECT>
</div>

<div class="form-group col-md-12">
<label class="control-label" for="materia"> Asignatura </label> 
<SELECT name='materia' id='materia'
	class="form-control" required>
	<OPTION></OPTION>
<?php
	$asig0 = mysqli_query($db_con, "SELECT distinct materia, grupo, nivel FROM profesores WHERE profesor = '$profe' order by grupo, nivel, materia asc");

	if ($asig = mysqli_fetch_array($asig0))
	{

		do {
			$opcion = printf ("<OPTION>$asig[0] -> $asig[1] -> $asig[2]</OPTION>");
			echo "$opcion";

		} while($asig = mysqli_fetch_array($asig0));
	}
?>
</SELECT> 
</div>

<div class="form-group col-md-4">
<input name="submit3" type="submit" id="submit1" value="Enviar Datos"
	class="btn btn-primary">
</div>

</fieldset>

</form>

</div>

<br>

<div class="well well-large">

<form action='index.php' method='post' name='f1' class='form' role='form'>

<fieldset>

<legend> Faltas y días sin justificar</legend>

<p class="help-block">( Alumnos que
tienen un número mínimo de faltas entre el rango de fechas
seleccionadas. )</p> 

<div class="form-group col-md-6">
<label class="control-label" for='numero'> Número mínimo de Faltas</label> 
<INPUT
	name="numero" type="text" id="numero" class="form-control"
	maxlength="3" value="1">
</div>
<legend><small>Rango de fechas...</small></legend>

<div class="form-group col-md-6" id="datetimepicker3" style="display: inline;">
<label class="control-label" for="fecha10">Inicio </label>
<div class="input-group">
<input name="fecha10" type="text"
	class="form-control" value="" data-date-format="DD-MM-YYYY"
	id="fecha10" required> <span class="input-group-addon"><i
	class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group col-md-6" id="datetimepicker4" style="display: inline;">
<label
	for="fecha20" class="control-label">Fin </label>
<div class="input-group"><input name="fecha20" type="text"
	class="form-control" value="" data-date-format="DD-MM-YYYY"
	id="fecha20" required> <span class="input-group-addon"><i
	class="fa fa-calendar"></i></span>
</div>
</div>

<br>

<div class="form-group col-md-4">
<INPUT name="submit4" type="submit" value="Enviar Datos" id="submit4"
	class="btn btn-primary">
</div>

</fieldset>

</form>

</div>
</div>

	<?php }?>

</div>
</div>
	<?php include("../../pie.php");?>

<script>  
$(function ()  
{ 
	$('#datetimepicker1').datetimepicker({
		language: 'es',
		pickTime: false
	});
	
	$('#datetimepicker2').datetimepicker({
		language: 'es',
		pickTime: false
	});
	
	$('#datetimepicker3').datetimepicker({
		language: 'es',
		pickTime: false
	});
	
	$('#datetimepicker4').datetimepicker({
		language: 'es',
		pickTime: false
	});
});  
</script>
</body>
</html>
