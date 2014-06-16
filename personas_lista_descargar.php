<?php
include_once('constantes.php');
include_once('/librerias/querydb.php');
permiso();

if(isset($_GET['carrera']))
	$carreraID = $_GET['carrera'];	

else 
	$carreraID = '';

	$lista = querydb::listarPersonas($carreraID);
$i=0;
foreach ($lista as $persona) {
	if ($i==10){
		echo "\n\n\n</br></br></br>\n\n\n";	
		$i = 0;
	}
	echo $persona['email'].", ";
	$i++;
}
?>
