<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
?>
<div class="container">
<div class="page-header">
<h2>Libros de Texto <small> Borrar Libro de Texto</small></h2>
</div>

<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<?php
$query = "DELETE FROM Textos WHERE id = '$id'";
$result = mysqli_query($db_con, $query) or die ("Error en la Consulta: $query. " . mysqli_error($db_con));

mysqli_close($connection);

echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			El Libro de Texto ha sido borrado de la Base de datos.
		</div></div>';
?>
 <?php include("../../pie.php");?>		
</body>
</html>
