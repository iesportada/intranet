<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];

include("../../menu.php");
include("menu.php");
?>

<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tareas <small> Expulsión o ausencia del Alumno</small></h2>
</div>
<br>

<div class="col-md-6 col-md-offset-3">	

<?php
// Buscamos los grupos que tiene el Profesor, con su asignatura y nivel
	$SQLcurso = "select distinct grupo, materia, nivel from profesores where profesor = '$profesor'";
	//echo $SQLcurso;
$resultcurso = mysqli_query($db_con, $SQLcurso);
	while($rowcurso = mysqli_fetch_array($resultcurso))
	{
	$unidad = $rowcurso[0];
	$asignatura = str_replace("nbsp;","",$rowcurso[1]);
	$asignatura = str_replace("&","",$asignatura);
	

// Buscamos el código de la asignatura (materia) de cada grupo al que da el profesor
	$asigna0 = "select codigo, nombre from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'";
	//echo "$asigna0<br>";
	$asigna1 = mysqli_query($db_con, $asigna0);
	$asigna2 = mysqli_fetch_array($asigna1);
	$codasi = $asigna2[0];
	$n_asig = $asigna2[1];
	$hoy=date('Y-m-d');
// Buscamos los alumnos de esos grupos que tienen informes de Tutoría activos y además tienen esa asignatura en su el campo combasi	
	$query = "SELECT tareas_alumnos.ID, tareas_alumnos.CLAVEAL, tareas_alumnos.APELLIDOS, tareas_alumnos.NOMBRE, tareas_alumnos.unidad, alma.matriculas, tareas_alumnos.FECHA, tareas_alumnos.DURACION FROM tareas_alumnos, alma WHERE tareas_alumnos.claveal = alma.claveal and  date(tareas_alumnos.FECHA)>='$hoy' and tareas_alumnos. unidad = '$unidad' and combasi like '%$codasi%' ORDER BY tareas_alumnos.FECHA asc";
	//echo "$query<br>";
	$result = mysqli_query($db_con, $query);
	$result0 = mysqli_query($db_con, "select tutor from FTUTORES where unidad = '$unidad'" );
	$row0 = mysqli_fetch_array ( $result0 );	
	$tuti = $row0[0];
	if (mysqli_num_rows($result) > 0)
{
	echo "<form name='consulta' method='POST' action='tutoria.php'>";
//$num_informe = mysqli_num_rows($sql1);
echo "<p class='lead text-info'>$unidad <br /><small class='text-muted'>$n_asig</small></p>";
echo "<table align=center  class='table'><tr class='active'>";
echo "<th>Alumno</th>
<th>Fecha Inicio</th>
<th></th>
</tr>";
$count = "";
	while($row = mysqli_fetch_array($result))
	{
		
// Comprobamos que el profesor no ha rellenado el informe de esa asignatura	
$hay = "select * from tareas_profesor where id_alumno = '$row[0]' and asignatura = '$asignatura'";
$si = mysqli_query($db_con, $hay);	
if (mysqli_num_rows($si) > 0)
		{ 
		echo "<tr><TD> $row[3] $row[2]</td>
   <TD colspan='1' nowrap style='vertical-align:middle'><span class='label label-success'>Informe ya rellenado</span></td>";
   echo "<TD> 
			<a href='infocompleto.php?id=$row[0]&c_asig=$asignatura' class=' btn-mini'><i class='fa fa-search' title='Ver Informe'> </i></a>";			
   if (stristr($cargo,'1') == TRUE or ($tuti == $_SESSION['profi'])) {
   	echo "&nbsp;&nbsp;<a href='borrar_informe.php?id=$row[0]&del=1' class=' btn-mini' data-bb='confirm-delete'><i class='fa fa-trash-o' title='Borrar Informe' > </i> </a> 	";
   }
			echo "</td>";	
   }
   		else
		{
		$count = $count + 1;
		echo "<tr><TD>
	 $row[3] $row[2]</td>
   <TD>$row[6]</td>
   ";
	 echo "
	 <input type='hidden' name='profesor' value='$profesor'>";
			echo "
      <td>";
	  if (mysqli_num_rows($si) > 0 and $count < 1)
		{} 
		else{
			echo "<a href='infocompleto.php?id=$row[0]&c_asig=$asignatura' class=' btn-mini'><i class='fa fa-search' title='Ver Informe'> </i> </a>";		
		 if (stristr($cargo,'1') == TRUE or ($tuti == $_SESSION['profi'])) {
   	echo "&nbsp;&nbsp;<a href='borrar_informe.php?id=$row[0]&del=1' class=' btn-mini' data-bb='confirm-delete'><i class='fa fa-trash-o' title='Borrar Informe' > </i> </a> 	";
   }	
		}
	  if (mysqli_num_rows($si) > 0 and $count < 1)
		{} 
		else{ 
echo "&nbsp;&nbsp;<a href='informar.php?id=$row[0]' class=' btn-mini'><i class='fa fa-pencil-square-o' title='Redactar Informe'> </i> </a>";
			}
		}
	}	

	 echo "</td>
	  </tr>
	  </table><br /></form><hr>";

}
else{

		echo "<p class='lead text-info'>$unidad<br /><small class='text-muted'> $n_asig</small></p>";
				echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No hay Informes de Tareas Activos para t&iacute;</div></div><hr>';
}

	}
	   		
?>
</div>
</div>
</div>
<?php include("../../pie.php");?>		
</body>
</html>
