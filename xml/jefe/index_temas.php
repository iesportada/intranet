<?php
require('../../bootstrap.php');

if (isset($_POST['tema'])) {
			
	if ($_POST['fondo']=="1") {
				$p_fondo = 'navbar-inverse';
			}
	else{
				$p_fondo = 'navbar-default';
			}
			
if (empty($_POST['tema'])) {
		$_SESSION ['tema']="bootstrap.min.css";
		$_POST ['tema']="bootstrap.min.css";
	}
			
	$res = mysqli_query($db_con, "select distinct tema, fondo from temas where idea = '".$_SESSION['ide']."'" );
		
	if (mysqli_num_rows($res)>0) {
		
		//$ro = mysqli_fetch_array ( $res );

			mysqli_query($db_con,"update temas set tema='".$_POST['tema']."', fondo='".$p_fondo."' where idea='".$_SESSION['ide']."'");		
	}
	else{
			mysqli_query($db_con,"insert into temas (idea, tema, fondo) VALUES ('".$_SESSION['ide']."','".$_POST['tema']."', '".$p_fondo."')");
	}
		
	$_SESSION ['tema'] = $_POST['tema'];
		
	$_SESSION ['fondo'] = $p_fondo;
	
	if (isset($_GET['tour']) && $_GET['tour']) {
		header('Location:'.'../../index.php?tour=1');
	}
	else {
		$mens = '<div class="alert alert-success">El tema se ha modificado correctamente. Comprueba los cambios.</div>';
	}

}

include("../../menu.php");
?>

<div class="container">

	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Cambiar tema de la aplicación</h2>
	</div>
	
	<?php echo $mens; ?>

	<!-- SCAFFOLDING -->
	<div class="row">
		
			<div class="col-sm-6">

				<div class="well">
					
					<form action="" method="post" enctype="multipart/form-data">
						<fieldset>
							
							<div class="form-group">
								<label for="tema">Selecciona el tema</label>
								<select class="form-control" id="tema" name="tema">
									<optgroup label="Temas de la aplicación">
										<?php $d = dir("../../css/temas/"); ?>
										<?php while (false !== ($entry = $d->read())): ?>
										<?php if (stristr($entry,".css")==TRUE and !($entry=="bootstrap.min.css")): ?>
										<option value="temas/<?php echo $entry; ?>" <?php echo (stristr($_SESSION ['tema'],$entry)==TRUE) ? 'selected' : ''; ?>><?php echo $entry; ?></option>
										<?php endif; ?>
										<?php endwhile; ?>
										<?php $d->close(); ?>
									</optgroup>
									<optgroup label="Tema por defecto">
										<option value="bootstrap.min.css" <?php echo ($_SESSION ['tema']=="bootstrap.min.css") ? 'selected' : ''; ?>>bootstrap.min.css</option>
									</optgroup>
								</select>
							</div>
							
							<div class="checkbox">
								<label>
									<input type="checkbox" name="fondo" value="1" <?php if($_SESSION ['fondo']=="navbar-inverse"){echo "checked";}?>>
									Invertir colores de la Barra de Navegación
								</label>
							</div>
							
							
							<input type="submit" name="submit" value="Cambiar tema" class="btn btn-primary">
							<?php if (isset($_GET['tour']) && $_GET['tour']): ?>
							<a href="../../index.php?tour=1" class="btn btn-default">Omitir</a>
							<?php endif; ?>
							
							
						</fieldset>
						
						<br>
					
						<p class="help-block">El aspecto que presentan las páginas de la Intranet puede ser 
						modificado mediante temas. La aplicación contiene un conjunto de temas que modifican 
						los distintos elementos que constituyen su presentación visual: el tipo de letra, los 
						fondos, botones, etiquetas, colores de los distintos elementos, barra de navegación, 
						etc. Puedes probar los distintos temas que suministramos seleccionando uno de ellos 
						de la lista desplegable, pulsando el botón para enviar los datos y observando los 
						cambios. Puedes cambiar de tema tantas veces como quieras ya que no afecta al 
						funcionamiento de la Intranet.</p>
					</form>
			
				</div><!-- /.well -->
		
			</div><!-- /.col-sm-6 -->
			
			<div class="col-sm-6">
				
				<img id="theme-preview" class="img-thumbnail" src="../../img/temas/intranet.png" alt="">
				
			</div>
	
	</div><!-- /.row -->

</div><!-- /.container -->

	<?php include("../../pie.php");	?>
	
	<script>
	$('#tema').on({
	    'click': function(){
	    		var tema = $('#tema').val();
					if (tema != 'bootstrap.min.css') {
		    		var exp_tema = tema.split('-');
		    		var name = exp_tema[1].replace('.css','.png');
		    	}
		    	else {
		    		var name = 'intranet.png';
		    	}
	    		
	        $('#theme-preview').attr('src','../../img/temas/' + name);
	    }
	});
	</script>
	
</body>
</html>