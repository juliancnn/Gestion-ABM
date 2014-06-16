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
        
        <title><?php echo TITULO; ?> - Apunteca Agregar</title>
        <script src="apunteca_editar.js"></script>

	</head>
	<body>
	<div class="container-fluid" id="contenido">    
    	<div class="row"> <br></div>
        <div class="row center-block">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
            	<div class="panel panel-default">
                  <div class="panel-heading" align="center">Editar apunte</div>
                  <div class="panel-body" align="center">
                    <form class="form-inline" role="form" id="form_apunteca">
                    			<div class="input-group" id="id_campo">
                                	<input type="text" class="form-control" id="id" placeholder="id del Apunte" value="<?php echo $id_libro; ?> ">
                                </div>
                                <div class="input-group hide" id="detalle_apunte_campo">
	                                <input type="text" class="form-control" id="estante" placeholder="Estante">
	 								<input type="text" class="form-control" id="numero" placeholder="Numero">
	 								<input type="text" class="form-control" id="nombre" placeholder="Nombre">
	                                </br>
	                                <select name="lugar" id="lugar" multiple class="form-control formulario">
									  <?php
			                            $arrayLugares = querydb::arrayApunteLugares();
			                            foreach($arrayLugares as $fila){
			                                echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>'."\n";
			                            }
			                            
			                        ?>
			                        </select></br>
		                        </div>
                       	<div class="input-group" id="btn_verificar_campo" >
                       		</br>
	                        <button type="button" class="btn btn-primary" id="btn_verificar"><span class="glyphicon glyphicon-flash"></span> Verificar datos</button>
	                    </div>
                        <div class="input-group" id="btn_enviar_campo" >
                        	</br>
                        	<button type="button" class="btn btn-primary hide" id="btn_enviar"><span class="glyphicon glyphicon-ok"></span> Editar apunte</button>
	                    </div>
	                    <div class="input-group" id="btn_enviar_campo" >
	                		</br>
	                        <button type="button" class="btn btn-default hide" id="btn_clear"><span class="glyphicon glyphicon-remove"></span> Limpiar</button>
                        </div>
						<div class="alert hide" id="resultado">
						</div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
	</div>
    
	</body>
</html>