<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2, 8));

include("../../menu.php");
?>
<div class="hidden-print">
<?php 
if (strstr($_SESSION['cargo'],"2")==FALSE) :
include("./menu.php");
endif;
?>
</div>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Informes de Tránsito <small class="hidden-print">Consulta de alumnos</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-12">
		
<?php if (isset($_GET['claveal'])) {$claveal = $_GET['claveal'];}elseif (isset($_POST['claveal'])) {$claveal = $_POST['claveal'];} ?>

<?php
// Actualizar de datos
if ($_POST['submit0']=="Actualizar datos") {
	mysqli_query($db_con,"delete from transito_datos where claveal='$claveal'");
	foreach ($_POST as $clave=>$valor){
		if ($clave!=="claveal" and $clave!=="submit0") {
			if (is_array($valor)) {
				$valo="";
				foreach ($valor as $key=>$val){
					$valo.=$val;
					}
					$valor=$valo;
			}
			mysqli_query($db_con,"insert into transito_datos values ('','$claveal','$clave','$valor')");
		}
	}
	echo '<br /><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente.
</div>';
}

$cl = mysqli_query($db_con,"select distinct claveal, apellidos, nombre, colegio, unidad from alma_primaria where claveal = '$claveal'");
$clav = mysqli_fetch_array($cl);
?>
<h3 align="center" class="text-info"><?php echo $clav[2]." ".$clav[1];?><small> Colegio <?php echo $clav[3];?> (<?php echo $clav[4];?>)</small></h3>
<br>
<?php
$ya_hay=mysqli_query($db_con,"select * from transito_datos where claveal='$claveal'");
if (mysqli_num_rows($ya_hay)>0) {
	$proc=1;
	while ($ya=mysqli_fetch_array($ya_hay)) {
		${$ya[2]}=$ya[3];
		//echo "${$ya[2]} => $ya[3]<br>";
	}
}
?>
<?php 
 if ($rep2) {$r2="checked";}
 if ($rep4) {$r4="checked";}
 if ($rep6) {$r6="checked";}
?>
<?php if ($asiste==1) {$as1="checked";}elseif ($asiste==2) {$as2="checked";}elseif ($asiste==3) {$as3="checked";}else{$asiste=="";} ?>
<?php 
 if ($dif1) {$d1="checked";}
 if ($dif2) {$d2="checked";}
 if ($dif3) {$d3="checked";}
 if ($dif4) {$d4="checked";}
 if ($dif5) {$d5="checked";}
 if ($dif6) {$d6="checked";}
 if ($dif7) {$d7="checked";}
?>
<?php 
 if ($reflen) {$ref1="checked";}
 if ($refmat) {$ref2="checked";}
 if ($refing) {$ref3="checked";}
?>
<?php 
 if (stristr($adcurrsign,"1")==TRUE) {$acs="checked";}
 if (stristr($adcurrnosign,"1")==TRUE) {$acns="checked";}
 if (stristr($necadcurrsign,"1")==TRUE) {$nacs="checked";}
 if (stristr($necadcurrnosign,"1")==TRUE) {$nacns="checked";}
?>
<?php 
 if ($acompanamiento) {$acomp="checked";}
 if ($exento) {$exen="checked";}
?>
<?php 
if ($PT_AL=="SI") {$ptal1="checked";}elseif ($PT_AL=="NO") {$ptal2="checked";}
if ($PT_AL_aula=="Aula") {$ptalaula1="checked";}elseif ($PT_AL_aula=="Fuera") {$ptalaula2="checked";}
?>
<?php 
 if ($atal) {$atl="checked";}
 if ($necatal) {$necatl="checked";}
?>
<?php if ($nacion==1) {$n1="checked";}elseif ($nacion==2) {$n2="checked";}elseif ($nacion==3) {$n3="checked";}elseif ($nacion==4) {$n4="checked";} ?>
<?php if ($integra==1) {$int1="checked";}elseif ($integra==2) {$int2="checked";}elseif ($integra==3) {$int3="checked";}elseif ($integra==4) {$int4="checked";}elseif ($integra==5) {$int5="checked";} ?>
<?php if ($relacion==1) {$rel1="checked";}elseif ($relacion==2) {$rel2="checked";}elseif ($relacion==3) {$rel3="checked";}?>
<?php if ($disruptivo==1) {$dis1="checked";}elseif ($disruptivo==2) {$dis2="checked";}elseif ($disruptivo==3) {$dis3="checked";}?>
<?php if ($expulsion==1) {$exp1="checked";}elseif ($expulsion==2) {$exp2="checked";}?>

<?php 
 if (stristr($repeticion,"2")==TRUE) {$r2="checked";}
 if (stristr($repeticion,"4")==TRUE) {$r4="checked";}
 if (stristr($repeticion,"6")==TRUE) {$r6="checked";}
 ?>
<?php if ($asiste==1) {$as1="checked";}elseif ($asiste==2) {$as2="checked";}elseif ($asiste==3) {$as3="checked";}else{$asiste=="";} ?>
<?php 
 if (stristr($dificultad,"1")==TRUE) {$d1="checked";}
 if (stristr($dificultad,"2")==TRUE) {$d2="checked";}
 if (stristr($dificultad,"3")==TRUE) {$d3="checked";}
 if (stristr($dificultad,"4")==TRUE) {$d4="checked";}
 if (stristr($dificultad,"5")==TRUE) {$d5="checked";}
 if (stristr($dificultad,"6")==TRUE) {$d6="checked";}
 if (stristr($dificultad,"7")==TRUE) {$d7="checked";}
?>
<?php 
 if (stristr($refuerzo,"Leng")==TRUE) {$ref1="checked";}
 if (stristr($refuerzo,"Mat")==TRUE) {$ref2="checked";}
 if (stristr($refuerzo,"Ing")==TRUE) {$ref3="checked";}
?>
<?php 
 if (stristr($adcurr,"Len")==TRUE) {$ac1="checked";}
 if (stristr($adcurr,"Mat")==TRUE) {$ac2="checked";}
 if (stristr($adcurr,"Ing")==TRUE) {$ac3="checked";}
?>
<?php 
 if ($acompanamiento) {$acomp="checked";}
 if ($exento) {$exen="checked";}
?>
<?php if ($nacion==1) {$n1="checked";}elseif ($nacion==2) {$n2="checked";}elseif ($nacion==3) {$n3="checked";}elseif ($nacion==4) {$n4="checked";} ?>
<?php if ($integra==1) {$int1="checked";}elseif ($integra==2) {$int2="checked";}elseif ($integra==3) {$int3="checked";}elseif ($integra==4) {$int4="checked";}elseif ($integra==5) {$int5="checked";} ?>
<?php if ($relacion==1) {$rel1="checked";}elseif ($relacion==2) {$rel2="checked";}elseif ($relacion==3) {$rel3="checked";}?>
<?php if ($disruptivo==1) {$dis1="checked";}elseif ($disruptivo==2) {$dis2="checked";}elseif ($disruptivo==3) {$dis3="checked";}?>
<?php if ($expulsion==1) {$exp1="checked";}elseif ($expulsion==2) {$exp2="checked";}?>


<form class="form-inline" method="post">

<input type="hidden" name="claveal" value="<?php echo $claveal;?>" />
<legend class="text-muted">TUTOR</legend>
<label>
  <input type="text"  style="width:300px"  name="tutor" value="<?php echo $tutor;?>" placeholder="Nombre y Apellidos del Tutor del Grupo" >
</label>
<hr>

<legend class="muted">ÁMBITO ACADÉMICO</legend>

<h5 class="text-info">Cursos Repetidos</h5>
<label class="checkbox inline">
  <input type="checkbox" name="repeticion[]" value="2 " <?php echo $r2;?>> 2º Curso
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="repeticion[]" value="4 " <?php echo $r4;?>> 4º Curso
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="repeticion[]" value="6 " <?php echo $r6;?>> 6º Curso
</label>
<hr>
<h5 class="text-info">Nº de Suspensos</h5>
<label>1ª Evaluación</label>
<select name="susp1">
  <option><?php echo $susp1;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
</select>
&nbsp;&nbsp;
<label>2ª Evaluación</label>
<select name="susp2">
  <option><?php echo $susp2;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
</select>
&nbsp;&nbsp;
<label>3ª Evaluación</label>
<select name="susp3">
  <option><?php echo $susp3;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  </select>
<hr>
<h5 class="text-info">Notas Finales</h5>
<label>Lengua</label>
<select name="leng" class="input input-mini">
<option><?php echo $leng;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Matemáticas</label>
<select name="mat" class="input input-mini">
  <option><?php echo $mat;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Inglés</label>
<select name="ing" class="input input-mini">
<option><?php echo $ing;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Conocimiento</label>
<select name="con" class="input input-mini">
<option><?php echo $con;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>8</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Ed. Física</label>
<select name="edfis" class="input input-mini">
<option><?php echo $edfis;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Música</label>
<select name="mus" class="input input-mini">
<option><?php echo $mus;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Plástica</label>
<select name="plas" class="input input-mini">
<option><?php echo $plas;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
<hr>
<h5 class="text-info">Asistencia</h5>
<label class="radio inline">
  <input type="radio" name="asiste" value="1" <?php echo $as1;?>> Presenta faltas de asistencia
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="asiste" value="2" <?php echo $as2;?>> Falta más de lo normal
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="asiste" value="3" <?php echo $as3;?>> Absentismo
</label>
<hr>
<h5 class="text-info">Dificultades de Aprendizaje</h5>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="1" <?php echo $d1;?>> Tiene carencias en aprendizajes básicos: "falta de base"
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="2" <?php echo $d2;?>>  Tiene dificultades en la lectura
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="3" <?php echo $d3;?>>  Tiene dificultades de comprensión oral / escrita
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="4" <?php echo $d4;?>>  Tiene dificultades de expresión oral / escrita
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="5" <?php echo $d5;?>>  Tiene dificultades de razonamiento matemático
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="6" <?php echo $d6;?>>  Tiene dificultades en hábitos /  método de estudio
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="7" <?php echo $d7;?>>  Tiene dificultades de cálculo.
</label>
<hr>

<h5 class="text-info">Refuerzos</h5>
<h6 class="text-success">Ha tenido Refuerzo:</h6>
<label class="checkbox inline">
  <input type="checkbox" name="refuerzo[]" value="Lengua " <?php echo $ref1;?>> Lengua
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="refuerzo[]" value="Matemáticas " <?php echo $ref2;?>> Matemáticas
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="refuerzo[]" value="Inglés " <?php echo $ref3;?>> Inglés
</label>
<h6 class="text-success">Necesita Refuerzo:</h6>
<p class="help-block">En caso necesario señalar orden de preferencia del Refuerzo.</p>
<label>Lengua</label>
<select name="necreflen">
<option><?php echo $necreflen;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
&nbsp;&nbsp;
<label>Matemáticas</label>
<select name="necrefmat">
<option><?php echo $necrefmat;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
&nbsp;&nbsp;
<label>Inglés</label>
<select name="necrefing">
<option><?php echo $necrefing;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>

<h6 class="text-success">Exención</h6>
<label class="checkbox inline">
  <input type="checkbox" name="exento" value="1" <?php echo $exen;?>> Alumnado que por sus dificultades no se le recomienda cursar optativa
</label>

<h6 class="text-success">Programa de Acompañamiento Escolar</h6>
<label class="checkbox inline">
  <input type="checkbox" name="acompanamiento" value="1" <?php echo $acomp;?>> Se aconseja asistencia al Programa de Acompañamiento Escolar
</label>
<hr>

<h5 class="text-info">Medidas de Atención a la Diversidad</h5>
<h6 class="text-success">Ha tenido Adaptación Curricular:</h6>
<label>Areas cursadas en la Adaptación Curricular Significativa
  <input type="text" style="width:300px" name="areasadcurrsign" value="<?php echo $areasadcurrsign;?>" caption="Tarari">
</label>
<br>
<label>Areas cursadas en la Adaptación Curricular <b>No</b> Significativa
  <input type="text" style="width:300px" name="areasadcurrnosign" value="<?php echo $areasadcurrnosign;?>" >
</label>
<h6 class="text-success">Necesita Adaptación Curricular:</h6>
<label>Areas propuestas para la Adaptación Curricular Significativa
  <input type="text" style="width:300px" name="necareasadcurrsign" value="<?php echo $necareasadcurrsign;?>">
</label>
<br>
<label>Areas  propuestas para la Adaptación Curricular <b>No</b> Significativa
  <input type="text" style="width:300px" name="necareasadcurrnosign" value="<?php echo $necareasadcurrnosign;?>" >
</label>

<h6 class="text-success">¿Ha sido atendido por PT o AL?</h6>
<label class="radio inline">
  <input type="radio" name="PT_AL" value="SI" <?php echo $ptal1;?>> Sí
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="PT_AL" value="NO" <?php echo $ptal2;?>> No
</label>
<br>
<label class="radio inline">
  <input type="radio" name="PT_AL_aula" value="Aula" <?php echo $ptalaula1;?>> Dentro del Aula
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="PT_AL_aula" value="Fuera" <?php echo $ptalaula2;?>> Fuera del Aula
</label>
<hr>

<h5 class="text-info">Alumnado de otra nacionalidad</h5>
<label class="radio inline">
  <input type="radio" name="nacion" value="4" <?php echo $n4;?>> No conoce el español
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="nacion" value="1" <?php echo $n1;?>> Nociones básicas de español
</label>
<label class="radio inline">
  <input type="radio" name="nacion" value="2" <?php echo $n2;?>> Dificultades en lectura y escritura
</label>
<label class="radio inline">
  <input type="radio" name="nacion" value="3" <?php echo $n3;?>> Puede seguir el Currículo
</label>
<br>
<br>
<label class="checkbox">
  <input type="checkbox" name="atal" value="SI" <?php echo $atl;?>> Ha sido atendido en el aula de ATAL
</label>
<br>
<label class="checkbox">
  <input type="checkbox" name="necatal" value="SI" <?php echo $necatl;?>> Necesita asistir al aula de ATAL
</label>
<hr>
<br>
<legend class="muted">ÁMBITO SOCIAL Y DE LA PERSONALIDAD</legend>
<h5 class="text-info">Integración en el Aula</h5>
<label class="radio inline">
  <input type="radio" name="integra" value="5" <?php echo $int5;?>> Líder
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="1" <?php echo $int1;?>> Integrado
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="2" <?php echo $int2;?>> Poco integrado
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="3" <?php echo $int3;?>> Se aísla
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="4" <?php echo $int4;?>> Alumno rechazado
</label>
<hr>
<h5 class="text-info">Actitud, comportamiento, estilo de aprendizaje</h5>
<p class="help-block">Colaborador/a, Trabajador, Atento, Impulsivo.. Indicar los aspectos más significativos</p>
<textarea name="actitud" rows="5"cols="80"><?php echo $actitud;?></textarea>
<hr>
<h5 class="text-info">Lo que mejor "funciona" con el Alumno</h5>
<textarea name="funciona" rows="5"cols="80"><?php echo $funciona;?></textarea>
<hr>
<br>

<legend class="muted">RELACIÓN COLEGIO - FAMILIA</legend>
<h5 class="text-info">Tipo de relación con el Colegio</h5>
<label class="radio">
  <input type="radio" name="relacion" value="3" <?php echo $rel3;?>> Colaboración constante
</label>
<br>
<label class="radio">
  <input type="radio" name="relacion" value="1" <?php echo $rel1;?>> Colaboración sólo cuando el Centro la ha solicitado
</label>
<br>
<label class="radio">
  <input type="radio" name="relacion" value="2" <?php echo $rel2;?>> Demanda constante por parte de los Padres
</label>
<hr>
<h5 class="text-info">Razones para la ausencia de relación con el Colegio</h5>
<p class="help-block">En caso de ausencia completa de relación de los padres con el Colegio señalar si es posible las razones de la misma.</p>
<textarea name="norelacion" rows="3"cols="80"><?php echo $norelacion;?></textarea>
<hr>
<br>

<legend class="muted">DISCIPLINA</legend>
<h5 class="text-info">Comportaiento disruptivo</h5>
<label class="radio inline">
  <input type="radio" name="disruptivo" value="3" <?php echo $dis3;?>> Nunca
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="disruptivo" value="1" <?php echo $dis1;?>> Ocasionalmente
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="disruptivo" value="2" <?php echo $dis2;?>> Alumno disruptivo
</label>
<hr>
<h5 class="text-info">El alumno ha sido expulsado en alguna ocasión</h5>
<label class="radio inline">
  <input type="radio" name="expulsion" value="1" <?php echo $exp1;?>> No
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="expulsion" value="2" <?php echo $exp2;?>> Sí
</label>
<hr>
<br>
<legend class="muted">OBSERVACIONES</legend>
<p class="help-block">Otros aspectos a reseñar (agrupamientos, datos médicos, autonomía, etc).</p>
<textarea name="observaciones" rows="6" cols="80"><?php echo $observaciones;?></textarea>
<hr>
<br>
<legend class="muted">ORIENTACIÓN</legend>
<p class="help-block">Informe privado del Dpto. de Orientación.</p>
<textarea name="orientacion" rows="6" cols="80"><?php echo $orientacion;?></textarea>
<hr>
<?php
if (strstr($_SESSION['cargo'],"2")==TRUE) :
$extra = "disabled";
endif;
?>
<input type="submit" class="btn btn-large btn-info hidden-print" name="submit0" value="Actualizar datos" <?php echo $extra; ?>>
</form>


		</div><!-- /.col-sm-6 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>

