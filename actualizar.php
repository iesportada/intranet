<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `actualizacion` (
  `d` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`d`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");


/*
 @descripcion: Sistema de reservas
 @fecha: 20 de agosto de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Sistema de reservas'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Sistema de reservas', NOW())");
	
	// Eliminamos antigua actualización
	$result = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Reservas en base de datos principal'");
	if (! mysqli_num_rows($result)) {
	 mysqli_query($db_con, "DELETE FROM actualizacion WHERE modulo = 'Reservas en base de datos principal' LIMIT 1");
	}

	// Estructura de tabla para la tabla `reservas`
	
	mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS ".$config['db_name'].".`reservas` (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `eventdate` date default NULL,
	  `dia` tinyint(1) NOT NULL default '0',
	  `html` tinyint(1) NOT NULL default '0',
	  `event1` varchar(64) default NULL,
	  `event2` varchar(64) NOT NULL default '',
	  `event3` varchar(64) NOT NULL default '',
	  `event4` varchar(64) NOT NULL default '',
	  `event5` varchar(64) NOT NULL default '',
	  `event6` varchar(64) NOT NULL default '',
	  `event7` varchar(64) NOT NULL default '',
	  `servicio` varchar(32) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
	
	// Estructura de tabla para la tabla `reservas_hor`
	
	mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS ".$config['db_name'].".`reservas_hor` (
	  `dia` tinyint(1) NOT NULL default '0',
	  `hora1` varchar(24) default NULL,
	  `hora2` varchar(24) default NULL,
	  `hora3` varchar(24) default NULL,
	  `hora4` varchar(24) default NULL,
	  `hora5` varchar(24) default NULL,
	  `hora6` varchar(24) default NULL,
	  `hora7` varchar(24) default NULL,
	  `servicio` varchar(32) NOT NULL,
	  KEY `dia` (`dia`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
	
	// Tabla de Estadísticas TIC
	
	mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS ".$config['db_name'].".`usuario` (
	  `profesor` varchar(48) NOT NULL default '',
	  `c1` smallint(3) default NULL,
	  `c2` smallint(3) default NULL,
	  `c3` smallint(3) default NULL,
	  `c4` smallint(3) default NULL,
	  `c5` smallint(3) default NULL,
	  `c6` smallint(3) default NULL,
	  `c7` smallint(3) default NULL,
	  `c8` smallint(3) default NULL,
	  `c9` smallint(3) default NULL,
	  `c10` smallint(3) default NULL,
	  `c11` smallint(3) default NULL,
	  `c12` smallint(6) default NULL,
	  `c13` smallint(6) default NULL,
	  `c14` smallint(6) default NULL,
	  `c15` smallint(6) default NULL,
	  PRIMARY KEY  (`profesor`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
	
	// Tabla de Dependencias ocultas
	
	mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `".$config['db_name']."`.`ocultas` (
	  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	  `aula` varchar(48) COLLATE latin1_spanish_ci NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
	
	// Tabla de Dependencias nuevas
	
	mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `".$config['db_name']."`.`nuevas` (
	  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	  `abrev` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
	  `nombre` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
	  `texto` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
	
	
	// CREACIÓN TABLA: RESERVAS_TIPOS
	mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `".$config['db_name']."`.`reservas_tipos` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `tipo` varchar(254) COLLATE latin1_spanish_ci NOT NULL,
	  `observaciones` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ;");

	mysqli_query($db_con, "TRUNCATE TABLE `".$config['db_name']."`.`reservas_tipos`");
	
	// CREACIÓN TABLA: RESERVAS_ELEMENTOS
	mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `".$config['db_name']."`.`reservas_elementos` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `elemento` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
	  `id_tipo` tinyint(2) NOT NULL,
	  `oculto` tinyint(1) NOT NULL DEFAULT '0',
	  `observaciones` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
	  PRIMARY KEY (`id`)

	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
	mysqli_query($db_con, "TRUNCATE TABLE `".$config['db_name']."`.`reservas_elementos`");
	
	// INSERTAMOS LOS TIPOS DE RESERVAS POR DEFECTO DE LA APLICACIÓN
	mysqli_query($db_con,"INSERT INTO `".$config['db_name']."`.`reservas_tipos` (`id`, `tipo`, `observaciones`) VALUES
	(1, 'TIC', ''),
	(2, 'Medios Audiovisuales', '');");
	
	
	// INSERTAMOS LOS CARRITOS TIC
	$result = mysqli_query($db_con, "SHOW TABLES FROM `reservas` LIKE 'carrito%'");
	if(! mysqli_num_rows($result)) {
		$result = mysqli_query($db_con, "SHOW TABLES FROM `".$config['db_name']."` LIKE 'carrito%'");
	}
	
	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
	
		if ((stristr($row[0], 'hor') == FALSE)) {
			$nomcarrito = mysqli_real_escape_string($db_con, $row[0]);
			
			mysqli_query($db_con, "INSERT INTO `".$config['db_name']."`.`reservas_elementos` (elemento, id_tipo, oculto, observaciones) VALUES ('TIC $i', '1', '0', '')");
			
			$i++;
		}
		
	}
	mysqli_free_result($result);
	
	// INSERTAMOS LOS MEDIOS AUDIOVISUALES
	$result = mysqli_query($db_con, "SHOW TABLES FROM `reservas` LIKE 'medio%'");
	if(! mysqli_num_rows($result)) {
		$result = mysqli_query($db_con, "SHOW TABLES FROM `".$config['db_name']."` LIKE 'medio%'");
	}
	
	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
		
		if ((stristr($row[0], 'hor') == FALSE)) {
			$nommedio = mysqli_real_escape_string($db_con, $row[0]);
			
			mysqli_query($db_con, "INSERT INTO `".$config['db_name']."`.`reservas_elementos` (elemento, id_tipo, oculto, observaciones) VALUES ('Medio $i', '2', '0', '')");
			
			$i++;
		}
		
	}
	mysqli_free_result($result);
	
	// ELIMINACIÓN DE DATOS
	
	// ELIMINAMOS TABLAS DE AULAS Y DEPENDENCIAS 
	$result = mysqli_query($db_con, "SELECT DISTINCT a_aula, n_aula FROM horw WHERE c_asig NOT LIKE '25' AND a_aula NOT LIKE '' ORDER BY n_aula ASC");
	while ($row = mysqli_fetch_array($result)) {
	
		$nomdependencia = mysqli_real_escape_string($db_con, $row[0]);
		
		// MIGRAMOS LOS DATOS
		$result_reservas = mysqli_query($db_con, "SELECT * FROM `reservas`.`$nomdependencia`");
		if(! mysqli_num_rows($result_reservas)) {
			$result_reservas = mysqli_query($db_con, "SELECT * FROM `".$config['db_name']."`.`$nomdependencia`");
		}
		while ($datos = mysqli_fetch_array($result_reservas)) {
			mysqli_query($db_con,"INSERT INTO `".$config['db_name']."`.`reservas` (`eventdate`, `dia`, `html`, `event1`, `event2`, `event3`, `event4`, `event5`, `event6`, `event7`, `servicio`) VALUES ('$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', '$datos[5]', '$datos[6]', '$datos[7]', '$datos[8]', '$datos[9]', '$datos[10]', '$nomdependencia')");
		}
		
		mysqli_query($db_con, "DROP TABLE ".$config['db_name'].".`$nomdependencia`");
		
	}
	mysqli_free_result($result);
	
	// ELIMINAMOS TABLAS DE CARRITOS TIC
	$result = mysqli_query($db_con, "SHOW TABLES FROM `reservas` LIKE 'carrito%'");
	if(! mysqli_num_rows($result)) {
		$result = mysqli_query($db_con, "SHOW TABLES FROM `".$config['db_name']."` LIKE 'carrito%'");
	}
	while ($row = mysqli_fetch_array($result)) {
	
		$nomcarrito = mysqli_real_escape_string($db_con, $row[0]);
		
		// MIGRAMOS LOS DATOS
		$result_reservas = mysqli_query($db_con, "SELECT * FROM `reservas`.`$nomcarrito`");
		if(! mysqli_num_rows($result_reservas)) {
			$result_reservas = mysqli_query($db_con, "SELECT * FROM `".$config['db_name']."`.`$nomcarrito`");
		}
		while ($datos = mysqli_fetch_array($result_reservas)) {
			$nombre_tic = str_replace("carrito","TIC ",$nomcarrito);
			mysqli_query($db_con,"INSERT INTO `".$config['db_name']."`.`reservas` (`eventdate`, `dia`, `html`, `event1`, `event2`, `event3`, `event4`, `event5`, `event6`, `event7`, `servicio`) VALUES ('$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', '$datos[5]', '$datos[6]', '$datos[7]', '$datos[8]', '$datos[9]', '$datos[10]', '$nombre_tic')");
		}
		
		mysqli_query($db_con, "DROP TABLE ".$config['db_name'].".`$nomcarrito`");
		
	}
	mysqli_free_result($result);
	
	// ELIMINAMOS TABLAS DE MEDIOS AUDIOVISUALES
	$result = mysqli_query($db_con, "SHOW TABLES FROM `reservas` LIKE 'medio%'");
	if(! mysqli_num_rows($result)) {
		$result = mysqli_query($db_con, "SHOW TABLES FROM `".$config['db_name']."` LIKE 'medio%'");
	}
	while ($row = mysqli_fetch_array($result)) {
	
		$nommedio = mysqli_real_escape_string($db_con, $row[0]);
		
		// MIGRAMOS LOS DATOS
		$result_reservas = mysqli_query($db_con, "SELECT * FROM `reservas`.`$nommedio`");
		if(! mysqli_num_rows($result_reservas)) {
			$result_reservas = mysqli_query($db_con, "SELECT * FROM `".$config['db_name']."`.`$nommedio`");
		}
		while ($datos = mysqli_fetch_array($result_reservas)) {
			$nombre_medio = str_replace("medio","medio ",$nommedio);
			mysqli_query($db_con,"INSERT INTO `".$config['db_name']."`.`reservas` (`eventdate`, `dia`, `html`, `event1`, `event2`, `event3`, `event4`, `event5`, `event6`, `event7`, `servicio`) VALUES ('$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', '$datos[5]', '$datos[6]', '$datos[7]', '$datos[8]', '$datos[9]', '$datos[10]', '$nombre_medio')");
		}
		
		mysqli_query($db_con, "DROP TABLE ".$config['db_name'].".`$nommedio`");
		
	}
	mysqli_free_result($result);
	
	// ELIMINAMOS LA BASE DE DATOS DE RESERVAS
	mysqli_query($db_con, "DROP DATABASE `reservas`");
	
	unset($nomcarrito);
	unset($nommedio);
	unset($i);

}

/*
 @descripcion: Temas personalizados para cada profesor.
 @fecha: 19 de julio de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Temas del Profesor'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Temas del Profesor', NOW())");

	mysqli_query($db_con, "CREATE TABLE IF NOT EXISTS `temas` (
  `idea` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `tema` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `fondo` varchar(16) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

mysqli_query($db_con, "ALTER TABLE `temas`
 ADD UNIQUE KEY `idea` (`idea`)");
}


/*
 @descripcion: Eliminado usuario conserje
 @fecha: 10 de agosto de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Eliminado usuario conserje'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Eliminado usuario conserje', NOW())");

	mysqli_query($db_con, "DELETE FROM departamentos WHERE nombre='conserje' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM departamentos WHERE nombre='Conserjeria' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM c_profes WHERE profesor='conserje' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM c_profes WHERE profesor='Conserjeria' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM calendario_categorias WHERE nombre='conserje'");
	mysqli_query($db_con, "DELETE FROM calendario_categorias WHERE nombre='Conserjeria'");
	mysqli_query($db_con, "DELETE FROM mens_texto WHERE origen='conserje'");
	mysqli_query($db_con, "DELETE FROM mens_texto WHERE origen='Conserjeria'");
	mysqli_query($db_con, "DELETE FROM reg_intranet WHERE profesor='conserje'");
	mysqli_query($db_con, "DELETE FROM reg_intranet WHERE profesor='Conserjeria'");
}


/*
 @descripcion: Eliminar calendarios duplicados
 @fecha: 10 de agosto de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Eliminar calendarios duplicados'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Eliminar calendarios duplicados', NOW())");
	
	$result_profesores = mysqli_query($db_con, "SELECT DISTINCT profesor FROM calendario_categorias ORDER BY profesor ASC");
	
	while ($row = mysqli_fetch_array($result_profesores)) {
		
		$result_calendarios = mysqli_query($db_con, "SELECT id, nombre FROM calendario_categorias WHERE profesor='".$row['profesor']."' AND color='#3498db' AND espublico=0 ORDER BY id ASC");
		
		$i = 0;
		while ($row_calendario = mysqli_fetch_array($result_calendarios)) {
		
			if ($i == 0) {
				$calendario_principal = $row_calendario['id'];
			}
			else {
				$result_eventos = mysqli_query($db_con, "SELECT id FROM calendario WHERE categoria='".$row_calendario['id']."' ORDER BY id ASC");
				
				while ($row_evento = mysqli_fetch_array($result_eventos)) {
					mysqli_query($db_con, "UPDATE calendario SET categoria='".$calendario_principal."' WHERE categoria='".$row_evento['id']."' LIMIT 1");
				}
				mysqli_free_result($result_eventos);
				
				mysqli_query($db_con, "DELETE FROM calendario_categorias WHERE id='".$row_calendario['id']."' LIMIT 1");
			}
			
			$i++;
		}
		mysqli_free_result($result_calendarios);
		
	}
	mysqli_free_result($result_profesores);
	
	unset($calendario_principal);
	unset($i);
}

/*
 @descripcion: Eliminado usuario conserje
 @fecha: 10 de agosto de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Eliminado usuario conserje'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Eliminado usuario conserje', NOW())");

	mysqli_query($db_con, "DELETE FROM departamentos WHERE nombre='conserje' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM departamentos WHERE nombre='Conserjeria' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM c_profes WHERE profesor='conserje' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM c_profes WHERE profesor='Conserjeria' LIMIT 1");
	mysqli_query($db_con, "DELETE FROM calendario_categorias WHERE nombre='conserje'");
	mysqli_query($db_con, "DELETE FROM calendario_categorias WHERE nombre='Conserjeria'");
	mysqli_query($db_con, "DELETE FROM mens_texto WHERE origen='conserje'");
	mysqli_query($db_con, "DELETE FROM mens_texto WHERE origen='Conserjeria'");
	mysqli_query($db_con, "DELETE FROM reg_intranet WHERE profesor='conserje'");
	mysqli_query($db_con, "DELETE FROM reg_intranet WHERE profesor='Conserjeria'");
}


/*
 @descripcion: Actualización de tablas de mensajes a Idea.
 @fecha: 12 de agosto de 2015
 */
 
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Idea en Mensajes'");
if (! mysqli_num_rows($actua)) {

	mysqli_query($db_con,"drop table mens_texto_backup");
	mysqli_query($db_con,"drop table mens_profes_backup");
	mysqli_query($db_con,"create table mens_texto_backup select * from mens_texto");
	mysqli_query($db_con,"create table mens_profes_backup select * from mens_profes");
	
	
	mysqli_query($db_con,"create table departamento_tmp select nombre, idea, dni from departamentos");
	mysqli_query($db_con,"insert into departamento_tmp select nombre, idea, dni from ".$config['db_name']."2014.departamentos where nombre not in (select nombre from departamento_tmp)");
	mysqli_query($db_con,"insert into departamento_tmp select nombre, idea, dni from ".$config['db_name']."2013.departamentos where nombre not in (select nombre from departamento_tmp)");
	mysqli_query($db_con,"insert into departamento_tmp select nombre, idea, dni from ".$config['db_name']."2012.departamentos where nombre not in (select nombre from departamento_tmp)");
	mysqli_query($db_con,"insert into departamento_tmp select nombre, idea, dni from ".$config['db_name']."2011.departamentos where nombre not in (select nombre from departamento_tmp)");
	
	$query = mysqli_query($db_con,"select distinct profesor from mens_profes");
	while ($row = mysqli_fetch_array($query)) {
		if (strlen($row[0])>10) {		
		$query1 = mysqli_query($db_con,"select idea from departamento_tmp where nombre = '$row[0]'");
		if (mysqli_num_rows($query1)>0) {	
		$row1 = mysqli_fetch_array($query1);
		$idea = $row1[0];
		if ($idea!=="") {
			$n++;
		mysqli_query($db_con,"update mens_profes set profesor = '$idea' where profesor = '$row[0]'");
				}
			}
		}
	}
	
	$n=0;
	$query = mysqli_query($db_con,"select distinct origen from mens_texto");
	while ($row = mysqli_fetch_array($query)) {
		if (strlen($row[0])>10) {		
		$query1 = mysqli_query($db_con,"select idea from departamento_tmp where nombre = '$row[0]'");
		if (mysqli_num_rows($query1)>0) {	
		$row1 = mysqli_fetch_array($query1);
		$idea = $row1[0];
		if ($idea!=="") {
		$n++;
		mysqli_query($db_con,"update mens_texto set origen = '$idea' where origen = '$row[0]'");
				}
			}
		}
	}
	
	$n=0;
	$query = mysqli_query($db_con,"select distinct destino from mens_texto where destino not like 'Departamento%' and destino not like 'Equipo Educativo%' and destino not like 'CA%' and destino not like 'ETCP%' and destino not like 'Claustro%' and destino not like 'Equipo Directivo%' and destino not like 'Biling%' and destino not like '' and destino not like '; '");
	
	while ($row = mysqli_fetch_array($query)) {
		$idea = "";
		$trozos = explode("; ",$row[0]);
		foreach ($trozos as $nombre){
		if (strlen($row[0])>10) {		
		$query1 = mysqli_query($db_con,"select idea from departamento_tmp where nombre = '$nombre'");
		if (mysqli_num_rows($query1)>0) {	
		$row1 = mysqli_fetch_array($query1);
		$idea.=$row1[0]."; ";
				}
			}
		}
		if ($idea!=="") {
			$n++;
			mysqli_query($db_con,"update mens_texto set destino = '$idea' where destino = '$row[0]'");
		}
	}
	
	mysqli_query($db_con,"drop table departamento_tmp");
	
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Idea en Mensajes', NOW())");
	
	unset($idea);
	unset($n);
}


/*
 @descripcion: Integración de la tabla Jornada en la tabla Tramos.
 @fecha: 18 de agosto de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Eliminacion tabla jornada'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Eliminacion tabla jornada', NOW())");
	
	$query_j = mysqli_query($db_con,"select hora_inicio from tramos");
	if (mysqli_num_rows($query_j)>0) {	}
	else{
		mysqli_query($db_con,"ALTER TABLE `tramos` ADD `hora_inicio` VARCHAR(5) NOT NULL , ADD `hora_fin` VARCHAR(5) NOT NULL");
	}
}

/*
 @descripcion: Modificación Tabla listafechorias
 @fecha: 27 de agosto de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Tabla listafechorias'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Tabla listafechorias', NOW())");
	
	mysqli_query($db_con, "ALTER TABLE `listafechorias` CHANGE `ID` `ID` INT(4) NOT NULL AUTO_INCREMENT;");
	
}

/*
 @descripcion: Informes de tutoría - Nuevo campo motivo
 @fecha: 5 de octubre de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Informes de tutoría - Nuevo campo motivo'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Informes de tutoría - Nuevo campo motivo', NOW())"); 
 	mysqli_query($db_con, "ALTER TABLE `infotut_alumno` ADD `motivo` VARCHAR(255) NULL");
}

/*
 @descripcion: Tabla Usuarioalumno - Aumento de longitid del campo (5 a 64)
 @fecha: 10 de octubre de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Usuarioalumno - actualizacion campo unidad'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Usuarioalumno - actualizacion campo unidad', NOW())"); 
	
	mysqli_query($db_con,"ALTER TABLE `usuarioalumno` CHANGE `unidad` `unidad` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT ''");
	
	$cambio0 = mysqli_query($db_con, "select claveal, unidad, apellidos, nombre from alma");
	while($cambio = mysqli_fetch_array($cambio0)){
		$f_cambio0 = mysqli_query($db_con, "select unidad from usuarioalumno where claveal = '$cambio[0]'");
		$f_cambio = mysqli_fetch_array($f_cambio0);
		if($cambio[1] == $f_cambio[0]){}
		else{
			mysqli_query($db_con, "update usuarioalumno set unidad = '$cambio[1]' where claveal = '$cambio[0]'");
		}	
	}
}

/*
 @descripcion: Tabla FALTAS - Aumento de longitud del campo CODASI (5 a 10)
 @fecha: 4 de noviembre de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Tabla FALTAS - Aumento de longitud del campo CODASI'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Tabla FALTAS - Aumento de longitud del campo CODASI', NOW())"); 
	
	if (file_exists(INTRANET_DIRECTORY . '/config_datos.php')) {
		$anio_escolar = substr($config['curso_actual'], 0, 4)-1;
		
		while ($config['db_host_c'.$anio_escolar] != "") {
			$db_con = mysqli_connect($config['db_host_c'.$anio_escolar], $config['db_user_c'.$anio_escolar], $config['db_pass_c'.$anio_escolar], $config['db_name_c'.$anio_escolar]);
			
			mysqli_query($db_con, "ALTER TABLE `FALTAS` CHANGE `CODASI` `CODASI` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NULL DEFAULT NULL;");
			
			mysqli_close($db_con);
			
			$anio_escolar--;
		}
		
		$db_con = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
		
		mysqli_query($db_con, "ALTER TABLE `FALTAS` CHANGE `CODASI` `CODASI` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NULL DEFAULT NULL;");
	}
	else {
		mysqli_query($db_con, "ALTER TABLE `FALTAS` CHANGE `CODASI` `CODASI` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NULL DEFAULT NULL;");
	}
}

/*
 @descripcion: Tabla FALTAS - Correción regular de error de código de asignatura vacía (hasta confirmar que error ha desaparecido, como parece)
 @fecha: 28 de noviembre de 2015
 */
$hoy= date('Y-m-d');
$tr_dia = explode("-",$hoy);
$n_dia = date('N', mktime(0, 0, 0, $tr_dia[1], $tr_dia[2], $tr_dia[0]));
$n_hora = date('G');

if($config['mod_asistencia']=="1" and $n_dia = "1" and $n_hora = "8") { 
	$result_falta = mysqli_query($db_con, "SELECT distinct claveal, hora, dia, unidad FROM FALTAS WHERE codasi = '' ORDER BY fecha DESC");
	while($row_falta = mysqli_fetch_array($result_falta)){
		$claveal = $row_falta['claveal'];
		$dia = $row_falta['dia'];
		$unidad = $row_falta['unidad'];
		$hora = $row_falta['hora'];
		$sin_cod=mysqli_query($db_con,"select c_asig from horw_faltas where dia='$dia' and hora='$hora' and a_grupo like '$unidad%'");
		while ($sin_codigo = mysqli_fetch_array($sin_cod)) {
			$asig_nene = mysqli_query($db_con,"select combasi from alma where claveal = '$claveal' and combasi like '%$sin_codigo[0]:%'");
			if (mysqli_num_rows($asig_nene)>0) {
				$codigo_asignatura=$sin_codigo[0];
				$num++;
				mysqli_query($db_con,"update FALTAS set codasi = '$codigo_asignatura' where claveal = '$claveal' and hora = '$hora' and dia = '$dia'");
				break;
			}
		}
	}
	echo $num;
}

/*
 @descripcion: Modificación temas - Standard y Yeti
 @fecha: 30 de noviembre de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Modificación temas - Standard y Yeti'");
if (! mysqli_num_rows($actua)) {
	mysqli_query($db_con, "UPDATE temas SET tema = 'temas/bootstrap.min-standard.css' WHERE tema = 'temas/bootstrap.min.standard.css'");
	mysqli_query($db_con, "UPDATE temas SET tema = 'temas/bootstrap.min-yeti.css' WHERE tema = 'temas/bootstrap.min-jeti.css'");
	
	unlink(INTRANET_DIRECTORY . '/css/temas/bootstrap.min.standard.css');
	unlink(INTRANET_DIRECTORY . '/img/temas/standard.png');
	
	unlink(INTRANET_DIRECTORY . '/css/temas/bootstrap.min-jeti.css');
	unlink(INTRANET_DIRECTORY . '/css/temas/jeti.png');
	
	mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Modificación temas - Standard y Yeti', NOW())"); 
}

/*
 @descripcion: Eliminar del horario grupos seleccionados del Cuaderno en los que no impartimos clase a ningún alumno.
 @fecha: 11 de Diciembre de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Borrar grupos seleccionados sin alumnos del horario'");
if (! mysqli_num_rows($actua)) {
$hor = mysqli_query($db_con, "select distinct profesor, asignatura, curso, id from grupos where alumnos=''");
while($hor_profe = mysqli_fetch_array($hor)){

	// Varios códigos de asignatura en Bachillerato
		$bach1 = mysqli_query($db_con,"select nomcurso from unidades, cursos where unidades.idcurso=cursos.idcurso and nomunidad='$hor_profe[2]'");
		$bach2 = mysqli_fetch_array($bach1);
		if (stristr($bach2[0], "Bachill")==TRUE) {
			$asig1 = mysqli_query($db_con,"select codigo from asignaturas, unidades, cursos where unidades.idcurso=cursos.idcurso and nomcurso=asignaturas.curso and nomunidad='$hor_profe[2]' and nombre = (select distinct nombre from asignaturas where codigo = '".$hor_profe[1]."' and abrev not like '%\_%')");
			$asig2 = mysqli_fetch_array($asig1);
			$asignatura=$asig2[0];
		}

	mysqli_query($db_con, "delete from horw where prof = '$hor_profe[0]' and c_asig = '$hor_profe[1]' and a_grupo = '$hor_profe[2]'");
	mysqli_query($db_con, "delete from horw_faltas where prof = '$hor_profe[0]' and c_asig = '$hor_profe[1]' and a_grupo = '$hor_profe[2]'");
	mysqli_query($db_con, "delete from grupos where id = '$hor_profe[3]'");
	}
mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Borrar grupos seleccionados sin alumnos del horario', NOW())"); 
}

/*
 @descripcion: cambiar estructura de la tabla profesores_seneca para simplificarla Y actualizar nombre de profesores en Horw.
 @fecha: 28 de Diciembre de 2015
 */
$actua = mysqli_query($db_con, "SELECT modulo FROM actualizacion WHERE modulo = 'Estructura tabla profesores_seneca'");
if (! mysqli_num_rows($actua)) {
mysqli_query($db_con,"ALTER TABLE `profesores_seneca` CHANGE `nomprofesor` `nomprofesor` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL;");

// Cambiamos el nombre de los profesores de Horw para ajustarlos a Séneca.	
	$nom_prof = mysqli_query($db_con, "select ape1profesor, ape2profesor, nomprofesor, idprofesor from profesores_seneca");
	while($nom_profe = mysqli_fetch_row($nom_prof)){
		$nombre_profesor = "$nom_profe[0] $nom_profe[1], $nom_profe[2]";
		mysqli_query($db_con,"update profesores_seneca set nomprofesor = '$nombre_profesor' where idprofesor = '$nom_profe[3]'");
	}

// Borramos campos innecesarios
mysqli_query($db_con,"ALTER TABLE `profesores_seneca` DROP `ape1profesor`");
mysqli_query($db_con,"ALTER TABLE `profesores_seneca` DROP `ape2profesor`");

// Cambiamos el nombre de los profesores de Horw para ajustarlos a Séneca.
$hor0 = mysqli_query($db_con, "select distinct c_prof, prof from horw order by prof");
while($hor_profe0 = mysqli_fetch_array($hor0)){
	
	$nom_prof0 = mysqli_query($db_con, "select nomprofesor from profesores_seneca where idprofesor = '$hor_profe0[0]'");
	$nom_profe0 = mysqli_fetch_row($nom_prof0);
	mysqli_query($db_con,"update horw set prof = '$nom_profe0[0]' where c_prof = '$hor_profe0[0]'");
	mysqli_query($db_con,"update horw_faltas set prof = '$nom_profe0[0]' where c_prof = '$hor_profe0[0]'");
	mysqli_query($db_con,"update profesores set profesor = '$nom_profe0[0]' where profesor = '$hor_profe0[1]'");
}

mysqli_query($db_con,"delete from profesores where nivel='' or grupo=''");
mysqli_query($db_con, "INSERT INTO actualizacion (modulo, fecha) VALUES ('Estructura tabla profesores_seneca', NOW())"); 
}
