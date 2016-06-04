<?php
require('../../bootstrap.php');
require('../../lib/trendoo/sendsms.php');

$tutor = $_SESSION['profi'];


include("../../menu.php");
include("menu.php");
?>
	<div class="container">
	
		<div class="page-header">
			<h2 style="display: inline;">Problemas de convivencia <small> Informe personal del Problema</small></h2>
			
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
							<p>Esta página tiene varias funciones. En primer lugar, ofrece información detallada de un 
							problema de convivencia registrado por un Profesor. Presenta también datos numéricos sobre 
							los problemas y tipos de problema del alumno. En la parte inferior tenemos una tabla donde 
							se recoge el historial delictivo del alumno.</p>
							<p>En la parte derecha nos encontramos, si pertenecemos al Equipo directivo, un par de 
							formularios para expulsar al alumno del Centro o expulsarlo al A.T.I. una serie 
							de horas o días. La fecha de la expulsión no debe ser inmediata, considerando que los 
							Profesores del Equipo educativo del alumno que va a ser expulsado necesitarán algún tiempo 
							para rellenar su Informe de Tareas de tal modo que éste trabaje durante su ausencia.</p>
							<p>También nos encontramos una serie de botones para imprimir partes oficiales relacionados 
							con el problema registrado, en caso de que necesitemos hacerlo. Generan documentos oficiales 
							preparados para ser enviados a los Padres del alumno, por lo que su uso está limitado a 
							Tutores y Equipo directivo.</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
						</div>
					</div>
				</div>
			</div>
		  
		</div>

<?php
if(!($_POST['id'])){$id = $_GET['id'];}else{$id = $_POST['id'];}
if(!($_POST['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}
if (isset($_POST['expulsion'])) { $expulsion = $_POST['expulsion']; }
if (isset($_POST['inicio'])) { $inicio = $_POST['inicio']; }
if (isset($_POST['fin'])) { $fin = $_POST['fin']; }
if (isset($_POST['mens_movil'])) { $mens_movil = $_POST['mens_movil']; }
if (isset($_POST['submit'])) { $submit = $_POST['submit']; }
if (isset($_POST['convivencia'])) { $convivencia = $_POST['convivencia']; }
if (isset($_POST['horas'])) { $horas = $_POST['horas']; }
if (isset($_POST['fechainicio'])) { $fechainicio = $_POST['fechainicio']; }
if (isset($_POST['fechafin'])) { $fechafin = $_POST['fechafin']; }
if (isset($_POST['tareas'])) { $tareas = $_POST['tareas']; }
if (isset($_POST['tareas_exp'])) { $tareas_exp = $_POST['tareas_exp']; }
if (isset($_POST['imprimir4'])) { $imprimir4 = $_POST['imprimir4']; }
if (isset($_POST['imprimir'])) { $imprimir = $_POST['imprimir']; }
if (isset($_POST['imprimir5'])) { $imprimir5 = $_POST['imprimir5']; }
if (isset($_POST['imprimir2'])) { $imprimir2 = $_POST['imprimir2']; }
if (isset($_POST['imprimir3'])) { $imprimir3 = $_POST['imprimir3']; }
if (isset($_POST['inicio_aula'])) { $inicio_aula = $_POST['inicio_aula']; }
if (isset($_POST['fin_aula'])) { $fin_aula = $_POST['fin_aula']; }
if (isset($_POST['convivencia'])) { $convivencia = $_POST['convivencia']; }

if (isset($_POST['medidaJefatura'])) {
	$medidaJefatura = $_POST['medidaJefatura'];
	$actualizar ="UPDATE  Fechoria SET  medidaJefatura =  '$medidaJefatura' WHERE id = '$id'"; 
	mysqli_query($db_con, $actualizar);
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>CONFIRMACION:</h5>Medida de jefatura actualizada</div></div>';
}
else
	include("expulsiones.php");

if (strlen($mensaje)>"0") {
echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>'.
            $mensaje.'
          </div></div>';
}
$result = mysqli_query($db_con, "select FA.apellidos, FA.nombre, FA.unidad, FA.nc, Fe.fecha, Fe.notas, Fe.asunto, Fe.informa, Fe.grave, Fe.medida, listafechorias.medidas2, Fe.expulsion, Fe.tutoria, Fe.inicio, Fe.fin, aula_conv, inicio_aula, fin_aula, Fe.horas, Fe.atiende, Fe.horaEnvia, Fe.horaAtiende, efectos.comentario from Fechoria as Fe, FALUMNOS as FA, listafechorias, efectos where Fe.claveal = FA.claveal and listafechorias.fechoria = Fe.asunto  and Fe.id = '$id' and Fe.medidaJefatura = efectos.id order by Fe.fecha DESC");

if ($row = mysqli_fetch_array($result))
{
	$apellidos = $row[0];
	$nombre = $row[1];
	$unidad = $row[2];
	$fecha = $row[4];
	$notas = $row[5];
	$asunto = $row[6];
	$informa = $row[7];
	$grave = $row[8];
	$medida = $row[9];
	$medidas2 = $row[10];
	$expulsion = $row[11];
	$tutoria = $row[12];
	$inicio = $row[13];
	$fin = $row[14];
	$convivencia = $row[15];
	$inicio_aula = $row[16];
	$fin_aula = $row[17];
	$horas = $row[18];
	$atiende = $row[19];
	$horaEnvia = $row[20];
	$horaAtiende = $row[21];
	$medidaJefatura = $row[22];
		
 	if($inicio){ $inicio1 = explode("-",$inicio); $inicio = $inicio1[2] . "-" . $inicio1[1] ."-" . $inicio1[0];}
    if($fin){ $fin1 = explode("-",$fin); $fin = $fin1[2] . "-" . $fin1[1] ."-" . $fin1[0];}
	if($inicio_aula){ $inicio1 = explode("-",$inicio_aula); $inicio_aula = $inicio1[2] . "-" . $inicio1[1] ."-" . $inicio1[0];}
    if($fin_aula){ $fin1 = explode("-",$fin_aula); $fin_aula = $fin1[2] . "-" . $fin1[1] ."-" . $fin1[0];}
}
$consulta = mysqli_query($db_con, "select count(*) from Fechoria where claveal = '".$claveal."' and fecha >= '".$config['curso_inicio']."'"); 
$nt= mysqli_fetch_row($consulta);
$numerototal = $nt[0];

$consulta = mysqli_query($db_con, "select count(*) from Fechoria where claveal = '".$claveal."' and fecha >= '".$config['curso_inicio']."' and grave = 'grave'"); 
$nt= mysqli_fetch_row($consulta);
$numerograves = $nt[0];

$consulta = mysqli_query($db_con, "select count(*) from Fechoria where claveal = '".$claveal."' and fecha >= '".$config['curso_inicio']."' and grave = 'muy grave'"); 
$nt= mysqli_fetch_row($consulta);
$numeromuygraves = $nt[0];

$consulta = mysqli_query($db_con, "select count(*) from Fechoria where claveal = '".$claveal."' and fecha >= '".$config['curso_inicio']."' and expulsion >= '1'"); 
$nt= mysqli_fetch_row($consulta);
$numeroexpulsiones = $nt[0];	
?>
<legend align="center">
  <?php echo "$nombre $apellidos ($unidad)";?>
  </legend>
  <br />
<div class="row">
  <div class="col-sm-7">
      <div class="well well-large">
      <?php
            if(file_exists("../../xml/fotos/".$claveal.".jpg")){
echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-bottom:-145px' class='img-thumbnail img-circle pull-right hidden-phone' />";
            }
            ?>
        <table class="table table-striped">
          <tr>
            <th colspan="5"><h4>Información detallada sobre el Problema</h4></th>
          </tr>
          <tr>
            <th>NOMBRE</th>
            <td colspan="4"><?php echo $nombre." ".$apellidos; ?>
            </td>
          </tr>
          <tr>
            <th>GRUPO</th>
            <td colspan="4"><?php echo $unidad; ?></td>
          </tr>
          <tr>
            <th>FECHA</th>
            <td colspan="4"><?php echo $fecha; ?></td>
          </tr>
          <tr>
            <th>OBSERVACIONES</th>
            <td colspan="4"><?php echo $notas; ?></td>
          </tr>
          <tr>
            <th>ASUNTO</th>
            <td colspan="4"><?php echo $asunto; ?></td>
          </tr>
          <tr>
            <th>MEDIDAS</th>
            <td colspan="4"><?php echo $medida; ?></td>
          </tr>
          <tr>
            <th>GRAVEDAD</th>
            <td colspan="4"><?php echo $grave; ?></td>
          </tr>
          <tr>
            <th>ANTECEDENTES</th>
            <td >Totales: <?php echo $numerototal; ?></td>
            <td >Graves: <?php echo $numerograves; ?></td>
            <td >Muy Graves: <?php echo $numeromuygraves; ?></td>
            <td >Expulsiones: <?php echo $numeroexpulsiones; ?></td>
          </tr>
          <tr>
            <th>PROTOCOLOS</th>
            <td colspan="4"><?php echo $medidas2; ?></td>
          </tr>
          <tr>
            <th>PROF. ENVÍA</th>
            <td colspan="3"><?php echo $informa; ?></td>
			<th>HORA: </th>
            <td colspan="1"><?php echo $horaEnvia; ?></td>
          </tr>
		  <tr>
            <th>PROF. ATIENDE</th>
            <td colspan="3"><?php echo $atiende; ?></td>
			<th>HORA: </th>
            <td colspan="1"><?php echo $horaAtiende; ?></td>
          </tr>
        </table>
        <br />
	<div align="center">
		<form id="formParte" name="formParte" method="post" target="_blank" action="imprimir/parte.php">
    	  	<input name="id" type="hidden" value="<?php echo $id;?>" />
   		  	<input name="claveal" type="hidden" value="<?php echo $claveal;?>" />
			
			<input name="numTotal" type="hidden" value="<?php echo $numerototal;?>" />
			<input name="numGraves" type="hidden" value="<?php echo $numerograves;?>" />
			<input name="numMuyGraves" type="hidden" value="<?php echo $numeromuygraves;?>" />
			<input name="numExpulsiones" type="hidden" value="<?php echo $numeroexpulsiones;?>" />

      		<input name="fechainicio" type="hidden" id="textfield2" size="10" maxlength="10" <?php if($inicio){echo "value=$inicio";}?> />
      		<input name="fechafin" type="hidden" id="textfield3" size="10" maxlength="10" <?php if($fin){echo "value=$fin";}?> />
			<?php if($grave <> 'leve') {echo "<input type='submit' name='imprimir' value='Imprimir Parte' class='btn btn-danger'/>";}?> 
    		
        	<a href="../informes/index.php?claveal=<?php echo $claveal;?>&todos=1" target="_blank" class="btn btn-primary">Ver Informe del Alumno</a> 
        	<a href="../jefatura/index.php?alumno=<?php echo $apellidos.", ".$nombre;?>&unidad=<?php echo $unidad;?>&grupo=<?php echo $grupo;?>" target="_blank" class="btn btn-primary">Registrar intervención de Jefatura</a>
	</form>
    </div>
	</div>
    <hr>
    <br />
    <h4>Problemas de Convivencia en el Curso</h4>
    <?php
    echo "<br /><table class='table table-striped' style='width:auto;'>";
	echo "<tr>
		<th>Fecha</th>
		<th>Tipo</th>
		<th>Gravedad</th>
		<th></th>
		</tr>";
	// Consulta de datos del alumno.
	$result = mysqli_query($db_con, "select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.grave, Fechoria.id from Fechoria where claveal = '$claveal' and fecha >= '".$config['curso_inicio']."' order by fecha DESC" );
	
	while ( $row = mysqli_fetch_array ( $result ) ) {
		echo "<tr>
	<td nowrap>$row[0]</td>
	<td>$row[1]</td>
	<td>$row[2]</td>
	<td nowrap><a href='detfechorias.php?id= $row[3]&claveal=$claveal' data-bs='tooltip' title='Detalles'><i class='fa fa-search fa-fw fa-lg'></i></a><a href='delfechorias.php?id= $row[3]' data-bs='tooltip' title='Eliminar'><i class='fa fa-trash-o fa-fw fa-lg'></i></a></td>
	</tr>";
	}
	echo "</table>\n";
    ?>
    
  </div>

  
  <div class="col-sm-5">
    <?php
   $pr = $_SESSION ['profi'];
   $conv = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo like '%b%' AND nombre = '$pr'");
   if (mysqli_num_rows($conv) > '0') {$gucon = '1';}
   if (mysqli_num_rows($expulsion) > '0') {$expul = '1';}
   if(stristr($_SESSION['cargo'],'1') == TRUE or $gucon == '1' or stristr($_SESSION['cargo'],'8') == TRUE)
	{
	if (stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE) {
	?>
    
    <div class="well"><h4>Expulsión del centro</h4><br>
    <form id="form1" name="form1" method="post" action="detfechorias.php" class="">


	    <div class="form-group">
		<label> N&ordm; de D&iacute;as:</label>
        <input name="expulsion" type="text" id="textfield" <?php if($expulsion > 0){echo "value=$expulsion";}?> maxlength="2" class="form-control" />
        
    </div>   
    <input name="id" type="hidden" value="<?php echo $id; ?>"/>
    <input name="claveal" type="hidden" value="<?php echo $claveal; ?>"/>
 

<div class="row">	
		<div class="col-sm-6">
			<div class="form-group " id="datetimepicker1">
				<label>Inicio:</label>
				<div class="input-group">
  				<input name="inicio" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="inicio" <?php if(strlen($inicio) > '0' and !($inicio == '00-00-0000')){echo "value='$inicio'";}?>  >
  				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
			</div>
		</div>		
	
		<div class="col-sm-6">
			<div class="form-group " id="datetimepicker2">
			<label>Fin:</label>
			<div class="input-group">
  				<input name="fin" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fin" <?php if(strlen($fin) > '0' and !($fin == '00-00-0000')){echo "value='$fin'";}?>  >
  				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			</div>
		</div> 
	</div>
</div>

<div class="row">
<?php if($config['mod_sms']){?>      
   <div class="form-group col-sm-4">
      <div class="checkbox">    
         <label>
         <input name="mens_movil" type="checkbox" id="sms" value="envia_sms" checked="checked" />
        Enviar SMS </label>
      </div>
      </div>
 <?php } ?>
  <div class="form-group col-sm-4">
    <div class="checkbox">
      <label for='tareas'>
	 <input name="tareas_exp" type="checkbox" id="tareas" value="insertareas_exp" checked="checked" />
      Activar Tareas
      </label>
    </div>
   </div>
   <div class="form-group col-sm-4">
      <div class="checkbox pull-right">    
         <label>
         <input name="borrar_exp" type="checkbox" id="borrar_exp" value="<?php echo $id;?>" />
        Borrar datos </label>
      </div>
      </div>
      </div>
        <input name="submit" type="submit" value="Enviar datos" class="btn btn-primary" />
      
    </form>
    </div>
    <?php } ?>
    <?php 
 $hora = date ( "G" ); // hora
	$ndia = date ( "w" );
	if (($hora == '8' and $minutos > 15) or ($hora == '9' and $minutos < 15)) {
		$hora_dia = '1';
	} elseif (($hora == '9' and $minutos > 15) or ($hora == '10' and $minutos < 15)) {
		$hora_dia = '2';
	} elseif (($hora == '10' and $minutos > 15) or ($hora == '11' and $minutos < 15)) {
		$hora_dia = '3';
	} elseif (($hora == '11' and $minutos > 15) or ($hora == '11' and $minutos < 45)) {
		$hora_dia = 'R';
	} elseif (($hora == '11' and $minutos > 45) or ($hora == '12' and $minutos < 45)) {
		$hora_dia = '4';
	} elseif (($hora == '12' and $minutos > 45) or ($hora == '13' and $minutos < 45)) {
		$hora_dia = '5';
	} elseif (($hora == '13' and $minutos > 45) or ($hora == '14' and $minutos < 45)) {
		$hora_dia = '6';
	} else {
		$hora_dia = "0";
	}	
 ?>

 <div class="well">
    <h4>Expulsi&oacute;n al A.T.I. </h4><br>
    <form id="form2" name="form2" method="post" action="detfechorias.php" >
		<div class="row">	
			<div class="col-sm-6">
      			<div class="form-group">
      				<label >N&uacute;mero de D&iacute;as</label>
        			<input name="convivencia" type="text" id="expulsion" <?php if($convivencia > 0){echo "value=$convivencia";}?> maxlength="2" class="form-control" />
      			</div>
      		</div>
			<div class="col-sm-6">
      			<div class="form-group">
      				<label >Horas sueltas</label>
        			<input name="horas" type="text" <?php if($horas > 0){echo "value=$horas";}else{ 
          			if (stristr($_SESSION['cargo'],'1') == TRUE) {	echo "value=123456";
          			}
					else{
          				echo "value=$hora_dia";
	          			}
          			}
          		?> size="6" maxlength="6" class="form-control" />
            	</div>
			</div>
        	<input name="id" type="hidden" value="<?php echo $id;?>" />
        	<input name="claveal" type="hidden" value="<?php echo $claveal;?>" />
		</div>

<div class="row">	
	<div class="col-sm-6">
		<div class="form-group"  id="datetimepicker3">
			<label>Inicio:</label>
			<div class="input-group">
				<input name="fechainicio" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fechainicio" <?php if(strlen($inicio_aula) > '0' and !($inicio_aula == '00-00-0000')){echo "value='$inicio_aula'";}?> >
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			</div>
		</div>
	</div> 
	<div class="col-sm-6">
    		<div class="form-group" id="datetimepicker4">
			<label>Fin:</label>
			<div class="input-group">
				<input name="fechafin" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fechafin" <?php if(strlen($fin_aula) > '0' and !($fin_aula == '00-00-0000')){echo "value='$fin_aula'";}?> >
  				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			</div>
		</div> 
	</div>
</div>

	<div class="row">
          <div class="form-group col-sm-4">
          <div class="checkbox">
         <label for='tareas'>
          <input name="tareas" type="checkbox" id="tareas" value="insertareas" <?php if ($gucon == '1') {}else{          	echo 'checked="checked"';
          }?> />
          Activar Tareas
          </label>
          </div>
          </div>
          <?php if($config['mod_sms']){ ?>
          <div class="form-group  col-sm-4">
           <div class="checkbox">
          <label for='sms'>
          <input name="mens_movil" type="checkbox" id="sms" value="envia_sms" checked="checked"  />
          Enviar SMS
          </label>
          </div>             
          </div>
          <?php } ?>
          <div class="form-group  col-sm-4">
           <div class="checkbox">
          <label for='borrar_aula'>
          <input name="borrar_aula" type="checkbox" id="borrar_aula" value="<?php echo $id;?>"  />
          Borrar datos
          </label>
          </div>
          </div>
	</div>
	<input type="submit" name="imprimir4" value="Enviar datos" class="btn btn-primary"/>    
</form>
</div>


<div class="well">
	<h4>Otras medidas aplicadas por Jefatura</h4><br>
    <form id="form1" name="form3" method="post" action="detfechorias.php" class="">
		<div class="form-group">
			<label>Medida:</label>	
			<select	class="form-control" id="medidaJefatura" name="medidaJefatura" required>
			<?php if (isset($medidaJefatura))
				echo '<OPTION value="">'.$medidaJefatura.'</OPTION>';?>
			<option><?php $sql0 = mysqli_query($db_con, "select id,nombre,comentario from efectos");
				while($accion = mysqli_fetch_array($sql0)) {
					echo '<OPTION value="'.$accion[0].'">'.$accion[2].'</OPTION>';
				}?>
			</option>
			</select>
		</div>   
	    <input name="id" type="hidden" value="<?php echo $id; ?>"/>
	    <input name="claveal" type="hidden" value="<?php echo $claveal; ?>"/>
	    <input name="submit" type="submit" value="Enviar datos" class="btn btn-primary" />      
    </form>
</div>

<?php } ?>

<div>
	<div class="well">
		<h4>Impresión de partes</h4><br>
    <?php
	if(stristr($_SESSION['cargo'],'1') == TRUE)
	{
		?>
    <h6>EXPULSI&Oacute;N DEL CENTRO</h6>
    <form id="form2" name="form2" method="post" action="imprimir/expulsioncentro.php">
      <input name="id" type="hidden" value="<?php echo $id;?>" />
      <input name="claveal" type="hidden" value="<?php echo $claveal;?>" />
      <input name="fechainicio" type="hidden" id="textfield2" size="10" maxlength="10" <?php if($inicio){echo "value=$inicio";}?> />
      <input name="fechafin" type="hidden" id="textfield3" size="10" maxlength="10" <?php if($fin){echo "value=$fin";}?> />
      <input type="submit" name="imprimir" value="Expulsi&oacute;n del Centro" class="btn btn-danger"/>
      
    </form>
    <h6>EXPULSI&Oacute;N AL A.T.I.</h6>
    
      <form id="form3" name="form3" method="post" action="imprimir/convivencia.php">
        <input name="id" type="hidden" value="<?php echo $id;?>" />
        <input name="claveal" type="hidden" value="<?php echo $claveal;?>" />
        <input name="fechainicio" type="hidden" id="textfield2" size="10" maxlength="10" <?php if($inicio_aula){echo "value=$inicio_aula";}?> />
        <input name="fechafin" type="hidden" id="textfield3" size="10" maxlength="10" <?php if($fin_aula){echo "value=$fin_aula";}?> />
        <input name="horas" type="hidden" value="<?php echo $horas;?>" />
        <input type="submit" name="imprimir5" value="A.T.I."  class="btn btn-danger" />
      </form>
        <?php
}
   ?>
    <h6>EXPULSI&Oacute;N
      DEL AULA </h6>
    <form id="form3" name="form3" method="post" action="imprimir/expulsionaula.php">
      
        <input name="id" type="hidden" value="<?php echo $id;?>" />
        <input name="claveal" type="hidden" value="<?php echo $claveal;?>" />
        <input type="submit" name="imprimir2" value="Parte de Expulsi&oacute;n del Aula" class="btn btn-danger" />
      
    </form>
    <h6>AMONESTACI&Oacute;N ESCRITA </h6>
    <form id="form3" name="form3" method="post" action="imprimir/amonestescrita.php">
      
        <input name="id" type="hidden" value="<?php echo $id;?>" />
        <input name="claveal" type="hidden" value="<?php echo $claveal;?>" />
        <input type="submit" name="imprimir3" value="Amonestaci&oacute;n escrita " class="btn btn-danger" />
      
    </form>
    </div>
  </div>
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
		});
		
		$('#datetimepicker2').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datetimepicker3').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datetimepicker4').datetimepicker({
			language: 'es',
			pickTime: false
		});
	});  
	</script>
</body>
</html>
