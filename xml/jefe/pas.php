<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include("../../menu.php");
?>

	<div class="container">
		
		<div class="page-header">
		  <h2>Administración <small>Importación de Personal de Administración y Servicios</small></h2>
		</div>
		
		
		<div class="alert alert-info hidden-print">
			<strong>Información:</strong> Las nuevas incorporaciones aparecen marcadas en verde.
		</div>
		
		<div id="status-loading" class="text-center">
			<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
		</div>
		
		
		<div id="wrap" class="row" style="display: none;">
		
			<div class="col-sm-12">
								
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>DNI</th>
							<th>Departamento</th>
							<th>Usuario IdEA</th>
							<th>Contraseña</th>
						</tr>
					</thead>
					<tbody>
							<?php
							if(isset($_FILES['archivo'])) {
							
								$file = fopen($_FILES['archivo']['tmp_name'], "r");
								
								$conectores = array("(", ")", "de ", "del ", "de la ", "de los ", "de las ", "y ", "y de ");
								$acentos_no_permitidos = array("á","é","í","ó","ú","Á","É","Í","Ó","Ú");
								$acentos_permitidos = array("a","e","i","o","u","A","E","I","O","U");
								
								$linea = 1;
								while(($row = fgetcsv($file, 1000, "|")) !== FALSE) {
									
									// Saltamos la cabecera del fichero txt
									if ($linea > 8) {
										$pas_nombre			= mysqli_real_escape_string($db_con, trim($row[0]));
										$pas_dni			= mysqli_real_escape_string($db_con, trim($row[1]));
										$pas_departamento	= mysqli_real_escape_string($db_con, trim($row[2]));
										$pas_idea			= mysqli_real_escape_string($db_con, trim($row[5]));
										
										// Sanitizamos el DNI
										(strlen($pas_dni) < 9) ? $pas_dni_sanitizado = '0'.$pas_dni : $pas_dni_sanitizado = $pas_dni;
										
										// Si no tiene asignado usuario IdEA, lo creamos
										if(empty($pas_idea)) {
											$nombre_sanitizado = mb_convert_case($pas_nombre, MB_CASE_LOWER, 'ISO-8859-1');
											$nombre_sanitizado = str_replace($conectores, "", $nombre_sanitizado);
											$nombre_sanitizado = str_replace($acentos_no_permitidos, $acentos_permitidos, $nombre_sanitizado);
											
											$exp_nombre = explode(',', $nombre_sanitizado);
											$nombre = trim($exp_nombre[1]);
											
											$exp_apellidos = explode(' ', $exp_nombre[0]);
											$apellido1 = trim($exp_apellidos[0]);
											$apellido2 = trim($exp_apellidos[1]);
											
											$pas_idea = substr($nombre, 0, 1).substr($apellido1, 0, 3).substr($apellido2, 0, 3).substr($pas_dni_sanitizado, 5, 3);
										}
										
										// Administracion = '7';
										if($pas_departamento == 'Administrativo/a' || $pas_departamento == 'Auxiliar administrativo/a' || $pas_departamento == 'Titulado/a Grado Medio' || $pas_departamento == 'Titulado/a Superior') {
											
											$resultDepto = mysqli_query($db_con, "SELECT * FROM departamentos WHERE idea = '$pas_idea'");
											(mysqli_num_rows($resultDepto)) ? $usuarioExiste = 1 : $usuarioExiste = 0;
											
											$clase = '';
											if(! $usuarioExiste) {
												// INCORPORACIÓN EN TABLA DEPARTAMENTOS
												mysqli_query($db_con, "INSERT INTO departamentos (NOMBRE, DNI, DEPARTAMENTO, CARGO, idea) VALUES ('".$pas_nombre."', '".$pas_dni."', 'Administracion', '7', '".$pas_idea."')");
												
												// INCORPORACIÓN EN TABLA C_PROFES
												mysqli_query($db_con, "INSERT INTO c_profes (pass, PROFESOR, dni, idea, estado) VALUES ('".sha1($pas_dni)."', '".$pas_nombre."', '".$pas_dni."', '".$pas_idea."', 0)");
												
												$clase = ' class="success"';
											}
											
											echo "<tr".$clase.">\n";
											echo "<td>".$pas_nombre."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "<td>Administracion</td>\n";
											echo "<td>".$pas_idea."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "</tr>\n";
										}
										
										// Auxiliar de Conversacion = '';
										if(stristr($pas_departamento, 'Auxiliar de Conversación') == TRUE) {
										
											$resultDepto = mysqli_query($db_con, "SELECT * FROM departamentos WHERE idea = '$pas_idea'");
											(mysqli_num_rows($resultDepto)) ? $usuarioExiste = 1 : $usuarioExiste = 0;
											
											$clase = '';
											if(! $usuarioExiste) {
												// TABLA DEPARTAMENTOS
												mysqli_query($db_con, "INSERT INTO departamentos (NOMBRE, DNI, DEPARTAMENTO, CARGO, idea) VALUES ('".$pas_nombre."', '".$pas_dni."', 'Auxiliar de Conversacion', '', '".$pas_idea."')");
												
												// INCORPORACIÓN EN TABLA C_PROFES
												mysqli_query($db_con, "INSERT INTO c_profes (pass, PROFESOR, dni, idea, estado) VALUES ('".sha1($pas_dni)."', '".$pas_nombre."', '".$pas_dni."', '".$pas_idea."', 0)");
											
												$clase = ' class="success"';
											}
											
											echo "<tr".$clase.">\n";
											echo "<td>".$pas_nombre."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "<td>Auxiliar de Conversacion</td>\n";
											echo "<td>".$pas_idea."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "</tr>\n";
										}
										
										// Educador/a social = '';
										if(stristr($pas_departamento, 'Educador/a') == TRUE) {
											
											$resultDepto = mysqli_query($db_con, "SELECT * FROM departamentos WHERE idea = '$pas_idea'");
											(mysqli_num_rows($resultDepto)) ? $usuarioExiste = 1 : $usuarioExiste = 0;
											
											$clase = '';
											if(! $usuarioExiste) {
												// TABLA DEPARTAMENTOS
												mysqli_query($db_con, "INSERT INTO departamentos (NOMBRE, DNI, DEPARTAMENTO, CARGO, idea) VALUES ('".$pas_nombre."', '".$pas_dni."', 'Educador', '', '".$pas_idea."')");
												
												// INCORPORACIÓN EN TABLA C_PROFES
												mysqli_query($db_con, "INSERT INTO c_profes (pass, PROFESOR, dni, idea, estado) VALUES ('".sha1($pas_dni)."', '".$pas_nombre."', '".$pas_dni."', '".$pas_idea."', 0)");
											
												$clase = ' class="success"';
											}
											
											echo "<tr".$clase.">\n";
											echo "<td>".$pas_nombre."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "<td>Educador/a</td>\n";
											echo "<td>".$pas_idea."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "</tr>\n";
										}
										
										// Mentor acompañante = '';
										if(stristr($pas_departamento, 'Mentor acompañante') == TRUE) {
											
											$resultDepto = mysqli_query($db_con, "SELECT * FROM departamentos WHERE idea = '$pas_idea'");
											(mysqli_num_rows($resultDepto)) ? $usuarioExiste = 1 : $usuarioExiste = 0;
											
											$clase = '';
											if(! $usuarioExiste) {
												// TABLA DEPARTAMENTOS
												mysqli_query($db_con, "INSERT INTO departamentos (NOMBRE, DNI, DEPARTAMENTO, CARGO, idea) VALUES ('".$pas_nombre."', '".$pas_dni."', 'Mentor acompañante', '', '".$pas_idea."')");
												
												// INCORPORACIÓN EN TABLA C_PROFES
												mysqli_query($db_con, "INSERT INTO c_profes (pass, PROFESOR, dni, idea, estado) VALUES ('".sha1($pas_dni)."', '".$pas_nombre."', '".$pas_dni."', '".$pas_idea."', 0)");
											
												$clase = ' class="success"';
											}
											
											echo "<tr".$clase.">\n";
											echo "<td>".$pas_nombre."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "<td>Mentor acompañante</td>\n";
											echo "<td>".$pas_idea."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "</tr>\n";
										}
										
										
										// Conserje = '6';
										if($pas_departamento == 'Conserje' || $pas_departamento == 'Ordenanza') {
										
											$resultDepto = mysqli_query($db_con, "SELECT * FROM departamentos WHERE idea = '$pas_idea'");
											(mysqli_num_rows($resultDepto)) ? $usuarioExiste = 1 : $usuarioExiste = 0;
											
											$clase = '';
											if(! $usuarioExiste) {
												// TABLA DEPARTAMENTOS
												mysqli_query($db_con, "INSERT INTO departamentos (NOMBRE, DNI, DEPARTAMENTO, CARGO, idea) VALUES ('".$pas_nombre."', '".$pas_dni."',  'Conserjeria', '6', '".$pas_idea."')");
												
												// INCORPORACIÓN EN TABLA C_PROFES
												mysqli_query($db_con, "INSERT INTO c_profes (pass, PROFESOR, dni, idea, estado) VALUES ('".sha1($pas_dni)."', '".$pas_nombre."', '".$pas_dni."', '".$pas_idea."', 0)");
											
												$clase = ' class="success"';
											}
											
											echo "<tr".$clase.">\n";
											echo "<td>".$pas_nombre."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "<td>Conserjeria</td>\n";
											echo "<td>".$pas_idea."</td>\n";
											echo "<td>".$pas_dni."</td>\n";
											echo "</tr>\n";
										}
									}
									
									$linea++;
								}
								fclose($file);
								
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
						</tr>
					</tbody>
				</table>
					
				
				<div class="hidden-print">
					<a class="btn btn-primary" href="javascript:print();">Imprimir</a>
					<a class="btn btn-default" href="../index.php">Volver a Administración</a>
				</div>
			
			</div><!-- /.col-sm-12 -->
		
		</div><!-- /.row -->
	
	</div><!-- /.container -->
	
	</div>

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