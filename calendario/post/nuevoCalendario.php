<?php
require('../../bootstrap.php');

$GLOBALS['db_con'] = $db_con;


if (! isset($_POST['cmp_calendario_nombre'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

// Limpiamos variables
$nombre_calendario = mysqli_real_escape_string($db_con, $_POST['cmp_calendario_nombre']);
$color_calendario = mysqli_real_escape_string($db_con, $_POST['cmp_calendario_color']);
$fecha_calendario = date('Y-m-d');
$profesor_calendario = mysqli_real_escape_string($db_con, $_SESSION['ide']);
$publico_calendario = mysqli_real_escape_string($db_con, $_POST['cmp_calendario_publico']);


// Eliminamos espacios innecesarios
$nombre_calendario = trim($nombre_calendario);
$color_calendario = trim($color_calendario);


if ($publico_calendario == '') $publico_calendario = 0;
else $publico_calendario = 1;


// Comprobamos si existe el calendario
$result = mysqli_query($db_con, "SELECT nombre FROM calendario_categorias WHERE nombre='$nombre_calendario' AND profesor='$profesor_calendario' LIMIT 1");

if (mysqli_num_rows($result)) {
	header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&msg=ErrorCalendarioExiste');
	exit();
}
else {
	$crear = mysqli_query($db_con, "INSERT INTO calendario_categorias (nombre, fecha, profesor, color, espublico) VALUES ('$nombre_calendario', '$fecha_calendario', '$profesor_calendario', '$color_calendario', $publico_calendario)");
	if (! $crear) {
		header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&msg=ErrorCalendarioInsertar');
		exit();
	}
	else {
		header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'');
		exit();
	}
}
?>