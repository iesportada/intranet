<?php
require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE) and !(stristr($_SESSION['cargo'],'8') == TRUE) and !(stristr($_SESSION['cargo'],'d') == TRUE))
{
	header('Location:'.'http://'.$config['dominio'].'/intranet/salir.php');
	exit;
}
?>

</BODY>
</HTML>