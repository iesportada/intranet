<?php
require('../../bootstrap.php');

$pr = $_SESSION['profi'];

if (isset($_POST['profes'])) {
	$profes = $_POST['profes'];
} 
elseif (isset($_GET['profes'])) {
	$profes = $_GET['profes'];
} 

$_SESSION['msg_block'] = 0;

if($_POST['token']) $token = $_POST['token'];
if(!isset($token)) $token = time(); 

$profeso = $_POST['profeso'];
$tutores = $_POST['tutores'];
$tutor = $_POST['tutor'];
$departamentos = $_POST['departamentos'];
$departamento = $_POST['departamento'];
$equipos = $_POST['equipos'];
$equipo = $_POST['equipo'];
$claustro = $_POST['claustro'];
$etcp = $_POST['etcp'];
$ca = $_POST['ca'];
$direccion = $_POST['direccion'];
$orientacion = $_POST['orientacion'];
$bilingue = $_POST['bilingue'];
$biblio = $_POST['biblio'];
$profesor = $_POST['profesor'];

if (isset($_POST['padres'])) {
	$padres = $_POST['padres'];
} 
elseif (isset($_GET['padres'])) {
	$padres = $_GET['padres'];
} 
else
{
$padres="";
}
if (isset($_POST['asunto'])) {
	$asunto = htmlspecialchars($_POST['asunto'], ENT_QUOTES, 'ISO-8859-1');
} 
elseif (isset($_GET['asunto'])) {
	$asunto = htmlspecialchars($_GET['asunto'], ENT_QUOTES, 'ISO-8859-1');
} 
else
{
$asunto="";
}
if (isset($_POST['texto'])) {
	$texto = htmlspecialchars($_POST['texto'], ENT_QUOTES, 'ISO-8859-1');
} 
elseif (isset($_GET['texto'])) {
	$texto = htmlspecialchars($_GET['texto'], ENT_QUOTES, 'ISO-8859-1');
} 
if (isset($_POST['origen'])) {
	$origen = $_POST['origen'];
} 
elseif (isset($_GET['origen'])) {
	$origen = $_GET['origen'];
} 
else
{
$origen="";
}


$verifica = $_GET['verifica'];
if($verifica){
 mysqli_query($db_con, "UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$verifica'");
}

if (isset($_GET['id'])) {
	
	if (isset($_POST['submit1'])) {
		$result = mysqli_query($db_con, "UPDATE mens_texto SET asunto='$asunto', texto='$texto' WHERE id=".$_GET['id']." LIMIT 1");
		
		if(!$result) {
			$msg_error = "No se ha podido editar el mensaje. Error: ".mysqli_error($db_con);
			$_SESSION['msg_block'] == 0;
		}
		else {
			unset($_SESSION['msg_block']);
			header('Location:'.'index.php?inbox=recibidos&action=send');
			exit;
		}
	}
	
	$result = mysqli_query($db_con, "SELECT ahora, asunto, texto, destino FROM mens_texto WHERE id=".$_GET['id']."");
	if (mysqli_num_rows($result)) {
		$row = mysqli_fetch_array($result);
		
		$ahora = $row['ahora'];
		$asunto = htmlspecialchars($row['asunto']);
		$texto = htmlspecialchars($row['texto']);
		$destino = trim($row['destino']);
		
		$num_seg = (strtotime(date('Y-m-d H:i:s')) - strtotime($ahora)) * 60;
		if ($num_seg > (60 * 60)) {
			header('Location:'.'index.php?inbox=enviados&action=exceeded');
		}
		
		$bloq_destinatarios = 1;
	}
	else {
		unset($_GET['id']);
	}
	
}
else {
	include("profesores.php");
}

include('../../menu.php');
include('menu.php');
$page_header = "Redactar mensaje";
?>
	<div class="container">
  	
  	
  	<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
	    <h2>Mensajes <small><?php echo $page_header; ?></small></h2>
	  </div>
	  
	  <!-- MENSAJES -->
	  <?php if (isset($msg_error)): ?>
	  <div class="alert alert-danger">
	  	<?php echo $msg_error; ?>
	  </div>
	  <?php endif; ?>
	  
	  
	  <form id="formMensaje" method="post" action="" name="formulario" onsubmit="return checkAsunto(this);">
	  
	  <!-- SCALLFODING -->
		<div class="row">
    
    	<!-- COLUMNA IZQUIERDA -->
      <div class="col-sm-7">
      
      	<div class="well">
      		
      		<fieldset>
      			<legend>Redactar mensaje</legend>
      			
      			<input type="hidden" name="token" value="<?php echo $token; ?>">
      		
	      		<div class="form-group">
	      			<label for="asunto">Asunto</label>
	      			<input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del mensaje" value="<?php echo (isset($asunto)) ? $asunto : ''; ?>" maxlength="120" required autofocus>
	      		</div>
	      		
	      		<div class="form-group">
	      			<label for="texto" class="sr-only">Contenido</label>
	      			<textarea class="form-control" id="texto" name="texto" rows="10" maxlength="3000"><?php echo (isset($texto) && $texto) ? $texto : ''; ?></textarea>
	      		</div>
	      		
	      		<button type="submit" class="btn btn-primary" name="submit1">Enviar mensaje</button>
	      		<a href="index.php" class="btn btn-default">Volver</a>
      		
      		</fieldset>
      		
      	</div><!-- /.well-->
         
      </div><!-- /.col-sm-7 -->
      
      <!-- COLUMNA DERECHA -->
      <div class="col-sm-5">
      
      	<div id="grupos_destinatarios" class="well">
      		
      		<fieldset>
      			<legend>Grupos de destinatarios</legend>
      			
      			<input type="hidden" name="profesor" value="<?php echo $_SESSION['ide']; ?>">
      			
      			<?php if (!isset($bloq_destinatarios) && !$bloq_destinatarios): ?>
            <div class="row">
            	
            	<!-- COLUMNA IZQUIERDA -->
              <div class="col-sm-6">
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input id="profes" name="profes" type="checkbox" value="1" <?php if($profes=='1' and !$claustro) echo 'checked'; ?>> Personal del Centro
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input id="tutores" name="tutores" type="checkbox" value="1" <?php if($tutores=='1' and !$claustro) echo 'checked'; ?>> Tutores
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input id="departamentos" name="departamentos" type="checkbox" value="1" <?php if($departamentos=='1' and !$claustro) echo 'checked'; ?>> Departamentos
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input id="equipos" name="equipos" type="checkbox" value="1" <?php if($equipos=='1' and !$claustro) echo 'checked'; ?>> Equipos educativos
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input id="claustro" name="claustro" type="checkbox" value="1" <?php if($claustro=='1') echo 'checked'; ?>> Todo el claustro
                		</label>
                	</div>
                </div>
                
                <?php if(isset($config['mod_biblioteca']) && $config['mod_biblioteca']): ?>
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input id="biblio" name="biblio" type="checkbox" value="1" <?php if($biblio=='1' and !$claustro) echo 'checked'; ?>> Biblioteca
                		</label>
                	</div>
                </div>
                <?php endif; ?>
                
              </div>
              
              
              <!-- COLUMNA DERECHA -->
              <div class="col-sm-6">
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input id="etcp" name="etcp" type="checkbox" value="1" <?php if($etcp=='1' and !$claustro) echo 'checked'; ?>> Jefes Departamento
              			</label>
              		</div>
              	</div>
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input id="ca" name="ca" type="checkbox" value="1" <?php if($ca=='1' and !$claustro) echo 'checked'; ?>> Coordinadores Área
              			</label>
              		</div>
              	</div>
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input id="direccion" name="direccion" type="checkbox" value="1" <?php if($direccion=='1' and !$claustro) echo 'checked'; ?>> Equipo directivo
              			</label>
              		</div>
              	</div>
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input id="orientacion" name="orientacion" type="checkbox" value="1" <?php if($orientacion=='1' and !$claustro) echo 'checked'; ?>> Orientación
              			</label>
              		</div>
              	</div>
              	
              	<?php if(isset($config['mod_bilingue']) && $config['mod_bilingue']): ?>
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input id="bilingue" name="bilingue" type="checkbox" value="1" <?php if($bilingue=='1' and !$claustro) echo 'checked'; ?>> Profesores bilingüe
              			</label>
              		</div>
              	</div>
              	<?php endif; ?>

              	<?php if(stristr($_SESSION['cargo'],'1') == TRUE || stristr($_SESSION['cargo'],'2') == TRUE): ?>
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input id="padres" name="padres" type="checkbox" value="1" <?php if($padres=='1' and !$claustro) echo 'checked'; ?>> Familias y alumnos
              			</label>
              		</div>
              	</div>
              <?php endif; ?>
              </div>
              <?php else: ?>
              
              <p class="help-block">
              <?php 
            $n_p = str_ireplace("; ","",$row[3]);
            $numero = trim(substr($n_p,strlen($n_p)-3,strlen($n_p)));
            
            if(is_numeric(trim($n_p))){           	
            $real = "";	
            $trozos = explode("; ",$destino);	
            foreach($trozos as $val){
            $query0 = mysqli_query($db_con,"select nombre, apellidos from alma where claveal = '$val'");
			$row0 = mysqli_fetch_array($query0);
            $real.=$row0[0]." ". $row0[1]."; ";           
            }
            $dest = substr($real,0,-2);
            }            
            elseif(is_numeric($numero)) {
            $real = "";	
            $trozos = explode("; ",$destino);	
            foreach($trozos as $val){
            $query0 = mysqli_query($db_con,"select nombre from departamentos where idea = '$val'");
			$row0 = mysqli_fetch_array($query0);
            $real.=$row0[0]."; ";           
            }
            $dest = substr($real,0,-2);
            }
            else{
            $dest = $n_p;
            }
            echo $dest;
              ?></p>
              
              <?php endif; ?>
            
      		</fieldset>
      	
      	</div>
      	
				
				<!-- PROFESORES -->
				<div id="grupo_profesores" class="well <?php echo (isset($profes) && !empty($profes)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Selección de Personal</legend>
						
						<?php $s_origen = mb_strtoupper($origen); ?>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre, idea FROM departamentos ORDER BY nombre ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="profeso[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['idea']; ?>;<? echo $row['nombre']; ?>" <?php echo (isset($origen) && mb_strtoupper($origen) == mb_strtoupper($row['idea'])) ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="profeso[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples profesores.</div>
						</div>
						
					</fieldset>
					
				</div>

				<!-- TUTORES -->
				<div id="grupo_tutores" class="well <?php echo (isset($tutores) && !empty($tutores)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Seleccione tutores</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT tutor, unidad, idea FROM FTUTORES, departamentos where tutor = nombre  ORDER BY unidad ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="tutor[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['idea']; ?> --> <?php echo $row['unidad']; ?>-"><?php echo $row['unidad']; ?> - <?php echo $row['tutor']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="tutor[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples tutores.</div>
						</div>
						
					</fieldset>
				</div>
				
				<!-- JEFES DE DEPARTAMENTO -->
				<div id="grupo_departamentos" class="well <?php echo (isset($departamentos) && !empty($departamentos)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Seleccione departamentos</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos where departamento not like 'Admin%' and departamento not like 'Conserje%' ORDER BY departamento ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="departamento[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['departamento']; ?>"><?php echo $row['departamento']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="departamento[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples departamentos.</div>
						</div>
						
					</fieldset>
				</div>
				
				<!-- EQUIPOS EDUCATIVOS -->
				<div id="grupo_equipos" class="well <?php echo (isset($equipos) && !empty($equipos)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Seleccione equipos educativos</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT grupo FROM profesores ORDER BY grupo ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="equipo[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['grupo']; ?>"><?php echo $row['grupo']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="equipo[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples equipos educativos.</div>
						</div>
						
					</fieldset>
				</div>
				
				
				<!-- CLAUSTRO DEL CENTRO -->
				<div id="grupo_claustro" class="well <?php echo (isset($claustro) && !empty($claustro)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Claustro de profesores</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				
				<!-- BIBLIOTECA -->
				<div id="grupo_biblioteca" class="well <?php echo (isset($biblio) && !empty($biblio)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Biblioteca</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%c%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				
				<!-- JEFES DE DEPARTAMENTO -->
				<div id="grupo_etcp" class="well <?php echo (isset($etcp) && !empty($etcp)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Jefes de departamento</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%4%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>				
				
				<!-- COORDINADORES DE AREA -->
				<div id="grupo_coordinadores" class="well <?php echo (isset($ca) && !empty($ca)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Coordinadores de área</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%9%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				
				<!-- EQUIPO DIRECTIVO -->
				<div id="grupo_directivo" class="well <?php echo (isset($direccion) && !empty($direccion)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Equipo directivo</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%1%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				
				<!-- ORIENTACION -->
				<div id="grupo_orientacion" class="well <?php echo (isset($orientacion) && !empty($orientacion)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Orientación</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%8%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>

				<?php if(isset($config['mod_bilingue']) && $config['mod_bilingue']): ?>
				<!-- BILINGÜE -->
				<div id="grupo_bilingue" class="well <?php echo (isset($bilingue) && !empty($bilingue)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Profesores Bilinguismo</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%a%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				<?php endif; ?>
				
				<?php if(stristr($_SESSION['cargo'],'1') == TRUE || stristr($_SESSION['cargo'],'2') == TRUE): ?>
				
				<?php $sql_where = ""; ?>
				
				<?php if(stristr($_SESSION['cargo'],'2')): ?>
					<?php $result = mysqli_query($db_con, "SELECT unidad FROM FTUTORES WHERE tutor='$pr'"); ?>
					<?php $unidad = mysqli_fetch_array($result); ?>
					<?php $unidad = $unidad['unidad']; ?>
					<?php mysqli_free_result($result); ?>
					
					<?php $sql_where = "WHERE unidad='$unidad'"; ?>
				<?php endif; ?>
										
				
				<!-- FAMILIAS Y ALUMNOS -->
				<div id="grupo_padres" class="well <?php echo (isset($padres) && !empty($padres)) ? '' : 'hidden'; ?>">
					
					<fieldset>
						<legend>Familias y alumnos</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT apellidos, nombre, unidad, claveal FROM alma $sql_where ORDER BY unidad ASC, apellidos ASC, nombre ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="padres[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['claveal']; ?>" <?php echo (isset($origen) && $origen == $row['apellidos'].', '.$row['nombre']) ? 'selected' : ''; ?>><?php echo $row['unidad'].' - '.$row['apellidos'].', '.$row['nombre']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="padres[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples alumnos.</div>
						</div>
						
					</fieldset>
				</div>
				
				<?php endif; ?>
				
			</div><!-- /.col-sm-5 -->
			
		</div><!-- /.row -->
		
		</form>
	
	</div><!-- /.container -->
  

<?php include("../../pie.php"); ?>
	
	<script>
	
	$(document).ready(function() {
		
		// Campos visibles

			//Personal
			$('#profes').change(function() {
				if(profes.checked==true) {
					$('#grupo_profesores').removeClass('hidden');
				}
				else {
					$('#grupo_profesores').addClass('hidden');
				}
			});

			// Tutores
			$('#tutores').change(function() {
				if(tutores.checked==true) {
					$('#grupo_tutores').removeClass('hidden');
				}
				else {
					$('#grupo_tutores').addClass('hidden');
				}
			});

			// Departamentos
			$('#departamentos').change(function() {
				if(departamentos.checked==true) {
					$('#grupo_departamentos').removeClass('hidden');
				}
				else {
					$('#grupo_departamentos').addClass('hidden');
				}
			});

			// Equipos
			$('#equipos').change(function() {
				if(equipos.checked==true) {
					$('#grupo_equipos').removeClass('hidden');
				}
				else {
					$('#grupo_equipos').addClass('hidden');
				}
			});

			//Claustro
			$('#claustro').change(function() {
				if(claustro.checked==true) {
					$('#grupo_claustro').removeClass('hidden');
					$('#profes').prop('disabled', true);
					$('#tutores').prop('disabled', true);
					$('#departamentos').prop('disabled', true);
					$('#equipos').prop('disabled', true);
					$('#biblio').prop('disabled', true);
					$('#etcp').prop('disabled', true);
					$('#ca').prop('disabled', true);
					$('#direccion').prop('disabled', true);
					$('#orientacion').prop('disabled', true);
					$('#bilingue').prop('disabled', true);
					$('#padres').prop('disabled', true);
				}
				else {
					$('#grupo_claustro').addClass('hidden');
					$('#profes').prop('disabled', false);
					$('#tutores').prop('disabled', false);
					$('#departamentos').prop('disabled', false);
					$('#equipos').prop('disabled', false);
					$('#biblio').prop('disabled', false);
					$('#etcp').prop('disabled', false);
					$('#ca').prop('disabled', false);
					$('#direccion').prop('disabled', false);
					$('#orientacion').prop('disabled', false);
					$('#bilingue').prop('disabled', false);
					$('#padres').prop('disabled', false);
					
				}
			});

			// Biblioteca
			$('#biblio').change(function() {
				if(biblio.checked==true) {
					$('#grupo_biblioteca').removeClass('hidden');
				}
				else {
					$('#grupo_biblioteca').addClass('hidden');
				}
			});

			// Jefes Departamento
			$('#etcp').change(function() {
				if(etcp.checked==true) {
					$('#grupo_etcp').removeClass('hidden');
				}
				else {
					$('#grupo_etcp').addClass('hidden');
				}
			});

			// Coordinadores Área
			$('#ca').change(function() {
				if(ca.checked==true) {
					$('#grupo_coordinadores').removeClass('hidden');
				}
				else {
					$('#grupo_coordinadores').addClass('hidden');
				}
			});

			// Direccion
			$('#direccion').change(function() {
				if(direccion.checked==true) {
					$('#grupo_directivo').removeClass('hidden');
				}
				else {
					$('#grupo_directivo').addClass('hidden');
				}
			});

			// Orientación
			$('#orientacion').change(function() {
				if(orientacion.checked==true) {
					$('#grupo_orientacion').removeClass('hidden');
				}
				else {
					$('#grupo_orientacion').addClass('hidden');
				}
			});

			// Bilinguismo
			$('#bilingue').change(function() {
				if(bilingue.checked==true) {
					$('#grupo_bilingue').removeClass('hidden');
				}
				else {
					$('#grupo_bilingue').addClass('hidden');
				}
			});

			// Padres
			$('#padres').change(function() {
				if(padres.checked==true) {
					$('#grupo_padres').removeClass('hidden');
				}
				else {
					$('#grupo_padres').addClass('hidden');
				}
			});	

		// EDITOR DE TEXTO
		$('#texto').summernote({
			height: 300,
			lang: 'es-ES',
			
			onChange: function(content) {
				var sHTML = $('#texto').code();
		    localStorage['summernote-<?php echo $token; ?>'] = sHTML;
			}
		});
		
		$('#texto').code(localStorage['summernote-<?php echo $token; ?>']);
	  
	  	$('#mostrar_grupos').click(function() {
	  	mostrar_grupos();
	  });
	  
	});
	</script>
	
	<script>
	
	bootbox.setDefaults({
	  locale: "es",
	  show: true,
	  backdrop: true,
	  closeButton: true,
	  animate: true,
	  title: "Enviar mensaje",
	});
	
	
	
	
	function checkAsunto(form)
	  {

	    // Comprobación de Asunto vacío
	    if($('#asunto').val() == "") {
	      bootbox.alert("No ha escrito nada en el asunto del formulario.");
	      $('#asunto').parent('.form-group').addClass('has-error');
	      return false;
	    }
	
	    // Comprobación de Grupo de destinatarios sin marcar       
	    if(formulario.profes.checked == false && formulario.tutores.checked == false && formulario.departamentos.checked == false && formulario.equipos.checked == false && formulario.claustro.checked == false && formulario.biblio.checked == false && formulario.etcp.checked == false && formulario.ca.checked == false && formulario.direccion.checked == false && formulario.orientacion.checked == false <?php if(isset($config['mod_bilingue']) && $config['mod_bilingue']): ?>&& formulario.bilingue.checked == false<?php endif; ?><?php if(stristr($_SESSION['cargo'],'1') == TRUE || stristr($_SESSION['cargo'],'2') == TRUE): ?>&& formulario.padres.checked == false<?php endif; ?>) {
			bootbox.alert("No ha seleccionado ningún grupo de destinatarios para el mensaje.");
			return false;
	    }
		
	    // Comprobación de destinatario vacío
	    if(formulario.claustro.checked == false && formulario.biblio.checked == false && formulario.etcp.checked == false && formulario.ca.checked == false && formulario.direccion.checked == false && formulario.orientacion.checked == false <?php if(isset($config['mod_bilingue']) && $config['mod_bilingue']): ?>&& formulario.bilingue.checked == false<?php endif; ?>) {
		    if(document.forms['formulario']['profeso[]'].selectedIndex == -1 && document.forms['formulario']['equipo[]'].selectedIndex == -1 && document.forms['formulario']['tutor[]'].selectedIndex == -1 && document.forms['formulario']['departamento[]'].selectedIndex == -1 <?php if(stristr($_SESSION['cargo'],'1') == TRUE || stristr($_SESSION['cargo'],'2') == TRUE): ?>&& document.forms['formulario']['padres[]'].selectedIndex == -1<?php endif; ?>) {
		    	bootbox.alert("No ha seleccionado ningún destinatario para el mensaje.");
		    	return false;
		  	}
		}
		
		return true;
	
	  }
	</script>
</body>
</html>
