<?php
session_start();

include('config.php');
include('config/version.php');

$_SESSION['autentificado'] = 0;
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Intranet &middot; <?php echo $config['centro_denominacion']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style type="text/css">
    /* Space out content a bit */
    body {
      padding-top: 70px;
      padding-bottom: 20px;
    }
    
    /* Everything but the jumbotron gets side spacing for mobile first views */
    .header,
    .footer {
      padding-right: 15px;
      padding-left: 15px;
    }
    
    /* Custom page header */
    .header {
      border-bottom: 1px solid #e5e5e5;
    }
    /* Make the masthead heading the same height as the navigation */
    .header h3 {
      padding-bottom: 19px;
      margin-top: 0;
      margin-bottom: 0;
      line-height: 40px;
    }
    
    /* Custom page footer */
    .footer {
      padding-top: 19px;
      color: #777;
      border-top: 1px solid #e5e5e5;
    }
    
    /* Customize container */
    @media (min-width: 768px) {
      .container {
        max-width: 730px;
      }
    }
    .container-narrow > hr {
      margin: 30px 0;
    }
    
    /* Main marketing message and sign up button */
    .jumbotron {
      text-align: center;
      border-bottom: 1px solid #e5e5e5;
    }
    .jumbotron .btn {
      padding: 14px 24px;
      font-size: 21px;
    }
    
    /* Supporting marketing content */
    .marketing {
      margin: 40px 0;
    }
    .marketing p + h4 {
      margin-top: 28px;
    }
    
    /* Responsive: Portrait tablets and up */
    @media screen and (min-width: 768px) {
      /* Remove the padding we set earlier */
      .header,
      .footer {
        padding-right: 0;
        padding-left: 0;
      }
      /* Space out the masthead */
      .header {
        margin-bottom: 30px;
      }
      /* Remove the bottom border on the jumbotron for visual effect */
      .jumbotron {
        border-bottom: 0;
      }
    }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="jumbotron">
        <h1>Intranet</h1>
        
        <br>
        
        <p class="lead">Esta página se encuentra cerrada temporalmente por tareas de mantenimiento. El acceso se reanudará pronto.</p>
        
        <br>
        
        <p><a class="btn btn-lg btn-success" href="//<?php echo $config['dominio']; ?>" role="button">Ir a la página del centro</a></p>
      </div>

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

    </div> <!-- /container -->

  </body>
</html>

