<?php
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['titulo'])) {$titulo = $_GET['titulo'];}elseif (isset($_POST['titulo'])) {$titulo = $_POST['titulo'];}else{$titulo="";}
if (isset($_GET['asignatura'])) {$asignatura = $_GET['asignatura'];}elseif (isset($_POST['asignatura'])) {$asignatura = $_POST['asignatura'];}else{$asignatura="";}
if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['editorial'])) {$editorial = $_GET['editorial'];}elseif (isset($_POST['editorial'])) {$editorial = $_POST['editorial'];}else{$editorial="";}
if (isset($_GET['isbn'])) {$isbn = $_GET['isbn'];}elseif (isset($_POST['isbn'])) {$isbn = $_POST['isbn'];}else{$isbn="";}
if (isset($_GET['ano'])) {$ano = $_GET['ano'];}elseif (isset($_POST['ano'])) {$ano = $_POST['ano'];}else{$ano="";}
if (isset($_GET['autor'])) {$autor = $_GET['autor'];}elseif (isset($_POST['autor'])) {$autor = $_POST['autor'];}else{$autor="";}
if (isset($_GET['NOTAS'])) {$NOTAS = $_GET['NOTAS'];}elseif (isset($_POST['NOTAS'])) {$NOTAS = $_POST['NOTAS'];}else{$NOTAS="";}
if (isset($_GET['obligatorio'])) {$obligatorio = $_GET['obligatorio'];}elseif (isset($_POST['obligatorio'])) {$obligatorio = $_POST['obligatorio'];}else{$obligatorio="";}
if (isset($_GET['clase'])) {$clase = $_GET['clase'];}elseif (isset($_POST['clase'])) {$clase = $_POST['clase'];}else{$clase="";}
if (isset($_GET['grupo1'])) {$grupo1 = $_GET['grupo1'];}elseif (isset($_POST['grupo1'])) {$grupo1 = $_POST['grupo1'];}else{$grupo1="";}
if (isset($_GET['grupo2'])) {$grupo2 = $_GET['grupo2'];}elseif (isset($_POST['grupo2'])) {$grupo2 = $_POST['grupo2'];}else{$grupo2="";}
if (isset($_GET['grupo3'])) {$grupo3 = $_GET['grupo3'];}elseif (isset($_POST['grupo3'])) {$grupo3 = $_POST['grupo3'];}else{$grupo3="";}
if (isset($_GET['grupo4'])) {$grupo4 = $_GET['grupo4'];}elseif (isset($_POST['grupo4'])) {$grupo4 = $_POST['grupo4'];}else{$grupo4="";}
if (isset($_GET['grupo5'])) {$grupo5 = $_GET['grupo5'];}elseif (isset($_POST['grupo5'])) {$grupo5 = $_POST['grupo5'];}else{$grupo5="";}
if (isset($_GET['grupo6'])) {$grupo6 = $_GET['grupo6'];}elseif (isset($_POST['grupo6'])) {$grupo6 = $_POST['grupo6'];}else{$grupo6="";}
if (isset($_GET['grupo7'])) {$grupo7 = $_GET['grupo7'];}elseif (isset($_POST['grupo7'])) {$grupo7 = $_POST['grupo7'];}else{$grupo7="";}
if (isset($_GET['grupo8'])) {$grupo8 = $_GET['grupo8'];}elseif (isset($_POST['grupo8'])) {$grupo8 = $_POST['grupo8'];}else{$grupo8="";}
if (isset($_GET['grupo9'])) {$grupo9 = $_GET['grupo9'];}elseif (isset($_POST['grupo9'])) {$grupo9 = $_POST['grupo9'];}else{$grupo9="";}
if (isset($_GET['grupo10'])) {$grupo10 = $_GET['grupo10'];}elseif (isset($_POST['grupo10'])) {$grupo10 = $_POST['grupo10'];}else{$grupo10="";}

if (isset($_POST['insertar']))
{
	include("intextos2.php");
	exit();
}
require('../../bootstrap.php');

include("../../menu.php");
include("menu.php");

?>
<?php 
echo '
<div class="container">
<div class="page-header">
  <h2>Libros de texto <small>'.$nivel.'</small></h2>
</div><br />';
?>
<div class="row">
<div class="col-sm-10 col-sm-offset-1">

<?php 
for ($i = 1; $i < 11; $i++) {
	if (strlen(${grupo.$i})>0) {
		$grupo.=${grupo.$i}.";";
	}
}

//Introducción de datos si todo va bién
$query="UPDATE Textos SET Titulo = '$titulo', Autor = '$autor',
		Editorial = '$editorial', Departamento = '$departamento', 
		Asignatura = '$asignatura', Notas = '$NOTAS', isbn = '$isbn', nivel = '$nivel', grupo = '$grupo', obligatorio = '$obligatorio' where Id = '$id'";
//echo $query;
mysqli_query($db_con, $query);
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El texto se ha registrado correctamente. <br>Comprueba los datos en la tabla de abajo, y en caso de no ser correctos, puedes volver a editarlos.</div></div><br />';

$textos = mysqli_query($db_con, "SELECT Departamento, Asignatura, Autor, Titulo, Editorial, Notas, Id, Nivel, Grupo FROM Textos where Id='$id' order by Asignatura");
if ($textos) {
	echo "<table class='table table-striped' style='width:auto' align='center'>
  <tr> 
    <th>DEPARTAMENTO</th>
	<th>ASIGNATURA</th>
	<th>AUTOR</th>
	<th>TITULO</th>
	<th>EDITORIAL</th>
	<th>GRUPOS</th>
	<th></th>
  </tr>";
	while ($row = mysqli_fetch_array($textos))
	{
		echo "<tr>
			 <td>$row[0]</td>
			 <td>$row[1]</td>
			 <td>$row[2]</td>
			 <td>$row[3]</td>
			 <td>$row[4]</td>
		  <td>$row[8]</td>
		  <td><a href='editextos.php?id=$row[6]'><i class='fa fa-pencil' title='Editar'> </i> </a> <a href=deltextos.php?id=$row[6] style='color:brown;' data-bb='confirm-delete'><i class='fa fa-trash-o' title='Borrar' > </i></a></td>
		  </tr>";      	
	}
		  echo "</table>";
}


?>
</div>
</div>
</div>

<?php include("../../pie.php");?>

