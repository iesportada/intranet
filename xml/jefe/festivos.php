<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
?>
	<div class="container">
	
		<div class="page-header">
			<h2>Administración <small> Días festivos</small></h2>
		</div>
	
		<div id="status-loading" class="text-center">
			<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
		</div>
		
		<div id="wrap" class="row" style="display: none;">
		
			<div class="col-sm-8 col-sm-offset-2">
				<?php
				 
				// Borramos datos
				mysqli_query($db_con, "truncate table festivos");	
				
				// Importamos los datos del fichero CSV en la tabña alma.
				$handle = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die('
				<div align="center"><div class="alert alert-success alert-block fade in" align="left">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
				No se ha podido abrir el fichero de importación<br> Asegúrate de que su formato es correcto y no está vacío.
							</div></div><br />	'); 
				while (($data1 = fgetcsv($handle, 1000, "|")) !== FALSE) 
				{
				$tr = explode("/",trim($data1[0]));
				$fecha="$tr[2]-$tr[1]-$tr[0]";
				$datos1 = "INSERT INTO festivos ( `fecha` , `nombre` , `ambito` , `docentes` ) VALUES (\"". $fecha . "\",\"". trim($data1[1]) . "\",\"". trim($data1[2]) . "\",\"". trim($data1[3]) . "\")";
				mysqli_query($db_con, $datos1);
				}
				fclose($handle);
				$borrarvacios = "delete from festivos where date(fecha) = '0000-00-00'";
				 mysqli_query($db_con, $borrarvacios);
				 if (mysqli_affected_rows($db_con) > '0') {
				?>
 				<div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
					 Los datos se han importado correctamente.
				</div>
				
				<div class="text-center">
					<a href="../index.php" class="btn btn-primary">Volver a Administración</a>
				</div>
				<?php
				}
				?>
			</div><!-- /.col-sm-8 -->
		
		</div><!-- /.row -->
	
	</div><!-- /.container -->

	<?php include("../../pie.php");	?>
	
	<script>
	function espera() {
		document.getElementById("wrap").style.display = '';
		document.getElementById("status-loading").style.display = 'none';        
	}
	window.onload = espera;
	</script>

</body>
</html>