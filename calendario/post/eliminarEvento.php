<?php
require('../../bootstrap.php');

$GLOBALS['db_con'] = $db_con;


if (! isset($_POST['cmp_evento_id'])) {
	die("<h1>FORBIDDEN</h1>");
	exit();
}

$evento_id = mysqli_escape_string($db_con, $_POST['cmp_evento_id']);

$result = mysqli_query($db_con, "DELETE FROM calendario WHERE id=$evento_id");
if (! $result) {
	header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&msg=ErrorEliminarEvento');
	exit();
}
else {
	header('Location:'.'http://'.$config['dominio'].'/intranet/calendario/index.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'');
	exit();
}
?>