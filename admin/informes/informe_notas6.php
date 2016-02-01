<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>
<br />
<div align="center" style="max-width:980px;margin:auto;">
<div class="page-header">
  <h2>Informe de Evaluaciones <small> Estadísticas de Calificaciones</small></h2>
</div>

<?php
?>
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">1ª Evaluación</a></li>
<li><a href="#tab2" data-toggle="tab">2ª Evaluación</a></li>
<li><a href="#tab3" data-toggle="tab">Evaluación Ordinaria</a></li>
</ul>

<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<?php 
// Comprobamos datos de evaluaciones
$n1 = mysqli_query($db_con, "select * from pendientes");
if(mysqli_num_rows($n1)>0){}
else{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de alumnos con asignaturas pendientes en la Base de datos. Debes primero importar los datos de los pendientes a través de la página de Administración de la Intranet. Sigue las instrucciones del enlace para la importación.
          </div></div>';
	exit();
}
?>


<?php
$titulos = array("1"=>"1ª Evaluación","2"=>"2ª Evaluación","3"=>"Evaluación Ordinaria");
foreach ($titulos as $key=>$val){
	
// Creamos la tabla en cada evaluación
 $crea_tabla = "CREATE TABLE IF NOT EXISTS `suspensos3` (
  `claveal` varchar(12) NOT NULL,
  `suspensos` tinyint(4) NOT NULL,
  `pil` tinyint(4) NOT NULL,
  `grupo` varchar( 6 ) NOT NULL,
  `nivel` varchar( 64 ) NOT NULL,
  KEY `claveal` (`claveal`)
)";
 mysqli_query($db_con, $crea_tabla);

 // Tabla temporal.
 $crea_tabla2 = "CREATE TABLE IF NOT EXISTS `temp4` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`claveal` VARCHAR( 12 ) NOT NULL ,
`asignatura` INT( 8 ) NOT NULL ,
`nota` TINYINT( 2 ) NOT NULL ,
INDEX (  `claveal` )
)";	
  mysqli_query($db_con, $crea_tabla2);
 
	$key == '1' ? $activ=" active" : $activ='';
?>
<div class="tab-pane fade in<?php echo $activ;?>" id="<?php echo "tab".$key;?>">
<h3>Resultados de los Alumnos por Nivel</h3><br />

<table class="table table-striped table-bordered"  align="center" style="width:auto" valign="top">
<thead>
<th></th>
<th class='text-info'>Alumnos</th>
<th class='text-warning'>Repiten</th>
<th>0 Susp</th>
<th>1-2 Susp</th>
<th>3-5 Susp</th>
<th>6-8 Susp</th>
<th>9+ Susp.</th>
</thead>
<tbody>
<?php
// Evaluaciones ESO
$nivele = mysqli_query($db_con, "select * from cursos");
while ($orden_nivel = mysqli_fetch_array($nivele)){
	
$niv = mysqli_query($db_con, "select distinct curso from alma where curso = '$orden_nivel[1]' and curso not like '1%'");
while ($ni = mysqli_fetch_array($niv)) {
	$n_grupo+=1;
	$curso = $ni[0];
	$rep = ""; 
	$promo = "";
$notas1 = "select notas". $key .", claveal1, matriculas, unidad, curso, alma.claveal from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.curso = '$curso' and alma.claveal in (select distinct claveal from pendientes) and curso not like '1%'";
//echo $notas1."<br>";

$result1 = mysqli_query($db_con, $notas1);
if (!($result1)) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administracción --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
}
while($row1 = mysqli_fetch_array($result1)){
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$claveal = $row1[1];
$claveal2 = $row1[5];
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
$asig_pendi="";
$cod_pend="";
$al_pend = "";
 for ($i=0;$i<$num; $i++)
  {
$bloque = explode(":", $trozos1[$i]);

$asig_pend = mysqli_query($db_con, "select codigo from pendientes where claveal = '" . $claveal2 . "' and codigo = '" . $bloque[0] . "'");
$asig_pendi = mysqli_fetch_array($asig_pend);
$cod_pend = $asig_pendi[0];

if (strlen($cod_pend)>1) {
$control_pend = mysqli_query($db_con, "select abrev from asignaturas where codigo = '$cod_pend' and abrev like '%\_%'");
$control_pendiente = mysqli_fetch_array($control_pend);
$control_pd = "_".substr($curso,0,1);
if (strstr($control_pendiente[0],"_")==TRUE and strstr($control_pendiente[0],$control_pd)==FALSE) {
$al_pend = 1;
$nombreasig = "select nombre from calificaciones where codigo = '" . $bloque[1] . "'";
//echo "$nombreasig<br>";
$asig = mysqli_query($db_con, $nombreasig);
$cali = mysqli_fetch_row($asig);	
	if($cali[0] < '5' and !($cali[0] == ''))	{		
	$susp+=1; 
	}	
	mysqli_query($db_con, "insert into temp4 values('','$claveal','$bloque[0]','$cali[0]')");
}
}
  }
//echo "$claveal2 $grupo $susp <br>";
if ($al_pend==1) {
$suspensos = "insert into suspensos3  (`claveal` ,`suspensos` ,`pil` ,`grupo`,`nivel`) VALUES ('$claveal',  '$susp',  '$pil', '$grupo', '$curso')";
mysqli_query($db_con, $suspensos);	
}
//echo $suspensos."<br>";
}

// Calculamos
$cer = mysqli_query($db_con, "select distinct claveal, grupo from suspensos3 where nivel = '$curso' and suspensos = '0'");
$cero = '';
$cero=mysqli_num_rows($cer);

$uno_do = mysqli_query($db_con, "select distinct claveal, grupo from suspensos3 where nivel = '$curso' and suspensos > '0' and suspensos < '3'");
$uno_dos='';
$uno_dos=mysqli_num_rows($uno_do);

$tres_cinc = mysqli_query($db_con, "select distinct claveal, grupo from suspensos3 where nivel = '$curso' and suspensos > '2' and suspensos < '6'");
$tres_cinco='';
$tres_cinco=mysqli_num_rows($tres_cinc);

$seis_och = mysqli_query($db_con, "select distinct claveal, grupo from suspensos3 where nivel = '$curso' and suspensos > '5' and suspensos < '9'");
$seis_ocho='';
$seis_ocho=mysqli_num_rows($seis_och);

$nuev = mysqli_query($db_con, "select distinct claveal, grupo from suspensos3 where nivel = '$curso' and suspensos > '8'");
$nueve='';
$nueve=mysqli_num_rows($nuev);

//$tota = mysqli_query($db_con, "select distinct notas.claveal from notas, alma where alma.claveal1 = notas.claveal and nivel = '$curso'");
$tota = mysqli_query($db_con, "select distinct claveal from suspensos3 where nivel = '$curso'");
$total='';
$total=mysqli_num_rows($tota);

// Promocion
	$extra1 = " and suspensos = '0'";
	$prom1 = mysqli_query($db_con, "select distinct claveal, grupo from suspensos3 where nivel = '$curso'  $extra1");
	$promo1=mysqli_num_rows($prom1);
	if ($promo1==0) { $promo1=""; }

$n_pil = mysqli_query($db_con, "select distinct claveal, grupo from suspensos3 where nivel = '$curso' and pil = '1'");
$num_pil='';
$num_pil=mysqli_num_rows($n_pil);

$porcient = (($promo1)*100)/$total;
$porciento='';
if ($porcient>49) {
	$porciento = "<span class='text-success'>".substr($porcient,0,5)."%</span>";
}
else{
	$porciento = "<span class='text-danger'>".substr($porcient,0,5)."%</span>";	
}

?>

<tr>
<th><?php echo $curso;?></th>
<th class='text-info'><?php echo $total;?></th>
<td class='text-warning'><?php echo $num_pil;?></td>
<td><?php echo $cero;?></td>
<td><?php echo $uno_dos;?></td>
<td><?php echo $tres_cinco;?></td>
<td><?php echo $seis_ocho;?></td>
<td><?php echo $nueve;?></td>
</tr>
<?php
}
}
?>
</tbody>
</table>
<hr />
<br />
<!--  Estadísticas por asignatura -->
<h3>Resultados de las Materias por Nivel</h3><br />
<?php
$nivele = mysqli_query($db_con, "select * from cursos where nomcurso not like '1%'");
while ($orden_nivel = mysqli_fetch_array($nivele)){
	?>
	<legend><?php echo $orden_nivel[1]; ?></legend>
<table class="table table-striped table-bordered"  align="center" style="width:700px;" valign="top">
<thead>
<th class='text-info'>Asignatura</th>
<th class='text-info'>Matriculados</th>
<th class='text-info'>Suspensos</th>
<th class='text-info'>Aprobados</th>
</thead>
<tbody>	
	<?php
$as = mysqli_query($db_con, "select asignaturas.nombre, asignaturas.codigo from asignaturas where curso = '$orden_nivel[1]' and abrev like '%\_%'");
// echo "select asignaturas.nombre, asignaturas.codigo from asignaturas where curso = '$orden_nivel[1]' and abrev not like '%\_%'";
while ($asi = mysqli_fetch_array($as)) {
	$n_c = mysqli_query($db_con, "select distinct nivel from alma where curso = '$orden_nivel[1]'");
	//echo "select distinct nivel from alma where curso = '$orden_nivel[1]'";
	$niv_cur = mysqli_fetch_array($n_c);
	$nomasi2 = $asi[0];
	$codasi2 = $asi[1];
	$cod_nota2 = mysqli_query($db_con, "select id from temp4, alma where asignatura = '$codasi2' and nota < '5' and alma.claveal1 = temp4.claveal and curso = '$orden_nivel[1]'");
	
	//echo "select id from temp4 where asignatura = '$codasi'<br>";
	$num_susp2='';
	$num_susp2 = mysqli_num_rows($cod_nota2);

	$combas2 = mysqli_query($db_con, "select claveal from alma where combasi like '%$codasi2%' and curso = '$orden_nivel[1]'");
	$num_matr2='';
	$num_matr2 = mysqli_num_rows($combas2);
	
	$porcient_asig2 = ($num_susp2*100)/$num_matr2;
	$porciento_asig2='';
if ($porcient_asig2>49) {
	$porciento_asig2 = "<span class='text-success'>".substr($porcient_asig2,0,4)."%</span>";
}
else{
	$porciento_asig2 = "<span class='text-danger'>".substr($porcient_asig2,0,4)."%</span>";	
}
	$num_apro2 = "";
	$num_apro2 = $num_matr2-$num_susp2;
	$porcient_asig22 = ($num_apro2*100)/$num_matr2;
	$porciento_asig22='';
if ($porcient_asig22>49) {
	$porciento_asig22 = "<span class='text-success'>".substr($porcient_asig22,0,4)."%</span>";
}
else{
	$porciento_asig22 = "<span class='text-danger'>".substr($porcient_asig22,0,4)."%</span>";	
}

//if ($porcient_asig2>0) {
			echo "<tr><th>$nomasi2</th><td>$num_matr2</td><td>";
	echo $porciento_asig2."<span class='pull-right'>(".$num_susp2.")</span></td><td>$porciento_asig22 <span class='pull-right'>(".$num_apro2.")</span></td></tr>";
//	}

}
?>
</tbody>
</table>
<br />
<hr />
<?php
}
?>
<br />
</div>
<?php
mysqli_query($db_con, "drop table suspensos3");
mysqli_query($db_con, "drop table temp4");
}
mysqli_close();
?>
</div>
</div>
</div>
</div>

<?php include("../../pie.php");?> 
</body>
</html>