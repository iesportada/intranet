<?php
require('../../bootstrap.php');


$profesor = $_SESSION ['profi'];


if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['imprimir'])) {$imprimir = $_GET['imprimir'];}elseif (isset($_POST['imprimir'])) {$imprimir = $_POST['imprimir'];}else{$imprimir="";}

require_once("../../pdf/dompdf_config.inc.php"); 
define("DOMPDF_ENABLE_PHP", true);

if ($imprimir=="1") {
		mysqli_query($db_con, "update r_departamento set impreso = '1' where id = '$id'");
}
	$query = "SELECT contenido, fecha, departamento FROM r_departamento WHERE id = '$id'";
   	$result = mysqli_query($db_con, $query) or die ("Error en la Consulta: $query. " . mysqli_error($db_con));
   	if (mysqli_num_rows($result) > 0)
   	{
   	  	
   	  	$html .= '<html><body>';
   	  	
		$html .= '
					<style type="text/css">
					html {
					  margin: 0 !important;
					}
					body {
					  font-family: Arial, Helvetica, sans-serif !important;
					  font-size: 11pt !important;
					  margin: 20mm 20mm 30mm 25mm !important;
					}
					</style>';
   	  	
   		$row = mysqli_fetch_array($result);
   		$contenido = $row[0];
   		$html .= mb_convert_encoding($contenido, 'UTF-8', 'ISO-8859-1');
   		$html .= '</body></html>';
   		
   		$fecha = $row[1];
   		$departamento = $row[2];
   	}
 
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Acta de Departamento $departamento $fecha.pdf", array("Attachment" => 0));
?>