<?php
require('../../bootstrap.php');


if ((stristr($_SESSION['cargo'],'1') == false) && (stristr($_SESSION['cargo'],'2') == false)) {
	die ("<h1>FORBIDDEN</h1>");
}

if (isset($_GET['id'])) $id = $_GET['id'];

if (!$id) {
	die ("<h1>FORBIDDEN</h1>");
}

require_once("../../pdf/dompdf_config.inc.php"); 

// REGISTRAMOS LA ACCION
mysqli_query($db_con, "UPDATE evaluaciones_actas SET impresion=1 WHERE id=$id");

// OBTENEMOS LOS DATOS
$result = mysqli_query($db_con, "SELECT unidad, evaluacion, texto_acta FROM evaluaciones_actas WHERE id=$id");

if (mysqli_num_rows($result)) {
	$row = mysqli_fetch_array($result);
	
	$unidad = $row['unidad'];
	$evaluacion = $row['evaluacion'];
	$texto_acta = $row['texto_acta'];
	$texto_acta = '<style type="text/css">
	body {
		font-size: 10pt;
	}
	#footer {
		position: fixed;
	 left: 0;
		right: 0;
		bottom: 0;
		color: #aaa;
		font-size: 0.9em;
		text-align: right;
	}
	.page-number:before {
	  content: counter(page);
	}
	</style>
	<div id="footer">
	  Página <span class="page-number"></span>
	</div>'.$texto_acta;
	$html = mb_convert_encoding($texto_acta, 'UTF-8', 'ISO-8859-1');
	
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream("Acta de evaluación $evaluacion - $unidad.pdf", array("Attachment" => 0));
}
?>