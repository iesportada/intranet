<?php
require('../../bootstrap.php');

include "../../menu.php";
?>
<br />

<div class="container">
<div class="page-header">
		<h2>Evaluación de Pendientes <small>Calificación de las materias pendientes</small></h2>
</div>

<div class="row">
<div class="col-sm-12">
<?php
$curso_pendiente=$_POST["curso"];
if(strlen($_POST["unidad"])>0){
$grupo_pendiente=$_POST["unidad"];
$extra = " and pendientes.claveal in (select claveal from alma where unidad = '$grupo_pendiente')";
}
else{
$extra="";
}
$evaluacion_pendiente=$_POST["evaluacion"];
?>

<legend class="text-info" align="center"><strong><?php echo $curso_pendiente;?></strong></legend>
<legend class='text-warning' align="center"><?php echo $evaluacion_pendiente;?>ª Evaluación</legend>
<table class='table table-striped table-bordered table-condensed' style="width:auto;" align='center'>

<?php
$fila.= "<tr><th></th>";
$asig = mysqli_query($db_con,"select distinct pendientes.codigo, asignaturas.curso, asignaturas.abrev from pendientes, asignaturas 
where asignaturas.codigo = pendientes.codigo and asignaturas.abrev like '%\_%' and curso = '$curso_pendiente' $extra order by nombre");

while($asignatur = mysqli_fetch_row($asig))
{
$ni+=1;
$asignatura = $asignatur[0];
$abreviatura = $asignatur[2];
$array_asigna.="$asignatura:$abreviatura;";
$curso = "$asignatur[1]";
$fila.= "<th style='font-size:8px;'>$abreviatura</th>";	
}
	$array_asigna=substr($array_asigna,0,-1);

$fila.="</tr>";
echo $fila;
$nf=0;
$sql = "SELECT distinct alma.apellidos, alma.nombre, alma.unidad, alma.curso, pendientes.claveal, alma.matriculas 
FROM pendientes, asignaturas, alma WHERE asignaturas.codigo = pendientes.codigo and alma.curso='$curso_pendiente' 
AND asignaturas.abrev LIKE '%\_%' AND alma.claveal = pendientes.claveal $extra ORDER BY alma.curso, alma.unidad, alma.apellidos, alma.nombre";
$Recordset1 = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));  

while ($salida = mysqli_fetch_array($Recordset1)){
	$nf++;
	$claveal=$salida[4];
	$nombre_al="$salida[0], $salida[1]";
	if (strlen($nombre_al)>20) {
		//$nombre_al=substr($nombre_al,0,20);
	}
	if ($salida[5]>1) {
		$rep = "(Rep.)";
	}
	else{
		$rep='';
	}
	echo "<tr>";
	$columna = "<td nowrap>$salida[2]&nbsp;&nbsp;<span class='text-info'>$nombre_al</span>&nbsp;<span class='text-warning'>$rep</span></td>";
	echo $columna;
	$tr_asigna = explode(";",$array_asigna);
	
	foreach ($tr_asigna as $asignaturas) {
		$tr_codigos = explode(":", $asignaturas);
		$as_pend=$tr_codigos[0];
		$ab_pend=$tr_codigos[1];
		$nota_evaluacion="";
		
		$hay=mysqli_query($db_con,"select * from pendientes where claveal='$claveal' and codigo='$as_pend'");
		//echo "select * from pendientes where claveal='$claveal' and codigo='$as_pend'<br>";
		$hay2=mysqli_fetch_array($hay);
		if(strlen($hay2[0])>0){$extra="style='background-color:#edf'";} else{$extra="";}
		
		$datos=mysqli_query($db_con,"select nota from evalua_pendientes where evaluacion='$evaluacion_pendiente' and claveal='$claveal' and codigo='$as_pend' and materia='$ab_pend'");

		$datos2=mysqli_fetch_array($datos);
		$nota_evaluacion=$datos2[0];
		if(strlen($nota_evaluacion)>0) {}else{$nota_evaluacion="";}
		echo "<td $extra>$nota_evaluacion</td>";
			}
	//echo $columna;		
  	echo"</tr>";
	
	if ($nf==15 or $nf==30 or $nf==45 or $nf==60 or $nf==75 or $nf==90 ) {
		echo $fila;
	}
	
}

echo "</table></div>";
echo "<br />";
?>
</div>
</div>
<?php include("../../pie.php"); ?>
</body>
</html>