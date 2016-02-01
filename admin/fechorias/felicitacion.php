<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$dia0 = explode ( "-", $fecha );
$fecha3 = "$dia0[2]-$dia0[1]-$dia0[0]";

// Control de errores
if (! $_POST['nombre'] or ! $asunto or ! $fecha or ! $informa or $fecha=='0000-00-00') {
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCI&Oacute;N:</legend>
            No has introducido datos en alguno de los campos <strong>obligatorios</strong>.<br> Por favor, rellena los campos vac&iacute;os e int&eacute;ntalo de nuevo.
          </div></div>';
} elseif (isset($_POST['nombre'])) {
	
	if (is_array($nombre))
		$num_a = count($_POST['nombre']);
	else
		$num_a=1;

	$z=0;
	for ($i=0;$i<$num_a;$i++){
		if ($num_a==1 and !is_array($nombre))
			$claveal = $nombre;
		else
			$claveal = $nombre[$i];

	$ya_esta = mysqli_query($db_con, "select claveal, fecha, grave, asunto, notas, informa from Fechoria where claveal = '$claveal' and fecha = '$fecha3' and grave = '$grave' and asunto = '$asunto' and informa = '$informa'");

	if (mysqli_num_rows($ya_esta)>0) {
		echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <legend>Atenci&oacute;n:</legend>
            Ya hay una felicitación registrada que contiene los mismos datos que est&aacute;s enviando, y no queremos repetirlos... .
          </div></div><br />';
	}
	else{
		$alumno = mysqli_query($db_con, " SELECT distinct FA.APELLIDOS, FA.NOMBRE, FA.unidad, FA.nc, FA.CLAVEAL, alma.TELEFONO, alma.TELEFONOURGENCIA FROM FALUMNOS as FA, alma WHERE FA.claveal = alma.claveal and FA.claveal = '$claveal'" );

		$rowa = mysqli_fetch_array ( $alumno );
		$apellidos = trim ( $rowa [0] );
		$nombre_alum = trim ( $rowa [1] );
		$unidad = trim ( $rowa [2] );
		$tfno = trim ( $rowa [5] );
		$tfno_u = trim ( $rowa [6] );


		// SMS
		if ($config['mod_sms']) {

			$hora_f = date ( "G" );

			//echo "TELEFONO1: " .$tfno." TELEFONO_U:" .$tfno_u."<br>";
			if (($grave == "felicitar") and (substr ( $tfno, 0, 1 ) == "6" or substr ( $tfno, 0, 1 ) == "7" or substr ( $tfno_u, 0, 1 ) == "6" or substr ( $tfno_u, 0, 1 ) == "7")) {

				$sms_n = mysqli_query($db_con, "select max(id) from sms" );
				$n_sms = mysqli_fetch_array ( $sms_n );
				$extid = $n_sms [0] + 1;

				if (substr ( $tfno, 0, 1 ) == "6" or substr ( $tfno, 0, 1 ) == "7") {
					$mobile = $tfno;
				} else {
					$mobile = $tfno_u;
				}
				$message = "El dia " .$fecha. ", a ".$horaEnvia." hora, felicitamos a su hijo/a ".$nombre_alum." por su buena actitud y trabajo en clase";
				
				if(strlen($mobile) == 9) {
				
					mysqli_query($db_con, "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$message','$informa')" );
					
					// ENVIO DE SMS
					include_once(INTRANET_DIRECTORY . '/lib/trendoo/sendsms.php');
					$sms = new Trendoo_SMS();
					$sms->sms_type = SMSTYPE_GOLD_PLUS;
					$sms->add_recipient('+34'.$mobile);
					$sms->message = $message;
					$sms->sender = $config['mod_sms_id'];
					$sms->set_immediate();
					if ($sms->validate()) 
						$sms->send();	
					$fecha2 = date ( 'Y-m-d' );
					$observaciones = $message;
					$accion = "Env&iacute;o de SMS";
					$causa = "Felicitaci&oacute;n";
				}
				else {
					echo "
					<div class=\"alert alert-error\">
						<strong>Error:</strong> No se pudo enviar el SMS al teléfono (+34) ".$mobile.". Corrija la información de contacto del alumno/a en Séneca e importe los datos nuevamente.
					</div>
					<br>";
				}
			}
		}
		// FIN SMS
		$dia = explode ( "-", $fecha );
		$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
		$query = "insert into Fechoria (CLAVEAL,FECHA,ASUNTO,NOTAS,INFORMA,grave,medida,expulsionaula,atiende,horaEnvia,horaAtiende) 
			values ('" . $claveal . "','" . $fecha2 . "','" . $asunto . "','" . $notas . "','" . $informa . "','" . $grave . "','" . $medida . "','" . $expulsionaula . "','" . $atiende . "','" . $horaEnvia . "','" . $horaAtiende . "')";
	 	//echo $query."<br>";
	 	$inserta = mysqli_query($db_con, $query );
		if ($inserta) {
	 		$z++;
	 	}
		$nfechoria = "select max(id) from Fechoria where claveal = '$claveal'";
	 	$nfechoria0 = mysqli_query($db_con, $nfechoria );
	 	$nfechoria1 = mysqli_fetch_row ( $nfechoria0 );
	 	$id = $nfechoria1 [0];
	}
}

if ($z>0) {
	$cadena = "<br /><div align='center'><div class='alert alert-success alert-block fade in'>";
	$cadena .= "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
	$cadena .= "Se ha enviado la felicitación mediante SMS a ".$z." alumno/s";
	$cadena .= "<a href='detfechorias.php?id=".$id."&claveal=".$claveal."'><i class='fa fa-search fa-fw fa-lg' data-bs='tooltip' title='Ver Detalles'></i></a></div></div><br />";
	echo $cadena;
}
unset ($unidad);
unset($nombre);
unset ($id);
unset ($claveal);
}
?>
