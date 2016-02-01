<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2, 6, 7, 8, 'a'));

$profe = $_SESSION['profi'];

include("../menu.php");
if (isset($_GET['submit0'])) {$submit0 = $_GET['submit0'];}elseif (isset($_POST['submit0'])) {$submit0 = $_POST['submit0'];}else{$submit0="";}
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['text'])) {$text = $_GET['text'];}elseif (isset($_POST['text'])) {$text = $_POST['text'];}else{$text="";}
if (isset($_GET['causa'])) {$causa = $_GET['causa'];}elseif (isset($_POST['causa'])) {$causa = $_POST['causa'];}else{$causa="";}
if (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (isset($_GET['extid'])) {$extid = $_GET['extid'];}elseif (isset($_POST['extid'])) {$extid = $_POST['extid'];}else{$extid="";}
if (isset($_GET['mobile'])) {$mobile = $_GET['mobile'];}elseif (isset($_POST['mobile'])) {$mobile = $_POST['mobile'];}else{$mobile="";}

?>
<script>
function contar(form,name) {
  n = document.forms[form][name].value.length;
  t = 160;
  if (n > t) {
    document.forms[form][name].value = document.forms[form][name].value.substring(0, t);
  }
  else {
    document.forms[form]['result'].value = t-n;
  }
}
</script> 
<div class="container">

<div class="page-header">
  <h2>SMS <small> Envío de mensajes</small></h2>
<?php
if(strlen($unidad)>1){
	$t0 = mysqli_query($db_con,"select Tutor from FTUTORES where unidad='$unidad'");
	if (mysqli_num_rows($t0)>0) {
		$t1 = mysqli_fetch_row($t0);
?>
<h4 class="text-info">Tutor/a: <?php echo nomprofesor($t1[0]); ?></h4>
<?		
	}
?>
<h4 class="text-info">Grupo: <?php echo $unidad; ?></h4>
<?	 		
	 	}
?>
</div>
<br>
<div class="row">

<?php
 if ($config['mod_sms']) {
// variables(); 
// Procesado de los datos del Formulario
if($submit0 == "Enviar SMS")
{
	if(empty($causa)){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No has seleccionado ninguna Causa del Mensaje.<br />Vuelve atrás, selecciónala e inténtalo de nuevo.
          </div></div>';
		  exit();
}
if(empty($text)){
		echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No has escrito ningún texto para el Mensaje.<br />Vuelve atrás, redacta el texto e inténtalo de nuevo.
          </div></div>';
		  exit();
}
  	if(strlen($text) > "2")
	{ 
	if($nombre)
	{
	foreach($nombre as $tel)
	{
	$trozos = explode(" --> ",$tel);
	$claveal = trim($trozos[0]);
	$tel0 = mysqli_query($db_con, "select telefono, telefonourgencia, apellidos, alma.nombre, alma.unidad, alma.matriculas, tutor, idea from alma, FTUTORES, departamentos where FTUTORES.unidad = alma.unidad and FTUTORES.tutor = departamentos.nombre and claveal = '$claveal'");
	
	$tel1 = mysqli_fetch_array($tel0);
	$tfno = $tel1[0];	
	$tfno_u = $tel1[1];
	$apellidos = $tel1[2];
	$nombre = $tel1[3];
	$unidad = $tel1[4];
	$alumno_nombre.="$nombre $apellidos;";
	$alumno_mens.="$claveal|$unidad;";
	$tutor_mens = $tel1[6];
	$tutor_idea = $tel1[7];
	if (stristr($todos_tutores,"$tutor_idea|$unidad;")==FALSE) {
		$todos_tutores.="$tutor_idea|$unidad;";
	}
	
	if(substr($tfno,0,1)=="6" OR substr($tfno,0,1)=="7"){$mobil=$tfno;}elseif((substr($tfno_u,0,1)=="6" OR substr($tfno_u,0,1)=="7") and !(substr($tfno,0,1)=="6" OR substr($tfno,0,1)=="7")){$mobil=$tfno_u;}else{$mobil="";}
	
	//if(substr($tfno,0,1)=="6"){$mobil=$tfno;}elseif(substr($tfno_u,0,1)=="6" and !(substr($tfno,0,1)=="6")){$mobil=$tfno_u;}else{$mobil="";}
	if (strlen($mobil)>2) {
		$mobile.=$mobil.",";
	}
	if(stristr($_SESSION['cargo'],'1') == TRUE){$tuto="Jefatura de Estudios";}else{$tuto=$profe;}
$fecha2 = date('Y-m-d');
$observaciones = $text;
$accion = "Envío de SMS";
	}

	$mobile=substr($mobile,0,strlen($mobile)-1);
	}
else
{
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>ATENCIÓN:</strong>
No has seleccionado ningún alumno para el envío de SMS.<br />Vuelve atrás, selecciónalo e inténtalo de nuevo.
          </div></div>';
		  exit();
}


$sms_n = mysqli_query($db_con, "select max(id) from sms");
$n_sms =mysqli_fetch_array($sms_n);
$extid = $n_sms[0]+1;



	// ENVIO DE SMS
	include_once(INTRANET_DIRECTORY . '/lib/trendoo/sendsms.php');
	$sms = new Trendoo_SMS();
	$sms->sms_type = SMSTYPE_GOLD_PLUS;
	
	$exp_moviles = explode(',', $mobile);
	
	foreach ($exp_moviles as $num_movil) {
		
		$num_movil = trim($num_movil);
		
		if(strlen($num_movil) == 9) {
			$sms->add_recipient('+34'.$num_movil);
		}
		else {
			echo "
			<div class=\"alert alert-error\">
				<strong>Error:</strong> No se pudo enviar el SMS al teléfono (+34) ".$num_movil.". Corrija la información de contacto del alumno/a en Séneca e importe los datos nuevamente.
			</div>
			<br>";
		}
	}
	
	$sms->message = $text;
	$sms->sender = $config['mod_sms_id'];
	$sms->set_immediate();
	if ($sms->validate()) $sms->send();
	
	mysqli_query($db_con, "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobile','$text','$profe')");
	mysqli_query($db_con, "insert into tutoria (apellidos, nombre, tutor,unidad,observaciones,causa,accion,fecha,claveal) values ('".$apellidos."','".$nombre."','".$tuto."','".$unidad."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$claveal."')");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
	            <button type="button" class="close" data-dismiss="alert">&times;</button>
	El mensaje SMS se ha enviado correctamente a los siguientes alumnos: '.$alumno_nombre.'.<br>Una nueva acción tutorial ha sido también registrada.
	          </div></div>';
	
}

// Mensaje al Tutor
if (stristr($_SESSION['cargo'],'1') == TRUE) {
	$trozos_tutores = explode(";",$todos_tutores);
	
	foreach ($trozos_tutores as $val_tutor){
		$tr_tutor = explode("|",$val_tutor);
		$tut = $tr_tutor[0];
		$unidad_tut = $tr_tutor[1];
		$alumnos_sms="";
		$alumnos_nombre="";
		
			$trozos_alumnos = explode(";",$alumno_mens);
			foreach ($trozos_alumnos as $val_alumno){
				$tr_al = explode("|",$val_alumno);
				$al_sms = $tr_al[0];
				$unidad_al = $tr_al[1];
				$al_nom  = mysqli_query($db_con, "select nombre, apellidos from alma where claveal='$al_sms'");
				$al_nombre = mysqli_fetch_array($al_nom);
				$al_nombre_sms = "$al_nombre[0] $al_nombre[1]";
				
				if ($unidad_tut == $unidad_al) {
					$alumnos_sms.= "$al_sms; ";
					$alumnos_nombre.= "$al_nombre_sms; ";
				}
			}
if (!empty($tut)) {
				
$query0="insert into mens_texto (asunto, texto, origen, destino) values ('Envío de SMS desde Jefatura de Estudios a los padres de ".$alumnos_nombre." con el siguiente texto:<< ".$observaciones.">>','".$observaciones."','".$profe."', '$alumnos_sms')";
//echo "$query0<br>";
mysqli_query($db_con, $query0);
$id0 = mysqli_query($db_con, "select id from mens_texto where asunto like 'Envío de SMS desde Jefatura de Estudios a los padres de ".$alumnos_nombre."%' and texto = '$observaciones' and origen = '$profe'");
$id1 = mysqli_fetch_array($id0);
$id = $id1[0];
$query1="insert into mens_profes (id_texto, profesor) values ('".$id."','".$tut."')";
//echo "$query1<br>";
mysqli_query($db_con, $query1);	
echo "<br>";
		}
	}
}
	
}
else
{
	 if((!(empty($unidad))) or (stristr($_SESSION['cargo'],'1') == TRUE) or stristr($_SESSION['cargo'],'a') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE){
	 	
		?>
		
<div class="col-md-4 col-md-offset-2">

        <?php
	}
	else{
	echo '<div class="col-md-4 col-md-offset-2">';	
	}
?>
<div class="well well-large" align="left">
<form method="post" action="index.php" name="nameform" class="form-vertical">

      <?php if(stristr($_SESSION['cargo'],'2') == TRUE){} else{ ?>
      <div class="form-group">
      <label>Grupo </label>
		<select  name="unidad" class="form-control" onChange="submit()">
          <option><?php echo $unidad;?></option>
          <?php if(stristr($_SESSION['cargo'],'1') == TRUE){echo "<option>Cualquiera</option>";} ?>
          <?php unidad($db_con); ?>
        </select>
        </div>
        <?php }?>
      
          	<div class="form-group">
          	<label>Causa</label>
			<select name="causa" class="form-control">
 <?php if(stristr($_SESSION['cargo'],'8') == TRUE){?>
		    <option><?php echo $causa; ?></option>
		    <option>Orientación académica y profesional</option>
		    <option>Evoluci&oacute;n acad&eacute;mica</option>
		    <option>T&eacute;cnicas de estudio</option>
            <option>Problemas de convivencia</option>
            <option>Dificultades de integraci&oacute;n</option>
            <option>Problemas familiares, personales</option>
            <option>Dificultades de Aprendizaje</option>
            <option>Faltas de Asistencia</option>
            <option>Otras</option>
<?php } else{ ?>
            <option><?php echo $causa; ?></option>
            <option>Estado general del Alumno</option>
            <option>Evoluci&oacute;n acad&eacute;mica</option>
            <option>Faltas de Asistencia</option>
            <option>Problemas de convivencia</option>
            <option>Otras</option>
<?php } ?>        
	</select>
    </div>
<?php
if(empty($text)){$text = "";}
echo "<div class='form-group'>
<label>Texto del mensaje</label>
<TEXTAREA name='text' class='form-control' rows='4'  onkeydown=\"contar('nameform','text')\" onkeyup=\"contar('nameform','text')\">$text</TEXTAREA></div>
		<div class='form-group'>
		<label>Caracteres restantes:</label> <INPUT name=result value=160 class='form-control' readonly='true'></div>";
$sms_n = mysqli_query($db_con, "select max(id) from sms");
$n_sms =mysqli_fetch_array($sms_n);
$extid = $n_sms[0]+1;
?>
      	

        <br /><input type="submit" name="submit0" value="Enviar SMS" class="btn btn-primary"/>

  <?	  
  if((!(empty($unidad))) or (stristr($_SESSION['cargo'],'1') == TRUE) or stristr($_SESSION['cargo'],'a') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE)
	    {	
		?>
</div>
</div>
<div class="col-sm-4">
<div class="well">
<div class='form-group'>
<label>Selección de Alumnos<?php echo "<span class='text-info'>: $unidad</span>"; ?></label>
        <?php
  		echo '<SELECT  name=nombre[] multiple=multiple class="form-control" style="height:370px">';
  		if ($unidad=="Cualquiera") {$alumno_sel="";}else{$alumno_sel = "WHERE unidad like '$unidad%'";}
  $alumno = mysqli_query($db_con, "SELECT distinct APELLIDOS, NOMBRE, claveal FROM alma $alumno_sel order by APELLIDOS asc");
  
       while($falumno = mysqli_fetch_array($alumno)) 
	   {
	echo "<OPTION>$falumno[2] --> $falumno[0], $falumno[1]</OPTION>";
		}
	echo  '</select></div>';
		} 	
		
		
		
?>
  </form>
<?php
}
 } 
 else {
	 echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
El módulo de envío de SMS debe ser activado en la Configuración general de la Intranet para poder accede a estas páginas, y ahora mismo está desactivado.
          </div></div>';
 }
 
 if((!(empty($unidad))) or (stristr($_SESSION['cargo'],'1') == TRUE)  or stristr($_SESSION['cargo'],'a') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE)
	    {	
echo '</div>
</div></div>';
}
?>
</div>
</div>
</div>
<?php include("../pie.php");?>

</body>
</html>