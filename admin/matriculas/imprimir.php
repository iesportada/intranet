<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

require("../../pdf/pdf_js.php");

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
$n_curso = substr($curso, 0, 1);
$result0 = mysqli_query($db_con, "select distinct id_matriculas from matriculas_temp, matriculas where id=id_matriculas order by curso".$mas.", letra_grupo, apellidos, nombre" );
//echo "select distinct id_matriculas from matriculas_temp, matriculas where id=id_matriculas order by curso".$mas.", letra_grupo, apellidos, nombre";
while ($id_ar = mysqli_fetch_array($result0)) {
$id = $id_ar[0];
$result = mysqli_query($db_con, "select * from matriculas where id = '$id'");
if ($row = mysqli_fetch_array ( $result )) {
	$apellidos = "Apellidos del Alumno: ". $row[2];
	 $nombre= "Nombre: ".$row[3];
	 $nacido= "Nacido en: ".$row[4];
	 $nacimiento = cambia_fecha($row[6]);
	 $provincia= "Provincia de: ".$row[5];
	 $fecha_nacimiento= "Fecha de Nacimiento: $nacimiento";
	 $domicilio= "Domicilio: ".$row[7];
	 $localidad= "Localidad: ".$row[8];
	 $dni= "DNI del alumno: ".$row[9];
	 $padre= "Apellidos y nombre del Tutor legal 1: ".$row[10];
	 $pa = explode(", ", $row[10]);
	 $papa = "$pa[1] $pa[0]";
	 $dnitutor= "DNI: ".$row[11];
	 $madre= "Apellidos y nombre del Tutor legal 2: ".$row[12];
	 $dnitutor2= "DNI: ".$row[13];
	 $telefono1= "Teléfono Casa: ".$row[14];
	 $telefono2= "Teléfono Móvil: ".$row[15];
	 $telefonos="$telefono1\n   $telefono2";
	 $idioma = $row[20];
	 $religion = $row[21];
	 $itinerario = $row['itinerario'];
	 $matematicas4 = $row['matematicas4'];
	 $matematicas3 = $row['matematicas3'];
	 if ($row[16] == "Otro Centro") { $colegio= "Centro de procedencia:  ".$row[17]; }else{	 $colegio= "Centro de procedencia:  ".$row[16]; }
	 $correo= "Correo electrónico de padre o madre: ".$row[19];
	 // Optativas y refuerzos
	 $n_curso = substr($curso, 0, 1);
	 $n_curso2 = $n_curso-1;
	 if ($n_curso == '1') {
$opt1 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Tecnología Aplicada");
$a1 = array("Actividades de Lengua Castellana ", "Actividades de Matemáticas", "Actividades de Inglés", "Taller T.I.C.", "Taller de Lenguas Extranjeras");
	 }
	 if ($n_curso == '2') {
$opt1 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Métodos de la Ciencia");
$a1 = array("Actividades de Lengua Castellana ", "Actividades de Matemáticas", "Actividades de Inglés", "Taller T.I.C. II");
$opt21 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Tecnología Aplicada");
$a21 = array("Actividades de Lengua Castellana ", "Actividades de Matemáticas", "Actividades de Inglés", "Taller T.I.C.", "Taller de Lenguas Extranjeras");
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
	 for ($i=1;$i<6;$i++)
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
	 $itinerario = $row[50];
	 $matematicas4 = $row[51];
}
$fech = explode(" ",$fecha_total);
$fecha = $fech[0];
//$hoy = formatea_fecha($fech[0]);
$an = substr($config['curso_actual'],0,4);
$an1 = $an+1;
$hoy = formatea_fecha(date('Y-m-d'));
$titulo_documentacion = "DOCUMENTACIÓN NECESARIA PARA LA MATRICULACIÓN";
$documentacion = "1. Fotocopia del D.N.I. Obligatorio por ley para todo alumnado mayor de 14 años. Si el alumnado es menor de 14 años y no se dispone de D.N.I., se admitirá una fotocopia del Libro de Familia o Certificado de Nacimiento.
2. El alumnado procedente de otros Institutos o de Colegios no adscritos a nuestro Centro deben aportar el Certificado de expediente académico..
3. Los alumnos que se matriculen a partir de 3º de ESO tienen que abonar 2 euros para la cuota obligatoria del Seguro Escolar.
4. Cuota voluntaria de 12 euros para la Asociación de Padres y Madres del Centro.
";
$datos_junta = "PROTECCIÓN DE DATOS.\n En cumplimiento de lo dispuesto en la Ley Orgánica 15/1999, de 13 de Diciembre, de Protección de Datos de Carácter Personal, la Consejería de Educación le informa que los datos personales obtenidos mediante la cumplimentación de este formulario y demás documentación que se adjunta van a ser incorporados, para su tratamiento, al fichero 'Séneca. Datos personales y académicos del alumnado', con la finalidad de recoger los datos personales y académicos del alumnado que cursa estudios en centros dependientes de la Conserjería de Educación, así como de las respectivas unidades familiares.\n De acuerdo con lo previsto en la Ley, puede ejercer los derechos de acceso, rectificación, cancelación y oposición dirigiendo un escrito a la Secretaría General Técnica de la Conserjería de Educación de la Junta de Andalucía en Avda. Juan Antonio de Vizarrón, s/n, Edificio Torretriana 41071 SEVILLA";

// Normas de telefonía móvil
$titulo_moviles = "SOBRE EL USO DE TELÉFONOS MÓVILES Y OTROS DISPOSITIVOS EN EL CENTRO";

$texto_moviles="
           Estimadas familias:

     Les informamos de que está prohibido el uso de teléfonos móviles y otros dispositivos de grabación/reproducción multimedia por parte del alumnado durante el horario escolar. Dicha medida es consecuencia de salvaguardar la intimidad tanto del alumnado como del profesorado, quienes pudieran ver vulnerados sus derechos de protección por grabaciones y/o difusiones de imágenes capturadas de forma ajena a su voluntad. Por este motivo, recordamos que la utilización de estos aparatos está prohibida en el Centro. En caso de que algún alumno sea sorprendido con cualquier dispositivo electrónico, este le será requisado aplicándose las medidas que en materia de convivencia hay estipuladas en nuestro Reglamento al efecto.
     El teléfono móvil en el Centro es absolutamente innecesario y constituye un elemento perturbador del clima de estudio y trabajo en el mismo. En aquellos casos en los que el alumnado tenga que comunicarse con la familia (que se entienden como situaciones graves o de urgencia), los teléfonos del Centro están siempre a disposición del alumnado. 
     Por último anunciar que dado que se ha dejado claro que están prohibidos estos dispositivos en el instituto, informamos que el Centro no se hace responsable ni va a mediar en situaciones donde se produzcan <<desapariciones>> de dichos dispositivos dentro de nuestras instalaciones.";

$final_moviles="
D./Dª. $papa, con DNI número $row[11], padre/madre/tutor legal del alumno/ a $row[3] $row[2] del curso $curso, teniendo en cuenta la información aportada, es conocedor de la prohibición de la tenencia y uso de los teléfonos móviles, así como de cualquier otro dispositivo electrónico que difunda o grabe imágenes de vídeo/audio.
";
$firma_moviles="
Firmado,


Padre/madre/tutor legal.";

// Formulario de la junta	
for($i=1;$i<3;$i++){
	$MiPDF->Addpage ();
	#### Cabecera con dirección
	$MiPDF->SetFont ( 'Times', 'B', 10  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	$MiPDF->Image ( '../../img/encabezado2.jpg', 10, 10, 180, '', 'jpg' );
	$MiPDF->Ln ( 8 );
	$titulo2 = "EDUCACIÓN SECUNDARIA OBLIGATORIA                                                           MATRICULA";
	$MiPDF->Multicell ( 0, 4, $titulo2, 0, 'L', 0 );

	$MiPDF->Ln ( 8 );
	$MiPDF->SetFont ( 'Times', '', 7 );
	$MiPDF->Cell(21,6,"Nº MATRÍCULA: ",0);
	$MiPDF->Cell(24,6,"",1);
	$adv = "         ANTES DE FIRMAR ESTE IMPRESO, COMPRUEBE QUE CORRESPONDE A LA
	        ETAPA EDUCATIVA EN LA QUE DESEA REALIZAR LA MATRÍCULA.
	        ESTA MATRÍCULA ESTÁ CONDICIONADA A LA COMPROBACIÓN DE LOS DATOS,  DE CUYA
	        VERACIDAD SE RESPONSABILIZA LA PERSONA FIRMANTE. ";
	$MiPDF->MultiCell(120, 3, $adv,0,'L',0);
	$MiPDF->Ln ( 5 );
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->Cell(5,6,"1",1,0,'C',1);
	$MiPDF->Cell(163,6,"DATOS PERSONALES DEL ALUMNO",1,0,'C',1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(84,5,"APELLIDOS",0,0,"C");
	$MiPDF->Cell(84,5,"NOMBRE",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,5,$row[2],1,0,'C');
	$MiPDF->Cell(84,5,$row[3],1,0,'C');
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(40,5,"FECHA NACIMIENTO",0,0,"C");
	$MiPDF->Cell(26,5,"DNI/NIE",0,0,"C");
	$MiPDF->Cell(26,5,"TELÉFONO",0,0,"C");
	$MiPDF->Cell(35,5,"NACIONALIDAD",0,0,"C");
	$MiPDF->Cell(21,5,"HERMANOS",0,0,"C");
	$MiPDF->Cell(20,5,"SEXO",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(40,5,$nacimiento,1,0,'C');
	$MiPDF->Cell(26,5,$row[9],1,0,'C');
	$MiPDF->Cell(26,5,$row[14],1,0,'C');
	$MiPDF->Cell(35,5,$nacionalidad,1,0,'C');
	$MiPDF->Cell(21,5,$hermanos,1,0,'C');
	$MiPDF->Cell(20,5,$sexo,1,0,'C');
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(100,5,"DOMICILIO",0,0,"C");
	$MiPDF->Cell(25,5,"LOCALIDAD",0,0,"C");
	$MiPDF->Cell(15,5,"C.P.",0,0,"C");
	$MiPDF->Cell(28,5,"PROVINCIA",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(100,5,$row[7],1,0,'C');
	$MiPDF->Cell(25,5,$row[8],1,0,'C');
	$MiPDF->Cell(15,5,$config['centro_codpostal'],1,0,'C');
	$MiPDF->Cell(28,5,$config['centro_provincia'],1,0,'C');
	$MiPDF->Ln ( 8 );
		
	$MiPDF->Cell(84,5,"CORREO ELECTRÓNICO DE CONTACTO",0,0,"C");
	$MiPDF->Cell(84,5,"Transporte Escolar",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,5,$row[19],1,0,'C');
	$MiPDF->Cell(84,5,$ruta_est.$ruta_oeste,1,0,'C');
	
	$MiPDF->Ln ( 12 );
	$MiPDF->Cell(5,6,"2",1,0,'C',1);
	$MiPDF->Cell(163,6,"DATOS DE LOS REPRESENTANTES LEGALES DEL ALUMNO",1,0,'C',1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(140,5,"APELLIDOS Y NOMBRE DEL REPRESENTANTE LEGAL 1(con quien este convive)",0,0,"C");
	$MiPDF->Cell(28,5,"DNI/NIE",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(140,5,$row[10],1,0,'C');
	$MiPDF->Cell(28,5,$row[11],1,0,'C');
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(140,5,"APELLIDOS Y NOMBRE DEL REPRESENTANTE LEGAL 2",0,0,"C");
	$MiPDF->Cell(28,5,"DNI/NIE",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(140,5,$row[12],1,0,'C');
	$MiPDF->Cell(28,5,$row[13],1,0,'C');

	
	$MiPDF->Ln ( 12 );
	$MiPDF->Cell(5,6,"3",1,0,'C',1);
	$MiPDF->Cell(163,6,"DATOS DE MATRÍCULA",1,0,'C',1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(76,5,"CENTRO DOCENTE EN EL QUE SE MATRICULA",0,0,"C");
	$MiPDF->Cell(46,5,"LOCALIDAD",0,0,"C");
	$MiPDF->Cell(46,5,"CODIGO",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(76,5,$config['centro_denominacion'],1,0,'C');
	$MiPDF->Cell(46,5,$config['centro_localidad'],1,0,'C');
	$MiPDF->Cell(46,5,$config['centro_codigo'],1,0,'C');
	$MiPDF->Ln ( 6 );
	//echo $itinerario;
	if ($n_curso == '4') { $extra="4ESO (It. $itinerario)";}elseif ($n_curso == '3') { $extra="3ESO (Matemáticas $matematicas3)";}else{$extra=$curso;}
	
	if(($n_curso==2 or $n_curso==4) and stristr($religion,"Valores")==TRUE){$religion="Atención Educativa";}
        $MiPDF->Cell(84,6,"IDIOMA EXTRANJERO",0,0,'C');
	$MiPDF->Cell(84,6,"RELIGIÓN O ALTERNATIVA",0,0,'C');
	$MiPDF->Ln ( 6);
	$MiPDF->Cell(84,5,$idioma,1,0,'C');
	$MiPDF->Cell(84,5,$religion,1,0,'C');	
	$MiPDF->Ln ( 7);
	
	$MiPDF->Cell(60,5,"CURSO EN QUE SE MATRICULA",0,0,"C");
	$MiPDF->Cell(108,5,"MATERIAS OPTATIVAS DEL CURSO EN QUE SE MATRICULA",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(60,5,$extra,1,0,'C');
	$opt="";
	if ($n_curso=="4" and ($itinerario == "1" or $itinerario == "4") ) {
		$opt = "     $optativa1
	    $optativa2
	    $optativa3";
	}
	elseif ($n_curso=="1" ) {
		$opt = "     $optativa1
	    $optativa2
	    $optativa3
	    $optativa4
	    $optativa5";
	}
	else{
	$opt = "     $optativa1										     $optativa5
	    $optativa2											     $optativa6
	    $optativa3											     $optativa7
	    $optativa4";
	}
	$MiPDF->MultiCell(108,5,$opt,1);
	$MiPDF->Ln ( 4 );
	$f_hoy = "        En ".$config['centro_localidad'].", a ".$hoy;
	$sello = "                                  Sello del Centro";
	$firma_centro = "                                El/La Funcionario/a";
	$firma_padre= "  Firma del representante o Guardador legal 1";
	$MiPDF->Cell(84,8,$firma_padre,0);	
	$MiPDF->Cell(84, 8, $firma_centro,0);
	$MiPDF->Ln ( 20 );
	$MiPDF->Cell(84, 8, $f_hoy,0);
	$MiPDF->Cell(84, 8, $sello,0);
	$MiPDF->Ln ( 9 );
	$nota = "NOTA: Para la primera matriculación del alumnado en el centro docente se aportará documento acreditativo de la fecha de nacimimiento del alumno/a y documento de estar en posesión de los requisitos académicos establecidos en la legislación vigente.";
	$MiPDF->SetFont ( 'Times', 'B', 8 );
	$MiPDF->MultiCell(168,5,$nota,0);
	$MiPDF->SetFont ( 'Times', '', 7 );
	$MiPDF->Ln ( 3 );		
	$MiPDF->MultiCell(168, 3, $datos_junta,1,'L',1);
}

	# insertamos la primera pagina del documento
	$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'Times', 'B', 11  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	$MiPDF->Image ( '../../img/encabezado2.jpg', 10, 10, 180, '', 'jpg' );
	$MiPDF->Ln ( 12 );
	$MiPDF->Multicell ( 0, 4, $titulo_documentacion, 0, 'C', 0 );
	$MiPDF->Ln ( 4 );
	$MiPDF->SetFont ( 'Times', '', 10  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	$MiPDF->Multicell ( 0, 6, $documentacion, 0, 'L', 0 );
	$MiPDF->Ln ( 5 );
	$MiPDF->Multicell ( 0, 6, "------------------------------------------------------------------------------------------------------------------------------------------", 0, 'L', 0 );
	$MiPDF->Multicell ( 0, 6, "------------------------------------------------------------------------------------------------------------------------------------------", 0, 'L', 0 );
	$MiPDF->Ln ( 8 );
	$MiPDF->SetFont ( 'Times', 'B', 11  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	$MiPDF->Multicell ( 0, 4, $titulo_moviles, 0, 'C', 0 );
	$MiPDF->Ln ( 2 );
	$MiPDF->SetFont ( 'Times', '', 10  );
	$MiPDF->Multicell ( 0, 6, $texto_moviles, 0, 'L', 0 );
	$MiPDF->Ln ( 1 );
	$MiPDF->Multicell ( 0, 6, $final_moviles, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 6, $firma_moviles, 0, 'C', 0 );
	
	include("autorizaciones.php");
	}
   $MiPDF->AutoPrint(true);     
   $MiPDF->Output ();

?>