<?php
include_once('constantes.php');
include_once('librerias/querydb.php');
permiso();

if(isset($_GET['id_apunte']))
	$id_libro = $_GET['id_apunte'];
else 
	$id_libro = "";

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
        <title><?php echo TITULO; ?> - Retirar Apunte</title>
        <script src="apunteca_retirar.js"></script>

	</head>
	<body>
	<div class="container" id="contenido">    
    	<div class="row"> </br></div>
        <div class="row center-block">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title" align="center">Retirar apunte</h5>
                  </div>
                  <div class="panel-body" align="center">
                    <form class="form-inline" role="form" id="formulario_retiroApunte">
                    	
                    	<div  id="campo_apunte_id">
                    		<div class="input-group">
								<span class="glyphicon glyphicon-asterisk input-group-addon"></span>
	    	                	<input type="text" class="form-control" id="id_apunte" placeholder="ID del Apuntes" value="<?php echo $id_libro; ?>">
    	                	</div>
                    	</div>
                    	</br>
                    	<div id="alertaApunte"></div>
                   		
                   		<div class="input-group hide" id="nombre_apunte_campo" >
                   			<input type="text" class="form-control" id="nombre_apunte" placeholder="Nombre del apunte" disabled>
                       	</div>
                       	
                       	<div class="input-group" id="matricula_campo" >
		                   	<span class="glyphicon glyphicon-user input-group-addon"></span>
	    	               	<input type="text" class="form-control" id="matricula" placeholder="Matricula">
    	               	</div>
    	               	
                    	<div  id="campo_persona">
	                    	<div class="alert alert-warning hide" id="alertaPersona"></div>
	                    	<div class="input-group hide" id="nombre_campo">
								<input type="text" class="form-control" id="nombre" placeholder="Nombre">
							</div>
	      

	                        <div class="input-group hide" id="apellido_campo">
	                        	<input type="text" class="form-control" id="apellido" placeholder="Apellido">
	                        </div>
	                        <div class="input-group hide" id="celular_campo">
	                        	<input type="text" class="form-control" id="celular" placeholder="Celular (con codigo de area)">
	                        </div>
	                        <div class="input-group hide" id="email_campo">
	                        	<input type="text" class="form-control" id="email" placeholder="email">
							</div>
							</br>
							<div class="input-group hide" id="carrera_campo">
	                    		<select name="carrera" id="carrera" multiple class="form-control">
									<?php
		                        		$arrayCarreras = querydb::arrayCarreras();
		                            	foreach($arrayCarreras as $fila){
		                                	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>'."\n";
		                            	}
		                        	?>
		                		</select>
							</div>
							<div class="input-group hide" id="comentario_campo">
								<textarea id="comentario" class="form-control" rows="3" placeholder="Observaciones"></textarea>
							</div>

                        </div>
                       	<div class="input-group" id="btn_verificar_campo" >
                       		</br>
	                        <button type="button" class="btn btn-primary" id="btn_verificar"><span class="glyphicon glyphicon-flash"></span>Verificar datos</button>
	                    </div>
                        <div class="input-group" id="btn_enviar_campo" >
                        	</br>
                        	<button type="button" class="btn btn-primary hide" id="btn_enviar"><span class="glyphicon glyphicon-ok"></span> Confirmar datos</button>
	                    </div>
	                    <div class="input-group" id="btn_enviar_campo" >
	                		</br>
	                        <button type="button" class="btn btn-default hide" id="btn_clear"><span class="glyphicon glyphicon-remove"></span> Limpiar</button>
                        </div>
                    	<div  id="resultado"></div>
					</form>
                    </br>
					<div class="alert alert-success hide" id="resultado">
						<button type="button" class="close formulario" data-dismiss="alert">&times;</button>
						<strong>Registrado!</strong> </br> Los cambios fueron registrados correctamente.
					</div>
                  </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
	</div>
    
	</body>
</html>