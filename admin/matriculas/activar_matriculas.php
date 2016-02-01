<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
include("./menu.php");


$activar = $_GET['activar'];

if ($activar==1) {
// Comprobamos que el módulo no está activado
	$c1 = mysqli_query($db_con,"select * from alma");
	$c10 = mysqli_num_rows($c1);
	$c2 = mysqli_query($db_con,"select * from control");
	$c20 = mysqli_num_rows($c2);
	if ($c10==$c20 or (!($c20 < ($c10-5)) and !($c20 > ($c10+5)))) {
			$mensaje="La Matriculación ya ha sido activada. Sólo puede ser desactivada.";
	}
	else{
	
// Cambiamos la tabla de contraseñas de la página principal para convertir el NIE del alumno en la contraseña.
	mysqli_query($db_con,"drop table control_matriculas");
	mysqli_query($db_con,"create table control_matriculas select * from control");
	mysqli_query($db_con,"truncate table control");
	$fa=mysqli_query($db_con,"select claveal from alma");
	while ($fal=mysqli_fetch_array($fa)) {
		$claveal=$fal[0];
		$pass=sha1($fal[0]);
		$insert=mysqli_query($db_con,"insert into control (claveal, pass) VALUES ('$claveal','$pass')");
	}
$mensaje="Has activado la Matriculación desde la Página del Centro. Tanto la Clave del Centro como la Clave Personal del Alumno pasan ahora a ser la misma: el NIE del alumno. Los Tutores deberán darle el NIE a los alumnos para que estos procedan a la Matriculación, escribiendo el NIE en ambos campos.<br> Este proceso anula las claves generadas por los padres para acceder a la Página del Alumno, por lo que durante el tiempo en que esté activa la Matriculación sólo podrán acceder a la misma con el NIE. <br>Una vez completado el proceso de registro de las matrículas hay que desactivar la Matriculación. Al hacerlo, se restauran las claves originales de los Padres para acceder a la Página del alumno.";
}		
}
		
if ($activar==2) {

// Restituimos las contraseñas de los padres y desactivamos el botón de Enviar datos para que no se puedan modificar los datos de la matrícula.
mysqli_query($db_con,"truncate table control");
mysqli_query($db_con,"insert into control select * from control_matriculas");
$mensaje="Has desactivado la Matriculación desde la Página del Centro. Tanto la Clave del Centro como la Clave Personal del Alumno han sido restauradas para que los Padres puedan volver a entrar en la Página del Alumno como hacían normalmente. Los datos registrados en la matrícula del alumno ya no pyeden ser modificados desde la Página pública del Centro.";
}
?>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Matriculación de alumnos <small>Activación del proceso de Matriculación de los Alumnos</small></h2>
	</div>
	<br />
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6 col-sm-offset-3">
			
	<div class="alert alert-success alert-block fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $mensaje; ?>
	</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
