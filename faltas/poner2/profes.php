<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<center> 
<table class="table table-striped table-condensed table-bordered" style="">
    <tr>
<td></td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">L</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">M</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">X</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">J</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">V</span></div>
</div></td>
  </tr>
<?php
// Nombres de los días y variable que recoge el nombre del dia.
// Días de la semana
$horas=array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5",6=>"6");
foreach($horas as $n_hora => $nombre) 
{
echo "<tr><th><div class='badge badge-warning'>$nombre</div></th>";
		for($z=1;$z<6;$z++) 
{
	
	if ($z == "1")
	{ $diafaltas = $lunes1;}
    elseif ($z == "2")
	{ $diafaltas = $martes;}
    elseif ($z == "3")
	{$diafaltas = $miercoles;}
    elseif ($z == "4")
	{$diafaltas = $jueves;}
    elseif ($z == "5")
	{ $diafaltas = $viernes;}


?>
    
  <td valign="top">  
    <div align=center>
      <?php 
 $trozos = explode("_ ",$profesor) ;
		  $id = $trozos[0];
		  $profesores = $trozos[1]; 
// Comienza la presentación de la tabla.
// Asignaturas del Curso en un día
// Abreviatura de la Asignatura
$asignatur1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_asig FROM  horw_faltas where prof = '$profesores' and dia = '$z' and hora = '$n_hora'");
$rowasignatur1 = mysqli_fetch_row($asignatur1);
if($rowasignatur1[0]){echo "<h4><span class='label label-primary'>".$rowasignatur1[1]."</span></h4>"; }
 
// Recorremos los grupos a los que da en ese hora.
	$asignaturas1 = mysqli_query($db_con, "SELECT distinct  c_asig, a_grupo FROM  horw_faltas where prof = '$profesores' and dia = '$z' and hora = '$n_hora' AND a_grupo not like 'G%'");
$n = count($asignaturas1);
  while ($rowasignaturas1 = mysqli_fetch_array($asignaturas1))
    { 
    	
 		$nivel_curso = substr($rowasignaturas1[1],0,1);				
//	Problemas con Diversificación (4E-Dd)
			$profe_div = mysqli_query($db_con, "select * from profesores where grupo = '$rowasignaturas1[1]'");
			if (mysqli_num_rows($profe_div)<1) {		
				$diversificacion = 1;
				$grupo_div = mysqli_query($db_con, "select distinct unidad from alma where unidad like '$nivel_curso%' and (combasi like '%25204%' or combasi LIKE '%25226%' OR combasi LIKE '%135785%')");
				$grupo_diver = mysqli_fetch_row($grupo_div);
				$curso_con = $grupo_diver[0];
			}	
			else{
				$curso_con = $rowasignaturas1[1];
			}
    	
// Si no hay Nivel, pasamos del negocio y continuamos el Horario buscando las celdas que tienen datos.     	    	  
  if($rowasignaturas1[1] !== "") 
    	    {	

// Si hay más de un grupo, separamos para cada grupo un conjunto de variables distintas  	    	
    for ($i=0;$i<$n;$i++) 
    {   	    	  	    
 // Como esto es un formulario, y cada elemento del formulario debe tener una identificación única para poder convertirse en una variable válida, hay que producir un mogollón de nombres distintos para cada elemento del formulario. L estrucruraes: primera hora del lunes, del martes, etc. Y luego segunda hora del lunes, etc.	
  	$curso = substr($rowasignaturas1[1],$i,1);  
  	   // Fecha exacta de cada día, referida a los cálculos de nombres.php 
    echo "<INPUT type=hidden name=fecha".$z.$n_hora.$curso_con." value=$diafaltas>";	
	// Nivel y Grupo en pantalla	
	echo "<h4><span class='label label-warning'>" .$rowasignaturas1[1]."</span></h4>";      	
    echo "<INPUT type=hidden name=grupo".$z.$n_hora.$curso_con." value=$curso_con>";
    // Cambios de fecha entre PHP y MySQL, de española a internacional.
     if (isset($diafaltas)) {
    $fechanc = explode("-",$diafaltas);
    $dia10 = $fechanc[0];
    $mes10 = $fechanc[1];
    $ano10 = $fechanc[2];
    $fechanc0 = "$ano10-$mes10-$dia10";
    }
   
// Buscamos las faltas del profesor en esa semana y las clavamos en los campos de NC.
    $faltas10 = "select NC from FALTAS where FECHA = '$fechanc0' and FALTA = 'F' and PROFESOR = '$id' and HORA = '$n_hora' and unidad = '$curso_con' order by NC asc";	
    $faltas11 = mysqli_query($db_con, $faltas10);
    $faltas13 = "";
    while($faltas12 = mysqli_fetch_array($faltas11))
    {	
// Unimos las faltas si son varias mediante un punto.
    $faltas13 .= $faltas12[0]. ".";
}
// Eliminamos el último punto de la serie, limpiando un poco.
$faltas14 = rtrim($faltas13, "."); 
	  
    echo " <div class='form-group col-md-12'> 
    <INPUT type=text name=alumnos".$z.$n_hora.$curso_con." value='$faltas14' class='form-control input-sm'>
    </div>";
    echo "<INPUT type=hidden name=unidad".$z.$n_hora.$curso_con." value='$curso_con'>";
    echo "<INPUT type=hidden name=asignatura".$z.$n_hora.$curso_con." value='$rowasignaturas1[0]'>";
    echo "<INPUT type=hidden name=hora".$z.$n_hora.$curso_con." value='$n_hora'>";
    }}}
// Termina la presentación de la primera hora de todos los días de la semanana. El resto es lo mismo para las horas siguientes. 
?>
    </div></td>
  
  <?php }?></tr><?php }?>
</table>



