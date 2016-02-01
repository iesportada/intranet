<?php
require('../../bootstrap.php');


// VARIABLES DEL FORMULARIO
$unidad = $_POST['unidad'];


require('../../pdf/mc_table.php');

$pdf = new PDF_MC_Table();
$pdf->Open();
$pdf->SetMargins(11,10,11);
$pdf->SetDisplayMode('fullpage');

// Cargamos las fuentes corporativas
$pdf->AddFont('NewsGotT','','NewsGotT.php');
$pdf->AddFont('NewsGotT','B','NewsGotTb.php');

// En el caso de haber seleccionado una unidad, se muestra el listado de alumnos de dicha unidad,
// en otro caso mostramos el listado de faltas de todas las unidades.
$query = "SELECT DISTINCT unidad FROM FALUMNOS where unidad not like '' ";
if ($unidad) $query .= " and unidad='$unidad'";
$query .= " order by unidad";
// echo $query;
$unidades = mysqli_query($db_con, $query);

while ($unidad = mysqli_fetch_array($unidades)) {
	
	$unidad = $unidad[0];

	$pdf->AddPage('L','A4');
	
	// CABECERA DEL DOCUMENTO
	
	// Obtenemos la fecha inicial y final de la semana en curso
	list($anio, $mes, $dia, $semana, $sdia) = explode(':', date('Y:m:d:W:w'));
	$inicio = strtotime("$anio-$mes-$dia 12:00am");
	$inicio += (1 - $sdia) * 86400;
	$fin = $inicio + (6 * 86400);
	$inicio = date('d-m-Y', $inicio);
	$fin = date('d-m-Y', $fin);
	
	// Consultamos el tutor del grupo
	$result = mysqli_query($db_con, "SELECT TUTOR FROM FTUTORES WHERE unidad='$unidad'");
	$tutor = mysqli_fetch_array($result);
	mysqli_free_result($result);
	
	// Impresiï¿½n de la cabecera
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->Cell(96,5,"PARTE DE FALTAS DEL GRUPO $unidad",0,0,'L');
	$pdf->Cell(81,5,"SEMANA: _______________________",0,0,'C');
	$pdf->Cell(96,5,"TUTOR/A: $tutor[0]",0,1,'R');
	$pdf->Ln(1);
	
	$pdf->SetLineWidth(0.6); // Grosor de linea
	for ($i=0; $i<6; $i++) {
		$pdf->Line(74+42*$i, 16.2, 74+42*$i, 16+10);
	}
	$pdf->SetLineWidth(0.2); // Grosor por defecto
	
	// PRIMERA FILA
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->SetWidths(array(63,42,42,42,42,42));
	$pdf->SetAligns(array('L','C','C','C','C','C'));
	$pdf->Row(array('','LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES'));
	
	// SEGUNDA FILA
	$pdf->SetWidths(array(8,55,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7));
	$pdf->SetAligns(array('C','L','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C'));
	$pdf->Row(array('#','Alumno/a','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6'));
	
	// RESTO DE LA TABLA
	$pdf->SetFont('NewsGotT','',10);
	$pdf->SetFillColor(239,240,239);	// Color de sombreado
	
	// Consultamos los alumnos del grupo seleccionado
	$result = mysqli_query($db_con, "SELECT nc, CONCAT(apellidos,', ',nombre) AS alumno FROM FALUMNOS WHERE unidad='$unidad' ORDER BY nc ASC");
	
	$i=0;
	while ($alumno = mysqli_fetch_array($result)) {
		if ($i%2==0) $somb='DF'; else $somb='';
		$pdf->Row(array($alumno['nc'],substr($alumno['alumno'],0,40),'','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),$somb);
		
		$pdf->SetLineWidth(0.6); // Grosor de linea
		for ($j=0; $j<6; $j++) {
			if ($i<34) { $inicio=26; $f=$i; } else { $inicio=5.1; $f=mysqli_num_rows($result)-$i; }
			$pdf->Line(74+42*$j, $inicio+5*$f, 74+42*$j, $inicio+5+5*$f+0.1*$f);
		}
		$pdf->SetLineWidth(0.2); // Grosor por defecto
		
		$i++;
	}

	// En una hoja caben 34 filas, si es menor aï¿½adimos el cuadrante de faltas en otra hoja;
	// en otro caso, la tabla aparecerï¿½ a continuaciï¿½n del listado de alumnos.
	if ($i<34) $pdf->AddPage('L','A4');
	else $pdf->Ln(5);
	
	$pdf->SetLineWidth(0.2);
	
	// CUADRANTE DE FIRMAS
	// Primera fila
	$pdf->SetFillColor(61,61,61);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->SetWidths(array(273));
	$pdf->SetAligns(array('C'));
	$pdf->SetTextColor(255,255,255);
	$pdf->Row(array("CUADRANTE DE FIRMAS DEL PROFESORADO"),'DF');
	
	// Segunda fila
	$pdf->SetWidths(array(54.6,54.6,54.6,54.6,54.6));
	$pdf->SetAligns(array('C','C','C','C','C'));
	$pdf->SetTextColor(0,0,0);
	$pdf->Row(array('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES'));
	
	// Resto de la tabla
	$pdf->SetFont('NewsGotT','',10);
	$pdf->SetTextColor(102,102,102);
	$pdf->SetAligns(array('L','L','L','L','L'));
	
	$horas = array(1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6" );
	
	foreach($horas as $hora => $nombre) {

		for($i=1;$i<6;$i++) {
			$result = mysqli_query($db_con, "SELECT DISTINCT a_asig, asig FROM horw WHERE a_grupo='$unidad' AND dia='$i' AND hora='$hora'");
			
			unset($asignaturas);
			while ($asignatura = mysqli_fetch_array($result)) {
				$asignaturas .= $asignatura[0]." | ";
			}
			$asignaturas = trim($asignaturas," | ");
			$row[$i] = $asignaturas."\n\n\n";
		}
		
		$pdf->Row(array($row[1],$row[2],$row[3],$row[4],$row[5]));
	}
	
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Ln(5);
	
	$pdf->SetFillColor(61,61,61);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->SetWidths(array(273));
	$pdf->SetAligns(array('C'));
	$pdf->Row(array('OBSERVACIONES'),'DF');
	$pdf->SetWidths(array(54.6,54.6,54.6,54.6,54.6));
	$pdf->SetAligns(array('C','C','C','C','C'));
	$pdf->SetTextColor(0,0,0);
	$pdf->Row(array("LUNES",'MARTES','MIÉRCOLES','JUEVES','VIERNES'));
	$pdf->Row(array("\n\n\n\n\n\n",'','','','','',''));
	
	
	$pdf->Ln(5);
	$pdf->SetFont('NewsGotT','B',9);
	$pdf->Cell(273,5,"A - Ir al Aseo. B - Ir a beber agua. F - Falta de Asistencia. R - Retraso injustificado. J - Viene de Jefatura.",0,0,'C');
	
	mysqli_free_result($result);
		
}

$pdf->Output('Parte de faltas semanal '.$inicio.'.pdf','I');
?>
