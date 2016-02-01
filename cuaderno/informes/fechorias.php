<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

echo "<h4 class='text-info'>Problemas de convivencia</h4>";

// Consulta del aï¿½ en curso.

  $fechoria = mysqli_query($db_con, "select distinct Fechoria.claveal from Fechoria where Fechoria.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha");
$fech = mysqli_fetch_array($fechoria);

if ($fech[0] == "")
{ 
echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El Alumno no tiene Problemas de convivencia.
</div></div>';}
else {

  $result = mysqli_query($db_con, "select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, 
  Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal
   and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.unidad, 
    FALUMNOS.apellidos");
 // print "$AUXSQL";
  if ($row = mysqli_fetch_array($result))

	$fecha1 = (date("d").-date("m").-date("Y"));
		echo "<table class='table table-striped' style='width:auto'>
		<TR><Th nowrap>FECHA</th>

		<th>TIPO</th><th 
		 nowrap>INFORMA</th></tr>";

                do {
		
//	$claveal = $row[8];
	// print $claveal;
		$numero = mysqli_query($db_con, "select claveal from Fechoria where claveal = '$claveal' and Fechoria.fecha >= '2005-09-01'"); 
		// $numero1 = "select claveal from Fechoria where claveal = '$claveal' and Fechoria.fecha >= '2005-09-01' "; 
		// print $numero1;
		$rownumero= mysqli_num_rows($numero);
		$rowcurso = $row[2];
                $rowalumno = $row[0].",&nbsp;".$row[1];
		printf ("<tr><td >%s</td><td>%s</td>
		<td>%s</td></tr>",  $row[4], $row[5], $row[6]);
        } while($row = mysqli_fetch_array($result));
        echo "</table>";
        }
	
  ?>

