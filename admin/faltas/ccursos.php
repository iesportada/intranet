<?php
if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];} elseif (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="";}
if (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];} elseif (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];} else{$grupo="";}

if ($_POST['submit2'])
{
	if ($_POST['dia1']!="Formato semanal") {
		include("horariofaltas_cursos.php");
	}
	else {
		include("horario_semanal.php");
	}
}
else
{

require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

include("../../menu.php");
?>
<br />
<div align=center>
<div class="page-header">
  <h2>Listas de Alumnos <small> Partes de faltas de Aula</small></h2>
</div>
</div>
<br>
<div class="container">
<div class="row">
<div class="col-md-4 col-md-offset-4">
<FORM action="ccursos.php" method="POST" name="listas2" class="well well-large">
<legend>Partes de Faltas de Aula</legend> <br /> 

<div class="form-group">
<label for="grupo" class="control-label"> Grupo </label>     
<SELECT  name="unidad" onChange="submit()" class="form-control" id="unidad">
            <option><?php echo $unidad;?></option>
            <?php unidad($db_con);?>
          </SELECT>
</label>
<label for="dia1" class="control-label">
          Día de la semana:</label>
          <select name="dia1" class="form-control">
            <option>Lunes</option>
            <option>Martes</option>
            <option>Miércoles</option>
            <option>Jueves</option>
            <option>Viernes</option>
            <option>Formato semanal</option>
          </select>
          <hr />
          <INPUT class="btn btn-primary" type="submit" name="submit2" value="Lista del Curso">
          </div>
</FORM>    
</div>
</div>
</div>
   

<?php  
}
?>

	<?php include("../../pie.php"); ?>
	
</body>
</html>
