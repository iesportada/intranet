<?php
if (isset($_POST['submit1'])) {
	include("imprimir.php");
}
elseif(isset($_POST['submit2'])){
	include("registrar.php");
}

require('../../bootstrap.php');


if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'4') == TRUE or stristr($_SESSION['cargo'],'5') == TRUE)
{
	$jefes=1;
}
?>
  <?php
include("../../menu.php");
include("menu.php");  
  ?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Selección de alumnos</small></h2>
</div>
</div>

<div class="col-sm-8 col-sm-offset-2">
    <div class="well well-lg">      
<?php
$profes_actividad = $_GET['profesores'];
if (($jefes==1 or strstr(mb_strtoupper($profes_actividad),mb_strtoupper($_SESSION['profi']))==TRUE) and $_GET['ver_lista']!=="1") {
?>
<a href="javascript:seleccionar_todo()" class="btn btn-primary btn-sm hidden-print">Marcar todos</a>
<a href="javascript:deseleccionar_todo()" class="btn btn-primary btn-sm pull-right hidden-print">Desmarcar todos</a>
<br /><br />
<?php } ?>
    <form action="extraescolares.php" method="POST" name="imprime">

  <?php
$cursos0 = mysqli_query($db_con, "select unidades, profesores, nombre from calendario where id = '$id'");
while($cursos = mysqli_fetch_array($cursos0))
{
$actividad=$cursos[2];
echo "<legend align='center' class='text-info'>$actividad</legend>";
$profes_actividad = $cursos[1];
$profesor="";
$profes="";
$profes = explode(";",$cursos[1]);
foreach ($profes as $n_profe)
{
$profe = explode(", ",$n_profe);
$profesor.=$profe[1]." ".$profe[0].", ";
//$profesor.=$profeso.",";
}
$profesor = substr($profesor,0,-5);
$uni=substr($cursos[0],0,strlen($cursos[0])-1);
$trozos = explode(";",$uni);
foreach($trozos as $valor)
{
$unidad = trim($valor);
?> 
<table class="table table-striped">
<tr><td colspan="2"><h4><?php echo "Alumnos de $unidad";?></h4></td>
</tr>
<?php
$alumnos0 = "select alma.nombre, alma.apellidos, NC, alma.claveal from alma, FALUMNOS where alma.claveal = FALUMNOS.claveal and alma.unidad = '$unidad' order by NC";
//echo $cursos[0]." => ".$alumnos0."<br>";
$alumnos1 = mysqli_query($db_con, $alumnos0);
$num = mysqli_num_rows($alumnos1);

$datos0 = "select fechaini, horaini, profesores, nombre, descripcion, observaciones, fechafin, horafin from calendario where id ='$id'";
$datos1 = mysqli_query($db_con, $datos0);
$datos = mysqli_fetch_array($datos1);
$fecha0 = explode("-",$datos[0]);
$fecha  = $fecha0[2]."-". $fecha0[1]."-". $fecha0[0];
$horario = $datos[1];
$actividad = $datos[3];
$descripcion = $datos[4];
$observaciones = $datos[5];
$fecha1 = explode("-",$datos[6]);
$fecha2  = $fecha1[2]."-". $fecha1[1]."-". $fecha1[0];
$horario2 = $datos[7];
?>
<?php

if ($jefes==1 OR strstr(mb_strtoupper($profes_actividad),mb_strtoupper($_SESSION['profi']))==TRUE) {
?>
<input name="fecha" type="hidden" id="A" value="<?php echo $fecha;?>">
<input name="horario" type="hidden" id="A" value="<?php echo $horario;?>">
<input name="fechafin" type="hidden" id="A" value="<?php echo $fecha2;?>">
<input name="horariofin" type="hidden" id="A" value="<?php echo $horario2;?>">
<input name="profesor" type="hidden" id="A" value="<?php echo $profesor;?>">
<input name="actividad" type="hidden" id="A" value="<?php echo $actividad;?>">
<input name="descripcion" type="hidden" id="A" value="<?php echo $descripcion;?>">
<input name="observaciones" type="hidden" id="A" value="<?php echo $observaciones;?>">
<input name="id" type="hidden" id="A" value="<?php echo $id;?>">  
<?}
while($alumno = mysqli_fetch_array($alumnos1)){
$apellidos = $alumno[0];
$nombre = $alumno[1];
$nc = $alumno[2];
$claveal = $alumno[3];
$extra_al="";
$ya = mysqli_query($db_con,"select * from actividadalumno where cod_actividad='$id' and claveal='$claveal'");
if (mysqli_num_rows($ya)>0) {
	$extra_al = 'checked';
}
if($_GET['ver_lista']=="1" and $extra_al!==""){
?>
<tr>
<td >
<?php 
echo " $nc. $apellidos $nombre";
?>
</td>
</tr>
<?php 
}
elseif($_GET['ver_lista']!=="1"){
?>
<tr>
<td>
<input name="<?php echo $nc.$claveal;?>" type="checkbox" id="A" value="<?php echo $claveal;?>" <?php echo $extra_al;?>> 
</td>
<td>
<?php
echo " $nc. $apellidos $nombre";
?>
</td></tr>
<?php
}
}
?>
</table>
<?php
}
}

?>
<br />
<div align="center">
<?php
if (($jefes==1 OR strstr(mb_strtoupper($profes_actividad),mb_strtoupper($_SESSION['profi']))==TRUE) and $_GET['ver_lista']!=="1") {
?>
<button type="submit" name="submit1" value="Imprimir Carta para Padres" class="btn btn-primary hidden-print">Imprimir Carta para Padres</button>&nbsp;
<button type="submit" name="submit2" value="Registrar Alumnos" class="btn btn-info hidden-print">Registrar Alumnos</button>&nbsp;
<?php } ?>
<input type="button" name="print"  class="btn btn-success hidden-print" value="Imprimir Lista de Alumnos" onclick="window.print();">
</div>
  </form>
  </div>
  </div>
  </div>
</div> 
  <script>
function seleccionar_todo(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == "checkbox")	
			document.imprime.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == "checkbox")	
			document.imprime.elements[i].checked=0
}
</script>

	<?php include("../../pie.php"); ?>
	
</body>
</html>