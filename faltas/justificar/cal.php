<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

if (isset($_GET['month'])) { $month = $_GET['month']; $month = preg_replace ("/[[:space:]]/", "", $month); $month = preg_replace ("/[[:punct:]]/", "", $month); $month = preg_replace ("/[[:alpha:]]/", "", $month); }
if (isset($_GET['year'])) { $year = $_GET['year']; $year = preg_replace ("/[[:space:]]/", "", $year); $year = preg_replace ("/[[:punct:]]/", "", $year); $year = preg_replace ("/[[:alpha:]]/", "", $year); if ($year < 1990) { $year = 1990; } if ($year > 2035) { $year = 2035; } }
if (isset($_GET['today'])) { $today = $_GET['today']; $today = preg_replace ("/[[:space:]]/", "", $today); $today = preg_replace ("/[[:punct:]]/", "", $today); $today = preg_replace ("/[[:alpha:]]/", "", $today); }

$month = (isset($month)) ? $month : date("n",time());
$year = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$daylong = date("l",mktime(1,1,1,$month,$today,$year));
$monthlong = date("F",mktime(1,1,1,$month,$today,$year));
$dayone = date("w",mktime(1,1,1,$month,1,$year))-1;
$numdays = date("t",mktime(1,1,1,$month,1,$year));
$alldays = array('Lun','Mar','Mie','Jue','Vie','Sáb','Dom');
$next_year = $year + 1;
$last_year = $year - 1;
include("nombres.php");
 
if ($today > $numdays) { $today--; }

// Estructura de la Tabla
echo "<table class='table table-bordered table-striped' style=''><tr><th style='text-align:center'>
	<a href='".$_SERVER['PHP_SELF']."?year=$last_year&today=$today&month=$month&profesor=$profesor&unidad=$unidad&alumno=$alumno'>
<i class='fa fa-arrow-circle-left fa-2x pull-left' name='calb2' style='margin-right:20px;'> </i> </a>
<h3 style='display:inline'>$year</h3>
<a href='".$_SERVER['PHP_SELF']."?year=$next_year&today=$today&month=$month&profesor=$profesor&unidad=$unidad&alumno=$alumno'>
<i class='fa fa-arrow-circle-right fa-2x pull-right' name='calb1' style='margin-left:20px;'> </i> </a></th></tr></table>";
echo "<table class='table table-bordered' style=''>
      <tr>";
$meses = array("1"=>"Ene" ,"2"=>"Feb" ,"3"=>"Mar" ,"4"=>"Abr" ,"5"=>"May" ,"6"=>"Jun" ,"7"=>"Jul" ,"8"=>"Ago" ,"9"=>"Sep" ,"10"=>"Oct" ,"11"=>"Nov" ,"12"=>"Dic");
foreach ($meses as $num_mes => $nombre_mes) {

	if ($num_mes==$month) {
		echo "<th style='background-color:#08c'>
		<a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&month=".$num_mes."\" style='color:#efefef'>".$nombre_mes."</a> </th>";
	}
	else{
		echo "<th>
		<a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&month=".$num_mes."\">".$nombre_mes."</a> </th>";
	}
	if ($num_mes=='6') {
		echo "</tr><tr>";
	}
}
echo "</tr>
    </table>";
 
//Nombre del Mes
echo "<table class='table table-bordered' style=''><tr>";
echo "<td colspan=\"7\" valign=\"middle\" align=\"center\"><h4 align='center'>" . $monthlong .
"</h4></td>";
echo "</tr><tr>";


//Nombre de Días
foreach($alldays as $value) {
	echo "<th  style='background-color:#eee'>
	$value</th>";
}
echo "</tr><tr>";


//Días vacíos
if ($dayone < 0) $dayone = 6;
for ($i = 0; $i < $dayone; $i++) {
	echo "<td>&nbsp;</td>";
}


//Días

for ($zz = 1; $zz <= $numdays; $zz++) {

	if ($i >= 7) {  print("</tr>\n<tr>\n"); $i=0; }

	if ($result_found != 1) {

		//Buscar falta en el día y marcarla

		$sql_currentday = "$year-$month-$zz";
		// echo $sql_currentday;
		$hora_F="";
		$falta_F="";
		$event = "SELECT FALTA, hora FROM FALTAS, FALUMNOS WHERE FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.FECHA = '$sql_currentday' and FALTAS.claveal = '$alumno' and FALTA not like 'R'";
		//echo $eventQuery;
		$Exec = mysqli_query($db_con, $event);		
		while($h_f = mysqli_fetch_row($Exec)){
			if ($h_f[0] == "F") {	
				$hora_F.=$h_f[1].",";
			}
				$falta_F.=$h_f[0].",";
				}
				
		$eventQuery = "SELECT FALTA, hora FROM FALTAS, FALUMNOS WHERE FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.FECHA = '$sql_currentday' and FALTAS.claveal = '$alumno' and FALTA not like 'R'";
		//echo $eventQuery;
		$eventExec = mysqli_query($db_con, $eventQuery);		
		if($row = mysqli_fetch_array($eventExec)) {
			if (strlen($row[0]) > 0) {
				if ($row[0] == "F" or strstr($falta_F,"F")==TRUE) {						
				echo "<td style=\"background-color:#9d261d;\">";	
				
			?>
					
<!-- Button trigger modal -->
<a href="<?php echo $_SERVER['PHP_SELF']."?falta=J&profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month&J=1>";?>" data-toggle="modal" data-target="#myModalF<?php echo "_".$zz;?>">
			<span style=color:white> <?php echo $zz; ?></span>
			<?php if(strstr($falta_F,"J")==TRUE){?>
			<i class="fa fa-warning pull-right" style="color:white;" data-bs="tooltip" title="El alumno tiene faltas de asistencia justificadas y no justificadas"></i>
			<?php }?>
			</a>

<!-- Modal -->
<div class="modal fade" id="myModalF<?php echo "_".$zz;?>" tabindex="-1"
	role="dialog" aria-labelledby="myModalFLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title text-info" id="myModalFLabel<?php echo "_".$zz;?>">Selecciona
las Horas para Justificar: <span class='text-success'> <?php echo "$zz-$month-$year";?></span></h4>
</div>
<div class="modal-body">
<form action="index.php" method="POST"
	name="marcar_falta<?php echo "_".$zz;?>" style="display: inline">&nbsp;&nbsp;
<div class="checkbox" style="display: inline; align: center;"><label
	class="checkbox-inline"> <input type="checkbox" <?php if (strstr($hora_F,"1")==TRUE){ echo "checked"; } else{ echo "disabled";}?>
	name="1<?php echo "_".$zz;?>" value="1">1ª</label> <label
	class="checkbox-inline"> <input type="checkbox" <?php if (strstr($hora_F,"2")==TRUE){ echo "checked"; } else{ echo "disabled";}?>
	name="2<?php echo "_".$zz;?>" value="2">2ª</label> <label
	class="checkbox-inline"> <input type="checkbox" <?php if (strstr($hora_F,"3")==TRUE){ echo "checked"; } else{ echo "disabled";}?>
	name="3<?php echo "_".$zz;?>" value="3">3ª</label> <label
	class="checkbox-inline"> <input type="checkbox" <?php if (strstr($hora_F,"4")==TRUE){ echo "checked"; } else{ echo "disabled";}?>
	name="4<?php echo "_".$zz;?>" value="4">4ª</label> <label
	class="checkbox-inline"> <input type="checkbox" <?php if (strstr($hora_F,"5")==TRUE){ echo "checked"; } else{ echo "disabled";}?>
	name="5<?php echo "_".$zz;?>" value="5">5ª</label> <label
	class="checkbox-inline"> <input type="checkbox" <?php if (strstr($hora_F,"6")==TRUE){ echo "checked"; } else{ echo "disabled";}?>
	name="6<?php echo "_".$zz;?>" value="6">6ª</label></div>

</div>
<div class="modal-footer"><input type="hidden" name="profesor"
	value="<?php echo $profesor;?>"> <input type="hidden" name="unidad"
	value="<?php echo $unidad;?>"> <input type="hidden" name="alumno"
	value="<?php echo $alumno;?>"> <input type="hidden" name="year"
	value="<?php echo $year;?>"> <input type="hidden" name="month"
	value="<?php echo $month;?>"> <input type="hidden" name="today"
	value="<?php echo $zz;?>"> <input type="hidden" name="F" value="1"> <input
	type="submit" class="btn btn-danger" name="Enviar" value="Justificar">
<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
</form>
</div>
</div>
</div>
</div>
<script>
function seleccionar_todo<?php echo "_".$zz;?>(){
	for (i=0;i<document.marcar_falta<?php echo "_".$zz;?>.elements.length;i++)
		if(document.marcar_falta<?php echo "_".$zz;?>.elements[i].type == "checkbox")	
			document.marcar_falta<?php echo "_".$zz;?>.elements[i].checked=1
}
</script>
					<?
					echo "</td>";
					$result_found = 1;
				}
				elseif($row[0] == "J") {
					//        echo "<td valign=\"middle\" align=\"center\" style=\"background-color:#009933\"><span style=color:white>$zz</span></td>\n";
					echo "<td style=\"background-color:#46a546\"><a href=\"".$_SERVER['PHP_SELF']."?falta=J&profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month&F=1\"><span style=color:white>$zz</a></span></td>\n";
					$result_found = 1;
				}
			}
		}
	}

	if ($result_found != 1) {
		$timestamp0 = strtotime($sql_currentday);
		$timestamp1 = strtotime($config['curso_fin']);
		$timestamp2= strtotime($config['curso_inicio']);
		
		
		$dia_festivo="";
		$repe=mysqli_query($db_con, "select fecha from festivos where date(fecha) = date('$sql_currentday')");
		if (mysqli_num_rows($repe) > '0') {
			$dia_festivo='1';
		}

		if($dia_festivo=='1')
		{
			echo "<td><span class='text-warning'>$zz</span></td>";
		}
		
		elseif($timestamp0 > $timestamp1){
			echo "<td><span class='text-warning'>$zz</span></td>";
		} 
		
		elseif($timestamp0 < $timestamp2){
			echo "<td><span class='text-warning'>$zz</span></td>";
		} 
		
		elseif (($i== "5") or ($i== "6")){
			echo "<td><span class='text-warning'>$zz</span></td>";
		}
		else{
			echo "<td>";
			//echo "<a href=\"".$_SERVER['PHP_SELF']."?profesor=$profesor&unidad=$unidad&alumno=$alumno&year=$year&today=$zz&month=$month\" class=\"normal\">$zz</a>";
			?>
<!-- Button trigger modal -->
<a href="#" data-toggle="modal" data-target="#myModal<?php echo "_".$zz;?>">
			<?php echo $zz;
			?> </a>

<!-- Modal -->
<div class="modal fade" id="myModal<?php echo "_".$zz;?>" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title text-info" id="myModalLabel<?php echo "_".$zz;?>">Selecciona
las Horas de la Ausencia.</h4>
</div>
<div class="modal-body">
<a onClick="seleccionar_todo<?php echo "_".$zz;?>()"
	class="btn btn-success" style="display: inline">Marcar todas</a>
<form action="index.php" method="POST"
	name="marcar_falta<?php echo "_".$zz;?>" style="display: inline">&nbsp;&nbsp;
<div class="checkbox" style="display: inline; align: center;"><label
	class="checkbox-inline"> <input type="checkbox"
	name="1<?php echo "_".$zz;?>" value="1">1ª</label> <label
	class="checkbox-inline"> <input type="checkbox"
	name="2<?php echo "_".$zz;?>" value="2">2ª</label> <label
	class="checkbox-inline"> <input type="checkbox"
	name="3<?php echo "_".$zz;?>" value="3">3ª</label> <label
	class="checkbox-inline"> <input type="checkbox"
	name="4<?php echo "_".$zz;?>" value="4">4ª</label> <label
	class="checkbox-inline"> <input type="checkbox"
	name="5<?php echo "_".$zz;?>" value="5">5ª</label> <label
	class="checkbox-inline"> <input type="checkbox"
	name="6<?php echo "_".$zz;?>" value="6">6ª</label></div>

</div>
<div class="modal-footer"><input type="hidden" name="profesor"
	value="<?php echo $profesor;?>"> <input type="hidden" name="unidad"
	value="<?php echo $unidad;?>"> <input type="hidden" name="alumno"
	value="<?php echo $alumno;?>"> <input type="hidden" name="year"
	value="<?php echo $year;?>"> <input type="hidden" name="month"
	value="<?php echo $month;?>"> <input type="hidden" name="today"
	value="<?php echo $zz;?>"> <input type="hidden" name="F" value="1"> <input
	type="submit" class="btn btn-danger" name="Enviar" value="Registrar">
<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
</form>
</div>
</div>
</div>
</div>
<script>
function seleccionar_todo<?php echo "_".$zz;?>(){
	for (i=0;i<document.marcar_falta<?php echo "_".$zz;?>.elements.length;i++)
		if(document.marcar_falta<?php echo "_".$zz;?>.elements[i].type == "checkbox")	
			document.marcar_falta<?php echo "_".$zz;?>.elements[i].checked=1
}
</script>
			<?php
			echo "</td>";
		}



	}
	$i++; $result_found = 0;
}

$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) { $create_emptys = 0; }

if ($create_emptys != 0) {
	echo "<td colspan=\"$create_emptys\">&nbsp;</td>";
}
echo "</tr>
      </table>";
?>
