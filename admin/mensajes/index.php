<?php
require('../../bootstrap.php');



$profesor = $_SESSION['ide'];
$profe_nombre = $_SESSION['profi'];

isset($_GET['inbox']) ? $_buzon = $_GET['inbox'] : $_buzon = 'recibidos';
isset($_GET['delete']) ? $idmensaje = intval($_GET['delete']) : $idmensaje=0;

switch ($_buzon) {
	default:
	case 'recibidos' :
		$page_header = "Mensajes recibidos";
		$active1 = "class=\"active\"";

		if ($idmensaje > 0) {
			$delete = mysqli_query($db_con, "DELETE FROM mens_profes WHERE id_profe='$idmensaje' LIMIT 1") or die (mysqli_error($db_con));
			if($delete) $msg_delete = 1;
		}
		
		$tabla_encabezado = array('De', 'Asunto', 'Fecha', ' ');
		$result = mysqli_query($db_con, "SELECT ahora, asunto, id, origen, id_profe, texto, recibidoprofe FROM mens_profes JOIN mens_texto ON mens_texto.id = mens_profes.id_texto WHERE (profesor = '$profesor' or profesor = '$profe_nombre') ORDER BY ahora DESC LIMIT 0, 500");
		$rec = 1;
		break;
	
	case 'enviados'  :
		$page_header = "Mensajes enviados";
		$active2 = "class=\"active\"";
		
		if ($idmensaje > 0) {
			$delete = mysqli_query($db_con, "UPDATE mens_texto SET oculto='1' WHERE id='$idmensaje' LIMIT 1") or die (mysqli_error($db_con));
			if($delete) $msg_delete = 1;
		}
		
		$tabla_encabezado = array('Para', 'Asunto', 'Fecha', ' ');
		$result = mysqli_query($db_con, "SELECT ahora, asunto, id, destino, id, texto FROM mens_texto WHERE (origen = '$profesor' or origen = '$profe_nombre') AND oculto NOT LIKE '1' ORDER BY ahora DESC LIMIT 0, 500");
		break;
}

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");
?>


<div class="container">
  
  <div class="page-header">
    <h2>Mensajes <small><?php echo $page_header; ?></small></h2>
  </div>
  
  <div class="row">
    
    <!-- MENSAJES -->
    <div class="col-sm-12">
    
      <!-- Mensaje eliminado -->
      <?php if(isset($msg_delete) && $msg_delete==1): ?>
      <div class="alert alert-success alert-fadeout">
        El mensaje ha sido eliminado.
      </div>
      <?php endif; ?>
      
      <!-- Mensaje enviado -->
      <?php if($_GET['action']=='send'): ?>
      <div class="alert alert-success alert-fadeout">
        El mensaje ha sido enviado correctamente.
      </div>
      <?php endif; ?>
      
      <!-- Mensaje enviado -->
      <?php if($_GET['action']=='exceeded'): ?>
      <div class="alert alert-danger alert-fadeout">
        Ha excedido el tiempo para editar el mensaje.
      </div>
      <?php endif; ?>
      
      <style class="text/css">
        a.link-msg, a.link-msg:hover { color: #444; display: block; text-decoration:none; }
      </style>
      
      <table class="table table-striped table-hover datatable">
        <thead>
          <tr>
            <?php $i=0; while ($tabla_encabezado[$i] != FALSE): ?>
            	<th><?php echo $tabla_encabezado[$i]; $i++ ?></th>
            <?php endwhile; ?>
          </tr>
        </thead>
        <tbody>
        <?php 
        while($row = mysqli_fetch_array($result)):
        $texto = htmlentities($row[5]);
        
        if(strpos($texto,'a href')) $pos = true;
        elseif(strpos($texto,'img src')) $pos = true;
        elseif(strpos($texto,'iframe src')) $pos = true;
        else $pos=false;
        
        $_buzon=='recibidos' ? $leido = $row[6] : $leido=1;
        ?>
          <tr> 
            <td width="25%"><?php if(!$leido) echo '<strong>'; ?><a class="link-msg" href="mensaje.php?id=<?php echo $row[2]; ?>&idprof=<?php echo $row[4]; ?>"><?php 
            $n_p = str_ireplace("; ","",$row[3]);
            
            $numero = trim(substr($n_p,strlen($n_p)-3,strlen($n_p)));
            
            if(is_numeric(trim($n_p))){           	
            $real = "";	
            $trozos = explode("; ",$row[3]);	
            foreach($trozos as $val){
            $query0 = mysqli_query($db_con,"select nombre, apellidos from alma where claveal = '$val'");
			$row0 = mysqli_fetch_array($query0);
            $real.=$row0[0]." ". $row0[1]."; ";           
            }
            $dest = substr($real,0,-2);
            }            
            elseif(is_numeric($numero)) {
            $real = "";	
            $trozos = explode("; ",$row[3]);	
            foreach($trozos as $val){
            $query0 = mysqli_query($db_con,"select nombre from departamentos where idea = '$val'");
			$row0 = mysqli_fetch_array($query0);
            $real.=$row0[0]."; ";           
            }
            $dest = substr($real,0,-2);
            }
            else{
            $dest = $row[3];
            }
            if (strlen($dest)>150) {
            	$dest = substr($dest,0,150)."...";
            }
            echo $dest;
            ?><?php if(!$leido) echo '</strong>'; ?></a></td>        
            <td width="55%"><?php if(!$leido) echo '<strong>'; ?><a class="link-msg" href="mensaje.php?id=<?php echo $row[2]; ?>&idprof=<?php echo $row[4]; ?>"><?php echo $row[1]; if($pos !== false) echo ' <span class="pull-right fa fa-paperclip fa-lg"></span>'; ?></a><?php if(!$leido) echo '</strong>'; ?></td>
            <td width="15%" data-order="<?php echo $row[0]; ?>" nowrap><?php if(!$leido) echo '<strong>'; ?><a class="link-msg" href="mensaje.php?id=<?php echo $row[2]; ?>&idprof=<?php echo $row[4]; ?>"><?php echo $row[0]; ?></a><?php if(!$leido) echo '</strong>'; ?></td>
            <td width="5%" nowrap>
            	<?php $num_seg = (strtotime(date('Y-m-d H:i:s')) - strtotime($row[0])) * 60; ?>
            	<?php if ($_buzon=='enviados' && $num_seg <= (60 * 60)): ?>
            	<a href="redactar.php?id=<?php echo $row[4] ;?>" data-bs="tooltip" title="Editar"><span class="fa fa-edit fa-fw fa-lg"></span></a>
            	<?php endif; ?>
            	<a href="?inbox=<?php echo $_buzon; ?>&delete=<?php echo $row[4] ;?>" data-bb="confirm-delete"  data-bs="tooltip" title="Eliminar"><span class="fa fa-trash-o fa-fw fa-lg"></span></a>
            </td>
          </tr>
      	<?php endwhile; ?>
      	</tbody>
      </table>
    </div>
    
  </div>
  
  <br>
  <br>

</div>

<?php include("../../pie.php"); ?>

<script>
$(document).ready(function() {
	$('.alert-fadeout').delay(5000).fadeOut('slow');
	
  var table = $('.datatable').DataTable({
  		"paging":   true,
      "ordering": true,
      "info":     false,
      
  		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
  		
  		"order": [[ 2, "desc" ]],
  		
  		"language": {
  		            "lengthMenu": "_MENU_",
  		            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
  		            "info": "Página _PAGE_ de _PAGES_",
  		            "infoEmpty": "No hay resultados disponibles.",
  		            "infoFiltered": "(filtrado de _MAX_ resultados)",
  		            "search": "Buscar: ",
  		            "paginate": {
  		                  "first": "Primera",
  		                  "next": "Última",
  		                  "next": "",
  		                  "previous": ""
  		                }
  		        }
  	});
});
</script>
   
</body>
</html>