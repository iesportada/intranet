<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

if (isset($_POST['niv'])) {$niv = $_POST['niv'];}else{$niv="";}	
include("../../pdf/fpdf.php");
define('FPDF_FONTPATH','../../pdf/font/');
# creamos la clase extendida de fpdf.php 
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
		$this->Image( '../../img/encabezado.jpg',25,14,53,'','jpg');
		$this->SetFont('ErasDemiBT','B',12);
		$this->SetY(15);
		$this->Cell(75);
		$this->Cell(80,5,'CONSEJERÍA DE EDUCACIÓN, CULTURA Y DEPORTE',0,1);
		$this->SetFont('ErasMDBT','I',12);
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

			# creamos el nuevo objeto partiendo de la clase
			$MiPDF=new GranPDF('P','mm','A4');
$MiPDF->AddFont('NewsGotT','','NewsGotT.php');
$MiPDF->AddFont('NewsGotT','B','NewsGotTb.php');
$MiPDF->AddFont('ErasDemiBT','','ErasDemiBT.php');
$MiPDF->AddFont('ErasDemiBT','B','ErasDemiBT.php');
$MiPDF->AddFont('ErasMDBT','','ErasMDBT.php');
$MiPDF->AddFont('ErasMDBT','I','ErasMDBT.php');
	$MiPDF->SetMargins(20,20,20);
	$MiPDF->SetDisplayMode('fullpage');

// Alumnos que deben reponer libros
$repo1 = "select distinct textos_alumnos.claveal from textos_alumnos, alma where alma.claveal = textos_alumnos.claveal and alma.curso = '$niv' and (estado = 'M' or estado = 'N') and devuelto = '1' order by alma.curso";
//echo $repo1;
$repo0 = mysqli_query($db_con, $repo1);
while ($repo = mysqli_fetch_array($repo0)) {
	$claveal = $repo[0];
// Datos del alumno	
	$sqlal="SELECT concat(Nombre,' ',Apellidos),alma.Unidad,Domicilio,Localidad,codpostal,Tutor, curso FROM alma, FTUTORES WHERE alma.unidad = FTUTORES.unidad and claveal='".$claveal."'";
	$resultadoal = mysqli_query($db_con, $sqlal);
	$registroal = mysqli_fetch_row($resultadoal);
	$nivel = $niv;

// Libros en mal estado o perdidos
$sqlasig="SELECT distinct asignaturas.nombre, textos_gratis.titulo, textos_gratis.editorial, importe from textos_alumnos, textos_gratis, asignaturas where textos_alumnos.claveal='$claveal' and asignaturas.codigo = textos_alumnos.materia and textos_gratis.materia=asignaturas.nombre and (estado = 'M' or estado = 'N')  and textos_gratis.nivel='$nivel'";
$resulasig=mysqli_query($db_con, $sqlasig);
#recogida de variables.
$hoy=formatea_fecha(date('Y-m-d'));
$alumno=$registroal[0];
$unidad=$registroal[1];
$domicilio=$registroal[2];
$localidad=$registroal[3];
$codigo=$registroal[4];
$tutor="Tutor/a: ".$registroal[5];
$fecha = date('d/m/Y');
$texto2=" Se debe reponer o en su caso abonar el importe indicado ";

$titulo2="NOTIFICACIÓN DE REPOSICIÓN DE LIBROS DE TEXTO";
$cuerpo21="D./Dña. ".$config['directivo_secretaria'].", como Secretario/a del centro ".$config['centro_denominacion'].", y con el visto bueno de la Direccción: ";
$cuerpo22="CERTIFICA que el/la alumno/a: $alumno matriculado/a en el curso $unidad, revisados sus libros con fecha $fecha, debe ";
$cuerpo22.="reponer (o en su caso abonar el importe segun tarifa marcada por la Junta de Andalucía) los siguientes libros: ";
$importante2='En caso de no atender a este requerimiento el/la alumno/a no podrá disfrutar del programa de gratuidad el curso próximo.'; 

# insertamos la primera página del documento
$MiPDF->Addpage();
#### Cabecera con direcciÃ³n
$MiPDF->SetFont('NewsGotT','',12);
$MiPDF->SetTextColor(0,0,0);
$MiPDF->Text(30,55,$tutor);
$MiPDF->Text(30,65,$domicilio);
$MiPDF->Text(30,70,$codigo." (".$localidad.")");

	$total=0;
	$MiPDF->Ln(60);
	$MiPDF->SetFont('NewsGotT','B',12);
	$MiPDF->Multicell(0,4,$titulo2,0,'C',0);
	$MiPDF->SetFont('NewsGotT','',12);
	$MiPDF->Ln(4);
	$MiPDF->Multicell(0,4,$cuerpo21,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->Multicell(0,4,$cuerpo22,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->SetFont('NewsGotT','',12);
	$MiPDF->Ln(2);
	while($regasig=mysqli_fetch_row($resulasig)){
		$MiPDF->SetFont('NewsGotT','',12);
		$MiPDF->SetX(170);
		$MiPDF->cell(0,4,$regasig[3].' Euros',0,'D',0);
	$MiPDF->SetX(20);
	$MiPDF->Multicell(150,4,'- '.$regasig[0].' --> Título: '.$regasig[1].' ('.$regasig[2].')',0,'I',0);
	
	$total=$total+$regasig[3];
	}#del while
	mysqli_query($db_con, "update textos_alumnos set devuelto = '1', fecha = now() where claveal = '$claveal'");		
		$MiPDF->SetFont('NewsGotT','B',12);
		$MiPDF->SetX(158);
	$MiPDF->Multicell(0,4,' Total: '.$total.' Euros',0,'D',0);
		$MiPDF->SetFont('NewsGotT','',12);
	$MiPDF->Ln(5);
	$MiPDF->Multicell(0,4,'En '.$config['centro_localidad'].', a '.$hoy,0,'C',0);
	$MiPDF->Ln(5);
	$MiPDF->Multicell(0,4,'Secretario/a:                        Sello del Centro                         Director/a:',0,'C',0);
	$MiPDF->Ln(14);
	$MiPDF->Multicell(0,4,$config['directivo_secretaria'].'                                             '.$config['directivo_direccion'],0,'C',0);
	$MiPDF->Ln(4);
	$MiPDF->Multicell(0,4,$importante2,0,'J',0);
	
}

$MiPDF->Output();
			
?>

