<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2));

include("../../menu.php");
include("menu.php");

$prof = mysqli_query($db_con, "SELECT TUTOR FROM FTUTORES WHERE unidad like '$unidad%'");
$fprof = mysqli_fetch_array($prof);
$tutor = $fprof[0];
?>
<div class="container">
<div class="row">
<div class="page-header">
<h2>Informes de Tutoría <small> Activar Informe</small></h2>
</div>
<br>

<div class="col-md-6 col-md-offset-3">	
<div class="well well-large">
<?php
if($unidad)
{
	echo '<h5>Grupo: <span class="text-info">';
	echo $unidad;
	echo '</span></h5> <h5>Tutor: <span class="text-info">';
	eliminar_mayusculas($fprof[0]);
	echo $fprof[0];
	echo '</span></h5><br />';
}
else
{
	?>
<form name="curso" method="POST" action="infotut.php">

<div class="form-group">
<label>Grupo: </label>
<SELECT name="unidad" onChange="submit()" class="form-control">
	<option><?php echo $unidad;?></option>
	<?php unidad($db_con);?>
</SELECT> 
</FORM>
</div>
	<?php
}
?> <?php
echo "<form name='alumno' method='POST' action='activar.php' role='form'>";

echo "<div class='form-group'>
<label>Alumno </label>";
echo"<select name='alumno' class='form-control'>";
echo "<OPTION></OPTION>";
if ($unidad == ""){ echo "<OPTION></OPTION>";}
else
{
	$alumno=mysqli_query($db_con, "SELECT CLAVEAL, APELLIDOS, NOMBRE, unidad FROM alma WHERE unidad like '$unidad%' ORDER BY APELLIDOS ASC, NOMBRE ASC");
	while($falumno = mysqli_fetch_array($alumno))
	{
	 echo "<OPTION>$falumno[1], $falumno[2] --> $falumno[0]</OPTION>";
	}
}
echo "</select></div>";

if ($unidad == ""){ echo "";}
else
{
	echo"<div class='form-group'>
	<label>Tutor/a del grupo</label>";
	echo "<input type='text' value ='$fprof[0]' name='tutor' class='form-control' readonly>";
	echo "</div>";
}
?>

<div class='form-group' id="datetimepicker1">
<label>Fecha de la reunión</label>
<div class="input-group">
<input name="fecha"	type="text" class="form-control" value="" data-date-format="DD-MM-YYYY" id="fecha" required> 
	<span class="input-group-addon"><i class="fa fa-calendar"></i>
	</span>
	</div>
</div>

<div class="form-group">
	<label for="motivo">Motivo de la reunión</label>
	<textarea class="form-control" id="motivo" name="motivo" rows="3"></textarea>
</div>

 <?php
echo '<input type=submit value="Activar informe" class="btn btn-primary btn-block">';
?>
</form>
</div>
</div>
</div>
</div>
<?php
include("../../pie.php");
?> <script>
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
