<?php
require('../../bootstrap.php');

$GLOBALS['db_con'] = $db_con;


if (! isset($_POST['cmp_calendario_id'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

// Limpiamos variables
$id_calendario = mysqli_real_escape_string($db_con, $_POST['cmp_calendario_id']);
$nombre_calendario = mysqli_real_escape_string($db_con, $_POST['cmp_calendario_nombre']);
$color_calendario = mysqli_real_escape_string($db_con, $_POST['cmp_calendario_color']);
$profesor_calendario = mysqli_real_escape_string($db_con, $_SESSION['ide']);
$publico_calendario = mysqli_real_escape_string($db_con, $_POST['cmp_calendario_publico']);


// Eliminamos espacios innecesarios
$nombre_calendario = trim($nombre_calendario);
$color_calendario = trim($color_calendario);


if ($publico_calendario == '') $publico_calendario = 0;
else $publico_calendario = 1;

// Comprobamos si existe el calendario
$result = mysqli_query($db_con, "SELECT nombre FROM calendario_categorias WHERE id='$id_calendario' AND profesor='$profesor_calendario' LIMIT 1");

if (mysqli_num_rows($result)) {
	header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&msg=ErrorCalendarioNoExiste');
	exit();
}
else {
	$editar = mysqli_query($db_con, "UPDATE calendario_categorias SET nombre='$nombre_calendario', color='$color_calendario', espublico='$publico_calendario' WHERE id='$id_calendario'");
	if (! $editar) {
		header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&ErrorCalendarioEdicion');
		exit();
	}
	else {
		header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'');
		exit();
	}
}
?>