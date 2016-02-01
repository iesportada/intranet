<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

// TABLAS INTOCABLES
$intocables = array("alma_primaria", "alma_secundaria", "biblioteca","actualizacion","calendario","calendario_categorias", "c_profes", "control", "departamentos", "fotos", "inventario_clases", "inventario", "inventario_lugares", "listafechorias", "matriculas", "matriculas_bach", "matriculas_backup", "matriculas_bach_backup", "mem_dep", "mensajes", "mens_profes", "mens_texto", "noticias", "partestic", "recursos", "reservas", "reservas_tipos", "reservas_elementos", "r_departamento", "temas", "Textos", "textos_gratis", "transito_control". "transito_datos", "transito_tipo");

if (isset($_GET['action']) && ($_GET['action'] == 'bdtruncate')) {
	
	$tablas = mysqli_query($db_con, "SHOW TABLES");
	
	while ($tabla = mysqli_fetch_array($tablas)) {
		
		$protegida = 0;
		
		foreach ($intocables as $notocar) {
			if ($tabla[0] == $notocar) $protegida = 1;
		}
		
		if (! $protegida) {
			mysqli_query($db_con, "TRUNCATE TABLE `".$tabla[0]."`");
		}
	}
	echo 1;
	
}
else {
	
	// Copia de la Base de datos principal para mantener registro de cursos académicos
	$curso_pasado = date('Y');
	$nombre_copia = $config['db_name'].$curso_pasado;
	
	echo '
		<div class="text-center">
		
			<div class="alert alert-info">
	    	Si el servidor de base de datos es propio del centro, a principio de cada curso escolar se crea una copia de la base de datos, <strong><em>'.$config['db_name'].'</em></strong>, con el año del curso escolar añadido al final del nombre (en este caso <strong><em>'.$nombre_copia.'</em></strong>). A continuación, se vacían las tablas adecuadas, aunque se mantienen las que contienen datos persistentes. Una vez completadas estas tareas, comienza la importación de datos de alumnos.
	    </div>
	    
	   </div>
	   
	   <br>';
	
	$result = mysqli_query($db_con, "CREATE DATABASE `".$nombre_copia."`");
	
	if (! $result) {
		echo '
			
				<div class="alert alert-danger">
					<h4>ATENCIÓN:</h4>
					
					Ha surgido un error al crear la nueva base de datos de forma automática. Esto se debe a que estas utilizando la Intranet en un servidor comercial y no tienes privilegios para crear una nueva base de datos. Es importante que no cierre esta página y siga los siguientes pasos para continuar:
					
					<ol>
						<li>Diríjase a la página de gestión de su alojamiento web y cree una nueva base de datos. Apunte los parámetros de conexión: <strong>servidor</strong>, <strong>usuario</strong>, <strong>contraseña</strong> y <strong>nombre de la base de datos</strong>.</li>
						<li>Realice una <a href="copia_db/index.php" class="alert-link" target="_blank">copia de seguridad</a> de la base de datos actual.</li>
						<li>Descargue la copia de seguridad que ha generado.</li>
						<li>Importe la copia de seguridad en la nueva base de datos. Para ello, el proveedor de alojamiento web, suele ofrecer una herramienta de Administración de Bases de datos como PHPMyAdmin.</li>
						<li>Una vez importado los datos, modifique la configuración de la base de datos en <a href="../../config/config.php" class="alert-link" target="_blank">Configuración general y módulos</a> por los nuevos parámetros.</li>
						<li>Haga click en <em>Continuar</em> e importe de nuevo los datos.</li>
					</ol>
					
					<a href="index2.php?action=bdtruncate" class="btn btn-primary">Continuar</a>
					
				</div>
				
			</div>
		</div>
		</div>
		</div>
		';
		include('../../pie.php');
		echo '
		<script>
		function espera() {
			document.getElementById("wrap").style.display = \'\';
			document.getElementById("status-loading").style.display = \'none\';        
		}
		window.onload = espera;
		</script>
		
		</body>
		</html>
		';
		exit();
	}
	else {
				
		$tablas = mysqli_query($db_con, "SHOW TABLES");
		
		while ($tabla = mysqli_fetch_array($tablas)) {
		
			// COPIA DEL CONTENIDO
			mysqli_query($db_con, "CREATE TABLE `".$nombre_copia."`.`".$tabla[0]."` SELECT * FROM `".$config['db_name']."`.`".$tabla[0]."`");
			
			$protegida = 0;
			
			foreach ($intocables as $notocar) {
				if ($tabla[0] == $notocar) $protegida = 1;
			}
			
			if (! $protegida) {
				mysqli_query($db_con, "TRUNCATE TABLE `".$tabla[0]."`");
			}
		}
		
	}
	
	
}
?>