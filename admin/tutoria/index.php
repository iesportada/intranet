<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 2, 8));

// COMPROBAMOS SI ES EL TUTOR, SINO ES DEL EQ. DIRECTIVO U ORIENTADOR
if (stristr($_SESSION['cargo'],'2') == TRUE) {
	
	$_SESSION['mod_tutoria']['tutor']  = $_SESSION['mod_tutoria']['tutor'];
	$_SESSION['mod_tutoria']['unidad'] = $_SESSION['mod_tutoria']['unidad'];
	
}
else {

	if(isset($_POST['tutor'])) {
		$exp_tutor = explode('==>', $_POST['tutor']);
		$_SESSION['mod_tutoria']['tutor'] = trim($exp_tutor[0]);
		$_SESSION['mod_tutoria']['unidad'] = trim($exp_tutor[1]);
	}
	else{
		if (!isset($_SESSION['mod_tutoria'])) {
			header('Location:'.'tutores.php');
		}
	}
	
}


include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Tutoría de <?php echo $_SESSION['mod_tutoria']['unidad']; ?> <small>Resumen de la unidad</small></h2>
			<h4 class="text-info">Tutor/a: <?php echo nomprofesor($_SESSION['mod_tutoria']['tutor']); ?></h4>
		</div>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
			
			<div class="col-sm-12">
				
				<?php include("inc_pendientes.php"); ?>
				
			</div>
			
		</div>
		
		
		<div class="row">
		
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-4">
				
				<?php include("inc_asistencias.php"); ?>
				<hr>
				<h3 class="text-info">Actividades extraescolares</h3>
				<?php include("inc_actividades.php"); ?>
				<hr>
				
				
			</div><!-- /.col-sm-4 -->
			
			
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-4">
				
				<?php include("inc_convivencia.php"); ?>
				<hr>
				<?php include("inc_biblio.php"); ?>
				<hr>
				<?php include("inc_informes_tareas.php"); ?>
				<hr>
				
			</div><!-- /.col-sm-4 -->
			
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-4">
				
				<?php include("inc_mensajes.php"); ?>
				<hr>
				
				<?php include("inc_informes_tutoria.php"); ?>
				<hr>
				
				<?php include("inc_intervenciones.php"); ?>
				<hr>
				
			</div><!-- /.col-sm-4 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
