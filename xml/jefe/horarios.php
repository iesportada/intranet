<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
?>
<div class="container">
<div class="page-header">
<h2>Administración <small>Importación del horario con archivo DEL de Horw</small></h2>
</div>
<div class="row"><?php

$contents = file($_FILES['archivo']['tmp_name']);
$n_lineas = count($contents);

if ($n_lineas>10) {

// Backup
mysqli_query($db_con,"truncate table horw_seg");
mysqli_query($db_con,"insert into horw_seg select * from horw");
mysqli_query($db_con,"truncate table horw_seg_faltas");
mysqli_query($db_con,"insert into horw_seg_faltas select * from horw_faltas");
mysqli_query($db_con,"truncate table horw");

}
else{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>
El archivo de Horw que intentas descargar está <strong>VACÍO</strong>. Inténtalo de nuevo con el archivo de datos exportado desde HORWIN.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><br />';
		exit();	
}
foreach($contents as $linea){
	$campo = explode('","',$linea);
	$campo = str_replace('"','',$campo);
	$num_col = count($campo);
	
	if ($num_col<>11) {
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>Atención:</legend>
El archivo de Horw que estás intentando exportar contiene <strong>'.$num_col.' columnas</strong> de datos y debe contener <strong>11 columnas</strong>. Asegúrate de que el archivo de Horw sigue las instrucciones de la imagen, y vuelve a intentarlo.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div><br />';
		exit();
	}
			
	$sql="INSERT INTO horw (dia,hora,a_asig,asig,c_asig,prof,no_prof,c_prof,a_aula,n_aula,a_grupo) ";
	$sql.=" VALUES ( ";		
	foreach ($campo as $indice=>$clave){
		
		if ($indice<11) {
			$sql.="'".trim($clave)."', ";
		}
	}
	$sql=substr($sql,0,strlen($sql)-2);
	$sql.=" )";

	mysqli_query($db_con,$sql) or die ('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se han podido insertar los datos en la tabla <strong>Horw</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');
}

// Eliminamos el Recreo como 4Âª Hora.
$recreo = "update horw set hora = 'R' WHERE hora ='4'";
mysqli_query($db_con,$recreo);
$hora4 = "UPDATE  horw SET  hora =  '4' WHERE  hora = '5'";
mysqli_query($db_con,$hora4);
$hora5 = "UPDATE  horw SET  hora =  '5' WHERE  hora = '6'";
mysqli_query($db_con,$hora5);
$hora6 = "UPDATE  horw SET  hora =  '6' WHERE  hora = '7'";
mysqli_query($db_con,$hora6);
mysqli_query($db_con,"OPTIMIZE TABLE  `horw`");

// Quitamos las S del codigo de las Actividades
$s_cod = mysqli_query($db_con,"select distinct c_asig from horw where c_asig like 'S%'");
while($s_asigna = mysqli_fetch_array($s_cod)){
	$s_l="";
	$trozos = explode(" ",$s_asigna[0]);
	$s_l = substr($trozos[0],1,strlen($trozos[0]));
	mysqli_query($db_con,"update horw set c_asig = '$s_l', asig = (select nomactividad from actividades_seneca where idactividad = '$s_l') where c_asig = '$s_asigna[0]'");
}

// Detectamos asignaturas sin código
$sin_codigo="";
$sin_cd = mysqli_query($db_con,"select distinct a_asig, asig from horw where c_asig = '' or c_asig is null");
if (mysqli_num_rows($sin_cd)>0) {

	echo '<div align="center"><div class="alert alert-warning alert-block fade in" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha registrado un código para las asignaturas que aparecen abajo. Esta situación producirá problemas en módulos fundamentales de la Intranet. Asigna el código correcto y actualiza el horario cuanto antes, a menos que sepas lo que haces.
<br><br><ul>';

	while($sin_codi = mysqli_fetch_array($sin_cd)){
		echo "<li>$sin_codi[0] => $sin_codi[1]</li>";
	}
	echo '</ul></div></div>';
}

// Cambiamos el nombre de los profesores de Horw para ajustarlos a Séneca.
$hor0 = mysqli_query($db_con, "select distinct c_prof from horw order by prof");
while($hor_profe0 = mysqli_fetch_array($hor0)){
	
	$nom_prof = mysqli_query($db_con, "select nomprofesor from profesores_seneca where idprofesor = '$hor_profe0[0]'");
	$nom_profe = mysqli_fetch_row($nom_prof);
	$nombre_profesor = $nom_profe[0];
	mysqli_query($db_con,"update horw set prof = '$nom_profe[0]' where c_prof = '$hor_profe0[0]'");
}

// Cambiamos los numeros de Horw para dejarlos en orden alfabético.
$hor = mysqli_query($db_con, "select distinct prof from horw order by prof");
while($hor_profe = mysqli_fetch_array($hor)){
	$np+=1;
	$sql = "update horw set no_prof='$np' where prof = '$hor_profe[0]'";
	$sql1 = mysqli_query($db_con, $sql);
}

// Limpiez de codigos
$h1 = mysqli_query($db_con, "select id, c_asig, a_grupo, asig, unidades.idcurso, nomcurso from horw, unidades, cursos where a_grupo=nomunidad and unidades.idcurso=cursos.idcurso and a_grupo not like ''");
while ($h2 = mysqli_fetch_array($h1)) {
	
	$id_horw = $h2[0];
	$curso = $h2[5];
	$curso_corto = substr($curso,0,10);
	$cod = $h2[1];
	$unidad = $h2[2];
	$nombre_asignatura = $h2[3];

	// Primera pasada
$asig2 = mysqli_query($db_con, "select codigo, nombre, abrev from asignaturas where curso = '$curso' and curso not like '' and (codigo not like '2' and codigo = '$cod') and abrev not like '%\_%'");
	if (mysqli_num_rows($asig2)>0) {
		$asignatur2 = mysqli_fetch_array($asig2);
		$asignatura2=$asignatur2[0];
		$nombre_asig2=$asignatur2[1];
		$abrev_asig2=$asignatur2[2];
		
			$codasi2 = $asignatura2;
			mysqli_query($db_con, "update horw set c_asig = '$codasi2', asig='$nombre_asig2', a_asig = '$abrev_asig2' where id = '$id_horw'");
		
	}
	
		// Problema con materias comunes en Bachillerato
		if ($cod!=="") {			
	$bach0 = mysqli_query($db_con,"select distinct curso from asignaturas where codigo = '$cod' and abrev not like '%\_%' and curso like '%bachill%'");
	$bc = mysqli_fetch_array($bach0);
	if ($bc[0]!==$curso) {
		$as0 = mysqli_query($db_con, "select codigo, nombre, abrev, curso from asignaturas where codigo !='$cod' and abrev=(select distinct abrev from asignaturas where codigo = '$cod' and abrev not like '%\_%') and nombre=(select distinct nombre from asignaturas where codigo = '$cod' and abrev not like '%\_%') and curso like '$curso_corto%' and curso like '%bach%' and abrev not like '%\_%'");
		
		if (mysqli_num_rows($as0)>0) {
			$bc1 = mysqli_fetch_array($as0);
			mysqli_query($db_con,"update horw set c_asig = '$bc1[0]', asig='$bc1[1]', a_asig = '$bc1[2]' where id = '$id_horw'");
			}	
		}	
	}
	
		
	// Segunda pasada
$asig = mysqli_query($db_con, "select codigo from asignaturas where curso = '$curso' and curso not like '' and nombre = '$nombre_asignatura' and codigo not like '2' and abrev not like '%\_%'");
	if (mysqli_num_rows($asig)>0) {
		$asignatur = mysqli_fetch_array($asig);
		$asignatura=$asignatur[0];
		if (!($asignatura==$cod)) {
			$codasi = $asignatura;
			mysqli_query($db_con, "update horw set c_asig = '$codasi' where id = '$id_horw'");
		}
		else{
			$codasi="";
		}
	}
}

// Depuramos nombres y abreviaturas de asignaturas
$pro =mysqli_query($db_con,"select distinct asig, a_asig, c_asig from horw where a_grupo in (select nomunidad from unidades) and c_asig not like '2' order by prof");
	while ($prf =mysqli_fetch_array($pro)) {
		$asig = $prf[0];
		$a_asig = $prf[1];
		$c_asig = $prf[2];
		$niv =mysqli_query($db_con,"select distinct nombre, abrev from asignaturas where codigo = '$c_asig' and abrev not like '%\_%'");
		if (mysqli_num_rows($niv)>0) {
			$nive =mysqli_fetch_array($niv);
			mysqli_query($db_con,"update horw set asig = '$nive[0]', a_asig = '$nive[1]' where c_asig = '$c_asig'");
		}
	}
	
// Recorremos la tabla Profesores bajada de Séneca
$tabla_profes =mysqli_query($db_con,"select * from profesores");
if (mysqli_num_rows($tabla_profes) > 0) {
	$hay_profes=1;
}
else{
	$nohay_profes=1;
	$pro =mysqli_query($db_con,"select distinct asig, a_grupo, prof from horw where a_grupo in (select nomunidad from unidades) and c_asig not like '2' order by prof");
	while ($prf =mysqli_fetch_array($pro)) {
		$materia = $prf[0];
		$grupo = $prf[1];
		$profesor = $prf[2];
		$niv =mysqli_query($db_con,"select distinct curso from alma where unidad = '$grupo'");
		$nive =mysqli_fetch_array($niv);
		$nivel = $nive[0];

		mysqli_query($db_con,"INSERT INTO  profesores (
`nivel` ,
`materia` ,
`grupo` ,
`profesor`
) VALUES ('$nivel', '$materia', '$grupo', '$profesor')");
	}
}

mysqli_query($db_con, "OPTIMIZE TABLE `horw`");

// Actualizamos nombre de las materias / actividades para hacerlas más intuitivas
mysqli_query($db_con, "update horw set a_asig = 'TCA' where c_asig = '2'");
mysqli_query($db_con, "update asignaturas set abrev = 'TCA' where codigo = '2'");
mysqli_query($db_con, "update horw set a_asig = 'TCF' where c_asig = '279'");
mysqli_query($db_con, "update horw set a_asig = 'TAP' where c_asig = '117'");
mysqli_query($db_con, "update horw set a_asig = 'GU' where c_asig = '25'");
mysqli_query($db_con, "update horw set a_asig = 'GUREC' where c_asig = '353'");
mysqli_query($db_con, "update horw set a_asig = 'GUBIB' where c_asig = '26'");

// Metemos a los profes en la tabla profesores hasta que el horario se haya exportado a Séneca y consigamos los datos reales de los mismos


// Recorremos la tabla Profesores bajada de Séneca
if ($nohay_profes==1) {
        mysqli_query($db_con,"drop table profesores_seg");
        mysqli_query($db_con,"create table profesores_seg select * from profesores");
	mysqli_query($db_con,"truncate table profesores");
	$pro =mysqli_query($db_con,"select distinct asig, a_grupo, prof from horw where (a_grupo in (select nomunidad from unidades) or a_grupo in (select distinct a_grupo from horw where c_asig = '135785' or c_asig = '25226')) and c_asig not like '2' order by prof");
	while ($prf =mysqli_fetch_array($pro)) {
		$materia = $prf[0];
		$grupo = $prf[1];
		$profesor = $prf[2];
		$tr_g = explode("-",$grupo);
		if(strlen($tr_g[1])>1){
		$grupo = substr($grupo,0,-1);
		}
		$niv =mysqli_query($db_con,"select distinct curso from alma where unidad = '$grupo'");
		$nive =mysqli_fetch_array($niv);
		$nivel = $nive[0];

		mysqli_query($db_con,"INSERT INTO  profesores (
`nivel` ,
`materia` ,
`grupo` ,
`profesor`
) VALUES ('$nivel', '$materia', '$grupo', '$profesor')");
	}
}

// Horw para Faltas
mysqli_query($db_con, "drop table horw_faltas");
mysqli_query($db_con, "create table horw_faltas select * from horw where a_grupo not like '' and c_asig not in (select distinct idactividad from actividades_seneca where idactividad not like '2' and idactividad not like '386' and idactividad not like '21')");

// Cargos varios
$carg = mysqli_query($db_con, "select distinct prof from horw");
while ($cargo = mysqli_fetch_array($carg)) {
	$cargos="";
	$profe_dep = mysqli_query($db_con, "select distinct c_asig from horw where prof = '$cargo[0]'");
	while ($profe_dpt = mysqli_fetch_array($profe_dep)) {
		if ($profe_dpt[0]=="44") {
			$cargos="1";
		}
		if ($profe_dpt[0]=="45") {
			$cargos.="4";
		}
		if ($profe_dpt[0]=="50") {
			$cargos.="8";
		}
		if ($profe_dpt[0]=="376") {
			$cargos.="a";
		}
		if ($profe_dpt[0]=="716" OR $profe_dpt[0]=="717" OR $profe_dpt[0]=="718" OR $profe_dpt[0]=="719") {
			$cargos.="9";
		}
		if ($profe_dpt[0]=="26") {
			$cargos.="c";
		}
		if ($profe_dpt[0]=="2" OR $profe_dpt[0]=="351" OR $profe_dpt[0]=="279") {
			$cargos.="2";
		}
	}
	
	$dep_ya = mysqli_query($db_con,"select * from departamentos where nombre = '$cargo[0]' and cargo = ''");
	if (mysqli_num_rows($dep_ya)>0) {
		mysqli_query($db_con,"update departamentos set cargo='$cargos' where nombre = '$cargo[0]'");
	}

	// Tutores
	$tabla_tut = mysqli_query($db_con, "select * from FTUTORES where tutor = '$cargo[0]'");
	if(mysqli_num_rows($tabla_tut) > 0){}
	else{
		if(strstr($cargos,"2")==TRUE)
		{
			mysqli_query($db_con, "insert into FTUTORES (unidad, tutor) select distinct a_grupo, prof from horw where c_asig like '2' and prof = '$cargo[0]' and prof in (select nombre from departamentos)");
			mysqli_query($db_con,"insert into FTUTORES (unidad, tutor) select distinct prof from horw where c_asig like '117' and prof = '$cargo[0]' and prof not in (select tutor from FTUTORES)");
		}
	}
}
?>
<div class="alert alert-success alert-block fade in">
<button type="button" class="close" data-dismiss="alert">&times;</button>
El Horario ha sido importado correctamente.</div>
</div>
<br />
<div align="center"><a href="../index.php" class="btn btn-primary" />Volver
a Administración</a></div>
<br />
</div>
</div>
	<?php include("../../pie.php"); ?>
	
</body>
</html>
