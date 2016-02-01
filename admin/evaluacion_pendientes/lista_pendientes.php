<?php
require('../../bootstrap.php');


include "../../menu.php";
?>
<style>
input[type=number]::-webkit-inner-spin-button {
	-webkit-appearance: none;
}

input[type=number] {
	-moz-appearance: textfield;
}
</style>

<br />

<div class="container">
<div class="page-header">
		<h2>Evaluación de Pendientes <small>Alumnos con la asignatura pendiente</small></h2>
</div>
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<?php
if(isset($_POST['enviar'])){
	
	foreach ($_POST as $clave=>$valor){
		if ($clave!=="enviar" and $clave!=="select") {
			
			$eval="";
			$clave_eval="";
			$asig_eval="";
			$abrev_eval="";
			$nota_eval="";
			
			$datos=explode("-",$clave);
			$eval=$datos[0];
			$clave_eval=$datos[1];
			$asig_eval=$datos[2];
			$abrev_eval=$datos[3];
			$nota_eval=$valor;
			if(is_numeric($nota_eval)){}else{$nota_eval="";}
			
			$check2=mysqli_query($db_con,"select id from evalua_pendientes where evaluacion='$eval' and claveal='$clave_eval' and codigo='$asig_eval' and materia='$abrev_eval'");
			if (mysqli_num_rows($check2)==1) {
				$ya = mysqli_fetch_array($check2);
				if($nota_eval!==""){
				mysqli_query($db_con,"update evalua_pendientes set nota='$nota_eval' where id='$ya[0]'");
				}
			}
			else{
				if($nota_eval!==""){
				mysqli_query($db_con,"insert into evalua_pendientes 
				VALUES ('','$eval','$clave_eval','$asig_eval','$abrev_eval','$nota_eval')");
				}
			}
		}
	}
	
}

$asig_pendiente=$_POST["select"];
$asig = mysqli_query($db_con,"select distinct nombre, curso from asignaturas where codigo = '$asig_pendiente' order by nombre");
$asignatur = mysqli_fetch_row($asig);
$asignatura = $asignatur[0];
$curso = $asignatur[1];

$profe_dep = $_SESSION ['profi'];

echo '<legend class="text-info" align="center"><strong>'.$asignatura.' ('.$curso.')</strong></legend>';
echo '<form action="lista_pendientes.php" method="POST">';
echo "<table class='table table-striped' align='center'><thead><th>Grupo</th><th>NC</th><th>Alumno</th><th nowrap>1ª Ev.</th><th nowrap>2ª Ev.</th><th>Junio</th><th>Sept.</th></thead><tbody>";

if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'4') == TRUE){
$sql = 'SELECT distinct alma.apellidos, alma.nombre, alma.unidad, asignaturas.nombre, asignaturas.abrev, alma.curso, FALUMNOS.nc,  pendientes.claveal, alma.matriculas
FROM pendientes, asignaturas, alma, FALUMNOS
WHERE asignaturas.codigo = pendientes.codigo
AND FALUMNOS.claveal=alma.claveal
AND alma.claveal = pendientes.claveal
AND asignaturas.codigo =  "'.$asig_pendiente.'" 
AND abrev LIKE  "%\_%"
ORDER BY alma.curso, alma.unidad, nc';
}
else{
$sql = 'SELECT distinct alma.apellidos, alma.nombre, alma.unidad, asignaturas.nombre, asignaturas.abrev, alma.curso, FALUMNOS.nc,  pendientes.claveal, alma.matriculas
FROM pendientes, asignaturas, alma, FALUMNOS
WHERE asignaturas.codigo = pendientes.codigo
AND FALUMNOS.claveal=alma.claveal
AND alma.claveal = pendientes.claveal
AND asignaturas.codigo =  "'.$asig_pendiente.'" 
AND abrev LIKE  "%\_%"
AND pendientes.grupo in (select distinct grupo from profesores where profesor = "'.$profe_dep.'")
ORDER BY alma.curso, alma.unidad, nc';	
}
//echo $sql."<br><br>";
$Recordset1 = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));  #crea la consulata;
while ($salida = mysqli_fetch_array($Recordset1)){
	$claveal=$salida[7];
	$abrev_pendiente=$salida[4];
	$val_nivel=substr($pendi[5],0,1);
	$c_unidad = substr($salida[2],0,1);
	$c_curso = substr($salida[4],-2,1);
	if ($salida[8]>1) {
		$rep = "(Rep.)";
	}
	else{
		$rep='';
	}
	$n1+=1;
	echo "<tr><td>$salida[2]</td><td>$salida[6]</td><td nowrap><a href='//".$config['dominio']."/intranet/admin/informes/index.php?claveal=$salida[7]&todos=Ver Informe Completo del Alumno'>$salida[0], $salida[1]</a> <span class='text-warning'>$rep</span></td>";
	
	for ($i = 1; $i < 5; $i++) {
		$nota_evaluacion="";
		$datos=mysqli_query($db_con,"select nota from evalua_pendientes where evaluacion='$i' and claveal='$claveal' and codigo='$asig_pendiente' and materia='$abrev_pendiente'");

		$datos2=mysqli_fetch_array($datos);
		$nota_evaluacion=$datos2[0];
		if(strlen($nota_evaluacion)>0) {}else{$nota_evaluacion="";}
		echo "<td><input type='number' step='1' min='0' max='10' name='$i-$claveal-$asig_pendiente-$abrev_pendiente' value='$nota_evaluacion' style='max-width:40px;'></td>";
	}
	
	echo"</tr>";

}

echo "</tbody></table>";
echo "<input type='hidden' name='select' value='$asig_pendiente' />";
echo "<input type='submit' name='enviar' value='Enviar datos' class='btn btn-primary' />";
echo '<a href="index.php" class="btn btn-default pull-right">Volver a la página de Pendientes</a>';
echo "</form>";

?>

</div>
</div>
</div>
<?php include("../../pie.php"); ?>
<script type="text/javascript">

/*Desactivar rueda del ratón en campos numéricos*/

$('form').on('focus', 'input[type=number]', function (e) {
$(this).on('mousewheel.disableScroll', function (e) {
e.preventDefault()
})
})
$('form').on('blur', 'input[type=number]', function (e) {
$(this).off('mousewheel.disableScroll')
})	
</script>

<script type="text/javascript">

/*Modificar función de la tecla Intro para desplazarse por columna de datos*/

$('table input').keypress(function(e) {
    if (e.keyCode == 13) {
        var $this = $(this),
            index = $this.closest('td').index();

        $this.closest('tr').next().find('td').eq(index).find('input').focus();
        $this.closest('tr').next().find('td').eq(index).find('input').select();
        e.preventDefault();
    }
});
</script>
</body>
</html>