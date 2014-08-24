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
        
        <script src="academico_materias.js"></script>

	</head>
	<body>
	<div class="container-fluid" id="contenido">    
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<!-- Agregar -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h5 class="panel-title" align="center">Lista de materias</h5>
					</div>
					<div class="panel-body" align="center">
						<form class="form-inline" role="form" id="form_materia_agregar">
									<p><input type="text" class="form-control" id="materia" placeholder="Materia"></br></p>
									<p>
										<button type="button" class="btn btn-primary" id="btn_agregar"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
										<button type="button" class="btn btn-default" id="btn_buscar"><span class="glyphicon glyphicon-search"></span> Buscar</button>
									
									</p>			
								</div>
						</form>
					</div>
				</br></br>
						<div id="resultado"></div>
						<table class="table table-hover">
							<thead>
								<tr>
									<td># </td>
									<td>Nombre</td>
									<td></td>
								</tr>
							</thead>
							<tbody id="listaMaterias">
	
							</tbody>
						</table>
				</div>
				<!-- Fin Agregar -->
			</div>
			<div class="col-md-4"></div>
		</div>

	</div>
	<?PHP echo PIEPAGINA; ?>

	</body>
</html>
