<?php
if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];} elseif (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="";}
if (isset($_POST['todos'])) {$todos = $_POST['todos'];} elseif (isset($_GET['todos'])) {$todos = $_GET['todos'];}else{$todos="";}

if(isset($_POST['submit1']) || (isset($_GET['submit1']) && ($_GET['submit1'] == 1)))
{
	include("cursos.php");
	exit();
}

require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Listado de alumnos <small>Consultas</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="">
					<fieldset>
						<legend>Alumnos por grupo</legend>
						
						<div class="form-group">
						    <select class="form-control" name="unidad[]" multiple size="6">
<?php
if(stristr($_SESSION['cargo'],'1') == TRUE || stristr($_SESSION['cargo'],'8') == TRUE || stristr($_SESSION['cargo'],'5') == TRUE || stristr($_SESSION['cargo'],'d') == TRUE || $todos=="1"){
 unidad($db_con);
 $SQLcurso = "SELECT DISTINCT unidad FROM alma WHERE combasi LIKE '%25204%' OR combasi LIKE '%25226%' OR combasi LIKE '%135785%'";
$resultcurso = mysqli_query($db_con, $SQLcurso);
while($rowcurso = mysqli_fetch_array($resultcurso)){
	echo "<option>$rowcurso[0] DIV</option>";	
}
}
else{

$SQLcurso = "SELECT grupo, materia, nivel FROM profesores WHERE profesor = '$profesor'";
$resultcurso = mysqli_query($db_con, $SQLcurso);
$curso="";
$asignatura="";	
	while($rowcurso = mysqli_fetch_array($resultcurso))
	{
	$curso = $rowcurso[0];
	$asignatura = $rowcurso[1];
	$n_curs = substr($rowcurso[2],0,1);
	if (stristr($rowcurso[2],"bach")) {
		$asigna0 = "SELECT codigo FROM asignaturas WHERE nombre = '$asignatura' AND curso LIKE '%bach%' AND curso LIKE '$n_curs%' AND abrev NOT LIKE '%\_%'";
	}
	else{
	$asigna0 = "SELECT codigo FROM asignaturas WHERE nombre = '$asignatura' AND curso = '$rowcurso[2]' AND abrev NOT LIKE '%\_%'";
	}
	$asigna1 = mysqli_query($db_con, $asigna0);
	$codasi="";
	while ($asigna2 = mysqli_fetch_array($asigna1)) {
		$codasi.=$asigna2[0]."-";
	}
	$codasi = substr($codasi,0,-1)	;
	//echo "<option>select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'</option>";
	echo "<option value='$curso -> $asignatura -> $codasi'>$curso -> $asignatura</option>";
 }
 
}
?>

						    </select>
						    <p class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples grupos.</p>
						  </div>
						  
						  <div class="checkbox">
						  	<label>
						    	<input type="checkbox" name="asignaturas" value="1"> Mostrar asignaturas
						    </label>
						  </div>
						  
						  <div class="checkbox">
						  	<label>
						    	<input type="checkbox" name="todos" value="1" onclick="submit()" <?php echo (isset($todos) && $todos == 1) ? 'checked' : '' ;?>> Mostrar todos los grupos
						    </label>
						  </div>
						  
						  <button type="submit" class="btn btn-primary" name="submit1" formtarget="_blank">Consultar</button>
						</fieldset>
						
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="excel.php">
<?php
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE or stristr($_SESSION['cargo'],'5') == TRUE or stristr($_SESSION['cargo'],'d') == TRUE or $todos == "1"){
	$query_Recordset1 = "SELECT distinct unidad FROM alma ORDER BY unidad ASC";
}
else{
	$query_Recordset1 = "SELECT grupo, materia, nivel FROM profesores WHERE profesor = '$profesor'";
}
$Recordset1 = mysqli_query($db_con, $query_Recordset1) or die(mysqli_error($db_con));
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 = "SELECT * FROM alma ORDER BY apellidos ASC";
$Recordset2 = mysqli_query($db_con, $query_Recordset2) or die(mysqli_error($db_con));
$row_Recordset2 = mysqli_fetch_array($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
					<fieldset>
						<legend>Exportar en formato XLS</legend>
						
						<div class="form-group">
					    <select class="form-control" name="select">
					    	     <?php 
					    	 do {  
					    	 ?>
					    	     <option><?php  echo $row_Recordset1[0]?></option>
					    	     <?php 
					    	 } while ($row_Recordset1 = mysqli_fetch_array($Recordset1));
					    	   $rows = mysqli_num_rows($Recordset1);
					    	 ?>
					    </select>
					    <p class="help-block">Selecciona el grupo para exportar los datos al formato de las hojas de cálculo, como Calc o Excel.</p>
					  </div>
					  
					  <div class="checkbox">
					  	<label>
					    	<input type="checkbox" name="tipo" value="2"> Mostrar asignaturas
					    </label>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="boton1">Exportar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?>
</body>
</html>
