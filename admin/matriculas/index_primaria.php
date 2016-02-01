<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
include("menu.php");
?>
<div class="container">

<div class="page-header" align="center">
  <h2>Matriculación de Alumnos <small> Importar Alumnos de Primaria</small></h2>
</div>
<br />
<div class="row">
<div class="col-sm-5">
<FORM ENCTYPE="multipart/form-data" ACTION="../../xml/jefe/alma_primaria.php" METHOD="post">
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
 <p class="help-block">El m&oacute;dulo de Matriculaci&oacute;n permite importar los datos de los alumnos de Colegios adscritos al IES, facilitando enormemente la tarea al tomar los datos de las criaturas de la base de datos. Para contar con los datos de los Colegios, los Directores de los mismos deben proporcionar el archivo de S&eacute;neca RegAlum.txt (lo descargamos desde S&eacute;neca: Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano). Una vez en nuestras manos, le cambiamos el nombre por el del Colegio respectivo (p.ej.: Santo Tomas.txt), y comprimimos todos los archivos en formato .zip. Este es el archivo comprimido que debes seleccionar en el formulario.</p><p><em><strong>Hay que tener en cuenta que el módulo de importación supone que el formato de las grupos de los Colegios es semejante al de los Institutos</strong></em>, por lo que se espera que el nombre sea del tipo <strong>6P-A</strong>, <strong>6º A</strong>,, <strong>6º Primaria A</strong> etc. Si el Colegio no sigue ese criterio, es necesario editar los archivos de Séneca y buscar / reemplazar el nombre de las Unidades para ajustarlo a los criterios de la Intranet antes de proceder a la importación.</p><p>
La importación de los alumnos de Primaria también permite que los Colegios adscritos puedan registrar los Informes de Tránsito de los alumnos de 6º a través del módulo correspondiente de la Página del Centro (http://iesmonterroso.org/transito/). Estos datos prueden luego ser consultados en Informes de Tránsito en el Módulo de Matriculación de la Intranet. Para que los Colegios accedan, se genera una contraseña que debe ser entregada al Director de cada Centro. Ésta se genera escribiendo el nombre del colegio sin espacios y en minúsculas, seguido de un guión bajo y el código de Centro de nuestro IES.  
 </p>
</div>

</div>
</div>


	<?php include("../../pie.php"); ?>

</body>
</html>

