<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];

include("../../menu.php");
include("menu.php");
?>
<div align="center">
<div class="page-header">
  <h2>Matriculación de Alumnos <small> Importar Alumnos de Secundaria</small></h2>
</div>
<br />
<FORM ENCTYPE="multipart/form-data" ACTION="../../xml/jefe/alma_secundaria.php" METHOD="post">
  <div class="form-group success">
    <p class="help-block" style="width:600px; text-align:left"><span style="color:#9d261d">(*) </span>El m&oacute;dulo de Matriculaci&oacute;n permite importar los datos de los alumnos de los Institutos de ESO puros cuyos alumnos suelen matricularse en el Centro, facilitando enormemente la tarea de la matr&iacute;cula. Para contar con los datos de los IES, los Directores de los mismos deben proporcionar el archivo de S&eacute;neca RegAlum.txt (lo descargamos desde S&eacute;neca: Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano). Una vez en nuestras manos, le cambiamos el nombre por el del IES respectivo, y comprimimos todos los archivos en formato .zip. Este es el archivo que debes seleccionar en el formulario.</p></div><br />
  <div class="well well-large" style="width:500px; margin:auto;" align="left">
  <p class="lead">Selecciona el archivo con los datos<br />
  </p>
  <input type="file" name="archivo1" class="input input-file col-sm-4">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
</FORM>
<br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>
</div>

	<?php include("../../pie.php"); ?>

</body>
</html>