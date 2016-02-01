<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
$PLUGIN_DATATABLES = 1;
include("../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Alumnos mayores de 18 años hoy (<?php echo date('d-m-Y'); ?>)</small></h2>
	</div>
		
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-8 col-sm-offset-2">
		<br>
		<table class="table table-striped table-bordered datatable">
		<thead><tr><th>Alumno</th><th>Fecha de Nacimiento</th><th>Curso</th></tr></thead>
		
			<?php
			$hoy = date('Y-m-d',strtotime('-18 year'));
			$result = mysqli_query($db_con, "SELECT apellidos, nombre, nacimiento, CONCAT( curso, '-', grupo_actual ) FROM matriculas_bach where date(nacimiento) < '$hoy' order by apellidos, nombre, curso, grupo_actual");
			
			if (mysqli_num_rows($result)>0) {
				while($my = mysqli_fetch_array($result)){
					echo "<tr><td nowrap>$my[0], $my[1]</td><td nowrap>$my[2]</td><td nowrap>$my[3]</td></tr>";
				}
			}
			else{
				echo '<br><div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Esta página sólo funciona si el Módulo de Matriculación está operativo y la tabla de matrículas de los alumnos de Bachillerato contiene datos. La tabla en cuestión no contiene datos por lo que parece que el módulo no está operativo. No podemos presentar los datos solicitados.
</div></div><br>';
			}
		
			?>
			</table>	
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  	  "paging":   true,
	      "ordering": true,
	      "info":     false,
	      
			"lengthMenu": [[300, 35, 50, -1], [15, 35, 50, "Todos"]],  		
	  		
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
