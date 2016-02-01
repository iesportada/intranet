<?php 
require('../../bootstrap.php');

if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];} elseif (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];} elseif (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];} else{$nombre="";}
if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];} elseif (isset($_GET['apellidos'])) {$apellidos = $_GET['apellidos'];} else{$apellidos="";}
if (isset($_GET['clave_al'])) {$clave_al = $_GET['clave_al'];} else{$clave_al="";}

# para el pdf
require_once('../../pdf/class.ezpdf.php');
$pdf=new Cezpdf('a4','landscape');

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

// Número de grupo para los saltos de página
$numg=0;
$grupo=$_POST['unidad'];
$n=count($grupo);
foreach ($grupo as $grupo1)
{ 
$numg++;
//$g=$grupo[$i];

$sqldatos="SELECT concat(alma.apellidos,', ',alma.nombre),Fecha,matriculas,Sexo,padre,Domicilio,Telefonourgencia,alma.claveal, Telefono, nc FROM alma, FALUMNOS WHERE FALUMNOS.claveal=alma.claveal and alma.unidad='".$grupo1."' ORDER BY nc";
//echo $sqldatos;
$lista= mysqli_query($db_con, $sqldatos) or die (mysqli_error($db_con));
$num=0;
unset($data);
$ixx = 0;
while($datatmp = mysqli_fetch_array($lista)) { 
	$ixx = $ixx+1;
	$tels = trim($datatmp[6]."    ".$datatmp[8]);
	if ($datatmp[2]>1) {
                		$repite="Sí";
                	}
                	else{
                		$repite="No";
                	}
	$data[] = array(
				'num'=>$datatmp[9],
				'nombre'=>$datatmp[0],
				'fecha'=>cambia_fecha($datatmp[1]),
				'Repite'=>$repite,
				'NIE'=>$datatmp[7],
				'Tutor'=>$datatmp[4],
				'Domicilio'=>$datatmp[5],
				'Telefonos'=>$tels
				);
}
$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno/a</b>',
				'fecha'=>'<b>Fecha ncto.</b>',
				'Repite'=>'<b>Rep.</b>',
				'NIE'=>'<b>NIE</b>',
				'Tutor'=>'<b>Padre / madre</b>',
				'Domicilio'=>'<b>Domicilio</b>',
				'Telefonos'=>'<b>Teléfono(s)</b>'
				#'direccion'=>'<b>Direccion</b>',
				#'telefono'=>'<b>Telefono</b>'
			);
$options = array(
				'showLines'=> 2,
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'fontSize' => 8,
				'width'=>775
			);
$txttit = "<b>Datos del grupo ".$grupo1."</b>\n";
	
$pdf->ezText($txttit, 14,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n", 4);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_left);
#####  Hasta aquí la lista con cuadrícula

//echo $numg;
if ($numg!=$n){$pdf->ezNewPage();unset($data);unset($titles);}
} #del for
$pdf->ezStream();
?>
