<?php
require('../../bootstrap.php');


include("../../menu.php");
include("../menu.php");

if (isset($_GET['mes'])) {$mes = $_GET['mes'];}elseif (isset($_POST['mes'])) {$mes = $_POST['mes'];}else{$mes="";}
if (isset($_GET['claveal'])) {$claveal = $_GET['claveal'];}elseif (isset($_POST['claveal'])) {$claveal = $_POST['claveal'];}else{$claveal="";}
if (isset($_GET['del'])) {$del = $_GET['del'];}elseif (isset($_POST['del'])) {$del = $_POST['del'];}else{$del="";}
if (isset($_GET['inf'])) {$inf = $_GET['inf'];}elseif (isset($_POST['inf'])) {$inf = $_POST['inf'];}else{$inf="";}
if (isset($_GET['texto'])) {$texto = $_GET['texto'];}elseif (isset($_POST['texto'])) {$texto = $_POST['texto'];}else{$texto="";}
if (isset($_GET['texto2'])) {$texto2 = $_GET['texto2'];}elseif (isset($_POST['texto2'])) {$texto2 = $_POST['texto2'];}else{$texto2="";}
$mas2="";
?>
<?php
if (strstr($_SESSION['cargo'],'8')==TRUE) {
	$mas="";
	$titulo="Departamento de orientación  ";
	$upd=" orientacion='$texto' ";
}
if (strstr($_SESSION['cargo'],'2')==TRUE and strstr($_SESSION['cargo'],'8')==FALSE) {
	$tut=$_SESSION['profi'];
	$tutor=mysqli_query($db_con, "select unidad from FTUTORES where tutor='$tut'");
	$d_tutor=mysqli_fetch_array($tutor);
	$mas=" and absentismo.unidad='$d_tutor[0]' and tutoria IS NULL ";
	$mas2=" and tutoria IS NULL ";
	$titulo="Tutor: $d_tutor[0]";
	$upd=" tutoria='$texto' ";
}
if (strstr($_SESSION['cargo'],'1')==TRUE) {
	$mas="";
	$titulo="Jefatura de Estudios ";
	$upd=" jefatura='$texto', serv_sociales='$texto2' ";
}
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Alumnos absentistas</small></h2>
</div>
<br />
<?php
// Borramos alumnos
if ($del=='1') {
	mysqli_query($db_con, "delete from absentismo where claveal = '$claveal' and mes = '$mes'");
	echo '<div align="center""><div class="alert alert-warning alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos del alumno han sido borrados de la Base de datos.
			</div></div><br />';
}
// Procesamos datos si se ha dado al botón 
if (isset($_POST['submit'])) {
mysqli_query($db_con, "update absentismo set $upd where claveal='$claveal' and mes='$mes'")	;
// echo "update absentismo set $upd where claveal='$claveal' and mes='$mes'";
echo '<div align="center""><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de los alumnos absentistas se han actualizado.
			</div></div><br />';
	}

                    if($mes=='Septiembre'){$mes='09';}
                    if($mes=='Octubre'){$mes='10';}
                    if($mes=='Noviembre'){$mes='11';}
                    if($mes=='Diciembre'){$mes='12';}
                    if($mes=='Enero'){$mes='01';}
                    if($mes=='Febrero'){$mes='02';}
                    if($mes=='Marzo'){$mes='03';}
                    if($mes=='Abril'){$mes='04';}
                    if($mes=='Mayo'){$mes='05';}
                    if($mes=='Junio'){$mes='06';}
// Vamos a rellenar informe

if ($_GET['inf']=="1") {
echo "<div class='row'><div class='col-sm-8 col-sm-offset-2'>
";	
echo "<legend align='center'>Datos del Alumno</legend><br>";
$al=mysqli_query($db_con, "SELECT distinct apellidos, nombre, absentismo.unidad, matriculas, numero, jefatura, orientacion, tutoria, serv_sociales FROM absentismo, alma WHERE alma.claveal = absentismo.claveal and absentismo.claveal='$claveal' and mes='$mes' $mas2");
if (mysqli_num_rows($al)>0) {
$datos=mysqli_fetch_array($al);
if (strstr($_SESSION['cargo'],'1')==TRUE) {$obs=$datos[5];$obs2=$datos[8];}elseif (strstr($_SESSION['cargo'],'8')==TRUE){$obs=$datos[6];}else {$obs=$datos[7];}
echo  "<table class='table' style='width:auto' align=center><tr><th align='center'> NOMBRE </th><th align='center'> CURSO </th>
<th align='center'> MES </th><th align='center'> Nº FALTAS </th></tr>
<tr class='warning'><td align='center'>$datos[0], $datos[1]</td><td id='' align='center'>$datos[2]</td><td id='' align='center'>$mes</td><td id='' align='center'>$datos[4]</td></tr></table><br />";
echo "<form enctype='multipart/form-data' action='index2.php' method='post'>";
?>
<input name="claveal" type="hidden" value="<?php echo $claveal;?>">
<input name="mes" type="hidden" value="<?php echo $mes;?>">
<div class="form-group"><label>Observaciones</label>
<textarea name="texto" title="Informe de Alumno absentista." class="form-control" rows="12"><?php echo $obs;?></textarea></div>
<?php
if (strstr($_SESSION['cargo'],'1')==TRUE) {
?>
<div class="form-group"><label>Informe de Servicios Sociales</label>
<textarea name="texto2" title="Informe de Alumno absentista." class="form-control" rows="12"><?php echo $obs2;?></textarea></div>
<?php
}
?>
<input type="submit" name="submit" value="Enviar Informe" class="btn btn-primary">
<?php
echo "</form>";
echo "";
}
echo "</div></div>";
}
?>
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<br />
<legend align="center">Alumnos con informes de absentismo pendiente <br /><span class="text-info"><?php echo  $titulo;?></span> </legend><br />
<?php

$SQL0 = "SELECT absentismo.CLAVEAL, apellidos, nombre, absentismo.unidad, matriculas, numero, mes, jefatura, orientacion, tutoria, serv_sociales FROM absentismo, alma WHERE alma.claveal = absentismo.claveal and mes='$mes' $mas  order by unidad";

$result0 = mysqli_query($db_con, $SQL0);
  if (mysqli_num_rows($result0)>0) {
echo  "<center><table class='table table-striped table-bordered' style='width:auto'>\n";
        echo "<tr><th align='center' colspan=2>ALUMNO</th><th align='center'>CURSO</th>
        <th align='center'>MES</th><th align='center'>Nº FALTAS</th>";

        if (strstr($_SESSION['cargo'],'1')==TRUE OR strstr($_SESSION['cargo'],'8')==TRUE) {
        	echo "<th>Jef.</th><th>Orienta.</th><th>Tut.</th><th>S. Soc.</th><th class='no_imprimir'></th>";
        }
		echo "</tr>";
 while  ($row0 = mysqli_fetch_array($result0)){
 	$claveal=$row0[0];
 	$mes=$row0[6];
 	$numero=$row0[5];
 	$unidad=$row0[3];
 	$nombre=$row0[2];
 	$apellidos=$row0[1];
 	$jefatura=$row0[7];
 	$orientacion=$row0[8];
 	$tutoria=$row0[9];
 	$s_sociales=$row0[10];
 	if (strlen($jefatura)>0) {$chj=" checked ";}else{$chj="";}if(strlen($orientacion)>0) {$cho=" checked ";}else{$cho="";}if (strlen($tutoria)>0) {$cht=" checked ";}else{$cht="";} if (strlen($s_sociales)>0) {$chs=" checked ";}else{$chs="";}
	echo "<tr><td  align='left'>";
	    $foto="";
		$foto = "<img src='../../xml/fotos/$claveal.jpg' width='55' height='64'  />";
		echo $foto."</td>";
	echo "<td>$apellidos, $nombre</td><td>$unidad</td><td>$mes</td><td>$numero</td>";
        if (strstr($_SESSION['cargo'],'1')==TRUE OR strstr($_SESSION['cargo'],'8')==TRUE) {
	echo "<td><input type='checkbox' disabled $chj></td><td><input type='checkbox' disabled $cho></td><td><input type='checkbox' disabled $cht></td><td><input type='checkbox' disabled $chs></td>";
        }
	echo "<td align='center' class='no_imprimir'><a href='index2.php?claveal=$claveal&mes=$mes&inf=1'> <i class='fa fa-pencil'> </i></a>";
if (strstr($_SESSION['cargo'],'1')==TRUE) {
		echo "<a href='index2.php?claveal=$claveal&mes=$mes&del=1' data-bb='confirm-delete'> <i class='fa fa-trash-o'> </i></a>";
}

	echo "</td>";
	
	echo "</tr>";
	}
	echo "</table>";
	echo "<div class='no_imprimir'><br /><input type='button' value='Imprimir todos' name='boton2' class='btn btn-primary' onclick='window.location=\"imprimir.php?mes=".$mes."\"' /></div>";   
	}
else
{
	echo '<div align="center""><div class="alert alert-warning alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Parece que no hay alumnos absentistas registrados en ese mes. Si te has equivocado, vueve atr&aacute;s e int&eacute;ntalo de nuevo.			</div></div>';
}
  ?>
</div>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
	
</body>
</html>