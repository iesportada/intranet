<?php
if (version_compare(phpversion(), '5.3.0', '<')) die ("<h1>Versión de PHP incompatible</h1>\n<p>Necesita PHP 5.3.0 o superior para poder utilizar esta aplicación.</p>");

session_start();

// CONFIGURACIÓN INICIAL
error_reporting(0);
date_default_timezone_set('Europe/Madrid');
setlocale(LC_TIME, 'es_ES');


define('INTRANET_DIRECTORY', __DIR__);
define('CONFIG_FILE', INTRANET_DIRECTORY . '/config.php');
define('VERSION_FILE', INTRANET_DIRECTORY .'/config/version.php');

if (file_exists(CONFIG_FILE)) {
	
	$archivo = fopen(CONFIG_FILE, 'r'); 
	$num_lineas = 0; 
	
	while (!feof ($archivo)) { 
	    if ($linea = fgets($archivo)) $num_lineas++;
	} 
	fclose ($archivo); 
	
	if ($num_lineas > 78) {
		unlink(CONFIG_FILE);
		header('Location:'.'http://'.$_SERVER['SERVER_NAME'].'/intranet/config/index.php?update=1');
		exit;
	}
	
	include_once(CONFIG_FILE);
	if (file_exists(INTRANET_DIRECTORY . '/config_datos.php')) {
		include_once(INTRANET_DIRECTORY . '/config_datos.php');
	}
	include_once(VERSION_FILE);
	include_once(INTRANET_DIRECTORY . '/funciones.php');
	include_once(INTRANET_DIRECTORY . '/simplepie/autoloader.php');
}
else {
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$_SERVER['SERVER_NAME'].'/intranet/config/index.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$_SERVER['SERVER_NAME'].'/intranet/config/index.php');
		exit();
	}
	
}

// CONEXIÓN A LA BASE DE DATOS
$db_con = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']) or die("<h1>Error " . mysqli_connect_error() . "</h1>"); 


if($_SERVER['SCRIPT_NAME'] != '/intranet/login.php') {
	
	// COMPROBAMOS LA SESION
	if ($_SESSION['autentificado'] != 1) {
		$_SESSION = array();
		session_destroy();
		
		if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
			header('Location:'.'https://'.$config['dominio'].'/intranet/salir.php');
			exit();
		}
		else {
			header('Location:'.'http://'.$config['dominio'].'/intranet/salir.php');
			exit();
		}
	}
	else {
	
		if ((stristr($_SESSION['cargo'],'1') != TRUE) && (isset($config['mantenimiento']) && $config['mantenimiento'])) {
			if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
				header('Location:'.'https://'.$config['dominio'].'/intranet/mantenimiento.php');
				exit();
			}
			else {
				header('Location:'.'http://'.$config['dominio'].'/intranet/mantenimiento.php');
				exit();
			}
		}
		
	}
	
	if($_SERVER['SCRIPT_NAME'] != '/intranet/clave.php') {
		if($_SESSION['cambiar_clave']) {
			if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
				header('Location:'.'https://'.$config['dominio'].'/intranet/clave.php');
				exit();
			}
			else {
				header('Location:'.'http://'.$config['dominio'].'/intranet/clave.php');
				exit();
			}
		}
	}
	
	// REGISTRAMOS EL ACCESO A LA PAGINA
	registraPagina($db_con, $_SERVER['REQUEST_URI']);
	
	// VER COMO USUARIO
	
	// Es el Administrador de la Aplicación.
	if (($_SESSION['ide'] == 'admin') || (stristr($_SESSION['cargo'],'0') == TRUE)) {
		$_SESSION['user_admin'] = 1;
	}
			
	if(isset($_SESSION['user_admin']) && isset($_POST['view_as_user'])) {
		$_SESSION['profi'] = $_POST['view_as_user'];
		$profe = $_SESSION['profi'];
		
		// Variables de sesión del cargo del Profesor
		$cargo0 = mysqli_query($db_con, "select cargo, departamento, idea from departamentos where nombre = '$profe'" );
		$cargo1 = mysqli_fetch_array ( $cargo0 );
		$_SESSION['cargo'] = $cargo1 [0];
		$carg = $_SESSION['cargo'];
		$_SESSION['dpt'] = $cargo1 [1];
		if (isset($_POST['idea'])) {}
		else{
		$_SESSION['ide'] = $cargo1 [2];
		}
			
		// Si es tutor
		if (stristr($_SESSION['cargo'], '2') == TRUE) {
			$result = mysqli_query($db_con, "select distinct unidad from FTUTORES where tutor = '$profe'" );
			$row = mysqli_fetch_array ( $result );
			$_SESSION['mod_tutoria']['tutor'] = $profe;
			$_SESSION['mod_tutoria']['unidad'] = $row [0];
		}
	
		// Si tiene Horario
		$cur0 = mysqli_query($db_con, "SELECT distinct prof FROM horw where prof = '$profe'" );
		$cur1 = mysqli_num_rows ( $cur0 );
		$_SESSION['n_cursos'] = $cur1;
		
		// Si tiene tema personalizado
		$res = mysqli_query($db_con, "select distinct tema, fondo from temas where idea = '".$_SESSION['ide']."'" );
		if (mysqli_num_rows($res)>0) {
			$ro = mysqli_fetch_array ( $res );
			$_SESSION['tema'] = $ro[0];
			$_SESSION['fondo'] = $ro[1];
		}
		else{
			$_SESSION['tema']="bootstrap.min.css";
			$_SESSION['fondo'] = "navbar-default";
		}
		
	}

}

// Variable del cargo del Profesor
$pr = $_SESSION['profi']; // Nombre
$carg = $_SESSION['cargo']; // Perfil
$dpto = $_SESSION['dpt']; // Departamento
$idea = $_SESSION['ide']; // Usuario iDea de Séneca
$n_curso = $_SESSION['n_cursos']; // Tiene Horario