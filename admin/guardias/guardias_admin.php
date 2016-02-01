<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
include 'menu.php';

if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['no_dia'])) {$no_dia = $_GET['no_dia'];}elseif (isset($_POST['no_dia'])) {$no_dia = $_POST['no_dia'];}else{$no_dia="";}
if (isset($_GET['profeso'])) {$profeso = $_GET['profeso'];}elseif (isset($_POST['profeso'])) {$profeso = $_POST['profeso'];}else{$profeso="";}
if (isset($_GET['hora'])) {$hora = $_GET['hora'];}elseif (isset($_POST['hora'])) {$hora = $_POST['hora'];}else{$hora="";}
if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}

if ($no_dia== '1') {$nombre_dia = 'Lunes';}
if ($no_dia== '2') {$nombre_dia = 'Martes';}
if ($no_dia== '3') {$nombre_dia = 'Miércoles';}
if ($no_dia== '4') {$nombre_dia = 'Jueves';}
if ($no_dia== '5') {$nombre_dia = 'Viernes';}
$mes=date('m');
$dia_n = date('d');
$ano = date('Y');
$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia_n,$ano));

if ($no_dia> $numerodiasemana) {
	$dif = $no_dia- $numerodiasemana;
	$g_dia = date('d')+$dif;
}
if ($no_dia< $numerodiasemana) {
	$dif = $numerodiasemana - $no_dia;
	$g_dia = date('d')-$dif;
}
if ($no_dia== $numerodiasemana) {
	$dif = 0;
	$g_dia = date('d');
}
if ($g_dia=="") {
	$g_dia = date('d');
}
$g_fecha = date("Y-m-$g_dia");
$fecha_sp = formatea_fecha($g_fecha);
?>
<div class="container">
<div class="row"><br>
<div class="page-header">
<h2>Guardias de Aula <small> <?php echo $fecha_sp;?></small></h2>
</div>

<div align="center"><br>
<div class="well" style="width: 450px">
<FORM action="guardias_admin.php" method="POST" name="Cursos">
<div class="form-group"><label>Selecciona Profesor</label> <SELECT
	name=profeso onchange="submit()" class="form-control">
	<option value="<?php echo $profeso; ?>"><?php echo nomprofesor($profeso); ?></option>
	<?php
	$profe = mysqli_query($db_con, "SELECT distinct prof FROM horw where c_asig not in (select distinct idactividad from actividades_seneca where idactividad not like '2' and idactividad not like '21') order by prof asc");
	if ($filaprofe = mysqli_fetch_array($profe))
	{
		do {

			$opcion1 = printf ('<OPTION value="'.$filaprofe[0].'">'.nomprofesor($filaprofe[0]).'</OPTION>');
			echo "$opcion1";

		} while($filaprofe = mysqli_fetch_array($profe));
	}
	?>
</select></div>
</FORM>
</div>
</div>
<div class="row">
<br>
<?php
if ($borrar=='1') {
	mysqli_query($db_con, "delete from guardias where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La sustitución ha sido borrada correctamente. Puedes comprobarlo en la tabla de la derecha.
          </div></div>';
}
?>
<div class="col-sm-5"><?php
if ($profeso) {
	echo '<br /><legend>'.nomprofesor($profeso).'</legend>';
	echo '  <div align="center" class="well well-large">';
}
?>  <?php 
if ($profeso) {
	$link = "1";
	$pr=$profeso;
	include("horario.php");

}
echo "</div>";
?></div>
<div class="col-sm-7">
<br>
<?php
$fech_hoy = date("Y-m-d");
$hoy0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha from guardias where dia = '$no_dia' and hora = '$hora' and date(fecha_guardia) = '$g_fecha'");
if (mysqli_num_rows($hoy0) > 0) {
	echo "<legend>Sustituciones registradas para la Guardia de hoy</legend>";
	echo '<table class="table table-striped">';
	echo "<tr><th>Profesor de Guardia</th><th>Profesor ausente</th></tr>";
	while ($hoy = mysqli_fetch_array($hoy0)) {
		echo "<tr><td>$hoy[1]</td><td>$hoy[2]</td></tr>";
	}
	echo "</table><br>";
}
?> 
<?php 
$h_gu0= mysqli_query($db_con, "select prof from horw where dia = '$no_dia' and hora = '$hora' and c_asig != '2' AND c_asig not in (select distinct idactividad from actividades_seneca where idactividad not like '2' and idactividad not like '21')");
if (mysqli_num_rows($h_gu0)>0) {
if ($profeso and $no_dia and $hora) {
	echo '<a name="marca"></a>';
	?>
<legend>Sustituciones realizadas durante la <?php echo "<span class='text-danger'>".$hora."ª </span>";?>
hora del <?php echo "<span class='text-danger'>$nombre_dia</span>";?></legend>
	<?php 
}
	
echo '<table class="table table-striped">';
while ($h_gu = mysqli_fetch_array($h_gu0)) {
	$num_g0=mysqli_query($db_con, "select id from guardias where profesor = '$h_gu[0]' and dia = '$no_dia' and hora = '$hora'");
	$ng_prof = mysqli_num_rows($num_g0);
	if ($ng_prof>0) {
		echo "<tr>";
		echo "<td>";
		echo "<span>$h_gu[0]</span>";
		echo "</td><td>";
		echo $ng_prof;
		echo "</td>";
		echo "</tr>";
	}
	
}
echo "</table><br>";
}

?> <?php
if ($profeso) {
	$extra = " and hora = '$hora' and dia = '$no_dia'";
	$extra1 = " a ".$hora."ª hora del ".$nombre_dia;
	$h_hoy0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia, dia from guardias where profesor = '$profeso'");
	if (mysqli_num_rows($h_hoy0) > 0) {

		echo "<legend>Sustituciones realizadas por el profesor</legend>";
		echo '<table class="table table-striped">';
		echo "<tr><th>Profesor Ausente</th><th>Fecha de la Guardia</th><th>Día</th><th>Hora</th><th></th></tr>";
		while ($h_hoy = mysqli_fetch_array($h_hoy0)) {
			$nu_dia = $h_hoy[5];
			if ($nu_dia == '1') {$nom_dia = 'Lunes';}
			if ($nu_dia == '2') {$nom_dia = 'Martes';}
			if ($nu_dia == '3') {$nom_dia = 'Miércoles';}
			if ($nu_dia == '4') {$nom_dia = 'Jueves';}
			if ($nu_dia == '5') {$nom_dia = 'Viernes';}
			$fecha_sp = formatea_fecha($h_hoy[4]);
			echo "<tr><td>".nomprofesor($h_hoy[2])."</td><td >$fecha_sp</td><td >$nom_dia</td><td >$h_hoy[3]</td><td ><a href='guardias_admin.php?id=$h_hoy[0]&borrar=1&profeso=$profeso' data-bb='confirm-delete'><i class='fa fa-trash-o fa-fw fa-lg' title='Borrar' > </i></a>";
		}
		echo "</table><br>";
	}
	else{
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hay datos sobre las Guardias del profesor.
</div></div>';
	}
}
?></div>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
	
</body>
</html>