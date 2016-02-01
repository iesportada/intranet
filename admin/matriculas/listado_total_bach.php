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

		$sqldatos="SELECT concat(apellidos,', ',nombre),";
		if ($curso=="1BACH") {
		$sqldatos.="itinerario1, optativa1, idioma1, idioma2, ";
		$num_opc = 5;
		}
		else{
		$sqldatos.="itinerario2, optativa2, optativa2b1, optativa2b2, optativa2b3, optativa2b4, optativa2b5, optativa2b6, optativa2b7, optativa2b8, optativa2b9, optativa2b10, ";	
		$num_opc = 14;
		}
		$sqldatos .= "religion, bilinguismo FROM matriculas_bach WHERE curso = '$curso' and grupo_actual='".$grupo_actual[0]."' ORDER BY apellidos, nombre";

$lista= mysqli_query($db_con, $sqldatos );
$nc=0;
unset($data);
while($datatmp = mysqli_fetch_array($lista)) { 
	$bil = "";
    if($datatmp['bilinguismo']=="Si"){$bil = " (Bil.)";}
	$religion = "";
	for ($i = 0; $i < $num_opc; $i++) {
		if ($datatmp[$i]=="0") {
			$datatmp[$i]="";
		}
	}

$nc+=1;

if ($curso=="2BACH") {
for ($i = 3; $i < 13; $i++) {
		if ($datatmp[$i]=="1") {
			$datatmp[$i]="X";
		}
		else{
			$datatmp[$i]="";
		}
	}		
		if (strstr($datatmp[13],"Cat")==TRUE) {
			$religion ="X";
		}
		
	$opt = '
	
	Itinerarios: 1 => Ciencias de la Salud y Tecnológico; 2 => Humanidades y Ciencias Sociales
	
	Optativas:
	Opt.1 = Alemán 2º Idioma; Opt.2 = Francés 2º Idioma; Opt.3 = T.I.C.; Opt.4 = Ciencias de la Tierra y Medioambientales; Opt.5 = Historia de la Música y la Danza; Opt.6 = Literatura Universal; Opt.7 = Educación Física; Opt.8 = Estadística; Opt.9 = Introducción a las Ciencias de la Salud; Opt.10 = Inglés 2º Idioma;
	';
	$optas = str_replace("21","",$datatmp[2]);
	$optas = str_replace("22","",$optas);
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c1'=>$religion,
				'c2'=>$datatmp[1],
				'c3'=>$optas,
				'c4'=>$datatmp[3],
				'c5'=>$datatmp[4],
				'c6'=>$datatmp[5],
				'c7'=>$datatmp[6],
				'c8'=>$datatmp[7],
				'c9'=>$datatmp[8],
				'c10'=>$datatmp[9],
				'c11'=>$datatmp[10],
				'c12'=>$datatmp[11],
				'c13'=>$datatmp[12],
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c1'=>'Rel.Cat.',
				'c2'=>'It2',
				'c3'=>'Opt2',
				'c4'=>'1',
				'c5'=>'2',
				'c6'=>'3',
				'c7'=>'4',
				'c8'=>'5',
				'c9'=>'6',
				'c10'=>'7',
				'c11'=>'8',
				'c12'=>'9',
				'c13'=>'10',
			);
}
if ($curso=="1BACH") {

		if (strstr($datatmp[5],"Cat")==TRUE) {
			$religion ="R. Cat.";
		}
		elseif (strstr($datatmp[5],"Isl")==TRUE) {
			$religion ="R. Isl.";
		}
		elseif (strstr($datatmp[5],"Eva")==TRUE) {
			$religion ="R. Evan.";
		}
		elseif (strstr($datatmp[5],"Valo")==TRUE) {
			$religion ="E. Ciud.";
		}
		elseif (strstr($datatmp[5],"Cult")==TRUE) {
			$religion ="C. Cient.";
		}
		$opt = '
	
	Itinerarios de 1º de Bachillerato: 1 => Tecnología; 2 => Salud; 3 => Humanidades; 4 => Ciencias Sociales
	';
	$optas = str_replace("11","",$datatmp[2]);
	$optas = str_replace("12","",$optas);
	$data[] = array(
				'num'=>$nc,
				'nombre'=>$datatmp[0].$bil,
				'c1'=>$religion,
				'c2'=>$datatmp[1],
				'c3'=>$optas,
				'c4'=>$datatmp[3],
				'c5'=>$datatmp[4],
				);
	$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c1'=>'',
				'c2'=>'It1',
				'c3'=>'Opt1',
				'c4'=>'Idioma1',
				'c5'=>'Idioma2',
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
$txttit = "Lista del Grupo $curso-$grupo_actual[0]\n";
$txttit.= $config['centro_denominacion'].". Curso ".$config['curso_actual'].".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText($opt, '10', $options);

$pdf->ezText("\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);

$pdf->ezNewPage();
}
$pdf->ezStream();
?>