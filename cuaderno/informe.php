<?php
require('../bootstrap.php');


include("../menu.php");
include("menu.php");
?>
<div class="container">
<div class="row">
<?php
echo "<div class='page-header'>";
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
echo "<h2 class='no_imprimir'>Cuaderno de Notas&nbsp;&nbsp;<small> Informes personales</small></h2>";
echo "</div>";
echo '<div align="center">';
?>
<div class="col-sm-8 col-sm-offset-2">
<?php

$dia = $_GET['dia'];
$hora = $_GET['hora'];
 foreach($_GET as $key => $val)
	{
		${$key} = $val;
	}
	echo "<h3><span class='label label-info' style='padding:8px'>$curso -- $nom_asig </span></h3><br>";
		 
if($siguiente == '1'){
  $unidad = $curso;
  $adelante1 = "select nc, claveal from FALUMNOS where unidad = '$unidad' and nc>$nc order by nc asc limit 2";
  $adelante0 = mysqli_query($db_con, $adelante1);
  $adelante = mysqli_fetch_array($adelante0);
  $nc = $adelante[0];
  $claveal = $adelante[1];
  }
   if($anterior == '1'){
  $unidad = $curso;
  $menor = $nc - 1;
  $anterior1 = "select nc, claveal from FALUMNOS where unidad = '$unidad' and nc < '$nc' order by nc desc limit 1";
  $anterior0 = mysqli_query($db_con, $anterior1);
  $anterior = mysqli_fetch_array($anterior0);
  $nc = $anterior[0];
  $claveal = $anterior[1];
  }
  $alum = mysqli_query($db_con, "select nc, unidad , nombre, apellidos from FALUMNOS where claveal = '$claveal'");
  $alumno = mysqli_fetch_array($alum);
  $nc = $alumno[0];
  $unidad = $alumno[1];
  $nombre = $alumno[2];
  $apellidos = $alumno[3];
  $curso = $unidad;

	
	$max_nc = mysqli_query($db_con, "select max(nc) from FALUMNOS where unidad = '$unidad'");
  	$max = mysqli_fetch_row($max_nc);
	$ultimo = $max[0];
	

	
  echo "<br /><div class='well'><table style='width:100%'><tr><td style='text-align:center;width:90%'><h4 class='text-info'>";
  
  if($nc > 1){$mens_ant = "informe.php?profesor=$profesor&clave=$clave&nc=$nc&curso=$curso&asignatura=$asignatura&nombre=$nombre&apellidos=$apellidos&nom_asig=$nom_asig&dia=$dia&hora=$hora&anterior=1";
  echo '<button class="btn btn-primary btn-sm" name="anterior" onclick="window.location=\'';	
  echo $mens_ant;
  echo '\'" style="cursor: pointer;"><i class="fa fa-chevron-left">&nbsp; </i> Anterior</button>';}
  
  echo "&nbsp;&nbsp; $nombre $apellidos &nbsp;&nbsp;"; 
   
  if($nc < $ultimo){
 $mens_sig = "informe.php?profesor=$profesor&clave=$clave&nc=$nc&curso=$curso&asignatura=$asignatura&nombre=$nombre&apellidos=$apellidos&nom_asig=$nom_asig&dia=$dia&hora=$hora&siguiente=1";
	echo ' <button class="btn btn-primary btn-sm" name="siguiente" onclick="window.location=\'';	
	echo $mens_sig;
	echo '\'" style="cursor: pointer;">Siguiente &nbsp;<i class="fa fa-chevron-right "> </i> </button>';}
	echo "</h4></td><td style='text-align:right'>";
	   	$foto = '../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto)) {
		echo "<img src='../xml/fotos/$claveal.jpg' width='60' height='72' class='img-respnsive'  />";
	}
		else {
				echo '<span class="fa fa-user fa-fw fa-4x"></span>';
			}	
			echo "</td></tr></table>";
			
	
 	echo "</div>"; 

?>
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Notas del alumno</a></li>
<li><a href="#tab2" data-toggle="tab">Datos generales</a></li>
<li><a href="#tab3" data-toggle="tab">Datos académicos </a></li>
</ul>
<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<div class="tab-pane fade in active" id="tab1">
<br>
<?php  
// Procesamos los datosxxxx
$datos1 = "select distinct fecha, nombre, nota from datos, notas_cuaderno where  notas_cuaderno.id = datos.id and profesor = '$profesor' and curso like '%$curso%,' and claveal = '$claveal' and asignatura = '$asignatura' order by orden";
$datos0 = mysqli_query($db_con, $datos1);
	if (mysqli_num_rows($datos0) > 0) {
		?>
    <h4 class='text-info'>
 Notas en la Columnas</h4><br />
    <?php
echo "<table align='center' class='table table-striped' style='width:auto'>\n"; 
echo "<tr><th>Fecha</td><th>Columna</td><th>Datos</td>";
		while($datos = mysqli_fetch_array($datos0))
		{
		echo "<tr><td class='text-info' nowrap>".cambia_fecha($datos[0])."</td><td>$datos[1]</td><td align='left' class='text-success'> <strong>$datos[2]</strong></td></tr>";
		}
echo "</table>";
		}
		else	
		{
echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El alumno no tiene notas registradas.
</div></div>';		
		}
?>
</div>

<div class="tab-pane fade in" id="tab2">
<br>
<?		
   	include("informes/datos.php");
	echo '<hr style="width:400px;">';   
?>
    </div>
    
<div class="tab-pane fade in" id="tab3">
<br>
<div align="left">
<?	
include("informes/faltas.php");
echo '<hr style="width:400px;">';
include("informes/fechorias.php");
echo '<hr style="width:400px;">';
include("informes/notas.php");
?>
</div>
<br />
</div>
</div>
</div>
</div>
</div>
</div>
<?php 
include("../pie.php");
?>
  </body>
</html>

