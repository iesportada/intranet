<?php
require('../../bootstrap.php');


$profesor = $_SESSION['profi'];

if (isset($_POST['curso'])) {$curso = $_POST['curso'];} elseif (isset($_GET['curso'])) {$curso = $_GET['curso'];} else{$curso="";}
if (isset($_POST['claveal'])) {$claveal = $_POST['claveal'];} elseif (isset($_GET['claveal'])) {$claveal = $_GET['claveal'];} else{$claveal="";}

include("../../menu.php");
?>
<?php
if (strlen($_GET['claveal'])>1) {
	// Asignaturas
mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `asig_tmp` (
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL,
  `codigo` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
mysqli_query($db_con,"TRUNCATE TABLE asig_tmp");

$comb = mysqli_query($db_con,"select combasi from alma where claveal = '".$_GET['claveal']."'");
$combasi = mysqli_fetch_array($comb);
$tr_combasi = explode(":",$combasi[0]);
foreach ($tr_combasi as $codigo){
	 mysqli_query($db_con,"insert into asig_tmp(claveal, codigo) VALUES ('".$_GET['claveal']."','$codigo')");
}
$extra_al = " and (c_asig in (select codigo from asig_tmp) or c_asig = '2')";
$extra_asig = " and materia in (select nombre from asignaturas where codigo in (select codigo from asig_tmp) and abrev not like '%\_%')";
}
else{
$extra_asig="";	
$extra_al="";
}
?>

<div class="container">

	<div class="page-header">
		<h2 style="display: inline;"><?php echo $curso; ?> <small>Consulta de horario y profesores</small></h2>
		
		<form class="pull-right col-sm-2" method="post" action="horarios.php?">
			<?php $result = mysqli_query($db_con, "SELECT nomunidad from unidades ORDER BY idunidad"); ?>
			<select class="form-control" id="curso" name="curso" onChange="submit()">
				<?php while($row = mysqli_fetch_array($result)): ?>
				<option value="<?php echo $row['nomunidad']; ?>" <?php echo ($row['nomunidad'] == $curso) ? 'selected' : ''; ?>><?php echo $row['nomunidad']; ?></option>
				<?php endwhile; ?>
			</select>
			<input type="hidden" name="claveal" value="">
		</form>
	</div>

	<!-- SCAFFOLDING -->
	<div class="row">
	
		<div class="col-sm-12">
		
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Lunes</th>
							<th>Martes</th>
							<th>Miércoles</th>
							<th>Jueves</th>
							<th>Viernes</th>
						</tr>
					</thead>
					<tbody>
					<?php $horas = array(1 => "1ª", 2 => "2ª", 3 => "3ª", 4 => "4ª", 5 => "5ª", 6 => "6ª" ); ?>
					<?php foreach($horas as $hora => $desc): ?>
						<tr>
							<th><?php echo $desc; ?></th>
							<?php for($i = 1; $i < 6; $i++): ?>
							<td width="20%" style="border-right: 2px solid #ddd;"><?php $result = mysqli_query($db_con, "SELECT DISTINCT asig, a_aula, n_aula FROM horw WHERE a_grupo='$curso' AND dia='$i' AND hora='$hora' $extra_al"); ?>
							<?php while($row = mysqli_fetch_array($result)): ?> <?php echo '<div style="display: block; font-size: 0.9em; margin-bottom: 5px;">'; ?>
							<?php echo ($row['a_aula']) ? '<abbr class="text-danger pull-right" data-bs="tooltip" title="'.$row['n_aula'].'">'.$row['a_aula'].'</abbr>' : '<abbr class="text-danger pull-right" data-bs="tooltip" title="Sin asignar o sin aula">Sin aula</abbr>'; ?>
							<?php echo $row['asig']; ?> <?php echo '</div>'; ?> <?php endwhile; ?>
							</td>
							<?php endfor; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
	
		</div><!-- /.col-sm-12 -->
	
	</div><!-- /.row -->

	<div class="row">

		<div class="col-sm-12">

			<h3>Equipo educativo de la unidad</h3>

			<?php $result = mysqli_query($db_con, "SELECT DISTINCT MATERIA, PROFESOR FROM profesores WHERE grupo='$curso' $extra_asig"); ?>
			<?php if(mysqli_num_rows($result)): ?>
			<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="col-sm-4">Asignatura</th>
						<th class="col-sm-8">Profesor/a</th>
					</tr>
				</thead>
				<tbody>
				<?php while($row = mysqli_fetch_array($result)): ?>
					<tr>
						<td><?php echo $row[0]; ?></td>
						<td><?php echo nomprofesor($row[1]); ?></td>
					</tr>
					<?php endwhile; ?>
					<?php mysqli_free_result($result); ?>
				</tbody>
			</table>
			</div>
			<?php endif; ?>
			
		</div><!-- /.col-sm-12 -->
		
	</div><!-- /.row -->

	<div class="hidden-print">
		<a class="btn btn-primary" href="#" onclick="javascript:print();">Imprimir</a>
		<a class="btn btn-default" href="chorarios.php">Volver</a>
	</div>

</div><!-- /.container -->
<?php mysqli_query($db_con,"DROP TABLE asig_tmp"); ?>
<?php include("../../pie.php"); ?>

</body>
</html>
