<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];


include("../../menu.php");
include("menu.php");

if (empty($departamento) and stristr($_SESSION['cargo'],'4') == TRUE){
	$departamento=$_SESSION['dpt'];
	$departament=$departamento;
}
else{
	$departament="Dirección del Centro";
}
echo '<div align="center">';
  echo '<div class="page-header">
  <h2>Jefaturas de los Departamentos <small> Registro de Reuniones</small></h1>
  <h3 style="color:#08c;">'.$departament.'</h3>
</div>
<br />';
?>
<p class="lead" align="center">Actas que contienen la expresión<a href="#"> &quot;<?php echo $expresion;?></a>&quot;</p><br /><?php
$trozos = explode(" ",$expresion,5);
$frase="";
for($i=0;$i<5;$i++)
{
if(!(empty($trozos[$i]))){
$frase.=" and (contenido like '%$trozos[$i]%')";
}
}
if (stristr($_SESSION['cargo'],'4') == TRUE){
	$dep = " and departamento = '".$_SESSION['dpt']."' ";
}
else{
	$dep = "";
}
$query = "SELECT  id, fecha, departamento, contenido, jefedep, numero FROM r_departamento where 1=1".$frase." ". $dep ." order BY id DESC limit 50";
// echo $query;
$result = mysqli_query($db_con, $query);
if(mysqli_num_rows($result) > 0)
{
?>
	<div align="center">
    <TABLE class="table table-striped" style="width:auto;">
<?	while($row = mysqli_fetch_object($result))
	{
	?>      <tr> 
        <td>       
      <?php
	echo $row->numero; 
	?>	
</td>
 <td>       
      <?php
	echo $row->fecha; 
	?>	
</td>
 <td>       
      <?php
	echo $row->departamento; 
	?>	
</td>
<td style="text-align:right;">
<a href="story.php?id=<?php echo $row->id; ?>"  style="color:#08c;margin-right:10px;"><i class="fa fa-search" data-bs="tooltip" title='Ver el Acta'> </i></a> 
<a href="pdf.php?id=<?php echo $row->id; ?>"  style="color:#990000"> <i class="fa fa-print" data-bs="tooltip" title='Crear PDF del Acta para imprimir o guardar'> </i></a>  
</div>
        </td>
      </tr>

	<?php
	}
		echo "</TABLE></div>";

}
else
{
?>
<div align="center"><div class="alert alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Lo sentimos, pero ninguna noticia responde a ese criterio de búsqueda.          
</div>
</div>
<?php
}
?>

</div><?php

include("../../pie.php");
?>

</body>
</html>
