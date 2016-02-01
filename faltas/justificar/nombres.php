<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

//$alldays=array("L","M","X","J","V");
// Variables para profes.php y cal.php
// Variables para profes.php y cal.php
if (isset($dia)) {
if ($dia == "D")
	{$dia = "Domingo";}
    elseif ($dia == "L")
	{$dia = "Lunes";}
    elseif ($dia == "M")
	{$dia = "Martes";}
    elseif ($dia == "X")
	{$dia = "Miércoles";}
    elseif ($dia == "J")
	{$dia = "Jueves";}
    elseif ($dia == "V")
	{$dia = "Viernes";}
    elseif ($dia == "S")
	{$dia = "Sábado";}
}

if (isset($daylong)) {
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
}

if (isset($monthlong)) {
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
}
// Que dia de la semana tenemos, buscando primero el lunes de cada semana. 

$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$nombredia = $hoy[wday];	
	if ($nombredia == "0")
	{	$lunes = date( mktime(0, 0, 0, $month, $today + 1, $year));
		$hoylunes = getdate($lunes);
		$d = $hoylunes[mday];
		$m = $hoylunes[mon];
		$y = $hoylunes[year];		
		$lunes2  = mktime(0, 0, 0, date("$m")  , date("$d"), date("$y"));
		$diasiguiente =getdate($lunes2);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$lunes1 = $d1 . "-" .$m1 . "-" . $y1;
		
		$martes1  = mktime(0, 0, 0, date("$m")  , date("$d")+1, date("$y"));
		$diasiguiente =getdate($martes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$martes = $d1 . "-" .$m1 . "-" . $y1;
		
		$miercoles1  = mktime(0, 0, 0, date("$m")  , date("$d")+2, date("$y"));
		$diasiguiente =getdate($miercoles1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$miercoles = $d1 . "-" .$m1 . "-" . $y1;
		
		$jueves1  = mktime(0, 0, 0, date("$m")  , date("$d")+3, date("$y"));
		$diasiguiente =getdate($jueves1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$jueves = $d1 . "-" .$m1 . "-" . $y1;
		
		$viernes1  = mktime(0, 0, 0, date("$m")  , date("$d")+4, date("$y"));
		$diasiguiente =getdate($viernes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$viernes = $d1 . "-" .$m1 . "-" . $y1;}
	elseif ($nombredia == "1")
	{		$lunes = date( mktime(0, 0, 0, $month, $today, $year));
		$hoylunes = getdate($lunes);
		$d = $hoylunes[mday];
		$m = $hoylunes[mon];
		$y = $hoylunes[year];
		$lunes2  = mktime(0, 0, 0, date("$m")  , date("$d"), date("$y"));
		$diasiguiente =getdate($lunes2);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$lunes1 = $d1 . "-" .$m1 . "-" . $y1;
		
		$martes1  = mktime(0, 0, 0, date("$m")  , date("$d")+1, date("$y"));
		$diasiguiente =getdate($martes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$martes = $d1 . "-" .$m1 . "-" . $y1;
		
		$miercoles1  = mktime(0, 0, 0, date("$m")  , date("$d")+2, date("$y"));
		$diasiguiente =getdate($miercoles1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$miercoles = $d1 . "-" .$m1 . "-" . $y1;
		
		$jueves1  = mktime(0, 0, 0, date("$m")  , date("$d")+3, date("$y"));
		$diasiguiente =getdate($jueves1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$jueves = $d1 . "-" .$m1 . "-" . $y1;
		
		$viernes1  = mktime(0, 0, 0, date("$m")  , date("$d")+4, date("$y"));
		$diasiguiente =getdate($viernes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$viernes = $d1 . "-" .$m1 . "-" . $y1;}
    elseif ($nombredia == "2")
	{		$lunes = date( mktime(0, 0, 0, $month, $today - 1, $year));
		$hoylunes = getdate($lunes);
		$d = $hoylunes[mday];
		$m = $hoylunes[mon];
		$y = $hoylunes[year];
		$lunes2  = mktime(0, 0, 0, date("$m")  , date("$d"), date("$y"));
		$diasiguiente =getdate($lunes2);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$lunes1 = $d1 . "-" .$m1 . "-" . $y1;
		
		$martes1  = mktime(0, 0, 0, date("$m")  , date("$d")+1, date("$y"));
		$diasiguiente =getdate($martes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$martes = $d1 . "-" .$m1 . "-" . $y1;
		
		$miercoles1  = mktime(0, 0, 0, date("$m")  , date("$d")+2, date("$y"));
		$diasiguiente =getdate($miercoles1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$miercoles = $d1 . "-" .$m1 . "-" . $y1;
		
		$jueves1  = mktime(0, 0, 0, date("$m")  , date("$d")+3, date("$y"));
		$diasiguiente =getdate($jueves1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$jueves = $d1 . "-" .$m1 . "-" . $y1;
		
		$viernes1  = mktime(0, 0, 0, date("$m")  , date("$d")+4, date("$y"));
		$diasiguiente =getdate($viernes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$viernes = $d1 . "-" .$m1 . "-" . $y1;}
    elseif ($nombredia == "3")
	{		$lunes = date( mktime(0, 0, 0, $month, $today - 2, $year));
		$hoylunes = getdate($lunes);
		$d = $hoylunes[mday];
		$m = $hoylunes[mon];
		$y = $hoylunes[year];
		$lunes2  = mktime(0, 0, 0, date("$m")  , date("$d"), date("$y"));
		$diasiguiente =getdate($lunes2);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$lunes1 = $d1 . "-" .$m1 . "-" . $y1;
		
		$martes1  = mktime(0, 0, 0, date("$m")  , date("$d")+1, date("$y"));
		$diasiguiente =getdate($martes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$martes = $d1 . "-" .$m1 . "-" . $y1;
		
		$miercoles1  = mktime(0, 0, 0, date("$m")  , date("$d")+2, date("$y"));
		$diasiguiente =getdate($miercoles1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$miercoles = $d1 . "-" .$m1 . "-" . $y1;
		
		$jueves1  = mktime(0, 0, 0, date("$m")  , date("$d")+3, date("$y"));
		$diasiguiente =getdate($jueves1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$jueves = $d1 . "-" .$m1 . "-" . $y1;
		
		$viernes1  = mktime(0, 0, 0, date("$m")  , date("$d")+4, date("$y"));
		$diasiguiente =getdate($viernes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$viernes = $d1 . "-" .$m1 . "-" . $y1;}
    elseif ($nombredia == "4")
	{		
		$lunes = date( mktime(0, 0, 0, $month, $today - 3, $year));
		$hoylunes = getdate($lunes);
		$d = $hoylunes[mday];
		$m = $hoylunes[mon];
		$y = $hoylunes[year];
		$lunes2  = mktime(0, 0, 0, date("$m")  , date("$d"), date("$y"));
		$diasiguiente =getdate($lunes2);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$lunes1 = $d1 . "-" .$m1 . "-" . $y1;
		
		$martes1  = mktime(0, 0, 0, date("$m")  , date("$d")+1, date("$y"));
		$diasiguiente =getdate($martes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$martes = $d1 . "-" .$m1 . "-" . $y1;
		
		$miercoles1  = mktime(0, 0, 0, date("$m")  , date("$d")+2, date("$y"));
		$diasiguiente =getdate($miercoles1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$miercoles = $d1 . "-" .$m1 . "-" . $y1;
		
		$jueves1  = mktime(0, 0, 0, date("$m")  , date("$d")+3, date("$y"));
		$diasiguiente =getdate($jueves1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$jueves = $d1 . "-" .$m1 . "-" . $y1;
		
		$viernes1  = mktime(0, 0, 0, date("$m")  , date("$d")+4, date("$y"));
		$diasiguiente =getdate($viernes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$viernes = $d1 . "-" .$m1 . "-" . $y1;
	}
    elseif ($nombredia == "5")
	{		$lunes = date( mktime(0, 0, 0, $month, $today - 4, $year));
		$hoylunes = getdate($lunes);
		$d = $hoylunes[mday];
		$m = $hoylunes[mon];
		$y = $hoylunes[year];
		$lunes2  = mktime(0, 0, 0, date("$m")  , date("$d"), date("$y"));
		$diasiguiente =getdate($lunes2);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$lunes1 = $d1 . "-" .$m1 . "-" . $y1;
		
		$martes1  = mktime(0, 0, 0, date("$m")  , date("$d")+1, date("$y"));
		$diasiguiente =getdate($martes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$martes = $d1 . "-" .$m1 . "-" . $y1;
		
		$miercoles1  = mktime(0, 0, 0, date("$m")  , date("$d")+2, date("$y"));
		$diasiguiente =getdate($miercoles1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$miercoles = $d1 . "-" .$m1 . "-" . $y1;
		
		$jueves1  = mktime(0, 0, 0, date("$m")  , date("$d")+3, date("$y"));
		$diasiguiente =getdate($jueves1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$jueves = $d1 . "-" .$m1 . "-" . $y1;
		
		$viernes1  = mktime(0, 0, 0, date("$m")  , date("$d")+4, date("$y"));
		$diasiguiente =getdate($viernes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$viernes = $d1 . "-" .$m1 . "-" . $y1;}
    elseif ($nombredia == "6")
	{		$lunes = date( mktime(0, 0, 0, $month, $today - 5, $year));
		$hoylunes = getdate($lunes);
		$d = $hoylunes[mday];
		$m = $hoylunes[mon];
		$y = $hoylunes[year];
		$lunes2  = mktime(0, 0, 0, date("$m")  , date("$d"), date("$y"));
		$diasiguiente =getdate($lunes2);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$lunes1 = $d1 . "-" .$m1 . "-" . $y1;
		
		$martes1  = mktime(0, 0, 0, date("$m")  , date("$d")+1, date("$y"));
		$diasiguiente =getdate($martes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$martes = $d1 . "-" .$m1 . "-" . $y1;
		
		$miercoles1  = mktime(0, 0, 0, date("$m")  , date("$d")+2, date("$y"));
		$diasiguiente =getdate($miercoles1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$miercoles = $d1 . "-" .$m1 . "-" . $y1;
		
		$jueves1  = mktime(0, 0, 0, date("$m")  , date("$d")+3, date("$y"));
		$diasiguiente =getdate($jueves1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$jueves = $d1 . "-" .$m1 . "-" . $y1;
		
		$viernes1  = mktime(0, 0, 0, date("$m")  , date("$d")+4, date("$y"));
		$diasiguiente =getdate($viernes1);
		$d1 = $diasiguiente[mday];
		$m1 = $diasiguiente[mon];
		$y1 = $diasiguiente[year];		
		$viernes = $d1 . "-" .$m1 . "-" . $y1;}
?>

	
	