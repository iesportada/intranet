<?php
require('../../bootstrap.php');

require_once('../../pdf/class.ezpdf.php');
$pdf =& new Cezpdf('a4','landscape');
$pdf->selectFont('../../pdf/fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

// Días de la semana 
$profe1 = mysqli_query($db_con, "SELECT distinct prof, no_prof from horw_faltas order by prof");
while($profe2 = mysqli_fetch_array($profe1))
{
unset($datos);
$dia="";
$nombre="";
$i="";
${'a'.$i}="";
$profesor = $profe2[0];
$no_prof+=1;
$profes = "<b>FALTAS DE ASISTENCIA</b>    -    <b>$no_prof</b> => $profesor     Semana de ................... a ...................";
$horas=array(1=>"1ª Hora",2=>"2ª Hora",3=>"3ª Hora",4=>"4ª Hora",5=>"5ª Hora",6=>"6ª Hora");
foreach($horas as $n_hora => $nombre) 
{
for($i=1;$i<6;$i++) 
{
	
${'a'.$i}="";
$asignaturas1 = mysqli_query($db_con, "SELECT distinct a_asig, a_grupo FROM  horw_faltas where prof = '$profesor' and dia = '$i' and hora = '$n_hora'");
while($rowasignaturas1 = mysqli_fetch_array($asignaturas1))
 {
 	$grupo = $rowasignaturas1[1];
	${'a'.$i}.= "<b>".$grupo."</b> - <i>".$rowasignaturas1[0]."</i>\n\n"; 
 }
 ${'a'.$i}=substr(${'a'.$i},0,strlen(${'a'.$i})-1);
}
$datos[] = array(
    'c0'=>'<b>'.strtoupper($nombre).'</b>',
	'c1'=>$a1,
	'c2'=>$a2,
	'c3'=>$a3,
	'c4'=>$a4,
	'c5'=>$a5,
    );
}
$titles = array(
				'c0'=>'',
				'c1'=>'<b>L</b>',
				'c2'=>'<b>M</b>',
				'c3'=>'<b>X</b>',
				'c4'=>'<b>J</b>',
				'c5'=>'<b>V</b>',
				);
$options = array(
				'showLines'=> 2,
				'shadeCol'=>array(1,1,1),
				'xOrientation'=>'center',
				'fontSize'=>9,
				'width'=>780,
				'innerLineThickness'=>0.5,
  				'outerLineThickness'=>0.9,
  				'lineCol'=>array(0.1,0.1,0.1),
  				'rowGap' => 10, 
  				'titleFontSize' => 11,
  				'titleGap' => 8,
				'cols' => array(
				'c0'=>array('width'=>65),
				'c1'=>array('justification'=>'center'),
				'c2'=>array('justification'=>'center'),
				'c3'=>array('justification'=>'center'),
				'c4'=>array('justification'=>'center'),
				'c5'=>array('justification'=>'center'),
				'c6'=>array('justification'=>'center')
				)
		);
$pdf->ezTable($datos, $titles, $title=$profes, $options);
$pdf->ezNewPage();
}
$pdf->ezStream(); 
?>