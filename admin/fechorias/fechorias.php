<?php
require('../../bootstrap.php');


$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");
?>
<style>
.table th{
	font-size:0.8em;
	vertical-align:top !important;
}
</style>
	<div class="container">
	
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
		  <h2>Problemas de convivencia <small> Consultas</small></h2>
		</div>
		
		
		<!-- SCAFFOLDING -->
  	<div class="row">
  		
  		<!-- COLUMNA CENTRAL -->
  		<div class="col-sm-12">
 
<?php
if(isset($_POST['submit1'])){$submit1 = $_POST['submit1'];}elseif(isset($_GET['submit1'])){$submit1 = $_GET['submit1'];}else{ $submit1=""; }
if(isset($_POST['unidad'])){$unidad = $_POST['unidad'];}elseif(isset($_GET['unidad'])){$unidad = $_GET['unidad'];}else{ $unidad=""; }
if(isset($_POST['c_escolar'])){$c_escolar = $_POST['c_escolar'];}elseif(isset($_GET['c_escolar'])){$c_escolar = $_GET['c_escolar'];}else{ $c_escolar=""; }
if(isset($_POST['apellido'])){$APELLIDOS = $_POST['apellido'];}elseif(isset($_GET['apellido'])){$APELLIDOS = $_GET['apellido'];}else{ $APELLIDOS=""; }
if(isset($_POST['nombre'])){$NOMBRE = $_POST['nombre'];}elseif(isset($_GET['nombre'])){$NOMBRE = $_GET['nombre'];}else{ $NOMBRE=""; }
if(isset($_POST['dia'])){$DIA = $_POST['dia'];}elseif(isset($_GET['dia'])){$DIA = $_GET['dia'];}else{ $DIA=""; }
if(isset($_POST['mes'])){$MES = $_POST['mes'];}elseif(isset($_GET['mes'])){$MES = $_GET['mes'];}else{ $MES=""; }
if(isset($_POST['clase'])){$clase = $_POST['clase'];}elseif(isset($_GET['clase'])){$clase = $_GET['clase'];}else{ $clase=""; }
if(isset($_POST['confirma'])){$confirma = $_POST['confirma'];}elseif(isset($_GET['confirma'])){$confirma = $_GET['confirma'];}else{ $confirma=""; }
if(isset($_GET['claveal'])){$claveal = $_GET['claveal'];}elseif(isset($_POST['claveal'])){$claveal = $_POST['claveal'];}else{$claveal="";}
if(isset($_GET['id'])){$id = $_GET['id'];}

if (!(empty($confirma))) {
 	foreach ($_POST as $clave => $valor){
  		if (strlen($valor) > '0' and $clave !== 'confirma') {
  		$actualiza = "update Fechoria set confirmado = '1' where id = '$clave'";
  		//echo $actualiza;
  		$act = mysqli_query($db_con, $actualiza);
  		} 
  	}
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El problema de convivencia ha sido confirmado correctamente. <br />No te olvides de recargar la página si decides volver atrás a los resultados de la consulta.
          </div><br />
<INPUT class="btn btn-primary" TYPE="button" VALUE="Volver atrás"
	onClick="history.back()"></div>';
exit();
  }
  
   if(isset($_GET['borrar']) and $_GET['borrar']=="1"){
$query = "DELETE FROM Fechoria WHERE id = '$id'";
$result = mysqli_query($db_con, $query) or die ("Error en la Consulta: $query. " . mysqli_error($db_con));
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El registro ha sido eliminado de la base de datos.
          </div></div>';	
exit();
}
	if(empty($NOMBRE) and empty($APELLIDOS) and empty($MES) and empty($DIA) and empty($unidad) and empty($claveal) and empty($clase))
	   {
	   echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
            Debes seleccionar al menos un tipo de datos (Apellidos, Nombre, unidad, etc.) para poder hacer la Consulta. Vuelve atrás y selecciona algún criterio de búsqueda.
          </div></div>';
	echo " <br /><center>
<INPUT class='btn btn-primary' TYPE='button' VALUE='Volver atrás'
	onClick='history.back()'></center>";
exit();
    }
	$AUXSQL = "";
	$clase=$_POST["clase"]; 
  #Comprobamos si se han metido Apellidos o no, etc.
  if  (TRIM("$NOMBRE")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.nombre like '$NOMBRE%'";
    }
	  if  (TRIM("$claveal")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.claveal = '$claveal'";
    }
  if  (TRIM("$APELLIDOS")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.apellidos like '$APELLIDOS%'";
    }
  #Comprobamos d y mes.
  IF (TRIM("$MES")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and (month(Fechoria.fecha)) = '$MES'";
    }
      IF (TRIM("$DIA")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $DIA = cambia_fecha($DIA);
    $AUXSQL .= " and (date(Fechoria.fecha)) = '$DIA'";
    }

    if  (TRIM("$unidad")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.unidad like '$unidad'";
    }

    if (isset($clase)) {
    	$AUXSQL .=" AND (";
        foreach ($clase as $tipo_fech){
    	    
	     if  ($tipo_fech == "Expulsion del Centro")
    {
    $AUXSQL .= " expulsion > '0' OR";
    }
		     if  ($tipo_fech == "Expulsion del Aula")
    {
    $AUXSQL .= " expulsionaula = '1' OR";
    }
		     if  ($tipo_fech == "A.T.I.")
    {
    $AUXSQL .= " aula_conv > '0' OR";
    }
		    if  ($tipo_fech == "A.T.I. Jefatura")
    {
    $AUXSQL .= " (aula_conv > '0' and horas='123456') OR";
    }
		     if  ($tipo_fech == "Falta Grave")
    {
    $AUXSQL .= " grave = 'grave' OR";
    }
		     if  ($tipo_fech == "Falta Muy Grave")
    {
    $AUXSQL .= " grave = 'muy grave' OR";
    }
			if  ($tipo_fech == "Biblioteca")
    {
    $AUXSQL .= " asunto like '%Biblioteca%' OR";
    }
    }
    	$AUXSQL=substr($AUXSQL,0,-2);
    	$AUXSQL .=" )";
    }

    
if (isset($submit1))
	{			
mysqli_query($db_con, "create table if not exists Fechcaduca select id, fecha, TO_DAYS(now()) - TO_DAYS(fecha) as dias from Fechoria");
mysqli_query($db_con,"ALTER TABLE `Fechcaduca` ADD PRIMARY KEY (`id`);");
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, Fechoria.confirmado, horas from Fechoria, FALUMNOS, Fechcaduca where Fechcaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal " . $AUXSQL . " order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos";
  //echo $query0;
  $result = mysqli_query($db_con, $query0);
 echo "<br /><center>
 <form action='fechorias.php' method='post' name='cnf'>
 <div class='table-responsive'>
 <table class='table table-bordered' style='width:auto' align='center'><tr><td class='expulsion-centro'>Expulsión del Centro</td><td class='amonestacion-escrita'>Amonestación escrita</td><td class='expulsion-aula'>Expulsión del aula</td><td class='aula-convivencia-jefatura'>A.T.I. (Jefatura)</td><td class='aula-convivencia-profesor'>A.T.I. (Profesor)</td></tr></table><br />";
		echo "<center><form action='fechorias.php' method='post' name='cnf'>
		<table class='table table-bordered table-striped table-vcentered datatable'>";
		$fecha1 = (date("d").-date("m").-date("Y"));
		echo "<thead><tr>
		<th></th>
		<th>ALUMNO</th>
		<th width='60'>CURSO</th>
		<th>FECHA</th>
		<th>TIPO</th>
		<th>INFORMA</th>
		<th>GRAV.</th>
		<th width='48'>NUM.</th>
		<th width='48'>CAD.</th>
		<th></th>
		<th></th>
		<th></th>		
		</tr></thead><tbody>";	
        	
   while($row = mysqli_fetch_array($result))
        {
        $marca = '';
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
		$confirmado=$row[19];
		$horas=$row[20];
		if ($confirmado == '1') {
			$marca = " checked = 'checked'";
		}
		if(($dias > 30 and ($grave == 'leve' or $grave == 'grave')) or ($dias > 60 and $grave == 'muy grave'))
		{$caducada="Sí";} else {$caducada="No";}
		$numero = mysqli_query($db_con, "select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' order by Fechoria.fecha"); 
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
				if($recibido == '1'){$comentarios1="<i class='fa fa-check' title='recibido'> </i>";}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){$comentarios1="<i class='fa fa-exclamation-triangle' title='No recibido'> </i>";}else{$comentarios1="";}
		echo "<tr>
		<td>";
		$foto="<span class='fa fa-user fa-fw fa-3x'></span>";
		if(file_exists('../../xml/fotos/'.$claveal.'.jpg')) $foto = "<img src='../../xml/fotos/$claveal.jpg' width='50'>";

		echo $foto."</td>";
		echo "<td>$rowalumno</td>
		<td>$rowcurso</td>
		<td nowrap>$fecha</td>
		<td>$asunto</td>
		<td>".nomprofesor($informa)."</td>
		<td nowrap $bgcolor>$grave</td>
		<td nowrap><center>$rownumero</center></td>
		<td nowrap>$caducada</td>
		<td nowrap>$comentarios1</td>
		<td  nowrap>"; 
if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE or (stristr($_SESSION['cargo'],'c') == TRUE and stristr($asunto,"Biblioteca")==TRUE)){
		$ahora = mktime();
		$tr_f = explode("-",$fecha);
		$antes = mktime(0,0,0,$tr_f[1],$tr_f[2],$tr_f[0])+172800;
		if ($ahora < $antes) {
			echo "<A HREF='infechoria.php?id=$id&nombre=$claveal'><i class='fa fa-pencil fa-fw fa-lg' data-bs='tooltip' title='Editar'></i></A>";
		}
	echo "<a href='fechorias.php?id=$id&borrar=1' data-bb='confirm-delete'><i class='fa fa-trash-o fa-fw fa-lg' data-bs='tooltip' title='Eliminar'></i></a>";
}	
		echo "<a href='lfechorias2.php?clave=$claveal'><span class='fa fa-user fa-fw fa-lg' data-bs='tooltip' title='Historial del alumno'></span></a>
		 <A HREF='detfechorias.php?id=$id&claveal=$claveal'><i class='fa fa-search fa-fw fa-lg' data-bs='tooltip' title='Detalles del problema e historial de problemas del alumno'></i></A></td>
		<td>";
		//echo "$expulsion >  $expulsionaula";
		if (stristr($_SESSION['cargo'],'1')) {
			echo "<input type='checkbox' name='$id' value='1'  $marca onChange='submit()' />";			
		}

		
		echo "</td></tr>";
        }
        echo "</tbody></table></div>
        <input type='hidden' name='confirma' value='si' />
        </form></center>\n";
        
 	}
 	mysqli_query($db_con, "drop table Fechcaduca");
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
