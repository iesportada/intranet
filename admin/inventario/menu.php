<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}else{$departamento="";}
if (isset($_GET['familia'])) {$familia = $_GET['familia'];}elseif (isset($_POST['familia'])) {$familia = $_POST['familia'];}else{$familia="";}
if (isset($_GET['clase'])) {$clase = $_GET['clase'];}elseif (isset($_POST['clase'])) {$clase = $_POST['clase'];}else{$clase="";}
if (isset($_GET['lugar'])) {$lugar = $_GET['lugar'];}elseif (isset($_POST['lugar'])) {$lugar = $_POST['lugar'];}else{$lugar="";}
if (isset($_GET['descripcion'])) {$descripcion = $_GET['descripcion'];}elseif (isset($_POST['descripcion'])) {$descripcion = $_POST['descripcion'];}else{$descripcion="";}
if (isset($_GET['marca'])) {$marca = $_GET['marca'];}elseif (isset($_POST['marca'])) {$marca = $_POST['marca'];}else{$marca="";}
if (isset($_GET['modelo'])) {$modelo = $_GET['modelo'];}elseif (isset($_POST['modelo'])) {$modelo = $_POST['modelo'];}else{$modelo="";}
if (isset($_GET['serie'])) {$serie = $_GET['serie'];}elseif (isset($_POST['serie'])) {$serie = $_POST['serie'];}else{$serie="";}
if (isset($_GET['unidades'])) {$unidades = $_GET['unidades'];}elseif (isset($_POST['unidades'])) {$unidades = $_POST['unidades'];}else{$unidades="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['eliminar'])) {$id = $_GET['eliminar'];}elseif (isset($_POST['eliminar'])) {$eliminar = $_POST['eliminar'];}else{$eliminar="";}
if (isset($_GET['enviar'])) {$enviar = $_GET['enviar'];}elseif (isset($_POST['enviar'])) {$enviar = $_POST['enviar'];}else{$enviar="";}
if (isset($_GET['crear'])) {$crear = $_GET['crear'];}elseif (isset($_POST['crear'])) {$crear = $_POST['crear'];}else{$crear="";}
if (isset($_GET['buscar'])) {$buscar = $_GET['buscar'];}elseif (isset($_POST['buscar'])) {$buscar = $_POST['buscar'];}else{$buscar="";}
if (isset($_GET['expresion'])) {$expresion = $_GET['expresion'];}elseif (isset($_POST['expresion'])) {$expresion = $_POST['expresion'];}else{$expresion="";}

$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'introducir.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'buscar.php')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE){ $activo3 = ' class="active" ';}
?>
        <div class="container">
        <div class="tabbable">
          <ul class="nav nav-tabs">

     <li <?php echo $activo1;?>><a href="introducir.php">Introducir / Listar registros</a></li>
<?php
if ($j_s == '') {
?>    
     <li <?php echo $activo2;?>> <a href="buscar.php">Buscar / Consultar / Imprimir</a></li>
<?php
}
?>
     <?php
     if(stristr($_SESSION ['cargo'],'1') == TRUE){?>
     <li <?php echo $activo3;?>><a href="index.php">Seleccionar Departamento</a></li>
     <?php }?>
    </ul>
        </div>
        </div>