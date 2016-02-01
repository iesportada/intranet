<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

//variables();
if(isset($_POST['pondera']) and $_POST['pondera']=="Guardar resultado como columna"){
	//variables();
	foreach ($_POST as $key => $val) {
		if(is_numeric($key) and strlen($key)<5){
			$id_cols.="$key, ";
		}
	}
	$id_cols=substr($id_cols, 0, -2);
	$pr = $_SESSION['profi'];
	$fecha = date('Y-m-d');
	$asignatura=$_POST['asignatura'];
	$curso=$_POST['curso'];
	$texto="Ponderacion de columnas: $id_cols";
	$nombre="Ponderación de columnas: $id_cols";
	$tipo="Ponderacion";
	
	//echo "select max(orden) from notas_cuaderno where profesor = '$pr' and curso like '$curso%' and asignatura = '$asignatura'";
	
	$serie = mysqli_query($db_con, "select max(orden) from notas_cuaderno where profesor = '$pr' and curso like '".rtrim($curso, ', ')."%' and asignatura = '$asignatura'");
	$num_col = mysqli_fetch_array($serie);
	$orden = $num_col[0] + 1;

	$sql = "INSERT INTO  notas_cuaderno ( profesor ,  fecha ,  nombre ,  texto ,  asignatura, curso, orden, Tipo, color )
VALUES ( '$pr',  '$fecha',  '$nombre',  '$texto',  '$asignatura', '$curso', '$orden', '$tipo', '#555')";
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La nueva columna ha sido añadida a la tabla del Cuaderno.
</div></div>';
	mysqli_query($db_con, $sql) or die (mysqli_error($db_con));

	$id_col = mysqli_query($db_con, "select id from notas_cuaderno where profesor = '$pr' and curso like '$curso%' and asignatura = '$asignatura' and nombre = '$nombre'");
	$num_col = mysqli_fetch_array($id_col);
	foreach ($_POST as $key=>$val){
		if (strlen($key)>5 and is_numeric($key)) {
			$claveal_pond = $key;
			$insert = "insert into datos (id, claveal, nota, ponderacion) values ('$num_col[0]','$claveal_pond','$val','1')";
			$insert0 = mysqli_query($db_con, $insert);
		}
	}
	
}

if(isset($_POST['recalcula'])){
	//variables();
	if (is_numeric($id) and is_numeric($valor)){
		$upd=mysqli_query($db_con, "update datos set ponderacion='$valor' where id='$id'") or die ("error update ponderacion");
	}
}
?>
<form action="editar.php" method="POST" id="editar"><?php
// Codigo Curso
echo '<input name=curso type=hidden value="';
echo $curso;
echo '" />';
// Profesor
echo '<input name=profesor type=hidden value="';
echo $profesor;
echo '" />';
// Asignatura.
echo '<input name=asignatura type=hidden value="';
echo $asignatura;
echo '" />';
// Día.
echo '<input name=dia type=hidden value="';
echo $dia;
echo '" />';
// Hora.
echo '<input name=hora type=hidden value="';
echo $hora;
echo '" />';
echo '<input name=nom_asig type=hidden value="';
echo $nom_asig;
echo '" />';

$volver="../cuaderno.php?dia=$dia&hora=$hora&curso=$curso&asignatura=$asignatura&nom_asig=$nom_asig";
$nums_ids=0;
$sum='';
foreach ($_POST as $id => $valor) {
	if (is_numeric($id) and strlen($id)<5){
		$columnas = $columnas + 1;
		$num_ids +=1;
		$celdas .= " id = '$id' or";
		$upd=mysqli_query($db_con, "update datos set ponderacion='$valor' where id='$id'");
		$t='La ponderaci&oacute;n usada es '.$valor;
		$upd1=mysqli_query($db_con, "update notas_cuaderno set texto_pond='$t' where id='$id'") or die ("error notas_cuaderno");
		$sum += $valor;
	}
}
$celdas = substr($celdas,0,strlen($celdas)-3);

$num_ids = count($_POST)-6;
if (empty($num_ids)) {
	echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar al menos una Columna del cuaderno para poder operar.
</div></div>';
	echo "<INPUT TYPE='button' VALUE='Volver al Cuaderno' onClick='history.back(-1)' class='btn btn-primary'>";
	exit;
}
// Procesamos los datos
// Distintos cÃ³digos de la asignatura cuando hay varios grupos en una hora.
$n_c = mysqli_query($db_con, "SELECT distinct  a_grupo, asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'");
while($varias = mysqli_fetch_array($n_c))
{
	if (substr($varias[0],3,2) == "Dd" ) {
		$varias[0] = substr($varias[0],0,4);
	}
	$curso_alma = mysqli_query($db_con, "select distinct curso from alma where unidad = '$varias[0]'");
	$curso_alma1 = mysqli_fetch_row($curso_alma);
	$nombre_curso = $curso_alma1[0];
	$largo = strlen($varias[1]);
	if (strlen($varias[1]) > 10) {$nombre_asig = substr($varias[1],0,10);} else {$nombre_asig = substr($varias[1],0,6);}
	$nombre_asig = trim($nombre_asig);
	$asig_sen0 = mysqli_query($db_con, "select codigo from asignaturas where curso = '$nombre_curso' and nombre like '$nombre_asig%' and abrev not like '%\_%'");
	while($asig_sen1 = mysqli_fetch_row($asig_sen0)){
		if (strstr($asigna_a , $asig_sen1[0]) == false)
		{
			$asigna_a .= $asig_sen1[0].",";
		}
	}
}
$asigna_c = explode(",",$asigna_a);
$asignatura0 = $asigna_c[0];
$asignatura1 = $asigna_c[1];
$asignatura2 = $asigna_c[2];
if (!(empty($asignatura1))) {
	$otras = " or combasi like '%$asignatura1:%' ";
}
if (!(empty($asignatura2))) {
	$otras .= " or combasi like '%$asignatura2:%' ";
}
// Tabla con las distintas notas_cuaderno y la media

// Todos los Grupos juntos
$n_cursos = mysqli_query($db_con, "SELECT distinct  a_grupo, c_asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'");
while($n_cur = mysqli_fetch_array($n_cursos))
{
	$curs .= $n_cur[0].", ";
}

// Eliminamos la última coma para el título.
$curso_sin = rtrim($curs, ', ');

//Número de columnas

$col = "select distinct id, nombre, orden from notas_cuaderno where profesor = '$profesor' and curso like '%$curso_sin%' and oculto = '0' and ($celdas)  order by orden asc";
$col0 = mysqli_query($db_con, $col);

echo "<table align='center' class='table table-striped' style='width:auto'>";
echo "<thead><th style='background-color:#fff'>NC</th><th style='background-color:#fff' colspan='2' align='center'>Alumno</th>";
// Número de las columnas de la tabla
while($col20 = mysqli_fetch_array($col0)){
	$ident= $col20[2];
	$id = $col20[0];
	$nombre_col=$col20[1];
	
if (strlen($nombre_col)>23) {
	$col_vert = "&nbsp;&nbsp;".substr($nombre_col,0,20)."...<br>&nbsp;&nbsp;&nbsp;<span  data-bs='tooltip' title='Número de la Columna'>".$ident."</span>";
						}
else {
	$col_vert = "&nbsp;&nbsp;".$nombre_col."<br>&nbsp;&nbsp;&nbsp;<span  data-bs='tooltip' title='Número de la Columna'>".$ident."</span> ".$orden_ponde;
						}
	echo "<th nowrap style='background-color:#fff'>
<div style='width:40px;height:100px;'>
<div class='Rotate-90'><span class='text-info text-lowercase'>$col_vert</span> </div>
</div> </th>";	
}
echo "<th nowrap style='background-color:#fff'>
<div style='width:40px;height:100px;'>
<div class='Rotate-90'><span class='text-warning text-lowercase'>Media Ponderada</span> </div>
</div> </th></thead>";

// Tabla para cada Grupo
$curso0 = "SELECT distinct  a_grupo, c_asig, asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'";
$curso20 = mysqli_query($db_con, $curso0);
while ($curso11 = mysqli_fetch_array($curso20))
{
	$curso = $curso11[0];
	$asignatura = $curso11[1];
	$nombre = $curso11[2];
	// Número de Columnas para crear la tabla
	$num_col = 4 + $num_ids;
	$nivel_curso = substr($curso,0,1);
	//	Problemas con Diversificación (4E-Dd)
	$profe_div = mysqli_query($db_con, "select * from profesores where grupo = '$curso'");
	if (mysqli_num_rows($profe_div)<1) {

		$div = $curso;
		$grupo_div = mysqli_query($db_con, "select distinct unidad from alma where unidad like '$nivel_curso%' and (combasi like '%25204%' or combasi LIKE '%25226%' OR combasi LIKE '%135785%')");
		$grupo_diver = mysqli_fetch_row($grupo_div);
		$curso = $grupo_diver[0];
	}
	mysqli_select_db($db_con, $db);
	$hay0 = "select alumnos from grupos where profesor='$profesor' and asignatura = '$asignatura' and curso = '$curso'";
	$hay1 = mysqli_query($db_con, $hay0);
	$hay = mysqli_fetch_row($hay1);

	if(mysqli_num_rows($hay1) == "1"){


		$seleccionados = substr($hay[0],0,strlen($hay[0])-1);

		$t_al = explode(",",$seleccionados);
		$todos = " and (nc = '300'";
		foreach($t_al as $cadauno){
			$todos .=" or nc = '$cadauno'";
		}
		$todos .= ")";
	}
	mysqli_select_db($db_con, $db);

	$mediaaprobados=0;
	$mediasuspensos=0;
	$mediatotal=0;

	// Alumnos para presentar que tengan esa asignatura en combasi
	$resul = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and alma.unidad = '$curso' and (combasi like '%$asignatura0:%' $otras) ".$todos ." order by NC";
	$result = mysqli_query($db_con, $resul);
	$t_alumnos += mysqli_num_rows ($result);
	while($row = mysqli_fetch_array($result))
	{
		$claveal = $row[0];
		echo "<tr><td >$row[1]</td><td colspan='2' nowrap>$row[2], $row[3]</td>";
			
		// Si hay datos escritos rellenamos la casilla correspondiente
		$colu10 = "select distinct id from notas_cuaderno where ";
	 foreach ($_POST as $id => $valor) {
	 	if (is_numeric($id) and strlen($id)<5){
	 		$colu10 .= " id = '$id' or";
	 		$n_1 = "1";
	 	}
	 }


	 $colu10 = substr($colu10,0,strlen($colu10)-2);
	 $colu10 .= "  and profesor = '$profesor' and curso like '%$curso%' and oculto = '0'order by id";
	 $colu20 = mysqli_query($db_con, $colu10);
	 $suma = "";

	 while($colus10 = mysqli_fetch_array($colu20)){
	 	$id = $colus10[0];
	 	$dato0 = mysqli_query($db_con, "select nota,ponderacion from datos where claveal = '$claveal' and id = '$id'");
	 	$dato1 = mysqli_fetch_array($dato0);
	 	$suma += $dato1[0]*$dato1[1];
	 	if($dato1[0]==''){$dato1[0]='0';}
	 	echo "<td align='center'>$dato1[0]</td>";

	 }
	 $media = $suma / $sum;
	 $mediatotal+=$media;
	 if ($media<>0){
	 	if($media < 5 ){$mediasuspensos+=1;}
	 	else{$mediaaprobados+=1; }
	 }
	 echo "<td align='center' class='text-warning' style='font-weight:bold; background-color:#eee'>";
	 if ($media == "" ) {
	 	$media = "0";
	 }

	 $media_pond = media_ponderada($media);
	 echo "<input type='number' name='$claveal' value='$media_pond' style='max-width:50px;border:none; background-color:#eee' readonly>";
	 echo "</td>";
	 mysqli_select_db($db_con, $db);
	 echo "</tr>";
	}
	$toti+=$mediatotal;
	$m_sus+=$mediasuspensos;
	$m_ap+=$mediaaprobados;
}
$i=0;
foreach ($_POST as $id => $valor2) {
	if (is_numeric($id) and strlen($id)<5){
		$i+=1;
		$aprobados[$i]=0;
		$suspensos[$i]=0;
		$sumanotas[$i]=0;

		$est=mysqli_query($db_con, "select nota from datos where id='$id'");
		while ($esta=mysqli_fetch_array($est)){
			if(($esta[0] < 5) or (empty ($esta[0]))){$suspensos[$i]+=1;  $sumanotas[$i]+=$esta[0];}
			else{$aprobados[$i]+=1;     $sumanotas[$i]+=$esta[0];}
		}
	}}
	//media del grupo
	echo "<tr class='info'><td align='left' colspan='3' style='font-weight:bold;'>Media del Grupo</td>";
	for($j = 1;$j<=$i;$j++) {
		$x=$sumanotas[$j]/($aprobados[$j]+$suspensos[$j]);
		$x_total=$sumanotas[$j]/$t_alumnos;
		echo "<td align='center'>"; redondeo($x_total);  echo"</td>";
	}
	$fin_total=$toti/$t_alumnos;
	$fin=$toti/($m_ap+$m_sus);
	echo "<td style='font-weight:bold'>"; redondeo($fin_total); echo"</td>";

	//aprobados
	echo "</tr><tr class='success'><td colspan='3' align='left' style='font-weight:bold;'>Aprobados</td>";
	for($j = 1;$j<=$i;$j++) {
		echo "<td align='center'>$aprobados[$j]</td>";
		$pap=($m_ap/($t_alumnos))*100;
	}
	echo "<td style='font-weight:bold'>$m_ap -> "; redondeo($pap);  echo"%</td>";


	//suspensos
	echo "</tr><tr class='danger'><td colspan='3' style='font-weight:bold;'>Suspensos</td>";
	for($j = 1;$j<=$i;$j++) {
		$t_s1=$t_alumnos-$aprobados[$j];
		echo "<td align='center'>$t_s1</td>";
		$t_s= $t_alumnos - $m_ap;
		$psus=($t_s/($t_alumnos))*100;

	}
	echo "<td align='center' style='font-weight:bold'>$t_s -> "; redondeo($psus);  echo"%</td>";
	echo "</tr>";

	echo '</table>';
	?> <br />
<legend>Cambiar la ponderaci&oacute;n de las notas</legend> <?php
$nid='';
$name="";
foreach ($_POST as $id => $valor) {

	if (is_numeric($id) and strlen($id)<5){  $nid.=  " id = '$id' or";
	$name=$name. $id.' ';
	}
}
$nid = substr($nid,0,strlen($nid)-2);
$colum= "select distinct id, nombre, orden, oculto from notas_cuaderno where". $nid." order by orden asc";
$colum0 = mysqli_query($db_con, $colum);
if (mysqli_num_rows($colum0) > 0) {
	echo "<table align='center' class='table table-striped table-bordered' style='width:auto'>";
	echo "<tr><th colspan='2'>Columnas</th><th>Ponderaci&oacute;n</th>";
}
while ($colum1 = mysqli_fetch_array($colum0)) {
	$pon=mysqli_query($db_con, "select distinct ponderacion from datos where id='$colum1[0]'");
	$pon0=mysqli_fetch_array($pon);
	$n_col = $colum1[2];
	$id = $colum1[0];
	$nombre = $colum1[1];
	$oculto = $colum1[3];
	$pond= $pon0[0];
	$mens0 = "../cuaderno/c_nota.php?profesor=$pr&curso=$curs0&dia=$dia&hora=$hora&id=$id&orden=$ident";
	echo "<tr><td><a href='$mens0'>$n_col</a></td><td><a href='$mens0'>$nombre</td></a>";
	?> <?php
	echo"<td align='center'><input type=input name='$colum1[0]' value='$pon0[0]' class='form-control' style='color:$color;'/></td>";
	echo "</tr>";

}
echo "</table>";

?> <br />
<input name="recalcula" type="submit" value="Cambiar Ponderaci&oacute;n"
	class="btn btn-default" /> <input name="pondera" type="submit"
	value="Guardar resultado como columna" class="btn btn-info" /><br>
<br>

</form>

