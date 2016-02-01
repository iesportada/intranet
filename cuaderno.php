<?php
ini_set("session.cookie_lifetime","2800");
ini_set("session.gc_maxlifetime","3600");

require('bootstrap.php');


$pr = $_SESSION['profi'];

include("menu.php");
include("cuaderno/menu.php");

?>
<script>
function cambia_color(primero,segundo,tercero,cuarto,quinto,sexto,septimo,octavo,noveno,decimo){
	celda = document.getElementById(primero);celda.style.backgroundColor="#555";
	celda = document.getElementById(segundo);celda.style.backgroundColor="#555";
	celda = document.getElementById(tercero);celda.style.backgroundColor="#555";
	celda = document.getElementById(cuarto);celda.style.backgroundColor="#555";
	celda = document.getElementById(quinto);celda.style.backgroundColor="#555";
	celda = document.getElementById(sexto);celda.style.backgroundColor="#555";
	celda = document.getElementById(septimo);celda.style.backgroundColor="#555";
	celda = document.getElementById(octavo);celda.style.backgroundColor="#555";
	celda = document.getElementById(noveno);celda.style.backgroundColor="#555";
	celda = document.getElementById(decimo);celda.style.backgroundColor="#555";
	}
function descambia_color(primero,segundo,tercero,cuarto,quinto,sexto,septimo,octavo,noveno,decimo){
	celda = document.getElementById(primero);celda.style.backgroundColor="#fff";
	celda = document.getElementById(segundo);celda.style.backgroundColor="#fff";
	celda = document.getElementById(tercero);celda.style.backgroundColor="#fff";
	celda = document.getElementById(cuarto);celda.style.backgroundColor="#fff";
	celda = document.getElementById(quinto);celda.style.backgroundColor="#fff";
	celda = document.getElementById(sexto);celda.style.backgroundColor="#fff";
	celda = document.getElementById(septimo);celda.style.backgroundColor="#fff";
	celda = document.getElementById(octavo);celda.style.backgroundColor="#fff";
	celda = document.getElementById(noveno);celda.style.backgroundColor="#fff";
	celda = document.getElementById(decimo);celda.style.backgroundColor="#fff";
	}	
</script>
<style>
input[type=number]::-webkit-inner-spin-button {
	-webkit-appearance: none;
}

input[type=number] {
	-moz-appearance: textfield;
}
</style>
<?php
// Variables

if (isset($_GET['nom_asig'])) {
	$nom_asig = $_GET['nom_asig'];
}
elseif (isset($_POST['nom_asig'])) {
	$nom_asig = $_POST['nom_asig'];
}

if (isset($_GET['clave'])) {
	$clave = $_GET['clave'];
}
elseif (isset($_POST['clave'])) {
	$clave = $_POST['clave'];
}

if (isset($_GET['seleccionar'])) {
	$seleccionar = $_GET['seleccionar'];
}
elseif (isset($_POST['seleccionar'])) {
	$seleccionar = $_POST['seleccionar'];
}
else{
	$seleccionar = "";
}

if (isset($_GET['foto'])) {
	$foto = $_GET['foto'];
}
elseif (isset($_POST['foto'])) {
	$foto = $_POST['foto'];
}

// Elegir Curso y Asignatura.
if(empty($curso))
{
	include("index.php");
	exit;
}
mysqli_query($db_con, "ALTER TABLE  datos CHANGE  nota VARCHAR( 48 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT  '' ");
mysqli_query($db_con,"ALTER TABLE `datos` CHANGE `nota` `nota` TEXT CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT ''");

$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
// Titulo

if($pr and $dia and $hora)
{
	$num_cursos0 = mysqli_query($db_con, "SELECT distinct  a_grupo FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora' ORDER BY a_grupo");
	// Todos los Grupos juntos
	$curs = "";
	$codigos = "";
	$nom_asig="";
	while($n_cur = mysqli_fetch_array($num_cursos0))
	{
		$curs .= $n_cur[0].", ";
	}

	$num_asig0 = mysqli_query($db_con, "SELECT distinct c_asig, asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora' ORDER BY c_asig");
	while ($num_asig1=mysqli_fetch_array($num_asig0)) {	
		$num_codigos++;
		$codigos.= $num_asig1[0]." ";
		${asignatura.$num_codigos}=$num_asig1[0];
		$nom_asig = $num_asig1[1];
	}

	if (strlen($asignatura2)>1) {
			$extra_asig = " or asignatura = '$asignatura2'";
	}
	else{
			$asignatura2=$asignatura1;
			$extra_asig = "";
	}	
	?>
<div class='container'>
<div class='row'>
<div class='page-header hidden-print'>
<h2 class='no_imprimir'>Cuaderno de Notas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small
	class="text-info">&nbsp;<i class='fa fa-users'> </i>&nbsp;<?php echo substr($curs,0,-2)." ( ".$nom_asig," )";?></small></h2>
</div>

<div align="center"><?php
// Enviar datos y procesarlos
if(isset($_POST['enviar']))
{
	include("cuaderno/poner_notas.php");
}

// Distintos códigos de la asignatura cuando hay varios grupos en una hora.
$n_c = mysqli_query($db_con, "SELECT distinct  a_grupo, profesores.nivel FROM  horw, profesores where prof = profesor and a_grupo = profesores.grupo and prof = '$pr' and dia = '$dia' and hora = '$hora' ORDER BY a_grupo");

while($varias = mysqli_fetch_array($n_c))
{
	if (substr($varias[0],3,2) == "Dd" ) {
		$varias[0] = substr($varias[0],0,4);
	}
	$nombre_curso = $varias[1];
	$nombre_materia = strtolower($nombre_curso);
}

$codigos = substr($codigos,0,-1);
// Eliminamos el espacio
$curs0 = substr($curs,0,(strlen($curs)-1));
// Eliminamos la última coma para el título.
$curso_sin = substr($curs0,0,(strlen($curs0)-1));
$curso_asignatura = substr($curso_sin, 0, 8);
//Número de columnas
$col = "select distinct id, nombre, orden, visible_nota, Tipo, texto_pond from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and (asignatura='$asignatura' $extra_asig) and oculto = '0' order by orden asc";
//echo $col;
$col0 = mysqli_query($db_con, $col);
$cols = mysqli_num_rows($col0);
$sin_coma=$curso;
}
?> <?php
include("cuaderno/menu_cuaderno.php");
?>

<div class="col-md-12">
<form action="cuaderno.php" method="post" name="imprime"
	class="form-inline">
<table class="table" style="width: auto">
	<thead>
		<tr>
			<td style="vertical-align: top; padding: 1px">

			<table class='table table-bordered table-condensed'
				style='width: auto;'>
				<tr>
					<td nowrap>
					<div style='width: 40px; height: 104px;'>
					<div class='Rotate-90'></div>
					</div>
					</td>
				</tr>
				<?php
				$curso0 = "SELECT distinct a_grupo, asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora' ORDER BY a_grupo";
				//echo $curso0."<br />";
				$curso20 = mysqli_query($db_con, $curso0);
				$num_cursos = mysqli_num_rows($curso20);
				while ($curso11 = mysqli_fetch_array($curso20))
				{
					if ($num_cursos>1) {
						echo "<tr><td class='active'><h4 align=center>$curso11[0]</h4></td></tr>";
					}
					$curso = $curso11[0];
					$nivel_curso = substr($curso,0,1);
					$nombre = $curso11[1];

					// Número de Columnas para crear la tabla
					$num_col =  $cols2;

					

					//	Problemas con Diversificación (4E-Dd)
					$profe_div = mysqli_query($db_con, "select * from profesores where grupo = '$curso'");
					if (mysqli_num_rows($profe_div)<1) {
						$asig_div="";						
						$div = $curso;
						$nivel_curso2 = substr($div,0,-1);
						$grupo_div = mysqli_query($db_con, "select distinct unidad from alma where unidad like '$nivel_curso2%' and (combasi like '%25204%' or combasi LIKE '%25226%' or combasi LIKE '%31307%' OR combasi LIKE '%135785%')");
						$grupo_diver = mysqli_fetch_row($grupo_div);
						$curso = $grupo_diver[0];
						$asig_div = "combasi like '%25204%' or combasi LIKE '%25226%' or combasi LIKE '%31307%' OR combasi LIKE '%135785%'";
					}
					if (empty($seleccionar)) {
						if(!(empty($div))){$curso_orig = $div;}else{$curso_orig = $curso;}
						mysqli_select_db($db_con, $db);
						$hay0 = "select alumnos from grupos where profesor='$pr' and (asignatura = '$asignatura' $extra_asig) and curso = '$curso_orig'";
						//echo $hay0."<br>";
						$hay1 = mysqli_query($db_con, $hay0);
						$hay = mysqli_fetch_row($hay1);
						$todos = "";
						if(mysqli_num_rows($hay1) == "1"){
							$seleccionados = substr($hay[0],0,strlen($hay[0])-1);
							$t_al = explode(",",$seleccionados);
							$todos = " and (nc = '300'";
							foreach($t_al as $cadauno){
								$todos .=" or nc = '$cadauno'";
							}
							$todos .= ")";
						}
					}
					// Alumnos para presentar que tengan esa asignatura en combasi
					$resul = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi, alma.unidad, alma.curso from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and alma.unidad = '$curso' and (";
					//Alumnos de 2º de Bachillerato
					if (strstr($nombre_curso,"Bach")==TRUE) {
							$resul.=" combasi like '%$asignatura:%' or combasi like '%$asignatura2:%'";
						}
					elseif(strlen($asig_div)>0){
							$resul.= $asig_div;
						}
					elseif($asignatura=="21" or $asignatura=="2"){
							$resul.= " 1=1 ";
						}
					else{
						$resul.=" combasi like '%$asignatura:%' ";
					}
					$resul.=") ". $todos ." order by NC ASC";
					$result = mysqli_query($db_con, $resul);
					while($row = mysqli_fetch_array($result))
					{
						$n_fila+=1;
						$claveal = $row[0];
						$nombre_al =   $row[3];
						$apellidos =   $row[2];
						$nombre_completo = $apellidos.", ".$nombre_al;
						$n_nombre = strlen($nombre_completo);
						if ($n_nombre > 25) {
							$nombre_completo = substr($nombre_completo,0,25)."..";
						}
						$nc = $row[1];
						$grupo_simple =  $row[6];
						if ($row[5] == "") {}
						else
						{
							$inf = 'cuaderno/informe.php?profesor='.$pr.'&curso='.$curso.'&asignatura='.$asignatura.'&nc='.$nc.'&claveal='.$claveal.'&nombre='.$nombre_al.'&apellidos='.$apellidos.'&nom_asig='.$nom_asig.'&dia='.$dia.'&hora='.$hora.'';
						}
						if ($n_fila=="10" or $n_fila=="20" or $n_fila=="30" or $n_fila=="40") {
							echo "<tr><td>
<div style='width:40px;height:90px;'>
<div class='Rotate-corto'></div>
</div> </td></tr>";
						}
						?>
				<tr>
					<td nowrap style='vertical-align: middle; height: 74px;'
						class='text-info' data-bs='tooltip'
						title=' <?php echo $apellidos.", ".$nombre_al;?>'><a href="#"
						onclick="window.open('<?php echo $inf;?>')"> <?php
						if ($foto=="1") {
						$foto1='<span class="fa fa-user fa-fw fa-3x"></span>';
						}
						else{
						$foto1="";
						$foto1 = "<img src='xml/fotos/$claveal.jpg' width='50' height='60' class=''  />";													
						}
						echo $foto1;
						echo "&nbsp;".$row[1];?>&nbsp; <?php
						echo $nombre_completo;?></a></td>
				</tr>
				<?php
					}
				}
				?>
			</table>

			</td>

			<td style="vertical-align: top; padding: 1px">

			<div
				style="overflow: auto; overflow-y: hidden; width: 855px; padding: 0">


			<table class='table table-bordered table-condensed'
				style='width: auto'>
				<tr>
				<?php if ($config['mod_asistencia']) { ?>
					
					<td>
					<div style='width: 40px; height: 104px;'>
					<div class='Rotate-90'><span style='font-weight: bold'>Asistencia</span>
					</div>
					</div>
					</td>
				<?php } ?>	
					<?php
					// Notas de las Evaluaciones de Séneca
					$ev_sen1 = mysqli_query($db_con,"select notas1 from notas where notas1 != ''");
					$ev_sen2 = mysqli_query($db_con,"select notas2 from notas where notas2 != ''");
					$ev_sen3 = mysqli_query($db_con,"select notas3 from notas where notas3 != ''");
					$num_ev1 = mysqli_num_rows($ev_sen1);
					$num_ev2 = mysqli_num_rows($ev_sen2);
					$num_ev3 = mysqli_num_rows($ev_sen3);

					for ($i=1; $i < 4; $i++) { 
									if (${num_ev.$i}>0 and $asignatura!=="2") {
									echo "<td nowrap>
									<div style='width:40px;height:104px;'>
									<div class='Rotate-90'><span style='font-weight:bold'>".$i."ª Evalución Séneca</span></div>
									</div> </td>";
									${extra_sen.$i} = "1";
									}
								}

					// Número de las columnas de la tabla
					$cols2=0;
					while($col20 = mysqli_fetch_array($col0)){
						$id = $col20[0];
						$tipo_col = $col20[4];

						$col_ord=mysqli_query($db_con, "select distinct ponderacion from datos where id = '$id' ");
						$col_pondera = mysqli_fetch_array($col_ord);
						$orden_pondera = $col_pondera[0];
						if ($orden_pondera=="") {
							$orden_ponde="";
						}
						else{
							$orden_ponde="<span class='text-muted' data-bs='tooltip' title='Ponderación asignada a la columna'>(".$orden_pondera.")</span>";
						}

						if ($tipo_col=="Números") { $clase_col = "text-info";}elseif ($tipo_col=="Texto corto"){$clase_col = "text-success";}elseif ($tipo_col=="Texto largo"){$clase_col = "text-warning";}elseif ($tipo_col=="Casilla de verificación"){$clase_col = "text-danger";}elseif ($tipo_col=="Ponderacion"){$clase_col = "";}
						$icon_eye="";
						$nombre_col="";
						$col2=mysqli_query($db_con, "select distinct id from datos where id = '$col20[0]' ");
						$cols2 += mysqli_num_rows($col2); //echo $cols2;
						$ident= $col20[2];
						$nombre_col = $col20[1];
						$mens0 = "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&curso=$curs0&dia=$dia&hora=$hora&id=$id&orden=$ident&nom_asig=$nom_asig";
						if (strstr($nombre_col,"Ponderación")==TRUE) {
							$nombre_columna="";
							$orden_columna="";
							$tr_pond= explode(":",$nombre_col);
							$id_pond=str_replace(" ","",$tr_pond[1]);
							$tr_pond2= explode(", ",$tr_pond[1]);
							$orden_columna="Cols. ";
							foreach ($tr_pond2 as $id_columna){
								$n_colum = mysqli_query($db_con,"select nombre, orden from notas_cuaderno where id='$id_columna'");
								$n_columna = mysqli_fetch_array($n_colum);
								$orden_columna.=$n_columna[1].", ";
								$nombre_columna.=$n_columna[0].", ";
								$nombre_columna.=$n_columna[0].", ";
							}
							$nombre_columna=substr($nombre_columna,0,-2);
							$orden_columna=substr($orden_columna,0,-2);
							$col_vert="<span  data-bs='tooltip' title='Columna con Media Ponderada'>&nbsp;&nbsp;Ponderación  ($ident)<br>&nbsp;&nbsp;&nbsp;".$orden_columna."</span>";
						}
						elseif (strlen($nombre_col)>23) {
							$col_vert = "&nbsp;&nbsp;".substr($nombre_col,0,20)."...<br>&nbsp;&nbsp;&nbsp;<span  data-bs='tooltip' title='Número de la Columna'>".$ident."</span>";
						}
						else {
							$col_vert = "&nbsp;&nbsp;".$nombre_col."<br>&nbsp;&nbsp;&nbsp;<span  data-bs='tooltip' title='Número de la Columna'>".$ident."</span> ".$orden_ponde;
						}

						if ($tipo_col=="Ponderacion") {
							?>
							<?php
							echo "<td nowrap style='background-color:#555' id='$id' onmouseover='cambia_color($id_pond)' onmouseout='descambia_color($id_pond)'>
<div style='width:40px;height:104px;'>
<div class='Rotate-90'><span text-lowercase' style='font-weight:normal;color:#fff'>$col_vert</span></div>
</div> </td>";
						}
						else{
							echo "<td nowrap id='$id'>
<div style='width:40px;height:104px;'>
<div class='Rotate-90'><span class='$clase_col text-lowercase' style='font-weight:normal'>$col_vert</span> </div>
</div> </td>";
						}
					}

					if($seleccionar == 1){
						echo "<td nowrap class='warning'>
<div style='width:40px;height:104px;'>
<div class='Rotate-90'><span class='text-lowercase' style='font-weight:normal'> Selección de alumnos </span></div>
</div> </td>";
					}

					echo "</tr>";
					// Tabla para cada Grupo
					$curso0 = "SELECT distinct a_grupo, asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora' ORDER BY a_grupo";
					$curso20 = mysqli_query($db_con, $curso0);
					$num_cursos = mysqli_num_rows($curso20);
					while ($curso11 = mysqli_fetch_array($curso20))
					{
						if ($num_cursos>1) {
							$col_total=$cols+1;
							if ($extra_sen1==1) {$col_total+=1;}
							if ($extra_sen2==1) {$col_total+=1;}
							if ($extra_sen3==1) {$col_total+=1;}
							echo "<tr><td colspan='$col_total' class='active'><h4 align=center>$curso11[0]</h4></td></tr>";
						}
						$curso = $curso11[0];
						$nivel_curso2 = substr($curso,0,-1);
						$nombre = $curso11[1];

						// Número de Columnas para crear la tabla
						$num_col =  $cols2;
					


						//	Problemas con Diversificación (4E-Dd)
						$profe_div = mysqli_query($db_con, "select * from profesores where grupo = '$curso'");
						if (mysqli_num_rows($profe_div)<1) {

							$div = $curso;
							$grupo_div = mysqli_query($db_con, "select distinct unidad from alma where unidad like '$nivel_curso2%' and (combasi like '%25204%' or combasi LIKE '%25226%' OR combasi LIKE '%135785%')");
							$grupo_diver = mysqli_fetch_row($grupo_div);
							$curso = $grupo_diver[0];
						}
						else{
							if($seleccionar=="1"){	$num_col += 1;	}
						}

						// Seleccionar alumnos
						if($seleccionar=="1"){
							// Si seleccionamos alumnos, se lo indicamos a poner_notas.php
							echo '<input name=seleccionar type=hidden value="1" />';
						}
						// Codigo Curso
						echo '<input name=curso type=hidden value="';
						echo $curs0;
						echo '" />';
						// Profesor
						echo '<input name=profesor type=hidden value="';
						echo $pr;
						echo '" />';
						// Asignatura.
						echo '<input name=asignatura type=hidden value="';
						echo $asignatura;
						echo '" />';
						if (empty($seleccionar)) {
							if(!(empty($div))){$curso_orig = $div;}else{$curso_orig = $curso;}
							mysqli_select_db($db_con, $db);
							$hay0 = "select alumnos from grupos where profesor='$pr' and (asignatura = '$asignatura' $extra_asig) and curso = '$curso_orig'";
							//echo $hay0."<br>";
							$hay1 = mysqli_query($db_con, $hay0);
							$hay = mysqli_fetch_row($hay1);
							$todos = "";
							if(mysqli_num_rows($hay1) == "1"){
								$seleccionados = substr($hay[0],0,strlen($hay[0])-1);
								$t_al = explode(",",$seleccionados);
								$todos = " and (nc = '300'";
								foreach($t_al as $cadauno){
									$todos .=" or nc = '$cadauno'";
								}
								$todos .= ")";
							}
						}

						// Alumnos para presentar que tengan esa asignatura en combasi
						$resul = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi, alma.unidad, alma.curso from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and alma.unidad = '$curso' and (";
						//Alumnos de 2º de Bachillerato
						if (strstr($nombre_curso,"Bach")==TRUE) {
							$resul.=" combasi like '%$asignatura1:%' or combasi like '%$asignatura2:%'";
							$fal_e =" FALTAS.codasi='$asignatura' or FALTAS.codasi='$asignatura2'";
						}
						elseif($asignatura=="21" or $asignatura=="2"){
								$resul.= " 1=1 ";
								$fal_e.= " 1=1 ";
						}
						else{
							$resul.=" combasi like '%$asignatura:%' ";
							$fal_e =" FALTAS.codasi='$asignatura' ";
						}
						$fal_e="($fal_e)";
						$resul.=") ". $todos ." order by NC ASC";
						//echo $resul;
						$result = mysqli_query($db_con, $resul);
						while($row = mysqli_fetch_array($result))
						{
							$n_fila2+=1;
							if ($n_fila2=="10" or $n_fila2=="20" or $n_fila2=="30" or $n_fila2=="40") {
								echo "<tr>";
								$col_col = "select distinct id, nombre, Tipo from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and (asignatura='$asignatura' $extra_asig)  and oculto = '0' order by orden asc";
								$col00 = mysqli_query($db_con, $col_col);
								
								if ($config['mod_asistencia']) { 
								echo "<td nowrap>
								<div style='width:40px;height:90px;'>
								<div class='Rotate-corto'>Asistencia</div>
								</div> </td>";
								}

								for ($i=1; $i < 4; $i++) { 
									if (${num_ev.$i}>0) {
									echo "<td nowrap>
									<div style='width:40px;height:90px;'>
									<div class='Rotate-corto'>".$i."ª Ev. Séneca</div>
									</div> </td>";
									}
								}

								while($col30 = mysqli_fetch_array($col00)){
									$tipo_col = $col30[2];
									
									if ($tipo_col=="Números") { $clase_col = "text-info";}elseif ($tipo_col=="Texto corto"){$clase_col = "text-success";}elseif ($tipo_col=="Texto largo"){$clase_col = "text-warning";}elseif ($tipo_col=="Casilla de verificación"){$clase_col = "text-danger";}elseif ($tipo_col=="Ponderacion"){$clase_col = "text-muted";}

									$nombre_col="";
									$nombre_col = $col30[1];
									if (strlen($nombre_col)>17) {
										$col_vert = substr($nombre_col,0,15)."..";
									}
									else {
										$col_vert = $nombre_col;
									}
									
									echo "<td nowrap>
<div style='width:40px;height:90px;'>
<div class='Rotate-corto'><span class='$clase_col text-lowercase' style='font-weight:normal'>$col_vert</span> </div>
</div> </td>";
								
								}
								if($seleccionar == 1){
									echo "<td nowrap class='warning'>
<div style='width:40px;height:90px;'>
<div class='Rotate-corto'></div>
</div> </td>";
								}

								echo "</tr>";
							}

							$claveal = $row[0];
							$nombre_al =   $row[3];
							$apellidos =   $row[2];
							$nc =   $row[1];
							$grupo_simple =  $row[6];
							if ($row[5] == "") {}
							else
							{
								echo "<tr>";
								?>
					<?php if ($config['mod_asistencia']) { ?>
					<td style='vertical-align: middle; height: 74px !important;'><?php 
					$faltaT_F = mysqli_query($db_con,"select falta from FALTAS where profesor = (select distinct no_prof from horw where prof ='$pr') and $fal_e and claveal='$claveal' and falta='F'");

					$faltaT_J = mysqli_query($db_con,"select falta from FALTAS where profesor = (select distinct no_prof from horw where prof ='$pr') and $fal_e and claveal='$claveal' and falta='J'");
					$f_faltaT = mysqli_num_rows($faltaT_F);
					$f_justiT = mysqli_num_rows($faltaT_J);
					?> <span class="label label-danger" data-bs='tooltip'
						title='Faltas de Asistencia en esta Asignatura'><?php if ($f_faltaT>0) {echo "".$f_faltaT."";}?></span>
						<?php
						if ($f_faltaT>0) {echo "<br>";}
						?> <span class="label label-info" data-bs='tooltip'
						title='Faltas Justificadas'><?php if ($f_faltaT>0) {echo "".$f_justiT."";}?></span>
					</td>
					<?php } ?>
					<?php
						for ($i=1; $i < 4; $i++) { 
									if (${num_ev.$i}>0 and $asignatura!=="2") {
									?>
					<td style="background-color:#444;color:#fff;vertical-align: middle; text-align: center; height: 74px !important;">
					<?php
					${seneca.$i} = mysqli_query($db_con, "select notas".$i." from notas where claveal = (select claveal1 from alma where claveal = '$claveal')");
					${dato_seneca.$i} = mysqli_fetch_array(${seneca.$i});
					$tr_n = explode(";", ${dato_seneca.$i}[0]);
					foreach ($tr_n as $value) {
						
							$tr_d = explode(":", $value);
							if ($tr_d[0]==$asignatura or $tr_d[0]==$asignatura2) {
								$califica = "select nombre from calificaciones where codigo = '" . $tr_d[1] . "'";
								$calificacion = mysqli_query($db_con, $califica);
								$rown = mysqli_fetch_array($calificacion);
								echo $rown[0];
							}
						}	
					?>	
					</td>
					<?php
								}
							}

					// Si hay datos escritos rellenamos la casilla correspondiente
					$colu10 = "select distinct id, Tipo, color, nombre from notas_cuaderno where profesor = '$pr' and curso like '%$curso%' and (asignatura = '$asignatura' $extra_asig) and oculto = '0' order by orden";
					$colu20 = mysqli_query($db_con, $colu10);
					while($colus10 = mysqli_fetch_array($colu20)){
						$id = $colus10[0];
						$t_dato = $colus10[1];
						$color_dato = $colus10[2];
				
						$tr_pond= explode(":",$colus10[3]);
						$id_pond_col=str_replace(" ","",$tr_pond[1]);
						$pond_extra="";
						
						$dato0 = mysqli_query($db_con, "select nota, ponderacion from datos where claveal = '$claveal' and id = '$id'");
						$dato1 = mysqli_fetch_array($dato0);

						if (stristr($t_dato,"Casilla")==TRUE) {
							$tipo_dato = "<div class='checkbox'><input type='checkbox' name='$id-$claveal' value='1' ";
							if ($dato1[0]==1) {
								$tipo_dato.=" checked ";
							}
							$tipo_dato.=" /></div>";
						}
						elseif (stristr($t_dato,"Número")==TRUE) {

							$tipo_dato = "<input type='number' step='any'  name='$id-$claveal' value='$dato1[0]' data-bs='tooltip' title='$dato1[0]' style='max-width:40px;height:60px;border:none;background-color:$color_dato'>";
						}
						elseif (stristr($t_dato,"Texto corto")==TRUE) {
							$tipo_dato = "<input type='text' name='$id-$claveal' value='$dato1[0]' data-bs='tooltip' title='$dato1[0]' style='width:100%;margin:0px;height:60px;maxlength:3;max-width:40px;border:none;background-color:$color_dato'>";
						}
						elseif (stristr($t_dato,"Ponderacion")==TRUE) {
							$tipo_dato = "<input type='number' name='$id-$claveal' value='$dato1[0]' data-bs='tooltip' title='$dato1[0]' style='max-width:40px;height:60px;border:none;background-color:$color_dato;color:#FFF' disabled>";
							$pond_extra=" onmouseover='cambia_color($id_pond_col)' onmouseout='descambia_color($id_pond_col)'";
						}
						else{
							$tipo_dato = "<textarea name='$id-$claveal' data-bs='tooltip' title='$dato1[0]' style='height:67px;width:80px;font-size:10px;max-width:250px;border:none;max-height:68px !important;background-color:$color_dato'>$dato1[0]</textarea>";
						}

						echo "<td id='$id' style='vertical-align:middle; text-align:center;margin:0px;padding:0px;width:auto;height:74px !important;background-color:$color_dato' $pond_extra>$tipo_dato</td>";

					}
							}
							// Casilla para seleccionar alumnos
							if($seleccionar == "1")
							{
								if(!(empty($div))){$curso_orig = $div;}else{$curso_orig = $grupo_simple;}
								$grupos2 = "select alumnos from grupos where profesor = '$pr' and curso = '$curso_orig' and (asignatura = '$asignatura' $extra_asig)";
								$marcado = "";
								$grupos0 = mysqli_query($db_con, $grupos2);
								$grupos1 = mysqli_fetch_array($grupos0);
								$sel = explode(",",$grupos1[0]);
								foreach($sel as $nc_sel){if($nc_sel == $nc)
								{
									$marcado = "1";
								}
								}
								if(!(empty($div))){$curso = $div;}
								?>
					<td  class='warning'
						style="vertical-align: middle; text-align: center; height: 74px !important;">
					<div class="checkbox"><input
						name="select_<?php echo $row[1]."_".$curso;?>" type="checkbox"
						id="selal" <?php if ($marcado == "1") {echo "checked ";}?> value="1" /></div>
					</td>
					<?php
							}

							echo "</tr>";
						}
					}
					$num_col+=1;
					// Datos ocultos

					// Asignatura.
					echo '<input name=asignatura type=hidden value="';
					echo $asignatura;
					echo '" />';
					// Nombre Asignatura.
					echo '<input name=nom_asig type=hidden value="';
					echo $nom_asig;
					echo '" />';
					// Día.
					echo '<input name=dia type=hidden value="';
					echo $dia;
					echo '" />';
					// Hora.
					echo '<input name=hora type=hidden value="';
					echo $hora;
					echo '" />';

					?>
			
			</table>
			</div>
			</td>
		</tr>

</table>
<div align="center" class="hidden-print"><input name="enviar"
	type="submit" value="Enviar datos" class="btn btn-primary" /></div>
</FORM>
					<?php

					$colum24= "select distinct id, nombre, orden from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and (asignatura='$asignatura' $extra_asig) order by orden asc";
					$colu = mysqli_query($db_con, $colum24);
					?></div>
</div>
</div>
</div>
					<?php include("pie.php");?>
<script type="text/javascript">

/*Desactivar rueda del ratón en campos numéricos*/

$('form').on('focus', 'input[type=number]', function (e) {
$(this).on('mousewheel.disableScroll', function (e) {
e.preventDefault()
})
})
$('form').on('blur', 'input[type=number]', function (e) {
$(this).off('mousewheel.disableScroll')
})	
</script>

<script type="text/javascript">

/*Modificar función de la tecla Intro para desplazarse por columna de datos*/

$('table input').keypress(function(e) {
    if (e.keyCode == 13) {
        var $this = $(this),
            index = $this.closest('td').index();

        $this.closest('tr').next().find('td').eq(index).find('input').focus();
        $this.closest('tr').next().find('td').eq(index).find('input').select();
        e.preventDefault();
    }
});
</script>
</body>
</html>
