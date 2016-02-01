<?php
require('../../bootstrap.php');


if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = '1'; }

include("../../menu.php");
include("menu.php");
?>
<div class="container">
<div class="page-header">
  <h2>Material del Centro <small> Inventario</small></h2>
</div>
<?php
/*if (empty($departamento) or stristr ( $_SESSION ['cargo'], '1' ) == FALSE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección";
}
*/

if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE and empty($departamento)){
	$departament="Dirección";
	$departamento=$departament;
}
else{
	if (empty($departamento)) {
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
	}	
	else{
	$departament=$departamento;
	}
}

?>
<?php
if ($_GET['eliminar']=="1") {
	mysqli_query($db_con, "delete from inventario where id='".$_GET['id']."'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';
}
$profe=$_SESSION['profi'];
if($enviar == "Enviar datos")
{
if (!(empty($familia) or empty($clase) or empty($lugar))) 
{
	$tipo=mysqli_query($db_con, "select id from inventario_clases where familia = '$familia' and clase = '$clase'");
	$tip=mysqli_fetch_array($tipo);
	mysqli_query($db_con, "INSERT INTO  `inventario` (  `id` ,  `clase` ,  `lugar` ,  `descripcion` ,  `marca` ,  `modelo` ,  `serie` ,  `unidades` ,  `fecha` ,  `ahora` ,  `departamento` ,  `profesor` ) 
VALUES (
NULL ,  '$tip[0]',  '$lugar',  '$descripcion',  '$marca',  '$modelo',  '$serie',  '$unidades',  '$fecha',  now(), '$departamento',   '$profe'
)");
	$num = mysqli_affected_rows();
if ($num==1) {
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han registrado correctamente.
</div></div><br />';
}
}
else {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que no has escrito nada en alguno de los campos obligatorios del formulario. Inténtalo de nuevo.
</div></div><br />';
}
}
?>
<div class="row">
<?php 
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'4') == TRUE)
{ ?>
<div class="col-sm-6">

<legend>Registro de Material <span style="color:#9d261d">(<?php echo $departament;?>)</span></legend>
<div class="well" align="left">
<form name="textos" method="post" action="introducir.php">
<div align="center"><p class="help-block"> <span style="color:#9d261d">(*)</span> --> Campos obligatorios</p></div>
<input type="hidden" name="departamento" value="<?php echo $departamento;?>">

<div class='form-group'><label>Familia<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
<select name="familia" onchange="submit()" class="form-control">
        <?php
echo "<option>$familia</option>";
$famil = mysqli_query($db_con, " SELECT distinct familia FROM inventario_clases order by familia asc");
while($fam = mysqli_fetch_array($famil))
	{
	echo "<OPTION>$fam[0]</OPTION>";
	} 
	?>
</select>
</div>
<div class='form-group'><label>Clase<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
<select name="clase" class="form-control">
        <?php
echo "<option></option>";
$cla = mysqli_query($db_con, " SELECT distinct clase FROM inventario_clases where familia='$familia' order by familia asc");
while($clas = mysqli_fetch_array($cla))
	{
	echo "<OPTION>$clas[0]</OPTION>";
	} 
	?>
</select>
</div>
<div class='form-group'><label>Lugar<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
<select name="lugar" class="form-control">
        <?php
echo "<option></option>";
$luga = mysqli_query($db_con, " SELECT distinct lugar FROM inventario_lugares order by lugar asc");
while($lug = mysqli_fetch_array($luga))
	{
	echo "<OPTION>$lug[0]</OPTION>";
	} 
	?>
</select>
</div>
<div class='form-group'><label>Descipción</label>
<textarea name="descripcion" cols="45" rows="5" class="form-control"></textarea>
</div>
<div class='form-group'><label>Marca</label>
<input type="text" name="marca" size="40" class="form-control"/>
</div>
<div class='form-group'><label>Modelo</label>
<input type="text" name="modelo" size="40"class="form-control" />
</div>
<div class='form-group'><label>Nº Serie</label>
<input type="text" name="serie" size="25" class="form-control"/>
</div>
<div class='form-group'><label>Nº de Unidades<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
<input type="text" name="unidades" size="5" value="1" class="form-control"/>
</div>

<div class="form-group"  id="datetimepicker1">
<label>Fecha de Alta<span style="color:#9d261d;"> (*) </span></label>
<div class="input-group">
  <input name="fecha" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fecha">
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>
</div>
<br />
<input type="submit" name="enviar"  value="Enviar datos" class="btn btn-primary btn-block"/>
</form>
</div>
  <?php
}
if ($j_s == '1') {
	echo '<div class="col-sm-6 col-sm-offset-3">';
}
else{
	echo '<div class="col-sm-6">';
}
?>
<?php
$it = mysqli_query($db_con, "select inventario_clases.clase, marca, modelo, unidades, inventario.id from inventario, inventario_clases where inventario_clases.id=inventario.clase and departamento='$departamento'");
if (mysqli_num_rows($it)>0) {
	echo '<legend>Inventario: ';
	if($departamento){echo "<span style=color:#9d261d>".$departamento."</span>";}
	else{echo "<span style=color:#9d261d>Dirección del Centro</span>";}
	echo '</legend>
<table class="table table-striped">
<tr><th>Tipo</th><th>Marca / Modelo</th><th>Núm.</th><th></th><th></th></tr>';
while($item = mysqli_fetch_row($it))
{
	if (empty($item[1])) {
		$marca = $item[2];
	}
	else{
		$marca = $item[1];
	}
?>
<tr><td><?php echo $item[0];?></td><td><?php echo $marca;?></td><td><?php echo $item[3];?></td><td align=right>
<?php
if ($j_s == '') {
?>
<a href="introducir.php?id=<?php echo $item[4];?>&eliminar=1" data-bb='confirm-delete'><i class="fa fa-trash-o" title="Borrar registro"> </i> </a>
<?php
}
?>
&nbsp;<a href="editar.php?id=<?php echo $item[4];?>&departamento=<?php echo $departamento;?>"><i class="fa fa-pencil" title="Editar registro"> </i> </a></td></tr>
<?php
}
	echo '
</table>	';
}
?>
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
</body>
</html>
