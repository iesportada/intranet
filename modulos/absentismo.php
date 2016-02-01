<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');

echo "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>&times;</button><p class='lead'><i class='fa fa-bell'> </i> Informes de Absentismo</p><hr />";

while ($ausente=mysqli_fetch_array($result0)) {	
	echo "<p><a href='./faltas/absentismo/index2.php?claveal=$ausente[0]&mes=$ausente[6]&inf=1' class='alert-link'>";
	echo "$ausente[1], $ausente[2] ($ausente[3])";
	echo ($ausente[4] > 1) ? ' Repetidor' : '';
	echo "<span class='pull-right fa fa-pencil fa-fw fa-lg' data-bs='tooltip' title='Rellenar'></span></a></p>";
}
?>
</div>
