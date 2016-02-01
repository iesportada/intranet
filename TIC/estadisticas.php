<?php
require('../bootstrap.php');


// RECOPILACION DE INFORMACION
$ar = array('ñ'=>'','º'=>'','ª','á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U',' '=>'');

$srv0 = mysqli_query($db_con,"select distinct elemento from reservas_elementos where id_tipo = '1' order by elemento");
$num_carrito = mysqli_num_rows($srv0);
				
// Tabla de Estadísticas TIC

mysqli_query($db_con,"drop table usuario"); 
$user = "CREATE TABLE IF NOT EXISTS `usuario` (
  `profesor` varchar(48) NOT NULL default '',";
while ($servic = mysqli_fetch_array($srv0)) {
	$rc_tc = $servic[0];
	foreach ($ar as $key => $usr_sin){	
		$usr = str_replace($key,$usr_sin,$rc_tc);
		}	
	$user.="`$usr` smallint(3) default NULL, ";
}
$user.="PRIMARY KEY  (`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci";

mysqli_query($db_con, $user);

$result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos ORDER BY nombre ASC");
while ($row = mysqli_fetch_array($result)) {

	$profesor = $row[0];
	
	$srv0 = mysqli_query($db_con,"select distinct elemento from reservas_elementos where id_tipo = '1' order by elemento");
	while ($elm1 = mysqli_fetch_array($srv0)) {
		$n_elm = $elm1[0];
		
		$result1 = mysqli_query($db_con, "SELECT eventdate FROM reservas WHERE servicio='$n_elm' and date(eventdate) > date('".$config['curso_inicio']."') AND (event1='$profesor' OR event2='$profesor' OR event3='$profesor' OR event4='$profesor' OR event5= '$profesor' OR event6='$profesor' OR event7='$profesor')") or die ("Error in query: $query. " . mysqli_error($db_con));

		$dias_profesor = mysqli_num_rows($result1);

		if ($dias_profesor > 0) {
				
			$result2 = mysqli_query($db_con, "SELECT profesor FROM usuario WHERE profesor='$profesor'");
				
			if (!mysqli_num_rows($result2)) {
				
				foreach ($ar as $key => $srv_sin){	
					$n_srv = str_replace($key,$srv_sin,$n_elm);
				}	
				mysqli_query($db_con, "INSERT INTO usuario SET profesor='$profesor', $n_srv='$dias_profesor'");
			}
			else {
				mysqli_query($db_con, "UPDATE usuario SET $n_srv='$dias_profesor' WHERE profesor='$profesor'");
			}
				
			mysqli_free_result($result2);
		}

		mysqli_free_result($result1);
	}
}
mysqli_free_result($result1);



include("../menu.php");
include("../TIC/menu.php");
?>

<div
	class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Centro TIC <small>Estadísticas de uso de Recursos TIC</small></h2>
</div>

<!-- SCAFFOLDING -->
<div class="row"><!-- COLUMNA IZQUIERDA -->
<div class="col-sm-4">

<h3>Información de Recursos TIC</h3>

<br>

<?php
$srv = mysqli_query($db_con,"select distinct elemento from reservas_elementos where id_tipo = '1' order by elemento");
while ($elm = mysqli_fetch_array($srv)):
$rc_tic = $elm[0];
?> 
<?php $result = mysqli_query($db_con, "SELECT eventdate FROM `reservas` WHERE DATE(eventdate) > date('".$config['curso_inicio']."') and servicio='$rc_tic'"); ?>
<?php $n_dias = mysqli_num_rows($result); ?> 
<?php $n_horas = 0; ?> <?php if ($n_dias): ?>
<?php while ($row = mysqli_fetch_array($result)): ?> 
<?php $result1 = mysqli_query($db_con, "SELECT * FROM reservas WHERE servicio='$rc_tic' and eventdate='".$row['eventdate']."'"); ?>
<?php $row1 = mysqli_fetch_array($result1); ?> 
<?php for ($j = 3; $j < 10; $j++): ?>
<?php if(!empty($row1[$j])): ?> 
<?php $n_horas = $n_horas+1; ?> 
<?php endif; ?>
<?php endfor; ?> <?php endwhile; ?> 
<?php endif; ?>

<table class="table table-bordered">
	<thead>
		<tr>
			<th colspan="2"><?php echo $rc_tic; ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th class="col-sm-9">Total días de uso</th>
			<td class="col-sm-3"><span class="text-info"><?php echo $n_dias; ?></span></td>
		</tr>
		<tr>
			<th>Total horas de uso</th>
			<td><span class="text-info"><?php echo $n_horas; ?></span></td>
		</tr>
	</tbody>
</table>

<?php endwhile; ?></div>
<!-- /.col-sm-4 --> <!-- COLUMNA DERECHA -->
<div class="col-sm-8">

<h3>Información de uso por profesor</h3>

<br>

<div class="table-responsive">
<table class="table table-bordered table-hover">
	<thead>
		<th>Profesor/a</th>
		<?php
		$srv = mysqli_query($db_con,"select distinct elemento from reservas_elementos where id_tipo = '1' order by elemento");
		while ($elm = mysqli_fetch_array($srv)):
		$rc_tic = $elm[0];
		$n_elm = $elm[0];	
		foreach ($ar as $key => $srv_sin){	
		$usr = str_replace($key,$srv_sin,$rc_tic);
		}	
		?>
		<th class="text-center"><?php echo $rc_tic; ?></th>
		<?php endwhile; ?>
	</thead>
	<tbody>
	<?php $result = mysqli_query($db_con, "SELECT * FROM usuario"); ?>
	<?php while ($row = mysqli_fetch_array($result)): ?>
		<tr>
			<td><?php echo $row['profesor']; ?></td>
			<?php for ($i = 1; $i <= $num_carrito; $i++): ?>
			<td class="text-center"><span class="text-info"><?php echo $row[$i]; ?></span></td>
			<?php endfor; ?>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>
</div>
<p class="text-muted"><small class="pull-right">Total de días que el
profesor/a ha reservado un carro TIC.</small></p>

</div>
<!-- /.col-sm-8 --></div>
<!-- /.row -->

<div class="row">

<div class="col-sm-12">

<div class="hidden-print"><a href="#" class="btn btn-primary"
	onclick="javascript:print();">Imprimir</a></div>

</div>

</div>

</div>
<!-- /.container -->
		<?php include("../pie.php"); ?>

</body>
</html>
