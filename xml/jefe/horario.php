<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$HorExpSen = $_FILES['HorExpSen']['tmp_name'];

if (isset($_POST['s_seneca']) && isset($_FILES['HorExpSen'])) {
	include("exportarHorariosSeneca.php");
	exit();
}


include("../../menu.php");
?>

<div
	class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Administración <small>Importación del horario / Generar XML de
importación para Séneca</small></h2>
</div>

<?php $result = mysqli_query($db_con, "SELECT * FROM horw LIMIT 1"); ?>
<?php if(mysqli_num_rows($result)): ?>
<div class="alert alert-warning">Ya existe información en la base de
datos. Este proceso actualizará la información de los horarios. Es
recomendable realizar una <a href="copia_db/index.php"
	class="alert-link" class="alert-link">copia de seguridad</a> antes de proceder a la
importación de los datos.</div>
<?php endif; ?> <!-- SCAFFOLDING -->

<div class="row"><!-- COLUMNA IZQUIERDA -->
<div class="col-sm-6">

<div class="well"><?php if (!$HorExpSen) { ?>

<form method="POST" action="horario.php" enctype="multipart/form-data">

<fieldset><legend>Importación del horario / Generar XML</legend>

<div class="form-group"><label for="HorExpSen"><span class="text-info">Importacion_horarios_seneca.xml</span></label>
<input type="file" id="HorExpSen" name="HorExpSen" accept="text/xml"></div>

<br>

<div class="form-group">
<div class="checkbox"><label> <input type="checkbox" id="depurar"
	name="depurar" value="1"> Modo depuración <small>(solo para la opción
Generar XML)</small> </label></div>
</div>


<button type="submit" class="btn btn-primary" name="s_horario">Importar</button>
<button type="submit" class="btn btn-primary" name="s_seneca">Generar
XML</button>
<a href="../index.php" class="btn btn-default">Volver</a></fieldset>

</form>

<?php
}
else {

	$porcentaje=0;
	echo '<p id="progress_job"></p>';
	echo '<div id="progress" class="progress">';
	echo '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"> <span class="sr-only">0% Completado</span></div>';
	echo '</div>';


	$xml = simplexml_load_file($HorExpSen);

	$total += $xml->BLOQUE_DATOS->grupo_datos[1]->attributes()->registros;
	$unid = 100/$total;

	$tabla = 'horw';


	// Borramos y creamos la tabla de los horarios Creamos copia de seguridad de la tabla por si acaso
	mysqli_query($db_con, "drop table horw_seg");
	mysqli_query($db_con, "create table horw_seg select * from horw");
	mysqli_query($db_con, "drop table horw");
	$crea ="CREATE TABLE IF NOT EXISTS `horw` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `dia` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `hora` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `a_asig` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `asig` varchar(128) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `c_asig` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `prof` varchar(50) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `no_prof` tinyint(4) DEFAULT NULL,
					  `c_prof` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `a_aula` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `n_aula` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `a_grupo` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  `clase` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
					  PRIMARY KEY (`id`),
					  KEY `prof` (`prof`),
					  KEY `c_asig` (`c_asig`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci";
	mysqli_query($db_con, $crea) or die ('<div align="center"><div class="alert alert-danger alert-block fade in">
					            <button type="button" class="close" data-dismiss="alert">&times;</button>
								<h5>ATENCIÃ“N:</h5>
					No se ha podido crear la tabla <strong>Horw</strong>. Ponte en contacto con quien pueda resolver el problema.
					</div></div><br />
					<div align="center">
					  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
					</div>');


	$i=0;
	foreach ($xml->BLOQUE_DATOS->grupo_datos[1]->grupo_datos as $profesor) {

		$idprofesor = utf8_decode($profesor->dato[0]);
		$num_prof+=1;
		foreach ($xml->BLOQUE_DATOS->grupo_datos[1]->grupo_datos[$i]->grupo_datos as $horario) {
			$nombre_asignatura="";
			$abrev = "";
			$codigo_asig="";

			$diasemana = utf8_decode($horario->dato[0]);
			$idtramo = utf8_decode($horario->dato[1]);
			$tram = mysqli_query($db_con, "select hora from tramos where tramo = '$idtramo'");
			$tram_hor = mysqli_fetch_row($tram);
			$hora = $tram_hor[0];

			if (utf8_decode($horario->dato[2]) == "") $iddependencia = "NULL";
			else $iddependencia = utf8_decode($horario->dato[2]);

			if (utf8_decode($horario->dato[3]) == "") {$idunidad=""; $grupo=''; $curso='';}
			else {
				$idunidad = utf8_decode($horario->dato[3]);
				$unid = mysqli_query($db_con, "select nomunidad, nomcurso from unidades, cursos where  cursos.idcurso = unidades.idcurso
				AND unidades.idunidad  = '$idunidad'");
				$unidad = mysqli_fetch_row($unid);
				$grupo = $unidad[0];
				$curso = $unidad[1];
			}

			$idactividad = utf8_decode($horario->dato[10]);

			if (utf8_decode($horario->dato[5]) == "") {$idmateria="";}
			else {$idmateria = utf8_decode($horario->dato[5]);}

			if (utf8_decode($horario->dato[4]) == "") {$idcurso="";}
			else {$idcurso = utf8_decode($horario->dato[4]);}

			if ($idunidad == "" or $idmateria =="") {

				$activ = mysqli_query($db_con, "select nomactividad, idactividad from actividades_seneca where idactividad = '$idactividad'");
				$activida = mysqli_fetch_row($activ);
				$nombre_asigna = $activida[0];
				$idactividad = $activida[1];
				$nombre_asignatura = $activida[0];

				$nombre_asigna = str_replace(" de "," ",$nombre_asigna);
				$nombre_asigna = str_replace("/","",$nombre_asigna);
				$nombre_asigna = str_replace(" y "," ",$nombre_asigna);
				$nombre_asigna = str_replace(" á"," a",$nombre_asigna);
				$nombre_asigna = str_replace(" a "," ",$nombre_asigna);
				$nombre_asigna = str_replace(" la "," ",$nombre_asigna);
				$nombre_asigna = str_replace("(","",$nombre_asigna);
				$nombre_asigna = str_replace(")","",$nombre_asigna);

				$codigo_asig = $idactividad;

				$tr_abrev = explode(" ",$nombre_asigna);

				$letra1 = strtoupper(substr($tr_abrev[0],0,1));
				$letra2 = strtoupper(substr($tr_abrev[1],0,1));
				$letra3 = strtoupper(substr($tr_abrev[2],0,1));
				$letra4 = strtoupper(substr($tr_abrev[3],0,1));


				$abrev = $letra1.$letra2.$letra3.$letra4;

			}
			else{
				$nom_asig = mysqli_query($db_con, "select abrev, nombre from asignaturas where codigo = '$idmateria' and abrev not like '%\_%' and codigo is not NULL and codigo not like ''");
				$nom_asigna = mysqli_fetch_row($nom_asig);
				$abrev = $nom_asigna[0];
				$nombre_asignatura = $nom_asigna[1];
				$codigo_asig = $idmateria;
			}


			$nom_prof = mysqli_query($db_con, "select nomprofesor from profesores_seneca where idprofesor = '$idprofesor'");
			$nom_profe = mysqli_fetch_row($nom_prof);
			$nombre_profesor = $nom_profe[0];

			mysqli_query($db_con, "INSERT horw (`dia`, `hora`, `a_asig`, `asig`, `c_asig`, `prof`, `no_prof`, `c_prof`, `a_aula`, `n_aula`, `a_grupo`) VALUES ('$diasemana', '$hora', '$abrev', '$nombre_asignatura', '$codigo_asig', '$nombre_profesor', '$num_prof', '$idprofesor', '$iddependencia', '$iddependencia', '$grupo')");

			$asig = mysqli_query($db_con, "select codigo, nombre from asignaturas where curso = '$curso' and curso not like '' and nombre = '$nombre_asignatura' and abrev = '$abrev' and codigo not like '2'");

			if (mysqli_num_rows($asig)>0) {
				$asignatur = mysqli_fetch_array($asig);
				$asignatura=$asignatur[0];

				if (!($asignatura==$idmateria)) {
					$codasi = $asignatura;
					mysqli_query($db_con, "update horw set c_asig = '$codasi' where c_prof = '$idprofesor' and a_grupo = '$grupo' and c_asig = '$idmateria'");
				}
				else{
					$codasi="";
				}
			}
		}

		$i++;
			
		$porcentaje += $unid;
			
		echo '<script>callprogress('.round($porcentaje).' , \''.$tabla.'\');</script>';

	}


	// Actualizamos nombre de las materias / actividades para hacerlas más intuitivas
	mysqli_query($db_con, "update horw set a_asig = 'TCA' where c_asig = '2'");
	mysqli_query($db_con, "update asignaturas set abrev = 'TCA' where codigo = '2'");	
	mysqli_query($db_con, "update horw set a_asig = 'TCF' where c_asig = '279'");
	mysqli_query($db_con, "update horw set a_asig = 'TAP' where c_asig = '117'");		
	mysqli_query($db_con, "update horw set a_asig = 'GU' where c_asig = '25'");
	mysqli_query($db_con, "update horw set a_asig = 'GUREC' where c_asig = '353'");
	mysqli_query($db_con, "update horw set a_asig = 'GUBIB' where c_asig = '26'");

	// Eliminamos el Recreo como 4Âª Hora.
	$hora0 = "update horw set hora = 'R' WHERE hora ='4'";
	mysqli_query($db_con, $hora0);
	$hora4 = "UPDATE  horw SET  hora =  '4' WHERE  hora = '5'";
	mysqli_query($db_con, $hora4);
	$hora5 = "UPDATE  horw SET  hora =  '5' WHERE  hora = '6'";
	mysqli_query($db_con, $hora5);
	$hora6 = "UPDATE  horw SET  hora =  '6' WHERE  hora = '7'";
	mysqli_query($db_con, $hora6);
	mysqli_query($db_con, "OPTIMIZE TABLE  `horw`");

	// Metemos a los profes en la tabla profesores hasta que el horario se haya exportado a Séneca y consigamos los datos reales de los mismos
	$tabla_profes = mysqli_query($db_con, "select * from profesores");
	if (mysqli_num_rows($tabla_profes) > 0) {}
	else{
		// Recorremos la tabla Profesores bajada de Séneca
		$pro = mysqli_query($db_con, "select distinct asig, a_grupo, prof from horw where a_grupo in (select distinct nomunidad from unidades) order by prof");
		while ($prf = mysqli_fetch_array($pro)) {
			$materia = $prf[0];
			$grupo = $prf[1];
			$profesor = $prf[2];
			$niv = mysqli_query($db_con, "select distinct curso from alma where unidad = '$grupo'");
			$nive = mysqli_fetch_array($niv);
			$nivel = $nive[0];

			mysqli_query($db_con, "INSERT INTO  profesores (
				`nivel` ,
				`materia` ,
				`grupo` ,
				`profesor`
				) VALUES ('$nivel', '$materia', '$grupo', '$profesor')");
		}
	}


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
			if ($profe_dpt[0]=="384") {
				$cargos.="9";
			}
			if ($profe_dpt[0]=="26") {
				$cargos.="c";
			}
		if ($profe_dpt[0]=="2" OR $profe_dpt[0]=="351" OR $profe_dpt[0]=="279") {
				$cargos.="2";
			}
		}
		
		mysqli_query($db_con,"update departamentos set cargo='$cargos' where nombre = '$cargo[0]'");
		
			// Tutores
		$tabla_tut = mysqli_query($db_con, "select * from FTUTORES where tutor = '$cargo[0]'");
		if(mysqli_num_rows($tabla_tut) > 0){}
		else{
			if(strstr($cargos,"2")==TRUE)
			{
				mysqli_query($db_con, "insert into FTUTORES (unidad, tutor) select distinct a_grupo, prof from horw where c_asig like '2' and prof = '$cargo[0]' and prof in (select nombre from departamentos)");
				mysqli_query($db_con,"insert into FTUTORES (unidad, tutor) select distinct  prof from horw where c_asig like '117' and prof = '$cargo[0]' and prof not in (select tutor from FTUTORES)");
			}
		}
	}

	//
	// Creamos horw_faltas
	//
	mysqli_query($db_con, "drop table horw_faltas");
	mysqli_query($db_con, "create table horw_faltas select * from horw where a_grupo not like '' and c_asig not in (select distinct idactividad from actividades_seneca where idactividad not like '2' and idactividad not like '21' and idactividad not like '386')");

	// Eliminamos residuos y cambiamos alguna cosa.

	$sin = mysqli_query($db_con, "SELECT nombre FROM departamentos WHERE nombre not in (select profesor from profesores)");
	if(mysqli_num_rows($sin) > "0"){
		while($sin_hor=mysqli_fetch_array($sin))
		{
			$prof_sin.=" prof like '%$sin_hor[0]%' or";
		}
	}
	$prof_sin = " and ".substr($prof_sin,0,strlen($prof_sin)-3);

	mysqli_query($db_con, "delete from horw_faltas where a_grupo = ''");

	// Cambiamos los numeros de Horw para dejarlos en orden alfabético.
	$hor = mysqli_query($db_con, "select distinct prof from horw order by prof");
	while($hor_profe = mysqli_fetch_array($hor)){
		$np+=1;
		$sql = "update horw set no_prof='$np' where prof = '$hor_profe[0]'";
		$sql0 = "update horw_faltas set no_prof='$np' where prof = '$hor_profe[0]'";
		//echo "$sql<br>";
		$sql1 = mysqli_query($db_con, $sql);
		$sql2 = mysqli_query($db_con, $sq0);
	}

	mysqli_query($db_con, "OPTIMIZE TABLE  `horw_faltas`");

	echo '<p class="lead">Los datos han sido importados correctamente.</p>';

}

?></div>
<br>
<div class="well"><legend>Importación del horario con archivo DEL</legend>
<FORM ENCTYPE="multipart/form-data" ACTION="horarios.php" METHOD="post">

<div class="form-group"><label for="file">Selecciona el archivo con los
datos del Horario </label> <input type="file" name="archivo" id="file"></div>
<hr>

<INPUT type="submit" name="enviar" value="Importar"
	class="btn btn-primary">
</FORM>
</div>



</div>
<!-- /.col-sm-6 --> <!-- COLUMNA DERECHA -->
<div class="col-sm-6"><legend>Información sobre la importación con
archivo XML</legend>

<p>Este apartado se encarga de importar los <strong>horarios generados
por el programa generador de horarios</strong>.</p>

<p>
El primer formulario nos ofrece la posibilidad de importar el horario del Centro desde un archivo XML. Necesitamos el archivo en formato XML que las aplicaciones comerciales de Horarios (Horwin, etc.) crean para subir a Séneca. <b>Importar</b> extrae el horario del archivo y lo introduce en la tabla <b>Horw</b>.<br>
El segundo formulario nos ofrece la posibilidad de importar el horario del Centro desde un archivo DEL. Más información abajo.
</p>

<p>La opción <strong>Generar XML</strong> del primer formulario se encarga de comprobar la
compatibilidad de los horarios con Séneca, evitando tener que corregir
manualmente los horarios de cada profesor. El resultado es la descarga
del archivo <strong>Importacion_horarios_seneca.xml</strong> preparado
para subir a Séneca.</p>

<p>Si la opción <strong>Modo depuración</strong> se encuentra marcada se
podrá consultar los <strong>problemas de compatibilidad</strong> que
afectan al horario y podrán dar problemas en Séneca. Se recomienda
marcarla antes de importar el horario en Séneca. Con esta opción no se
genera el archivo XML.</p>
<hr />
<legend>Información sobre la importación con archivo DEL</legend>
<p>La importación de los horarios con el archivo DEL creado por Horwin
es una opción que sólo debe ser utilizada si no contamos con el archivo
XML, que es la opción preferida. Se mantiene para aquellos casos en los
que no tenemos a mano el XML para exportar a Séneca, o este produce errores en la importación. Las preferencias de
generación del archivo DEL aparecen marcadas en la imagen de abajo.</p>
<img border="0" src="exporta_horw.jpg"></div>
<!-- /.col-sm-6 --></div>
<!-- /.row --></div>
<!-- /.container -->


<?php include("../../pie.php"); ?>

<script>
	function callprogress ( valor , tabla ) {
	  var job = document.getElementById("progress_job");
	  var bar = document.getElementById("progress");
	  
	  job.innerHTML = 'Importando '+tabla+'...';
	  bar.innerHTML = '<div class="progress-bar" role="progressbar" aria-valuenow="'+valor+'" aria-valuemin="0" aria-valuemax="100" style="width: '+valor+'%;"><span class="sr-only">'+valor+'% Completado</span></div>';
	  
	  if (valor == 100) {
	  	job.className = 'hidden';
	  	bar.className = 'hidden';
	  }
	}
	</script>

</body>
</html>
