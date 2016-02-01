<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<div class="container hidden-print"><?php if (strstr($_SESSION['cargo'],'1') == TRUE || strstr($_SESSION['cargo'],'8') == TRUE): ?>
<form method="post" action="">
<div class="pull-right"><?php $result = mysqli_query($db_con, "SELECT DISTINCT FTUTORES.unidad, tutor, curso FROM FTUTORES, alma where alma.unidad=FTUTORES.unidad ORDER BY FTUTORES.unidad ASC"); ?>
<?php if(mysqli_num_rows($result)): ?> <select
	class="form-control input-sm" id="tutor" name="tutor"
	onchange="submit()" style="width:280px;">
	<?php while($row = mysqli_fetch_array($result)): $curso_tutor=$row[2];?>
	<option value="<?php echo $row['tutor'].' ==> '.$row['unidad']; ?>"
	<?php echo ($_SESSION['mod_tutoria']['tutor'].' ==> '.$_SESSION['mod_tutoria']['unidad'] == $row['tutor'].' ==> '.$row['unidad']) ? 'selected' : ''; ?>><?php echo $row['unidad'].' - '.nomprofesor($row['tutor']); ?></option>
	<?php endwhile; ?>
</select> <?php else: ?> <select class="form-control" id="tutor"
	name="tutor" disabled>
	<option value=""></option>
</select> <?php endif; ?> <?php mysqli_free_result($result); ?></div>
</form>
	<?php endif; ?>
<?php
$result2 = mysqli_query($db_con, "SELECT DISTINCT curso FROM alma where unidad= '".$_SESSION['mod_tutoria']['unidad']."'");
$query2= mysqli_fetch_array($result2);
$curso_tutor=$query2[0]; 
?>
<ul class="nav nav-tabs hidden-print">
	<li
	<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) ? ' class="active"' : ''; ?>><a
		href="index.php">Resumen</a></li>
	<li
	<?php echo (strstr($_SERVER['REQUEST_URI'],'intervencion.php')==TRUE) ? ' class="active"' : ''; ?>><a
		href="intervencion.php">Intervenciones</a></li>
		<li	class="dropdown<?php echo (strstr($_SERVER['REQUEST_URI'],'Tutor')==TRUE) ? ' active' : ''; ?>">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Menú de Tutoría <span
		class="caret"></span> </a>
	<ul class="dropdown-menu" role="menu">
		<li><a href="../datos/datos.php?unidad=<?php echo $_SESSION['mod_tutoria']['unidad'] ?>">Datos de alumnos/as</a></li>
		<li><a href="../cursos/ccursos.php?unidad=<?php echo $_SESSION['mod_tutoria']['unidad']; ?>&submit1=1" target="_blank">Listado de alumnos/as</a></li>
		<?php if (isset($config['mod_sms']) && $config['mod_sms']): ?>
		<li><a href="../../sms/index.php?unidad=<?php echo $_SESSION['mod_tutoria']['unidad'];?>">Enviar SMS</a></li>	
		<?php endif; ?>
		<?php if (isset($config['mod_asistencia']) && $config['mod_asistencia']): ?>
		<li><a href="../../faltas/justificar/index.php">Justificar Faltas de Asistencia del Grupo</a></li>	
		<?php endif; ?>
		<li><a href="consulta_fotografias.php">Fotografías de alumnos/as</a></li>
		<li><a href="consulta_mesas.php">Asignación de mesas</a></li>
		<li><a href="../../xml/jefe/form_carnet.php">Credenciales de alumnos</a></li>
		<li><a href="consulta_absentismo.php">Alumnos absentistas</a></li>
		<li class="divider"></li>
		<li><a href="../../admin/actividades/indexextra.php">Actividades Complementarias / Extraescolares</a></li>
		<?php if($_SERVER['SERVER_NAME']=="iesmonterroso.org"): ?>
		<li class="divider"></li>
		<li><a href="http://www.iesmonterroso.net/moodle/course/view.php?id=33"	target="_blank">Moodle de Orientación</a></li>
		<?php endif; ?>
		<?php if($config['centro_provincia']=="Málaga"): ?>
		<li class="divider"></li>
		<li><a href="http://lnx.educacionenmalaga.es/orientamalaga/plan-provincial-2/" target="_blank">Plan Provincial contra el Absentismo Escolar</a></li>
		<?php endif; ?>
	</ul>
	</li>
	<li
		class="dropdown<?php echo (strstr($_SERVER['REQUEST_URI'],'informe_')==TRUE) ? ' active' : ''; ?>">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Informes <span
		class="caret"></span> </a>
	<ul class="dropdown-menu" role="menu">
		<li><a href="../informes/cinforme.php?unidad=<?php echo $_SESSION['mod_tutoria']['unidad']; ?>">Informe de un alumno/a</a></li>
		<li><a href="../infotutoria/index.php">Informes de tutoría</a></li>
		<li><a href="../tareas/index.php">Informes de tareas</a></li>
		<li class="divider"></li>
		
		<?php 
		$inf_t = mysqli_query($db_con,"select idcurso from unidades where nomunidad = '".$_SESSION['mod_tutoria']['unidad']."'"); 
		$id_t = mysqli_fetch_array($inf_t);
		$id_curso = $id_t[0];
		if (strstr($id_curso,"10114")==TRUE or $id_curso=="105806" or $id_curso=="105825"):
		?>
		<li><a href="../tutoria/informe_evaluaciones.php">Informes de Evaluación</a></li>
		<li class="divider"></li>
		<?php endif; ?>
		
		<?php 
		if ($id_curso=="101140"):
		?>
		<li><a href="../matriculas/consulta_transito.php">Informes de Tránsito</a></li>
		<li class="divider"></li>
		<?php endif; ?>
		
		<li><a href="../tutoria/informe_notas_grupo.php?unidad=<?php echo $_SESSION['mod_tutoria']['unidad']; ?>">Estadísticas de Evaluación del Grupo</a></li>
		<li><a href="../tutoria/informe_notas_nivel.php?curso=<?php echo $curso_tutor;?>">Estadísticas de Evaluación del Nivel</a></li>
		<li class="divider"></li>
		<li><a href="informe_memoria.php">Memoria de tutoría</a></li>
	</ul>
	</li>

	<?php if(strstr($curso_tutor,"E.S.O.")==TRUE and date('m') > '06' and date('m') < '10'): ?>
	<li><a
		href="../libros/libros.php?unidad=<?php echo $_SESSION['mod_tutoria']['unidad']; ?>&tutor=1">Libros
	de Texto</a></li>
	<?php endif; ?>
</ul>

</div>
