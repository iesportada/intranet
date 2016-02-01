<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");

$fotos_dir = "../fotos_profes";

//Descomprimimos el archivo .zip con la fotos
include('../../lib/pclzip.lib.php');   
$archive = new PclZip($_FILES['archivo']['tmp_name']);  
      if ($archive->extract(PCLZIP_OPT_PATH, $fotos_dir) == 0) 
	  {
        die('<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
Ha surgido un problema al importar las fotos. Una de dos: o tu servidor no admite la subida de archivos con PHP porque la directiva <em>file_uploads</em> está desactivada ( Off ) o el 
tamaño máximo de archivo para subir al servidor es inferior al del archivo comprimido que estás intentando subir.
Tienes dos opciones para solucionar el problema: o bien te aseguras de que la directiva <em>file_uploads</em> está activada ( On ) y aumentas el tamaño de 
<em>upload_max_filesize</em> en el archivo de configuración de PHP <em>php.ini</em>, o bien comprime las fotos en varios paquetes pequeños ( 32MB, p. ej. )
 y los subes uno tras otro. Tu decides.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');
      }  
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Administración <small> Importación masiva de fotos de Profesores</small></h2>
</div>
<br />
<div class="well well-large" style="width:700px;margin:auto;text-align:left">

<?php
// Comprobamos estado del directorio con las fotos.

$d = dir($fotos_dir);
while (false !== ($entry = $d->read())) {
   $n_file+=1;
}
// Directorio vacío
if ($n_file<5) {
	echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />
Ha surgido un problema al importar las fotos. Parece que el directorio donde deben ser copiadas no existe o está vacío porque las fotos no se han subido correctamente. 
Comprueba el estado del directorio (debe tener permiso de escritura) e inténtalo de nuevo.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>';
	     	exit();
}
else{
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Las fotos se han subido correctamente al directorio correspondiente. Hay <strong>'. $n_file .'</strong> fotos de alumnos en el directorio.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>';
}
$d->close();
?>
</div>