<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
  ?>
 <div class="container">
  <div class="page-header">
  <h2>Información sobre Guardias <small> Datos y Estadísticas</small></h2>
</div>
<div class="row">
<div class="well well-larfe" style="width:750px;margin:auto">
<p class="block-help">
<legend class=" text-warning" align="center">Aclaraciones sobre los datos presentados sobre las Guardias.</legend>
<ul class=" text-info">
<li>Las Guardias de Pasillo presentan las guardias de pasillo totales registradas en el Horario en Séneca. Quedan excluidas las guardias de Biblioteca, las guardias en el Aula de Convivencia y las guardias de Recreo. Si el profesor tiene además guardias de recreo, aparece un asterisco azul moradito; si el profesor tiene guardias de Biblioteca, aparece un asterisco verde; y si el profesor tiene guardias de Convivencia, aparece un asterisco naranja.</li>
<li>Las Guardias de Biblioteca, Aula de Convivencia y Recreo aparecen en tablas específicas para cada grupo.</li>
<li>Las Guardias en el Aula se refieren a las sustituciones realizadas por los profesores de guardia hasta la fecha. En letra gris aparece el número de guardias asignadas en horario para cada profesor.</li>
</ul>
</p>
</div>
<hr />
<br />
<?php

$profes_tot = mysqli_query($db_con, "select distinct prof from horw");
$profes_total = mysqli_num_rows($profes_tot);

$sql = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE c_asig =  '25'
GROUP BY prof
ORDER BY  `prof` ASC ";

$sql_gu = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE (c_asig = '25' or c_asig = '353')
GROUP BY prof
ORDER BY  `num` ASC ";

$sql_bib = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE c_asig = '26'
GROUP BY prof
ORDER BY  `prof` ASC ";

$sql_conv = "SELECT DISTINCT prof, COUNT( * ) AS num
FROM  `horw` 
WHERE a_asig LIKE  'GUC%'
GROUP BY prof
ORDER BY  `prof` ASC ";

$sql_reg = "SELECT DISTINCT profesor, COUNT( * ) AS numero
FROM  `guardias` where profesor not like ''
GROUP BY profesor
ORDER BY  `numero` ASC ";

$sql_rec = "SELECT prof, count(*) as numero
FROM  `horw` where prof not like '' and hora = 'R' and c_asig = '353'
group by prof ORDER BY  prof ASC";
?>

<div class="col-sm-4">
<legend align="center" class="text-info">Guardias de Pasillo</legend>
<table class="table table-striped table-bordered datatable" align="center">
<thead>
<th>
Profesor
</th>
<th>
#
</th>
</thead>
<?php
$query = mysqli_query($db_con, $sql);
while ($arr = mysqli_fetch_array($query)) {
	
	$bibl="";
	$convi=""; 
	$recr="";	
	
	$biblio = mysqli_query($db_con, "select * from horw where prof = '$arr[0]' and a_asig like 'GUB%'");
	$conviven = mysqli_query($db_con, "select * from horw where prof = '$arr[0]' and a_asig like 'GUC%'");
	$recreo = mysqli_query($db_con, "select * from recreo where profesor = '$arr[0]'");
	
	if (mysqli_num_rows($biblio)>0) { $bibl =  "<span class='text-success' style='font-size:18px'>*</span>";}
	if (mysqli_num_rows($conviven)>0) {$convi =  "<span class='text-warning' style='font-size:18px'>*</span>";}
	if (mysqli_num_rows($recreo)>0) { $recr =  "<span class='text-info' style='font-size:18px'>*</span>";}
	
	echo "<tr><td>".nomprofesor($arr[0])."</td><td class='col-sm-2'>$arr[1]  $bibl $convi $recr</td></tr>";
	$num_gu+=$arr[1];
	$num_prof+=1;
}
echo "</table>";
$media = substr($num_gu/$num_prof,0,3);

echo '<br /><table class="table table-striped table-bordered" align="center">';
echo "<tr><td class='text-info'><strong>Profesores con Guardias</strong></td><td nowrap class='text-warning'><strong>$num_prof <span class='muted'>($profes_total)</span></strong></td></tr>";
echo "<tr><td class='text-info'><strong>Número de Guardias en total</strong></td><td class='text-warning'><strong>$num_gu</strong></td></tr>";
echo "<tr><td class='text-info'><strong>Media de Guardias por Profesor</strong></td><td class='text-warning'><strong>$media</strong></td></tr>";
echo "</table>";
?>
</div>

<div class="col-sm-4">
<legend align="center" class="text-info">Guardias de Biblioteca</legend>
<table class="table table-striped table-bordered" align="center">
<thead>
<th>
Profesor
</th>
<th>
#
</th>
</thead>
<?php
$query_bib = mysqli_query($db_con, $sql_bib);
while ($arr_bib = mysqli_fetch_array($query_bib)) {
	
	echo "<tr><td>".nomprofesor($arr_bib[0])."</td><td class='col-sm-2'>$arr_bib[1]</td></tr>";
}
echo "</table>";
?>
<br />
<hr />
<legend align="center" class="text-info">Guardias de Convivencia</legend>
<table class="table table-striped table-bordered" align="center">
<thead>
<th>
Profesor
</th>
<th>
#
</th>
</thead>
<?php
$query_conv = mysqli_query($db_con, $sql_conv);
while ($arr_conv = mysqli_fetch_array($query_conv)) {
	echo "<tr><td>".nomprofesor($arr_conv[0])."</td><td class='col-sm-2'>$arr_conv[1]</td></tr>";
}
echo "</table>";
?>

<br />
<hr />
<legend align="center" class="text-info">Guardias de Recreo</legend>
<table class="table table-striped table-bordered" align="center">
<thead>
<th>
Profesor
</th>
<th>
#
</th>
</thead>
<?php
$query_rec = mysqli_query($db_con, $sql_rec);
while ($arr_rec = mysqli_fetch_array($query_rec)) {
	echo "<tr><td>".nomprofesor($arr_rec[0])."</td><td class='col-sm-2'>$arr_rec[1]</td></tr>";
}
echo "</table>";
?>

</div>

<div class="col-sm-4">
<legend align="center" class="text-info">Guardias en las Aulas</legend>
<table class="table table-striped table-bordered datatable">
<thead>
<th>
Profesor
</th>
<th>
#
</th>
<th>
#
</th>
</thead>
<?php
$query_reg = mysqli_query($db_con, $sql_reg);
while ($arr_reg = mysqli_fetch_array($query_reg)) {
	
$sql1 = mysqli_query($db_con, "SELECT prof
FROM  `horw` 
WHERE c_asig = '25' and prof = '$arr_reg[0]'");
$num_gu = mysqli_num_rows($sql1);	

echo "<tr><td>".nomprofesor($arr_reg[0])."</td><td class='col-sm-2' nowrap>$arr_reg[1] </td><td class='col-sm-2 text-muted' nowrap>$num_gu</td></tr>";

$num_gureg+=$arr_reg[1];
$num_profreg+=1;
}
echo "</table>";

	
echo "</table>";
$media_reg = substr($num_gureg/$num_profreg,0,4);

echo '<br /><table class="table table-striped table-bordered" align="center">';
echo "<tr><td class='text-info'><strong>Guardias totales en Aulas</strong></td><td class='text-warning'><strong>$num_gureg</strong></td></tr>";
echo "<tr><td class='text-info'><strong>Media de Guardias por Profesor</strong></td><td class='text-warning'><strong>$media_reg</strong></td></tr>";
echo "</table>";
?>

</div>

</div>
</div>
<?php
include("../../pie.php");
?>

	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  		"paging":   true,
	      "ordering": true,
	      "info":     false,
	      
	  		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
	  		
	  		"order": [[ 0, "asc" ]],
	  		
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
