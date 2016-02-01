<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

  $SQLT = "select DISTINCTROW FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALUMNOS.nc,
  FALTAS.fecha, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal
  and FALTAS.falta = 'F' and FALUMNOS.claveal = $claveal GROUP BY FALUMNOS.apellidos";
  $SQLTJ = "select DISTINCTROW FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALUMNOS.nc, 
  FALTAS.fecha, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal
  and FALTAS.falta = 'J' and  FALUMNOS.claveal = $claveal GROUP BY FALUMNOS.apellidos";
 //print $SQLT;
  $resultt = mysqli_query($db_con, $SQLT);
  $rowt = mysqli_fetch_array($resultt);
  $resulttj = mysqli_query($db_con, $SQLTJ);
  $rowtj = mysqli_fetch_array($resulttj);

  if ($rowt != "" OR $rowtj != "")
             {
echo "<h4 class='text-info'>Faltas de Asistencia en el Curso</h4>";
echo "<h5>
		Días con Faltas de Asistencia</h5>";
		do {
  	if($rowt[5]=="")
		$rowt[5]="0";
		  	if($rowtj[5]=="")
		$rowtj[5]="0";
		printf ("<TABLE class ='table table-bordered' style='width:auto'><tr><th>Faltas sin justificar</th><td style='color:#9d261d;font-weight:bold'>%s</td></tr>\n", $rowt[5]);
				printf ("<tr><th>Faltas justificadas</th><td style='color:#46a546; font-weight:bold'>%s</td></tr>\n", $rowtj[5]);
        } while($rowt = mysqli_fetch_array($resultt) or $rowtj = mysqli_fetch_array($resulttj));
        echo "</table></center>\n";
        }
	$fechasp0=explode("-",$fecha1);
	$fechasp1=$fechasp0[2]."-".$fechasp0[1]."-".$fechasp0[0];
	$fechasp2=explode("-",$fecha2);
	$fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
  $SQLF = "SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALUMNOS.nc, FALTAS.falta, FALTAS.fecha FROM FALUMNOS, FALTAS where FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.falta = 'F' and  FALUMNOS.claveal = '$claveal' and FALTAS.codasi = '$asignatura' group by FALUMNOS.APELLIDOS, FALTAS.fecha";
  $resultf = mysqli_query($db_con, $SQLF);
  $rowf = mysqli_fetch_array($resultf);
  $numdias = mysqli_num_rows($resultf);
  echo "<h5>Faltas de Asistencia en esta Asignatura (<span style='color:brown;'>".$numdias."</span>)</h5>";
   if(mysqli_num_rows($resultf) > '0')
	{
$nf = "";
$numdias=mysqli_num_rows($resultf);
		echo "<table class='table table-bordered' style='width:auto;'><tr><td>";
					do {
	$nf = $nf + 1;		
	$fechar=explode("-",$rowf[5]);
	$fechar1=$fechar[2]."-".$fechar[1]."-".$fechar[0];
				printf ("&nbsp;".$fechar1."&nbsp;");
				for($i=0;$i<$numdias;$i=$i+11){
				if($nf == $i) echo "<br>";}
		} while($rowf = mysqli_fetch_array($resultf));
		
        echo "</td></tr></TABLE>";}
        else{
			echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El Alumno no tiene Faltas en tu Asignatura.
</div></div>';
        }
		
		
      
    ?>
