<?php
require('../../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
$PLUGIN_DATATABLES = 1;
include("../../../menu.php"); 
?>
	
	<div class="container">
	
	<?php
	if($_SERVER['SERVER_NAME'] == 'iesantoniomachado.es' || $_SERVER['SERVER_NAME'] == 'iesbahiamarbella.es') {
		$query_accesos = mysqli_query($db_con, "SELECT rp.claveal, COUNT(*) AS accesos FROM reg_principal AS rp GROUP BY claveal, pagina HAVING pagina='/alumnos/login.php' ORDER BY claveal ASC");
	}
	else {
		$query_accesos = mysqli_query($db_con, "SELECT rp.claveal, COUNT(*) AS accesos FROM reg_principal AS rp GROUP BY claveal, pagina HAVING pagina='/notas/control.php' ORDER BY claveal ASC");
	}
	?>
		
		<!-- TITULO DE LA PAGINA -->
		
		<div class="page-header">
			<h2 class="page-title" align="center">Informe de accesos de alumnos a la Intranet</h2>
		</div>
		
		
		<!-- CONTENIDO DE LA PAGINA -->
		
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
			
			    <div class="no_imprimir">
			      <a href="../../index.php" class="btn btn-default">Volver</a>
			      <a href="#" class="btn btn-primary" onclick="print()"><i class="fa fa-print"></i> Imprimir</a>
			      <br><br>
			    </div>
				
				<table class="table table-bordered table-condensed table-striped datatable">
					<thead>
						<tr>
							<th>Alumno/a</th>
							<th>Unidad</th>
							<th>Total accesos</th>
							<th>Fecha último acceso</th>
						</tr>
					</thead>
					<tbody>
					  <?php 
					  while ($row = mysqli_fetch_object($query_accesos)):
					  	
					  	$subquery = mysqli_query($db_con, "SELECT CONCAT(apellidos,', ',nombre) AS alumno, unidad FROM alma WHERE claveal=$row->claveal LIMIT 1");
					  	$datos = mysqli_fetch_object($subquery);
					  	mysqli_free_result($subquery);
					  	
					  	$subquery2 = mysqli_query($db_con, "SELECT fecha FROM reg_principal WHERE claveal=$row->claveal ORDER BY fecha DESC LIMIT 1");
					  	$fecha = mysqli_fetch_object($subquery2);
					  	mysqli_free_result($subquery2);
					  	
					  	if($datos->alumno != "" && $datos->unidad != ""):
					  ?>
					  	<tr>
					  		<td><?php echo $datos->alumno; ?></td>
								<td><?php echo $datos->unidad; ?></td>
					  		<td><?php echo $row->accesos; ?></td>
								<td><?php echo $fecha->fecha; ?></td>
					  	</tr>
					  <?php 
					  	endif;
					  endwhile;
					  mysqli_free_result($query_accesos);
					  ?>
					</tbody>
				</table>
				
			</div><!-- /.col-sm-12 -->
		</div><!-- /.row -->
	  
	</div><!-- /.container -->
	
	<br>

<?php include('../../../pie.php'); ?>

	<script>
	$(document).ready(function() {
		var table = $('.datatable').DataTable({
			"paging":   true,
	    "ordering": true,
	    "info":     false,
	    
			"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
			
			"order": [[ 3, "desc" ]],
			
			"language": {
			            "lengthMenu": "_MENU_",
			            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
			            "info": "Página _PAGE_ de _PAGES_",
			            "infoEmpty": "No hay resultados disponibles.",
			            "infoFiltered": "(filtrado de _MAX_ resultados)",
			            "search": "Buscar: ",
			            "paginate": {
			                  "first": "Primera",
			                  "next": "Última",
			                  "next": "",
			                  "previous": ""
			                }
			        }
		});
	});
	</script>
	
</body>
</html>