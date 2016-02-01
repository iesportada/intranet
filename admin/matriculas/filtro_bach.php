<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

foreach($_POST as $val)
{
if (strlen($val)>0) {
	$n+=1;
}
}
if ($n>2) {
	$mostrar_filtro = ' in';
}
?>
<form action="consultas_bach.php" method="post" name="form2">
<div class="well well-sm hidden-print">
<div class="row">
<div class="col-sm-4">

<div class="form-group" align="left">

<label>Selecciona Nivel&nbsp;</label>
<select class="form-control" name="curso" id="curso" onChange="submit()">
	<option><?php echo $curso;?></option>
	<option>1BACH</option>
	<option>2BACH</option>
</select>
</div>
</div>
<div class="col-sm-8">
<div class="checkbox-inline">
<label>Grupos:</label><br>
<?					
$tipo0 = "select distinct grupo_actual from matriculas_bach where curso = '$curso' order by grupo_actual";
$tipo10 = mysqli_query($db_con, $tipo0);
  while($tipo20 = mysqli_fetch_array($tipo10))
        {	
        	if ($tipo20[0]=="") {
        		$tipo20[0]="Ninguno";
        	}

echo "<div class='checkbox-inline'><label class='badge'><input name='grupo_actua[]' type='checkbox' value='$tipo20[0]' ";
if ($_POST['grupo_actua']) {			
		foreach ($_POST['grupo_actua'] as $grup_actua){
			  if ($grup_actua==$tipo20[0]) {
			  	echo " checked ";
			  }
		}	
	}
echo ">";
echo "".$tipo20[0]."</label></div>";
        }
						
	?>
    </div>
    </div>
    </div>
	
			<div class="panel-group" id="filter">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title" align="left">
			        <a data-toggle="collapse" data-parent="#filter" href="#avanzado">
			          <span class="fa fa-filter"></span> Búsqueda avanzada
			        </a>
			      </h4>
			    </div>
			    <div id="avanzado" class="panel-collapse collapse<?php echo $mostrar_filtro;?>">
			      <div class="panel-body">
			      
<div class="row">
<div class="col-sm-3">
<div class="form-group"><label>
		DNI </label><input type="text" class="form-control" name="dn" 
		<?php
		if ($dn) {
			echo "value='$dn'";
		}
		?>
		 />
         </div>
</div>
<div class="col-sm-3">
		<div class="form-group"><label>
		Apellidos </label><input type="text" class="form-control" name="apellid" 
		<?php
		if ($apellid) {
			echo "value='$apellid'";
		}
		?>
		 />
</div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>
		Nombre </label><input type="text" class="form-control" name="nombr" 
		<?php
		if ($nombr) {
			echo "value='$nombr'";
		}
		?>
		 />
         </div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Modalidad </label><select class="form-control"  name="itinerari">
		<?php
		if ($itinerari) {
			echo "<option>$itinerari</option>";
		}
		?>
			<option></option>
			<option>1</option>
			<option>2</option>
			<?php if ($curso=="1BACH") { ?>
			<option>3</option>
			<option>4</option>	
			<?php } ?>
			
		</select>
		</div>
</div>
</div>

<div class="row">

<div class="col-sm-3">
<div class="form-group"><label>Optativas Modalidad </label><select class="form-control"  name="optativ">
		<?php
		if ($optativ) {
			for ($i = 1; $i < 4; $i++) {
			foreach(${opt.$n_curso.$i} as $key=>$val){
			if ($optativ == $key) {
				echo "<option value='$optativ'>$val</option>";
			}
		}			
		}			
		}
		?>
			<option></option>
		<?php
		for ($i = 1; $i < 4; $i++) {
			foreach(${opt.$n_curso.$i} as $key=>$val){
			echo '<option value="'.$key.'">'.$val.'</option>';
		}			
		}

			
		?>	
		</select>
		</div>
</div>



<?php if($curso=="2BACH"){ ?>
<div class="col-sm-3">
<div class="form-group"><label>Otras Optativas </label><select class="form-control"  name="optativ2">
		<?php


		if ($optativ2) {
			foreach(${opt23} as $key0=>$val0){
			$n_opt2+=1;
			  if($n_opt2==$optativ2){
			echo '<option value="'.$n_opt2.'">'.$val0.'</option>';
		}
		}
		}
		?>
			<option></option>
		<?php
		$n_opt2="";

			foreach(${opt23} as $key=>$val){
			$n_opt2+=1;
			echo '<option value="'.$n_opt2.'">'.$val.'</option>';

		}

			
		?>	
		</select></div></div><?php }
else{
	?>
	<div class="col-sm-3">
	<div class="row">
	<div class="col-sm-6">
	<center>
	<div class="form-group"><label>Idioma 1 </label><select class="form-control"  name="idiom1">
		<?php
		if ($idiom1) {
			echo "<option>$idiom1</option>";
		}
		?>
			<option></option>
			<option>Inglés</option>
			<option>Francés</option>
		</select>
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
	<label>Idioma 2 </label><select class="form-control"  name="idiom2">
		<?php
		if ($idiom2) {
			echo "<option>$idiom2</option>";
		}
		?>
			<option></option>
			<option>Alemán</option>
			<option>Francés</option>
			<option>Alemán</option>
		</select>
		</div>
		</div>
	</center>
		</div>
		</div>	
<?php }
		?>

		
<div class="col-sm-3">
<div class="form-group"><label>Promoción </label><select class="form-control"  name="promocion" >
		<?php
		if ($promocion) {
			echo "<option>$promocion</option>";
		}
		?>
			<option></option>
			<option>SI</option>
			<option>NO</option>
		<?php if ($n_curso=="1") {?>
			<option>3/4</option>
			<?php }?>
			
		</select>
		</div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Grupo de Origen </label><select class="form-control"  name="letra_grup">
		<?php
		if ($letra_grup) {
			echo "<option>$letra_grup</option>";
		}
		?>
			<option></option>
			<option>A</option>
			<option>B</option>
			<option>C</option>
			<option>D</option>
			<option>E</option>
			<option>F</option>
			<option>G</option>
			<option>H</option>
			<option>I</option>
		</select>
		</div>
</div>
</div>

<div class="row">

<div class="col-sm-3">
<div class="form-group"><label>Grupo Actual </label><select class="form-control"  name="grupo_actua_seg">
		<?php
		if ($grupo_actua_seg) {
			echo "<option>$grupo_actua_seg</option>";
		}
		?>
			<option></option>
			<option>Ninguno</option>
			<option>A</option>
			<option>B</option>
			<option>C</option>
			<option>D</option>
			<option>E</option>
			<option>F</option>
			<option>G</option>
			<option>H</option>
			<option>I</option>
			</select>
			</div>
</div>

<div class="col-sm-3">
<div class="form-group"><label>Transporte escolar </label><select class="form-control"  name="transport">
		<?php
		if ($transport) {
			echo "<option>$transport</option>";
		}
		?>
			<option></option>
			<option>ruta_este</option>
			<option>ruta_oeste</option>
		</select>
		</div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Religión</span> </label><select class="form-control"  name="religio" id="religion">
		<?php
		if ($religio) {
			echo "<option>$religio</option>";
		}
		?>
			<option></option>
			<option>Religi&oacute;n Cat&oacute;lica</option>
			<option>Religión Islámica</option>
			<option>Religión Judía</option>
			<option>Religión Evangélica</option>
			<option>Cultura Científica</option>
			<option value="Valores Éticos">Educación para la Ciudadanía y los Derechos Humanos</option>
		</select>
		</div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Centro Origen </label><select class="form-control"  name="colegi">
		<?php
		if ($colegi) {
			echo "<option>$colegi</option>";
		}
		?>
		<option></option>
		<?php 
		$coleg=mysqli_query($db_con, "select distinct colegio from matriculas_bach order by colegio");
		while ($cole=mysqli_fetch_array($coleg)) {
			echo "<option>$cole[0]</option>";
		}
		?>
		</select></div>
</div>
</div>

<div class="row">

<?php if ($curso=="1BACH") {		
?>
<div class="col-sm-6">
<div class="form-group">
	<label >Bilinguismo </label><select class="form-control" name="bilinguism">
		<?php if ($bilinguism) {
			echo "<option>$bilinguism</option>";
		}
		?>
			<option></option>
			<option>Si</option>
			<option>No</option>
		</select>
</div>
</div>
<?php } ?>
<?php if ($curso=="2BACH") {		
?>
<div class="col-sm-6">
<div class="form-group">
<label>Idioma 1 </label><select class="form-control"  name="idiom1">
		<?php
		if ($idiom1) {
			echo "<option>$idiom1</option>";
		}
		?>
			<option></option>
			<option>Inglés</option>
			<option>Francés</option>
		</select>
		</div>
		</div>
<?php } ?>
<div class="col-sm-6">
<div class="form-group">
	<label >Problemas de Convivencia </label><select class="form-control" name="fechori">
		<?php if ($fechori) {
			echo "<option>$fechori</option>";
		}
		?>
			<option></option>
			<option>Sin problemas</option>
			<option>1 --> 5</option>
			<option>5 --> 15</option>
			<option>15 --> 1000</option>
		</select>
</div>
</div>

</div>	
<div class="row">
<div class="col-sm-12" align=left>
<strong>Criterio de ordenación<br></strong>
<div class="radio">
<label class="radio-inline">
  <input type="radio" name="op_orden" value="promociona"> Promociona
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="bilinguismo"> Bilingues
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="letra_grupo"> Grupo de origen
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="grupo_actual"> Grupo actual
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="itinerario1"> Itinerario1
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="itinerario2"> Itinerario2
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="opt_orden"> Optativas
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="religion"> Religion
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="colegio"> Centro escolar
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="idioma1"> Idioma1
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="idioma2"> Idioma2
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="confirmado"> Confirmados
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="repite"> Repite</label>
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="foto"> Foto
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="enfermedad"> Enfermedad
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="divorcio"> Divorcio
</label>
</div>
</div>
</div>
		      
</div>			      

</div>
			      </div>
			    </div>
			  </div>
	
			</div>
			<input type="submit" name="consulta" value="Ver matrículas" alt="Introducir" class="btn btn-primary" />
</form>
<br />
