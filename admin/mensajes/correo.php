<?php
require('../../bootstrap.php');

if($_POST['token']) $token = $_POST['token'];
if(!isset($token)) $token = time(); 

if (isset($_POST['enviar'])) {
	$profe_envia = $_SESSION['profi'];
	$cor_pr = mysqli_query($db_con, "select correo from c_profes where profesor = '$profe_envia'");
	$cor_pr0 = mysqli_fetch_array($cor_pr);
	$mail_from = $cor_pr0[0];
	
	$titulo = stripslashes(mysqli_real_escape_string($db_con, $_POST['tema']));
	$contenido = stripslashes(mysqli_real_escape_string($db_con, $_POST['texto']));

	require("../../lib/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = $mail_from;
	$mail->FromName = $profe_envia;
	$mail->AddReplyTo($mail_from, $profe_envia);
	$mail->Sender = $mail_from;
	$mail->IsHTML(true);
	
	$message = file_get_contents(INTRANET_DIRECTORY.'/lib/mail_template/index.htm');
	$message = str_replace('{{dominio}}', $config['dominio'], $message);
	$message = str_replace('{{centro_denominacion}}', $config['centro_denominacion'], $message);
	$message = str_replace('{{centro_codigo}}', $config['centro_codigo'], $message);
	$message = str_replace('{{centro_direccion}}', $config['centro_direccion'], $message);
	$message = str_replace('{{centro_codpostal}}', $config['centro_codpostal'], $message);
	$message = str_replace('{{centro_localidad}}', $config['centro_localidad'], $message);
	$message = str_replace('{{centro_provincia}}', $config['centro_provincia'], $message);
	$message = str_replace('{{centro_telefono}}', $config['centro_telefono'], $message);
	$message = str_replace('{{centro_fax}}', $config['centro_fax'], $message);
	$message = str_replace('{{titulo}}', 'Nuevo mensaje', $message);
	$message = str_replace('{{contenido}}', '<strong>'.$titulo.'</strong><br>'.$contenido.'<br><br><small>Enviado por: '.$profe_envia.'</small>', $message);
	
	$mail->msgHTML($message);
	$mail->Subject = $config['centro_denominacion'].' - Nuevo mensaje';
	$mail->AltBody = $titulo.' '.$contenido;


	foreach($_POST as $var => $valor) {
		$dni=$var;
		$cambia[$dni]=$valor;
	}
	
	
	
	foreach($cambia as $eldni => $valor){
		$mail0=mysqli_query($db_con, "select correo, PROFESOR from c_profes where dni='$eldni'");
		if (mysqli_num_rows($mail0)>0) {
			$numcor++;
		}
		$mail1=mysqli_fetch_row($mail0);
		$direccion = $mail1[0];
		$profes = $mail1[1];
		$mail->AddAddress($direccion, $profes);
	}

	for ($i=0;$i<5;$i++) {
		$varname{$i} = $_FILES['fil'.$i]['name'];
		$vartemp{$i} = $_FILES['fil'.$i]['tmp_name'];
		if($varname != "") {
			$mail->AddAttachment($vartemp{$i}, $varname{$i});
		}
	}

	if(!$mail->Send()) {
		$msg_class = "alert-danger";
		$msg = "Error: " . $mail->ErrorInfo;
	} else {
		if (!($numcor>0)) {	
		$msg_class = "alert-danger";	
		$msg = '<strong>Atención:</strong> No has seleccionado <em>destinatario</em> para enviar el correo. Procede a a hacerlo para completar la operación.';			
	}
	else{
		$msg_class = "alert-success";
		$msg = "El mensaje ha sido enviado.";
		}
	}
}


$page_header = "Enviar correo electrónico";
include("../../menu.php");
include("menu.php");
?>

	<div class="container">

		<div class="page-header">
			<h2>Mensajes <small><?php echo $page_header; ?></small></h2>
		</div>
		
		<?php if($msg): ?>
		<div class="alert <?php echo $msg_class; ?> alert-block"><?php echo $msg; ?>
		</div>
		<?php endif; ?>
		
		<?php if ($_SERVER['SERVER_NAME'] == 'iesmonterroso.org'): ?>
		<div class="alert alert-warning">
			<strong>Atención:</strong> Si utiliza este medio de comunicación, debe tener en cuenta que los destinatarios no podrán ponerse en contacto directamente con usted a través de su dirección de correo electrónico. Puede incluir una dirección de correo de contacto en su mensaje si desea recibir respuesta.
		</div>
		<?php endif; ?>
		
		
		<form enctype="multipart/form-data" method="post" name="cargos">
		
		<div class="row">

			<div class="col-sm-7">
			
				<div class="well">
				
					<fieldset>
						<legend>Redactar correo</legend>
						
						<input type="hidden" name="token" value="<?php echo $token; ?>">
						
						<div class="form-group">
							<label for="tema">Asunto</label>
							<input type="text" class="form-control" id="tema" name="tema" placeholder="Asunto del correo">
						</div>
						
						<div class="form-group">
							<label for="texto" class="sr-only">Contenido</label>
							<textarea class="form-control" id="texto" name="texto" rows="10"></textarea>
						</div>
										
						
						<div id="adjuntos"></div>
						
						<br>
						
						<button type="submit" class="btn btn-primary" name="enviar">Enviar correo</button>
						<button type="button" class="btn btn-default" onclick="crear(this)">Adjuntar archivo</button>
						<a class="btn btn-default" href="index.php">Cancelar</a>
						
					</fieldset>
					
				</div>
				
			</div>

			<div class="col-sm-5">

				<div id="botones_grupos">
					<a href="javascript:seleccionar_todo()"	class="btn btn-sm btn-info">Todos</a>&nbsp;
					<a href="javascript:seleccionar_tutor()" class="btn btn-sm btn-info">Tutores</a>&nbsp;
					<a href="javascript:seleccionar_jd()" class="btn btn-sm btn-info">Jefes Deptos.</a>&nbsp;
					<a href="javascript:seleccionar_ca()" class="btn btn-sm btn-info">C. de Areas</a>&nbsp;
					<a href="javascript:seleccionar_ed()" class="btn btn-sm btn-info">Dirección</a>
				</div>
			
				<br>

				<div class="panel-group" id="departamentos">
					<?php $result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos ORDER BY departamento ASC"); ?>
					<?php $i = 0; ?>
					<?php while ($departamento = mysqli_fetch_array($result)): ?>
				  <div class="panel panel-default">
				    <div class="panel-heading">
				    	<h4 class="panel-title">
				    		<a data-toggle="collapse" data-parent="#departamentos" href="#departamento<?php echo $i; ?>">
				        	<?php echo $departamento['departamento']; ?>
				      	</a>
				    	</h4>
				    </div>
				    <div id="departamento<?php echo $i; ?>" class="panel-collapse collapse <?php if($i==0) echo 'in'; ?>">
				      <div class="panel-body">
				      
				      <?php $profesores = mysqli_query($db_con, "SELECT distinct profesor, c_profes.dni, correo, cargo FROM c_profes, departamentos WHERE departamentos.idea = c_profes.idea AND departamento='$departamento[0]' AND correo IS NOT NULL ORDER BY profesor"); ?>
				      <?php if(mysqli_num_rows($profesores)>0): ?>
  
			        <?php while($profesor = mysqli_fetch_array($profesores)): ?>
	        			<?php $pro = $profesor[0]; ?>
	        			<?php $dni = $profesor[1]; ?>
	         			<?php $correo = $profesor[2]; ?>
	         			<?php $perf = $profesor[3]; ?>
	         			<?php $n_i = $n_i + 1; ?>       
      					
      					<div class="checkbox">
      						<label>
         						<input type="checkbox" id="dato0" name="<?php echo $dni;?>" value="cambio"> <?php echo nomprofesor($pro); ?>
         					</label>
      					</div>
      					<input type="hidden" name="<?php echo $dni.":".$perf;?>" value="<?php echo $perf;?>">
							<?php endwhile; ?>
							
							<?php else: ?>
     						<p class="muted">No hay profesores en este departamento con correo electrónico</p>
							<?php endif; ?>

							</div>
						</div>
					</div>
					
					<?php $i++; ?>
					<?php endwhile; ?>
				</div>
			</div>

		</div>
	
	</div>
	
	</form>

</div>


	<?php include('../../pie.php'); ?>

<script>

function seleccionar_todo(){
	for (i=0;i<document.cargos.elements.length;i++)
		if(document.cargos.elements[i].type == "checkbox")	
			document.cargos.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.cargos.elements.length;i++)
		if(document.cargos.elements[i].type == "checkbox")	
			document.cargos.elements[i].checked=0
}
function seleccionar_tutor(){
	deseleccionar_todo()
for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("2");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_jd(){
	deseleccionar_todo()
	for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("4");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_ed(){
	deseleccionar_todo()
	for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("1");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}
function seleccionar_ca(){
	deseleccionar_todo()
	for (i=0;i<document.cargos.elements.length;i++){
		if(document.cargos.elements[i].type == "hidden"){
		valorCasilla = document.cargos.elements[i].value;		
		valorReal = valorCasilla.indexOf("9");
		if(valorReal >= "0"){
			document.cargos.elements[i-1].checked=1;
}
}
}
}

num=0;
function crear(obj) {
  if(num<5) {
	  fi = document.getElementById('adjuntos'); // 1
	  contenedor = document.createElement('div'); // 2
	  contenedor.id = 'div'+num; // 3
	  fi.appendChild(contenedor); // 4
	
	  ele = document.createElement('input'); // 5
	  ele.type = 'file'; // 6
	  ele.name = 'fil'+num; // 6
	  contenedor.appendChild(ele); // 7
	  
	  ele = document.createElement('input'); // 5
	  ele.type = 'button'; // 6
	  ele.className = 'btn btn-danger btn-sm';
	  ele.value = 'Eliminar'; // 8
	  ele.name = 'div'+num; // 8
	  ele.onclick = function () {borrar(this.name)} // 9
	  contenedor.appendChild(ele); // 7
	  num++;
  }
}
function borrar(obj) {
  fi = document.getElementById('adjuntos'); // 1 
  fi.removeChild(document.getElementById(obj)); // 10
  num--;
}
</script>
	
	<script>
	$(document).ready(function() {
	
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
	  
	});
	</script>
	
</body>
</html>
