<?php
include_once("constantes.php");
permiso();
 
?>
<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="librerias/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="librerias/css/flick/jquery-ui-1.10.4.custom.min.css">
        <script src="librerias/jquery-2.1.1.js"></script>
        <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
		<script src="librerias/bootbox.min.js"></script>
        <link href="footer.css" rel="stylesheet">
        
        <script src="academico_personasConsulta_update.js"></script>

	</head>
	<body>
	<div class="container-fluid" id="contenido">    
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title" align="center">Registro o actualizacion de Clases de Consulta</h5>
                  </div>
                  <div class="panel-body" align="center" id="contenedor_panel">
                    <form class="form-inline" role="form" id="formulario_persona">
                    	<!-- Personas -->
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
					</form>
					<!-- Fin Personas -->
					<br><br><br>
					<!-- Materias -->
					<form class="form-inline" role="form" id="formulario_materias">

						<div class="checkbox" id="listaMaterias" align="left">
	                     <?php
                            $arrayMaterias = querydb::AcademicoListarMateria("", false);
							$fila_0 = $fila_1 = $fila_2 = "";
							$numF = 0;  
							$cantidad = ceil(count($arrayMaterias)/3);
							foreach($arrayMaterias as $fila){
								$numF++;
								if($numF<=$cantidad*1)
									$fila_0 .= '<label><input type="checkbox" id="mat_'.$fila['id'].'" value="'.$fila['id'].'" nombre="'.$fila['materia'].'">'.$fila['materia'].'</option></label>'."</br>\n";
								else if($numF<=$cantidad*2)
									$fila_1 .= '<label><input type="checkbox" id="mat_'.$fila['id'].'" value="'.$fila['id'].'" nombre="'.$fila['materia'].'">'.$fila['materia'].'</option></label>'."</br>\n";
								else
									$fila_2 .= '<label><input type="checkbox" id="mat_'.$fila['id'].'" value="'.$fila['id'].'" nombre="'.$fila['materia'].'">'.$fila['materia'].'</option></label>'."</br>\n";				
							}
                        ?>
							<div class="row">
						    	<div class="col-md-4">
						    		<?php echo $fila_0 ?>
								</div>
						    	<div class="col-md-4">
						    		<?php echo $fila_1 ?>
								</div>
								<div class="col-md-4">
						    		<?php echo $fila_2 ?>
								</div>
						    </div>
					    </div>
					    <!-- Fin materias Materias -->
                        <br>
                        <button type="button" class="btn btn-default" id="btn_clear">Limpiar</button>

                        <button type="button" class="btn btn-primary" id="btn_enviar">Siguiente >></button>

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
	<?PHP echo PIEPAGINA; ?>

	</body>
</html>
