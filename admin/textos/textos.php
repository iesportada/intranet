<?php
require('../../bootstrap.php');

 
include("../../menu.php");
include 'menu.php';

if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (strstr(" P.E.S.",$departamento)==TRUE) {
	$departamento = str_replace(" P.E.S","",$departamento);
}
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}

$AUXSQL = "";
  if  (TRIM("$departamento")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and Textos.Departamento = '$departamento'";
    }
// Base de datos
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Libros de Texto <small> Búsqueda de Textos</small></h2>
</div>
<div class="col-sm-12">
<?php
	print "<h3 align=center class='text-muted'>$nivel</h3>"; 
$textos = mysqli_query($db_con, "SELECT distinct Departamento, Asignatura, Autor, Titulo, Editorial, Notas, Id, nivel, grupo FROM Textos where nivel = '$nivel' " . $AUXSQL . " order by Asignatura");
if (mysqli_num_rows($textos)>0) {
		echo "<br /><table class='table table-striped' align='center'>
  <tr> 
    
    <th>DEPARTAMENTO</th>
	<th>ASIGNATURA</th>
	<th>AUTOR</th>
	<th>TITULO</th>
	<th>EDITORIAL</th>
	<th>GRUPOS</th>";
	 if(stristr($_SESSION['cargo'],'1') == TRUE OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['dpt'] == $row[0]))
{
	echo "<th></th>";
			 }

  echo "</tr>";
	
  while ($row = mysqli_fetch_array($textos))
   {
           echo "<tr>";		 
			 echo "
			 <td>$row[0]</td>
			 <td>$row[1]</td>
			 <td>$row[2]</td><td>$row[3]</td><td>$row[4]</td>
		  <td>$row[8]</td>";
		   if(stristr($_SESSION['cargo'],'1') == TRUE OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['dpt'] == $row[0]))
{
	echo "<td nowrap><a href='editextos.php?id=$row[6]'><i class='fa fa-pencil' title='Editar'> </i> </a>&nbsp;&nbsp;<a href=deltextos.php?id=$row[6] style='color:brown;' data-bb='confirm-delete'><i class='fa fa-trash-o' title='Borrar' > </i></a></td>";
			 }
		  
		  echo "</tr>";
   }
		  echo "</table>";
}

		else
		{
			echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hubo suerte, bien porque te has equivocado
        al introducir los datos, bien porque ningún dato se ajusta a tus criterios.
		</div></div><br />';
		echo '<input type="submit" name="enviar2" value="Volver atrás" onClick="history.back(1)" class="btn btn-primary">';
		}

?>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
	
</body>
</html>
