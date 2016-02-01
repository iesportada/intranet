<?php
require('../../bootstrap.php');

require_once("../../pdf/dompdf_config.inc.php"); 
foreach($_GET as $key => $val)
{
	${$key} = $val;
}
$html="<html><head>
<meta charset='iso-8859-1'>";
$html.="<style>
html {
  font-family: sans-serif;
  font-size:16px;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
}
  .table {
    border-collapse: collapse !important;
  	width: auto;
  }
  .table td
  {
    background-color: #fff !important;
    padding:5px 8px;
  }
  .table th {
    background-color: #fff !important;
    padding:8px -3px;
    margin:0px;
  }
  .table-bordered td {
    border: 1px solid #ddd !important;
  }
  .Rotate-90
{
  -webkit-transform: rotate(-80deg);
  -moz-transform: rotate(-80deg);
  -ms-transform: rotate(-80deg);
  -o-transform: rotate(-80deg);
  transform: rotate(-80deg);
  font-size: 10px;
  width:30px;
  position:relative;
  top:30px;
}
</style>";
$html.="</head>";
$html.="<body>";
foreach ($_GET as $id => $valor) {
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
$num_ids = count($_GET)-6;
$n_c = mysqli_query($db_con, "SELECT distinct  a_grupo, asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'");
while($varias = mysqli_fetch_array($n_c))
{
	if (substr($varias[0],3,2) == "Dd" ) {
		$varias[0] = substr($varias[0],0,4);
	}
	$asigna_col = $varias[1];
	$curso_alma = mysqli_query($db_con, "select distinct curso from alma where unidad = '$varias[0]'");
	$curso_alma1 = mysqli_fetch_row($curso_alma);
	$nombre_curso = $curso_alma1[0];
	$largo = strlen($varias[1]);
	if (strlen($varias[1]) > 10) {$nombre_asig = substr($varias[1],0,10);} else {$nombre_asig = substr($varias[1],0,6);}
	$nombre_asig = trim($nombre_asig);
	$asig_sen0 = mysqli_query($db_con, "select codigo from asignaturas where curso = '$nombre_curso' and nombre like '$nombre_asig%' and abrev not like '%º'");
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
$n_cursos = mysqli_query($db_con, "SELECT distinct  a_grupo, c_asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'");
while($n_cur = mysqli_fetch_array($n_cursos))
{
	$curs .= $n_cur[0].", ";
}
$curs0 = substr($curs,0,(strlen($curs)-1));
$curso_sin = substr($curs0,0,(strlen($curs0)-1));
$col = "select distinct id, nombre, orden from notas_cuaderno where profesor = '$profesor' and curso like '%$curso%' and oculto = '0' and ($celdas)  order by orden asc";
$col0 = mysqli_query($db_con, $col);
$curso_sin = substr($curso,0,strlen($curso) - 1);
$html.="<h2 align='center'>$asigna_col</h2><h4 align='center'>$nombre_curso</h4><br>";
$html.="<table align='center' class='table table-bordered'>";
$html.="<tr><th style='background-color:#fff' colspan='3' align='center'></th>";
while($col20 = mysqli_fetch_array($col0)){
	$ident= $col20[2];
	$id = $col20[0];
	$nombre_col=$col20[1];
if (strlen($nombre_col)>12) {
	$nombre_col=str_replace( ".", "",$nombre_col);
	$tr_col = explode(" ",$nombre_col);
	$col_vert = substr($tr_col[0],0,2).". ".substr($tr_col[1],0,2).". ".substr($tr_col[2],0,2).".";						}
else {
	$col_vert = "".$nombre_col;
						}
	$html.="<th nowrap style='text-align:left;'>
<div style='width:30px;height:40px;'>
<div class='Rotate-90'>$col_vert</div>
</div> </th>";		
}
$html.="</tr>";
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
	//	Problemas con Diversificaci�n (4E-Dd)
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
	$resul = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and alma.unidad = '$curso' and (combasi like '%$asignatura0:%' $otras) ".$todos ." order by NC";
	$result = mysqli_query($db_con, $resul);
	$t_alumnos += mysqli_num_rows ($result);
	while($row = mysqli_fetch_array($result))
	{
		$claveal = $row[0];
		$n_nombre="$row[2], $row[3]";
	if (strlen($n_nombre) > 30) {
			$n_nombre = substr($n_nombre,0,30).".";
						}
		$html.="<tr><td >$row[1]</td><td colspan='2' style='width:120px' nowrap>$n_nombre</td>";			
		// Si hay datos escritos rellenamos la casilla correspondiente
		$colu10 = "select distinct id from notas_cuaderno where ";
	 foreach ($_GET as $id => $valor) {
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
	 	$html.="<td>$dato1[0]</td>";
	 }
	 $html.="</tr>";
	}
}
$html.="</table></body></html>";
$content = mb_convert_encoding($html, 'UTF-8', 'ISO-8859-1');
$dompdf = new DOMPDF();
$dompdf->load_html($content);
$dompdf->render();
$dompdf->stream("cuaderno.pdf", array("Attachment" => 0));
?>
