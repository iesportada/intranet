<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

// Aquí empieza la justificación.
// Buscamos registros siguiendo a cal.php
// Datos complementarios para el formulario
$borrajusti = "SELECT NC, CLAVEAL, apellidos, nombre FROM FALUMNOS WHERE claveal = '$alumno'";
$borrajusti0 = mysqli_query($db_con, $borrajusti);
// Borrado de faltas justificadas
if ($falta=="J")
{
	$borrajusti1 = mysqli_fetch_array($borrajusti0);
	$nombreal = trim($borrajusti1[3]);
	$apellidoal = trim($borrajusti1[2]);
	$deljusti = "DELETE FROM FALTAS WHERE FECHA = '$year-$month-$today' and CLAVEAL = '$alumno' and FALTA = 'J'";
	mysqli_query($db_con, $deljusti) or die("No se ha podido eliminar la Falta Justificada.<br> Ponte en contacto con quien pueda arreglarlo..");
}
// Aquí empieza la justificación.
else
{
	$justifica0 = "SELECT FALTA, FALTAS.NC, FALUMNOS.CLAVEAL, FALTAS.HORA, FALTAS.CODASI FROM FALTAS, FALUMNOS WHERE FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.FECHA = '$year-$month-$today' and FALTAS.claveal = '$alumno'";
	// echo $justifica0."<br>";
	$justifica1 = mysqli_query($db_con, $justifica0);
	if (mysqli_num_rows($justifica1) > 0) {
		while ($faltones = mysqli_fetch_array($justifica1)) {
			foreach ($_POST as $clave => $valor){
				if (strstr($clave,"_")==TRUE) {
					$tr_dia = explode("_",$clave);					
					if ($valor==$faltones[3]) {
						$justificacion = "UPDATE  FALTAS SET  FALTA =  'J' WHERE  FECHA = '$year-$month-$today' and FALTAS.claveal = '$alumno' and FALTAS.FALTA = 'F' and hora='$valor'";
						//echo $justificacion."<br>";
						mysqli_query($db_con, $justificacion);
					}
				}
			}
				
				

		}
	}
	// S i el tutor quiere justificar una falta antes de que haya sido introducida en la base de datos, procedemos a rellenar las horas marcadas de ese día con la "J".
	elseif($_POST['Enviar']=="Registrar"){
		foreach ($_POST as $clave => $valor){
			if (strstr($clave,"_")==TRUE) {
				$tr_dia = explode("_",$clave);
				$hoy_mismo=$tr_dia[1];
				$today=$hoy_mismo;
			}
		}
		if ($today == "") {
			$today = date('d');
		}

		$fecha2 = mktime(0,0,0,$month,$today,$year);
		$fecha22 = mktime(0,0,0,9,15,2008);
		$diames = date("j");
		$nmes = date("n");
		$nano = date("Y");
		$hoy1 = mktime(0,0,0,$nmes,$diames,$nano);
		$a = '$month-$today-$year';
		$ndia = getdate(mktime(0,0,0,$month,$today,$year));
		$fecha33 = $year."-".$month."-".$today;
		$fecha44 = $today."-".$month."-".$year;
		$fecha_fiesta= strtotime($fecha33);

		// Fiestas del Año, Vacaciones, etc.
		$comienzo_del_curso = strtotime($config['curso_inicio']);
		$final_del_curso = strtotime($config['curso_fin']);
		$dia_festivo="";
		$mens_fecha="";
		$repe=mysqli_query($db_con, "select fecha from festivos where date(fecha) = date('$fecha33')");
		if (mysqli_num_rows($repe) > '0') {
			$dia_festivo='1';
		}
		if($dia_festivo=='1')
		{
			$mens_fecha = "No es posible poner o justificar Faltas en un <b>Día Festivo</b> o en <b>Vacaciones</b>. Comprueba la Fecha: <b>$today-$month-$year</b>";
			if($year and $month and $today){$mens_fecha.=": ".$fecha44;}
			$mens_fecha.=".</p>";
		}
		elseif (($fecha2 < $comienzo_del_curso) and !($month == "" or $today == "" or $year == "")) {
			$mens_fecha = "No es posible poner Faltas del <b>Curso Anterior</b>.<br>Comprueba la Fecha: <b>$today-$month-$year</b>.";
		}
		elseif ($fecha2 > $hoy1) {
			$mens_fecha = "No es posible poner Faltas en el <b>Futuro</b>.<br>Comprueba la Fecha: <b>$today-$month-$year</b>.";
		}

		// Excluimos Sábados y Domingos;
		elseif (($ndia ['wday']== "0") or ($ndia ['wday']== "6")) {
		}
			
		else

		{

			$ctrl=0;
				
			if ($today == "") {
				$today = date('d');
			}
			// Excluimos otras posibilidades de error.
			if ($unidad == "") {
				echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>Parece que tenemos un problema: no has seleccionado el Grupo, Alumno o Día para justificar las Faltas de Asistencia. Si lo has hecho, quizás deberías buscar ayuda si este mensaje aparece de nuevo.</div></div>';
			}
			else {
				for ($i=1;$i<7;$i++)
				{
					?>
					<?php
					foreach ($_POST as $clave => $valor){
						if (strstr($clave,"_")==TRUE) {
							$codasi="";
							$profeso="";
							$num_dia = $ndia['wday'];

							$ctrl++;
							$tr_dia = explode("_",$clave);
							$hoy_mismo=$tr_dia[1];
							$today=$hoy_mismo;
							$hora_mismo=$tr_dia[0];
							$semana = date( mktime(0, 0, 0, $month, $hoy_mismo, $year));
							$hoy = getdate($semana);
							$nombredia = $hoy[wday];

							if ($valor == $i) {
								$unica = "select combasi from alma where alma.claveal = '$alumno'";
								$unica0 = mysqli_query($db_con, $unica);
								$unica1 = mysqli_fetch_row($unica0);
								$combasi=rtrim($unica1[0]);
								$comb_asi=explode(':', $combasi);
								//echo $combasi."<br>";
								$codasi10 = "select prof, a_asig, c_asig, no_prof from horw_faltas where a_grupo like '%$unidad%' and dia = '$num_dia' and hora = '$i'";
								$codasi0 = mysqli_query($db_con, $codasi10);
								while ($codasi1 = mysqli_fetch_row($codasi0)) {
									$cod_orig = $codasi1[2];
									$prof_orig = $codasi1[3];
										
									if ($codasi1[2]=="2") {
										$codasi = "2";
										$profeso = $codasi1[3];
									}
									elseif ($codasi1[2]=="21") {
										$codasi = "21";
										$profeso = $codasi1[3];
									}
									else {
										if(in_array($codasi1[2], $comb_asi)) {
											//if (stristr($combasi,$codasi1[2])==TRUE) {
											$codasi = $codasi1[2];
											$profeso = $codasi1[3];
										}
									}
								}
								if ($codasi=="") {
									$codasi = $cod_orig;
									$profeso = $prof_orig;
								}
								$clavenc = "SELECT NC FROM FALUMNOS WHERE claveal = '$alumno'";
								$clavenc0 = mysqli_query($db_con, $clavenc);
								$clavenc1 = mysqli_fetch_row($clavenc0);
								$nc = $clavenc1[0];
								$enviada = "$year-$month-$today";
									
								$justifica10 = "insert INTO  FALTAS (  CLAVEAL , unidad  ,  NC ,  FECHA ,  HORA , DIA,  PROFESOR ,  CODASI ,  FALTA ) VALUES ('$alumno',  '$unidad', '$nc',  '$year-$month-$hoy_mismo', '$i', '$nombredia', '$profeso',  '$codasi', 'F')";
								//echo $justifica10."<br>";
								mysqli_query($db_con, $justifica10) or die("No se ha podido justificar las faltas.");
							}
						}
					}
				}
			}
			if ($ctrl==0) {
				echo '<div align="center"><div class="alert alert-danger alert-block fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>Debes marcar al menos una hora de ausencia para poder justificarla posteriormente, y no has marcado ninguna en elcuadro de diálogo que ha aparecido anteriormente.</div></div>';
			}
		}
	}
}
$borrapend = mysqli_query($db_con, "select combasi, claveal, curso from alma where curso like '%bach%'order by curso");
while ($com=mysqli_fetch_array($borrapend)) {
	if (strlen($com[0])<49) {
		mysqli_query($db_con, "delete from FALTAS where claveal='$com[1]' and codasi='' and profesor=''");
	}
}
?>