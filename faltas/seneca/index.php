<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$error=0;
if(isset($_POST['Submit'])) {
	
	$tipo = $_POST['tipo'];
	$iniciofalta = $_POST['iniciofalta'];
	$finfalta = $_POST['finfalta'];
	
	if (!empty($iniciofalta) && !empty($finfalta)) {
		switch ($tipo) {
			default :
			case 1 : header("Location:"."exportarSeneca.php?iniciofalta=$iniciofalta&finfalta=$finfalta"); break;
			case 2 : header("Location:"."exportar.php?iniciofalta=$iniciofalta&finfalta=$finfalta"); break;
		}
	}
	else {
		$error=1;
	}
}


include("../../menu.php");
include("../menu.php");
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Subir faltas a S&eacute;neca</small></h2>
</div>
<br />
 <?php
 if(isset($_POST['enviar'])) {
 // Descomprimimos el zip de las calificaciones en el directorio origen/ tras eliminar los antiguos
$dir = "./origen/";
$ficheroseliminados="";
$handle = opendir($dir);
while ($file = readdir($handle)) {
 if (is_file($dir.$file) and strstr($file,"xml")==TRUE) {
  if ( unlink($dir.$file) ){
   $ficheroseliminados++;
  }
 }
}

include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo1']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH, $dir) == 0) 
	  {
        die("Error : ".$archive->errorInfo(true));
      }  
      echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los archivos de los alumnos han sido descargados correctamente en el directorio /faltas/seneca/origen/.
</div></div><br />';
 }
?>
<div class="col-sm-6">
<legend align="center">Importar datos de los Alumnos</legend>
<FORM ENCTYPE="multipart/form-data" ACTION="index.php" METHOD="post" role="form">
  <div class="well well-large" align="left">

 <div class="form-group">
    <p class="help-block">Selecciona el archivo comprimido descargado desde Séneca 'Exportacion_Faltas_Alumnado.zip'</p>
   <input type="file" name="archivo1" class="input input-file" id="file1">
  </div>
  
     <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary btn-block">
  
  </div> <!-- well -->
<hr />
  <div class="help-block" style="text-align:justify; <?php if($error) echo 'color: red;';?>"><p class="lead text-warning">Información sobre la Importación.</p>
Para poder subir las faltas de los alumnos a Séneca, es necesario en primer lugar descargar un archivo desde <em>S&eacute;neca --> Utilidades --> Imprtaci&oacute;n/Exportaci&oacute;n --> Exportaci&oacute;n de Faltas del alumnado</em>. <br />Crea un nuevo archivo con todos los grupos del Centro, y acepta la fecha propuesta. Tardar&aacute; unos instantes en aparecer, as&iacute; que vuelve al cabo de un minuto a la misma p&aacute;gina y te aparecer&aacute; un mensaje confirmando que el archivo ha sido generado. <br />Descarga el archivo y selecciónalo para proceder. Los archivo se colocan en el directorio /faltas/seneca/origen/ y se utilizan como punto de partida en la generación del archivo comprimido que subiremos a Séneca. Puede ser necesario repetir este procedimientoa lo largo del Curso para actualizar la lista de los alumnos.
 </div>
</FORM>
</div>


<div class="col-sm-6">
<legend align="center">Exportar Faltas a Séneca</legend>
<div class="well" align="left">	

        <form id="form1" name="form1" method="post" action="index.php">
  <fieldset>      
 <div class="form-group col-md-6" id="datetimepicker1" style="display: inline;">
<label class="control-label"
	for="iniciofalta">Primer d&iacute;a:</label>
<div class="input-group">
<input name="iniciofalta" type="text"
	class="form-control" value="" data-date-format="DD/MM/YYYY" id="iniciofalta"
	required> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>

<div class="form-group col-md-6" id="datetimepicker2" style="display: inline;">
<label class="control-label"
	for="finfalta">Ultimo d&iacute;a:  </label>
<div class="input-group">
<input name="finfalta" type="text"
	class="form-control" value="" data-date-format="DD/MM/YYYY" id="finfalta"
	required> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</div>
      <br>
      
      <p class="lead">Tipo de exportaci&oacute;n</p>
      <div class="radio">
  <label>
    <input type="radio" name="tipo" value="1" checked>
     Generar un archivo con todas las unidades.
  </label>
</div>
      <div class="radio">
  <label>
    <input type="radio" name="tipo" value="2">
     Generar un archivo por cada unidad.
  </label>
</div>

   <br />
  <input type="submit" name="Submit" value="Enviar" class="btn btn-primary btn-block" />
  </fieldset>
        </form>
      
        </div>
        <hr />
        <div class="help-block" style="text-align:justify; <?php if($error) echo 'color: red;';?>"><p class="lead text-warning">Instrucciones de Uso.</p>
        La condición esencial que debe cumplirse para poder subir las faltas a Séneca es que el horario de los profesores esté correctamente registrado en Séneca. El 99% de los problemas que puedan surgir al subir las faltas se deben al horario. Revisa el horario con detenimiento antes de proceder, con especial cuidado a los cursos de Bachillerato.<br />
        Es importante que los datos de los Alumnos est&eacute;n actualizados para evitar errores en la importaci&oacute;n de las Faltas. El formulario de la izquierda permite actualizar la información.<br />Adem&aacute;s, ten en cuenta que S&eacute;neca s&oacute;lo acepta importaciones de un mes m&aacute;ximo de Faltas de Asistencia. Por esta raz&oacute;n, el Primer D&iacute;a que introduces debe ser el primer d&iacute;a del mes (o el mas pr&oacute;ximo en caso de que sea un mes de vacaciones, o 
puente coincidente con los primeros dias de un mes, etc.). <br />El mismo criterio se aplica para el ultimo d&iacute;a del mes. <br />Una vez le damos a enviar se generan los ficheros (o el fichero comprimido, según la opción elegida) que posteriormente se importan a S&eacute;neca, as&iacute; que ya puedes abrir la pagina de S&eacute;neca para hacerlo. La opción por defecto, más simple y cómoda, es la creación de un archivo comprimido con todos los Grupos. El archivo comprimido se genera en el navegador preparado para subir.<br /> La opción de crear tantos archivos como Grupos tiene una función de ayuda en caso de problemas al subir las faltas a Séneca (ayuda a determinar dóde se encuentra el problema y solucionarlo). Los archivos se encuentran en el directorio de la intranet /faltas/seneca/exportado/.</div>
        
</div>
</div>

</div>
  
        <?php	
include("../../pie.php");
?>   

<?php 
$exp_inicio_curso = explode('-', $config['curso_inicio']);
$inicio_curso = $exp_inicio_curso[2].'/'.$exp_inicio_curso[1].'/'.$exp_inicio_curso[0];

$exp_fin_curso = explode('-', $config['curso_fin']);
$fin_curso = $exp_fin_curso[2].'/'.$exp_fin_curso[1].'/'.$exp_fin_curso[0];

$result = mysqli_query($db_con, "SELECT fecha FROM festivos ORDER BY fecha ASC");
$festivos = '';
while ($row = mysqli_fetch_array($result)) {
	$exp_festivo = explode('-', $row['fecha']);
	$dia_festivo = $exp_festivo[2].'/'.$exp_festivo[1].'/'.$exp_festivo[0];
	
	$festivos .= '"'.$dia_festivo.'", ';
}

$festivos = substr($festivos,0,-2);
?>
	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false,
			minDate:'<?php echo $inicio_curso; ?>',
			maxDate:'<?php echo $fin_curso; ?>',
			disabledDates: [<?php echo $festivos; ?>],
			daysOfWeekDisabled:[0,6] 
		});
		
		$('#datetimepicker2').datetimepicker({
			language: 'es',
			pickTime: false,
			minDate:'<?php echo $inicio_curso; ?>',
			maxDate:'<?php echo $fin_curso; ?>',
			disabledDates: [<?php echo $festivos; ?>],
			daysOfWeekDisabled:[0,6] 
		});
	});  
	</script>
</body>
</html>