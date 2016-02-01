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
		$sqldatos="SELECT concat(apellidos,', ',nombre), exencion, optativa1, optativa2, optativa3, optativa4, optativa5, optativa6, optativa7, act1, religion, diversificacion, matematicas3, bilinguismo FROM matriculas WHERE curso = '$curso' and grupo_actual='".$grupo_actual."' ORDER BY apellidos, nombre";
		$div3=mysqli_query($db_con,"SELECT diversificacion FROM matriculas WHERE curso = '$curso' and grupo_actual='".$grupo_actual."' and diversificacion='1'");
		if (mysqli_num_rows($div3)>0) {
			$div_3 = $grupo_actual;
		}		
	}
	else{
		$sqldatos="SELECT concat(apellidos,', ',nombre), exencion, optativa1, optativa2, optativa3, optativa4, act1, itinerario, religion, diversificacion, matematicas4, bilinguismo FROM matriculas WHERE curso = '$curso' and grupo_actual='".$grupo_actual."' ORDER BY apellidos, nombre";
	}
$lista= mysqli_query($db_con, $sqldatos );
$nc=0;
unset($data);
while($datatmp = mysqli_fetch_array($lista)) { 
        $bil = "";
        if($datatmp['bilinguismo']=="Si"){$bil = " (Bil.)";}
        
	$religion = "";
	
if ($curso=="3ESO") {
for ($i = 2; $i < 9; $i++) {
		if ($datatmp[$i]=="1") {
			$datatmp[$i]="X";
		}
		else{
			$datatmp[$i]="";
		}
	}
	// Diversificación
if ($datatmp[11]=="1") {
			$datatmp[11]="X";
		}
		else{
			$datatmp[11]="";
		}
}
else {
for ($i = 2; $i < 6; $i++) {
if ($datatmp[$i]=="1") {
			$datatmp[$i]="X";
		}
		else{
			$datatmp[$i]="";
		}		
	}

	// Diversificación
if ($datatmp[9]=="1") {
			$datatmp[9]="X";
		}
	
}

for ($i = 0; $i < 10; $i++) {
		if ($datatmp[$i]=="0") {
			$datatmp[$i]="";
		}
	}
	
$nc+=1;
if ($curso=="3ESO") {	
		if (strstr($datatmp[10],"Cat")==TRUE) {
			$religion ="X";
		}
}
else{
	if (strstr($datatmp[8],"Cat")==TRUE) {
			$religion ="X";
		}
}
if ($curso=="3ESO") {
		
	$opt = "
	
	Optativas:
	1 => Alemán 2º Idioma,	2 => Cambios Sociales y Género,	3 => Francés 2º Idioma,	4 => Cultura Clásica, 5 => Taller T.I.C. III,	6 => Taller de Cerámica, 7 => Taller de Teatro
	
	Matemáticas: A => Mat. Académicas; B => Mat. Enseñanzas Aplicadas
	";
	if ($div_3 == $grupo_actual) {
			$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c9'=>$religion,
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				'c6'=>$datatmp[6],
				'c7'=>$datatmp[7],
				'c8'=>$datatmp[8],
				'c11'=>$datatmp[11],
				'c12'=>$datatmp[12],
				
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c9'=>'Rel. Cat.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c6'=>'Opt5',
				'c7'=>'Opt6',
				'c8'=>'Opt7',
				'c11'=>'Div',
				'c12'=>'Mat',
			);
	}
	else{
			$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c10'=>$religion,
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				'c6'=>$datatmp[6],
				'c7'=>$datatmp[7],
				'c8'=>$datatmp[8],
				'c9'=>$datatmp[12],
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c10'=>'Rel. Cat.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c6'=>'Opt5',
				'c7'=>'Opt6',
				'c8'=>'Opt7',
				'c9'=>'Mat',
			);
	}

}

if ($curso=="2ESO") {
	
		$act = "
	Actividades de Refuerzo y Ampliación:
	1 => Actividades de refuerzo de Lengua Castellana, 2 => Actividades de refuerzo de Matemáticas, 3 => Actividades de refuerzo de Inglés,4 => Ampliación: Taller T.I.C. II, 5 => Taller de Teatro";	
		
		$opt = "
	
	Optativas:
	1 => Alemán 2º Idioma, 2 => Cambios Sociales y Género,	3 => Francés 2º Idioma,	4 => Métodos de la Ciencia";
	
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c7'=>$religion,
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				'c6'=>$datatmp[6],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c7'=>'Rel. Cat.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c6'=>'Act.',
			);
}


if ($curso=="1ESO") {
	$act = "
	Actividades de Refuerzo y Ampliación:
	1 => Actividades de refuerzo de Lengua Castellana, 2 => Actividades de refuerzo de Matemáticas, 3 => Actividades de refuerzo de Inglés,	4 => Ampliación: Taller T.I.C., 5 => Ampliación: Taller de Teatro";		
	
		$opt = "
					
	Optativas:
	1 => Alemán 2º Idioma,	2 => Cambios Sociales y Género, 3 => Francés 2º Idioma,	4 => Tecnología Aplicada";
	
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				'c7'=>$religion,
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				'c6'=>$datatmp[6],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c7'=>'Rel. Cat.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c6'=>'Act.',
			);
}


if ($curso=="4ESO") {

		$opt = "
	
	Optativas Itinerario 1 (Salud):
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Informática
	Optativas Itinerario 2 (Tecnológico):
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Informática, 4 => Ed. Plástica y Visual
	Optativas Itinerario 3 (Ciencias Sociales):
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Informática,	4 => Ed. Plástica y Visual
	Optativas Itinerario 4 (FP: Salidas laborales):
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Tecnología
	";
	
if ($datatmp[7]=="1" or $datatmp[7]=="2") {
$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c6'=>$religion,
				'It.'=>$datatmp[7],
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c6'=>'Rel. Cat.',
				'It.'=>'Itiner.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
			);
	}
		elseif ($datatmp[7]=="3") {
$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c6'=>$religion,
				'It.'=>$datatmp[7],
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				'c10'=>$datatmp[10],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c6'=>'Rel. Cat.',
				'It.'=>'Itiner.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c10'=>'Mat.',
			);
	}	
	else{
		$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c6'=>$religion,
				'It.'=>$datatmp[7],
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				'c9'=>$datatmp[9],
				);

	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c6'=>'Rel. Cat.',
				'It.'=>'Itiner.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c9'=>'Div.',				
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
				'width'=>500
			);
$txttit = "Lista del Grupo $curso-$grupo_actual\n";
$txttit.= $config['centro_denominacion'].". Curso ".$config['curso_actual'].".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText($opt, '10', $options);
if ($curso == "1ESO" or $curso == "2ESO") {
	$pdf->ezText($act, '10', $options);
}
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);
	
$pdf->ezNewPage();
}
$pdf->ezStream();
?>