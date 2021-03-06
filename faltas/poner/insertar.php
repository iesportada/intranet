<?php
// Eliminamos de FALTAS las faltas borradas por el profesor. La tarea es cosa del fichero borrar.php
include("borrar.php");
// Conexi�n
// Contamos el total de variables que se han enviado desde el Formulario.
$total = count($_POST);
$claves = array_values($_POST);
$i = 4;
// Cambiamos el nombre del profe por su codigo
$profesor = trim($profesor);
$profe = "select no_prof from horw where prof = '$profesor'";
$profe0 = mysqli_query($db_con, $profe);
$codprof = mysqli_fetch_row($profe0);
$num_profe = trim($codprof[0]);

// Luego habr� que separar del total los dos campos que molestan para formar los bloques de 6 variables: profesor al principio y enviar al final. Por eso restamos 2.
while($i < $total - 2)
{

	// Dividimos los valores en grupos de 6, cada uno conteniendo todos los datos necesarios para una hora de un dia de la semana, con su fecha, nivel grupo, etc.
	$trozos = array_slice($claves, $i, 6);

	// Comienzan los controles para validar los datos.
	// Primero comprobamos si se han puesto faltas. Si no, pasamos al siguiente bloque.
	if (empty($trozos[2]))
	{
	}

	else {
		// Bloquear Fechas futuras y pasadas
		$fecha0 = explode('-',$trozos[0]);
		$dia0 = $fecha0[0];
		$mes = $fecha0[1];
		$ano = $fecha0[2];
		$fecha1 = $ano . "-" . $mes . "-" . $dia0;
		$fecha11 = $dia0 . "-" . $mes . "-" . $ano;
		$fecha2 = mktime(0,0,0,$mes,$dia0,$ano);
		$diames = date("j");
		$nmes = date("n");
		$nano = date("Y");
		$hoy1 = mktime(0,0,0,$nmes,$diames,$nano);

		$fecha_fiesta= strtotime($fecha1);
		$comienzo_del_curso = strtotime($config['curso_inicio']);
		$final_del_curso = strtotime($config['curso_fin']);

		$repe=mysqli_query($db_con, "select fecha from festivos where date(fecha) = date('$fecha1')");
		if (mysqli_num_rows($repe) > '0') {
			$dia_festivo='1';
		}
		if($dia_festivo=='1')
		{
			$mens_fecha = "No es posible poner o justificar Faltas en un <b>D�a Festivo</b> o en <b>Vacaciones</b>. Comprueba la Fecha: <b>$fecha11</b>";
		}
		elseif ($fecha2 < $comienzo_del_curso) {
			$mens_fecha = "No es posible poner Faltas del <b>Curso Anterior</b>.<br>Comprueba la Fecha: <b>$fecha11</b>.";
		}
		elseif ($fecha2 > $hoy1) {
			$mens_fecha = "No es posible poner Faltas en el <b>Futuro</b>.<br>Comprueba la Fecha: <b>$fecha11</b>.";
		}
		else {
			// Pasamos fecha espa�ola a formato MySql
			$fecha0 = explode('-',$trozos[0]);
			$dia0 = $fecha0[0];
			$mes = $fecha0[1];
			$ano = $fecha0[2];
			$fecha1 = $ano . "-" . $mes . "-" . $dia0;

			// Caso de faltas para TODOS los alumnos en una hora
			if ($trozos[2] == "T" OR $trozos[2] == "t") {
				// Buscamos en FALUMNOS los datos que necesitamos, claveal y nc, porque los dem�s los cogemos del formulario.
				$claveT ="select CLAVEAL, NC from FALUMNOS where unidad = '$trozos[3]' order by NC";
				$claveT0 = mysqli_query($db_con, $claveT);
				while ($claveT1 = mysqli_fetch_array($claveT0))
				{
					$clavealT = $claveT1[0];
					$ncT = $claveT1[1];
					// Comprobamos si se est� volviendo a meter una falta que ya ha sido metida.
					$duplicadosT = "select NC from FALTAS where unidad = '$trozos[3]' and NC = '$ncT' and HORA = '$trozos[5]' and FECHA = '$fecha1' and CODASI = '$trozos[4]' and PROFESOR = '$num_profe' and FALTA = 'F'";
					$duplicadosT0 = mysqli_query($db_con, $duplicadosT);
					$duplicadosT1 = mysqli_num_rows($duplicadosT0);
					// O si hay al menos una justicaci�n introducida por el Tutor en ese d�a
					$jt ="select NC from FALTAS where unidad = '$trozos[3]' and NC = '$ncT' and FECHA = '$fecha1' and FALTA = 'J'";
					$jt0 = mysqli_query($db_con, $jt);
					$jt1 = mysqli_num_rows($jt0);
						
					// Tiene actividad extraescolar en la fecha
					$hay_actividad="";
					$extraescolar=mysqli_query($db_con, "select cod_actividad from actividadalumno where claveal = '$clavealT' and cod_actividad in (select id from calendario where date(fechaini) >= date('$fecha1') and date(fechafin) <= date('$fecha1'))");
					if (mysqli_num_rows($extraescolar) > '0') {
						while($actividad = mysqli_fetch_array($extraescolar)){
							$tr = mysqli_query($db_con,"select * from calendario where id = '$actividad[0]' and horaini<= (select hora_inicio from tramos where hora = '$trozos[5]') and horafin>= (select hora_fin from tramos where hora = '$trozos[5]')");
							if (mysqli_num_rows($tr)>0) {
								$hay_actividad = 1;
							}
						}
					}
					if ($hay_actividad==1){
						$mens_fecha = "No es posible poner Falta a algunos o todos los alumnos del grupo porque est�n registrados en una Actividad Extraescolar programada.";
					}
					else{
						// Si la falta no se ha metido, insertamos los datos.
						if ($duplicadosT1 == "0" and $jt1 == "0") {
							$semana = date( mktime(0, 0, 0, $mes, $dia0, $ano));
							$hoy = getdate($semana);
							$nombredia = $hoy[wday];
							// Insertamos las faltas de TODOS los alumnos.
							$t0 = "insert INTO  FALTAS (  CLAVEAL , unidad,  NC ,  FECHA ,  HORA , DIA,  PROFESOR ,  CODASI ,  FALTA )
VALUES ('$clavealT',  '$trozos[3]',  '$ncT',  '$fecha1',  '$trozos[5]', '$nombredia',  '$num_profe',  '$codasi', 'F')";
							mysqli_query($db_con, $t0) or die("No se ha podido insertar datos");
						}
						if ($jt1 > 0) {
							$mens4.=" El Tutor ya ha justificado las Faltas del Alumno N� <b>$ncT</b> de <b>$trozos[3]</b> en ese d�a.<br>";
						}
					}
				}
			}
			else {
				// Cortamos los NC de los alumnos, en caso de que haya varias faltas.
				$nnc = explode(".",trim($trozos[2],"."));
				$nnc1 = array($nnc);
				// Contamos el n�mero de faltas puestas.
				$num =count($nnc);
				// Recorremos los distintos NC.
				$c = 0;
				while ($c < ($num)) {
					$nc = $nnc[$c];
					// Para cada falta, comprobamos si existe el alumno, o sea, si tiene CLAVEAL en FALUMNOS.
					$clave ="select CLAVEAL from FALUMNOS where unidad = '$trozos[3]' AND NC = '$nc'";
					$clave0 = mysqli_query($db_con, $clave);
					$clave1 = mysqli_fetch_row($clave0);
					$claveal = $clave1[0];
					// Si la falta tiene formato num�rico, continuamos (en el formato num�rico se excluyen signos como "-" o ",", por si el profe separa las faltas de otra manera que la correcta).
					if (is_numeric($nc))
					{
						// Si no existe el alumno, porque su CLAVEAL no aparece...
						if ( strlen($claveal) < 5)
						{
							// mensaje de error: no existe el Alumno.
							$mens1.="<b>$nc</b> no es el n�mero de ning�n alumno de <b>$trozos[3]</b>.<br>";
						}
						else {
							// Si hemos pasado los filtros, hay que comprobar si se est� volviendo a meter una falta que ya ha sido metida.
							$duplicados = "select NC, FALTA from FALTAS where unidad = '$trozos[3]' and NC = '$nc' and HORA = '$trozos[5]' and FECHA = '$fecha1' and CODASI = '$trozos[4]' and FALTA = 'F'";
							$duplicados0 = mysqli_query($db_con, $duplicados);
							$duplicados1 = mysqli_num_rows($duplicados0);
							// O si hay al menos una justicaci�n introducida por el Tutor en ese d�a
							$jt ="select NC from FALTAS where unidad = '$trozos[3]' and NC = '$nc' and FECHA = '$fecha1' and FALTA = 'J'";
							$jt0 = mysqli_query($db_con, $jt);
							$jt1 = mysqli_num_rows($jt0);
							
							// Tiene actividad extraescolar en la fecha
							$hay_actividad="";
							$extraescolar=mysqli_query($db_con, "select cod_actividad from actividadalumno where claveal = '$claveal' and cod_actividad in (select id from calendario where date(fechaini) >= date('$fecha1') and date(fechafin) <= date('$fecha1'))");
							if (mysqli_num_rows($extraescolar) > '0') {
								while($actividad = mysqli_fetch_array($extraescolar)){
									$tr = mysqli_query($db_con,"select * from calendario where id = '$actividad[0]' and horaini<= (select hora_inicio from tramos where hora = '$trozos[5]') and horafin>= (select hora_fin from tramos where hora = '$trozos[5]')");
									if (mysqli_num_rows($tr)>0) {
										$hay_actividad = 1;
									}
								}
							}
							if ($hay_actividad==1){
								$mens_fecha = "No es posible poner Falta a algunos o todos los alumnos del grupo porque est�n registrados en una Actividad Extraescolar programada.";
							}
							else{
								// Si la falta no se ha metido, insertamos los datos.
								if ($duplicados1 == "0" and $jt1 == "0") {
									$semana = date( mktime(0, 0, 0, $mes, $dia0, $ano));
									$hoy = getdate($semana);
									$nombredia = $hoy[wday];
									$insert = "insert INTO  FALTAS (  CLAVEAL , unidad ,   NC ,  FECHA ,  HORA , DIA,  PROFESOR ,  CODASI ,  FALTA ) VALUES ('$claveal',  '$trozos[3]', '$nc',  '$fecha1',  '$trozos[5]', '$nombredia',  '$num_profe',  '$trozos[4]', 'F')";
									//echo "$insert<br>";
									mysqli_query($db_con, $insert) or die("No se ha podido insertar datos");
								}
								// Otras posibilidades
								elseif ($duplicados1 > 0 or $jt1 > 0)
								{
									$duplicados2 = mysqli_fetch_row($duplicados0);
									// La falta est� justificada
									if ($jt1 > 0) {
										$mens3.="El Tutor ya ha justificado las Faltas del Alumno N� <b>$nc</b> de <b style='color:brown'>$trozos[3]</b> en ese d�a.<br>";
									}
									// La falta ha sido metida ya.
									elseif ($duplicados2[1] == "F") {
									}
								}
							}
						}
					}
					else {
						// Mensaje de error: no es un n�mero correcto, porque no existe ("45", o un alumno que se ha dado de baja, o bien porque se han incluido letras o signos inv�lidos)
						$mens2.="<b>$nc</b> no es el n�mero de ning�n alumno de <b>$trozos[3]</b>.<br>";
					}
					$c++;
				}
			}
		}
	}
	// Pasamos al siguiente bloque de 6 variables hasta el final
	$i += 6;
}
//exit();
?>
<script language="javascript">
<?php
if(!(empty($mens_fecha)) or !(empty($mens1)) or !(empty($mens2)) or !(empty($mens3)) or !(empty($mens4)))
{
?>
setTimeout("window.location='index.php?year=<?php echo $ano;?>&today=<?php echo $today;?>&month=<?php echo $mes;?>'", 3000) 
<?php
}
else
{
?>
setTimeout("window.location='index.php?registro=1&year=<?php echo $ano;?>&today=<?php echo $today;?>&month=<?php echo $mes;?>'", 5) 
<?php
}
?>
</script>
