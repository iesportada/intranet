<?php
require('../bootstrap.php');


$pr = $_SESSION['profi'];

include("../menu.php");
?>
<div class='container'>
<div class='row'>
<br>
<?php
 echo "<br /><div align='center' class='page-header'>";
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
echo "<h2 class='no_imprimir'>Cuaderno de Notas&nbsp;&nbsp;<small> Crear nueva columna de datos</small></h2>";
echo "</div><br />";
echo '<div align="center">';
$curso = $_GET['curso'];

 foreach($_POST as $key => $val)
	{
		${$key} = $val;
	}
	
echo "<p class='lead'>$curso <span class='muted'>( $nom_asig )</span></p>";	
if(empty($nombre)){
	echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes escribir al menos un Nombre para la Columna del cuaderno que estás creando.
</div></div>';
echo '<br /><div align="center"><input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-primary"></div>';
exit;
}
// Nueva Columna

if (!$visible_nota) $visible_nota = 0;

$fecha = date('Y-m-d');
// Si hay datos, actualizamos
if(strlen($id) > 0){
$sql = "UPDATE  notas_cuaderno set nombre='$nombre', texto='$texto', visible_nota='$visible_nota', Tipo = '$tipo', color='$color' where id = '$id'";
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han modificado correctamente.          
</div></div>';
}
else{
	$serie = mysqli_query($db_con, "select max(orden) from notas_cuaderno where profesor = '$pr' and curso = '$curso_nota' and asignatura = '$asignatura'");
	$num_col = mysqli_fetch_array($serie);
	$orden = $num_col[0] + 1;
	// Si no, insertamos
$sql = "INSERT INTO  notas_cuaderno ( profesor ,  fecha ,  nombre ,  texto ,  asignatura, curso, orden, visible_nota, Tipo, color ) 
VALUES ( '$pr',  '$fecha',  '$nombre',  '$texto',  '$asignatura', '$curso_nota', '$orden', '$visible_nota', '$tipo', '$color')";
//echo $sql;
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La nueva columna ha sido añadida a la tabla del Cuaderno.
</div></div>';
}
mysqli_query($db_con, $sql) or die (mysqli_error($db_con));
mysqli_close();
echo $mens10;
?>

<BR>
</div>
</div>
</div>
<script language="javascript">
<?php 
// Redireccionamos al Cuaderno    
$mens = "../cuaderno.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curso&clave=$clave";
?>
setTimeout("window.location='<?php echo $mens; ?>'", 1000) 
</script>
</body>
</html>
