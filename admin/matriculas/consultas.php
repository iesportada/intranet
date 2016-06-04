<?php
ini_set("session.cookie_lifetime",1800);
ini_set("session.gc_maxlifetime",1800);

require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'7') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE))
{
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');
	exit;
}


if (isset($_GET['curso'])) {$curso = $_GET['curso'];}elseif (isset($_POST['curso'])) {$curso = $_POST['curso'];}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}
if (isset($_GET['consulta'])) {$consulta = $_GET['consulta'];}elseif (isset($_POST['consulta'])) {$consulta = $_POST['consulta'];}

// Control de tablas
$bck =mysqli_query($db_con,"select divorcio from matriculas_backup");
if (mysqli_num_rows($bck)>0) {}else{
	mysqli_query($db_con,"ALTER TABLE `matriculas_backup` ADD `enfermedad` VARCHAR(254) NULL , ADD `otraenfermedad` VARCHAR(254) NULL , ADD `foto` TINYINT(1) NOT NULL , ADD `divorcio` VARCHAR(64) NULL , ADD `matematicas3` CHAR(1) NULL");
	mysqli_query($db_con,"ALTER TABLE `matriculas_bach_backup` ADD `enfermedad` VARCHAR(254) NULL , ADD `otraenfermedad` VARCHAR(254) NULL , ADD `foto` TINYINT(1) NOT NULL , ADD `divorcio` VARCHAR(64) NULL , ADD `bilinguismo` CHAR(2) NULL , ADD `religion1b` VARCHAR(64) NULL");
}

if (isset($_POST['listados'])) {
	foreach ($_POST as $key=>$val)
	{
		if (strlen($val)==1 and !(is_numeric($val))) {
			$cur_actual=$val;
		}
	}
	include("listados.php");
	exit();
}

if (isset($_POST['listado_total'])) {
	include("listado_total.php");
	exit();
}

if (isset($_POST['listado_simple'])) {
	include("listado_simple.php");
	exit();
}

if (isset($_POST['imprimir'])) {
	mysqli_query($db_con, "drop table if exists matriculas_temp");
	mysqli_query($db_con, "CREATE TABLE  `matriculas_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
		$tr = explode("-",$key);
		$id_submit = $tr[1];
		$col = $tr[0];
		if (is_numeric($id_submit)) {

			mysqli_query($db_con, "insert into matriculas_temp VALUES ('$id_submit')");
		}
	}
	include("imprimir.php");
	exit();
}

if (isset($_POST['caratulas'])) {
	mysqli_query($db_con, "drop table if exists matriculas_temp");
	mysqli_query($db_con, "CREATE TABLE  `matriculas_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
		$tr = explode("-",$key);
		$id_submit = $tr[1];
		$col = $tr[0];
		if (is_numeric($id_submit)) {
			mysqli_query($db_con, "insert into matriculas_temp VALUES ('$id_submit')");
		}
	}
	include("caratulas.php");
	exit();
}



if (isset($_POST['cambios'])) {
	include("../../menu.php");
	include("menu.php");
	mysqli_query($db_con, "drop table if exists matriculas_temp");
	mysqli_query($db_con, "CREATE TABLE  `matriculas_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
		$tr = explode("-",$key);
		$id_submit = $tr[1];
		$col = $tr[0];
		if (is_numeric($id_submit)) {

			mysqli_query($db_con, "insert into matriculas_temp VALUES ('$id_submit')");
		}
	}

	$camb = mysqli_query($db_con, "select distinct id_matriculas from matriculas_temp");
	echo '<br><h3 align="center">Alumnos de <span style="color:#08c">'.$curso.'</span> con datos cambiados.</h3><br /><br />';
	echo "<div class='well well-large' style='width:520px;margin:auto;'>";
	while ($cam = mysqli_fetch_array($camb)) {
		$text_n="";
		$text_t="";
		$id_cambios = $cam[0];
		if ($curso == "1ESO") {$alma="alma_primaria";}else{$alma="alma_primera";}
		$contr = mysqli_query($db_con, "select matriculas.apellidos, $alma.apellidos, matriculas.nombre, $alma.nombre, matriculas.domicilio, $alma.domicilio, matriculas.dni, $alma.dni, matriculas.padre, concat(primerapellidotutor,' ',segundoapellidotutor,', ',nombretutor), matriculas.dnitutor, $alma.dnitutor, matriculas.telefono1, $alma.telefono, matriculas.telefono2, $alma.telefonourgencia, $alma.claveal from matriculas, $alma where $alma.claveal=matriculas.claveal and id = '$id_cambios'");
		//$col_datos = array()
		$control = mysqli_fetch_array($contr);
		if (strlen($control[16])>0) {
			$text_n = "<p style='color:#08c'>$control[16]: $control[0], $control[2]</p>";
			for ($i = 0; $i < 18; $i++) {
				if ($i%2) {
					if ($i=="5" and strstr($control[$i], $control[$i-1])==TRUE) {}
					elseif ($i=="17") {}
					else{
						if ($control[$i]==$control[$i-1]) {}else{
							$text_t.= "<li><span class='text-error'>Séneca:</span> ".$control[$i]." ==> <span class='text-error'>Matrícula:</span> ".$control[$i-1]."</li>";
						}
					}
				}
			}
		}
			if(strlen($text_t)>0){
			echo $text_n.$text_t."<hr>";
		}
	}
	echo "</div>";
	mysqli_query($db_con, "drop table matriculas_temp");
	exit();
}


if (isset($_POST['sin_matricula'])) {
	include("../../menu.php");
	include("menu.php");
	echo "<br>";
	if ($curso=="4ESO") {
		$tabla ='matriculas_bach';
	}
	else{
		$tabla = 'matriculas';
	}
	if ($curso=="1ESO") {
		$tabla_origen='alma_primaria';
		$cur_cole = "6";
		$cur_monterroso = substr($curso, 0, 1);
		$cole_nene = ", colegio";
		$cole_order = "colegio,";
		$tabla_origen2='alma';

		$query2 = "select distinct alma_primaria.apellidos, alma_primaria.nombre, alma_primaria.unidad, alma_primaria.telefono, alma_primaria.telefonourgencia, alma_primaria.fecha from alma_primaria, matriculas where alma_primaria.claveal=matriculas.claveal and (confirmado not like '1') order by alma_primaria.unidad, alma_primaria.apellidos, alma_primaria.nombre";

		$camb = mysqli_query($db_con, "select distinct apellidos, nombre, unidad, telefono, telefonourgencia, fecha $cole_nene from $tabla_origen where claveal not in (select claveal from $tabla) and curso like '$cur_cole%' order by $cole_order unidad, apellidos, nombre");

		echo '<h3 align="center">Alumnos de '.$curso.' sin matricular de Colegios de Primaria.</h3><br />';
		echo "<div class='well well-large' style='width:700px;margin:auto;'><ul class='unstyled'>";
		while ($cam = mysqli_fetch_array($camb)) {
			if(strlen($cam[6])>0){$cole = " ($cam[6])";}else{$cole="";}
			echo "<li><i class='fa fa-user'></i> &nbsp;<span style='color:#08c'>$cam[0], $cam[1]</span> --> <strong style='color:#9d261d'>$cam[2]</strong> : $cam[3] - $cam[4] ==> $cam[5] $cole</li>";

		}
		echo "</ul></div><br />";
	}
	else{
		$tabla_origen = 'alma';
		$tabla_origen2 = 'alma';
		$cur_monterroso = substr($curso, 0, 1);
		$cole_nene = "";
		$cole_order = "";
		$query2 = "select distinct alma.apellidos, alma.nombre, alma.unidad, alma.telefono, alma.telefonourgencia, alma.fecha from alma, matriculas where alma.claveal=matriculas.claveal  and alma.curso like '$cur_monterroso%' and alma.curso like '%E.S.O.' and confirmado not like '1' order by unidad, apellidos, nombre";
	}

	$camb2 = mysqli_query($db_con, "select distinct apellidos, nombre, unidad, telefono, telefonourgencia, fecha from $tabla_origen2 where claveal not in (select claveal from $tabla) and curso like '$cur_monterroso%' and curso like '%E.S.O.' order by unidad, apellidos, nombre");

	echo '<h3 align="center">Alumnos de '.$curso.' sin matricular de nuestro Centro.</h3><br />';
	echo "<div class='well well-large' style='width:700px;margin:auto;'><ul class='unstyled'>";
	while ($cam2 = mysqli_fetch_array($camb2)) {
		if(strlen($cam[6])>0){$cole = " ($cam2[6])";}else{$cole="";}
		echo "<li><i class='fa fa-user'></i> &nbsp;<span style='color:#08c'>$cam2[0], $cam2[1]</span> --> <strong style='color:#9d261d'>$cam2[2]</strong> : $cam2[3] - $cam2[4] ==> $cam2[5] $cole</li>";

	}
	echo "</ul></div><br />";

	$canf = mysqli_query($db_con, $query2);
	echo '<h3 align="center">Alumnos de '.$curso.' prematriculados sin confirmar.</h3><br />';
	echo "<div class='well well-large' style='width:600px;margin:auto;'><ul class='unstyled'>";
	while ($cam2 = mysqli_fetch_array($canf)) {
		echo "<li><i class='fa fa-user'></i> &nbsp;<span style='color:#08c'>$cam2[0], $cam2[1]</span> --> <strong style='color:#9d261d'>$cam2[2]</strong> : $cam2[3] - $cam2[4] ==> $cam2[5]</li>";

	}
	echo "</ul></div>";
	exit();
}

?>

<?php
include("../../menu.php");
include("./menu.php");

foreach($_POST as $key => $val)
{
	${$key} = $val;
}

foreach($_GET as $key_get => $val_get)
{
	${$key_get} = $val_get;
}
?>
<div class="container">

<div class="page-header">
<h2>Matriculación de alumnos <small> Alumnos/as matriculados en ESO</small></h2>
</div>
<br>

<?php
echo '<div  class="hdden-print">';
include 'filtro.php';
echo "</div>";
if (isset($_GET['borrar'])) {
	mysqli_query($db_con, "insert into matriculas_backup (select * from matriculas where id = '$id')");
	mysqli_query($db_con, "delete from matriculas where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El alumno ha sido borrado de la tabla de matrículas. Se ha creado una copia de respaldo de us datos en la tabla matriculas_backup.
</div></div><br />' ;
}
if (isset($_GET['copia'])) {
	mysqli_query($db_con, "delete from matriculas where id='$id'");
	mysqli_query($db_con, "insert into matriculas (select * from matriculas_backup where id = '$id')");
	mysqli_query($db_con, "delete from matriculas_backup where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos originales de la matrícula del alumno han sido correctamente restaurados.
</div></div><br />' ;
}
if (isset($_GET['consulta']) or isset($_POST['consulta'])) {

	if ($curso) {$extra=" curso='$curso' ";}else{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has seleccionado el Nivel. Así no podemos seguir...
</div></div>' ;
		exit();
	}
}

$n_curso = substr($curso, 0, 1);

if ($diversificacio=="Si") { $extra.=" and diversificacion = '1'";	}elseif ($diversificacio=="No"){ $extra.=" and diversificacion = '0'"; }
if ($exencio=="Si") { $extra.=" and exencion = '1'";	}elseif ($exencio=="No") { $extra.=" and exencion = '0'"; }
if ($promocion=="Promociona") { $extra.=" and promociona = '1'";	}elseif($promocion=="PIL"){ $extra.=" and promociona = '2'"; }elseif($promocion=="Repite"){$extra.=" and promociona = '3'";}
if ($optativ) { $extra.=" and $optativ = '1'";}
if ($religio) { $extra.=" and religion = '$religio'";}
if ($letra_grup) { $extra.=" and letra_grupo = '$letra_grup'";}
if ($_POST['grupo_actua']) {

	$extra.=" and ( ";
	foreach ($_POST['grupo_actua'] as $grup_actua){
		if($grup_actua=="Ninguno"){$extra.=" grupo_actual = '' or";}
		else{
			$extra.=" grupo_actual = '$grup_actua' or";
		}
	}
	$extra = substr($extra,0,strlen($extra)-2);
	$extra.=")";

}
if ($grupo_actua_seg) { if($grupo_actua_seg=="Ninguno"){$extra.=" and grupo_actual = ''";} else{  $extra.=" and grupo_actual = '$grupo_actua_seg'";}}
if ($colegi) { $extra.=" and colegio = '$colegi'";}
if ($actividade) { $extra.=" and act1 = '$actividade'";}
if ($itinerari and $n_curso=='4') { $extra.=" and itinerario = '$itinerari'";}
if ($matematica4 and $n_curso=='4') { $extra.=" and matematicas4 = '$matematica4'";}
if ($matematica4 and $n_curso=='3') { $extra.=" and matematicas3 = '$matematica4'";}
if ($transport == "ruta_este") { $extra.=" and ruta_este != ''";}
if ($transport == "ruta_oeste") { $extra.=" and ruta_oeste != ''";}
if ($bilinguism == "Si") { $extra.=" and bilinguismo = 'Si'";}
if ($bilinguism == "No") { $extra.=" and bilinguismo = ''";}
if ($itinerario == "0") { $itinerario = "";	}
if (strlen($dn)>5) {$extra.=" and dni = '$dn'";}
if (strlen($apellid)>1) {$extra.=" and apellidos like '%$apellid%'";}
if (strlen($nombr)>1) {$extra.=" and nombre like '%$nombr%'";}
if (!($orden)) {
	$orden=" ";
	if (isset($_POST['op_orden'])) {
		$op_filtro= $_POST['op_orden'];
		if ($_POST['op_orden']=="optativas") {
			$orden.="optativa1, optativa2, optativa3, optativa4, optativa5, optativa6, optativa7, ";
		}
		elseif ($_POST['op_orden']=="actividades") {
			$orden.="act1, act2, act3, act4, ";
		}
		else{
			$orden.="$op_filtro desc, ";
		}
	}

	if ($curso=="1ESO") {
		// En Junio puede interesar ordenar por colegio
		if (date('m')>'05' and date('m')<'09'){
			$orden.="colegio, ";
		}
		else{
			$orden.="";
		}
	}

	include 'procesado.php';

	// Optativas de ESO
	$opt1 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Tecnología Aplicada");
	$opt2 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Métodos de la Ciencia");
	$opt3 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Cultura Clásica", "Taller T.I.C. III", "Taller de Cerámica", "Taller de Teatro");
	$opt41=array("Alemán2_1" => "Alemán 2º Idioma", "Francés2_1" => "Francés 2º Idioma", "Informatica_1" => "Informática");
	$opt42=array("Alemán2_2" => "Alemán 2º Idioma", "Francés2_2" => "Francés 2º Idioma", "Informatica_2" => "Informática", "EdPlástica_2" => "Ed. Plástica y Visual");
	$opt43=array("Alemán2_3" => "Alemán 2º Idioma", "Francés2_3" => "Francés 2º Idioma", "Informatica_3" => "Informática", "EdPlástica_3" => "Ed. Plástica y Visual");
	$opt44=array("Alemán2_4" => "Alemán 2º Idioma", "Francés2_4" => "Francés 2º Idioma", "Tecnología_4" => "Tecnología");
	//	$a1 = array("Actividades de refuerzo de Lengua Castellana", "Actividades de refuerzo de Matemáticas", "Actividades de refuerzo de Inglés", "Ampliación: Taller T.I.C.", "Ampliación: Taller de Teatro");
	$a1 = array("Actividades de refuerzo de Lengua Castellana", "Actividades de refuerzo de Matemáticas", "Actividades de refuerzo de Inglés", "Ampliación: Taller T.I.C.", "Ampliación: Taller de Teatro", "Ampliación: Taller de Lenguas Extranjeras");
	$a2 = array("Actividades de refuerzo de Lengua Castellana ", "Actividades de refuerzo de Matemáticas", "Actividades de refuerzo de Inglés", "Ampliación: Taller T.I.C. II", "Ampliación: Taller de Teatro II");


	$sql = "select matriculas.id, matriculas.apellidos, matriculas.nombre, matriculas.curso, letra_grupo, colegio, bilinguismo, diversificacion, act1, confirmado, grupo_actual, observaciones, exencion, religion, itinerario, matematicas4, promociona, claveal, ruta_este, ruta_oeste, revisado, foto, enfermedad, divorcio, matematicas3 ";

	if ($curso=="3ESO"){$num_opt = "7";}else{$num_opt = "4";}
	for ($i=1;$i<$num_opt+1;$i++)
	{
		$sql.=", optativa$i";
	}
	$sql.=" from matriculas where ". $extra ." order by curso, ". $orden ." grupo_actual, apellidos, nombre ";
	//echo $sql;
	$cons = mysqli_query($db_con, $sql);
	if(mysqli_num_rows($cons) < 1){
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hay alumnos que se ajusten a ese criterio. Prueba de nuevo.
</div></div><br />' ;
	}
	else{
		if ($curso) {
			?>
<h3 align=center><? if($_POST['grupo_actua']){ 
	echo $curso." ";
	foreach ($_POST['grupo_actua'] as $grup_actua){
		echo $grup_actua." ";
	}
} else{ echo $curso;}?></h3>
<br />
<form action="consultas.php?curso=<? echo $curso;?>&consulta=1"
	name="form1" method="post">
<table class="table table-striped table-condensed" align="center"
	style="width: auto">
	<thead>
		<th colspan="2"></th>
		<th>Nombre</th>
		<th>Curso</th>
		<th>Gr1</th>
		<th>Gr2</th>
		<?php
		if ($curso=="1ESO") {
			echo '<th>Colegio</th>';
		}
		echo '<th>Rel.</th>';
		echo '<th>Transprt</th>';
		echo '<th>Bil.</th>';
		if ($n_curso<3) {
			echo '<th>Ex.</th>';
		}
		if ($n_curso>2) {
			echo '<th>Div.</th>';
		}
		if ($n_curso=="4") {
			echo '<th>Itin.</th>';
		}
		if ($n_curso=="3") {
			echo '<th>Mat.</th>';
		}
		for ($i=1;$i<$num_opt+1;$i++)
		{
			echo "<th>Opt".$i."</th>";
		}
		if ($n_curso<3) {
			echo '<th>Act.</th>';
		}
		?>

		<th class="hdden-print">Opciones</th>
		<?php
		if ($n_curso>1) {
			echo '<th class="hdden-print">SI |PIL |NO </th>';
		}
//		echo '<th class="hdden-print">Rev.</th>';
		echo '<th class="hdden-print">Copia</th>';
		echo '<th class="hdden-print">Borrar</th>';
		?>
		<th class="hdden-print">Conv.</th>
		<th class="hdden-print">Otros</th>
	</thead>
	<tbody>
	<?php
	while($consul = mysqli_fetch_array($cons)){
		$backup="";
		$respaldo='1';
		$id = $consul[0];
		$apellidos = $consul[1];
		$nombre= $consul[2];
		$letra_grupo = $consul[4];
		$colegio=str_ireplace("C.E.I.P.","",$consul[5]);
		$bilinguismo = $consul[6];
		$diversificacion = $consul[7];
		$act1 = $consul[8];
		$confirmado = $consul[9];
		$grupo_actual = $consul[10];
		$observaciones = $consul[11];
		$exencion = $consul[12];
		$religion = $consul[13];
		$itinerario = $consul[14];
		$matematicas4 = $consul[15];
		$promociona = $consul[16];
		$claveal = $consul[17];
		$ruta_este = $consul[18];
		$ruta_oeste = $consul[19];
		$revisado = $consul[20];
		$foto = $consul[21];
		$enf = $consul[22];
		$divorcio = $consul[23];
		$matematicas3 = $consul[24];
		$back = mysqli_query($db_con, "select id from matriculas_backup where id = '$id'");
		if (mysqli_num_rows($back)>0) {
			$respaldo = '1';
			$backup="<a href='consultas.php?copia=1&id=$id&curso=$curso&consulta=1'><i class='fa fa-refresh' data-bs='tooltip' title='Restaurar datos originales de la matrícula del alumno '> </i></a>";
		}

		if ($curso=='4ESO') {
			$back4 = mysqli_query($db_con, "select id from matriculas_bach_backup where claveal = '$claveal'");
			if (mysqli_num_rows($back4)>0) {
				$id4 = mysqli_fetch_array($back4);
				$respaldo = '1';
				$backup="<a href='consultas_bach.php?copia=1&id=$id4[0]&id_4=$id&curso=$curso&consulta=1'><i class='fa fa-refresh text-warning' rel='Tooltip' title='Restaurar datos originales de la matrícula de Bachillerato'> </i> <span class=text-warning>(B)</span></a>";
			}
		}

		//echo $ruta_este;
		for ($i=1;$i<$num_opt+1;$i++)
		{
			${optativa.$i} = $consul[$i+24];
		}

		// Problemas de Convivencia
		$n_fechorias="";
		$fechorias = mysqli_query($db_con, "select * from Fechoria where claveal='".$claveal."'");
		$n_fechorias = mysqli_num_rows($fechorias);
		//$fechori="16 --> 1000";
		if (!(isset($fechori)) or $fechori=="") {
			$fechori1="0";
			$fechori2="1000";
		}
		else{
			if ($fechori=="Sin problemas") {
				$fechori1="0";
				$fechori2="1";
			}
			else{
				$tr_fech = explode(" --> ",$fechori);
				$fechori1=$tr_fech[0];
				$fechori2=$tr_fech[1];
			}
		}
		if ($n_fechorias >= $fechori1 and $n_fechorias < $fechori2) {
			$num_al+=1;
			echo '<tr>

	<td><input value="1" name="confirmado-'. $id .'" type="checkbox"';
			if ($confirmado=="1") { echo " checked";}
			echo ' onClick="submit()"/></td><td>'.$num_al.'</td>
	<td><a href="matriculas.php?id='. $id .'" target="_blank">'.$apellidos.', '.$nombre.'</a></td>
	<td>'.$curso.'</td>
	<td>'.$letra_grupo.'</td>
	<td><input name="grupo_actual-'. $id .'" type="text" class="form-control input-sm" style="width:35px" value="'. $grupo_actual .'" /></td>';
			if ($curso=="1ESO") {
				echo '<td>';
				$clg = mysqli_query($db_con,"select * from transito_datos where claveal = '$claveal'");
				if (mysqli_num_rows($clg)>0) {	echo "<a href='informe_transito.php?claveal=$claveal' target='_blank' data-bs='tooltip' title='Alumno de Primaria con Informe de Tránsito' class='text-info'>$colegio</a>";}
				echo '</td>';
			}
			if (strstr($religion,"Cat")==TRUE) {
				$color_rel = " style='background-color:#FFFF99;'";
			}
			if (strstr($religion,"Valores")==TRUE) {
				$color_rel = " style='background-color:#cdecab'";
			}
			if (strstr($religion,"Rel")==TRUE) { $text_rel = substr($religion,9,3);}else{ $text_rel = substr($religion,0,3);}
			echo '<td '.$color_rel.'>'.$text_rel.'</td>';
			$trans = "";
			if($ruta_este){$trans = substr($ruta_este, 0, 10).".";}
			if($ruta_oeste){$trans = substr($ruta_oeste, 0, 10).".";}
			echo '<td> '.$trans.'</td>';

			echo '<td><input name="bilinguismo-'. $id .'" type="checkbox" value="Si"';
			if($bilinguismo=="Si"){echo " checked";}
			echo ' /></td>';

			if ($n_curso<3) {
			 if ($exencion=="0") {$exencion="";}
			 echo '<td><input name="exencion-'. $id .'" type="checkbox" value="1"';
			 if($exencion=="1"){echo " checked";}
			 echo ' /></td>';
			}

			if ($n_curso>2) {
				echo '<td><input name="diversificacion-'. $id .'" type="checkbox" value="1"';
				if($diversificacion=="1"){echo " checked";}
				echo ' /></td>';
			}
			if ($n_curso=="4") {
				if ($itinerario == '0'){$itinerario="";}
				if ($itinerario == '3') {$it = $itinerario."".$matematicas4."";}else{$it=$itinerario;}
				echo '<td>'.$it.'</td>';
			}
			if ($n_curso=="3") {
				echo '<td>'.$matematicas3.'</td>';
			}
			for ($i=1;$i<$num_opt+1;$i++)
			{
				if (${optativa.$i} == '0') {${optativa.$i}="";}
				echo "<td align='center'";
				if(${optativa.$i}=='1'){echo " style='background-color:#efdefd;'";}
				echo ">".${optativa.$i}."</td>";
			}

			if ($n_curso<3) {
				if ($act1==0) {
					$act1="";
				}
				echo '<td><input name="act1-'. $id .'" type="text" class="form-control input-sm" style="width:35px" value="'. $act1 .'" /></td>';
			}
			echo '<td class="hdden-print">';
			if ($curso == "1ESO") {$alma="alma_primaria";}else{$alma="alma";}
			$contr = mysqli_query($db_con, "select matriculas.apellidos, $alma.apellidos, matriculas.nombre, $alma.nombre, matriculas.domicilio, $alma.domicilio, matriculas.dni, $alma.dni, matriculas.padre, concat(primerapellidotutor,' ',segundoapellidotutor,', ',nombretutor), matriculas.dnitutor, $alma.dnitutor, matriculas.telefono1, $alma.telefono, matriculas.telefono2, $alma.telefonourgencia from matriculas, $alma where $alma.claveal=matriculas.claveal and id = '$id'");
			$control = mysqli_fetch_array($contr);

			for ($i = 0; $i < 16; $i++) {
				if ($i%2) {
					if ($i=="5" and strstr($control[$i], $control[$i-1])==TRUE) {}
					else{
						$text_contr="";
						if ($control[$i]==$control[$i-1]) {$icon="";}else{
							if ($control[$i-1]<>0) {
								$icon="fa fa-info-circle";
								$text_contr.= $control[$i]." --> ".$control[$i-1]."; ";
							}
						}
					}
				}
				//echo "$control[$i] --> ";
			}
			echo "<i class='$icon' data-bs='tooltip' title='$text_contr'> </i>&nbsp;&nbsp;";

			if ($observaciones) { echo "<i class='fa fa-bookmark' data-bs='tooltip' title='$observaciones' > </i>";}
			echo '</td>';

			// Promocionan o no
			if ($n_curso>1) {
				echo "<td style='background-color:#efeefd' class='hdden-print' nowrap>";
				if (!($promociona =='') and !($promociona == '0')) {
					for ($i=1;$i<4;$i++){
						echo '<input type="radio" name = "promociona-'. $id .'" value="'.$i.'"';
						if($promociona == $i){echo " checked";}
						echo " />&nbsp;&nbsp;";
					}
				}
				else{
					$val_notas="";
					$not = mysqli_query($db_con, "select notas3, notas4 from notas, alma where alma.claveal1=notas.claveal and alma.claveal='".$claveal."'");

					$nota = mysqli_fetch_array($not);
					$tr_not = explode(";", $nota[0]);
					
					if (date('m')>'05' and date('m')<'09'){
					foreach ($tr_not as $val_asig) {
						$tr_notas = explode(":", $val_asig);
						foreach ($tr_notas as $key_nota=>$val_nota) {
							if($key_nota == "1" and ($val_nota<'347' and $val_nota !=="339" and $val_nota !=="") or $val_nota == '397' ){
								$val_notas=$val_notas+1;
							}
						}
					}
					}
					
					elseif (date('m')=='09'){
					$tr_not2 = explode(";", $nota[1]);
					foreach ($tr_not2 as $val_asig) {
						$tr_notas = explode(":", $val_asig);
						foreach ($tr_notas as $key_nota=>$val_nota) {
							if($key_nota == "1" and ($val_nota<'347' and $val_nota !=="339" and $val_nota !=="") or $val_nota == '397' ){
								$val_notas=$val_notas+1;
							}
						}
					}
					}
					// Junio


					if (date('m')>'05' and date('m')<'09'){
						//echo " ".$val_notas;
						if ($val_notas<3) {$promociona="1";}
						echo "<span class='text-muted'> $val_notas&nbsp;</span>";
						for ($i=1;$i<4;$i++){
							echo '<input type="radio" name = "promociona-'. $id .'" value="'.$i.'" ';
							if($promociona == $i){echo " checked";}
							echo " />&nbsp;&nbsp;";
						}
					}
					// Septiembre
					elseif (date('m')=='09'){
						if ($val_notas>2) {$promociona="3";}else{$promociona="1";}
						echo "<span class='text-muted'> $val_notas&nbsp;</span>";
						for ($i=1;$i<4;$i++){
							echo '<input type="radio" name = "promociona-'. $id .'" value="'.$i.'" ';
							if($promociona == $i){echo " checked";}
							echo " />&nbsp;&nbsp;";
						}
					}
				}
				echo "</td>";
			}
//			echo '<td class="hdden-print"><input name="revisado-'. $id .'" type="checkbox" value="1"';
//			if($revisado=="1"){echo " checked";}
//			echo ' /></td>';
			echo "<td class='hdden-print'>";
			if ($respaldo=='1') {
				echo $backup;
			}
			echo "</td>";
			echo "<td class='hdden-print'>";
			echo "<a href='consultas.php?borrar=1&id=$id&curso=$curso&consulta=1'><i class='fa fa-trash-o' data-bs='tooltip' title='Eliminar alumno de la tabla' onClick='return confirmacion();'> </i></a>";
			echo "</td>";

			echo "<td class='hdden-print'>";
			$disr = mysqli_query($db_con,"select * from transito_datos where claveal = '$claveal' and (tipo='disruptivo' and dato='2')");
			if (mysqli_num_rows($disr)>0) {	echo "<a href='informe_transito.php?claveal=$claveal' target='_blank'><span class='label label-info' data-bs='tooltip' title='Alumno disruptivo de Primaria con Problemas de Convivencia'>Disrup.</span></a>";}
			$disr1 = mysqli_query($db_con,"select * from transito_datos where claveal = '$claveal' and (tipo='integra' and dato='4')");
			if (mysqli_num_rows($disr1)>0) {echo "<br><a href='informe_transito.php?claveal=$claveal' target='_blank'><span class='label label-warning' data-bs='tooltip' title='Viene de Primaria con Problemas de Integración en el Aula'>Integra</span></a>";}
			// Problemas de Convivencia
			if($n_fechorias >= 15){ echo "<a href='../fechorias/fechorias.php?claveal=$claveal&submit1=1' target='blank'><span class='badge badge-important'>$n_fechorias</span></a>";}
			elseif($n_fechorias > 4 and $n_fechorias < 15){ echo "<a href='../fechorias/fechorias.php?claveal=$claveal&submit1=1' target='blank'><span class='badge badge-warning'>$n_fechorias</span></a>";}
			elseif($n_fechorias < 5 and $n_fechorias > 0){ echo "<a href='../fechorias/fechorias.php?claveal=$claveal&submit1=1' target='blank'><span class='badge badge-info'>$n_fechorias</span></a>";}
			// Fin de Convivencia.
			echo "</td>";
			echo "<td class='hdden-print' nowrap>";
			if($foto == 1){ echo '<span class="fa fa-camera" style="color: green;" data-bs="tooltip" title="Es posible publicar su foto."></span>&nbsp;';}
			if(!empty($enf)){ echo '<span class="fa fa-medkit" style="color: red;" data-bs="tooltip" title="'.$enf.'"></span>&nbsp;';}
			if(!empty($divorcio)){
				if ($divorcio=="Guardia y Custodia compartida por Madre y Padre") {echo '<span class="fa fa-group" style="color: orange;" data-bs="tooltip" title="'.$divorcio.'"></span>';}
				elseif($divorcio=="Guardia y Custodia de la Madre") {echo '<span class="fa fa-female" style="color: orange;" data-bs="tooltip" title="'.$divorcio.'"></span>';}
				elseif($divorcio=="Guardia y Custodia del Padre") {echo '<span class="fa fa-male" style="color: orange;" data-bs="tooltip" title="'.$divorcio.'"></span>';}
			}
			echo "</td>";
			echo '
	</tr>';	
		}
	}
	echo "</table>";
	echo "<div align='center'>
<input type='hidden' name='extra' value='$extra' />";

	// Control del envío de datos

	echo "<input type='submit' name='enviar' value='Enviar datos' class='btn btn-primary hdden-print' onclick='confirmacion2()' /><br>";

	echo "<br><input type='submit' name='imprimir' value='Imprimir'  class='btn btn-success hdden-print' />&nbsp;&nbsp;<input type='submit' name='caratulas' value='Imprimir Carátulas' class='btn btn-success hdden-print' />&nbsp;&nbsp;<input type='submit' name='cambios' value='Ver cambios en datos' class='btn btn-warning hdden-print' />&nbsp;&nbsp;<input type='submit' name='sin_matricula' value='Alumnos sin matricular' class='btn btn-danger hdden-print' />";

	if(count($grupo_actua)=='1'){
		echo "<input type='hidden' name='grupo_actual' value='$grupo_actua' />&nbsp;&nbsp;<input type='submit' name='listados' value='Listado en PDF' class='btn btn-inverse hdden-print' />";} else{ echo "&nbsp;&nbsp;<input type='submit' name='listado_total' value='Listado PDF total' class='btn btn-inverse hdden-print' />
		&nbsp;&nbsp;<input type='submit' name='listado_simple' value='Listado Simple' class='btn btn-inverse hdden-print' />";
		}
		echo "</div></form>";
		?>
		<?php
		if ($curso) {

			if ($curso=="1ESO" OR $curso=="2ESO"){
				$exen = mysqli_query($db_con, "select exencion from matriculas where $extra and exencion ='1'");
				$num_exen = mysqli_num_rows($exen);

				if ($curso=="1ESO" or $curso=="2ESO"){$num_acti = "7";}else{$num_acti = "4";}
				for ($i=1;$i<$num_acti+1;$i++){
					${acti.$i} = mysqli_query($db_con, "select act1 from matriculas where $extra and act1 = '$i'");
					${num_act.$i} = mysqli_num_rows(${acti.$i});
				}
			}
			$rel = mysqli_query($db_con, "select religion from matriculas where $extra and religion like '%Católica%'");

			$num_rel = mysqli_num_rows($rel);
			//echo $num_rel;
			if ($curso=="3ESO"){$num_opta = "7";}else{$num_opta = "4";}
			for ($i=1;$i<$num_opta+1;$i++){
				${opta.$i} = mysqli_query($db_con, "select optativa$i from matriculas where $extra and optativa$i = '1'");
				${num_opta.$i} = mysqli_num_rows(${opta.$i});
			}

			if ($curso=="3ESO" OR $curso=="4ESO"){
				$diver = mysqli_query($db_con, "select diversificacion from matriculas where $extra and diversificacion = '1'");
				$num_diver = mysqli_num_rows($diver);
			}
			$promo = mysqli_query($db_con, "select promociona from matriculas where $extra and promociona = '1'");
			$num_promo = mysqli_num_rows($promo);

			$pil = mysqli_query($db_con, "select promociona from matriculas where $extra and promociona = '2'");
			$num_pil = mysqli_num_rows($pil);

			$an_bd = substr($curso_actual,0,4);
			$repit = mysqli_query($db_con, "select * from matriculas_bach, ".$db.$an_bd.".alma where ".$db.$an_bd.".alma.claveal = matriculas_bach.claveal and matriculas_bach.curso = '$curso' and ".$db.$an_bd.".alma.unidad like '$n_curso%'");
			$num_repit = mysqli_num_rows($repit);
			?>
		<br />
		<table class="table table-striped table-bordered" align="center"
			style="width: auto">
			<tr>
			<?php
			echo "<th>Religión</th>";
			if ($curso=="1ESO" OR $curso=="2ESO"){
				echo "<th>Exención</th>";
			}
			if ($curso=="3ESO" OR $curso=="4ESO"){
				echo "<th>Diversificación</th>";
			}
			if ($curso=="3ESO"){$num_opta = "7";}else{$num_opta = "4";}
			for ($i=1;$i<$num_opta+1;$i++){
				echo "<th>Optativa$i</th>";
			}
			if ($curso=="1ESO"){
				$num_acti = "6";
				for ($i=1;$i<$num_acti+1;$i++){
					echo "<th>Act$i</th>";
				}
			}
			if ($curso=="2ESO"){
				$num_acti = "5";
				for ($i=1;$i<$num_acti+1;$i++){
					echo "<th>Act$i</th>";
				}
			}

			echo "<th>Promociona</th>";
			echo "<th>PIL</th>";
			echo "<th>Repite</th>";
			?>
			</tr>
			<tr>
			<?php
			echo "<td>$num_rel</td>";
			if ($curso=="1ESO" OR $curso=="2ESO"){
				echo "<td>$num_exen</td>";
			}
			if ($curso=="3ESO" OR $curso=="4ESO"){
				echo "<td>$num_diver</td>";
			}
			if ($curso=="3ESO"){$num_opta = "7";}else{$num_opta = "4";}
			for ($i=1;$i<$num_opta+1;$i++){
				echo "<td>${num_opta.$i}</td>";
		}
		if ($curso=="1ESO" OR $curso=="2ESO"){
			if ($curso=="1ESO"){$num_acti = "6";}else{$num_acti = "6";}
			for ($i=1;$i<$num_acti+1;$i++){
				echo "<td>${num_act.$i}</td>";
		}
		}
		echo "<td>$num_promo</td>";
		echo "<td>$num_pil</td>";
		echo "<td>$num_repit</td>";
		?>
			</tr>
		</table>
		<?php
	}
	?>

		<br />
		<table class="table table-striped table-bordered hdden-print"
			align="center" style="width: auto">
			<tr>
				<td><?php
				if ($curso=="4ESO") {

					for ($i=1;$i<$num_opt;$i++){
						$nombre_optativa = "";
						$nom_opt.= "<span style='font-weight:bold;color:#9d261d;'>Itinerario $i: </span>";
						foreach (${opt4.$i} as $nombre_opt => $valor){

							$nombre_optativa=$nombre_optativa+1;
							$nom_opt.="<span style='color:#08c;'>Opt".$nombre_optativa."</span> = ".$valor."; ";
						}
						//echo substr($nom_opt,0,-2);
						$nom_opt.= "<br>";
					}

				}
				else{
					foreach (${opt.$n_curso} as $nombre_opt => $valor){
						$nombre_optativa=$nombre_opt+1;
						$nom_opt.="<span style='color:#08c;'>Opt".$nombre_optativa."</span> = ".$valor."; ";
					}
				}
				echo substr($nom_opt,0,-2);
				?></td>
			</tr>
		</table>
		<?php
		if ($n_curso<3){
			echo '<table class="table table-striped table-bordered hdden-print" align="center" style="width:auto"><tr>
<td>';
			foreach (${a.$n_curso} as $nombre_a => $valora){
				$nombre_act=$nombre_a+1;
				$nom_a.="<span style='color:#08c;'>Act ".$nombre_act."</span> = ".$valora."; ";
			}
			echo substr($nom_a,0,-2).'</td></tr></table>';
		}
}
	}
	}
	?>
		</div>
		<? include("../../pie.php"); ?>
		<script language="javascript">
		 if (document.form2.curso.value=="1ESO"){ 
			 document.form2.itinerari.disabled = true; 
			 document.form2.matematica4.disabled = true;
			 document.form2.diversificacio.disabled = true;
			 document.form2.promocion.disabled = true;
			 document.form2.actividade.disabled = false;
			 document.form2.exencio.disabled = false;
			}
		 if (document.form2.curso.value=="2ESO"){ 
			 document.form2.itinerari.disabled = true; 
			 document.form2.matematica4.disabled = true;
			 document.form2.diversificacio.disabled = true;
			 document.form2.promocion.disabled = false;
			 document.form2.actividade.disabled = false;
			 document.form2.exencio.disabled = false;
			}
		 if (document.form2.curso.value=="3ESO"){ 
			 document.form2.itinerari.disabled = true; 
			 document.form2.matematica4.disabled = false;
			 document.form2.actividade.disabled = true;
			 document.form2.exencio.disabled = true;
			 document.form2.diversificacio.disabled = false;
			 document.form2.promocion.disabled = false;
			}
		 if (document.form2.curso.value=="4ESO"){ 
			 document.form2.actividade.disabled = true;
			 document.form2.exencio.disabled = true;
			 document.form2.itinerari.disabled = false; 
			 document.form2.matematica4.disabled = false;
			 document.form2.diversificacio.disabled = false;
			 document.form2.promocion.disabled = false;  
			}
  </script>
  <?php
  // Control del envío de datos

  if (($mes_submit>5 and $mes_submit<9)) {
  	?>
		<script type="text/javascript">
function confirmacion2() {
	var answer = confirm("ATENCIÓN\n Estás a punto de procesar los datos de todos los alumnos de este Nivel tomando como referencia las calificaciones de la EVALUACIÖN ORDINARIA. Los alumnos que cumplen con los criterios de Promoción propios de su Nivel han sido marcados en la columna <<SI/NO/PIL>>.\n ES MUY IMPORTANTE que marques con un SÍ aquellos alumnos que promocionan por imperativo legal (PIL) o por decisión del Equipo Educativo a pesar de que no cumplen con los criterios habituales de promoción.\n El resto de los alumnos serán procesados tras la Evaluación Extraordinaria de Septiembre.\n Si estás seguro de lo que haces pulsa Aceptar; de lo contrario pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?php
  }
  elseif ($mes_submit=="9") {
  	?>
		<script type="text/javascript">
function confirmacion2() {
	var answer = confirm("ATENCIÓN\n Estás a punto de procesar los datos de todos los alumnos de este Nivel tomando como referencia las calificaciones de la EVALUACIÖN EXTRAORDINARIA. Todos los alumnos han sido marcados en la columna <<SI/NO/PIL>> de acuerdo a los criterios regulares de promoción.\n ES MUY IMPORTANTE por lo tanto que marques con un SÍ aquellos alumnos que promocionan por imperativo legal (PIL) o por decisión del Equipo Educativo a pesar de que no cumplen con los criterios regulares de promoción.\n Por motivos de seguridad, se va acrear una copia de respaldo de los datos originales de la matrícula de aquellos alumnos que NO promocionan. Estos datos pueden ser recuperados en todo momento pulsando el botón <<Restaurar>>.\n Si estás seguro de lo que haces pulsa Aceptar; de lo contrario pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
		<?php
  	  }
  
  ?>

		</body>
		</html>