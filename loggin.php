<?php
include_once('constantes.php');
?>
<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="librerias/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script src="librerias/jquery-2.1.1.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
        
        <title><?php echo TITULO; ?> - Iniciar Sesion</title>
        <script src="loggin.js"></script>
        <link href="footer.css" rel="stylesheet">
	</head>
	<body>
	<div class="container-fluid">    
    	<div class="row"> <br></div>
        <div class="row center-block">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
            	<div class="panel panel-primary">
                  <div class="panel-heading" align="center">Iniciar Sesión</div>
                  <div class="panel-body" align="center">
                    <form class="form-inline" role="form" id="form_loggin">
                                <input type="text" class="form-control formulario" id="usuario" placeholder="Matricula o DNI">
 								<input type="password" class="form-control formulario" id="password" placeholder="password">
                                <br>
                                <button type="button" class="btn btn-default formulario" id="btn_iniciar">Iniciar sesion</button>
                                <div class="alert alert-danger alert-dismissable hide" id="resultado">
                                  <button type="button" class="close formulario" data-dismiss="alert">&times;</button>
                                  <strong>Datos Incorrectos</strong> <br> Nombre de usuario o contraseña incorrectos.
                                </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
	</div>
    <?PHP echo PIEPAGINA; ?>
	</body>
</html>