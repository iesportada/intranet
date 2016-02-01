<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

require_once('../../pdf/class.ezpdf.php');
$pdf =& new Cezpdf('a4');
$pdf->selectFont('../../pdf/fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
$tot = mysqli_query($db_con, "select distinct curso, grupo_actual from matriculas_bach where grupo_actual != '' order by curso, grupo_actual");
while($total = mysqli_fetch_array($tot)){
# hasta aquÃ­ lo del pdf
$options_center = array(
				'justification' => 'center'
			);
$options_right = array(
				'justification' => 'right'
			);
$options_left = array(
				'justification' => 'left'
					);
	$curso = $total[0];
	$grupo_actual = $total[1];

		$sqldatos="SELECT concat(apellidos,', ',nombre)";		
		$sqldatos .= "FROM matriculas_bach WHERE curso = '$curso' and grupo_actual='".$grupo_actual[0]."' ORDER BY apellidos, nombre";

$lista= mysqli_query($db_con, $sqldatos );
$nc=0;
unset($data);
while($datatmp = mysqli_fetch_array($lista)) { 
	

$nc+=1;

if ($curso=="2BACH") {

	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
			);
}
if ($curso=="1BACH") {
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
			);
}
}

$options = array(
				'textCol' => array(0.2,0.2,0.2),
				'innerLineThickness'=>0.5,
				'outerLineThickness'=>0.7,
				'showLines'=> 2,
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>230
			);
$txttit = "Lista del Grupo $curso-$grupo_actual[0]\n";
$txttit.= $config['centro_denominacion'].". Curso ".$config['curso_actual'].".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);

$pdf->ezText("\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);

$pdf->ezNewPage();
}
$pdf->ezStream();
?>