<?php
require('../../bootstrap.php');
include '../../menu.php';
?>
	<style type="text/css">
	@media print {
		.container {
			width: 100%;
		}
		
		.nopad-right {
			padding-right: 0;
		}
		
		.col-print {
			width: 10.66666667%;
			height: 145px !important;
		}
		
		.stack-print {
			height: 60px !important;
		}
		
		.fa-stack {
			font-size: 1.5em;
		}
		
		.fa-4x {
			font-size: 0.5em;
		}
		
		.img-print {
			max-height: 25%;
		}
		
		h5 {
			font-size: 50%;
		}
		
		h6 {
			font-size: 60%;
		}
	}
	</style>
	
	
	<div class="container nopad-right">
	
		<div class="page-header">
			<h2>Claustro de profesores <small>Curso <?php echo $config['curso_actual']; ?></small></h2>
		</div>
		
		<div class="row">
		
			<div class="col-sm-12 nopad-right">
				
				<div id="fotografias">
					<?php $result = mysqli_query($db_con, "SELECT DISTINCT departamento, nombre, idea FROM departamentos WHERE departamento NOT LIKE 'Administracion' AND departamento NOT LIKE 'admin' AND departamento NOT LIKE 'Conserjeria' ORDER BY departamento ASC, nombre ASC"); ?>
					<?php while($row = mysqli_fetch_assoc($result)): ?>
					
					<div class="col-xs-4 col-md-2 col-print" style="height: 275px;">
						<?php $foto = "../../xml/fotos_profes/".$row['idea'].".jpg"; ?>
						<?php if(file_exists($foto)): ?>
						<img class="img-responsive img-thumbnail img-print" src="<?php echo $foto; ?>" style="max-height: 50%; margin: 0 auto !important; display: inherit !important;">
						<?php else: ?>
						<div class="text-center text-muted stack-print" style="height: 138px;">
							<span class="fa-stack fa-4x">
							  <i class="fa fa-circle fa-stack-2x"></i>
							  <i class="fa fa-user fa-stack-1x fa-inverse"></i>
							</span>
						</div>
						<?php endif; ?>
						<h5 class="text-center"><?php echo $row['nombre']; ?></h5>
						<h6 class="text-center text-info"><?php echo $row['departamento']; ?></h6>
					</div>
					<?php endwhile; ?>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="hidden-print">
					<a class="btn btn-primary" href="javascript:print();">Imprimir</a>
					<a class="btn btn-default" href="../../index.php">Volver</a>
				</div>
				
			</div><!-- /.col-sm-12 -->
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->


<?php include('../../pie.php'); ?>

</body>
</html>