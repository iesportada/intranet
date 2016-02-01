<?php
  if(isset($_GET['todos']) and $_GET['todos'] == "1") { 
  $titulo = "Todos los Informes en este año escolar";
} else { 
  $titulo = "Informes que responden a los datos introducidos";
}
  if(isset($_GET['ver']) or isset($_POST['ver'])) { 
  $id = $llenar;
  include("infocompleto.php");
exit;}

  if(isset($_GET['meter']) or isset($_POST['meter'])) { 
  $id = $llenar;
  include("informar.php");
exit;
}

require('../../bootstrap.php');


$PLUGIN_DATATABLES = 1;

$profesor = $_SESSION['profi'];
include("../../menu.php");
include("menu.php");

if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];}else{$apellidos="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}

if (!(empty($unidad))) {
}
?>
<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tareas <small> Buscar Informes</small></h2>
</div>
<br>

<div class="col-md-10 col-md-offset-1">
<?php
// Consulta
 $query = "SELECT ID, CLAVEAL, APELLIDOS, NOMBRE, unidad, FECHA FROM tareas_alumnos WHERE 1=1 "; 
  if(!(empty($apellidos))) {$query .= "and apellidos like '%$apellidos%'";} 
  if(!(empty($nombre))) {$query .=  "and nombre like '%$nombre%'";} 
  if(!(empty($unidad))) {$query .=  "and unidad = '$unidad'";} 
  $query .=  " ORDER BY FECHA DESC";
//echo $query;
$result = mysqli_query($db_con, $query) or die ("Error in query: $query. " . mysqli_error($db_con));

echo "<table class='table table-striped table-bordered datatable' align='center'><thead>";
echo "<ter><th>Alumno/a </th>
<th>Curso</Th>
<Th>Fecha inicio</th><th>Sí</th><th>No</th><th></th><th></th></TR></thead><tbody>";
if (mysqli_num_rows($result) > 0)
{

	while($row = mysqli_fetch_object($result))
	{
	$si='';
	$no='';
	$nulo='';
		$t_si=mysqli_query($db_con, "select confirmado from tareas_profesor where confirmado = 'Si' and id_alumno = '$row->ID'");
		$t_no=mysqli_query($db_con, "select confirmado from tareas_profesor where confirmado = 'No' and id_alumno = '$row->ID'");
		$vacio=mysqli_query($db_con, "select confirmado from tareas_profesor where confirmado is NULL and id_alumno = '$row->ID'");
		$si = mysqli_num_rows($t_si);
		$no = mysqli_num_rows($t_no);
		$nulo = mysqli_num_rows($vacio);
		if ($nulo > 0){ $bola = "<i class='fa fa-check' title='confirmado' />"; } else{ $bola = "<i class='fa fa-exclamation-triangle' title='No confirmado' />"; }

   echo "<tr><td nowrap style='vertical-align:middle'>";
		$foto="";
		$foto = "<img src='../../xml/fotos/".$row->CLAVEAL.".jpg' width='55' height='64'  />";
		echo $foto."&nbsp;&nbsp;";	
   echo stripslashes($row->APELLIDOS)." ".stripslashes($row->NOMBRE)."</TD>
   <TD style='vertical-align:middle'>".stripslashes($row->unidad)."</TD>
   <TD style='vertical-align:middle'>$row->FECHA</TD><TD style='vertical-align:middle'>$si</TD><TD style='vertical-align:middle'>$no</TD><TD style='vertical-align:middle'>$bola</TD>";
   echo "<td style='vertical-align:middle'><div class='btn-group'><a href='infocompleto.php?id=$row->ID' class='btn btn-primary btn-mini'><i class='fa fa-search ' title='Ver Informe'> </i></a>";
   $result0 = mysqli_query($db_con, "select tutor from FTUTORES where unidad = '$row->unidad'" );
$row0 = mysqli_fetch_array ( $result0 );	
$tuti = $row0[0];
		 if (stristr($_SESSION ['cargo'],'1') == TRUE || nomprofesor($tuti) == nomprofesor($_SESSION['profi'])) {
   	   	echo "<a href='informar.php?id=$row->ID' class='btn btn-primary btn-mini'><i class='fa fa-pencil-square-o ' title='Rellenar Informe'> </i> </a>";
		echo "<a href='borrar_informe.php?id=$row->ID&del=1' class='btn btn-primary btn-mini' data-bb='confirm-delete'><i class='fa fa-trash-o ' title='Borrar Informe' > </i> </a> 	";
   }	
echo  '</div></td></tr>';
	}
echo "</tbody></table><br />";
}
// Si no hay datos
else
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No hay Informes de Tareas disponibles con esos criterios.</div></div><hr>';
?>
<?php
}
?>
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
				
				"order": [[ 2, "desc" ]],
				
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