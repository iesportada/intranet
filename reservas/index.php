<?php
require('../bootstrap.php');

if (isset($_GET['recurso'])) {	
	$nombre_rec = $_GET['recurso'];	
}

include("../menu.php");
include("menu.php");
?>

<div class="container">

	<div class="page-header">
	  <h2>Sistema de Reservas <small> <?php echo $nombre_rec; ?></small></h2>
	</div>

<?php

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
$alldays = array('L','M','X','J','V','S','D');
$next_year = $year + 1;
$last_year = $year - 1;
    if ($daylong == "Sunday")
	{$daylong = "Domingo";}
    elseif ($daylong == "Monday")
	{$daylong = "Lunes";}
    elseif ($daylong == "Tuesday")
	{$daylong = "Martes";}
    elseif ($daylong == "Wednesday")
	{$daylong = "Miércoles";}
    elseif ($daylong == "Thursday")
	{$daylong = "Jueves";}
    elseif ($daylong == "Friday")
	{$daylong = "Viernes";}
    elseif ($daylong == "Saturday")
	{$daylong = "Sábado";}
    

    if ($monthlong == "January")
	{$monthlong = "Enero";}
    elseif ($monthlong == "February")
	{$monthlong = "Febrero";}
    elseif ($monthlong == "March")
	{$monthlong = "Marzo";}
    elseif ($monthlong == "April")
	{$monthlong = "Abril";}
    elseif ($monthlong == "May")
	{$monthlong = "Mayo";}
    elseif ($monthlong == "June")
	{$monthlong = "Junio";}
    elseif ($monthlong == "July")
	{$monthlong = "Julio";}
    if ($monthlong == "August")
	{$monthlong = "Agosto";}
    elseif ($monthlong == "September")
	{$monthlong = "Septiembre";}
    elseif ($monthlong == "October")
	{$monthlong = "Octubre";}
    elseif ($monthlong == "November")
	{$monthlong = "Noviembre";}
    elseif ($monthlong == "December")
	{$monthlong = "Diciembre";}
if ($today > $numdays) { $today--; }

$primero = 0;
$rc = mysqli_query($db_con, "select reservas_tipos.id, tipo, elemento, id_tipo, reservas_elementos.observaciones from reservas_tipos, reservas_elementos where reservas_tipos.id = reservas_elementos.id_tipo and tipo = '$recurso'");
	while ($srv = mysqli_fetch_array($rc)) {
		$ci+=1;	
		$servicio = $srv[2];
		$lugar = $srv[4];
		
if ($ci == 1 or $ci == 4 or $ci == 7 or $ci == 10 or $ci == 13 or $ci == 16){
	echo ($primero) ? '</div> <hr>' : '';
	echo '<div class="row">';
	$primero = 1;
}	

?>
<div class="col-sm-4">
	<a name="<?php echo $servicio; ?>"></a>
	<h3 class="text-center"><?php echo $servicio;?></h3> 
	<h4><small><?php echo $lugar; ?></small></h4>
	
	<table class="table table-bordered table-centered">
		<thead>
			<tr>
				<th colspan="7"><h4><?php echo $monthlong; ?></h4></th>
			</tr>
			<tr>
				<?php foreach ($alldays as $value): ?>
				<th><?php echo $value; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
<?php
//Días vacíos
if ($dayone < 0) $dayone = 6;
for ($i = 0; $i < $dayone; $i++) {
  echo "<td>&nbsp;</td>";
}


//Días
for ($zz = 1; $zz <= $numdays; $zz++) {
  if ($i >= 7) {  print("</tr><tr>"); $i=0; }
  // Mirar a ver si hay alguna ctividad en el días
  $result_found = 0;
  if ($zz == $today) { 
    echo "<td class=\"calendar-today\">$zz</td>";
    $result_found = 1;
  }
  
  if ($result_found != 1) { 
		//Buscar actividad para el día y marcarla
		$sql_currentday = "$year-$month-$zz";
    	$eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM `reservas` WHERE eventdate = '$sql_currentday' and servicio = '$servicio'";
 		$eventExec = mysqli_query($db_con, $eventQuery );
		if (mysqli_num_rows($eventExec)>0) {
			while ( $row = mysqli_fetch_array ( $eventExec ) ) {
echo "<td class=\"calendar-orange\">$zz</td>";
$result_found = 1;
		}	
		}
		else{
		$sql_currentday = "$year-$month-$zz";
		$fest = mysqli_query($db_con, "select distinct fecha, nombre from $db.festivos WHERE fecha = '$sql_currentday'");
		if (mysqli_num_rows($fest)>0) {
		$festiv=mysqli_fetch_array($fest);
			        echo "<td class=\"calendar-red\">$zz</a></td>\n";
				$result_found = 1;
				}	
		}
		
	}

  if ($result_found != 1) {
    echo "<td>$zz</td>";
  }

  $i++; $result_found = 0;
}

$create_emptys = 7 - (($dayone + $numdays) % 7);
if ($create_emptys == 7) { $create_emptys = 0; }

if ($create_emptys != 0) {
  echo "<td colspan=\"$create_emptys\">&nbsp;</td>";
}

echo "</tr>";
echo "</table>";
?>
	<div class="well">
		<h4 class="text-info">Próximos días</h4>
<?php
for ($i = $today; $i <= ($today + 6); $i++) {
  $current_day = $i;
  $current_year = $year;
  $current_month = $month;
  if ($i > $numdays) {
    $current_day = ($i - $numdays);
    $current_month = $month + 1;
    if ($current_month > 12) {
      $current_month = 1; $current_year = $year + 1;
    }
  }
  $dayname = date("l",mktime(1,1,1,$current_month,$current_day,$current_year));
    if ($dayname == "Sunday")
	{$dayname = "Domingo";}
    elseif ($dayname == "Monday")
	{$dayname = "Lunes";}
    elseif ($dayname == "Tuesday")
	{$dayname = "Martes";}
    elseif ($dayname == "Wednesday")
	{$dayname = "Miércoles";}
    elseif ($dayname == "Thursday")
	{$dayname = "Jueves";}
    elseif ($dayname == "Friday")
	{$dayname = "Viernes";}
    elseif ($dayname == "Saturday")
	{$dayname = "Sábado";}
    
    $sql_currentday = "$current_year-$current_month-$current_day";
    $eventQuery = "SELECT event1, event2, event3, event4, event5, event6, event7 FROM `reservas` WHERE eventdate = '$sql_currentday' and servicio = '$servicio'";
    $eventExec = mysqli_query($db_con, $eventQuery);
    while($row = mysqli_fetch_array($eventExec)) {
   if (mysqli_num_rows($eventExec) == 1) {
        // $this_days_title = stripslashes($row["title"]);
   $event_event1 = stripslashes($row["event1"]);
   $event_event2 = stripslashes($row["event2"]);
   $event_event3 = stripslashes($row["event3"]);
   $event_event4 = stripslashes($row["event4"]);
   $event_event5 = stripslashes($row["event5"]);
   $event_event6 = stripslashes($row["event6"]);
   $event_event7 = stripslashes($row["event7"]);
      }
    }
    
	echo '<p><span class="fa fa-calendar-o fa-fw"></span> '.$dayname.' - '.$current_day.'</p>';
	echo '<a href="//'.$config['dominio'].'/intranet/reservas/reservar/index.php?year='.$current_year.'&today='.$current_day.'&month='.$current_month.'&servicio='.$servicio.'">';

  //Nombre del día
 if (mysqli_num_rows($eventExec) == 1) 
 {
 	 if ($event_event1 !== "") { 
 	    echo "<p>1ª hora: $event_event1</p>";
 	}
 	 	 if ($event_event2 !== "") { 
 	    echo "<p>2ª hora: $event_event2</p>";
 	}
 	 	 if ($event_event3 !== "") { 
 	    echo "<p>3ª hora: $event_event3</p>";
 	}
 	 	 if ($event_event4 !== "") { 
 	    echo "<p>4ª hora: $event_event4</p>";
 	}
 	 	 if ($event_event5 !== "") { 
 	    echo "<p>5ª hora: $event_event5</p>";
 	}
 	 	 if ($event_event6 !== "") { 
 	    echo "<p>6ª hora: $event_event6</p>";
 	}
 	 	 if ($event_event7 !== "") { 
 	    echo "<p>7ª hora: $event_event7</p>";
 	}
 }

echo "</a></p>";

   //$this_days_title = "";
   $event_event1 = "";
   $event_event2 = "";
   $event_event3 = "";
   $event_event4 = "";
   $event_event5 = "";
   $event_event6 = "";
   $event_event7 = "";
}
echo '<br>';
echo '<a class="btn btn-primary btn-block" href="//'.$config['dominio'].'/intranet/reservas/reservar/index.php?servicio='.$servicio.'">Reservar...</a>';
echo '</div>';
echo '</div>';

}		
echo '</div>';
?>

</div>

<?php include("../pie.php");?>  

</body>
</html>
