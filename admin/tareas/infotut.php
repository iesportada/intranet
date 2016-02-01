<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2));

$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];


include("../../menu.php");
include("menu.php");

eliminar_mayusculas($profesor);

$prof = mysqli_query($db_con, "SELECT TUTOR FROM FTUTORES WHERE unidad like '$unidad%'");
$fprof = mysqli_fetch_array($prof);
$tutor = $fprof[0];
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tareas <small> Activar Informe</small></h2>
</div>
<br>
<div class="col-md-4 col-md-offset-4">	
<div class="well well-large">
      <?php
if($unidad)
{
	echo '<h5>Grupo: <span class="text-info">';
	echo $unidad;
	echo '</span></h5> <h5>Tutor: <span class="text-info">';
	eliminar_mayusculas($tutor);
	echo $tutor;
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
      </FORM>
    <?php
}
?>
    <form name="alumno" method="POST" action="ejecutactivar.php">
      <?php

echo "<form name='alumno' method='POST' action='activar.php'>";

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

echo"<div class='form-group'>
<label>Profesor que activa el informe</label>";
echo "<input size='35' name='tutor' type='text' value='$profesor'  class='form-control' readonly>";
echo "</div>";
$today = date("j, n, Y");
$hoy = explode(",", $today);
$dia = $hoy[0];
$mes = $hoy[1];
$ano = $hoy[2];
?>
<div class='form-group' id="datetimepicker1">
<label>Fecha prevista de la ausencia</label>
<div class="input-group">
<input name="fecha"	type="text" class="form-control" value="" data-date-format="DD-MM-YYYY" id="fecha" required> 
	<span class="input-group-addon"><i class="fa fa-calendar"></i>
	</span>
	</div>
</div>

<?php

echo "<div class='form-group'>
<label>Duracion de la ausencia (en d&iacute;as)</label>";
echo "<select name='duracion' class='form-control'>";
for ($i=1;$i<32;$i++){echo "<option>$i</option>";}
echo "</select> ";
echo"</div>"
;
echo '<input type="submit" value="Activar informe de Tareas" class="btn btn-primary btn-block">';
?>
    </form>
  </div>
</div>
</div>

<?php 	
include("../../pie.php");
?>
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
