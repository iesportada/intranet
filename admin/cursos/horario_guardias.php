<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

if (isset($_POST['n_dia'])) {$n_dia = $_POST['n_dia'];} elseif (isset($_GET['n_dia'])) {$n_dia = $_GET['n_dia'];} else{$n_dia="";}
if ($n_dia == 'Lunes') {	$dia = '1';}
if ($n_dia == 'Martes') { $dia = '2';}
if ($n_dia == 'Miércoles') {	$dia = '3';}
if ($n_dia == 'Jueves') {	$dia = '4';}
if ($n_dia == 'Viernes') {	$dia = '5';}

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2 style="display: inline;"><?php echo $n_dia; ?> <small>Consulta de Guardias</small></h2>
		
		<?php $dias = array('Lunes','Martes','Miércoles','Jueves','Viernes'); ?>
		<form class="pull-right col-sm-2" method="post" action="">
			<select class="form-control" id="n_dia" name="n_dia" onChange="submit()">
				<?php for($i = 0; $i < count($dias); $i++): ?>	
				<option value="<?php echo $dias[$i]; ?>" <?php echo ($dias[$i] == $n_dia) ? 'selected' : ''; ?>><?php echo $dias[$i]; ?></option>
				<?php endfor; ?>
			</select>
		</form>
	</div>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<div class="col-sm-12">
			
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
						<?
						$hr = mysqli_query($db_con,"select hora_inicio, hora_fin, hora from tramos where hora < 7 or hora like 'R' order by tramo");
						while ($hor = mysqli_fetch_array($hr)) {
							if ($hor[2]=="R") {
								echo "<th>Recreo</th>";
							}
							else{
								echo "<th>$hor[0] - $hor[1]</th>";
							}
						}
						?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php 
							$horas = array("1","2","3","R","4","5","6");
							foreach($horas as $hora): ?>
							<td>
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT prof, a_aula, n_aula, c_asig, a_asig FROM horw WHERE (c_asig='25' or c_asig='26' or c_asig='353') and dia='$dia' and hora='$hora' ORDER BY a_asig, a_aula ASC"); ?>
							<?php while ($row = mysqli_fetch_array($result)): ?>
							<?php if ($row['c_asig'] == "353"){ ?>
								<p><a href="profes.php?profeso=<?php echo $row['prof']; ?>" class="text-success"><small><?php echo $row['prof']; ?></small></a><span class="text-warning pull-right" data-bs="tooltip" title="<?php echo $row['n_aula'];?>"><?php if($row['a_aula']==""){ echo "GUREC";} else{ echo $row['a_aula'];} ?></span></p><hr>
							<?php } 
							elseif($row['a_asig']=="GUCON") { ?>
								<p><a href="profes.php?profeso=<?php echo $row['prof']; ?>" class="text-warning"><small><?php echo $row['prof']; ?></small></a><span class="text-success pull-right" data-bs="tooltip" title="<?php echo $row['n_aula'];?>"><?php if($row['a_aula']==""){ echo "GUCON";} else{ echo $row['a_aula'];} ?></span></p><hr>
							<?php }
							elseif($row['c_asig']=="26") { ?>
								<p><a href="profes.php?profeso=<?php echo $row['prof']; ?>" class="text-default"><small><?php echo $row['prof']; ?></small></a><span class="text-info pull-right" data-bs="tooltip" title="<?php echo $row['n_aula'];?>"><?php if($row['a_aula']==""){ echo "GUBIB";} else{ echo $row['a_aula'];} ?></span></p><hr>
							<?php } 
							else { ?>
							<p><a href="profes.php?profeso=<?php echo $row['prof']; ?>"><small><?php echo $row['prof']; ?></small></a><span class="text-danger pull-right" data-bs="tooltip" title="<?php echo $row['n_aula'];?>"><?php if($row['a_aula']==""){ echo "GU";} else{ echo $row['a_aula'];} ?></span></p><hr>
							<?php } ?>
							<?php endwhile; ?>
							</td>
							<?php endforeach; ?>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="hidden-print">
				<a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
				<a class="btn btn-default" href="chorarios.php">Volver</a>
				<a class="btn btn-info" href="hor_guardias.php">Estadísticas</a>
			</div>
		
		</div><!-- /.col-sm-12 -->
		
	</div><!-- /.row -->
		
</div>

	<?php include("../../pie.php"); ?>

</body>
</html>
