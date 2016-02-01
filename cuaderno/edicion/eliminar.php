<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

// Procesamos los datos
 foreach ($_POST as $id => $valor) {
// Condiciones para procesar los datos
  		if (is_numeric($id)){
  		mysqli_query($db_con, "delete from notas_cuaderno where id = '$id'") or die ("<br>No ha sido posible eliminar la columna.<br>Ponte en contacto con quien lo entienda.");
  		$n_1 = mysqli_affected_rows($db_con);
  		mysqli_query($db_con, "delete from datos where id = '$id'") or die ("<br>No se han podido eliminar las notas_cuaderno asociadas a la columna<br>Ponte en contacto con quien lo entienda.");
  	}	
	}		
	if (empty($n_1)) {
		echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar al menos una Columna del cuaderno para poder operar.
</div></div>';
 echo "<br /><INPUT TYPE='button' VALUE='Volver al Cuaderno' onClick='history.back(-1)' class='btn btn-primary'>";			
		}
		else {	
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La columna ha sido eliminada correctamente.
</div></div>';// Redireccionamos al Cuaderno    
$mens = "../cuaderno.php?profesor=$profesor&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curso&clave=$clave";
?>
<script>
setTimeout("window.location='<?php echo $mens; ?>'", 1000) 
</script>
<?php
		}
?>.