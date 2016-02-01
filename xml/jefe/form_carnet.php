<?
require('../../bootstrap.php');


acl_acceso($_SESSION['cargo'], array(1, 2));

include("../../menu.php");
?>
<div class="container">

<div class="page-header">
  <h2>Administración <small> Crear el Carnet del Alumno</small></h2>
</div>
  <br>

<div class="row">

<div class="col-sm-6 col-sm-offset-3">

<?
$id=$_POST['seleccion'];
if ($id>0){$modificar=1;}
else {$modificar=0;}
$alumnos='';

$query_Recordset1 = "SELECT distinct unidad FROM alma ORDER BY unidad ASC";
$Recordset1 = mysqli_query($db_con, $query_Recordset1) or die(mysqli_error($db_con));
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 = "SELECT * FROM alma ORDER BY Apellidos ASC";
$Recordset2 = mysqli_query($db_con, $query_Recordset2) or die(mysqli_error($db_con));
$row_Recordset2 = mysqli_fetch_array($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$unidad = $row_Recordset1[16];
?>
<div class="well well-lg">
<form id="form1" name="form1" method="post" action="carnet.php">

<div class="form-group">
<legend>Impresión de Carnet por Grupo</legend>
  <label class="control-label" for="grupo">Selecciona un Grupo:</label>

<?
if (stristr($_SESSION['cargo'],'2') == TRUE and stristr($_SESSION['cargo'],'1') == FALSE) {
	$unidad_tutor = $_SESSION['mod_tutoria']['unidad'];
	echo "<input type='text' name='select' value='$unidad_tutor' readonly class='form-control'/>"; 
}
else{
?>
  <select name="select" class="form-control" id = "grupo">
    <?php
 while ($row_Recordset1 = mysqli_fetch_array($Recordset1)) { 
 	$unidad = $row_Recordset1[0];
?>
    <option value="<?php echo $unidad;?>"><?php echo $unidad;?></option>
    <?php
}
?>
  </select>
<?
}
?>
  </div>
  <input type="submit" name="Submit" value="Enviar" class="btn btn-primary" />

</form>
 
</div>

 <div class="well well-lg">

<form name="crear" action="carnet.php" method="POST" onsubmit="placeInHidden('*', this.form.al2,this.form.profes)">
<legend>Impresión de Carnet por Alumno</legend>

<?############################?>
<SCRIPT language="JavaScript" type="text/javascript">

<!-- Begin

function selectAllOptions(desel,sel,desel1,sel1){
  for (var i=0; i<sel.options.length; i++) {
    sel.options[i].selected = true;
  }
for (var i=0; i<desel.options.length; i++) {
    desel.options[i].selected = false;
  }
 for (var i=0; i<sel1.options.length; i++) {
    sel1.options[i].selected = true;
  }
for (var i=0; i<desel1.options.length; i++) {
    desel1.options[i].selected = false;
  }
}

sortitems = 1;  // Automatically sort items within lists? (1 or 0)

function move(fbox,tbox) {
for(var i=0; i<fbox.options.length; i++) {
if(fbox.options[i].selected && fbox.options[i].value != "") {
var no = new Option();
no.value = fbox.options[i].value;
no.text = fbox.options[i].text;
tbox.options[tbox.options.length] = no;
fbox.options[i].value = "";
fbox.options[i].text = "";
   }
}
BumpUp(fbox);
if (sortitems) SortD(tbox);
}
function BumpUp(box)  {
for(var i=0; i<box.options.length; i++) {
if(box.options[i].value == "")  {
for(var j=i; j<box.options.length-1; j++)  {
box.options[j].value = box.options[j+1].value;
box.options[j].text = box.options[j+1].text;
}
var ln = i;
break;
   }
}
if(ln < box.options.length)  {
box.options.length -= 1;
BumpUp(box);
   }
}

function SortD(box)  {
var temp_opts = new Array();
var temp = new Object();
for(var i=0; i<box.options.length; i++)  {
temp_opts[i] = box.options[i];
}
for(var x=0; x<temp_opts.length-1; x++)  {
for(var y=(x+1); y<temp_opts.length; y++)  {
if(temp_opts[x].text > temp_opts[y].text)  {
temp = temp_opts[x].text;
temp_opts[x].text = temp_opts[y].text;
temp_opts[y].text = temp;
temp = temp_opts[x].value;
temp_opts[x].value = temp_opts[y].value;
temp_opts[y].value = temp;
      }
   }
}
for(var i=0; i<box.options.length; i++)  {
box.options[i].value = temp_opts[i].value;
box.options[i].text = temp_opts[i].text;
   }
}

function placeInHidden(delim, selStr, hidStr)
{
  hidStr.value = '';
  for (var i=0; i<selStr.options.length; i++) {
    hidStr.value = hidStr.value + delim + selStr.options[i].value;
  }
}




// End -->
</script>
<?

if (stristr($_SESSION['cargo'],'2') == TRUE) {
	$unidad_tuto = " and unidad = '$unidad_tutor'";
}
else{
	$unidad_tuto = "";
}
if ($modificar==1) {                  #elige selección múltiple
		foreach($alumnos as  $valor) {
			if (!isset($seleccion1)) { $seleccion1="'".$valor;}
			else {$seleccion1=$seleccion1."','".$valor;}		
		}
	$seleccion1=$seleccion1."'";
	$query_al = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma WHERE claveal In (".$seleccion1.") ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
	$query_noal = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma WHERE claveal Not In (".$seleccion1.") ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
	#echo '<br>'.$query_al.'<br>';
}
else {
$query_al = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma WHERE 1=2 ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
$query_noal = "SELECT claveal, Unidad, Apellidos, Nombre FROM alma where 1=1 ".$unidad_tuto." ORDER BY Unidad, Apellidos, Nombre ASC";
}

?>

<table>
<tr>
<td style="width:45%">
<div class="form-group">
  <label for="al1">Alumnos disponibles</label>
<select multiple size="15" name="al1" id="al1" class="form-control">
	<?php $alumnos = mysqli_query($db_con, $query_noal);
	while ($alumnado = mysqli_fetch_row($alumnos)){ 
		echo "<Option value='$alumnado[0]'>$alumnado[1] $alumnado[2] , $alumnado[3] "; 
	} #del while
	?>
</select>
</td>
<td style="width:10%" align=center>
<div class="form-group">
<br>
<input type="button" value="   >>   " onclick="move(this.form.al1,this.form.al2)" name="B5" class="btn btn-warning"><br><br><br>
<input type="button" value="   <<   " onclick="move(this.form.al2,this.form.al1)" name="B6"class="btn btn-warning">
</div>
</td>
<td style="width:45%">
<div class="form-group">
  <label>Alumnos seleccionados</label>
<select multiple size="15" name="al2" id="al2" class="form-control">
	<?php $alumnos = mysqli_query($db_con, $query_al);
	while ($alumnado = mysqli_fetch_row($alumnos)){ 
		echo "<Option value='$alumnado[0]'>$alumnado[1] $alumnado[2] , $alumnado[3] "; 
	} #del while ?>
</select>
</td>

<input type='hidden' name='alumnos' value=''>
</tr>
</table>

<br />
<input type=submit value="Aceptar" class="btn btn-primary" onclick="placeInHidden('*', this.form.al2,this.form.alumnos);">

</form>
</div>

<?php if(stristr($_SESSION['cargo'],'1') == TRUE) {
	echo ' <div class="well well-lg" >';
	echo '<legend>Impresión de todos los Alumnos</legend>';
	echo "<a href='carnet.php?todos=1' class='btn btn-primary btn-block'><i class='fa fa-print '> </i> Imprimir todos los cursos</a></div>";
}
?>
</div>
</div>
</div>


	<?php include("../../pie.php"); ?>
	
</body>
</html>
