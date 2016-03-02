<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>

<style type="text/css">
.table td{
	vertical-align:middle;
}
</style>
<div class="container">
<div class="page-header">
  <h2>Problemas de convivencia <small> Alumnos expulsados</small></h2>
</div>
<br />

<div class="row">

<div class="col-sm-12 ">	
<?php   
  $hoy = date('Y') . "-" . date('m') . "-" . date('d');
  $ayer = date('Y') . "-" . date('m') . "-" . (date('d') - 1);
  $result = mysqli_query($db_con, "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad,
  FALUMNOS.nc, Fechoria.expulsion, inicio, fin, id, Fechoria.claveal, tutoria from Fechoria,
  FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and expulsion > '0' and Fechoria.fin = '$ayer'
  order by Fechoria.fecha ");
echo "<legend align='center'>Alumnos que se reincorporan hoy tras su expulsión</legend>";
     if ($row = mysqli_fetch_array($result))
        {

		echo "<center><table class='table table-striped' style='width:auto'>";
        echo "<tr><th>Apellidos</th><th>Nombre</th>
		<th>Grupo</th><th>Días</th><th>Comienzo</th><th>Fin</th><th>Detalles</th><th>Tareas</th><th>Foto</th></tr>";

                do {
$foto0="";		
$tareas0 = "select id from tareas_alumnos where fecha = '$row[5]' and claveal = '$row[8]' and duracion = '$row[4]'";
		//echo $tareas0;
		$tareas1 = mysqli_query($db_con, $tareas0);
		$tareas = mysqli_fetch_row($tareas1);
		$idtareas = $tareas[0];
		$bgcolor="white";
		$foto0 = "<div align='center'><img src='../../xml/fotos/$row[8].jpg' border='2' width='40' height='50' style='margin:auto;border:1px solid #ccc;'  /></div>";
	
                printf ("<tr><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td>
<td>
<A HREF='detfechorias.php?id=$row[7]&claveal=$row[8]'><i class='fa fa-search' title='Detalles'> </i> </A></td>
<td ><A HREF='../tareas/infocompleto.php?ver=ver&id=$idtareas'><i class='fa fa-tasks' title='Tareas' title='Ver Tareas del Alumno'> </i> </A>
</td><td >%s</td></tr>", $row[0], $row[1], $row[2], $row[4], $row[5], $row[6], $foto0);

        }
while( $row = mysqli_fetch_array($result));
                        echo "</table></center>";
        } 
		else{
			echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
 Parece que ningún Alumno se reincorpora hoy al Centro.          
		</div></div>';
			 }
  
  
echo "<br /><legend align='center'>Alumnos expulsados del Centro actualmente</legend>";
  $result = mysqli_query($db_con, "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad,
  FALUMNOS.nc, Fechoria.expulsion, inicio, fin, id, Fechoria.claveal, tutoria from Fechoria,
  FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and expulsion > '0' and date(Fechoria.fin) >= '$hoy'
  and date(Fechoria.inicio) <= '$hoy' order by Fechoria.fecha ");
     if ($row = mysqli_fetch_array($result))
        {
		echo "<center><table class='table table-striped' style='width:auto'>";
        echo "<tr><th>Apellidos</th><th>Nombre</th>
		<th>Grupo</th><th>Días</th><th>Comienzo</th><th>Fin</th><th>Detalles</th><th>Foto</th></tr>";

                do {
		$foto="";
		$foto = "<div align='center'><img src='../../xml/fotos/$row[8].jpg' border='2' width='40' height='50' style='margin:auto;border:1px solid #bbb;'  /></div>";

				if(strlen($row[9]) > 0 or strlen($row[10]) > 0 ){$comentarios="(*)";}else{$comentarios="";}
                printf ("<tr ><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td>
<td  align='center'><A HREF='detfechorias.php?id=$row[7]&claveal=$row[8]'><i class='fa fa-search' title='Detalles'> </i> </A></td><td >%s</td></tr>", $row[0], $row[1], $row[2],$row[4], $row[5], $row[6], $foto);

        }
while( $row = mysqli_fetch_array($result));
                        echo "</table></center>";
        } 
  		else{ 
		echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
 Parece que no hay alumnos actualmente expulsados del Centro.          
		</div></div>';
		}



  ?>
  </div>
  </div>
  </div>
  
	<?php include("../../pie.php"); ?>
	
</body>
</html>