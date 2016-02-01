<?php
if (isset($_POST['submit1']) and $_POST['submit1']=="Enviar Datos") {
	include("rellenainf.php");
	exit;
}

require('../../bootstrap.php');


$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];

include("../../menu.php");
include("menu.php");

?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tareas <small> Redactar Informe</small></h2>
</div>
<br>

<div class="col-md-6 col-md-offset-3">	

<div class="well well-large" >
<form name="informar" method="POST" action="informar.php?id=<?php echo $id;?>">         
<?php

echo "<input type='hidden'  name='ident' value='$id'>";
echo "<input type='hidden'  name='profesor' value='$profesor'>";
$alumno=mysqli_query($db_con, "SELECT tareas_alumnos.CLAVEAL, tareas_alumnos.APELLIDOS, tareas_alumnos.NOMBRE, tareas_alumnos.unidad, tareas_alumnos.id, tareas_alumnos.fecha, duracion, curso FROM tareas_alumnos, alma WHERE alma.claveal=tareas_alumnos.claveal and ID='$id'");
$dalumno = mysqli_fetch_array($alumno);
$n_cur=$dalumno[7];

if (empty($dalumno[0])) {
echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo.<br /><br /
><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
	exit();	
}
$claveal=trim($dalumno[0]);
echo "<table align=center class='table table-striped'>";
echo "<thead><tr  class='active'><th>Alumno/a </th>
 <th>Grupo</th><th nowrap>Expulsión</th><th>Duración</th><tr></thead><tbody>
<TR><td>$dalumno[1], $dalumno[2]</td>
<td>$dalumno[3]</td><td>$dalumno[5]</td><td>$dalumno[6]</td></tr></TABLE>";

   	$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto) and !(empty($dalumno[0]))) {
		echo "<div style='width:150px;margin:auto;'>";
		echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' class='img-rsponsive'  />";
		echo "</div>";
	}

$coinciden = mysqli_query($db_con, "SELECT materia FROM profesores WHERE profesor='$profesor' and grupo = '$dalumno[3]'");
while($coinciden0 = mysqli_fetch_row($coinciden)){
$asignatur = $coinciden0[0];
$asignatur = str_replace("nbsp;","",$asignatur);
$asignatur = str_replace("&","",$asignatur);
}

/*$as=mysqli_query($db_con, "SELECT COMBASI FROM alma WHERE CLAVEAL='$claveal' ");
$asi=mysqli_fetch_array($as);
$asi1 = substr($asi[0],0,strlen($asi[0]) -1);
$asig0 = explode(":",$asi1);
foreach($asig0 as $asignatura){			
$abrev = mysqli_query($db_con, "select distinct nombre from asignaturas where codigo = '$asignatura'  and abrev not like '%\_%' limit 1");
				while($abrev0 = mysqli_fetch_row($abrev)){
				$nombre10 = $abrev0[0];
				if($nombre10 == $asignatur){
				echo "<OPTION selected='selected'>$nombre10 </OPTION>";
				}
				else {echo"<OPTION>$nombre10</OPTION>";}

}
}*/

$as=mysqli_query($db_con, "SELECT COMBASI FROM alma WHERE CLAVEAL='$claveal' ");
$asi=mysqli_fetch_array($as);
$asi1 = substr($asi[0],0,strlen($asi[0]) -1);

$coinciden = mysqli_query($db_con, "SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]' and asignaturas.curso='$n_cur' and abrev not like '%\_%' and profesor = '$profesor'");
echo "<div class='form-group'><label>Asignatura</label><select name='asignatura' class='form-control'>";
if(mysqli_num_rows($coinciden)<1 and stristr($_SESSION['cargo'],'1') == TRUE){
$coinciden = mysqli_query($db_con, "SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]' and asignaturas.curso='$n_cur' and abrev not like '%\_%'");
}
echo"<OPTION></OPTION>";
while($coinciden0 = mysqli_fetch_row($coinciden)){
$n_asig = $coinciden0[0];
$cod = $coinciden0[1];
if (strstr($asi1,$cod)==TRUE) {
				if($n_asig == $asignatur){
				$materia = $n_asig;
				echo "<OPTION selected='selected'>$n_asig </OPTION>";
				}
				else {echo"<OPTION>$n_asig</OPTION>";}
}
}

echo "</select></div>";

echo "</td>";
$ya_hay=mysqli_query($db_con, "select tarea from tareas_profesor where asignatura = '$materia' and id_alumno = '$id'");
$ya_hay1=mysqli_fetch_row($ya_hay);
$informe=$ya_hay1[0];
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
