<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

require_once('../../pdf/class.ezpdf.php');

$pdf =& new Cezpdf('a4');
$pdf->selectFont('../../pdf/fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
# hasta aquí lo del pdf
$options_center = array(
				'justification' => 'center'
			);
$options_right = array(
				'justification' => 'right'
			);
$options_left = array(
				'justification' => 'left'
					);
//$grupo_actual = $_POST['grupo_actual'];					
	if ($curso=="3ESO") {
		$sqldatos="SELECT concat(apellidos,', ',nombre), exencion, optativa1, optativa2, optativa3, optativa4, optativa5, optativa6, optativa7, act1, religion FROM matriculas WHERE curso = '$curso' and grupo_actual='".$cur_actual."' ORDER BY apellidos, nombre";
	}
	else{
		$sqldatos="SELECT concat(apellidos,', ',nombre), exencion, optativa1, optativa2, optativa3, optativa4, act1, itinerario, religion FROM matriculas WHERE curso = '$curso' and grupo_actual='".$cur_actual."' ORDER BY apellidos, nombre";
	}
	//echo $sqldatos;
$lista= mysqli_query($db_con, $sqldatos );
$nc=0;
unset($data);
while($datatmp = mysqli_fetch_array($lista)) { 
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
}
else 
{
for ($i = 2; $i < 6; $i++) {
if ($datatmp[$i]=="1") {
			$datatmp[$i]="X";
		}
		else{
			$datatmp[$i]="";
		}
	}	
}

for ($i = 0; $i < 10; $i++) {
		if ($datatmp[$i]=="0") {
			$datatmp[$i]="";
		}
	}

$nc+=1;
if ($curso=="3ESO") {	
		if (strstr($datatmp[10],"Rel")==TRUE) {
			$religion ="X";
		}
}
else{
	if (strstr($datatmp[8],"Rel")==TRUE) {
			$religion ="X";
		}
}
if ($curso=="3ESO") {
		
		if (strstr($datatmp[10],"Rel")==TRUE) {
			//$datatmp[$i]="X";
			$religion ="X";
		}
	$opt = "
	
	Optativas:
	1 => Alemán 2º Idioma,	2 => Cambios Sociales y Género,	3 => Francés 2º Idioma,	4 => Cultura Clásica,	5 => Taller T.I.C. III,	6 => Taller de Cerámica, 7 => Taller de Teatro
	";
	
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
				'c9'=>$religion,
				'c2'=>$datatmp[2],
				'c3'=>$datatmp[3],
				'c4'=>$datatmp[4],
				'c5'=>$datatmp[5],
				'c6'=>$datatmp[6],
				'c7'=>$datatmp[7],
				'c8'=>$datatmp[8],
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c9'=>'Rel.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c6'=>'Opt5',
				'c7'=>'Opt6',
				'c8'=>'Opt7',
			);
}

if ($curso=="2ESO") {

		$act = "
	Actividades de Refuerzo y Ampliación:
	1 => Actividades de refuerzo de Inglés, 2 => Actividades de refuerzo de Lengua Castellana, 3 => Actividades de refuerzo de Matemáticas,		4 => Ampliación: Taller T.I.C. II";	
		
		$opt = "
	
	Optativas:
	1 => Alemán 2º Idioma, 2 => Cambios Sociales y Género,	3 => Francés 2º Idioma,	4 => Métodos de la Ciencia";
	
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
				'c7'=>'Rel.',
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
	1 => Actividades de refuerzo de Inglés, 2 => Actividades de refuerzo de Lengua Castellana, 3 => Actividades de refuerzo de Matemáticas,		4 => Ampliación: Taller T.I.C., 5 => Ampliación: Taller de Teatro";		
	
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
				'c7'=>'Rel.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				'c6'=>'Act.',
			);
}


if ($curso=="4ESO") {
	if ($datatmp[7]=="1") {
		$opt = "
	
	Optativas Itinerario 1:
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Informática
	";
	}
if ($datatmp[7]=="2") {
		$opt = "
	
	Optativas Itinerario 2:
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Informática, 4 => Ed. Plástica y Visual
	";
	}
if ($datatmp[7]=="3") {
		$opt = "
	
	Optativas Itinerario 3:
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Informática,	4 => Ed. Plástica y Visual
	";
	}
if ($datatmp[7]=="4") {
		$opt = "
	
	Optativas Itinerario 4:
	1 => Alemán 2º Idioma,	2 => Francés 2º Idioma,	3 => Tecnología
	";
	}	
	
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0],
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
				'c6'=>'Rel.',
				'It.'=>'Itiner.',
				'c2'=>'Opt1',
				'c3'=>'Opt2',
				'c4'=>'Opt3',
				'c5'=>'Opt4',
				
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
				'width'=>500
			);
$txttit = "Lista del Grupo $curso-$cur_actual[0]\n";
$txttit.= $config['centro_denominacion'].". Curso ".$config['curso_actual'].".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText($opt, '10', $options);
if ($curso == "1ESO" or $curso == "2ESO") {
	$pdf->ezText($act, '10', $options);
}
$pdf->ezText("\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);

$pdf->ezStream();
?>