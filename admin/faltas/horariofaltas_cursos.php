<?php
require('../../bootstrap.php');
require_once('../../pdf/class.ezpdf.php');
$pdf =& new Cezpdf('a4');
$pdf->selectFont('../../pdf/fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
$options_center = array(
				'justification' => 'center'
			);
$options_right = array(
				'justification' => 'right'
			);
$options_left = array(
				'justification' => 'left'
					);
# hasta aquí lo del pdf

if($dia1=='Lunes'){$dia = "1";}
if($dia1=='Martes'){$dia = "2";}
if($dia1=='Miércoles'){$dia = "3";}
if($dia1=='Jueves'){$dia = "4";}
if($dia1=='Viernes'){$dia = "5";}
		
$sqldatos="SELECT concat(apellidos,', ',nombre), NC FROM FALUMNOS WHERE unidad='$unidad ' ORDER BY NC";
//echo $sqldatos;
$lista= mysqli_query($db_con, $sqldatos );
$num=0;
unset($data);
$ixx = 0;
while($datatmp = mysqli_fetch_array($lista)) { 
	$ixx = $datatmp[1];
	$data[] = array(
				'num'=>$ixx,
				'nombre'=>$datatmp[0]				
				);
}
$firma="Observaciones:\n\n\n\n\n\n\n\n";
$data[]=array(
			'num'=>'',
			'nombre'=>$firma
			);
for($i=1;$i<7;$i++){
$curso0 = $unidad;
$rowasignaturas1="";
${'a'.$i}="";
$asignaturas1 = mysqli_query($db_con, "SELECT distinct a_asig FROM horw where  dia= '$dia' and hora = '$i' and a_grupo like '%$curso0%'");
 	while ( $rowasignaturas1 = mysqli_fetch_array($asignaturas1)){	
		${'a'.$i}.= $rowasignaturas1[0]."\n"; 
 }
 ${'a'.$i}=substr(${'a'.$i},0,strlen(${'a'.$i})-1);
 } 
$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c1'=>$a1,
				'c2'=>$a2,
				'c3'=>$a3,
				'c4'=>$a4,
				'c5'=>$a5,
				'c6'=>$a6,
			);
$options = array(
				'showLines'=> 2,
				'shadeCol'=>array(0.94,0.94,0.94),
				'xOrientation'=>'center',
				'width'=>500,
				'fontSize'=>9,
				'innerLineThickness'=>0.5,
  				'outerLineThickness'=>0.8
			);
$txttit = "<b>Parte de faltas del Alumno</b>     <b>Grupo $unidad</b>     $dia1      Fecha: ____/____/_________\n";
		
$pdf->ezText($txttit, 11,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n", 10);
$pdf->ezText("<b>A</b> - Ir al Aseo.<b> B</b> - Ir a beber agua.<b>F </b> - Falta de Asistencia.<b> R</b> - Retraso injustificado.<b> J</b> - Viene de Jefatura.", 9,$options_center);
$pdf->ezNewPage();
$pdf->ezStream();
?>