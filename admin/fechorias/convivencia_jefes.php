<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include ("../../menu.php");
include ("menu.php");
?>
<div class="container">

	<div class="page-header">
		<h2 style="display: inline;">Aula de Trabajo Individualizado <small> Últimos Problemas del A.T.I.</small></h2>
		
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
						<p>Este módulo permite hacer un seguimiento de los alumnos que son enviados al A.T.I., 
						en caso de que el Centro disponga de una. Los Profesores que atienden el Aula en una determinada 
						hora en su Guardia deben  haber sido seleccionados en los <em><strong>Perfiles de los Profesores</strong></em>. 
						Cuando un Profesor tiene este tipo de Guardia en el A.T.I. acceden desde el <em>Menú 
						de la Página de Inicio --> Trabajo --> Problemas de Convivencia --> A.T.I.</em>.</p>
						<p>Esta página nos presenta una tabla con los alumnos que deberían encontrarse en el Aula (al haber 
						rellenado Jefatura el formulario de Expulsión al A.T.I. en el Informe del Problema) 
						en una hora y día determinados. El Profesor puede informar sobre la <strong><em>Asistencia</em></strong> 
						y <strong><em>Trabajo</em></strong> del alumno. Si necesita además informar sobre otro asunto, 
						puede utilizar el campo <strong><em>Observaciones</em></strong>. Una vez terminado de marcar las 
						opciones de cada alumno, enviamos los datos para guardarlos. El Equipo directivo, por su parte, 
						visualiza en todo momento la actividad en el Aula al recibir los datos de todos los Profesores que 
						hacen allí su Guardia.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>

	</div>
	
<div class="row">
<div class="col-sm-12">
<?php 
$borrar = $_GET['borrar'];
$id = $_GET['id'];
$claveal = $_GET['claveal'];
if(isset($_GET['hoy'])) {$hoy = $_GET['hoy'];} else {$hoy = $_POST['hoy'];}
$fecha0 = $_POST['fecha0'];
if(isset($_GET['hor'])) {$hor = $_GET['hor'];} else {$hor = $_POST['hor'];}
$fecha1 = $_POST['fecha1'];
$fecha11 = $_POST['fecha11'];

if ($borrar == '1') {
	$del = mysqli_query($db_con, "delete from convivencia where id='$id'");
	$comprobar = mysqli_query($db_con, "select id from convivencia where id = '$id'");
	if (mysqli_num_rows($comprobar) == '0') {
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han borrado correctamente.
          </div></div>';
	}
	else{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
            Algún problema impide borrar los datos, así que deberías ponerte en contacto con quien pueda ayudarte.
          </div></div>';
	}
}

if ($_POST['enviar'] == 'Registrar'){
if (empty($hoy)) {
		$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );
	}
foreach ( $_POST as $clave => $valor ) {
	if(is_numeric($clave)) {
	$tr=explode("-", $valor);
	// Comprobacion de duplicacion de datos 
	$sel1 =  mysqli_query($db_con, "select * from convivencia where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
	//echo "select * from convivencia where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'";
	if (mysqli_num_rows($sel1) == 0) {
		mysqli_query($db_con, "insert into convivencia (claveal, dia, hora, fecha) VALUES ('$tr[0]','$tr[1]','$tr[2]', '$hoy')");
			$mens = '1';	
			}
	else{
			mysqli_query($db_con, "update convivencia set dia = '$tr[1]', hora = '$tr[2]' where claveal = '$tr[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
			$mens = '2';	
	}
	}
if (stristr($clave,"observa")==TRUE) {
	$tr1=explode("-", $clave);
	mysqli_query($db_con, "update convivencia set observaciones = '$valor' where claveal = '$tr1[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
}
else{
if ($valor == "1") {
	$tr1=explode("-", $clave);
	mysqli_query($db_con, "update convivencia set trabajo = '1' where claveal = '$tr1[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
}
else {
	$tr1=explode("-", $clave);
	mysqli_query($db_con, "update convivencia set trabajo = '0' where claveal = '$tr1[0]' and dia = '$tr[1]' and hora = '$tr[2]' and fecha = '$hoy'");
}
}
}
if ($mens == '1') {
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han registrado correctamente.
          </div></div>';	}
if ($mens == '2') {
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han registrado y actualizado correctamente.
          </div></div>';	}
}

if ($fecha1) {
	if (strlen($fecha0)<'6' and strlen($fecha11) > '6') {
		$fecha0 = $fecha11;
	}
	elseif (strlen($fecha0)<'6' and strlen($fecha11) < '6') {
		$fecha0 = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );
	}else{		
		$fechasp0 = explode ( "-", $fecha0 );
		$fecha0 = $fechasp0 [2] . "-" . $fechasp0 [1] . "-" . $fechasp0 [0];
	}
}
else
{
$fecha0=$hoy;
}
     
echo " <legend class='text-info' align='center'>";
if (empty($hor))  {$hoy0 = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );}else {$hoy0 = $fecha0;}
if ($hoy) {
	$hoy0=$hoy;
}
$tr_h = explode("-", $hoy0);
$hoy0 = "$tr_h[2]-$tr_h[1]-$tr_h[0]";
echo "$hoy0</legend>";
	echo "<center><form name='conv' action='convivencia_jefes.php' method='post' enctype=multipart/form-data' class='form-inline'>";
	?>
<div class="well">	
	<div class="form-group" id="datetimepicker1">
<label>Selecciona el Día </label>
<div class="input-group">
  <input name="fecha0" id="fecha0" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fecha" value="<?php echo $hoy0;?>" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="form-group">	
    <label>
	<?php
	echo "  y la Hora &nbsp;</label>";
	echo "<select name = 'hor' class='form-control'>";
	if (empty($hor)) {
	}else{
		echo "<option>$hor</option>";
	}
	echo "<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option>
	</select>
	</div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='hidden' name = 'fecha11' value = '$fecha0' />
	<input type='submit' name = 'fecha1' value = 'Enviar fecha' class='btn btn-primary' />
	</form></center>";
if (empty($fecha0)) {$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );}else{$hoy = $fecha0;}
$trf = explode("-", $hoy);

// Horas y dÃŒas segË™n el horario

$minutos = date ( "i" );
$diames = date ( "j", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0]) );
$nmes = date ( "n", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0]) );
$nano = date ( "Y", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0]) );
$ndia = date ( "w", mktime(0, 0, 0, $trf[1], $trf[2], $trf[0])  );
//echo "$minutos --> $diames --> $nmes --> $nano<br>";
if (empty($hor)) {$hora_dia = '1';}
if ($hor) {
	$hora_dia = $hor;
}
$result = mysqli_query($db_con, "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad,
  FALUMNOS.nc, aula_conv, inicio_aula, fin_aula, id, Fechoria.claveal, horas from Fechoria,
  FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and aula_conv > '0' and inicio_aula <= '$hoy' and fin_aula >= '$hoy' and horas like '%$hora_dia%' order by apellidos, nombre " );
?>
</div>
</div>
<?php
	echo "<center><table class='table table-striped'>";
	echo "<thead><th>Alumno</th>
		<th>Grupo</th><th>Días</th><th>Inicio</th><th>Detalles</th><th>Asistencia</th><th>Trabajo</th><th>Observaciones</th><th align='center'>1</th><th align='center'>2</th><th align='center'>3</th><th align='center'>4</th><th align='center'>5</th><th align='center'>6</th><th align='center'></th><th></th></thead>";
	echo '<form name="conviv" action="convivencia_jefes.php" method="post" enctype="multipart/form-data">';
while ( $row = mysqli_fetch_array ( $result ) ) {
	$obs="";
	$sel =  mysqli_query($db_con, "select * from convivencia where claveal = '$row[8]' and hora = '$hora_dia'  and fecha = '$hoy'");
	$ya = mysqli_fetch_array($sel);
	$id0 = $ya[0];
	$obs_al = $ya[6];

	if (empty($ya[0])) {$ch = '';} else{$ch=" checked";}
	if ($ya[4] == 0) {$ch_tr = '';$trab = "";} else{$ch_tr=" checked";}
		echo "<tr ><td style='vertical-align:middle'>$row[0], $row[1]</td>
		<td style='vertical-align:middle'>$row[2]</td>
		<td style='vertical-align:middle'>$row[4]</td>
		<td style='vertical-align:middle'>$row[5]</td>
		<td style='vertical-align:middle' align='center'><A HREF='detfechorias.php?id=$row[7]&claveal=$row[8]'><i data-bs='tooltip' title='Detalles sobre el problema que ha traído al alumno al A.T.I.' class='fa fa-search'> </i> </A>$comentarios</td>
		<td style='vertical-align:middle' align='center'>
	
		<input type='checkbox' name='$row[8]' value='$row[8]-$ndia-$hora_dia' $ch /></td>
		<td style='vertical-align:middle' align='center'>
		<input type='checkbox' name='$row[8]-trabajo'  value='1' $ch_tr/>
		<input type='hidden' name='hoy'  value='$fecha0' />
		<input type='hidden' name='hor'  value='$hora_dia' /></td>
		<td>
		<textarea name='$row[8]-observaciones' rows='3' cols='25'>$obs_al</textarea>
		</td>";
		
	for ($i = 1; $i < 7; $i++) {
		echo "<td>";
		$asiste0 = "select hora, trabajo, id, observaciones from convivencia where claveal = '$row[8]' and fecha = '$hoy' and hora = '$i'";
		//echo $asiste0;
		$asiste1 = mysqli_query($db_con, $asiste0);
			$asiste = mysqli_fetch_array($asiste1);
			if ($asiste[1] == '0') {
			echo "<center><i data-bs='tooltip' title='No trabaja' class='fa fa-exclamation-triangle text-warning'> </i> </center";
			}
			if ($asiste[1] == '1') {
			echo "<center><i data-bs='tooltip' title='Trabaja' class='fa fa-check text-success'> </i> </center";
			}
			if (!empty($asiste[3])) {
			echo "<center><i data-bs='tooltip' title='$asiste[3]' class='fa fa-comment text-danger'> </i> </center";
			}
		echo "</td>";
	}
	echo "<td style='vertical-align:middle'>";
	if (!empty($id0)) {
		echo "<A HREF='convivencia_jefes.php?id=$id0&borrar=1&hoy=$hoy' data-bb='confirm-delete'><i title='Borrar' class='fa fa-trash-o' > </i> </A>";
	}
	echo "</td><td>";
	$foto="";
		$foto = "<div align='center'><img src='../../xml/fotos/$row[8].jpg' border='2' width='50' height='60' style='margin:auto;border:1px solid #bbb;'  /></div>";
		echo $foto;
	
	echo "</td></tr>";
		
} 
	echo "</table><input type='submit' name = 'enviar' value = 'Registrar' class='btn btn-primary' /></form></center>";
?>
</div>
</div>
</div>
<?php include("../../pie.php");?>
<script>  
$(function ()  
{ 
	$('#datetimepicker1').datetimepicker({
		language: 'es',
		pickTime: false
	})
});  
</script>
  </body>
</html>

