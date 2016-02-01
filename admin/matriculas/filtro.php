<?
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
<div class="well well-sm hidden-print">
<form action="consultas.php" method="post" name="form2" id="form2">
<div class="row">
<div class="col-sm-4">
<div class="form-group" align="left">
<label>Selecciona Nivel&nbsp;</label>
<select class="form-control" name="curso" id="curso" onChange="submit()">
	<option><? echo $curso;?></option>
	<option>1ESO</option>
	<option>2ESO</option>
	<option>3ESO</option>
	<option>4ESO</option>
</select>
</div>
</div>
<script type="text/javascript">
desactivaOpcion();
</script>
<div class="col-sm-8">
<label>Grupos:
    </label><br>
<?					
$tipo0 = "select distinct grupo_actual from matriculas where curso = '$curso' order by grupo_actual";
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
			<div class="panel-group" id="filter">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#filter" href="#avanzado">
			          <span class="fa fa-filter"></span> Búsqueda avanzada
			        </a>
			      </h4>
			    </div>
			    <div id="avanzado" class="panel-collapse collapse<? echo $mostrar_filtro;?>">
			      <div class="panel-body">
<div class="row">
<div class="col-sm-3">
<div class="form-group"><label>
		DNI </label><input type="text" name="dn" class="form-control" 
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
		Apellidos </label><input type="text" name="apellid" class="form-control" 
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
		Nombre </label><input type="text" name="nombr" class="form-control" 
		<?php
		if ($nombr) {
			echo "value='$nombr'";
		}
		?>
		 />
         </div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Bilinguismo </label><select name="bilinguism" class="form-control" >
		<? if ($bilinguism) {
			echo "<option>$bilinguism</option>";
		}
		?>
			<option></option>
			<option>Si</option>
			<option>No</option>
		</select></div>
</div>
</div>

<div class="row">
<div class="col-sm-3">
<div class="form-group"><label>Promoción </label><select name="promocion" class="form-control" >
		<?php
		if ($promocion) {
			echo "<option>$promocion</option>";
		}
		?>
			<option></option>
			<option>Promociona</option>
			<option>PIL</option>
			<option>Repite</option>
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Exención </label><select name="exencio"class="form-control" >
		<?php
		if ($exencio) {
			echo "<option>$exencio</option>";
		}
		?>
			<option></option>
			<option>Si</option>
			<option>No</option>
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Itinerario </label><select name="itinerari"class="form-control" >
		<?php
		if ($itinerari) {
			echo "<option>$itinerari</option>";
		}
		?>
			<option></option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Matematicas </label><select name="matematica4"class="form-control" >
		<?php
		if ($matematica4 or $matematica3) {
			echo "<option>$matematica4$matematica3</option>";
		}
		?>
			<option></option>
			<option>A</option>
			<option>B</option>
		</select></div>
</div>
</div>
<div class="row">
<div class="col-sm-3">
<div class="form-group"><label>Diversificación </label><select name="diversificacio"class="form-control" >
		<?php
		if ($diversificacio) {
			echo "<option>$diversificacio</option>";
		}
		?>
			<option></option>
			<option>Si</option>
			<option>No</option>
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Grupo de Origen </label><select name="letra_grup"class="form-control" >
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
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Grupo Actual </label><select name="grupo_actua_seg"class="form-control" >
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
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Optativa </label><select name="optativ" class="form-control" ">
		<?php
		if ($optativ) {
			echo "<option>$optativ</option>";
		}
		?>
			<option></option>
			<option>optativa1</option>
			<option>optativa2</option>
			<option>optativa3</option>
			<option>optativa4</option>
			<option>optativa5</option>
			<option>optativa6</option>
			<option>optativa7</option>
		</select></div>
</div>
</div>
<div class="row">
<div class="col-sm-3">
<div class="form-group"><label>Transporte escolar<br /> </label><select name="transport" class="form-control" >
		<?php
		if ($transport) {
			echo "<option>$transport</option>";
		}
		?>
			<option></option>
			<option>ruta_este</option>
			<option>ruta_oeste</option>
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Religión<br /></span> </label><select name="religio" id="religion" class="form-control" >
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
			<option>Valores Éticos</option>
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Centro Origen </label><select name="colegi" class="form-control" >
		<?php
		if ($colegi) {
			echo "<option>$colegi</option>";
		}
		?>
		<option></option>
		<?php 
		$coleg=mysqli_query($db_con, "select distinct colegio from matriculas order by colegio");
		while ($cole=mysqli_fetch_array($coleg)) {
			echo "<option>$cole[0]</option>";
		}
		?>
		</select></div>
</div>
<div class="col-sm-3">
<div class="form-group"><label>Actividades </label><select name="actividade" class="form-control" >
		<?php
		if ($actividade) {
			echo "<option>$actividade</option>";
		}
		?>
			<option></option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
			<option>6</option>
		</select></div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="form-group"><label align=center>Problemas de Convivencia </label><select name="fechori" class="form-control" >
		<? if ($fechori) {
			echo "<option>$fechori</option>";
		}
		?>
			<option></option>
			<option>Sin problemas</option>
			<option>1 --> 5</option>
			<option>5 --> 15</option>
			<option>15 --> 1000</option>
		</select></div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
		<strong>Criterio de ordenación<br></strong>
<div class="radio">
		
<label class="radio-inline">
  <input type="radio" name="op_orden" value="promociona"> Promociona
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="bilinguismo"> Bilingues
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="exencion"> Exencion
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="itinerario"> Itinerario de 4º
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="matematicas4"> Matemáticas
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="diversificacion"> Diversificación
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="letra_grupo"> Grupo de origen
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="grupo_actual"> Grupo actual
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="opt_orden"> Optativas
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="act_orden"> Actividades
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="religion"> Religion
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="colegio"> Colegio
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="idioma"> Idioma
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="confirmado"> Confirmados
</label>
<label class="radio-inline">
  <input type="radio" name="op_orden" value="repite"> Repite
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
<input type="submit" name="consulta" value="Ver matrículas" alt="Introducir" class="btn btn-primary" />
</form><br />
