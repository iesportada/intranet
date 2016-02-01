<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 'c'));

if(isset($_POST['impreso'])){
	
	$impreso=$_POST['impreso'];
	$hola=$_POST['hola'];
	
	$j=0;
	foreach ($_POST as $ide => $valor) {
		if(($ide<>'impreso') and (!empty( $valor))){
			include ("../../pdf/fpdf.php");
			define ( 'FPDF_FONTPATH', '../../pdf/font/' );
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

			# creamos el nuevo objeto partiendo de la clase
			$MiPDF=new GranPDF('P','mm','A4');
$MiPDF->AddFont('NewsGotT','','NewsGotT.php');
$MiPDF->AddFont('NewsGotT','B','NewsGotTb.php');
$MiPDF->AddFont('ErasDemiBT','','ErasDemiBT.php');
$MiPDF->AddFont('ErasDemiBT','B','ErasDemiBT.php');
$MiPDF->AddFont('ErasMDBT','','ErasMDBT.php');
$MiPDF->AddFont('ErasMDBT','I','ErasMDBT.php');
			# creamos el nuevo objeto partiendo de la clase ampliada
			$MiPDF->SetMargins ( 25, 20, 20 );
			# ajustamos al 100% la visualizaciÃƒÂ³n
			$MiPDF->SetDisplayMode ( 'fullpage' );
			$hoy= date ('d-m-Y',time());
			$tutor="Jefatura de Estudios";
			$titulo1 = "COMUNICACIÓN DE AMONESTACIÓN ESCRITA";

			for($i=0; $i <= count($valor)-1; $i++){ 
			$j+=1; //echo $valor[$i];
			$al=mysqli_query($db_con, "select apellidos,nombre,curso from morosos where id='$valor[$i]'") or die ("error al localizar alumno");
			//echo "select apellidos,nombre,curso from morosos where id='$valor[$i]'";
			while($alu=mysqli_fetch_array($al)){
					
				$nombre=$alu[1];
				$apellido=$alu[0];
				$curso=$alu[2];
				// echo $nombre.'-'.$apellido;



				// aquÃ­ generamos el pdf con todas las amonestaciones
				$nombre=$nombre;
				$apellido=$apellido;
					
				$cuerpo1 = "Muy Señor/Sra. mío/a:

Pongo en su conocimiento que con  fecha $hoy su hijo/a $nombre $apellido alumno del grupo $curso ha sido amonestado/a por \"Retraso injustificado en la devolución de material a la Biblioteca del Centro\"";
				$cuerpo2 = "Asimismo, le comunico que, según contempla el Plan de Convivencia del Centro, regulado por el Decreto 327/2010 de 13 de Julio por el que se aprueba el Reglamento Orgánico de los Institutos de Educación Secundaria, de reincidir su hijo/a en este tipo de conductas contrarias a las normas de convivencia del Centro podría imponérsele otra medida de corrección que podría llegar a ser la suspensión del derecho de asistencia al Centro.";
				$cuerpo3 = "----------------------------------------------------------------------------------------------------------------------------------------------

En ".$config['centro_localidad'].", a _________________________________
Firmado: El Padre/Madre/Representante legal:



D./Dña _____________________________________________________________________
D.N.I ___________________________";
				$cuerpo4 = "
----------------------------------------------------------------------------------------------------------------------------------------------

COMUNICACIÓN DE AMONESTACIÓN ESCRITA

	El alumno/a $nombre $apellido del grupo $curso, ha sido amonestado/a con fecha $hoy con falta grave, recibiendo la notificación mediante comunicación escrita de la misma para entregarla al padre/madre/representante legal.

                                           Firma del alumno/a:
	
";

				# insertamos la primera pagina del documento
				$MiPDF->Addpage ();
				#### Cabecera con direcciÃ³n
				$MiPDF->SetFont ( 'NewsGotT', '', 12 );
				$MiPDF->SetTextColor ( 0, 0, 0 );
				$MiPDF->SetTextColor ( 0, 0, 0 );
				$MiPDF->Text ( 128, 35, $config['centro_denominacion'] );
				$MiPDF->Text ( 128, 39, $config['centro_direccion'] );
				$MiPDF->Text ( 128, 43, $config['centro_codpostal'] . " (" . $config['centro_localidad'] . ")" );
				$MiPDF->Text ( 128, 47, "Tlfno. " . $config['centro_telefono']);
				#Cuerpo.
				$MiPDF->Ln ( 45 );
				$MiPDF->SetFont ( 'NewsGotT', 'B', 12 );
				$MiPDF->Multicell ( 0, 4, $titulo1, 0, 'C', 0 );
				$MiPDF->SetFont ( 'NewsGotT', '', 12 );
				$MiPDF->Ln ( 4 );
				$MiPDF->Multicell ( 0, 4, $cuerpo1, 0, 'J', 0 );
				$MiPDF->Ln ( 3 );
				$MiPDF->Multicell ( 0, 4, $cuerpo2, 0, 'J', 0 );
				$MiPDF->Ln ( 6 );
				$MiPDF->Multicell ( 0, 4, 'En ' . $config['centro_localidad'] . ', a ' . $hoy, 0, 'C', 0 );
				$MiPDF->Ln ( 20 );
				$MiPDF->Multicell ( 0, 4, $tutor, 0, 'C', 0 );
				$MiPDF->Ln ( 5 );
				$MiPDF->Multicell ( 0, 4, $cuerpo3, 0, 'J', 0 );
				$MiPDF->Ln ( 5 );
				$MiPDF->Multicell ( 0, 4, $cuerpo4, 0, 'J', 0 );
			}
			}
			$MiPDF->Output ();
	 }
	}
}

?>
