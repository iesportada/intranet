<?php
require('../bootstrap.php');


$GLOBALS['db_con'] = $db_con;


$result = mysqli_query($db_con, "SELECT DISTINCT unidad FROM alma ORDER BY unidad ASC LIMIT 1");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
}
elseif(isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
}
else {
	$unidad = $row['unidad'];
}

// CALENDARIO
$dia_actual = date('d');

$dia  = isset($_GET['dia'])  ? $_GET['dia']  : date('d');
$mes  = isset($_GET['mes'])  ? $_GET['mes']  : date('n');
$anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

$semana = 1;

for ($i = 1; $i <= date('t', strtotime($anio.'-'.$mes)); $i++) {
	
	$dia_semana = date('N', strtotime($anio.'-'.$mes.'-'.$i));
	
	$calendario[$semana][$dia_semana] = $i;
	if ($dia_semana == 7) $semana++;
	
}


// NAVEGACION
$mes_ant = $mes - 1;
$anio_ant = $anio;

if ($mes == 1) {
	$mes_ant = 12;
	$anio_ant = $anio - 1;
}


$mes_sig = $mes + 1;
$anio_sig = $anio;

if ($mes == 12) {
	$mes_sig = 1;
	$anio_sig = $anio + 1;
}

// HTML CALENDARIO MENSUAL
function vista_mes ($calendario, $dia, $mes, $anio, $unidad) {
	
	// Corrección en mes
	($mes < 10) ? $mes = '0'.$mes : $mes = $mes;
	
	echo '<div class"table-responsive">';
	echo '<table id="calendar" class="table table-bordered">';
	echo '	<thead>';
	echo '		<tr>';
	echo '			<th class="text-center">Lunes</th>';
	echo '			<th class="text-center">Martes</th>';
	echo '			<th class="text-center">Miércoles</th>';
	echo '			<th class="text-center">Jueves</th>';
	echo '			<th class="text-center">Viernes</th>';
	echo '			<th class="text-center">Sábado</th>';
	echo '			<th class="text-center">Domingo</th>';
	echo '		</tr>';
	echo '	</thead>';
	echo '	<tbody>';
	
	foreach ($calendario as $dias) {
		echo '		<tr>';
	
		for ($i = 1; $i <= 7; $i++) {
			
			if ($i > 5) {
				if (isset($dias[$i]) && ($mes == date('m')) && ($dias[$i] == date('d'))) {
					echo '			<td class="text-muted today" width="14.28%">';
				}
				else {
					echo '			<td class="text-muted" width="14.28%">';
				}
			}
			else {
				if (isset($dias[$i]) && ($mes == date('m')) && ($dias[$i] == date('d'))) {
					echo '			<td class="today" width="14.28%">';
				}
				else {
					echo '			<td width="14.28%">';
				}
			}
			
			if (isset($dias[$i])) {

				echo '				<p class="lead text-right">'.$dias[$i].'</p>';
				
				// Corrección en día
				($dias[$i] < 10) ? $dia0 = '0'.$dias[$i] : $dia0 = $dias[$i];
				
				
				// Consultamos los calendarios privados del equipo educativo de la unidad
				$result_equipo_educativo = mysqli_query($GLOBALS['db_con'], "SELECT DISTINCT prof, (SELECT idea FROM departamentos WHERE departamentos.nombre = h.prof) AS idea FROM horw AS h WHERE a_grupo = '$unidad'");
				while ($row_equipoeducativo = mysqli_fetch_assoc($result_equipo_educativo)) {
					
					$result_calendarios = mysqli_query($GLOBALS['db_con'], "SELECT id, color FROM calendario_categorias WHERE profesor = '".$row_equipoeducativo['idea']."' AND espublico=0");
					while ($calendario = mysqli_fetch_assoc($result_calendarios)) {
					
						$result_eventos = mysqli_query($GLOBALS['db_con'], "SELECT id, nombre, descripcion, fechaini, horaini, fechafin, horafin, asignaturas FROM calendario WHERE categoria='".$calendario['id']."' AND YEAR(fechaini)='$anio' AND MONTH(fechaini)='$mes' AND unidades LIKE '%$unidad%' ORDER BY horaini ASC, horafin ASC");
	
						while ($eventos = mysqli_fetch_assoc($result_eventos)) {
						
							$exp_asignaturas = explode('; ', $eventos['asignaturas']);
							$nomasignatura = trim($exp_asignaturas[0], ';');
							
							$horaini = substr($eventos['horaini'], 0, -3);
							$horafin = substr($eventos['horafin'], 0, -3);
							
							if ($anio.'-'.$mes.'-'.$dia0 >= $eventos['fechaini'] && $anio.'-'.$mes.'-'.$dia0 <= $eventos['fechafin']) {
								echo '<div class="label" style="background-color: '.$calendario['color'].';" data-bs="tooltip" title="'.$eventos['descripcion'].'"><p><strong>'.$horaini.' - '.$horafin.': '.$nomasignatura.'</strong></p>'.$eventos['nombre'].'</div>';
							}
							
							unset($nomasignatura);
							unset($horaini);
							unset($horafin);
						}
						mysqli_free_result($result_eventos);
					}
					mysqli_free_result($result_calendarios);
				}
				mysqli_free_result($result_equipo_educativo);
				
				
				// Consultamos los calendarios públicos
				$result_calendarios = mysqli_query($GLOBALS['db_con'], "SELECT id, color FROM calendario_categorias WHERE espublico=1");
				while ($calendario = mysqli_fetch_assoc($result_calendarios)) {
					
					$result_eventos = mysqli_query($GLOBALS['db_con'], "SELECT id, nombre, descripcion, fechaini, horaini, fechafin, horafin FROM calendario WHERE categoria='".$calendario['id']."' AND YEAR(fechaini)='$anio' AND MONTH(fechaini)='$mes' AND unidades LIKE '%$unidad%' ORDER BY horaini ASC, horafin ASC");
					
					while ($eventos = mysqli_fetch_assoc($result_eventos)) {
						
						$horaini = substr($eventos['horaini'], 0, -3);
						$horafin = substr($eventos['horafin'], 0, -3);
						
						if ($anio.'-'.$mes.'-'.$dia0 >= $eventos['fechaini'] && $anio.'-'.$mes.'-'.$dia0 <= $eventos['fechafin']) {
							echo '<div class="label" style="background-color: '.$calendario['color'].';" data-bs="tooltip" title="'.$eventos['descripcion'].'"><p><strong>'.$horaini.' - '.$horafin.'</strong></p>'.$eventos['nombre'].'</div>';
						}
						
						unset($horaini);
						unset($horafin);
					}
					mysqli_free_result($result_eventos);
				}
				mysqli_free_result($result_calendarios);
				
				// FESTIVOS
				$result = mysqli_query($GLOBALS['db_con'], "SELECT fecha, nombre FROM festivos");
				while ($festivo = mysqli_fetch_assoc($result)) {
					
					if ($festivo['fecha'] == $anio.'-'.$mes.'-'.$dia0) {
						echo '<div class="label label-danger hidden_calendario_festivo visible" data-bs="tooltip" title="'.$festivo['nombre'].'">'.$festivo['nombre'].'</div>';
					}
				}
				mysqli_free_result($result);
				unset($festivo);
				
				
			}
			else {
				echo '&nbsp;';
			}
			
			echo '			</td>';
		}
		echo '		</tr>';
	}
	
	echo '	</tbody>';
	echo '</table>';
	echo '</div>';

}

include("../menu.php");

if (isset($_GET['menu_cuaderno']) && $_GET['menu_cuaderno'] == 1) {
	include('../cuaderno/menu.php');
}
?>

	<div class="container">
		
		<style type="text/css">
		table>tbody>tr>td {
			height: 103px !important;
		}
		.label {
			display: block;
			white-space: normal;
			text-align: left;
			margin-top: 5px;
			text-decoration: none !important;
			font-size: 0.9em;
			font-weight: 400;
		}
		
		p.lead {
			margin-bottom: 0;
		}
		
		@media print {
			html, body {
				width: 100%;
			}
			
			.container, .col-md-12 {
				width: 100%;
			}
			
		}
		</style>
		
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Calendario <small><?php echo strftime('%B, %Y', strtotime($anio.'-'.$mes)); ?></small></h2>
			<h3 class="visible-print"><?php echo $unidad; ?></h3>
		</div>
		
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-md-12">
				
				<!-- BUTTONS -->
				<div class="hidden-print">
					
					<form class="form-horizontal pull-left col-xs-4 col-md-3" method="post" action="index_unidades.php?mes=<?php echo $mes; ?>&anio=<?php echo $anio; ?>">
						<div class="form-group">
							<div class="col-xs-12">
								<select class="form-control" id="unidad" name="unidad" onchange="submit()">
									<?php $result = mysqli_query($db_con, "SELECT DISTINCT unidad FROM alma ORDER BY unidad ASC"); ?>
									<?php while($row = mysqli_fetch_assoc($result)): ?>
									<option value="<?php echo $row['unidad']; ?>" <?php echo (isset($unidad) && $unidad == $row['unidad']) ? 'selected' : ''; ?>><?php echo $row['unidad']; ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>
					</form>
					
					<div class="pull-right">
						<a href="#" onclick="javascrip:print()" class="btn btn-default"><span class="fa fa-print fa-fw"></span></a>
						
						<div class="btn-group">
						  <a href="?mes=<?php echo $mes_ant; ?>&anio=<?php echo $anio_ant; ?>&unidad=<?php echo $unidad; ?><?php if (isset($_GET['menu_cuaderno']) && $_GET['menu_cuaderno'] == 1) echo '&menu_cuaderno=1'; ?>" class="btn btn-default">&laquo;</a>
						  <a href="?mes=<?php echo date('n'); ?>&anio=<?php echo date('Y'); ?>&unidad=<?php echo $unidad; ?><?php if (isset($_GET['menu_cuaderno']) && $_GET['menu_cuaderno'] == 1) echo '&menu_cuaderno=1'; ?>" class="btn btn-default">Hoy</a>
						  <a href="?mes=<?php echo $mes_sig; ?>&anio=<?php echo $anio_sig; ?>&unidad=<?php echo $unidad; ?><?php if (isset($_GET['menu_cuaderno']) && $_GET['menu_cuaderno'] == 1) echo '&menu_cuaderno=1'; ?>" class="btn btn-default">&raquo;</a>
						</div>
						
						<!-- Button trigger modal -->
						<a href="#"class="btn btn-default hidden-print" data-toggle="modal" data-target="#modalAyuda">
							<span class="fa fa-question fa-lg"></span>
						</a>
					
						<!-- Modal -->
						<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modal_ayuda_titulo" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
										<h4 class="modal-title" id="modal_ayuda_titulo">Instrucciones de uso</h4>
									</div>
									<div class="modal-body">
										<p>El Calendario de los Grupos presenta información sobre los exámenes 
										y actividades que los miembros de un Equipo Educativo han registrado 
										en su Calendario Personal y han asociado a ese Grupo. Las actividades 
										han sido introducidas a través del Calendario, y han quedado vinculadas 
										a un Grupo o Grupos determinados. La información registrada para el 
										Grupo también es visible desde la zona de acceso privado para los alumnos 
										y sus padres en la Página del Centro, de tal modo que estos pueden ver 
										el Calendario de exámenes y actividades de sus hijos.</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
									</div>
								</div>
							</div>
						</div>
						
					</div>

				</div>
				
				<div class="clearfix"></div>
				<br class="hidden-print">
				
				<?php vista_mes($calendario, $dia, $mes, $anio, $unidad); ?>
				
			</div><!-- /.col-md-12 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../pie.php"); ?>

</body>
</html>
