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
        <script src="menu.js"></script>
        <link href="footer.css" rel="stylesheet">

	</head>
	<body>
	<div class="container-fluid" id="menu_superior">    
		<div class="nav nav-pills nav-justified">
			<!-- Btn Inicio -->
			<li class="active"><a href="#">Inicio</a></li>
			<!-- Btn Personas -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Personas <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a id="btn_personas_agregar" href="#">Agregar / Actualizar</a></li>
					<li><a id="btn_personas_buscar" href="#">Buscar</a></li>
					<li class="divider"></li>
					<li><a id="btn_personas_lista" href="#">Listas email</a></li>
				</ul>
			</li>
			<!-- Btn apunteca -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Apunteca <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" id="btn_apunteca_buscar">Buscar</a></li>
					<li><a href="#" id="btn_apunteca_retirar">Retirar</a></li>
					<li class="divider"></li>
					<li><a id="btn_apunteca_agregar" href="#">Agregar</a></li>
					<li><a id="btn_apunteca_editar" href="#">Editar</a></li>
					<li class="divider"></li>
					<li><a id="btn_apunteca_noDev" href="#">No devueltos</a></li>
					<li><a id="btn_apunteca_reg" href="#">Historial de Registro</a></li>

				</ul>
			</li>
			<!-- Btn Academico -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Academico <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" id="btn_academico_materia">Materias</a></li>
					<li><a id="btn_academico_bolsa" href="#">Bolsa</a></li>
					<li><a id="btn_academico_consulta" href="#">Consultas</a></li>

				</ul>
			</li>
			<!-- Btn Mi perfil -->
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Mi perfil<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li class="disabled"><a id="btn_usuario_change" href="#">Cambiar password</a></li>
					<li class="divider"></li>
					<li><a id="btn_usuario_salir" href="logout.php">Cerrar sesion</a></li>
				</ul>
			</li>
		</div>
		<div class="row" id="contenedorPrincipal">
			<div class="col-md-12">Pagina Inicio</div>
		</div>
	</div>
	<?PHP echo PIEPAGINA; ?>

	</body>
</html>
