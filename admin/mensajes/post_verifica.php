<?php 
require('../../bootstrap.php');

$jsondata = array();

// Verificación lectura de mensajes de profesores
if( isset($_POST['idp']) ) {
		
		$idp = $_POST['idp'];
		
		$result = mysqli_query($db_con, "UPDATE mens_profes SET recibidoprofe='1' WHERE id_profe=$idp LIMIT 1");
		
    if($result) {
        $jsondata['status'] = true;
    } else {
        $jsondata['status'] = false;
    }
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    exit();

}

// Verificación lectura de mensajes de familias
if( isset($_POST['idf']) ) {
		
		$idf = $_POST['idf'];
		
		$result = mysqli_query($db_con, "UPDATE mensajes SET recibidotutor='1' WHERE id=$idf LIMIT 1");
		
    if($result) {
        $jsondata['status'] = true;
    } else {
        $jsondata['status'] = false;
    }
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata);
    exit();

}
?>