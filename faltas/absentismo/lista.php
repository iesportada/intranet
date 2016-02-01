<?php
require('../../bootstrap.php');


include("../../menu.php");
include("../menu.php");

if (isset($_GET['mes'])) {$mes = $_GET['mes'];}elseif (isset($_POST['mes'])) {$mes = $_POST['mes'];}else{$mes="";}
if (isset($_GET['num_mes'])) {$num_mes = $_GET['num_mes'];}elseif (isset($_POST['num_mes'])) {$num_mes = $_POST['num_mes'];}else{$num_mes="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Alumnos absentistas</small></h2>
</div>
<br />
<div class="col-sm-6 col-sm-offset-3">

<?php
if (isset($_POST['submit'])) {
	          if($mes=='Septiembre'){$n_mes='09';}
                    if($mes=='Octubre'){$n_mes='10';}
                    if($mes=='Noviembre'){$n_mes='11';}
                    if($mes=='Diciembre'){$n_mes='12';}
                    if($mes=='Enero'){$n_mes='01';}
                    if($mes=='Febrero'){$n_mes='02';}
                    if($mes=='Marzo'){$n_mes='03';}
                    if($mes=='Abril'){$n_mes='04';}
                    if($mes=='Mayo'){$n_mes='05';}
                    if($mes=='Junio'){$n_mes='06';}
	//mysqli_query($db_con, "delete from absentismo where mes='$num_mes'");
	foreach ($_POST as $num=>$key)
	{
// echo "$num --> $key<br>";
$claveal=$num;
$trozos=explode(";",$key);
$n_mes=$trozos[0];
$n_faltas=$trozos[1];
$curso=$trozos[2];

 $insert0=mysqli_query($db_con, "select claveal, mes from absentismo where claveal='$claveal' and mes='$n_mes'");
 
 	if (mysqli_num_rows($insert0)>0) {}
 	else {
 		if (is_numeric($claveal)) {
  	 	$abs = mysqli_query($db_con, "insert into absentismo (  claveal ,  mes ,  numero ,  unidad )  VALUES (  '$claveal', '$n_mes', '$n_faltas', '$curso' )");	
		
 		}
 	}
	}
	echo '<br /><div align="center""><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Los datos de los alumnos absentistas se han actualizado. Se ha enviado un mensaje al <b>Departamento de Orientación</b> y los <b>Tutores</b> para que procedan con el Informe de Absentismo.
			</div></div>';
}
else 
{
?> 
<form enctype='multipart/form-data' action='lista.php' method='post'> 
 <?php 
                    if($mes=='Septiembre'){$n_mes='09';}
                    if($mes=='Octubre'){$n_mes='10';}
                    if($mes=='Noviembre'){$n_mes='11';}
                    if($mes=='Diciembre'){$n_mes='12';}
                    if($mes=='Enero'){$n_mes='01';}
                    if($mes=='Febrero'){$n_mes='02';}
                    if($mes=='Marzo'){$n_mes='03';}
                    if($mes=='Abril'){$n_mes='04';}
                    if($mes=='Mayo'){$n_mes='05';}
                    if($mes=='Junio'){$n_mes='06';}
                    $mes=strtoupper($mes);
        echo "<center> <h4>Alumnos con más de <span class='badge badge-warning'>$numero</span> faltas de asistencia en <span class='badge badge-warning'>$mes</span></h4>";
		echo '<br /><TABLE class="table table-striped" style="width:auto" align="center">
';
        echo "<tr><th></th><th align='center'>Alumno</th><th align='center'>Curso</th>
        <th align='center'>Nº faltas</th><th align='center'>Nº días</th></tr>";

// Creación de la tabla temporal donde guardar los registros. La variable para el bucle es 10224;  
  $SQLTEMP = "create table faltastemp2 SELECT FALTAS.CLAVEAL, falta, (count(*)) AS numero, FALTAS.unidad FROM FALTAS, FALUMNOS where FALTAS.CLAVEAL=FALUMNOS.claveal and  falta = 'F' and month(FALTAS.fecha)= '$n_mes'   group by apellidos, nombre";
  $resultTEMP= mysqli_query($db_con, $SQLTEMP);
  mysqli_query($db_con, "ALTER TABLE faltastemp2 ADD INDEX (CLAVEAL)");
  $SQL0 = "SELECT CLAVEAL  FROM  faltastemp2 WHERE numero > '$numero' order by unidad";
  //print $SQL0;
  $result0 = mysqli_query($db_con, $SQL0);
 while  ($row0 = mysqli_fetch_array($result0)){
 	//reset($claveal);
$claveal = $row0[0];
// No justificadas
  $SQLF = "select faltastemp2.claveal, alma.apellidos, alma.nombre, alma.unidad, alma.matriculas,
  FALTAS.falta,  faltastemp2.numero, alma.DOMICILIO, alma.CODPOSTAL, alma.LOCALIDAD  
  from faltastemp2, FALTAS, alma where alma.claveal = FALTAS.claveal  
  and faltastemp2.claveal = FALTAS.claveal and FALTAS.claveal like '$claveal' 
  and FALTAS.falta = 'F' GROUP BY alma.apellidos";
  //echo $SQLF;
  $resultF = mysqli_query($db_con, $SQLF);	
//Fecha del día
$fhoy=getdate();
$fecha=$fhoy[mday]."-".$fhoy[mon]."-".$fhoy[year];
// Bucle de Consulta.
  while($rowF = mysqli_fetch_array($resultF))
        {
        	$sel="";
        	$registrado = mysqli_query($db_con, "select claveal from absentismo where claveal='$claveal' and mes='$n_mes'");
        	if (mysqli_num_rows($registrado)>0) {
        		$sel=" checked";
        	}
	echo "<tr><td align='center'>";
        $foto="";
		$foto = "<img src='../../xml/fotos/$rowF[0].jpg' width='55' height='64' class='image-thumbnail'  />";
		echo $foto."&nbsp;&nbsp;&nbsp;";	
	echo "</td>";
	echo "<td  align='left' style='vertical-align:middle'><div class='checkbox'><label><input name='$rowF[0]' type='checkbox' value='$n_mes;$rowF[6];$rowF[3]' $sel /> $rowF[2] $rowF[1]</label></div></td><td style='vertical-align:middle'>$rowF[3]</td>
	<td style='vertical-align:middle'>$rowF[6]</td>";
  $SQL2 = "SELECT distinct FALTAS.fecha from FALTAS where FALTAS.CLAVEAL like '$claveal' and month(FALTAS.fecha) = '$n_mes'";
  $result2 = mysqli_query($db_con, $SQL2);
  $rowsql = mysqli_num_rows($result2);
  echo "<td style='vertical-align:middle'>$rowsql</td></tr>";
	}         
	} 
	echo '</table';      
// Eliminar Tabla temporal
 mysqli_query($db_con, "DROP table `faltastemp2`");
  ?>
 <INPUT name="num_mes" type="hidden" value="<?php echo $n_mes;?>"> 
 <br />
 <INPUT name="submit" type="submit" value="Enviar Datos" id="submit" align="center" class="btn btn-danger"> 

</form>
<?php
}
if (strstr($_SESSION['cargo'],'1')==TRUE OR strstr($_SESSION['cargo'],'8')==TRUE) {echo '<br><div align="center"><br /><a href="index.php" class="btn btn-primary">Volver a la Página de Absentismo</a>';}
?>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
	
</body>
</html>
