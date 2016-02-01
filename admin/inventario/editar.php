<?php
require('../../bootstrap.php');


if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = '1'; }

include("../../menu.php");
include("menu.php");
?>
<div class="container">
<div class="page-header">
  <h2>Material del Centro <small> Edición de datos</small></h2>
</div>
<?php
/*if (empty($departamento) or stristr ( $_SESSION ['cargo'], '1' ) == FALSE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección";
}*/

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

$profe=$_SESSION['profi'];
?>
<?php
// Eliminar registro
if ($_GET['eliminar']=="1") {
	mysqli_query($db_con, "delete from inventario where id='".$_GET['id']."'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.</div></div><br />';
}
// Modificar registro
if($enviar == "Cambiar datos")
{
if (!(empty($familia) or empty($clase) or empty($lugar))) 
{
	$tipo=mysqli_query($db_con, "select id from inventario_clases where familia = '$familia' and clase = '$clase'");
	$tip=mysqli_fetch_array($tipo);
	mysqli_query($db_con, "update inventario set clase='$tip[0]', lugar='$lugar', descripcion='$descripcion', marca='$marca', modelo='$modelo', serie='$serie', unidades='$unidades', fecha='$fecha', ahora=NOW() where id='$id'");
	$num = mysqli_affected_rows();
if ($num==1) {
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han modificado correctamente.
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
// Crear nuevo registro
if($crear== "Crear nuevo registro")
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
</div></div><br />';}
}
else {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Parece que no has escrito nada en alguno de los campos obligatorios del formulario. Inténtalo de nuevo.
</div></div><br />';
}
}

$datos=mysqli_query($db_con, "select familia, inventario_clases.clase, lugar, descripcion, marca, modelo, serie, unidades, fecha from inventario, inventario_clases where inventario.clase=inventario_clases.id and inventario.id='$id'");
$dat=mysqli_fetch_row($datos);
if (empty($familia)) {
$familia=$dat[0];	
}
$clase=$dat[1];
$lugar=$dat[2];
$descripcion=$dat[3];
$marca=$dat[4];
$modelo=$dat[5];
$serie=$dat[6];
$unidades=$dat[7];
$fecha=$dat[8];
?>
<div class="row">
<div class="col-sm-6">
<legend>Cambio de datos <span style="color:#9d261d">(<?php echo $departament;?>)</span></legend>
<div class="well" align="left">
<?php
if ($j_s == '') {
?>
<form name="textos" method="post" action="editar.php">
<?php
}
?>
<div align="center"><p class="help-block"> <span style="color:#9d261d">(*)</span> --> Campos obligatorios</p></div>
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="departamento" value="<?php echo $departamento;?>">

<div class="form-group"><label>Familia<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
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
<div class="form-group"><label>Clase<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
<select name="clase" class="form-control">
        <?php
echo "<option>$clase</option>";
$cla = mysqli_query($db_con, " SELECT distinct clase FROM inventario_clases where familia='$familia' order by familia asc");
while($clas = mysqli_fetch_array($cla))
	{
	echo "<OPTION>$clas[0]</OPTION>";
	} 
	?>
</select>
</div>
<div class="form-group"><label>Lugar<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
<select name="lugar" class="form-control">
        <?php
echo "<option>$lugar</option>";
$luga = mysqli_query($db_con, " SELECT distinct lugar FROM inventario_lugares order by lugar asc");
while($lug = mysqli_fetch_array($luga))
	{
	echo "<OPTION>$lug[0]</OPTION>";
	} 
	?>
</select>
</div>
<div class="form-group"><label>Descipción</label>
<textarea name="descripcion" cols="45" rows="5" class="form-control"><?php echo $descripcion;?></textarea>
</div>
<div class="form-group"><label>Marca</label>
<input type="text" name="marca" size="40" class="form-control" value="<?php echo $marca;?>"/>
</div>
<div class="form-group"><label>Modelo</label>
<input type="text" name="modelo" size="40"class="form-control" value="<?php echo $modelo;?>" />
</div>
<div class="form-group"><label>Nº Serie</label>
<input type="text" name="serie" size="25" class="form-control" value="<?php echo $serie;?>"/>
</div>
<div class="form-group"><label>Nº de Unidades<span style="color:#9d261d;font-size:12px;"> (*) </span></label>
<input type="text" name="unidades" size="5" class="form-control" value="<?php echo $unidades;?>"/>
</div>
<div class="form-group"  id="datetimepicker1">
<label>Fecha de Alta<span style="color:#9d261d;"> (*) </span></label>
<div class="input-group">
  <input name="fecha" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fecha" value="<?php echo $fecha;?>">
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>

<br />
<input type="submit" name="enviar"  value="Cambiar datos" class="btn btn-primary btn-block"
<?php
if ($j_s == '1') { echo "disabled";}
?>
/>
</form>
</div>
</div>
<div class="col-sm-6">
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
<a href="introducir.php?id=<?php echo $item[4];?>&eliminar=1" data-bb='confirm-delete'><i class="fa fa-trash-o" title="Borrar registro" > </i> </a>
<?php
}
?>
&nbsp;&nbsp;<a href="editar.php?id=<?php echo $item[4];?>&departamento=<?php echo $departamento;?>"><i class="fa fa-pencil" title="Editar registro"> </i> </a></td></tr>
<?php
}
	echo '
</table>	';
}
?>
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
</body>
</html>
