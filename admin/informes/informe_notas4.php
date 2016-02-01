<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>
<br />
<div align="center" style="width:auto;margin:auto;">
<div class="page-header">
  <h2>Informe de Evaluaciones <small> Estadísticas de Calificaciones</small></h2>
</div>

<?php
if (isset($_POST['f_curso'])) {
	$f_curso=$_POST['f_curso'];
}

if (file_exists(INTRANET_DIRECTORY . '/config_datos.php')) {

	if (!empty($f_curso) && ($f_curso != $config['curso_actual'])) {
		$exp_c_escolar = explode("/", $f_curso);
		$anio_escolar = $exp_c_escolar[0];
		
		$db_con = mysqli_connect($config['db_host_c'.$anio_escolar], $config['db_user_c'.$anio_escolar], $config['db_pass_c'.$anio_escolar], $config['db_name_c'.$anio_escolar]);
	}
	if (empty($f_curso)){
		$f_curso = $config['curso_actual'];
	}
}
else {
		$f_curso = $config['curso_actual'];
}
?>

<?php if (file_exists(INTRANET_DIRECTORY . '/config_datos.php')): ?>
<form method="POST" class="well well-large" style="width:450px; margin:auto">
<p class="lead">Informe Histórico</p>	
  	<div class="form-group">
  			    <label for="f_curso">Curso escolar</label>
  			    
  			    <select class="form-control" id="f_curso" name="f_curso" onChange="submit()">
  			    	<?php $exp_c_escolar = explode("/", $config['curso_actual']); ?>
  			    	<?php for($i=0; $i<5; $i++): ?>
  			    	<?php $anio_escolar = $exp_c_escolar[0] - $i; ?>
  			    	<?php $anio_escolar_sig = substr(($exp_c_escolar[0] - $i + 1), 2, 2); ?>
  			    	<?php if($i == 0 || (isset($config['db_host_c'.$anio_escolar]) && $config['db_host_c'.$anio_escolar] != "")): ?>
  			    	<option value="<?php echo $anio_escolar.'/'.$anio_escolar_sig; ?>"<?php if ($_POST['f_curso']==$anio_escolar.'/'.$anio_escolar_sig) { echo "selected"; }?>><?php echo $anio_escolar.'/'.$anio_escolar_sig; ?></option>
  			    	<?php endif; ?>
  			    	<?php endfor; ?>
  			    </select>
  	</div>
</form>
<hr />  	
<?php endif; ?>
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs"  style="max-width:980px">
<li class="active"><a href="#tab1" data-toggle="tab">1ª Evaluación</a></li>
<li><a href="#tab2" data-toggle="tab">2ª Evaluación</a></li>
<li><a href="#tab3" data-toggle="tab">Evaluación Ordinaria</a></li>
</ul>

<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<br>
<?php 
// Comprobamos datos de evaluaciones
$n1 = mysqli_query($db_con, "select * from notas where notas1 not like ''");
if(mysqli_num_rows($n1)>0){}
else{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administración de la Intranet --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
	exit();
}
?>


<?php
$titulos = array("1"=>"1ª Evaluación","2"=>"2ª Evaluación","3"=>"Evaluación Ordinaria");
foreach ($titulos as $key=>$val){

// Tabla temporal.
 $crea_tabla2 = "CREATE TABLE  `temp2` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`claveal` VARCHAR( 12 ) NOT NULL ,
`asignatura` INT( 8 ) NOT NULL ,
`nota` TINYINT( 2 ) NOT NULL ,
INDEX (  `claveal` )
) ENGINE = MyISAM";
 mysqli_query($db_con, $crea_tabla2); 
 mysqli_query($db_con, "ALTER TABLE  `temp2` ADD INDEX (  `asignatura` )");
	$key == '1' ? $activ=" active" : $activ='';
?>
<div class="tab-pane fade in<?php echo $activ;?>" id="<?php echo "tab".$key;?>">
<?php
// Evaluaciones ESO
$nivele = mysqli_query($db_con, "select distinct curso from alma order by curso");
while ($orden_nivel = mysqli_fetch_array($nivele)){
$niv = mysqli_query($db_con, "select distinct curso from alma where curso = '$orden_nivel[0]'");
while ($ni = mysqli_fetch_array($niv)) {
	$n_grupo+=1;
	$curso = $ni[0];
	$rep = ""; 
	$promo = "";
$notas1 = "select notas". $key .", claveal1, matriculas, unidad, curso from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.curso = '$curso'";
//echo $notas1."<br>";

$result1 = mysqli_query($db_con, $notas1);
$todos = mysqli_num_rows($result1);
if ($todos < '1') {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:920px">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones del Curso <strong class=text-danger>'.$curso.'</strong>. 
          </div></div>';
}
while($row1 = mysqli_fetch_array($result1)){
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$claveal = $row1[1];
$grupo = $row1[3];
$nivel_curso = $row1[4];
if ($row1[2]>"1") {
	$pil = "1";
}
else{
	$pil = '0';
}
$trozos1 = explode(";", $asignatura1);
$num = count($trozos1);
$susp="";
 for ($i=0;$i<$num; $i++)
  {
$bloque = explode(":", $trozos1[$i]);
$nombreasig = "select nombre from calificaciones where codigo = '" . $bloque[1] . "'";
$asig = mysqli_query($db_con, $nombreasig);
$cali = mysqli_fetch_row($asig);
if($cali[0] < '5' and !($cali[0] == ''))	{
	$susp+=1; 
	}
		mysqli_query($db_con, "insert into temp2 values('','$claveal','$bloque[0]','$cali[0]')");
	}
	}
}
}
?>
<h3>Resultados de los Alumnos por Materias / Nivel / Grupo:</h3>
<span class="help-block"> ( * ) En color <strong class="text-success">verde</strong> los aprobados; en color <strong class="text-warning">naranja</strong> los suspensos</span>
<br />
<?php
$nivele = mysqli_query($db_con, "select distinct curso from alma order by curso");
while ($orden_nivel = mysqli_fetch_array($nivele)){
?>
<legend><?php echo $orden_nivel[0]; ?></legend>
<table class="table table-striped table-condensed table-bordered"  align="center" style="width:700px;" valign="top">
<tr><th></th>
<?php
$sql_asig = "select distinct unidad from alma where curso = '$orden_nivel[0]' order by unidad";
$query_asig = mysqli_query($db_con, $sql_asig);
while ($a_asig = mysqli_fetch_array($query_asig)) {
echo '<th colspan="2" style="text-align:center">'.$a_asig[0].'</th>';
}
echo "</tr>";

$sql = "select distinct asignaturas.nombre, asignaturas.codigo, abrev from asignaturas, profesores where profesores.materia = asignaturas.nombre
 and asignaturas.curso = '$orden_nivel[0]' and abrev not like '%\_%' and asignaturas.codigo not in 
(select distinct asignaturas.codigo from asignaturas where asignaturas.nombre like 'Libre Disp%') order by asignaturas.nombre";
//echo $sql;	
$as = mysqli_query($db_con, $sql);
while ($asi = mysqli_fetch_array($as)) {
?>
<?php
	$nomasi = $asi[0];
	$codasi = $asi[1];
	$abrev = $asi[2];
	echo "<tr><th nowrap>$abrev</th>";
	
$sql_asig = "select distinct unidad from alma where curso = '$orden_nivel[0]' order by unidad";
$query_asig = mysqli_query($db_con, $sql_asig);
while ($a_asig = mysqli_fetch_array($query_asig)) {	
	$unidad = $a_asig[0];
	$cod_nota = mysqli_query($db_con, "select id from temp2, alma where asignatura = '$codasi' and nota < '5' and alma.claveal1 = temp2.claveal and unidad = '$unidad'");
	//echo "select id from temp2, alma where asignatura = '$codasi' and nota < '5' and alma.claveal1 = temp.claveal and unidad = '$unidad'";
	$cod_apro = mysqli_query($db_con, "select id from temp2, alma where asignatura = '$codasi' and nota > '4' and alma.claveal1 = temp2.claveal and unidad = '$unidad'");
	
	//echo "select id from temp2 where asignatura = '$codasi'<br>";
	$num_susp='';
	$num_susp = mysqli_num_rows($cod_nota);

	$num_apro='';
	$num_apro = mysqli_num_rows($cod_apro);
	
	$combas = mysqli_query($db_con, "select claveal from alma where combasi like '%$codasi%' and unidad = '$unidad'");
	//echo "select claveal from alma where combasi like '%$codasi%' and unidad = '$unidad'<br>";
	$num_matr='';
	$num_matr = mysqli_num_rows($combas);
	
	$porcient_asig = ($num_susp*100)/$num_matr;
	$porciento_asig='';
	$porciento_susp='';
	if ($porcient_asig > 0) {
			$porciento_susp = "<span class='text-warning'>".substr($porcient_asig,0,4)."% </span><span class=''> (".$num_susp.")</span>";
	}
		
	$porcient_asig2 = ($num_apro*100)/$num_matr;
	$porciento_asig2='';
	$porciento_apro='';
	if ($porcient_asig2 > 0) {
	$porciento_apro = "<span class='text-success'>".substr($porcient_asig2,0,4)."% </span><span class=''> (".$num_apro.")</span>";
	}
	//echo "<td>$num_matr</td>";
	echo "<td nowrap>".$porciento_susp."</td><td nowrap>$porciento_apro </td>";
	

}
echo "</tr>";
}
?>
</table>
<hr />
<br />
<?php
}

?>
</div>
<?php
mysqli_query($db_con, "drop table temp2");
}
?>
</div>
</div>
</div>
</div>

<?php include("../../pie.php");?>

</body>
</html>
