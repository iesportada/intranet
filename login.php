<?php
// COMPROBAMOS LA VERSIÓN DE PHP
if (version_compare(phpversion(), '5.3.0', '<')) die ("<h1>Versión de PHP incompatible</h1>\n<p>Necesita PHP 5.3.0 o superior para poder utilizar esta aplicación.</p>");

require('bootstrap.php');

// Comienzo de sesión
$_SESSION['autentificado'] = 0;

if (! isset($_SESSION['intentos'])) $_SESSION['intentos'] = 0;

// DESTRUIMOS LAS VARIABLES DE SESIÓN
if (isset($_SESSION['profi'])) {
	$_SESSION = array();
	session_destroy();
}

include('actualizar.php');

// Entramos
if (isset($_POST['submit']) and ! ($_POST['idea'] == "" or $_POST['clave'] == "")) {
	$clave0 = $_POST['clave'];
	$clave = sha1 ( $_POST['clave'] );
	
	$pass0 = mysqli_query($db_con, "SELECT c_profes.pass, c_profes.profesor , departamentos.dni, c_profes.estado, c_profes.correo FROM c_profes, departamentos where c_profes.profesor = departamentos.nombre and c_profes.idea = '".$_POST['idea']."'" );

	$usuarioExiste = mysqli_num_rows($pass0);

	$pass1 = mysqli_fetch_array ( $pass0 );
	$codigo = $pass1 [0];
	$profe = $pass1 [1];
	$dni = $pass1 [2];
	$bloqueado = $pass1 [3];
	$correo = $pass1 [4];

	if (! $bloqueado) {
		
		if ($codigo == $clave) {
			$_SESSION['autentificado'] = 1;
			$_SESSION['profi'] = $pass1[1];
			$profe = $_SESSION['profi'];

			// Variables de sesión del cargo del Profesor
			$cargo0 = mysqli_query($db_con, "select cargo, departamento, idea from departamentos where nombre = '$profe'" );
			$cargo1 = mysqli_fetch_array ( $cargo0 );
			$_SESSION['cargo'] = $cargo1 [0];
			$carg = $_SESSION['cargo'];
			$_SESSION['dpt'] = $cargo1[1];
			$_SESSION['ide'] = $cargo1[2];
				
			// Si es tutor
			if (stristr ( $_SESSION['cargo'], '2' ) == TRUE) {
				$result = mysqli_query($db_con, "select distinct unidad from FTUTORES where tutor = '$profe'" );
				$row = mysqli_fetch_array ( $result );
				$_SESSION['mod_tutoria']['tutor'] = $profe;
				$_SESSION['mod_tutoria']['unidad'] = $row [0];
			}

			// Si tiene Horario
			$cur0 = mysqli_query($db_con, "SELECT distinct prof FROM horw where prof = '$profe'" );
			$cur1 = mysqli_num_rows ( $cur0 );
			$_SESSION['n_cursos'] = $cur1;
			
			// Si tiene tema personalizado
			$res = mysqli_query($db_con, "select distinct tema, fondo from temas where idea = '".$_SESSION['ide']."'" );
			if (mysqli_num_rows($res)>0) {
				$ro = mysqli_fetch_array ( $res );
				$_SESSION['tema'] = $ro[0];
				$_SESSION['fondo'] = $ro[1];
			}
			else{
				$_SESSION['tema']="bootstrap.min.css";
				$_SESSION['fondo'] = "navbar-default";
			}
			
			// Registramos la entrada en la Intranet
			mysqli_query($db_con, "insert into reg_intranet (profesor, fecha,ip) values ('".$_SESSION['ide']."','".date('Y-m-d H:i:s')."','" . $_SERVER ['REMOTE_ADDR'] . "')");
			$id_reg = mysqli_query($db_con, "select id from reg_intranet where profesor = '".$_SESSION['ide']."' order by id desc limit 1" );
			$id_reg0 = mysqli_fetch_array ( $id_reg );
			$_SESSION['id_pag'] = $id_reg0 [0];

			unset($_SESSION['intentos']);
			
			if ($dni == $clave0 || (strlen($codigo) < '12'))
			{
				$_SESSION['cambiar_clave'] = 1;
				header("location:clave.php?tour=1");
				exit();
			}
			else {
				header("location:index.php");
				exit();
			}
		
		}
		// La contraseña no es correcta
		else {

			if ($_SESSION['intentos'] > 4) {
				mysqli_query($db_con, "UPDATE c_profes SET estado=1 WHERE idea='".$_POST['idea']."' LIMIT 1");

				require("lib/class.phpmailer.php");
				$mail = new PHPMailer();
				$mail->Host = "localhost";
				$mail->From = 'no-reply@'.$config['dominio'];
				$mail->FromName = $config['centro_denominacion'];
				$mail->Sender = 'no-reply@'.$config['dominio'];
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
				$message = str_replace('{{titulo}}', 'Cuenta temporalmente bloqueada', $message);
				$message = str_replace('{{contenido}}', 'Estimado '.$profe.',<br><br>Para ayudar a proteger tu cuenta contra fraudes o abusos, hemos tenido que bloquear el acceso temporalmente porque se ha detectado alguna actividad inusual. Sabemos que el hecho de que tu cuenta esté bloqueada puede resultar frustrante, pero podemos ayudarte a recuperarla fácilmente en unos pocos pasos.<br><br>Pónte en contacto con algún miembro del equipo directivo para restablecer tu contraseña. Una vez restablecida podrás acceder a la Intranet utilizando tu DNI como contraseña. Para mantener tu seguridad utilice una contraseña segura.<br><br><hr>Este es un mensaje automático y no es necesario responder.', $message);
				
				$mail->msgHTML($message);
				$mail->Subject = $config['centro_denominacion'].' - Cuenta temporalmente bloqueada';
				$mail->AltBody = 'Estimado '.$profe.',<br><br>Para ayudar a proteger tu cuenta contra fraudes o abusos, hemos tenido que bloquear el acceso temporalmente porque se ha detectado alguna actividad inusual. Sabemos que el hecho de que tu cuenta esté bloqueada puede resultar frustrante, pero podemos ayudarte a recuperarla fácilmente en unos pocos pasos.<br><br>Pónte en contacto con algún miembro del equipo directivo para restablecer tu contraseña. Una vez restablecida podrás acceder a la Intranet utilizando tu DNI como contraseña. Para mantener tu seguridad utilice una contraseña segura.<br><br><hr>Este es un mensaje automático y no es necesario responder.';

				$mail->AddAddress($correo, $profe);
				$mail->Send();

				$msg_error = "La cuenta de usuario ha sido bloqueada";
				unset($_SESSION['intentos']);
			}
			else {
				$msg_error = "Nombre de usuario y/o contraseña incorrectos";

				if ($usuarioExiste) {
					$_SESSION['intentos']++;
				}
				else {
					unset($_SESSION['intentos']);
				}
			}
		}
	}
	else {
		$msg_error = "La cuenta de usuario está bloqueada";
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="iso-8859-1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Intranet del <?php echo $config['centro_denominacion']; ?>">
	<meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
	<meta name="robots" content="noindex, nofollow">
	
	<title>Intranet &middot; <?php echo $config['centro_denominacion']; ?></title>
	
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/bootstrap.min.css" rel="stylesheet">
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/font-awesome.min.css" rel="stylesheet">
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/animate.css" rel="stylesheet">
	<link href="//<?php echo $config['dominio']; ?>/intranet/css/otros.css" rel="stylesheet">
</head>

<body id="login">

	<!--[if lte IE 9 ]>
	<div id="old-ie" class="modal">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<br>
	        <p class="lead text-center">Estás utilizando una versión de Internet Explorer demasiado antigua. <br>Actualiza tu navegador o cámbiate a <a href="http://www.google.com/chrome/">Chrome</a> o <a href="https://www.mozilla.org/es-ES/firefox/new/">Firefox</a>.</p>
	        <br>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<![endif]-->

	<div id="wrapper">
	
		<div class="container">
  
		  <div class="text-center" style="-webkit-animation: fadeInDown 1s;">
		    <h1><?php echo $config['centro_denominacion']; ?></h1>
		    <h4>Inicia sesión para acceder</h4>
		  </div>
		  
		  <form id="form-signin" class="form-signin well" method="POST" autocomplete="on">
		      <div class="text-center text-muted form-signin-heading">
		        <span class="fa-stack fa-4x">
		          <i class="fa fa-circle fa-stack-2x"></i>
		          <i class="fa fa-user fa-stack-1x fa-inverse"></i>
		        </span>
		      </div>
		      
		      <div id="form-group" class="form-group">
		        <input type="text" class="form-control" id="idea" name="idea" placeholder="Usuario IdEA" maxlength="12" required autofocus>
		        <input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña" required>
		        
		        <?php if($msg_error): ?>
		            <label class="control-label text-danger"><?php echo $msg_error; ?></label>
		        <?php endif; ?>
		      </div>
		      
		      
		      
		      <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Iniciar sesión</button>
		      
		      <div class="form-signin-footer">
		        
		      </div>
		  </form>
		
		</div><!-- /.container -->
	
	</div><!-- /#wrap -->
	
	<footer class="hidden-print">
		<div class="container-fluid" role="footer">
			<hr>
			
			<p class="text-center">
				<small class="text-muted">Versión <?php echo INTRANET_VERSION; ?> - Copyright &copy; <?php echo date('Y'); ?> IESMonterroso</small><br>
				<small class="text-muted">Este programa es software libre, liberado bajo la GNU General Public License.</small>
			</p>
			<p class="text-center">
				<small>
					<a href="//<?php echo $config['dominio']; ?>/intranet/LICENSE.md" target="_blank">Licencia de uso</a>
					&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;
					<a href="https://github.com/IESMonterroso/intranet" target="_blank">Github</a>
				</small>
			</p>
		</div>
	</footer>
	
	
	<script src="//<?php echo $config['dominio']; ?>/intranet/js/jquery-1.11.2.min.js"></script>  
	<script src="//<?php echo $config['dominio']; ?>/intranet/js/bootstrap.min.js"></script>
	
	<?php if($msg_error): ?>
	<script>$("#form-group").addClass( "has-error" );</script>
	<?php endif; ?>
	<script>
	$(function(){
	
		$('#old-ie').modal({
			backdrop: true,
			keyboard: false,
			show: true
		});
		
		// Deshabilitamos el botón
		$("button[type=submit]").attr("disabled", "disabled");
		
		// Cuando se presione una tecla en un input del formulario
		// realizamos la validación
		$('input').keyup(function(){
		      // Validamos el formulario
		      var validated = true;
		      if($('#idea').val().length < 5) validated = false;
		      if($('#clave').val().length < 8) validated = false;
		
		      // Si el formulario es válido habilitamos el botón, en otro caso
		      // lo volvemos a deshabilitar
		      if(validated) $("button[type=submit]").removeAttr("disabled");
		      else $("button[type=submit]").attr("disabled", "disabled");
		                                  
		});
		
		$('input:first').trigger('keyup');
		
	});
	</script>
</body>
</html>
