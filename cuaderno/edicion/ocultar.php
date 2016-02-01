<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<div align="center">
<?php
//$ocultar = $_POST['ocultar'];
// Procesamos los datos
 foreach ($_POST as $id => $valor) {
// Condiciones para procesar los datos
  		if (is_numeric($id) and is_numeric($valor)){  			
  		$actual = mysqli_query($db_con, "update notas_cuaderno set oculto = '$ocultar' where id = '$id'") or die ("<br>No ha sido posible eliminar la columna.<br>Ponte en contacto con quien lo entienda.");
  		$n_1 = mysqli_affected_rows($actual);
  	}	
	}		

		if($ocultar == "1"){$ms = "ocultada";}else{$ms = "restaurada";}
		echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La Nota ha sido ';
 echo $ms;
 echo ' correctamente.</div></div>';
 echo "<br /><INPUT TYPE='button' VALUE='Volver al Cuaderno' onClick='history.back(-1)' class='btn btn-primary'>";	
 
// Redireccionamos al Cuaderno    
$mens = "../cuaderno.php?profesor=$profesor&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curso&clave=$clave";
?>
<script>
setTimeout("window.location='<?php echo $mens; ?>'", 1000) 
</script>
<?php

?></div>