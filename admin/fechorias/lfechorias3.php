<?php
require('../../bootstrap.php');


$PLUGIN_DATATABLES = 1;

include ("../../menu.php");
include ("menu.php");
?>
<div class="container">
<div class="page-header">
  <h2>Problemas de convivencia <small> Ranking de Fechorías</small></h2>
</div>
<br />

<div class="row">

<div class="col-sm-12">	
		<div class="text-center" id="t_larga_barra">
			<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
		</div>
   <div id='t_larga' style='display:none' >	
<?php

		echo "<table class='table table-bordered table-striped table-vcentered datatable'>";
		$fecha1 = (date ( "d" ) . - date ( "m" ) . - date ( "Y" ));
		echo "<thead><tr>
		<th>ALUMNO</th>
		<th>CURSO</th>
		<th>TOTAL</th>
		<th>Leves</th>
		<th>Graves</th>
		<th nowrap>Muy Graves</th>
		<th>Expulsion</th>
		<th>Convivencia</th>
		</tr></thead><tbody>";

		$t1 = mysqli_query($db_con,"SELECT fecha FROM festivos WHERE nombre like '%navidad%' limit 1");	
		$t2 = mysqli_query($db_con,"SELECT fecha FROM festivos WHERE nombre like '%santa%' limit 1");
		$tt1 = mysqli_fetch_array($t1);
		$tt2 = mysqli_fetch_array($t2);
		$navidad = $tt1[0];
		$santa = $tt2[0];

		mysqli_query($db_con, "create table Fechoria_temp SELECT DISTINCT claveal, COUNT( * ) as total FROM Fechoria GROUP BY claveal" );
		$num0 = mysqli_query($db_con, "select * from Fechoria_temp order by total desc" );
		while ( $num = mysqli_fetch_array ( $num0 ) ) 
		{
			$query0 = "select apellidos, nombre, unidad from FALUMNOS where claveal = '$num[0]'";
			$result = mysqli_query($db_con, $query0 );
			$row = mysqli_fetch_array ( $result );
			$claveal = $num[0];
			$apellidos = $row[0];
			$nombre = $row[1];
			$unidad = $row[2];
			$rownumero = $num[1];
			$rowcurso = $unidad ;
			$rowalumno = $nombre . "&nbsp;" . $apellidos;
		
		$leve="";
		$grave="";
		$m_grave="";
		$expulsion="";
		$conv="";

		$lev1 = mysqli_query($db_con, "select grave from Fechoria where grave='leve' and claveal = '$claveal' and date(fecha) < '$navidad'");
		$leve1 = mysqli_num_rows($lev1);
		$lev2 = mysqli_query($db_con, "select grave from Fechoria where grave='leve' and claveal = '$claveal' and date(fecha) < '$santa' and date(fecha) > '$navidad'");
		$leve2 = mysqli_num_rows($lev2);
		$lev3 = mysqli_query($db_con, "select grave from Fechoria where grave='leve' and claveal = '$claveal' and date(fecha) > '$santa'");
		$leve3 = mysqli_num_rows($lev3);
		if ($leve1>0) {$leve="<b class='text-info'>1T:</b> $leve1";}
		if ($leve2>0) {$leve.="<br><b class='text-warning'>2T:</b> $leve2";}
		if ($leve3>0) {$leve.="<br><b class='text-danger'>3T:</b> $leve3";}

		$grav1 = mysqli_query($db_con, "select grave from Fechoria where grave='grave' and claveal = '$claveal' and date(fecha) < '$navidad'");
		$grave1 = mysqli_num_rows($grav1);
		$grav2 = mysqli_query($db_con, "select grave from Fechoria where grave='grave' and claveal = '$claveal' and date(fecha) < '$santa' and date(fecha) > '$navidad'");
		$grave2 = mysqli_num_rows($grav2);
		$grav3 = mysqli_query($db_con, "select grave from Fechoria where grave='grave' and claveal = '$claveal' and date(fecha) > '$santa'");
		$grave3 = mysqli_num_rows($grav3);
		if ($grave1>0) {$grave="<b class='text-info'>1T:</b> $grave1";}
		if ($grave2>0) {$grave.="<br><b class='text-warning'>2T:</b> $grave2";}
		if ($grave3>0) {$grave.="<br><b class='text-danger'>3T:</b> $grave3";}

		$m_grav1 = mysqli_query($db_con, "select grave from Fechoria where grave='muy grave' and claveal = '$claveal' and date(fecha) < '$navidad'");
		$m_grave1 = mysqli_num_rows($m_grav1);
		$m_grav2 = mysqli_query($db_con, "select grave from Fechoria where grave='muy grave' and claveal = '$claveal' and date(fecha) < '$santa' and date(fecha) > '$navidad'");
		$m_grave2 = mysqli_num_rows($m_grav2);
		$m_grav3 = mysqli_query($db_con, "select grave from Fechoria where grave='muy grave' and claveal = '$claveal' and date(fecha) > '$santa'");
		$m_grave3 = mysqli_num_rows($m_grav3);
		if ($m_grave1>0) {$m_grave="<b class='text-info'>1T:</b> $m_grave1";}
		if ($m_grave2>0) {$m_grave.="<br><b class='text-warning'>2T:</b> $m_grave2";}
		if ($m_grave3>0) {$m_grave.="<br><b class='text-danger'>3T:</b> $m_grave3";}

		$expulsio1 = mysqli_query($db_con, "select grave from Fechoria where expulsion > '0' and claveal = '$claveal' and date(fecha) < '$navidad'");
		$expulsion1 = mysqli_num_rows($expulsio1);
		$expulsio2 = mysqli_query($db_con, "select grave from Fechoria where expulsion > '0' and claveal = '$claveal' and date(fecha) < '$sata' and date(fecha) > '$navidad'");
		$expulsion2 = mysqli_num_rows($expulsio2);
		$expulsio3 = mysqli_query($db_con, "select grave from Fechoria where expulsion > '0' and claveal = '$claveal' and date(fecha) > '$santa'");
		$expulsion3 = mysqli_num_rows($expulsio3);
		if ($expulsion1>0) {$expulsion="<b class='text-info'>1T:</b> $expulsion1";}
		if ($expulsion2>0) {$expulsion.="<br><b class='text-warning'>2T:</b> $expulsion2";}
		if ($expulsion3>0) {$expulsion.="<br><b class='text-danger'>3T:</b> $expulsion3";}

		$conviv1 = mysqli_query($db_con, "select grave from Fechoria where aula_conv > '0' and claveal = '$claveal' and date(fecha) < '$navidad'");
		$conv1 = mysqli_num_rows($conviv1);
		$conviv2 = mysqli_query($db_con, "select grave from Fechoria where aula_conv > '0' and claveal = '$claveal' and date(fecha) < '$santa' and date(fecha) > '$navidad'");
		$conv2 = mysqli_num_rows($conviv2);
		$conviv3 = mysqli_query($db_con, "select grave from Fechoria where aula_conv > '0' and claveal = '$claveal' and date(fecha) > '$santa'");
		$conv3 = mysqli_num_rows($conviv3);
		if ($conv1>0) {$conv="<b class='text-info'>1T:</b> $conv1";}
		if ($conv2>0) {$conv.="<br><b class='text-warning'>2T:</b> $conv2";}
		if ($conv3>0) {$conv.="<br><b class='text-danger'>3T:</b> $conv3";}



	
		if(!(empty($apellidos))){
		echo "<tr>
		<td nowrap>";
		$foto="<span class='fa fa-user fa-4x'></span>";
		if(file_exists('../../xml/fotos/'.$claveal.'.jpg')) {
			$foto = "<img class='img-thumbnail' src='../../xml/fotos/$claveal.jpg' width='55' height='64'>";
		}
		echo $foto."&nbsp;&nbsp;";			
		echo "<a href='lfechorias2.php?clave=$claveal'>$rowalumno</a></td>";
		echo "<td>$rowcurso</td>";
		echo "<td><b>$rownumero</b></td>";
		echo "<td>$leve</td>";
		echo "<td>$grave</td>";
		echo "<td>$m_grave</td>";
		echo "<td>$expulsion</td>";
		echo "<td>$conv</td>";
		echo "</tr>";
		}
		}
		echo "</tbody></table>";
		mysqli_query($db_con, "drop table Fechoria_temp" );
		?>
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
  <script>
 function espera( ) {
         document.getElementById("t_larga").style.display = '';
         document.getElementById("t_larga_barra").style.display = 'none';        
 }
 window.onload = espera;
</script>     
  </body>
</html>
