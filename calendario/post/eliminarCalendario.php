<?php
require('../../bootstrap.php');

$GLOBALS['db_con'] = $db_con;


if (! isset($_POST['cmp_calendario_id'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

$calendario_id = mysqli_escape_string($db_con, $_POST['cmp_calendario_id']);

// Comprobamos si existen eventos y los eliminamos
$result = mysqli_query($db_con, "SELECT id FROM calendario WHERE categoria=$calendario_id");
while ($row = mysqli_fetch_assoc($result)) {
	mysqli_query($db_con, "DELETE FROM calendario WHERE id=".$row['id']." LIMIT 1");
}

$result = mysqli_query($db_con, "DELETE FROM calendario_categorias WHERE id=$calendario_id");
if (! $result) {
	header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&msg=ErrorEliminarCalendario');
	exit();
}
else {
	header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'');
	exit();
}
?>