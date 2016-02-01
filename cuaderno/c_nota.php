<?php
require('../bootstrap.php');

$PLUGIN_COLORPICKER = 1;

$pr = $_SESSION['profi'];
 include("../menu.php");
 include("menu.php");
 variables();
?>
<div class="container">
		<div class="row">
<br>		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Cuaderno de Notas&nbsp;&nbsp;<small> Crear nueva columna de datos</small></h2>
		</div>
					
			<div class="col-sm-6 col-sm-offset-3">
<?php

echo '<div align="center">';
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
foreach($_GET as $key => $val)
	{
		${$key} = $val;
	}

$curso_sin=substr($curso,0,-1);
$curso_nota=$curso.",";
	echo "<h3><span class='label label-info' style='padding:8px'>$curso -- $nom_asig </span></h3><br>";
// Asignatura ese día a esa hora
$asig0 = "SELECT distinct c_asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora'";
$asig1 = mysqli_query($db_con, $asig0);
$asig = mysqli_fetch_array($asig1);
$asignatura = $asig[0];

if(strlen($id) > '0'){
		
$ident1 = mysqli_query($db_con, "select id, nombre, texto, texto_pond, visible_nota, Tipo, color from notas_cuaderno where id='$id'") or die ("error notas_cuaderno"); //echo $ident2; 
$ident0 = mysqli_fetch_array($ident1);
$id = $ident0[0];
$nombre = $ident0[1];
$texto =$ident0[2];
$color =$ident0[6];

$ident0[4] ? $visible_nota = 1 : $visible_nota = 0;
$tipo = $ident0[5];
} 


// Formulario general y datos ocultos
?>
<form action="n_col.php" method="post">
	<input type="hidden" name="asignatura" value = "<?php echo $asignatura;?>" />
	<input type="hidden" name="curso_nota" value = "<?php echo $curso_nota;?>" />
	<input type="hidden" name="curso" value = "<?php echo $curso;?>" />
		<input type="hidden" name="curso_nota" value = "<?php echo $curso_nota;?>" />
	<input type="hidden" name="dia" value = "<?php echo $dia;?>" />
	<input type="hidden" name="hora" value = "<?php echo $hora;?>" />
	<input type="hidden" name="id" value = "<?php echo $id;?>" />
	<input type="hidden" name="nom_asig" value = "<?php echo $nom_asig;?>" />
	
	<div class="well well-large" align="left">
		<div class="form-group">
		<label for="cmp_nombre">Nombre de la columna</label>
		<input type="text" id="cmp_nombre" name="nombre" size="32" value="<?php echo $nombre;?>" class="form-control" />
		</div>
		<div class="form-group">
			<label for="select_tipo">Tipo de datos</label>
			<select id="select_tipo" name="tipo" value="1" class="form-control" >
			<?php if($tipo) echo "<option>$tipo</option>"; ?>
			<option>Números</option>
			<option>Texto largo</option>
			<option>Texto corto</option>
			<option>Casilla de verificación</option>			
			</select>
			<p class="help-block well well-small well-transparent small">
			<strong>Números. </strong>Cualquier número entero o con decimales<br />
			<strong>Texto largo. </strong>Observaciones, descripciones, etc. (hasta 48 caracteres)<br />
			<strong>Texto corto. </strong>Uno a tres caracteres (por ejemplo: B, M, R, Si, No, etc)<br />
			<strong>Casilla de verificación. </strong>Selección entre dos posibles estados: marcado (por ejemplo: ha realizado una actividad) o desmarcado (No ha realizado la actividad)<br />
			</p>
		</div>
		<div class="form-group">
		<label for="cmp_observaciones">Observaciones</label>
		<textarea name="texto" rows="6" id="cmp_observaciones" class="form-control"><?php echo $texto;?></textarea>
		</div>
		<div class="row">
		<div class="col-sm-5">
		<div class="input-group" id="colorpicker1">
			<input type="text" class="form-control" id="color_nombre" style="border:1px solid #aaa" name="color" value="<?php if(strlen($color)>0){echo $color;}else{ echo "#fff";}?>">
			<span class="input-group-addon" style="border:1px solid #aaa; background-color:#fee"><i></i></span>
		</div>
		</div>
		</div>
		<div class="checkbox">
			<label for="cmp_visible_nota">
			<input type="checkbox" id="cmp_visible_nota" name="visible_nota" value="1" <?php if($visible_nota) echo 'checked'; ?>>
			Visible en la página externa <strong data-bs="tooltip" title="Si está marcada, permite a los padres y alumnos ver la nota de la actividad o examen en la página externa">(?)</strong></label>
		</div>
		<hr />
		<div class="form-group">
		<input type="submit" name="crear" value="Crear o Modificar" class="btn btn-primary"/>
		</div>
	</div>
</form>

</div>
<?php include('../pie.php'); ?>

  <script type="text/javascript">
  document.forms[0].elements['nombre'].focus(); 
  
  $('#colorpicker1').colorpicker();
  </script>

</body>
</html>