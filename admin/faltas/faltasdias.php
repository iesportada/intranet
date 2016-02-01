<?php
require('../../bootstrap.php');


include("../../menu.php");
include("../../faltas/menu.php");
$PLUGIN_DATATABLES = 1;
?>
<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>
<?php
$imprimir_activado = true;
  $fechasq0=explode("-",$fecha10);
  $fechasq1=$fechasq0[2]."-".$fechasq0[1]."-".$fechasq0[0];
  $fechasq2=explode("-",$fecha20);
  $fechasq3=$fechasq2[2]."-".$fechasq2[1]."-".$fechasq2[0];
  echo '<div class="container">
  <div class="row">
  <div class="col-sm-2"></div>
  <div class="col-sm-8">';
  echo '<div class="page-header">
  <h2>Faltas de Asistencia <small> Informe de faltas</small></h2>
  </div>
';
        echo "<legend align='center' class='text-info'>Alumnos con más de <strong class='text-info'>$numero</strong> faltas de asistencia<br> entre los días <strong class='text-info'>$fechasq1</strong> y <strong class='text-info'>$fechasq3</strong></legend>
		<table class='table table-striped datatable' style='width:100%;'>";
        echo "<thead><tr><th>Alumno</th><th>Curso</th>
        <th nowrap>Nº faltas</th><th nowrap>Nº días</th></tr></thead><tbody>";

// Creación de la tabla temporal donde guardar los registros. La variable para el bucle es 10224;  
  $SQLTEMP = "create table temp SELECT CLAVEAL, falta, (count(*)) AS numero, unidad, nc FROM FALTAS where falta = 'F' and FALTAS.fecha >= '$fechasq1' and FALTAS.fecha <= '$fechasq3'  group by claveal";
  $resultTEMP= mysqli_query($db_con, $SQLTEMP);
  mysqli_query($db_con, "ALTER TABLE temp ADD INDEX (CLAVEAL)");
  $SQL0 = "SELECT CLAVEAL  FROM  temp WHERE falta = 'F' and numero > '$numero' order by unidad";
  //echo $SQL0;
  $result0 = mysqli_query($db_con, $SQL0);
 while  ($row0 = mysqli_fetch_array($result0)){
$claveal = $row0[0];
// No justificadas
  $SQLF = "select temp.claveal, alma.apellidos, alma.nombre, alma.unidad, alma.matriculas,
  FALTAS.falta,  temp.numero, alma.DOMICILIO, alma.CODPOSTAL, alma.LOCALIDAD  
  from temp, FALTAS, alma where alma.claveal = FALTAS.claveal  
  and temp.claveal = FALTAS.claveal and FALTAS.claveal like '$claveal' 
  and FALTAS.falta = 'F' GROUP BY alma.apellidos";
  //echo $SQLF;
  $resultF = mysqli_query($db_con, $SQLF);	
//Fecha del día
$fhoy=getdate();
$fecha=$fhoy[mday]."-".$fhoy[mon]."-".$fhoy[year];
// Bucle de Consulta.
  if ($rowF = mysqli_fetch_array($resultF))
        {
	echo "<tr><td >";
	$foto="";
	$foto = "<img src='../../xml/fotos/$rowF[0].jpg' width='55' height='64' class=''  />";
	echo $foto."&nbsp;&nbsp;";
	echo "$rowF[2] $rowF[1]</td><td>$rowF[3]</td>
	<td><strong style='color:#9d261d'>$rowF[6]</strong></td>";
# Segunda parte.

  $SQL2 = "SELECT distinct FALTAS.fecha from FALTAS where FALTAS.CLAVEAL like '$claveal' and FALTAS.fecha >= '$fechasq1' and FALTAS.fecha <= '$fechasq3'";
 // print $SQL2;
  $result2 = mysqli_query($db_con, $SQL2);
  $rowsql = mysqli_num_rows($result2);
//  print $rowsql;
  echo "<td><strong style='color:#46a546'>$rowsql</strong></td></tr>";
//  	endwhile;
	}     
	}
       
// Eliminar Tabla temporal
 mysqli_query($db_con, "DROP table `temp`");
  ?>
</tbody>
</table>
</div>
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
	  		
	  		"order": [[ 1, "desc" ]],
	  		
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

