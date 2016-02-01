<?php
if (isset($_POST['submit1']) and $_POST['submit1']=="Enviar Datos") {
	include("rellenainf.php");
	exit;
}

require('../../bootstrap.php');

$pr = $_SESSION['profi'];

include("../../menu.php");
include("menu.php");
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tutoría <small> Redactar Informe por asignatura</small></h2>
</div>
<br>

<div class="col-md-6 col-md-offset-3">	
        
<?php
$asignatura = $_POST['asignatura'];
$alumno=mysqli_query($db_con, "SELECT infotut_alumno.CLAVEAL, infotut_alumno.APELLIDOS, infotut_alumno.NOMBRE, infotut_alumno.unidad, infotut_alumno.id, curso, infotut_alumno.motivo FROM infotut_alumno, alma WHERE alma.claveal=infotut_alumno.claveal and ID='$id'");
$dalumno = mysqli_fetch_array($alumno);
$n_cur=$dalumno[5];
if (empty($dalumno[0])) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo
<br><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-primary">
		</div></div>';
	exit;	
}
?>
<div class="well well-large">
 <form name="informar" method="POST" action="informar.php?id=<?php echo $id;?>"> 
<?php
echo "<input type='hidden'  name='ident' value='$id'>";
echo "<input type='hidden'  name='profesor' value='$pr'>";
$claveal=trim($dalumno[0]);
if (empty($dalumno[0])) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo.<br /><br /
><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
	exit();	
}

echo "<p align=center class='lead'>$dalumno[2] $dalumno[1] ( $dalumno[3] )</p>";
   	$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto) and !(empty($dalumno[0]))) {
		echo "<div style='width:150px;margin:auto;'>";
		echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' class='img-responsive' />";
		echo "</div>";
	}
echo "<br />";
echo "<label>Motivo de la reunión:</label>";
$motivo_reunion = ($dalumno['motivo']) ? $dalumno['motivo'] : 'No se ha especificado el motivo de la reunión.';
echo "<p class=\"text-info\">".$motivo_reunion."</p>";

$depto = $_SESSION ['dpt'];
$extra_dep = "where departamento = '$depto'";

$pend = mysqli_query($db_con, "select distinct materia, abrev from 
profesores, asignaturas where asignaturas.nombre = materia and profesor in (select distinct departamentos.nombre from departamentos $extra_dep) and abrev like '%\_%' and codigo in (SELECT distinct pendientes.codigo FROM pendientes where pendientes.claveal = '$claveal' order by codigo)");

while($pendi = mysqli_fetch_array($pend)){
	$pendiente.="<option value='$pendi[0] ($pendi[1])'>$pendi[0] ($pendi[1])</option>";
}

$coinciden = mysqli_query($db_con, "SELECT materia FROM profesores WHERE profesor='$pr' and grupo = '$dalumno[3]'");
while($coinciden0 = mysqli_fetch_row($coinciden)){
$asignatur = $coinciden0[0];
$asignatur = str_replace("nbsp;","",$asignatur);
$asignatur = str_replace("&","",$asignatur);
}

$as=mysqli_query($db_con, "SELECT COMBASI FROM alma WHERE CLAVEAL='$claveal' ");
$asi=mysqli_fetch_array($as);
$asi1 = substr($asi[0],0,strlen($asi[0]) -1);
$coinciden = mysqli_query($db_con, "SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]' and asignaturas.curso='$n_cur' and abrev not like '%\_%' and profesor = '$pr'");
if(mysqli_num_rows($coinciden)<1 and stristr($_SESSION['cargo'],'1') == TRUE){
$coinciden = mysqli_query($db_con, "SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]' and asignaturas.curso='$n_cur' and abrev not like '%\_%'");	
}
echo "<div class='form-group'><label>Asignatura</label><select name='asignatura' class='form-control' required onChange='submit()'>";
echo"<OPTION>$asignatura</OPTION>";
while($coinciden0 = mysqli_fetch_row($coinciden)){
$n_asig = $coinciden0[0];
$cod = $coinciden0[1];
if (strstr($asi1,$cod)==TRUE) {
				if($n_asig == $asignatur){
					if (isset($asignatura)) {
						$materia = $asignatura;
					}
					else{
						$materia = $n_asig;
						//$extra = " selected='selected'";
					}
				echo "<OPTION $extra value='$n_asig'>$n_asig</OPTION>";
				}
				else {echo"<OPTION value='$n_asig'>$n_asig</OPTION>";}
}
}
echo $pendiente;
echo "</select></div>";

$ya_hay=mysqli_query($db_con, "select informe from infotut_profesor where asignatura = '$materia' and id_alumno = '$id'");
$ya_hay1=mysqli_fetch_row($ya_hay);
if (isset($asignatura)) {
						$informe=$ya_hay1[0];
					}
					else{
						$informe="";
						//$materia = $n_asig;
						//$extra = " selected='selected'";
					}
echo "<div class='form-group'><label>Informe</label><textarea rows='6' name='informe' class='form-control' required>$informe</textarea></div>";
?>
<input name="submit1" type=submit value="Enviar Datos" class="btn btn-primary btn-block">
</form>
</div>
</div>
</div>
</div>

<?php include("../../pie.php");?>		
</body>
</html>
