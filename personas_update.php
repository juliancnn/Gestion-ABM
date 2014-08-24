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
        
        <title><?php echo TITULO; ?> - Personas update</title>
        <script src="personas_update.js"></script>

	</head>
	<body>
	<div class="container" id="contenido">    
    	<div class="row"> <br></div>
        <div class="row center-block">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title" align="center">Registro o actualizacion de personas</h5>
                  </div>
                  <div class="panel-body" align="center">
                    <form class="form-inline" role="form" id="formulario_persona">
                    	 <input type="text" class="form-control" id="matricula" placeholder="Matricula">
                         <br>
						<input type="text" class="form-control" id="nombre" placeholder="Nombre">
                        <br>
                         <input type="text" class="form-control" id="apellido" placeholder="Apellido">
                        <br>
                         <input type="text" class="form-control" id="celular" placeholder="Celular (con codigo de area)">
                        <br>
                         <input type="text" class="form-control" id="email" placeholder="email">
                        <br>
						<select name="carrera" id="carrera" multiple class="form-control">
						  <?php
                            $arrayCarreras = querydb::arrayCarreras();
                            foreach($arrayCarreras as $fila){
                                echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>'."\n";
                            }
                            
                        ?>
                        </select>
                        <br>
                        <button type="button" class="btn btn-primary" id="btn_enviar">Registrar</button>
                        <button type="button" class="btn btn-default" id="btn_clear">Limpiar</button>

					</form>
                    <br>
					<div class="alert alert-success hide" id="resultado">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Registrado!</strong> <br> Los cambios fueron registrados correctamente.
					</div>
                  </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
	</div>
    
	</body>
</html>