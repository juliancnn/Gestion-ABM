<?php
include_once('constantes.php');
include_once('/librerias/querydb.php');
permiso();

if(isset($_GET['carrera'])){
	$carreraID = $_GET['carrera'];
	
	$arrayCarreras = querydb::arrayCarreras();
	$arrayCarreras = $arrayCarreras->fetch_all(MYSQLI_ASSOC);
	foreach ($arrayCarreras as $carrera) {
		if ($carrera['id']==$carreraID) {
			$subtitulo = "Lista de ".$carrera['nombre'];
			break;
		}
	}	
}
else {
	$subtitulo = "Lista completa";
	$carreraID = '';
}
	

$lista = querydb::listarPersonas($carreraID);


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
        
        <title><?php echo TITULO." - Perfil de ".$matricula; ?></title>
        <script src="loggin.js"></script>

	</head>
	<body>
	<div class="container-fluid" id="contenido">    
    	<div class="row"> <br></div>
        <div class="row center-block">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
            	<div class="panel panel-default">
                  <div class="panel-heading" align="center"><strong><?php echo $subtitulo; ?></strong></div>
                  <div class="panel-body" align="center">
						<div id="dPersonal">
							<p align="right"><a target="_blank" href="personas_lista_descargar.php?carrera=<?PHP echo $carreraID;?>"><strong>Descargar lista</strong></a></p>
							<p align="left">
								<table class="table table-striped">
									<thead>
										<tr>
											<td># </td>
											<td>Nombre y apellido</td>
											<td>Email</td>
										</tr>
									</thead>
											<?php
											foreach ($lista as $persona) {
												echo "<tr> \n";
												echo "<td> ".$persona['matricula']." </td> \n";
												echo "<td> ".$persona['apellido'].", ".$persona['nombre']." </td> \n";
												echo "<td> ".$persona['email']." </td> \n";
												echo "</tr> \n";
											}
											?>
								</table>	
							</p>
						</div>
                  </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
	</div>
    
	</body>
</html>