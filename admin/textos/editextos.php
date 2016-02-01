<?php
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}

if(isset($_POST['enviar']) or isset($_POST['insertar'])){
	include("edtextos.php");
	exit;
}

require('../../bootstrap.php');


include("../../menu.php");
include 'menu.php';
?>
<div class="container">
<div class="page-header">
  <h2>Libros de texto <small>Edición de libros</small></h2>
</div>

<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<div class="well well-lg" align="left">

<?php
$textos = mysqli_query($db_con, "SELECT Departamento, Asignatura, Autor, Titulo, Editorial, Notas, Id, isbn, nivel, grupo, Obligatorio FROM Textos where Id='$id'");
$row = mysqli_fetch_array($textos);
$id = $row[6];
$nivel = $row[8];
$obliga = $row[10];
?> <legend>Selecciona el Curso y los Grupos</legend>
<form method="post" action="editextos.php">

<div class="form-group"><label> Nivel:</label> <select name="nivel"
	id="select4" onChange="submit()" class="form-control">
	<?php
	echo "<option>$nivel</option>";
	$tipo = "select distinct curso from alma order by NIVEL";
	$tipo1 = mysqli_query($db_con, $tipo);
	while($tipo2 = mysqli_fetch_array($tipo1))
	{
		$completo = "$tipo2[0]";
		if($completo == $nivel){}
		else{
			echo "<option>$completo</option>";
		}
	}
	?>
</select></div>
<input type="hidden" name="id" value="<?php echo $id; ?>" /></form>

<form name="textos" method="post" action="editextos.php"><input
	type="hidden" name="id" value="<?php echo $id; ?>" /> <input type="hidden"
	name="nivel" value="<?php echo $nivel; ?>" />

<div class="form-group"><label>Grupos: </label><br> <?	
$tipo0 = "select distinct unidad from alma where curso = '$nivel' order by unidad";
$tipo10 = mysqli_query($db_con, $tipo0);
$ng = "";
while($tipo20 = mysqli_fetch_array($tipo10))
{
	$ng++;
	$sql = mysqli_query($db_con, "select grupo from Textos where id = '$id'");

	while ($sql_w = mysqli_fetch_array($sql)) {
		if (strstr($sql_w[0],$tipo20[0])==TRUE) {
			$extra = " checked";
		}
	}
	echo "<div class='checkbox-inline'><label>";
	echo "<input name='grupo$ng' type='checkbox' id='$tipo20[0]' value='$tipo20[0]' $extra><span class='badge badge-info'>$tipo20[0]</span></label></div>&nbsp;";
}

?></div>
<legend>Datos del Libro de Texto</legend>

<div class="form-group"><label>T&iacute;tulo</label> <input
	name="titulo" type="text" id="titulo"
	value='<?php echo $row[3];?>' class="form-control" required></div>

<div class="form-group"><label>Autor</label> <input name="autor"
	type="text" id="autor" value='<?php echo $row[2];?>'
	class="form-control" required></div>

<div class="form-group"><label>Editorial</label> <input name="editorial"
	type="text" id="editorial" value="<?php echo $row[4];?>"
	class="form-control" required></div>

<div class="form-group"><label>Departamento</label> <select
	name="departamento" id="departamento" value="Todos ..."
	onChange="submit()" class="form-control" required>
	<option><?php if($departamento){echo $departamento;}else{echo $row[0];}?></option>
	<?php
	$profe = mysqli_query($db_con, " SELECT distinct departamento FROM departamentos order by departamento asc");
	while($filaprofe = mysqli_fetch_array($profe))
	{
		if ($filaprofe[0] == "Lengua Castellana" or $filaprofe[0] == "Lengua Extranjera-Inglés (Secundaria)" or $filaprofe[0] == "Matemáticas")
		{}
		else {$departamen = $filaprofe[0];}
		$opcion1 = printf ("<OPTION>$departamen</OPTION>");
		echo "$opcion1";
	}
	?>
</select></div>

<div class="form-group"><label>Asignatura</label> <select
	name="asignatura" id="asignatura" class="form-control" required>
	<option><?php if($asignatura){echo $asignatura;}else{echo $row[1];}?></option>
	<option><?php
	// Datos de la Asignatura
	$asignatu = "SELECT DISTINCT asignaturas.NOMBRE, ABREV FROM asignaturas, departamentos, profesores where asignaturas.nombre=profesores.materia and profesores.profesor=departamentos.nombre and curso = '$nivel' ";
	if($departamento){$asignatu.="and departamento like '$departamento%'";}else{$asignatu.="and departamento like '$row[1]%'";}
	$asignatu.=" ORDER BY NOMBRE asc";
	$asignatur = mysqli_query($db_con, $asignatu);
	while($fasignatur = mysqli_fetch_array($asignatur)) {
		if(strlen($fasignatur[1]) > 3)	{ }
		else{
			$opcion = printf ("<OPTION>$fasignatur[0]</OPTION>");
			echo "$opcion"; }
	}
	?></option>
</select></div>

<div class="form-group"><label>Tipo de Libro</label> <select
	name="clase" class="form-control" required>
	<option>Texto</option>
	<option>Lectura</option>
</select></div>

<div class="form-group"><select name="obligatorio" class="form-control">
	<option><?php if($obliga){echo $obliga;}?></option>

	<option>Obligatorio</option>
	<option>Recomendado</option>
</select></div>

<div class="form-group"><label>Observaciones</label> <textarea
	name="NOTAS" cols="50" rows="6" class="form-control"><?php echo $row[5];?></textarea>
</div>

<div class="form-group"><label>ISBN</label> <input name="isbn"
	type="text" id="isbn"  value="<?php echo $row[7];?>"
	class="form-control" required></div>

<center>
	<input type="submit" name="enviar" value="Actualizar datos"
	alt="Introducir" class="btn btn-warning" style="width: 45%"> 
	
	<input type="submit" name="insertar" value="Insertar como nuevo Libro"
	alt="Introducir2" class="btn btn-success" style="width: 45%"></center>
</form>
</div>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
	
</body>
</html>
