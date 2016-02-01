<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

require("../../pdf/pdf_js.php");
//require("../pdf/mc_table.php");

class PDF_AutoPrint extends PDF_JavaScript
{
function AutoPrint($dialog=false)
{
    //Open the print dialog or start printing immediately on the standard printer
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
    //Print on a shared printer (requires at least Acrobat 6)
    $script = "var pp = getPrintParams();";
    if($dialog)
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
    else
        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
    $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
    $script .= "print(pp);";
    $this->IncludeJS($script);
}
}
define ( 'FPDF_FONTPATH', '../../pdf/font/' );
# creamos el nuevo objeto partiendo de la clase ampliada
$MiPDF = new PDF_AutoPrint();
$MiPDF->SetMargins ( 20, 20, 20 );
# ajustamos al 100% la visualizaciÃ³n
$MiPDF->SetDisplayMode ( 'fullpage' );
// Consulta  en curso. 
if (substr($curso, 0, 1) == '1') {
	$mas = ", colegio";
}
//echo "select distinct id_matriculas from matriculas_temp, matriculas where id=id_matriculas order by curso".$mas.", letra_grupo, apellidos, nombre" ;
$result0 = mysqli_query($db_con, "select distinct id_matriculas from matriculas_temp, matriculas where id=id_matriculas order by curso".$mas.", letra_grupo, apellidos, nombre" );
while ($id_ar = mysqli_fetch_array($result0)) {
$id = "";
$id = $id_ar[0];
$result = mysqli_query($db_con, "select * from matriculas where id = '$id'");
if ($row = mysqli_fetch_array ( $result )) {
	 $apellidos = "Apellidos del Alumno: ". $row[2];
	 $nombre= "Nombre: ".$row[3];
	 $nacido= "Nacido en: ".$row[4];
	 $provincia= "Provincia de: ".$row[5];
	 $fecha_nacimiento= "Fecha de Nacimiento: ". cambia_fecha($row[6]);
	 $domicilio= "Domicilio: ".$row[7];
	 $localidad= "Localidad: ".$row[8];
	 $dni= "DNI del alumno: ".$row[9];
	 $padre= "Apellidos y nombre del Tutor legal 1: ".$row[10];
	 $dnitutor= "DNI: ".$row[11];
	 $madre= "Apellidos y nombre del Tutor legal 2: ".$row[12];
	 $dnitutor2= "DNI: ".$row[13];
	 $telefono1= "Teléfono Casa: ".$row[14];
	 $telefono2= "Teléfono Móvil: ".$row[15];
	 $telefonos="$telefono1\n   $telefono2";
	 $idioma = $row['idioma'];
	 $religion = $row['religion'];
	 $itinerario = $row['itinerario'];
	 $matematicas4 = $row['matematicas4'];
	 $matematicas3 = $row['matematicas3'];

	 if ($row[16] == "Otro Centro") { $colegio= "Centro de procedencia:  ".$row[17]; }else{	 $colegio= "Centro de procedencia:  ".$row[16]." (".$row['letra_grupo'].")"; }
	 $correo= "Correo electrónico de padre o madre: ".$row[19];
	 // Optativas y refuerzos
	 $n_curso = substr($curso, 0, 1);
	 $n_curso2 = $n_curso-1;
	 if ($n_curso == '1') {
$opt1 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Tecnología Aplicada");
$a1 = array("Actividades de Lengua Castellana ", "Actividades de Matemáticas", "Actividades de Inglés", "Taller T.I.C.","Taller de Teatro","Taller de Lenguas Extranjeras");
	 }
	 if ($n_curso == '2') {
$opt1 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Métodos de la Ciencia");
$a1 = array("Actividades de Lengua Castellana ", "Actividades de Matemáticas", "Actividades de Inglés", "Taller T.I.C. II","Taller de Teatro II");
$opt21 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Tecnología Aplicada");
$a21 = array("Actividades de Lengua Castellana ", "Actividades de Matemáticas", "Actividades de Inglés", "Taller T.I.C.","Taller de Teatro","Taller de Lenguas Extranjeras");
	 }
	 if ($n_curso == '3') {
$opt1 = array("Alemán 2º Idioma","Cambios Sociales", "Francés 2º Idioma","Cultura Clásica", "Taller T.I.C. III", "Taller de Cerámica", "Taller de Teatro");
$opt21 = array("Alemán 2º Idioma","Cambios Sociales", "Francés 2º Idioma","Métodos de la Ciencia");
$a21 = array("Actividades de Lengua Castellana ", "Actividades de Matemáticas", "Actividades de Inglés", "Taller T.I.C. II");
	 }
if ($n_curso == '4') {
	$it41 = array("(Bachillerato de Ciencias y Tecnología - Vía de Ciencias de la Naturaleza y la Salud)", "Física y Química", "Biología y Geología", "Matemáticas B", "Alemán 2º Idioma", "Francés 2º Idioma", "Informática");
	$it42 = array("(Bachillerato de Ciencias y Tecnología - Vía de Ciencias e Ingeniería)", "Física y Química", "Tecnología", "Matemáticas B", "Alemán 2º Idioma", "Francés 2º Idioma", "Informática", "Ed. Plástica y Visual");
	$it43 = array("(Bachillerato de Humanidades y Ciencias Sociales)", "Latín", "Música", "Matemáticas A", "Matemáticas B", "Alemán 2º Idioma", "Francés 2º Idioma", "Informática", "Ed. Plástica y Visual");
	$it44 = array("(Ciclos Formativos y Mundo Laboral)", "Informática", "Ed. Plástica y Visual", "Matemáticas A", "Alemán 2º Idioma", "Francés 2º Idioma", "Tecnología");
	
	$opt41=array("Alemán 2º Idioma", "Francés 2º Idioma", "Informática");
	$opt42=array("Alemán 2º Idioma", "Francés 2º Idioma","Informática", "Ed. Plástica y Visual");
	$opt43=array("Alemán 2º Idioma", "Francés 2º Idioma", "Informática", "Ed. Plástica y Visual");
	$opt44=array("Alemán 2º Idioma", "Francés 2º Idioma", "Tecnología");
	
	$opt21 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Cultura Clásica", "Taller T.I.C. III", "Taller de Cerámica", "Taller de Teatro");
}
if ($n_curso < '4'){
	 $optativa1= "$row[22] - $opt1[0]";
	 $optativa2= "$row[23] - $opt1[1]";
	 $optativa3= "$row[24] - $opt1[2]";
	 $optativa4= "$row[25] - $opt1[3]";
	 if($n_curso=='3'){
	 $optativa5= "$row[52] - $opt1[4]";
	 $optativa6= "$row[53] - $opt1[5]";
	 $optativa7= "$row[54] - $opt1[6]";
		 }
}
else{
	$n_opt="";
	foreach (${opt4.$itinerario} as $clave4){
	$n_opt+=1;
	$n_row=21+$n_opt;
	 ${optativa.$n_opt} = "$row[$n_row] - $clave4";
	}

}

	 for ($i=1;$i<6;$i++)
	 {
	 	if ($row[26] == $i) {
	 		${act.$i} = " X  " . $a1[$i-1];
	 	}
	 	else{
	 		${act.$i} = "      ".$a1[$i-1];
	 	}
	 }

	 
	 $optativa21= "$row[30] - $opt21[0]";
	 $optativa22= "$row[31] - $opt21[1]";
	 $optativa23= "$row[32] - $opt21[2]";
	 $optativa24= "$row[33] - $opt21[3]";
 	 $optativa25= "$row[56] - $opt21[4]";
 	 $optativa26= "$row[57] - $opt21[5]";
 	 $optativa27= "$row[58] - $opt21[6]";
	 for ($i=1;$i<7;$i++)
	 {
	 	if ($row[34] == $i) {
	 		${act2.$i} = " X  " . $a21[$i-1];
	 	}
	 	else{
	 		${act2.$i} = "      ".$a21[$i-1];
	 	}
	 }

	 
	 $observaciones= "OBSERVACIONES: ".$row[38];
	 $texto_exencion= "El alumno solicita la exención de la Asignatura Optativa";
	 $texto_bilinguismo= "El alumno solicita participar en el Programa de Bilinguismo";
	 $curso = $row[41];
	 $fecha_total = $row[42];
	 $transporte = $row[44];
	 $ruta_este = $row[45];
	 $ruta_oeste = $row[46];
	 $texto_transporte = "Transporte escolar: $ruta_este$ruta_oeste.";
	 $sexo = $row[47];
	 if ($row[48] == '' or $row[48] == '0') { $hermanos = ""; } else{ $hermanos = $row[48]; }
	 
	 $nacionalidad = $row[49];
}
$fech = explode(" ",$fecha_total);
$fecha = $fech[0];
$titulo1 = "SOLICITUD DE MATRÍCULA EN ".$n_curso."º DE E.S.O.";
$an = substr($config['curso_actual'],0,4);
$an1 = $an+1;
$hoy = formatea_fecha(date('Y-m-d'));
$cuerpo3 = "En ".$config['centro_localidad'].", a $hoy
Firma del Padre/Madre/Representante legal D/Dª



Fdo. D/Dª ---------------------------------------------
que asegura la veracidad de los datos registrados en el formulario.
";
$datos_centro = "PROTECCIÓN DE DATOS.\n En cumplimiento de lo dispuesto en la Ley Orgánica 15/1999, de 13 de Diciembre, de Protección de Datos de Carácter Personal, el ".$config['centro_denominacion']." le informa que los datos personales obtenidos mediante la cumplimentación de este formulario y demás documentación que se adjunta van a ser incorporados, para su tratamiento, a nuestra base de datos, con la finalidad de recoger los datos personales y académicos del alumnado que cursa estudios en nuestro Centro, así como de las respectivas unidades familiares.\n De acuerdo con lo previsto en la Ley, puede ejercer los derechos de acceso, rectificación, cancelación y oposición dirigiendo un escrito a la Secretaría del Instituto en ".$config['centro_direccion'].", ".$config['centro_codpostal']." ".$config['centro_localidad'].", Málaga";

	# insertamos la primera pagina del documento
	$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'Times', '', 10  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	
	
	// Formulario de matrícula

	#Cuerpo.
	$MiPDF->Image ( '../../img/encabezado2.jpg', 10, 10, 180, '', 'jpg' );
	$MiPDF->Ln ( 10 );
	$MiPDF->Multicell ( 0, 4, $titulo1, 0, 'C', 0 );
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(168,6,"DATOS PERSONALES DEL ALUMNO",1,0,'C',1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(112,8,$apellidos,1);

	$MiPDF->Cell(56,8,$nombre,1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(56,8,$nacido,1);
	$MiPDF->Cell(56,8,$provincia,1);
	$MiPDF->Cell(56,8,$fecha_nacimiento,1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(72,8,$domicilio,1);
	$MiPDF->Cell(40,8,$localidad,1);
	$MiPDF->Cell(56,8,$dni,1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(112,8,$padre,1);
	$MiPDF->Cell(56,8,$dnitutor,1);
	if (strlen($madre)>38) {
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(112,8,$madre,1);
	$MiPDF->Cell(56,8,$dnitutor2,1);
	}
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(90,8,$telefonos,1);
	$MiPDF->Cell(78,8,$colegio,1);
	if ($transporte=='1') {
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(168,8,$texto_transporte,1);	
	}
	if (strlen($correo)>38) {
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(168,8,$correo,1);	
	}
	$MiPDF->Ln ( 10 );
	$MiPDF->Cell(84,6,"IDIOMA EXTRANJERO",1,0,'L',1);
	$MiPDF->Cell(84,6,"ENSEÑANZA DE RELIGIÓN O ALTERNATIVA",1,0,'L',1);
	$MiPDF->Ln ( 6);
	$MiPDF->Cell(84,8,$idioma,0);
	$MiPDF->Cell(84,8,$religion,0);
	$MiPDF->Ln ( 8 );
	if($n_curso<'3'){
	$MiPDF->Cell(84,6,"ASIGNATURAS OPTATIVAS",1,0,'L',1);
	$MiPDF->Cell(84,6,"PROGRAMA DE REFUERZO O ALTERNATIVO",1,0,'L',1);
	$MiPDF->Ln ( 6 );
	}
	else{
		if($n_curso=='4'){
	$MiPDF->Cell(168,6,"ITINERARIO $itinerario: ASIGNATURAS OPTATIVAS",1,0,'C',1);
	$MiPDF->Ln ( 6 );
		}
		else{
	$MiPDF->Cell(168,6,"ASIGNATURAS OPTATIVAS",1,0,'C',1);
	$MiPDF->Ln ( 6 );
		}
	}
	// $MyPDF->FillColor();
	if($n_curso<3){
	$MiPDF->Cell(84,8,$optativa1,0);
	$MiPDF->Cell(84,8,$act1,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa2,0);
	$MiPDF->Cell(84,8,$act2,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa3,0);
	$MiPDF->Cell(84,8,$act3,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa4,0);
	$MiPDF->Cell(84,8,$act4,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,"",0);
	$MiPDF->Cell(84,8,$act5,0);
	$MiPDF->Ln ( 5 );
	if ($n_curso=='1') {
	$MiPDF->Cell(84,8,"",0);
	$MiPDF->Cell(84,8,$act5,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,"",0);
	$MiPDF->Cell(84,8,$act6,0);
	$MiPDF->Ln ( 5 );
	}
	}
	elseif($n_curso=='4'){
	if ($itinerario == "3") {
	$MiPDF->Cell(84,8,$optativa1,0);
	$MiPDF->Cell(84,8,"Matematicas $matematicas4",0);
	$MiPDF->Ln ( 5 );
	}
	else{
	$MiPDF->Cell(168,8,$optativa1,0);
	$MiPDF->Ln ( 5 );
	}
	$MiPDF->Cell(168,8,$optativa2,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(168,8,$optativa3,0);
	if ($itinerario=="2" or $itinerario=="3") {
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(168,8,$optativa4,0);
	}
	$MiPDF->Ln ( 5 );
	}
	elseif($n_curso=='3'){
	if ($matematicas3=="A") {$mat_3="Matemáticas Académicas (Bachillerato)";}else{$mat_3="Matemáticas Aplicadas (Formación Profesional)";}
	$MiPDF->Cell(168,6,$mat_3,1,0,'C',0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa1,0);
	$MiPDF->Cell(84,8,$optativa5,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa2,0);
	$MiPDF->Cell(84,8,$optativa6,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa3,0);
	$MiPDF->Cell(84,8,$optativa7,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa4,0);
	$MiPDF->Cell(84,8,"",0);
	$MiPDF->Ln ( 5 );
	}
	if (substr($curso, 0, 1) == 2 or substr($curso, 0, 1) == 3){
	$MiPDF->Ln ( 7 );
	$MiPDF->Cell(168,6,"ASIGNATURAS DE ".$n_curso2."º DE ESO",1,0,'C',1);
	$MiPDF->Ln ( 6 );
	$MiPDF->Cell(84,6,"ASIGNATURA OPTATIVA",1,0,'L',1);
	$MiPDF->Cell(84,6,"PROGRAMA DE REFUERZO O ALTERNATIVO",1,0,'L',1);
	$MiPDF->Ln ( 6 );
	// $MyPDF->FillColor();
	$MiPDF->Cell(84,8,$optativa21,0);
	$MiPDF->Cell(84,8,$act21,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa22,0);
	$MiPDF->Cell(84,8,$act22,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa23,0);
	$MiPDF->Cell(84,8,$act23,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa24,0);
	$MiPDF->Cell(84,8,$act24,0);
	if ($n_curso=="2") {
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,"",0);
	$MiPDF->Cell(84,8,$act25,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,"",0);
	$MiPDF->Cell(84,8,$act26,0);
	}
	}
	elseif (substr($curso, 0, 1) == 4){
	$MiPDF->Ln ( 7 );
	$MiPDF->Cell(168,6,"ASIGNATURAS OPTATIVAS DE ".$n_curso2."º DE ESO",1,0,'C',1);
	$MiPDF->Ln ( 6 );
	$MiPDF->Cell(84,8,$optativa21,0);
	$MiPDF->Cell(84,8,$optativa25,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa22,0);
	$MiPDF->Cell(84,8,$optativa26,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa23,0);
	$MiPDF->Cell(84,8,$optativa27,0);
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,8,$optativa24,0);
	$MiPDF->Cell(84,8,"",0);
	$MiPDF->Ln ( 5 );
	}
	else{
	$MiPDF->Ln ( 7 );		
	}
		
	if ($row[39]=='1') {
	$MiPDF->Ln ( 7 );	
	$MiPDF->Cell(168,5,$texto_exencion,1,0,'L',1);
	}
	if ($row[40]=='Si') {
		$MiPDF->Ln ( 7 );
		$MiPDF->Cell(168,5,$texto_bilinguismo,1,0,'L',1);
	}
	$MiPDF->Ln ( 8 );
	if (strlen($observaciones)>15) {
	$MiPDF->MultiCell(168,4,$observaciones,0,'L');
	$MiPDF->Ln ( 3);		
	}
	else{
	$MiPDF->Ln ( 8 );		
	}
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->Multicell ( 0, 5, $cuerpo3, 0, 'C', 0 );
	$MiPDF->SetFont ( 'Times', 'B', 7 );
	$MiPDF->SetTextColor ( 120, 120, 120 );	
	$MiPDF->SetFillColor(248,248,248);
	$MiPDF->Ln ( 4 );		
	$MiPDF->MultiCell(168, 3, $datos_centro,1,'L',1);
	}
   $MiPDF->AutoPrint(true);     
   $MiPDF->Output ();

?>