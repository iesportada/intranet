<?php
require('../../bootstrap.php');


$pr = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];


$tut = mysqli_query($db_con, "select unidad from FTUTORES where tutor = '$pr'");
if (mysqli_num_rows($tut) > 0) {
	$tuto = mysqli_fetch_array($tut);
	$unidad = $tuto[0];
}

include("../../menu.php");
include("menu.php");
?>
  
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Informes de Tutoría <small> Buscar Informes</small></h2>
</div>
<br>

<div class="col-md-4 col-md-offset-4">
    
<div class="well well-large" align="left">
<form action="buscar.php" method="post">  
  
    <div class="form-group">
    <label>Apellidos</label>
    <input name="apellidos" type="text" class="form-control" alt="Alumno" />
  </div>
    
   <div class="form-group">
   <label> Nombre</label>
    <input name="nombre" type="text" class="form-control" alt="nombre" />
  </div>
  
  <div class="form-group">
   <label> Grupo</label>
<SELECT name="unidad" class="form-control">
      <OPTION><?php echo $unidad;?></OPTION>
      <?php unidad($db_con);?>
    </SELECT>
        </div>   
  
    <br />
      <input type="submit" name="submit1" value="Buscar Informes" class="btn btn-primary btn-block">
    <br />
    <p class="help-block"><strong><u>Nota</u></strong>: No es necesario escribir el Nombre o Apellidos completos del Alumno. Es preferible introducir pocos datos aunque el resultado sea m&aacute;s amplio. As&iacute;, si escribo "gar" el resultado incluir&aacute; alumnos con Apellidos como "<span class="Estilo1">Gar</span>cía", "Esti<span class="Estilo1">gar</span>ribia", "Mel<span class="Estilo1">gar</span>", etc.</p>
  
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
