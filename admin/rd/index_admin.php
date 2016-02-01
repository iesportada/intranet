<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profesor = $_SESSION ['profi'];

// PLUGINS
$PLUGIN_DATATABLES = 1;

include ("../../menu.php");
include ("menu.php");
/*
if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección del Centro";
}*/
echo '<div align="center">';
  echo '<div class="page-header">
  <h2>Actas del Departamento <small> Todos los Registros</small></h2>
</div>
<br />';
?>
<table class="table table-bordered" style="width:auto">

<?php
$n_col=0;
$n_fila=0;
$dep0 = mysqli_query($db_con, "select distinct departamentos.departamento from departamentos where departamentos.departamento in (select distinct r_departamento.departamento from r_departamento) order by departamentos.departamento");
while ($dep = mysqli_fetch_array($dep0)) {
	
$departamento = $dep[0];
if (!($pag)) {
	$pag = "";
}
if($pag == "") {$pag = "0";} else {$pag = $pag + 100;}
$query = "SELECT id, fecha, departamento, contenido, impreso, numero FROM r_departamento where departamento = '$departamento' ORDER BY fecha desc limit $pag,50";
$result = mysqli_query($db_con, $query) or die ("Error in query: $query. " . mysqli_error($db_con));
$n_actas = mysqli_num_rows($result);

if($n_col%4==0) {
	echo "<tr>";
	$n_filas++;
}

$n_col++;
?>
<td valign="top">
<p class="lead text-info" align="center"><?php echo $departamento;?></p>
	<TABLE class="table table-striped table-bordered datatable">
		<thead><th>#</th><th>Fecha</th><th>Opc.</th></thead>
	
<?	while($row = mysqli_fetch_object($result))
	{
	?>
      <TR> 
        <TD nowrap><?php echo $row->numero; ?></td> 
		<TD nowrap><?php echo fecha_sin($row->fecha); ?></td>        
        <TD nowrap>
        <?php
	if(($row->departamento == $_SESSION['dpt']) or (strstr($_SESSION['cargo'],"1") == TRUE)){	
		?>
<a href="story.php?id=<?php echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="fa fa-search" data-bs="tooltip" title='Ver el Acta'> </i></a> 
<a href="pdf.php?id=<?php echo $row->id; ?>&imprimir=1"  style="color:#990000;margin-right:10px;"> <i class="fa fa-print" data-bs="tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>
<?php 
if ($row->impreso == '0') {
?>
<i class="fa fa-exclamation-triangle" data-bs="tooltip" title='El Acta aún no ha sido imprimida.'> </i>
<?php
}
else{
?>
<i class="fa fa-check" data-bs="tooltip" title='El Acta ya ha sido imprimida.'> </i>
<?php
}
?>
</td>
<?php
		}
		?>
      </tr>
	<?php
	}
	echo "</TABLE>";
}
?>
</td>
<?php
if($n_actas < ($n_col * $n_filas)) echo '<td></td>';
if($n_col%4==0) echo "</tr>";

echo "</table>";
?>
<br />
<!--<form action="pdf.php" method="POST">
<input type="submit" name="imp_todas" value="Imprimir actas no impresas" class="btn btn-primary">
</form>
--></div>
<?php
include("../../pie.php");
?>
<script>  
	$(document).ready(function() {
		var table = $('.datatable').DataTable({
		"paging":   true,
	    "ordering": false,
	    "info":     false,
	    "searching":   false,
	    
			"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
			
			"order": [[ 0, "desc" ]],
			
			"language": {
			            "lengthMenu": "_MENU_",
			            "zeroRecords": "Sin resultados.",
			            "info": "Página _PAGE_ de _PAGES_",
			            "infoEmpty": "No hay resultados disponibles.",
			            "infoFiltered": "(filtrado de _MAX_ resultados)",
			            "paginate": {
			                  "first": "Primera",
			                  "next": "Última",
			                  "next": "",
			                  "previous": "",
			                }
			        }
		});
	});
	</script>
	
</body>
</html>
