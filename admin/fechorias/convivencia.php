<?php
require('../../bootstrap.php');


include ("../../menu.php");
include ("menu.php");

$id = $_GET['id'];
$claveal = $_GET['claveal'];
if(isset($_GET['hor'])) {$hor = $_GET['hor'];} elseif(isset($_POST['hor'])) {$hor = $_POST['hor'];}
$fecha1 = $_POST['fecha1'];
$fecha11 = $_POST['fecha11'];
if(isset($_GET['hoy'])) {$hoy = $_GET['hoy'];} elseif(isset($_POST['hoy'])) {$hoy = $_POST['hoy'];}else{$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );}
$hoy = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . date ( 'd' );
$hoy2 = date ( 'd' ) . "-" . date ( 'm' ) . "-" . date ( 'Y' );
$ayer = date ( 'Y' ) . "-" . date ( 'm' ) . "-" . (date ( 'd' ) - 1);
?>
<div class="container">

	<div class="page-header">
		<h2 style="display: inline;">Aula de Trabajo Individualizado <small> Alumnos en el Aula</small></h2>
		
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
						hora en su Guardia deben haber sido seleccionados en los <em><strong>Perfiles de los Profesores</strong></em>. 
						Cuando un Profesor tiene este tipo de Guardia en el A.T.I. acceden desde el <em>Menú 
						de la Página de Inicio --> Trabajo --> Problemas de Convivencia --> A.T.I.</em>.</p>
						<p>Esta página nos presenta una tabla con los alumnos que deberían encontrarse en el Aula (al haber 
						rellenado Jefatura el formulario de Expulsión al A.T.I. en el Informe del Problema) en 
						una hora y día determinados. El Profesor puede informar sobre la <strong><em>Asistencia</em></strong> 
						y <strong><em>Trabajo</em></strong> del alumno. Si necesita además informar sobre otro asunto, puede 
						utilizar el campo <strong><em>Observaciones</em></strong>. Una vez terminado de marcar las opciones 
						de cada alumno, enviamos los datos para guardarlos. El Equipo directivo, por su parte, visualiza en 
						todo momento la actividad en el A.T.I. al recibir los datos de todos los Profesores que hacen allí 
						su Guardia.</p>
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
echo " <legend class='lead text-info' align='center' >";
echo "$hoy2</legend>";



if ($_POST['enviar'] == 'Registrar'){
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

// Horas y días según el horario
$minutos = date ( "i" );
$diames = date ( "j" );
$nmes = date ( "n" );
$nano = date ( "Y" );
$hoy = $nano . "-" . $nmes . "-" . $diames;
if (empty ( $hora_dia )) {
	$hora = date ( "G" ); // hora
	$ndia = date ( "w" );
	if (($hora == '8' and $minutos > 15) or ($hora == '9' and $minutos < 15)) {
		$hora_dia = '1';
	} elseif (($hora == '9' and $minutos > 15) or ($hora == '10' and $minutos < 15)) {
		$hora_dia = '2';
	} elseif (($hora == '10' and $minutos > 15) or ($hora == '11' and $minutos < 15)) {
		$hora_dia = '3';
	} elseif (($hora == '11' and $minutos > 15) or ($hora == '11' and $minutos < 45)) {
		$hora_dia = '9';
	} elseif (($hora == '11' and $minutos > 45) or ($hora == '12' and $minutos < 45)) {
		$hora_dia = '4';
	} elseif (($hora == '12' and $minutos > 45) or ($hora == '13' and $minutos < 45)) {
		$hora_dia = '5';
	} elseif (($hora == '13' and $minutos > 45) or ($hora == '14' and $minutos < 45)) {
		$hora_dia = '6';
	} else {
		$hora_dia = "0";
	}	
}

$result = mysqli_query($db_con, "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad,
  FALUMNOS.nc, aula_conv, inicio_aula, fin_aula, id, Fechoria.claveal, horas from Fechoria,
  FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and aula_conv > '0' and inicio_aula <= '$hoy' and fin_aula >= '$hoy' and horas like '%$hora_dia%' order by apellidos, nombre " );
?>
<?php
echo "<br /><center><table class='table table-striped'>";
	echo "<thead><th>Alumno</th>
		<th>Grupo</th><th>Días</th><th>Inicio</th><th>Detalles</th><th>Asiste</th><th>Trabaja</th><th>Observaciones</th><th align='center'>1</th><th align='center'>2</th><th align='center'>3</th><th align='center'>4</th><th align='center'>5</th><th align='center'>6</th><th align='center'></th></thead>";
	echo '<form name="conviv" action="convivencia.php" method="post" enctype="multipart/form-data">';
while ( $row = mysqli_fetch_array ( $result ) ) {
	$sel =  mysqli_query($db_con, "select * from convivencia where claveal = '$row[8]' and dia = '$ndia' and hora = '$hora_dia' and fecha = '$hoy'");
	$ya = mysqli_fetch_array($sel);
	if (empty($ya[0])) {$ch = '';} else{$ch=" checked";}
	if ($ya[4] == 0) {$ch_tr = '';$trab = "";} else{$ch_tr=" checked";}
	$obs_al = $ya[6];
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
		echo "<td style='vertical-align:middle'>";
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
	$foto="";
		$foto = "<div align='center'><img src='../../xml/fotos/$row[8].jpg' border='2' width='50' height='60' style='margin:auto;border:1px solid #bbb;'  /></div>";
		echo $foto;
	
	echo "</td></tr>";	
} 
	echo "</table><input type='submit' name = 'enviar' value = 'Registrar' class='btn btn-primary' /></form></center>";
	echo '</div>
</div>
</div>
</div>
';
?>
<?php include("../../pie.php");?>
  </body>
</html>

