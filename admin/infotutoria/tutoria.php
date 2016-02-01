<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); 

if(isset($_GET['ver']) or isset($_POST['ver'])) { 
	include("infocompleto.php");
}

if(isset($_GET['meter']) or isset($_POST['meter'])) { 
	include("informar.php");
}
?>
