<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<h4><span class="fa fa-search fa-fw"></span> Buscar...</h4>

<form method="get" action="admin/noticias/buscar.php">
	<input type="text" class="form-control" name="q" id="buscarAlumnos" onkeyup="javascript:buscar('list_alumnos',this.value);" placeholder="Buscar alumnos, noticias...">
</form>

<div id="list_alumnos"></div>
