<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$pa = explode(", ", $row[10]);
$papa = "$pa[1] $pa[0]";
$hoy = formatea_fecha(date('Y-m-d'));
$titulo4 = "AUTORIZACIÓN  PARA FOTOS Y GRABACIONES";
$autoriza_fotos="
D./Dª $papa, con DNI $row[11], representante legal del alumno/a $row[3] $row[2]
AUTORIZA al ".$config['centro_denominacion']." a fotografiar o grabar con video a su hijo o hija con fines educativos 
y dentro del contexto educativo del centro o de actividades complementarias o extraescolares desarrolladas por el mismo. 
";
$titulo5 = "		
En ".$config['centro_localidad'].", a $hoy


Firmado. D./Dª
NOTA: Los padres y madres son libres de firmar,  o no,  esta autorización.";

// Fotos
	$MiPDF->Addpage ();
	#### Cabecera con dirección
	$MiPDF->SetFont ( 'Times', 'B', 11  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	#Cuerpo.
	$MiPDF->Image ( '../../img/encabezado2.jpg', 10, 10, 180, '', 'jpg' );
	$MiPDF->Ln ( 20 );
	$MiPDF->Cell(168,5,$titulo4,0,0,'C');
	$MiPDF->SetFont ( 'Times', '', 10  );	
	$MiPDF->Ln ( 4 );
	$MiPDF->Multicell ( 0, 6, $autoriza_fotos, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 6, $titulo5, 0, 'C', 0 );
	$MiPDF->Ln ( 10 );

$titulo_religion = "SOLICITUD PARA CURSAR LAS ENSEÑANZAS DE RELIGIÓN";
$an = substr($config['curso_actual'],0,4);
$an1 = $an+1;
$an2 = $an+2;
$c_escolar = $an1."/".$an2;
$autoriza_religion="
D./Dª $papa, como padre, madre o tutor legal del alumno/a $row[3] $row[2] del curso ".$n_curso."º de ESO del ".$config['centro_denominacion'].", en desarrollo de la Ley Orgánica 2/2006 de 3 de Mayo, de Educación, modificada por la Ley Orgánica 8/2013, de 9 de diciembre, para la mejora de la calidad educativa.

SOLICITA:

Cursar a partir del curso escolar $c_escolar. mientras no modifique expresamente esta decisión, la enseñanza de Religión:
x $religion
";
$firma_religion = "		
En ".$config['centro_localidad'].", a $hoy


Firmado. D./Dª
";
$final_religion="
SR./SRA. DIRECTOR/A -----------------------------------------------------------------------------------------------------";
$direccion_junta = "
Ed. Torretriana. C/. Juan A. de Vizarrón, s/n. 41071 Sevilla
Telf. 95 506 40 00. Fax: 95 506 40 03.
e-mail: informacion.ced@juntadeandalucia.es
";
// Religion

if (substr($religion, 0, 1)=="R") {
	$MiPDF->Cell(168,5,"----------------------------------------------------------------------------------------------------------------------------------------",0,0,'C');
	$MiPDF->Ln ( 10 );
	$MiPDF->SetFont ( 'Times', 'B', 11  );
	$MiPDF->Cell(168,5,$titulo_religion,0,0,'C');
	$MiPDF->SetFont ( 'Times', '', 10  );	
	$MiPDF->Ln ( 4 );
	$MiPDF->Multicell ( 0, 6, $autoriza_religion, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 6, $firma_religion, 0, 'C', 0 );
	$MiPDF->Ln ( 8 );
	$MiPDF->Multicell ( 0, 6, $final_religion, 0, 'L', 0 );
	$MiPDF->Ln ( 5 );
	$MiPDF->SetFont ( 'Times', '', 9  );
	$MiPDF->Multicell ( 0, 6, $direccion_junta, 0, 'L', 0 );
}

// AMPA
$dni_papa = explode(": ", $dnitutor);
$dnipapa = $dni_papa[1];
$hijos = mysqli_query($db_con, "select apellidos, nombre, curso from matriculas where dnitutor = '$dnipapa'");
$hijos_primaria = mysqli_query($db_con, "select apellidos, nombre, curso from matriculas_bach where dnitutor = '$dnipapa'");
$num_hijos = mysqli_num_rows($hijos);
$num_hijos_primaria = mysqli_num_rows($hijos_primaria);

if ($num_hijos > 0) {
$n_h="";
while ($hij = mysqli_fetch_array($hijos)){
	$n_h+=1;
	${hijo.$n_h} = $hij[1]." ".$hij[0];
	//echo $hij[2];
	if (substr($hij[2], 0, 2) == '1E' or substr($hij[2], 0, 2) == '2E' or substr($hij[2], 0, 2) == '3E' or substr($hij[2], 0, 2) == '4E'){
		$niv = substr($hij[2], 0, 1)+1;
		//echo "$niv";
		if ($niv == "5") {
			${nivel.$n_h} = "1 BACHILLERATO";
		}
		else{
			${nivel.$n_h} = $niv." ESO";			
		}
	}
}	
}


if ($num_hijos_primaria > 0) {
$n_h_p="";
while ($hij_primaria = mysqli_fetch_array($hijos_primaria)){
	$n_h_p+=1;
	${hijop.$n_h_p} = $hij_primaria[1]." ".$hij_primaria[0];
	//echo $hij[2];
	if (substr($hij_primaria[2], 0, 2) == '1E' or substr($hij_primaria[2], 0, 2) == '2E' or substr($hij_primaria[2], 0, 2) == '3E' or substr($hij_primaria[2], 0, 2) == '4E'){
		$niv_primaria = substr($hij_primaria[2], 0, 1)+1;
		//echo "$niv";
		if ($niv_primaria == "5") {
			${nivelp.$n_h_p} = "1 BACHILLERATO";
		}
		else{
			${nivelp.$n_h_p} = $niv_primaria." ESO";			
		}
	}
	
}
}	

	
	$tit_ampa = '
I.E.S. MONTERROSO
Avda. Sto. Tomás de Aquino s/n
29680 ESTEPONA
e-mail: ampa@iesmonterroso.org
ampamonterroso@gmail.com

     Como cada año, la labor del A.M.P.A. comienza informando a las madres y padres de la necesidad de pertenecer a la Asociación, pues con su aportación y colaboración ayudamos a la gran tarea que supone EDUCAR A NUESTROS HIJAS E HIJOS. Son muchas las cosas que hacemos pero más las que se pueden llevar a cabo, con el compromiso e implicación de toda la comunidad educativa: padres y madres, profesorado y alumnado.
     Para más información de las actividades del A.M.P.A. consultar página www.iesmonterroso.org  pinchando en A.M.P.A, o directamente accediendo al blog   http://ampamonterroso.blogspot.com/ 
     La  cuota  de  la Asociación  de  Madres  y  Padres  es  de  12 euros por  familia y por curso.  La  pertenencia  a la   A.M.P.A  es voluntaria. Las  madres,  padres o tutores  de  los  alumnos/as  que  deseen  pertenecer a la  A.M.P.A  deberán  presentar  este  impreso.';
	
	$ampa21='El Ampa sorteará un regalo, que podrá ser una tablet, una cámara de fotos o una bici.';
	$ampa2 = '
Nombre del Padre, Madre o Tutor Legal: '.$papa.'. DNI: '.$dnipapa.'
'.$domicilio.'
'.$telefono1.'
'.$correo.'

NOMBRE Y  APELLIDOS  DE SUS HIJOS/AS  Y CURSO EN QUE SE MATRICULAN EN '.$c_escolar.'
';
	$ampa31='EXCLUSIVO  PARA ALUMNOS  QUE  VAN  A  CURSAR 1º, 2º, 3º y 4º DE E.S.O.';
	$ampa3 = '     Os recordamos que  es OBLIGATORIO el uso de la Agenda Escolar del Instituto para 1º, 2º, 3º y 4º de E.S.O., necesaria para el contacto permanente entre el profesorado y familia.  La Agenda será entregada gratuitamente a los alumnos que se hagan socios en el momento de la matriculación.
   
     Un cordial saludo.
	
	';
	if ($num_hijos=="0" and $num_hijos_primaria=="0") {
		$hijo1 = "$row[3] $row[2]";
		$nivel1= $curso;
		$ampa2.=$hijo1." ".$nivel1;
	}
	for ($i = 1; $i < $num_hijos+1; $i++) {
		$ampa2.=${hijo.$i}.' '.${nivel.$i}.'
';
		
	}
	for ($i = 1; $i < $num_hijos_primaria+1; $i++) {
		if (empty(${nivelp.$i})) {
			${nivelp.$i}=$curso;
		}
		$ampa2.=${hijop.$i}.' '.${nivelp.$i}.'
';
		
	}
	
	$MiPDF->Addpage ();
	#### Cabecera con dirección
	$MiPDF->SetFont ( 'Times', 'B', 11  );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->SetFillColor(230,230,230);
	#Cuerpo.
	$MiPDF->Image ( '../../img/ampa.jpg', 8, 8, 170, '', 'jpg' );
	$MiPDF->Ln ( 20 );
	$MiPDF->Cell(168,8,"ASOCIACIÓN DE MADRES Y PADRES BACCALAUREATUS",1,1,'C');
	$MiPDF->SetFont ( 'Times', '', 10  );	
	$MiPDF->Ln ( 4 );
	$MiPDF->Multicell ( 0, 6, $tit_ampa, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 6, $ampa21, 1, 'L', 1 );
	$MiPDF->Multicell ( 0, 6, $ampa2, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 6, $ampa31, 1, 'L', 1 );
	$MiPDF->Multicell ( 0, 6, $ampa3, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	
	?>