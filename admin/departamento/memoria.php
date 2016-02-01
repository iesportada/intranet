<?php
ini_set("session.cookie_lifetime","5600"); 
ini_set("session.gc_maxlifetime","7200");

require('../../bootstrap.php');


$profesor = $_SESSION ['profi'];
$n_preg=15;

include '../../menu.php';
// Creación de la tabla
mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `mem_dep` (
  `departamento` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `jefe` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `p1` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p2` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p3` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p4` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p5` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p6` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p7` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p8` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p9` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p10` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p11` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p12` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p13` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p14` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p15` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p16` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p17` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p18` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p19` longtext COLLATE latin1_spanish_ci NOT NULL,
  `p20` longtext COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`departamento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
// Miembros
$depto=$_SESSION ['dpt'];
$dep0 = mysqli_query($db_con, "select nombre from departamentos where departamento = '$depto'");
$miembros.="Los profesores que componen el Departamento, así como sus grupos y las asignaturas que imparten a los mismos son los siguientes:<br><br>";
while ($dep = mysqli_fetch_array($dep0)) {
	$jefe=$dep[0]."<br>\n";
	$cl = "";
	$grupos0 = mysqli_query($db_con, "select distinct grupo, materia from profesores where profesor = '$dep[0]'");
	while ($grupos = mysqli_fetch_array($grupos0)) {
	$cl.=$grupos[0]." (".$grupos[1]."), ";
	}
	$cl = substr($cl,0,-2);
	$miembros.=$jefe.$cl."<br>\n\n";
}
// Actividades
$act0 = mysqli_query($db_con, "select distinct actividad, grupos, fecha from actividades where departamento = '$depto'");
//echo "select nombre from departamentos where departamento = '$depto'";
if (mysqli_num_rows($act0)>0) {
	$activ.= "Las actividades complementarias y extraescolares realizadas por el Departamento son las siguientes:<br><br>";
}
while ($act = mysqli_fetch_array($act0)) {
	$jefe2=$act[2].". ".$act[0]."<br />\nGrupos afectados por la actividad: ";
	$cl2 = $act[1];
	$cl2 = substr($cl2,0,-1);
	$activ.=$jefe2.$cl2."<br>\n\n";
}

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
$pregunta[6]='4.1. ¿Se han aplicado y revisado los criterios de evaluación de cada asignatura?, ¿cómo?. Indica los avances y dificultades más significativas al respecto.';
$nota[6]='';
$pregunta[7]='4.2. ¿Se concretaron objetivos y contenidos mínimos al principio de curso? En caso afirmativo, ¿qué consecuencia ha tenido esta medida?';
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

// Jefe del departamento
$j_dep = mysqli_query($db_con, "select nombre from departamentos where departamento = '$depto' and cargo like '%4%'");
$jef_dep = mysqli_fetch_array($j_dep);
$profe = $jef_dep[0];

// Actualización de datos
// Se comprueba si hay envío y se actualiza el registro correspondiente con update
if (isset($_POST['aceptar'])){$aceptar=$_POST['aceptar'];}else{$aceptar='';}

if($aceptar == "Si"){

//Comprobamos si está el registro para crearlo si no lo encontramos;
	$sqlmem="SELECT departamento FROM mem_dep WHERE departamento='".$depto."'";
	$datos_memoria= mysqli_query($db_con, $sqlmem);
	$memoria = mysqli_fetch_array($datos_memoria);
	if ($memoria[0]=='') {
		mysqli_query($db_con, "INSERT INTO  mem_dep (departamento, jefe) VALUES ('".$depto."', '".$profe."')");
	}
	else{
		mysqli_query($db_con, "update mem_dep set jefe = '$profe' where departamento = '$depto'");
	}

foreach($campos as $nombre_del_campo)
{
if (!isset($_POST[$nombre_del_campo]) or ($_POST[$nombre_del_campo]=='')){$_POST[$nombre_del_campo]="";
}	
}


$actualiza = "UPDATE  mem_dep SET  ";
for ($i=1; $i<=$n_preg; $i++){ $actualiza.="p".$i." = '".$_POST[$campos[$i-1]]."',";}
$actualiza.=" jefe = '".$profe."'";
$actualiza.=" WHERE departamento =  '".$depto."' LIMIT 1 ";
//echo $actualiza.'<br>';
mysqli_query($db_con, $actualiza);	
}
// Fin Actualización de datos

// Lectura de los datos de la memoria
#Seleccionamos ahora el registro del grupo
$sqlmem="SELECT * FROM mem_dep WHERE departamento='".$depto."'";
//echo $sqlmem;
$datos_memoria= mysqli_query($db_con, $sqlmem);
$memoria = mysqli_fetch_array($datos_memoria);
# Se le asigna a los campo un valor más manejable
for ( $i = 1 ; $i <= $n_preg ; $i ++) {
$p[$i]=$memoria[$i+1];
}
if (!($memoria[1]=='')){$profe=$memoria[1];}

?>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
	  <h2>Jefatura de Departamento <small>Memoria final</small></h2>
	  <h3 class="text-info">Departamento de <?php echo $_SESSION['dpt']; ?></h3>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
		
		<!-- COLUMNA CENTRAL -->
		<div class="col-sm-12">
			
			<div class="well">
<?php 

	if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'4') == TRUE){
		echo '<form action="memoria.php?depto='.$depto.'" method="post" name="memoria">';
	}
	echo '<div class="form-group">';
	echo '<input type="hidden" name="aceptar" value="Si" />';
	#  preguntas
	echo '<label for="inputZprofe">Jefe del Departamento</label> ';

	$prof = mysqli_query($db_con, "SELECT nombre FROM departamentos where departamento = '$depto' and cargo like '%4%'");
	$profes = mysqli_fetch_row($prof);
	
	echo '<input type="text" class="form-control" disabled name="zprofe" value = "'.$profes[0].'">';
	echo '</div>';

for ($i=1; $i<=$n_preg; $i++){
if ($i==1) {echo "<h3>"."1. Aspectos organizativos del departamento"."</h3>";}
if ($i==6) {echo "<h3>"."4. Criterios de Evaluación."."</h3>";}
if ($i==8) {echo "<h3>"."5. Medidas de atención a la diversidad."."</h3>";}
echo "<h4 class=\"text-info\">".$pregunta[$i]."</h4>";
echo "<p class='text-muted'>".$nota[$i]."</p>";
if (strstr($pregunta[$i], "1.1.")==TRUE and strlen($p[$i])<"5") {
	$contenido = $miembros;
}
elseif (strstr($pregunta[$i], "2. Análisis")==TRUE and strlen($p[$i])<"5") {
	$contenido = '<p>1. Evoluci&oacute;n de los resultados acad&eacute;micos: an&aacute;lisis seg&uacute;n niveles y grupos.</p>
<p><br></p>
<p><br></p>
<p>2. An&aacute;lisis de causas de las posibles divergencias.</p>
<p><br></p>
<p><br></p>
<p>3. Medidas adoptadas para la mejora de resultados durante el curso actual</p>
<p><br></p>
<p><br></p>';
}
elseif (strstr($pregunta[$i], "3. Seguimiento")==TRUE and strlen($p[$i])<"5") {
	$contenido = '<p>1. An&aacute;lisis y descripci&oacute;n del grado de cumplimiento de la programaci&oacute;n por asignatura, nivel y grupo.</p>
<p><br></p>
<p><br></p>
<p>2. Propuestas de modificaciones de la programaci&oacute;n (objetivos, contenidos, metodolog&iacute;a, temporalizaci&oacute;n...).</p>
<p><br></p>
<p><br></p>';
}
elseif (strstr($pregunta[$i], "5.1.")==TRUE and strlen($p[$i])<"5") {
	$contenido = '<p>1. Miembros del Departamento responsables del seguimiento del alumnado con materias pendientes</p>
<p><br></p>
<p><br></p>
<p>2. Resultados obtenidos: causas de posibles divergencias</p>
<p><br></p>
<p><br></p>
<p>3. Seguimiento del programa de recuperaci&oacute;n: caracter&iacute;sticas de los programas, plazos...</p>
<p><br></p>
<p><br></p>';
}
elseif(strstr($pregunta[$i], "8. Act")==TRUE and strlen($p[$i])<"5"){
	$contenido = $activ;
}
else{
	$contenido = $p[$i];
}
echo '
<div class="form-group">
<textarea class="form-control" id="'.$campos[$i-1].'" name="'.$campos[$i-1].'">';
echo $contenido;
echo '</textarea></div><hr>';
}
	if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'4') == TRUE){
echo '<center><button class="btn btn-primary" type="submit" name="procesar" value="Guardar" ><i class="fa fa-pencil-square-o "> </i> Guardar</button>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" target="_blank" href="memoria_print.php?depto='.$depto.'"><i class="fa fa-print "> </i> Imprimir</a></center>';
	}
echo "</form>";
?>
			</div><!-- /.well -->
			 
		</div><!-- /.col-sm-12 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include('../../pie.php'); ?>

	<script>
	$(document).ready(function() {
	
		// EDITOR DE TEXTO
		for (var i = 1; i <= 15; i++) {
			$('#p'+i).summernote({
				height: 260,
				lang: 'es-ES',
			});
		}

	});
	</script>

</body>
</html>
