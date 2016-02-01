<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<div class="container">
<div class="row">
<div class="page-header">
<h2 style="display:inline">Faltas de Asistencia <small> Poner faltas</small></h2>
</div>
<div class="col-sm-4"><?php
if(is_numeric($profesor))
{
	$nombre_p=mysqli_query($db_con, "select distinct prof from horw where no_prof = '$profesor'");
	echo "select distinct prof from horw where no_prof = '$profesor'";
	$nombre_pr = mysqli_fetch_array($nombre_p);
	$n_profe=$profesor."_ ".$nombre_pr[0];
}
else{$n_profe = $profesor;}
if(strlen($n_profe)>0){
	?>
<div align="center"><legend><small> <?php eliminar_mayusculas($n_profe); echo $n_profe;?></small></legend>
	<?php
}
?> <?php
if ($profesor) {
	$trozos = explode("_ ",$profesor) ;
	$id = $trozos[0];
	$profesores = $trozos[1];
	echo "<a href=index.php?year=$year&today=$today&month=$month&id=$id class='btn btn-success'>Elegir otro Profesor</a>";
	echo "</div>";

	echo "<input type=hidden name=profesor value= \"$profesor\"><hr>";
}
?> <?php
if(empty($profesor)){
	echo '<div align="center">';
	echo '<legend>Selecciona un profesor</legend>';
	if($_POST['submit']) {$continuar = "";}
	echo "<div class='form-group col-md-10 col-md-offset-1'>
<SELECT name='profesor' id='idprofe' onChange='submit()' class='form-control'>";
	echo "<OPTION>";
	echo "</OPTION>";
	// Datos del Profesor que hace la consulta. No aparece el nombre del año de la nota. Se podría incluir.
	$profe = mysqli_query($db_con, "SELECT distinct prof, no_prof FROM horw order by prof asc");
	while($filaprofe = mysqli_fetch_array($profe)) {
		$n_p+=1;
		echo '<OPTION value="'.$filaprofe[1].'_ '.$filaprofe[0].'">'.$filaprofe[1].'_ '.nomprofesor($filaprofe[0]).'</OPTION>';
	}
	echo "</select></div>";
	echo "</div>";
}
?> <?php
if (isset($registro)) {
	echo '<div align="left""><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Las Faltas de Asistencia han sido registradas.
          </div></div>';
}
if (isset($mens1)) {
	echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens1.'</div></div>';
}
if (isset($mens2)) {
	echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens2.'</div></div>';
}
if (isset($mens3)) {
	echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens3.'</div></div>';
}
if (isset($mens4)) {
	echo '<div align="left""><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_4.'</div></div>';
}
if (isset($fiesta)) {
	echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$fiesta.'</div></div>';
}
if (isset($mens_fecha)) {
	echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_fecha.'</div></div>';
}
?> <?php include("cal.php"); ?></div>
<div class="col-sm-8"><?php
echo "<legend align='center'><small class='text-uppercase'>Semana:&nbsp;&nbsp;$lunes1 &nbsp;&nbsp;-->&nbsp;&nbsp; $viernes&nbsp;&nbsp;</small></legend><br />";
echo "<input type=hidden name=today value= \"$today\">";
echo "<input type=hidden name=year value= \"$year\">";
echo "<input type=hidden name=month value= \"$month\">";
include("profes.php"); ?>
<div align="center"><br />
<input type="submit" name="enviar" class="btn btn-primary"
	value="Registrar las faltas de asistencia"></div>
</div>
</div>

<script>

document.form1.profesor.focus()
document.form1.profesor.options[<?php $id = $id; echo $id-1;?>].selected = true

    </script>