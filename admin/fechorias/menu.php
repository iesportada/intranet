<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

$activo1="";
$activo2="";
$activo3="";
$activo4="";
$activo5="";
$activo6="";
$activo7="";
if (strstr($_SERVER['REQUEST_URI'],'cfechorias.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infechoria.php')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'lfechorias.php')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'expulsados.php')==TRUE){ $activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'convivencia.php')==TRUE){ $activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'lfechorias3')==TRUE){ $activo6 = ' class="active" ';}
?>
<div class="container">
<div class="tabbable">
<ul class="nav nav-tabs">

	<li <?php echo $activo1;?>><a
		href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/cfechorias.php">
	Consultar Problemas</a></li>
	<li <?php echo $activo2;?>><a
		href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/infechoria.php">
	Registrar Problema</a></li>
	<li <?php echo $activo3;?>><a
		href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/lfechorias.php">
	Últimos Problemas</a></li>
	<li <?php echo $activo4;?>><a
		href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/expulsados.php">
	Alumnos expulsados</a></li>

	<li
		class="dropdown<?php echo (strstr($_SERVER['REQUEST_URI'],'lfechorias3')==TRUE) ? ' active' : ''; ?>">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Ranking <span
		class="caret"></span> </a>
	<ul class="dropdown-menu" role="menu">
		<li><a href="lfechorias3.php">General</a></li>
		<li><a href="lfechorias3b.php">Tras última Expulsión del Centro</a></li>
	</ul>
	</li>
	<?php
	$pr_conv = $_SESSION['profi'];
	$conv = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo like '%b%' AND nombre = '$pr_conv'");
	// echo "select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr'";
	if (mysqli_num_rows($conv) > '0') {
		?>
	<li <?php echo $activo5;?>><a
		href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/convivencia.php">A.T.I. Profes</a></li>
	<?php
	}
	?>
	<?php
	if(stristr($_SESSION['cargo'],'1') == TRUE){
		?>
	<li <?php echo $activo5;?>><a
		href="//<?php echo $config['dominio']; ?>/intranet/admin/fechorias/convivencia_jefes.php">A.T.I. Jefatura</a></li>
	<?php
	}
	?>

</ul>
</div>
</div>

