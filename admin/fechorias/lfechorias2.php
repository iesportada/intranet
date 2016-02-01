<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");


if(isset($_GET['clave'])){$clave = $_GET['clave'];}else{$clave="";}
  
 $nom = mysqli_query($db_con, "select nombre, apellidos, unidad from alma where claveal = '$clave'");
   $nom0 = mysqli_fetch_array($nom);
  mysqli_query($db_con, "drop table FechCaduca");
  mysqli_query($db_con, "create table FechCaduca select id, fecha, TO_DAYS(now()) - TO_DAYS(fecha) as dias from Fechoria");
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, Fechoria.id from Fechoria, FALUMNOS, FechCaduca where FechCaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal and Fechoria.claveal = '$clave' order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos";
  $result = mysqli_query($db_con, $query0);
  echo "<div class='container'>";
  echo '<div class="row">
  <div class="col-sm-12">';
  
  echo '
<div class="page-header">
  <h2>Problemas de convivencia <small> &Uacute;ltimos Problemas de Convivencia</small></h2>
  <h3 class="text-info">';
 echo "$nom0[0] $nom0[1] ($nom0[2])";
  echo '</h3>
</div>';

 echo "<table class='table table-bordered' style='width:auto' align='center'><tr><td class='expulsion-centro'>Expulsión del Centro</td><td class='amonestacion-escrita'>Amonestación escrita</td><td class='expulsion-aula'>Expulsión del aula</td><td class='aula-convivencia-jefatura'>A.T.I. (Jefatura)</td><td class='aula-convivencia-profesor'>A.T.I. (Profesor)</td></tr></table><br />";
		echo '<div class="table-responsive"><table class="table table-striped table-bordered table-vcentered datatable">';
		$fecha1 = (date("d").-date("m").-date("Y"));
       echo "<thead>
		<th>CURSO</th>
		<th>FECHA</th>
		<th>TIPO</th>
		<th>INFORMA</th>
		<th>GRAV.</th>
		<th width='48'>NUM.</th>
		<th width='45'>CAD.</th>		
		<th></th>
		<th></th>
		</thead><tbody>";	
   while($row = mysqli_fetch_array($result))
        {
		$apellidos = $row[0];
		$nombre = $row[1];
		$unidad = $row[2];
		$fecha = $row[4];
		$asunto = $row[5];
		$informa = $row[6];
		$grave = $row[7];
		$claveal = $row[8];
		$id = $row[9];
		$expulsion=$row[10];
		$expulsionaula=$row[11];
		$medida=$row[12];
		$tutoria=$row[13];
		$recibido=$row[14];
		$dias=$row[15];
		$aula_conv=$row[16];
		$inicio_aula=$row[17];
		$fin_aula=$row[18];
		$ident=$row[19];
		if(($dias > 30 and ($grave == 'leve' or $grave == 'grave')) or ($dias > 60 and $grave == 'muy grave'))
		{$caducada="Sí";} else {$caducada="No";}
		$numero = mysqli_query($db_con, "select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '2006-09-15' order by Fechoria.fecha"); 
		$rownumero= mysqli_num_rows($numero);
		$rowcurso = $unidad;
        $rowalumno = $nombre."&nbsp;".$apellidos;
				$bgcolor="class=''";
				if($medida == "Amonestación escrita" and $expulsionaula !== "1" and $expulsion == 0){$bgcolor="class='amonestacion-escrita'";}
				if($expulsionaula == "1"){$bgcolor="class='expulsion-aula'";}
				
				if($aula_conv > 0){
					if ($horas == "123456") {
						$bgcolor="class='aula-convivencia-jefatura'";
					}
					else{
						$bgcolor="class='aula-convivencia-profesor'";
					}
				}	
				
				if($expulsion > 0){$bgcolor="class='expulsion-centro'";}	
				if($recibido == '1'){
					$comentarios1="<i class='fa fa-check' title='recibido'> </i>";
				}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){
					$comentarios1="<i class='fa fa-exclamation-triangle' title='No recibido'> </i>";
				}else{
					$comentarios1="";
				}
		echo "<tr>
		<td >$rowcurso</td>
		<td >$fecha</td>
		<td >$asunto</td>
		<td ><span  style='font-size:0.9em'>$informa</span></td>
		<td $bgcolor>$grave</td>
		<td ><center>$rownumero</center></td>
		<td >$caducada</td>
		<td  nowrap>$comentarios1 $comentarios</td>
		<td  nowrap>"; 
		echo "<a href='detfechorias.php?id=$id&claveal=$claveal' data-bs='tooltip' title='Detalles'><span class='fa fa-search fa-fw fa-lg'></span></a>";
if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE){echo "<a href='delfechorias.php?id= $row[9]' data-bs='tooltip' title='Eliminar' data-bb='confirm-delete'><span class='fa fa-trash-o fa-fw fa-lg'></span></a></div>";}	
		echo "</td>";
		echo "</tr>";
        }
        echo "</tbody></table></div>";
 
  ?>
</div>
</div>
</div>
<?php include("../../pie.php");?>
</body>
</html>
