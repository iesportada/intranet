<?php
require('../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

include ("../menu.php");
?>
<div class='container'>

	<div class="page-header">
	  <h2>Administración <small> Perfiles de Profesores</small></h2>
	</div>
	
	<?php
	if ($_GET['borrar']=='1') {
		mysqli_query($db_con, "delete from departamentos where dni = '".$_GET['dni_profe']."'");
		echo '<div class="alert alert-success">
	            <button type="button" class="close" data-dismiss="alert">&times;</button>
	            El profesor ha sido borrado de la base de datos..
	          </div>';
	}
	if (isset($_POST['enviar'])) {
	mysqli_query($db_con, "truncate table FTUTORES" );
	mysqli_query($db_con, "truncate table cargos " );
		
		foreach ( $_POST as $dni => $cargo_profe ) {
			if ($cargo_profe == "Enviar") {
				continue;
			} elseif (strlen ( $cargo_profe ) > "1") {
				$dni = substr ( $dni, 0, -2 );
				$n_profe = mysqli_query($db_con, "select nombre from departamentos where dni='$dni'" );
				$n_prof = mysqli_fetch_array ( $n_profe );
				$unidad = $cargo_profe;
				$n_tutor = mb_strtoupper ( $n_prof [0], 'iso-8859-1' );
				
				mysqli_query($db_con, "insert INTO `FTUTORES` ( `unidad` , `tutor` ) VALUES ('$unidad', '$n_tutor')" );
			
			} elseif (strlen ( $cargo_profe ) < "2") {
				$dni=trim($dni);
				mysqli_query($db_con, "update departamentos set cargo = ''" );
				$dni = substr ( $dni, 0, - 1 );
				mysqli_query($db_con, "INSERT INTO `cargos` ( `dni` , `cargo` ) VALUES ('$dni', '$cargo_profe')" );
			}
		}

		$n_cargo = mysqli_query($db_con, "select dni from departamentos" );
		while ( $n_carg = mysqli_fetch_array ( $n_cargo ) ) {
			$num_cargos = "";
			$num_car = mysqli_query($db_con, "select distinct cargo from cargos where dni = '$n_carg[0]'" );
			while ( $num_carg = mysqli_fetch_array ( $num_car ) ) {
				$num_cargos .= $num_carg [0];
			}
			mysqli_query($db_con, "update departamentos set cargo='$num_cargos' where dni='$n_carg[0]'" );
		}
	echo '<div class="alert alert-success">
	Los perfiles han sido asignados correctamente a los profesores.
	          </div>';
	}
	?>
	
  <div class="row">
  	
   <div class="col-sm-12"> 
   
   <style type="text/css">
   thead th {
   	font-size: 0.8em;
   }
   </style>

		<?php
		$head = '<thead>
			<tr>
				<th>Profesor</th>
				<th><span data-bs="tooltip" title="Administradores de la Aplicación">Admin</span></th>
				<th><span data-bs="tooltip" title="Miembros del Equipo Directivo del Centro">Dirección</span></th>
				<th><span data-bs="tooltip" title="Tutores de Grupo de todos los niveles">Tutor</span></th>
				<th><span data-bs="tooltip" title="Tutores de faltas de asistencia. Estos tutores se encargan de pasar a la Intranet las faltas que los profesores registran en su parte personal (Administracción de la Intranet --> Faltas de Asistencia -> Horario de faltas para profesores), que entregan los viernes en Jefatura o Conserjería. ">Faltas</span></th>
				<th><span data-bs="tooltip" title="Jefes de los distintos Departamentos que el IES ha seleccionado.">JD</span></th>
				<th><span data-bs="tooltip" title="Miembros del Equipo Técnico de Coordinación Pedadgógica">ETCP</span></th>
				<th><span data-bs="tooltip" title="Miembro del departamento de Actividades Complementarias y Extraescolares.">DACE</span></th>
				<th><span data-bs="tooltip" title="Miembros del personal de Administracción y Servicios: Conserjes.">Conserje</span></th>
				<th><span data-bs="tooltip" title="Miembros del personal de Administracción y Servicios: Administrativos">Administ.</span></th>
				<th><span data-bs="tooltip" title="Todos los profesores que pertenecen al Equipo de Orientación, incluídos ATAL, Apoyo, PCPI, etc.">Orienta.</span></th>';
		if($config['mod_bilingue']) $head .= '<th><span data-bs="tooltip" title="Profesores que participan en el Plan de Bilinguismo">Bilingüe</span></th>';
		$head .= '<th><span data-bs="tooltip" title="Profesores encargados de atender a los alumnos en el Aula de Convivencia del Centro, si este cuenta con ella.">Conv.</span></th>';
		if($config['mod_biblioteca']) $head .= '<th><span data-bs="tooltip" title="Profesores que participan en el Plan de Bibliotecas o se encargan de llevar la Biblioteca del Centro">Biblio.</span></th>';
		$head .= '<th><span data-bs="tooltip" title="Profesor encargado de las Relaciones de Género">Género</span></th>
				<th>&nbsp;</th>
			</tr>
			</thead>';
		?>
		
		<form name="cargos" action="cargos.php" method="post">
		
		<p class="help-block">
			Si necesitas información sobre los distintos perfiles de los profesores, puedes conseguirla colocando el cursor del ratón sobre los distintos tipos de perfiles.
		</p>
		
		<div class="table-responsive">
		<table class="table table-bordered table-striped table-condensed">
		<?php echo $head;?>
			<tbody>
		<?php
		$carg0 = mysqli_query($db_con, "select distinct nombre, cargo, dni, idea from departamentos order by nombre" );
		$num_profes = mysqli_num_rows ( $carg0 );
		while ( $carg1 = mysqli_fetch_array ( $carg0 ) ) {
			$pro = $carg1 [0];
			$car = $carg1 [1];
			$dni = $carg1 [2];
			$idea = $carg1 [3];
			$n_i = $n_i + 10;
			if ($n_i%"100"=="0") {
				echo $head;
			}
			?>
		<tr>
				<td nowrap><small><?php
			echo $pro;
			?></small>
			</td>
			
			<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>0"
					value="0" <?php
			if (stristr ( $car, '0' ) == TRUE) {
				echo "checked";
			}
			if ($idea == "admin") {
				echo "disabled";
			}
			?>
					id="dato0" /></td>
					
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>1"
					value="1" <?php
			if (stristr ( $car, '1' ) == TRUE) {
				echo "checked";
			}
			?>
					id="dato0" /></td>
				<td class="form-inline" nowrap><input type="checkbox" name="<?php
			echo $dni;
			?>2"
					value="2" id="dato0"
					<?php
			if (stristr ( $car, '2' ) == TRUE) {
				echo "checked";
			}
			?> /> <select class="form-control" style="width: 100px;"
					name="<?php
			echo $dni;
			?>2t">
		  <?php
			$curso_tut = mysqli_query($db_con, "select unidad from FTUTORES, departamentos where tutor=nombre and dni='$dni'" );
			$curso_tut0 = mysqli_fetch_array ( $curso_tut );
			$unidad = $curso_tut0 [0];
			?>
		  <option><?php
		  if (strlen($unidad) > '1') {
		  		echo $unidad;
		  }
			?></option>
		<?php
			echo "<option></option>";
			$tipo = "select distinct unidad from alma order by unidad";
			$tipo1 = mysqli_query($db_con, $tipo );
			while ( $tipo2 = mysqli_fetch_array ( $tipo1 ) ) {
				echo "<option>" . $tipo2 [0] . "</option>";
			}
			
			?>
		  </select></td>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>3"
					value="3" id="dato0"
					<?php
			if (stristr ( $car, '3' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>4"
					value="4" id="dato0"
					<?php
			if (stristr ( $car, '4' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>9"
					value="9" id="dato0"
					<?php
			if (stristr ( $car, '9' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>5"
					value="5" id="dato0"
					<?php
			if (stristr ( $car, '5' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>6"
					value="6" id="dato0"
					<?php
			if (stristr ( $car, '6' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>7"
					value="7" id="dato0"
					<?php
			if (stristr ( $car, '7' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>8"
					value="8" id="dato0"
					<?php
			if (stristr ( $car, '8' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php if($config['mod_bilingue']) { ?>
				<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>9"
					value="a" id="dato0"
					<?php
			if (stristr ( $car, 'a' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php } ?>
			<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>10"
					value="b" id="dato0"
					<?php
			if (stristr ( $car, 'b' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php if($config['mod_biblioteca']) { ?>
			<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>11"
					value="c" id="dato0"
					<?php
			if (stristr ( $car, 'c' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php } ?>
			<td class="text-center"><input type="checkbox" name="<?php
			echo $dni;
			?>11"
					value="d" id="dato0"
					<?php
			if (stristr ( $car, 'd' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<td class="text-center"><a href="cargos.php?borrar=1&dni_profe=<?php echo $dni;?>" data-bb='confirm-delete'><span class="fa fa-trash-o fa-lg fa-fw"></span></a></td>
			</tr>
		<?php
			}
		?>
		</tbody>
		</table>
		</div>

	<button type="submit" class="btn btn-primary" name="enviar">Guardar cambios</button>
	<a class="btn btn-default" href="../xml/index.php">Volver</a>
</form>
            </div></div></div>
<?php include("../pie.php");?>
</body>
</html>
