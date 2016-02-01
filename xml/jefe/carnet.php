<?php
ini_set("memory_limit","2048M");

require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

require('../../pdf/fpdf.php');
################ Definimos la clase extendida PDF ########### 
class PDF extends FPDF {
	function fondoverde($x,$y) {
      $tam=8.4;
	  $div=0;
		 for ($n=1;$n<=10;$n+=1) {  #columnas
		   for ($s=1;$s<=6;$s+=1)	{	#fila
				if ($dib==1) {	$this->Image('./carnet/tramado_verde_logo.jpg',$x,$y,$tam);}
				if ($dib==0) {	$this->Image('./carnet/tramado_verde_fondo.jpg',$x,$y,$tam);}
				if ($dib==0) {$dib=1;} else {$dib=0;}
		    	$y=$y+$tam; 
			}
		  if ($dib==0) {$dib=1;} else {$dib=0;}
		  $y=$y-6*$tam;
		  $x=$x+$tam;
		  }
				
	}

	function fondonaranja($x,$y) {
      $tam=8.4;
	  $dib=0;
		 for ($n=1;$n<=10;$n+=1) {  #columnas
		   for ($s=1;$s<=6;$s+=1)	{	#fila
				if ($dib==1) {	$this->Image('./carnet/tramado_naranja_logo.jpg',$x,$y,$tam);}
				if ($dib==0) {	$this->Image('./carnet/tramado_naranja_fondo.jpg',$x,$y,$tam);}
				if ($dib==0) {$dib=1;} else {$dib=0;}
		    	$y=$y+$tam; 
			}
		  if ($dib==0) {$dib=1;} else {$dib=0;}
		  $y=$y-6*$tam;
		  $x=$x+$tam;
		  }
				
	}

	
	function uno($x,$y) {
      $tam=8.4;
	  $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+5*$tam,$y+$tam,$tam);
      $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+6*$tam,$y+2*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+6*$tam,$y+4*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+5*$tam,$tam);
	}

	function dos($x,$y) {
      $tam=8.4;
	  $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+5*$tam,$y+$tam,$tam);
      $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+7*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+5*$tam,$y+5*$tam,$tam);
      $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+7*$tam,$y+5*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+7*$tam,$y+2*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+5*$tam,$y+4*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+5*$tam,$tam);
	}
	function tres($x,$y) {
      $tam=8.4;
	  $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+5*$tam,$y+$tam,$tam);
      $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+7*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+5*$tam,$y+5*$tam,$tam);
      $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+7*$tam,$y+5*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_fondo.jpg',$x+7*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+7*$tam,$y+2*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+7*$tam,$y+4*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+3*$tam,$tam);
	  $this->Image('./carnet/tramado_oscuro_logo.jpg',$x+6*$tam,$y+5*$tam,$tam);
	}
}

function codigo_control($x){
	$long=strlen($x);
	$sum=206;
	
    #  La fórmula para el cálculo del código de control es valida para restos menores a 95. Para restos entre 95 y 102 son:
	#  95-chr(187) ; 96-chr(133) ; 97-¿? ; 98-chr(192) ; 99-chr(195) ; 100-¿? ; 101-chr(140) ; 102-chr(156)
	#  Únicamente tengo los códigosa hasta el chr(211) y no encuentro los corresxpondientes al resto 97 y 100.
	#  Prueba a imprimirme el pdf con los códigos hasta el chr(255).
	
	for ($n=1;$n<=strlen($x);$n+=1) {
		$num=substr($x,$n-1,1);
		$sum=$sum+($n+1)*($num+16);
	}
	$codigo= $sum%103;
	if ($codigo==0) {
		return (chr(174));}
	elseif ($codigo < 91) {
		return (chr($codigo+32));}
	else {
		return (chr($codigo+70));
	}
}
	$bib = mysqli_query($db_con, "select * from biblioteca_lectores");
	$n_bib = mysqli_num_rows($bib);
	//echo $n_bib;
############### Abrimos la base de datos y creamos la consulta
if (strlen($_POST['alumnos'])>0) {

		#elige selección múltiple
		$sel=explode("*",$_POST['alumnos']);
		foreach($sel as  $valor) {
			if (!isset($seleccion)) { $seleccion="'".$valor;}
			else {$seleccion=$seleccion."','".$valor;}		
		}
	$seleccion=$seleccion."'";
if ($n_bib>0) {
		$query_Recordset1 = "SELECT claveal, unidad, alma.apellidos, alma.nombre, fecha, combasi, biblioteca_lectores.codigo
FROM alma
INNER JOIN biblioteca_lectores ON alma.apellidos = biblioteca_lectores.apellidos
AND alma.nombre = biblioteca_lectores.nombre
AND claveal In (".$seleccion.")
ORDER BY Apellidos ASC ";
		//echo $query_Recordset1;
	}
	else{
		$query_Recordset1 = "SELECT claveal, unidad, apellidos, nombre, fecha, combasi FROM alma WHERE claveal In (".$seleccion.") ORDER BY Apellidos ASC";
	}
		$opcion=2;
	}

	elseif (isset($_POST['select'])) {		
	#elige selección de un curso
	$selecc=trim($_POST['select']);
	if ($n_bib>0) {
		$query_Recordset1 = "SELECT claveal, unidad, alma.apellidos, alma.nombre, fecha, combasi, biblioteca_lectores.codigo
FROM alma
INNER JOIN biblioteca_lectores ON alma.apellidos = biblioteca_lectores.apellidos
AND alma.nombre = biblioteca_lectores.nombre
AND Unidad = '" .$selecc ."'
ORDER BY Apellidos ASC ";
	}
	else{
		$query_Recordset1 = "SELECT claveal, unidad, apellidos, nombre, fecha, combasi FROM alma where Unidad = '" .$selecc ."' order by Apellidos ASC";
	}
		}
	
	else {
		if ($n_bib>0) {
		$query_Recordset1 = "SELECT claveal, unidad, alma.apellidos, alma.nombre, fecha, combasi, biblioteca_lectores.codigo
FROM alma
INNER JOIN biblioteca_lectores ON alma.apellidos = biblioteca_lectores.apellidos
AND alma.nombre = biblioteca_lectores.nombre
ORDER BY Apellidos ASC ";
	}
	else{
		$query_Recordset1 = "SELECT claveal, unidad, apellidos, nombre, fecha, combasi FROM alma order by Unidad, Apellidos"; #otro caso, es decir, todos los alumnos
	}
	}
//	echo $query_Recordset1;
$Recordset1 = mysqli_query($db_con, $query_Recordset1) or die(mysqli_error("No es posible conectar"));  #crea la consulata
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);  #cantidad de registros

$pdf=new PDF();
$curso='Curso '.$config['curso_actual'];
$curso_an=date('Y');
$mes_an=date('m');
//$curso_an=substr($curso,6,4)+1;
//echo "$config['curso_actual'] => $curso_an<br />";
$pdf->SetFillColor(255,255,255);
$pdf->AddPage();
$pdf->AddFont('c128ab');
$n=1; # carnet nº 1

while ($row_Recordset1 = mysqli_fetch_array($Recordset1)){
$fecha0 = str_replace("/","-",$row_Recordset1[4]);
$tr = explode("-",$fecha0);
$fecha = "$tr[2]-$tr[1]-$tr[0]";
$fecha4 = "$tr[1]-$tr[0]-$tr[2]";
$claveal = $row_Recordset1[0];
$unidad = $row_Recordset1[1];
$apellidos = $row_Recordset1[2];
$nombre = $row_Recordset1[3];
$combasi = $row_Recordset1[5];
if ($n_bib>0) {
$c_bib = $row_Recordset1[6];
$claveal_bib.=" ".$c_bib;
}
########################### Comenzamos con los carnets

	#posición del carnet
	if ($n%2==1) {
		$y=10+(round($n/2)-1)*52;
		$x=10;}
	else {$x=96;}
	$fech_ano=substr($fecha,0,4);
	$fech_mes=substr($fecha,5,2);

$fechaFinal = mktime(0,0,0,$tr[1],$tr[0],$tr[2]);
$fechaInicio = mktime(0,0,0,date('m'),date('d'),date('Y'));
$segundos = ($fechaInicio - $fechaFinal);
$anyos = floor(($segundos-$sumadiasBis)/31536000);

//echo strlen($combasi)." ".$claveal."<br>";
	$naranja=0;
	if (isset($_POST['alumnos']) && isset($_POST['checkbox'])) { $pdf->fondoverde($x,$y);
		}
	elseif ($anyos >= '18' or (strstr($row_Recordset1[1],"B-")==TRUE and strlen($row_Recordset1[5])<"54")) {
		$pdf->fondonaranja($x,$y);
		$pdf->uno($x,$y); }
	else {
		$pdf->fondoverde($x,$y);
		$naranja=0;}
		
	#Hasta aquí el fondo, ahora el texto:
	
	// CABECERA
	$pdf->Image('./carnet/junta.png',$x+3,$y+4,24);
	$pdf->Image('./carnet/consejeria.png',$x+57,$y+4,24);
	$pdf->SetTextColor(59,113,59);
	$pdf->SetFont('Arial','B',7);
	$pdf->Text(33+$x,6.1+$y,$curso);
	$pdf->SetFont('Arial','B',5);
	$pdf->Text(57.2+$x,7.7+$y,$config['centro_denominacion']);
	$pdf->SetTextColor(0,0,0);

	$longnie=strlen($claveal);
    $dplz=0;
	if ($longnie<7) {$dplz=4;}

	
	$pdf->Rect(2+$x,12+$y,23,30,'F');
	#$pdf->Rect(46+$x,36+$y,33,11,F);
	

$fileExtension=".jpg";
$foto_al = "../fotos/".$claveal.".jpg";
if (file_exists($foto_al)) {
 	$pdf->Image($foto_al,2.5+$x,12.5+$y,22);
}
	
	//$pdf->SetFont('c128ab','',40);
    //$cadena= chr(124) . chr(172). $claveal . codigo_control($claveal) . chr(126);
    //$pdf->Text(32+$x+$dplz,40+$y,$cadena);
    
/*	if (stristr($_SERVER['SERVER_NAME'],"iesmonterroso.org")==TRUE){
    		$pdf->Rect(34+$x+$dplz,36+$y,40-$dplz,13,'F');
    		$pdf->Image('http://'.$config['dominio'].'/intranet/xml/jefe/carnet/Barcode/test.php?text='.$c_bib,36+$x+$dplz,37+$y,33,0,'PNG');
    }
	    
	else*/
	
	if ($n_bib>0) {
    	
    	if ($longnie<7) {
    		$pdf->Rect(24+$x+$dplz,36+$y,58-$dplz,13,'F');
    		$pdf->Image('http://'.$config['dominio'].'/intranet/xml/jefe/carnet/Barcode/test.php?text='.$claveal.'&show=1',25+$x+$dplz,37+$y,19,0,'PNG');
    		$pdf->Image('http://'.$config['dominio'].'/intranet/xml/jefe/carnet/Barcode/test.php?text='.$c_bib.'&show=1',52+$x+$dplz,37+$y,25,0,'PNG');
    	}
    	else {
    		$pdf->Rect(28+$x+$dplz,36+$y,54-$dplz,13,'F');
    		$pdf->Image('http://'.$config['dominio'].'/intranet/xml/jefe/carnet/Barcode/test.php?text='.$claveal.'&show=1',29+$x+$dplz,37+$y,24,0,'PNG');
    		$pdf->Image('http://'.$config['dominio'].'/intranet/xml/jefe/carnet/Barcode/test.php?text='.$c_bib.'&show=1',56+$x+$dplz,37+$y,25,0,'PNG');
    	}
    	
    }
    else {
    	$pdf->Rect(46+$x+$dplz,36+$y,34-$dplz,13,'F');
    	
    	if ($longnie<7) {
    		$pdf->Image('http://'.$config['dominio'].'/intranet/xml/jefe/carnet/Barcode/test.php?text='.$claveal,49+$x+$dplz,37+$y,24,0,'PNG');
    	}
    	else {
    		$pdf->Image('http://'.$config['dominio'].'/intranet/xml/jefe/carnet/Barcode/test.php?text='.$claveal,48+$x+$dplz,37+$y,30,0,'PNG');
    	}
    }
    
	$pdf->SetFont('Arial','',7);
   	$pdf->Text(28+$x,16+$y,'Nombre:');
	$pdf->Text(28+$x,21+$y,'Apellidos:');
	$pdf->Text(28+$x,26+$y,'Curso:');
	$pdf->Text(28+$x,33+$y,'Fecha de Nacimiento:');
#	$pdf->Text(60+$x,25+$y,'N.I.E.');
	$pdf->SetFont('Arial','B',9);
	$pdf->Text(42+$x,16+$y,$nombre);
	$pdf->Text(42+$x,21+$y,$apellidos);
	$pdf->Text(42+$x,26+$y,$unidad);
	$pdf->Text(58+$x,33+$y,$fecha);
#	$pdf->Text(60+$x,30+$y,);
#	$pdf->Text(60+$x,42+$y,$claveal);
	$pdf->SetFont('Arial','',7);
   	
    if ($n_bib>0) {
    	$pdf->SetFont('Arial','B',8);
   		$pdf->Text(2+$x,49+($y-2),$claveal."   ".$c_bib);
    }
    else{
		$pdf->Text(5+$x,49+($y-2),'NIE: ');
    	$pdf->SetFont('Arial','B',8);
		$pdf->Text(10+$x,49+($y-2),$claveal);
    }
    
$n++;		#siguiente carnet
if ($n%10==1){		#cada 10 carnets empezamos en la página siguiente
	$pdf->AddPage();
	$n=1;
	}


}   #cuando termina un registro pasa al siguiente

$pdf->Output();

mysqli_free_result($Recordset1);
?>
                                                                               