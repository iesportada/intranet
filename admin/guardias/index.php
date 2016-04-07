<?
require('../../bootstrap.php');


include("../../menu.php");

if (isset($_GET['n_dia'])) {$n_dia = $_GET['n_dia'];}elseif (isset($_POST['n_dia'])) {$n_dia = $_POST['n_dia'];}else{$n_dia="";}
if (isset($_GET['hora'])) {$hora = $_GET['hora'];}elseif (isset($_POST['hora'])) {$hora = $_POST['hora'];}else{$hora="";}
if (isset($_GET['profeso'])) {$profeso = $_GET['profeso'];}elseif (isset($_POST['profeso'])) {$profeso = $_POST['profeso'];}else{$profeso="";}
if (isset($_GET['h_profe'])) {$h_profe = $_GET['h_profe'];}elseif (isset($_POST['h_profe'])) {$h_profe = $_POST['h_profe'];}else{$h_profe="";}
if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}
if (isset($_GET['submit'])) {$submit = $_GET['submit'];}elseif (isset($_POST['submit'])) {$submit = $_POST['submit'];}else{$submit="";}
if (isset($_GET['sustituido'])) {$sustituido = $_GET['sustituido'];}elseif (isset($_POST['sustituido'])) {$sustituido = $_POST['sustituido'];}else{$sustituido="";}
if (isset($_GET['historico'])) {$historico = $_GET['historico'];}elseif (isset($_POST['historico'])) {$historico = $_POST['historico'];}else{$historico="";}


if ($n_dia == '1') {$nombre_dia = 'Lunes';}
if ($n_dia == '2') {$nombre_dia = 'Martes';}
if ($n_dia == '3') {$nombre_dia = 'Miércoles';}
if ($n_dia == '4') {$nombre_dia = 'Jueves';}
if ($n_dia == '5') {$nombre_dia = 'Viernes';}
$mes=date('m');
$dia_n = date('d');
$ano = date('Y');
$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia_n,$ano));
if ($numerodiasemana==0) {
	$numerodiasemana=7;
}
if ($n_dia > $numerodiasemana) {
	$dif = $n_dia - $numerodiasemana;
	$dif2 = $numerodiasemana-$n_dia;
	$g_dia = date('d')+$dif;
 } 
 if ($n_dia < $numerodiasemana) {
	$dif = $numerodiasemana - $n_dia;
	$dif2 = $numerodiasemana - $n_dia;	
	$g_dia = date('d')-$dif;
 } 
 if ($n_dia == $numerodiasemana) {
 	$dif = 0;
 	$g_dia = date('d');
 }
 	$g_fecha = date("Y-m-$g_dia");
 	$fecha_sp = formatDate($g_fecha);
?>
<div class="container">
<div class="row">
<br>
<div class="page-header">
<h2 style="display:inline">Guardias de Aula <small> Registro de Guardias</small></h2>

<!-- Button trigger modal -->
		<a href="#"class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
			<span class="fa fa-question fa-lg"></span>
		</a>
	
		<!-- Modal -->
		<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modal_ayuda_titulo" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
						<h4 class="modal-title" id="modal_ayuda_titulo">Instrucciones de uso</h4>
					</div>
					<div class="modal-body">
						<p>Este módulo permite registrar las sustituciones de profesores ausentes que hemos 
						hecho en su aula (guardias de aula). Aparece de entrada el número de sustituciones 
						de todos los miembros del Equipo de Guardia. Si hacemos click sobre el nombre de un 
						Compañero de guardia aparecen en la parte inferior de la página las sustituciones que 
						ha realizado ese profesor. Hay que tener en cuenta que en la selección de profesores 
						a sustituir sólo aparecen los profesores que tienen hora lectiva en ese momento 
						según el horario importado en la Intranet.</p>
						<p>Al registrar una sustitución cualquier compañero de la Guardia, aparece señalada 
						en la parte superior de la página de tal modo que todos los compañeros puedan ver 
						quién ha sustituido a quien en un aula durante esa hora.</p>
						<p>Las sustituciones sólo pueden registrarse hasta dos días después de realizarse. 
						Si nos olvidamos de hacerlo, tendremos que pedir al Equipo Directivo que nos la 
						registren.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
</div>
<?
if ($borrar=='1') {
	mysqli_query($db_con, "delete from guardias where id='".$_GET['id']."'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La sustitución ha sido borrada correctamente.
</div></div>';
}

if ($submit) {
	
	if (!(empty($sustituido))) {
		
					if (isset($dif2) and $dif2 > '1') {
						echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
Estás intentando registrar una sustitución con dos días o más de diferencia respecto a la fecha de la Guardia, y eso no es posible. Si por motivo justificado necesitas hacerlo, ponte en contacto con algún miembro del Equipo Directivo.
</div></div><br>';

 	}
 	else{
		$reg_sust0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = date('$g_fecha') and profesor = '$profeso'");

			if (mysqli_num_rows($reg_sust0) > '0') {
		$c1 = "1";
		$reg_sust = mysqli_fetch_array($reg_sust0);
		$id= $reg_sust[0];
		$prof_sust= $reg_sust[1];
		$prof_reg= $reg_sust[2];
		$hor_reg = $reg_sust[3];
		$fecha_reg0 = explode(" ",$reg_sust[4]);
		$fecha_reg = $fecha_reg0[0];
			mysqli_query($db_con, "update guardias set profe_aula = '$sustituido' where id = '$id'");
			echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Has actualizado correctamente los datos del Profesor que sustituyes.
</div></div><br>';
		}		
		else{
			
		$reg_sust0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = date('$g_fecha') and profe_aula = '$sustituido'");
			if (mysqli_num_rows($reg_sust0) > '0') {
		$c1 = "2";
		$reg_sust = mysqli_fetch_array($reg_sust0);	
		$id= $reg_sust[0];
		$prof_sust= $reg_sust[1];
		$prof_reg= $reg_sust[2];
		$fecha_reg0 = explode(" ",$reg_sust[4]);
		$fecha_reg = $fecha_reg0[0];
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>'.
$sustituido .'ya ha sido sustituido a la '.$hora.' hora el día '.$fecha_reg.'. Selecciona otro profesor y continúa.
</div></div><br>';
			}	
			else{
			
		if (!($c1) > '0') {

			$ya = mysqli_query($db_con, "select * from ausencias where profesor = '$sustituido' and date(inicio) <= date('$g_fecha') and date(fin) >= ('$g_fecha')");
			
		if (mysqli_num_rows($ya) > '0') {
			$ausencia_ya = mysqli_fetch_array($ya);
			$horas = $ausencia_ya[4];
			if ($horas!=="0" and $horas!=="" and strstr($horas, $hora)==FALSE) {
				$horas=$horas.$hora;	
				$actualiza = mysqli_query($db_con, "update ausencias set horas = '$horas' where id = '$ausencia_ya[0]'");									
				}
		}
		else{
			$inserta = mysqli_query($db_con, "insert into ausencias VALUES ('', '$sustituido', '$g_fecha', '$g_fecha', '$hora', '', NOW(), '')");	
		}
		
		
			$r_profe = mb_strtoupper($profeso, "ISO-8859-1");
			mysqli_query($db_con, "insert into guardias (profesor, profe_aula, dia, hora, fecha, fecha_guardia) VALUES ('$r_profe', '$sustituido', '$n_dia', '$hora', NOW(), '$g_fecha')");
			if (mysqli_affected_rows() > 0) {
				echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Has registrado correctamente a '.$sustituido.' a '.$hora.' hora para sustituirle en al Aula.
</div></div><br>';
			}	
		}				
			}
			
		}
	}
}
else{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN“N:</legend>
No has seleccionado a ningún profesor para sustituir. Elige uno de la lista desplegable para registrar esta hora.
</div></div><br>';
}
}	
?>
<div class="col-md-8 col-md-offset-2">
  <legend class="text-info" align="center"><? echo $nombre_dia.", ".$fecha_sp.", $hora"."ª hora";?></legend>

<?
$fech_hoy = date("Y-m-d");
$hoy0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha from guardias where dia = '$n_dia' and hora = '$hora' and date(fecha_guardia) = '$g_fecha'");
if (mysqli_num_rows($hoy0) > 0) {
	echo '<div class="well-transparent well-large" style="width:600px;">';
	echo "<p class='lead text-warning'>Sustituciones registradas para la Guardia de hoy</p>";
	echo '<table class="table table-striped" align=center style="">';
	echo "<tr><th>Profesor de Guardia</th><th>Profesor ausente</th></tr>";
	while ($hoy = mysqli_fetch_array($hoy0)) {
			echo "<tr><td>$hoy[1]</td><td style='color:#bd362f'>$hoy[2]</td></tr>";
	}
	echo "</table></div>";
}
?>
<p class='lead text-warning'>Sustituciones realizadas durante la <? echo "<span style=''>".$hora."ª</span>";?> hora del <? echo "<span style=''>$nombre_dia</span>";?></p>
<div class="row">
<div class="col-sm-6">
<?
echo '<table class="table table-striped" align="center">';
$h_gu0= mysqli_query($db_con, "select prof from horw where dia = '$n_dia' and hora = '$hora' and c_asig = '25' and a_asig not like 'GUCON'");
while ($h_gu = mysqli_fetch_array($h_gu0)) {
	echo "<tr><td>";
		echo "<a href='index.php?historico=1&profeso=$profeso&h_profe=$h_gu[0]&n_dia=$n_dia&hora=$hora#marca' style='font-size:0.9em'>$h_gu[0]</a></td>";

	echo "<td>";
	$num_g0=mysqli_query($db_con, "select id from guardias where profesor = '$h_gu[0]' and dia = '$n_dia' and hora = '$hora'");
	$ng_prof = mysqli_num_rows($num_g0);
	echo $ng_prof;
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
?>
</div>
<div class="col-sm-6">
<div class="well well-large">
<form action="index.php" method="POST">
<div class="form-group">
<label>Selecciona el Profesor que vas a cubrir</label>
<select name="sustituido" class="form-control">
<option></option>
<?
$sust0 = mysqli_query($db_con, "select distinct prof from horw where dia = '$n_dia' and hora = '$hora' and c_asig not like '25' and a_grupo not like '' or a_grupo like 'GCON%' order by prof");
while ($sust = mysqli_fetch_array($sust0)) {
	echo "<option>$sust[0]</option>";
}
?>
</select>
</div>
<input type="hidden" name="profeso" value="<? echo $profeso;?>">
<input type="hidden" name="n_dia" value="<? echo $n_dia;?>">
<input type="hidden" name="hora" value="<? echo $hora;?>">
<input type="submit" name="submit" class="btn btn-primary btn-block" value="Registrar sustitución del Profesor" />
</form>
</div>
</div>
</div>

<?
if ($historico == '1') {
	if (stristr($_SESSION['cargo'],'1') == TRUE) {
		$extra = "";
		$extra1 = " en este Curso Escolar";
	}
	else{
		$extra = " and hora = '$hora' and dia = '$n_dia'";
		$extra1 = " a ".$hora."ª hora del ".$nombre_dia;		
	}
	echo '<br><a name="marca"></a>';
$h_hoy0 = mysqli_query($db_con, "select id, profesor, profe_aula, hora, fecha_guardia from guardias where profesor = '$h_profe' $extra");
if (mysqli_num_rows($h_hoy0) > 0) {
	$h_profe=mb_strtolower($h_profe);
	echo "<p class='lead text-warning'>Sustituciones realizadas $extra1:<br /><span class='text-info text-capitalize'>$h_profe</span></p>";
	echo '<table class="table table-striped">';
	echo "<tr><th>Profesor Ausente</th><th>Fecha de la Guardia</th><th></th></tr>";
	while ($h_hoy = mysqli_fetch_array($h_hoy0)) {
		 	$fecha_sp = formatea_fecha($h_hoy[4]);
			echo "<tr><td>$h_hoy[2]</td><td>$fecha_sp</td>
			<td>";
			if (mb_strtolower($h_profe)==mb_strtolower($_SESSION['profi'])) {
			echo "<a href='index.php?id=$h_hoy[0]&borrar=1&profeso=$profeso&n_dia=$n_dia&hora=$hora' style='margin-top:5px;color:brown;' data-bb='confirm-delete'><i class='fa fa-trash-o' title='Borrar' > </i> </a>";				
			}
			echo "</td></tr>";
	}
	echo "</table><br>";
}
}
?>
</div>
</div>
</div>

<? include("../../pie.php");?>
</BODY>
</HTML>
