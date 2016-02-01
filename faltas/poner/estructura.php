<div class="col-sm-4">
<legend><small> <?php eliminar_mayusculas($profesor); echo $profesor;?> &nbsp;&nbsp;</small></legend><br />
<?php
  if (isset($_SESSION['todo_profe'])) {
		  $trozos = explode("_ ",$_SESSION['todo_profe']) ;
		  $id = $trozos[0];
		  $profesor = $trozos[1];     	
		  echo "";
          	if (!(isset($_SESSION['todo_profe']))) 
			{
			echo "<a href=index.php?year=$year&today=$today&month=$month&id=$id class='btn btn-primary'>Elegir otro Profesor</a>";
          	echo "<br /><br />";
			}
          	echo "<input type=hidden name=profesor value= \"$profesor\">";
          }
          else { 
profesor();
          }
		if (isset($registro)) {
			echo '<div align="left""><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Las Faltas de Asistencia han sido registradas.
          </div></div>';
		}
		if (isset($mens1)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens1.'</div></div>';
		}
		if (isset($mens2)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens2.'</div></div>';
		}
		if (isset($mens3)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens3.'</div></div>';
		}
		if (isset($mens4)) {
			echo '<div align="left""><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_4.'</div></div>';
		}
		if (isset($fiesta)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$fiesta.'</div></div>';
		}
		if (isset($mens_fecha)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_fecha.'</div></div>';
		}				
		?>
                 
                 <?php
				  
                  include("cal.php"); 
                  ?>                   
</div>
<div class="col-sm-8">

<?php          
            echo "<input type=hidden name=today value= \"$today\">";
			echo "<input type=hidden name=year value= \"$year\">";
			echo "<input type=hidden name=month value= \"$month\">";
echo "<legend align='center'><small class='text-uppercase'>Semana:&nbsp;&nbsp;$lunes1 &nbsp;&nbsp;-->&nbsp;&nbsp; $viernes&nbsp;&nbsp;</small></legend><br />";
			            include("profes.php"); 
            ?>
             <div align="center"> 
    <br /><input type="submit" name="enviar" class="btn btn-primary" value="Registrar las faltas de asistencia">
  </div>                   
  </div>
  </div>      

			      <script>
document.form1.profesor.focus()
document.form1.profesor.options[<?php $id = $id; echo $id;?>].selected = true
    </script>
