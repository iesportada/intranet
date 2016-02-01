<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
include("menu.php");
?>
<div class="container">

<div class="page-header" align="center">
  <h2>Matriculación de Alumnos <small> Importar Alumnos de E.S.O.</small></h2>
</div>
<br />
<div class="row">
<div class="col-sm-5">
<FORM ENCTYPE="multipart/form-data" ACTION="../../xml/jefe/alma_secundaria.php" METHOD="post">
  <div class="well well-large">
  <p class="lead">Selecciona el archivo con los datos<br />
  </p>
  <input type="file" name="archivo1" class="input input-file span4">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
</FORM>
</div>
<div class="col-sm-7">
 <p class="help-block">El m&oacute;dulo de Matriculaci&oacute;n permite importar los datos de los alumnos de Centros de Educación Secundaria, facilitando la tarea de matriculación al tomar los datos de las criaturas de la base de datos. Para contar con los datos de los Centros, los Directores de los mismos deben proporcionar el archivo de S&eacute;neca RegAlum.txt (lo descargamos desde S&eacute;neca: Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano). Una vez en nuestras manos, le cambiamos el nombre por el del Centro respectivo (p.ej.: IES Puerta del Mar.txt), y comprimimos todos los archivos en formato .zip. Este es el archivo comprimido que debes seleccionar en el formulario.</p><p><em><strong>Hay que tener en cuenta que el módulo de importación supone que el formato de las grupos de los Centros sea más o menos standard</strong></em>, por lo que se espera que el nombre sea del tipo <strong>4E-A</strong>, <strong>4º A</strong>,, <strong>4º de ESO A</strong> etc. Si el Centro no sigue ese criterio, es necesario editar los archivos de Séneca y buscar / reemplazar el nombre de las Unidades para ajustarlo a los criterios de la Intranet antes de proceder a la importación.</p><p> 
 </p>
</div>

</div>
</div>


	<?php include("../../pie.php"); ?>

</body>
</html>