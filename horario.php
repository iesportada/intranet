<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<h4><span class="fa fa-clock-o fa-fw"></span> Horario</h4>

<table class="table table-bordered table-condensed table-striped table-centered">
<thead>
  <tr>
	<th width="20">&nbsp;</th>
	<th width="20">L</th>
	<th width="20">M</th>
	<th width="20">X</th>
	<th width="20">J</th>
	<th width="20">V</th>
  </tr>
</thead>
<tbody>
<?php	
// Horas del día
$t_hora = mysqli_query($db_con,"select hora, hora_inicio, hora_fin from tramos");
while($todas_horas=mysqli_fetch_array($t_hora)){
$n_hora = $todas_horas[0];
$hora_inicio = $todas_horas[1];
$nombre = $hora_inicio;
$algo = "";
for($i = 1; $i < 6; $i ++) {
$hay_algo = mysqli_query($db_con, "SELECT distinct  c_asig, a_asig, a_grupo, asig FROM  horw where prof = '$pr' and dia = '$i' and hora = '$n_hora' ORDER BY a_grupo" );
if (mysqli_num_rows($hay_algo)>0) {
	$algo = "1";
}

}

if ($algo=="1") {
	echo '<tr><th>'.$nombre.'</th>';
	
	//Días
	for($z = 1; $z < 6; $z ++) {

		?>
<td>
      <?php
		if (! (empty ( $z ) and ! ($n_hora))) {
			$extra = "and dia = '$z' and hora = '$n_hora'";
		}

		$asignatur1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_asig, a_grupo, asig FROM  horw where prof = '$pr' $extra ORDER BY a_grupo" );
		$rowasignatur1 = mysqli_fetch_row ( $asignatur1 );
		$act_seneca = mysqli_query($db_con, "SELECT * FROM  actividades_seneca where idactividad = '$rowasignatur1[0]' and nomactividad not like 'TUT%' and idactividad not like '21'" );	
		$asig_seneca = mysqli_query($db_con, "SELECT * FROM  asignaturas where codigo = '$rowasignatur1[0]'" );
		
		if(mysqli_num_rows($act_seneca)>0 and ! ($rowasignatur1 [0] == "25" or $rowasignatur1 [0] == "44")){
			echo "<span class='label label-default' data-bs='tooltip' title='".$rowasignatur1[3]."'>" . $rowasignatur1 [1] . "</span><br />";
		}		
		elseif (mysqli_num_rows($asig_seneca)>0 and ! ($rowasignatur1 [0] == "25" or $rowasignatur1 [0] == "44")) {
			echo "<span class='label label-info' data-bs='tooltip' title='".$rowasignatur1[3]."'>" . $rowasignatur1 [1] . "</span><br />";
		}		
		elseif (empty ( $rowasignatur1 [2] ) and ! ($rowasignatur1 [0] == "25" or $rowasignatur1 [0] == "44")) {
			echo "<span class='label label-warning' data-bs='tooltip' title='".$rowasignatur1[3]."'>" . $rowasignatur1 [1] . "</span><br />";
		}
		elseif ($rowasignatur1 [1]=="GUCON") {
			echo "<a href='//".$config['dominio']."/intranet/admin/fechorias/convivencia.php' style='text-decoration: none;'><span class='label label-danger' data-bs='tooltip' title='".$rowasignatur1[3]."'>".$rowasignatur1[1]."</span>";
		}
		elseif ((($rowasignatur1 [0] == "25" and $rowasignatur1 [1]!=="GUCON") or $rowasignatur1 [0] == "44") and $config['mod_asistencia']) {
			if (strstr($_SESSION ['cargo'],"1")==TRUE and $rowasignatur1 [0] == "44") {
				echo "<a href='//".$config['dominio']."/intranet/admin/fechorias/admin.php' style='text-decoration: none;'><span class='label label-success' data-bs='tooltip' title='".$rowasignatur1[3]."'>".$rowasignatur1[1]."</span>";
			}
			else{
				echo "<a href='//".$config['dominio']."/intranet/admin/guardias/index.php?n_dia=$z&hora=$n_hora&profeso=$pr' style='text-decoration: none;'><span class='label label-danger' data-bs='tooltip' title='".$rowasignatur1[3]."'>" . $rowasignatur1 [1] . "</span></a>";
			}
		}
		// Recorremos los grupos a los que da en ese hora.
		$rep_grupo = "";
		$cont = 1;
		$asignaturas1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_grupo FROM  horw where prof = '$pr' and dia = '$z' and hora = '$n_hora' ORDER BY a_grupo" );
		while ( $rowasignaturas1 = mysqli_fetch_array ( $asignaturas1 ) ) {
			$grupo = $rowasignaturas1 [1];
			
			echo "<a href='//".$config['dominio']."/intranet/cuaderno.php?dia=$z&hora=$n_hora&curso=$grupo&asignatura=$rowasignatur1[0]' style='font-size:0.8em'>";
			if (is_numeric ( substr ( $grupo, 0, 1 ) )) {
				if ($grupo != $rep_grupo) {

					if($cont > 1) {
						if (stristr($grupo, '-') == TRUE) {
							$exp_grupo = explode('-', $grupo);
							echo "/".$exp_grupo[1];
						}
						elseif (stristr($grupo, 'º') == TRUE) {
							$exp_grupo = explode('º', $grupo);
							echo "/".$exp_grupo[1];
						}
						else {
							echo $grupo.'<br>';
						}
					}
					else {
						echo $grupo;
					}
				}
			}
			echo "</a>";
			$rep_grupo = $grupo;
			$cont++;
		}
		?>
    </span>
</td>
<?php
	}
}
	?></tr><?php
}
?>
</tbody>
</table>

<a class="btn btn-sm btn-default" href="xml/jefe/horarios/index.php">Modificar horario</a>