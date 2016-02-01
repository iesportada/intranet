<?php
if(isset($_POST['padres']))
{
include("padres.php");
exit;
}

require('../../bootstrap.php');


include("../../menu.php");
include("../../faltas/menu.php");
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (isset($_GET['fecha12'])) {$fecha12 = $_GET['fecha12'];}elseif (isset($_POST['fecha12'])) {$fecha12 = $_POST['fecha12'];}else{$fecha12="";}
if (isset($_GET['fecha22'])) {$fecha22 = $_GET['fecha22'];}elseif (isset($_POST['fecha22'])) {$fecha22 = $_POST['fecha22'];}else{$fecha22="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}

?>
<div class="container">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Informe para los Padres</small></h2>
</div>
<br />

  <form enctype='multipart/form-data' action='cpadres.php' method='post'>
<div class="row">
  <div class="col-sm-4 col-sm-offset-2">
   <div class="well well-large">        
        <h4>Selecciona el Grupo</h4><br />
          <div class="form-group">
           <select  name="unidad" class="form-control" onChange="submit()">
            <option><?php echo $unidad;?></option>
            <?php
unidad($db_con);
?>
</select>
            </div>
<hr>
            <h4>
        Selecciona los Alumnos...</h4><br />
                    <div class="form-group">
          <select name="nombre[]" multiple class="form-control" style="height:560px;">
            <?php 
$alumno = mysqli_query($db_con, " SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE unidad like '$unidad%'  order by APELLIDOS asc");
  while($falumno = mysqli_fetch_array($alumno))
        {
	      echo "<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>";

        }
	?>
    </select>
    
         </div>
         
         
       </div>
       </div>
<div class="col-sm-4">
 
  <div class="well well-large">
          <?php
	$fecha32 = date('d')."-".date('m')."-".date('Y');
  $tr = explode("-",$config['curso_inicio']);
  $inicio = "$tr[2]-$tr[1]-$tr[0]";
?>
         <h4> Rango de fechas</h4><br />      
         <label> Inicio: </label>
      <div class="form-group"  id="datetimepicker1">
      <div class="input-group">
            <input name="fecha12" type="text" class="form-control" data-date-format="DD/MM/YYYY" id="fecha12" value="<?php if($fecha12){ echo $fecha12;}?>" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>
<label>Fin: </label>
	<div class="form-group"  id="datetimepicker2">
 <div class="input-group">
  <input name="fecha22" type="text" class="form-control" data-date-format="DD/MM/YYYY" id="fecha22" value="<?php if($fecha22){ echo $fecha22;}?>" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
 </div>
</div> 
      
                     <div class="form-group">
          <label>
        N&uacute;mero m&iacute;nimo
            de Faltas&nbsp;</label>
            <input name="numero" type="text" value="1" class="form-control" maxlength="3" alt="Mes" />
          </div>
          <input name="padres" type="submit" id="padres" value='Enviar Datos' class="btn btn-primary" />
       </div>
         </div>
         </div>
</form>

        <?php	
include("../../pie.php");
?>   

	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datetimepicker2').datetimepicker({
			language: 'es',
			pickTime: false
		});
	});  
	</script>
</body>
</html>
