<?php
require('../../bootstrap.php');


if (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];} elseif (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];} else{$grupo="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];} elseif (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];} else{$nombre="";}
if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];} elseif (isset($_GET['apellidos'])) {$apellidos = $_GET['apellidos'];} else{$apellidos="";}
if (isset($_GET['clave_al'])) {$claveal = $_GET['clave_al'];}
if (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
	$AUXSQL = " and unidad = '$unidad'";
} else{$unidad="";}

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
?>

<div class="container">
	
	<div class="page-header">
		<h2>Datos de los alumnos <small>Consultas</small></h2>
	</div>
	

	<div class="row">
	
		<div class="col-sm-12">
<?php
// Si se envian datos desde el campo de búsqueda de alumnos, se separa claveal para procesarlo.
if (!(isset($_GET['seleccionado']))) {
	$seleccionado="";
}else{
	$seleccionado=$_GET['seleccionado'];
}
if (!(isset($_GET['alumno']))) {
	$alumno="";
}
else{
	$alumno=$_GET['alumno'];
}
if (!(isset($AUXSQL))) {
	$AUXSQL="";
}

//Reseteamos Clave en la página principal
if (isset($_GET['resetear']) and $_GET['resetear']==1) {
	$sql_reset=mysqli_query($db_con, "delete from control where claveal = '".$_GET['clavealumno']."'");
	if ($sql_reset) {
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La contraseña del alumno para el acceso a la página pública del Centro se ha reiniciado correctamente. El alumno debe entrar ahora con el NIE como usuario y contraseña. Una vez dentro se le forzará a cambiar la contraseña.
		</div></div>';    
		if (strstr($_GET['correo'],'@')==TRUE) {
		$direccion = $_GET['correo'];
		$tema = "Contraseña de acceso privado reiniciada en ".$config['dominio'];
		$texto = "La clave de acceso privada del alumno/a ha sido reiniciada. Para entrar en las páginas personales del alumno deberás introducir de nuevo el NIE (Número de Identificación Escolar) que el Centro te ha proporcionado en los dos campos del formulario de acceso. Si a pesar de todo persisten los problemas y no puedes entrar, ponte en contacto con el Tutor o Jefatura de Estudios. Gracias. ";
		mail($direccion, $tema, $texto);  
		}  
	}
}

// Borramos alumno de la base de datos
if (isset($_GET['borrar']) and $_GET['borrar']==1) {
	mysqli_query($db_con, "delete from control where claveal = '".$_GET['clavealumno']."'");
	mysqli_query($db_con, "delete from FALUMNOS where claveal = '".$_GET['clavealumno']."'");
	mysqli_query($db_con, "delete from usuarioalumno where claveal = '".$_GET['clavealumno']."'");
	mysqli_query($db_con, "delete from alma where claveal = '".$_GET['clavealumno']."'");
	if (mysqli_affected_rows($db_con)>0) {
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
		El alumno ha sido eliminado correctamente de la Base de datos.
		</div></div>';  
	}
}

$d_table="datatable";

if (isset($seleccionado) and $seleccionado=="1") {
	$d_table="";
	$tr=explode(" --> ",$alumno);
	$claveal=$tr[1];
	$nombre_al=$tr[0];
	$uni=mysqli_query($db_con, "select unidad from alma where claveal='$claveal'");
	$un=mysqli_fetch_array($uni);
	$unidad=$un[0];
}
$AUXSQL == "";
if  (TRIM("$apellidos")==""){}else{	$AUXSQL .= " and alma.apellidos like '%$apellidos%'";}
if  (TRIM("$nombre")==""){}else{ $AUXSQL .= " and alma.nombre like '%$nombre%'";}
if  (isset($_POST['unidad'])){ 
	$AUXSQL=" and (";
	foreach ($_POST['unidad'] as $grupo){
		$AUXSQL .= " alma.unidad like '$grupo' or";
	}
	$AUXSQL=substr($AUXSQL,0,-2);
	$AUXSQL.=")";
}
if  (TRIM("$claveal")==""){}else{ $AUXSQL .= " and alma.claveal = '$claveal'";}
if ($seleccionado=='1') { $AUXSQL = " and alma.claveal = '$claveal'";}

$SQL = "select distinct alma.claveal, alma.apellidos, alma.nombre, alma.unidad, 
  alma.DNI, alma.fecha, alma.dni, alma.telefono, alma.telefonourgencia, padre, matriculas, correo from alma
  where 1 " . $AUXSQL . " order BY unidad, alma.apellidos, nombre";
 //echo $SQL;
$result = mysqli_query($db_con, $SQL);

if ($row = mysqli_fetch_array($result))
{

	echo "<table class='table table-bordered table-striped table-vcentered $d_table'>";
	echo "<thead><tr>
			<th></th>
			<th>Alumno/a</th>
	        <th>NIE</th>
	        <th>Unidad</th>
	        <th>Fecha Ncto.</th>	        
	        <th>DNI</th>
        	<th>Padre</th>
        	<th>Teléfonos</th>	
        	<th>Repite</th>";
	echo "<th></th>";
	echo "</tr></thead><tbody>";
	do {
		if ($row[10]>1) {
			$repite="Sí";
		}
		else{
			$repite="No";
		}
		$nom=$row[1].", ".$row[2];
		$unidad = $row[3];
		$claveal = $row[0];
		$correo = $row[12];
		$alumno = "$nom --> $claveal";
		
		echo "<tr>";
	if($_POST['sin_foto']=="1" or isset($_GET['unidad']) or $seleccionado==1){
		$foto_dir = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto_dir)) {
		$foto = "<img src='$foto_dir' width='55' class=\"img-thumbnail\" />";
	}
	else {
		$foto = "<span class=\"fa fa-user fa-3x fa-fw\"></span>";
	}
	}
	else{
	$foto='';
	}
	echo "<td>$foto</td><td>$nom</td>
			<td>$row[0]</td>
			<td>$unidad</td>
			<td>$row[5]</td>
			<td>$row[6]</td>
			<td>$row[9]</td>
			<td>$row[7]</td>
			<td>$repite</td>";

		if ($seleccionado=='1'){
			$todo = '&todos=Ver Informe Completo del Alumno';
		}
		echo "<td style='width:100px'>";
		echo '<div class="btn-group hidden-print">
 	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
     <span class="fa fa-user fa-fw"></span>
     <span class="caret"></span>
   </button>
  <ul class="dropdown-menu dropdown-menu-right">';

echo "<li><a href='//".$config['dominio']."/intranet/admin/informes/index.php?claveal=$claveal&todos=Ver Informe Completo'><i class='fa fa-search fa-fw'></i> Informe completo</a></li>";
echo "<li><a href='//".$config['dominio']."/intranet/admin/informes/cinforme.php?nombre_al=$alumno&unidad=$unidad'><i class='fa fa-calendar fa-fw'></i> Informe histórico</a></li>";
echo "<li><a href='../fechorias/infechoria.php?seleccionado=1&nombre=$claveal'><i class='fa fa-bug fa-fw'></i> Problema de disciplina</a></li>";
echo "<li><a href='//".$config['dominio']."/intranet/admin/cursos/horarios.php?curso=$unidad&claveal=$claveal'><i class='fa fa-calendar-o fa-fw'></i> Horario</a></li>";

// Comprobamos si el centro cuenta con módulo de la página principal para el acceso de los alumnos
	$sql_control = mysqli_query($db_con, "select * from control where claveal = '$claveal'");
	if (mysqli_num_rows($sql_control)>0) {
		$s_control = '1';
	}

// Menú personalizado
	if (stristr($_SESSION['cargo'],'2') == TRUE ){
		$tutor = $_SESSION['profi'];
		$dat = mysqli_query($db_con, "select unidad from FALUMNOS where claveal='$claveal'");
		$dat_tutor = mysqli_query($db_con, "select unidad from FTUTORES where tutor='$tutor'");
		$tut=mysqli_fetch_row($dat);
		$tut2=mysqli_fetch_array($dat_tutor);
		$unidad=$tut[0];
		$unidad_tutor=$tut2[0];
		if ($unidad==$unidad_tutor) {
			echo "<li><a href='../tutoria/intervencion.php?seleccionado=1&alumno=$alumno&unidad=$unidad&tutor=$tutor'><i class='fa fa-edit fa-fw'></i> Intervención de Tutoría</a></li>";		
		}
		if ($unidad!==$unidad_tutor) {
			$s_control="";
		}
}
	if (stristr($_SESSION['cargo'],'1') == TRUE) {
		$dat = mysqli_query($db_con, "select unidad from FALUMNOS where claveal='$claveal'");
		$tut=mysqli_fetch_row($dat);
		$unidad=$tut[0];
		echo "<li><a href='../jefatura/index.php?seleccionado=1&alumno=$alumno&unidad=$unidad'><i class='fa fa-edit fa-fw'></i> Intervención de Tutoría</a>";
		echo "<li><a href='datos.php?borrar=1&clavealumno=$claveal&seleccionado=1&alumno=$alumno&unidad=$unidad&correo=$correo'  data-bs='tooltip' title='Esta acción borra el alumno de las tablas de alumnos de la Base de datos. Sólo utilizar en caso de una anomalía persistente y bien constatada (cuando el alumno aparece en la importación de datos de Séneca pero es absolutamente seguro que ya no está matriculado en el Centro, por ejemplo). Utilizar esta opción con mucho cuidado.' data-bb='confirm-delete'><i class='fa fa-trash fa-fw'></i>  Borrar alumno</a></li>";	
	}
	if (stristr($_SESSION['cargo'],'8') == TRUE) {
		$dat = mysqli_query($db_con, "select unidad from FALUMNOS where claveal='$claveal'");
		$tut=mysqli_fetch_row($dat);
		$unidad=$tut[0];
		echo "<li><a href='../orientacion/tutor.php?seleccionado=1&alumno=$alumno&unidad=$unidad'><i class='fa fa-edit fa-fw'></i> Intervención de Orientación</a></li>";
	}
	if ($s_control=='1' and (stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'2') == TRUE)) {
			echo "<li><a href='datos.php?resetear=1&clavealumno=$claveal&seleccionado=1&alumno=$alumno&unidad=$unidad&correo=$correo'  data-bs='tooltip' title='Si el alumno o sus padres han olvidado la contraseña de acceso a la página principal, este botón permite reiniciar la contraseña al NIE del alumno. Si el alumno o tutores del mismo han registrado una dirección de correo electrónico, se les enviará un cooreo automaticamente. De lo contrario habrá que ponerse en contacto para hacérselo saber.'><i class='fa fa-refresh fa-fw'></i> Reiniciar contraseña</a></li>";
			}
	

	echo '</td></tr>';
		
	} while($row = mysqli_fetch_array($result));
	echo "</tbody></table>\n";
} else
{
	if ($_GET['borrar']!=="1") {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
		<legend>ATENCIÓN:</legend>
		No hubo suerte, bien porque te has equivocado
        al introducir los datos, bien porque ningún dato se ajusta a tus criterios.
		</div></div>';
	}
}
?> 

<br />
</div>
</div>
</div>

<?php include("../../pie.php"); ?>

	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  		"paging":   true,
	      "ordering": true,
	      "info":     false,
	      
	  		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
	  		
	  		"order": [[ 1, "asc" ]],
	  		
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