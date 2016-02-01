<?php
if(stristr($_SESSION['cargo'],'4') == TRUE)
{
	include("introducir.php");
}
else{

require('../../bootstrap.php');

include("../../menu.php");
include("menu.php");
?>
<div class="container">
<div class="page-header">
<h2>Material del Centro <small> Selección de Departamento</small></h2>
</div>
<div class="row">
<div class="col-sm-4 col-sm-offset-4"><br />
<div class="well well-lg" align="center"><br />
<form name="textos" method="post" action="introducir.php"><select
	name="departamento" id="departamento" class="form-control"
	value="Todos ...">
	<option></option>
	<?php
	$profe = mysqli_query($db_con, " SELECT distinct departamento FROM departamentos, profesores where departamento not like 'admin' and departamento not like 'Administracion' and departamento not like 'Conserjeria' order by departamento asc");
	while($filaprofe = mysqli_fetch_array($profe))
	{
		$departamen = $filaprofe[0];
		$opcion1 = printf ("<OPTION>$departamen</OPTION>");
		echo "$opcion1";
	}
	?>
	<option>-------------------------------</option>
	<option>Plan de Autoprotección</option>
	<option>Plan de Biblioteca</option>
	<option>Plan Espacio de Paz</option>
	<option>Plan de Deporte en la Escuela</option>
	<option>Centro TIC</option>
</select> <br />
<button type="submit" name="enviar2" value="Enviar"
	class="btn btn-primary btn-block"><i class="fa fa-search "> </i> Enviar
</button>
</form>
</div>
</div>
</div>
</div>
	<?php
}
include("../../pie.php");
?>
</body>
</html>