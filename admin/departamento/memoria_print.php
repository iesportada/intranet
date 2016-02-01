<?php
require('../../bootstrap.php');

require_once("../../pdf/dompdf_config.inc.php"); 


$n_preg=15;
// Miembros
$depto=$_SESSION ['dpt'];

$campos=array('p1','p2','p3','p4','p5','p6','p7','p8','p9','p10','p11','p12','p13','p14','p15','p16','p17','p18','p19','p20');
#Preguntas
$pregunta[1]='1.1. Composición.';
$nota[1]='Miembros del Departamento, reparto de asignaturas, etc...';
$pregunta[2]='1.2. Reuniones del Departamento.';
$nota[2]='Número de reuniones aprox., asuntos y acuerdos más importantes.';
$pregunta[3]='1.3. Consideraciones generales.';
$nota[3]='Valoración general del funcionamiento del Departamento.';
$pregunta[4]='2. Análisis y propuestas de mejora de los resultados académicos.';
$nota[4]='';
$pregunta[5]='3. Seguimiento de la programación.';
$nota[5]='Análisis y descripción del grado de consecución de los objetivos propuestos en la programación por asignatura y grupo.';
$pregunta[6]='4.1.¿Se han aplicado y revisado los criterios de evaluación de cada asignatura?, ¿Cómo?. Indica los avances y dificultades más significativas al respecto.';
$nota[6]='';
$pregunta[7]='4.2.¿Se concretaron objetivos y contenidos mínimos al principio de curso? En caso afirmativo, ¿qué consecuencia ha tenido esta medida?';
$nota[7]='';
$pregunta[8]='5.1. Alumnos con materias pendientes de otros cursos.';
$nota[8]='Metodología. Análisis de los resultados y propuestas de mejora.';
$pregunta[9]='5.2. Adaptaciones curriculares.';
$nota[9]='¿Ha sido necesario aplicar alguna ACIs? En caso afirmativo, indicar alumno, nivel, asignatura y resultado.';
$pregunta[10]='6. Proyecto TIC.';
$nota[10]='Aplicación de las TIC en el aula, valoración y sugerencias.';
$pregunta[11]='7. Plan de Lectura';
$nota[11]='Acciones referentes al plan de lectura y valoración.';
$pregunta[12]='8. Actividades complementarias y extraescolares.';
$nota[12]='Valoración.';
$pregunta[13]='9. Material necesario.';
$nota[13]='Dentro de las circunstancias que rodean a nuestro Centro, ¿qué material consideras que es necesario para poder impartir mejor tu(s) asignatura(s) el curso que viene?';
$pregunta[14]='10. Formación';
$nota[14]='Propuestas de formación.';
$pregunta[15]='11. Propuestas y comentarios generales.';
$nota[15]='Usa este espacio para cualquier cuestión que no esté contemplada en los puntos anteriores.';
$pregunta[16]='Esta es la 16º pregunta';
$nota[16]='';
$pregunta[17]='Esta es la 17º pregunta';
$nota[17]='';
$pregunta[18]='Esta es la 18º pregunta';
$nota[18]='';
$pregunta[19]='Esta es la 19º pregunta';
$nota[19]='';
$pregunta[20]='Esta es la 20º pregunta';
$nota[20]='';

if (isset($_POST['zprofe'])){$profe = $_POST['zprofe'];}

###############
# Lectura de los datos de la memoria
##############

$sqlmem="SELECT * FROM mem_dep WHERE departamento='".$_GET['depto']."'";
//echo $sqlmem;
$datos_memoria= mysqli_query($db_con, $sqlmem);
$memoria = mysqli_fetch_array($datos_memoria);
$nombre_dep = $memoria[0];
# Se le asigna a los campo un valor más manejable
for ( $i = 1 ; $i <= $n_preg ; $i ++) {
$p[$i]=$memoria[$i+1];
}
if ($memoria[1]!=''){$profe=$memoria[1];}

$html .= '<html><body>';
$html.='<style type="text/css">
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
</div>'; 
$html.=  '<div>';
#Cabecera
$html.=  '<h1 align="center">' . $config['centro_denominacion'] . '</h1><hr style="color:#eee;">';
$html.=  '<h2 align="center">Memoria final del Departamento<br /> '.$depto.'</h2>';
$html.=  '<h3 align="center">Departamento:  '.$nombre_dep.'</h2>';
$html.=  '<h3 align="center">Curso: '.$config['curso_actual'].'</h3><hr style="color:#eee;"></div>';

for ($i=1; $i<=$n_preg; $i++){
if ($i==1) {$html.=  "<h3>"."1. Aspectos organizativos del departamento"."</h3>";}
if ($i==6) {$html.=  "<h3>"."4. Criterios de Evaluación."."</h3>";}
if ($i==8) {$html.=  "<h3>"."5. Medidas de atención a la diversidad."."</h3>";}
$html.=  "<h4>".$pregunta[$i]."</h4>";
$html.=  "<h5>".$nota[$i]."</h5>";
$html.=  '<div style="border:0px solid #aaa; padding: 10px;">';
$html.=  strip_tags($p[$i], '<br><p><strong><em><b><i><ul><ol><li><table><tr><td><th>').'</div><br>';
}

####################
# Fin de la lectura de datos de la memoria
####################

$html.=  '<table style="border:0px; padding: 1px;><tr><td style="border:0px; padding: 10px;">';

$html.=  '</td></tr></table>';

# Firma del tutor/a
$html.=  '<div align=center><br><br>'.$config['centro_localidad'].', '.formatea_fecha(date("Y/m/d"));
$html.=  '<br><br><br><br>';
$html.=  'Fdo.: '.$memoria[1];

$html.=  '</div></div></body></html>';

$html = mb_convert_encoding($html, 'UTF-8', 'ISO-8859-1');
$depto = mb_convert_encoding($depto, 'UTF-8', 'ISO-8859-1');

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Memoria del Departamento de $depto.pdf", array("Attachment" => 0));
mysqli_close();
?>
