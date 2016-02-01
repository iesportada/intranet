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
# ajustamos al 100% la visualización
$MiPDF->SetDisplayMode ( 'fullpage' );
// Consulta  en curso. 
if (substr($curso, 0, 1) == '1') {
	$mas = ", colegio";
}
$n_curso = substr($curso, 0, 1);
$result0 = mysqli_query($db_con, "select distinct id_matriculas from matriculas_bach_temp, matriculas_bach where id=id_matriculas order by curso".$mas.", letra_grupo, apellidos, nombre" );
while ($id_ar = mysqli_fetch_array($result0)) {
$id = $id_ar[0];
$result = mysqli_query($db_con, "select * from matriculas_bach where id = '$id'");
if ($datos_ya = mysqli_fetch_object ( $result )) {

$naci = explode("-",$datos_ya->nacimiento);
$nacimiento = "$naci[2]-$naci[1]-$naci[0]";
$apellidos = $datos_ya->apellidos; $id = $datos_ya->id; $nombre = $datos_ya->nombre; $nacido = $datos_ya->nacimiento; $provincia = $datos_ya->provincia; $domicilio = $datos_ya->domicilio; $localidad = $datos_ya->localidad; $dni = $datos_ya->dni; $padre = $datos_ya->padre; $dnitutor = $datos_ya->dnitutor; $madre = $datos_ya->madre; $dnitutor2 = $datos_ya->dnitutor2; $telefono1 = $datos_ya->telefono1; $telefono2 = $datos_ya->telefono2; $colegio = $datos_ya->colegio; $correo = $datos_ya->correo; $otrocolegio = $datos_ya->otrocolegio; $letra_grupo = $datos_ya->letra_grupo; $religion = $datos_ya->religion; $observaciones = $datos_ya->observaciones; $promociona = $datos_ya->promociona; $transporte = $datos_ya->transporte; $ruta_este = $datos_ya->ruta_este; $ruta_oeste = $datos_ya->ruta_oeste; $sexo = $datos_ya->sexo; $hermanos = $datos_ya->hermanos; $nacionalidad = $datos_ya->nacionalidad; $claveal = $datos_ya->claveal; $curso = $datos_ya->curso;  $itinerario1 = $datos_ya->itinerario1; $itinerario2 = $datos_ya->itinerario2; $optativa1 = $datos_ya->optativa1; $optativa2 = $datos_ya->optativa2; $optativa2b1 = $datos_ya->optativa2b1; $optativa2b2 = $datos_ya->optativa2b2; $optativa2b3 = $datos_ya->optativa2b3; $optativa2b4 = $datos_ya->optativa2b4; $optativa2b5 = $datos_ya->optativa2b5; $optativa2b6 = $datos_ya->optativa2b6; $optativa2b7 = $datos_ya->optativa2b7; $optativa2b8 = $datos_ya->optativa2b8; $optativa2b9 = $datos_ya->optativa2b9; $optativa2b10 = $datos_ya->optativa2b10; $repetidor = $datos_ya->repite;$revisado = $datos_ya->revisado; $confirmado = $datos_ya->confirmado; $grupo_actual = $datos_ya->grupo_actual; $idioma1 = $datos_ya->idioma1; $idioma2 = $datos_ya->idioma2;

	$apellidos = "Apellidos del Alumno: ". $apellidos;
	 $nombre= "Nombre: ".$nombre;
	 $nacido= "Nacido en: ".$nacido;
	 $provincia= "Provincia de: ".$provincia;
	 $fecha_nacimiento= "Fecha de Nacimiento: $nacimiento";
	 $domicilio= "Domicilio: ".$domicilio;
	 $localidad= "Localidad: ".$localidad;
	 $dni= "DNI del alumno: ".$dni;
	 $padre= "Apellidos y nombre del Tutor legal 1: ".$padre;
	 $pa = explode(", ", $datos_ya->padre);
	 $papa = "$pa[1] $pa[0]";
	 $dnitutor= "DNI: ".$dnitutor;
	 $madre= "Apellidos y nombre del Tutor legal 2: ".$madre;
	 $dnitutor2= "DNI: ".$dnitutor2;
	 $telefono1= "Tel�fono Casa: ".$telefono1;
	 $telefono2= "Tel�fono M�vil: ".$telefono2;
	 $telefonos="$telefono1\n   $telefono2";

	 if ($datos_ya->colegio == "Otro Centro") { $colegio= "Centro de procedencia:  ".$datos_ya->otrocolegio; }else{	 $colegio= "Centro de procedencia:  ".$datos_ya->colegio; }
	 $correo= "Correo electr�nico de padre o madre: ".$datos_ya->correo;
	 // Optativas y refuerzos
	 $n_curso = substr($curso, 0, 1);
	 $n_curso2 = $n_curso-1;
	 
	 
// Asignaturas y Modalidades
// 1� BACH

$opta_11=array( "MAT1"=>"Matem�ticas",  "FYQ1"=>"F�sica y Qu�mica", "DBT1" => "Dibujo T�cnico");
$opta_12=array("MAT1"=>"Matem�ticas",  "FYQ1"=>"F�sica y Qu�mica", "BYG11"=>"Biolog�a y Geolog�a");

// Asignaturas y Modalidades
$it1 = array("1"=>"Ciencias e Ingenier�a y Arquitectura", "2"=>"Ciencias y Ciencias de la Salud", "3"=>"Humanidades", "4"=>"Ciencias Sociales y Jur�dicas");
$opt11=array( "TIN1" => "Tecnolog�a Industrial", "TIC1" => "Tecnolog�as de Informaci�n y Comunicaci�n");
$opt12=array("AAP1"=>"Anatom�a Aplicada", "TIC11" => "Tecnolog�as de Informaci�n y Comunicaci�n");
$opt13=array(
""=>"",
"LAT1-GRI1-PAC1" => "Lat�n, Griego, Patrimonio Art�stico y Cultural", 
"LAT1-GRI1-CEE1" => "Lat�n, Griego, Cultura Emprendedora y Empresarial",
"LAT1-GRI1-TIC0" => "Lat�n, Griego, Tecnolog�as de la Informaci�n y Comunicaci�n",
"LAT1-LUN1-PAC1" => "Lat�n, Literatura Universal, Patrimonio Art�stico y Cultural",
"LAT1-LUN1-CEE1" => "Lat�n, Literatura Universal, Cultura Emprendedora y Empresarial",
"LAT1-LUN1-TIC0" => "Lat�n, Literatura Universal, Tecnolog�as de la Informaci�n y Comunicaci�n",
"LAT1-ECO1-PAC1" => "Lat�n, Econom�a, Patrimonio Art�stico y Cultural",
"LAT1-ECO1-CEE1" => "Lat�n, Econom�a, Cultura Emprendedora y Empresarial",
"LAT1-ECO1-TIC0" => "Lat�n, Econom�a, Tecnolog�as de la Informaci�n y Comunicaci�n",
"MCS1-GRI1-PAC1" => "Matem�ticas Aplicadas a Ciencias Sociales, Griego, Patrimonio Art�stico y Cultural", 
"MCS1-GRI1-CEE1" => "Matem�ticas Aplicadas a Ciencias Sociales, Griego, Cultura Emprendedora y Empresarial",
"MCS1-GRI1-TIC0" => "Matem�ticas Aplicadas a Ciencias Sociales, Griego, Tecnolog�as de la Informaci�n y Comunicaci�n",
"MCS1-LUN1-PAC1" => "Matem�ticas Aplicadas a Ciencias Sociales, Literatura Universal, Patrimonio Art�stico y Cultural",
"MCS1-LUN1-CEE1" => "Matem�ticas Aplicadas a Ciencias Sociales, Literatura Universal, Cultura Emprendedora y Empresarial",
"MCS1-LUN1-TIC0" => "Matem�ticas Aplicadas a Ciencias Sociales, Literatura Universal,Tecnolog�as de la Informaci�n y Comunicaci�n",
"MCS1-ECO1-PAC1" => "Matem�ticas Aplicadas a Ciencias Sociales, Econom�a, Patrimonio Art�stico y Cultural",
"MCS1-ECO1-CEE1" => "Matem�ticas Aplicadas a Ciencias Sociales, Econom�a, Cultura Emprendedora y Empresarial",
"MCS1-ECO1-TIC0" => "Matem�ticas Aplicadas a Ciencias Sociales, Econom�a, Tecnolog�as de la Informaci�n y Comunicaci�n",
);

// 2� BACH
$it21 = array("Bachillerato de Ciencias y Tecnolog�a", "V�a de Ciencias e Ingenier�a", "V�a de Ciencias de la Naturaleza y la Salud", "Ciencias y Tecnolog�a");
$it22 = array("Bachillerato de Humanidades y Ciencias Sociales", "V�a de Humanidades", "V�a de Ciencias Sociales", "Humanidades y Ciencias Sociales");
$opt21=array("FIS21_DBT21" => "F�sica, Dibujo T�cnico", "FIS21_TIN21" => "F�sica, Tecnolog�a", "FIS21_QUI21" => "F�sica, Qu�mica", "BIO21_QUI21" => "Biolog�a, Qu�mica");
$opt22=array("HAR22_LAT22_GRI22" => "Historia del Arte, Lat�n, Griego", "HAR22_LAT22_MCS22" => "Historia del Arte, Lat�n, Matem�ticas de las C. Sociales", "HAR22_ECO22_GRI22" => "Historia del Arte, Econom�a, Griego", "HAR22_ECO22_MCS22" => "Historia del Arte, Econom�a, Matem�ticas de las C. Sociales", "GEO22_ECO22_MCS22" => "Geograf�a, Econom�a, Matem�ticas de las C. Sociales", "GEO22_ECO22_GRI22" => "Geograf�a, Econom�a, Griego", "GEO22_LAT22_MCS22" => "Geograf�a, Lat�n, Matem�ticas de las C. Sociales", "GEO22_LAT22_GRI22" => "Geograf�a, Lat�n, Griego");
$opt23 =array("aleman_25" => "Alem�n 2� Idioma", "frances_25" => "Franc�s 2� Idioma", "tic_25" => "T.I.C.", "ciencias_25" => "Ciencias de la Tierra y Medioambientales", "musica_25" => "Historia de la M�sica y la Danza", "literatura_25" => "Literatura Universal", "edfisica_25"=>"Educaci�n F�sica", "estadistica_25"=>"Estad�stica", "salud_25"=>"Introducci�n a las Ciencias de la Salud","ingles_25" => "Ingl�s 2� Idioma");
	 	 
	 $observaciones= "OBSERVACIONES: ".$observaciones;
	 $fecha_total = $fecha;
	 $texto_transporte = "Transporte escolar: $ruta_este$ruta_oeste.";
	 if ($hermanos == '' or $hermanos == '0') { $hermanos = ""; }
	 
}
$fech = explode(" ",$fecha_total);
$fecha = $fech[0];
//$hoy = formatea_fecha($fech[0]);
$an = substr($config['curso_actual'],0,4);
$an1 = $an+1;
$hoy = formatea_fecha(date('Y-m-d'));
$titulo_documentacion = "DOCUMENTACI�N NECESARIA PARA LA MATRICULACI�N";
$documentacion = "1. Fotocopia del DNI. Si el alumno no dispone de DNI, una fotocopia del Libro de Familia o Certificado de Nacimiento. El alumnado extranjero deber� entregar una fotocopia del Pasaporte y Tarjeta de Residencia.
2. El alumnado procedente de otros Institutos o de Colegios no adscritos a nuestro Centro deben aportar el Certificado de expediente acad�mico..
3. Los alumnos que se matriculen a partir de 3� de ESO tienen que abonar 2 euros para la cuota obligatoria del Seguro Escolar.
4. Cuota voluntaria de 12 euros para la Asociaci�n de Padres y Madres del Centro.
";
$datos_junta = "PROTECCI�N DE DATOS.\n En cumplimiento de lo dispuesto en la Ley Org�nica 15/1999, de 13 de Diciembre, de Protecci�n de Datos de Car�cter Personal, la Consejer�a de Educaci�n le informa que los datos personales obtenidos mediante la cumplimentaci�n de este formulario y dem�s documentaci�n que se adjunta van a ser incorporados, para su tratamiento, al fichero 'S�neca. Datos personales y acad�micos del alumnado', con la finalidad de recoger los datos personales y acad�micos del alumnado que cursa estudios en centros dependientes de la Conserjer�a de Educaci�n, as� como de las respectivas unidades familiares.\n De acuerdo con lo previsto en la Ley, puede ejercer los derechos de acceso, rectificaci�n, cancelaci�n y oposici�n dirigiendo un escrito a la Secretar�a General T�cnica de la Conserjer�a de Educaci�n de la Junta de Andaluc�a en Avda. Juan Antonio de Vizarr�n, s/n, Edificio Torretriana 41071 SEVILLA";
// Normas de telefon�a m�vil
$titulo_moviles = "SOBRE EL USO DE TEL�FONOS M�VILES Y OTROS DISPOSITIVOS EN EL CENTRO";

$texto_moviles="
           Estimadas familias:

     Les informamos de que est� prohibido el uso de tel�fonos m�viles y otros dispositivos de grabaci�n/reproducci�n multimedia por parte del alumnado durante el horario escolar. Dicha medida es consecuencia de salvaguardar la intimidad tanto del alumnado como del profesorado, quienes pudieran ver vulnerados sus derechos de protecci�n por grabaciones y/o difusiones de im�genes capturadas de forma ajena a su voluntad. Por este motivo, recordamos que la utilizaci�n de estos aparatos est� prohibida en el Centro. En caso de que alg�n alumno sea sorprendido con cualquier dispositivo electr�nico, este le ser� requisado aplic�ndose las medidas que en materia de convivencia hay estipuladas en nuestro Reglamento al efecto.
     El tel�fono m�vil en el Centro es absolutamente innecesario y constituye un elemento perturbador del clima de estudio y trabajo en el mismo. En aquellos casos en los que el alumnado tenga que comunicarse con la familia (que se entienden como situaciones graves o de urgencia), los tel�fonos del Centro est�n siempre a disposici�n del alumnado. 
     Por �ltimo anunciar que dado que se ha dejado claro que est�n prohibidos estos dispositivos en el instituto, informamos que el Centro no se hace responsable ni va a mediar en situaciones donde se produzcan <<desapariciones>> de dichos dispositivos dentro de nuestras instalaciones.";

$final_moviles="
D./D�. $papa, con DNI n�mero $datos_ya->dnitutor, padre/madre/tutor legal del alumno/ a $datos_ya->nombre $datos_ya->apellidos del curso $curso, teniendo en cuenta la informaci�n aportada, es conocedor de la prohibici�n de la tenencia y uso de los tel�fonos m�viles, as� como de cualquier otro dispositivo electr�nico que difunda o grabe im�genes de v�deo/audio.
";
$firma_moviles="
Firmado,


Padre/madre/tutor legal.";
	
// Formulario de la junta	
$pags = array("1","2");
foreach ($pags as $pag_pdf){

	$MiPDF->Addpage ();
	#### Cabecera con direcci�n
	$MiPDF->SetFont ( 'Times', 'B', 10  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	$MiPDF->Image ( '../../img/encabezado2.jpg', 10, 10, 180, '', 'jpg' );
	$MiPDF->Ln ( 8 );
	$titulo2 = "MATR�CULA DE ". $n_curso."� DE BACHILLERATO";
	$MiPDF->Multicell ( 0, 4, $titulo2, 0, 'C', 0 );

	$MiPDF->Ln ( 8 );
	$MiPDF->SetFont ( 'Times', '', 7 );
	$MiPDF->Cell(21,6,"N� MATR�CULA: ",0);
	$MiPDF->Cell(24,6,"",1);
	$adv = "         ANTES DE FIRMAR ESTE IMPRESO, COMPRUEBE QUE CORRESPONDE A LA
	        ETAPA EDUCATIVA EN LA QUE DESEA REALIZAR LA MATR�CULA.
	        ESTA MATR�CULA EST� CONDICIONADA A LA COMPROBACI�N DE LOS DATOS,  DE CUYA
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
	$MiPDF->Cell(84,5,$datos_ya->apellidos,1,0,'C');
	$MiPDF->Cell(84,5,$datos_ya->nombre,1,0,'C');
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(40,5,"FECHA NACIMIENTO",0,0,"C");
	$MiPDF->Cell(26,5,"DNI/NIE",0,0,"C");
	$MiPDF->Cell(26,5,"TEL�FONO",0,0,"C");
	$MiPDF->Cell(35,5,"NACIONALIDAD",0,0,"C");
	$MiPDF->Cell(21,5,"HERMANOS",0,0,"C");
	$MiPDF->Cell(20,5,"SEXO",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(40,5,$nacimiento,1,0,'C');
	$MiPDF->Cell(26,5,$datos_ya->dni,1,0,'C');
	$MiPDF->Cell(26,5,$datos_ya->telefono1,1,0,'C');
	$MiPDF->Cell(35,5,$nacionalidad,1,0,'C');
	$MiPDF->Cell(21,5,$hermanos,1,0,'C');
	$MiPDF->Cell(20,5,$sexo,1,0,'C');
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(100,5,"DOMICILIO",0,0,"C");
	$MiPDF->Cell(25,5,"LOCALIDAD",0,0,"C");
	$MiPDF->Cell(15,5,"C.P.",0,0,"C");
	$MiPDF->Cell(28,5,"PROVINCIA",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(100,5,$datos_ya->domicilio,1,0,'C');
	$MiPDF->Cell(25,5,$datos_ya->localidad,1,0,'C');
	$MiPDF->Cell(15,5,$config['centro_codpostal'],1,0,'C');
	$MiPDF->Cell(28,5,$config['centro_provincia'],1,0,'C');
	$MiPDF->Ln ( 8 );

	$MiPDF->Cell(84,5,"CORREO ELECTR�NICO DE CONTACTO",0,0,"C");
	$MiPDF->Cell(84,5,"Transporte Escolar",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(84,5,$datos_ya->correo,1,0,'C');
	$MiPDF->Cell(84,5,$datos_ya->ruta_este.$datos_ya->ruta_oeste,1,0,'C');
		
	$MiPDF->Ln ( 9 );
	$MiPDF->Cell(5,6,"2",1,0,'C',1);
	$MiPDF->Cell(163,6,"DATOS DE LOS REPRESENTANTES LEGALES DEL ALUMNO",1,0,'C',1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(140,5,"APELLIDOS Y NOMBRE DEL REPRESENTANTE LEGAL 1(con quien este convive)",0,0,"C");
	$MiPDF->Cell(28,5,"DNI/NIE",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(140,5,$datos_ya->padre,1,0,'C');
	$MiPDF->Cell(28,5,$datos_ya->dnitutor,1,0,'C');
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(140,5,"APELLIDOS Y NOMBRE DEL REPRESENTANTE LEGAL 2",0,0,"C");
	$MiPDF->Cell(28,5,"DNI/NIE",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(140,5,$datos_ya->madre,1,0,'C');
	$MiPDF->Cell(28,5,$datos_ya->dnitutor2,1,0,'C');

	
	$MiPDF->Ln ( 9 );
	$MiPDF->Cell(5,6,"3",1,0,'C',1);
	$MiPDF->Cell(163,6,"DATOS DE MATR�CULA",1,0,'C',1);
	$MiPDF->Ln ( 8 );
	$MiPDF->Cell(76,5,"CENTRO DOCENTE EN EL QUE SE MATRICULA",0,0,"C");
	$MiPDF->Cell(46,5,"LOCALIDAD",0,0,"C");
	$MiPDF->Cell(46,5,"CODIGO",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->Cell(76,5,$config['centro_denominacion'],1,0,'C');
	$MiPDF->Cell(46,5,$config['centro_localidad'],1,0,'C');
	$MiPDF->Cell(46,5,$config['centro_codigo'],1,0,'C');
	$MiPDF->Ln ( 8 );
	
	if ($curso=="2BACH") {
	if(stristr($religion,"Valores")==TRUE){$religion="Atenci�n Educativa";}
	$MiPDF->Cell(84,6,"IDIOMA EXTRANJERO",0,0,'C');
	$MiPDF->Cell(84,6,"RELIGI�N O ALTERNATIVA",0,0,'C');
	$MiPDF->Ln ( 6);
	$MiPDF->Cell(84,5,$idioma1,1,0,'C');
	$MiPDF->Cell(84,5,$religion,1,0,'C');	
	}
	else{
	if(stristr($religion,"Valores")==TRUE){$religion="Educaci�n para la Ciudadan�a";}
	$MiPDF->Cell(56,6,"1� IDIOMA EXTRANJERO",0,0,'C');
	$MiPDF->Cell(56,6,"2� IDIOMA EXTRANJERO",0,0,'C');
	$MiPDF->Cell(56,6,"RELIGI�N O ALTERNATIVA",0,0,'C');
	$MiPDF->Ln ( 6);
	$MiPDF->Cell(56,5,$idioma1,1,0,'C');
	$MiPDF->Cell(56,5,$idioma2,1,0,'C');
	$MiPDF->Cell(56,5,$religion,1,0,'C');
	}
	$MiPDF->Ln ( 8 );
	
	//echo $itinerario;
	if ($n_curso == '4') { $extra="4ESO (It. $itinerario)";}else{$extra=$curso;}
	$MiPDF->Cell(78,5,"CURSO EN QUE SE MATRICULA",0,0,"C");
	$MiPDF->Cell(90,5,"MATERIAS DE LA MODALIDAD",0,0,"C");
	$MiPDF->Ln ( 5 );
	
	$opt="";
	$opta1="";
	$opta2="";
	$nombre_opta="";
	$nombre_opt="";
	if ($n_curso=="1") {
                foreach($it1 as $num_it=>$nombre_it){
                    if($num_it==$itinerario1){
                        $mod_registro = $nombre_it;
                    }
                }
                foreach($opta_11 as $abrev_opta=>$nombre_opta){ 
					$opta1.=$nombre_opta.", ";
				}  
				foreach($opta_12 as $abrev_opta=>$nombre_opta){ 
					$opta2.=$nombre_opta.", ";
				}        
		for ($i = 1; $i < 4; $i++) {
                    if($itinerario1 == 1){
					foreach($opt11 as $abrev_opt=>$nombre_opt){ 
                         if($optativa1==$abrev_opt){
                                $opt = $nombre_opt;
                         }
                    }	
                    $opt=$opta1.$opt;				
                    }
                    elseif($itinerario1 == 2){
    					foreach($opt12 as $abrev_opt=>$nombre_opt){ 
					
                         if($optativa1==$abrev_opt){
                                $opt = $nombre_opt;
                         }
                    }
                    $opt=$opta2.$opt;					
                    }
                    else{
                         foreach($opt13 as $abrev_opt=>$nombre_opt){   
                         if($optativa1==$abrev_opt){
                                $opt = "Historia del Mundo Contempor�neo, ".$nombre_opt;
                         }
                    }
				}
            }
	}
	if ($n_curso=="2") {
		$mod_registro = ${it2.$itinerario2}[3];
		for ($i = 1; $i < 3; $i++) {		
			foreach (${opt2.$i} as $key=>$val){
				if ($optativa2 == $key) {
				$opt = "$val";				
				}
			}
		}
// Optativas extra de 2 de bach.
	$n_z="";
	$opt_2b = "";
			foreach ($opt23 as $key=>$val){
				$n_z+=1;		
				$opt_b = mysqli_query($db_con, "select optativa2b$n_z from matriculas_bach where id = '$id'");
				$o_b = mysqli_fetch_array($opt_b);
				$reduce = substr($key,0,-3);
				$opt_2b .= $o_b[0].". ".$val."; ";				
				}
			}
		//$opt_o = "\nOptativas de Bachillerato".$opt_2b;
	$MiPDF->Cell(78,5,$n_curso."� DE BACH. ( ".$mod_registro." )",1,0,'C');
	$MiPDF->MultiCell(90,5,$opt,1);
	if ($curso=="2BACH") {
	$MiPDF->Ln ( 2 );
	$MiPDF->Cell(165,5,"MATERIAS OPTATIVAS",0,0,"C");
	$MiPDF->Ln ( 5 );
	$MiPDF->MultiCell(168,5,$opt_2b,1);
	}
	$MiPDF->Ln ( 4 );
	$f_hoy = "        En ".$config['centro_localidad'].", a ".$hoy;
	$sello = "                                  Sello del Centro";
	$firma_centro = "                                El/La Funcionario/a";
	$firma_padre= "  Firma del representante o Guardador legal 1";
	$MiPDF->Cell(84,8,$firma_padre,0);	
	$MiPDF->Cell(84, 8, $firma_centro,0);
	$MiPDF->Ln ( 17 );
	$MiPDF->Cell(84, 8, $f_hoy,0);
	$MiPDF->Cell(84, 8, $sello,0);
	$MiPDF->Ln ( 9 );
	$nota = "NOTA: Para la primera matriculaci�n del alumnado en el centro docente se aportar� documento acreditativo de la fecha de nacimimiento del alumno/a y documento de estar en posesi�n de los requisitos acad�micos establecidos en la legislaci�n vigente.";
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
	
	
	
	if ($promociona=="3") {
		if (date('m')=='09'){
				$materias="";
				$not = mysqli_query($db_con, "select notas3, notas4 from notas, alma where alma.claveal1=notas.claveal and alma.claveal=".$claveal."");
				$nota = mysqli_fetch_array($not);
				$val_notas="";
				$tr_not2 = explode(";", $nota[1]);
				foreach ($tr_not2 as $val_asig) {
					$tr_notas = explode(":", $val_asig);
					foreach ($tr_notas as $key_nota=>$val_nota) {
						if($key_nota == "1" and $val_nota<'427' and $val_nota !=="439" and $val_nota !==""){
							$mat = mysqli_query($db_con, "select nombre from asignaturas where codigo = '$tr_notas[0]'");
							//echo "select nombre from asignaturas where codigo = '$tr_notas[0]'<br>";
							$mater = mysqli_fetch_array($mat);
							$materias.="x ".$mater[0]."\n ";
						}
					}
				}

				
	# insertamos la primera pagina del documento
	$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'Times', 'B', 11  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	$MiPDF->Ln ( 4 );
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
	
	$titulo_34 = "REPETIDORES DE 1� DE BACHILLERATO";
$an = substr($config['curso_actual'],0,4);
$an1 = $an+1;
$an2 = $an+2;
$c_escolar = $an1."/".$an2;
$autoriza_34="
D./D� $papa, como padre, madre o tutor legal del alumno/a ".$datos_ya->nombre." ".$datos_ya->apellidos." del curso ".$n_curso."� de Bachillerato, matriculado en el ".$config['centro_denominacion']." (".$config['centro_localidad'].") durante el curso acad�mico $c_escolar:



SOLICITA:

   1) Que su hijo/a sea matriculado exclusivamente de las materias que se exponen a continuaci�n por no haber sido superadas en el curso anterior. De este modo se autoriza a que cuando no tenga clase abandone el Centro. 
   
 $materias

   2) Que su hijo/a sea matriculado de nuevo en segundo curso de Bachillerato en su totalidad, de forma que tenga la oportunidad de consolidar su formaci�n en las materias.
";
$firma_34 = "		
En ".$config['centro_localidad'].", a $hoy


 Firma del padre/madre/tutor/a.
";

$direccion_junta = "
Ed. Torretriana. C/. Juan A. de Vizarr�n, s/n. 41071 Sevilla
Telf. 95 506 40 00. Fax: 95 506 40 03.
e-mail: informacion.ced@juntadeandalucia.es
";
	$MiPDF->Addpage ();
	#### Cabecera con direcci�n
	$MiPDF->SetFont ( 'Times', 'B', 11  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);		
	$MiPDF->Image ( '../../img/encabezado_junta.jpg', 10, 10, 180, '', 'jpg' );
	$MiPDF->Ln ( 20 );
	$MiPDF->Cell(168,5,$titulo_34,0,0,'C');
	$MiPDF->SetFont ( 'Times', '', 10  );	
	$MiPDF->Ln ( 4 );
	$MiPDF->Multicell ( 0, 6, $autoriza_34, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 6, $firma_34, 0, 'C', 0 );
	$MiPDF->Ln ( 8 );
	$MiPDF->SetFont ( 'Times', '', 9  );
	$MiPDF->Multicell ( 0, 6, $direccion_junta, 0, 'L', 0 );
	}	
}
		
	include("autorizaciones_bach.php");
	}
   $MiPDF->AutoPrint(true);     
   $MiPDF->Output ();

?>