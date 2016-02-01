<?php
require('../../bootstrap.php');


if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = 'disabled'; }

include("../../menu.php");
include("menu.php");


$query = "SELECT id, contenido, fecha, numero, departamento FROM r_departamento WHERE id = '$id'";
$result = mysqli_query($db_con, $query) or die ("Error en la Consulta: $query. " . mysqli_error($db_con));
if (mysqli_num_rows($result) > 0)
{
	$row = mysqli_fetch_object($result);
}
 
if ($row)
{
?>
<div class="container">

	<div class="page-header">
	  <h2>Actas del Departamento <small>Registro de Reuniones (<?php echo $row->departamento; ?>)</small></h2>
	</div>

	<div class="row">
		<div class="col-sm-12">
			
			<object type="application/pdf" data="pdf.php?id=<?php echo $row->id; ?>" width="100%" height="500" style="border: 1px solid #dedede;"></object>
			
			<div class="clearfix"></div>
			
			<br>
			
			<div class="hidden-print">
				<a href="pdf.php?id=<?php echo $id; ?>&imprimir=1" class="btn btn-primary">Imprimir</a>
				<a href="add.php" class="btn btn-default">Volver</a>
			</div>
			
 		</div>
 	</div>

</div>

<?php
}
else
{
?>

<div class="container">

	<div class="page-header">
	  <h2>Actas del Departamento <small> Contenido de la Reunión ( <?php  echo $row->departamento;?> )</small></h2>
	</div>

	<div class="container">
	
		<div class="row">
			
			<div class="col-sm-4 col-sm-offset-4">
				
				<div class="alert alert-danger alert-block fade in">
		            <button type="button" class="close" data-dismiss="alert">&times;</button>
		            <h4>ATENCIÓN:</h4>No tiene permiso o no se encuentra el acta en la base de datos.
          		</div>
          	</div>
        </div>
     </div>
</div>

<?php
}
?>

<?php include("../../pie.php");?>
</body>
</html>