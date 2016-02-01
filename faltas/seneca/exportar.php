<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
include("../menu.php");
?>
<div align="container">
<div align="row">
<div align="center">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Subir faltas a S&eacute;neca</small></h2>
</div>
<br />
<?php
if (isset($_GET['iniciofalta'])) {$iniciofalta = $_GET['iniciofalta'];}elseif (isset($_POST['iniciofalta'])) {$iniciofalta = $_POST['iniciofalta'];}
if (isset($_GET['finfalta'])) {$finfalta = $_GET['finfalta'];}elseif (isset($_POST['finfalta'])) {$finfalta = $_POST['finfalta'];}
if (isset($_GET['Submit'])) {$Submit = $_GET['Submit'];}elseif (isset($_POST['Submit'])) {$Submit = $_POST['Submit'];}

	$dir = "./origen/";
	$fecha0 = explode("/",$_GET['iniciofalta']);
	$fecha10 = explode("/",$_GET['finfalta']);

$dir0 = "./exportado/";
$ficheroseliminados="";
$handle0 = opendir($dir0);
while ($file0 = readdir($handle0)) {
 if (is_file($dir0.$file0) and strstr($file0,"xml")==TRUE) {
  if ( unlink($dir0.$file0) ){
   $ficheroseliminados++;
  }
 }
}
// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
if ($handle = opendir($dir)) {
$ni=0;
while (false !== ($file = readdir($handle))) {

//header('Content-Type: text/xml');
$doc = new DOMDocument('1.0', 'iso-8859-1');
/*Cargo el XML*/
$doc->load( './origen/'.$file );

// Variables comunes
$curso = explode("_",$file);
$nivel = strtoupper(substr($curso[0],0,2));
$grupo = strtoupper(substr($curso[0],2,1));

	$ni+=1;
$x_ofert = $doc->getElementsByTagName( "X_OFERTAMATRIG" );
$d_ofert = $doc->getElementsByTagName( "D_OFERTAMATRIG" );
$x_unida = $doc->getElementsByTagName( "X_UNIDAD" );
$t_nombr = $doc->getElementsByTagName( "T_NOMBRE" );
$x_oferta = $x_ofert->item(0)->nodeValue;
$d_oferta = $d_ofert->item(0)->nodeValue;
$x_unidad = $x_unida->item(0)->nodeValue;
$t_nombre = $t_nombr->item(0)->nodeValue;
$n_curso=utf8_decode($d_oferta); 
$n_curso1 = utf8_decode($n_curso);     
$hoy = date('d/m/Y')." 08:00:00"; 
$ano_curso=substr($config['curso_inicio'],0,4); 
$xml="<SERVICIO>
  <DATOS_GENERALES>
    <MODULO>FALTAS DE ASISTENCIA</MODULO>
    <TIPO_INTERCAMBIO>I</TIPO_INTERCAMBIO> 
    <AUTOR>SENECA</AUTOR>
    <FECHA>$hoy</FECHA>
    <C_ANNO>$ano_curso</C_ANNO>
    <FECHA_DESDE>$iniciofalta</FECHA_DESDE>
    <FECHA_HASTA>$finfalta</FECHA_HASTA>
    <CODIGO_CENTRO>".$config['centro_codigo']."</CODIGO_CENTRO>
    <NOMBRE_CENTRO>".$config['centro_denominacion']."</NOMBRE_CENTRO>
    <LOCALIDAD_CENTRO>".$config['centro_localidad']."</LOCALIDAD_CENTRO>
  </DATOS_GENERALES>
  <CURSOS>
    <CURSO>
      <X_OFERTAMATRIG>$x_oferta</X_OFERTAMATRIG>
      <D_OFERTAMATRIG>$n_curso</D_OFERTAMATRIG>
      <UNIDADES>
        <UNIDAD>
          <X_UNIDAD>$x_unidad</X_UNIDAD>
          <T_NOMBRE>$t_nombre</T_NOMBRE>
          <ALUMNOS>";
$alumn = $doc->getElementsByTagName( "ALUMNO" );
foreach ($alumn as $alumno){
	$x_matricul = $alumno->getElementsByTagName( "X_MATRICULA" );
	$x_matricula = $x_matricul->item(0)->nodeValue;	
	$clavea = $alumno->getElementsByTagName( "C_NUMESCOLAR" );
	$claveal = $clavea->item(0)->nodeValue;

	$xml.="
	<ALUMNO>
       <X_MATRICULA>$x_matricula</X_MATRICULA>
       <FALTAS_ASISTENCIA>";

	include 'exportado.php';
	
	$xml.="
        </FALTAS_ASISTENCIA>
       </ALUMNO>";

}
$xml.="         
     </ALUMNOS>
    </UNIDAD>
   </UNIDADES>
  </CURSO>
 </CURSOS>
</SERVICIO>";
$fp1=fopen("exportado/".$file."","w");
$pepito2=fwrite($fp1,$xml);
}

if ($ni==0) {
	echo '<div align="center""><div class="alert alert-danger alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
	Parece que no hay archivos que se puedan procesar en el directorio /faltas/seneca/origen/. Asegúrate de que el directorio contiene los archivos exportados desde Séneca..
			</div></div><br />';
exit();
}
?>
<div align="center"><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
	 Las Faltas de Asistencia se han escrito correctamente en los archivos  del directorio /exportado/. <br />Puedes proceder a importarlos a Séneca.
			</div></div><br />
<?php
}
else{
	
	?>
<div align="center"><div class="alert alert-success alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Selecciona las fechas de comienzo y final del registro de faltas en el formulario.
			</div></div><br />	
	<?php
}
?>
</div>
</div>
</div>