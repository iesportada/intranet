<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1, 8));

if (isset($_SESSION['mod_tutoria'])) {
	header('Location:'.'index.php');
}


include("../../menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Tutoría <small>Selección de tutoría</small></h2>
		</div>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-6 col-sm-offset-3">
				
				<div class="well">
					
					<form method="post" action="index.php">
						<fieldset>
							<legend>Seleccione tutor</legend>
							
							<div class="form-group">
						    <label for="tutor">Tutores/as de grupo</label>
						    <?php $result = mysqli_query($db_con, "SELECT DISTINCT unidad, tutor FROM FTUTORES ORDER BY unidad ASC"); ?>
						    <?php if(mysqli_num_rows($result)): ?>
						    <select class="form-control" id="tutor" name="tutor">
						    	<?php while($row = mysqli_fetch_array($result)): ?>
						    	<option value="<?php echo $row['tutor'].' ==> '.$row['unidad']; ?>"><?php echo $row['unidad'].' - '.nomprofesor($row['tutor']); ?></option>
						    	<?php endwhile; ?>
						    </select>
						    <?php else: ?>
						    <select class="form-control" id="tutor" name="tutor" disabled>
						    	<option value=""></option> 
						    </select>
						    <?php endif; ?>
						    <?php mysqli_free_result($result); ?>
						  </div>
						  
						  <button type="submit" class="btn btn-primary" name="enviar">Consultar</button>
					  </fieldset>
					</form>
					
				</div><!-- /.well -->
				
			</div><!-- /.col-sm-6 -->
			
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
