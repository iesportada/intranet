<?php
require('../../bootstrap.php');


include("../../menu.php");
include("../menu.php");
?>

<div class="container">
<div class="row">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Alumnos Absentistas</small></h2>
</div>
<br />
<div class="col-sm-5 col-sm-offset-1">
<div class="well well-large" style="text-align:left;">
<?php
	  if(stristr($_SESSION['cargo'],'1') == TRUE)
	  {
?>
<form enctype='multipart/form-data' action='lista.php' method='post' role="form">
<legend> Consulta por Mes y Número de Faltas.</legend>
<fieldset>		
                    <div class="form-group ">
<label class="control-label">Mes </label>
	
                    <select name='mes' type='text' class="form-control">
                    <option></option>
                    <option>Septiembre</option>
                    <option>Octubre</option>
                    <option>Noviembre</option>
                    <option>Diciembre</option>
                    <option>Enero</option>
                    <option>Febrero</option>
                    <option>Marzo</option>
                    <option>Abril</option>
                    <option>Mayo</option>
                    <option>Junio</option>
                    </select>
 </div>
                    <div class="form-group">
                    <label >Número mínimo de Faltas</label>
                    <INPUT name="numero" type="text" id="numero" size="3" maxlength="3" class="form-control">
                    </div>
                    <br /> 
			              <INPUT name="submit4" type="submit" value="Enviar Datos" id="submit4" class="btn btn-primary"> 
</fieldset>
</form>
<?php
	  }
?>
</div>
</div>
<div class="col-sm-5">
<div class="well well-large" style="text-align:left;">
<form enctype='multipart/form-data' action='index2.php' method='post'>
<legend> Consulta de Absentismo por mes.</legend>
<fieldset>		
                    <div class="form-group ">
                    <label>Mes</label>
                    <select name='mes' type='text' class="form-control">
                    <option>Septiembre</option>
                    <option>Octubre</option>
                    <option>Noviembre</option>
                    <option>Diciembre</option>
                    <option>Enero</option>
                    <option>Febrero</option>
                    <option>Marzo</option>
                    <option>Abril</option>
                    <option>Mayo</option>
                    <option>Junio</option>
                    </select>
</div>
<br />
                    <INPUT name="submit5" type="submit" value="Ir a la Página de Informes" class="btn btn-primary"> 
</form>
</div>
</div>
</div>
</div>
    <?php 
include("../../pie.php");
?>
</body>
</html>
