<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

				// Vaciamos o borramos tablas
				mysqli_query($db_con, "TRUNCATE TABLE calificaciones");
				mysqli_query($db_con, "TRUNCATE TABLE asignaturas");
				mysqli_query($db_con, "drop table materias");
			
				// Crear la tabla temporal donde guardar todas las asignaturas de todos los gruposy la tabla del sistema de calificaciones
				$crear = "CREATE TABLE  IF NOT EXISTS `materias_temp` (
				`CODIGO` varchar( 10 ) default NULL ,
			 	`NOMBRE` varchar( 64 ) default NULL ,
			 	`ABREV` varchar( 10 ) default NULL ,
				`CURSO` varchar( 128 ) default NULL,
				`GRUPO` varchar( 6 ) default NULL
				)" ;
				mysqli_query($db_con, $crear);
				mysqli_query($db_con, "CREATE TABLE if not exists `calificaciones_temp` (
			  `codigo` varchar(5) CHARACTER SET latin1 NOT NULL DEFAULT '',
			  `nombre` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
			  `abreviatura` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
			  `orden` varchar(4) CHARACTER SET latin1 DEFAULT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci ");
			
				// Claveal primaria e índice
				mysqli_query($db_con, "ALTER TABLE  `materias_temp` ADD  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
				mysqli_query($db_con, "ALTER TABLE  `materias_temp` ADD INDEX (  `CODIGO` )");
			
				mysqli_query($db_con, "ALTER TABLE  `calificaciones_temp` ADD INDEX (  `CODIGO` )");
				$num="";
				// Recorremos directorio donde se encuentran los ficheros y aplicamos la plantilla.
				if ($handle = opendir('../exporta')) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != ".." && $file != "index.php" ) {
							//echo $file."<br />";
							$num+=1;
							$doc = new DOMDocument('1.0', 'iso-8859-1');
			
							/*Cargo el XML*/
							$doc->load( '../exporta/'.$file );
			
							/*Obtengo el nodo MATERIA del XML
							 a traves del metodo getElementsByTagName,
							 este nos entregara una lista de todos los
							 nodos encontrados */
							$cursos = $doc->getElementsByTagName( "D_OFERTAMATRIG");
							$cur = $cursos->item(0)->nodeValue;
							
							$unidades = $doc->getElementsByTagName( "T_NOMBRE");
							$unidad = utf8_decode($unidades->item(0)->nodeValue);
							
							$materias = $doc->getElementsByTagName( "MATERIA" );
			
							/*Al ser $materias una lista de nodos
							 lo puedo recorrer y obtener todo
							 su contenido*/
							foreach( $materias as $materia )
							{	
								$codigos = $materia->getElementsByTagName( "X_MATERIAOMG" );
			
								/*Obtengo el valor del primer elemento 'item(0)'
								 de la lista $codigos.
								 Si existiera un atriburto en el nodo para obtenerlo
								 usaria $codigos->getAttribute('atributo');
								 */
								$codigo = $codigos->item(0)->nodeValue;
								$nombres = $materia->getElementsByTagName( "D_MATERIAC" );
								$nombre = $nombres->item(0)->nodeValue;
								$abrevs = $materia->getElementsByTagName( "T_ABREV" );
								$abrev = $abrevs->item(0)->nodeValue;
								mysqli_query($db_con, "INSERT INTO  `materias_temp` (
			`CODIGO` ,
			`NOMBRE` ,
			`ABREV` ,
			`CURSO` ,
			`GRUPO`
			)
			VALUES ('$codigo',  '$nombre',  '$abrev',  '$cur', '$unidad')");}
			
								//
								if ($num=="3") {
									///*Obtengo el nodo Calificación del XML
									//a traves del metodo getElementsByTagName,
									//este nos entregara una lista de todos los
									//nodos encontrados */
									//
									$calificaciones = $doc->getElementsByTagName( "CALIFICACION" );
			
									/*Al ser $calificaciones una lista de nodos
									 lo puedo recorrer y obtener todo
									 su contenido*/
									foreach( $calificaciones as $calificacion )
									{
										/*Obtengo el valor del primer elemento 'item(0)'
										 de la lista $codigos.
										 Si existiera un atributo en el nodo para obtenerlo
										 usaria $codigos->getAttribute('atributo');
										 */
										$codigos0 = $calificacion->getElementsByTagName( "X_CALIFICA" );
										$codigo0 = $codigos0->item(0)->nodeValue;
										$nombres0 = $calificacion->getElementsByTagName( "D_CALIFICA" );
										$nombre0 = $nombres0->item(0)->nodeValue;
										$abrevs0 = $calificacion->getElementsByTagName( "T_ABREV" );
										$abrev0 = $abrevs0->item(0)->nodeValue;
										$ordenes0 = $calificacion->getElementsByTagName( "N_ORDEN" );
										$orden0 = $ordenes0->item(0)->nodeValue;
										$nombre_utf = utf8_decode($nombre0);
										mysqli_query($db_con, "INSERT INTO  `calificaciones_temp` VALUES ('$codigo0',  '$nombre_utf',  '$abrev0',  '$orden0')");
									}
								}
								
						}
					}
					closedir($handle);
				}
				else{
					echo '<div class="alert alert-danger alert-block fade in">
			            <button type="button" class="close" data-dismiss="alert">&times;</button>
						<h5>ATENCIÓN:</h5>
			No se han colocado los ficheros de Evaluación de Séneca en el directorio exporta/.<br> Descárgalos de Séneca y colócalos allí antes de continuar.
			</div><br />
			<div align="center">
			  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-primary" />
			</div>';
					exit();
				}
			
				//Tabla calificaciones
				mysqli_query($db_con, "insert into calificaciones select distinct codigo, nombre, abreviatura, orden from calificaciones_temp");
			
				//Creamos tabla materias y arreglamos problema de codificación.
			
				mysqli_query($db_con, "create table materias select * from materias_temp");
				mysqli_query($db_con, "ALTER TABLE  `materias` ADD INDEX ( `CODIGO` )");
				//mysqli_query($db_con, "ALTER TABLE `materias` DROP `GRUPO`");
			
				$pr1 = mysqli_query($db_con, "select * from materias");
				while ($pr10 = mysqli_fetch_array($pr1)){
					$nombr = utf8_decode($pr10[1]);
					$abre = utf8_decode($pr10[2]);
					$cu = utf8_decode($pr10[3]);
					$id = $pr10[5];
					mysqli_query($db_con, "update materias set nombre = '$nombr', curso = '$cu', abrev = '$abre' where id = '$id'");
				}
			
				//Borramos tablas temporales
				mysqli_query($db_con, "drop table materias_temp");
				mysqli_query($db_con, "drop table calificaciones_temp");
			
				// Depuramos los códigos de las asignaturas eliminando duplicados y creamos tabla definitiva asignaturas.
				$crear = "insert into asignaturas select distinct CODIGO, NOMBRE, ABREV, CURSO from materias order by CODIGO" ;
				mysqli_query($db_con, $crear) or die('<div class="alert alert-danger alert-block fade in">
			            <button type="button" class="close" data-dismiss="alert">&times;</button>
						<h5>ATENCIÓN:</h5>
			No se pueden crear los registros en la tabla asignaturas. Busca ayuda.
			</div><br />
			<div align="center">
			  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-primary" />
			</div>'); 
			
				// Añadimos excepciones
				mysqli_query($db_con,"INSERT INTO `asignaturas` (`CODIGO`, `NOMBRE`, `ABREV`, `CURSO`) VALUES ('2', 'Tutoría con Alumnos', 'TCA', '1º de E.S.O.'), ('2', 'Tutoría con Alumnos', 'TCA', '2º de E.S.O.'), ('2', 'Tutoría con Alumnos', 'TCA', '3º de E.S.O.'), ('2', 'Tutoría con Alumnos', 'TCA', '4º de E.S.O.'), ('386', 'Tutoría Programa Diversificación Curricular (Orientador/a)', 'TUDIV', '1º de F.P.B. (Informática y Comunicaciones)'), ('386', 'Tutoría Programa Diversificación Curricular (Orientador/a)', 'TUDIV', '2º de F.P.B. (Informática y Comunicaciones)'), ('21', 'Refuerzo Pedagógico', 'REF', '1º de E.S.O.'), ('21', 'Refuerzo Pedagógico', 'REF', '2º de E.S.O.')");
			
				echo '<br />
				<div class="alert alert-success alert-block fade in">
			            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ASIGNATURAS y CALIFICACIONES:</h5> Los datos se han introducido correctamente en la Base de Datos.
			</div><br />';
			
			
				// Alumnos con pendientes
				include("pendientes.php");
			
?>