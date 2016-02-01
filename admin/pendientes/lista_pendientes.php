<?php
require('../../bootstrap.php');


if ($_POST['pdf'] == 1) {
	
	require("../../pdf/mc_table.php");
	
	class GranPDF extends PDF_MC_Table {
		function Header() {
			$this->SetTextColor(0, 122, 61);
			$this->Image( '../../img/encabezado.jpg',25,14,53,'','jpg');
			$this->SetFont('ErasDemiBT','B',10);
			$this->SetY(15);
			$this->Cell(75);
			$this->MultiCell(170, 5, 'CONSEJERÍA DE EDUCACIÓN, CULTURA Y DEPORTE', 0,'R', 0);
			$this->Ln(15);
		}
		function Footer() {
			$this->SetTextColor(0, 122, 61);
			$this->Image( '../../img/pie.jpg', 0, 160, 24, '', 'jpg' );
		}
	}
	
	$MiPDF = new GranPDF('L', 'mm', 'A4');
	
	$MiPDF->AddFont('NewsGotT','','NewsGotT.php');
	$MiPDF->AddFont('NewsGotT','B','NewsGotTb.php');
	$MiPDF->AddFont('ErasDemiBT','','ErasDemiBT.php');
	$MiPDF->AddFont('ErasDemiBT','B','ErasDemiBT.php');
	$MiPDF->AddFont('ErasMDBT','','ErasMDBT.php');
	$MiPDF->AddFont('ErasMDBT','I','ErasMDBT.php');
	
	$MiPDF->SetMargins(25, 20, 20);
	$MiPDF->SetDisplayMode('fullpage');
	
	$titulo = "Listado de alumnos con asignaturas pendientes";
	
	$grupos=substr($_POST['grupos'],0,-1);
	$tr_gr = explode(";",$grupos);
	
	foreach($tr_gr as  $valor) {
		$MiPDF->Addpage();
		
		$MiPDF->SetFont('NewsGotT', 'B', 12);
		$MiPDF->Multicell(0, 5, mb_strtoupper($titulo, 'iso-8859-1'), 0, 'C', 0 );
		$MiPDF->Ln(5);
		
		
		$MiPDF->SetFont('NewsGotT', '', 12);
		
		
		// INFORMACION
		$result = mysqli_query($db_con, "SELECT DISTINCT nombre, curso FROM asignaturas WHERE codigo='$valor' ORDER BY nombre ASC");
		
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$MiPDF->SetFont('NewsGotT', 'B', 12);
		$MiPDF->Cell(25, 5, 'Asignatura: ', 0, 0, 'L', 0);
		$MiPDF->SetFont('NewsGotT', '', 12);
		$MiPDF->Cell(100, 5, $row['nombre'].' ('.$row['curso'].')', 0, 1, 'L', 0 );
		
		$MiPDF->Ln(5);
		
		mysqli_free_result($result);
		
		
		// INFORME
		
		$MiPDF->SetWidths(array(20, 10, 90, 30, 105));
		$MiPDF->SetFont('NewsGotT', 'B', 12);
		$MiPDF->SetTextColor(255, 255, 255);
		$MiPDF->SetFillColor(61, 61, 61);
		
		$MiPDF->Row(array('Unidad', 'Nº', 'Alumno/a', 'Asignatura', 'Observaciones'), 0, 6);	
		
		$result = mysqli_query($db_con, "SELECT DISTINCT alma.unidad, FALUMNOS.NC, CONCAT(alma.apellidos, ', ', alma.nombre) AS alumno, alma.matriculas, asignaturas.abrev FROM pendientes, asignaturas, alma, FALUMNOS WHERE asignaturas.codigo = pendientes.codigo AND FALUMNOS.claveal=alma.claveal AND alma.claveal = pendientes.claveal AND alma.unidad NOT LIKE '%p-%' AND asignaturas.codigo = '$valor' and alma.unidad not like '1%' AND abrev LIKE  '%\_%' ORDER BY alma.curso, alma.unidad, nc");
		
		$MiPDF->SetTextColor(0, 0, 0);
		$MiPDF->SetFont('NewsGotT', '', 12);
		
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
			$observaciones = ($row['matriculas']>1) ? 'Repetidor/a' : '';
			
			$MiPDF->Row(array($row['unidad'], $row['NC'], $row['alumno'], $row['abrev'], $observaciones), 1, 6);	
		}
		
		mysqli_free_result($result);
	}
	
	
	// SALIDA
	
	$MiPDF->Output();
	exit();
}
else{
	include "../../menu.php";
	
	foreach($_POST["select"] as  $val) {
		$grupos.=$val.";";
	}
	
	echo '
<div class="container">

	<div class="page-header">
	  <h2 style="display: inline;">Listas de Alumnos <small>Lista de Alumnos con asignaturas pendientes</small></h2>';
	 echo "<form class=\"pull-right\" action='lista_pendientes.php' method='post'>";	
	 echo "<input type='hidden' name='grupos' value='".$grupos."' />";
	 echo "<input type='hidden' name='pdf' value='1' />";
	 echo "<button class='btn btn-primary' name='submit10' type='submit' formtarget='_blank'><i class='fa fa-print fa-fw'></i> Imprimir</button>";
	 echo "</form>";
	echo '	  
	</div>

	<div class="row">
	<div class="col-sm-8 col-sm-offset-2">';

foreach($_POST["select"] as  $valor) {
	$asig = mysqli_query($db_con,"select distinct nombre, curso from asignaturas where codigo = '$valor' order by nombre");
	$asignatur = mysqli_fetch_row($asig);
	$asignatura = $asignatur[0];
	$curso = $asignatur[1];
echo '<br><legend class="text-info" align="center"><strong>'.$asignatura.' ('.$curso.')</strong></legend><hr />';	
echo "<table class='table table-striped' align='center'><thead><th>Grupo</th><th>NC</th><th>Alumno</th><th>Asignatura</th></thead><tbody>";
//$pend = mysqli_query($db_con, "SELECT * from asignaturas where nombre='$valor' and abrev like '%\_%' and asignaturas.nombre in (select distinct materia from profesores) order by curso");
//while ($pendi = mysqli_fetch_array($pend)) {

	
	/*$sql = "SELECT distinct alma.claveal, alma.apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso, alma.unidad, FALUMNOS.nc, asignaturas.nombre
FROM alma,  pendientes , asignaturas, FALUMNOS
WHERE pendientes.codigo='".$pendi[0]."' and alma.claveal = pendientes.claveal and alma.claveal = FALUMNOS.claveal
AND asignaturas.codigo = pendientes.codigo and asignaturas.curso like '$val_nivel%' and alma.unidad like '$val_nivel%' and asignaturas.nombre not like 'Ámbito %'  ORDER BY alma.curso, unidad, nc, alma.Apellidos, alma.Nombre";*/
$sql = 'SELECT distinct alma.apellidos, alma.nombre, alma.unidad, asignaturas.nombre, asignaturas.abrev, alma.curso, FALUMNOS.nc,  pendientes.claveal, alma.matriculas
FROM pendientes, asignaturas, alma, FALUMNOS
WHERE asignaturas.codigo = pendientes.codigo
AND FALUMNOS.claveal=alma.claveal
AND alma.claveal = pendientes.claveal
AND alma.unidad NOT LIKE  "%p-%" 
AND asignaturas.codigo =  "'.$valor.'" and alma.unidad not like "1%"
AND abrev LIKE  "%\_%"
ORDER BY alma.curso, alma.unidad, nc';
		//echo $sql."<br><br>";
		$Recordset1 = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));  #crea la consulata;
		while ($salida = mysqli_fetch_array($Recordset1)){
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
		echo "<tr><td>$salida[2]</td><td>$salida[6]</td><td nowrap><a href='//".$config['dominio']."/intranet/admin/informes/index.php?claveal=$salida[7]&todos=Ver Informe Completo del Alumno'>$salida[0], $salida[1]</a> <span class='text-warning'>$rep</span></td><td>$salida[4] </td></tr>";

		}
//}

		echo "</tbody></table>";

	}
}

?>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
</body>
</html>
