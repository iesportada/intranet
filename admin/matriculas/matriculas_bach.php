<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 7));


if (isset($_GET['curso'])) {$curso = $_GET['curso'];}elseif (isset($_POST['curso'])) {$curso = $_POST['curso'];}else{$curso="";}
if (isset($_GET['dni'])) {$dni = $_GET['dni'];}elseif (isset($_POST['dni'])) {$dni = $_POST['dni'];}else{$dni="";}
if (isset($_GET['claveal'])) {$claveal = $_GET['claveal'];}elseif (isset($_POST['claveal'])) {$claveal = $_POST['claveal'];}else{$claveal="";}
if (isset($_GET['enviar'])) {$enviar = $_GET['enviar'];}elseif (isset($_POST['enviar'])) {$enviar = $_POST['enviar'];}else{$enviar="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}

// Divorcios
$divorciados = array(
array(
													'id'     => 'Guardia y Custodia compartida por Madre y Padre',
													'nombre' => 'Guardia y Custodia compartida por Madre y Padre',
),
array(
													'id'     => 'Guardia y Custodia de la Madre',
													'nombre' => 'Guardia y Custodia de la Madre',
),
array(
													'id'     => 'Guardia y Custodia del Padre',
													'nombre' => 'Guardia y Custodia del Padre',
),
);


// Enfermedades
$enfermedades = array(
array(
													'id'     => 'Celiaquía',
													'nombre' => 'Celiaquía',
),
array(
													'id'     => 'Alergias a alimentos',
													'nombre' => 'Alergias a alimentos',
),
array(
													'id'     => 'Alergias respiratorias',
													'nombre' => 'Alergias respiratorias',
),
array(
													'id'     => 'Asma',
													'nombre' => 'Asma',
),
array(
													'id'     => 'Convulsiones febriles',
													'nombre' => 'Convulsiones febriles',
),
array(
													'id'     => 'Diabetes',
													'nombre' => 'Diabetes',
),
array(
													'id'     => 'Epilepsia',
													'nombre' => 'Epilepsia',
),
array(
													'id'     => 'Insuficiencia cardíaca',
													'nombre' => 'Insuficiencia cardíaca',
),
array(
													'id'     => 'Insuficiencia renal',
													'nombre' => 'Insuficiencia renal',
),
);

$transporte_este = array(
array(
												'id'     => 'Urb. Mar y Monte',
												'nombre' => 'Urb. Mar y Monte',
),
array(
												'id'     => 'Urb. Diana - Isdabe',
												'nombre' => 'Urb. Diana - Isdabe',
),
array(
												'id'     => 'Benamara - Benavista',
												'nombre' => 'Benamara - Benavista',
),
array(
												'id'     => 'Bel Ai',
												'nombre' => 'Bel Ai',
),
array(
												'id'     => 'Parada Bus Portillo Cancelada',
												'nombre' => 'Parada Bus Portillo Cancelada',
),
array(
												'id'     => 'Parque Antena',
												'nombre' => 'Parque Antena',
),
array(
												'id'     => 'El Pirata',
												'nombre' => 'El Pirata',
),
array(
												'id'     => 'El Velerín',
												'nombre' => 'El Velerín',
),
array(
												'id'     => 'El Padrón',
												'nombre' => 'El Padrón',
),
array(
												'id'     => 'Mc Donald\'s',
												'nombre' => 'Mc Donald\'s',
),
);

$transporte_oeste = array(
array(
												'id'     => 'Buenas Noches',
												'nombre' => 'Buenas Noches',
),
array(
												'id'     => 'Costa Galera',
												'nombre' => 'Costa Galera',
),
array(
												'id'     => 'Bahía Dorada',
												'nombre' => 'Bahía Dorada',
),
array(
												'id'     => 'Don Pedro',
												'nombre' => 'Don Pedro',
),
array(
												'id'     => 'Bahía Azul',
												'nombre' => 'Bahía Azul',
),
array(
												'id'     => 'G. Shell - H10',
												'nombre' => 'G. Shell - H10',
),
array(
												'id'     => 'Seghers Bajo (Babylon)',
												'nombre' => 'Seghers Bajo (Babylon)',
),
array(
												'id'     => 'Seghers Alto (Ed. Sierra Bermeja)',
												'nombre' => 'Seghers Alto (Ed. Sierra Bermeja)',
),
);

// Asignaturas y Modalidades
$it1 = array("1"=>"Ciencias e Ingeniería y Arquitectura", "2"=>"Ciencias y Ciencias de la Salud", "3"=>"Humanidades", "4"=>"Ciencias Sociales y Jurídicas");
$opt11=array( "TIN1" => "Tecnología Industrial", "TIC1" => "Tecnologías de Información y Comunicación");
$opt12=array("AAP1"=>"Anatomía Aplicada", "TIC11" => "Tecnologías de Información y Comunicación");
$opt13=array(
""=>"",
"LAT1-GRI1-PAC1" => "Latín, Griego, Patrimonio Artístico y Cultural", 
"LAT1-GRI1-CEE1" => "Latín, Griego, Cultura Emprendedora y Empresarial",
"LAT1-GRI1-TIC0" => "Latín, Griego, Tecnologías de la Información y Comunicación",
"LAT1-LUN1-PAC1" => "Latín, Literatura Universal, Patrimonio Artístico y Cultural",
"LAT1-LUN1-CEE1" => "Latín, Literatura Universal, Cultura Emprendedora y Empresarial",
"LAT1-LUN1-TIC0" => "Latín, Literatura Universal, Tecnologías de la Información y Comunicación",
"LAT1-ECO1-PAC1" => "Latín, Economía, Patrimonio Artístico y Cultural",
"LAT1-ECO1-CEE1" => "Latín, Economía, Cultura Emprendedora y Empresarial",
"LAT1-ECO1-TIC0" => "Latín, Economía, Tecnologías de la Información y Comunicación",
"MCS1-GRI1-PAC1" => "Matemáticas Aplicadas a Ciencias Sociales, Griego, Patrimonio Artístico y Cultural", 
"MCS1-GRI1-CEE1" => "Matemáticas Aplicadas a Ciencias Sociales, Griego, Cultura Emprendedora y Empresarial",
"MCS1-GRI1-TIC0" => "Matemáticas Aplicadas a Ciencias Sociales, Griego, Tecnologías de la Información y Comunicación",
"MCS1-LUN1-PAC1" => "Matemáticas Aplicadas a Ciencias Sociales, Literatura Universal, Patrimonio Artístico y Cultural",
"MCS1-LUN1-CEE1" => "Matemáticas Aplicadas a Ciencias Sociales, Literatura Universal, Cultura Emprendedora y Empresarial",
"MCS1-LUN1-TIC0" => "Matemáticas Aplicadas a Ciencias Sociales, Literatura Universal,Tecnologías de la Información y Comunicación",
"MCS1-ECO1-PAC1" => "Matemáticas Aplicadas a Ciencias Sociales, Economía, Patrimonio Artístico y Cultural",
"MCS1-ECO1-CEE1" => "Matemáticas Aplicadas a Ciencias Sociales, Economía, Cultura Emprendedora y Empresarial",
"MCS1-ECO1-TIC0" => "Matemáticas Aplicadas a Ciencias Sociales, Economía, Tecnologías de la Información y Comunicación",
);

$it21 = array("Bachillerato de Ciencias y Tecnología", "Vía de Ciencias e Ingeniería", "Vía de Ciencias de la Naturaleza y la Salud", "Ciencias y Tecnología");
$it22 = array("Bachillerato de Humanidades y Ciencias Sociales", "Vía de Humanidades", "Vía de Ciencias Sociales", "Humanidades y Ciencias Sociales");
$opt21=array("FIS21_DBT21" => "Física, Dibujo Técnico", "FIS21_TIN21" => "Física, Tecnología", "FIS21_QUI21" => "Física, Química", "BIO21_QUI21" => "Biología, Química");
$opt22=array("HAR22_LAT22_GRI22" => "Historia del Arte, Latín, Griego", "HAR22_LAT22_MCS22" => "Historia del Arte, Latín, Matemáticas de las C. Sociales", "HAR22_ECO22_GRI22" => "Historia del Arte, Economía, Griego", "HAR22_ECO22_MCS22" => "Historia del Arte, Economía, Matemáticas de las C. Sociales", "GEO22_ECO22_MCS22" => "Geografía, Economía, Matemáticas de las C. Sociales", "GEO22_ECO22_GRI22" => "Geografía, Economía, Griego", "GEO22_LAT22_MCS22" => "Geografía, Latín, Matemáticas de las C. Sociales", "GEO22_LAT22_GRI22" => "Geografía, Latín, Griego");
$opt23 =array("aleman_25" => "Alemán 2º Idioma", "frances_25" => "Francés 2º Idioma", "tic_25" => "T.I.C.", "ciencias_25" => "Ciencias de la Tierra y Medioambientales", "musica_25" => "Historia de la Música y la Danza", "literatura_25" => "Literatura Universal", "edfisica_25"=>"Educación Física", "estadistica_25"=>"Estadística", "salud_25"=>"Introducción a las Ciencias de la Salud","ingles_25" => "Inglés 2º Idioma");
//$opt23 =array("ingles_25" => "Inglés 2º Idioma","aleman_25" => "Alemán 2º Idioma", "frances_25" => "Francés 2º Idioma", "tic_25" => "T.I.C.", "ciencias_25" => "Ciencias de la Tierra y Medioambientales", "musica_25" => "Historia de la Música y la Danza", "literatura_25" => "Literatura Universal", "edfisica_25"=>"Educación Física", "estadistica_25"=>"Estadística", "salud_25"=>"Introducción a las Ciencias de la Salud");

// Se procesan los datos enviados ppor el formulario
if(isset($_POST['enviar'])){
	foreach($_POST as $key => $val)
	{
		${$key} = $val;
		//echo "${$key} --> $val<br />";
	}
	// Comprobación de campos vacíos
	$nacimiento = str_replace("/","-",$nacimiento);
	$fecha0 = explode("-",$nacimiento);
	$fecha_nacimiento = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
	$campos = "apellidos nombre nacido provincia nacimiento domicilio localidad padre dnitutor telefono1 telefono2 religion colegio sexo nacionalidad ";
	$itinerario1=substr($mod1,-1);
	$itinerario2=substr($mod2,-1);
	foreach($_POST as $key => $val)
	{		
		if ($mod1==1) {$optativa1=$optativa11;}elseif ($mod1==2) {$optativa1=$optativa12;}elseif($mod1==3 or $mod1==4){$optativa1=$optativa13;}else{$optativa1="";}
		if ($key=="mod1") {
						if($optativa11=="" and $optativa12=="" and $optativa13==""){
							$vacios.= "optativas de modalidad de 1BACH, ";
							$num+=1;
						}

		}
		

		if ($key=="mod2"){
			foreach (${opt2.$itinerario2} as $opt => $n_opt){
				foreach ($_POST as $clave=>$valor){
					if ($valor==$opt) {
						$n_o=2;
						${optativa.$n_o}=$valor;
						if(${optativa.$n_o} == ""){
							$vacios.= "optativa".$n_o.", ";
							$num+=1;
						}
						$tr_o = explode(", ",$n_opt);
						$optativa2=$valor;
					}
				}
				$n_o="";
				$num="";
				foreach (${opt23} as $opt => $n_opt){
					foreach ($_POST as $clave=>$valor){
						if ($clave==$opt) {
							$n_o+=1;
							${optativa2b.$n_o}=$valor;
							if(${optativa2b.$n_o} == ""){
								$vacios.= "optativa2b".$n_o.", ";
								$num+=1;
							}
						}
					}
				}
			}
		}


		if(strstr($campos,$key." ")==TRUE){
			if($val == ""){
				$vacios.= $key.", ";
				$num+=1;
			}
		}
	}

	if ($religion == "") {
		$vacios.= "religion, ";
		$num+=1;
	}
	if ($religion1b == "" and $curso=="2BACH" and $repetidor<>1) {
		$vacios.= "religion o alternativa de 1BACH, ";
		$num+=1;
	}
	if ($idioma1 == "") {
		$vacios.= "1º idioma, ";
		$num+=1;
	}
	if ($idioma2 == "" and $curso=="1BACH") {
		$vacios.= "2º idioma, ";
		$num+=1;
	}
	if ($curso=="2BACH" and $repetidor == ""  and (empty($itinerario1) or empty($itinerario2))) {
		$vacios.= "modalidad de 2, ";
		$num+=1;
	}
	if ($curso=="2BACH" and $repetidor == "1" and empty($itinerario2)) {
		$vacios.= "modalidad de 2, ";
		$num+=1;
	}
	if ($curso=="1BACH" and empty($itinerario1)) {
		$vacios.= "modalidad de 1º, ";
		$num+=1;
	}

	if ($sexo == "") {
		$vacios.= "sexo, ";
		$num+=1;
	}
	// Control de errores
	if($num > 0){
		$adv = substr($vacios,0,-2);
		echo '
<script> 
 alert("Los siguientes datos son obligatorios y no los has rellenado en el formulario de inscripción:\n ';
		$num_cur = substr($curso,0,1);
		$num_cur_ant = $num_cur - 1;
		$cur_act = substr($curso,0,1)."º de BACHILLERATO";
		$cur_ant = $num_cur_ant . "º de BACHILLERATO";
		for ($i=1;$i<8;$i++){
			$adv= str_replace("optativa$i", "optativa de $cur_ant $i", $adv);
		}
		for ($i=1;$i<5;$i++){
			$adv= str_replace("optativa$i", "optativa de $cur_act  $i", $adv);
		}
		echo $adv.'.\n';
		echo 'Rellena los campos mencionados y envía los datos de nuevo para poder registrar tu solicitud correctamente.")
 </script>
';
	}
	else{

		if (substr($curso,0,1)==2){
			for ($i = 1; $i < 11; $i++) {
				for ($z = $i+1; $z < 11; $z++) {
					if (${optativa2b.$i}>0) {
						if (${optativa2b.$i}==${optativa2b.$z}) {
							$opt_rep="1";
						}
					}
				}
			}
		}

/*		if ($curso=="2BACH" and $repetidor <> "1") {
			if ($itinerario2==1 and $itinerario1>2){
				$incompat = 1;
			}
			if ($itinerario2==2 and $itinerario1<3){
				$incompat = 1;
			}
		}*/
		
	/*	if ($curso=="2BACH" and $repetidor <> "1") {
			if ($itinerario1=="1"){
				if ($optativa1=="BYG11" and (strstr($optativa2,"BIO")==FALSE and strstr($optativa2,"QUI")==FALSE)) {
					$incompat = 1;
				}
				if (strstr($optativa1,"BYG")==FALSE and (strstr($optativa2,"BIO")==TRUE or strstr($optativa2,"QUI")==TRUE)) {
					$incompat = 1;
				}
			}
			else
			{
				$n_opcs="";
				$it_csh = explode("-",$optativa1);
				foreach ($it_csh as $o_cs1){
					$o_cs1 = substr($o_cs1,0,3);
					if (strstr($optativa2,$o_cs1)==TRUE) {
						$n_opcs+=1;
					}
				}
				if ($n_opcs<>2) {
					$incompat = 1;
				}
			}
		}*/

		if (substr($curso,0,1)==1 and ($idioma1==$idioma2)){
			$idioma_rep="1";
		}
		if($colegio == "Otro Centro" and ($otrocolegio == "" or $otrocolegio == "Escribe aquí el nombre del Centro")){
			$vacios.="otrocolegio ";
			echo '
<script> 
 alert("No has escrito el nombre del Centro del que procede el alumno.\n';
			echo 'Rellena el nombre del Centro y envía los datos de nuevo para poder registrar tu solicitud correctamente.")
 </script>
';
		}
		elseif($enfermedad == "Otra enfermedad" and ($otraenfermedad == "" or $otraenfermedad == "Escribe aquí el nombre de la enfermedad")){
			$vacios.="otraenfermedad ";
			$msg_error = "No has escrito el nombre de la enfermedad del alumno. Rellena el nombre de la enfermedad y envía los datos de nuevo para poder registrar tu solicitud correctamente.";
		}
		elseif(strstr($nacimiento,"-") == FALSE){
			echo '
<script> 
 alert("ATENCIÓN:\n ';
			echo 'La fecha de nacimiento que has escrito no es correcta.\nEl formato adecuado para la fecha  es: dia-mes-año (01-01-1998).")
 </script>
';
		}
		elseif(strlen($ruta_este) > 0 and strlen($ruta_oeste) > 0){
			echo '
<script> 
 alert("ATENCIÓN:\n';
			echo 'Parece que has seleccionado dos rutas incompatibles para el Transporte Escolar, y solo puedes seleccionar una ruta, hacia el Este o hacia el Oeste de '.$config['centro_localidad'].'.\nElige una sola parada y vuelve a enviar los datos.")
 </script>
';
			$ruta_error = "";
		}
		elseif ($opt_rep=="1"){
			echo '
						<script> 
 alert("ATENCIÓN:\n';
			echo 'Parece que has seleccionado el mismo número de preferencia para varias optativas, y cada optativa debe tener un número de preferencia distinto.\nElige las optativas sin repetir el número de preferencia e inténtalo de nuevo.")
 </script>
';
		}
		elseif ($idioma_rep=="1"){
			echo '
						<script> 
 alert("ATENCIÓN:\n';
			echo 'Parece que has seleccionado el mismo idioma como primera y segunda, y cada idioma debe ser distinto.\nElige los idiomas sin repetir e inténtalo de nuevo.")
 </script>
';
		}
	/*	elseif($incompat=="1"){
			echo '
						<script> 
 alert("ATENCIÓN:\n';
			echo 'Parece que has seleccionado un grupo de asignaturas optativas de modalidad que son incompatibles con las optativas que has cursado en 1º de Bachillerato. Si quieres optar por esta posibilidad ponte en contacto con Jefatura de Estudios.")
 </script>
';			
		}*/
		else{
			if (strlen($claveal) > 3) {$extra = " claveal = '$claveal'";}
			elseif (strlen($dni) > 3) {$extra = " dni = '$dni'";}
			else {$extra = " dnitutor = '$dnitutor' ";}

			// El alumno ya se ha registrado anteriormente
			$ya_esta = mysqli_query($db_con, "select id from matriculas_bach where $extra");
			if (mysqli_num_rows($ya_esta) > 0) {
				$ya = mysqli_fetch_array($ya_esta);
				if (strlen($ruta_este) > 0 or strlen($ruta_oeste) > 0) {$transporte = '1';}
				if (empty($foto)) { $foto = "0";}
				$act_datos = "update matriculas_bach set apellidos='$apellidos', nombre='$nombre', nacido='$nacido', provincia='$provincia', nacimiento='$fecha_nacimiento', domicilio='$domicilio', localidad='$localidad', dni='$dni', padre='$padre', dnitutor='$dnitutor', madre='$madre', dnitutor2='$dnitutor2', telefono1='$telefono1', telefono2='$telefono2', religion='$religion', colegio='$colegio', otrocolegio='$otrocolegio', letra_grupo='$letra_grupo', idioma1='$idioma1', idioma2='$idioma2', religion = '$religion', observaciones = '$observaciones', promociona='$promociona', transporte='$transporte', ruta_este='$ruta_este', ruta_oeste='$ruta_oeste', curso='$curso', sexo = '$sexo', hermanos = '$hermanos', nacionalidad = '$nacionalidad', claveal = '$claveal', itinerario1 = '$itinerario1', itinerario2 = '$itinerario2', optativa1='$optativa1', optativa2='$optativa2', optativa2b1 = '$optativa2b1', optativa2b2 = '$optativa2b2', optativa2b3 = '$optativa2b3', optativa2b4 = '$optativa2b4', optativa2b5 = '$optativa2b5', optativa2b6 = '$optativa2b6', optativa2b7 = '$optativa2b7', optativa2b8 = '$optativa2b8', optativa2b9 = '$optativa2b9', optativa2b10 = '$optativa2b10', repite = '$repetidor', enfermedad = '$enfermedad', otraenfermedad = '$otraenfermedad', foto='$foto', bilinguismo='$bilinguismo', divorcio='$divorcio', religion1b='$religion1b' where id = '$ya[0]'";
				//echo $act_datos."<br>";
				mysqli_query($db_con, $act_datos);
			}
			else{

				if (strlen($ruta) > 0) {$transporte = '1';}
				if (empty($foto)) { $foto = "0";}
				$con_matr =  "insert into matriculas_bach (apellidos, nombre, nacido, provincia, nacimiento, domicilio, localidad, dni, padre, dnitutor, madre, dnitutor2, telefono1, telefono2, colegio, otrocolegio, letra_grupo, correo, idioma1, idioma2, religion, optativa1, optativa2, optativa2b1, optativa2b2, optativa2b3, optativa2b4, optativa2b5, optativa2b6, optativa2b7, optativa2b8, optativa2b9, optativa2b10, observaciones, curso, fecha, promociona, transporte, ruta_este, ruta_oeste, sexo, hermanos, nacionalidad, claveal, itinerario1, itinerario2, repite, enfermedad, otraenfermedad, foto, bilinguismo, divorcio, religion1b) VALUES ('$apellidos',  '$nombre', '$nacido', '$provincia', '$fecha_nacimiento', '$domicilio', '$localidad', '$dni', '$padre', '$dnitutor', '$madre', '$dnitutor2', '$telefono1', '$telefono2', '$colegio', '$otrocolegio', '$letra_grupo', '$correo', '$idioma1', '$idioma2', '$religion', '$optativa1', '$optativa2', '$optativa2b1', '$optativa2b2', '$optativa2b3', '$optativa2b4', '$optativa2b5', '$optativa2b6', '$optativa2b7', '$optativa2b8', '$optativa2b9', '$optativa2b10', '$observaciones', '$curso', now(), '$promociona', '$transporte', '$ruta_este', '$ruta_oeste', '$sexo', '$hermanos', '$nacionalidad', '$claveal', '$itinerario1', '$itinerario2', '$repetidor', '$enfermedad', '$otraenfermedad', '$foto', '$bilinguismo', '$divorcio', '$religion1b')";
				mysqli_query($db_con, $con_matr);
				
				//echo $con_matr;
			}
			$ya_esta1 = mysqli_query($db_con, "select id from matriculas_bach where $extra");
			$ya_id = mysqli_fetch_array($ya_esta1);
			$id = $ya_id[0];
			if ($nuevo=="1") {
				include("imprimir.php");
			}
			else{
				?>
<link
	href="../../css/bootstrap.min.css" rel="stylesheet">
<link
	href="../../css/otros.css" rel="stylesheet">
<link
	href="../../css/bootstrap-responsive.min.css" rel="stylesheet">
<link
	href="../../css/font-awesome.min.css" rel="stylesheet">
<link
	href="../../css/imprimir.css" rel="stylesheet" media="print">
<br />
<br />
<div align="center">
<div class="alert alert-success alert-block fade in">
<button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de la Matrícula se han registrado correctamente en la Base de
datos.</div>
</div>
<br />
				<?php
			}
			//	exit();
		}
	}
}

$n_curso="";

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="iso-8859-1">
<title>Intranet &middot; <?php echo $config['centro_denominacion']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Intranet del <?php echo $config['centro_denominacion']; ?>">
<meta name="author"
	content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">

<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/otros.css" rel="stylesheet">

<link href="../../js/datetimepicker/bootstrap-datetimepicker.css"
	rel="stylesheet">
<link href="../../css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="padding-top: 10px;">

<div class="container"><!-- MENSAJES --> <?php if(isset($msg_error)): ?>
<div class="alert alert-danger"><?php echo $msg_error; ?></div>
<?php endif; ?> <?php if(isset($msg_success)): ?>
<div class="alert alert-success"><?php echo $msg_success; ?></div>
<?php endif; ?> <?php

$cargo="1";

// Rellenar datos a partir de las tablas alma o matriculas.
if ($dni or $claveal or $id) {

	if (!empty($id)) {
		$conditio = " id = '$id'";
	}
	else{
		if (strlen($claveal) > 3) {$conditio = " claveal = '$claveal'"; $conditio1 = $conditio;}else{$conditio = " dni = '$dni' or dnitutor = '$dni' "; $conditio1 = " dni = '$dni' or dnitutor = '$dni' ";}
	}
	//echo $conditio;
	$curso = str_replace(" ","",$curso);
	// Comprobación de padre con varios hijos en el Centro
	$ya_matricula = mysqli_query($db_con, "select claveal, apellidos, nombre, id from matriculas_bach where ". $conditio ."");
	$ya_secundaria = mysqli_query($db_con, "select claveal, apellidos, nombre from alma_secundaria where ". $conditio1 ."");
	$ya_alma = mysqli_query($db_con, "select claveal, apellidos, nombre, unidad, idcurso from alma, unidades where nomunidad=unidad and (". $conditio1 .")");
	// Comprobamos si el alumno se ha registrado ya
	$ya = mysqli_query($db_con, "select apellidos, nombre, nacido, provincia, nacimiento, domicilio, localidad, dni, padre, dnitutor, madre,
	dnitutor2, telefono1, telefono2, colegio, otrocolegio, letra_grupo, correo, idioma1, idioma2, religion, 
	itinerario1, itinerario2, optativa1, optativa2, optativa2b1, optativa2b2, optativa2b3, 
	optativa2b4, optativa2b5, optativa2b6, optativa2b7, optativa2b8, optativa2b9, optativa2b10, observaciones, curso, fecha, 
	promociona, transporte, ruta_este, ruta_oeste, sexo, hermanos, nacionalidad, claveal, itinerario1, itinerario2, repite, foto, enfermedad, otraenfermedad, bilinguismo, divorcio, religion1b from matriculas_bach where ". $conditio ."");

	// Ya se ha matriculado
	if (mysqli_num_rows($ya) > 0) {
		$datos_ya = mysqli_fetch_object($ya);
		$naci = explode("-",$datos_ya->nacimiento);
		$nacimiento = "$naci[2]-$naci[1]-$naci[0]";
		$apellidos = $datos_ya->apellidos; $id = $datos_ya->id; $nombre = $datos_ya->nombre; $nacido = $datos_ya->nacido; $provincia = $datos_ya->provincia; $domicilio = $datos_ya->domicilio; $localidad = $datos_ya->localidad; $dni = $datos_ya->dni; $padre = $datos_ya->padre; $dnitutor = $datos_ya->dnitutor; $madre = $datos_ya->madre; $dnitutor2 = $datos_ya->dnitutor2; $telefono1 = $datos_ya->telefono1; $telefono2 = $datos_ya->telefono2; $colegio = $datos_ya->colegio; $correo = $datos_ya->correo; $otrocolegio = $datos_ya->otrocolegio; $letra_grupo = $datos_ya->letra_grupo; $religion = $datos_ya->religion; $observaciones = $datos_ya->observaciones; $promociona = $datos_ya->promociona; $transporte = $datos_ya->transporte; $ruta_este = $datos_ya->ruta_este; $ruta_oeste = $datos_ya->ruta_oeste; $sexo = $datos_ya->sexo; $hermanos = $datos_ya->hermanos; $nacionalidad = $datos_ya->nacionalidad; $claveal = $datos_ya->claveal; $curso = $datos_ya->curso;  $itinerario1 = $datos_ya->itinerario1; $itinerario2 = $datos_ya->itinerario2; $optativa1 = $datos_ya->optativa1; $optativa2 = $datos_ya->optativa2; $optativa2b1 = $datos_ya->optativa2b1; $optativa2b2 = $datos_ya->optativa2b2; $optativa2b3 = $datos_ya->optativa2b3; $optativa2b4 = $datos_ya->optativa2b4; $optativa2b5 = $datos_ya->optativa2b5; $optativa2b6 = $datos_ya->optativa2b6; $optativa2b7 = $datos_ya->optativa2b7; $optativa2b8 = $datos_ya->optativa2b8; $optativa2b9 = $datos_ya->optativa2b9; $optativa2b10 = $datos_ya->optativa2b10; $repetidor = $datos_ya->repite; $idioma1 = $datos_ya->idioma1; $idioma2 = $datos_ya->idioma2; $foto = $datos_ya->foto; $enfermedad = $datos_ya->enfermedad; $otraenfermedad = $datos_ya->otraenfermedad; $bilinguismo = $datos_ya->bilinguismo; $divorcio = $datos_ya->divorcio; $religion1b = $datos_ya->religion1b;
		
		$n_curso = substr($curso,0,1);
		if ($ruta_error == '1') {
			$ruta_este = "";
			$ruta_oeste = "";
		}
	}

	// Viene de Colegio de Secundaria
	elseif (mysqli_num_rows($ya_secundaria) > 0){
		$alma = mysqli_query($db_con, "select apellidos, nombre, provinciaresidencia, fecha, domicilio, localidad, dni, padre, dnitutor, concat(PRIMERAPELLIDOTUTOR2,' ',SEGUNDOAPELLIDOTUTOR2,', ',NOMBRETUTOR2), dnitutor2, telefono, telefonourgencia, correo, concat(PRIMERAPELLIDOTUTOR,' ',SEGUNDOAPELLIDOTUTOR,', ',NOMBRETUTOR), curso, sexo, nacionalidad, matriculas, claveal, colegio, unidad from alma_secundaria where ". $conditio1 ."");

		if (mysqli_num_rows($alma) > 0) {
			$al_alma = mysqli_fetch_array($alma);
			$apellidos = $al_alma[0];  $nombre = $al_alma[1]; $nacido = $al_alma[5]; $provincia = $al_alma[2]; $nacimiento = $al_alma[3]; $domicilio = $al_alma[4]; $localidad = $al_alma[5]; $dni = $al_alma[6]; $padre = $al_alma[7]; $dnitutor = $al_alma[8];
			if (strlen($al_alma[9]) > 3) {$madre = $al_alma[9];	}else{ $madre = ""; }
			; $dnitutor2 = $al_alma[10]; $telefono1 = $al_alma[11]; $telefono2 = $al_alma[12]; $correo = $al_alma[13]; $padre = $al_alma[14];
			$n_curso_ya = $al_alma[15]; $sexo = $al_alma[16]; $nacionalidad = $al_alma[17]; $letra_grupo = substr($al_alma[21],1); $claveal= $al_alma[19]; $colegio= $al_alma[20];
			$nacimiento= str_replace("/","-",$nacimiento);
			$curso="1BACH";
			$n_curso=substr($curso, 0, 1);
		}
	}

	// Es alumno del Centro
	elseif (mysqli_num_rows($ya_alma) > 0){
		$alma = mysqli_query($db_con, "select apellidos, nombre, provinciaresidencia, fecha, domicilio, localidad, dni, padre, dnitutor, concat(PRIMERAPELLIDOTUTOR2,' ',SEGUNDOAPELLIDOTUTOR2,', ',NOMBRETUTOR2), dnitutor2, telefono, telefonourgencia, correo, concat(PRIMERAPELLIDOTUTOR,' ',SEGUNDOAPELLIDOTUTOR,', ',NOMBRETUTOR), curso, sexo, nacionalidad, matriculas, claveal, unidad, combasi, curso, matriculas, idcurso, localidadnacimiento from alma, unidades where nomunidad=unidad and (". $conditio1 .")");

		if (mysqli_num_rows($alma) > 0) {
			$al_alma = mysqli_fetch_array($alma);
			if (empty($curso)) {
				if ($al_alma[24]=="6204" or $al_alma[24]=="2063"){$curso="2BACH";}
				if ($al_alma[24]=="6029" or $al_alma[24]=="2067"){$curso="2BACH";}
				if ($al_alma[24]=="101143"){$curso="1BACH";}
			}
			else{
				if ($al_alma[24]=="101143"){$curso="1BACH";}
			}
			$n_curso = substr($curso,0,1);

			$apellidos = $al_alma[0];  $nombre = $al_alma[1]; $nacido = $al_alma[5]; $provincia = $al_alma[2]; $nacimiento = $al_alma[3]; $domicilio = $al_alma[4]; $localidad = $al_alma[5]; $dni = $al_alma[6]; $padre = $al_alma[7]; $dnitutor = $al_alma[8];
			if ($madre == "") { if (strlen($al_alma[9]) > 3) {$madre = $al_alma[9];	}else{ $madre = ""; }}
			if ($dnitutor2 == "") { $dnitutor2 = $al_alma[10];} if ($telefono1 == "") { $telefono1 = $al_alma[11]; } if ($telefono2 == "") { $telefono2 = $al_alma[12];} if ($correo == "") { $correo = $al_alma[13];} $padre = $al_alma[14];
			$n_curso_ya = $al_alma[15]; $sexo = $al_alma[16]; $nacionalidad = $al_alma[17]; $letra_grupo = substr($al_alma[20],-1); $claveal= $al_alma[19]; $combasi = $al_alma[21]; $unidad = $al_alma[20]; $curso_largo = $al_alma[22]; $matriculas = $al_alma[23]; $nacido = $al_alma[25];
			if ($n_curso == substr($n_curso_ya,0,1)) {
				echo '
<script> 
 if(confirm("ATENCIÓN:\n ';
				echo 'Has elegido matricularte en el mismo Curso( ';
				echo strtoupper($n_curso_ya);
				echo ') que ya has estudiado este año. \nEsta situación solo puede significar que estás absolutamente seguro de que vas a repetir el mismo Curso. Si te has equivocado al elegir Curso para el próximo año escolar, vuelve atrás y selecciona el curso correcto. De lo contrario, puedes continuar.")){}else{history.back()};
 </script>';
				/*if ($n_curso=="1") {
				 $repetidor = '1';
				 $repetidor1 = "1";
				 }*/
				$repetidor = '1';
				// ${repetidor.$n_curso} = "1";
			}
			$nacimiento= str_replace("/","-",$nacimiento);
			$colegio = $config['centro_denominacion'];
		}
	}
	?>
<form id="form1" name="form1" method="post"
	action="matriculas_bach.php<?php if($cargo == "1"){echo "?cargo=1";}?>">

<table align="center" class="table table-bordered">
	<!-- CABECERA: LOGOTIPO -->
	<thead>
		<tr>
			<td colspan="2" style="border-right: 0; height: 90px;"><img
				class="img-responsive" src="../../img/encabezado.jpg" alt=""
				width="350"></td>
			<td colspan="2">
			<h4 class="text-uppercase"><strong>Consejería de Educación, Cultura y
			Deporte</strong></h4>
			<h5 class="text-uppercase"><strong><?php echo $config['centro_denominacion']; ?></strong></h5>
			</td>
		</tr>
	</thead>

	<!-- CUERPO -->
	<tbody>
	<?php
	// CURSO MATRICULA
	if (empty($n_curso)) $n_curso = substr($curso,0,1);

	switch ($curso) {
		case '1BACH' : $curso_matricula="PRIMERO"; break;
		case '2BACH' : $curso_matricula="SEGUNDO"; break;
	}
	?>
		<tr>
			<td colspan="4">
			<h4 class="text-center text-uppercase">SOLICITUD DE MATRÍCULA EN <?php echo $curso_matricula; ?>
			DE BACHILLERATO</h4>
			</td>
		</tr>

		<?php
		if (substr($curso,0,1) == substr($n_curso_ya,0,1) and (substr($n_curso_ya,0,1) == "1") and $cargo == '1') {$repite_1bach = "1";}
		if (substr($curso,0,1) == substr($n_curso_ya,0,1) and (substr($n_curso_ya,0,1) == "2") and $cargo == '1') {$repite_2bach = "1";}
		?>

		<!-- DATOS PERSONALES DEL ALUMNO -->
		<tr>
			<th class="active text-center text-uppercase" colspan="4">Datos
			personales del alumno o alumna</th>
		</tr>
		<tr>
			<td class="col-sm-3">
			<div
				class="form-group <?php echo (strstr($vacios,"apellidos, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="apellidos">Apellidos</label> <input type="text"
				class="form-control" id="apellidos" name="apellidos"
				value="<?php echo (isset($apellidos)) ? $apellidos : ''; ?>"
				maxlength="60"></div>
			</td>
			<td class="col-sm-3">
			<div
				class="form-group <?php echo (strstr($vacios,"nombre, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="nombre">Nombre</label> <input type="text"
				class="form-control" id="nombre" name="nombre"
				value="<?php echo (isset($nombre)) ? $nombre : ''; ?>"
				maxlength="30"></div>
			</td>
			<td class="col-sm-3">
			<div
				class="form-group <?php echo (strstr($vacios,"nacimiento, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="nacimiento">Fecha de nacimiento</label> <input
				type="text" class="form-control" id="nacimiento" name="nacimiento"
				value="<?php echo (isset($nacimiento)) ? $nacimiento : ''; ?>"
				maxlength="11" data-date-format="DD-MM-YYYY"
				data-date-viewmode="years"></div>
			</td>
			<td class="col-sm-3">
			<div
				class="form-group <?php echo (strstr($vacios,"dni, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="dni">DNI / Pasaporte o equivalente</label> <input
				type="text" class="form-control" id="dni" name="dni"
				value="<?php echo (isset($dni)) ? $dni : ''; ?>" maxlength="10"></div>
			</td>
		</tr>
		<tr>
			<td class="col-sm-3">
			<div
				class="form-group <?php echo (strstr($vacios,"nacionalidad, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="nacionalidad">Nacionalidad</label> <input type="text"
				class="form-control" id="nacionalidad" name="nacionalidad"
				value="<?php echo (isset($nacionalidad)) ? $nacionalidad : ''; ?>"
				maxlength="30"></div>
			</td>
			<td>
			<div
				class="form-group <?php echo (strstr($vacios,"nacido, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="nacido">Nacido en</label> <input type="text"
				class="form-control" id="nacido" name="nacido"
				value="<?php echo (isset($nacido)) ? $nacido : ''; ?>"
				maxlength="30"></div>
			</td>
			<td>
			<div
				class="form-group <?php echo (strstr($vacios,"provincia, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="provincia">Provincia</label> <input type="text"
				class="form-control" id="provincia" name="provincia"
				value="<?php echo (isset($provincia)) ? $provincia : ''; ?>"
				maxlength="30"></div>
			</td>
			<td>
			<p><strong>Sexo</strong></p>
			<div class="form-inline">
			<div
				class="form-group <?php echo (strstr($vacios,"sexo, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="sexo"
				value="hombre"
				<?php echo (isset($sexo) && $sexo == 'hombre' || $sexo == 'H') ? 'checked' : ''; ?>>
			&nbsp;Hombre </label></div>
			</div>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<div
				class="form-group <?php echo (strstr($vacios,"sexo, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="sexo"
				value="mujer"
				<?php echo (isset($sexo) && $sexo == 'mujer' || $sexo == 'M') ? 'checked' : ''; ?>>
			&nbsp;Mujer </label></div>
			</div>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<div
				class="form-group <?php echo (strstr($vacios,"domicilio, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="domicilio">Domicilio, calle, plaza o avenida y número</label>
			<input type="text" class="form-control" id="domicilio"
				name="domicilio"
				value="<?php echo (isset($domicilio)) ? $domicilio : ''; ?>"
				maxlength="60"></div>
			</td>
			<td>
			<div
				class="form-group <?php echo (strstr($vacios,"localidad, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="localidad">Municipio / Localidad</label> <input
				type="text" class="form-control" id="localidad" name="localidad"
				value="<?php echo (isset($localidad)) ? $localidad : ''; ?>"
				maxlength="30"></div>
			</td>
			<td>
			<div class="form-group"><label for="hermanos">Nº de hermanos</label>
			<input type="number" class="form-control" id="hermanos"
				name="hermanos"
				value="<?php echo (isset($hermanos)) ? $hermanos : '0'; ?>" min="0"
				max="99" maxlength="2"></div>
			</td>
		</tr>
		<tr>
			<td>
			<div
				class="form-group <?php echo (strstr($vacios,"telefono1, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="telefono1">Teléfono</label> <input type="text"
				class="form-control" id="telefono1" name="telefono1"
				value="<?php echo (isset($telefono1)) ? $telefono1 : ''; ?>"
				maxlength="9"></div>
			</td>
			<td>
			<div
				class="form-group <?php echo (strstr($vacios,"telefono2, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="telefono2">Teléfono urgencias</label> <input type="text"
				class="form-control" id="telefono2" name="telefono2"
				value="<?php echo (isset($telefono2)) ? $telefono2 : ''; ?>"
				maxlength="9"></div>
			</td>
			<td>
			<div class="form-group"><label for="correo">Correo electrónico</label>
			<input type="text" class="form-control" id="correo" name="correo"
				value="<?php echo (isset($correo)) ? $correo : ''; ?>"
				maxlength="120"></div>
			</td>
			<td rowspan="2">
<div
				class="form-group <?php echo (strstr($vacios,"colegio, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="colegio">Centro de procedencia</label> <select
				class="form-control" id="colegio" name="colegio">
				<?php if($curso == "1BACH"): 
				$cole_1=mysqli_query($db_con,"select distinct colegio from alma_secundaria order by colegio");
				?>
				<option value="<?php echo (isset($colegio)) ? $colegio : ''; ?>"><?php echo (isset($colegio)) ? $colegio : ''; ?></option>
				<?php while ($centros_adscritos=mysqli_fetch_array($cole_1)): ?>
				<option value="<?php echo $centros_adscritos[0]; ?>"
				<?php echo (isset($colegio) && $colegio == $centros_adscritos[0]) ? 'selected' : ''; ?>><?php echo $centros_adscritos[0]; ?></option>
				<?php endwhile; ?>
				<?php else: ?>
				<option value="<?php echo $config['centro_denominacion']; ?>"><?php echo $config['centro_denominacion']; ?></option>
				<?php endif; ?>
				<option value="Otro Centro">Otro Centro</option>
			</select></div>
			
			<div id="form-otrocolegio"
				class="form-group <?php echo (isset($otrocolegio) && !empty($otrocolegio)) ? '' : 'hidden'; ?>">
			<label for="otrocolegio">Centro educativo</label> <input type="text"
				class="form-control" id="otrocolegio" name="otrocolegio"
				value="<?php echo (isset($otrocolegio)) ? $otrocolegio : ''; ?>"
				maxlength="60" placeholder="Escribe aquí el nombre del Centro"> <input
				type="hidden" name="letra_grupo"
				value="<?php echo (isset($letra_grupo)) ? $letra_grupo : ''; ?>"></div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<p class="help-block"><small>El centro podrá enviar comunicaciones
			vía SMS si proporciona el número de un teléfono móvil o por correo
			electrónico.</small></p>
			</td>
		</tr>
		<!-- DATOS DE LOS REPRESENTANTES O GUARDADORES LEGALES -->
		<tr>
			<th class="active text-center text-uppercase" colspan="4">Datos de
			los representantes o guardadores legales</th>
		</tr>
		<tr>
			<td colspan="3">
			<div
				class="form-group <?php echo (strstr($vacios,"padre, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="padre">Apellidos y nombre del representante o guardador
			legal 1 <br><small class="text-muted">(con quien conviva el alumno/a y tenga atribuida su
			guarda y custodia)</small></label> <input type="text"
				class="form-control" id="padre" name="padre"
				value="<?php echo (isset($padre)) ? $padre : ''; ?>" maxlength="60">
			</div>
			</td>
			<td>
			<div
				class="form-group <?php echo (strstr($vacios,"dnitutor, ")==TRUE) ? 'has-error' : ''; ?>">
			<label for="dnitutor">DNI / NIE</label> <input type="text"
				class="form-control" id="dnitutor" name="dnitutor"
				value="<?php echo (isset($dnitutor)) ? $dnitutor : ''; ?>"
				maxlength="10"></div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<div class="form-group"><label for="madre">Apellidos y nombre del
			representante o guardador legal 2</label> <input type="text"
				class="form-control" id="madre" name="madre"
				value="<?php echo (isset($madre)) ? $madre : ''; ?>" maxlength="60">
			</div>
			</td>
			<td>
			<div
				class="form-group <?php echo ((isset($madre) && !empty($madre)) && (isset($dnitutor2) && empty($dnitutor2))) ? 'has-error' : ''; ?>">
			<label for="dnitutor2">DNI / NIE</label> <input type="text"
				class="form-control" id="dnitutor2" name="dnitutor2"
				value="<?php echo (isset($dnitutor2)) ? $dnitutor2 : ''; ?>"
				maxlength="10"></div>
			</td>
		</tr>

		<?php if($config['mod_transporte_escolar']): ?>
		<!-- TRANSPORTE ESCOLAR -->
		<tr>
			<th class="active text-center text-uppercase" colspan="4">Solicitud
			de transporte escolar</th>
		</tr>
		<tr>
			<td class="text-center" colspan="4">
			<div class="form-inline">

			<div class="form-group"><label for="ruta_este">Ruta Este:</label> <select
				class="form-control" id="ruta_este" name="ruta_este">
				<option value=""></option>
				<?php for ($i = 0; $i < count($transporte_este); $i++): ?>
				<option value="<?php echo $transporte_este[$i]['id']; ?>"
				<?php echo (isset($ruta_este) && $ruta_este == $transporte_este[$i]['id']) ? 'selected' : ''; ?>><?php echo $transporte_este[$i]['nombre']; ?></option>
				<?php endfor; ?>
			</select></div>

			&nbsp;&nbsp;&nbsp;&nbsp;

			<div class="form-group"><label for="ruta_oeste">Ruta Oeste:</label> <select
				class="form-control" id="ruta_oeste" name="ruta_oeste">
				<option value=""></option>
				<?php for ($i = 0; $i < count($transporte_oeste); $i++): ?>
				<option value="<?php echo $transporte_oeste[$i]['id']; ?>"
				<?php echo (isset($ruta_oeste) && $ruta_oeste == $transporte_oeste[$i]['id']) ? 'selected' : ''; ?>><?php echo $transporte_oeste[$i]['nombre']; ?></option>
				<?php endfor; ?>
			</select></div>

			</div>
			</td>
		</tr>
		<?php endif; ?>

		<!-- PRIMER IDIOMA Y RELIGION O ALTERNATIVA -->
		<tr>
			<th class="active text-center text-uppercase"
			<?php echo ($curso != 1) ? ' colspan="2"' : '' ?>>Primer idioma
			extranjero</th>
			<?php if ($curso == 1): ?>
			<th class="active text-center text-uppercase">Segundo idioma
			extranjero</th>
			<?php endif ?>
			<th class="active text-center text-uppercase" colspan="2">Opción de
			enseñanza de religión o alternativa<br>
			<small>(señale una)</small></th>
		</tr>
		<tr>
			<td <?php echo ($curso != 1) ? ' colspan="2"' : '' ?>>
			<div class="form-group"><select class="form-control" id="idioma1"
				name="idioma1">
				<?php $result = mysqli_query($db_con, "SELECT combasi FROM alma WHERE claveal='$claveal'"); ?>
				<?php $row = mysqli_fetch_array($result); ?>
				<?php $exp_combasi = explode(':', $row['combasi']); ?>
				<?php foreach ($combasi as $codasi): ?>
				<?php $result1 = mysqli_query($db_con, "SELECT abrev, nombre FROM asignaturas WHERE codigo='$codasi' AND (abrev = 'ING' OR abrev = 'FRA')"); ?>
				<?php $row1 = mysqli_fetch_array($result1); ?>
				<?php if (!(empty($row1['nombre'])) && $n_curso=="2"): ?>
				<?php $idio = 1; ?>
				<?php $id_1b = $row1['nombre']; ?>
				<option value="<?php echo $row1['nombre']; ?>"><?php echo $row1['nombre']; ?></option>
				<?php endif; ?>
				<?php endforeach; ?>
				<?php if ($idio<>1 || $cargo=="1"): ?>
				<option value="Inglés"
				<?php echo (isset($idioma1) && $idioma1 == 'Inglés') ? 'selected' : ''; ?>>Inglés</option>
				<option value="Francés"
				<?php echo (isset($idioma1) && $idioma1 == 'Francés') ? 'selected' : ''; ?>>Francés</option>
				<?php endif; ?>
			</select> <?php if (isset($idio) && $idio): ?> <small
				class="help-block">(El Idioma de 2º de Bachillerato debe ser el
			mismo que el Idioma de 1º de Bachillerato. Para otras opciones,
			consulta en Jefatura de Estudios.)</small> <?php endif; ?></div>
			</td>
			<?php if ($curso == 1): ?>
			<td>
			<div class="form-group"><select class="form-control" id="idioma2"
				name="idioma2">
				<option value="Francés"
				<?php echo (isset($idioma2) && $idioma2 == 'Francés') ? 'selected' : ''; ?>>Francés</option>
				<option value="Alemán"
				<?php echo (isset($idioma2) && $idioma2 == 'Alemán') ? 'selected' : ''; ?>>Alemán</option>
				<option value="Inglés"
				<?php echo (isset($idioma2) && $idioma2 == 'Inglés') ? 'selected' : ''; ?>>Inglés</option>
			</select></div>
			</td>
			<?php endif; ?>
			<td style="border-right: 0;">
			<div
				class="form-group <?php echo (strstr($vacios,"religion, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="religion"
				value="Religión Catolica"
				<?php if($religion == 'Religión Catolica'){echo "checked";} ?>>
			Religión Catolica </label></div>
			</div>

			<div
				class="form-group <?php echo (strstr($vacios,"religion, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="religion"
				value="Religión Islámica"
				<?php if($religion == 'Religión Islámica'){echo "checked";} ?>>
			Religión Islámica </label></div>
			</div>

			<div
				class="form-group <?php echo (strstr($vacios,"religion, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="religion"
				value="Religión Judía"
				<?php if($religion == 'Religión Judía'){echo "checked";} ?>>
			Religión Judía </label></div>
			</div>
			</td>
			<td>
			<div
				class="form-group <?php echo (strstr($vacios,"religion, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="religion"
				value="Religión Evangélica"
				<?php if($religion == 'Religión Evangélica'){echo "checked";} ?>>
			Religión Evangélica </label></div>
			</div>
			<?php if ($curso == 1): ?>
			<div
				class="form-group <?php echo (strstr($vacios,"religion, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="religion"
				value="Cultura Científica"
				<?php if($religion == 'Cultura Científica'){echo "checked";} ?>>
			Cultura Científica </label></div>
			</div>
			<?php endif; ?>
			<div
				class="form-group <?php echo (strstr($vacios,"religion, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio" name="religion"
				value="Valores Éticos"
				<?php if($religion == 'Valores Éticos'){echo "checked";} ?>>
			<?php if($n_curso == 1){?>Educación para la Ciudadanía y los Derechos Humanos<?php } else { ?>Atención Educativa<?php } ?> </label></div>
			</div>
			</td>
		</tr>


		<!-- ASIGNATURAS DE MODALIDAD Y OPTATIVAS -->
		<tr>
			<th class="active text-center text-uppercase" colspan="4">Modalidad y
			asignaturas optativas de <?php echo $curso_matricula; ?> de
			Bachillerato</th>
		</tr>

		<!-- ASIGNATURAS DE MODALIDAD Y OPTATIVAS EN PRIMERO DE BACHILLERATO opt11-->
		<?php if($curso == "1BACH"): ?>
		<tr>
		<?php foreach ($it1 as $n_it1=>$itiner1){ ?>
			<td class="text-center" >
			<strong>
			<div class="radio" id='it1'>
			<label> <input required type="radio" name="mod1" value="<?php echo $n_it1; ?>" <?php echo ($itinerario1 == $n_it1) ? 'checked' : ''; ?> /><strong><?php echo $itiner1; ?></strong></label>
			</div>
			</strong>
			</td>
			<?php } ?>
		</tr>
		<tr>
		<?php for ($i = 1; $i <= 3; $i++){ ?>
		
		<?php if ($i<3) {?>
		<td>
		<?php if ($i==1) { echo "<p>Matemáticas<br>Física y Química<br>Dibujo Técnico</p>";}elseif($i==2){echo "<p>Matemáticas<br>Física y Química<br>Biología y Geología</p>";}?>
		<div class="form-group">
		<select class="form-control" name="optativa1<?php echo $i;?>"  <?php if(stristr($vacios,"optativas de modalidad de 1B")==TRUE and $mod1 == $i){echo 'style="background-color:#FFFF66;"';}?>>
		<option></option>
		<?php foreach (${opt1.$i} as $optit_1 => $nombre){ ?>
				<option value="<?php echo $optit_1; ?>"
				<?php echo (isset($optativa1) && $optativa1 == $optit_1) ? 'selected' : ''; ?>><?php echo $nombre; ?></option>

				
		<?php }?>
		</select>
		</div>
		</td>		
		<?php } else {?>
		<td colspan="2">
		<?php if ($itinerario1>2) { $extra_opt1 = ''; } else{$extra_opt1 = 'style="visibility:hidden" disabled';}?>
			<p id='p-it1' >Historia del Mundo Contemporáneo</p>
			<div class="form-group">
			<select class="form-control" name="optativa13"  <?php if(stristr($vacios,"optativas de modalidad de 1B")==TRUE and $mod1 > 2){echo 'style="background-color:#FFFF66;"';}?>>
		<?php foreach (${opt1.$i} as $optit_1 => $nombre){ ?> ?>		

				<option value="<?php echo $optit_1; ?>"
				<?php echo (isset($optativa1) && $optativa1 == $optit_1) ? 'selected' : ''; ?>><?php echo $nombre; ?></option>
				<?php }?>
				</select>
				</div>
		</td>
		
		<?php }?>
		<?php }?>
	
		</tr>
		<?php endif;?>

		<!-- ASIGNATURAS DE MODALIDAD Y OPTATIVAS EN SEGUNDO DE BACHILLERATO -->
		<?php if ($curso == "2BACH"): ?>

		<?php
		if (empty($curso_largo)) {
			$cl = mysqli_query($db_con, "select curso from alma where claveal='$claveal'");
			$cl0 = mysqli_fetch_array($cl);
			$curso_largo = $cl0[0];
		}
		?>
		<tr>
		<?php for ($i = 1; $i <= 2; $i++): ?>
			<td class="text-center" colspan="2"><strong><?php echo ${it2.$i}[0]; ?></strong>
			</td>
			<?php endfor; ?>
		</tr>
		<tr>
		<?php for ($i = 1; $i <= 2; $i++): ?>
			<td colspan="2"><?php $num1 = 3; ?> <?php $num_it = count(${opt2.$i}); ?>
			<?php foreach (${opt2.$i} as $optit_1 => $nombre): ?> <?php $num1 += 1; ?>
			<?php if (${optativa.$num1}=="0") {${optativa.$num1}="";} ?>
			<div
				class="form-group <?php echo (strstr($vacios,"modalidad de 2, ")==TRUE) ? 'has-error' : ''; ?>">
			<div class="radio"><label> <input type="radio"
				value="<?php echo $optit_1; ?>" name="mod2"
				<?php echo ($optativa2 == $optit_1) ? 'checked' : ''; ?>
				<?php echo (strstr($curso_largo,${it2.$i}[3])==FALSE and !(empty($curso_largo)) and !($cargo=="1")) ? 'disabled' : '' ; ?>>
				<?php echo $nombre; ?> </label></div>
			</div>
			<?php endforeach; ?></td>
			<?php endfor; ?>
		</tr>

		<!-- OTRAS ASIGNATURAS OPTATIVAS DE SEGUNDO DE BACHILLERATO -->
		<tr>
			<th class="active text-center text-uppercase" colspan="4">Más
			asignaturas optativas de Segundo de Bachillerato<br>
			<p class="help-block"><small>(marca con 1, 2, 3, 4, etc. por orden de preferencia)</small></p>
			</th>
		</tr>
		<tr>
		<?php $num1 = ""; ?>
		<?php foreach ($opt23 as $optit_1 => $nombre): ?>
		<?php $num1 += 1; ?>
		<?php if ($num1==1 or $num1==4 or $num1==7 or $num1==10): ?>
			<td style="border-right: 0;">
			<div class="form-horizontal"><?php endif; ?>

			<div
				class="form-group <?php echo (isset($opt_rep) && $opt_rep == 1) ? 'has-error"' : '' ; ?>">
			<div class="col-sm-4"><select class="form-control"
				id="'<?php echo $optit_1; ?>" name="<?php echo $optit_1; ?>" required>
				<option value=""></option>
				<?php for ($z = 1; $z < 11; $z++): ?>
				<option value="<?php echo $z; ?>"
				<?php echo ((strlen(${optativa2b.$num1})>0) && ${optativa2b.$num1} == $z) ? 'selected' : ''; ?>><?php echo $z; ?></option>
				<?php endfor; ?>
			</select></div>
			<label class="col-sm-8 control-label">
			<div class="text-left"><?php echo $nombre; ?></div>
			</label></div>

			<?php if ($num1==3 or $num1==6 or $num1==9): ?></div>
			</td>
			<?php endif; ?>
			<?php endforeach; ?>
		</tr>

		<?php if ($repetidor <> 1): ?>

		<!-- ASIGNATURAS OPTATIVAS DE PRIMERO DE BACHILLERATO -->
		
		<tr id="no_repite1">
			<th class="active text-center text-uppercase" colspan="4">
			Opciones de matriculación en 1º de Bachillerato<p class="help-block"><small>
			(Para solicitar una modalidad o vía diferente a la que ya has
			cursado debes pasar por Jefatura de Estudios)</small></p></th>
		</tr>
		<tr>
	<td colspan="4">
	<div class="form-group">
	<div class="checkbox"><label> <input type="checkbox" name="bilinguismo"
		value="Si" <?php if($bilinguismo == 'Si'){echo "checked";} ?>> El
	alumno/a solicita participar en el programa de bilingüismo (Inglés) en 1º de BACHILLERATO </label></div>
	</div>
	</td>
</tr>
<tr>
<tr>
	<td style="background-color: #eee;" colspan="4">
	<strong>Religión, Educación para la Ciudadanía o Cultura Científica</strong>
	</td>
</tr>
<tr>
		
			<td colspan="4">
			
			
			<table style="width: 100%; border: none; <?php if(stristr($vacios,"religion o alternativa de 1BACH")==TRUE) {echo 'background-color: #FFFF66;'; } ?>">
			<tr>
				<td valign=top style="border: none;width:50%">
				<input type="radio" name="religion1b" value="Religión Catolica"
					style="margin: 2px 2px"
		<?php if($religion1b == 'Religión Catolica'){echo "checked";} ?> required />
				Religi&oacute;n Cat&oacute;lica<br />
				<input type="radio"
					name="religion1b" value="Religión Islámica" style="margin: 2px 2px"
		<?php if($religion1b == 'Religión Islámica'){echo "checked";} ?>  required />
				Religi&oacute;n Isl&aacute;mica<br />
				<input type="radio" name="religion1b" value="Religión Judía"
					style="margin: 2px 2px"
		<?php if($religion1b == 'Religión Judía'){echo "checked";} ?>  required />
				Religi&oacute;n Jud&iacute;a
				</td>
				<td valign=top style="border: none"><input type="radio"
					name="religion1b" value="Religión Evangélica" style="margin: 2px 2px"
		<?php if($religion1b == 'Religión Evangélica'){echo "checked";} ?>  required />

				Religi&oacute;n Evang&eacute;lica<br />
				<input type="radio" name="religion1b" value="Cultura Científica"
					style="margin: 2px 2px"
		<?php if($religion1b == 'Cultura Científica'){echo "checked";} ?>  required />
				Cultura Científica<br />
				<input type="radio" name="religion1b" value="Valores Éticos"
					style="margin: 2px 2px"
		<?php if($religion1b == 'Valores Éticos'){echo "checked";} ?>  required />
				Educación para la Ciudadanía y los Derechos Humanos </td>
			</tr>
		</table>
			
			</td>
			
		</tr>


		<tr>
		<tr>
	<td style="background-color: #eee;" colspan="4">
	<strong>Modalidades y Optativas de 1º Bachillerato</strong>
	</td>
</tr>
		<?php foreach ($it1 as $n_it1=>$itiner1){ ?>
			<td class="text-center" >
			<strong>
			<div class="radio" id='it1'>
			<label> <input required type="radio" name="mod1" value="<?php echo $n_it1; ?>" <?php echo ($itinerario1 == $n_it1) ? 'checked' : ''; ?> /><strong><?php echo $itiner1; ?></strong></label>
			</div>
			</strong>
			</td>
			<?php } ?>
		</tr>
		<tr>
		<?php for ($i = 1; $i <= 3; $i++){ ?>
		
		<?php if ($i<3) {?>
		<td>
		<?php if ($i==1) { echo "<p>Matemáticas<br>Física y Química<br>Dibujo Técnico</p>";}elseif($i==2){echo "<p>Matemáticas<br>Física y Química<br>Biología y Geología</p>";}?>
		<div class="form-group">
		<select class="form-control" name="optativa1<?php echo $i;?>"  <?php if(stristr($vacios,"optativas de modalidad de 1B")==TRUE and $mod1 == $i){echo 'style="background-color:#FFFF66;"';}?>>
		<option></option>
		<?php foreach (${opt1.$i} as $optit_1 => $nombre){ ?>
				<option value="<?php echo $optit_1; ?>"
				<?php echo (isset($optativa1) && $optativa1 == $optit_1) ? 'selected' : ''; ?>><?php echo $nombre; ?></option>

				
		<?php }?>
		</select>
		</div>
		</td>		
		<?php } else {?>
		<td colspan="2">
		<?php if ($itinerario1>2) { $extra_opt1 = ''; } else{$extra_opt1 = 'style="visibility:hidden" disabled';}?>
			<p id='p-it1' >Historia del Mundo Contemporáneo</p>
			<div class="form-group">
			<select class="form-control" name="optativa13"  <?php if(stristr($vacios,"optativas de modalidad de 1B")==TRUE and $mod1 > 2){echo 'style="background-color:#FFFF66;"';}?>>
		<?php foreach (${opt1.$i} as $optit_1 => $nombre){ ?> ?>		

				<option value="<?php echo $optit_1; ?>"
				<?php echo (isset($optativa1) && $optativa1 == $optit_1) ? 'selected' : ''; ?>><?php echo $nombre; ?></option>
				<?php }?>
				</select>
				</div>
		</td>
		
		<?php }?>
		<?php }?>
	
		</tr>
		
		<?php endif; ?>

		<?php endif; ?>
		
		<!-- BILINGÜISMO -->
		<?php if(substr($curso, 0, 1) < 2): ?>
		<tr>
			<td colspan="4">
			<div class="form-group">
			<div class="checkbox"><label> <input type="checkbox"
				name="bilinguismo" value="Si"
				<?php if($bilinguismo == 'Si'){echo "checked";} ?>> El alumno/a
			solicita participar en el programa de bilingüismo (Inglés) </label></div>
			</div>
			</td>
		</tr>
		<?php endif; ?>
		<!-- ENFERMEDADES -->
		<tr>
			<th class="active text-center" colspan="4"><span class="text-uppercase">Enfermedades del Alumno:</span><p class="help-block"><small>
			Señalar si el alumno tiene alguna enfermedad que es importante que el
			Centro conozca por poder afectar a la vida académica del alumno.</small></p></th>
		</tr>
		<tr>
			<td colspan="2" style="border-top: 0;">
			<p class="help-block"><small>
			Señalar si el alumno tiene alguna enfermedad que es importante que el Centro conozca por poder afectar a la vida académica del alumno.</small></p>
		<div
				class="form-group col-sm-5">
			<label for="enfermedad">Enfermedades del Alumno</label>					 
			<select
				class="form-control" id="enfermedad" name="enfermedad">
			<option value=""></option>	
				<?php for ($i = 0; $i < count($enfermedades); $i++): ?>
				<option value="<?php echo $enfermedades[$i]['id']; ?>"
				<?php echo (isset($enfermedad) && $enfermedad == $enfermedades[$i]['id']) ? 'selected' : ''; ?>><?php echo $enfermedades[$i]['nombre']; ?></option>
				<?php endfor; ?>
				<option value="Otra enfermedad"<?php echo (isset($enfermedad) && $enfermedad == "Otra enfermedad") ? 'selected' : ''; ?>>Otra enfermedad</option>
			</select></div>
			
			<div id="form-otraenfermedad"
				class="form-group <?php echo (isset($otraenfermedad) && !empty($otraenfermedad)) ? '' : 'hidden'; ?> col-sm-7">
			<label for="otraenfermedad">Otras enfermedades</label>
			<input type="text"
				class="form-control" id="otraenfermedad" name="otraenfermedad"
				value="<?php echo (isset($otraenfermedad)) ? $otraenfermedad : ''; ?>"
				maxlength="60" placeholder="Escribe aquí el nombre de la enfermedad"> 
				</div>
			</td>

		<!-- DIVORCIOS -->			
			<td colspan="2" style="border-top: 0;">
			<p class="help-block"><small>
			Señalar si el alumno procede de padres divorciados y cual es la situación legal de la Guardia y Custodia respecto al mismo.</small></p>
		<div
				class="form-group col-sm-10">
			<label for="divorcio">Alumno con padres divorciados</label>					 
			<select
				class="form-control" id="divorcio" name="divorcio">
			<option value=""></option>	
				<?php for ($i = 0; $i < count($divorciados); $i++): ?>
				<option value="<?php echo $divorciados[$i]['id']; ?>"
				<?php echo (isset($divorcio) && $divorcio == $divorciados[$i]['id']) ? 'selected' : ''; ?>><?php echo $divorciados[$i]['nombre']; ?></option>
				<?php endfor; ?>
			</select>
			</div>
			</td>
		</tr>
		
		<!-- FOTO -->
		<tr>
			<th class="active text-center" colspan="4"><span class="text-uppercase">Foto del Alumno:</span><p class="help-block"><small>
			Desmarcar si la familia tiene algún inconveniente en que se publiquen en nuestra web fotografías del alumno por motivos educativos (Actividaes Complementarias y Extraescolares, etc.)</small></p></th>
		</tr>
		<tr>
			<td colspan="4" style="border-top: 0;">
		<div
				class="checkbox">
			<label for="foto"> 
			<?php if ($foto==1 or $foto=="") { $extra_foto = "checked";	} else {$extra_foto="";} ?>
			<input	type="checkbox" name = "foto"  id="foto" value = "1" <?php echo $extra_foto;?>>
			 Foto del Alumno </label>
			</div>
			</td>
		</tr>
		
		<!-- OBSERVACIONES -->
		<tr>
			<th class="active text-center" colspan="4"><span class="text-uppercase">Observaciones:</span><p class="help-block"><small>
			Indique aquellas cuestiones que considere sean importantes para
			conocimiento del Centro</small></p></th>
		</tr>
		<tr>
			<td colspan="4" style="border-top: 0;"><textarea class="form-control"
				id="observaciones" name="observaciones" rows="5"><?php echo (isset($observaciones)) ? $observaciones : ''; ?></textarea>
			</td>
		</tr>

	</tbody>
</table>


<!-- CAMPOS OCULTOS Y ENVIO DE FORMULARIO -->
<div class="text-center" colspan="4"><input type="hidden" name="curso"
	value="<?php echo (isset($curso)) ? $curso : ''; ?>"> <input
	type="hidden" name="nuevo"
	value="<?php echo (isset($nuevo)) ? $nuevo : ''; ?>"> <input
	type="hidden" name="curso_matricula"
	value="<?php echo (isset($curso_matricula)) ? $curso_matricula : ''; ?>">
<input type="hidden" name="claveal"
	value="<?php echo (isset($claveal)) ? $claveal : ''; ?>"> <input
	type="hidden" name="repetidor"
	value="<?php echo (isset($repetidor)) ? $repetidor : ''; ?>">

<button type="submit" class="btn btn-primary" name="enviar">Guardar
cambios</button>
<button type="reset" class="btn btn-default">Cancelar</button>
</div>

</form>

				<?php
}
else{ ?> <?php if($dni == '' || $dnitutor == ''): ?>
<div class="alert alert-danger">Debes introducir el DNI / Pasaporte o
equivalente del alumno/a o tutor legal que solicita la matriculación en
este centro.</div>
<?php endif; ?> <?php if($curso == ''): ?>
<div class="alert alert-danger">Debes seleccionar el curso del alumno/a
que solicita la matriculación en este centro.</div>
<?php endif; ?> <?php
}
?></div>
<!-- /.container -->

<?php include("../../pie.php"); ?>

<script>
	$(function ()  
	{ 
		$('#nacimiento').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  
	
	$(document).ready(function() {
			
		// Selector de Enfermedad
		$('#enfermedad').change(function() {
				if($('#enfermedad').val() == 'Otra enfermedad') {
					$('#form-otraenfermedad').removeClass('hidden');
				}
				else {
					$('#form-otraenfermedad').addClass('hidden');
				}
			});
		
		// Selector de colegio
		$('#colegio').change(function() {
			if($('#colegio').val() == 'Otro Centro') {
				$('#form-otrocolegio').removeClass('hidden');
			}
			else {
				$('#form-otrocolegio').addClass('hidden');
			}
		});
	});
	</script>

</body>
</html>
