<?php
include_once('constantes.php');
include_once('librerias/querydb.php');
permiso();

?>
<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="librerias/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="global.css" rel="stylesheet" media="screen">
        <script src="librerias/jquery-2.1.1.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
        
        <title><?php echo TITULO; ?> - Buscar personas</title>
        <script src="personas_buscar.js"></script>

	</head>
	<body>
	<div class="container" id="contenido">    
    	<div class="row"> <br></div>
        <div class="row center-block">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title" align="center">Busqueda de personas</h5>
                  </div>
                  <div class="panel-body" align="center">
                    <form class="form-inline" role="form" id="formulario_busqueda">
                    	 <input type="text" class="form-control formulario" id="matricula" placeholder="Matricula">
                         <br>
						<input type="text" class="form-control formulario" id="nombre" placeholder="Nombre">
                        <br>
                         <input type="text" class="form-control formulario" id="apellido" placeholder="Apellido">
                        <br>
                        <button type="button" class="btn btn-primary" id="btn_buscar">Buscar</button>
                        <button type="button" class="btn btn-default" id="btn_clear">Limpiar</button>
					</form>
                    <br>
                  </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row" id="listaResultado">

		</div>
	</div>
    
	</body>
</html>