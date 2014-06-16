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
        <script src="librerias/jquery-2.1.1.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
        
        <title><?php echo TITULO; ?> - Buscar en el registro </title>
        <script src="apunteca_buscar_registro.js"></script>
        <script src="librerias/jquery-ui-1.10.4.calendario.js"></script>
		<link rel="stylesheet" href="librerias/css/flick/jquery-ui-1.10.4.custom.min.css">

	</head>
	<body>
	<div class="container"  id="contenido">    
    	<div class="row"> <br></div>
        <div class="row center-block">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title" align="center">Apuntes no devueltos</h5>
                  </div>
                  <div class="panel-body" align="center">
                    <form class="form-inline" role="form" id="formulario_busqueda">
                    	 <label><small>En blanco desde siempre</small></label></br>
                    	 <input type="text" class="form-control formulario" id="fecha_desde" placeholder="Desde la Fecha">
                         <br>
                         <label><small>En blanco, hasta  hoy</small></label></br>
                    	 <input type="text" class="form-control formulario" id="fecha_hasta" placeholder="Hasta la Fecha">
                         <br>
						<label>Cantidad de resultados por pagina</label><br>
                        <select class="form-control" id="cantidadpp">
						  <option>5</option>
						  <option>10</option>
						  <option>25</option>
						  <option>50</option>
						  <option>100</option>
						</select>
						<br><br>
                        <button type="button" class="btn btn-primary" id="btn_buscar"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                        <button type="button" class="btn btn-default" id="btn_clear"><span class="glyphicon glyphicon-remove"></span> Limpiar</button>
					</form>
                    <br>
                  </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="col-md-1"></div>
        <div class="row col-md-10" id="listaResultado" align="center" pagina=3 cantidadpp=2>

		</div>
        <div class="col-md-1"></div>

	</div>
    
	</body>
</html>