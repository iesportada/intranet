<?php
require('../../bootstrap.php');


$curso = substr($config['curso_actual'],0,4);

include("../../menu.php");
?>
	
	<div class="container">
	
		<div class="page-header">
			<h2>Calendario escolar <small>Curso <?php echo $curso; ?> / <?php echo $curso+1; ?></small></h2>
		</div>
		
		<?php
		require('../../lib/calendar.class.php');
		$cal = new calendar();
		
		$cal->enableNonMonthDays();
		$cal->enableYear();
		
		$cal->addEvent('Inicio curso Ed.Inf., Prim. E.E.', $curso, 9, 10, '#');
		$cal->addEvent('Inicio curso E.S.O. Bach. F.P.', $curso, 9, 15, '#');
		$cal->addEvent('Fin días lectivos', $curso+1, 6, 23, '#');
		
		// DIAS FESTIVOS
		$result = mysqli_query($db_con, "SELECT fecha, nombre FROM festivos");
		
		if (mysqli_num_rows($result)) {
		
			while ($row = mysqli_fetch_array($result)) {
				$fecha = explode('-', $row['fecha']);
				$fecha_anio = $fecha[0];
				substr($fecha[1],0,1)==0 ? $fecha_mes = substr($fecha[1],1,2) : $fecha_mes = $fecha[1];
				substr($fecha[2],0,1)==0 ? $fecha_dia = substr($fecha[2],1,2) : $fecha_dia = $fecha[2];
				
				$cal->addEvent($row['nombre'], $fecha_anio, $fecha_mes, $fecha_dia, '#');
			}
			
		}
		?>
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(9, $curso); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(10, $curso); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(11, $curso); ?>
		  </div>
		  
		</div><!-- ./row -->
		
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(12, $curso); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(1, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(2, $curso+1); ?>
		  </div>
		  
		</div><!-- ./row -->
		
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(3, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(4, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(5, $curso+1); ?>
		  </div>
		  
		</div><!-- ./row -->
		
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(6, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(7, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(8, $curso+1); ?>
		  </div>
		  
		</div><!-- ./row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>
  
</body>
</html>
