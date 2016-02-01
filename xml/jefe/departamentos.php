<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
?>

<div class="container">

	<div class="page-header">
	  <h2>Administración <small> Departamentos del Centro</small></h2>
	</div>
	
	<div id="status-loading" class="text-center">
		<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
	</div>

	<div id="wrap" class="row" style="display: none;">
	
		<div class="col-sm-8 col-sm-offset-2">
	
			<div class="well">
				<?php
				if(isset($_FILES['archivo'])){  
				// BacKup de la tabla
				mysqli_query($db_con, "drop table departamentos_seg");
				mysqli_query($db_con, "create table departamentos_seg select * from departamentos");
				 
				 //  Estructura de tabla para la tabla `departamento_temp`
				mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `departamento_temp` (
				  `NOMBRE` varchar(48) NOT NULL default '',
				  `DNI` varchar(10) NOT NULL default '',
				  `DEPARTAMENTO` varchar(48) NOT NULL default '',
				  `CARGO` varchar(16) default NULL,
				  `IDEA` varchar(12) NOT NULL default '',
				   KEY `NOMBRE` (`NOMBRE`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci ");
				if(isset($_POST['actualizar'])){	
				}
				else{
				 $base0 = "delete from departamentos where idea not like 'admin' and departamento not like '%Administracion%' and departamento not like '%Conserjeria%' and departamento not like '' and cargo not like '%1%'";
				  mysqli_query($db_con, $base0);
				}
				 
				
				// Importamos los datos del fichero CSV 
				$handle = fopen ($_FILES['archivo']['tmp_name'] , "r" ) or die('<br /><div align="center"><div class="alert alert-danger alert-block fade in">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
							<h5>ATENCIÓN:</h5>
				No se ha podido abrir el archivo RelPerCen.txt. O bien te has olvidado de enviarlo o el archivo está corrompido.
				</div></div><br />
				<div align="center">
				  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
				</div><br />'); 
				while (($data1 = fgetcsv($handle, 1000, "|")) !== FALSE) 
				{
				$dep_mod = trim($data1[2]);
				$dep_mod = str_replace("(Inglés)","",$dep_mod);
				$dep_mod = str_replace("(Francés)","",$dep_mod);
				$dep_mod = str_replace("(Alemán)","",$dep_mod);
				$dep_mod = str_replace("P.E.S.","",$dep_mod);
				$dep_mod = str_replace(" P.T.F.P","",$dep_mod);
				$dep_mod = str_replace("(Secundaria)","",$dep_mod);
				$dep_mod = trim($dep_mod);
				$datos1 = "INSERT INTO departamento_temp (NOMBRE, DNI, DEPARTAMENTO, IDEA) VALUES (\"". trim($data1[0]) . "\",\"". trim($data1[1]) . "\",\"". $dep_mod . "\",\"". trim($data1[5]) . "\")";
				mysqli_query($db_con, $datos1);
				}
				fclose($handle);
				$borrarvacios = "delete from departamento_temp where DNI = ''";
				mysqli_query($db_con, $borrarvacios);
				$borrarpuesto = "delete from departamento_temp where DEPARTAMENTO LIKE '%Puesto%'";
				mysqli_query($db_con, $borrarpuesto);
				// Eliminar duplicados e insertar nuevos
				$elimina = "select distinct NOMBRE, DNI, DEPARTAMENTO, IDEA from departamento_temp where dni NOT IN (select distinct dni from departamentos where departamento not like '%Conserjeria%' and departamento not like '%Administracion%' and idea not like 'admin')";
				$elimina1 = mysqli_query($db_con, $elimina);
				 if(mysqli_num_rows($elimina1) > 0)
				{
				echo "
				<br /><div align='center'><div class='alert alert-success alert-block fade in'>
				            <button type='button'' class='close' data-dismiss='alert'>&times;</button>
				Tabla <strong>Departamentos</strong>: los siguientes Profesores han sido añadidos a la tabla. <br>Comprueba los registros creados:</div></div>";
				while($elimina2 = mysqli_fetch_array($elimina1))
				{
				echo "<li>".$elimina2[0] . " -- " . $elimina2[1] . " -- " . $elimina2[2] . "</li>";
				  $SQL6 = "insert into departamentos  (NOMBRE, DNI, DEPARTAMENTO, IDEA) VALUES (\"". $elimina2[0] . "\",\"". $elimina2[1] . "\",\"". $elimina2[2] . "\",\"". $elimina2[3] . "\")";
				  $result6 = mysqli_query($db_con, $SQL6);
				}
				echo "<br />";
				}
				else {
					echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
							<h5>ATENCIÓN:</h5>
				Tabla <strong>Departamentos</strong>: No se ha añadido ningún registro a la tabla.
				</div></div>';
					}
				
				// Actualizamos nombre de los departamentos en la tabla y tablas relacionadas
				include("actualiza_dep.php");
				// Registramos los tutores desde FTUTORES
				$tut0=mysqli_query($db_con, "select distinct tutor from FTUTORES");
				while($tut=mysqli_fetch_array($tut0))
				{
				$cargo0=mysqli_query($db_con, "select cargo from departamentos where nombre = '$tut[0]'");
				$cargo1=mysqli_fetch_array($cargo0);
				$cargo_tutor="2".$cargo1[0];
				if(strstr($cargo1[0],"2")==TRUE){}else{
				mysqli_query($db_con, "update departamentos set cargo = '$cargo_tutor' where  nombre='$tut[0]'");
				}
				}
				// Usuario
				  // Actualización de IDEA de los Profesores del Centro.
				$SQL1 = "select distinct nombre, dni, idea from departamentos where nombre NOT IN (select distinct profesor from c_profes) and departamento not like '%Conserjer%' and idea not like 'admin'";
				$result1 = mysqli_query($db_con, $SQL1);
				$total = mysqli_num_rows($result1);
				if ($total !== 0)
				{
					echo "<div class='form-group success'><p class='help-block' style='text-align:left'>Tabla <strong>c_profes</strong>: los nuevos Profesores han sido añadidos a la tabla de usuarios de la Intranet. <br>Comprueba en la lista de abajo los registros creados:</p></div>";
				while  ($row1= mysqli_fetch_array($result1))
				 {
				$SQL2 = "INSERT INTO c_profes (profesor, dni, pass, idea) VALUES (\"". $row1[0]. "\",\"". $row1[1] . "\",\"". sha1($row1[1]) . "\",\"". $row1[2] . "\")";
				echo "<li>".$row1[0] . "</li>";
				$result2 = mysqli_query($db_con, $SQL2);
				}
				echo "<br />";
				}
				
				mysqli_query($db_con, "drop table departamento_temp");
				
				//------------------------------------------------------------------------------------------------------------
				//  Profesores TIC
					$borrar = "truncate table usuarioprofesor";
					mysqli_query($db_con, $borrar);
				// Primera parte, trabajamos sobre alma, que se actualiza regularmente.
				$profesores = "select distinct nombre, idea from departamentos";
				$sqlprof = mysqli_query($db_con, $profesores);
				while ($sqlprof0 = mysqli_fetch_array($sqlprof)) {
					$nombreorig = $sqlprof0[0];
					$usuario = $sqlprof0[1];
					$insertar = "insert into usuarioprofesor set nombre = '$nombreorig', usuario = '$usuario', perfil = 'p'";
					mysqli_query($db_con, $insertar);
				}
				$repetidos = mysqli_query($db_con, "select usuario from usuarioprofesor");
				while($num = mysqli_fetch_row($repetidos))
				{
				$n_a = "";
				$repetidos1 = mysqli_query($db_con, "select usuario, nombre from usuarioprofesor where usuario = '$num[0]'");
				if (mysqli_num_rows($repetidos1) > 1) {
				while($num1 = mysqli_fetch_row($repetidos1))
				{
				$n_a = $n_a +1;
				$nuevo = $num1[0].$n_a;
				mysqli_query($db_con, "update usuarioprofesor set usuario = '$nuevo' where nombre = '$num1[1]'");
				}	
				}
				}
				mysqli_query($db_con, "delete from usuarioprofesor where usuario like 'pprofesor%'");
				// Archivo de exportacion para Gesuser.
				$codigo = "select  usuario, nombre, perfil from usuarioprofesor";
				//echo $codigo . "<br>";
				$sqlcod = mysqli_query($db_con, $codigo);
				while($rowprof = mysqli_fetch_array($sqlcod))
				{
				$lineaprof = "$rowprof[0];$rowprof[1];$rowprof[2];\n";
				$todoprof .= $lineaprof;
				}
				 if (!(file_exists("TIC/profesores.txt")))
				{
				$fpprof=fopen("TIC/profesores.txt","w+");
				 }
				 else
				 {
				 $fpprof=fopen("TIC/profesores.txt","w+") or die('<br /><div align="center"><div class="alert alert-danger alert-block fade in">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
							<h5>ATENCIÓN:</h5>
				No se ha podido escribir en el archivo TIC/profesores.txt. ¿Has concedido permiso de escritura en ese directorio?
				</div></div><br />
				<div align="center">
				  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
				</div>'); 
				 }
				 $pepito=fwrite($fpprof,$todoprof);
				 fclose ($fpprof);
				 echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
				Los datos de los profesores se han importado correctamente en la tabla <strong>usuarioprofesor</strong>.<br> Se ha generado un fichero (profesores.txt) en el subdirectorio "xml/jefe/TIC/" preparado para el alta masiva en el Servidor TIC.
				</div></div><br />';
				 
				// Moodle
				$codigo1 = "select  c_profes.idea, c_profes.dni, c_profes.profesor, correo from c_profes, departamentos where c_profes.idea = departamentos.idea";
				$sqlcod1 = mysqli_query($db_con, $codigo1);
				$todos_moodle="username;password;firstname;lastname;email;city;country\n";
				while($rowprof = mysqli_fetch_array($sqlcod1))
				{
				if (!($rowprof[0]=='admin') and !($rowprof[0]=='conserje') and !($rowprof[4]=='7')) {
						$n_pro = explode(", ",$rowprof[2]);
				$nombre_profe = $n_pro[1];	
				$apellidos_profe = $n_pro[0];
				
				$linea_moodle = "$rowprof[0];$rowprof[1];$nombre_profe;$apellidos_profe;$rowprof[3];".$config['centro_localidad'].";ES\n";
				$todos_moodle.=$linea_moodle;
					}
				}
				
				 if (!(file_exists("TIC/profesores_moodle.txt")))
				{
				$fpprof1=fopen("TIC/profesores_moodle.txt","w+");
				 }
				 else
				 {
				 $fpprof1=fopen("TIC/profesores_moodle.txt","w+") or die('<br /><div align="center"><div class="alert alert-danger alert-block fade in">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
							<h5>ATENCIÓN:</h5>
				No se ha podido escribir en el archivo TIC/profesores.txt. ¿Has concedido permiso de escritura en ese directorio?
				</div></div><br />
				<div align="center">
				  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
				</div>'); 
				 }
				 $pepito1=fwrite($fpprof1,$todos_moodle);
				 fclose ($fpprof1);
				 echo '<div align="center"><div class="alert alert-success alert-block fade in">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
				 Se ha generado un fichero (profesores_moodle.txt) en el subdirectorio "xml/jefe/TIC/" preparado para el alta masiva de usuarios en la Plataforma Moodle.
				</div></div><br />'; 
				}
				else{
					echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in">
				            <button type="button" class="close" data-dismiss="alert">&times;</button>
							<h5>ATENCIÓN:</h5>
				Parece que te está olvidando de enviar el archivo con los datos de los Profesores. Asegúrate de enviar el archivo descargado desde Séneca.
				</div></div><br />';
				}
				
				// CALENDARIO
				$result = mysqli_query($db_con, "SELECT nombre, idea FROM departamentos");
				while ($row = mysqli_fetch_assoc($result)) {
					$exp_nombre = explode(',', $row['nombre']);
					$nombre = trim($exp_nombre[1]);
					if ($nombre == '') {
						$exp_nombre = explode(' ', $row['nombre']);
						$nombre = trim($exp_nombre[0]);
					}
					$idea = $row['idea'];
					
					
					$calendarioExiste = mysqli_query($db_con, "SELECT id FROM calendario_categorias WHERE profesor='$idea'");
					if (! mysqli_num_rows($calendarioExiste)) {
						$query = "INSERT INTO `calendario_categorias` (`nombre`, `fecha`, `profesor`, `color`, `espublico`) VALUES ('$nombre', '".date('Y-m-d')."', '$idea', '#3498db', 0)";
						mysqli_query($db_con, $query);
					}
					mysqli_free_result($calendarioExiste);
				}
				mysqli_free_result($result);
				
				?>
			
				<div class="text-center">
					 <a href="../index.php" class="btn btn-primary">Volver a Administración</a>
				</div>
			
			</div><!-- /.well -->
	
		</div><!-- /.col-sm-8 -->
		
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php");	?>

<script>
function espera() {
	document.getElementById("wrap").style.display = '';
	document.getElementById("status-loading").style.display = 'none';        
}
window.onload = espera;
</script>

</body>
</html>
