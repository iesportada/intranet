<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

require_once('../../pdf/class.ezpdf.php');

$pdf =& new Cezpdf('a4');
$pdf->selectFont('../../pdf/fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
$tot = mysqli_query($db_con, "select distinct curso, grupo_actual from matriculas where grupo_actual != '' order by curso, grupo_actual");
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
						
	if ($curso=="3ESO") {
		$sqldatos="SELECT concat(apellidos,', ',nombre), exencion, optativa1, optativa2, optativa3, optativa4, optativa5, optativa6, optativa7, act1, religion, diversificacion FROM matriculas WHERE curso = '$curso' and grupo_actual='".$grupo_actual."' ORDER BY apellidos, nombre";
		$div3=mysqli_query($db_con,"SELECT diversificacion FROM matriculas WHERE curso = '$curso' and grupo_actual='".$grupo_actual."' and diversificacion='1'");
		if (mysqli_num_rows($div3)>0) {
			$div_3 = $grupo_actual;
		}		
	}
	else{
		$sqldatos="SELECT concat(apellidos,', ',nombre) FROM matriculas WHERE curso = '$curso' and grupo_actual='".$grupo_actual."' ORDER BY apellidos, nombre";
	}
$lista= mysqli_query($db_con, $sqldatos );
$nc=0;
unset($data);
while($datatmp = mysqli_fetch_array($lista)) { 
	$religion = "";
	
for ($i = 0; $i < 10; $i++) {
		if ($datatmp[$i]=="0") {
			$datatmp[$i]="";
		}
	}
	
$nc+=1;

if ($curso=="3ESO") {
	
	if ($div_3 == $grupo_actual) {
			$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
			);
	}
	else{
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

if ($curso=="2ESO") {
	
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
			);
}


if ($curso=="1ESO") {
	
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
			);
}


if ($curso=="4ESO") {
	
if ($datatmp[7]=="1" or $datatmp[7]=="2") {
$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
			);
	}
		elseif ($datatmp[7]=="3") {
$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
			);
	}	
	else{
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
$txttit = "Lista del Grupo $curso-$grupo_actual\n";
$txttit.= $config['centro_denominacion'].". Curso ".$config['curso_actual'].".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);


$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);
	
$pdf->ezNewPage();
}
$pdf->ezStream();
?>