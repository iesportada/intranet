<?php
if (isset($_POST['impresion'])) {
foreach($_POST as $key => $val)
{
	$vars.="$key=$val&";
}
$vars=substr($vars,0,-1);
	header('Location:'.'edicion/impresion.php?'.$vars.'');
	exit();
}
if (isset($_POST['edicion'])) {
foreach($_POST as $key => $val)
{
	if (is_numeric($key)) {
		$vars.="id=$key&";;
	}
	$vars.="$key=$val&";
}
$vars=substr($vars,0,-1);
	header('Location:'.'c_nota.php?'.$vars.'');
	exit();
}

require('../bootstrap.php');


include("../menu.php");
include("menu.php");
// Titulo
echo "<div class='container'><div class='row'>";
echo "<br /><div class='page-header'>";
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
echo "<h2 class='hidden-print'>Cuaderno de Notas&nbsp;&nbsp;<small> Operaciones con los datos</small></h2>";
echo "</div>";
echo '<div align="center">';

foreach($_POST as $key => $val)
{
	${$key} = $val;
}
echo "<h3><span class='label label-info' style='padding:8px'>".rtrim($curso, ', ')." -- $nom_asig </span></h3><br>";

// Procesamos los datos
if ($eliminar) {
	include("edicion/eliminar.php");

}
elseif ($ocultar) {
	$ocultar = "1";
	include("edicion/ocultar.php");

}
elseif ($mostrar) {
	$ocultar = "0";
	include("edicion/ocultar.php");
	exit;
}
elseif ($media) {
	include("edicion/calcular.php");
}
elseif ($recalcula) {
	include("edicion/calcular_pond.php");
}
elseif ($pondera) {
	include("edicion/calcular_pond.php");
}
elseif ($media_pond2) {
	include("edicion/calcular_pond.php");
}
echo $edicion;
?>
<?php
include("../pie.php")
?>
</body>
</html>
