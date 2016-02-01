<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2, 7, 8));

$PLUGIN_DATATABLES = 1;

include("../../menu.php");

if (strstr($_SESSION['cargo'],"2")==FALSE) :
include("./menu.php");
endif;
?>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2 style="display:inline;">Consulta Informes de Tránsito <small>Alumnado de Primaria</small></h2>
		
		<!-- Button trigger modal -->
		<a href="#"class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
			<span class="fa fa-question fa-lg"></span>
		</a>
	
		<!-- Modal -->
		<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modal_ayuda_titulo" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
						<h4 class="modal-title" id="modal_ayuda_titulo">Instrucciones de uso</h4>
					</div>
					<div class="modal-body">
						<p>Las celdas que contienen datos numéricos variables o bolitas de colores 
						(diversos tipos de dificultades propios de un alumno, p. ej.) presentan 
						información sobre el texto simbolizado por el número o la bolita colocando el 
						cursor encima de la celda. Aparecerá entonces el texto correspondiente a la 
						opción numérica o el color de la bola.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>

	<!-- SCAFFOLDING -->
	<div class="row">
	<div class="col-sm-12">
	<div class="table-responsive">
	<table class="table table-striped table-bordered datatable"><thead>
	<?php
	$cabecera="<tr><th>Alumno</th><th>Colegio</th>";
	$col = mysqli_query($db_con,"select distinct tipo from transito_tipo where tipo not like 'norelacion' and tipo not like 'funciona' and tipo not like 'actitud' and tipo not like 'observaciones' and tipo not like 'orientacion'");
	while ($ncol=mysqli_fetch_array($col)) {
		$cabecera.= "<th>$ncol[0]</th>";
	}
	$cabecera.="<th>notas</th><th>orientacion</th>";
	$cabecera.="</tr>";
	echo $cabecera;	
	?>
	</thead>
	<?php
	if (strstr($_SESSION['cargo'],"2")==TRUE) {
		$extra = " where claveal in (select claveal from alma where unidad = '".$_SESSION['mod_tutoria']['unidad']."')";
	}
	else{
		$extra = "";
	}
	$cl = mysqli_query($db_con,"select distinct claveal, apellidos, nombre, colegio from alma_primaria $extra");
	while ($clav = mysqli_fetch_array($cl)) {
	
		$link="";
		$claveal=$clav[0];
		$clg=str_ireplace("C.E.I.P.","",$clav[3]);
		$con = mysqli_query($db_con,"select * from transito_datos where claveal = '$claveal'");
		if (mysqli_num_rows($con)>0) { $link = 1; }
		echo "<tr><td nowrap>$ni ";
		if ($link==1) {
			echo "<a href='informe_transito.php?claveal=$claveal' target='_blank'>";
		}
		echo "$clav[1], $clav[2]";
		if ($link == 1) {
			echo "</a>";;
		}
		echo "</td><td nowrap>$clg</td>";
		$col = mysqli_query($db_con,"select distinct tipo from transito_tipo");
		while ($ncol=mysqli_fetch_array($col)) {

			$tipo = $ncol[0];
			if ($tipo=='norelacion' or $tipo == 'funciona' or $tipo == 'actitud' or $tipo == 'observaciones' or $tipo == 'orientacion') {
			}
			else{			
			$col1 = mysqli_query($db_con,"select dato from transito_datos where claveal = '$claveal' and tipo = '$tipo'");
			$dat = mysqli_fetch_array($col1);
			$dato = $dat[0];
			$tt="";
			if (stristr($tipo,"dificulta")==TRUE and stristr($dato,"1")==TRUE) {$ttd = "Tiene carencias en aprendizajes básicos. <br>";}
			if (stristr($tipo,"dificulta")==TRUE and stristr($dato,"2")==TRUE) {$ttd.= "Tiene dificultades en la lectura. <br>";}
			if (stristr($tipo,"dificulta")==TRUE and stristr($dato,"3")==TRUE) {$ttd.= "Tiene dificultades de comprensión oral / escrita. <br>";}
			if (stristr($tipo,"dificulta")==TRUE and stristr($dato,"4")==TRUE) {$ttd.= "Tiene dificultades de expresión oral / escrita. <br>";}
			if (stristr($tipo,"dificulta")==TRUE and stristr($dato,"5")==TRUE) {$ttd.= "Tiene dificultades de razonamiento matemático. <br>";}
			if (stristr($tipo,"dificulta")==TRUE and stristr($dato,"6")==TRUE) {$ttd.= "Tiene dificultades en hábitos /  método de estudio. <br>";}
			if (stristr($tipo,"dificulta")==TRUE and stristr($dato,"7")==TRUE) {$ttd.= "Tiene dificultades de cálculo. <br>";}
			if (stristr($tipo,"dificulta")==TRUE and strlen($dato)>0) {$tt=" id='dific' data-bs='tooltip' data-html='true' title='$ttd'";$dato='<span class="fa fa-circle" style="color: red;"></span>';}
				
			if (stristr($tipo,"expuls")==TRUE and $dato==2) {$tt=" data-bs='tooltip' title='El alumno ha sido expulsado.'";$dato='<span class="fa fa-circle" style="color: red;"></span>';}elseif(stristr($tipo,"expuls")==TRUE and strlen($dato)==1){$tt="";$dato='';}
			
			if (stristr($tipo,"exento")==TRUE and $dato==1) {$tt=" data-bs='tooltip' title='Alumnado que por sus dificultades no se le recomienda cursar optativa'";$dato='<span class="fa fa-circle" style="color: green;"></span>';}
		
			if (stristr($tipo,"acompa")==TRUE and $dato==1) {$tt=" data-bs='tooltip' title='Se aconseja asistencia al Programa de Acompañamiento Escolar'";$dato='<span class="fa fa-circle" style="color: green;"></span>';}
			
			if (stristr($tipo,"asiste")==TRUE and $dato==1) {$tt=" data-bs='tooltip' title='El alumno presenta faltas de asistencia.'";$dato='<span class="fa fa-circle" style="color: yellow;"></span>';}elseif(stristr($tipo,"asiste")==TRUE and $dato==2){$tt=" data-bs='tooltip' title='El alumno falta más de lo normal'";$dato='<span class="fa fa-circle" style="color: orange;"></span>';}elseif(stristr($tipo,"asiste")==TRUE and $dato==3){$tt=" data-bs='tooltip' title='El alumno es absentista'";$dato='<span class="fa fa-circle" style="color: red;"></span>';}
						
			if (stristr($tipo,"nacion")==TRUE and $dato==4) {$tt = " data-bs='tooltip' title='No conoce el español'";}
			if (stristr($tipo,"nacion")==TRUE and $dato==1) {$tt = " data-bs='tooltip' title='Nociones básicas de español'";}
			if (stristr($tipo,"nacion")==TRUE and $dato==2) {$tt = " data-bs='tooltip' title='Dificultades lectoescritiras en español'";}
			if (stristr($tipo,"nacion")==TRUE and $dato==3) {$tt = " data-bs='tooltip' title='Puede seguir el Curriculum'";}
			if (stristr($tipo,"integra")==TRUE and $dato==5) {$tt = " data-bs='tooltip' title='Líder'";}
			if (stristr($tipo,"integra")==TRUE and $dato==1) {$tt = " data-bs='tooltip' title='Integrado'";}
			if (stristr($tipo,"integra")==TRUE and $dato==2) {$tt = " data-bs='tooltip' title='Poco integrado'";}
			if (stristr($tipo,"integra")==TRUE and $dato==3) {$tt = " data-bs='tooltip' title='Se aísla'";}
			if (stristr($tipo,"integra")==TRUE and $dato==4) {$tt = " data-bs='tooltip' title='Alumno rechazado'";}
			if (stristr($tipo,"relacion")==TRUE and $dato==3) {$tt = " data-bs='tooltip' title='Colaboración constante de la familia'";}
			if (stristr($tipo,"relacion")==TRUE and $dato==1) {$tt = " data-bs='tooltip' title='Colaboración sólo cuando el Centro la ha solicitado'";}
			if (stristr($tipo,"relacion")==TRUE and $dato==2) {$tt = " data-bs='tooltip' title='Demanda constante por parte de los Padres'";}
			if (stristr($tipo,"disruptivo")==TRUE and $dato==3) {$tt = " data-bs='tooltip' title='Nunca'";}
			if (stristr($tipo,"disruptivo")==TRUE and $dato==1) {$tt = " data-bs='tooltip' title='Ocasionalmente'";}
			if (stristr($tipo,"disruptivo")==TRUE and $dato==2) {$tt = " data-bs='tooltip' title='Alumno disruptivo'";}
			if (stristr($tipo,"expulsion")==TRUE and $dato==1) {$tt = " data-bs='tooltip' title='No ha sido expulsado'";}
			if (stristr($tipo,"expulsion")==TRUE and $dato==2) {$tt = " data-bs='tooltip' title='Ha sido expulsado'";}
			
			echo "<td $tt>$dato</td>";

			}	
		
		}

		$col2 = mysqli_query($db_con,"select dato from transito_datos where claveal = '$claveal' and ((tipo='norelacion' and dato not like '') or (tipo = 'funciona' and dato not like '') or (tipo = 'actitud' and dato not like '') or (tipo = 'observaciones' and dato not like '')))");		
		$dat1 = mysqli_num_rows($col2);
		$notas="";
				if ($dat1>0) {
				$notas='<span class="fa fa-circle" style="color: orange;"></span>';
				$tt=" data-bs='tooltip' title='Hay observaciones o notas sobre Actitud, Relación del Centro con la familia, etc.'";
				}
				
				$col3 = mysqli_query($db_con,"select dato from transito_datos where claveal = '$claveal' and (tipo = 'orientacion' and dato not like '')");		
		$dat2 = mysqli_num_rows($col3);

				if ($dat2>0) {
				$notas.='<span class="fa fa-warning" style="color: blue;"></span>';
				}
				
		echo "<td $tt>$notas</td>";		
		
		// COLUMNA DE ORIENTACIÓN ¿?		
		echo "<td></td>";
		
		echo "</tr>";
	}
	?>
	</table>
	</div>
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
</body>
</html>
