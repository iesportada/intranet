<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 'c'));

$PLUGIN_DATATABLES = 1;
include("../../menu.php");
include("menu.php");
	
?>
<script>
function seleccionar_todo(){
	for (i=0;i<document.form1.elements.length;i++)
		if(document.form1.elements[i].type == "checkbox")	
			document.form1.elements[i].checked=1
}
</script>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
	  <h2>Biblioteca <small>Gestión de los Préstamos</small></h1>
		<h3 class="text-info">Lista de morosos</small></h3>
	</div>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
	<!-- COLUMNA CENTRAL -->
  <div class="col-sm-12">
  <form name="form1" action="edicion.php" method="post">
<table class='table table-striped datatable'>
	<thead>
		<tr>		
		<th  style="width:60px"><a onClick="seleccionar_todo()" data-bs="tooltip" title="Seleccionar todos."><i class="fa fa-lg fa-check-square-o"> </i></a></th>
		<th style="width:100px">Código</th>
		<th style="width:100px">Grupo</th>
		<th>Alumno</th>
		<th>Título</th>
		<th nowrap style="width:150px">Fecha dev.</th>
		<th></th>
		</tr>	
	</thead>
	<tbody>
	<?php
	$fecha_act = date('Y-m-d');
	$lista=mysqli_query($db_con, "select curso, apellidos, nombre, ejemplar, devolucion, amonestacion, id, sms from morosos order by devolucion, apellidos asc");

	$n=0;
	while ($list=mysqli_fetch_array($lista)){
		
	?>
	<tr>
	<?php 	
		$n+=1   
	?>
		<td style="text-align: center"><input type="checkbox" name="id[]" value="<?php echo $list[6]; ?>" /></td>
		<td style="text-align: center"><?php echo $list[6]; ?></td>
		<td style="text-align: center"><?php echo $list[0]; ?></td>
		<td><?php echo $list[1].', '.$list[2]; ?></td>
		<td><?php echo $list[3]; ?></td>
		<td nowrap style="text-align: center"><?php echo $list[4]; ?></td>
		<td style="text-align: left" nowrap>
		<?php
		if ($list[7] == "SI") {
			echo '<span class="fa fa-comment fa-fw fa-lg" data-bs="tooltip" title="Se ha enviado SMS de advertencia"></span>';
		}
		if ($list[5]=='SI') {
			echo '<span class="fa fa-bolt fa-fw fa-lg" data-bs="tooltip" title="Se ha regsitrado una amonestación"></span>';
		}
		?>
		</td>

	</tr>
	<?	
	}
	?>
	</tbody>
</table>

<hr>
<button type="submit" class="btn btn-danger" name="borrar" value="Borrar"><span class="fa fa-trash-o fa-fw"></span> Borrar</button>
<button type="submit" class="btn btn-info" name="sms" value="sms"><span class="fa fa-mobile fa-fw"></span> Enviar SMS</button>
<button type="submit" class="btn btn-warning" name="registro" value="registro"><span class="fa fa-gavel fa-fw"></span> Registrar Amonestaciones</button>
<a href="lpdf.php" class="btn btn-primary" target="_blank">Listado en PDF</a>
</form>
</div>
</div>
</div>

<?php include("../../pie.php");?>
	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  	  "paging":   true,
	      "ordering": true,
	      "info":     false,
	      
			"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
	  		
	  		"order": [[ 1, "asc" ]],
	  		
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
	<script>
	function selectall(form) {  
	 var formulario = eval(form)  
	 for (var i=0, len=formulario.elements.length; i<len ; i++)  
	  {  
	    if ( formulario.elements[i].type == "checkbox" )  
	      formulario.elements[i].checked = formulario.elements[0].checked  
	  }  
	}  
	</script>  

</body>
</html>
