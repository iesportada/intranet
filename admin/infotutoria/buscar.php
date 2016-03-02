<?php
  if(isset($_GET['todos']) and $_GET['todos'] == "1") { 
  $titulo = "Todos los Informes en este año escolar";
} else { 
  $titulo = "Informes que responden a los datos introducidos";
}
  if(isset($_GET['ver']) or isset($_POST['ver'])) { 
  $id = $_GET['ver'];
  include("infocompleto.php");
exit;}
  if(isset($_GET['meter']) or isset($_POST['meter'])) { 
  $id = $_GET['llenar'];
  include("informar.php");
exit;
}

require('../../bootstrap.php');


$profesor = $_SESSION['profi'];



$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");
?>

<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>

<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tutoría <small> Buscar Informes</small></h2>
</div>
<br>

<div class="col-md-10 col-md-offset-1">

<?php
if (isset($_GET['validar'])) {$validar = $_GET['validar'];
if ($validar=='1') {
	mysqli_query($db_con, "update infotut_alumno set valido='0' where id = '$id'");
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido marcado como <b>NO VALIDADO</b> por el Tutor. Esto significa que el Informe no podrá ser visto por los Padres del Alumno desde la página pública del Centro
		</div></div>';
}
elseif ($validar=='0') {
	mysqli_query($db_con, "update infotut_alumno set valido='1' where id = '$id'");
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido marcado como <b>VALIDADO</b> por el Tutor. Esto significa que el Informe podrá ser visto por los Padres del Alumno desde la página pública del Centro
		</div></div>';
}
}
if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];}elseif (isset($_GET['apellidos'])) {$apellidos = $_GET['apellidos']; $extra.="&apellidos=$apellidos";}else{$apellidos="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}elseif (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];$extra.="&nombre=$nombre";}else{$nombre="";}
if (!(empty($unidad))) {
$grupo = $unidad;
$extra.="&unidad=$unidad";
}
// Consulta
 $query = "SELECT ID, CLAVEAL, APELLIDOS, NOMBRE, unidad, tutor, F_ENTREV, valido
  FROM infotut_alumno WHERE 1=1 "; 
  if(!(empty($apellidos))) {$query .= "and apellidos like '%$apellidos%'";} 
  if(!(empty($nombre))) {$query .=  "and nombre like '%$nombre%'";} 
  if(!(empty($unidad))) {$query .=  "and unidad = '$unidad'";} 
  $query .=  " ORDER BY F_ENTREV DESC";
$result = mysqli_query($db_con, $query) or die ("Error in query: $query. " . mysqli_error($db_con));

echo "<table class='table table-striped table-bordered datatable' align='center'><thead>";
echo "<th>Alumno</th>
<th>Curso</th>
<th>Cita</th><th></th></thead><tbody>";
if (mysqli_num_rows($result) > 0)
{

	while($row = mysqli_fetch_object($result))
	{
		$validado="";
		$validado =  $row->valido;
   echo "<tr><td nowrap style='vertical-align:middle'>";
		if (! file_exists('../../xml/fotos/'.$row->CLAVEAL.'.jpg')) {
			$foto="<span class=\"fa fa-user fa-3x fa-fw\"></span>";
		}
		else {
			$foto = "<img src='../../xml/fotos/".$row->CLAVEAL.".jpg' width='55' height='64'  />";
		}
		echo $foto."&nbsp;&nbsp;";	
   echo stripslashes($row->NOMBRE).' '.stripslashes($row->APELLIDOS).'</TD>';
  echo " <TD style='vertical-align:middle' nowrap>$row->unidad</TD>
   <TD style='vertical-align:middle' nowrap>$row->F_ENTREV</TD>";
echo "<td style='vertical-align:middle' nowrap><div class='btn-group'><a href='infocompleto.php?id=$row->ID' class='btn btn-primary'><i class='fa fa-search ' title='Ver Informe'> </i></a>";	

$result0 = mysqli_query($db_con, "select tutor from FTUTORES where unidad = '$row->unidad'" );
$row0 = mysqli_fetch_array ( $result0 );	
$tuti = $row0[0];
		 if (stristr($_SESSION ['cargo'],'1') == TRUE or (nomprofesor($tuti) == nomprofesor($_SESSION['profi']))) {
   	echo "<a href='borrar_informe.php?id=$row->ID&del=1' class='btn btn-primary' data-bb='confirm-delete'><i class='fa fa-trash-o ' title='Borrar Informe' > </i></a>";
   	echo "<a href='informar.php?id=$row->ID' class='btn btn-primary'><i class='fa fa-pencil-square-o ' title='Rellenar Informe'> </i> </a>";
		 if ($validado==1) {
				echo "<a href='buscar.php?id=$row->ID&validar=1$extra' class='btn btn-primary text-info'><i class='fa fa-check-square-o' data-bs='tooltip'  title='Informe validado por el Tutor' > </i></a> 	";				
					}
					else{
				echo "<a href='buscar.php?id=$row->ID&validar=0$extra' class='btn btn-primary text-danger'><i class='fa fa-minus-circle' data-bs='tooltip'  title='Informe no validado por el Tutor' > </i> </a> 	";					
					}
		 }
		 else {
		 	$result_profe = mysqli_query($db_con, "SELECT materia FROM profesores WHERE profesor='".nomprofesor($_SESSION['profi'])."' and grupo = '".stripslashes($row->unidad)."'");
		 	if (mysqli_num_rows($result_profe) && date('Y-m-d') <= $row->F_ENTREV) {
		 		 echo "<a href='informar.php?id=$row->ID' class='btn btn-primary btn-mini'><i class='fa fa-pencil-square-o ' title='Rellenar Informe'> </i> </a>";
		 		 
		 	}
		 }
echo '</div></td></tr>';
	}
echo "</tbody></table><br />";
}
// Si no hay datos
else
{
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hay Informes de Tutor&iacute;a disponibles.</div></div><hr>';
}
?>
<?php
if(mysqli_num_rows($result0) > 50) {
?>
<a href="buscar.php?pag=<?php echo $pag;?>" class="btn btn-primary">Siguientes 50 Informes</a>
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