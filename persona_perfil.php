<?php
include_once('constantes.php');
include_once('/librerias/querydb.php');
permiso();

$matricula = $_GET['matricula'];

/* Perfil de la persona */
$res = querydb::perfil($matricula,false);
$res = $res->fetch_all(MYSQLI_ASSOC);
$perfil = $res[0]; 

/*----------------------------------------
 				Apunteca 
----------------------------------------*/
$apuntecaRegistro = querydb::apuntecaRegistro($matricula, "", 0,10000000, false);
$apuntesNoDevueltos = querydb::apuntecaNoDevuelto($matricula, '', '', 0, 10000000, false);


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
	<div class="container-fluid">    
    	<div class="row"> <br></div>
        <div class="row center-block">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
            	<div class="panel panel-default">
                  <div class="panel-heading" align="center"><?php echo "Perfil de ".$perfil['nombre']; ?></div>
                  <div class="panel-body" align="center">
						<div id="dPersonal">
							<p align="center"><strong>Datos Personales</strong></p>
							<p align="left">	
								<strong>Apellido: </strong><?php echo $perfil['matricula']; ?></br>
								<strong>Nombre: </strong><?php echo $perfil['nombre']; ?></br>
								<strong>Apellido: </strong><?php echo $perfil['apellido']; ?></br>
								<strong>Carrera: </strong><?php echo $perfil['carrera']; ?></br>
								<strong>Email: </strong><?php echo $perfil['email']; ?></br>
								<strong>Celular: </strong><?php echo $perfil['celular']; ?></br>
								<strong>Ultima actualizacion de datos: </strong><?php echo $perfil['lastupdate']; ?>
								</br></br></br>	
							</p>
						</div>
						<div id="dRegistroApuntes">

							<p align="center"><strong>Apuntes no devueltos</strong></p>
							<p>
								 <table class="table table-hover">
									  <thead>
									    <tr>
									      <th># Transaccion</th>
		   							      <th>Apunte</th>
									      <th>Fecha</th>
									      <th>Observacion</th>
									    </tr>
									  </thead>
									  <tbody>
									    	<?php
									    	
				                            foreach($apuntesNoDevueltos as $fila){
				                                echo '<tr><td>'.$fila['numTransaccion'].'</td>'."\n";
				                                echo '<td>'.$fila['apunte'].'</td>'."\n";
												echo '<td>'.substr($fila['cuando'],0,10).'</td>'."\n";
												echo '<td>'.$fila['observacion'].'</td>'."\n";
				                            }
				                            ?>
									  </tbody>
								  </table>
								</br></br></br>	
							</p>
						</div>
						<div id="dRegistroApunteca">

							<p align="center"><strong>Registro de la apunteca</strong></p>
							<p>
								 <table class="table table-hover">
									  <thead>
									    <tr>
									      <th>#</th>
		   							      <th>Apunte</th>
									      <th>Accion</th>
									      <th>Fecha</th>
									      <th>Observacion</th>
									    </tr>
									  </thead>
									  <tbody>
									    	<?php
				                            foreach($apuntecaRegistro as $fila){
				                                echo '<tr><td>'.$fila['numTransaccion'].'</td>'."\n";
				                                echo '<td>'.$fila['apunte'].'</td>'."\n";
												if($fila['retiro']==1){
													echo '<td>Retiro</td>'."\n";
												}else{
													echo '<td>Devolvio</td>'."\n";
												}
												echo '<td>'.substr($fila['cuando'],0,10).'</td>'."\n";
												echo '<td>'.$fila['observacion'].'</td>'."\n";
												//echo '<td>'.$fila['persona_id'].'</td>'."\n";
				                            }
				                            ?>
									  </tbody>
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