<?php
include_once('constantes.php');
include_once('librerias/querydb.php');
permiso();

if(isset($_GET['id_apunte']))
	$id_apunte = $_GET['id_apunte'];
else 
	$id_apunte = "";
if(isset($_GET['matricula']))
	$matricula = $_GET['matricula'];
else 
	$matricula = "";
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
       <title><?php echo TITULO; ?> - Buscar personas</title>

	</head>
	<body>
		<div class="container"  id="contenido">
				<div class="col-md-12">
					<div class="row center-block">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h5 class="panel-title" align="center">Hisorial de registro</h5>
						</div>
						<div class="panel-body" align="center">
							<div class="row" id="listaResultado">
								 <table class="table table-hover">
							  <thead>
							    <tr>
							      <th>#</th>
   							      <th>Apunte</th>
							      <th>Accion</th>
							      <th>Fecha</th>
							      <th>Observacion</th>
							      <th>Matricula</th>
							    </tr>
							  </thead>
							  <tbody>
							    	<?php
		                            $arrayRes = querydb::apuntecaRegistro($matricula, $id_apunte, 0,10000000, false);
		                            foreach($arrayRes as $fila){
		                                echo '<tr><td>'.$fila['numTransaccion'].'</td>'."\n";
		                                echo '<td>'.$fila['apunte'].'</td>'."\n";
										if($fila['retiro']==1){
											echo '<td>Retiro</td>'."\n";
										}else{
											echo '<td>Devolvio</td>'."\n";
										}
										echo '<td>'.substr($fila['cuando'],0,10).'</td>'."\n";
										echo '<td>'.$fila['observacion'].'</td>'."\n";
										echo '<td>'.'<strong><a href="persona_perfil.php?&matricula='.$fila['persona_id'].'" target="_blank">'.$fila['persona_id'].'</a></strong>'.'</td>'."\n";
										//echo '<td>'.$fila['persona_id'].'</td>'."\n";
		                            }
		                            ?>
							  </tbody>
							  </table>
							</div>
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>    
	</body>
</html>