<?php
require('../../../bootstrap.php');
require('../../../pdf/fpdf.php');

$tutor = $_SESSION ['profi'];
// Consulta  en curso.

if(!($_POST['id'])){$id = $_GET['id'];}else{$id = $_POST['id'];}
if(!($_POST['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}

$numTotal = $_POST['numTotal'];
$numGraves = $_POST['numGraves'];
$numMuyGraves = $_POST['numMuyGraves'];
$numExpulsiones = $_POST['numExpulsiones'];

$result = mysqli_query($db_con, "select FA.apellidos, FA.nombre, FA.unidad, FA.nc, Fe.fecha, Fe.notas, Fe.asunto, Fe.informa, Fe.grave, Fe.medida, listafechorias.medidas2, Fe.expulsion, Fe.tutoria, Fe.inicio, Fe.fin, aula_conv, inicio_aula, fin_aula, Fe.horas, Fe.atiende, Fe.horaEnvia, Fe.horaAtiende, efectos.comentario from Fechoria as Fe, FALUMNOS as FA, listafechorias, efectos where Fe.claveal = FA.claveal and listafechorias.fechoria = Fe.asunto  and Fe.id = '$id' and Fe.medidaJefatura = efectos.id");

if ($row = mysqli_fetch_array($result))
{
		$apellidos = $row[0];
		$nombre = $row[1];
		$unidad = $row[2];
		$fecha = $row[4];
		$notas = $row[5];
		$asunto = $row[6];
		$informa = $row[7];
		$grave = $row[8];
		$medida = $row[9];
		$medidas2 = $row[10];
		$expulsion = $row[11];
		$tutoria = $row[12];
		$inicio = $row[13];
		$fin = $row[14];
		$convivencia = $row[15];
		$inicio_aula = $row[16];
		$fin_aula = $row[17];
		$horas = $row[18];
		$atiende = $row[19];
		$horaEnvia = $row[20];
		$horaAtiende = $row[21];
		$medidaJefatura = $row[22];
}

$hoy = strftime("%d.%m.%Y", strtotime($fecha));

// Variables globales para el encabezado y pie de pagina
$GLOBALS['CENTRO_NOMBRE'] = $config['centro_denominacion'];
$GLOBALS['CENTRO_DIRECCION'] = $config['centro_direccion'];
$GLOBALS['CENTRO_CODPOSTAL'] = $config['centro_codpostal'];
$GLOBALS['CENTRO_LOCALIDAD'] = $config['centro_localidad'];
$GLOBALS['CENTRO_TELEFONO'] = $config['centro_telefono'];
$GLOBALS['CENTRO_FAX'] = $config['centro_fax'];
$GLOBALS['CENTRO_CORREO'] = $config['centro_email'];
$GLOBALS['CENTRO_PROVINCIA'] = $config['centro_provincia'];

# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
	function Header() {
		$this->SetTextColor(0, 122, 61);
		$this->Image( '../../../img/encabezado.jpg',25,14,53,'','jpg');
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
		$this->Image( '../../../img/pie.jpg', 0, 245, 25, '', 'jpg' );
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
$A4="A4";
$MiPDF = new GranPDF ( 'P', 'mm', $A4 );
$MiPDF->AddFont('NewsGotT','','NewsGotT.php');
$MiPDF->AddFont('NewsGotT','B','NewsGotTb.php');
$MiPDF->AddFont('ErasDemiBT','','ErasDemiBT.php');
$MiPDF->AddFont('ErasDemiBT','B','ErasDemiBT.php');
$MiPDF->AddFont('ErasMDBT','','ErasMDBT.php');
$MiPDF->AddFont('ErasMDBT','I','ErasMDBT.php');

$MiPDF->SetMargins (25, 20, 20);
$MiPDF->SetDisplayMode ( 'fullpage' );

$titulo = "Ficha del información del Aula de Convivencia";

# insertamos la primera pagina del documento
$MiPDF->Addpage ();
	
$MiPDF->Ln(8);
$MiPDF->SetFont('NewsGotT', 'B', 16);
$MiPDF->Multicell(0, 5, mb_strtoupper($titulo, 'iso-8859-1'), 0, 'L', 0 );
$MiPDF->Ln(8);

// INFORMACION DE LA CARTA
//$MiPDF->SetY(35);

$imagenurl = "../../../xml/fotos/".$claveal.".jpg";
if(!file_exists($imagenurl))
	$imagenurl = "../../../xml/fotos/blank.jpg";
	
$MiPDF->Image($imagenurl,165,40,25,30,'JPG');
$MiPDF->Ln(25);
$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
$MiPDF->Cell(15, 10, 'FECHA: ', 0, 0, 'L', 0 );
$MiPDF->SetFont ( 'NewsGotT', '', 12 );
$MiPDF->Cell(22, 10, $hoy, 0, 0, 'L', 0 );
$MiPDF->Ln(10);
$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
$MiPDF->Cell(25, 10, 'ALUMNO/A:  ', 1, 0, 'C', 0 );
$MiPDF->SetFont ( 'NewsGotT', '', 12 );
$MiPDF->Cell(95, 10, $apellidos.', '.$nombre, 1, 0, 'L', 0 );
$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
$MiPDF->Cell(20, 10, 'GRUPO: ', 1, 0, 'C', 0 );
$MiPDF->SetFont ( 'NewsGotT', '', 12 );
$MiPDF->Cell(25, 10, $unidad, 1, 1, 'C', 0 );

//$MiPDF->Cell(0, 0, $miPDF->Image($imagenurl, $miPDF->GetX()-20+1,$miPDF->GetY()-10+1,20,10), 0, 0, 'C', false,'');

$MiPDF->Ln(8);
$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
$MiPDF->Cell(65, 8, 'PROFESOR QUE ENVÍA AL A.C.: ', 0, 0, 'L', 0 );
$MiPDF->SetFont ( 'NewsGotT', '', 12 );
$MiPDF->Cell(80, 8, $informa, 0, 0, 'L', 0 );
$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
$MiPDF->Cell(75, 8, 'HORA: '.$horaEnvia.'ª', 0, 1, 'L', 0 );

$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
$MiPDF->Cell(65, 8, 'PROFESOR QUE ATIENDE EN EL A.C.: ', 0, 0, 'L', 0 );
$MiPDF->SetFont ( 'NewsGotT', '', 12 );
$MiPDF->Cell(80, 8, $atiende, 0, 0, 'L', 0 );
$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
$MiPDF->Cell(75, 8, 'HORA: '.$horaAtiende.'ª', 0, 1, 'L', 0 );
$MiPDF->Ln(5);
	
// CUERPO DEL INFORME
$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(140, 5, 'MOTIVO DE LA EXPULSIÓN: ('.$grave.')', 0, 0, 'L', 0 );
$MiPDF->Ln(8);
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Cell(140, 5, '"'.$asunto.'"', 0, 0, 'L', 0 );
	
$MiPDF->Ln(8);
$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(140, 12, 'DESARROLLO DE LA ENTREVISTA:', 0, 0, 'L', 0 );
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Ln(12);
$MiPDF->Multicell(0, 5, $notas, 1, 'L', 0 );

$MiPDF->Ln(8);
$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(140, 6, 'ACTUACIÓN DE JEFATURA DE ESTUDIOS:', 0, 0, 'L', 0 );
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Ln(12);

if ($expulsion <> '0') {
	$desde = strftime("%d.%m.%Y", strtotime($inicio));
	$hasta = strftime("%d.%m.%Y", strtotime($fin));
	$MiPDF->Multicell(0, 10, 'Expulsión del Centro desde '.$desde.' al '.$hasta, 1, 'L', 0);
} elseif ($convivencia <> '0') {
		$desde = strftime("%d.%m.%Y", strtotime($inicio_aula));
		$hasta = strftime("%d.%m.%Y", strtotime($fin_aula));
		$MiPDF->Multicell(0, 10, 'Expulsión al A.T.I desde '.$desde.' al '.$hasta, 1, 'L', 0);		
} elseif ($medidaJefatura == 'SIN APLICAR')
			$MiPDF->Multicell(0, 10, '', 1, 'L', 0);
else {
	$MiPDF->Multicell(0, 15, $medidaJefatura, 1, 'L', 0);
}
$MiPDF->Ln(8);
$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(140, 5, 'ANTECEDENTES DURANTE EL CURSO ACTUAL:', 0, 0, 'L', 0 );
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Ln(10);
$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(26, 5, 'TOTALES: ', 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Cell(10, 5, $numTotal, 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', 'B', 12);

$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(25, 5, 'GRAVES: ', 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Cell(10, 5, $numGraves, 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', 'B', 12);

$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(37, 5, 'MUY GRAVES: ', 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Cell(10, 5, $numMuyGraves, 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', 'B', 12);

$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->Cell(37, 5, 'EXPULSIONES: ', 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', '', 12);
$MiPDF->Cell(10, 5, $numExpulsiones, 1, 0, 'C', 0 );
$MiPDF->SetFont('NewsGotT', 'B', 12);
$MiPDF->SetFont('NewsGotT', '', 12);
	
// Consulta del historial delictivo del alumno.
$consulta = "select fecha, grave, asunto from Fechoria where claveal = '".$claveal."' and fecha >= '".$config['curso_inicio']."' order by fecha DESC limit 50";
$result = mysqli_query($db_con, $consulta);

$MiPDF->Ln(8);
$MiPDF->SetFont('NewsGotT', '', 10);

$MiPDF->AddPage();
$contador = 0;
while ( $fila = mysqli_fetch_array ( $result ) ) {
	if ($fila[1] == 'leve')
		$gravedad = '[L]';
	elseif ($fila[1] == 'grave')
		$gravedad = '[G]';
	elseif ($fila[1] == 'muy grave')
		$gravedad = '[MG]';
	else
		$gravedad = '[?]';

	$MiPDF->Cell(140, 5, $fila[0].'   '.$gravedad.'   '.$fila[2], 0, 1, 'L', 0);
	$contador++;
}

$MiPDF->Output();
?>