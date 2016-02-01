<?php
if(isset($_POST['enviar']) and $_POST['enviar']=="Introducir datos"){
include("intextos2.php");
exit;
}

require('../../bootstrap.php');


if (stristr ( $_SESSION ['cargo'], '4' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { } else { $j_s = '1'; }


include("../../menu.php");
if (isset($_GET['titulo'])) {$titulo = $_GET['titulo'];}elseif (isset($_POST['titulo'])) {$titulo = $_POST['titulo'];}else{$titulo="";}
if (isset($_GET['asignatura'])) {$asignatura = $_GET['asignatura'];}elseif (isset($_POST['asignatura'])) {$asignatura = $_POST['asignatura'];}else{$asignatura="";}

if(stristr($_SESSION['cargo'],'4') == TRUE or stristr($_SESSION['cargo'],'1') == FALSE)
    {
    	$departamento = $_SESSION['dpt'];
    }
    else{	
		if (isset($_GET['departamento'])) {$departamento = $_GET['departamento'];}
		elseif (isset($_POST['departamento'])) {$departamento = $_POST['departamento'];}
		else{$departamento="";}
    }    
  
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['editorial'])) {$editorial = $_GET['editorial'];}elseif (isset($_POST['editorial'])) {$editorial = $_POST['editorial'];}else{$editorial="";}
if (isset($_GET['isbn'])) {$isbn = $_GET['isbn'];}elseif (isset($_POST['isbn'])) {$isbn = $_POST['isbn'];}else{$isbn="";}
if (isset($_GET['ano'])) {$ano = $_GET['ano'];}elseif (isset($_POST['ano'])) {$ano = $_POST['ano'];}else{$ano="";}
if (isset($_GET['autor'])) {$autor = $_GET['autor'];}elseif (isset($_POST['autor'])) {$autor = $_POST['autor'];}else{$autor="";}
if (isset($_GET['NOTAS'])) {$NOTAS = $_GET['NOTAS'];}elseif (isset($_POST['NOTAS'])) {$NOTAS = $_POST['NOTAS'];}else{$NOTAS="";}
if (isset($_GET['obligatorio'])) {$obligatorio = $_GET['obligatorio'];}elseif (isset($_POST['obligatorio'])) {$obligatorio = $_POST['obligatorio'];}else{$obligatorio="";}
if (isset($_GET['clase'])) {$clase = $_GET['clase'];}elseif (isset($_POST['clase'])) {$clase = $_POST['clase'];}else{$clase="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}

include 'menu.php';
?>

<div class="container">
<div class="page-header">
  <h2>Libros de texto <small>Registro de libros</small></h2>
</div>
<div class="container">
<div class="row">
<?php 
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'4') == TRUE)
{ 
?>
<div class="col-sm-6 col-sm-offset-3">	
<div class="well well-lg" align="left">
  <legend>Selecciona el Curso y los Grupos</legend>
<hr>
    <form method="post" action="intextos.php" >
    
 <div class="form-group">
  <label>
  Nivel</label>
    <select name="nivel" id="select4" onChange="submit()" class="form-control">
      <?php
 if(isset($_POST['nivel']))
        {
        $nivel = $_POST['nivel'];
        echo "<option>$nivel</option>";}
		else{echo "<option></option>";}
  $tipo = "select distinct curso from alma order by curso";
  $tipo1 = mysqli_query($db_con, $tipo);
  while($tipo2 = mysqli_fetch_array($tipo1))
        {
$completo = $tipo2[0];
echo "<option>$completo</option>";
}
?>
    </select>
</div>
     </form>
     <form method="post" action="intextos.php">   
<div class="form-group">
     <label>Grupos</label>
<br>
      <input name="ano" type="hidden" value="<?php 
// Cosas de la Fecha
$fecha = (date("Y"));
echo $fecha;
?>" size="4" maxlength="4">
      <?	
//$cur = explode(" --> ",$nivel);					
$tipo0 = "select distinct unidad from alma where curso = '$nivel' order by unidad";
$tipo10 = mysqli_query($db_con, $tipo0);
$ng = "";
  while($tipo20 = mysqli_fetch_array($tipo10))
        {	
$ng++;        	
echo "<div class='checkbox-inline'><label>";
echo "<input name='grupo$ng' type='checkbox' id='$tipo20[0]' value='$tipo20[0]' checked><span class='badge badge-info'>$tipo20[0]</span></label></div>&nbsp;&nbsp;";
        }
						
	?>
</div>
    <input name="nivel" type="hidden" value="<?php echo $nivel;?>">
    <legend>Datos del Libro de
      Texto</legend>
<div class="form-group">
    <label>T&iacute;tulo <span style="color:#9d261d"> (*)</span></label>
      <input name="titulo" type="text" id="titulo" class="form-control" value="<?php echo $titulo; ?>" required>
    </div>
    
    <div class="form-group">
    <label>Autor</label>
      <input name="autor" type="text" id="autor" class="form-control" value="<?php echo $autor; ?>">
</div>
<div class="form-group">    
    <label>Editorial<span style="color:#9d261d"> (*)</span></label>
      <input name="editorial" type="text" id="editorial" class="form-control" value="<?php echo $editorial; ?>" required>
</div> 
<div class="form-group">   
    <label>Departamento<span style="color:#9d261d"> (*)</span></label>
    <?php
    if(stristr($_SESSION['cargo'],'4') == TRUE and stristr($_SESSION['cargo'],'1') == FALSE)
    {
    ?>
        <input type="text" name="departamento" id="departamento"  value ="<?php echo  $departamento;?>" readonly class="form-control">
    
    <?	
    }
    else{
    ?>
    <select name="departamento" id="departamento"  value =" value="<?php echo $departamento; ?>"" onChange="submit()"  class="form-control" required>
        <option>
        <?php  echo $departamento;?>
        </option>
        <?php
  $profe = mysqli_query($db_con, " SELECT distinct departamento FROM departamentos, profesores where departamento not like 'admin' and departamento not like 'Administracion' and departamento not like 'Conserjeria' order by departamento asc");
  while($filaprofe = mysqli_fetch_array($profe))
	{

	$departamen = $filaprofe[0]; 
	$opcion1 = printf ("<OPTION>$departamen</OPTION>");
	echo "$opcion1";
	} 
	?>
      </select>
      <?php } ?>
    </div>
    
<div class="form-group">
    <label>Asignatura <span style="color:#9d261d"> (*)</span></label>
      <select name="asignatura" id="asignatura" class="form-control"  value="<?php echo $asignatura; ?>" required>
        <option>
        <?php
   // Datos de la Asignatura
  $asignatur = mysqli_query($db_con, "SELECT DISTINCT asignaturas.NOMBRE, ABREV FROM asignaturas, departamentos, profesores where asignaturas.nombre=profesores.materia and profesores.profesor=departamentos.nombre and curso = '$nivel' and departamento like '$departamento%' ORDER BY NOMBRE asc"); 
        while($fasignatur = mysqli_fetch_array($asignatur)) {
		if(strstr($fasignatur[1],"_"))	{ }

		else{ 
	      echo"<OPTION>$fasignatur[0]</OPTION>";
	     }
	} 
	?>
        </option>
      </select>
    </div>
    
    <div class="form-group">
    <label>Tipo de Libro</label>
      <select name="clase" class="form-control">
        <option>Texto</option>
        <option>Lectura</option>
      </select>
     </div> 
     
     <div class="form-group">
      <select name="obligatorio" class="form-control" >
        <option>Obligatorio</option>
        <option>Recomendado</option>
      </select>
    </div>

<div class="form-group">    
    <label>ISBN<span style="color:#9d261d"> (*)</span></label>
      <input name="isbn" type="text" id="isbn" class="form-control" value="<?php echo $isbn; ?>" required>
    </div>
    
<div class="form-group">    <label>Observaciones</label>
      <textarea name="NOTAS" class="form-control" rows="6"> <?php echo $NOTAS; ?></textarea>
    </div>
    <p class="help-block"><span style="color:#9d261d">(*)</span> Campos obligatorios del formulario.</p>
    <hr />
    <input type="submit" name="enviar" value="Introducir datos" size=15 maxlength=25 alt="Introducir" class="btn btn-primary btn-block">
  </form>
  </div>
  </div>
 </div>
 </div>
 </div>
 <?php
}
?>
	<?php include("../../pie.php"); ?>
	
</body>
</html>

