<?php
require('../../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

$profe = $_SESSION['profi'];
$msg = $_GET['msg'];

// ELIMINAR ITEM
if(isset($_GET['eliminar'])) {
	if ($id = intval($_GET['eliminar'])) {
		mysqli_query($db_con, "DELETE FROM listafechorias WHERE id=$id");
		$msg = "La regla ha sido eliminada";
	}
}

include("../../../menu.php");
?>

<div class="container">

	<div class="page-header">
	  <h2 style="display:inline">ROF <small>Administración de Reglas de Organización y Funcionamiento</small></h2>
	  
	  <!-- Button trigger modal -->
		<a href="#"class="btn btn-default btn-sm pull-right hidden-print" data-toggle="modal" data-target="#modalAyuda">
			<span class="fa fa-question fa-lg"></span>
		</a>
	
		<!-- Modal -->
		<div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modal_ayuda_titulo" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
						<h4 class="modal-title" id="modal_ayuda_titulo">Instrucciones de uso</h4>
					</div>
					<div class="modal-body">
						<p>El registro de Problemas de Convivencia supone que las Conductas Negativas de los 
						alumnos han sido definidas y organizadas en categorías. Estas conductas, a su vez, son 
						las que aparecen en el ROF del Centro, y se clasifican en función de la gravedad de 
						los hechos (Leve, Grave y Muy Grave). La lista más abajo presenta las Conductas Negativas 
						o Problemas de Convivencia de nuestro Centro, y por eso debe ser adaptada al Centro en 
						el que se instala la Intranet. La edición, modificación y eliminación de las Conductas 
						contra las normas del Centro es fundamental para que los profesores puedan registrar 
						los Problema de Convivencia en el marco del reglamento propio de cada I.E.S.</p>
						
						<p>La edición de una regla o la creación de una nueva nos presenta un formulario con 
						cuatro campos. El <strong>Asunto</strong> debe contener el enunciado conciso y preciso 
						de la Conducta Negativa del alumno o alumnos. El campo <strong>Medida</strong> indica 
						la acción emprendida por el profesor o Jefe de Estudios en relación a la Conducta. La 
						<strong>Medida Complementaria</strong> precisa el contenido de la <strong>Medida</strong> 
						que debe ser tomada con el alumno. La <strong>Gravedad</strong> clasifica la Conducta 
						dentro de tres categorías: <em>Leve, Grave y Muy Grave</em>.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="row">
	
		<div class="col-sm-12">
		  
		  <?php 
		  if($msg) {
		   echo "<div class=\"alert alert-success\">\n";
		   if($msg=="update") $msg = "La regla ha sido modificada";
		   if($msg=="insert") $msg = "La regla ha sido añadida";
		   echo "  $msg.";
		   echo "</div>\n";
		  }
		  ?>
		  
		  <table class="table table-hover table-bordered">
		    <thead>
		      <tr>
		        <th>Asunto</th>
		        <th>Medida</th>
		        <th>Medida complementaria</th>
		        <th></th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    $result = mysqli_query($db_con, "SELECT DISTINCT tipo FROM listafechorias");
		    
		    while ($tipos = mysqli_fetch_array($result)) {
		    	$tipo = $tipos[0];
		    	
		    	echo "<tr class=\"info\">\n";
		    	echo "  <td colspan=\"4\"><strong>$tipo</strong></td>\n";
		    	echo "</tr>\n";
		    	
		    	$result2 = mysqli_query($db_con, "SELECT id, fechoria, medidas, medidas2 FROM listafechorias WHERE tipo='$tipo' ORDER BY id");
		    	
		    	while ($fechoria = mysqli_fetch_array($result2)) {
		    		$id = $fechoria[0];
		    		
		    		echo "<tr>\n";
		    		echo "  <td>$fechoria[1]</td>\n";
		    		echo "  <td>$fechoria[2]</td>\n";
		    		echo "  <td>$fechoria[3]</td>\n";
		    		echo "  <td nowrap>\n";
		    		echo "    <a href=\"regla.php?id=$id\" rel=\"tooltip\" title=\"Editar\"><span class=\"fa fa-pencil-square-o fa-fw fa-lg\"></span></a>\n";
		    		echo "    <a href=\"index.php?eliminar=$id\" data-bb=\"confirm-delete\" rel=\"tooltip\" title=\"Eliminar\"><span class=\"fa fa-trash-o fa-fw fa-lg\"></span></a>\n";
		    		echo "  </td>\n";
		    		echo "</tr>\n";
		    	}
		    }
		    
		    ?>
		    </tbody>
		  </table>
		  
		  <a class="btn btn-primary" href="regla.php">Nueva regla</a>
		  <a class="btn btn-default" href="../../index.php">Volver</a>
		  
		</div><!-- /.col-sm-12 -->
		
	</div><!-- /.row -->

</div><!-- /.container -->

<?php include("../../../pie.php"); ?>
</body>
</html>
