<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2));

if (isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
} 
elseif (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
} 
else
{
$unidad="";
}

if (isset($_POST['nivel'])) {
	$nivel = $_POST['nivel'];
} 
elseif (isset($_GET['nivel'])) {
	$nivel = $_GET['nivel'];
} 
else
{
$niv_uni = mysqli_query($db_con,"select curso from alma where unidad = '$unidad'");
$niv_unidad = mysqli_fetch_array($niv_uni);
$nivel = $niv_unidad[0];
}

if (isset($_POST['claveal'])) {
	$claveal = $_POST['claveal'];
}
elseif (isset($_GET['claveal'])) {
	$claveal = $_GET['claveal'];
} 
else
{
$claveal="";
}
if (isset($_POST['tutor'])) {
	$tutor = $_POST['tutor'];
}
elseif (isset($_GET['tutor'])) {
	$tutor = $_GET['tutor'];
} 
else
{
$tutor="";
}

if(isset($_GET['imprimir']) and $_GET['imprimir'] == "si")
{
	include("cert_pdf.php");
	exit;
}

include("../../menu.php");
?>
<div class="container">

	<div class="page-header">
		<h2 style="display:inline;">Programa de Ayudas al Estudio <small>Informe sobre el estado de los Libros</small></h2>
		
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
						<p>El módulo permite gestionar los Libros de Texto dentro del Programa de Ayudas al 
						Estudio de la Junta de Andalucía. Se activa durante los meses de Junio y Septiembre, 
						y desaparece posteriormente.</p>
						<p>El Tutor marca el estado de los libros según las siguientes opciones: Bien, Regular, 
						Mal, No hay libro y Septiembre (en caso de que el alumno haya suspendido la asignatura 
						en Junio, y pueda entregarlo tras la Evaluación Extraordinaria).</p>
						<p>Para evitar un cierre inesperado de la página y la pérdida de datos, la aplicación 
						envía el formulario cada 9 minutos, recargando la página. El comportamiento, por lo 
						tanto, es normal.</p>
						<p>Una vez terminado de marcar el estado de los libros de los alumnos de la Tutoría, 
						se envían los datos del formulario por última vez para guardarlos. El Tutor puede 
						modificar el estado hasta que desaparece el formulario en Septiembre.</p>
						<p>El Secretario del Centro puede emitir con la aplicación Certificados de entrega y 
						estado de los libros, así como Facturas en caso de que los libros se encuentren 
						desaparecidos o en un estado inaceptable.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>

		<h3 class="text-info"><?php echo (isset($unidad) && $unidad != "") ? $unidad : $_POST['nivel']; ?></h3>
	</div>
<br />
<?php
$tarari=0;
foreach($_POST as $key0 => $val0)
{
if(strlen($val0) > "0"){$tarari=$tarari+1;}
}
if($tarari>0){
foreach($_POST as $key => $val)
{
//	echo "$key --> $val <br>";
$trozos = explode("-",$key);
$claveal = $trozos[0];
if($val == "B" or $val == "R" or $val == "M" or $val == "N" or $val == "S"){$asignatura = $trozos[1];$fila_asig = $fila_asig + "1";}

if(is_numeric($claveal) and ($val == "B" or $val == "R" or $val == "M" or $val == "N" or $val == "S"))
{
		$query = "select estado from textos_alumnos where claveal = '$claveal' and materia = '$asignatura' and curso = '".$config['curso_actual']."'";
		//echo $query;
		$edit = mysqli_query($db_con, $query);
		$estado0 = mysqli_fetch_array($edit);
		$estado = $estado0[0];
		if(strlen($estado) > 0){
		mysqli_query($db_con, "update textos_alumnos set estado = '$val' where claveal = '$claveal' and materia = '$asignatura'");		
		}
		else{
		mysqli_query($db_con, "insert into textos_alumnos (claveal, materia, estado, fecha, curso) values ('$claveal','$asignatura','$val',now(),'$nivel')");
		}
}
}
if(isset($_POST['procesar']) and $_POST['procesar'] == "Enviar datos"){
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente en la base de datos.
</div></div><br />';
}
}
$claveal = "";
?>
<form action="libros.php" method="post" name="libros">
<input type="hidden" name="nivel" value="<?php echo $nivel;?>" />
<p class="help-block">OPCIONES: <span class="label label-info">B</span> = Bien, <span class="label label-warning">R</span> = Regular, <span class="label label-danger">M</span> = Mal, <span class="label label-default">N</span> = No hay Libro, <span class="label label-success">S</span> = Septiembre.</p>
<?php
$curso = $nivel;
//$fila_asig = $fila_asig + 1;

echo "<br /><table class='table table-bordered'>";

if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'2') == TRUE){
echo "<thead><tr><th></th>";
}
if (isset($_POST['nivel'])) {
	$p_nivel=$_POST['nivel'];
}
else{
	$p_nivel=$nivel;
}
$asignaturas0 = "select distinct nombre, codigo, abrev from asignaturas where (curso like '".$curso."') and abrev not like '%\_%' and nombre in (select distinct materia from textos_gratis where textos_gratis.nivel = '".$p_nivel."') order by codigo";
// echo $asignaturas0;
$num_col = 1;
$asignaturas1 = mysqli_query($db_con, $asignaturas0);
$num_asig = mysqli_num_rows($asignaturas1);
while ($asignaturas = mysqli_fetch_array($asignaturas1)) {	
	$col{$num_col} = $asignaturas[1];
	echo "<th>$asignaturas[2]</th>";
	$num_col = $num_col + 1;
}
if(!(empty($unidad))){
	$extra=" and FALUMNOS.unidad = '$unidad'";
	$un = mysqli_query($db_con, "select distinct alma.curso from alma where unidad = '$unidad'");
	$cur = mysqli_fetch_array($un);
	$nivel = $cur[0];
	$curso = $nivel;
	$fila=1;
}
if(stristr($_SESSION['cargo'],'1') == TRUE){
	$jefe=1;
	$fila=0;
	echo "<th>Estado</th></tr>";
}
echo "</thead><tbody>";
$alumnos0 = "select nc, FALUMNOS.apellidos, FALUMNOS.nombre, combasi, FALUMNOS.claveal, FALUMNOS.unidad from FALUMNOS, alma where alma.claveal = FALUMNOS.claveal and alma.curso = '".$p_nivel."' $extra order by FALUMNOS.apellidos, FALUMNOS.nombre, nc"; 
//echo $alumnos0;
$fila_asig=0;
$alumnos1 = mysqli_query($db_con, $alumnos0);
while ($alumnos = mysqli_fetch_array($alumnos1)) {
	if(empty($jefe)){$nc="$alumnos[0]. $alumnos[1], $alumnos[2]";}else{$nc="$alumnos[1], $alumnos[2] ($alumnos[5])";}
	
	$fila_asig+=1;
	if(stristr($_SESSION['cargo'],'1') == TRUE){}else{}
	if($fila_asig == "5" or $fila_asig == "10" or $fila_asig == "15" or $fila_asig == "20" or $fila_asig == "25" or $fila_asig == "30" or $fila_asig == "35" or $fila_asig == "40")
{
echo "</thead><tbody><tr><td style='background-color:#eee'></td>";
$asignaturas0 = "select distinct nombre, codigo, abrev from asignaturas where curso like '".$curso."' and abrev not like '%\_%' and nombre in (select distinct materia from textos_gratis where textos_gratis.nivel = '".$curso."') order by codigo";
// echo $asignaturas0."<br>";
$num_col = 1;
$asignaturas1 = mysqli_query($db_con, $asignaturas0);
$num_asig = mysqli_num_rows($asignaturas1);
while ($asignaturas = mysqli_fetch_array($asignaturas1)) {	
	$col{$num_col} = $asignaturas[1];
	echo "<th style='background-color:#eee'>$asignaturas[2]</th>";
	$num_col = $num_col + 1;
}
if(stristr($_SESSION['cargo'],'1')){$extra=" order by apellidos";}else{$extra=" and FALUMNOS.unidad = '$unidad' order by nc";}
if(stristr($_SESSION['cargo'],'1')){echo "<th style='background-color:#eee'>Estado</th></tr>";}
}

	echo "<tr><td>$nc";
$clave = $alumnos[4];
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<br /><img class='img-thumbnail' src='../../xml/fotos/$clave.jpg' width='84' alt=''>";
	}    
	else{
		echo '<h4><span class="fa fa-user fa-fw fa-5x"></span></h4>';
	}       	
	echo "</td>";
	for ($i=1;$i<$num_asig+1;$i++){
		echo "<td nowrap>";
		//echo $col{$i}."-";
		if(strstr($alumnos[3], $col{$i}))
		{
		$r_nombre = $alumnos[4]."-".$col{$i};
		$trozos = explode("-",$r_nombre);
		$claveal = $trozos[0];
		$asignatura = $trozos[1];
		$query = "select estado from textos_alumnos where claveal = '$claveal' and materia like '$asignatura' and curso = '".$config['curso_actual']."'";
		//echo $query;
		$edit = mysqli_query($db_con, $query);
		$estado0 = mysqli_fetch_array($edit);
		$estado = $estado0[0];
?>
	<div class="radio">
		<label style="color:black;">
    	<input type="radio" name="<?php echo $r_nombre;?>" <?php echo "checked=\"checked\""; ?> value="N" id="botones_3" /> <span class="label label-default">N</span>
    </label>
  </div>
  <div class="radio">
    <label style="color:#3a87ad;">
    	<input type="radio" name="<?php echo $r_nombre;?>" <?php if($estado == "B"){echo "checked=\"checked\"";} ?> value="B" id="botones_0" /> <span class="label label-info">B</span>
    </label>
  </div>
  <div class="radio">
    <label style="color:#f89406;">
   	 <input type="radio" name="<?php echo $r_nombre;?>" <?php if($estado == "R"){echo "checked=\"checked\"";} ?> value="R" id="botones_1" /> <span class="label label-warning">R</span>
   	</label>
  </div>
  <div class="radio">
    <label style="color:#9d261d;">
    	<input type="radio" name="<?php echo $r_nombre;?>" <?php if($estado == "M"){echo "checked=\"checked\"";} ?> value="M" id="botones_2" /> <span class="label label-danger">M</span>
    </label>
  </div>
  <div class="radio">
    <label style="color:#46a546;">
    	<input type="radio" name="<?php echo $r_nombre;?>" <?php if($estado == "S"){echo "checked=\"checked\"";} ?> value="S" id="botones_4" /> <span class="label label-success">S</span>
    </label>
  </div>
    	
<?php
//			echo $col{$i};
		}
		echo "</td>";
		
	}
	
		$query2 = "select devuelto from textos_alumnos where claveal = '$claveal' and curso = '".$config['curso_actual']."'";
		$edit2 = mysqli_query($db_con, $query2);
		$estado2 = mysqli_fetch_array($edit2);
		$estadoP = $estado2[0];
	if(stristr($_SESSION['cargo'],'1'))
	{
				echo '<td>';

?>
<a  href="libros.php?claveal=<?php echo $claveal;?>&imprimir=si&nivel=<?php echo $nivel;?>" class="btn btn-primary" target="_blank"><i class="fa fa-print " title="imprimir"> </i></a> <br><br>
<?php
	if($estadoP == "1" ){ echo '<button class="btn btn-success"><i class="fa fa-check" title="Devueltos"> </i> </button>';}
	echo "</td>";
	}

echo "</tr>";
	}
echo "</table>";
?>
<br />
<input type="hidden" name="unidad" value="<?php echo $unidad;?>" />
<input type="submit" name="procesar" value="Enviar datos" class="btn btn-primary btn-large" />
</form>
</div>
<?php include("../../pie.php");?>
<script>
function wait(){
	string="document.forms.libros.submit();";
	setInterval(string,540000);
}
wait();
</script>
</body>
</html>