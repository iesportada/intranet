<?php
require('../../bootstrap.php');

function tipo_falta($falta) {
      
  switch ($falta) {
    case 'J' : $tipo = 'Justificada'; break;
    case 'F' : $tipo = 'Injustificada'; break;
    case 'I' : $tipo = 'Injustificada'; break;
    case 'R' : $tipo = 'Retraso'; break;
  }

  return $tipo;
}


include("../../menu.php");
include("../../faltas/menu.php");

if (isset($_POST['nombre'])) {
	$nombre = $_POST['nombre'];
} 
elseif (isset($_GET['nombre'])) {
	$nombre = $_GET['nombre'];
} 
else
{
$nombre="";
}
if (isset($_POST['claveal'])) {
	$claveal = $_POST['claveal'];
} 
elseif (isset($_GET['claveal'])) {
	$claveal = $_GET['claveal'];
} 
else
{
$claveal="";
}
if (isset($_POST['fechasp1'])) {
	$fechasp1 = $_POST['fechasp1'];
}
elseif (isset($_GET['fechasp1'])) {
	$fechasp1 = $_GET['fechasp1'];
} 
else
{
$fechasp1="";
}
if (isset($_POST['fechasp2'])) {
	$fechasp2 = $_POST['fechasp2'];
}
elseif (isset($_GET['fechasp2'])) {
	$fechasp2 = $_GET['fechasp2'];
} 
else
{
$fechasp2="";
}
if (isset($_POST['fechasp3'])) {
	$fechasp3 = $_POST['fechasp3'];
}
elseif (isset($_GET['fechasp3'])) {
	$fechasp3 = $_GET['fechasp3'];
} 
else
{
$fechasp3="";
}
if (isset($_POST['fecha3'])) {
	$fecha3 = $_POST['fecha3'];
}
elseif (isset($_GET['fecha3'])) {
	$fecha3 = $_GET['fecha3'];
} 
else
{
$fecha3="";
}
if (isset($_POST['fecha4'])) {
	$fecha4 = $_POST['fecha4'];
}
elseif (isset($_GET['fecha4'])) {
	$fecha4 = $_GET['fecha4'];
} 
else
{
$fecha4="";
}
if (isset($_POST['submit2'])) {
	$submit2 = $_POST['submit2'];
}
elseif (isset($_GET['submit2'])) {
	$submit2 = $_GET['submit2'];
} 
else
{
$submit2="";
}

$claveal0 = explode(" --> ",$nombre);
if(empty($claveal)){$claveal = $claveal0[1];} 
if($fechasp1 or $fechasp2){}
else{  
  $fechasp0=explode("-",$fecha4);
  $fechasp1=$fechasp0[2]."-".$fechasp0[1]."-".$fechasp0[0];
  $fechasp2=explode("-",$fecha3);
  $fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
}

$result = mysqli_query($db_con, "SELECT FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad FROM FALUMNOS WHERE CLAVEAL = '$claveal'");
$row = mysqli_fetch_array($result);
$foto = '../../xml/fotos/'.$row['claveal'].'.jpg';
?>
  
  <div class="container">

    <div class="page-header">
      <h2>Faltas de Asistencia <small> Informe de faltas del alumno</small></h2>
    </div>
    
    <br>

    <div class="row">
      
      <div class="col-sm-12">
        
        <div class="media">
          <div class="media-left">
          	  <?php if (file_exists($foto)): ?>
              <img class="media-object img-thumbnail" src="<?php echo $foto; ?>" alt="<?php echo $row['nombre'].' '.$row['apellidos']; ?>" style="width: 80px">
              <?php else: ?>
              <span class="fa-stack fa-3x text-muted">
                <i class="fa fa-circle fa-stack-2x"></i>
                <i class="fa fa-user fa-stack-1x fa-inverse"></i>
              </span>
              <?php endif; ?>
          </div>
          <div class="media-body">
            <h3 class="media-heading" style="margin-top: 4px;"><?php echo $row['nombre'].' '.$row['apellidos']; ?></h3>
            <h4 class="text-info">Unidad: <?php echo $row['unidad']; ?></h4>
          </div>
        </div>

        <br><br>
        <?php if($fechasp1 != "" && $fechasp3 != ""): ?>
        <div class="alert alert-info hidden-print">
            <span class="fa fa-filter fa-fw"></span> Mostrando resultados entre los días <strong><?php echo $fechasp1; ?></strong> y <strong><?php echo $fechasp3; ?></strong>.
        </div>
        <?php endif; ?>

        <h3>Resumen de faltas de asistencia</h3>

        <div class="row">
          
          <div class="col-sm-3">
            
            <?php if($fechasp1 != "" && $fechasp3 != ""): ?>
            <?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal AND FALTAS.falta = 'F' AND FALUMNOS.claveal = '$claveal' AND FALTAS.fecha BETWEEN '$fechasp1' AND '$fechasp3' GROUP BY FALUMNOS.apellidos"); ?>
            <?php else: ?>
            <?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal AND FALTAS.falta = 'F' AND FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos"); ?>
            <?php endif; ?>

            <?php $total = 0; ?>
            <?php if (mysqli_num_rows($result)): ?>
            <?php $row = mysqli_fetch_array($result); ?>
            <?php $total = $row['total']; ?>
            <?php mysqli_free_result($result); ?>
            <?php endif; ?>
            
            <h3 class="text-info text-center">
              <?php echo $total; ?><br>
              <small class="text-uppercase">faltas injustificadas</small>
            </h3>
            
          </div>
          
          <div class="col-sm-3">
            <?php if($fechasp1 != "" && $fechasp3 != ""): ?>
            <?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal AND FALTAS.falta = 'J' AND FALUMNOS.claveal = '$claveal' AND FALTAS.fecha BETWEEN '$fechasp1' AND '$fechasp3' GROUP BY FALUMNOS.apellidos"); ?>
            <?php else: ?>
            <?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal AND FALTAS.falta = 'J' AND  FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos"); ?>
            <?php endif; ?>

            <?php $total = 0; ?>
            <?php if (mysqli_num_rows($result)): ?>
            <?php $row = mysqli_fetch_array($result); ?>
            <?php $total = $row['total']; ?>
            <?php mysqli_free_result($result); ?>
            <?php endif; ?>
            
            <h3 class="text-info text-center">
              <?php echo $total; ?><br>
              <small class="text-uppercase">faltas justificadas</small>
            </h3>
            
          </div>

          <div class="col-sm-3">
            <?php if($fechasp1 != "" && $fechasp3 != ""): ?>
            <?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal AND FALTAS.falta = 'R' AND FALUMNOS.claveal = '$claveal' AND FALTAS.fecha BETWEEN '$fechasp1' AND '$fechasp3' GROUP BY FALUMNOS.apellidos"); ?>
            <?php else: ?>
            <?php $result = mysqli_query($db_con, "SELECT DISTINCT FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.fecha, COUNT(*) AS total FROM FALTAS, FALUMNOS WHERE FALUMNOS.claveal = FALTAS.claveal AND FALTAS.falta = 'R' AND FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos"); ?>
            <?php endif; ?>

            <?php $total = 0; ?>
            <?php if (mysqli_num_rows($result)): ?>
            <?php $row = mysqli_fetch_array($result); ?>
            <?php $total = $row['total']; ?>
            <?php mysqli_free_result($result); ?>
            <?php endif; ?>
            
            <h3 class="text-info text-center">
              <?php echo $total; ?><br>
              <small class="text-uppercase">retrasos injustificados</small>
            </h3>
            
          </div>
          
          <div class="col-sm-3">
            <?php if($fechasp1 != "" && $fechasp3 != ""): ?>
            <?php $result = mysqli_query($db_con, "SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.falta, FALTAS.fecha FROM FALUMNOS, FALTAS where FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.falta = 'F' and  FALUMNOS.claveal = $claveal AND FALTAS.fecha BETWEEN '$fechasp1' AND '$fechasp3' group by FALUMNOS.APELLIDOS, FALTAS.fecha"); ?>
            <?php else: ?>
            <?php $result = mysqli_query($db_con, "SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.unidad, FALTAS.falta, FALTAS.fecha FROM FALUMNOS, FALTAS where FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.falta = 'F' and  FALUMNOS.claveal = $claveal group by FALUMNOS.APELLIDOS, FALTAS.fecha"); ?>
            <?php endif; ?>
            <?php $total = 0; ?>
            <?php $total = mysqli_num_rows($result); ?>
            
            <h3 class="text-info text-center">
              <?php echo $total; ?><br>
              <small class="text-uppercase">días completos injustificados</small>
            </h3>
            
          </div>

        </div>

        <br>

        <h3>Informe detallado de faltas de asistencia</h3>
        <br>
        
        <?php if($fechasp1 != "" && $fechasp3 != ""): ?>
        <?php $result = mysqli_query($db_con, "SELECT DISTINCT fecha FROM FALTAS WHERE claveal = '$claveal' AND claveal = '$claveal' AND fecha BETWEEN '$fechasp1' AND '$fechasp3' ORDER BY fecha DESC"); ?>
        <?php else: ?>
        <?php $result = mysqli_query($db_con, "SELECT DISTINCT fecha FROM FALTAS WHERE claveal = '$claveal' ORDER BY fecha DESC"); ?>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result)): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-condensed table-striped table-hover">
            <thead>
              <tr>
                <th>Fecha</th>
                <?php for ($i = 1; $i < 7; $i++): ?>
                <th><?php echo $i; ?>ª hora</th>
                <?php endfor; ?>
              </tr>
            </thead>
            
  
            
            		<tbody>
			<?php while ($row = mysqli_fetch_array($result)): ?>
			<tr>
				<th><abbr data-bs="tooltip" title="<?php echo strftime('%A', strtotime($row['fecha'])); ?>"><?php echo $row['fecha']; ?></abbr></th>
				<?php for ($i = 1; $i < 7; $i++): ?>
				<?php $result_falta = mysqli_query($db_con, "SELECT DISTINCT falta, codasi FROM FALTAS WHERE claveal = '$claveal' AND fecha = '".$row['fecha']."' AND hora = '$i'"); ?>
				<?php $row_falta = mysqli_fetch_array($result_falta); ?>
				<?php $result_asig = mysqli_query($db_con, "SELECT DISTINCT asignaturas.abrev, asignaturas.nombre FROM asignaturas WHERE asignaturas.codigo = '".$row_falta['codasi']."' and abrev not like '%\_%'"); ?>
				<?php $row_asig = mysqli_fetch_array($result_asig); ?>
				
				<td>
					<abbr data-bs="tooltip" title="<?php echo $row_asig['nombre']; ?>">
						<span class="label label-default"><?php echo $row_asig['abrev']; ?></span>
					</abbr>
					
					<abbr data-bs="tooltip" title="<?php echo tipo_falta($row_falta['falta']); ?>">
					<?php echo ($row_falta['falta'] == "I" || $row_falta['falta'] == "F") ? '<span class="label label-danger">'.$row_falta['falta'].'</label>' : ''; ?>
					<?php echo ($row_falta['falta'] == "R") ? '<span class="label label-warning">'.$row_falta['falta'].'</label>' : ''; ?>
					<?php echo ($row_falta['falta'] == "J") ? '<span class="label label-success">'.$row_falta['falta'].'</label>' : ''; ?>
					</abbr>
				</td>
				<?php endfor; ?>
			</tr>
			<?php endwhile; ?>
		</tbody>
		
          </table>
        </div>
        <?php endif; ?>

        <div class="hidden-print">
          <a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
          <a class="btn btn-default" href="javascript:history.go(-1);">Volver</a>
        </div>

      </div><!-- /.col-sm-12 -->

    </div><!-- /.row -->


  </div>

  <?php include("../../pie.php");?>

</body>
</html>