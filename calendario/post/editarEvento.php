<?php
require('../../bootstrap.php');

$GLOBALS['db_con'] = $db_con;


if (! isset($_POST['cmp_nombre'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

// Limpiamos variables
$id_evento = mysqli_real_escape_string($db_con, $_POST['cmp_evento_id']);
$fechadiacomp_evento = mysqli_real_escape_string($db_con, $_POST['cmp_fecha_diacomp']);
$nombre_evento = mysqli_real_escape_string($db_con, $_POST['cmp_nombre']);
$fechaini_evento = mysqli_real_escape_string($db_con, $_POST['cmp_fecha_ini']);
$horaini_evento = mysqli_real_escape_string($db_con, $_POST['cmp_hora_ini']);
$fechafin_evento = mysqli_real_escape_string($db_con, $_POST['cmp_fecha_fin']);
$horafin_evento = mysqli_real_escape_string($db_con, $_POST['cmp_hora_fin']);
$descripcion_evento = mysqli_real_escape_string($db_con, $_POST['cmp_descripcion']);
$lugar_evento = mysqli_real_escape_string($db_con, $_POST['cmp_lugar']);
$calendario_evento = mysqli_real_escape_string($db_con, $_POST['cmp_calendario']);
$unidad_asignatura_evento = $_POST['cmp_unidad_asignatura'];
$departamento_evento = mysqli_real_escape_string($db_con, $_POST['cmp_departamento']);
$profesores_evento = $_POST['cmp_profesores'];
$observaciones_evento = $_POST['cmp_observaciones'];
$unidades_evento = $_POST['cmp_unidades'];
$profesorreg_evento = mysqli_real_escape_string($db_con, $_SESSION['ide']);
$fechareg_evento = date('Y-m-d');

// Limpiamos espacios innecesarios
$nombre_evento = trim($nombre_evento);
$fechaini_evento = trim($fechaini_evento);
$horaini_evento = trim($horaini_evento);
$fechafin_evento = trim($fechafin_evento);
$horafin_evento = trim($horafin_evento);
$descripcion_evento = trim($descripcion_evento);
$observaciones_evento = trim($observaciones_evento);
$lugar_evento = trim($lugar_evento);


if ($fechadiacomp_evento == '') $fechadiacomp_evento = 0;
else $fechadiacomp_evento = 1;

if ($fechadiacomp_evento) {
	$exp_fechaini_evento = explode('/', $fechaini_evento);
	$fechaini_evento_sql = $exp_fechaini_evento[2].'-'.$exp_fechaini_evento[1].'-'.$exp_fechaini_evento[0];
	
	$fechafin_evento_sql = $fechaini_evento_sql;
	$horaini_evento = '00:00:00';
	$horafin_evento = '00:00:00';
}
else {
	$exp_fechaini_evento = explode('/', $fechaini_evento);
	$fechaini_evento_sql = $exp_fechaini_evento[2].'-'.$exp_fechaini_evento[1].'-'.$exp_fechaini_evento[0];
	
	$exp_fechafin_evento = explode('/', $fechafin_evento);
	$fechafin_evento_sql = $exp_fechafin_evento[2].'-'.$exp_fechafin_evento[1].'-'.$exp_fechafin_evento[0];
}


// Declaramos las variables para los tipos de calendario
$string_departamento = "";
$string_profesores = "";
$string_unidad = "";
$string_asignatura = "";

// Es una actividad extraescolar
if ($calendario_evento == 2) {
	
	$string_departamento = $departamento_evento;
	
	if (is_array($profesores_evento)) {
	
		foreach ($profesores_evento as $profesor) {
			$string_profesores .= mysqli_real_escape_string($db_con, $profesor).'; ';
		}
		
		$string_profesores = trim($string_profesores);
	}
	
	if (is_array($unidades_evento)) {
	
		foreach ($unidades_evento as $unidad) {
			$string_unidad .= mysqli_real_escape_string($db_con, $unidad).'; ';
		}
		
		$string_unidad = trim($string_unidad);
	}
}
// Pertenece al diario del profesor
elseif ($calendario_evento != 2 && $calendario_evento != 1) {
	
	if (is_array($unidad_asignatura_evento)) {
		
		foreach ($unidad_asignatura_evento as $unidad) {
			$exp_unidad = explode(' => ', $unidad);
			$string_unidad .= mysqli_real_escape_string($db_con, $exp_unidad[0]).'; ';
			$string_asignatura .= mysqli_real_escape_string($db_con, $exp_unidad[1]).'; ';
		}
		
		$string_unidad = trim($string_unidad);
		$string_asignatura = trim($string_asignatura);
	}
}


// Comprobamos si existe el evento
$result = mysqli_query($db_con, "SELECT nombre FROM calendario WHERE id=$id_evento LIMIT 1");

if (! mysqli_num_rows($result)) {
	header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&msg=ErrorEventoNoExiste');
	exit();
}
else {
	$editar = mysqli_query($db_con, "UPDATE calendario SET categoria='$calendario_evento', nombre='$nombre_evento', descripcion='$descripcion_evento', fechaini='$fechaini_evento_sql', horaini='$horaini_evento', fechafin='$fechafin_evento_sql', horafin='$horafin_evento', lugar='$lugar_evento', departamento='$string_departamento', profesores='$string_profesores', unidades='$string_unidad', asignaturas='$string_asignatura', fechareg='$fechareg_evento', profesorreg='$profesorreg_evento', observaciones='$observaciones_evento' WHERE id=$id_evento") or die (mysqli_error($db_con));
	if (! $editar) {
		header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&msg=ErrorEventoEdicion');
		exit();
	}
	else {
		header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'');
		exit();
	}
}
?>