<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<h4 class='text-info'>
 Datos del Alumno</h4><br />
  <?php
   
  
  $SQL = "select distinct alma.claveal, alma.apellidos, alma.nombre, alma.unidad, alma.matriculas,\n
  alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.PADRE from alma
  where claveal = '$claveal' order BY alma.apellidos";
  // echo $SQL;
  $result = mysqli_query($db_con, $SQL);
echo "<table  class='table table-striped' style='width:auto'>";
                while($row = mysqli_fetch_array($result)){
		$claveal = $row[0];
		$PADRE =  $row[9];
		echo "
<tr><th>Clave</th><td>$claveal</td></tr>
<tr><th>Nombre</th><td>$row[2] $row[1]</td></tr>
<tr><th>Grupo</th><td>$row[3]</td></tr>
<tr><th>DNI</th><td>$row[5]</td></tr>
<tr><th>FECHA</th><td>$row[6]</td></tr>
<tr><th>DOMICILIO</th><td>$row[7]</td></tr>
<tr><th>TELÉFONO</th><td>$row[8]</td></tr>
<tr><th>PADRE</th><td>$PADRE</td></tr>";
        } 
        echo "</table>";        
  ?>

