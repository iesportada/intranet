<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 'c'));

if($borrar){
	include ("../menu.php");
	$i=0;
	$j=0;
	foreach ($_POST as $ide => $valor) {       if(($ide<>'borrar') and (!empty( $valor))){
		for($i=0; $i <= count($valor)-1; $i++){ $j+=1;
		$bor = mysqli_query($db_con, "delete from morosos where id=$valor[$i]") or die("No se ha podido borrar");
		}
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            																	<button type="button" class="close" data-dismiss="alert">&times;</button>
																										<h5>ATENCI&Oacute;N:</h5>
																	El proceso de borrado ha sido completado correctamente. Los alumnos no volver&aacute;n a aparecer en la lista.
																																									</div></div><br />
																													<div align="center">
  																		<input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
																																					</div>';	
	}
	elseif ($j==0)     {  echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            																	<button type="button" class="close" data-dismiss="alert">&times;</button>
																										<h5>ATENCI&Oacute;N:</h5>
																	No se ha podido borrar porque no has elegido ning&uacute;n alumno de la lista. Vuelve atr&aacute;s para solucionarlo.
																																									</div></div><br />
																													<div align="center">
  																		<input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
																																					</div>';									
	}
	}
}


elseif ($registro){
	$i=0;
	$j=0;
	$asunto='Retraso injustificado en la devoluci&oacute;n de material a la biblioteca del centro';
	$informa='Jefatura de Estudios';
	$grave='grave';
	$medida='Amonestaci&oacute;n escrita';
	$expulsionaula='0';
	$enviado='1';
	$recibido='1';
	$causa='Otras';
	$accion='Env&iacute;o de SMS';

	foreach ($_POST as $ide => $valor) {      if(($ide<>'registro') and (!empty( $valor))){
			
		include ("../pdf/fpdf.php");
		define ( 'FPDF_FONTPATH', '../pdf/font/' );
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
				$this->Image ( '../../img/encabezado.jpg',15,15,50,'','jpg');
				$this->SetFont('ErasDemiBT','B',10);
				$this->SetY(15);
				$this->Cell(90);
				$this->Cell(80,4,'CONSEJER�A DE EDUCACI�N, CULTURA Y DEPORTE',0,1);
				$this->SetFont('ErasMDBT','I',10);
				$this->Cell(90);
				$this->Cell(80,4,$GLOBALS['CENTRO_NOMBRE'],0,1);
				$this->Ln(8);
			}
			function Footer() {
				$this->Image ( '../../img/pie.jpg', 10, 245, 25, '', 'jpg' );
				$this->SetY(265);
				$this->SetFont('ErasMDBT','',10);
				$this->SetTextColor(156,156,156);
				$this->Cell(70);
				$this->Cell(80,4,$GLOBALS['CENTRO_DIRECCION'],0,1);
				$this->Cell(70);
				$this->Cell(80,4,$GLOBALS['CENTRO_CODPOSTAL'].', '.$GLOBALS['CENTRO_LOCALIDAD'].' ('.$GLOBALS['CENTRO_PROVINCIA'] .')',0,1);
				$this->Cell(70);
				$this->Cell(80,4,'Tlf: '.$GLOBALS['CENTRO_TELEFONO'].'   Fax: '.$GLOBALS['CENTRO_FAX'],0,1);
				$this->Cell(70);
				$this->Cell(80,4,'Correo: '.$GLOBALS['CENTRO_CORREO'],0,1);
				$this->Ln(8);
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
		$MiPDF->SetMargins(25,20,20);
		# ajustamos al 100% la visualizaciÃ³n
		$MiPDF->SetDisplayMode ( 'fullpage' );
		$hoy= date ('d-m-Y',time());
		$titulo1 = utf8_decode("COMUNICACI�N DE AMONESTACI�N ESCRITA");

		for($i=0; $i <= count($valor)-1; $i++){ $j+=1; //echo $valor[$i];
		$duplicado= mysqli_query($db_con, "select amonestacion from morosos where id=$valor[$i]");
		$duplicados=mysqli_fetch_array($duplicado);
			
		if($duplicados[0]=='NO'){//echo"Ya has registrado las amonestaciones";

			$upd = mysqli_query($db_con, "update morosos set amonestacion='SI' where id=$valor[$i]") or die ("No se ha podido actualizar registro");
			//localizo el alumno a través de la id de la tabla morosos.

			$al=mysqli_query($db_con, "select apellidos,nombre,curso from morosos where id=$valor[$i]") or die ("error al localizar alumno");
			while($alu=mysqli_fetch_array($al)){
					
				$nombre=$alu[1];
				$apellido=$alu[0];
				$curso=$alu[2];
				// echo $nombre.'-'.$apellido;
					
				//localizo la clave del alumno en Falumnos.
				$cla=mysqli_query($db_con, "select CLAVEAL,unidad from FALUMNOS where NOMBRE='$nombre' and APELLIDOS='$apellido'") or die ("error al localizar claveal");
				while($clav=mysqli_fetch_array($cla)){

					$dia= date ('Y-m-d',time());
					$clave=$clav[0];// echo $clave.'---'. $dia;
					$unidad=$clav[1]; //echo $nivel;
					//insertamos, por fín, la fechoría
					$fechoria = mysqli_query($db_con,  "insert into Fechoria (CLAVEAL,FECHA,ASUNTO,NOTAS,INFORMA,grave,medida,expulsionaula,enviado,recibido) values ('" . $clave . "','" . $dia . "','" . $asunto . "','" . $asunto . "','" . $informa . "','" . $grave . "','" . $medida . "','" . $expulsionaula . "','" . $enviado . "','" . $recibido . "')") or die ("error al registrar fechoría");

					//ahora registramos la intervencion en la tabla tutoría, debido al tema de los SMS

					$tutoria=mysqli_query($db_con, "insert into tutoria (apellidos, nombre, tutor,nivel,grupo,observaciones,causa,accion,fecha, claveal,jefatura) values ('" . $apellido . "','" . $nombre . "','" . $informa . "','" . $unidad . "','" . $asunto . "','" . $causa . "','" . $accion . "','" . $dia . "','" . $clave . "','" . $recibido . "')" ) or die ("error al registrar accion en tabla tutoria");

					// aquí iría el envío de sms











					// aquí generamos el pdf con todas las amonestaciones
					$nombre=utf8_decode($nombre);
					$apellido=utf8_decode($apellido);

					$cuerpo1 = utf8_decode("Muy Señor/Sra. mío/a:

Pongo en su conocimiento que con  fecha $hoy su hijo/a $nombre $apellido alumno del grupo $curso ha sido amonestado/a por \"Retraso injustificado en la devolución de material a la biblioteca del centro\"");
					$cuerpo2 = utf8_decode("Asimismo, le comunico que, según contempla el Plan de Convivencia del Centro, regulado por el Decreto 327/2010 de 13 de Julio por el que se aprueba el Reglamento Orgánico de los Institutos de Educación Secundaria, de reincidir su hijo/a en este tipo de conductas contrarias a las normas de convivencia del Centro podría imponérsele otra medida de corrección que podría llegar a ser la suspensión del derecho de asistencia al Centro.");
					$cuerpo3 = utf8_decode("----------------------------------------------------------------------------------------------------------------------------------------------

En $config['centro_localidad'], a _________________________________
Firmado: El Padre/Madre/Representante legal:



D./Dña _____________________________________________________________________
D.N.I ___________________________");
					$cuerpo4 = utf8_decode("
----------------------------------------------------------------------------------------------------------------------------------------------

COMUNICACIÓN DE AMONESTACIÓN ESCRITA

	El alumno/a $nombre $apellido del grupo $curso, ha sido amonestado/a con fecha $hoy con falta grave, recibiendo la notificación mediante comunicación escrita de la misma para entregarla al padre/madre/representante legal.

                                                                         Firma del alumno/a:
	
");

					# insertamos la primera pagina del documento
					$MiPDF->Addpage ();
					#### Cabecera con dirección
					$MiPDF->SetFont ( 'NewsGotT', '', 10 );
					$MiPDF->SetTextColor ( 0, 0, 0 );
					$MiPDF->SetTextColor ( 0, 0, 0 );
					$MiPDF->Text ( 128, 35, $config['centro_denominacion'] );
					$MiPDF->Text ( 128, 39, $config['centro_direccion'] );
					$MiPDF->Text ( 128, 43, $config['centro_codpostal'] . " (" . $config['centro_localidad'] . ")" );
					$MiPDF->Text ( 128, 47, "Tlfno. " . $config['centro_telefono']);
					#Cuerpo.
					$MiPDF->Ln ( 45 );
					$MiPDF->SetFont ( 'NewsGotT', 'B', 11 );
					$MiPDF->Multicell ( 0, 4, $titulo1, 0, 'C', 0 );
					$MiPDF->SetFont ( 'NewsGotT', '', 10 );
					$MiPDF->Ln ( 4 );
					$MiPDF->Multicell ( 0, 4, $cuerpo1, 0, 'J', 0 );
					$MiPDF->Ln ( 3 );
					$MiPDF->Multicell ( 0, 4, $cuerpo2, 0, 'J', 0 );
					$MiPDF->Ln ( 6 );
					$MiPDF->Multicell ( 0, 4, 'En ' . $config['centro_localidad'] . ', a ' . $hoy, 0, 'C', 0 );
					$MiPDF->Ln ( 6 );
					$MiPDF->Multicell ( 0, 4, 'Jefatura de Estudios', 0, 'C', 0 );
					$MiPDF->Ln ( 16 );
					$MiPDF->Multicell ( 0, 4, $tutor, 0, 'C', 0 );
					$MiPDF->Ln ( 5 );
					$MiPDF->Multicell ( 0, 4, $cuerpo3, 0, 'J', 0 );
					$MiPDF->Ln ( 5 );
					$MiPDF->Multicell ( 0, 4, $cuerpo4, 0, 'J', 0 );



				}

					
					
			}


		}
		}
			
		$MiPDF->Output ();


		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            																	<button type="button" class="close" data-dismiss="alert">&times;</button>
																										<h5>ATENCI&Oacute;N:</h5>
																	Las amonestaciones se han registrado con &eacute;xito. Ya puedes volver atr&aacute;s e imprimirlas.
																																									</div></div><br />
																													<div align="center">
  																		<input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
																																					</div>';

	}

	elseif ($j==0)     {  echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            																	<button type="button" class="close" data-dismiss="alert">&times;</button>
																										<h5>ATENCI&Oacute;N:</h5>
																	No se ha podido registrar la amonestaci&oacute;n porque no has elegido ning&uacute;n alumno de la lista. Vuelve atr&aacute;s para solucionarlo.
																																									</div></div><br />
																													<div align="center">
  																		<input type="button" value="Volver atr&aacute;s" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
																																					</div>';									
	}




	}

}



?>









