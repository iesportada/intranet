<?php
require('../bootstrap.php');


$pr = $_SESSION['profi'];

include("../menu.php");
include("menu.php");

// Titulo
?>
<div class='container'>
<div class='row'>
<br>
<div class='page-header hidden-print'>
<h2 class='no_imprimir'>Cuaderno de Notas&nbsp;&nbsp;<small>Horario del Profesor</small></h2>
</div>

<div align="center">';

<table class="table table-bordered table-condensed table-striped table-centered" style="width:650px">
<thead>
  <tr>
	<th width="20">&nbsp;</th>
	<th width="20">Lunes</th>
	<th width="20">Martes</th>
	<th width="20">Miércoles</th>
	<th width="20">Jueves</th>
	<th width="20">Viernes</th>
  </tr>
</thead>
<tbody>
<?php	
// Horas del día
$todas_horas = array (1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6" );
foreach ( $todas_horas as $n_hora => $nombre ) {	
echo '<tr><th>'.$nombre.'ª</th>';
	
	//Días
	for($z = 1; $z < 6; $z ++) {

		?>
<td valign="top">
<div align=center>
      <?php
		if (! (empty ( $z ) and ! ($n_hora))) {
			$extra = "and dia = '$z' and hora = '$n_hora'";
		}

		$asignatur1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_asig, a_grupo FROM  horw where prof = '$pr' $extra" );	
		$rowasignatur1 = mysqli_fetch_row ( $asignatur1 );
		
		if (strlen( $rowasignatur1 [2] )>1 and ! ($rowasignatur1 [0] == "25" or $rowasignatur1 [0] == "44")) {
			echo "<span class='label label-info'>" . $rowasignatur1 [1] . "</span><br />";
		}
		
		elseif (empty ( $rowasignatur1 [2] ) and ! ($rowasignatur1 [0] == "25" or $rowasignatur1 [0] == "44")) {
			echo "<span class='label label-default'>" . $rowasignatur1 [1] . "</span><br />";
		}
		elseif (($rowasignatur1 [0] == "25" or $rowasignatur1 [0] == "44") and $config['mod_asistencia']) {
			if (strstr($_SESSION ['cargo'],"1")==TRUE) {
				echo "<a href='//".$config['dominio']."/intranet/admin/guardias/admin.php'><span class='label label-danger'>".$rowasignatur1[1]."</span>";
			}
			else{
				echo "<a href='//".$config['dominio']."/intranet/admin/guardias/index.php?n_dia=$z&hora=$n_hora&profeso=$pr' class='label label-danger'>" . $rowasignatur1 [1] . "</a>";
			}
		}
		// Recorremos los grupos a los que da en ese hora.
		$asignaturas1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_grupo FROM  horw where prof = '$pr' and dia = '$z' and hora = '$n_hora'" );
		while ( $rowasignaturas1 = mysqli_fetch_array ( $asignaturas1 ) ) {
			$grupo = $rowasignaturas1 [1];
				echo "<a href='//".$config['dominio']."/intranet/cuaderno.php?dia=$z&hora=$n_hora&curso=$grupo&asignatura=$rowasignatur1[0]&profesor=$pr' style='font-size:0.8em'>";
			if (is_numeric ( substr ( $grupo, 0, 1 ) )) {
				echo $grupo . "<br />";
			}
				echo "</a>";
		}
		?>
    </span></div>
</td>
<?php
	}
	?></tr><?php
}
?>
</tbody>
</table>
</div>
</div>
</div>
<?php include("pie.php"); ?>
</body>
</html>



