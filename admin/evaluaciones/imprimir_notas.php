<?php
require('../../bootstrap.php');


if ((stristr($_SESSION['cargo'],'1') == false) && (stristr($_SESSION['cargo'],'2') == false)) {
	die ("<h1>FORBIDDEN</h1>");
}

if (isset($_POST['curso'])) $unidad = $_POST['curso'];
if (isset($_POST['evaluacion'])) $evaluacion = $_POST['evaluacion'];

if ($_SERVER['SERVER_NAME'] == 'iesantoniomachado.es') {
	$evaluaciones = array(
		'IN1' => 'Intermedia 1 (Febrero)',
		'IN2' => 'Intermedia 2 (Mayo)'
	);
}
else {
	$evaluaciones = array(
		'1EV' => '1ª Evaluación',
		'2EV' => '2ª Evaluación',
		'3EV' => '3ª Evaluación',
		'Ord' => 'Ordinaria',
		'FFP' => 'Final FP',
		'Ext' => 'Extraordinaria',
		'FE1' => 'Final Excepcional 1ª Convocatoria',
		'5CV' => '5º Convocatoria Extraordinaria de Evaluación',
		'OT1' => 'Obtención título ESO (Primer año)',
		'FE2' => 'Final Excepcional 2ª Convocatoria',
		'OT2' => 'Obtención título ESO (Segundo año)',
		'EP1' => 'Evaluación de pendientes 1ª Convovatoria',
		'EVI' => 'Evaluación inicial',
		'EP2' => 'Evaluación de pendientes 2ª Convovatoria',
	);
}

if (!$unidad) {
	die ("<h1>FORBIDDEN</h1>");
}


require("../../pdf/fpdf.php");

// Variables globales para el encabezado y pie de pagina
$GLOBALS['CENTRO_NOMBRE'] = $config['centro_denominacion'];
$GLOBALS['CENTRO_DIRECCION'] = $config['centro_direccion'];
$GLOBALS['CENTRO_CODPOSTAL'] = $config['centro_codpostal'];
$GLOBALS['CENTRO_LOCALIDAD'] = $config['centro_localidad'];
$GLOBALS['CENTRO_TELEFONO'] = $config['centro_telefono'];
$GLOBALS['CENTRO_FAX'] = $config['centro_fax'];
$GLOBALS['CENTRO_CORREO'] = $config['centro_email'];
$GLOBALS['CURSO_ACTUAL'] = $config['curso_actual'];
$GLOBALS['CENTRO_PROVINCIA'] = $config['centro_provincia'];

# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
	function Header() {
		$this->SetTextColor(0, 122, 61);
		$this->Image( '../../img/encabezado.jpg',25,14,53,'','jpg');
		$this->SetFont('ErasDemiBT','B',10);
		$this->SetY(15);
		$this->Cell(75);
		$this->Cell(80,5,'CONSEJERÍA DE EDUCACIÓN, CULTURA Y DEPORTE',0,1);
		$this->SetFont('ErasMDBT','I',10);
		$this->Cell(75);
		$this->Cell(80,5,$GLOBALS['CENTRO_NOMBRE'],0,1);
		$this->SetTextColor(255, 255, 255);
	}
	function Footer() {
		$this->SetTextColor(0, 122, 61);
		$this->Image( '../../img/pie.jpg', 0, 245, 25, '', 'jpg' );
		$this->SetY(275);
		$this->SetFont('ErasMDBT','',8);
		$this->Cell(75);
		$this->Cell(80,4,$GLOBALS['CENTRO_DIRECCION'].'. '.$GLOBALS['CENTRO_CODPOSTAL'].', '.$GLOBALS['CENTRO_LOCALIDAD'].' ('.$GLOBALS['CENTRO_PROVINCIA'] .')',0,1);
		$this->Cell(75);
		$this->Cell(80,4,'Telf: '.$GLOBALS['CENTRO_TELEFONO'].'   Fax: '.$GLOBALS['CENTRO_FAX'],0,1);
		$this->Cell(75);
		$this->Cell(80,4,'Correo-e: '.$GLOBALS['CENTRO_CORREO'],0,1);
		$this->SetTextColor(255, 255, 255);
	}
}


# creamos el nuevo objeto partiendo de la clase ampliada
$MiPDF = new GranPDF ( 'P', 'mm', 'A4' );

$MiPDF->AddFont('NewsGotT','','NewsGotT.php');
$MiPDF->AddFont('NewsGotT','B','NewsGotTb.php');
$MiPDF->AddFont('ErasDemiBT','','ErasDemiBT.php');
$MiPDF->AddFont('ErasDemiBT','B','ErasDemiBT.php');
$MiPDF->AddFont('ErasMDBT','','ErasMDBT.php');
$MiPDF->AddFont('ErasMDBT','I','ErasMDBT.php');

$MiPDF->SetMargins(25, 20, 20);

$titulo = "Boletín de calificaciones";


$result = mysqli_query($db_con, "SELECT * FROM alma WHERE unidad='$unidad' AND (combasi NOT LIKE '%25204%' AND combasi NOT LIKE '%25226%' AND combasi NOT LIKE '%31307%')");
if (!mysqli_num_rows($result)) {
$div = substr($unidad, 0, -1);
$result = mysqli_query($db_con, "SELECT * FROM alma WHERE unidad='".$div."' AND (combasi like '%25204%' or combasi LIKE '%25226%' or combasi LIKE '%31307%')");
}

$i = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	
	// VARIABLES
	$alumno = $row['APELLIDOS'].', '.$row['NOMBRE'];
	$numexp = $row['NUMEROEXPEDIENTE'];
	$curso  = $row['CURSO'];
	
	$padre = $row['NOMBRETUTOR'].' '.$row['PRIMERAPELLIDOTUTOR'].' '.$row['SEGUNDOAPELLIDOTUTOR'];
	$direccion = $row['DOMICILIO'];
	$codpostal = $row['CODPOSTAL'];
	$localidad = $row['LOCALIDAD'];
	$provincia = $row['PROVINCIARESIDENCIA'];
	
	// Consultamos el tutor del grupo
	$result1 = mysqli_query($db_con, "SELECT TUTOR FROM FTUTORES WHERE unidad='$unidad' OR unidad='$div'");
	$tutor = mysqli_fetch_array($result1);
	mysqli_free_result($result1);
	
	
	// CREAMOS UNA NUEVA PAGINA
	$MiPDF->Addpage();
	
	// INFORMACION DE LA CARTA
	$MiPDF->SetY(35);
	$MiPDF->SetFont('NewsGotT', 'BU', 10);
	$MiPDF->Multicell(0, 5, mb_strtoupper($titulo, 'iso-8859-1'), 0, 'C', 0 );
	$MiPDF->Ln(10);
	
	$MiPDF->SetFont ( 'NewsGotT', 'B', 10 );
	$MiPDF->Cell(25, 5, 'Alumno/a:', 0, 0, 'R', 0 );
	$MiPDF->SetFont ( 'NewsGotT', '', 10 );
	$MiPDF->Cell(50, 5, $alumno, 0, 0, 'L', 0 );
	$MiPDF->Cell(75, 5, $padre, 0, 1, 'L', 0 );
	$MiPDF->SetFont ( 'NewsGotT', 'B', 10 );
	$MiPDF->Cell(25, 5, 'Número exp.:', 0, 0, 'R', 0 );
	$MiPDF->SetFont ( 'NewsGotT', '', 10 );
	$MiPDF->Cell(50, 5, $numexp, 0, 0, 'L', 0 );
	$MiPDF->Cell(75, 5, $direccion, 0, 1, 'L', 0 );
	$MiPDF->SetFont ( 'NewsGotT', 'B', 10 );
	$MiPDF->Cell(25, 5, 'Curso:', 0, 0, 'R', 0 );
	$MiPDF->SetFont ( 'NewsGotT', '', 10 );
	$MiPDF->Cell(50, 5, (strlen($curso) > 31) ? substr($curso, 0 ,31).'...' : $curso, 0, 0, 'L', 0 );
	$MiPDF->Cell(0, 5, $localidad.' - '.$codpostal.' '.mb_strtoupper($provincia, 'iso-8859-1'), 0, 1, 'L', 0 );
	$MiPDF->SetFont ( 'NewsGotT', 'B', 10 );
	$MiPDF->Cell(25, 5, 'Unidad:', 0, 0, 'R', 0 );
	$MiPDF->SetFont ( 'NewsGotT', '', 10 );
	if (isset($div)) {
		$MiPDF->Cell(50, 5, $unidad.' (Diversificación)', 0, 1, 'L', 0 );
	}
	else {
		$MiPDF->Cell(50, 5, $unidad, 0, 1, 'L', 0 );
	}
	$MiPDF->SetFont ( 'NewsGotT', 'B', 10 );
	$MiPDF->Cell(25, 5, 'Convocatoria:', 0, 0, 'R', 0 );
	$MiPDF->SetFont ( 'NewsGotT', '', 10 );
	$MiPDF->Cell(75, 5, $evaluacion.' ('.$evaluaciones[$evaluacion].')', 0, 1, 'L', 0 );
	$MiPDF->SetFont ( 'NewsGotT', 'B', 10 );
	$MiPDF->Cell(25, 5, 'Año académico:', 0, 0, 'R', 0 );
	$MiPDF->SetFont ( 'NewsGotT', '', 10 );
	$MiPDF->Cell(50, 5, $GLOBALS['CURSO_ACTUAL'], 0, 1, 'L', 0 );
	$MiPDF->Ln(10);
	
	// CUERPO DE LA CARTA
	$MiPDF->SetFont('NewsGotT', 'B', 10);
	$MiPDF->Multicell(0, 5, mb_strtoupper('E V A L U A C I Ó N', 'iso-8859-1'), 0, 'C', 0 );
	$MiPDF->Ln(5);
	
	$MiPDF->SetFillColor(239,240,239);
	$MiPDF->Cell(75, 5, 'M A T E R I A S', 1, 0, 'C', 1 );
	$MiPDF->Cell(15, 5, $evaluacion, 1, 1, 'C', 1 );
	
	$MiPDF->SetFont('NewsGotT', '', 10);
	
	// OBTENEMOS LAS ASIGNATURAS
	$result_asig = mysqli_query($db_con, "SELECT DISTINCT a_asig, asig, c_asig FROM horw WHERE a_grupo='$unidad' AND a_asig NOT LIKE '%TUT%' AND a_asig <> 'PT' ORDER BY asig ASC");
	
	while ($row_asig = mysqli_fetch_array($result_asig)) {
		
		$MiPDF->Cell(75, 5, $row_asig['asig'], 1, 0, 'L', 0 );
		
		// OBTENEMOS LAS CALIFICACIONES
		$result_calif = mysqli_query($db_con, "SELECT calificaciones FROM evaluaciones WHERE unidad='$unidad' AND evaluacion='$evaluacion' AND asignatura='".$row_asig['c_asig']."'");
		
		if (mysqli_num_rows($result_calif)) {
			$row_calif = mysqli_fetch_array($result_calif);
			$calificaciones = unserialize($row_calif['calificaciones']);
			
			$MiPDF->Cell(15, 5, $calificaciones[$i]['nota'], 1, 1, 'C', 0);
		}
		else {
			$MiPDF->Cell(15, 5, '', 1, 1, 'C', 0);
		}
	}
	
	$MiPDF->Ln(5);
	$MiPDF->SetFont('NewsGotT', 'B', 10);
	$MiPDF->Cell(90, 5, 'Observaciones:', 0, 1, 'L', 0 );
	
	$MiPDF->SetFont('NewsGotT', '', 10);
	$MiPDF->Multicell( 0, 5, '' , 0, 'L', 0 );
	$MiPDF->Ln(10);
	

	//FIRMAS
	$MiPDF->Cell(90, 5, 'Sello del Centro', 0, 0, 'L', 0 );
	$MiPDF->Cell(55, 5, 'Les saludo cordialmente,', 0, 1, 'L', 0 );
	$MiPDF->Cell(55, 20, '', 0, 0, 'L', 0 );
	$MiPDF->Cell(55, 20, '', 0, 1, 'L', 0 );
	$MiPDF->SetFont('NewsGotT', '', 10);
	$MiPDF->Cell(90, 5, 'Firma del Padre, Madre, o Tutor/a', 0, 0, 'L', 0 );
	$MiPDF->Cell(55, 5, 'Tutor/a: '.mb_convert_case($tutor['TUTOR'], MB_CASE_TITLE, "iso-8859-1"), 0, 1, 'L', 0 );
	
	$i++;
}

$MiPDF->Output();
?>