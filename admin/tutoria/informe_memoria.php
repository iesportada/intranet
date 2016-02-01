<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2, 8));

// COMPROBAMOS SI ES EL TUTOR, SINO ES DEL EQ. DIRECTIVO U ORIENTADOR
if (stristr($_SESSION['cargo'],'2') == TRUE) {
	
	$_SESSION['mod_tutoria']['tutor']  = $_SESSION['mod_tutoria']['tutor'];
	$_SESSION['mod_tutoria']['unidad'] = $_SESSION['mod_tutoria']['unidad'];
	
}
else {

	if(isset($_POST['tutor'])) {
		$exp_tutor = explode('==>', $_POST['tutor']);
		$_SESSION['mod_tutoria']['tutor'] = trim($exp_tutor[0]);
		$_SESSION['mod_tutoria']['unidad'] = trim($exp_tutor[1]);
	}
	else{
		if (!isset($_SESSION['mod_tutoria'])) {
			header('Location:'.'tutores.php');
		}
	}
	
}



if (isset($_GET['imprimir'])) {
	$imprimir = $_GET['imprimir'];
}
if (isset($_POST['observaciones1'])) {
	$observaciones1 = $_POST['observaciones1'];
}
if (isset($_POST['observaciones2'])) {
	$observaciones2 = $_POST['observaciones2'];
}


include("../../menu.php");
include("menu.php");
?>
<style type="text/css">
@media print {
	body {
		font-size: 10px;
	}
	h2 {
		font-size: 22px;
	}
	
	h3 {
		font-size: 16px;
	}
	
	h4 {
		font-size: 18px;
	}
	.container {
		width: 100%;
	}
}
</style>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2 style="display:inline;">Tutoría de <?php echo $_SESSION['mod_tutoria']['unidad']; ?></h2>
	 	
	 	<!-- Button trigger modal -->
 		<a href="#" class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
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
 						<p>La Memoria de Tutoría ofrece a los Tutores un informe completo sobre 
 						los datos más relevantes que se han generado a lo largo del Curso escolar 
 						en relación con su Grupo de Alumnos. Presenta en primer lugar un conjunto 
 						de datos estadísticos de carácter general, y otro más específico sobre 
 						Problemas de Convivencia del Grupo. A partir de ahí, se muestran datos por 
 						Alumno sobre Faltas de Asistencia, Problemas de Convivencia, Expulsiones, 
 						Absentismo escolar, Visitas de Padres, Intervenciones del Tutor, 
 						Actividades Extraescolares y estadísticas de calificaciones en las 
 						distintas asignaturas del Tutor.</p>
 						<p>En la parte superior derecha de la página aparece un botón con el título 
 						'Redactar Observaciones finales'. Al hacer click sobre este botón se nos 
 						presenta un cuadro de texto en el que procedemos a escribir la valoración 
 						que el Tutor realiza sobre el Grupo y su Tutoría, así como cualquier otro 
 						elemento que considere relevante. Una vez rellenado el campo de observaciones, 
 						el botón cambia a 'Imprimir Memoria de Tutoría' y ya está lista para presentar 
 						en Jefatura de Estudios. Las observaciones aparecen en la parte inferior de 
 						la Memoria, y pueden ser editadas en todo momento hasta su impresión.</p>
 					</div>
 					<div class="modal-footer">
 						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
 					</div>
 				</div>
 			</div>
 		</div>
	 
		<h4 class="text-info">Tutor: <?php echo nomprofesor($_SESSION['mod_tutoria']['tutor']); ?></h4>
	</div>

 <?php
if (isset($_POST['imp_memoria'])) {
	mysqli_query($db_con, "update FTUTORES set observaciones1 = '$observaciones1', observaciones2='$observaciones2' where tutor = '".$_SESSION['mod_tutoria']['tutor']."'");
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Las observaciones que has redactado han sido guardadas. Puedes añadir y editar el texto tantas veces como quieras. O puedes volver a la página de la memoria e imprimirla para entregarla en Jefatura.
</div></div><br />';
	echo '<center><input type="button" value="Volver a la Memoria de Tutoría" name="boton" onclick="window.location.href = \'informe_memoria.php\'" class="btn btn-primary" /></center>';
	echo "</div>";
	include("../../pie.php");
	echo '</body></html>';
	exit();
}

 $obs1=mysqli_query($db_con, "select observaciones1, observaciones2 from FTUTORES where tutor = '".$_SESSION['mod_tutoria']['tutor']."'");
 $obs2=mysqli_fetch_array($obs1);
 if (empty($obs2[0]) && empty($obs[1]) && date('m')==06) {$boton = "Redactar Observaciones finales para imprimir";$click="onclick=\"window.location.href = 'informe_memoria.php?imprimir=1#observaciones'\"";}
 	else{
		$boton = "Imprimir Memoria final de Tutoría";$click="onClick=print()";}
 ?>
  <div style="margin-bottom:0px;">
 <input type="button" class="btn btn-primary hidden-print pull-right" value="<?php echo $boton;?>" <?php echo $click;?>>
</div>
 
<br>
<br />
 <h3>Datos Generales de los Alumnos</h3><br />
 <?php 
 // Curso
 $SQL0 = "select distinct curso from alma where unidad = '".$_SESSION['mod_tutoria']['unidad']."'";
 $result0 = mysqli_query($db_con, $SQL0);
 $max00 = mysqli_fetch_row($result0);
 $curso_seneca = $max00[0];
// Alumnos que se integran a lo largo del Curso
 $SQL = "select max(NC) from FALUMNOS_primero where unidad = '".$_SESSION['mod_tutoria']['unidad']."'";
 $result = mysqli_query($db_con, $SQL);
 $max0 = mysqli_fetch_row($result);
 $num_0 =  $max0[0];
 $SQL1 = "select max(NC) from FALUMNOS where unidad = '".$_SESSION['mod_tutoria']['unidad']."'";
 $result1 = mysqli_query($db_con, $SQL1);
 $max1 = mysqli_fetch_row($result1);
 $num_1 =  $max1[0];
 $nuevos = $num_1-$num_0;
 $nuevos = str_replace("-","",$nuevos);
 
// Alumnos repetidores
 $SQL = "select * from alma where unidad = '".$_SESSION['mod_tutoria']['unidad']."' and matriculas > '1'";
 $result = mysqli_query($db_con, $SQL);
 $num_repetidores = mysqli_num_rows($result);

// Alumnos a comienzo de Curso
 $SQL = "select * from FALUMNOS_primero where unidad = '".$_SESSION['mod_tutoria']['unidad']."'";
 $result = mysqli_query($db_con, $SQL);
 $num_empiezan = mysqli_num_rows($result);
 
 // Alumnos a final de Curso
 $SQL = "select * from alma where unidad = '".$_SESSION['mod_tutoria']['unidad']."'";
 $result = mysqli_query($db_con, $SQL);
 $num_acaban = mysqli_num_rows($result);

 // Alumnos que promocionan en Junio
 $SQL1 = "select notas3, apellidos, nombre from notas, alma where notas.claveal = alma.claveal1  and unidad = '".$_SESSION['mod_tutoria']['unidad']."'";
 $result1 = mysqli_query($db_con, $SQL1);

 while ($num_promo0 = mysqli_fetch_array($result1))                                                                                                                                                           
{                                                                                                                                                                                               
        $n_susp = "";                                                                                                                                                                                        
        $trozos0 = explode(";",$num_promo0[0]);                                                                                                                                                              
        foreach ($trozos0 as $val)                                                                                                                                                                           
        {                                                                                                                                                                                                    
        $trozos1 = explode(":",$val);                                                                                                                                                                        
                {                                                                                                                                                                                            
                if (stristr($curso_seneca,"Bach")==TRUE)                                                                                                                                                                          
                        {                                                                                                                                                                       
                        if (($trozos1[1] > "416" and $trozos1[1] < "427") or ($trozos1[1] == "439"))          
                                {                                                                                                                                                                            
                                    $n_susp++;                                                                                                                                                                       
                                }                                                                                                                                                                            
                        }                                                                                                                                                                                                                                                                                                                                                                       
                else                                                                                                                                                            
                        {                                                                                                                                                                                    
                if (($trozos1[1] > "336" and $trozos1[1] < "347" and $trozos1[1] !== "339" and $trozos1[1] !== ""))                                                                                          
                                {                                                                                                                                                                            
                                    $n_susp++;                                                                                                                                                                       
                                }                                                                                                                                                                            
                        }                                                                                                                                                                                    
                }                                                                                                                                                                                            
        }                                                                                                                                                                                                    
 if ($n_susp > "0" and (((stristr($curso_seneca,"2")==TRUE) and (stristr($curso_seneca,"Bach")==TRUE))  or (stristr($curso_seneca,"4")==TRUE)))                                                                                                                                                                       
        {                                                                                                                                                                                                    
//              $valor = $valor ."$n_susp: $num_promo0[2] $num_promo0[1] --> $num_promo0[0]<br>";                                                                                                            
                $n_al = $n_al + 1;                                                                                                                                                                           
        }                                                                                                                                                                                                    
        elseif($n_susp > "2" and !(((stristr($curso_seneca,"2")==TRUE) and (stristr($curso_seneca,"Bach")==TRUE))  or (stristr($curso_seneca,"4")==TRUE)))                                                                                                                                                          
        {                                                                                                                                                                                                    
//              $valor = $valor ."$n_susp: $num_promo0[2] $num_promo0[1] --> $num_promo0[0]<br>";                                                                                                            
                $n_al = $n_al + 1;                                                                                                                                                                           
        }                                                                                                                                                                                       }    

?>
<table class="table table-bordered table-striped">
<tr>
    <th>Comienzan el Curso</th>
    <th>Terminan el Curso</th>
    <th>No Promocionan</th>
    <th>Promocionan</th>
    <th>Repetidores</th>
    <th>Nuevas Incorporaciones</th>
</tr>
<tr>
	<td><?php echo $num_empiezan; ?></td>
    <td><?php echo $num_acaban; ?></td>
    <td><?php echo $n_al; // echo "<br>".$valor;?></td> 
    <td><?php echo $num_acaban-$n_al; ?></td> 
    <td><?php echo $num_repetidores; ?></td> 
    <td><?php echo $nuevos; ?></td>     
    </tr>
</table>
<?php
// Tabla de Absentismo.
 $faltas = "select distinct claveal from absentismo where unidad = '".$_SESSION['mod_tutoria']['unidad']."' order by claveal";
 $faltas0 = mysqli_query($db_con, $faltas);
 $num_faltas = mysqli_num_rows($faltas0);
  ?>
 <?php 
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and grave = 'leve' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and grave = 'grave' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and grave = 'muy grave' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and expulsion > '0' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and expulsion > '0' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and expulsionaula = '1' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select distinct id from infotut_alumno where unidad = '".$_SESSION['mod_tutoria']['unidad']."' order by claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select id from tutoria where unidad = '".$_SESSION['mod_tutoria']['unidad']."' and prohibido not like '1' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones = mysqli_num_rows($result);
 ?>
   <?php  
 $grupo_act = $_SESSION['mod_tutoria']['unidad'];  
 $SQL = "select * from calendario where unidades like '%$grupo_act%' and categoria='2' and date(fechaini) > '".$config['curso_inicio']."'";
 $result = mysqli_query($db_con, $SQL);
 $num_actividades = mysqli_num_rows($result);
 ?>
 <table class="table table-bordered table-striped">
<tr>
    <th>Absentismo</th>
    <th>Problemas de Convivencia</th>
    <th>Informes de Tutor&iacute;a (Visitas de Padres)</th>
    <th>Intervenciones del Tutor</th>
    <th>Actividades Extraescolares</th>
</tr>
<tr>
	<td><?php echo $num_faltas; ?></td>
    <td><?php echo $num_conv; ?></td>
    <td><?php echo $num_informes; ?></td> 
    <td><?php echo $num_acciones; ?></td>
    <td><?php echo $num_actividades; ?></td>
</tr>
</table>
<hr>
 <br />
 <h3>Informaci&oacute;n sobre Problemas de Convivencia</h3><br />
 <table class="table table-bordered table-striped">
<tr>
    <th>Problemas Leves</th>
    <th>Problemas Graves</th>
	<th>Problemas Muy Graves</th>
    <th>Expulsiones</th>
    <th>Alumnos Expulsados</th>
	<th>Expulsi&oacute;n del Aula</th>
</tr>
<tr>
    <td><?php echo $num_leves; ?></td>
    <td><?php echo $num_graves; ?></td>
    <td><?php echo $num_muygraves; ?></td>	
    <td><?php echo $num_expulsion; ?></td>
    <td><?php echo $num_expulsados; ?></td>
	<td><?php echo $num_expulsadosaula; ?></td>
</tr>
</table>

 
 <hr><br /><h3>Información de Tutoría por Alumno</h3>
  <div class="row">     
 <div class="col-sm-6">
 <hr><br /><h3>Alumnos absentistas</h3>

<?php
$faltas = "select distinct absentismo.claveal, count(*), nombre, apellidos from absentismo, FALUMNOS where absentismo.claveal = FALUMNOS.claveal and absentismo.unidad = '".$_SESSION['mod_tutoria']['unidad']."'  group by apellidos, nombre";
 $faltas0 = mysqli_query($db_con, $faltas);
 if(mysqli_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-bordered table-striped">';
 while($absentista = mysqli_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$absentista[2] .' '. $absentista[3].'</td><td>'.$absentista[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
 </div> 

  <div class="col-sm-6">       
 <hr><br /><h3>Faltas sin Justificar</h3>

<?php
 echo "<table class='table table-bordered table-striped'>";
		
$SQL = "select distinct FALTAS.claveal, count(*), apellidos, nombre from FALTAS, FALUMNOS  where FALTAS .claveal = FALUMNOS .claveal and FALTAS.falta = 'F' and FALTAS.unidad = '".$_SESSION['mod_tutoria']['unidad']."' and date(fecha) > '".$config['curso_inicio']."' group BY apellidos, nombre";
$result = mysqli_query($db_con, $SQL);

  if ($row = mysqli_fetch_array($result))
        {
	$hoy = date("d"). "-" . date("m") . "-" . date("Y");
                do {
	$claveal = $row[0];
          echo "<tr><td style='text-align:left'>$row[2], $row[3]</td><td style='text-align:left'>$row[1]</td></tr>";
        } while($row = mysqli_fetch_array($result));
        }
		        echo "</table>";
  ?>
</div>
</div>
  <div class="row">     
 <div class="col-sm-4">
  <hr><br /><h3>Problemas de Convivencia</h3>

<?php
$faltas = "select distinct Fechoria.claveal, count(*), nombre, apellidos from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and date(fecha) > '".$config['curso_inicio']."' group by NC";
 $faltas0 = mysqli_query($db_con, $faltas);
 if(mysqli_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-bordered table-striped">';
  while($fech = mysqli_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$fech[2] .' '. $fech[3].'</td><td>'.$fech[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
                   </div>
                    <div class="col-sm-4">
                    <hr><br /><h3>Alumnos expulsados</h3>

<?php
  
 
 $faltas = "select distinct Fechoria.claveal, count(*), nombre, apellidos from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and expulsion > '0' and date(fecha) > '".$config['curso_inicio']."' group by NC";
 $faltas0 = mysqli_query($db_con, $faltas);
 if(mysqli_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-bordered table-striped">';
 while($exp = mysqli_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$exp[2] .' '. $exp[3].'</td><td>'.$exp[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
 </div> <div class="col-sm-4"><hr><br /><h3>Alumnos expulsados del aula</h3>

 <?php
$faltas = "select distinct Fechoria.claveal, count(*), nombre, apellidos from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and unidad = '".$_SESSION['mod_tutoria']['unidad']."' and expulsionaula = '1' and date(fecha) > '".$config['curso_inicio']."' group by NC";
 $faltas0 = mysqli_query($db_con, $faltas);
 if(mysqli_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-striped" style="width:auto;">';
 while($exp = mysqli_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$exp[2] .' '. $exp[3].'</td><td>'.$exp[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
 </div>
 </div>
 
 <hr><br /><h3>Informes de Tutoría por visita de padres</h3>

<?php
 $faltas = "select distinct claveal, count(*), nombre, apellidos from infotut_alumno where unidad = '".$_SESSION['mod_tutoria']['unidad']."' and date(F_ENTREV) > '".$config['curso_inicio']."' group by apellidos";
 $faltas0 = mysqli_query($db_con, $faltas);
 if(mysqli_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-bordered table-striped" style="width: auto;">';
 while($infotut = mysqli_fetch_array($faltas0))
 {
 echo '<tr>
<td class="col-sm-6" style="text-align:left">'.$infotut[2] .' '. $infotut[3].'</td><td class="col-sm-1">'.$infotut[1].'</td>
</tr>';
 }
 echo '</table>';
 }
 ?>
 <div class="row">
  <div class="col-sm-5">
<hr><br /><h3>Intervenciones del Tutor</h3>

<?php
 $faltas = "select distinct apellidos, nombre, count(*) from tutoria where unidad = '".$_SESSION['mod_tutoria']['unidad']."' and prohibido not like '1' and date(fecha) > '".$config['curso_inicio']."' group by apellidos";
 $faltas0 = mysqli_query($db_con, $faltas);
 if(mysqli_num_rows($faltas0) > 0)
 {
 echo '<table class="table table-bordered table-striped">';
 while($tutoria = mysqli_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left">'.$tutoria[1] .' '. $tutoria[0].'</td><td>'.$tutoria[2].'</td>
</tr>';
 }
 echo '</table>';
 }
 
 $faltas = "select distinct apellidos, nombre, causa, accion, observaciones from tutoria where unidad = '".$_SESSION['mod_tutoria']['unidad']."' and prohibido not like '1' and accion not like '%SMS%'  and date(fecha) > '".$config['curso_inicio']."' order by apellidos";
 $faltas0 = mysqli_query($db_con, $faltas);
 if(mysqli_num_rows($faltas0) > 0)
 {
	 ?>
	 </div> 
	 <div class="col-sm-7">
 <hr><br /><h3>Intervenciones de Tutoría (excluidos SMS)</h3>

     <?php
 echo '<table class="table table-bordered table-striped">';
 while($tutoria = mysqli_fetch_array($faltas0))
 {
 echo '<tr>
<td style="text-align:left" nowrap>'.$tutoria[0] .', '. $tutoria[1].'</td><td style="text-align:left" >'.$tutoria[2].'</td><td style="text-align:left" >'.$tutoria[3].'</td>
</tr>';
 }
 echo '</table>';
 }
  $grupo_act2 = $_SESSION['mod_tutoria']['unidad'];  
  $n_activ = mysqli_query($db_con, "select * from calendario where  unidades like '%$grupo_act2%' and date(fechaini) > '".$config['curso_inicio']."'");
  if(mysqli_num_rows($n_activ) > "0"){
 ?>
  </div>
  </div>
  
 <hr><br /><h3>Informe sobre Actividades Extraescolares del Grupo</h3>
 <?php
include("inc_actividades.php");
 }
  ?>
 <br />
 <?php
include("inc_notas.php");
 ?>
<?php

if($imprimir == "1" or strlen($obs2[0]) > "1" or strlen($obs[1])>"1")
{
?>
<a name="observaciones" id="obs"></a>
<hr><br /><h3>
 Observaciones sobre dificultades encontradas en el Grupo<br />(Integración, Motivación, Rendimiento académico, etc.)</h3>
 <form action="" method="POST">
 <textarea class="form-control" name="observaciones1" rows="7"><?php echo $obs2[0];?></textarea>
 <hr>
<br />
<h3>
 Otras Observaciones</h3>
 <textarea class="form-control" name="observaciones2" rows="7"><?php echo $obs2[1];?></textarea>
 <br />
<input type="hidden" name="tutor" value="<?php echo $_SESSION['mod_tutoria']['tutor']; ?>">
<input type="hidden" name="unidad" value="<?php echo $_SESSION['mod_tutoria']['unidad']; ?>">
<br />
<input type="submit" name="imp_memoria" value="Enviar datos" class="btn btn-primary hidden-print">
</form>
<?php
if((strlen($obs2[0]) > "1" or strlen($obs[1])>"1"))
{
?>
<br />
  <p align="center">En <?php echo $config['centro_localidad']; ?> a   <?php $today = date("d") . "/" . date("m") . "/" . date("Y"); echo $today;?></p>
  <br>
<p align="center">EL Tutor</p>
<br>
<br>
<br>
<p align="center">Fdo. <?php  echo $_SESSION['mod_tutoria']['tutor']; ?></p>
<br />
<?php
}
}
 ?>
 </div>
 </div>
 </div>
 <script language="JavaScript">
 function doPrint(){
 document.all.item("noprint").style.visibility='hidden' 
 window.print()
 document.all.item("noprint").style.visibility='visible'
 }
 </script>
 <script type="text/javascript">
 function countLines(strtocount, cols) {
     var hard_lines = 1;
     var last = 0;
     while ( true ) {
         last = strtocount.indexOf("\n", last+1);
         hard_lines ++;
         if ( last == -1 ) break;
     }
     var soft_lines = Math.round(strtocount.length / (cols-1));
     var hard = eval("hard_lines  " + unescape("%3e") + "soft_lines;");
     if ( hard ) soft_lines = hard_lines;
     return soft_lines;
 }
 function cleanForm() {
     var the_form = document.forms[0];
     for ( var x in the_form ) {
         if ( ! the_form[x] ) continue;
         if( typeof the_form[x].rows != "number" ) continue;
         the_form[x].rows = countLines(the_form[x].value,the_form[x].cols) +3;
     }
     setTimeout("cleanForm();", 300);
 }
 </script>
 <?php include("../../pie.php"); ?>
</body>
</html>