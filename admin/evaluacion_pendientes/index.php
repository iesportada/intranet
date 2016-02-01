<?php
if (isset($_POST['poner'])) {
	include 'lista_pendientes.php';
	exit();
}
if (isset($_POST['consultar'])) {
	include 'consulta_pendientes.php';
	exit();
}

require('../../bootstrap.php');


include("../../menu.php"); 

$check=mysqli_query($db_con,"select * from evalua_pendientes");
if ($check) {}else{
mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `evalua_pendientes` (
`id` int(11) NOT NULL auto_increment,
  `evaluacion` tinyint(1) NOT NULL,
  `claveal` varchar(8) NOT NULL,
  `codigo` int(6) NOT NULL,
  `materia` varchar(8) NOT NULL,
  `nota` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;");
}

$depto = $_SESSION ['dpt'];
$profe_dep = $_SESSION ['profi'];
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr ( $_SESSION ['cargo'], '4' ) == TRUE){
$query_Recordset1 = "SELECT distinct pendientes.codigo FROM pendientes order by grupo";
}
/*elseif (stristr ( $_SESSION ['cargo'], '4' ) == TRUE)
{
$query_Recordset1 = "select distinct codigo from 
profesores, asignaturas where asignaturas.nombre = materia and profesor in (select distinct departamentos.nombre from departamentos where departamento = '$depto') and abrev like '%\_%' and codigo in (SELECT distinct pendientes.codigo FROM pendientes order by codigo)";
}*/
else{
$query_Recordset1 = "select distinct codigo from 
profesores, asignaturas where asignaturas.nombre = materia and profesor in (select distinct departamentos.nombre from departamentos where departamento = '$depto') and abrev like '%\_%' and codigo in (SELECT distinct pendientes.codigo FROM pendientes where grupo in (select distinct grupo from profesores where profesor = '$profe_dep') order by grupo)";	
}

$Recordset1 = mysqli_query($db_con, $query_Recordset1) or die(mysqli_error($db_con));
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2 style="display:inline;">Evaluación de Pendientes <small>Listado de pendientes por asignatura</small></h2>
		
		<!-- Button trigger modal -->
		<a href="#"class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
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
						<p>Este módulo permite poner y consultar las notas de las distintas Evaluaciones de los alumnos con 
						Asignaturas pendientes de otros Cursos.</p>
						<p>El formulario para colocar las calificaciones nos presenta los Niveles en los que impartimos la 
						asignatura. Al seleccionar un Nivel nos encontramos con los alumnos pendientes de alguno de nuestros 
						Grupos en ese Nivel.</p>
						<p>Los Jefes de Departamento pueden seleccionar todos los Niveles y colocar notas a todos los alumnos 
						de ese Nivel; el Equipo Directivo puede seleccionar y poner notas en todos los Niveles y todas las 
						Asignaturas.</p>
						<p>La Consulta es abierta para todos los Profesores, Departamentos y Asignaturas. Nos presenta un 
						bloque por Nivel en el que aparecen los alumnos con cualquier asignatura pendiente.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>

	</div>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	<br>
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-5 col-sm-offset-1">
			
			<div class="well">
				
				<form method="post" action="index.php">
					<fieldset>
						<legend>Registro de Calificaciones de Pendientes</legend>
						
						<div class="form-group">
						  <select class="form-control" name="select">
<?php 
do {  
	$asig = mysqli_query($db_con,"select distinct nombre, curso from asignaturas where codigo = '$row_Recordset1[0]' and abrev like '%\_%' order by curso, nombre");
	$asignatur = mysqli_fetch_row($asig);
	$asignatura = $asignatur[0];
	$curso = $asignatur[1];
?>
    <option value='<?php  echo $row_Recordset1[0];?>'><?php  echo $curso." => ".$asignatura;?></option>
    <?php 
} while ($row_Recordset1 = mysqli_fetch_array($Recordset1));
  $rows = mysqli_num_rows($Recordset1);
?>
						  </select>
						</div>
					  
					  <button type="submit" class="btn btn-primary" name="poner">Registrar Calificaciones</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		<div class="col-sm-5">
			
			<div class="well">
			
			<form method="post" action="index.php">
					<fieldset>
						<legend>Consulta de Calificaciones</legend>
						
						<div class="form-group">
						<label>Curso</label>
						  <select class="form-control" name="curso" onChange="submit()">
<?php 
if(isset($_POST['curso'])){
echo "<option>".$_POST['curso']."</option>";
}
else{
echo "<option></option>";
}
	$asig2 = mysqli_query($db_con,"select distinct curso from alma, cursos where curso=nomcurso and unidad in (select distinct unidad from pendientes) and curso not like '1%' order by idcurso");
	while($asignatur2 = mysqli_fetch_row($asig2)){
	$curso1 = $asignatur2[0];
?>
    <option><?php  echo $curso1;?></option>
    <?php 
	}
?>
						  </select>
						</div>
						
						<div class="form-group">
						<label>Grupo</label>
						  <select class="form-control" name="unidad">
						  <option></option>

<?php 
	$uni = mysqli_query($db_con,"select distinct unidad from alma where curso = '".$_POST['curso']."' order by unidad");
	while($uni2 = mysqli_fetch_row($uni)){
	$unidad = $uni2[0];
?>
    <option><?php  echo $unidad;?></option>
    <?php 
	}
?>

						  </select>
						</div>
						
						<div class="form-group">
						<label>Evaluación</label>
						  <select class="form-control" name="evaluacion">

    <option value='1'>1ª Evaluación</option>
     <option value='2'>2ª Evaluación</option>
      <option value='3'>Evaluación Ordinaria</option>
       <option value='4'>Evaluación Extraordinaria</option>

						  </select>
						</div>
					  <button type="submit" class="btn btn-primary" name="consultar">Consultar Calificaciones</button>
				  </fieldset>
				</form>
				
			</div>
			
			</div>
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?>
</body>
</html>
